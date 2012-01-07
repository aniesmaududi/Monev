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
        $this->data['nav_title'] = 'Dirjen Anggaran';
        $this->data['nav_menu'] = array(
                                        0 => 'Penyerapan Anggaran',
                                        1 => 'Konsistensi',
                                        2 => 'Pencapaian Hasil Keluaran',
                                        3 => 'Efisiensi',
                                        4 => 'Penilaian Capaian Hasil',
                                        5 => 'Penilaian Aspek Evaluasi',
                                        );
        $this->data['nav_menu_link'] = array(
                                        0 => base_url().'dja/penyerapan',
                                        1 => base_url().'dja/konsistensi',
                                        2 => base_url().'dja/keluaran',
                                        3 => base_url().'dja/efisiensi',
                                        4 => '#',
                                        5 => '#',
                                        );
    }
    
    function index()
    {
        $this->data['title'] = 'Dashboard';        
                
        $this->data['template'] = 'dja/index';
        $this->load->view('index', $this->data);
    }
    
    /*------------------------------------------- Penyerapan Anggaran ----------------------*/
    function penyerapan($penyerapan="")
    {
        $this->data['title'] = 'Pengukuran Penyerapan Anggaran';
        $this->data['pengukuran'] = 'penyerapan';
        $param = explode('-', $penyerapan);
                  
        if(count($param) == 3)
        {
            $dept = $param[0];
            $unit = $param[1];
            $program = $param[2];
            $pagu = $this->mdja->get_pagu_anggaran('2011', $dept, $unit, $program, false);
            if(count($pagu) > 0)
            {
                $this->data['kddept'] = $pagu['kddept'];
                $this->data['dept'] = $pagu['nmdept'];
                $this->data['kdunit'] = $pagu['kdunit'];
                $this->data['unit'] = $pagu['nmunit'];
                $this->data['kdprogram'] = $pagu['kdprogram'];
                $this->data['program'] = $pagu['nmprogram'];
                $this->data['total_pagu'] = $pagu['total'];
            } else {
                $this->data['kddept'] = 0;
                $this->data['dept'] = 0;
                $this->data['kdunit'] = 0;
                $this->data['unit'] = 0;
                $this->data['kdprogram'] = 0;
                $this->data['program'] = 0;
                $this->data['total_pagu'] = 0;
            }
            $realisasi = $this->mdja->get_realisasi_anggaran($dept, $unit, $program);
            $this->data['total_realisasi'] = $realisasi['total'];
            $this->data['template'] = 'dja/penyerapan';            
        }
        elseif(count($param) == 2)
        {
            $dept = $param[0];
            $unit = $param[1];
            $this->data['program'] = $this->mdja->get_program($dept, $unit);
            $this->data['dept'] = $this->data['program'][0]['nmdept'];
            $this->data['unit'] = $this->data['program'][0]['nmunit'];
            $this->data['button'] = 'Penyerapan Anggaran';
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
    
    /*---------------------Konsistensi antara Perencanaan dan Implementasi ----------------------*/
    function konsistensi($konsistensi="")
    {
        $this->data['title'] = 'Konsistensi antara Perencanaan dan Implementasi';
        $this->data['pengukuran'] = 'konsistensi';
        $param = explode('-', $konsistensi);
                  
        if(count($param) == 3)
        {
            $dept = $param[0];
            $unit = $param[1];
            $program = $param[2];
            $rpd = $this->mdja->get_rpd($dept, $unit, $program);
            if(count($rpd) > 0)
            {
                $this->data['kddept'] = $rpd['kddept'];
                //$this->data['dept'] = $rpd['nmdept'];
                $this->data['kdunit'] = $rpd['kdunit'];
                //$this->data['unit'] = $rpd['nmunit'];
                //$this->data['kdprogram'] = $rpd['kdprogram'];
                //$this->data['program'] = $rpd['nmprogram'];
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
                $this->data['jml01'] = 0;
                $this->data['jml02'] = 0;
                $this->data['jml03'] = 0;
                $this->data['jml04'] = 0;
                $this->data['jml05'] = 0;
                $this->data['jml06'] = 0;
                $this->data['jml07'] = 0;
                $this->data['jml08'] = 0;
                $this->data['jml09'] = 0;
                $this->data['jml10'] = 0;
                $this->data['jml11'] = 0;
                $this->data['jml12'] = 0;
            }
            
            $this->data['realisasi'] = $this->mdja->get_realisasi_bulanan($dept, $unit);
            
            $this->data['template'] = 'dja/konsistensi';            
        }
        elseif(count($param) == 2)
        {
            $dept = $param[0];
            $unit = $param[1];
            //$this->data['program'] = $this->mdja->get_program($dept, $unit);
            //$this->data['dept'] = $this->data['program'][0]['nmdept'];
            //$this->data['unit'] = $this->data['program'][0]['nmunit'];
            $this->data['button'] = 'Konsistensi';
            $rpd = $this->mdja->get_rpd($dept, $unit);
            if(count($rpd) > 0)
            {
                $this->data['kddept'] = $rpd['kddept'];
                //$this->data['dept'] = $rpd['nmdept'];
                $this->data['kdunit'] = $rpd['kdunit'];
                //$this->data['unit'] = $rpd['nmunit'];
                //$this->data['kdprogram'] = $rpd['kdprogram'];
                //$this->data['program'] = $rpd['nmprogram'];
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
                $this->data['jml01'] = 0;
                $this->data['jml02'] = 0;
                $this->data['jml03'] = 0;
                $this->data['jml04'] = 0;
                $this->data['jml05'] = 0;
                $this->data['jml06'] = 0;
                $this->data['jml07'] = 0;
                $this->data['jml08'] = 0;
                $this->data['jml09'] = 0;
                $this->data['jml10'] = 0;
                $this->data['jml11'] = 0;
                $this->data['jml12'] = 0;
            }
            
            $this->data['realisasi'] = $this->mdja->get_realisasi_bulanan($dept, $unit);
            
            $this->data['template'] = 'dja/konsistensi';
            //$this->data['template'] = 'dja/program';            
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
    
    /*------------------------------------------- Pengukuran Volume Keluaran ----------------------*/
    public function keluaran($keluaran="")
    {
        $this->data['title'] = 'Pengukuran Pencapaian Hasil Keluaran';
        $this->data['pengukuran'] = 'keluaran';
        $param = explode('-', $keluaran);
                  
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
            $this->data['template'] = 'dja/keluaran';            
        }
        elseif(count($param) == 2)
        {
            $dept = $param[0];
            $unit = $param[1];
            $this->data['program'] = $this->mdja->get_program($dept, $unit);
            $this->data['dept'] = $this->data['program'][0]['nmdept'];
            $this->data['unit'] = $this->data['program'][0]['nmunit'];
            $this->data['button'] = 'Pencapaian Keluaran';
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
    
    /*------------------------------------------- Pengukuran Efisiensi ----------------------*/
    public function efisiensi($efisiensi="")
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