<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <h1>Checkout</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Your Order</h5>
                <p>Total Amount: <strong>Rp <?= number_format($order_amount_idr, 0, ',', '.') ?></strong></p>
                <hr>

                <!-- Currency Converter -->
                <?php if (!empty($rates)) : ?>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="currency-select" class="form-label">See price in another currency:</label>
                            <select id="currency-select" class="form-select">
                                <option value="IDR" selected>IDR (Indonesian Rupiah)</option>
                                <?php foreach ($rates as $currency => $rate) : ?>
                                    <option value="<?= esc($currency) ?>"><?= esc($currency) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <h5 id="converted-price" class="mb-1"></h5>
                        </div>
                    </div>
                    <hr>
                <?php endif; ?>

                <!-- Doku Payment Button -->
                <h5>Pay with Doku (IDR)</h5>
                <form id="doku-payment-form" action="<?= site_url('/web/payment/dokuCheckout') ?>" method="post">
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
    <script src="https://www.paypal.com/sdk/js?client-id=<?= env('paypal.clientId') ?>&currency=USD"></script>

    <?php if (!empty($rates)) : ?>
        <script>
            const rates = <?= json_encode($rates) ?>;
            const baseAmountIDR = <?= $order_amount_idr ?>;
            const currencySelector = document.getElementById('currency-select');
            const convertedPriceElement = document.getElementById('converted-price');

            function updateConvertedPrice() {
                const selectedCurrency = currencySelector.value;

                if (selectedCurrency === 'IDR') {
                    convertedPriceElement.innerText = '';
                    return;
                }

                const rate = rates[selectedCurrency];
                if (rate) {
                    const convertedAmount = baseAmountIDR * rate;

                    // Format the currency with symbol and appropriate decimal places
                    const formattedAmount = new Intl.NumberFormat(undefined, {
                        style: 'currency',
                        currency: selectedCurrency,
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }).format(convertedAmount);

                    convertedPriceElement.innerText = `${formattedAmount}`;
                }
            }

            // Add event listener
            currencySelector.addEventListener('change', updateConvertedPrice);
        </script>
    <?php endif; ?>

    <script>
        // Doku Payment Handling
        const dokuForm = document.getElementById('doku-payment-form');
        dokuForm.addEventListener('submit', function(event) {
            event.preventDefault();

            // Get the CSRF token name and hash from the form
            const csrfName = dokuForm.querySelector('input[name="<?= csrf_token() ?>"]').name;
            const csrfHash = dokuForm.querySelector('input[name="<?= csrf_token() ?>"]').value;

            // Since dokuCheckout is excluded from CSRF, we don't need to send the token.
            // We also send an empty body because the controller gets data from the session.
            fetch('<?= site_url('web/payment/dokuCheckout') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data && data.payment_url) {
                        // Open Doku payment page in a new window/popup
                        window.open(data.payment_url, 'doku_payment', 'width=800,height=600');
                    } else if (data && data.error) {
                        alert('Error: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while processing the Doku payment.');
                });
        });

        // PayPal Payment Handling
        let csrfHeader = '<?= config('Security')->headerName ?>' || 'X-CSRF-TOKEN';
        let csrfHash = '<?= csrf_hash() ?>';

        paypal.Buttons({
            // 1. Set up the transaction
            createOrder: function(data, actions) {
                // Call your backend to create the order
                return fetch('<?= site_url('/web/payment/paypalCreateOrder') ?>', {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        [csrfHeader]: csrfHash
                    },
                    body: JSON.stringify({})
                }).then(function(res) {
                    return res.json();
                }).then(function(orderData) {
                    // Update CSRF hash for the next request (captureOrder)
                    if (orderData.csrf_token) {
                        csrfHash = orderData.csrf_token;
                    }
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
                        'X-Requested-With': 'XMLHttpRequest',
                        [csrfHeader]: csrfHash
                    },
                    body: JSON.stringify({
                        orderID: data.orderID
                    })
                }).then(function(res) {
                    return res.json();
                }).then(function(orderData) {
                    // Update CSRF hash if returned (even on error)
                    if (orderData.csrf_token) {
                        csrfHash = orderData.csrf_token;
                    }

                    // Handle Instrument Declined (allow retry)
                    if (orderData.error === 'INSTRUMENT_DECLINED') {
                        return actions.restart();
                    }

                    if (orderData.status === 'success') {
                        // Send a success message to the parent window instead of reloading directly
                        // The parent window will listen for this message and handle the reload.
                        window.parent.postMessage('paymentSuccess', '<?= base_url() ?>');
                    } else {
                        alert('Something went wrong with the payment.');
                    }
                });
            }
        }).render('#paypal-button-container');
    </script>
</body>

</html>