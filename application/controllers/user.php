<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();
		$this->data['now'] = date("Y-m-d H:i:s");
		$this->data['title'] = '';
	}
	
	function index()
	{
		show_404();
	}

	function login()
	{
		$this->form_validation->set_rules('user_username', 'Username', 'required');
        $this->form_validation->set_rules('user_password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE):
            $this->data['title'] = 'Login';
            $this->data['template'] = 'user/login';
            $this->load->view($this->data['template'], $this->data);
        else:
			//login script
		endif;
	}
	
}