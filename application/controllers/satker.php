<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Satker extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
		is_login();
        $this->data['now'] = date("Y-m-d H:i:s");
        $this->data['title'] = 'Satker ';
        //get Satker model
        $this->load->model('msatker');
        $this->load->model('muser');
        $this->kdsatker = $this->session->userdata('kdsatker');
		$this->data['dashboard_menu_link'] =  base_url().'satker/';
        $this->data['kdunit'] = $this->session->userdata('kdunit'); // 11
		$this->data['kddept'] = $this->session->userdata('kddept'); // 015
		$this->data['kdprogram'] = null;
        $this->_iskl = FALSE;

    }

    function index()
    {
        $this->data['title'] = 'Dashboard Satker';
		$this->data['penyerapan'] = get_penyerapan('2011',$this->data['kddept'],$this->data['kdunit']);
		$this->data['konsistensi'] = get_konsistensi('2011',$this->data['kddept'],$this->data['kdunit']);
		$this->data['keluaran'] = get_keluaran('2011',$this->data['kddept'],$this->data['kdunit']);
		$this->data['efisiensi'] = get_efisiensi('2011',$this->data['kddept'],$this->data['kdunit']);
		
        $this->data['template'] = 'satker/index';
        $this->load->view('index', $this->data);
    }

    /*-------------------------------- Laporan ----------------------------------*/
    //Dita
    function laporan()
    {
    	//this part loads get_satker_program content according to satker's id 
    	$this->data['program'] = $this->msatker->get_satker_program($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'));
    	if($this->data['program']):
			$this->data['nmprogram'] = $this->data['program'][0]['nmprogram'];
			$this->data['kdprogram'] = $this->data['program'][0]['kdprogram'];
			$this->data['kegiatan'] = $this->msatker->get_satker_kegiatan($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'),$this->data['kdprogram']);
    	endif;
    	
    	$this->data['template'] = 'satker/laporan';	
    	$this->load->view('index',$this->data);
    }
    
    /*------------------------------- Penyerapan Anggaran ----------------------*/
    //Dita
    function penyerapan_table()
    {
    	//this part loads get_satker_program content according to satker's id 
    	$this->data['program'] = $this->msatker->get_satker_program($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'));
    	if($this->data['program']):
			$this->data['nmprogram'] = $this->data['program'][0]['nmprogram'];
			$this->data['kdprogram'] = $this->data['program'][0]['kdprogram'];
			$this->data['kegiatan'] = $this->msatker->get_satker_kegiatan($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'),$this->data['kdprogram']);
    	endif;
        	
    	$this->data['dept'] = $this->muser->getDept($this->session->userdata('kddept'));
    	$this->data['nmdept'] = $this->data['dept'][0]['nmdept'];
    	$this->data['unit'] = $this->muser->getUnit($this->session->userdata('kddept'),$this->session->userdata('kdunit'));
    	$this->data['nmunit'] = $this->data['unit'][0]['nmunit'];
    	
        $this->data['template'] = 'satker/penyerapan';
    	$this->load->view('index',$this->data);
    }

    /*---------------------Konsistensi antara Perencanaan dan Implementasi ----------------------*/
    function konsistensi_table()
    {
    	//this part loads get_satker_program content according to satker's id 
    	$this->data['program'] = $this->msatker->get_satker_program($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'));
    	if($this->data['program']):
			$this->data['nmprogram'] = $this->data['program'][0]['nmprogram'];
			$this->data['kdprogram'] = $this->data['program'][0]['kdprogram'];
			$this->data['kegiatan'] = $this->msatker->get_satker_kegiatan($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'),$this->data['kdprogram']);
    	endif;
        	
    	$this->data['dept'] = $this->muser->getDept($this->session->userdata('kddept'));
    	$this->data['nmdept'] = $this->data['dept'][0]['nmdept'];
    	$this->data['unit'] = $this->muser->getUnit($this->session->userdata('kddept'),$this->session->userdata('kdunit'));
    	$this->data['nmunit'] = $this->data['unit'][0]['nmunit'];
    	
        $this->data['template'] = 'satker/ketepatan';
    	$this->load->view('index',$this->data);
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
        foreach ($getProg as $pIdx => $pVal) {
            $program[] = $pVal['kdprogram'];
        }
        $this->data['program'] = $program;

        //GET THANG LIST
        $getThang = $this->msatker->getAllThang();
        foreach ($getThang as $index => $value) {
            $thang[] = $value['thang'];
        }

        $this->data['thang'] = $thang;

        $post = $this->input->post();

        //parameter for get report
        $nmSatuan = "";
        if ($post['dept']) {
            $kdDept = $post['dept'];
            $this->data['kdDept'] = $post['dept'];
            $resDeptName = $this->msatker->getDept($kdDept);
            $this->data['deptName'] = $resDeptName[0]['nmdept'];
            $nmSatuan = $this->data['deptName'];
        } else if ($this->_kddept) {
            $kdDept = $this->_kddept;
            $this->data['kdDept'] = $this->_kddept;
            $resDeptName = $this->msatker->getDept($kdDept);
            $this->data['deptName'] = $resDeptName[0]['nmdept'];
            $nmSatuan = $this->data['deptName'];
        } else {
            $kdDept = NULL;
        }

        if ($post['unit']) {
            $kdUnit = $post['unit'];
            $this->data['kdUnit'] = $post['unit'];
            $resUnitName = $this->msatker->getUnit($kdUnit);
            $this->data['unitName'] = $resUnitName[0]['nmunit'];
            $nmSatuan = $this->data['unitName'];
        } else if ($this->_kdunit) {
            $kdUnit = $this->_kdunit;
            $this->data['kdUnit'] = $this->_kdunit;
            $resUnitName = $this->msatker->getUnit($kdUnit);
            $this->data['unitName'] = $resUnitName[0]['nmunit'];
            $nmSatuan = $this->data['unitName'];
        } else {
            $kdUnit = NULL;
        }

        if ($this->_iskl) {
            $iskl = TRUE;
        } else {
            $iskl = NULL;
        }

        if ($post['kdprogram']) {
            $kdProgram = $post['kdprogram'];
            $this->data['kdprogram'] = $post['kdprogram'];
            $nmSatuan = "Program Dengan Kode " . $post['kdprogram'];
        } else {
            $kdProgram = NULL;
        }

        if ($post['thang']) {
            $thangVal = $post['thang'];
        } else {

            $thangVal = substr($this->data['now'], 0, 4) - 1;
        }
        $this->data['thangVal'] = $thangVal;
        $this->load->helper(array('url', 'fusioncharts'));

        //Convert data to XML and append
        /* P */
        $graph_swfFile = base_url() . 'public/charts/Line.swf';
        $graph_caption = 'Grafik Pencapaian Keluaran ' . $nmSatuan . ' Tahun Anggaran ' . $thangVal;
        $graph_numberPrefix = '';
        $graph_numberSuffix = '%';
        $graph_title = 'Konsistensi ' . $thangVal;
        $graph_width = 510;
        $graph_height = 250;

        $strXML_L = "<graph caption='" . $graph_caption . "' numberSuffix='" . $graph_numberSuffix . "' formatNumberScale='0' decimalPrecision='0'>";

        // Store Name of months
        $monthList = $this->mlib->getMonth();
        $getSerapanAnggaran = $this->msatker->getSerapanAnggaran($thangVal, $kdProgram, $kdUnit, $kdDept, $iskl);

        if ($getSerapanAnggaran) {
            $i = 0;
            foreach ($monthList as $month) {
                $arrData_P[$i][1] = $month;
                $i++;
            }

            $i = 0;
            foreach ($getSerapanAnggaran as $idx => $val) {
                $arrData_P[$i][2] = $val['value'];
                $i++;
            }
            // pre($arrData_P);
            foreach ($arrData_P as $arSubData) {
                if (isset($arSubData[2])) {
                    $strXML_L .= "<set name='" . $arSubData[1] . "' value='" . $arSubData[2] . "' color='" . getFCColor() . "' />";
                }
            }
            $strXML_L .= "</graph>";

            $this->data['graph_L'] = renderChart($graph_swfFile, $graph_title, $strXML_L, "LINE", $graph_width, $graph_height);
        } else {
            $this->data['graph_L'] = "No data to show";
        }


        // --------- PIE K/L --------- //
        $graph_swfFile_PieKL = base_url() . 'public/charts/Pie2D.swf';
        $graph_caption_PieKL = 'Pencapaian Keluaran ' . $this->data['deptName'] . ' Tahun Anggaran ' . $thangVal;
        $graph_numberPrefix_PieKL = '';
        $graph_numberSuffix_PieKL = '%';
        $graph_title_PKL = 'Pencapaian Keluaran';
        $graph_width_PKL = 450;
        $graph_height_PKL = 250;
        $this->data['PKL'] = $this->msatker->getSerapanYearly($thangVal, $kdDept, NULL, NULL);
        $this->data['notPKL'] = 100 - $this->data['PKL'];
        // Store Name of months
        $arrData_PKL[0][1] = "Anggaran terserap";
        $arrData_PKL[1][1] = "Anggaran belum terserap";

        //Store P data
        $arrData_PKL[0][2] = $this->data['PKL'];
        $arrData_PKL[1][2] = $this->data['notPKL'];

        $strXML_P = "<graph caption='" . $graph_caption_PieKL . "' numberSuffix='" . $graph_numberSuffix_PieKL . "' formatNumberScale='0' decimalPrecision='0'>";

        foreach ($arrData_PKL as $arSubData) {
            $strXML_P .= "<set name='" . $arSubData[1] . "' value='" . $arSubData[2] . "' color='" . getFCColor() . "' />";
        }
        $strXML_P .= "</graph>";

        $this->data['graph_PKL'] = renderChart($graph_swfFile_PieKL, $graph_title_PKL, $strXML_P, "PIEPKL", $graph_width_PKL, $graph_height_PKL);
        // --------- PIE K/L --------- //

        // --------- PIE ESELON --------- //
        $graph_swfFile_PieEs = base_url() . 'public/charts/Pie2D.swf';
        $graph_caption_PieEs = 'Pencapaian Keluaran ' . $this->data['unitName'] . ' Tahun Anggaran ' . $thangVal;
        $graph_numberPrefix_PieEs = '';
        $graph_numberSuffix_PieEs = '%';
        $graph_title_PKL = 'Pencapaian Keluaran';
        $graph_width_PKL = 450;
        $graph_height_PKL = 250;
        $this->data['PES'] = $this->msatker->getSerapanYearly($thangVal, $kdDept, $kdUnit, NULL);
        $this->data['notPES'] = 100 - $this->data['PES'];
        // Store Name of months
        $arrData_PKL[0][1] = "Anggaran terserap";
        $arrData_PKL[1][1] = "Anggaran belum terserap";

        //Store P data
        $arrData_PKL[0][2] = $this->data['PES'];
        $arrData_PKL[1][2] = $this->data['notPES'];

        $strXML_P = "<graph caption='" . $graph_caption_PieEs . "' numberSuffix='" . $graph_numberSuffix_PieEs . "' formatNumberScale='0' decimalPrecision='0'>";

        foreach ($arrData_PKL as $arSubData) {
            $strXML_P .= "<set name='" . $arSubData[1] . "' value='" . $arSubData[2] . "' color='" . getFCColor() . "' />";
        }
        $strXML_P .= "</graph>";

        $this->data['graph_PES'] = renderChart($graph_swfFile_PieEs, $graph_title_PKL, $strXML_P, "PIEES", $graph_width_PKL, $graph_height_PKL);
        // --------- PIE ESELON --------- //

        // --------- PIE PROGRAM --------- //
        $this->data['graph_PPRO'] = "";
        if (isset($kdProgram)) {
            $graph_swfFile_PiePro = base_url() . 'public/charts/Pie2D.swf';
            $graph_caption_PiePro = 'Pencapaian Keluaran Dengan Kode Program ' . $post['kdprogram'];
            $graph_numberPrefix_PiePro = '';
            $graph_numberSuffix_PiePro = '%';
            $graph_title_PKL = 'Pencapaian Keluaran';
            $graph_width_PKL = 450;
            $graph_height_PKL = 250;
            $this->data['PPRO'] = $this->msatker->getSerapanYearly($thangVal, $kdDept, $kdUnit, $kdProgram);
            $this->data['notPPRO'] = 100 - $this->data['PPRO'];
            // Store Name of months
            $arrData_PKL[0][1] = "Anggaran terserap";
            $arrData_PKL[1][1] = "Anggaran belum terserap";

            //Store P data
            $arrData_PKL[0][2] = $this->data['PPRO'];
            $arrData_PKL[1][2] = $this->data['notPPRO'];

            $strXML_P = "<graph caption='" . $graph_caption_PiePro . "' numberSuffix='" . $graph_numberSuffix_PiePro . "' formatNumberScale='0' decimalPrecision='0'>";

            foreach ($arrData_PKL as $arSubData) {
                $strXML_P .= "<set name='" . $arSubData[1] . "' value='" . $arSubData[2] . "' color='" . getFCColor() . "' />";
            }
            $strXML_P .= "</graph>";

            $this->data['graph_PPRO'] = renderChart($graph_swfFile_PiePro, $graph_title_PKL, $strXML_P, "PIEPRO", $graph_width_PKL, $graph_height_PKL);
        }

        // --------- PIE PROGRAM --------- //

        $this->data['template'] = 'laporan/laporan_pk_satker';
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
        foreach ($getProg as $pIdx => $pVal) {
            $program[] = $pVal['kdprogram'];
        }
        $this->data['program'] = $program;

        //GET THANG LIST
        $getThang = $this->msatker->getAllThang();
        foreach ($getThang as $index => $value) {
            $thang[] = $value['thang'];
        }

        $this->data['thang'] = $thang;

        $post = $this->input->post();

        //parameter for get report
        $nmSatuan = "";
        if ($post['dept']) {
            $kdDept = $post['dept'];
            $this->data['kdDept'] = $post['dept'];
            $resDeptName = $this->msatker->getDept($kdDept);
            $this->data['deptName'] = $resDeptName[0]['nmdept'];
            $nmSatuan = $this->data['deptName'];
        } else if ($this->_kddept) {
            $kdDept = $this->_kddept;
            $this->data['kdDept'] = $this->_kddept;
            $resDeptName = $this->msatker->getDept($kdDept);
            $this->data['deptName'] = $resDeptName[0]['nmdept'];
            $nmSatuan = $this->data['deptName'];
        } else {
            $kdDept = NULL;
        }

        if ($post['unit']) {
            $kdUnit = $post['unit'];
            $this->data['kdUnit'] = $post['unit'];
            $resUnitName = $this->msatker->getUnit($kdUnit);
            $this->data['unitName'] = $resUnitName[0]['nmunit'];
            $nmSatuan = $this->data['unitName'];
        } else if ($this->_kdunit) {
            $kdUnit = $this->_kdunit;
            $this->data['kdUnit'] = $this->_kdunit;
            $resUnitName = $this->msatker->getUnit($kdUnit);
            $this->data['unitName'] = $resUnitName[0]['nmunit'];
            $nmSatuan = $this->data['unitName'];
        } else {
            $kdUnit = NULL;
        }

        if ($this->_iskl) {
            $iskl = TRUE;
        } else {
            $iskl = NULL;
        }

        if ($post['kdprogram']) {
            $kdProgram = $post['kdprogram'];
            $this->data['kdprogram'] = $post['kdprogram'];
            $nmSatuan = "Program Dengan Kode " . $post['kdprogram'];
        } else {
            $kdProgram = NULL;
        }

        if ($post['thang']) {
            $thangVal = $post['thang'];
        } else {

            $thangVal = substr($this->data['now'], 0, 4) - 1;
        }
        $this->data['thangVal'] = $thangVal;
        $this->load->helper(array('url', 'fusioncharts'));

        //Convert data to XML and append
        /* P */
        $graph_swfFile = base_url() . 'public/charts/Line.swf';
        $graph_caption = 'Grafik Efisiensi ' . $nmSatuan . ' Tahun Anggaran ' . $thangVal;
        $graph_numberPrefix = '';
        $graph_numberSuffix = '%';
        $graph_title = 'Konsistensi ' . $thangVal;
        $graph_width = 510;
        $graph_height = 250;

        $strXML_L = "<graph caption='" . $graph_caption . "' numberSuffix='" . $graph_numberSuffix . "' formatNumberScale='0' decimalPrecision='0'>";

        // Store Name of months
        $monthList = $this->mlib->getMonth();
        $getSerapanAnggaran = $this->msatker->getSerapanAnggaran($thangVal, $kdProgram, $kdUnit, $kdDept, $iskl);

        if ($getSerapanAnggaran) {
            $i = 0;
            foreach ($monthList as $month) {
                $arrData_P[$i][1] = $month;
                $i++;
            }

            $i = 0;
            foreach ($getSerapanAnggaran as $idx => $val) {
                $arrData_P[$i][2] = $val['value'];
                $i++;
            }
            // pre($arrData_P);
            foreach ($arrData_P as $arSubData) {
                if (isset($arSubData[2])) {
                    $strXML_L .= "<set name='" . $arSubData[1] . "' value='" . $arSubData[2] . "' color='" . getFCColor() . "' />";
                }
            }
            $strXML_L .= "</graph>";

            $this->data['graph_L'] = renderChart($graph_swfFile, $graph_title, $strXML_L, "LINE", $graph_width, $graph_height);
        } else {
            $this->data['graph_L'] = "No data to show";
        }


        // --------- PIE K/L --------- //
        $graph_swfFile_PieKL = base_url() . 'public/charts/Pie2D.swf';
        $graph_caption_PieKL = 'Efisiensi ' . $this->data['deptName'] . ' Tahun Anggaran ' . $thangVal;
        $graph_numberPrefix_PieKL = '';
        $graph_numberSuffix_PieKL = '%';
        $graph_title_PKL = 'Efisiensi';
        $graph_width_PKL = 450;
        $graph_height_PKL = 250;
        $this->data['PKL'] = $this->msatker->getSerapanYearly($thangVal, $kdDept, NULL, NULL);
        $this->data['notPKL'] = 100 - $this->data['PKL'];
        // Store Name of months
        $arrData_PKL[0][1] = "Anggaran terserap";
        $arrData_PKL[1][1] = "Anggaran belum terserap";

        //Store P data
        $arrData_PKL[0][2] = $this->data['PKL'];
        $arrData_PKL[1][2] = $this->data['notPKL'];

        $strXML_P = "<graph caption='" . $graph_caption_PieKL . "' numberSuffix='" . $graph_numberSuffix_PieKL . "' formatNumberScale='0' decimalPrecision='0'>";

        foreach ($arrData_PKL as $arSubData) {
            $strXML_P .= "<set name='" . $arSubData[1] . "' value='" . $arSubData[2] . "' color='" . getFCColor() . "' />";
        }
        $strXML_P .= "</graph>";

        $this->data['graph_PKL'] = renderChart($graph_swfFile_PieKL, $graph_title_PKL, $strXML_P, "PIEPKL", $graph_width_PKL, $graph_height_PKL);
        // --------- PIE K/L --------- //

        // --------- PIE ESELON --------- //
        $graph_swfFile_PieEs = base_url() . 'public/charts/Pie2D.swf';
        $graph_caption_PieEs = 'Efisiensi ' . $this->data['unitName'] . ' Tahun Anggaran ' . $thangVal;
        $graph_numberPrefix_PieEs = '';
        $graph_numberSuffix_PieEs = '%';
        $graph_title_PKL = 'Efisiensi';
        $graph_width_PKL = 450;
        $graph_height_PKL = 250;
        $this->data['PES'] = $this->msatker->getSerapanYearly($thangVal, $kdDept, $kdUnit, NULL);
        $this->data['notPES'] = 100 - $this->data['PES'];
        // Store Name of months
        $arrData_PKL[0][1] = "Anggaran terserap";
        $arrData_PKL[1][1] = "Anggaran belum terserap";

        //Store P data
        $arrData_PKL[0][2] = $this->data['PES'];
        $arrData_PKL[1][2] = $this->data['notPES'];

        $strXML_P = "<graph caption='" . $graph_caption_PieEs . "' numberSuffix='" . $graph_numberSuffix_PieEs . "' formatNumberScale='0' decimalPrecision='0'>";

        foreach ($arrData_PKL as $arSubData) {
            $strXML_P .= "<set name='" . $arSubData[1] . "' value='" . $arSubData[2] . "' color='" . getFCColor() . "' />";
        }
        $strXML_P .= "</graph>";

        $this->data['graph_PES'] = renderChart($graph_swfFile_PieEs, $graph_title_PKL, $strXML_P, "PIEES", $graph_width_PKL, $graph_height_PKL);
        // --------- PIE ESELON --------- //

        // --------- PIE PROGRAM --------- //
        $this->data['graph_PPRO'] = "";
        if (isset($kdProgram)) {
            $graph_swfFile_PiePro = base_url() . 'public/charts/Pie2D.swf';
            $graph_caption_PiePro = 'Efisiensi Dengan Kode Program ' . $post['kdprogram'];
            $graph_numberPrefix_PiePro = '';
            $graph_numberSuffix_PiePro = '%';
            $graph_title_PKL = 'Pencapaian Keluaran';
            $graph_width_PKL = 450;
            $graph_height_PKL = 250;
            $this->data['PPRO'] = $this->msatker->getSerapanYearly($thangVal, $kdDept, $kdUnit, $kdProgram);
            $this->data['notPPRO'] = 100 - $this->data['PPRO'];
            // Store Name of months
            $arrData_PKL[0][1] = "Anggaran terserap";
            $arrData_PKL[1][1] = "Anggaran belum terserap";

            //Store P data
            $arrData_PKL[0][2] = $this->data['PPRO'];
            $arrData_PKL[1][2] = $this->data['notPPRO'];

            $strXML_P = "<graph caption='" . $graph_caption_PiePro . "' numberSuffix='" . $graph_numberSuffix_PiePro . "' formatNumberScale='0' decimalPrecision='0'>";

            foreach ($arrData_PKL as $arSubData) {
                $strXML_P .= "<set name='" . $arSubData[1] . "' value='" . $arSubData[2] . "' color='" . getFCColor() . "' />";
            }
            $strXML_P .= "</graph>";

            $this->data['graph_PPRO'] = renderChart($graph_swfFile_PiePro, $graph_title_PKL, $strXML_P, "PIEPRO", $graph_width_PKL, $graph_height_PKL);
        }

        // --------- PIE PROGRAM --------- //

        $this->data['template'] = 'laporan/laporan_e_satker';
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
        foreach ($getProg as $pIdx => $pVal) {
            $program[] = $pVal['kdprogram'];
        }
        $this->data['program'] = $program;

        //GET THANG LIST
        $getThang = $this->msatker->getAllThang();
        foreach ($getThang as $index => $value) {
            $thang[] = $value['thang'];
        }

        $this->data['thang'] = $thang;

        $post = $this->input->post();

        //parameter for get report
        $nmSatuan = "";
        if ($post['dept']) {
            $kdDept = $post['dept'];
            $this->data['kdDept'] = $post['dept'];
            $resDeptName = $this->msatker->getDept($kdDept);
            $this->data['deptName'] = $resDeptName[0]['nmdept'];
            $nmSatuan = $this->data['deptName'];
        } else if ($this->_kddept) {
            $kdDept = $this->_kddept;
            $this->data['kdDept'] = $this->_kddept;
            $resDeptName = $this->msatker->getDept($kdDept);
            $this->data['deptName'] = $resDeptName[0]['nmdept'];
            $nmSatuan = $this->data['deptName'];
        } else {
            $kdDept = NULL;
        }

        if ($post['unit']) {
            $kdUnit = $post['unit'];
            $this->data['kdUnit'] = $post['unit'];
            $resUnitName = $this->msatker->getUnit($kdUnit);
            $this->data['unitName'] = $resUnitName[0]['nmunit'];
            $nmSatuan = $this->data['unitName'];
        } else if ($this->_kdunit) {
            $kdUnit = $this->_kdunit;
            $this->data['kdUnit'] = $this->_kdunit;
            $resUnitName = $this->msatker->getUnit($kdUnit);
            $this->data['unitName'] = $resUnitName[0]['nmunit'];
            $nmSatuan = $this->data['unitName'];
        } else {
            $kdUnit = NULL;
        }

        if ($this->_iskl) {
            $iskl = TRUE;
        } else {
            $iskl = NULL;
        }

        if ($post['kdprogram']) {
            $kdProgram = $post['kdprogram'];
            $this->data['kdprogram'] = $post['kdprogram'];
            $nmSatuan = "Program Dengan Kode " . $post['kdprogram'];
        } else {
            $kdProgram = NULL;
        }

        if ($post['thang']) {
            $thangVal = $post['thang'];
        } else {

            $thangVal = substr($this->data['now'], 0, 4) - 1;
        }
        $this->data['thangVal'] = $thangVal;
        $this->load->helper(array('url', 'fusioncharts'));

        //Convert data to XML and append
        /* P */
        $graph_swfFile = base_url() . 'public/charts/Line.swf';
        $graph_caption = 'Grafik Capaian Hasil ' . $nmSatuan . ' Tahun Anggaran ' . $thangVal;
        $graph_numberPrefix = '';
        $graph_numberSuffix = '%';
        $graph_title = 'Penyerapan Anggaran ' . $thangVal;
        $graph_width = 510;
        $graph_height = 250;

        $strXML_L = "<graph caption='" . $graph_caption . "' numberSuffix='" . $graph_numberSuffix . "' formatNumberScale='0' decimalPrecision='0'>";

        // Store Name of months
        $monthList = $this->mlib->getMonth();
        $getSerapanAnggaran = $this->msatker->getSerapanAnggaran($thangVal, $kdProgram, $kdUnit, $kdDept, $iskl);

        if ($getSerapanAnggaran) {
            $i = 0;
            foreach ($monthList as $month) {
                $arrData_P[$i][1] = $month;
                $i++;
            }

            $i = 0;
            foreach ($getSerapanAnggaran as $idx => $val) {
                $arrData_P[$i][2] = $val['value'];
                $i++;
            }
            // pre($arrData_P);
            foreach ($arrData_P as $arSubData) {
                if (isset($arSubData[2])) {
                    $strXML_L .= "<set name='" . $arSubData[1] . "' value='" . $arSubData[2] . "' color='" . getFCColor() . "' />";
                }
            }
            $strXML_L .= "</graph>";

            $this->data['graph_L'] = renderChart($graph_swfFile, $graph_title, $strXML_L, "LINE", $graph_width, $graph_height);
        } else {
            $this->data['graph_L'] = "No data to show";
        }


        // --------- PIE K/L --------- //
        $graph_swfFile_PieKL = base_url() . 'public/charts/Pie2D.swf';
        $graph_caption_PieKL = 'Capaian Hasil ' . $this->data['deptName'] . ' Tahun Anggaran ' . $thangVal;
        $graph_numberPrefix_PieKL = '';
        $graph_numberSuffix_PieKL = '%';
        $graph_title_PKL = 'Penyerapan Anggaran';
        $graph_width_PKL = 450;
        $graph_height_PKL = 250;
        $this->data['PKL'] = $this->msatker->getSerapanYearly($thangVal, $kdDept, NULL, NULL);
        $this->data['notPKL'] = 100 - $this->data['PKL'];
        // Store Name of months
        $arrData_PKL[0][1] = "Anggaran terserap";
        $arrData_PKL[1][1] = "Anggaran belum terserap";

        //Store P data
        $arrData_PKL[0][2] = $this->data['PKL'];
        $arrData_PKL[1][2] = $this->data['notPKL'];

        $strXML_P = "<graph caption='" . $graph_caption_PieKL . "' numberSuffix='" . $graph_numberSuffix_PieKL . "' formatNumberScale='0' decimalPrecision='0'>";

        foreach ($arrData_PKL as $arSubData) {
            $strXML_P .= "<set name='" . $arSubData[1] . "' value='" . $arSubData[2] . "' color='" . getFCColor() . "' />";
        }
        $strXML_P .= "</graph>";

        $this->data['graph_PKL'] = renderChart($graph_swfFile_PieKL, $graph_title_PKL, $strXML_P, "PIEPKL", $graph_width_PKL, $graph_height_PKL);
        // --------- PIE K/L --------- //

        // --------- PIE ESELON --------- //
        $graph_swfFile_PieEs = base_url() . 'public/charts/Pie2D.swf';
        $graph_caption_PieEs = 'Capaian Hasil ' . $this->data['unitName'] . ' Tahun Anggaran ' . $thangVal;
        $graph_numberPrefix_PieEs = '';
        $graph_numberSuffix_PieEs = '%';
        $graph_title_PKL = 'Penyerapan Anggaran';
        $graph_width_PKL = 450;
        $graph_height_PKL = 250;
        $this->data['PES'] = $this->msatker->getSerapanYearly($thangVal, $kdDept, $kdUnit, NULL);
        $this->data['notPES'] = 100 - $this->data['PES'];
        // Store Name of months
        $arrData_PKL[0][1] = "Anggaran terserap";
        $arrData_PKL[1][1] = "Anggaran belum terserap";

        //Store P data
        $arrData_PKL[0][2] = $this->data['PES'];
        $arrData_PKL[1][2] = $this->data['notPES'];

        $strXML_P = "<graph caption='" . $graph_caption_PieEs . "' numberSuffix='" . $graph_numberSuffix_PieEs . "' formatNumberScale='0' decimalPrecision='0'>";

        foreach ($arrData_PKL as $arSubData) {
            $strXML_P .= "<set name='" . $arSubData[1] . "' value='" . $arSubData[2] . "' color='" . getFCColor() . "' />";
        }
        $strXML_P .= "</graph>";

        $this->data['graph_PES'] = renderChart($graph_swfFile_PieEs, $graph_title_PKL, $strXML_P, "PIEES", $graph_width_PKL, $graph_height_PKL);
        // --------- PIE ESELON --------- //

        // --------- PIE PROGRAM --------- //
        $this->data['graph_PPRO'] = "";
        if (isset($kdProgram)) {
            $graph_swfFile_PiePro = base_url() . 'public/charts/Pie2D.swf';
            $graph_caption_PiePro = 'Capaian Hasil Dengan Kode Program ' . $post['kdprogram'];
            $graph_numberPrefix_PiePro = '';
            $graph_numberSuffix_PiePro = '%';
            $graph_title_PKL = 'Penyerapan Anggaran';
            $graph_width_PKL = 450;
            $graph_height_PKL = 250;
            $this->data['PPRO'] = $this->msatker->getSerapanYearly($thangVal, $kdDept, $kdUnit, $kdProgram);
            $this->data['notPPRO'] = 100 - $this->data['PPRO'];
            // Store Name of months
            $arrData_PKL[0][1] = "Anggaran terserap";
            $arrData_PKL[1][1] = "Anggaran belum terserap";

            //Store P data
            $arrData_PKL[0][2] = $this->data['PPRO'];
            $arrData_PKL[1][2] = $this->data['notPPRO'];

            $strXML_P = "<graph caption='" . $graph_caption_PiePro . "' numberSuffix='" . $graph_numberSuffix_PiePro . "' formatNumberScale='0' decimalPrecision='0'>";

            foreach ($arrData_PKL as $arSubData) {
                $strXML_P .= "<set name='" . $arSubData[1] . "' value='" . $arSubData[2] . "' color='" . getFCColor() . "' />";
            }
            $strXML_P .= "</graph>";

            $this->data['graph_PPRO'] = renderChart($graph_swfFile_PiePro, $graph_title_PKL, $strXML_P, "PIEPRO", $graph_width_PKL, $graph_height_PKL);
        }

        // --------- PIE PROGRAM --------- //

        $this->data['template'] = 'laporan/laporan_ch_satker';
        $this->load->view('index', $this->data);
    }

    /*------------------------------------------- Aspek Evaluasi ----------------------*/
    public function aspek_evaluasi()
    {

    }

    /*------------------------------ End of Laporan ------------------------------*/


    /*------------------------------ KEGIATAN ------------------------------*/
    //Dita

    function kegiatan()
    {
    	//this part loads get_satker_program content according to satker's id 
    	$this->data['program'] = $this->msatker->get_satker_program($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'));
    	if($this->data['program']):
			$this->data['nmprogram'] = $this->data['program'][0]['nmprogram'];
			$this->data['kdprogram'] = $this->data['program'][0]['kdprogram'];
			$this->data['kegiatan'] = $this->msatker->get_satker_kegiatan($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'),$this->data['kdprogram']);
    	endif;
    	//this part loads kegiatan
    	
    	$this->data['template'] = 'satker/kegiatan';
    	$this->load->view('index',$this->data);
    }
    
    function detail_giat($kode)
    {
    	//this part loads get_satker_program content according to satker's id 
    	$this->data['program'] = $this->msatker->get_satker_program($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'));
    	$this->data['nmprogram'] = $this->data['program'][0]['nmprogram'];
    	$this->data['kdprogram'] = $this->data['program'][0]['kdprogram'];
    	
    	//this part loads kegiatan
    	$this->data['kegiatan'] = $this->msatker->get_satker_kegiatan($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'),$this->data['kdprogram']);
    	$this->data['nmgiat'] = $this->data['kegiatan'][0]['nmgiat'];
    	$this->data['kdgiat'] = $this->data['kegiatan'][0]['kdgiat'];
    	
    	//this part loads output
    	$this->data['output'] = $this->msatker->get_output($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'),$this->data['kdprogram'],$this->data['kdgiat']);
    	
    	$this->data['ikk'] = $this->msatker->get_ikk($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'),$this->data['kdprogram'],$this->data['kdgiat']);
    	
		/*
echo '<pre style="background:white;">';
		var_dump($this->data['output']);
		var_dump($this->data['ikk']);
		echo '</pre>';
*/
    	
    	$this->data['template'] = 'satker/detail_giat';
    	$this->load->view('index',$this->data);
    }
    
    
    /*------------------------------ OUTPUT ------------------------------*/
    function output()
    {
        $this->data['kdsatker'] = $this->kdsatker;
        $this->data['satker_identity'] = $this->msatker->get_satker_identity($this->data['kdsatker']);
        $this->data['nmsatker'] = $this->data['satker_identity']['nmsatker'];
        $this->data['nmunit'] = $this->data['satker_identity']['nmunit'];
        $this->data['nmdept'] = $this->data['satker_identity']['nmdept'];
        $this->data['kdunit'] = $this->data['satker_identity']['kdunit'];
        $this->data['kddept'] = $this->data['satker_identity']['kddept'];

        //fungsi untuk menampilkan daftar program
        $this->data['program'] = $this->msatker->get_satker_program($this->data['kddept'], $this->data['kdunit'], $this->data['kdsatker']);
        $this->data['kdprogram'] = 0;
        $this->data['kdgiat'] = 0;

        if (isset($_POST['program'])) {
            $this->data['kdprogram'] = $this->input->post('program');
            $this->data['kegiatan'] = $this->msatker->get_satker_kegiatan($this->data['kddept'], $this->data['kdunit'], $this->data['kdsatker'], $this->data['kdprogram']);
        }

        if (isset($_POST['kegiatan'])) {
            $this->data['kdprogram'] = $this->input->post('program');
            $this->data['kdgiat'] = $this->input->post('kegiatan');
            $this->data['output'] = $this->msatker->get_output($this->data['kddept'], $this->data['kdunit'], $this->data['kdsatker'], $this->data['kdprogram'], $this->data['kdgiat']);
        }

        $this->data['template'] = 'satker/output';
        $this->load->view('index', $this->data);
    }

    public function do_real_output()
    {
        $do = $this->input->post('submit');
        $this->msatker->set_real_output($do);

        $kdsatker = $this->input->post('kdsatker');
        $this->data['satker_identity'] = $this->msatker->get_satker_identity($kdsatker);
        $this->data['nmsatker'] = $this->data['satker_identity']['nmsatker'];
        $this->data['nmunit'] = $this->data['satker_identity']['nmunit'];
        $this->data['nmdept'] = $this->data['satker_identity']['nmdept'];

        if ($do == 'Simpan') {
            $message = "Data realisasi keluaran telah disimpan, tetapi belum dieskalasi ke Eselon I. Anda dapat mengubahnya kembali.";
        } elseif ($do == 'Proses') {
            $message = "Data realisasi keluaran telah dieskalasi ke Eselon I.";
        }
        $this->data['message'] = $message;
        $this->data['template'] = 'satker/realisasi_status';
        $this->load->view('index', $this->data);
    }

    /*-------------------------------- IKK ---------------------------------*/
    function ikk()
    {
        $this->data['kdsatker'] = $this->kdsatker;
        $this->data['satker_identity'] = $this->msatker->get_satker_identity($this->data['kdsatker']);
        $this->data['nmsatker'] = $this->data['satker_identity']['nmsatker'];
        $this->data['nmunit'] = $this->data['satker_identity']['nmunit'];
        $this->data['nmdept'] = $this->data['satker_identity']['nmdept'];
        $this->data['kdunit'] = $this->data['satker_identity']['kdunit'];
        $this->data['kddept'] = $this->data['satker_identity']['kddept'];

        //fungsi untuk menampilkan daftar program
        $this->data['program'] = $this->msatker->get_satker_program($this->data['kddept'], $this->data['kdunit'], $this->data['kdsatker']);
        $this->data['kdprogram'] = 0;
        $this->data['kdgiat'] = 0;

        if (isset($_POST['program'])) {
            $this->data['kdprogram'] = $this->input->post('program');
            $this->data['kegiatan'] = $this->msatker->get_satker_kegiatan($this->data['kddept'], $this->data['kdunit'], $this->data['kdsatker'], $this->data['kdprogram']);
        }

        if (isset($_POST['kegiatan'])) {
            $this->data['kdprogram'] = $this->input->post('program');
            $this->data['kdgiat'] = $this->input->post('kegiatan');
            $this->data['ikk'] = $this->msatker->get_ikk($this->data['kddept'], $this->data['kdunit'], $this->data['kdsatker'], $this->data['kdprogram'], $this->data['kdgiat']);
        }

        $this->data['template'] = 'satker/ikk';
        $this->load->view('index', $this->data);
    }

    public function do_real_ikk()
    {
        $do = $this->input->post('submit');
        $this->msatker->set_real_ikk($do);

        $kdsatker = $this->input->post('kdsatker');
        $this->data['satker_identity'] = $this->msatker->get_satker_identity($kdsatker);
        $this->data['nmsatker'] = $this->data['satker_identity']['nmsatker'];
        $this->data['nmunit'] = $this->data['satker_identity']['nmunit'];
        $this->data['nmdept'] = $this->data['satker_identity']['nmdept'];

        if ($do == 'Simpan') {
            $message = "Data realisasi IKK telah disimpan, tetapi belum dieskalasi ke Eselon I. Anda dapat mengubahnya kembali.";
        } elseif ($do == 'Proses') {
            $message = "Data realisasi IKK telah dieskalasi ke Eselon I.";
        }
        $this->data['message'] = $message;
        $this->data['template'] = 'satker/realisasi_status';
        $this->load->view('index', $this->data);
    }

    /*-------------------------------- Entri Efisiensi ---------------------------------*/
    function efisien()
    {
        $this->data['kdsatker'] = $this->kdsatker;
        $this->data['satker_identity'] = $this->msatker->get_satker_identity($this->data['kdsatker']);
        $this->data['nmsatker'] = $this->data['satker_identity']['nmsatker'];
        $this->data['nmunit'] = $this->data['satker_identity']['nmunit'];
        $this->data['nmdept'] = $this->data['satker_identity']['nmdept'];
        $this->data['kdunit'] = $this->data['satker_identity']['kdunit'];
        $this->data['kddept'] = $this->data['satker_identity']['kddept'];

        //fungsi untuk menampilkan daftar program
        $this->data['program'] = $this->msatker->get_satker_program($this->data['kddept'], $this->data['kdunit'], $this->data['kdsatker']);
        $this->data['kdprogram'] = 0;
        $this->data['kdgiat'] = 0;

        if (isset($_POST['program'])) {
            $this->data['kdprogram'] = $this->input->post('program');
            $this->data['kegiatan'] = $this->msatker->get_satker_kegiatan($this->data['kddept'], $this->data['kdunit'], $this->data['kdsatker'], $this->data['kdprogram']);
        }

        if (isset($_POST['kegiatan'])) {
            $this->data['kdprogram'] = $this->input->post('program');
            $this->data['kdgiat'] = $this->input->post('kegiatan');
            $this->data['efisien'] = $this->msatker->get_efisien($this->data['kddept'], $this->data['kdunit'], $this->data['kdsatker'], $this->data['kdprogram'], $this->data['kdgiat']);
        }

        $this->data['template'] = 'satker/efisien';
        $this->load->view('index', $this->data);
    }

    public function do_real_efisien()
    {
        $do = $this->input->post('submit');
        $this->msatker->set_real_efisien($do);

        $kdsatker = $this->input->post('kdsatker');
        $this->data['satker_identity'] = $this->msatker->get_satker_identity($kdsatker);
        $this->data['nmsatker'] = $this->data['satker_identity']['nmsatker'];
        $this->data['nmunit'] = $this->data['satker_identity']['nmunit'];
        $this->data['nmdept'] = $this->data['satker_identity']['nmdept'];

        if ($do == 'Simpan') {
            $message = "Data realisasi Efisiensi telah disimpan, tetapi belum dieskalasi ke Eselon I. Anda dapat mengubahnya kembali.";
        } elseif ($do == 'Proses') {
            $message = "Data realisasi Efisiensi telah dieskalasi ke Eselon I.";
        }
        $this->data['message'] = $message;
        $this->data['template'] = 'satker/realisasi_status';
        $this->load->view('index', $this->data);
    }

    public function upload()
    {
        $config['upload_path'] = './tmp/';
        $config['allowed_types'] = 'rar';
        $config['overwrite'] = true;
        $config['max_size'] = '4096';
        $this->load->library('upload', $config);

        if ($_FILES) {

            if ($this->upload->do_upload('file')) {

                $data = $this->upload->data('file');
                $code = substr($data['file_name'], 1, 21);
                $code . "\n\n\n\n";
                $kd_dokumen = substr($code, 0, 2);
                $kd_kementrian = substr($code, 3, 3);
                $kd_unit = substr($code, 6, 2);
                $kd_lokasi = substr($code, 9, 2);
                $kd_satker = substr($code, 12, 6);
                $kd_thang = substr($code, 19, 21);

                $code = $kd_kementrian . $kd_unit . $kd_lokasi . $kd_satker . '.' . $kd_thang;

                $fp = fopen($data['full_path'], 'r');
                $content = fread($fp, $_FILES['file']['size']);
                $content = base64_encode($content);
                fclose($fp);


                $code2 = substr($data['file_name'], 0, 19);


                $this->db->insert('tb_upload', array(
                    'filename' => $data['file_name'],
                    'length' => $_FILES['file']['size'],
                    'data' => $content,
                    'code' => $code . '.' . $kd_thang,
                    'code2' => $code2,
                    //'kdjendok' => $kd_dokumen,
                    'kddept' => $kd_kementrian,
                    'kdunit' => $kd_unit,
                    'kdlokasi' => $kd_lokasi,
                    'kdsatker' => $kd_satker,
//                    'thang' => $kd_thang,
		    'submit_date' => date("Y-m-d H:i:s"),
                ));


            }


            $error = $this->upload->display_errors();
            $this->session->set_flashdata('message', $error);


        }
        echo $this->upload->display_errors();


        $this->data['template'] = 'satker/upload';
        $this->load->view('index', $this->data);
    }
}
