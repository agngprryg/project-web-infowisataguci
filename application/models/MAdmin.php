<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MAdmin extends CI_Model
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

    public function delete_data_gambar($id)
    {
        $this->db->where('id_referensi', $id);
        return $this->db->delete('data_gambar');
    }

    public function count_all($table)
    {
        return $this->db->count_all($table);
    }

    public function get_wisata_with_kategori()
    {
        $this->db->select('data_wisata.*, 
        data_kategori.nama as nama_kategori
        ');
        $this->db->from('data_wisata');
        $this->db->join('data_kategori', 'data_kategori.id = data_wisata.id_kategori');
        $this->db->order_by('data_wisata.urutan', 'ASC');
        return $this->db->get()->result();
    }

    public function get_penginapan_with_kategori()
    {
        $this->db->select('data_penginapan.*, 
        data_kategori.nama as nama_kategori
        ');
        $this->db->from('data_penginapan');
        $this->db->join('data_kategori', 'data_kategori.id = data_penginapan.id_kategori');
        $this->db->order_by('data_penginapan.urutan', 'ASC');
        return $this->db->get()->result();
    }

    public function get_transportasi_with_kategori()
    {
        $this->db->select('data_transportasi.*, 
        data_kategori.nama as nama_kategori
        ');
        $this->db->from('data_transportasi');
        $this->db->join('data_kategori', 'data_kategori.id = data_transportasi.id_kategori');
        $this->db->order_by('data_transportasi.urutan', 'ASC');
        return $this->db->get()->result();
    }

    public function get_pesanan_terbaru()
    {
        $this->db->select('
        item_pesanan.*, 
        pesanan.*,
        pesanan.status as status_pesanan,
        data_wisata.*
        ');
        $this->db->from('item_pesanan');
        $this->db->join('pesanan', 'pesanan.id = item_pesanan.id_pesanan');
        $this->db->join('data_wisata', 'data_wisata.id = item_pesanan.id_wisata');
        $this->db->limit(3);
        return $this->db->get()->result();
    }

    public function get_pesanan_per_bulan()
    {
        $this->db->select('MONTH(pesanan.created_at) as bulan, COUNT(*) as total');
        $this->db->from('pesanan');
        $this->db->where('YEAR(pesanan.created_at)', date('Y'));
        $this->db->group_by('MONTH(pesanan.created_at)');
        $this->db->order_by('MONTH(pesanan.created_at)', 'ASC');
        return $this->db->get()->result();
    }

    public function get_fasilitas_penginapan($id_penginapan)
    {
        $this->db->select('id_fasilitas');
        $this->db->from('fasilitas_penginapan');
        $this->db->where('id_penginapan', $id_penginapan);
        $result = $this->db->get()->result();
        return array_column($result, 'id_fasilitas');
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
        $this->db->order_by('data_gambar.urutan', 'ASC');
        return $this->db->get()->result();
    }

    public function insert_pivot_fasilitas_penginapan($id_penginapan, $id_fasilitas)
    {
        $this->db->insert(
            'fasilitas_penginapan',
            [
                'id_penginapan' => $id_penginapan,
                'id_fasilitas' => $id_fasilitas
            ]
        );
    }

    public function update_pivot_fasilitas_penginapan($id_penginapan, $fasilitas)
    {
        $this->db->where('id_penginapan', $id_penginapan);
        $this->db->delete('fasilitas_penginapan');

        if (is_array($fasilitas) && !empty($fasilitas)) {
            $data = [];
            foreach ($fasilitas as $fasilitas_row) {
                $data[] = [
                    'id_penginapan' => $id_penginapan,
                    'id_fasilitas' => $fasilitas_row
                ];
            }
            $this->db->insert_batch('fasilitas_penginapan', $data);
        }
    }

    public function get_pivot_fasilitas_penginapan()
    {
        $this->db->select('
        data_penginapan.*, 
        data_kategori.nama AS nama_kategori,
        GROUP_CONCAT(data_fasilitas.nama SEPARATOR ", ") AS fasilitas
        ');
        $this->db->from('data_penginapan');
        $this->db->join('data_kategori', 'data_kategori.id = data_penginapan.id_kategori', 'left');
        $this->db->join('fasilitas_penginapan', 'fasilitas_penginapan.id_penginapan = data_penginapan.id', 'left');
        $this->db->join('data_fasilitas', 'data_fasilitas.id = fasilitas_penginapan.id_fasilitas', 'left');
        $this->db->group_by('data_penginapan.id');
        return $this->db->get()->result();
    }

    public function get_penginapan_with_gambar($id_penginapan)
    {
        $penginapan = $this->db->get_where('data_penginapan', ['id' => $id_penginapan])->row();

        $gambar = $this->db->get_where('data_gambar', [
            'tipe'          => 'penginapan',
            'id_referensi'  => $id_penginapan
        ])->result();

        $penginapan->gambar = $gambar;
        return $penginapan;
    }

    public function get_item_pesanan_with_pesanan_by_id($id)
    {
        $this->db->select('
        item_pesanan.*, 
        pesanan.*
        ');
        $this->db->from('item_pesanan');
        $this->db->join('pesanan', 'pesanan.id = item_pesanan.id_pesanan');
        $this->db->where('item_pesanan.id_pesanan', $id);
        return $this->db->get()->row();
    }

    public function get_item_pesanan_with_wisata_by_id($id)
    {
        $this->db->select('
        item_pesanan.*, 
        data_wisata.*
        ');
        $this->db->from('item_pesanan');
        $this->db->join('data_wisata', 'data_wisata.id = item_pesanan.id_wisata');
        $this->db->where('item_pesanan.id_pesanan', $id);
        return $this->db->get()->row();
    }

    public function get_pesanan_filter($bulan = null, $year = null)
    {
        $this->db->select('
        item_pesanan.*, 
        pesanan.*,
        pesanan.created_at as tanggal_pesanan,
        data_wisata.*
        ');
        $this->db->from('item_pesanan');
        $this->db->join('pesanan', 'pesanan.id = item_pesanan.id_pesanan');
        $this->db->join('data_wisata', 'data_wisata.id = item_pesanan.id_wisata');

        if ($bulan) {
            $this->db->where('MONTH(pesanan.created_at)', $bulan);
        }

        if ($year) {
            $this->db->where('YEAR(pesanan.created_at)', $year);
        }

        $this->db->order_by('MONTH(pesanan.created_at)', 'ASC');
        return $this->db->get()->result();
    }

    public function get_wisata_filter($bulan = null, $year = null)
    {
        $this->db->select('
        data_wisata.*,
        data_wisata.nama as nama_wisata,
        data_kategori.*,
        data_kategori.nama as nama_kategori,
        ');
        $this->db->from('data_wisata');
        $this->db->join('data_kategori', 'data_kategori.id = data_wisata.id_kategori');

        if ($bulan) {
            $this->db->where('MONTH(pesanan.created_at)', $bulan);
        }

        if ($year) {
            $this->db->where('YEAR(pesanan.created_at)', $year);
        }

        return $this->db->get()->result();
    }

    public function get_pelanggan_filter($bulan = null, $year = null)
    {
        $this->db->select('
        data_pelanggan.*,
        ');
        $this->db->from('data_pelanggan');

        if ($bulan) {
            $this->db->where('MONTH(data_pelanggan.created_at)', $bulan);
        }

        if ($year) {
            $this->db->where('YEAR(data_pelanggan.created_at)', $year);
        }

        return $this->db->get()->result();
    }
}
