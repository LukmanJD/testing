<?php

namespace App\Controllers\Web;

use CodeIgniter\Controller;
use Midtrans\Config;
use Midtrans\Snap;
use Config\Midtrans as MidtransConfig;
use Midtrans\Transaction;

class PaymentController extends Controller
{
<<<<<<< Updated upstream
=======
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

    /**
     * Constructor.
     * 
     * Purpose: Initializes the controller, loads necessary helpers, models, and API clients.
     * How it works:
     * 1. Loads session helper.
     * 2. Instantiates ReservationModel.
     * 3. Instantiates GuzzleClient for HTTP requests (Doku, ExchangeRate).
     * 4. Configures and instantiates PayPalHttpClient if credentials exist.
     */
>>>>>>> Stashed changes
    public function __construct()
    {
        // Load Midtrans configuration
        $midtransConfig = new MidtransConfig();

<<<<<<< Updated upstream
        // Set Midtrans configuration
        Config::$serverKey = $midtransConfig->serverKey;
        Config::$clientKey = $midtransConfig->clientKey;
        Config::$isProduction = $midtransConfig->isProduction;
        Config::$isSanitized = $midtransConfig->isSanitized;
        Config::$is3ds = $midtransConfig->is3ds;
    }

    // Create a payment transaction
    public function createTransaction($transactionDetails = null, $customerDetails = null)
=======
        // --- Guzzle Client for Doku ---
        $this->guzzleClient = new GuzzleClient();

        // --- PayPal Client ---
        if (env('paypal.clientId')) {
            $environment = env('paypal.isProduction')
                ? new ProductionEnvironment(env('paypal.clientId'), env('paypal.clientSecret'))
                : new SandboxEnvironment(env('paypal.clientId'), env('paypal.clientSecret'));
            $this->paypalClient = new PayPalHttpClient($environment);
        }
    }

    /**
     * Displays the unified checkout page for a specific reservation.
     * 
     * Purpose: Prepares the checkout view where users can select payment methods.
     * How it works:
     * 1. Fetches reservation details.
     * 2. Validates if the user owns the reservation.
     * 3. Calculates the amount to be paid based on $paymentType ('deposit' or 'full') and current status.
     * 4. Stores payment context in session.
     * 5. Fetches currency exchange rates for display.
     * 6. Loads the 'web/unified_checkout' view.
     * 
     * Redirects:
     * - To '/web/reservation' if reservation is not found or user is unauthorized.
     * - To '/web/reservation/detail/{id}' if the payment amount is invalid or status is incorrect.
     * 
     * @param string $reservationId
     * @param string $paymentType   'deposit' or 'full'
     */
    public function unifiedCheckout($reservationId, $paymentType)
>>>>>>> Stashed changes
    {

<<<<<<< Updated upstream
        // Transaction payload
        $transactionData = array(
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
        );
=======
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
        $apiKey = env('exchangerate.apiKey');
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
            'idr_to_usd_rate'  => (float)env('IDR_TO_USD_RATE'),
            'rates'            => $rates
        ];

        // Prevent caching to ensure CSRF token is fresh
        $this->response->noCache();

        return view('web/unified_checkout', $data);
    }

    /**
     * Creates a Doku checkout session and returns the payment URL.
     * 
     * Purpose: Initiates a transaction with the Doku Payment Gateway via API.
     * How it works:
     * 1. Retrieves order details from session.
     * 2. Generates a unique invoice number.
     * 3. Constructs the API request body (amount, customer info, callbacks).
     * 4. Generates required security headers (Signature/Digest).
     * 5. Sends POST request to Doku API.
     * 6. Returns JSON containing the payment URL or error message.
     * 
     * Redirects: None (Returns JSON response).
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
                // Point to the new raw webhook file to bypass potential hosting blocks
                'callback_url' => 'https://desawisatalembaharau.ifree.page/doku_webhook.php',
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
                'success_redirect_url' => site_url('web/payment/dokuPopupClose?id=' . $orderId),
                'failure_redirect_url' => site_url('web/payment/dokuPopupClose?id=' . $orderId)
            ]
        ];

        $dokuApiUrl = env('doku.apiUrl');
        $requestTarget = '/checkout/v1/payment';

        log_message('error', 'Doku API URL: ' . $dokuApiUrl);
        log_message('error', 'Doku Request Body: ' . json_encode($requestBody));
>>>>>>> Stashed changes

        try {
            // Get Snap payment page URL
            $snapToken = Snap::getSnapToken($transactionData);

<<<<<<< Updated upstream
            // Return snap token to the view
            // return view('web/payment_page', ['snapToken' => $snapToken]);
            return $snapToken;
=======
            $response = $this->guzzleClient->post($dokuApiUrl . $requestTarget, [
                'headers' => $dokuData['headers'],
                'body' => $dokuData['body']
            ]);

            $responseBody = json_decode($response->getBody()->getContents(), true);

            if (isset($responseBody['response']['payment']['url'])) {
                // The token is usually in 'token_id'. Check your logs if it's named differently.
                $paymentToken = $responseBody['response']['payment']['token_id'] ?? null;

                // Update your database here
                // $this->reservationModel->update($orderId, ['payment_token' => $paymentToken]); // Temporarily disabled as the column doesn't exist

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
     * 
     * Purpose: Sets up a transaction on PayPal's servers.
     * How it works:
     * 1. Validates AJAX request and PayPal client.
     * 2. Gets IDR amount from session and converts to USD.
     * 3. Sends `OrdersCreateRequest` to PayPal API.
     * 4. Returns JSON with the PayPal Order ID.
     * 
     * Redirects: None (Returns JSON response).
     */
    public function paypalCreateOrder()
    {
        // === TEST LOG ENTRY ===
        log_message('error', 'PayPal Create Order method entered. This is a test log entry.');
        // ======================

        log_message('error', 'PayPal Create Order Request: isAJAX=' . ($this->request->isAJAX() ? 'true' : 'false') . ', isAJAX() is deprecated. paypalClient=' . ($this->paypalClient ? 'initialized' : 'null') . ', CSRF Protection: ' . (config('Security')->csrfProtection ?? 'N/A'));

        if (!$this->request->isAJAX() || !$this->paypalClient) {
            log_message('error', 'PayPal Create Order failed: Not AJAX request or paypalClient not initialized.');
            return $this->response->setStatusCode(403);
        }

        $amountIDR = session()->get('order_amount_idr');
        $rate = (float)env('IDR_TO_USD_RATE');
        log_message('error', 'IDR_TO_USD_RATE: ' . env('IDR_TO_USD_RATE'));

        if (!$amountIDR || !$rate) {
            log_message('error', 'PayPal Create Order failed due to configuration error. Amount: ' . $amountIDR . ' Rate: ' . $rate);
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Configuration error.']);
        }

        // Convert IDR to USD and format to 2 decimal places
        $amountUSD = round($amountIDR * $rate, 2);

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
            return $this->response->setStatusCode(200)->setJSON([
                'id' => $response->result->id,
                'csrf_token' => csrf_hash() // Send new token for the next request
            ]);
>>>>>>> Stashed changes
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

<<<<<<< Updated upstream
    // Check payment status
    public function checkPaymentStatus($orderId)
=======
    /**
     * Captures the payment for a PayPal order after user approval.
     * 
     * Purpose: Finalizes the PayPal transaction and updates the reservation status.
     * How it works:
     * 1. Receives `orderID` from the frontend.
     * 2. Sends `OrdersCaptureRequest` to PayPal API.
     * 3. If status is 'COMPLETED', calls `_handleSuccessfulPayment` to update DB.
     * 4. Returns JSON status.
     * 
     * Redirects: None (Returns JSON response).
     */
    public function paypalCaptureOrder()
>>>>>>> Stashed changes
    {
        try {
            // Get the status of the transaction
            $status = Transaction::status($orderId);

            // Check the transaction status
            if ($status->transaction_status == 'settlement') {
                return 'Settlement';
            } elseif ($status->transaction_status == 'pending') {
                return 'Pending';
            } elseif ($status->transaction_status == 'deny') {
                return 'Deny';
            } elseif ($status->transaction_status == 'expire') {
                return 'Expire';
            } elseif ($status->transaction_status == 'cancel') {
                return 'Cancel';
            } else {
                return 'Unknown payment status';
            }
        } catch (\Exception $e) {
<<<<<<< Updated upstream
            return 'Error: ' . $e->getMessage();
        }
    }
=======
            $message = $e->getMessage();
            log_message('error', 'PayPal Capture Order Exception: ' . $message);

            // Handle INSTRUMENT_DECLINED (e.g. card rejected in sandbox)
            if (strpos($message, 'INSTRUMENT_DECLINED') !== false) {
                return $this->response->setStatusCode(422)->setJSON([
                    'error' => 'INSTRUMENT_DECLINED',
                    'csrf_token' => csrf_hash()
                ]);
            }

            return $this->response->setStatusCode(500)->setJSON(['error' => 'Failed to capture PayPal order.']);
        }
    }

    /**
     * Generates the required headers for a Doku API request.
     * 
     * Purpose: Creates the HMAC-SHA256 signature and other security headers required by Doku.
     * How it works:
     * 1. Generates Request-Id and Timestamp.
     * 2. Hashes the JSON body to create a Digest.
     * 3. Constructs the raw signature string using Client ID, Request ID, Timestamp, Target, and Digest.
     * 4. Signs the string using the Secret Key.
     * 5. Returns array containing headers and the raw JSON body.
     * 
     * Redirects: None.
     */
    // 1. Change return type to return BOTH headers and the body string
    private function generateDokuHeaders(string $requestTarget, array $requestBody): array
    {
        $clientId = env('doku.clientId');
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
        $secretKey = env('doku.secretKey');
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
     * 
     * Purpose: Webhook endpoint to receive payment status updates from Doku.
     * How it works:
     * 1. Reads headers and raw body from the request.
     * 2. Reconstructs the signature using the same logic as `generateDokuHeaders`.
     * 3. Compares the calculated signature with the one received in headers.
     * 4. If valid and status is SUCCESS, updates the reservation status via `_handleSuccessfulPayment`.
     * 5. Returns JSON status to Doku.
     * 
     * Redirects: None.
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
        log_message('error', $path);
        $signatureComponents = [
            'Client-Id:' . $clientId,
            'Request-Id:' . $requestId,
            'Request-Timestamp:' . $requestTimestamp,
            'Request-Target:' . $path,
            'Digest:' . $digest
        ];

        $signatureString = implode("\n", $signatureComponents);
        $secretKey = env('doku.secretKey');
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
     * 
     * Purpose: Updates the database status and clears session data after a confirmed payment.
     * How it works:
     * 1. Identifies the reservation ID and payment type (from args or session).
     * 2. Fetches the current reservation status.
     * 3. Determines the new status (e.g., 'Deposit Successful' or 'Full Pay Successful').
     * 4. Updates the database.
     * 5. Clears payment-related session variables.
     * 
     * Redirects: None.
     * 
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
     * 
     * Purpose: Generates valid headers and body for testing the Doku notification endpoint manually.
     * How it works:
     * 1. Uses configured credentials.
     * 2. Creates a mock success payload for the given invoice number.
     * 3. Calculates the correct signature.
     * 4. Returns JSON with headers and body to copy-paste into Postman.
     * 
     * Redirects: None.
     */
    public function testDoku($invoiceNumber)
    {
        $clientId = env('doku.clientId');
        $secretKey = env('doku.secretKey');
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
     * 
     * Purpose: Serves as the landing page after a Doku payment is completed or failed.
     * How it works:
     * 1. Gets the reservation ID from URL or session.
     * 2. Determines the fallback URL (reservation detail page).
     * 3. Returns HTML containing JavaScript.
     * 4. The JavaScript checks if the window has an opener (popup mode).
     *    - If yes, it redirects the opener to the detail page and closes the popup.
     *    - If no, it redirects the current window to the detail page.
     * 
     * Redirects:
     * - Javascript redirect to '/web/reservation/detail/{id}' (if ID exists).
     * - Javascript redirect to '/web/reservation' (fallback).
     */
    public function dokuPopupClose()
    {
        $id = $this->request->getGet('id');

        // Fallback URL: Go to detail page if ID exists, otherwise list page
        $baseUrl = rtrim(env('app.baseURL', 'https://desawisatalembaharau.ifree.page/'), '/');
        $fallbackUrl = $id ? $baseUrl . '/web/reservation/detail/' . $id : $baseUrl . '/web/reservation';

        return '
            <html>
            <body>
                <p>Please wait, you are being redirected...</p>
                <script>
                    try {
                        if (window.opener && !window.opener.closed) {
                            // This is a popup, reload the parent and close self
                            window.opener.location.reload();
                            window.close();
                        } else {
                            // Not a popup, just redirect the current window
                            window.location.href = "' . $fallbackUrl . '";
                        }
                    } catch (e) {
                        // Fallback in case of cross-origin issues
                        window.location.href = "' . $fallbackUrl . '";
                    }
                </script>
            </body>
            </html>
        ';
    }
>>>>>>> Stashed changes
}
