<?php
class Madmin_ref extends CI_Model
{
    public function __construct()
    {        
        $this->load->database();
    }
    
    public function get_tables()
    {
        $query = $this->db->query('select table_name '.
                                  'from information_schema.tables '.
                                  'where table_schema = "monev_db" '.
                                  'and table_name in ("t_dept","t_unit","t_satker","t_output","t_iku","t_program") ');
        
        return $query->result_array();
    }
    
    public function get_table_field($table_name)
    {
        return $this->db->list_fields($table_name);
    }
    
    public function get_table_detail($table_name,$limit=FALSE, $offset=FALSE)
    {
		if ($table_name=='satker'){
			$sql = 'SELECT s.kdsatker, s.nmsatker, s.kddept, s.kdunit, d.nmdept, u.nmunit FROM t_satker s, t_dept d, t_unit u
		WHERE s.kddept = d.kddept
				AND s.kdunit = u.kdunit
				AND s.kddept = u.kddept ';
			
			if($limit):
				$sql .='limit '.$offset.','.$limit.' ';
			endif;
			$query = $this->db->query($sql);
		}
		
		
		elseif ($table_name=='dept'){
		$query = $this->db->query( 'SELECT kddept, nmdept FROM t_dept');
		}
		elseif ($table_name=='unit'){
		$sql = 'SELECT d.kddept, d.nmdept, u.kdunit, u.nmunit
		FROM t_dept d, t_unit u
		WHERE d.kddept = u.kddept ';
		if($limit):
				$sql .='limit '.$offset.','.$limit.' ';
			endif;
			$query = $this->db->query($sql);
		}
		elseif ($table_name=='output'){
		$sql = 'SELECT o.KDOUTPUT, o.NMOUTPUT, g.KDGIAT, g.NMGIAT, o.SAT
		FROM t_giat g, t_output o
		WHERE g.kdgiat = o.KDGIAT ';
		if($limit):
				$sql .='limit '.$offset.','.$limit.' ';
			endif;
			$query = $this->db->query($sql);
		}
		elseif ($table_name=='iku'){
		$sql = 'SELECT i.kdiku, i.kddept, i.kdunit, i.nmiku, i.kdprogram, p.nmprogram
		FROM t_iku i, t_program p, t_dept d, t_unit u
		WHERE i.kdprogram = p.kdprogram
		AND i.kddept = p.kddept
		AND i.kdunit = p.kdunit 
		AND i.kddept = d.kddept
		AND i.kdunit = u.kdunit
		AND i.kddept = u.kddept ';
				
		if($limit):
				$sql .='limit '.$offset.','.$limit.' ';
			endif;
			$query = $this->db->query($sql);
		}
		
		elseif ($table_name=='program'){
		$sql = 'SELECT kddept, kdunit, kdprogram, nmprogram, uroutcome FROM t_program ';
		if($limit):
				$sql .='limit '.$offset.','.$limit.' ';
			endif;
			$query = $this->db->query($sql);
		}
		else {
        $query = $this->db->query('select * '.
                                  'from '.$table_name.' '.
                                  'limit 10');
		}
        return $query->result();
    }
    
    public function get_row_detail($table_name, $keys)
    {        
        $where = $keys[5].' = '.$keys[6];
        for($i=7;$i<count($keys);$i++)
        {
            if($i%2 != 0){
                $field = $keys[$i];
                $value = $keys[$i+1];
                $where .= ' and '.$field.' = '.$value;
            } 
        }
        
        $query = $this->db->query('select * '.
                                  'from '.$table_name.' '.
                                  'where '.$where);
        return $query->row_array();
    }
    
	public function get_data_detailsatker($param = FALSE, $praid1 =FALSE, $praid2 = FALSE, $id = FALSE)
	{
		if($param && $id && $praid1 && $praid2):
			if($param=='satker'):
				$data = $this->db->query('SELECT kdsatker, 	kdinduk, 	nmsatker, 	kddept, 	kdunit, 	kdlokasi, 	kdkabkota, 	nomorsp, 	kdkppn, 	kdjnssat, 	kdupdate FROM t_satker 
		WHERE kddept = '.$praid1.'
				AND kdunit = '.$praid2.'
				AND kdsatker = '.$id.'
					ORDER BY kdsatker ASC
				');
			endif;
			return $data->row();
		else:
		
		endif;
	}
	
	public function get_data_detaildept($param = FALSE, $id = FALSE)
	{
		if($param && $id):
			if($param=='dept'):
				$data = $this->db->query('
					select kddept, nmdept, kdkl, kdupload, kdstm, kdbatal, kdhapus, kdupdate
					from t_dept
					where kddept = '.$id.' 
				');
			endif;
			return $data->row();
		else:
		
		endif;
	}
	
	public function get_data_detailunit($param = FALSE, $praid = FALSE, $id = FALSE)
	{
		if($param && $id && $praid):
			if($param=='unit'):
				$data = $this->db->query('
					select kddept, kdunit, nmunit, kdupdate
					from t_unit
					where kdunit = '.$id.' AND kddept = '.$praid.'
				');
			endif;
			return $data->row();
		else:
		
		endif;
	}
	public function get_data_detailoutput($param = FALSE, $praid = FALSE, $id = FALSE)
	{
		if($param && $id && $praid):
			if($param=='output'):
				$data = $this->db->query('
					select * from t_output
					where KDOUTPUT = '.$id.' AND KDGIAT = '.$praid.' 
					ORDER BY NMOUTPUT ASC
				');
			endif;
			return $data->row();
		else:
		
		endif;
	}
		
		public function get_data_detailiku($param = FALSE, $praid1 =FALSE, $praid2 = FALSE, $praid3=FALSE,  $id = FALSE)
	{
		if($param && $id && $praid1 && $praid2 && $praid3):
			if($param=='iku'):
				$data = $this->db->query('
					select kddept, kdunit, kdprogram, kdiku, nmiku, kdupdate from t_iku
					where kdiku = '.$id.' AND kddept = '.$praid1.' AND kdunit = '.$praid2.' AND kdprogram = '.$praid3.'
				');
			endif;
			return $data->row();
		else:
		
		endif;
	}
	public function get_data_detailprogram($param = FALSE, $praid1 = FALSE, $praid2 = FALSE, $id = FALSE)
	{
		if($param && $id && $praid1 &&$praid2):
			if($param=='program'):
				$data = $this->db->query('
					select kddept, kdunit, kdprogram, nmprogram, uroutcome, kdsasaran, kdjnsprog, kdupdate from t_program
					where kdprogram = '.$id.' AND kddept = '.$praid1.' AND kdunit = '.$praid2.'	');
			endif;
			return $data->row();
		else:
		
		endif;
	}
	
	function ubahdept(){
	$nmdept = $this->input->post('nmdept');
	$kddept = $this->input->post('kddept');
	$kdkl = $this->input->post('kdkl');
	$kdupload = $this->input->post('kdupload');
	$kdstm = $this->input->post('kdstm');
	$kdbatal = $this->input->post('kdbatal');
	$kdhapus = $this->input->post('kdhapus');
	$kdupdate = $this->input->post('kdupdate');
	
		$data = array(
			'nmdept' => $nmdept,
			'kdkl' =>$kdkl,
			'kdupload' => $kdupload,
			'kdstm' => $kdstm,
			'kdbatal' => $kdbatal,
			'kdhapus' => $kdhapus,
			'kdupdate' => $kdupdate,
			);
	       $this->db->where('kddept', $kddept);
	       $this->db->update('t_dept', $data);
	  }
	
	function ubahunit(){
	$id = $this->input->post('id');
	$praid = $this->input->post('praid');
	$nmunit = $this->input->post('nmunit');
	$kdunit = $this->input->post('kdunit');
	$kddept = $this->input->post('kddept');
	$kdupdate = $this->input->post('kdupdate');
		$data = array(
			'nmunit' => $nmunit,
			'kddept' => $kddept,
			'kdupdate' => $kdupdate,
			);
	       $this->db->where('kdunit', $kdunit);
		   $this->db->where('kddept', $praid);
	       $this->db->update('t_unit', $data);
	  }
	  
	  function ubahsatker(){
		  $praid1 = $this->input->post('praid1');
	$praid2 = $this->input->post('praid2');
	
	$nmsatker = $this->input->post('nmsatker');
	$kdunitasal = $this->input->post('kdunitasal');
	$kdunit = $this->input->post('kdunit');
	$kddept = $this->input->post('kddept');
	$kdsatker = $this->input->post('kdsatker');
	$kdinduk = $this->input->post('kdinduk');
	$kdlokasi = $this->input->post('kdlokasi');
	$kdkabkota = $this->input->post('kdkabkota');
	$nomorsp = $this->input->post('nomorsp');
	$kdkppn = $this->input->post('kdkppn');
	$kdjnssat = $this->input->post('kdjnssat');
	$kdupdate = $this->input->post('kdupdate');
	
		$data = array(
			'kddept' => $kddept,
			'nmsatker' => $nmsatker,
			'kdunit' => $kdunit,
			'kdinduk'=> $kdinduk,
			'kdlokasi' => $kdlokasi,
			'kdkabkota' => $kdkabkota,
			'nomorsp' => $nomorsp,
			'kdkppn' => $kdkppn,
			'kdjnssat'=> $kdjnssat,
			'kdupdate' => $kdupdate,
			);
	       $this->db->where('kdsatker', $kdsatker);
	       $this->db->update('t_satker', $data);
	  }
	function ubahoutput(){
	$praid = $this->input->post('praid');
	$kdgiat = $this->input->post('KDGIAT');
	$kdoutput = $this->input->post('KDOUTPUT');
	$nmoutput = $this->input->post('NMOUTPUT');
	$sat = $this->input->post('SAT');
	$kdsum = $this->input->post('KDSUM');
		$data = array(
			'KDGIAT' => $kdgiat,
			'NMOUTPUT' => $nmoutput,
			'SAT' => $sat,
			'KDSUM' => $kdsum,
			);
	       $this->db->where('KDGIAT', $praid);
		   $this->db->where('KDOUTPUT', $kdoutput);
	       $this->db->update('t_output', $data);
	  }
	   function ubahiku(){
		   $praid1 = $this->input->post('praid1');
		   $praid2 = $this->input->post('praid2');
		   $praid3 = $this->input->post('praid3');
	$kddept = $this->input->post('kddept');
	$kdunit = $this->input->post('kdunit');
	$kdprogram = $this->input->post('kdprogram');
	$kdiku = $this->input->post('kdiku');
	$nmiku = $this->input->post('nmiku');
	$kdupdate = $this->input->post('kdupdate');
		$data = array(
			
'nmiku'=>$nmiku,
'kddept' => $kddept,
'kdunit' => $kdunit,
	'kdprogram' => $kdprogram,
	'kdupdate' => $kdupdate,
			);
	       $this->db->where('kddept', $praid1);
		   $this->db->where('kdunit', $praid2);
		   $this->db->where('kdprogram', $praid3);
		   $this->db->where('kdiku', $kdiku);
	       $this->db->update('t_iku', $data);
	  }
	  
    function ubahprogram(){
		$praid1 =$this->input->post('praid1');
		$praid2 =$this->input->post('praid2');
	$kddept = $this->input->post('kddept');
	$kdunit = $this->input->post('kdunit');
	$kdprogram = $this->input->post('kdprogram');
	$nmprogram = $this->input->post('nmprogram');
	$uroutcome = $this->input->post('uroutcome');
	$kdsasaran = $this->input->post('kdsasaran');
	$kdjnsprog = $this->input->post('kdjnsprog');
	$kdupdate = $this->input->post('kdupdate');
		$data = array(
					  'kddept' => $kddept,
					  'kdunit' => $kdunit,
	'nmprogram' => $nmprogram,
	'uroutcome' => $uroutcome,
	'kdsasaran' => $kdsasaran,
	'kdjnsprog' => $kdjnsprog,
	'kdupdate' => $kdupdate,
			);
	       $this->db->where('kddept', $praid1);
		   $this->db->where('kdunit', $praid2);
		   $this->db->where('kdprogram', $kdprogram);
	       $this->db->update('t_program', $data);
	  }
}