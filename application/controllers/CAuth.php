<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CAuth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|trim|valid_email',
            [
                'required' => 'Email wajib diisi.',
                'valid_email' => 'Format email tidak valid.'
            ]
        );

        $this->form_validation->set_rules(
            'password',
            'Password',
            'required|trim|min_length[6]',
            [
                'required' => 'Password wajib diisi.',
                'min_length' => 'Password harus memiliki minimal 6 karakter.'
            ]
        );

        if ($this->form_validation->run() == false) {
            $this->load->view('components/header');
            $this->load->view('pages/auth/login');
            $this->load->view('components/footer');
        } else {
            $this->_login();
        }
    }

    public function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $user = $this->db->get_where('pengguna', ['email' => $email])->row_array();

        if ($user) {
            $pelanggan = $this->db->get_where('data_pelanggan', ['id_pengguna' => $user['id']])->row_array();

            if (password_verify($password, $user['password'])) {
                $data = [
                    'id_user'           => $user['id'],
                    'id_pelanggan'      => $pelanggan ? $pelanggan['id'] : null,
                    'nama_pelanggan'    => $pelanggan ? $pelanggan['nama'] : null,
                    'email'             => $user['email'],
                    'nama'              => $user['nama'],
                    'role'              => $user['role'],
                ];
                $this->session->set_userdata($data);
                if ($user['role'] == "admin") {
                    redirect('admin/data-wisata');
                }
            } else {
                $this->session->set_flashdata('message', '<p class="text-sm text-red-500">
					password salah
		 			 </p>');
                redirect('CAuth');
            }
        } else {
            $this->session->set_flashdata('message', '<p class="text-sm text-red-500">
			email tidak terdaftar
		 	 </p>');
            redirect('CAuth');
        }
    }

    public function register()
    {
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('no_hp', 'No HP', 'required|numeric|min_length[5]|max_length[15]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[pengguna.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('components/header');
            $this->load->view('pages/auth/register');
            $this->load->view('components/footer');
        } else {
            $data_pengguna = [
                'email'        => $this->input->post('email'),
                'password'     => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'role'   => 'pelanggan',
            ];
            $this->db->insert('pengguna', $data_pengguna);
            $id_pengguna = $this->db->insert_id();

            $data_pelanggan = [
                'id_pengguna'        => $id_pengguna,
                'nama'               => $this->input->post('nama'),
                'no_hp'              => $this->input->post('no_hp'),
                'status'             => 'aktif'
            ];
            $this->db->insert('data_pelanggan', $data_pelanggan);
            $this->session->set_flashdata('message', '<p class="text-sm text-black">akun berhasil dibuat</p>');
            redirect('login');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('id_pelanggan');
        $this->session->unset_userdata('nama_pelanggan');
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role');

        $this->session->set_flashdata('message', '<p class="text-sm text-red-500">yeyy Kamu berhasil logout</p>');
        redirect('login');
    }
}
