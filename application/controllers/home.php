<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();
		is_login();
		$this->data['now'] = date("Y-m-d H:i:s");
		$this->data['title'] = '';
		$this->load->model('muser');
	}
	
	function index()
	{
		$query_bappenas = $this->muser->cek_user_akses_bappenas($this->session->userdata('username'),$this->session->userdata('user_pass'));
		$query_dja = $this->muser->cek_user_akses_dja($this->session->userdata('username'),$this->session->userdata('user_pass'));
		if($this->session->userdata('username') && $this->session->userdata('nama')
            && $this->session->userdata('jabatan')):
			switch($this->session->userdata('jabatan'))
			{
				case 1 :
					$page = "satker/";
				break;
				case 2 :
					$page = "eselon/";
				break;
				case 3 :
					$page = "kementrian/";
				break;
				case 4 : $page = "dja";
				break;
			}
			redirect($page);
		elseif($query_bappenas):
			redirect('bappenas');
		elseif($query_dja):
			redirect('dja/satker');
		else:
			redirect('user/login');
		endif;
	}

}