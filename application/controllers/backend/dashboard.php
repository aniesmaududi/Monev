<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_adminlogin();
		$this->data['now'] = date("Y-m-d H:i:s");
        $this->load->library('form_validation');
		$this->load->model('admin_model','admin');
    }

    public function index()
    {
		$this->data['title'] = 'Dashboard';
		$this->data['template'] = 'dashboard/index';
		$this->load->view('backend/index', $this->data);
    }
	
    public function login()
    {
        $this->form_validation->set_rules('admin_username', 'Username', 'required');
        $this->form_validation->set_rules('admin_password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE):
            $this->data['title'] = 'Admin Login';
            $this->data['template'] = 'login';
            $this->load->view('backend/' . $this->data['template'], $this->data);
        else:
            $username = mysql_real_escape_string(strip_tags($this->input->post('admin_username')));
            $password = md5(mysql_real_escape_string(strip_tags($this->input->post('admin_password'))));
			
			$params = array(
				'admin_username' => $username,
				'admin_password' => $password,
				'admin_is_active'=> 1
			);
			$result = $this->admin->get_admin($params,1);
						
            if ($result):
				$data = array(
					'admin_last_login' => $this->data['now']
				);
				$this->admin->update_admin($data,$result->admin_ID);
                $this->session->set_userdata('admin_ID', $result->admin_ID);
                $this->session->set_userdata('admin_username', $result->admin_username);
                $this->session->set_flashdata('message_type', 'success');
                $this->session->set_flashdata('message', 'Admin login success');
                redirect('backend');
            else:
                $this->session->set_flashdata('message_type', 'error');
                $this->session->set_flashdata('message', 'Failed to login.');
                redirect('backend/login');
            endif;

        endif;
    }

    function logout()
    {
        $this->session->unset_userdata('admin_ID');
        $this->session->unset_userdata('admin_username');
        redirect('backend');
    }

}

/* End of file dashboard.php */
/* Location: ./application/controllers/backend/dashboard.php */