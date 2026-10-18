<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;


class CLaporanPelanggan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MAdmin');
    }

    public function index()
    {
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        $data['pelanggan'] = $this->MAdmin->get_pelanggan_filter($bulan, $tahun);
        $data['bulan_aktif'] = $bulan;
        $data['tahun_aktif'] = $tahun;

        // header('Content-Type: application/json');
        // echo json_encode($data);

        $this->load->view('components/header.php');
        $this->load->view('components/sidebar_owner.php');
        $this->load->view('pages/owner/laporan-pelanggan/index.php', $data);
        $this->load->view('components/footer.php');
    }

    public function generate_pdf()
    {
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');

        $data['pelanggan']  = $this->MAdmin->get_pelanggan_filter($bulan, $tahun);
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        // Render HTML dari view
        $html = $this->load->view('pages/owner/laporan-pelanggan/pdf.php', $data, true);

        // ✅ Konfigurasi DomPDF untuk mengizinkan akses remote image
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE); // WAJIB agar logo tampil dari URL

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream("laporan_pelanggan_{$bulan}_{$tahun}.pdf", array("Attachment" => 0));
    }
}
