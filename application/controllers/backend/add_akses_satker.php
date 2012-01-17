<?php

if(!defined('BASEPATH'))
	exit('No direct script access allowed');

class Add_akses_satker extends CI_Controller
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
		$temp_data_kementerian = $this->man_akses->get_all_departemen();
		$this->data['kementerian_value'][] = "";
		foreach($temp_data_kementerian as $key=>$val):
			$this->data['kementerian_value'][$val['kddept']] = $val['nmdept'];
		endforeach;
		
		$this->data['unit_value'] = array();
		$this->data['satker_value'] = array();
		
		$temp_data_dja = $this->man_akses->get_all_user_dja();
		foreach($temp_data_dja as $key3=>$val3):
			$this->data['dja_value'][$val3['kddja']] = $val3['nama'];
		endforeach;
		
		$temp_data_bappenas = $this->man_akses->get_all_akses_bappenas();
		foreach($temp_data_bappenas as $key4=>$val4):
			$this->data['bapenas_value'][$val4['kdbapenas']] = $val4['nama'];
		endforeach;
		
		$this->data['title'] = "Tambah Akses Satker";
		$this->data['template'] = 'manajemen_akses/form_akses_satker';
		
		$this->load->view('backend/index',$this->data);
	}
	
	function simpan()
	{
		$this->form_validation->set_rules('kdkementerian','Input K/L','trim|required');
		$this->form_validation->set_rules('kdbapenas','User Bappenas','trim|required');
		$this->form_validation->set_rules('kddja','User DJA','trim|required');	
			
		if($this->form_validation->run() == FALSE):
			$this->index();
		else:
			$data_post = $this->input->post();
			unset($data_post['kdkementerian']);
			unset($data_post['kdunit']);
			$this->man_akses->insert_akses_satker($data_post);
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('message', 'Data berhasil disimpan');
            $this->log->create('', 'Berhasil simpan satker baru');
			redirect('backend/add_akses_satker');
		endif;
	}
	
	function get_eselon1()
	{
		$this->kdkementerian = $_POST['kdkementerian'];
		$temp_data_eselon1 = $this->man_akses->get_group_unit($this->kdkementerian);
		$data_eselon1[] = "";
		foreach($temp_data_eselon1 as $key=>$val):
			$data_eselon1[$val['kdunit']] = $val['nmunit'];
		endforeach;
		echo form_dropdown('kdunit',$data_eselon1,'','id="kdunit" class="kdunit"');
		return $data_eselon1;
	}
	
	function get_satker()
	{
		$this->kdkementerian = $_POST['kdkementerian'];
		$this->kdunit = $_POST['kdunit'];
		$temp_data_satker = $this->man_akses->get_group_satker($this->kdkementerian,$this->kdunit);
		$data_satker[] = "";
		foreach($temp_data_satker as $key=>$val):
			$data_satker[$val['kdsatker']] = $val['nmsatker'];
		endforeach;
		//print_r($data_satker);
		echo form_dropdown('kdsatker',$data_satker,'id="kdsatker" class="kdsatker"');
	}
	
}