<!DOCTYPE html>
<html>

<head>
    <title>Midtrans Payment</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= config('Midtrans')->clientKey; ?>"></script>
</head>

<body>
    <h1>Proceed to Payment</h1>

    <button id="pay-button">Pay Now</button>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');

        payButton.addEventListener('click', function() {
            console.log('<?= $snapToken; ?>');
            snap.pay('<?= $snapToken; ?>'); // Use the Snap token from the controller
        });
    </script>
</body>

</html>