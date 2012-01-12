<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ref extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_adminlogin();
        $this->data['now'] = date("Y-m-d H:i:s");
        $this->load->model('admin_model', 'admin');
        $this->load->model('madmin_ref');
        $this->load->library('form_validation');
    }

    function index()
    {
        $this->data['title'] = 'Pemeliharaan Referensi';
        $this->data['tables'] = $this->madmin_ref->get_tables();
        $this->data['template'] = 'manajemen_referensi/index';
        $this->load->view('backend/index', $this->data);
    }
    
    function view()
    {
        $this->data['title'] = 'Pemeliharaan Referensi';
        $this->data['table_name'] = $this->uri->segment(4);
        $this->data['field'] = $this->madmin_ref->get_table_field($this->data['table_name']);
        $this->data['table'] = $this->madmin_ref->get_table_detail($this->data['table_name']);
        $this->data['template'] = 'manajemen_referensi/view';
        $this->load->view('backend/index', $this->data);
    }
    
    function edit()
    {
        $this->data['title'] = 'Pemeliharaan Referensi';
        $this->data['table_name'] = $this->uri->segment(4);        
        $this->data['keys'] = $this->uri->segments;        
        $this->data['field'] = $this->madmin_ref->get_table_field($this->data['table_name']);
        $this->data['row'] = $this->madmin_ref->get_row_detail($this->data['table_name'], $this->data['keys']);
        $this->data['template'] = 'manajemen_referensi/edit';
        $this->load->view('backend/index', $this->data);
    }
    
    function hapus()
    {
        $this->data['title'] = 'Pemeliharaan Referensi';
        $this->data['table_name'] = $this->uri->segment(4);        
        $this->data['keys'] = $this->uri->segments;        
        $this->data['field'] = $this->madmin_ref->get_table_field($this->data['table_name']);
        $this->data['row'] = $this->madmin_ref->get_row_detail($this->data['table_name'], $this->data['keys']);
        $this->data['template'] = 'manajemen_referensi/hapus';
        $this->load->view('backend/index', $this->data);
    }
    
    function do_simpan()
    {
        $table_name = $this->input->post('table_name');
        $save = $this->madmin_ref->save_record($table_name);        
        $this->session->set_flashdata('message_type', 'success');
	$this->session->set_flashdata('message', 'update sukses');
        $this->log->create('aksi', 'update data referensi '.$table_name);
        redirect(site_url().'backend/ref/view/'.$table_name);
    }
    
    function do_hapus()
    {
        $table_name = $this->input->post('table_name');
        $delete = $this->madmin_ref->delete_record($table_name);        
        $this->session->set_flashdata('message_type', 'success');
	$this->session->set_flashdata('message', 'delete sukses');
        $this->log->create('aksi', 'hapus data referensi '.$table_name);
        redirect(site_url().'backend/ref/view/'.$table_name);
    }
}