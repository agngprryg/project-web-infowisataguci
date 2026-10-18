<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config['midtrans_server_key'] = getenv('MIDTRANS_SERVER_KEY');
$config['midtrans_client_key'] = getenv('MIDTRANS_CLIENT_KEY');
$config['midtrans_is_production'] = false;
$config['midtrans_is_sanitized'] = TRUE;
$config['midtrans_is_3ds'] = TRUE;
