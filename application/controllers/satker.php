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
		$this->load->model('mdja');
        $this->kdsatker = $this->session->userdata('kdsatker');
		$this->data['dashboard_menu_link'] =  base_url().'satker/';
		$this->data['kddept'] = $this->session->userdata('kddept');
		$this->data['kdunit'] = $this->session->userdata('kdunit');
		$this->data['kdsatker'] = $this->session->userdata('kdsatker');
		$this->data['kdprogram'] = null;
		$this->data['kdgiat'] = null;
    }

    function index()
    {
        $this->data['title'] = 'Dashboard Satker';
		$this->data['thang'] = '2011';
		if(isset($_POST['thang']) && $_POST['thang'] != 0):
			$this->data['thang'] = $_POST['thang'];
		endif;
		$this->data['penyerapan'] = get_penyerapan($this->data['thang'], $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'], $this->data['kdsatker'], $this->data['kdgiat']);
		$this->data['konsistensi'] = get_konsistensi($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		$this->data['keluaran'] = get_keluaran($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		$this->data['efisiensi'] = get_efisiensi($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		
        $this->data['template'] = 'satker/index';
        $this->load->view('index', $this->data);
    }

    /*-------------------------------- Laporan ----------------------------------*/
    /*------------------------------- Penyerapan Anggaran ----------------------*/
    function penyerapan()
    {
		$this->data['title'] = 'Pengukuran Penyerapan Anggaran';        
        $this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
        $this->data['kdprogram'] = null;    
        
       	$thang = $this->input->post('thang');
		if(empty($thang)) { $thang = '2011'; }
		$this->data['thang'] = $thang;
		
		if((isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0))
        {
            $this->data['kdprogram'] = $_POST['kdprogram'];
			$this->data['giat'] = get_giat($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram']);
        }
		if((isset($_POST['kdgiat']) && $_POST['kdgiat'] != 0))
        {
			$this->data['kdgiat'] = $_POST['kdgiat'];
        }
		$kddept = $this->data['kddept'];
		$kdunit = $this->data['kdunit'];
		$kdprogram = $this->data['kdprogram'];
		$kdsatker = $this->data['kdsatker'];
		$kdgiat = $this->data['kdgiat'];
		
		$this->data['penyerapan'] = get_penyerapan($this->data['thang'], $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'], $this->data['kdsatker'], $this->data['kdgiat']);
        $this->data['template'] = 'satker/penyerapan';  
        $this->load->view('index', $this->data);
    }

    /*---------------------Konsistensi antara Perencanaan dan Implementasi ----------------------*/
    function konsistensi()
    {
        $this->data['title'] = 'Konsistensi Antara Perencanaan dan Implementasi';
        $this->data['pengukuran'] = 'konsistensi';
		$this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
		$this->data['kdprogram'] = null;
        $thang = $this->input->post('thang');
		if(empty($thang)) { $thang = '2011'; }
		$this->data['thang'] = $thang;
       
        if((isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0))
        {
            $this->data['kdprogram'] = $_POST['kdprogram'];
        }
		
		$this->data['konsistensi'] = get_report_konsistensi($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
        $this->data['template'] = 'satker/konsistensi';
        $this->load->view('index', $this->data);
    }

    /*----------------------------- Pengukuran Volume Keluaran ----------------------*/
    public function keluaran()
    {
        $this->data['title'] = 'Tingkat Pencapaian Keluaran';
        $this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
        $thang = $this->input->post('thang');
		if(empty($thang)) { $thang = '2011'; }
		$this->data['thang'] = $thang;
        $this->data['kdprogram'] = null;      
		$this->data['kdgiat'] = null; 		
        
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
		$config['base_url'] 	= base_url().'satker/keluaran/';
		$config['total_rows'] 	= count($this->mdja->get_volume_keluaran($thang, $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'], $this->data['kdgiat']));
		$config['per_page'] 	= 15; 
		$config['cur_page'] 	= $this->data['halaman'];
		$this->pagination->initialize($config);
		$this->data['page'] 	= $this->pagination->create_links();
		$this->data['output'] 	= $this->mdja->get_volume_keluaran($thang, $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'], $this->data['kdgiat'], $config['per_page'],$config['cur_page']);
		
        $this->data['template'] = 'satker/keluaran';                 
        $this->load->view('index', $this->data);
    }

    /*----------------------------- Pengukuran Efisiensi ----------------------*/
    public function efisiensi()
    {
        $this->data['title'] = 'Pengukuran Efisiensi';    
        $this->data['program'] = get_program($this->data['kddept'], $this->data['kdunit']);
        $thang = $this->input->post('thang');
		if(empty($thang)) { $thang = '2011'; }
		$this->data['thang'] = $thang;
        $this->data['kdprogram'] = null;                
        
        if((isset($_POST['kdprogram']) && $_POST['kdprogram'] != 0))
        {
            $this->data['kdprogram'] = $_POST['kdprogram'];
			$this->data['giat'] = get_giat($this->data['thang'], $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram']);			
        }
		if((isset($_POST['kdgiat']) && $_POST['kdgiat'] != 0))
        {
            $this->data['kdgiat'] = $_POST['kdgiat'];
		}
        
		//get volume keluaran
		$this->data['output'] = $this->mdja->get_volume_keluaran($thang, $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'], $this->data['kdsatker']);
		
        $this->data['template'] = 'satker/efisiensi';    
        $this->load->view('index', $this->data);
    }

    /*----------------------------- Capaian Hasil ----------------------*/
    public function capaian_hasil()
    {
        // pending
    }

    /*------------------------------------------- Aspek Evaluasi ----------------------*/
    public function aspek_evaluasi()
    {
	// pending
    }

    /*------------------------------ End of Laporan ------------------------------*/


    /*------------------------------ KEGIATAN ------------------------------*/
    //edited by Radita

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
    
    function detail_giat($kdgiat)
    {
    	//this part loads get_satker_program content according to satker's id 
    	$this->data['program'] = $this->msatker->get_satker_program($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'));
    	$this->data['nmprogram'] = $this->data['program'][0]['nmprogram'];
    	$this->data['kdprogram'] = $this->data['program'][0]['kdprogram'];
    	
    	//this part loads kegiatan
    	$this->data['kegiatan'] = $this->msatker->get_satker_kegiatan($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'),$this->data['kdprogram']);
    	$this->data['kdgiat'] = $kdgiat;
	$detail_giat = $this->msatker->get_detail_giat($kdgiat);
	$this->data['nmgiat'] = $detail_giat['nmgiat'];

    	//this part loads output
    	$this->data['output'] = $this->msatker->get_output($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'),$this->data['kdprogram'],$kdgiat);
    	
    	$this->data['ikk'] = $this->msatker->get_ikk($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'),$this->data['kdprogram'],$kdgiat);
    	
   	$this->data['template'] = 'satker/detail_giat';
    	$this->load->view('index',$this->data);
    }
    
    function revisi()
    {
    	//this part loads get_satker_program content according to satker's id 
    	$this->data['program'] = $this->msatker->get_satker_program_revisi($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'));
    	if($this->data['program']):
			$this->data['nmprogram'] = $this->data['program'][0]['nmprogram'];
			$this->data['kdprogram'] = $this->data['program'][0]['kdprogram'];
			$this->data['revisi'] = $this->msatker->get_satker_kegiatan_revisi($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'),$this->data['kdprogram']);
    	endif;
    	//this part loads kegiatan
    	
    	$this->data['template'] = 'satker/revisi';
    	$this->load->view('index',$this->data);
    }
    
    function detail_revisi($kdgiat)
    {
    	//this part loads get_satker_program content according to satker's id 
    	$this->data['program'] = $this->msatker->get_satker_program($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'));
    	$this->data['nmprogram'] = $this->data['program'][0]['nmprogram'];
    	$this->data['kdprogram'] = $this->data['program'][0]['kdprogram'];
    	
    	//this part loads kegiatan
    	$this->data['kegiatan'] = $this->msatker->get_satker_kegiatan($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'),$this->data['kdprogram']);
    	$this->data['kdgiat'] = $kdgiat;
	$detail_giat = $this->msatker->get_detail_giat($kdgiat);
	$this->data['nmgiat'] = $detail_giat['nmgiat'];

    	//this part loads output
    	$this->data['output'] = $this->msatker->get_output($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'),$this->data['kdprogram'],$kdgiat);
    	
    	$this->data['ikk'] = $this->msatker->get_ikk($this->session->userdata('kddept'),$this->session->userdata('kdunit'),$this->session->userdata('kdsatker'),$this->data['kdprogram'],$kdgiat);
    	
   	$this->data['template'] = 'satker/detail_giat';
    	$this->load->view('index',$this->data);
    }
    
    /*------------------------------ OUTPUT ------------------------------*/    
    public function do_real_output()
    {
	$kdgiat = $this->input->post('kdgiat');
        $do = $this->input->post('submit');
        $this->msatker->set_real_output($do);

        if ($do == 'Simpan') {
            $message = "Data realisasi keluaran telah disimpan, tetapi belum dieskalasi ke Eselon I. Anda dapat mengubahnya kembali.";
        } elseif ($do == 'Proses') {
            $message = "Data realisasi keluaran telah dieskalasi ke Eselon I.";
        }
	$this->session->set_flashdata('message', $message);
	redirect('satker/detail_giat/'.$kdgiat);        
    }

    /*-------------------------------- IKK ---------------------------------*/
    function ikk()
    {
        // belum diaplikasikan, karena data antara Output dan IKK belum bisa berelasi [anies]
    }

    public function do_real_ikk()
    {
	// belum diaplikasikan, karena data antara Output dan IKK belum bisa berelasi [anies]
	/*
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
	*/
    }

    /*-------------------------------- Catatan Satker ---------------------------------*/
    function catatan()
    {
        // untuk menulis catatan dari satker ke eselon terkait proses input, kendala, dan lain-lain
	$this->data['title'] = 'Catatan Penting';
	$this->data['subtitle'] = 'Catatan ini untuk disampaikan kepada Eselon I perihal capaian kinerja, kendala, dan lain-lain.';
		$this->data['thang'] = '2011';
		if(isset($_POST['thang']) && $_POST['thang'] != 0):
			$this->data['thang'] = $_POST['thang'];
		endif;
		$this->data['penyerapan'] = get_penyerapan($this->data['thang'], $this->data['kddept'], $this->data['kdunit'], $this->data['kdprogram'], $this->data['kdsatker'], $this->data['kdgiat']);
		$this->data['konsistensi'] = get_konsistensi($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		$this->data['keluaran'] = get_keluaran($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		$this->data['efisiensi'] = get_efisiensi($this->data['thang'],$this->data['kddept'],$this->data['kdunit'],$this->data['kdprogram'],$this->data['kdsatker']);
		
	$this->data['template'] = 'satker/catatan';
    	$this->load->view('index',$this->data);
    }
    
    function history_catatan()
    {
        // untuk menulis catatan dari satker ke eselon terkait proses input, kendala, dan lain-lain
	$this->data['title'] = 'Rekaman Catatan';
	$this->data['subtitle'] = 'Catatan ini untuk disampaikan kepada Eselon I perihal capaian kinerja, kendala, dan lain-lain.';
	$this->data['catatan'] = $this->msatker->get_catatan();
	$this->data['template'] = 'satker/history_catatan';
    	$this->load->view('index',$this->data);
    }
    
    public function do_catatan()
    {		
        $do = $this->input->post('submit');
        $this->msatker->set_catatan($do);

        if ($do == 'Simpan') {
            $message = "Catatan Anda telah direkam untuk diteruskan ke Eselon I";
        }
	
	$this->session->set_flashdata('message', $message);
	redirect('satker/catatan/');	
    }

    /*-------------------------------- Upload ---------------------------------*/
	/*
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
		    //'thang' => $kd_thang,
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
	
	*/
	
	/*---------- CAPTCHA & UPLOAD ---------------*/
	
	function _make_captcha()
	{
		$this->load->helper('captcha');
		$vals = array(
		'img_path' => './captcha/', 
		'img_url' => base_url().'captcha/', 
		'img_width' => 200, 
		'img_height' => 60, 
		// 'font_path'    => '../system/fonts/2.ttf',
		 'expiration' => 300 ,
		);
		// Create captcha
		$cap = create_captcha( $vals );
		// Write to DB
		if ($cap) {
			$data = array(
			'captcha_id' => '',
			'captcha_time' => $cap['time'],
			'ip_address' => $this->input->ip_address(),
			'word' => $cap['word'] ,
			);
			$query = $this ->db->insert_string('captcha',$data );
			$this->db->query($query);
		}else{
			return "Umm captcha not work";
		}
		return $cap['image'] ;
	}

	function _check_capthca()
	{
		// Delete old data ( 2hours)
		$expiration = time()-300 ;
		$sql = " DELETE FROM captcha WHERE captcha_time < ? ";
		$binds = array($expiration);
		$query = $this->db->query($sql, $binds);
		 
		//checking input
		$sql = "SELECT COUNT(*) AS count FROM captcha WHERE LOWER(word) = LOWER(?) AND ip_address = ? AND captcha_time > ?";
		$binds = array($_POST['captcha'], $this->input->ip_address(), $expiration);
		$query = $this->db->query($sql, $binds);
		$row = $query->row();

		if ($row->count>0)
		{
			return true;
		}
		return false;
	}
	
	function upload()
	{
		$captcha_result = '';
		$this->data['cap_img'] = $this->_make_captcha();
		$this->data['file'] = $this->input->post('file');
		if($this->input->post('submit')) //press submit
		{
			if($this->_check_capthca()) //check captcha true
			{
		echo 'test';
				$config['upload_path'] = './tmp/';
				$config['allowed_types'] = 'rar';
				$config['overwrite'] = true;
				$config['max_size'] = '4096';
				$this->load->library('upload', $config);		
				if ($_FILES) //check if file selected
				{ 
					if ($this->upload->do_upload('file')) //check file extention
					{ 
						$data = $this->upload->data('file');
						$code = substr($data['file_name'], 1, 21);
						$code . "\n\n\n\n";
						$kd_dokumen = substr($code, 0, 2);
						$kd_kementrian = substr($code, 3, 3);
						$kd_unit = substr($code, 6, 2);
						$kd_lokasi = substr($code, 9, 2);
						$kd_satker = substr($code, 12, 6);
						$kd_thang = substr($code, 19, 21);
						$check = substr($data['file_name'], 20, 7); //check jika di string tersebut mengandung 12_.rar

						if($check=='12_.rar') //check format filename.. format pengecekan di cek lagi
						{ 
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

							$filename = substr($data['file_name'], 0, 21);
							$filename1 = substr($data['file_name'], 20, 7);
					
							$kd_file = $this->msatker->get_kd_file($filename);
							foreach($kd_file as $hasil)
							{
							}
					
							$message = 'Upload sukses, anda mendapat antrian ke-'.$hasil->id.'.';
							$this->session->set_flashdata('message_type', 'success');
							$this->session->set_flashdata('message', $message);
						} // end check format filename
						else //false format filename 
						{
							$error = 'Format penamaan file tidak sesuai';
							$this->session->set_flashdata('message', $error);
						} //end false format filename 
					} //end check file extention
					else //false file extention
					{
						$error = $this->upload->display_errors(); //You did not select a file to upload. OR. The filetype you are attempting to upload is not allowed.
						$this->session->set_flashdata('message', $error);
					} //end false file extention
				} //end check if file selected
				else //no file selected
				{
						$this->session->set_flashdata('message', 'File tidak ada');
				} //end of no file selected
			} //end check captcha true
			else
			{
				$this->session->set_flashdata('message', 'captcha gagal');
			}
					redirect ('satker/upload');
		} //end press submit
		$this->data['template'] = 'satker/upload';
		$this->load->view('index', $this->data);
	
	
	}


	
	
	
}
