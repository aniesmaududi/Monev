<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Eselon extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		is_login();
		$this->data['now'] = date("Y-m-d H:i:s");
		$this->data['title'] = 'Eselon ';
		//get Satker model
		$this->load->model('msatker');
		//get Unit model
		$this->load->model('meselon');
		$this->load->model('mdja');	
		$this->kdunit = $this->session->userdata('kdunit');
		$this->kddept = $this->session->userdata('kddept');
		//keperluan chart
		$this->data['thang'] = '2011';
		$this->data['kddept'] = $this->session->userdata('kddept');
		$this->data['kdunit'] = $this->session->userdata('kdunit');
		$this->data['kdprogram'] = null; 
		$this->data['kdsatker'] = null;
		$this->data['kdgiat'] = null;
	}
	
	function index()
	{
		$this->data['title'] = 'Dashboard Kementrian / Lembaga';
		$this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
		$this->data['kdprogram'] = null;
		$this->data['thang'] = '2011';
		
		if(isset($_POST['thang']) && $_POST['thang'] != 0):
			$this->data['thang'] = $_POST['thang'];
		endif;
		
		if((isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0)):
			$this->data['kdprogram'] = $_POST['kdprogram'];
		endif;
		
		$this->data['penyerapan'] = get_penyerapan($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		$this->data['konsistensi'] = get_konsistensi($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		$this->data['keluaran'] = get_keluaran($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		$this->data['efisiensi'] = get_efisiensi($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		
		$this->data['template'] = 'eselon/index';
		$this->load->view('index', $this->data);
	}
	/*-------------------------------- Laporan ----------------------------------*/
	/*------------------------------- Penyerapan Anggaran ----------------------*/
	function penyerapan()
	{
	    $this->data['title'] = 'Pengukuran Penyerapan Anggaran';        
        $this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
        $this->data['kdprogram'] = null;    
        
       
        if((isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0))
        {
            $this->data['kdprogram'] = $_POST['kdprogram'];
        }
        
		$thang = $this->input->post('thang');
		if(empty($thang))
		{
			$thang = '2011';
		}
		$kddept = $this->data['kddept'];
		$kdunit = $this->data['kdunit'];
		$kdprogram = $this->data['kdprogram'];
		
		$this->data['penyerapans'] = $this->mdja->get_penyerapan($thang,$kddept,$kdunit,$kdprogram)->result();
        $this->data['template'] = 'eselon/penyerapan';  
        $this->load->view('index', $this->data);
	}
	
	/*---------------------Konsistensi antara Perencanaan dan Implementasi ----------------------*/
	function konsistensi()
	{
	    $this->data['title'] = 'Konsistensi Antara Perencanaan dan Implementasi';
        $this->data['pengukuran'] = 'konsistensi';
		$this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
        $this->data['kdprogram'] = null; 
		$this->data['kdsatker'] = null;		
        
		if(isset($_POST['thang']) && $_POST['thang'] != 0)
        {
			$this->data['thang'] = $_POST['thang'];
		}
       
        if((isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0))
        {
            $this->data['kdprogram'] = $_POST['kdprogram'];
			$this->data['satker'] = get_satker($this->data['kddept'], $this->data['kdunit']);
        }
		if((isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0) && (isset($_POST['kdsatker']) && $_POST['kdsatker'] != 0))
        {
            $this->data['kdprogram'] = $_POST['kdprogram'];
			$this->data['kdsatker'] = $_POST['kdsatker'];
		}
		
		$this->data['konsistensi'] = get_report_konsistensi($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
        $this->data['template'] = 'eselon/konsistensi';
        $this->load->view('index', $this->data);
	}
	
	/*------------------------------------------- Pengukuran Volume Keluaran ----------------------*/
	public function keluaran()
	{
	    $this->data['title'] = 'Tingkat Pencapaian Keluaran';
        $this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
        $this->data['kdprogram'] = null;      
		$this->data['kdgiat'] = null; 		
        
        if(isset($_POST['thang']) && $_POST['thang'] != 0)
        {
			$this->data['thang'] = $_POST['thang'];
		}
        if((isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0))
        {
            $this->data['kdprogram'] = $_POST['kdprogram'];    
			$this->data['giat'] = get_giat($this->data['thang'], $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram']);
        }
		if((isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0) && (isset($_POST['kdgiat']) && $_POST['kdgiat'] != 0))
        {
            $this->data['kdprogram'] = $_POST['kdprogram'];    
			$this->data['kdgiat'] = $_POST['kdgiat'];
        }
		
		$this->load->library('pagination');
		$this->data['halaman']	= abs((int)$this->uri->segment(3));
		$config['base_url'] 	= base_url().'eselon/keluaran/';
		$config['total_rows'] 	= count($this->mdja->get_volume_keluaran($this->data['thang'], $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'], $this->data['kdsatker'], $this->data['kdgiat']));
		$config['per_page'] 	= 15; 
		$config['cur_page'] 	= $this->data['halaman'];
		$this->pagination->initialize($config);
		$this->data['page'] 	= $this->pagination->create_links();
		$this->data['output'] = $this->mdja->get_volume_keluaran($this->data['thang'], $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'], $this->data['kdsatker'], $this->data['kdgiat'], $config['per_page'],$config['cur_page']);
		
        $this->data['template'] = 'eselon/keluaran';                 
        $this->load->view('index', $this->data);
	}
	
	/*------------------------------------------- Pengukuran Efisiensi ----------------------*/
	public function efisiensi()
	{
	    $this->data['title'] = 'Pengukuran Efisiensi';    
        $this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
        $this->data['kdprogram'] = null;                
        
        if(isset($_POST['thang']) && $_POST['thang'] != 0)
        {
			$this->data['thang'] = $_POST['thang'];
		}
        if((isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0))
        {
            $this->data['kdprogram'] = $_POST['kdprogram'];            
        }
        
		//get volume keluaran
		$this->data['output'] = $this->mdja->get_volume_keluaran($this->data['thang'], $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'],null,0);
		
        $this->data['template'] = 'eselon/efisiensi';    
        $this->load->view('index', $this->data);
	}
	
	/*-------------------------------------------- MONITORING ---------------------------------------------*/
	/*------------------------------------------- Penyerapan Anggaran -------------------------------------*/
	public function mpenyerapan()
    {
        $this->data['title'] = 'Monitoring Penyerapan Anggaran';
        $this->data['kdprogram'] = null;    
		$this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
        
        if((isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0))
        {
            $this->data['kdprogram'] = $_POST['kdprogram'];
        }
        
		if(isset($_POST['thang']) && $_POST['thang']!=''){ 
			$this->data['thang'] = $_POST['thang']; 
		}
		
		$this->data['penyerapan'] = $this->mdja->get_penyerapan($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'])->row();
        $this->data['template'] = 'eselon/mpenyerapan';  
        $this->load->view('index', $this->data);
    }
	
	/*---------------------- Konsistensi antara Perencanaan dan Implementasi ------------------------------*/
    public function mkonsistensi()
    {
        $this->data['title'] = 'Konsistensi Antara Perencanaan dan Implementasi';
        $this->data['pengukuran'] = 'konsistensi';
		$this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
		
		if(isset($_POST['thang']) && $_POST['thang']!=''){ 
			$this->data['thang'] = $_POST['thang']; 
		}
		$this->data['bulan_awal'] = null;
		$this->data['bulan_akhir'] = null;
        
        if((isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0))
        {
            $this->data['kdprogram'] = $_POST['kdprogram'];
			$this->data['satker'] = get_satker($this->data['kddept'], $this->data['kdunit']);
        }
		if((isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0) && (isset($_POST['kdsatker']) && $_POST['kdsatker'] != 0))
        {
            $this->data['kdprogram'] = $_POST['kdprogram'];
			$this->data['kdsatker'] = $_POST['kdsatker'];
		}
		if(isset($_POST['bulan_awal']) && $_POST['bulan_awal']!=''){
			$this->data['bulan_awal'] = $_POST['bulan_awal'];
		}
		if(isset($_POST['bulan_akhir']) && $_POST['bulan_akhir']!=''){
			$this->data['bulan_akhir'] = $_POST['bulan_akhir'];
			if(isset($this->data['bulan_awal']) && ($this->data['bulan_awal'] > $this->data['bulan_akhir'])){
				$this->data['bulan_akhir'] = $this->data['bulan_awal'];
			}
		}
		
		$this->data['konsistensi'] = $this->mdja->get_report_konsistensi($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker'],$this->data['bulan_awal'],$this->data['bulan_akhir']);
                
        $this->data['template'] = 'eselon/mkonsistensi';            
        
        $this->load->view('index', $this->data);
    }
	
	/*-------------------------------- Pengukuran Volume Keluaran -----------------------------------------*/
    public function mkeluaran()
    {
		$this->data['title'] = 'Monitoring Tingkat Pencapaian Keluaran';
		$this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
		if(isset($_POST['thang']) && $_POST['thang']!=''){ 
			$this->data['thang'] = $_POST['thang']; 
		}		
        if((isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0))
        {
            $this->data['kdprogram'] = $_POST['kdprogram'];    
			$this->data['giat'] = get_giat($this->data['thang'], $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram']);
        }
		if((isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0) && (isset($_POST['kdgiat']) && $_POST['kdgiat'] != 0))
        {
            $this->data['kdprogram'] = $_POST['kdprogram'];    
			$this->data['kdgiat'] = $_POST['kdgiat'];
        }
		if(!isset($this->data['kdgiat'])):
			$this->load->library('pagination');
			$this->data['halaman']	= abs((int)$this->uri->segment(3));
			$config['base_url'] 	= base_url().'eselon/mkeluaran/';
			$config['total_rows'] 	= count($this->mdja->get_volume_keluaran($this->data['thang'], $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'], $this->data['kdsatker'], $this->data['kdgiat']));
			$config['per_page'] 	= 15; 
			$config['cur_page'] 	= $this->data['halaman'];
			$this->pagination->initialize($config);
			$this->data['page'] 	= $this->pagination->create_links();
			$this->data['output'] 	= $this->mdja->get_volume_keluaran($this->data['thang'], $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'], $this->data['kdsatker'], $this->data['kdgiat'], $config['per_page'],$config['cur_page']);
		else:
			$this->data['output'] 	= $this->mdja->get_volume_keluaran($this->data['thang'], $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'], $this->data['kdsatker'], $this->data['kdgiat']);
		endif;
        $this->data['template'] = 'eselon/mkeluaran';                 
        $this->load->view('index', $this->data);
    }
	
	/*------------------------------------------- Capaian Hasil ----------------------*/
	public function capaian_hasil()
	{
	    //pending
	}
	
	/*------------------------------------------- Aspek Evaluasi ----------------------*/
	public function aspek_evaluasi()
	{
	    //pending
	}
	/*------------------------------ End of Laporan ------------------------------*/
	
	/*------------------------------ Approval Inputan Output Satker ------------------------------*/
	function kegiatan()
	{
	    //this part loads get_unit_program content according to unit's id 
	    $this->data['program'] = $this->meselon->get_unit_program($this->session->userdata('kddept'),$this->session->userdata('kdunit'));
	    if($this->data['program']):
		$this->data['nmprogram'] = $this->data['program'][0]['nmprogram'];
		$this->data['kdprogram'] = $this->data['program'][0]['kdprogram'];
		$this->data['kegiatan'] = $this->meselon->get_unit_kegiatan($this->session->userdata('kddept'),$this->session->userdata('kdunit'), $this->data['kdprogram']);
	    endif;
	    //this part loads kegiatan
	    
	    $this->data['template'] = 'eselon/kegiatan';
	    $this->load->view('index',$this->data);
	}
	
	function detail_giat($kdgiat)
	{
	    //this part loads get_unit_program content according to unit's id 
	    $this->data['program'] = $this->meselon->get_unit_program($this->session->userdata('kddept'),$this->session->userdata('kdunit'));
	    $this->data['nmprogram'] = $this->data['program'][0]['nmprogram'];
	    $this->data['kdprogram'] = $this->data['program'][0]['kdprogram'];
	    
	    //this part loads kegiatan
	    $this->data['kegiatan'] = $this->meselon->get_unit_kegiatan($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'),$this->data['kdprogram']);
	    $this->data['kdgiat'] = $kdgiat;
	    $detail_giat = $this->msatker->get_detail_giat($kdgiat);
	    $this->data['nmgiat'] = $detail_giat['nmgiat'];
    
	    //this part loads output
	    $this->data['output'] = $this->meselon->get_output($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'),$this->data['kdprogram'],$kdgiat);
	    
	    $this->data['ikk'] = $this->meselon->get_ikk($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'),$this->data['kdprogram'],$kdgiat);
	    
	    $this->data['template'] = 'eselon/detail_giat';
	    $this->load->view('index',$this->data);
	}
	
	/*---------------------------------- Output --------------------------------*/
	public function output()
	{
		$this->data['kdunit'] = $this->kdunit;
		$this->data['kddept'] = $this->kddept;
		$this->data['unit_identity'] = $this->meselon->get_unit_identity($this->data['kddept'], $this->data['kdunit']);		
                $this->data['nmunit'] = $this->data['unit_identity']['nmunit'];
                $this->data['nmdept'] = $this->data['unit_identity']['nmdept'];	
		
		//fungsi untuk menampilkan daftar program		
		$this->data['program'] = $this->meselon->get_unit_program($this->data['kddept'], $this->data['kdunit']);
		$this->data['kdsatker'] = $this->data['program'][0]['kdsatker'];
		$this->data['kdprogram'] = 0;
		$this->data['kdgiat'] = 0;
		
		if(isset($_POST['program']))
		{
			$this->data['kdprogram'] = $this->input->post('program');
			$this->data['kegiatan'] = $this->meselon->get_satker_kegiatan($this->data['kddept'],$this->data['kdunit'], $this->data['kdsatker'], $this->data['kdprogram']);
		}
		
		if(isset($_POST['kegiatan']))
		{
			$this->data['kdprogram'] = $this->input->post('program');
			$this->data['kdgiat'] = $this->input->post('kegiatan');
			$this->data['output'] = $this->meselon->get_output($this->data['kddept'],$this->data['kdunit'], $this->data['kdsatker'], $this->data['kdprogram'], $this->data['kdgiat']);			
		}
		
		$this->data['template'] = 'eselon/output';
		$this->load->view('index', $this->data);
	}
	
	public function do_output_approval()
	{
		$kdgiat = $this->input->post('kdgiat');
		$do = $this->input->post('submit');
		$this->meselon->set_real_output_approval();	

		$message = "Data realisasi keluaran yang sah telah dieskalasi ke Kementrian. <br>".
			   "Data realisasi keluaran yang tidak sah telah dikembalikan ke Satuan Kerja untuk diperiksa ulang";
		$this->session->set_flashdata('message', $message);
		redirect('eselon/detail_giat/'.$kdgiat);
		
	}
	
	/*---------------------------------- Outcome --------------------------------*/
	function outcome()
	{
		$this->data['kdunit'] = $this->kdunit;
		$this->data['kddept'] = $this->kddept;
		$this->data['unit_identity'] = $this->meselon->get_unit_identity($this->data['kddept'], $this->data['kdunit']);		
                $this->data['nmunit'] = $this->data['unit_identity']['nmunit'];
                $this->data['nmdept'] = $this->data['unit_identity']['nmdept'];		
		
		//fungsi untuk menampilkan daftar program
		//data program ini sementara diambil dari d_output karena belum ada data untuk kebutuhan outcome
		$this->data['program'] = $this->meselon->get_unit_program($this->data['kddept'], $this->data['kdunit']);
		$this->data['kdprogram'] = 0;
		
		if(isset($_POST['program']))
		{
			$this->data['kdprogram'] = $this->input->post('program');
			$this->data['outcome'] = $this->meselon->get_iku($this->data['kddept'],$this->data['kdunit'], $this->data['kdprogram']);			
		}		
		
		$this->data['template'] = 'eselon/outcome';
		$this->load->view('index', $this->data);
	}
	
	public function do_outcome_approval()
	{		
		$this->meselon->set_real_iku();
				
		$kdunit = $this->kdunit;
		$kddept = $this->kddept;
		$this->data['unit_identity'] = $this->meselon->get_unit_identity($kddept, $kdunit);		
                $this->data['nmunit'] = $this->data['unit_identity']['nmunit'];
                $this->data['nmdept'] = $this->data['unit_identity']['nmdept'];		

		$this->data['message'] = "Data realisasi outcome yang sah telah dieskalasi ke Kementrian. <br>".
					 "Data realisasi outcome yang tidak sah telah dikembalikan ke Satuan Kerja untuk diperiksa ulang";
		$this->data['template'] = 'eselon/realisasi_status';
		$this->load->view('index', $this->data);
	}	
	
	/*----------------------------------- IKK ---------------------------------------------*/
	public function ikk()
	{
		/*
		--- Pending atau bahkan not used, butuh penjelasan lebih lanjut
		
		$this->data['kdunit'] = $this->kdunit;
		$this->data['kddept'] = $this->kddept;
		$this->data['unit_identity'] = $this->meselon->get_unit_identity($this->data['kddept'], $this->data['kdunit']);		
                $this->data['nmunit'] = $this->data['unit_identity']['nmunit'];
                $this->data['nmdept'] = $this->data['unit_identity']['nmdept'];	
		
		//fungsi untuk menampilkan daftar program		
		$this->data['program'] = $this->meselon->get_unit_program($this->data['kddept'], $this->data['kdunit']);
		$this->data['kdsatker'] = $this->data['program'][0]['kdsatker'];
		$this->data['kdprogram'] = 0;
		$this->data['kdgiat'] = 0;
		
		if(isset($_POST['program']))
		{
			$this->data['kdprogram'] = $this->input->post('program');
			$this->data['kegiatan'] = $this->meselon->get_satker_kegiatan($this->data['kddept'],$this->data['kdunit'], $this->data['kdsatker'], $this->data['kdprogram']);
		}
		
		if(isset($_POST['kegiatan']))
		{
			$this->data['kdprogram'] = $this->input->post('program');
			$this->data['kdgiat'] = $this->input->post('kegiatan');
			$this->data['ikk'] = $this->meselon->get_ikk($this->data['kddept'],$this->data['kdunit'], $this->data['kdsatker'], $this->data['kdprogram'], $this->data['kdgiat']);			
		}
		
		$this->data['template'] = 'eselon/ikk';
		$this->load->view('index', $this->data);
		*/
	}
	
	public function do_ikk_approval()
	{
		/*
		--- Pending atau bahkan not used, butuh penjelasan lebih lanjut 
		$do = $this->input->post('submit');
		$this->meselon->set_real_ikk_approval();
				
		$this->data['kdunit'] = $this->kdunit;
		$this->data['kddept'] = $this->kddept;
		$this->data['unit_identity'] = $this->meselon->get_unit_identity($this->data['kddept'], $this->data['kdunit']);		
                $this->data['nmunit'] = $this->data['unit_identity']['nmunit'];
                $this->data['nmdept'] = $this->data['unit_identity']['nmdept'];		

		$this->data['message'] = "Data realisasi IKK yang sah telah dieskalasi ke Kementrian. <br>".
					"Data realisasi IKK yang tidak sah telah dikembalikan ke Satuan Kerja untuk diperiksa ulang";
		$this->data['template'] = 'eselon/realisasi_status';
		$this->load->view('index', $this->data);
		*/
	}
	
	/*---------------------------------- Efisien --------------------------------*/
	public function efisien()
	{
		/*
		--- Pending atau bahkan not used, butuh penjelasan lebih lanjut
		
		$this->data['kdunit'] = $this->kdunit;
		$this->data['kddept'] = $this->kddept;
		$this->data['unit_identity'] = $this->meselon->get_unit_identity($this->data['kddept'], $this->data['kdunit']);		
                $this->data['nmunit'] = $this->data['unit_identity']['nmunit'];
                $this->data['nmdept'] = $this->data['unit_identity']['nmdept'];	
		
		//fungsi untuk menampilkan daftar program		
		$this->data['program'] = $this->meselon->get_unit_program($this->data['kddept'], $this->data['kdunit']);
		$this->data['kdsatker'] = $this->data['program'][0]['kdsatker'];
		$this->data['kdprogram'] = 0;
		$this->data['kdgiat'] = 0;
		
		if(isset($_POST['program']))
		{
			$this->data['kdprogram'] = $this->input->post('program');
			$this->data['kegiatan'] = $this->meselon->get_satker_kegiatan($this->data['kddept'],$this->data['kdunit'], $this->data['kdsatker'], $this->data['kdprogram']);
		}
		
		if(isset($_POST['kegiatan']))
		{
			$this->data['kdprogram'] = $this->input->post('program');
			$this->data['kdgiat'] = $this->input->post('kegiatan');
			$this->data['efisien'] = $this->meselon->get_efisien($this->data['kddept'],$this->data['kdunit'], $this->data['kdsatker'], $this->data['kdprogram'], $this->data['kdgiat']);			
		}
		
		$this->data['template'] = 'eselon/efisien';
		$this->load->view('index', $this->data);
		*/
	}
	
	public function do_efisien_approval()
	{
		/*
		--- Pending atau bahkan not used, butuh penjelasan lebih lanjut
		
		$do = $this->input->post('submit');
		$this->meselon->set_real_efisien_approval();
				
		$this->data['kdunit'] = $this->kdunit;
		$this->data['kddept'] = $this->kddept;
		$this->data['unit_identity'] = $this->meselon->get_unit_identity($this->data['kddept'], $this->data['kdunit']);		
                $this->data['nmunit'] = $this->data['unit_identity']['nmunit'];
                $this->data['nmdept'] = $this->data['unit_identity']['nmdept'];		

		$this->data['message'] = "Data efisiensi keluaran yang sah telah dieskalasi ke Kementrian. <br>".
					"Data efisiensi keluaran yang tidak sah telah dikembalikan ke Satuan Kerja untuk diperiksa ulang";
		$this->data['template'] = 'eselon/realisasi_status';
		$this->load->view('index', $this->data);
		*/
	}
	
	/*-------------------------------- Catatan Eselon ---------------------------------*/
	function catatan()
	{
	    // untuk menulis catatan dari eselon I ke K/L terkait proses input, kendala, dan lain-lain
	    $this->data['title'] = 'Catatan Penting';
	    $this->data['subtitle'] = 'Catatan ini untuk disampaikan kepada K/L perihal capaian kinerja, kendala, dan lain-lain.';
		$this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
		$this->data['kdprogram'] = null;
		$this->data['thang'] = '2011';
		
		if(isset($_POST['thang']) && $_POST['thang'] != 0):
			$this->data['thang'] = $_POST['thang'];
		endif;
		
		if((isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0)):
			$this->data['kdprogram'] = $_POST['kdprogram'];
		endif;
		
		$this->data['penyerapan'] = get_penyerapan($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		$this->data['konsistensi'] = get_konsistensi($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		$this->data['keluaran'] = get_keluaran($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		$this->data['efisiensi'] = get_efisiensi($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		    
	    $this->data['template'] = 'eselon/catatan';
	    $this->load->view('index',$this->data);
	}
	
	function history_catatan()
	{
	    // untuk menulis catatan dari eselon I ke K/L terkait proses input, kendala, dan lain-lain
	    $this->data['title'] = 'Rekaman Catatan';
	    $this->data['subtitle'] = 'Catatan ini untuk disampaikan kepada K/L perihal capaian kinerja, kendala, dan lain-lain.';
	    $this->data['catatan'] = $this->meselon->get_catatan();
	    $this->data['template'] = 'eselon/history_catatan';
	    $this->load->view('index',$this->data);
	}
	
	public function do_catatan()
	{		
	    $do = $this->input->post('submit');
	    $this->meselon->set_catatan($do);
    
	    if ($do == 'Simpan') {
		$message = "Catatan Anda telah direkam untuk diteruskan ke K/L";
	    }
	    
	    $this->session->set_flashdata('message', $message);
	    redirect('eselon/catatan/');	
	}
	
	function catatan_satker()
	{
	    // untuk melihat catatan dari satker terkait proses input, kendala, dan lain-lain
	    $this->data['title'] = 'Rekaman Catatan Satker';
	    $this->data['subtitle'] = 'Catatan ini untuk dari Satker perihal capaian kinerja, kendala, dan lain-lain.';
	    $this->data['catatan'] = $this->meselon->get_catatan_satker();
	    $this->data['template'] = 'eselon/history_catatan_satker';
	    $this->load->view('index',$this->data);
	}
}