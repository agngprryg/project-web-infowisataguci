<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MKasir extends CI_Model
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
}
