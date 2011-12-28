<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();
		is_login();
		$this->data['now'] = date("Y-m-d H:i:s");
		$this->data['title'] = '';
	}
	
	function index()
	{
		$this->data['title'] = 'Dashboard';
		$this->data['template'] = 'home/index';
		$this->load->view('index', $this->data);
	}

}