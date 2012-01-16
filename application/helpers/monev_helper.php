<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// pengecekan sudah login apa belum
function is_adminlogin()
{
    $ci = & get_instance();
    if (!$ci->session->userdata('admin_ID') && !$ci->session->userdata('admin_username')
            && !$ci->session->userdata('user_jabid') && $ci->uri->segment(2) != 'login') :
        redirect('backend/login');
    elseif ($ci->session->userdata('user_id') && $ci->session->userdata('user_nama')
            && $ci->session->userdata('user_jabid') && $ci->uri->segment(2) == 'login') :
		redirect('backend');
    endif;
}
	
// pengecekan sudah login apa belum
function is_login($redirect=TRUE)
{
    $ci = & get_instance();
    if (!$ci->session->userdata('username') && !$ci->session->userdata('nama')
            && !$ci->session->userdata('jabatan') && $ci->uri->segment(2) != 'login') :
		if(!$redirect):
			return FALSE;
		else:
			redirect('login');
		endif;
    elseif ($ci->session->userdata('username') && $ci->session->userdata('nama')
            && $ci->session->userdata('jabatan') && $ci->uri->segment(2) == 'login') :
		redirect('dashboard');
    endif;
}

// untuk sanitize string
function sanitize_string($str)
{
	$str = strip_tags($str);
    $str = htmlentities($str, ENT_QUOTES);
    return $str;
}

// untuk ambil data penyerapan dari tb_penyerapan_anggaran
function get_penyerapan($thang="2011",$kddept=null,$kdunit=null,$kdprogram=null)
{
	$ci = & get_instance();
	$ci->load->database();
	$sql = 'select round(avg(p),2) as p
	from tb_penyerapan_anggaran
	where thang='.$thang.' ';
	
	if(isset($kddept)):
		$sql .= 'and kddept='.$kddept.' ';
	endif;
	if(isset($kdunit)):
		$sql .= 'and kdunit='.$kdunit.' ';
	endif;
	if(isset($kdprogram)):
		$sql .= 'and kdprogram='.$kdprogram.' ';
	endif;
	return $ci->db->query($sql)->row();
}

// untuk ambil data konsistensi dari tb_konsistensi
function get_konsistensi($thang="2011",$kddept=null,$kdunit=null,$kdprogram=null)
{
	$ci = & get_instance();
	$ci->load->database();
	
	$sql = 'select round(avg(k),2) as k
	from tb_konsistensi
	where thang='.$thang.' ';
	
	if(isset($kddept)):
		$sql .= 'and kddept='.$kddept.' ';
	endif;
	if(isset($kdunit)):
		$sql .= 'and kdunit='.$kdunit.' ';
	endif;
	if(isset($kdprogram)):
		$sql .= 'and kdprogram='.$kdprogram.' ';
	endif;
	return $ci->db->query($sql)->row();
}

// untuk ambil data keluaran dari tb_keluaran
function get_keluaran($thang="2011",$kddept=null,$kdunit=null,$kdprogram=null)
{
	$ci = & get_instance();
	$ci->load->database();
	$sql = 'select round(avg(pk),2) as pk
	from tb_keluaran
	where thang='.$thang.' ';
	
	if(isset($kddept)):
		$sql .= 'and kddept='.$kddept.' ';
	endif;
	if(isset($kdunit)):
		$sql .= 'and kdunit='.$kdunit.' ';
	endif;
	if(isset($kdprogram)):
		$sql .= 'and kdprogram='.$kdprogram.' ';
	endif;
	return $ci->db->query($sql)->row();
}

// untuk ambil data efisiensi dari tb_efisiensi
function get_efisiensi($thang="2011",$kddept=null,$kdunit=null,$kdprogram=null)
{
	$ci = & get_instance();
	$ci->load->database();
	$sql = 'select round(avg(e),2) as e
	from tb_efisiensi
	where thang='.$thang.' ';
	
	if(isset($kddept)):
		$sql .= 'and kddept='.$kddept.' ';
	endif;
	if(isset($kdunit)):
		$sql .= 'and kdunit='.$kdunit.' ';
	endif;
	if(isset($kdprogram)):
		$sql .= 'and kdprogram='.$kdprogram.' ';
	endif;
	return $ci->db->query($sql)->row();
}

// untuk ambil data konsistensi perbulan dari tb_konsistensi
function get_konsistensi_perbulan($thang="2011",$bulan=null,$kddept=null,$kdunit=null,$kdprogram=null)
{
	$ci = & get_instance();
	$ci->load->database();
	$sql = 'SELECT 
			bulan, 
			sum( jmlrpd ) AS rpd, 
			sum( jmlrealisasi ) AS realisasi, 
			round( avg( k ) , 2 ) AS konsistensi
		FROM tb_konsistensi
		WHERE thang ='.$thang.' ';
	
	$group = '';
	if(isset($bulan)):
		$sql .= 'and bulan='.$bulan.' ';
	endif;
	if(isset($kddept)):
		$sql .= 'and kddept='.$kddept.' ';
		$group .= ', kddept';
	endif;
	if(isset($kdunit)):
		$sql .= 'and kdunit='.$kdunit.' ';
		$group .= ', kdunit';
	endif;
	if(isset($kdprogram)):
		$sql .= 'and kdprogram='.$kdprogram.' ';
		$group .= ', kdprogram';
	endif;
	
	$sql .=' GROUP BY thang, bulan'.$group;
	return $ci->db->query($sql)->row();
}

/* helper untuk backend */
function get_unit()
{
	$ci = & get_instance();
	$ci->load->database();
	
	return $unit = $ci->db->get('t_unit')->result();
}

function get_dept()
{
	$ci = & get_instance();
	$ci->load->database();
	
	return $dept = $ci->db->get('t_dept')->result();
}

function get_kabkota()
{
	$ci = & get_instance();
	$ci->load->database();
	
	return $kabkota = $ci->db->get('t_kabkota')->result();
}

function get_lokasi()
{
	$ci = & get_instance();
	$ci->load->database();
	
	return $lokasi = $ci->db->get('t_lokasi')->result();
}
function get_jnssat()
{
	$ci = & get_instance();
	$ci->load->database();
	
	return $jnssat = $ci->db->get('t_jnssat')->result();
}
function get_kppn()
{
	$ci = & get_instance();
	$ci->load->database();
	
	return $kppn = $ci->db->get('t_kppn')->result();
}