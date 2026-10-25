<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CPages extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MPelanggan');
        $this->load->model('MAdmin');
    }

    public function Admin()
    {
        if ($this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('message', 'Kamu Tidak Punya Akses Kesini');
            redirect('CAuth');
        }

        $data['total_wisata'] = $this->MAdmin->count_all('data_wisata');
        $data['total_penginapan'] = $this->MAdmin->count_all('data_penginapan');
        $data['total_pelanggan'] = $this->MAdmin->count_all('data_pelanggan');
        $data['total_pesanan'] = $this->MAdmin->count_all('pesanan');
        $data['pesanan_terbaru'] = $this->MAdmin->get_pesanan_terbaru();
        $data['total_pesanan_per_bulan'] = $this->MAdmin->get_pesanan_per_bulan();

        // header('Content-Type: application/json');
        // echo json_encode($data);

        $this->load->view('components/header.php');
        $this->load->view('components/sidebar_admin.php');
        $this->load->view('pages/admin/dashboard/index.php', $data);
        $this->load->view('components/footer.php');
    }


    public function Pelanggan()
    {

        $input = $this->input->get('kapasitas', TRUE);
        $kapasitas = NULL;

        if (
            $input !== NULL &&
            $input !== '' &&
            ctype_digit((string) $input) &&
            (int) $input > 0
        ) {
            $kapasitas = (int) $input;
        }

        $data['kapasitas_terpilih'] = $kapasitas;

        $data['data_penginapan'] =
            $this->MPelanggan->get_penginapan_with_kategori_limit(
                $kapasitas
            );


        $data['data_wisata'] =
            $this->MPelanggan->get_wisata_with_kategori_limit();

        $data['id_pelanggan'] =
            $this->session->userdata('id_pelanggan');

        $data['data_kategori'] =
            $this->MPelanggan->get_data_kategori_aktif();

        $this->load->view('components/header.php');
        $this->load->view('components/navbar.php', $data);
        $this->load->view(
            'pages/pelanggan/beranda/index.php',
            $data
        );
        $this->load->view('components/footer_pelanggan.php');
    }


    public function Owner()
    {
        if (!$this->session->userdata('role') == 'owner') {
            $this->session->set_flashdata('message', 'Kamu Tidak Punya Akses Kesini');
            redirect('CAuth');
        }

        $data['total_wisata'] = $this->MAdmin->count_all('data_wisata');
        $data['total_penginapan'] = $this->MAdmin->count_all('data_penginapan');
        $data['total_pelanggan'] = $this->MAdmin->count_all('data_pelanggan');
        $data['total_pesanan'] = $this->MAdmin->count_all('pesanan');
        $data['pesanan_terbaru'] = $this->MAdmin->get_pesanan_terbaru();
        $data['total_pesanan_per_bulan'] = $this->MAdmin->get_pesanan_per_bulan();

        $pesanan_terbaru = $this->MAdmin->get_pesanan_terbaru();

        foreach ($pesanan_terbaru as $item) {
            switch ($item->status_pesanan) {
                case 'pending':
                    $item->badge_color = 'bg-[#732b79] text-white';
                    break;
                case 'proses':
                    $item->badge_color = 'bg-[#feae28] text-black';
                    break;
                case 'selesai':
                    $item->badge_color = 'bg-[#00880e] text-white';
                    break;
                case 'batal':
                    $item->badge_color = 'bg-gray-200 text-black';
                    break;
                default:
                    $item->badge_color = 'bg-gray-200 text-black';
                    break;
            }
        }

        $data['pesanan_terbaru'] = $pesanan_terbaru;

        $this->load->view('components/header.php');
        $this->load->view('components/sidebar_owner.php');
        $this->load->view('pages/owner/dashboard/index.php', $data);
        $this->load->view('components/footer.php');
    }
}
