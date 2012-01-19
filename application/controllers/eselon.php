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
		$this->data['kddept'] = $this->session->userdata('kddept');
		$this->data['kdunit'] = $this->session->userdata('kdunit'); 
		$this->data['kdsatker'] = null;
		$this->_iskl = FALSE;
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
		
		$this->data['penyerapan'] = get_penyerapan($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram']);
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
        if(empty($thang))
        {
            $thang = '2011';
        }
		$this->data['thang'] = $thang;
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
        if(empty($thang))
        {
            $thang = '2011';
        }
		$this->data['thang'] = $thang;
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
		$config['total_rows'] 	= count($this->mdja->get_volume_keluaran($thang, $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'], $this->data['kdgiat']));
		$config['per_page'] 	= 15; 
		$config['cur_page'] 	= $this->data['halaman'];
		$this->pagination->initialize($config);
		$this->data['page'] 	= $this->pagination->create_links();
		$this->data['output'] = $this->mdja->get_volume_keluaran($thang, $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'], $this->data['kdgiat'], $config['per_page'],$config['cur_page']);
		
        $this->data['template'] = 'eselon/keluaran';                 
        $this->load->view('index', $this->data);
	}
	
	/*------------------------------------------- Pengukuran Efisiensi ----------------------*/
	public function efisiensi()
	{
	    $this->data['title'] = 'Pengukuran Efisiensi';    
        $this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
        if(empty($thang))
        {
            $thang = '2011';
        }
		$this->data['thang'] = $thang;
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
		$this->data['output'] = $this->mdja->get_volume_keluaran($thang, $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram']);
		
        $this->data['template'] = 'eselon/efisiensi';    
        $this->load->view('index', $this->data);
	}
	
	/*------------------------------------------- Capaian Hasil ----------------------*/
	public function capaian_hasil()
	{
	    // $sess = $this->session->userdata;
		    // pre($sess);
		    $this->data['title'] = 'Dashboard';
		    
		    $this->load->model('mlib');
		    $this->load->model('msatker');
		    
		    //GET DEPT LIST
		    $this->data['unitList'] = $this->msatker->getUnit();
		    
		    
		    //GET UNIT LIST
		    $this->data['deptList'] = $this->msatker->getDept();
		    
		    //GET PROGRAM LIST
		    $getProg = $this->msatker->getAllProgram();
		    foreach($getProg as $pIdx => $pVal){
				    $program[] = $pVal['kdprogram'];
		    }	
		    $this->data['program'] = $program;
		    
		    //GET THANG LIST
		    $getThang = $this->msatker->getAllThang();
		    foreach($getThang as $index => $value){
				    $thang[] = $value['thang'];
		    }
		    
		    $this->data['thang'] = $thang;
		    
		    $post = $this->input->post();
		    
		    //parameter for get report
		    $nmSatuan = "";
		    if($post['dept']){
			    $kdDept = $post['dept'];
			    $this->data['kdDept'] = $post['dept'];
			    $resDeptName = $this->msatker->getDept($kdDept);
			    $this->data['deptName'] = $resDeptName[0]['nmdept'];
			    $nmSatuan = $this->data['deptName'];
		    } else if($this->_kddept){
			    $kdDept = $this->_kddept;
			    $this->data['kdDept'] = $this->_kddept;
			    $resDeptName = $this->msatker->getDept($kdDept);
			    $this->data['deptName'] = $resDeptName[0]['nmdept'];
			    $nmSatuan = $this->data['deptName'];
		    } else {
			    $kdDept = NULL;
		    }
		    
		    if($post['unit']){
			    $kdUnit = $post['unit'];
			    $this->data['kdUnit'] = $post['unit'];
			    $resUnitName = $this->msatker->getUnit($kdUnit);
			    $this->data['unitName'] = $resUnitName[0]['nmunit'];
			    $nmSatuan = $this->data['unitName'];
		    } else if($this->_kdunit){
			    $kdUnit = $this->_kdunit;
			    $this->data['kdUnit'] = $this->_kdunit;
			    $resUnitName = $this->msatker->getUnit($kdUnit);
			    $this->data['unitName'] = $resUnitName[0]['nmunit'];
			    $nmSatuan = $this->data['unitName'];
		    } else {
			    $kdUnit = NULL;
		    }
		    
		    if($this->_iskl){
			    $iskl = TRUE;
		    } else {
			    $iskl = NULL;
		    }
		    
		    if($post['kdprogram']){
			    $kdProgram = $post['kdprogram'];
			    $this->data['kdprogram'] = $post['kdprogram'];
			    $nmSatuan = "Program Dengan Kode ".$post['kdprogram'];
		    } else {
			    $kdProgram = NULL;
		    }		
		    
		    if($post['thang']){
			    $thangVal = $post['thang'];
		    } else {
			    
			    $thangVal = substr($this->data['now'],0,4) - 1;
		    }
		    $this->data['thangVal'] = $thangVal;
		    $this->load->helper(array('url','fusioncharts'));
		    
		    //Convert data to XML and append
		    /* P */
		    $graph_swfFile      = base_url().'public/charts/Line.swf' ;
		    $graph_caption      = 'Grafik Capaian Hasil '.$nmSatuan.' Tahun Anggaran '.$thangVal;
		    $graph_numberPrefix = '';
		    $graph_numberSuffix = '%';
		    $graph_title        = 'Penyerapan Anggaran '.$thangVal ;
		    $graph_width        = 510 ;
		    $graph_height       = 250 ;	 	
	     
		    $strXML_L = "<graph caption='".$graph_caption."' numberSuffix='".$graph_numberSuffix."' formatNumberScale='0' decimalPrecision='0'>";
		    
		    // Store Name of months
		    $monthList = $this->mlib->getMonth();
		    $getSerapanAnggaran = $this->msatker->getSerapanAnggaran($thangVal,$kdProgram,$kdUnit,$kdDept,$iskl);
		    
		    if($getSerapanAnggaran){
			    $i = 0;
			    foreach($monthList as $month){
				    $arrData_P[$i][1] = $month;
				    $i++;
			    }
			    
			    $i = 0;
			    foreach($getSerapanAnggaran as $idx => $val){
					    $arrData_P[$i][2] = $val['value'];
					    $i++;
			    }
			    // pre($arrData_P);
			    foreach ($arrData_P as $arSubData) {
				    if(isset($arSubData[2])){
					    $strXML_L .= "<set name='" . $arSubData[1] . "' value='" . $arSubData[2] . "' color='".getFCColor()."' />";
				    }
			    }
			    $strXML_L .= "</graph>";
			    
			    $this->data['graph_L']  = renderChart($graph_swfFile, $graph_title, $strXML_L, "LINE" , $graph_width, $graph_height);
		    } else {
			    $this->data['graph_L'] = "No data to show";
		    }
		    
		    
		    // --------- PIE K/L --------- //
		    $graph_swfFile_PieKL	= base_url().'public/charts/Pie2D.swf' ;
		    $graph_caption_PieKL			= 'Capaian Hasil '.$this->data['deptName'].' Tahun Anggaran '.$thangVal;
		    $graph_numberPrefix_PieKL		= '';
		    $graph_numberSuffix_PieKL	= '%';
		    $graph_title_PKL		= 'Penyerapan Anggaran' ;
		    $graph_width_PKL		= 450 ;
		    $graph_height_PKL		= 250 ;	 	
			    $this->data['PKL'] = $this->msatker->getSerapanYearly($thangVal,$kdDept,NULL,NULL);
		    $this->data['notPKL'] = 100 - $this->data['PKL'];
		    // Store Name of months
		    $arrData_PKL[0][1] = "Anggaran terserap";
		    $arrData_PKL[1][1] = "Anggaran belum terserap";        
	     
		    //Store P data
		    $arrData_PKL[0][2] = $this->data['PKL'];
		    $arrData_PKL[1][2] = $this->data['notPKL'];        
	    
		    $strXML_P = "<graph caption='".$graph_caption_PieKL."' numberSuffix='".$graph_numberSuffix_PieKL."' formatNumberScale='0' decimalPrecision='0'>";
	    
		    foreach ($arrData_PKL as $arSubData) {
			$strXML_P .= "<set name='" . $arSubData[1] . "' value='" . $arSubData[2] . "' color='".getFCColor()."' />";
		    }
		    $strXML_P .= "</graph>";
			    
		    $this->data['graph_PKL']  = renderChart($graph_swfFile_PieKL, $graph_title_PKL, $strXML_P, "PIEPKL" , $graph_width_PKL, $graph_height_PKL);
		    // --------- PIE K/L --------- //
	    
		    // --------- PIE ESELON --------- //
		    $graph_swfFile_PieEs			= base_url().'public/charts/Pie2D.swf' ;
		    $graph_caption_PieEs			= 'Capaian Hasil '.$this->data['unitName'].' Tahun Anggaran '.$thangVal;
		    $graph_numberPrefix_PieEs		= '';
		    $graph_numberSuffix_PieEs		= '%';
		    $graph_title_PKL				= 'Penyerapan Anggaran' ;
		    $graph_width_PKL				= 450 ;
		    $graph_height_PKL				= 250 ;	 	
			    $this->data['PES'] = $this->msatker->getSerapanYearly($thangVal,$kdDept,$kdUnit,NULL);
		    $this->data['notPES'] = 100 - $this->data['PES'];
		    // Store Name of months
		    $arrData_PKL[0][1] = "Anggaran terserap";
		    $arrData_PKL[1][1] = "Anggaran belum terserap";        
	     
		    //Store P data
		    $arrData_PKL[0][2] = $this->data['PES'];
		    $arrData_PKL[1][2] = $this->data['notPES'];        
	    
		    $strXML_P = "<graph caption='".$graph_caption_PieEs."' numberSuffix='".$graph_numberSuffix_PieEs."' formatNumberScale='0' decimalPrecision='0'>";
	    
		    foreach ($arrData_PKL as $arSubData) {
			$strXML_P .= "<set name='" . $arSubData[1] . "' value='" . $arSubData[2] . "' color='".getFCColor()."' />";
		    }
		    $strXML_P .= "</graph>";
			    
		    $this->data['graph_PES']  = renderChart($graph_swfFile_PieEs, $graph_title_PKL, $strXML_P, "PIEES" , $graph_width_PKL, $graph_height_PKL);
		    // --------- PIE ESELON --------- //
		    
		    // --------- PIE PROGRAM --------- //
		    $this->data['graph_PPRO'] = "";
		    if(isset($kdProgram)){
			$graph_swfFile_PiePro			= base_url().'public/charts/Pie2D.swf' ;
			$graph_caption_PiePro			= 'Penyerapan Anggaran Dengan Kode Program '.$post['kdprogram'];
			$graph_numberPrefix_PiePro		= '';
			$graph_numberSuffix_PiePro		= '%';
			$graph_title_PKL				= 'Penyerapan Anggaran' ;
			$graph_width_PKL				= 450 ;
			$graph_height_PKL				= 250 ;	 	
			$this->data['PPRO'] = $this->msatker->getSerapanYearly($thangVal,$kdDept,$kdUnit,$kdProgram);
			$this->data['notPPRO'] = 100 - $this->data['PPRO'];
			// Store Name of months
			$arrData_PKL[0][1] = "Anggaran terserap";
			$arrData_PKL[1][1] = "Anggaran belum terserap";        
	 
			//Store P data
			$arrData_PKL[0][2] = $this->data['PPRO'];
			$arrData_PKL[1][2] = $this->data['notPPRO'];        
    
			$strXML_P = "<graph caption='".$graph_caption_PiePro."' numberSuffix='".$graph_numberSuffix_PiePro."' formatNumberScale='0' decimalPrecision='0'>";
    
			foreach ($arrData_PKL as $arSubData) {
				$strXML_P .= "<set name='" . $arSubData[1] . "' value='" . $arSubData[2] . "' color='".getFCColor()."' />";
			}
			$strXML_P .= "</graph>";
				
			$this->data['graph_PPRO']  = renderChart($graph_swfFile_PiePro, $graph_title_PKL, $strXML_P, "PIEPRO" , $graph_width_PKL, $graph_height_PKL);
		}
		
		// --------- PIE PROGRAM --------- //
		
		$this->data['template'] = 'laporan/laporan_ch_eselon';
		$this->load->view('index', $this->data);
	}
	
	/*------------------------------------------- Aspek Evaluasi ----------------------*/
	public function aspek_evaluasi()
	{
	    
	}
	/*------------------------------ End of Laporan ------------------------------*/
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
		$do = $this->input->post('submit');
		$this->meselon->set_real_output_approval();
				
		$this->data['kdunit'] = $this->kdunit;
		$this->data['kddept'] = $this->kddept;
		$this->data['unit_identity'] = $this->meselon->get_unit_identity($this->data['kddept'], $this->data['kdunit']);		
                $this->data['nmunit'] = $this->data['unit_identity']['nmunit'];
                $this->data['nmdept'] = $this->data['unit_identity']['nmdept'];		

		$this->data['message'] = "Data realisasi keluaran yang sah telah dieskalasi ke Kementrian. <br>".
					"Data realisasi keluaran yang tidak sah telah dikembalikan ke Satuan Kerja untuk diperiksa ulang";
		$this->data['template'] = 'eselon/realisasi_status';
		$this->load->view('index', $this->data);
	}
	
	/*----------------------------------- IKK ---------------------------------------------*/
	public function ikk()
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
			$this->data['ikk'] = $this->meselon->get_ikk($this->data['kddept'],$this->data['kdunit'], $this->data['kdsatker'], $this->data['kdprogram'], $this->data['kdgiat']);			
		}
		
		$this->data['template'] = 'eselon/ikk';
		$this->load->view('index', $this->data);
	}
	
	public function do_ikk_approval()
	{
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
	}
	
	/*---------------------------------- Efisien --------------------------------*/
	public function efisien()
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
			$this->data['efisien'] = $this->meselon->get_efisien($this->data['kddept'],$this->data['kdunit'], $this->data['kdsatker'], $this->data['kdprogram'], $this->data['kdgiat']);			
		}
		
		$this->data['template'] = 'eselon/efisien';
		$this->load->view('index', $this->data);
	}
	
	public function do_efisien_approval()
	{
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
	}
}