<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CDataFasilitas extends CI_Controller
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
        $data['data_fasilitas']  = $this->MAdmin->get_all('data_fasilitas');
        $this->load->view('components/header.php');
        $this->load->view('components/sidebar_admin.php');
        $this->load->view('pages/admin/data-fasilitas/index.php', $data);
        $this->load->view('components/footer.php');
    }

    public function create()
    {
        $this->load->view('components/header.php');
        $this->load->view('components/sidebar_admin.php');
        $this->load->view('pages/admin/data-fasilitas/create.php');
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
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('store_form', $error);
            return;
        } else {
            $uploadData = $this->upload->data();
            $icon = $uploadData['file_name'];
        }

        $data = [
            'nama'          => $this->input->post('nama'),
            'icon'          => $icon,
            'status'        => $this->input->post('status'),
        ];
        $this->MAdmin->store('data_fasilitas', $data);
        redirect('admin/data-fasilitas');
    }

    public function edit($id)
    {
        $data['data_fasilitas'] = $this->MAdmin->get_by_id('data_fasilitas', $id);
        $this->load->view('components/header.php');
        $this->load->view('components/sidebar_admin.php');
        $this->load->view('pages/admin/data-fasilitas/edit.php', $data);
        $this->load->view('components/footer.php');
    }

    public function update($id)
    {

        $data_fasilitas = $this->MAdmin->get_by_id('data_fasilitas', $id);
        $icon_lama = $data_fasilitas->icon;

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
            'icon'          => $icon_baru,
            'status'        => $this->input->post('status'),
        ];
        $this->MAdmin->update('data_fasilitas', $data, $id);
        redirect('admin/data-fasilitas');
    }

    public function delete($id)
    {
        $this->MAdmin->delete('data_fasilitas', $id);
        redirect('admin/data-fasilitas');
    }
}
