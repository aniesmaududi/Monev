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
<<<<<<< HEAD
        $this->data['kdunit'] = $this->session->userdata('kdunit'); // 11
		$this->data['kddept'] = $this->session->userdata('kddept'); // 015
		$this->data['kdprogram'] = null;
        $this->_iskl = FALSE;
        
        

=======
        $this->data['kdunit'] = $this->session->userdata('kdunit');
		$this->data['kddept'] = $this->session->userdata('kddept');
		$this->data['kdsatker'] = $this->session->userdata('kddept');
		$this->data['kdprogram'] = null;
>>>>>>> 632013b0353ed3beebd36dfa26dc508698a933b9
    }

    function index()
    {
        $this->data['title'] = 'Dashboard Satker';
		$this->data['thang'] = '2011';
		if(isset($_POST['thang']) && $_POST['thang'] != 0):
			$this->data['thang'] = $_POST['thang'];
		endif;
		$this->data['penyerapan'] = get_penyerapan($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram']);
		$this->data['konsistensi'] = get_konsistensi($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		$this->data['keluaran'] = get_keluaran($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		$this->data['efisiensi'] = get_efisiensi($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		
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
    public function keluaran_table()
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
    	
        $this->data['template'] = 'satker/keluaran';
    	$this->load->view('index',$this->data);
    }

    /*------------------------------------------- Pengukuran Efisiensi ----------------------*/
    public function efisiensi()
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
    	
        $this->data['template'] = 'satker/efisien';
    	$this->load->view('index',$this->data);
    }

    /*------------------------------------------- Capaian Hasil ----------------------*/
    public function capaian_hasil()
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
    	
        $this->data['template'] = 'satker/hasil';
    	$this->load->view('index',$this->data);   
    }

    /*------------------------------------------- Aspek Evaluasi ----------------------*/
    public function aspek_evaluasi()
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
    	
        $this->data['template'] = 'satker/evaluasi';
    	$this->load->view('index',$this->data);
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
