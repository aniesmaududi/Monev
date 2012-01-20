<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dja extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
		is_login();
        $this->data['now'] = date("Y-m-d H:i:s");
        $this->data['title'] = '';
        //get user DJA model
        $this->load->model('mdja');
		$this->data['thang'] = '2011';
    }
    
    function index()
    {
		$this->data['title'] = 'Dashboard DJA';
		$this->data['dept'] = get_departemen();
        $this->data['kddept'] = null;
        $this->data['kdunit'] = null;
        $this->data['kdprogram'] = null;
		$this->data['kdsatker'] = null;
		$this->data['thang'] = '2011';
		if(isset($_POST['thang']) && $_POST['thang'] != 0):
			$this->data['thang'] = $_POST['thang'];
		endif;
		
		if(isset($_POST['kddept']) && $_POST['kddept'] != 0):
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['unit'] = get_eselon($this->data['kddept']);
        endif;
		
		if((isset($_POST['kddept']) && $_POST['kddept'] != 0) && (isset($_POST['kdunit']) && $_POST['kdunit'] != 0)):
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
        endif;
		
        if((isset($_POST['kddept']) && $_POST['kddept'] != 0) && (isset($_POST['kdunit']) && $_POST['kdunit'] != 0) && (isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0)):
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['kdprogram'] = $_POST['kdprogram'];
        endif;
		
		$this->data['penyerapan'] = get_penyerapan($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		$this->data['konsistensi'] = get_konsistensi($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		$this->data['keluaran'] = get_keluaran($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		$this->data['efisiensi'] = get_efisiensi($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		
        $this->data['template'] = 'dja/index';
        $this->load->view('index', $this->data);
    }
    
	/*------------------------------------------- LAPORAN -------------------------------------------------*/
    /*------------------------------------------- Penyerapan Anggaran -------------------------------------*/
    public function penyerapan()
    {
        $this->data['title'] = 'Pengukuran Penyerapan Anggaran';        
        $this->data['dept'] = $this->mdja->get_dept();
        $this->data['kddept'] = null;
        $this->data['kdunit'] = null;
        $this->data['kdprogram'] = null;    
        
        if(isset($_POST['kddept']) && $_POST['kddept'] != 0)
        {
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['unit'] = get_eselon($this->data['kddept']);
        }
        if((isset($_POST['kddept']) && $_POST['kddept'] != 0) && (isset($_POST['kdunit']) && $_POST['kdunit'] != 0))
        {
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
        }
        if((isset($_POST['kddept']) && $_POST['kddept'] != 0) && (isset($_POST['kdunit']) && $_POST['kdunit'] != 0) && (isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0))
        {
            $this->data['kddept'] = $_POST['kddept'];
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
        $this->data['template'] = 'dja/penyerapan';  
        $this->load->view('index', $this->data);
    }
    
    /*---------------------- Konsistensi antara Perencanaan dan Implementasi ------------------------------*/
    public function konsistensi()
    {
        $this->data['title'] = 'Konsistensi Antara Perencanaan dan Implementasi';
        $this->data['pengukuran'] = 'konsistensi';
        $this->data['dept'] = $this->mdja->get_dept();
        if(empty($thang))
        {
            $thang = '2011';
        }
		$this->data['thang'] = $thang;
        $this->data['kddept'] = null;
        $this->data['kdunit'] = null;
        $this->data['kdprogram'] = null; 
		$this->data['kdsatker'] = null;		
        
		if(isset($_POST['thang']) && $_POST['thang'] != 0)
        {
			$this->data['thang'] = $_POST['thang'];
		}
		if(isset($_POST['kddept']) && $_POST['kddept'] != 0)
        {
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['unit'] = $this->mdja->get_unit($this->data['kddept']);
        }
        if((isset($_POST['kddept']) && $_POST['kddept'] != 0) && (isset($_POST['kdunit']) && $_POST['kdunit'] != 0))
        {
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['program'] = $this->mdja->get_program($this->data['kddept'], $this->data['kdunit']);
        }
        if((isset($_POST['kddept']) && $_POST['kddept'] != 0) && (isset($_POST['kdunit']) && $_POST['kdunit'] != 0) && (isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0))
        {
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['kdprogram'] = $_POST['kdprogram'];
			$this->data['satker'] = $this->mdja->get_satker($this->data['kddept'], $this->data['kdunit']);
        }
		if((isset($_POST['kddept']) && $_POST['kddept'] != 0) && (isset($_POST['kdunit']) && $_POST['kdunit'] != 0) && (isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0) && (isset($_POST['kdsatker']) && $_POST['kdsatker'] != 0))
        {
			$this->data['kddept'] = $_POST['kddept'];
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['kdprogram'] = $_POST['kdprogram'];
			$this->data['kdsatker'] = $_POST['kdsatker'];
		}
		
		
		$this->data['konsistensi'] = $this->mdja->get_report_konsistensi($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
                
        $this->data['template'] = 'dja/konsistensi';            
        
        $this->load->view('index', $this->data);
    }
    
    /*-------------------------------- Pengukuran Volume Keluaran -----------------------------------------*/
    public function keluaran()
    {
		$this->data['title'] = 'Tingkat Pencapaian Keluaran';
        $this->data['dept'] = $this->mdja->get_dept();
        if(empty($thang))
        {
            $thang = '2011';
        }
		
		$this->data['thang'] = $thang;
        $this->data['kddept'] = null;
        $this->data['kdunit'] = null;
        $this->data['kdprogram'] = null;
		$this->data['kdsatker'] = null; 		
		$this->data['kdgiat'] = null; 		
        
        if(isset($_POST['kddept']) && $_POST['kddept'] != 0)
        {
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['unit'] = $this->mdja->get_unit($this->data['kddept']);
        }
        if((isset($_POST['kddept']) && $_POST['kddept'] != 0) && (isset($_POST['kdunit']) && $_POST['kdunit'] != 0))
        {
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['program'] = $this->mdja->get_program($this->data['kddept'], $this->data['kdunit']);
        }
        if((isset($_POST['kddept']) && $_POST['kddept'] != 0) && (isset($_POST['kdunit']) && $_POST['kdunit'] != 0) && (isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0))
        {
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['kdprogram'] = $_POST['kdprogram'];    
			$this->data['giat'] = $this->mdja->get_giat($thang, $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram']);
        }
		if((isset($_POST['kddept']) && $_POST['kddept'] != 0) && (isset($_POST['kdunit']) && $_POST['kdunit'] != 0) && (isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0) && (isset($_POST['kdgiat']) && $_POST['kdgiat'] != 0))
        {
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['kdprogram'] = $_POST['kdprogram'];    
			$this->data['kdgiat'] = $_POST['kdgiat'];
        }
		
		$this->load->library('pagination');
		$this->data['halaman']	= abs((int)$this->uri->segment(3));
		$config['base_url'] 	= base_url().'dja/keluaran/';
		$config['total_rows'] 	= count($this->mdja->get_volume_keluaran($thang, $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'], $this->data['kdsatker'], $this->data['kdgiat']));
		$config['per_page'] 	= 15; 
		$config['cur_page'] 	= $this->data['halaman'];
		$this->pagination->initialize($config);
		$this->data['page'] 	= $this->pagination->create_links();
		$this->data['output'] = $this->mdja->get_volume_keluaran($thang, $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'], $this->data['kdsatker'], $this->data['kdgiat'], $config['per_page'],$config['cur_page']);
		
        $this->data['template'] = 'dja/keluaran';                 
        $this->load->view('index', $this->data);
    }
    
    /*-------------------------------------- Pengukuran Efisiensi -----------------------------------------*/
    public function efisiensi()
    {
        $this->data['title'] = 'Pengukuran Efisiensi';    
        $this->data['dept'] = $this->mdja->get_dept();
        if(empty($thang))
        {
            $thang = '2011';
        }
		$this->data['thang'] = $thang;
        $this->data['kddept'] = null;
        $this->data['kdunit'] = null;
        $this->data['kdprogram'] = null;                
        
        if(isset($_POST['kddept']) && $_POST['kddept'] != 0)
        {
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['unit'] = $this->mdja->get_unit($this->data['kddept']);
        }
        if((isset($_POST['kddept']) && $_POST['kddept'] != 0) && (isset($_POST['kdunit']) && $_POST['kdunit'] != 0))
        {
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['program'] = $this->mdja->get_program($this->data['kddept'], $this->data['kdunit']);
        }
        if((isset($_POST['kddept']) && $_POST['kddept'] != 0) && (isset($_POST['kdunit']) && $_POST['kdunit'] != 0) && (isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0))
        {
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['kdprogram'] = $_POST['kdprogram'];            
        }
        
		//get volume keluaran
		$this->data['output'] = $this->mdja->get_volume_keluaran($thang, $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'],null,0); 
        
        $this->data['template'] = 'dja/efisiensi';    
        $this->load->view('index', $this->data);
    }
	
	/*-------------------------------------------- MONITORING ---------------------------------------------*/
	/*------------------------------------------- Penyerapan Anggaran -------------------------------------*/
	public function mpenyerapan()
    {
        $this->data['title'] = 'Monitoring Penyerapan Anggaran';        
        $this->data['dept'] = $this->mdja->get_dept();
        $this->data['kddept'] = null;
        $this->data['kdunit'] = null;
        $this->data['kdprogram'] = null;    
        
        if(isset($_POST['kddept']) && $_POST['kddept'] != 0)
        {
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['unit'] = get_eselon($this->data['kddept']);
        }
        if((isset($_POST['kddept']) && $_POST['kddept'] != 0) && (isset($_POST['kdunit']) && $_POST['kdunit'] != 0))
        {
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
        }
        if((isset($_POST['kddept']) && $_POST['kddept'] != 0) && (isset($_POST['kdunit']) && $_POST['kdunit'] != 0) && (isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0))
        {
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['kdprogram'] = $_POST['kdprogram'];
        }
        
		if(isset($_POST['thang']) && $_POST['thang']!=''){ 
			$this->data['thang'] = $_POST['thang']; 
		}
		
		$this->data['penyerapan'] = $this->mdja->get_penyerapan($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'])->row();
        $this->data['template'] = 'dja/mpenyerapan';  
        $this->load->view('index', $this->data);
    }
	
	/*---------------------- Konsistensi antara Perencanaan dan Implementasi ------------------------------*/
    public function mkonsistensi()
    {
        $this->data['title'] = 'Konsistensi Antara Perencanaan dan Implementasi';
        $this->data['pengukuran'] = 'konsistensi';
        $this->data['dept'] = $this->mdja->get_dept();
		if(isset($_POST['thang']) && $_POST['thang']!=''){ 
			$this->data['thang'] = $_POST['thang']; 
		}
        $this->data['kddept'] = null;
        $this->data['kdunit'] = null;
        $this->data['kdprogram'] = null; 
		$this->data['kdsatker'] = null;
		$this->data['bulan_awal'] = null;
		$this->data['bulan_akhir'] = null;
        
		if(isset($_POST['thang']) && $_POST['thang'] != 0)
        {
			$this->data['thang'] = $_POST['thang'];
		}
		if(isset($_POST['kddept']) && $_POST['kddept'] != 0)
        {
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['unit'] = $this->mdja->get_unit($this->data['kddept']);
        }
        if((isset($_POST['kddept']) && $_POST['kddept'] != 0) && (isset($_POST['kdunit']) && $_POST['kdunit'] != 0))
        {
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['program'] = $this->mdja->get_program($this->data['kddept'], $this->data['kdunit']);
        }
        if((isset($_POST['kddept']) && $_POST['kddept'] != 0) && (isset($_POST['kdunit']) && $_POST['kdunit'] != 0) && (isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0))
        {
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['kdprogram'] = $_POST['kdprogram'];
			$this->data['satker'] = $this->mdja->get_satker($this->data['kddept'], $this->data['kdunit']);
        }
		if((isset($_POST['kddept']) && $_POST['kddept'] != 0) && (isset($_POST['kdunit']) && $_POST['kdunit'] != 0) && (isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0) && (isset($_POST['kdsatker']) && $_POST['kdsatker'] != 0))
        {
			$this->data['kddept'] = $_POST['kddept'];
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
                
        $this->data['template'] = 'dja/mkonsistensi';            
        
        $this->load->view('index', $this->data);
    }
	
	/*-------------------------------- Pengukuran Volume Keluaran -----------------------------------------*/
    public function mkeluaran()
    {
		$this->data['title'] = 'Monitoring Tingkat Pencapaian Keluaran';
        $this->data['dept'] = $this->mdja->get_dept();
		if(isset($_POST['thang']) && $_POST['thang']!=''){ 
			$this->data['thang'] = $_POST['thang']; 
		}
        $this->data['kddept'] = null;
        $this->data['kdunit'] = null;
        $this->data['kdprogram'] = null;
		$this->data['kdsatker'] = null; 		
		$this->data['kdgiat'] = null; 		
        
        if(isset($_POST['kddept']) && $_POST['kddept'] != 0)
        {
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['unit'] = $this->mdja->get_unit($this->data['kddept']);
        }
        if((isset($_POST['kddept']) && $_POST['kddept'] != 0) && (isset($_POST['kdunit']) && $_POST['kdunit'] != 0))
        {
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['program'] = $this->mdja->get_program($this->data['kddept'], $this->data['kdunit']);
        }
        if((isset($_POST['kddept']) && $_POST['kddept'] != 0) && (isset($_POST['kdunit']) && $_POST['kdunit'] != 0) && (isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0))
        {
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['kdprogram'] = $_POST['kdprogram'];    
			$this->data['giat'] = $this->mdja->get_giat($this->data['thang'], $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram']);
        }
		if((isset($_POST['kddept']) && $_POST['kddept'] != 0) && (isset($_POST['kdunit']) && $_POST['kdunit'] != 0) && (isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0) && (isset($_POST['kdgiat']) && $_POST['kdgiat'] != 0))
        {
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['kdprogram'] = $_POST['kdprogram'];    
			$this->data['kdgiat'] = $_POST['kdgiat'];
        }
		if(!isset($this->data['kdgiat'])):
			$this->load->library('pagination');
			$this->data['halaman']	= abs((int)$this->uri->segment(3));
			$config['base_url'] 	= base_url().'dja/mkeluaran/';
			$config['total_rows'] 	= count($this->mdja->get_volume_keluaran($this->data['thang'], $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'], $this->data['kdsatker'], $this->data['kdgiat']));
			$config['per_page'] 	= 15; 
			$config['cur_page'] 	= $this->data['halaman'];
			$this->pagination->initialize($config);
			$this->data['page'] 	= $this->pagination->create_links();
			$this->data['output'] 	= $this->mdja->get_volume_keluaran($this->data['thang'], $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'], $this->data['kdsatker'], $this->data['kdgiat'], $config['per_page'],$config['cur_page']);
		else:
			$this->data['output'] 	= $this->mdja->get_volume_keluaran($this->data['thang'], $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'], $this->data['kdsatker'], $this->data['kdgiat']);
		endif;
        $this->data['template'] = 'dja/mkeluaran';                 
        $this->load->view('index', $this->data);
    }
	
}