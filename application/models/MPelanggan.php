<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MPelanggan extends CI_Model
{
    public function get_all($table)
    {
        return $this->db->get($table)->result();
    }

    public function get_status_active($table)
    {
        return $this->db->where('status', 'aktif')->get($table)->result();
    }

    public function get_by_id($table, $id)
    {
        return $this->db->get_where($table, ['id' => $id])->row();
    }

    public function store($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function update($table, $data, $id)
    {
        $this->db->where('id', $id);
        return $this->db->update($table, $data);
    }

    public function delete($table, $id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($table);
    }

    public function count_all($table)
    {
        return $this->db->count_all($table);
    }

    public function get_data_kategori_aktif()
    {
        $this->db->where('data_kategori.status', 'aktif');
        return $this->db->get('data_kategori')->result();
    }


    public function get_penginapan_with_kategori($kapasitas = NULL)
    {
        $this->db->select(
            'data_penginapan.*, data_kategori.nama AS nama_kategori'
        );

        $this->db->from('data_penginapan');

        $this->db->join(
            'data_kategori',
            'data_kategori.id = data_penginapan.id_kategori'
        );

        $this->db->where('data_penginapan.status', 'aktif');

        if ($kapasitas !== NULL) {
            $this->db->where(
                'data_penginapan.kapasitas_max >=',
                $kapasitas
            );
        }

        $this->db->order_by('data_penginapan.urutan', 'ASC');

        return $this->db->get()->result();
    }


    public function get_wisata_with_kategori()
    {
        $this->db->select('data_wisata.*, data_kategori.nama as nama_kategori');
        $this->db->from('data_wisata');
        $this->db->join('data_kategori', 'data_kategori.id = data_wisata.id_kategori');
        $this->db->where('data_wisata.status', 'aktif');
        $this->db->order_by('data_wisata.urutan', 'ASC');
        return $this->db->get()->result();
    }

    public function get_transportasi_with_kategori()
    {
        $this->db->select('data_transportasi.*, 
        data_kategori.nama as nama_kategori
        ');
        $this->db->from('data_transportasi');
        $this->db->join('data_kategori', 'data_kategori.id = data_transportasi.id_kategori');
        $this->db->where('data_transportasi.status', 'aktif');
        $this->db->order_by('data_transportasi.urutan', 'ASC');
        return $this->db->get()->result();
    }

    public function get_penginapan_with_kategori_by_id($id)
    {
        $this->db->select('data_penginapan.*, data_kategori.nama as nama_kategori');
        $this->db->from('data_penginapan');
        $this->db->join('data_kategori', 'data_kategori.id = data_penginapan.id_kategori');
        $this->db->where('data_penginapan.id', $id);
        return $this->db->get()->row();
    }

    public function get_wisata_with_kategori_by_id($id)
    {
        $this->db->select('data_wisata.*, data_kategori.nama as nama_kategori');
        $this->db->from('data_wisata');
        $this->db->join('data_kategori', 'data_kategori.id = data_wisata.id_kategori');
        $this->db->where('data_wisata.id', $id);
        return $this->db->get()->row();
    }

    public function get_transportasi_with_kategori_by_id($id)
    {
        $this->db->select('data_transportasi.*, data_kategori.nama as nama_kategori');
        $this->db->from('data_transportasi');
        $this->db->join('data_kategori', 'data_kategori.id = data_transportasi.id_kategori');
        $this->db->where('data_transportasi.id', $id);
        return $this->db->get()->row();
    }

    public function get_gambar_with_penginapan($id)
    {
        $this->db->select('
        data_gambar.*, 
        ');
        $this->db->from('data_gambar');
        $this->db->join('data_penginapan', 'data_penginapan.id = data_gambar.id_referensi');
        $this->db->where('data_gambar.id_referensi', $id);
        $this->db->where('data_gambar.tipe', 'penginapan');
        $this->db->order_by('data_gambar.urutan', 'ASC');
        return $this->db->get()->result();
    }

    public function get_gambar_with_wisata($id)
    {
        $this->db->select('
        data_gambar.*, 
        ');
        $this->db->from('data_gambar');
        $this->db->join('data_wisata', 'data_wisata.id = data_gambar.id_referensi');
        $this->db->where('data_gambar.id_referensi', $id);
        $this->db->where('data_gambar.tipe', 'wisata');
        $this->db->order_by('data_gambar.urutan', 'ASC');
        return $this->db->get()->result();
    }

    public function get_gambar_with_transportasi($id)
    {
        $this->db->select('
        data_gambar.*, 
        ');
        $this->db->from('data_gambar');
        $this->db->join('data_transportasi', 'data_transportasi.id = data_gambar.id_referensi');
        $this->db->where('data_gambar.id_referensi', $id);
        $this->db->where('data_gambar.tipe', 'transportasi');
        return $this->db->get()->result();
    }


    public function get_fasilitas_by_penginapan($id_penginapan)
    {
        $this->db->select('data_fasilitas.*');
        $this->db->from('data_fasilitas');
        $this->db->join('fasilitas_penginapan ', 'fasilitas_penginapan.id_fasilitas = data_fasilitas.id');
        $this->db->where('fasilitas_penginapan.id_penginapan', $id_penginapan);
        return $this->db->get()->result();
    }

    public function get_penginapan_with_kategori_limit()
    {
        $this->db->select('data_penginapan.*, data_kategori.nama as nama_kategori');
        $this->db->from('data_penginapan');
        $this->db->join('data_kategori', 'data_kategori.id = data_penginapan.id_kategori');
        $this->db->limit(5);
        $this->db->where('data_penginapan.status', 'aktif');
        $this->db->order_by('data_penginapan.urutan', 'ASC');
        return $this->db->get()->result();
    }

    public function get_wisata_with_kategori_limit()
    {
        $this->db->select('data_wisata.*, data_kategori.nama as nama_kategori');
        $this->db->from('data_wisata');
        $this->db->join('data_kategori', 'data_kategori.id = data_wisata.id_kategori');
        $this->db->limit(5);
        $this->db->where('data_wisata.status', 'aktif');
        $this->db->order_by('data_wisata.urutan', 'ASC');
        return $this->db->get()->result();
    }

    public function get_item_pesanan_by_id($id)
    {
        $this->db->select('
        item_pesanan.*, 
        data_wisata.*  
        ');
        $this->db->from('item_pesanan');
        $this->db->join('data_wisata', 'data_wisata.id = item_pesanan.id_wisata');
        $this->db->where('item_pesanan.id', $id);
        return $this->db->get()->row();
    }

    public function get_pesanan_by_id_pelanggan($id)
    {
        $this->db->select('
        item_pesanan.*, 
        data_wisata.*,  
        pesanan.*
        ');
        $this->db->from('item_pesanan');
        $this->db->join('data_wisata', 'data_wisata.id = item_pesanan.id_wisata');
        $this->db->join('pesanan', 'pesanan.id = item_pesanan.id_pesanan');
        $this->db->where('pesanan.id_pelanggan', $id);
        return $this->db->get()->result();
    }

    public function get_item_pesanan_with_pesanan_by_id($id)
    {
        $this->db->select('
        item_pesanan.*, 
        pesanan.*, 
        pesanan.created_at as tanggal_pesanan, 
        data_wisata.*,  
        data_wisata.nama as nama_wisata,  
        ');
        $this->db->from('item_pesanan');
        $this->db->join('pesanan', 'pesanan.id = item_pesanan.id_pesanan');
        $this->db->join('data_wisata', 'data_wisata.id = item_pesanan.id_wisata');
        $this->db->where('item_pesanan.id', $id);
        return $this->db->get()->row();
    }
}
