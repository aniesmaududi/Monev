<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Access_management extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
		$this->load->helper('date');
		$this->load->model('maccess_management','access');
    }

    public function index() 
    {
		$this->data['title'] = 'Manajemen Akses';
		$this->data['template'] = 'manajemen_akses/index';
		$this->data['hasil'] = $this->access->getdata();
		$this->load->view('backend/index', $this->data);
    }
	
	public function edit()
	{
		$id = abs((int)$this->uri->segment(4));
		if(!empty($id)):
			$this->form_validation->set_rules('Start_time', 'start', 'required');
			$this->form_validation->set_rules('End_time', 'end', 'required');

				//validasi date
				$start = $this->input->post('Start_time');
				$end = $this->input->post('End_time');

			if($this->form_validation->run() == FALSE || $this->validate_date($start)==FALSE || $this->validate_date($end)==FALSE || (mysql_to_unix($end)-mysql_to_unix($start))/86400 <= 0):
				$this->data['user'] 	= $this->access->get_user($id);
				$this->data['title'] 	= 'Edit Akses Satker';
				$this->data['template'] = 'manajemen_akses/edit';
//				$this->session->set_flashdata('message_type', 'error');
//				$this->session->set_flashdata('message1', 'Data salah input');
				$this->load->view('backend/index', $this->data);
			else: 
				
				$this->access->update_date($start,$end,$id);
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('message', 'Data berhasil diperbaharui');
				redirect('backend/access_management/'); 
				
			endif;
		else:
			redirect('backend');
		endif;

	}
	function validate_date($str)
	{
		$dateArray=explode('-',$str);
		$dateArray=explode('-',$str);
		if($dateArray === false)
		{
			return false;
		}
		else
		{ 
			if(is_numeric($dateArray[0])&&is_numeric($dateArray[1])&&is_numeric($dateArray[2]))
				return (checkdate($dateArray[1],$dateArray[2],$dateArray[0])); 
		}
    }  

}

/* End of file access_management.php */
/* Location: ./application/controllers/backend/access_management.php */