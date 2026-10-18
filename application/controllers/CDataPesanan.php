<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CDataPesanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MAdmin');

        if (!$this->session->userdata('role') == 'admin') {
            $this->session->set_flashdata('message', 'Kamu Tidak Punya Akses Kesini');
            redirect('CAuth');
        }
    }

    public function index()
    {
        $data['pesanan']  = $this->MAdmin->get_all('pesanan');

        // header('Content-Type: application/json');
        // echo json_encode($data);

        $this->load->view('components/header.php');
        $this->load->view('components/sidebar_kasir.php');
        $this->load->view('pages/kasir/data-pesanan/index.php', $data);
        $this->load->view('components/footer.php');
    }

    public function detail($id)
    {
        $data['pesanan']  = $this->MAdmin->get_item_pesanan_with_pesanan_by_id($id);
        $data['wisata']  = $this->MAdmin->get_item_pesanan_with_wisata_by_id($id);

        // header('Content-Type: application/json');
        // echo json_encode($data);

        $this->load->view('components/header.php');
        $this->load->view('components/sidebar_kasir.php');
        $this->load->view('pages/kasir/data-pesanan/detail.php', $data);
        $this->load->view('components/footer.php');
    }

    public function update($id_pesanana)
    {
        $data = [
            'status' => 'Booked'
        ];

        $this->MAdmin->update('pesanan', $data, $id_pesanana);
        redirect('kasir/data-pesanan');
    }
}
