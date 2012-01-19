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
    }
    
    function index()
    {
		$this->data['title'] = 'Dashboard DJA';
		
		$this->data['dept'] = $this->mdja->get_dept();
        $this->data['kddept'] = null;
        $this->data['kdunit'] = null;
        $this->data['kdprogram'] = null;
	
        if(isset($_POST['kddept']) && $_POST['kddept'] != 0):
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['unit'] = $this->mdja->get_unit($this->data['kddept']);
        endif;
		
		if((isset($_POST['kddept']) && $_POST['kddept'] != 0) && (isset($_POST['kdunit']) && $_POST['kdunit'] != 0)):
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['program'] = $this->mdja->get_program($this->data['kddept'], $this->data['kdunit']);
        endif;
		
        if((isset($_POST['kddept']) && $_POST['kddept'] != 0) && (isset($_POST['kdunit']) && $_POST['kdunit'] != 0) && (isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0)):
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['kdprogram'] = $_POST['kdprogram'];
            //$this->data['program'] = $this->mdja->get_program($this->data['kddept'], $this->data['kdunit']);
        endif;
		
		$this->data['penyerapan'] = get_penyerapan($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram']);
		$this->data['konsistensi'] = get_konsistensi($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		$this->data['keluaran'] = get_keluaran($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		$this->data['efisiensi'] = get_efisiensi($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		
        $this->data['template'] = 'dja/index';
        $this->load->view('index', $this->data);
    }
    
    /*------------------------------------------- Penyerapan Anggaran ----------------------*/
    function penyerapan_table()
    {
        $this->data['title'] = 'Pengukuran Penyerapan Anggaran';        
        $this->data['dept'] = $this->mdja->get_dept();
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
            //$this->data['program'] = $this->mdja->get_program($this->data['kddept'], $this->data['kdunit']);
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
    
    /*---------------------Konsistensi antara Perencanaan dan Implementasi ----------------------*/
    function konsistensi_table()
    {
        $this->data['title'] = 'Konsistensi Antara Perencanaan dan Implementasi';
        $this->data['pengukuran'] = 'konsistensi';
        $this->data['dept'] = $this->mdja->get_dept();
        if(empty($thang))
        {
            $thang = '2011';
        }
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
		
		
		$this->data['submitK'] = 1;
		
		$thang = $this->input->post('thang');
		if(empty($thang))
		{
			$thang = '2011';
		}
		$this->data['thang'] = $thang;
		$kddept = $this->data['kddept'];
		$kdunit = $this->data['kdunit'];
		$kdprogram = $this->data['kdprogram'];
		
		if(empty($kddept)){
			$rpd = $this->mdja->get_rpd($thang, null, null, null);
			$this->data['realisasi'] = $this->mdja->get_realisasi_bulanan($thang, null, null, null);
		}
		elseif(isset($kddept) && empty($kdunit))
		{
			$rpd = $this->mdja->get_rpd($thang, $this->data['kddept'], null, null);
			$this->data['realisasi'] = $this->mdja->get_realisasi_bulanan($thang, $this->data['kddept'], null, null);                
		}            
		elseif(isset($kddept) && isset($kdunit) && empty($kdprogram))
		{
			$rpd = $this->mdja->get_rpd($thang, $this->data['kddept'], $this->data['kdunit'], null);
			$this->data['realisasi'] = $this->mdja->get_realisasi_bulanan($thang, $this->data['kddept'], $this->data['kdunit'], null);            
		}            
		elseif(isset($kddept) && isset($kdunit) && isset($kdprogram))
		{
			$rpd = $this->mdja->get_rpd($thang, $kddept, $kdunit, $kdprogram);
			$this->data['realisasi'] = $this->mdja->get_realisasi_bulanan($thang, $kddept, $kdunit, $kdprogram);
		}
		
		if(count($rpd) > 0)
		{ 
			$this->data['jml'] = "jml";                
			$this->data['jml1'] = $rpd['jml01'];
			$this->data['jml2'] = $rpd['jml02'];
			$this->data['jml3'] = $rpd['jml03'];
			$this->data['jml4'] = $rpd['jml04'];
			$this->data['jml5'] = $rpd['jml05'];
			$this->data['jml6'] = $rpd['jml06'];
			$this->data['jml7'] = $rpd['jml07'];
			$this->data['jml8'] = $rpd['jml08'];
			$this->data['jml9'] = $rpd['jml09'];
			$this->data['jml10'] = $rpd['jml10'];
			$this->data['jml11'] = $rpd['jml11'];
			$this->data['jml12'] = $rpd['jml12'];
		} else {
			$this->data['jml'] = 0;   
			$this->data['jml1'] = 0;
			$this->data['jml2'] = 0;
			$this->data['jml3'] = 0;
			$this->data['jml4'] = 0;
			$this->data['jml5'] = 0;
			$this->data['jml6'] = 0;
			$this->data['jml7'] = 0;
			$this->data['jml8'] = 0;
			$this->data['jml9'] = 0;
			$this->data['jml10'] = 0;
			$this->data['jml11'] = 0;
			$this->data['jml12'] = 0;
		}  
                
        $this->data['template'] = 'dja/konsistensi';            
        
        $this->load->view('index', $this->data);
    }
    
    /*-------------------------------- Pengukuran Volume Keluaran -----------------------------------------*/
    public function keluaran_table()
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
        
		
		$this->data['output'] = $this->mdja->get_keluaran($thang, $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'])->result();

		
		$this->data['n'] = count($this->data['output']);
        
        $this->data['template'] = 'dja/keluaran';                 
        $this->load->view('index', $this->data);
    }
    
    /*-------------------------------------- Pengukuran Efisiensi ----------------------------------*/
    public function efisiensi_table()
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
		
		$this->data['output'] = $this->mdja->get_volume_keluaran($thang, $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram']);
		
		
		$this->data['n'] = count($this->data['output']);
        
        
        $this->data['template'] = 'dja/efisiensi';    
        $this->load->view('index', $this->data);
    }
}