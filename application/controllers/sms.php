<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();
		is_login();
		$this->data['now'] = date("Y-m-d H:i:s");
		$this->data['title'] = '';
		$this->_kdsatker = "675713";
		$this->_phone = "6281381183424";
		$this->data['nav_title'] = 'Entri Data';
		$this->data['nav_menu'] = array(
						0 => 'Entri IKU',
						1 => 'Entri Output',
						2 => 'Entri IKK',
						3 => 'Entri Penyerapan Efisiensi',
						4 => 'Entri Data Revisi',
						);
		$this->data['nav_menu_link'] = array(
						0 => base_url().'satker/outcome',
						1 => base_url().'satker/output',
						2 => base_url().'satker/ikk',
						3 => base_url().'satker/efisien',
						4 => '#',
						);
		
		$this->data['nav2_title'] = 'Laporan';
		$this->data['nav2_menu'] = array(
						0 => 'Laporan Outcome',
						1 => 'Kertas Kerja Outcome',
						2 => 'Laporan Output',
						3 => 'Kertas Kerja Output',
						4 => 'Laporan Perencanaan & Realisasi',
						5 => 'Kertas Kerja Konsistensi',
						6 => 'Laporan Penyerapan Efisiensi',
						7 => 'Kertas Kerja Penyerapan Efisiensi',
						);
		$this->data['nav2_menu_link'] = array(
						0 => base_url().'satker/capaian_hasil',
						1 => base_url().'satker/kertas_kerja_outcome',
						2 => base_url().'satker/keluaran',
						3 => base_url().'satker/kertas_kerja_output',
						4 => base_url().'satker/konsistensi',
						5 => base_url().'satker/kertas_kerja_efisiensi',
						6 => base_url().'satker/efisiensi',
						7 => base_url().'satker/kertas_kerja_efisiensi',
						);
	}
	
	function index()
	{
		
		$this->data['title'] = 'SMS';
		$this->data['template'] = 'sms/index';
		$this->load->view('index', $this->data);
	}
	
	function responder(){
		$post = $this->input->post();
		
		$this->phoneAuthorizationChecker($post['phonenumber']);
		$text = $post['smsconfirm'];
		$arrText = explode(" ",$text);
		
		switch(strtoupper($arrText[0])){
			case "TOKEN" : 
				$this->smsverification($post['phonenumber'],$arrText[1]);
			break;
			
			default:
				$this->smsquickreply($post);
		}
	}
	
	function smsquickreply($array){
		$text = $array['smsconfirm'];
		$arrText = explode(" ",$text);
		
		$this->load->model('msms');	
		
		$getResponse = $this->msms->getResponse($arrText);
		
		// pre($getResponse); exit;
		
		$reply = $getResponse[0]['reply'];
		
		$this->session->set_flashdata('reply', $reply);
		redirect(base_url()."sms/smssimulation/");
	}
	
	function reqtoken(){
		$sendTime = date('Y-m-d H:i:s');
		$expTime = date('Y-m-d H:i:s',time()+600);
		$tokenCode = rand(123456, 987654);
		$verCode = rand(123456, 987654);
		
		$this->load->model('msms');	
		$arrIdBroadcast = $this->msms->getIdBroadcast($this->_kdsatker);
		$idBroadcast = $arrIdBroadcast[0]['id'];
		$this->msms->createToken($idBroadcast,$tokenCode,$verCode,$sendTime,$expTime);
		
		$this->data['tokencode'] = $tokenCode;
		$this->_kdsatker;
		$this->data['title'] = 'SMS';
		$this->data['template'] = 'sms/reqtoken';
		$this->load->view('index', $this->data);
	}
	
	function smssimulation(){
		$this->data['vercode'] = $this->session->flashdata('reply');
		$this->data['title'] = 'SMS';
		$this->data['template'] = 'sms/smssimulation';
		$this->data['phoneNumber'] = $this->_phone;
		$this->load->view('index', $this->data);
	}
	
	function restricted(){
		$this->data['text'] = $this->session->flashdata('flag');
		$this->data['title'] = 'SMS';
		$this->data['template'] = 'sms/restricted';
		$this->load->view('index', $this->data);
	}
	
	function smsverification($phonenumber,$smsconfirm){
		$this->load->model('msms');	
		$result = $this->msms->getVerCode($phonenumber,$smsconfirm);
		
		$reply = $result[0]['vercode'];
		
		if($reply){
			$this->session->set_flashdata('reply', $reply);
			redirect(base_url()."sms/smssimulation/");
		} else {
			$this->session->set_flashdata('reply', 'not valid code');
			redirect(base_url()."sms/smssimulation/");
		}
	}
	
	function tokenverification(){
		$post = $this->input->post();
		$this->load->model('msms');	
		$result = $this->msms->codeVerification($post['tokencode'],$post['vercode']);
		
		if($result == TRUE){
			$res = "You're Authorized to access this page";
		} else {
			$res = "You're not Authorized to access this page";
		}
		
		$this->session->set_flashdata('flag', $res);
		redirect(base_url()."sms/restricted/");
		
	}
	
	function phoneAuthorizationChecker($number){
		$this->load->model('msms');	
		$result = $this->msms->numberVerification($number);
		if($result == FALSE){
			$this->session->set_flashdata('reply', 'Nomor anda tidak terdaftar.');
			redirect(base_url()."sms/smssimulation/");
		}
	}
	
}