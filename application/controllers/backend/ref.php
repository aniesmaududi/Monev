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
		$this->load->helper('form');
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
		$param = $this->uri->segment(4);
        $this->data['table_name'] = $param;
        //$this->data['field'] = $this->madmin_ref->get_table_field($this->data['table_name']);
        
		$this->load->library('pagination');
		$this->data['halaman'] 	= abs((int)$this->uri->segment(5));
		$config['base_url']		= base_url().'backend/ref/view/'.$param.'/';
		$config['total_rows'] 	= count($this->madmin_ref->get_table_detail($this->data['table_name']));
		$config['per_page'] 	= 25; 
		$config['cur_page'] 	= $this->data['halaman'];
		$this->pagination->initialize($config);
		
		$this->data['page'] 	= $this->pagination->create_links();
		$this->data['table'] 	= $this->madmin_ref->get_table_detail($this->data['table_name'], $config['per_page'], $config['cur_page']);
        $this->data['template'] = 'manajemen_referensi/view_'.$param;
        $this->load->view('backend/index', $this->data);
		
    }
    
    function editsatker()
    {
        $this->data['title'] = 'Pemeliharaan Referensi';
		$this->data['param'] = $this->uri->segment(4);
		$this->data['id'] = $this->uri->segment(5);
		$this->data['detail'] = $this->madmin_ref->get_data_detailsatker($this->data['param'],$this->data['id']);
        $this->data['template'] = 'manajemen_referensi/edit_'.$this->data['param'];
        $this->load->view('backend/index', $this->data);
    }
	
	    function editdept()
    {
        $this->data['title'] = 'Pemeliharaan Referensi';
		$this->data['param'] = $this->uri->segment(4);
		$this->data['id'] = $this->uri->segment(5);
		$this->data['detail'] = $this->madmin_ref->get_data_detaildept($this->data['param'],$this->data['id']);
        $this->data['template'] = 'manajemen_referensi/edit_'.$this->data['param'];
        $this->load->view('backend/index', $this->data);
    }
	
	 function editunit()
    {
        $this->data['title'] = 'Pemeliharaan Referensi';
		$this->data['param'] = $this->uri->segment(4);
		$this->data['id'] = $this->uri->segment(5);
		$this->data['detail'] = $this->madmin_ref->get_data_detailunit($this->data['param'],$this->data['id']);
        $this->data['template'] = 'manajemen_referensi/edit_'.$this->data['param'];
        $this->load->view('backend/index', $this->data);
    }
    
    
	 function ubahdept() {
		 $kode=$this->input->post('kddept');
		         $this->load->model('madmin_ref');
	           $this->madmin_ref->ubahdept();
	           redirect('backend/ref/view/dept'); 
	}
	
	 function ubahunit() {
		 $kode=$this->input->post('kdunit');
		         $this->load->model('madmin_ref');
	           $this->madmin_ref->ubahunit();
	           redirect('backend/ref/view/unit'); 
	}
	
	 function ubahsatker() {
		 $kode=$this->input->post('kdsatker');
		         $this->load->model('madmin_ref');
	           $this->madmin_ref->ubahsatker();
	           redirect('backend/ref/view/satker'); 
	}
	
}