<?php

namespace App\Controllers\Web;

use CodeIgniter\Controller;
use Midtrans\Config;
use Midtrans\Snap;
use Config\Midtrans as MidtransConfig;
use Midtrans\Transaction;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Load Midtrans configuration
        $midtransConfig = new MidtransConfig();

        // Set Midtrans configuration
        Config::$serverKey = $midtransConfig->serverKey;
        Config::$clientKey = $midtransConfig->clientKey;
        Config::$isProduction = $midtransConfig->isProduction;
        Config::$isSanitized = $midtransConfig->isSanitized;
        Config::$is3ds = $midtransConfig->is3ds;
    }

    // Create a payment transaction
    public function createTransaction($transactionDetails = null, $customerDetails = null)
    {

        // Transaction payload
        $transactionData = array(
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
        );

        try {
            // Get Snap payment page URL
            $snapToken = Snap::getSnapToken($transactionData);

            // Return snap token to the view
            // return view('web/payment_page', ['snapToken' => $snapToken]);
            return $snapToken;
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    // Check payment status
    public function checkPaymentStatus($orderId)
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
            return 'Error: ' . $e->getMessage();
        }
    }
}
