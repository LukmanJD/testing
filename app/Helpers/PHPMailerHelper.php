<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once APPPATH . '../vendor/autoload.php';

function sendEmailWithPHPMailer($to, $subject, $body)
{
    $mail = new PHPMailer(true);

    try {
        // --- SMTP Debugging ---
        // Enable verbose debug output if set in .env
        if (env('SMTP_DEBUG') === 'true') {
            $mail->SMTPDebug = \PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;
        }

        // Server settings
        $mail->isSMTP();
        $mail->Host = env('SMTP_HOST');
        $mail->SMTPAuth = true;
        $mail->Username = env('SMTP_USERNAME');
        $mail->Password = env('SMTP_PASSWORD');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use SMTPS which is generally more reliable
        $mail->Port = (int)env('SMTP_PORT');

        // Recipients
        $mail->setFrom(env('SMTP_FROM_EMAIL'), env('SMTP_FROM_NAME'));
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Log the full exception message for better debugging
        log_message('error', "PHPMailer Exception: {$e->getMessage()}. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
