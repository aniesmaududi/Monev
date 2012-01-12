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
function get_penyerapan($thang="2011",$kddept=null,$kdunit=null,$kdprogram=null,$total=false)
{
	$ci = & get_instance();
	$ci->load->database();
	if($total==true):
		$sql = 'select sum(pagu) as pagu, sum(realisasi) as realisasi, round(avg(p),2) as p,thang,kddept,kdunit,kdprogram
		from tb_penyerapan_anggaran
		where thang='.$thang.' ';
	else:
		$sql = 'select pagu,realisasi,p,thang,kddept,kdunit,kdprogram
		from tb_penyerapan_anggaran
		where thang='.$thang.' ';
	endif;
	if(isset($kddept)):
		$sql .= 'and kddept='.$kddept.' ';
	endif;
	if(isset($kdunit)):
		$sql .= 'and kdunit='.$kdunit.' ';
	endif;
	if(isset($kdprogram)):
		$sql .= 'and kdprogram='.$kdprogram.' ';
	endif;
	if($total==true):
		return $ci->db->query($sql)->row();
	else:
		return $ci->db->query($sql)->result();
	endif;
}

// untuk ambil data penyerapan dari tb_penyerapan_anggaran
function get_konsistensi($thang="2011",$bulan=null,$kddept=null,$kdunit=null,$kdprogram=null)
{
	$ci = & get_instance();
	$ci->load->database();
	
	$sql = 'select sum(jmlrpd) as rpd, sum(jmlrealisasi) as realisasi, round(avg(k),2) as konsistensi,thang,bulan,kddept,kdunit,kdprogram
	from tb_konsistensi
	where thang='.$thang.' ';
	$group = ' group by thang,bulan';
	if(isset($bulan)):
		$sql .= 'and bulan='.$bulan.' ';
		$group .= '';
	endif;
	if(isset($kddept)):
		$sql .= 'and kddept='.$kddept.' ';
		$group .= ',kddept';
	endif;
	if(isset($kdunit)):
		$sql .= 'and kdunit='.$kdunit.' ';
		$group .= ',kdunit';
	endif;
	if(isset($kdprogram)):
		$sql .= 'and kdprogram='.$kdprogram.' ';
		$group .= ',kdprogram';
	endif;
	
	return $ci->db->query($sql.$group)->result();
}