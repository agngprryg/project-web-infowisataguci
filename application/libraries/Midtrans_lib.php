<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '../vendor/autoload.php';

class Midtrans_Lib
{

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->config->load('midtrans');

        \Midtrans\Config::$serverKey = $this->ci->config->item('midtrans_server_key');
        \Midtrans\Config::$isProduction = $this->ci->config->item('midtrans_is_production');
        \Midtrans\Config::$isSanitized = $this->ci->config->item('midtrans_is_sanitized');
        \Midtrans\Config::$is3ds = $this->ci->config->item('midtrans_is_3ds');
    }
}
