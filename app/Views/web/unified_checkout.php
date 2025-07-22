<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Unified Checkout</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Your Order</h5>
                <?php
                $amountUSD = round($order_amount_idr / $idr_to_usd_rate, 2);
                ?>
                <p>Total Amount: <strong>Rp <?= number_format($order_amount_idr, 0, ',', '.') ?></strong> (approx. $<?= number_format($amountUSD, 2, '.', '') ?>)</p>
                <hr>

                <!-- Doku Payment Button -->
                <h5>Pay with Doku (IDR)</h5>
                <form action="<?= site_url('/web/payment/dokuCheckout') ?>" method="post">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-primary">Pay with Doku</button>
                </form>

                <hr>

                <!-- PayPal Payment Button -->
                <h5>Pay with PayPal (USD)</h5>
                <div id="paypal-button-container" style="max-width: 300px;"></div>
            </div>
        </div>
    </div>

    <!-- PayPal SDK Script -->
    <script src="https://www.paypal.com/sdk/js?client-id=<?= getenv('paypal.clientId') ?>&currency=USD"></script>

    <script>
        paypal.Buttons({
            // 1. Set up the transaction
            createOrder: function(data, actions) {
                // Call your backend to create the order
                return fetch('<?= site_url('/web/payment/paypalCreateOrder') ?>', {
                    method: 'post'
                }).then(function(res) {
                    return res.json();
                }).then(function(orderData) {
                    if (orderData.id) {
                        return orderData.id;
                    }
                    alert('Could not create PayPal order. Please try again.');
                    return null;
                });
            },

            // 2. Finalize the transaction
            onApprove: function(data, actions) {
                // Call your backend to capture the order
                return fetch('<?= site_url('/web/payment/paypalCaptureOrder') ?>', {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        orderID: data.orderID
                    })
                }).then(function(res) {
                    return res.json();
                }).then(function(orderData) {
                    if (orderData.status === 'success') {
                        alert('Transaction completed!');
                        // Redirect to the reservation detail page
                        window.location.href = '<?= site_url('web/reservation/detail/') ?>' + orderData.reservation_id;
                    } else {
                        alert('Something went wrong with the payment.');
                    }
                });
            }
        }).render('#paypal-button-container');
    </script>
</body>

</html>