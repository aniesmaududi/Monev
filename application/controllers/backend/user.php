<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_adminlogin();
		$this->data['now'] = date("Y-m-d H:i:s");
		$this->load->model('admin_model','admin');
        $this->load->library('form_validation');
    }

    function index()
    {
		$this->load->library('pagination');
		$this->data['halaman'] 	= abs((int)$this->uri->segment(4));
		$config['base_url'] 	= base_url().'backend/user/index/';
		$config['total_rows'] 	= count($this->admin->get_user_list());
		$config['per_page'] 	= 25; 
		$config['cur_page'] 	= $this->data['halaman'];
		$this->pagination->initialize($config);
		
		$this->data['page'] 	= $this->pagination->create_links();
		$this->data['users'] 	= $this->admin->get_user_list($config['per_page'], $config['cur_page']);
		$this->data['title'] = 'Manajemen Pengguna';
		$this->data['template'] = 'user/index';
		$this->load->view('backend/index', $this->data);
    }
	
}