<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $fromEmail = 'lukmanjunedd@gmail.com';
    public string $fromName = 'TourismVillage';
    public string $recipients = '';

    //--------------------------------------------------------------------

    public string $protocol = 'smtp';

    //--------------------------------------------------------------------
    // SMTP Settings

    public string $SMTPHost = 'smtp.gmail.com'; // Updated to Gmail's SMTP server
    public string $SMTPUser = 'lukmanjunedd@gmail.com'; // Updated to Gmail user
    public string $SMTPPass = 'hnsr foae fquk yixw'; // Updated to Gmail app password
    public int $SMTPPort = 587; // Gmail SMTP port
    public int $SMTPTimeout = 300; // Increase timeout to 300 seconds
    public bool $SMTPKeepAlive = true;
    public string $SMTPCrypto = 'tls'; // Ensure 'tls' is used for Gmail
    public bool $SMTPAutoTLS = true;   // Enabled AutoTLS for secure connection
    public bool $SMTPDebug = false;    // Disable debugging for production

    //--------------------------------------------------------------------
    // Pengaturan tambahan opsional

    public string $mailType = 'html';
    public string $charset = 'UTF-8';
    public bool $validate = true;
}
