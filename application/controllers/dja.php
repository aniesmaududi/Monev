<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dja extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->data['now'] = date("Y-m-d H:i:s");
        $this->data['title'] = '';
        //get user DJA model
        $this->load->model('mdja');        
        $this->data['nav_title'] = 'Monitoring';
        $this->data['nav_menu'] = array(
                                        0 => 'Penyerapan Anggaran',
                                        1 => 'Konsistensi',
                                        2 => 'Pencapaian Hasil Keluaran',
                                        3 => 'Efisiensi',
                                        4 => 'Penilaian Capaian Hasil',
                                        5 => 'Penilaian Aspek Evaluasi',
                                        );
        $this->data['nav_menu_link'] = array(
                                        0 => base_url().'dja/penyerapan_table',
                                        1 => base_url().'dja/konsistensi_table',
                                        2 => base_url().'dja/keluaran_table',
                                        3 => base_url().'dja/efisiensi_table',
                                        4 => base_url().'dja/capaian_hasil',
                                        5 => base_url().'dja/aspek_evaluasi',
                                        );
        
        //keperluan chart
        $this->_kdunit = "11"; // 11
        $this->_kddept = "018"; // 015
        $this->_iskl = FALSE;
    }
    
    function index()
    {
		$this->data['title'] = 'Dashboard DJA';
		$this->data['penyerapan'] = get_penyerapan('2011',null,null,null,true);
		$this->data['konsistensi_all'] = get_konsistensi('2011');
        $this->data['template'] = 'dja/index';
        $this->load->view('index', $this->data);
    }
    
    /*------------------------------------------- Penyerapan Anggaran ----------------------*/
    function penyerapan_table()
    {
        $this->data['title'] = 'Pengukuran Penyerapan Anggaran';        
        $this->data['dept'] = $this->mdja->get_dept();
        $this->data['kddept'] = "";
        $this->data['kdunit'] = "";
        $this->data['kdprogram'] = "";
        
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
        if(isset($_POST['submit-p']))
        {
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['kdprogram'] = $_POST['kdprogram'];            
            $this->data['submitP'] = 1;
            $thang = $this->input->post('thang');
            if(empty($thang))
            {
                //$thang = date("Y");
                $thang = '2011';
            }
            $kddept = $this->data['kddept'];
            $kdunit = $this->data['kdunit'];
            $kdprogram = $this->data['kdprogram'];
            
            //all K/L
            if(empty($kddept)){
                $pagu = $this->mdja->get_pagu_anggaran($thang, null, null, null, true);                
                $this->data['total_pagu'] = $pagu['total'];
                $realisasi = $this->mdja->get_realisasi_anggaran($thang, null, null, null, true);
                $this->data['total_realisasi'] = $realisasi['total'];
            }
            else if(isset($kddept) && empty($kdunit))
            {
                $pagu = $this->mdja->get_pagu_anggaran($thang, $kddept, null, null, false);
                if(count($pagu) > 0){ $this->data['total_pagu'] = $pagu['total']; }
                $realisasi = $this->mdja->get_realisasi_anggaran($thang, $kddept, null, null, false);
                if(count($realisasi) > 0){ $this->data['total_realisasi'] = $realisasi['total']; }
            }
            else if(isset($kddept) && isset($kdunit) && empty($kdprogram))
            {
                $pagu = $this->mdja->get_pagu_anggaran($thang, $kddept, $kdunit, null, false);
                if(count($pagu) > 0){ $this->data['total_pagu'] = $pagu['total']; }
                $this->data['nmprogram'] = "Semua Program";
                $realisasi = $this->mdja->get_realisasi_anggaran($thang, $kddept, $kdunit, null, false);
                if(count($realisasi) > 0){ $this->data['total_realisasi'] = $realisasi['total']; }
            }
            else if(isset($kddept) && isset($kdunit) && isset($kdprogram))
            {
                $pagu = $this->mdja->get_pagu_anggaran($thang, $kddept, $kdunit, $kdprogram, false);
                if(count($pagu) > 0){ $this->data['total_pagu'] = $pagu['total']; $this->data['nmprogram'] = $pagu['nmprogram'];}                
                $realisasi = $this->mdja->get_realisasi_anggaran($thang, $kddept, $kdunit, $kdprogram, false);
                if(count($realisasi) > 0){ $this->data['total_realisasi'] = $realisasi['total']; }
            }
            
            //Chart Penyerapan
            $this->load->helper(array('url','fusioncharts'));
		
            // --------- PIE K/L --------- //
            $graph_swfFile_PieKL	= base_url().'public/charts/Pie2D.swf' ;
            //$graph_caption_PieKL	= 'Penyerapan Anggaran '.$this->data['nmdept'].' Tahun Anggaran '.$thangVal;
            $graph_caption_PieKL	= '';
            $graph_numberPrefix_PieKL	= '';
            $graph_numberSuffix_PieKL	= '%';
            $graph_title_PKL		= 'Penyerapan Anggaran' ;
            $graph_width_PKL		= 450 ;
            $graph_height_PKL		= 250 ;
                        
            $P = round(($this->data['total_realisasi']/$this->data['total_pagu'])*100,2);
            $this->data['P'] = $P;
            $this->data['notP'] = 100 - $this->data['P'];
            // Store Name of months
            $arrData_P[0][1] = "Anggaran terserap";
            $arrData_P[1][1] = "Anggaran belum terserap";        
     
            //Store P data
            $arrData_P[0][2] = $this->data['P'];
            $arrData_P[1][2] = $this->data['notP'];        
    
            $strXML_P = "<graph caption='".$graph_caption_PieKL."' numberSuffix='".$graph_numberSuffix_PieKL."' formatNumberScale='0' decimalPrecision='0'>";
    
            foreach ($arrData_P as $arSubData) {
                $strXML_P .= "<set name='" . $arSubData[1] . "' value='" . $arSubData[2] . "' color='".getFCColor()."' />";
            }
            $strXML_P .= "</graph>";
                    
            $this->data['graph_P']  = renderChart($graph_swfFile_PieKL, $graph_title_PKL, $strXML_P, "PIEPKL" , $graph_width_PKL, $graph_height_PKL);            
            
        }
        
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
            //$thang = date("Y");
            $thang = '2011';
        }
        $this->data['kddept'] = "";
        $this->data['kdunit'] = "";
        $this->data['kdprogram'] = "";                
        
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
        
        if(isset($_POST['submit-k']))
        {
            $thang = $this->input->post('thang');
            if(empty($thang))
            {
                //$thang = date("Y");
                $thang = '2011';
            }
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['kdprogram'] = $_POST['kdprogram'];            
            $this->data['submitK'] = 1;
            
            if(isset($this->data['kddept']) && empty($this->data['kdunit']))
            {
                $rpd = $this->mdja->get_rpd($thang, $this->data['kddept'], null, null);
                $this->data['realisasi'] = $this->mdja->get_realisasi_bulanan($thang, $this->data['kddept'], null, null);                
            }            
            elseif(isset($this->data['kdunit']) && empty($this->data['kdprogram']))
            {
                $rpd = $this->mdja->get_rpd($thang, $this->data['kddept'], $this->data['kdunit'], null);
                $this->data['realisasi'] = $this->mdja->get_realisasi_bulanan($thang, $this->data['kddept'], $this->data['kdunit'], null);            
            }            
            elseif(isset($this->data['kdprogram']))
            {
                $rpd = $this->mdja->get_rpd($thang, $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram']);
                $this->data['realisasi'] = $this->mdja->get_realisasi_bulanan($thang, $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram']);
            }
            
            if(count($rpd) > 0)
            {
                if(isset($rpd['kddept'])) $this->data['kddept'] = $rpd['kddept']; else $this->data['kddept'] = 0;
                if(isset($rpd['kdunit'])) $this->data['kdunit'] = $rpd['kdunit'];                
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
                $this->data['kddept'] = 0;
                $this->data['dept'] = 0;
                $this->data['kdunit'] = 0;
                $this->data['unit'] = 0;
                $this->data['kdprogram'] = 0;
                $this->data['program'] = 0;
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
            //$thang = date("Y");
            $thang = '2011';
        }
        $this->data['kddept'] = "";
        $this->data['kdunit'] = "";
        $this->data['kdprogram'] = "";                
        
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
        
        if(isset($_POST['submit-pk']))
        {
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['kdprogram'] = $_POST['kdprogram'];
            $this->data['submitPK'] = 1;
            
            //get volume keluaran
            if($this->data['kddept'] == 0)
            {
                //echo "dudi dept";
                $this->data['output'] = $this->mdja->get_volume_keluaran($thang, null, null, null);
            }
            elseif(isset($this->data['kddept']) && empty($this->data['kdunit']))
            {
                $this->data['output'] = $this->mdja->get_volume_keluaran($thang, $this->data['kddept'], null, null);
            }
            elseif(isset($this->data['kdunit']) && empty($this->data['kdprogram']))
            {
                $this->data['output'] = $this->mdja->get_volume_keluaran($thang, $this->data['kddept'], $this->data['kdunit'], null);                
            }            
            elseif(isset($this->data['kdprogram']))
            {
                $this->data['output'] = $this->mdja->get_volume_keluaran($thang, $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram']);
            }
            
            $this->data['n'] = count($this->data['output']);
        }
        
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
            //$thang = date("Y");
            $thang = '2011';
        }
        $this->data['kddept'] = "";
        $this->data['kdunit'] = "";
        $this->data['kdprogram'] = "";                
        
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
        
        if(isset($_POST['submit-e']))
        {
            $this->data['kddept'] = $_POST['kddept'];
            $this->data['kdunit'] = $_POST['kdunit'];
            $this->data['kdprogram'] = $_POST['kdprogram'];
            $this->data['submitE'] = 1;
            
            //get volume keluaran
            if($this->data['kddept'] == 0)
            {
                //echo "dudi dept";
                $this->data['output'] = $this->mdja->get_volume_keluaran($thang, null, null, null);
            }
            elseif(isset($this->data['kddept']) && empty($this->data['kdunit']))
            {
                $this->data['output'] = $this->mdja->get_volume_keluaran($thang, $this->data['kddept'], null, null);
            }
            elseif(isset($this->data['kdunit']) && empty($this->data['kdprogram']))
            {
                $this->data['output'] = $this->mdja->get_volume_keluaran($thang, $this->data['kddept'], $this->data['kdunit'], null);                
            }            
            elseif(isset($this->data['kdprogram']))
            {
                $this->data['output'] = $this->mdja->get_volume_keluaran($thang, $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram']);
            }
            
            $this->data['n'] = count($this->data['output']);
        }
        
        $this->data['template'] = 'dja/efisiensi';    
        $this->load->view('index', $this->data);
    }
}