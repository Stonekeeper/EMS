<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        if ( ! $this->session->userdata('logged_in'))
        { 
            redirect(base_url().'login');
        }
    }

    public function index()
    {
        $this->load->view('admin/header');
        $this->load->view('admin/add-department');
        $this->load->view('admin/footer');
    }

    public function manage_department()
    {
        $data['content']=$this->Department_model->select_departments();
        $this->load->view('admin/header');

        // Fetch departments from the department table
        $this->db->select('id, department_name');
        $this->db->from('department_tbl');
        $query = $this->db->get();
        $departments = $query->result_array();
    
        // Fetch employee count for each department from the employee table
        foreach ($departments as $key => $department) {
            $this->db->select('COUNT(id) as employee_count');
            $this->db->from('staff_tbl');
            $this->db->where('department_id', $department['id']);
            $query = $this->db->get();
            $employee_count = $query->row_array()['employee_count'];
            $departments[$key]['employee_count'] = $employee_count;
        }
    
        $data['content'] = $departments;
    
        $this->load->view('admin/manage-department', $data);
        $this->load->view('admin/footer');

    }

    public function insert()
    {
        $department=$this->input->post('txtdepartment');
        $data=$this->Department_model->insert_department(array('department_name'=>$department));
        if($data==true)
        {
            $this->session->set_flashdata('success', "New Department Added Succesfully"); 
        }else{
            $this->session->set_flashdata('error', "Sorry, New Department Adding Failed.");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function update()
    {
        $id=$this->input->post('txtid');
        $department=$this->input->post('txtdepartment');
        $data=$this->Department_model->update_department(array('department_name'=>$department),$id);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('success', "Department Updated Succesfully"); 
        }else{
            $this->session->set_flashdata('error', "Sorry, Department Update Failed.");
        }
        redirect(base_url()."department/manage_department");
    }


    function edit($id)
    {
        $data['content']=$this->Department_model->select_department_byID($id);
        $this->load->view('admin/header');
        $this->load->view('admin/edit-department',$data);
        $this->load->view('admin/footer');
    }


    function delete($id)
    {
        $data=$this->Department_model->delete_department($id);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('success', "Department Deleted Succesfully"); 
        }else{
            $this->session->set_flashdata('error', "Sorry, Department Delete Failed.");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }



}
