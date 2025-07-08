<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmailWithPHPMailer($to, $subject, $body, $fromEmail = 'lukmanjunedd@gmail.com', $fromName = 'TourismVillage')
{
    require_once APPPATH . '../vendor/autoload.php';

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'lukmanjunedd@gmail.com'; // Replace with your email
        $mail->Password = 'hnsr foae fquk yixw'; // Replace with your app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        log_message('error', "PHPMailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
