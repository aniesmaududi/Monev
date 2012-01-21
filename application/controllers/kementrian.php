<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kementrian extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		is_login();
		$this->data['now'] = date("Y-m-d H:i:s");
		$this->data['title'] = 'Kementrian ';
		//get Satker model
		$this->load->model('msatker');
		//get Unit model
		$this->load->model('meselon');
		//get Dept model
		$this->load->model('mkementrian');		
		$this->load->model('mdja');
		//keperluan chart
		$this->data['thang'] = '2011';
		$this->data['kddept'] = $this->session->userdata('kddept');
		$this->data['kdunit'] = null;
		$this->data['kdprogram'] = null;
		$this->data['kdsatker'] = null;
		$this->data['kdgiat'] = null; 
	}
	
	function index()
	{
		$this->data['title'] = 'Dashboard Kementrian / Lembaga';
		$this->data['unit'] = get_eselon($this->data['kddept']);
		$this->data['kdunit'] = null;
		$this->data['kdprogram'] = null;
		$this->data['thang'] = '2011';
		
		if(isset($_POST['thang']) && $_POST['thang'] != 0):
			$this->data['thang'] = $_POST['thang'];
		endif;
		
		if(isset($_POST['kdunit']) && $_POST['kdunit'] != 0):
			$this->data['kdunit'] = $_POST['kdunit'];
			$this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
		    endif;
		
		if((isset($_POST['kdunit']) && $_POST['kdunit'] != 0) && (isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0)):
			$this->data['kdunit'] = $_POST['kdunit'];
			$this->data['kdprogram'] = $_POST['kdprogram'];
		    endif;
		
		$this->data['penyerapan'] = get_penyerapan($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram']);
		$this->data['konsistensi'] = get_konsistensi($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		$this->data['keluaran'] = get_keluaran($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		$this->data['efisiensi'] = get_efisiensi($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		
		$this->data['template'] = 'kementrian/index';
		$this->load->view('index', $this->data);
	}
	/*-------------------------------- Laporan ----------------------------------*/
	/*------------------------------- Penyerapan Anggaran ----------------------*/
	function penyerapan()
	{
	    $this->data['title'] = 'Pengukuran Penyerapan Anggaran';        
		$this->data['unit'] = get_eselon($this->data['kddept']);
		$this->data['kdunit'] = null;
		$this->data['kdprogram'] = null;    
        
        if(isset($_POST['kdunit']) && $_POST['kdunit'] != 0)
        {
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
        }
        if((isset($_POST['kdunit']) && $_POST['kdunit'] != 0) && (isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0))
        {
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['kdprogram'] = $_POST['kdprogram'];
        }
        
		$thang = $this->input->post('thang');
		if(empty($thang))
		{
			//$thang = date("Y");
			$thang = '2011';
		}
		$kddept = $this->data['kddept'];
		$kdunit = $this->data['kdunit'];
		$kdprogram = $this->data['kdprogram'];
		
		$this->data['penyerapans'] = $this->mdja->get_penyerapan($thang,$kddept,$kdunit,$kdprogram)->result();
		$this->data['template'] = 'kementrian/penyerapan';  
		$this->load->view('index', $this->data);
	}
	
	/*---------------------Konsistensi antara Perencanaan dan Implementasi ----------------------*/
	function konsistensi()
	{
		$this->data['title'] = 'Konsistensi Antara Perencanaan dan Implementasi';
		$this->data['pengukuran'] = 'konsistensi';
		$this->data['unit'] = get_eselon($this->data['kddept']);
        if(empty($thang))
        {
            $thang = '2011';
        }
		$this->data['thang'] = $thang;
        $this->data['kdunit'] = null;
        $this->data['kdprogram'] = null; 
		$this->data['kdsatker'] = null;		
        
		if(isset($_POST['thang']) && $_POST['thang'] != 0)
        {
			$this->data['thang'] = $_POST['thang'];
		}
        if(isset($_POST['kdunit']) && $_POST['kdunit'] != 0)
        {
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
        }
        if((isset($_POST['kdunit']) && $_POST['kdunit'] != 0) && (isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0))
        {
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['kdprogram'] = $_POST['kdprogram'];
			$this->data['satker'] = get_satker($this->data['kddept'], $this->data['kdunit']);
        }
		if((isset($_POST['kdunit']) && $_POST['kdunit'] != 0) && (isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0) && (isset($_POST['kdsatker']) && $_POST['kdsatker'] != 0))
        {
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['kdprogram'] = $_POST['kdprogram'];
			$this->data['kdsatker'] = $_POST['kdsatker'];
		}
		
		$this->data['konsistensi'] = get_report_konsistensi($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
        $this->data['template'] = 'kementrian/konsistensi';
        $this->load->view('index', $this->data);
	}
	
	/*------------------------------------------- Pengukuran Volume Keluaran ----------------------*/
	public function keluaran()
	{
	    $this->data['title'] = 'Tingkat Pencapaian Keluaran';
        $this->data['unit'] = get_eselon($this->data['kddept']);
        if(empty($thang))
        {
            $thang = '2011';
        }
		$this->data['thang'] = $thang;
        $this->data['kdunit'] = null;
        $this->data['kdprogram'] = null;
		$this->data['kdsatker'] = null; 		
		$this->data['kdgiat'] = null; 		
        
        if(isset($_POST['thang']) && $_POST['thang'] != 0)
        {
			$this->data['thang'] = $_POST['thang'];
		}
        if((isset($_POST['kdunit']) && $_POST['kdunit'] != 0))
        {
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
        }
        if((isset($_POST['kdunit']) && $_POST['kdunit'] != 0) && (isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0))
        {
            $this->data['kdunit'] = $_POST['kdunit'];
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
		$config['base_url'] 	= base_url().'kementrian/keluaran/';
		$config['total_rows'] 	= count($this->mdja->get_volume_keluaran($thang, $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'], $this->data['kdsatker'], $this->data['kdgiat']));
		$config['per_page'] 	= 15; 
		$config['cur_page'] 	= $this->data['halaman'];
		$this->pagination->initialize($config);
		$this->data['page'] 	= $this->pagination->create_links();
		$this->data['output'] = $this->mdja->get_volume_keluaran($thang, $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'], $this->data['kdsatker'], $this->data['kdgiat'], $config['per_page'],$config['cur_page']);
		
        $this->data['template'] = 'kementrian/keluaran';                 
        $this->load->view('index', $this->data);
	}
	
	/*------------------------------------------- Pengukuran Efisiensi ----------------------*/
	public function efisiensi()
	{
	    $this->data['title'] = 'Pengukuran Efisiensi';    
        $this->data['unit'] = get_eselon($this->data['kddept']);
        if(empty($thang))
        {
            $thang = '2011';
        }
		$this->data['thang'] = $thang;
        $this->data['kdunit'] = null;
        $this->data['kdprogram'] = null;                
        
        if(isset($_POST['thang']) && $_POST['thang'] != 0)
        {
			$this->data['thang'] = $_POST['thang'];
		}
        if((isset($_POST['kdunit']) && $_POST['kdunit'] != 0))
        {
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
        }
        if((isset($_POST['kdunit']) && $_POST['kdunit'] != 0) && (isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0))
        {
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['kdprogram'] = $_POST['kdprogram'];            
        }
        
		//get volume keluaran
		
		$this->data['output'] = $this->mdja->get_volume_keluaran($thang, $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'],null,0);
		
        $this->data['template'] = 'kementrian/efisiensi';    
        $this->load->view('index', $this->data);
	}
	
	/*-------------------------------------------- MONITORING ---------------------------------------------*/
	/*------------------------------------------- Penyerapan Anggaran -------------------------------------*/
	public function mpenyerapan()
    {
        $this->data['title'] = 'Monitoring Penyerapan Anggaran';
        $this->data['kdunit'] = null;
        $this->data['kdprogram'] = null;    
		$this->data['unit'] = get_eselon($this->data['kddept']);
        
        if((isset($_POST['kdunit']) && $_POST['kdunit'] != 0))
        {
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
        }
        if((isset($_POST['kdunit']) && $_POST['kdunit'] != 0) && (isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0))
        {
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['kdprogram'] = $_POST['kdprogram'];
        }
        
		if(isset($_POST['thang']) && $_POST['thang']!=''){ 
			$this->data['thang'] = $_POST['thang']; 
		}
		
		$this->data['penyerapan'] = $this->mdja->get_penyerapan($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'])->row();
        $this->data['template'] = 'kementrian/mpenyerapan';  
        $this->load->view('index', $this->data);
    }
	
	/*---------------------- Konsistensi antara Perencanaan dan Implementasi ------------------------------*/
    public function mkonsistensi()
    {
        $this->data['title'] = 'Konsistensi Antara Perencanaan dan Implementasi';
        $this->data['pengukuran'] = 'konsistensi';
		$this->data['bulan_awal'] = null;
		$this->data['bulan_akhir'] = null;
		$this->data['unit'] = get_eselon($this->data['kddept']);
        
		if(isset($_POST['thang']) && $_POST['thang'] != 0)
        {
			$this->data['thang'] = $_POST['thang'];
		}
        if((isset($_POST['kdunit']) && $_POST['kdunit'] != 0))
        {
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
        }
        if((isset($_POST['kdunit']) && $_POST['kdunit'] != 0) && (isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0))
        {
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['kdprogram'] = $_POST['kdprogram'];
			$this->data['satker'] = get_satker($this->data['kddept'], $this->data['kdunit']);
        }
		if((isset($_POST['kdunit']) && $_POST['kdunit'] != 0) && (isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0) && (isset($_POST['kdsatker']) && $_POST['kdsatker'] != 0))
        {
            $this->data['kdunit'] = $_POST['kdunit'];
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
                
        $this->data['template'] = 'kementrian/mkonsistensi';            
        
        $this->load->view('index', $this->data);
    }
	
	/*-------------------------------- Pengukuran Volume Keluaran -----------------------------------------*/
    public function mkeluaran()
    {
		$this->data['title'] = 'Monitoring Tingkat Pencapaian Keluaran';
		$this->data['unit'] = get_eselon($this->data['kddept']);
		if(isset($_POST['thang']) && $_POST['thang']!=''){ 
			$this->data['thang'] = $_POST['thang']; 
		}		
				
        if((isset($_POST['kdunit']) && $_POST['kdunit'] != 0))
        {
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
        }
        if((isset($_POST['kdunit']) && $_POST['kdunit'] != 0) && (isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0))
        {
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['kdprogram'] = $_POST['kdprogram'];    
			$this->data['giat'] = get_giat($this->data['thang'], $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram']);
        }
		if((isset($_POST['kdunit']) && $_POST['kdunit'] != 0) && (isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0) && (isset($_POST['kdgiat']) && $_POST['kdgiat'] != 0))
        {
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['kdprogram'] = $_POST['kdprogram'];    
			$this->data['kdgiat'] = $_POST['kdgiat'];
        }
		if(!isset($this->data['kdgiat'])):
			$this->load->library('pagination');
			$this->data['halaman']	= abs((int)$this->uri->segment(3));
			$config['base_url'] 	= base_url().'kementrian/mkeluaran/';
			$config['total_rows'] 	= count($this->mdja->get_volume_keluaran($this->data['thang'], $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'], $this->data['kdsatker'], $this->data['kdgiat']));
			$config['per_page'] 	= 15; 
			$config['cur_page'] 	= $this->data['halaman'];
			$this->pagination->initialize($config);
			$this->data['page'] 	= $this->pagination->create_links();
			$this->data['output'] 	= $this->mdja->get_volume_keluaran($this->data['thang'], $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'], $this->data['kdsatker'], $this->data['kdgiat'], $config['per_page'],$config['cur_page']);
		else:
			$this->data['output'] 	= $this->mdja->get_volume_keluaran($this->data['thang'], $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'], $this->data['kdsatker'], $this->data['kdgiat']);
		endif;
        $this->data['template'] = 'kementrian/mkeluaran';                 
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
	/*---------------------------------------- OUTCOME ---------------------------------------*/
	function unit_outcome()
	{
		$this->data['title'] = 'Pengesahan Outcome';
		$dept = $this->mkementrian->get_dept_identity($this->kddept);
		$this->data['nmdept'] = $dept['nmdept'];
		$this->data['unit'] = $this->mkementrian->get_unit_iku($this->kddept);
		$this->data['title'] = 'Kementrian / Lembaga';
		$this->data['template'] = 'kementrian/unit_outcome';
		$this->load->view('index', $this->data);
	}
	
	function outcome()
	{
		$this->data['title'] = 'Pengesahan Outcome';
		$this->data['kdunit'] = $this->input->post('kdunit');		
		$this->data['kddept'] = $this->kddept;
		$this->data['unit_identity'] = $this->meselon->get_unit_identity($this->data['kddept'], $this->data['kdunit']);		
                $this->data['nmunit'] = $this->data['unit_identity']['nmunit'];
                $this->data['nmdept'] = $this->data['unit_identity']['nmdept'];
		
		//fungsi untuk menampilkan daftar program		
		$this->data['program'] = $this->mkementrian->get_unit_iku($this->data['kddept']);
		$this->data['kdprogram'] = 0;
		
		if(isset($_POST['program']))
		{			
			$this->data['kdunit'] = 11;
			$this->data['kdprogram'] = $this->input->post('program');
			$this->data['outcome'] = $this->mkementrian->get_iku($this->data['kddept'],$this->data['kdunit'], $this->data['kdprogram']);
		}		
		
		$this->data['template'] = 'kementrian/outcome';
		$this->load->view('index', $this->data);
	}
	
	public function do_outcome_approval()
	{		
		$this->mkementrian->set_real_iku();
				
		$kdunit = $this->input->post('kdunit');
		$kddept = $this->kddept;
		$this->data['unit_identity'] = $this->meselon->get_unit_identity($kddept, $kdunit);		
                $this->data['nmunit'] = $this->data['unit_identity']['nmunit'];
                $this->data['nmdept'] = $this->data['unit_identity']['nmdept'];		

		$this->data['message'] = "Data realisasi outcome yang sah telah dieskalasi ke DJA. <br>".
					 "Data realisasi outcome yang tidak sah telah dikembalikan ke Satuan Kerja untuk diperiksa ulang";
		$this->data['template'] = 'kementrian/realisasi_status';
		$this->load->view('index', $this->data);
	}
	
	/*---------------------------------------- OUTPUT ---------------------------------------*/
	function kegiatan()
	{
	    //this part loads get_unit_program content according to unit's id 
	    $this->data['program'] = $this->mkementrian->get_unit_program($this->session->userdata('kddept'),$this->session->userdata('kdunit'));
	    if($this->data['program']):
		$this->data['nmprogram'] = $this->data['program'][0]['nmprogram'];
		$this->data['kdprogram'] = $this->data['program'][0]['kdprogram'];
		$this->data['kegiatan'] = $this->mkementrian->get_unit_kegiatan($this->session->userdata('kddept'),$this->session->userdata('kdunit'), $this->data['kdprogram']);
	    endif;
	    //this part loads kegiatan
	    
	    $this->data['template'] = 'kementrian/kegiatan';
	    $this->load->view('index',$this->data);
	}
	
	function detail_giat($kdgiat)
	{
	    //this part loads get_unit_program content according to unit's id 
	    $this->data['program'] = $this->mkementrian->get_unit_program($this->session->userdata('kddept'),$this->session->userdata('kdunit'));
	    $this->data['nmprogram'] = $this->data['program'][0]['nmprogram'];
	    $this->data['kdprogram'] = $this->data['program'][0]['kdprogram'];
	    
	    //this part loads kegiatan
	    $this->data['kegiatan'] = $this->mkementrian->get_unit_kegiatan($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'),$this->data['kdprogram']);
	    $this->data['kdgiat'] = $kdgiat;
	    $detail_giat = $this->msatker->get_detail_giat($kdgiat);
	    $this->data['nmgiat'] = $detail_giat['nmgiat'];
    
	    //this part loads output
	    $this->data['output'] = $this->mkementrian->get_output($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'),$this->data['kdprogram'],$kdgiat);
	    
	    $this->data['ikk'] = $this->mkementrian->get_ikk($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'),$this->data['kdprogram'],$kdgiat);
	    
	    $this->data['template'] = 'kementrian/detail_giat';
	    $this->load->view('index',$this->data);
	}
	
	function unit_output()
	{
		$this->data['title'] = 'Pengesahan Output';
		$dept = $this->mkementrian->get_dept_identity($this->kddept);
		$this->data['nmdept'] = $dept['nmdept'];
		$this->data['unit'] = $this->mkementrian->get_unit_output($this->kddept);
		$this->data['title'] = 'Kementrian / Lembaga';
		$this->data['template'] = 'kementrian/unit_output';
		$this->load->view('index', $this->data);
	}
	
	public function output()
        {
		$this->data['title'] = 'Pengesahan Output';
		$this->data['kdunit'] = $this->input->post('kdunit');		
		$this->data['kddept'] = $this->kddept;
		$this->data['unit_identity'] = $this->meselon->get_unit_identity($this->data['kddept'], $this->data['kdunit']);		
                $this->data['nmunit'] = $this->data['unit_identity']['nmunit'];
                $this->data['nmdept'] = $this->data['unit_identity']['nmdept'];	
		
		//fungsi untuk menampilkan daftar program		
		$this->data['program'] = $this->mkementrian->get_unit_program_output($this->data['kddept']);		
		$this->data['kdprogram'] = 0;
		$this->data['kdgiat'] = 0;
		$this->data['kdsatker'] = 0;
		
		if(isset($_POST['program']))
		{			
			$this->data['kdprogram'] = $this->input->post('program');
			$this->data['kegiatan'] = $this->mkementrian->get_unit_kegiatan_output($this->data['kddept'],$this->data['kdunit'], $this->data['kdprogram']);
			$this->data['kdsatker'] = $this->data['kegiatan'][0]['kdsatker'];
		}
		
		if(isset($_POST['kegiatan']))
		{			
			$this->data['kdgiat'] = $this->input->post('kegiatan');			
			$this->data['output'] = $this->mkementrian->get_output($this->data['kddept'],$this->data['kdunit'], $this->data['kdsatker'], $this->data['kdprogram'], $this->data['kdgiat']);
		}
		
		$this->data['template'] = 'kementrian/output';
		$this->load->view('index', $this->data);
        }
               
	public function do_output_approval()
	{
		$kdgiat = $this->input->post('kdgiat');
		$do = $this->input->post('submit');
		$this->mkementrian->set_real_output_approval();		

		$message = "Data realisasi keluaran yang sah telah dieskalasi ke DJA. <br>".
					"Data realisasi keluaran yang tidak sah telah dikembalikan ke Satuan Kerja untuk diperiksa ulang";
		$this->session->set_flashdata('message', $message);
		redirect('kementrian/detail_giat/'.$kdgiat);
	}
	
	/*---------------------------------------- IKK ---------------------------------------*/
    function unit_ikk()
	{
		$this->data['title'] = 'Pengesahan IKK';
		$dept = $this->mkementrian->get_dept_identity($this->kddept);
		$this->data['nmdept'] = $dept['nmdept'];
		$this->data['unit'] = $this->mkementrian->get_unit_output($this->kddept);
		$this->data['title'] = 'Kementrian / Lembaga';
		$this->data['template'] = 'kementrian/unit_ikk';
		$this->load->view('index', $this->data);
	}
	
	public function ikk()
        {
		$this->data['title'] = 'Pengesahan IKK';
		$this->data['kdunit'] = $this->input->post('kdunit');		
		$this->data['kddept'] = $this->kddept;
		$this->data['unit_identity'] = $this->meselon->get_unit_identity($this->data['kddept'], $this->data['kdunit']);		
                $this->data['nmunit'] = $this->data['unit_identity']['nmunit'];
                $this->data['nmdept'] = $this->data['unit_identity']['nmdept'];	
		
		//fungsi untuk menampilkan daftar program		
		$this->data['program'] = $this->mkementrian->get_unit_program_ikk($this->data['kddept']);		
		$this->data['kdprogram'] = 0;
		$this->data['kdgiat'] = 0;
		$this->data['kdsatker'] = 0;
		
		if(isset($_POST['program']))
		{			
			$this->data['kdprogram'] = $this->input->post('program');
			$this->data['kegiatan'] = $this->mkementrian->get_unit_kegiatan_ikk($this->data['kddept'],$this->data['kdunit'], $this->data['kdprogram']);
			$this->data['kdsatker'] = $this->data['kegiatan'][0]['kdsatker'];
		}
		
		if(isset($_POST['kegiatan']))
		{			
			$this->data['kdgiat'] = $this->input->post('kegiatan');			
			$this->data['ikk'] = $this->mkementrian->get_ikk($this->data['kddept'],$this->data['kdunit'], $this->data['kdsatker'], $this->data['kdprogram'], $this->data['kdgiat']);
		}
		
		$this->data['template'] = 'kementrian/ikk';
		$this->load->view('index', $this->data);
        }
               
	public function do_ikk_approval()
	{
		$do = $this->input->post('submit');
		$this->mkementrian->set_real_ikk_approval();
				
		$kdsatker = $this->input->post('kdsatker');
		$this->data['satker_identity'] = $this->msatker->get_satker_identity($kdsatker);
		$this->data['nmsatker'] = $this->data['satker_identity']['nmsatker'];
		$this->data['nmunit'] = $this->data['satker_identity']['nmunit'];
		$this->data['nmdept'] = $this->data['satker_identity']['nmdept'];		

		$this->data['message'] = "Data realisasi IKK yang sah telah dieskalasi ke DJA. <br>".
					"Data realisasi IKK yang tidak sah telah dikembalikan ke Satuan Kerja untuk diperiksa ulang";
		$this->data['template'] = 'kementrian/realisasi_status';
		$this->load->view('index', $this->data);
	}
	
	/*---------------------------------------- Efisien ---------------------------------------*/
    function unit_efisien()
	{
		$this->data['title'] = 'Pengesahan EFisiensi';
		$dept = $this->mkementrian->get_dept_identity($this->kddept);
		$this->data['nmdept'] = $dept['nmdept'];
		$this->data['unit'] = $this->mkementrian->get_unit_output($this->kddept);
		$this->data['title'] = 'Kementrian / Lembaga';
		$this->data['template'] = 'kementrian/unit_efisien';
		$this->load->view('index', $this->data);
	}
	
	public function efisien()
        {
		$this->data['title'] = 'Pengesahan Output';
		$this->data['kdunit'] = $this->input->post('kdunit');		
		$this->data['kddept'] = $this->kddept;
		$this->data['unit_identity'] = $this->meselon->get_unit_identity($this->data['kddept'], $this->data['kdunit']);		
                $this->data['nmunit'] = $this->data['unit_identity']['nmunit'];
                $this->data['nmdept'] = $this->data['unit_identity']['nmdept'];	
		
		//fungsi untuk menampilkan daftar program		
		$this->data['program'] = $this->mkementrian->get_unit_program_efisien($this->data['kddept']);		
		$this->data['kdprogram'] = 0;
		$this->data['kdgiat'] = 0;
		$this->data['kdsatker'] = 0;
		
		if(isset($_POST['program']))
		{			
			$this->data['kdprogram'] = $this->input->post('program');
			$this->data['kegiatan'] = $this->mkementrian->get_unit_kegiatan_efisien($this->data['kddept'],$this->data['kdunit'], $this->data['kdprogram']);
			$this->data['kdsatker'] = $this->data['kegiatan'][0]['kdsatker'];
		}
		
		if(isset($_POST['kegiatan']))
		{			
			$this->data['kdgiat'] = $this->input->post('kegiatan');			
			$this->data['efisien'] = $this->mkementrian->get_efisien($this->data['kddept'],$this->data['kdunit'], $this->data['kdsatker'], $this->data['kdprogram'], $this->data['kdgiat']);
		}
		
		$this->data['template'] = 'kementrian/efisien';
		$this->load->view('index', $this->data);
        }
               
	public function do_efisien_approval()
	{
		$do = $this->input->post('submit');
		$this->mkementrian->set_real_efisien_approval();
				
		$kdsatker = $this->input->post('kdsatker');
		$this->data['satker_identity'] = $this->msatker->get_satker_identity($kdsatker);
		$this->data['nmsatker'] = $this->data['satker_identity']['nmsatker'];
		$this->data['nmunit'] = $this->data['satker_identity']['nmunit'];
		$this->data['nmdept'] = $this->data['satker_identity']['nmdept'];		

		$this->data['message'] = "Data efisiensi keluaran yang sah telah dieskalasi ke DJA. <br>".
					"Data efisiensi keluaran yang tidak sah telah dikembalikan ke Satuan Kerja untuk diperiksa ulang";
		$this->data['template'] = 'kementrian/realisasi_status';
		$this->load->view('index', $this->data);
	}
	
	/*-------------------------------- Catatan K/L ---------------------------------*/
	function catatan()
	{
	    // untuk menulis catatan dari K/L ke DJA terkait proses input, kendala, dan lain-lain
	    $this->data['title'] = 'Catatan Penting';
	    $this->data['unit'] = get_eselon($this->data['kddept']);
        $this->data['kdunit'] = null;
        $this->data['kdprogram'] = null;
		$this->data['thang'] = '2011';
		
		if(isset($_POST['thang']) && $_POST['thang'] != 0):
			$this->data['thang'] = $_POST['thang'];
		endif;
		
		if(isset($_POST['kdunit']) && $_POST['kdunit'] != 0):
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
        endif;
		
		if((isset($_POST['kdunit']) && $_POST['kdunit'] != 0) && (isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0)):
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['kdprogram'] = $_POST['kdprogram'];
        endif;
		
		$this->data['penyerapan'] = get_penyerapan($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram']);
		$this->data['konsistensi'] = get_konsistensi($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		$this->data['keluaran'] = get_keluaran($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		$this->data['efisiensi'] = get_efisiensi($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		
	    $this->data['template'] = 'kementrian/catatan';
	    $this->load->view('index',$this->data);
	}
	
	function history_catatan()
	{
	    // untuk menulis catatan dari K/L ke DJA terkait proses input, kendala, dan lain-lain
	    $this->data['title'] = 'Rekaman Catatan';
	    $this->data['subtitle'] = 'Catatan ini untuk disampaikan kepada DJA perihal capaian kinerja, kendala, dan lain-lain.';
	    $this->data['catatan'] = $this->mkementrian->get_catatan();
	    $this->data['template'] = 'kementrian/history_catatan';
	    $this->load->view('index',$this->data);
	}
	
	public function do_catatan()
	{		
	    $do = $this->input->post('submit');
	    $this->mkementrian->set_catatan($do);
    
	    if ($do == 'Simpan') {
		$message = "Catatan Anda telah direkam untuk diteruskan ke DJA";
	    }
	    
	    $this->session->set_flashdata('message', $message);
	    redirect('kementrian/catatan/');	
	}
	
	function catatan_eselon()
	{
	    // untuk melihat catatan dari eselon I terkait proses input, kendala, dan lain-lain
	    $this->data['title'] = 'Rekaman Catatan Eselon I';
	    $this->data['subtitle'] = 'Catatan ini dari Eselon I perihal capaian kinerja, kendala, dan lain-lain.';
	    $this->data['catatan'] = $this->mkementrian->get_catatan_eselon();
	    $this->data['template'] = 'kementrian/history_catatan_eselon';
	    $this->load->view('index',$this->data);
	}
}