<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');

class Bappenas extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->data['now'] = date("Y-m-d H:i:s");
		$this->data['title'] = '';
		$this->load->library('form_validation');
		$this->load->model('muser');
	}
	
	function index()
	{
		if($this->session->userdata('username')):
			$this->data['title'] = 'Dashboard Bappenas';
			//$this->data['template'] = 'satker/program';
			echo "Page Bappenas";
			$this->load->view('index', $this->data);
		else:
			redirect('user/login','refresh');
		endif;
	}
	
}