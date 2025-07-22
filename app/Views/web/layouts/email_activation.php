<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Account Activation</title>
</head>

<body>
    <h1>Account Activation</h1>
    <p>Thank you for registering. Please click the link below to activate your account. This link is valid for 10 minutes.</p>
    <p>
        <a href="<?= site_url('register/activateAccount/' . $hash) ?>">Activate My Account</a>
    </p>
</body>

</html>