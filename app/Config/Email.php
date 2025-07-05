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

    public string $SMTPHost = 'sandbox.smtp.mailtrap.io';
    public string $SMTPUser = 'a94646f83ec0e1';
    public string $SMTPPass = '199ef19887a082'; // BUKAN password utama akun Google
    public int $SMTPPort = 587;
    public int $SMTPTimeout = 60;
    public bool $SMTPKeepAlive = true;
    public string $SMTPCrypto = ''; // 'tls' atau 'ssl'
    public bool $SMTPAutoTLS = false;

    //--------------------------------------------------------------------
    // Pengaturan tambahan opsional

    public string $mailType = 'html';
    public string $charset = 'UTF-8';
    public bool $validate = true;
}
