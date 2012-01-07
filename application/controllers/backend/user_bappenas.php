<?php

if(!defined('BASEPATH'))
	exit('No direct script access allowed');

class User_bappenas extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		is_adminlogin();
		$this->data['now'] = date("Y-m-d H:i:s");
		$this->load->model('Manakses_model','man_akses');
		//$this->load->model('admin_model','admin');
	}
	
	function index()
	{
		$this->load->library('pagination');
		$this->data['halaman'] = abs((int)$this->uri->segment(4));
		$config['base_url'] 	= base_url().'backend/user_bappenas/index/';
		$config['total_rows'] 	= count($this->man_akses->get_all_akses_bappenas());
		$config['per_page'] 	= 10; 
		$config['cur_page'] 	= $this->data['halaman'];
		$this->pagination->initialize($config);
		
		$this->data['page'] 	= $this->pagination->create_links();
		$this->data['users'] 	= $this->man_akses->get_limited_akses_bappenas($config['cur_page'],$config['per_page']);
		$this->data['title'] = 'Manajemen User Bappenas';
		$this->data['template'] = 'manajemen_user/manajemen_user_bappenas';
		$this->load->view('backend/index', $this->data);
	}
	
	function tambah()
	{
		$this->data['title'] = "Tambah User Bappenas";
		$this->data['template'] = 'manajemen_user/form_user_bappenas';
		
		$this->load->view('backend/index',$this->data);		
	}
	
	function simpan()
	{
		//kdbapenas	username	password	nama	nip	email
		$this->form_validation->set_rules('username','Username','trim|required');
		$this->form_validation->set_rules('nama','Nama','trim|required');
		$this->form_validation->set_rules('nip','NIP','trim|required|numeric');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[konf_password]|md5');
		$this->form_validation->set_rules('konf_password','Konfirmasi Password','trim|required');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		
		if($this->form_validation->run() == FALSE):
			$this->data['title'] = "Tambah User Bappenas";
			$this->data['template'] = 'manajemen_user/form_user_bappenas';
			
			$this->load->view('backend/index',$this->data);
		else:
			$data_post = $this->input->post();
			unset($data_post['konf_password']);
			$this->man_akses->insert_user_bappenas($data_post);
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('message', 'Data berhasil disimpan');
			redirect('backend/add_user_bappenas');
		endif;
	}

}