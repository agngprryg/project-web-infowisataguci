<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;


class COwner extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MOwner');
    }

    public function laporan_penjualan()
    {
        $data['data_pesanan'] = $this->MOwner->get_item_pesanan_with_pesanan();

        // header('Content-Type: application/json');
        // echo json_encode($data);

        $this->load->view('components/header.php');
        $this->load->view('components/sidebar_owner.php');
        $this->load->view('pages/owner/laporan-penjualan/index.php', $data);
        $this->load->view('components/footer.php');
    }

    public function cetak_laporan_penjualan()
    {
        $data['data_pesanan'] = $this->MOwner->get_item_pesanan_with_pesanan();
        $html =  $this->load->view('pages/owner/laporan-penjualan/pdf.php', $data, TRUE);

        // Buat PDF dengan Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // Atur ukuran dan orientasi kertas
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF
        $dompdf->render();

        // Output ke browser
        $dompdf->stream("Laporan_Kunjungan.pdf", array("Attachment" => 0));
    }
}
