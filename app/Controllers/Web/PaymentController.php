<?php

namespace App\Controllers\Web;

use App\Models\Reservation\ReservationModel;
use CodeIgniter\Controller;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class PaymentController extends Controller
{
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

        if (!$reservation || $reservation->user_id !== user_id()) {
            return redirect()->to('/web/reservation')->with('error', 'Reservation not found.');
        }

        $amount = 0;
        if ($paymentType === 'deposit' && $reservation->status === '1') {
            $amount = $reservation->deposit_price;
        } elseif ($paymentType === 'full' && $reservation->status === '2') {
            $amount = $reservation->total_price - $reservation->deposit_price;
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

        $data = [
            'title' => 'Unified Checkout',
            'reservation_id'   => $reservationId,
            'order_amount_idr' => $amount,
            'idr_to_usd_rate'  => (float)getenv('IDR_TO_USD_RATE')
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

        if (!$amount) {
            return redirect()->to('/')->with('error', 'Order amount not found.');
        }

        $requestBody = [
            'order' => ['invoice_number' => $orderId, 'amount' => $amount],
            'payment' => ['payment_due_date' => 120],
            'customer' => ['name' => user()->username, 'email' => user()->email],
        ];

        $dokuApiUrl = getenv('doku.apiUrl');
        $requestTarget = '/checkout/v1/payment';

        try {
            $response = $this->guzzleClient->post($dokuApiUrl . $requestTarget, [
                'headers' => $this->generateDokuHeaders($requestTarget, $requestBody),
                'json' => $requestBody
            ]);

            $responseBody = json_decode($response->getBody()->getContents(), true);

            if (isset($responseBody['response']['payment']['url'])) {
                return redirect()->to($responseBody['response']['payment']['url']);
            }

            log_message('error', 'Doku Checkout failed: ' . json_encode($responseBody));
            return redirect()->to('/web/checkout/' . $orderId . '/' . session()->get('payment_type'))->with('error', 'Failed to create Doku payment session.');
        } catch (RequestException $e) {
            log_message('error', 'Doku API Exception: ' . $e->getMessage());
            return redirect()->to('/web/checkout/' . $orderId . '/' . session()->get('payment_type'))->with('error', 'An error occurred with the Doku payment gateway.');
        }
    }

    /**
     * Creates a PayPal order and returns the Order ID.
     */
    public function paypalCreateOrder()
    {
        if (!$this->request->isAJAX() || !$this->paypalClient) {
            return $this->response->setStatusCode(403);
        }

        $amountIDR = session()->get('order_amount_idr');
        $rate = (float)getenv('IDR_TO_USD_RATE');

        if (!$amountIDR || !$rate) {
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

        if (!$orderId) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Order ID is missing.']);
        }

        $request = new OrdersCaptureRequest($orderId);
        $request->prefer('return=representation');

        try {
            $response = $this->paypalClient->execute($request);

            if ($response->result->status === 'COMPLETED') {
                $this->_handleSuccessfulPayment();
                log_message('info', "PayPal payment completed for Order ID: {$orderId}");
                return $this->response->setStatusCode(200)->setJSON(['status' => 'success', 'reservation_id' => session()->get('reservation_id')]);
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
    private function generateDokuHeaders(string $requestTarget, array $requestBody): array
    {
        $clientId = getenv('doku.clientId');
        $requestId = bin2hex(random_bytes(16));
        $requestTimestamp = gmdate("Y-m-d\TH:i:s\Z");

        $digest = base64_encode(hash('sha256', json_encode($requestBody), true));

        $signatureComponents = [
            'Client-Id:' . $clientId,
            'Request-Id:' . $requestId,
            'Request-Timestamp:' . $requestTimestamp,
            'Request-Target:' . $requestTarget,
            'Digest:' . $digest
        ];

        $signatureString = implode("\n", $signatureComponents);
        $secretKey = getenv('doku.secretKey');
        $signature = base64_encode(hash_hmac('sha256', $signatureString, $secretKey, true));

        return [
            'Client-Id' => $clientId,
            'Request-Id' => $requestId,
            'Request-Timestamp' => $requestTimestamp,
            'Signature' => "HMACSHA256=" . $signature,
        ];
    }

    /**
     * Verifies an incoming Doku notification signature.
     */
    public function dokuNotification()
    {
        $headers = $this->request->getHeaders();
        $notificationBody = $this->request->getJSON(true);

        $clientId = $headers['Client-Id']->getValue();
        $requestId = $headers['Request-Id']->getValue();
        $requestTimestamp = $headers['Request-Timestamp']->getValue();
        $signature = $headers['Signature']->getValue();

        $digest = base64_encode(hash('sha256', json_encode($notificationBody), true));

        $signatureComponents = [
            'Client-Id:' . $clientId,
            'Request-Id:' . $requestId,
            'Request-Timestamp:' . $requestTimestamp,
            'Request-Target:' . $this->request->getPath(),
            'Digest:' . $digest
        ];

        $signatureString = implode("\n", $signatureComponents);
        $secretKey = getenv('doku.secretKey');
        $expectedSignature = "HMACSHA256=" . base64_encode(hash_hmac('sha256', $signatureString, $secretKey, true));

        if (hash_equals($expectedSignature, $signature)) {
            if ($notificationBody['transaction']['status'] === 'SUCCESS') {
                $this->_handleSuccessfulPayment($notificationBody['order']['invoice_number']);
            }
            return $this->response->setStatusCode(200)->setJSON(['status' => 'SUCCESS']);
        }

        log_message('error', "Invalid Doku signature for order");
        return $this->response->setStatusCode(400)->setJSON(['status' => 'FAILED']);
    }

    /**
     * Handles the logic for a successful payment.
     * @param string|null $reservationId
     */
    private function _handleSuccessfulPayment(string $reservationId = null)
    {
        $reservationId = $reservationId ?? session()->get('reservation_id');
        $paymentType   = session()->get('payment_type');

        if (!$reservationId) {
            log_message('error', 'Could not handle successful payment: reservation ID is missing.');
            return;
        }

        $reservation = $this->reservationModel->find($reservationId);

        if (!$reservation) {
            log_message('error', "Could not find reservation with ID: {$reservationId}");
            return;
        }

        // Determine next status based on current status and payment type
        $nextStatus = null;
        if ($paymentType === 'deposit' && $reservation->status === '1') { // Deposit payment
            $nextStatus = '2'; // Status for "Deposit Successful"
        } elseif ($paymentType === 'full' && $reservation->status === '2') { // Full payment
            $nextStatus = '3'; // Status for "Full Pay Successful"
        }

        if ($nextStatus) {
            $this->reservationModel->update($reservationId, ['status' => $nextStatus]);
            log_message('info', "Reservation {$reservationId} status updated to {$nextStatus}.");
        }

        // Clear session data
        session()->remove(['reservation_id', 'payment_type', 'order_amount_idr']);
    }
}
