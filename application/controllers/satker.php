<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Satker extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->data['now'] = date("Y-m-d H:i:s");
		$this->data['title'] = '';
		//get Satker model
		$this->load->model('msatker');
		$this->kdsatker = 675713; //inisial kdsatker = 675713 dari tabel t_satker, kdsatker riil diperoleh dari sesi login
		$this->data['nav_title'] = 'Satker '.$this->kdsatker;
		$this->data['nav_menu'] = array(
						0 => 'Entri Data Capaian Output',
						1 => 'Entri Data IKK',
						2 => 'Entri Data IKU',
						3 => 'Entri Data Penyerapan Efisiensi',
						4 => 'Entri Data Revisi'
						);
	}
	
	function index()
	{
		$this->data['title'] = 'Dashboard';
		$this->data['template'] = 'satker/index';
		$this->load->view('index', $this->data);
	}
        
	function program()
	{
		$kdsatker = $this->kdsatker;						
		$this->data['satker_identity'] = $this->msatker->get_satker_identity($kdsatker);
		$this->data['nmsatker'] = $this->data['satker_identity']['nmsatker'];
                $this->data['nmunit'] = $this->data['satker_identity']['nmunit'];
                $this->data['nmdept'] = $this->data['satker_identity']['nmdept'];
		$kdunit = $this->data['satker_identity']['kdunit'];
		$kddept = $this->data['satker_identity']['kddept'];
		
		//fungsi untuk menampilkan daftar program		
		$this->data['program'] = $this->msatker->get_satker_program($kddept, $kdunit, $kdsatker);
		
		$this->data['template'] = 'satker/program';
		$this->load->view('index', $this->data);
	}
        
        public function kegiatan($kegiatan='')
        {
		$param = explode("-",$kegiatan);
		$kddept = $param[0]; 
		$kdunit = $param[1];
		$kdsatker = $param[2];
		$kdprogram = $param[3];
		
		$this->data['satker_identity'] = $this->msatker->get_satker_identity($kdsatker);
		$this->data['nmsatker'] = $this->data['satker_identity']['nmsatker'];
		$this->data['nmunit'] = $this->data['satker_identity']['nmunit'];
		$this->data['nmdept'] = $this->data['satker_identity']['nmdept'];
		$this->data['kegiatan'] = $this->msatker->get_satker_kegiatan($kddept, $kdunit, $kdsatker, $kdprogram);
		$this->data['program'] = $this->data['kegiatan'][0]['nmprogram'];
		
		$this->data['template'] = 'satker/kegiatan';
		$this->load->view('index', $this->data);
        }
        
        public function realisasi($realisasi='')
        {
		$param = explode("-",$realisasi);
		$kddept = $param[0]; 
		$kdunit = $param[1];
		$kdsatker = $param[2];
		$kdprogram = $param[3];
		$kdgiat = $param[4];
		
		$this->data['satker_identity'] = $this->msatker->get_satker_identity($kdsatker);
		$this->data['nmsatker'] = $this->data['satker_identity']['nmsatker'];
		$this->data['nmunit'] = $this->data['satker_identity']['nmunit'];
		$this->data['nmdept'] = $this->data['satker_identity']['nmdept'];
		$this->data['kddept'] = $kddept;
		$this->data['kdunit'] = $kdunit;
		$this->data['kdsatker'] = $kdsatker;
		$this->data['kdprogram'] = $kdprogram;
		$this->data['kdgiat'] = $kdgiat;
		$this->data['output'] = $this->msatker->get_satker_output($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat);
		$this->data['program'] = $this->data['output'][0]['nmprogram'];
		$this->data['kegiatan'] = $this->data['output'][0]['nmgiat'];
		
		$this->data['template'] = 'satker/realisasi';
		$this->load->view('index', $this->data);
        }
               
	public function do_realisasi()
	{
		$do = $this->input->post('submit');
		$this->msatker->set_satker_realisasi($do);
				
		$kdsatker = $this->input->post('kdsatker');
		$this->data['satker_identity'] = $this->msatker->get_satker_identity($kdsatker);
		$this->data['nmsatker'] = $this->data['satker_identity']['nmsatker'];
		$this->data['nmunit'] = $this->data['satker_identity']['nmunit'];
		$this->data['nmdept'] = $this->data['satker_identity']['nmdept'];		
		
		if($do == 'Simpan'){
			$message = "Data realisasi keluaran telah disimpan, tetapi belum dieskalasi ke Eselon I. Anda dapat mengubahnya kembali.";
		} elseif($do == 'Eskalasi') {
			$message = "Data realisasi keluaran telah dieskalasi ke Eselon I.";
		}
		$this->data['message'] = $message;
		$this->data['template'] = 'satker/realisasi_status';
		$this->load->view('index', $this->data);
	}	
}