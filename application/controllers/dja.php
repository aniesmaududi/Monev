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
                                        3 => base_url().'dja/efisiensi',
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
        $this->data['template'] = 'dja/index';
        $this->load->view('index', $this->data);
    }
    
    /*------------------------------------------- Penyerapan Anggaran ----------------------*/
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
            
            $this->data['template'] = 'dja/graph_p';
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
            
            $this->data['template'] = 'dja/graph_k';
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
            
            $this->data['template'] = 'dja/graph_pk';
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
            
            $this->data['template'] = 'dja/graph_e';
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
            
            $this->data['template'] = 'dja/graph_ch';
            $this->load->view('index', $this->data);
    }
    
    /*------------------------------------------- Aspek Evaluasi ----------------------*/
    public function aspek_evaluasi()
    {
        
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
        $this->data['title'] = 'Konsistensi antara Perencanaan dan Implementasi';
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
    public function efisiensi_table($efisiensi="")
    {
        $this->data['title'] = 'Pengukuran Efisiensi';
        $this->data['pengukuran'] = 'efisiensi';
        $param = explode('-', $efisiensi);
                  
        if(count($param) == 3)
        {
            $dept = $param[0];
            $unit = $param[1];
            $program = $param[2];
            //get program detail
            $program_detail = $this->mdja->get_program_detail($dept, $unit, $program);
            $this->data['dept'] = $program_detail['nmdept'];
            $this->data['unit'] = $program_detail['nmunit'];
            $this->data['program'] = $program_detail['nmprogram'];
            //get volume keluaran
            $this->data['output'] = $this->mdja->get_volume_keluaran($dept, $unit, $program);                    
            $this->data['n'] = count($this->data['output']);
            $this->data['template'] = 'dja/efisiensi';            
        }
        elseif(count($param) == 2)
        {
            $dept = $param[0];
            $unit = $param[1];
            $this->data['program'] = $this->mdja->get_program($dept, $unit);
            $this->data['dept'] = $this->data['program'][0]['nmdept'];
            $this->data['unit'] = $this->data['program'][0]['nmunit'];
            $this->data['button'] = 'Efisiensi';
            $this->data['template'] = 'dja/program';            
        }
        elseif($param[0] != "")
        {
            $dept = $param[0];
            $this->data['unit'] = $this->mdja->get_unit($dept);
            $this->data['dept'] = $this->data['unit'][0]['nmdept'];
            $this->data['template'] = 'dja/unit';            
        }
        else
        {
            $this->data['dept'] = $this->mdja->get_dept();
            $this->data['template'] = 'dja/dept';
        }
        
        $this->load->view('index', $this->data);
    }
}