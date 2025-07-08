<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'lukmanjunedd@gmail.com'; // Replace with your email
    $mail->Password = 'hnsr foae fquk yixw'; // Replace with your app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('lukmanjunedd@gmail.com', 'TourismVillage');
    $mail->addAddress('nightbaron.369@gmail.com'); // Replace with recipient email

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Test Email from PHPMailer';
    $mail->Body = '<h1>Hello!</h1><p>This is a test email.</p>';

    $mail->send();
    echo 'Email successfully sent.';
} catch (Exception $e) {
    echo "Failed to send email. Error: {$mail->ErrorInfo}";
}
