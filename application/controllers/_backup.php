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
        // === Validasi Form ===
        $rules = [
            ['field' => 'id_kategori', 'label' => 'Kategori',  'rules' => 'required'],
            ['field' => 'nama',        'label' => 'Nama',      'rules' => 'required'],
            ['field' => 'deskripsi',   'label' => 'Deskripsi', 'rules' => 'required'],
            ['field' => 'harga',       'label' => 'Harga',     'rules' => 'required|numeric'],
            ['field' => 'status',      'label' => 'Status',    'rules' => 'required'],
        ];
        $this->form_validation->set_rules($rules);

        $data['data_kategori'] = $this->MAdmin->get_all('data_kategori');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('components/header.php');
            $this->load->view('components/sidebar_admin.php');
            $this->load->view('pages/admin/data-wisata/create.php', $data);
            $this->load->view('components/footer.php');
            return;
        }

        // === Konfigurasi Upload Aman ===
        $config = [
            'upload_path'   => './uploads/wisata',
            'allowed_types' => 'jpg|jpeg|png|gif',
            'max_size'      => 2048,
            'encrypt_name'  => TRUE,
        ];
        $this->upload->initialize($config);

        // === Upload Thumbnail Aman ===
        $thumbnail = null; // default jika tidak ada
        if (!empty($_FILES['thumbnail']['name'])) {
            if ($this->upload->do_upload('thumbnail')) {
                $uploadData = $this->upload->data();

                // validasi jenis file tambahan
                if (@getimagesize($uploadData['full_path']) !== FALSE) {
                    $thumbnail = $uploadData['file_name'];
                } else {
                    unlink($uploadData['full_path']); // hapus file tidak valid
                    $thumbnail = null;
                }
            }
        }

        // kalau thumbnail wajib diisi
        if ($thumbnail == null) {
            $this->session->set_flashdata('error', 'Thumbnail tidak valid atau tidak boleh kosong!');
            redirect('admin/data-wisata/create');
        }

        // === Simpan Data Wisata + XSS Clean ===
        $wisataData = [
            'id_kategori' => $this->security->xss_clean($this->input->post('id_kategori')),
            'nama'        => $this->security->xss_clean($this->input->post('nama')),
            'deskripsi'   => $this->security->xss_clean($this->input->post('deskripsi')),
            'thumbnail'   => $thumbnail,
            'harga'       => $this->input->post('harga'),
            'status'      => $this->input->post('status'),
        ];

        $id_wisata = $this->MAdmin->store('data_wisata', $wisataData);

        // === Upload dan Simpan Gambar Detail ===
        if (!empty($_FILES['gambar']['name'][0])) {
            $filesCount = count($_FILES['gambar']['name']);

            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['file']['name']     = $_FILES['gambar']['name'][$i];
                $_FILES['file']['type']     = $_FILES['gambar']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['gambar']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['gambar']['error'][$i];
                $_FILES['file']['size']     = $_FILES['gambar']['size'][$i];

                $this->upload->initialize($config);

                if ($this->upload->do_upload('file')) {
                    $fileData = $this->upload->data();

                    $gambar_detail = [
                        'id_referensi' => $id_wisata,
                        'gambar'       => $fileData['file_name'],
                        'tipe'         => 'wisata'
                    ];

                    $this->db->insert('data_gambar', $gambar_detail);
                }
            }
        } else {
            // Tidak memilih file sama sekali
            $this->session->set_flashdata('error', 'Gambar detail tidak boleh kosong!');
            redirect('admin/data-wisata/create');
        }

        redirect('admin/data-wisata');
    }


    public function edit($id)
    {
        $data['data_wisata'] = $this->MAdmin->get_by_id('data_wisata', $id);
        $data['data_kategori'] = $this->MAdmin->get_all('data_kategori');
        $this->load->view('components/header.php');
        $this->load->view('components/sidebar_admin.php');
        $this->load->view('pages/admin/data-wisata/edit.php', $data);
        $this->load->view('components/footer.php');
    }

    public function update($id)
    {

        $data_wisata = $this->MAdmin->get_by_id('data_wisata', $id);
        $thumbnail_lama = $data_wisata->thumbnail;

        $config['upload_path']   = './uploads/wisata';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size']      = 2048;
        $config['encrypt_name']  = TRUE;

        $this->upload->initialize($config);

        // Cek apakah user mengupload thumbnail baru
        if (!empty($_FILES['thumbnail']['name'])) {
            if ($this->upload->do_upload('thumbnail')) {
                $uploadData = $this->upload->data();
                $thumbnail_baru = $uploadData['file_name'];

                // Hapus file lama (jika ada)
                if (!empty($thumbnail_lama) && file_exists('./uploads/wisata/' . $thumbnail_lama)) {
                    unlink('./uploads/wisata/' . $thumbnail_lama);
                }
            } else {
                // Jika gagal upload, tampilkan error
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('form_edit', $error);
                return;
            }
        } else {
            // Tidak upload thumbnail baru, gunakan thumbnail lama
            $thumbnail_baru = $thumbnail_lama;
        }

        $data = [
            'id_kategori'       => $this->input->post('id_kategori'),
            'nama'              => $this->input->post('nama'),
            'deskripsi'         => $this->input->post('deskripsi'),
            'thumbnail'         => $thumbnail_baru,
            'harga'             => $this->input->post('harga'),
            'status'            => $this->input->post('status'),
        ];

        $this->MAdmin->update('data_wisata', $data, $id);
        redirect('admin/data-wisata');
    }

    public function delete($id)
    {
        $this->MAdmin->delete('data_wisata', $id);
        redirect('admin/data-wisata');
    }

    // public function _store()
    // {
    //     // === VALIDASI FORM BIASA ===
    //     $rules = [
    //         [
    //             'field' => 'id_kategori',
    //             'label' => 'Kategori',
    //             'rules' => 'required'
    //         ],
    //         [
    //             'field' => 'nama',
    //             'label' => 'Nama',
    //             'rules' => 'required'
    //         ],
    //         [
    //             'field' => 'deskripsi',
    //             'label' => 'Deskripsi',
    //             'rules' => 'required'
    //         ],
    //         [
    //             'field' => 'kapasitas',
    //             'label' => 'Kapasitas',
    //             'rules' => 'required'
    //         ],
    //         [
    //             'field' => 'harga',
    //             'label' => 'Harga',
    //             'rules' => 'required'
    //         ],
    //         [
    //             'field' => 'status',
    //             'label' => 'Status',
    //             'rules' => 'required'
    //         ]
    //     ];

    //     $this->form_validation->set_rules($rules);

    //     if ($this->form_validation->run() == false) {
    //         return $this->_errorBack('ppp');
    //     }

    //     // ==============================
    //     // === VALIDASI + UPLOAD THUMBNAIL ===
    //     // ==============================

    //     if (empty($_FILES['thumbnail']['tmp_name'])) {
    //         return $this->_errorBack("Thumbnail tidak boleh kosong!");
    //     }

    //     $thumbName = 'thumb_' . time() . '.jpg';
    //     $thumbPath = './uploads/penginapan/' . $thumbName;

    //     if (!move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbPath)) {
    //         return $this->_errorBack("Gagal upload thumbnail!");
    //     }

    //     // ==============================
    //     // === SIMPAN DATA PENGINAPAN ===
    //     // ==============================

    //     $data = [
    //         'id_kategori'   => $this->input->post('id_kategori'),
    //         'nama'          => $this->input->post('nama'),
    //         'deskripsi'     => $this->input->post('deskripsi'),
    //         'thumbnail'     => $thumbName,
    //         'kapasitas'     => $this->input->post('kapasitas'),
    //         'harga'         => $this->input->post('harga'),
    //         'status'        => $this->input->post('status'),
    //     ];
    //     $id_penginapan = $this->MAdmin->store('data_penginapan', $data);

    //     // ==============================
    //     // === UPLOAD GAMBAR DETAIL ===
    //     // ==============================

    //     if (empty($_FILES['gambar']['name'][0])) {
    //         return $this->_errorBack("Gambar detail tidak boleh kosong!");
    //     }

    //     $filesCount = count($_FILES['gambar']['name']);
    //     for ($i = 0; $i < $filesCount; $i++) {

    //         $fileTmp  = $_FILES['gambar']['tmp_name'][$i];
    //         $fileName = 'img_' . time() . '_' . $i . '.jpg';
    //         $targetPath = './uploads/penginapan/' . $fileName;

    //         if (move_uploaded_file($fileTmp, $targetPath)) {
    //             $gambar_detail = [
    //                 'id_referensi' => $id_penginapan,
    //                 'gambar'       => $fileName,
    //                 'tipe'         => 'penginapan',
    //                 'urutan'       => $i
    //             ];
    //             $this->db->insert('data_gambar', $gambar_detail);
    //         }
    //     }

    //     redirect('admin/data-penginapan');
    // }


    // async function compressImage(file, maxWidth = 1024, quality = 0.7) {
    //     return new Promise((resolve) => {
    //         const reader = new FileReader();
    //         reader.readAsDataURL(file);
    //         reader.onload = event => {
    //             const img = new Image();
    //             img.src = event.target.result;
    //             img.onload = () => {
    //                 const elem = document.createElement('canvas');
    //                 const scaleFactor = maxWidth / img.width;
    //                 elem.width = maxWidth;
    //                 elem.height = img.height * scaleFactor;

    //                 const ctx = elem.getContext('2d');
    //                 ctx.drawImage(img, 0, 0, elem.width, elem.height);

    //                 elem.toBlob((blob) => {
    //                     resolve(blob);
    //                 }, 'image/jpeg', quality);
    //             }
    //         }
    //     });
    // }

    // document.getElementById('submitBtn').addEventListener('click', async function(e) {
    //     e.preventDefault();

    //     let formData = new FormData();

    //     const thumb = document.getElementById('thumbnail').files[0];
    //     if (thumb) {
    //         const compressedThumb = await compressImage(thumb);
    //         formData.append("thumbnail", compressedThumb, "thumbnail.jpg");
    //     }

    //     const gambarFiles = document.getElementById('gambar').files;
    //     for (let i = 0; i < gambarFiles.length; i++) {
    //         const compressedDetail = await compressImage(gambarFiles[i]);
    //         formData.append("gambar[]", compressedDetail, "detail_" + i + ".jpg");
    //     }
    // });


    //     private function _errorBack($msg)
    // {
    //     $this->session->set_flashdata('error', $msg);
    //     redirect('admin/data-penginapan/create');
    // }

    // private function _backToForm()
    // {
    //     $data['data_kategori'] = $this->MAdmin->get_all('data_kategori');
    //     $data['data_fasilitas'] = $this->MAdmin->get_all('data_fasilitas');

    //     $this->load->view('components/header.php');
    //     $this->load->view('components/sidebar_admin.php');
    //     $this->load->view('pages/admin/data-penginapan/create.php', $data);
    //     $this->load->view('components/footer.php');
    // }
}
