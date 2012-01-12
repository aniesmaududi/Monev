<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kementrian extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->data['now'] = date("Y-m-d H:i:s");
		$this->data['title'] = 'Kementrian ';
		//get Satker model
		$this->load->model('msatker');
		//get Unit model
		$this->load->model('meselon');
		//get Dept model
		$this->load->model('mkementrian');		
		$this->kddept = $this->session->userdata('kddept');
		$this->data['nav_title'] = 'Pengesahan';
		$this->data['nav_menu'] = array(
						0 => 'Pengesahan Outcome',						
						1 => 'Pengesahan Output',						
						2 => 'Pengesahan IKK',						
						3 => 'Pengesahan Penyerapan Efisiensi',						
						);
		$this->data['nav_menu_link'] = array(
						0 => base_url().'kementrian/unit_outcome',
						1 => base_url().'kementrian/unit_output',
						2 => base_url().'kementrian/unit_ikk',
						3 => base_url().'kementrian/unit_efisien',						
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
						0 => base_url().'kementrian/capaian_hasil',
						1 => base_url().'kementrian/',
						2 => base_url().'kementrian/keluaran',
						3 => base_url().'kementrian/',
						4 => base_url().'kementrian/konsistensi',
						5 => base_url().'kementrian/',
						6 => base_url().'kementrian/efisiensi',
						7 => base_url().'kementrian/',
						);
		//keperluan chart
		$this->data['kddept'] = $this->session->userdata('kddept'); // 015
		$this->_iskl = FALSE;
	}
	
	function index()
	{
		$this->data['title'] = 'Dashboard Kementrian / Lembaga';
		$this->data['penyerapan'] = get_penyerapan('2011',$this->data['kddept']);
		$this->data['konsistensi'] = get_konsistensi('2011',$this->data['kddept']);
		$this->data['keluaran'] = get_keluaran('2011',$this->data['kddept']);
		$this->data['efisiensi'] = get_efisiensi('2011',$this->data['kddept']);
		$this->data['template'] = 'kementrian/index';
		$this->load->view('index', $this->data);
	}
	/*-------------------------------- Laporan ----------------------------------*/
	/*------------------------------- Penyerapan Anggaran ----------------------*/
	function penyerapan()
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
		    $graph_caption      = 'Grafik Penyerapan Anggaran '.$nmSatuan.' Tahun Anggaran '.$thangVal;
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
		    $graph_caption_PieKL			= 'Penyerapan Anggaran '.$this->data['deptName'].' Tahun Anggaran '.$thangVal;
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
		    $graph_caption_PieEs			= 'Penyerapan Anggaran '.$this->data['unitName'].' Tahun Anggaran '.$thangVal;
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
		
		$this->data['template'] = 'laporan/laporan_p_kl';
		$this->load->view('index', $this->data);
	}
	
	/*---------------------Konsistensi antara Perencanaan dan Implementasi ----------------------*/
	function konsistensi()
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
		    $graph_caption      = 'Grafik Konsistensi '.$nmSatuan.' Tahun Anggaran '.$thangVal;
		    $graph_numberPrefix = '';
		    $graph_numberSuffix = '%';
		    $graph_title        = 'Konsistensi '.$thangVal ;
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
		    $graph_caption_PieKL			= 'Konsistensin '.$this->data['deptName'].' Tahun Anggaran '.$thangVal;
		    $graph_numberPrefix_PieKL		= '';
		    $graph_numberSuffix_PieKL	= '%';
		    $graph_title_PKL		= 'Konsistensi' ;
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
		    $graph_caption_PieEs			= 'Konsistensi '.$this->data['unitName'].' Tahun Anggaran '.$thangVal;
		    $graph_numberPrefix_PieEs		= '';
		    $graph_numberSuffix_PieEs		= '%';
		    $graph_title_PKL				= 'Konsistensi' ;
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
			$graph_caption_PiePro			= 'Konsistensi Dengan Kode Program '.$post['kdprogram'];
			$graph_numberPrefix_PiePro		= '';
			$graph_numberSuffix_PiePro		= '%';
			$graph_title_PKL				= 'Konsistensi' ;
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
		
		$this->data['template'] = 'laporan/laporan_k_kl';
		$this->load->view('index', $this->data);
	}
	
	/*------------------------------------------- Pengukuran Volume Keluaran ----------------------*/
	public function keluaran()
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
		    $graph_caption      = 'Grafik Pencapaian Keluaran '.$nmSatuan.' Tahun Anggaran '.$thangVal;
		    $graph_numberPrefix = '';
		    $graph_numberSuffix = '%';
		    $graph_title        = 'Konsistensi '.$thangVal ;
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
		    $graph_caption_PieKL			= 'Pencapaian Keluaran '.$this->data['deptName'].' Tahun Anggaran '.$thangVal;
		    $graph_numberPrefix_PieKL		= '';
		    $graph_numberSuffix_PieKL	= '%';
		    $graph_title_PKL		= 'Pencapaian Keluaran' ;
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
		    $graph_caption_PieEs			= 'Pencapaian Keluaran '.$this->data['unitName'].' Tahun Anggaran '.$thangVal;
		    $graph_numberPrefix_PieEs		= '';
		    $graph_numberSuffix_PieEs		= '%';
		    $graph_title_PKL				= 'Pencapaian Keluaran' ;
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
			$graph_caption_PiePro			= 'Pencapaian Keluaran Dengan Kode Program '.$post['kdprogram'];
			$graph_numberPrefix_PiePro		= '';
			$graph_numberSuffix_PiePro		= '%';
			$graph_title_PKL				= 'Pencapaian Keluaran' ;
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
		
		$this->data['template'] = 'laporan/laporan_pk_kl';
		$this->load->view('index', $this->data);
	}
	
	/*------------------------------------------- Pengukuran Efisiensi ----------------------*/
	public function efisiensi()
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
		    $graph_caption      = 'Grafik Efisiensi '.$nmSatuan.' Tahun Anggaran '.$thangVal;
		    $graph_numberPrefix = '';
		    $graph_numberSuffix = '%';
		    $graph_title        = 'Konsistensi '.$thangVal ;
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
		    $graph_caption_PieKL			= 'Efisiensi '.$this->data['deptName'].' Tahun Anggaran '.$thangVal;
		    $graph_numberPrefix_PieKL		= '';
		    $graph_numberSuffix_PieKL	= '%';
		    $graph_title_PKL		= 'Efisiensi' ;
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
		    $graph_caption_PieEs			= 'Efisiensi '.$this->data['unitName'].' Tahun Anggaran '.$thangVal;
		    $graph_numberPrefix_PieEs		= '';
		    $graph_numberSuffix_PieEs		= '%';
		    $graph_title_PKL				= 'Efisiensi' ;
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
			$graph_caption_PiePro			= 'Efisiensi Dengan Kode Program '.$post['kdprogram'];
			$graph_numberPrefix_PiePro		= '';
			$graph_numberSuffix_PiePro		= '%';
			$graph_title_PKL				= 'Pencapaian Keluaran' ;
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
		
		$this->data['template'] = 'laporan/laporan_e_kl';
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
		
		$this->data['template'] = 'laporan/laporan_ch_kl';
		$this->load->view('index', $this->data);
	}
	
	/*------------------------------------------- Aspek Evaluasi ----------------------*/
	public function aspek_evaluasi()
	{
	    
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
		$do = $this->input->post('submit');
		$this->mkementrian->set_real_output_approval();
				
		$kdsatker = $this->input->post('kdsatker');
		$this->data['satker_identity'] = $this->msatker->get_satker_identity($kdsatker);
		$this->data['nmsatker'] = $this->data['satker_identity']['nmsatker'];
		$this->data['nmunit'] = $this->data['satker_identity']['nmunit'];
		$this->data['nmdept'] = $this->data['satker_identity']['nmdept'];		

		$this->data['message'] = "Data realisasi keluaran yang sah telah dieskalasi ke DJA. <br>".
					"Data realisasi keluaran yang tidak sah telah dikembalikan ke Satuan Kerja untuk diperiksa ulang";
		$this->data['template'] = 'kementrian/realisasi_status';
		$this->load->view('index', $this->data);
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
}