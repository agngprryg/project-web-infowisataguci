<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MOwner extends CI_Model
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

    public function get_produk_with_kategori()
    {
        $this->db->select('data_produk.*, data_kategori.nama as nama_kategori');
        $this->db->from('data_produk');
        $this->db->join('data_kategori', 'data_kategori.id = data_produk.id_data_kategori');
        return $this->db->get()->result();
    }

    public function get_pivot_kategori_bahan()
    {
        $this->db->select('
        kategori_bahan.*, 
        data_kategori.nama as nama_kategori, 
        data_bahan.nama as nama_bahan
        ');
        $this->db->from('kategori_bahan');
        $this->db->join('data_kategori', 'data_kategori.id = kategori_bahan.id_data_kategori');
        $this->db->join('data_bahan', 'data_bahan.id = kategori_bahan.id_data_bahan');
        return $this->db->get()->result();
    }

    public function get_pivot_produk_harga()
    {
        $this->db->select('
         produk_harga.*, 
         data_produk.nama as nama_produk,
         data_bahan.nama as nama_bahan,
         data_satuan.nama as nama_satuan,
         data_jenis.nama as nama_jenis,
         ');
        $this->db->from('produk_harga');
        $this->db->join('data_produk', 'data_produk.id = produk_harga.id_data_produk');
        $this->db->join('data_bahan', 'data_bahan.id = produk_harga.id_data_bahan');
        $this->db->join('data_satuan', 'data_satuan.id = produk_harga.id_data_satuan');
        $this->db->join('data_jenis', 'data_jenis.id = produk_harga.id_data_jenis');
        return $this->db->get()->result();
    }

    public function get_item_pesanan_with_pesanan()
    {
        $this->db->select('
         item_pesanan.*, 
         pesanan.id as id_pesanan,
         pesanan.no_invoice as nomor_invoice,
         pesanan.nama_pelanggan as nama_pelanggan,
         pesanan.status as status_pesanan,
         pesanan.total_harga as total_harga,
         data_produk.nama as nama_produk,
         data_bahan.nama as nama_bahan,
         data_satuan.nama as nama_satuan,
         data_jenis.nama as nama_jenis,
         ');
        $this->db->from('item_pesanan');
        $this->db->join('pesanan', 'pesanan.id = item_pesanan.id_pesanan');
        $this->db->join('data_produk', 'data_produk.id = item_pesanan.id_data_produk');
        $this->db->join('data_bahan', 'data_bahan.id = item_pesanan.id_data_bahan');
        $this->db->join('data_satuan', 'data_satuan.id = item_pesanan.id_data_satuan');
        $this->db->join('data_jenis', 'data_jenis.id = item_pesanan.id_data_jenis');
        return $this->db->get()->result();
    }

    public function get_pesanan_terbaru()
    {
        $this->db->select('
         item_pesanan.*, 
         pesanan.id as id_pesanan,
         pesanan.no_invoice as nomor_invoice,
         pesanan.nama_pelanggan as nama_pelanggan,
         pesanan.status as status_pesanan,
         data_produk.nama as nama_produk,
         data_bahan.nama as nama_bahan,
         data_satuan.nama as nama_satuan,
         data_jenis.nama as nama_jenis,
         ');
        $this->db->from('item_pesanan');
        $this->db->join('pesanan', 'pesanan.id = item_pesanan.id_pesanan');
        $this->db->join('data_produk', 'data_produk.id = item_pesanan.id_data_produk');
        $this->db->join('data_bahan', 'data_bahan.id = item_pesanan.id_data_bahan');
        $this->db->join('data_satuan', 'data_satuan.id = item_pesanan.id_data_satuan');
        $this->db->join('data_jenis', 'data_jenis.id = item_pesanan.id_data_jenis');
        $this->db->order_by('pesanan.created_at', 'DESC'); // urutkan dari yang terbaru
        $this->db->limit(3);
        return $this->db->get()->result();
    }

    public function get_pesanan_per_bulan()
    {
        $this->db->select('MONTH(created_at) as bulan, COUNT(*) as total');
        $this->db->from('pesanan');
        $this->db->where('YEAR(created_at)', date('Y'));
        $this->db->group_by('MONTH(created_at)');
        $this->db->order_by('MONTH(created_at)', 'ASC');
        return $this->db->get()->result();
    }
}
