<?php

namespace App\Controllers\Web;

use App\Models\Reservation\ReservationModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\IncomingRequest;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class PaymentController extends Controller
{
    /**
     * An instance of the IncomingRequest.
     *
     * @var IncomingRequest
     */
    protected $request;

    protected $helpers = ['auth', 'url', 'filesystem'];

    private ?GuzzleClient $guzzleClient = null;
    private ?PayPalHttpClient $paypalClient = null;
    protected ReservationModel $reservationModel;

    public function __construct()
    {
        helper('session');
        $this->reservationModel = new ReservationModel();

        // --- Guzzle Client for Doku ---
        $this->guzzleClient = new GuzzleClient();

        // --- PayPal Client ---
        if (getenv('paypal.clientId')) {
            $environment = getenv('paypal.isProduction')
                ? new ProductionEnvironment(getenv('paypal.clientId'), getenv('paypal.clientSecret'))
                : new SandboxEnvironment(getenv('paypal.clientId'), getenv('paypal.clientSecret'));
            $this->paypalClient = new PayPalHttpClient($environment);
        }
    }

    /**
     * Displays the unified checkout page for a specific reservation.
     * @param string $reservationId
     * @param string $paymentType   'deposit' or 'full'
     */
    public function unifiedCheckout($reservationId, $paymentType)
    {
        $reservation = $this->reservationModel->find($reservationId);

        if (!$reservation || $reservation['customer_id'] !== user_id()) {
            return redirect()->to('/web/reservation')->with('error', 'Reservation not found.');
        }

        $amount = 0;
        // Check if it's time to pay the deposit
        if ($paymentType === 'deposit' && ($reservation['status'] === '1' || $reservation['status'] === 'Deposit Pending')) {
            $amount = $reservation['deposit'];
        }
        // Check if it's time to pay the full amount
        elseif ($paymentType === 'full') {
            if ($reservation['status'] === 'Deposit Successful' || $reservation['status'] === 'Full Pay Pending') {
                $amount = $reservation['total_price'] - $reservation['deposit'] - $reservation['coin_use'];
            } elseif ($reservation['status'] === '1' || $reservation['status'] === 'Deposit Pending') {
                $amount = $reservation['total_price'] - $reservation['coin_use'];
            }
        }

        if ($amount <= 0) {
            return redirect()->to('/web/reservation/detail/' . $reservationId)->with('error', 'Invalid payment amount or status.');
        }

        // Store payment details in session
        session()->set([
            'reservation_id'   => $reservationId,
            'payment_type'     => $paymentType,
            'order_amount_idr' => $amount,
        ]);

        // --- Fetch Currency Conversion Rates ---
        $rates = [];
        $apiKey = getenv('exchangerate.apiKey');
        if ($apiKey) {
            try {
                $response = $this->guzzleClient->get("https://v6.exchangerate-api.com/v6/{$apiKey}/latest/IDR");
                $body = json_decode($response->getBody()->getContents(), true);
                if ($body['result'] === 'success') {
                    $rates = $body['conversion_rates'];
                }
            } catch (RequestException $e) {
                log_message('error', 'ExchangeRate-API Exception: ' . $e->getMessage());
                // Don't block the user, just won't show the converter
            }
        }
        // --- End Fetch ---

        $data = [
            'title' => 'Unified Checkout',
            'reservation_id'   => $reservationId,
            'order_amount_idr' => $amount,
            'idr_to_usd_rate'  => (float)getenv('IDR_TO_USD_RATE'),
            'rates'            => $rates
        ];

        return view('web/unified_checkout', $data);
    }

    /**
     * Creates a Doku checkout session and redirects the user.
     */
    public function dokuCheckout()
    {
        $orderId = session()->get('reservation_id');
        $amount  = session()->get('order_amount_idr');
        $paymentType = session()->get('payment_type');

        if (!$amount) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Order amount not found.']);
        }

        // Generate a unique invoice number for Doku (e.g., R021-deposit-1736322227)
        $invoiceNumber = $orderId . '-' . $paymentType . '-' . time();

        $requestBody = [
            'order' => [
                'invoice_number' => $invoiceNumber,
                'amount' => (int)$amount,
                'currency' => 'IDR',
                // Use site_url() for production, but for local testing with ngrok, use the ngrok URL:
                // 'callback_url' => 'https://your-ngrok-id.ngrok-free.app/web/payment/dokuNotification',
                'callback_url' => 'https://true-message-optimization-avi.trycloudflare.com/web/payment/dokuNotification',
                'session_id' => session_id()
            ],
            'payment' => [
                'payment_due_date' => 120,
                'payment_method_types' => [
                    'CREDIT_CARD',
                    'VIRTUAL_ACCOUNT_BCA',
                    'VIRTUAL_ACCOUNT_BANK_MANDIRI',
                    'VIRTUAL_ACCOUNT_BRI',
                    'VIRTUAL_ACCOUNT_BNI',
                    'ONLINE_TO_OFFLINE_ALFA',
                    'QRIS',
                    'EMONEY_OVO',
                    'EMONEY_SHOPEE_PAY'
                ]
            ],
            'customer' => [
                'name' => user()->username,
                'email' => user()->email,
            ],
            'override_configuration' => [
                'success_redirect_url' => 'https://true-message-optimization-avi.trycloudflare.com/web/payment/dokuPopupClose?id=' . $orderId,
                'failure_redirect_url' => 'https://true-message-optimization-avi.trycloudflare.com/web/payment/dokuPopupClose?id=' . $orderId
            ]
        ];

        $dokuApiUrl = getenv('doku.apiUrl');
        $requestTarget = '/checkout/v1/payment';

        log_message('error', 'Doku API URL: ' . $dokuApiUrl);
        log_message('error', 'Doku Request Body: ' . json_encode($requestBody));

        try {
            $dokuData = $this->generateDokuHeaders($requestTarget, $requestBody);
            log_message('error', 'Doku Headers: ' . json_encode($dokuData['headers']));

            $response = $this->guzzleClient->post($dokuApiUrl . $requestTarget, [
                'headers' => $dokuData['headers'],
                'body' => $dokuData['body']
            ]);

            $responseBody = json_decode($response->getBody()->getContents(), true);

            if (isset($responseBody['response']['payment']['url'])) {
                // The token is usually in 'token_id'. Check your logs if it's named differently.
                $paymentToken = $responseBody['response']['payment']['token_id'] ?? null;

                // Update your database here
                $this->reservationModel->update($orderId, ['payment_token' => $paymentToken]);

                log_message('error', 'Doku Checkout Success. Token: ' . ($paymentToken ?? 'None') . ' | Full Response: ' . json_encode($responseBody));

                return $this->response->setStatusCode(200)->setJSON(['payment_url' => $responseBody['response']['payment']['url']]);
            }

            log_message('error', 'Doku Checkout failed: ' . json_encode($responseBody));
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Failed to create Doku payment session. Response from Doku was: ' . json_encode($responseBody)
            ]);
        } catch (RequestException $e) {
            log_message('error', 'Doku API Exception: ' . $e->getMessage());
            $errorDetails = 'An error occurred with the Doku payment gateway: ' . $e->getMessage();
            if ($e->hasResponse()) {
                $responseBody = $e->getResponse()->getBody()->getContents();
                log_message('error', 'Doku API Response: ' . $responseBody);
                $errorDetails .= ' | Full response: ' . $responseBody;
            }
            return $this->response->setStatusCode(500)->setJSON(['error' => $errorDetails]);
        } catch (\Throwable $e) {
            // Catch any other possible errors
            log_message('error', 'Doku Generic Exception: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['error' => 'A server error occurred: ' . $e->getMessage()]);
        }
    }

    /**
     * Creates a PayPal order and returns the Order ID.
     */
    public function paypalCreateOrder()
    {
        // === TEST LOG ENTRY ===
        log_message('error', 'PayPal Create Order method entered. This is a test log entry.');
        // ======================

        log_message('error', 'PayPal Create Order Request: isAJAX=' . ($this->request->isAJAX() ? 'true' : 'false') . ', isAJAX() is deprecated. paypalClient=' . ($this->paypalClient ? 'initialized' : 'null') . ', CSRF Protection: ' . (config('Security')->csrfProtection ?? 'N/A'));

        if (!$this->request->isAJAX() || !$this->paypalClient || (config('Security')->csrfProtection ?? 'cookie') === 'session') { // isAJAX() is deprecated.
            log_message('error', 'PayPal Create Order failed: Not AJAX request (isAJAX() is deprecated), paypalClient not initialized, or CSRF protection is session-based. Returning 403. CSRF Protection: ' . (config('Security')->csrfProtection ?? 'N/A'));
            return $this->response->setStatusCode(403);
        }

        $amountIDR = session()->get('order_amount_idr');
        $rate = (float)getenv('IDR_TO_USD_RATE');
        log_message('error', 'IDR_TO_USD_RATE: ' . getenv('IDR_TO_USD_RATE'));

        if (!$amountIDR || !$rate) {
            log_message('error', 'PayPal Create Order failed due to configuration error. Amount: ' . $amountIDR . ' Rate: ' . $rate);
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Configuration error.']);
        }

        // Convert IDR to USD and format to 2 decimal places
        $amountUSD = round($amountIDR / $rate, 2);

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "amount" => [
                    "value" => (string)$amountUSD,
                    "currency_code" => "USD"
                ]
            ]]
        ];

        try {
            $response = $this->paypalClient->execute($request);
            return $this->response->setStatusCode(200)->setJSON(['id' => $response->result->id]);
        } catch (\Exception $e) {
            log_message('error', 'PayPal Create Order Exception: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Failed to create PayPal order.']);
        }
    }

    /**
     * Captures the payment for a PayPal order after user approval.
     */
    public function paypalCaptureOrder()
    {
        if (!$this->request->isAJAX() || !$this->paypalClient) {
            return $this->response->setStatusCode(403);
        }

        $orderId = $this->request->getJSON()->orderID ?? null;
        $reservationId = session()->get('reservation_id'); // Get reservation ID from session.

        if (!$orderId || !$reservationId) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Order ID or Reservation ID is missing from session.']);
        }

        $request = new OrdersCaptureRequest($orderId);
        $request->prefer('return=representation');

        try {
            $response = $this->paypalClient->execute($request);

            if ($response->result->status === 'COMPLETED') {
                $this->_handleSuccessfulPayment(null, session()->get('payment_type'));
                log_message('info', "PayPal payment completed for Order ID: {$orderId}");
                return $this->response->setStatusCode(200)->setJSON(['status' => 'success', 'reservation_id' => $reservationId]);
            }

            return $this->response->setStatusCode(400)->setJSON(['error' => 'Payment not completed.']);
        } catch (\Exception $e) {
            log_message('error', 'PayPal Capture Order Exception: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Failed to capture PayPal order.']);
        }
    }

    /**
     * Generates the required headers for a Doku API request.
     */
    // 1. Change return type to return BOTH headers and the body string
    private function generateDokuHeaders(string $requestTarget, array $requestBody): array
    {
        $clientId = getenv('doku.clientId');
        $requestId = bin2hex(random_bytes(16));
        $requestTimestamp = gmdate("Y-m-d\TH:i:s\Z");

        // FIX: Encode once and store it in a variable
        $jsonBody = json_encode($requestBody, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        // FIX: Use the variable for the hash
        $digest = base64_encode(hash('sha256', $jsonBody, true));

        $signatureComponents = [
            'Client-Id:' . $clientId,
            'Request-Id:' . $requestId,
            'Request-Timestamp:' . $requestTimestamp,
            'Request-Target:' . $requestTarget, // Ensure this is "/checkout/v1/payment" (PATH ONLY)
            'Digest:' . $digest
        ];

        $signatureString = implode("\n", $signatureComponents);
        $secretKey = getenv('doku.secretKey');
        $signature = base64_encode(hash_hmac('sha256', $signatureString, $secretKey, true));

        return [
            'headers' => [
                'Client-Id' => $clientId,
                'Request-Id' => $requestId,
                'Request-Timestamp' => $requestTimestamp,
                'Digest' => $digest,
                'Signature' => "HMACSHA256=" . $signature,
                'Content-Type' => 'application/json',
            ],
            'body' => $jsonBody // Return the exact string to send
        ];
    }


    /**
     * Verifies an incoming Doku notification signature.
     */
    public function dokuNotification()
    {
        log_message('error', "hallo ada");
        $headers = $this->request->headers();
        $notificationBodyString = $this->request->getBody();
        log_message('error', 'Doku Notification Body: ' . $notificationBodyString);
        $notificationBody = json_decode($notificationBodyString, true);

        // Basic validation
        if (empty($headers['Client-Id']) || empty($headers['Request-Id']) || empty($headers['Request-Timestamp']) || empty($headers['Signature']) || empty($notificationBody)) {
            log_message('error', "Doku notification is missing required headers or body.");
            return $this->response->setStatusCode(400)->setJSON(['status' => 'FAILED']);
        }

        $clientId = $headers['Client-Id']->getValue();
        $requestId = $headers['Request-Id']->getValue();
        $requestTimestamp = $headers['Request-Timestamp']->getValue();
        $signature = $headers['Signature']->getValue();

        // Use the raw body for the digest calculation for accuracy
        $digest = base64_encode(hash('sha256', $notificationBodyString, true));

        // Ensure path starts with '/' for Doku signature validation
        $path = $this->request->getUri()->getPath();
        if (substr($path, 0, 1) !== '/') {
            $path = '/' . $path;
        }

        $signatureComponents = [
            'Client-Id:' . $clientId,
            'Request-Id:' . $requestId,
            'Request-Timestamp:' . $requestTimestamp,
            'Request-Target:' . $path,
            'Digest:' . $digest
        ];

        $signatureString = implode("\n", $signatureComponents);
        $secretKey = getenv('doku.secretKey');
        $expectedSignature = "HMACSHA256=" . base64_encode(hash_hmac('sha256', $signatureString, $secretKey, true));

        if (hash_equals($expectedSignature, $signature)) {
            if (isset($notificationBody['transaction']['status']) && $notificationBody['transaction']['status'] === 'SUCCESS') {
                $invoiceNumber = $notificationBody['order']['invoice_number'];
                // Extract the original reservation ID (e.g., get 'R021' from 'R021-deposit-1736322227')
                $parts = explode('-', $invoiceNumber);
                $reservationId = $parts[0];
                $paymentType = $parts[1] ?? null;

                $this->_handleSuccessfulPayment($reservationId, $paymentType);
            }
            // Always acknowledge receipt to Doku, even if status is not SUCCESS (e.g., PENDING)
            return $this->response->setStatusCode(200)->setJSON(['status' => 'SUCCESS']);
        }

        log_message('error', "Invalid Doku signature for order: " . ($notificationBody['order']['invoice_number'] ?? 'N/A'));
        log_message('error', "Doku Signature Failed. Received: {$signature} | Expected: {$expectedSignature} | Components: " . print_r($signatureComponents, true));
        return $this->response->setStatusCode(400)->setJSON(['status' => 'FAILED']);
    }

    /**
     * Handles the logic for a successful payment.
     * @param string|null $reservationId
     * @param string|null $paymentType
     */
    private function _handleSuccessfulPayment(string $reservationId = null, string $paymentType = null)
    {
        // For Doku notifications, the reservation ID comes from the webhook body.
        // For PayPal, it's retrieved from the session after client-side capture.
        $resId = $reservationId ?? session()->get('reservation_id');
        $pType = $paymentType ?? session()->get('payment_type');

        if (!$resId) {
            log_message('error', 'Could not handle successful payment: reservation ID is missing.');
            return;
        }

        $reservation = $this->reservationModel->find($resId);

        if (!$reservation) {
            log_message('error', "Could not find reservation with ID: {$resId} during payment handling.");
            return;
        }

        $currentStatus = $reservation['status'];
        $nextStatus = null;

        // Determine the next status based on the *current* status in the database.
        // This is stateless and works for webhooks.
        if ($pType === 'deposit') {
            $nextStatus = 'Deposit Successful';
        } elseif ($pType === 'full') {
            $nextStatus = 'Full Pay Successful';
        } else {
            // Fallback if payment type is unknown
            if ($currentStatus === '1' || $currentStatus === 'Deposit Pending') {
                $nextStatus = 'Deposit Successful';
            } elseif ($currentStatus === 'Deposit Successful' || $currentStatus === 'Full Pay Pending') {
                $nextStatus = 'Full Pay Successful';
            }
        }

        if ($nextStatus) {
            $this->reservationModel->update($resId, ['status' => $nextStatus]);
            log_message('info', "Reservation {$resId} status updated to {$nextStatus}.");
        } else {
            log_message('warning', "Reservation {$resId} was already in a terminal state or an unhandled status '{$currentStatus}'. No status update performed.");
        }


        // Clear session data only if it exists (for browser-based flows like PayPal)
        if (session()->has('reservation_id')) {
            session()->remove(['reservation_id', 'payment_type', 'order_amount_idr']);
        }
    }

    /**
     * Helper to generate signature for Postman testing.
     * Access this in browser: /web/payment/testDoku/YOUR_INVOICE_NUMBER
     */
    public function testDoku($invoiceNumber)
    {
        $clientId = getenv('doku.clientId');
        $secretKey = getenv('doku.secretKey');
        $requestId = bin2hex(random_bytes(16));
        $timestamp = gmdate("Y-m-d\TH:i:s\Z");
        $path = '/web/payment/dokuNotification'; // Must match the route path exactly

        // Minimal body required for the notification
        $body = json_encode([
            "order" => ["invoice_number" => $invoiceNumber],
            "transaction" => ["status" => "SUCCESS"]
        ]);

        $digest = base64_encode(hash('sha256', $body, true));

        $component = "Client-Id:" . $clientId . "\n" .
            "Request-Id:" . $requestId . "\n" .
            "Request-Timestamp:" . $timestamp . "\n" .
            "Request-Target:" . $path . "\n" .
            "Digest:" . $digest;

        $signature = base64_encode(hash_hmac('sha256', $component, $secretKey, true));

        return $this->response->setJSON([
            'info' => 'Copy these headers and body into Postman to POST to: ' . site_url($path),
            'headers' => [
                'Client-Id' => $clientId,
                'Request-Id' => $requestId,
                'Request-Timestamp' => $timestamp,
                'Signature' => 'HMACSHA256=' . $signature,
            ],
            'body_raw' => json_decode($body)
        ]);
    }

    /**
     * Handles the redirect from Doku inside the popup.
     * Closes the popup and reloads the parent window.
     */
    public function dokuPopupClose()
    {
        $id = $this->request->getGet('id');

        // Try to get from session if not in URL (in case of fallback redirect)
        if (!$id) {
            $id = session()->get('reservation_id');
        }

        // Fallback URL: Go to detail page if ID exists, otherwise list page
        $fallbackUrl = $id ? site_url('web/reservation/detail/' . $id) : site_url('web/reservation');

        return '
            <html>
            <body>
                <script>
                    if (window.opener) {
                        window.opener.location.reload();
                        window.close();
                    } else if (window.parent && window.parent !== window) {
                        window.parent.location.reload();
                    } else {
                        window.location.href = "' . $fallbackUrl . '";
                    }
                </script>
            </body>
            </html>
        ';
    }
}
