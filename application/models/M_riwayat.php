<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_riwayat extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function read($limit, $start, $key)
    {
        $this->db->select('riwayat_id, riwayat_name');
        $this->db->from('tbl_riwayat');
        $this->db->where("riwayat_id != 0 ");

        if ($key != '') {
            $this->db->like("riwayat_name", $key);
        }

        if ($limit != "" or $start != "") {
            $this->db->limit($limit, $start);
        }

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return null;
    }

    public function create($data)
    {
        $this->db->insert('tbl_riwayat', $data);
    }

    public function update($data)
    {
        $this->db->update('tbl_riwayat', $data, array('riwayat_id' => $data['riwayat_id']));
    }

    public function delete($id)
    {
        $this->db->delete('tbl_riwayat', array('riwayat_id' => $id));
    }

    public function get($id)
    {
        $this->db->where('riwayat_id', $id);
        $query = $this->db->get('tbl_riwayat', 1);
        return $query->result();
    }

    function __destruct()
    {
        $this->db->close();
    }

    public function widget()
    {
        $query  = $this->db->query(" SELECT
            (SELECT count(riwayat_id) FROM tbl_riwayat) as total");
        return $query->result();
    }
}
