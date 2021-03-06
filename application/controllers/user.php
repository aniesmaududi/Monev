<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller
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
			$this->data['title'] = 'Dashboard';
			$this->data['template'] = 'satker/program';
			$this->data['result'] = $this->muser->getdata();
			$this->load->view('index', $this->data);
		else:
			redirect('user/login','refresh');
		endif;
	}
	
	function login() // faisal
	{
		$this->form_validation->set_rules('user_name', 'Username', 'required');
		$this->form_validation->set_rules('user_password', 'Password', 'required');
	
		if ($this->form_validation->run() == FALSE):
			$this->data['title'] = 'Login';
			$this->data['template'] = 'user/login';
			$this->load->view($this->data['template'], $this->data);
		else: 
			//login script
			$data['user_name']=$this->input->post('user_name');
			$data['user_pass']=md5($this->input->post('user_password'));
			$query = $this->muser->cekuser();
			$query_bappenas = $this->muser->cek_user_akses_bappenas($data['user_name'],$data['user_pass']);
			$query_dja = $this->muser->cek_user_akses_dja($data['user_name'],$data['user_pass']);
			if($query):
				$this->session->set_userdata('username',$data['user_name']);
				$this->session->set_userdata('user_pass',$data['user_pass']);
				$this->session->set_userdata('jabatan',$query->jabid);
				
				switch($query->jabid)
				{
					case 1 :
						$page = "satker/";
						$this->session->set_userdata('nama',get_detail_data('t_satker',array('kdsatker'=>$query->kdsatker),'nmsatker'));
						$this->session->set_userdata('kdsatker',$query->kdsatker);						
						$this->session->set_userdata('kdunit',$query->kdunit);
						$this->session->set_userdata('kddept',$query->kddept);
						$this->session->set_userdata('jabatan_name','SATKER');
						$this->log->create('login', 'Satker '.$query->kdsatker);
					break;
					case 2 :
						$page = "eselon/";
						$this->session->set_userdata('nama',get_detail_data('t_unit',array('kddept'=>$query->kddept,'kdunit'=>$query->kdunit),'nmunit'));
						$this->session->set_userdata('kdunit',$query->kdunit);
						$this->session->set_userdata('kddept',$query->kddept);
						$this->session->set_userdata('jabatan_name','ESELON');
						$this->log->create('login', 'Eselon '.$query->kdunit);
					break;
					case 3 :
						$page = "kementrian/";
						$this->session->set_userdata('nama',get_detail_data('t_dept',array('kddept'=>$query->kddept),'nmdept'));
						$this->session->set_userdata('kddept',$query->kddept);
						$this->session->set_userdata('jabatan_name','K /L ');
						$this->log->create('login', 'Kementerian '.$query->kddept);
					break;
					case 4 : $page = "dja";
						$this->session->set_userdata('nama','DIREKTORAT JENDERAL ANGGARAN');
						$this->session->set_userdata('jabatan_name','DJA');
						$this->log->create('login', 'DJA');
					break;
				}
				redirect($page);
			elseif($query_bappenas):
				$this->session->set_userdata('username',$data['user_name']);
				$this->session->set_userdata('user_pass',$data['user_pass']);
				$this->session->set_userdata('nama','BAPPENAS');
				$this->session->set_userdata('jabatan_name','BAPPENAS');
				redirect('bappenas');
			elseif($query_dja):
				$this->session->set_userdata('username',$data['user_name']);
				$this->session->set_userdata('user_pass',$data['user_pass']);
				$this->session->set_userdata('nama','DIREKTORAT JENDERAL ANGGARAN');
				$this->session->set_userdata('jabatan',$query_dja->kdjabatan);
				$this->session->set_userdata('jabatan_name','SATKER DJA');
				redirect('dja/satker');
			else:
				$this->session->set_flashdata('message_type', 'error');
                $this->session->set_flashdata('message', '<b>Login gagal</b>, userid atau password salah.');
				$data['error'] = 'password tidak benar';
				redirect('user/login');
			endif;	
		endif;
	}
	
	function logout()
	{
		$this->log->create('logout', $this->session->userdata('username').' logout');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('user_pass');
		$this->session->unset_userdata('nama');
		$this->session->unset_userdata('jabatan');
		$this->session->unset_userdata('jabatan_name');
		redirect();
	}
}
?>