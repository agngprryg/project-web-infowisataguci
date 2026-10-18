<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CDataWisata extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MAdmin');
        $this->load->library('upload');
        $this->load->library('form_validation');

        if (!$this->session->userdata('role') == 'admin') {
            $this->session->set_flashdata('message', 'Kamu Tidak Punya Akses Kesini');
            redirect('CAuth');
        }
    }

    public function index()
    {
        $data['data_wisata']  = $this->MAdmin->get_wisata_with_kategori();

        // header('Content-Type: application/json');
        // echo json_encode($data);

        $this->load->view('components/header.php');
        $this->load->view('components/sidebar_admin.php');
        $this->load->view('pages/admin/data-wisata/index.php', $data);
        $this->load->view('components/footer.php');
    }

    public function create()
    {
        $data['data_kategori'] = $this->MAdmin->get_all('data_kategori');

        $this->load->view('components/header.php');
        $this->load->view('components/sidebar_admin.php');
        $this->load->view('pages/admin/data-wisata/create.php', $data);
        $this->load->view('components/footer.php');
    }

    public function store()
    {
        $rules = [
            [
                'field' => 'id_kategori',
                'label' => 'Kategori',
                'rules' => 'required'
            ],
            [
                'field' => 'nama',
                'label' => 'Nama',
                'rules' => 'required'
            ],
            [
                'field' => 'deskripsi',
                'label' => 'Deskripsi',
                'rules' => 'required'
            ],

            [
                'field' => 'status',
                'label' => 'Status',
                'rules' => 'required'
            ],
        ];

        $this->load->helper('tarif');
        $this->form_validation->set_rules(array_merge($rules, tarif_validation_rules()));
        $data['data_kategori'] = $this->MAdmin->get_all('data_kategori');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('components/header.php');
            $this->load->view('components/sidebar_admin.php');
            $this->load->view('pages/admin/data-wisata/create.php', $data);
            $this->load->view('components/footer.php');
            return;
        }

        $thumbnail = $this->input->post('compressed_gambar');

        if (!empty($thumbnail)) {
            $thumbnail = str_replace('data:image/jpeg;base64,', '', $thumbnail);
            $thumbnail = str_replace('data:image/jpg;base64,', '', $thumbnail);
            $thumbnail = str_replace('data:image/png;base64,', '', $thumbnail);
            $thumbnail = str_replace(' ', '+', $thumbnail);

            $thumbnail_binary = base64_decode($thumbnail);

            $thumbnail_name = uniqid() . '.jpg';

            file_put_contents(FCPATH . 'uploads/wisata/' . $thumbnail_name, $thumbnail_binary);
        } else {
            $this->session->set_flashdata('error', 'Thumbnail tidak valid atau tidak boleh kosong!');
            redirect('admin/data-wisata/create');
        }

        $lastOrder = $this->db->select_max('urutan')
            ->get('data_wisata')
            ->row()->urutan;

        $lastOrder = $lastOrder ?? 0;

        $wisataData = [
            'id_kategori' => $this->input->post('id_kategori'),
            'nama'        => $this->input->post('nama'),
            'deskripsi'   => $this->input->post('deskripsi'),
            'thumbnail'   => $thumbnail_name,
            'urutan'      => $lastOrder + 1,
            'harga_weekday' => $this->input->post('harga_weekday'),
            'harga_weekend' => $this->input->post('harga_weekend'),
            'harga_high_season' => $this->input->post('harga_high_season'),
            'status'      => $this->input->post('status'),
        ];

        $id_wisata = $this->MAdmin->store('data_wisata', $wisataData);

        $images = $this->input->post('compressed_gambars');
        $images = json_decode($images, true);

        if (!is_array($images) || empty($images)) {
            $this->session->set_flashdata('error', 'Detail Gambar Tidak Boleh Kosong!');
            redirect('admin/data-wisata/create');
        } else {
            foreach ($images as $index => $item) {
                $item = preg_replace('/^data:image\/\w+;base64,/', '', $item);
                $item = str_replace(' ', '+', $item);

                $item_binary = base64_decode($item);
                $item_name = uniqid() . '.jpg';

                file_put_contents(FCPATH . 'uploads/wisata/' . $item_name, $item_binary);

                $data_gambar_detail = [
                    'id_referensi' => $id_wisata,
                    'gambar'       => $item_name,
                    'tipe'         => 'wisata',
                    'urutan'       => $index + 1
                ];

                $this->db->insert('data_gambar', $data_gambar_detail);
            }
        }

        redirect('admin/data-wisata');
    }

    public function edit($id)
    {
        $data['data_wisata'] = $this->MAdmin->get_by_id('data_wisata', $id);
        $data['data_kategori'] = $this->MAdmin->get_all('data_kategori');
        $data['data_gambar'] = $this->MAdmin->get_gambar_with_wisata($id);

        $this->load->view('components/header.php');
        $this->load->view('components/sidebar_admin.php');
        $this->load->view('pages/admin/data-wisata/edit.php', $data);
        $this->load->view('components/footer.php');
    }

    public function update($id)
    {
        $this->load->helper('tarif');
        $this->form_validation->set_rules(tarif_validation_rules());
        if (!$this->form_validation->run()) {
            $this->edit($id);
            return;
        }
        $data_wisata = $this->MAdmin->get_by_id('data_wisata', $id);
        $thumbnail_lama = $data_wisata->thumbnail;

        $thumbnail = $this->input->post('compressed_gambar');

        if (!empty($thumbnail)) {
            $thumbnail = str_replace('data:image/jpeg;base64,', '', $thumbnail);
            $thumbnail = str_replace('data:image/jpg;base64,', '', $thumbnail);
            $thumbnail = str_replace('data:image/png;base64,', '', $thumbnail);
            $thumbnail = str_replace(' ', '+', $thumbnail);

            $thumbnail_binary = base64_decode($thumbnail);

            $thumbnail_name = uniqid() . '.jpg';

            file_put_contents(FCPATH . 'uploads/wisata/' . $thumbnail_name, $thumbnail_binary);
        } else {
            $thumbnail_name = $thumbnail_lama;
        }

        $data = [
            'id_kategori'       => $this->input->post('id_kategori'),
            'nama'              => $this->input->post('nama'),
            'deskripsi'         => $this->input->post('deskripsi'),
            'thumbnail'         => $thumbnail_name,
            'harga_weekday' => $this->input->post('harga_weekday'),
            'harga_weekend' => $this->input->post('harga_weekend'),
            'harga_high_season' => $this->input->post('harga_high_season'),
            'status'            => $this->input->post('status'),
        ];

        $this->MAdmin->update('data_wisata', $data, $id);

        $images = $this->input->post('compressed_gambars');
        $images = json_decode($images, true);

        $ada_compressed_baru = (!empty($images) && is_array($images));
        $ada_file_baru       = (!empty($_FILES['gambar']['name'][0]));

        if ($ada_compressed_baru || $ada_file_baru) {

            $lastOrder = $this->db->select_max('urutan')
                ->where('id_referensi', $id)
                ->get('data_gambar')
                ->row()->urutan;

            $lastOrder = $lastOrder ?? 0;

            foreach ($images as $index => $item) {
                $item = preg_replace('/^data:image\/\w+;base64,/', '', $item);
                $item = str_replace(' ', '+', $item);

                $item_binary = base64_decode($item);
                $item_name = uniqid() . '.jpg';

                file_put_contents(FCPATH . 'uploads/wisata/' . $item_name, $item_binary);

                $order = $lastOrder + $index + 1;

                $data_gambar_detail = [
                    'id_referensi' => $id,
                    'gambar'       => $item_name,
                    'tipe'         => 'wisata',
                    'urutan'       => $order
                ];

                $this->db->insert('data_gambar', $data_gambar_detail);
            }
        }


        redirect('admin/data-wisata');
    }

    public function delete($id)
    {
        // hapus thumbnail
        $thumbnail_lama = $this->MAdmin->get_by_id('data_wisata', $id);
        $file_path = './uploads/wisata/' . $thumbnail_lama->thumbnail;
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // hapus detail gambar
        $gambar_lama = $this->db->get_where('data_gambar', [
            'id_referensi' => $id,
            'tipe'         => 'wisata'
        ])->result();

        foreach ($gambar_lama as $old) {
            $file_path = './uploads/wisata/' . $old->gambar;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        $this->MAdmin->delete_data_gambar($id);
        $this->MAdmin->delete('data_wisata', $id);
        redirect('admin/data-wisata');
    }

    public function hapus_gambar()
    {
        $id = $this->input->post('id');

        $gambar = $this->db->get_where('data_gambar', ['id' => $id])->row();
        if (!$gambar) {
            $this->session->set_flashdata('error', 'Ada yang salah nih sama foto yang kamu hapus');
            redirect('admin/data-wisata/edit');
        }

        $file_path = './uploads/wisata/' . $gambar->gambar;
        if (file_exists($file_path)) unlink($file_path);

        // Hapus dari DB
        $this->db->delete('data_gambar', ['id' => $id]);

        echo json_encode(['status' => 'success']);
    }

    public function update_order_data()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        foreach ($data as $item) {
            $this->db->where('id', $item['id']);
            $this->db->update('data_wisata', ['urutan' => $item['urutan']]);
        }
    }

    public function update_order_gambar()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['order'])) {
            foreach ($data['order'] as $index => $id_gambar) {
                $this->db->where('id', $id_gambar)->update('data_gambar', ['urutan' => $index]);
            }
        }
    }
}
