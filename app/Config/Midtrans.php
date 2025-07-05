<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Midtrans extends BaseConfig
{
    public $serverKey = 'SB-Mid-server-6zIoeK9pROKtoWYdnM9mbuMV'; // Replace with your Midtrans Server Key
    public $clientKey = 'SB-Mid-client-bjKbrTJOVNQuPxZ2'; // Replace with your Midtrans Client Key
    public $isProduction = false; // Set to true if you are using the production environment
    public $isSanitized = true;
    public $is3ds = true;
}
