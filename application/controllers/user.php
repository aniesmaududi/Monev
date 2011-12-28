<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	
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
		$this->data['title'] = 'Dashboard';
		$this->data['template'] = 'home/index';

		$this->data['result'] = $this->muser->getdata();

		$this->load->view('index', $this->data);
		else:
		redirect('user/login','refresh');
		endif;
	}

	function login()
	{
		$this->form_validation->set_rules('user_name', 'Username', 'required');
        $this->form_validation->set_rules('user_password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE):
            $this->data['title'] = 'Login';
            $this->data['template'] = 'user/login';
			$data['error'] = 'yay';
            $this->load->view($this->data['template'], $this->data);
        else: 
			//login script
			$data['user_name']=$this->input->post('user_name');
			$data['user_pass']=$this->input->post('user_password');
			$query = $this->muser->cekuser();
			if(!$query)
			{
			$data['error'] = 'password tidak benar';
			//$this->load->view('user/login',$data);
			redirect('user/login');
			}
			else
			{
			$this->session->set_userdata('username',$data['user_name']);
			redirect('user');
			}
		endif;
	}
	function logout()
	{
	$this->session->unset_userdata('logged_in');
	$this->session->sess_destroy();
//	$data['logout'] = 'You have been logged out.';
//	$this->load->view('user/login',$data);
    redirect('user/login','refresh');
		
	}
	
}
?>