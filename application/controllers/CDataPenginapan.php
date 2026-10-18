<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CDataPenginapan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MAdmin');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->load->library('form_validation');

        if (!$this->session->userdata('role') == 'admin') {
            $this->session->set_flashdata('message', 'Kamu Tidak Punya Akses Kesini');
            redirect('CAuth');
        }
    }

    public function index()
    {
        $data['data_penginapan']  = $this->MAdmin->get_penginapan_with_kategori();

        // header('Content-Type: application/json');
        // echo json_encode($data);

        $this->load->view('components/header.php');
        $this->load->view('components/sidebar_admin.php');
        $this->load->view('pages/admin/data-penginapan/index.php', $data);
        $this->load->view('components/footer.php');
    }

    public function create()
    {
        $data['data_kategori'] = $this->MAdmin->get_all('data_kategori');
        $data['data_fasilitas'] = $this->MAdmin->get_all('data_fasilitas');

        $this->load->view('components/header.php');
        $this->load->view('components/sidebar_admin.php');
        $this->load->view('pages/admin/data-penginapan/create.php', $data);
        $this->load->view('components/footer.php');
    }

    public function store()
    {
        $rules = [
            [
                'field' => 'id_kategori',
                'label' => 'ID Kategori',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kategori harus diisi.'
                ]
            ],
            [
                'field' => 'nama',
                'label' => 'Nama',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Penginapan harus diisi.'
                ]
            ],
            [
                'field' => 'deskripsi',
                'label' => 'Deskripsi',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi harus diisi.'
                ]
            ],
            [
                'field' => 'kapasitas',
                'label' => 'Kapasitas',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kapasitas harus diisi.'
                ]
            ],
            [
                'field' => 'status',
                'label' => 'Status',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status harus diisi.'
                ]
            ]
        ];

        $this->load->helper('tarif');
        $this->form_validation->set_rules(array_merge($rules, tarif_validation_rules()));

        $data['data_kategori'] = $this->MAdmin->get_all('data_kategori');
        $data['data_fasilitas'] = $this->MAdmin->get_all('data_fasilitas');

        if ($this->form_validation->run() == false) {
            $this->load->view('components/header.php');
            $this->load->view('components/sidebar_admin.php');
            $this->load->view('pages/admin/data-penginapan/create.php', $data);
            $this->load->view('components/footer.php');
        } else {
            $thumbnail = $this->input->post('compressed_gambar');

            if (!empty($thumbnail)) {
                $thumbnail = str_replace('data:image/jpeg;base64,', '', $thumbnail);
                $thumbnail = str_replace('data:image/jpg;base64,', '', $thumbnail);
                $thumbnail = str_replace('data:image/png;base64,', '', $thumbnail);
                $thumbnail = str_replace(' ', '+', $thumbnail);

                $thumbnail_binary = base64_decode($thumbnail);

                $thumbnail_name = uniqid() . '.jpg';

                file_put_contents(FCPATH . 'uploads/penginapan/' . $thumbnail_name, $thumbnail_binary);
            } else {
                $this->session->set_flashdata('error', 'Thumbnail tidak valid atau tidak boleh kosong!');
                redirect('admin/data-penginapan/create');
            }

            $lastOrder = $this->db->select_max('urutan')
                ->get('data_penginapan')
                ->row()->urutan;

            $lastOrder = $lastOrder ?? 0;

            $data = [
                'id_kategori'       => $this->input->post('id_kategori'),
                'nama'              => $this->input->post('nama'),
                'deskripsi'         => $this->input->post('deskripsi'),
                'thumbnail'         => $thumbnail_name,
                'kapasitas'         => $this->input->post('kapasitas'),
                'harga_weekday'     => $this->input->post('harga_weekday'),
                'harga_weekend'     => $this->input->post('harga_weekend'),
                'harga_high_season' => $this->input->post('harga_high_season'),
                'urutan'            => $lastOrder + 1,
                'status'            => $this->input->post('status'),
            ];

            $id_penginapan = $this->MAdmin->store('data_penginapan', $data);

            $images = $this->input->post('compressed_gambars');
            $images = json_decode($images, true);

            if (!is_array($images) || empty($images)) {
                $this->session->set_flashdata('error', 'Detail Gambar Tidak Boleh Kosong!');
                redirect('admin/data-penginapan/create');
            } else {
                foreach ($images as $index => $item) {
                    $item = preg_replace('/^data:image\/\w+;base64,/', '', $item);
                    $item = str_replace(' ', '+', $item);

                    $item_binary = base64_decode($item);
                    $item_name = uniqid() . '.jpg';

                    file_put_contents(FCPATH . 'uploads/penginapan/' . $item_name, $item_binary);

                    $data_gambar_detail = [
                        'id_referensi' => $id_penginapan,
                        'gambar'       => $item_name,
                        'tipe'         => 'penginapan',
                        'urutan'       => $index + 1
                    ];

                    $this->db->insert('data_gambar', $data_gambar_detail);
                }
            }

            redirect('admin/data-penginapan');
        }
    }

    public function edit($id)
    {
        $data['data_penginapan'] = $this->MAdmin->get_by_id('data_penginapan', $id);
        $data['data_kategori'] = $this->MAdmin->get_all('data_kategori');
        $data['data_gambar'] = $this->MAdmin->get_gambar_with_penginapan($id);

        // header('Content-Type: application/json');
        // echo json_encode($data);

        $this->load->view('components/header.php');
        $this->load->view('components/sidebar_admin.php');
        $this->load->view('pages/admin/data-penginapan/edit.php', $data);
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
        $data_penginapan = $this->MAdmin->get_by_id('data_penginapan', $id);
        $thumbnail_lama = $data_penginapan->thumbnail;

        $thumbnail = $this->input->post('compressed_gambar');

        if (!empty($thumbnail)) {
            $thumbnail = str_replace('data:image/jpeg;base64,', '', $thumbnail);
            $thumbnail = str_replace('data:image/jpg;base64,', '', $thumbnail);
            $thumbnail = str_replace('data:image/png;base64,', '', $thumbnail);
            $thumbnail = str_replace(' ', '+', $thumbnail);

            $thumbnail_binary = base64_decode($thumbnail);

            $thumbnail_name = uniqid() . '.jpg';

            file_put_contents(FCPATH . 'uploads/penginapan/' . $thumbnail_name, $thumbnail_binary);
        } else {
            $thumbnail_name = $thumbnail_lama;
        }

        $data = [
            'id_kategori'       => $this->input->post('id_kategori'),
            'nama'              => $this->input->post('nama'),
            'deskripsi'         => $this->input->post('deskripsi'),
            'thumbnail'         => $thumbnail_name,
            'kapasitas'         => $this->input->post('kapasitas'),
            'harga_weekday' => $this->input->post('harga_weekday'),
            'harga_weekend' => $this->input->post('harga_weekend'),
            'harga_high_season' => $this->input->post('harga_high_season'),
            'status'            => $this->input->post('status'),
        ];

        $this->MAdmin->update('data_penginapan', $data, $id);

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

                file_put_contents(FCPATH . 'uploads/penginapan/' . $item_name, $item_binary);

                $order = $lastOrder + $index + 1;

                $data_gambar_detail = [
                    'id_referensi' => $id,
                    'gambar'       => $item_name,
                    'tipe'         => 'penginapan',
                    'urutan'       => $order
                ];

                $this->db->insert('data_gambar', $data_gambar_detail);
            }
        }
        redirect('admin/data-penginapan');
    }

    public function delete($id)
    {
        // hapus thumbnail
        $thumbnail_lama = $this->MAdmin->get_by_id('data_penginapan', $id);
        $file_path = './uploads/penginapan/' . $thumbnail_lama->thumbnail;
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // hapus detail gambar
        $gambar_lama = $this->db->get_where('data_gambar', [
            'id_referensi' => $id,
            'tipe'         => 'penginapan'
        ])->result();

        foreach ($gambar_lama as $old) {
            $file_path = './uploads/penginapan/' . $old->gambar;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        $this->MAdmin->delete_data_gambar($id);
        $this->MAdmin->delete('data_penginapan', $id);
        redirect('admin/data-penginapan');
    }

    public function hapus_gambar()
    {
        $id = $this->input->post('id');

        $gambar = $this->db->get_where('data_gambar', ['id' => $id])->row();
        if (!$gambar) {
            $this->session->set_flashdata('error', 'Ada yang salah nih sama foto yang kamu hapus');
            redirect('admin/data-penginapan/edit');
        }

        $file_path = './uploads/penginapan/' . $gambar->gambar;
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
            $this->db->update('data_penginapan', ['urutan' => $item['urutan']]);
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
