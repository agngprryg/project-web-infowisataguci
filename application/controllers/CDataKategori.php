<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CDataKategori extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MAdmin');
        $this->load->library('upload');

        if (!$this->session->userdata('role') == 'admin') {
            $this->session->set_flashdata('message', 'Kamu Tidak Punya Akses Kesini');
            redirect('CAuth');
        }
    }

    public function index()
    {
        $data['data_kategori']  = $this->MAdmin->get_all('data_kategori');
        $this->load->view('components/header.php');
        $this->load->view('components/sidebar_admin.php');
        $this->load->view('pages/admin/data-kategori/index.php', $data);
        $this->load->view('components/footer.php');
    }

    public function create()
    {
        $this->load->view('components/header.php');
        $this->load->view('components/sidebar_admin.php');
        $this->load->view('pages/admin/data-kategori/create.php');
        $this->load->view('components/footer.php');
    }

    public function store()
    {
        $config['upload_path']   = './uploads/icon';
        $config['allowed_types'] = 'webp|jpg|jpeg|png|gif';
        $config['max_size']      = 2048;
        $config['encrypt_name']  = TRUE;

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('icon')) {
            $this->session->set_flashdata('error', 'Icon tidak valid atau tidak boleh kosong!');
            redirect('admin/data-kategori/create');
        } else {
            $uploadData = $this->upload->data();
            $icon = $uploadData['file_name'];
        }

        $data = [
            'nama'          => $this->input->post('nama'),
            'slug'          => $this->input->post('slug'),
            'icon'          => $icon,
            'status'        => $this->input->post('status'),
        ];
        $this->MAdmin->store('data_kategori', $data);
        redirect('admin/data-kategori');
    }

    public function edit($id)
    {
        $data['data_kategori'] = $this->MAdmin->get_by_id('data_kategori', $id);
        $this->load->view('components/header.php');
        $this->load->view('components/sidebar_admin.php');
        $this->load->view('pages/admin/data-kategori/edit.php', $data);
        $this->load->view('components/footer.php');
    }

    public function update($id)
    {
        $data_kategori = $this->MAdmin->get_by_id('data_kategori', $id);
        $icon_lama = $data_kategori->icon;

        $config['upload_path']   = './uploads/icon';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size']      = 2048;
        $config['encrypt_name']  = TRUE;

        $this->upload->initialize($config);

        // Cek apakah user mengupload icon baru
        if (!empty($_FILES['icon']['name'])) {
            if ($this->upload->do_upload('icon')) {
                $uploadData = $this->upload->data();
                $icon_baru = $uploadData['file_name'];

                // Hapus file lama (jika ada)
                if (!empty($icon_lama) && file_exists('./uploads/icon/' . $icon_lama)) {
                    unlink('./uploads/icon/' . $icon_lama);
                }
            } else {
                // Jika gagal upload, tampilkan error
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('form_edit', $error);
                return;
            }
        } else {
            // Tidak upload icon baru, gunakan icon lama
            $icon_baru = $icon_lama;
        }

        $data = [
            'nama'          => $this->input->post('nama'),
            'slug'          => $this->input->post('slug'),
            'icon'          => $icon_baru,
            'status'        => $this->input->post('status'),
        ];
        $this->MAdmin->update('data_kategori', $data, $id);
        redirect('admin/data-kategori');
    }

    public function delete($id)
    {
        $data_kategori = $this->MAdmin->get_by_id('data_kategori', $id);
        $file_path = './uploads/icon/' . $data_kategori->icon;
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        $this->MAdmin->delete('data_kategori', $id);
        redirect('admin/data-kategori');
    }
}
