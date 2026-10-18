<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CPelanggan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MPelanggan');
        $this->load->library('midtrans_lib');
        $this->load->library('upload');
        $this->load->library('email');
    }

    public function penginapan_page()
    {

        $data['data_penginapan'] = $this->MPelanggan->get_penginapan_with_kategori();
        $data['id_pelanggan'] = $this->session->userdata('id_pelanggan');
        $data['data_kategori'] = $this->MPelanggan->get_data_kategori_aktif();

        // header('Content-Type: application/json');
        // echo json_encode($data);

        $this->load->view('components/header.php');
        $this->load->view('components/navbar.php', $data);
        $this->load->view('pages/pelanggan/penginapan/index.php', $data);
        $this->load->view('components/footer_pelanggan.php');
    }

    public function detail_penginapan_page($id)
    {
        $data['id_pelanggan'] = $this->session->userdata('id_pelanggan');
        $data['penginapan'] = $this->MPelanggan->get_penginapan_with_kategori_by_id($id);
        $data['fasilitas'] = $this->MPelanggan->get_fasilitas_by_penginapan($id);
        $data['penginapan_gambar'] = $this->MPelanggan->get_gambar_with_penginapan($id);
        $data['data_kategori'] = $this->MPelanggan->get_data_kategori_aktif();

        // header('Content-Type: application/json');
        // echo json_encode($data);

        $this->load->view('components/header.php');
        $this->load->view('components/navbar.php', $data);
        $this->load->view('pages/pelanggan/penginapan/detail.php', $data);
        // $this->load->view('components/footer_pelanggan.php');
    }

    public function wisata_page()
    {
        $data['data_wisata'] = $this->MPelanggan->get_wisata_with_kategori();
        $data['id_pelanggan'] = $this->session->userdata('id_pelanggan');
        $data['data_kategori'] = $this->MPelanggan->get_data_kategori_aktif();

        // header('Content-Type: application/json');
        // echo json_encode($data);

        $this->load->view('components/header.php');
        $this->load->view('components/navbar.php', $data);
        $this->load->view('pages/pelanggan/wisata/index.php', $data);
        $this->load->view('components/footer_pelanggan.php');
    }

    public function detail_wisata_page($id)
    {
        $data['id_pelanggan'] = $this->session->userdata('id_pelanggan');
        $data['wisata'] = $this->MPelanggan->get_wisata_with_kategori_by_id($id);
        $data['wisata_gambar'] = $this->MPelanggan->get_gambar_with_wisata($id);
        $data['data_kategori'] = $this->MPelanggan->get_data_kategori_aktif();

        // header('Content-Type: application/json');
        // echo json_encode($data);

        $this->load->view('components/header.php');
        $this->load->view('components/navbar.php', $data);
        $this->load->view('pages/pelanggan/wisata/detail.php', $data);
        // $this->load->view('components/footer_pelanggan.php');
    }

    public function transportasi_page()
    {
        $data['data_transportasi'] = $this->MPelanggan->get_transportasi_with_kategori();
        $data['id_pelanggan'] = $this->session->userdata('id_pelanggan');
        $data['data_kategori'] = $this->MPelanggan->get_data_kategori_aktif();

        // header('Content-Type: application/json');
        // echo json_encode($data);

        $this->load->view('components/header.php');
        $this->load->view('components/navbar.php', $data);
        $this->load->view('pages/pelanggan/transportasi/index.php', $data);
        $this->load->view('components/footer_pelanggan.php');
    }

    public function detail_transportasi_page($id)
    {
        $data['id_pelanggan'] = $this->session->userdata('id_pelanggan');
        $data['transportasi'] = $this->MPelanggan->get_transportasi_with_kategori_by_id($id);
        $data['transportasi_gambar'] = $this->MPelanggan->get_gambar_with_transportasi($id);
        $data['data_kategori'] = $this->MPelanggan->get_data_kategori_aktif();

        // header('Content-Type: application/json');
        // echo json_encode($data);

        $this->load->view('components/header.php');
        $this->load->view('components/navbar.php', $data);
        $this->load->view('pages/pelanggan/transportasi/detail.php', $data);
        // $this->load->view('components/footer_pelanggan.php');
    }

    public function maintenance_page()
    {
        $this->load->view('components/header.php');
        $this->load->view('pages/pelanggan/maintenance/index.php');
        $this->load->view('components/footer.php');
    }
}
