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
                                  'where table_schema = "db_monev" '.
                                  'and table_name in ("t_dept","t_unit","t_satker") ');
        
        return $query->result_array();
    }
    
    public function get_table_field($table_name)
    {
        return $this->db->list_fields($table_name);
    }
    
    public function get_table_detail($table_name,$limit=FALSE, $offset=FALSE)
    {
		if ($table_name=='satker'){
			$sql = 'SELECT s.kdsatker,s.nmsatker, d.nmdept, u.nmunit FROM t_satker s, t_dept d, t_unit u
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
		$query = $this->db->query( 'SELECT d.kddept, d.nmdept, u.kdunit, u.nmunit
		FROM t_dept d, t_unit u
		WHERE d.kddept = u.kddept
		LIMIT 10 ');
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
    
	public function get_data_detailsatker($param = FALSE, $id = FALSE)
	{
		if($param && $id):
			if($param=='satker'):
				$data = $this->db->query('
					select kdsatker, kdunit, kddept, nmsatker, kdinduk, kdlokasi, kdkabkota, nomorsp, kdkppn, kdjnssat,	kdupdate
					from t_satker
					where kdsatker = '.$id.' 
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
	
	public function get_data_detailunit($param = FALSE, $id = FALSE)
	{
		if($param && $id):
			if($param=='unit'):
				$data = $this->db->query('
					select kddept, kdunit, nmunit, kdupdate
					from t_unit
					where kdunit = '.$id.' 
				');
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
	       $this->db->update('t_unit', $data);
	  }
	  
	  function ubahsatker(){
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
	
$explode = explode('|', $kdunit);
		$data = array(
			'nmsatker' => $nmsatker,
			'kdunit' => $explode[1],
			'kddept' => $kddept,
			'kdinduk'=> kdinduk,
			'kdlokasi' => kdlokasi,
			'kdkabkota' => kdkabkota,
			'nomorsp' => nomorsp,
			'kdkppn' => kdkppn,
			'kdjnssat'=> kdjnssat,
			'kdupdate' => kdupdate,
			);
	       $this->db->where('kdsatker', $kdsatker);
		 //  $this->db->where('kdunit', $kdunitasal);
	       $this->db->update('t_satker', $data);
	  }
	
   
}