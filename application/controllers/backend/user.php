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
	
	function edit()
	{
		$userid = abs((int)$this->uri->segment(4));
		if(!empty($userid)):
			$this->form_validation->set_rules('userid', 'Username', 'required');
			$this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('jabid', 'Jabatan', 'required');
			
			if($this->form_validation->run() == FALSE):
				$this->data['user'] 	= $this->admin->get_user($userid);
				$this->data['title'] 	= 'Edit Data Pengguna';
				$this->data['template'] = 'user/edit';
				$this->load->view('backend/index', $this->data);
			else:
				$posts = $this->input->post();
				foreach ($posts as $key =>$val):
					if($key!='passwd' && $key!='passwd2' && $key!='id'):
						$data[$key] = sanitize_string($val);
					endif;
				endforeach;
				$this->admin->update_user($data,$this->input->post('id'));
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('message', 'Data berhasil diperbaharui');
				if($this->input->post('passwd') && $this->input->post('passwd')!='' && $this->input->post('passwd2') && $this->input->post('passwd2')!=''):
					if($this->input->post('passwd')==$this->input->post('passwd')):
						$datapasswd = array('passwd'=>md5(sanitize_string($this->input->post('passwd'))));
						$this->admin->update_user($datapasswd,$this->input->post('id'));
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('message', 'Data berhasil diperbaharui');
					else:
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('message', 'Password tidak valid');
					endif;
				endif;
				redirect('backend/user');
			endif;
		else:
			redirect('backend');
		endif;
	}
	
}