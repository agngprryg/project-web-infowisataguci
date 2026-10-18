<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CKasir extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MKasir');
        $this->load->library('upload');
    }

    public function konfirmasi_pesanan()
    {
        $this->load->view('components/header.php');
        $this->load->view('components/sidebar_kasir.php');
        $this->load->view('pages/kasir/konfirmasi-pesanan/index.php');
        $this->load->view('components/footer.php');
    }
}
