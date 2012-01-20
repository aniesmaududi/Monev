<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*------------------------------------------------------------------------------*/
/* SESSION AND LOGIN */
/*------------------------------------------------------------------------------*/
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

/*------------------------------------------------------------------------------*/
/* MISC AND FORMATING */
/*------------------------------------------------------------------------------*/
// untuk sanitize string
function sanitize_string($str)
{
	$str = strip_tags($str);
    $str = htmlentities($str, ENT_QUOTES);
    return $str;
}
// untuk format bulan by $i
function format_bulan($i,$format="signed")
{
	if($format=="signed"):
		$bulan = ($i<10) ? '0'.$i : $i;
	else:
		$array_bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
		if($format=="long"):
			$bulan = $array_bulan[$i];
		elseif($format=="short"):
			$bulan = substr($array_bulan[$i],0,3);
		endif;
	endif;
	return $bulan;
}
// pembulatan juta
function pembulatan_juta($num)
{
	$num_bulat = $num;
	if($num>1000000):
		$num_bulat = substr($num, 0, -6);
		$num_juta = substr($num, -6);
		if($num_juta>=500000):
			$num_bulat = substr($num, 0, -6)+1;
		endif;
	elseif($num>=500000 && $num<1000000):
		$num_bulat = 1;
	else:
		$num_bulat = 0;
	endif;
	return $num_bulat;
}

/*------------------------------------------------------------------------------*/
/* REPORT AND CHART DATA */
/*------------------------------------------------------------------------------*/
// untuk ambil data penyerapan dari tb_penyerapan_anggaran
function get_penyerapan($thang="2011", $kddept=null, $kdunit=null, $kdprogram=null, $kdsatker=null, $kdgiat=null)
{
	$ci = & get_instance();
	$ci->load->database();
	$sql = 'select sum( realisasi ) as jmlrealisasi, sum( pagu ) as jmlpagu, round(( sum( realisasi ) / sum( pagu ) ) *100, 2) as p
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
	if(isset($kdsatker)):
		$sql .= 'and kdsatker='.$kdsatker.' ';
	endif;
	if(isset($kdgiat)):
		$sql .= 'and kdgiat='.$kdgiat.' ';
	endif;
	return $ci->db->query($sql)->row();
}
// untuk ambil data konsistensi dari tb_konsistensi
function get_konsistensi($thang="2011",$kddept=null,$kdunit=null,$kdprogram=null,$kdsatker=null)
{
	$ci = & get_instance();
	$ci->load->database();
	
	$sql = 'select round(( sum( jmlrealisasi ) / sum( jmlrpd ) ) *100, 2) AS k
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
	if(isset($kdsatker)):
		$sql .= 'and kdsatker='.$kdsatker.' ';
	endif;
	
	return $ci->db->query($sql)->row();
}
// untuk ambil data keluaran dari tb_keluaran
function get_keluaran($thang="2011",$kddept=null,$kdunit=null,$kdprogram=null,$kdsatker=null,$kdgiat=null)
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
	if(isset($kdsatker)):
		$sql .= 'and kdsatker='.$kdsatker.' ';
	endif;
	if(isset($kdgiat)):
		$sql .= 'and kdgiat='.$kdgiat.' ';
	endif;
	return $ci->db->query($sql)->row();
}
// untuk ambil data efisiensi dari tb_efisiensi
function get_efisiensi($thang="2011",$kddept=null,$kdunit=null,$kdprogram=null,$kdsatker=null,$kdgiat=null)
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
	if(isset($kdsatker)):
		$sql .= 'and kdsatker='.$kdsatker.' ';
	endif;
	if(isset($kdgiat)):
		$sql .= 'and kdgiat='.$kdgiat.' ';
	endif;
	return $ci->db->query($sql)->row();
}
// untuk ambil detail data dari tabel tertentu
function get_detail_data($table_name,$where,$return_data)
{
	$ci = & get_instance();
	$ci->load->database();
	$result = $ci->db->get_where($table_name,$where)->row();
	if($result):
		return $result->$return_data;
	else:
		return false;
	endif;
}
// untuk ambil list departemen
function get_departemen()
{
	$ci = & get_instance();
	$ci->load->database();
	$query = $ci->db->query('select kddept, nmdept '.
							  'from t_dept '.
							  'order by kddept');
	if($query->result()):
		return $query->result();
	else:
		return false;
	endif;
}
// untuk ambil list eselon
function get_eselon($kddept)
{
	$ci = & get_instance();
	$ci->load->database();
	$query = $ci->db->query('select dept.kddept, dept.nmdept, unit.kdunit, unit.nmunit '.
							  'from t_dept dept, t_unit unit '.
							  'where dept.kddept=unit.kddept '.
							  'and unit.kddept='.$kddept.'
							  order by kdunit
							  '
							  );
	if($query->result()):
		return $query->result();
	else:
		return false;
	endif;
}
// untuk ambil list program
function get_program($kddept, $kdunit)
{
	$ci = & get_instance();
	$ci->load->database();
	$query = $ci->db->query('select dept.kddept, dept.nmdept, unit.kdunit, unit.nmunit, program.kdprogram, program.nmprogram '.
								'from t_program program, t_dept dept, t_unit unit '.
								'where program.kddept = dept.kddept '.
								'and program.kdunit = unit.kdunit '.
								'and unit.kddept = dept.kddept '.
								'and program.kddept='.$kddept.' '.
								'and program.kdunit='.$kdunit.'
								order by kdprogram'
								);
	if($query->result()):
		return $query->result();
	else:
		return false;
	endif;
}
// untuk ambil list satker
function get_satker($kddept, $kdunit)
{
	$ci = & get_instance();
	$ci->load->database();
	$query = $ci->db->query('select dept.kddept, dept.nmdept, unit.kdunit, unit.nmunit, satker.kdsatker, satker.nmsatker '.
								'from t_satker satker, t_dept dept, t_unit unit '.
								'where satker.kddept = dept.kddept '.
								'and satker.kdunit = unit.kdunit '.
								'and unit.kddept = dept.kddept '.
								'and satker.kddept='.$kddept.' '.
								'and satker.kdunit='.$kdunit.'
								order by kdsatker'
								);
	if($query->result()):
		return $query->result();
	else:
		return false;
	endif;
}
// untuk ambil list kegiatan
function get_giat($thang,$kddept,$kdunit,$kdprogram)
{
	$ci = & get_instance();
	$ci->load->database();
	$query = $ci->db->query('
			select tro.kdgiat,tg.nmgiat
			from t_giat tg,tb_real_output tro
			where year(tgldok) = '.$thang.'
			and tro.kddept='.$kddept.' 
			and tro.kdunit='.$kdunit.' 
			and tro.kdprogram='.$kdprogram.' 
			and tro.kddept=tg.kddept
			and tro.kdunit=tg.kdunit
			and tro.kdprogram=tg.kdprogram
			and tro.kdgiat=tg.kdgiat
			group by tg.kdgiat
			order by tg.kdgiat
		');
	if($query->result()):
		return $query->result();
	else:
		return false;
	endif;
}
// untuk ambil data report konsistensi secara detail
function get_report_konsistensi($thang=null,$kddept=null,$kdunit=null,$kdprogram=null,$kdsatker=null)
{
	$ci = & get_instance();
	$ci->load->database();
	$sql = '
		SELECT 
			thang,
			bulan,
			sum(jmlrpd) AS jmlrpd, 
			sum(jmlrealisasi) AS jmlrealisasi,
			round(( sum( jmlrealisasi ) / sum( jmlrpd ) ) *100, 2) AS konsistensi
		FROM tb_konsistensi
		WHERE 
			thang='.$thang.'
		';
	$group = ' GROUP BY thang, bulan';
	$order = ' ORDER BY thang, bulan, kddept, kdunit, kdprogram, kdsatker';
	
	if(isset($kddept)){ 
		$sql .= ' and kddept='.$kddept.' ';
		$group .= ', kddept';
	}
	if(isset($kdunit)){
		$sql .= ' and kdunit='.$kdunit.' ';
		$group .= ', kdunit';
	}
	if(isset($kdprogram)){
		$sql .= ' and kdprogram='.$kdprogram.' ';
		$group .= ', kdprogram';
	}
	if(isset($kdsatker)){
		$sql .= ' and kdsatker='.$kdsatker.' ';
		$group .= ', kdsatker';
	}
	return $ci->db->query($sql.$group.$order)->result();
}
// untuk ambil data konsistensi perbulan dari tb_konsistensi
function get_konsistensi_perbulan($thang="2011",$bulan=null,$kddept=null,$kdunit=null,$kdprogram=null,$kdsatker=null,$return_data='rpd')
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
	if(isset($kdsatker)):
		$sql .= 'and kdsatker='.$kdsatker.' ';
		$group .= ', kdsatker';
	endif;
	
	$sql .=' GROUP BY thang, bulan'.$group;
	$konsistensi = $ci->db->query($sql)->row();
	if($konsistensi):
		return $konsistensi->$return_data;
	else:
		return 0;
	endif;
}

/*------------------------------------------------------------------------------*/
/* HELPER UNTUK BACKEND */
/*------------------------------------------------------------------------------*/
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
function get_jabid()
{
	$ci = & get_instance();
	$ci->load->database();
	
	return $kppn = $ci->db->get('tb_jabatan')->result();
}