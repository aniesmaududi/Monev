<?php
if(!defined('BASEPATH'))
	exit('No direct script access allowed');

class Akses_kl extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		is_adminlogin();
		$this->data['now'] = date("Y-m-d H:i:s");
		$this->load->model('Manakses_model','man_akses');
		//$this->load->model('admin_model','admin');
	}
	
	function index()
	{
		$this->load->library('pagination');
		$this->data['halaman'] = abs((int)$this->uri->segment(4));
		$config['base_url'] 	= base_url().'backend/akses_kl/index/';
		$config['total_rows'] 	= count($this->man_akses->get_all_departemen());
		$config['per_page'] 	= 10; 
		$config['cur_page'] 	= $this->data['halaman'];
		$this->pagination->initialize($config);
		$this->data['page'] 	= $this->pagination->create_links();
		$this->data['depts'] 	= $this->man_akses->get_limited_departemen($config['cur_page'],$config['per_page']);
		
		$this->data['data_akses'] = $this->man_akses->get_all_akses_kl();
		
		$this->data['title'] = 'Manajemen Akses K/L';
		$this->data['template'] = 'manajemen_user/add_akses_kl';
		$this->load->view('backend/index', $this->data);
	}
	
	function simpan()
	{
		$arr_data =$this->input->post();
		//id kddept username password isadmin
		$data_temp = array();
		$i = 0;
		foreach($arr_data as $arr):
			$i++;
			$data_temp[$i]['kddept'] = $data['kddept'] = $arr;
			$data_temp[$i]['username'] = $data['username'] = 'userkl_'.$arr;
			$data_temp[$i]['password'] = $data['password'] = md5('kl');
			$data_temp[$i]['isadmin'] = $data['isadmin'] = 'n';
			$this->man_akses->insert_akses_kl($data);
			$i++;
			$data_temp[$i]['kddept'] = $data['kddept'] = $arr;
			$data_temp[$i]['username'] = $data['username'] = 'adminkl_'.$arr;
			$data_temp[$i]['password'] = $data['password'] = md5('kl');
			$data_temp[$i]['isadmin'] = $data['isadmin'] = 'y';
			$this->man_akses->insert_akses_kl($data);
		endforeach;
		//$dt_kl = $this->man_akses->get_akses_kl($data['kddept']);
		//print_r($data_temp);
		$message = "<p>Data akses berhasil disimpan,dengan user : <br/>";
		foreach($data_temp as $val):
			$message .= "<br/>".$this->man_akses->get_departemen_by_id($val['kddept'])."<br/>";
			$message .= "&bull;<b>username :</b> ".$val['username']." & <b>password :</b> kl <br/>";
		endforeach;
		$message .= " </p>";
		$this->session->set_flashdata('message_type', 'success');
		$this->session->set_flashdata('message', $message);
        $this->log->create('', 'Berhasil simpan Akses KL');
		redirect('backend/akses_kl/index','refresh');
	}
	
}