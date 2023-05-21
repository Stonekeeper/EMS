<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department_model extends CI_Model {


    function insert_department($data)
    {
        $this->db->insert("department_tbl",$data);
        return $this->db->insert_id();
    }

    function select_departments()
    {
        $qry=$this->db->get('department_tbl');
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
    }

    function select_department_byID($id)
    {

        $this->db->where('id',$id);
        $qry=$this->db->get('department_tbl');
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
    }

    function select_department_byID2($department_id)
    {

        $this->db->where('id', $department_id);
        $query = $this->db->get('department_tbl');
        return $query->row_array();
    }

    function delete_department($id)
    {
        $this->db->where('id', $id);
        $this->db->delete("department_tbl");
        $this->db->affected_rows();
    }

    

    function update_department($data,$id)
    {
        $this->db->where('id', $id);
        $this->db->update('department_tbl',$data);
        $this->db->affected_rows();
    }

    public function get_employees_by_department_id($id) {
        $this->db->select('*');
        $this->db->from('staff_tbl');
        $this->db->join('department_tbl', 'department_tbl.id = staff_tbl.department_id');
        $this->db->where('department_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }




}
