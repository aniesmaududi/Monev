<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Access_management extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
		$this->load->model('maccess_management');
    }

    public function index() 
    {
		$this->data['title'] = 'Manajemen Akses';
		$this->data['template'] = 'manajemen_akses/index';
		$this->data['hasil'] = $this->maccess_management->getdata();
		$this->load->view('backend/index', $this->data);
    }
	
	public function edit()
	{
		$this->maccess_management->selectdata();
		$this->data['title'] = 'Update Akses';
		$this->data['template'] = 'manajemen_akses/form_akses_satker';
//		$this->data[''] = $this->maccess_management->selectdata();
		$this->load->view('backend/index', $this->data);
	}

}

/* End of file access_management.php */
/* Location: ./application/controllers/backend/access_management.php */