<?php
class muser extends CI_Model
{
	function cekuser()
	{
		$user = $this->input->post('user_name');
		$pass = md5($this->input->post('user_password'));
		$this->db->where('userid',$user);
		$this->db->where('passwd',$pass);
	
		$query = $this->db->get('tb_user');
		$result = $query->row();
		
		if(count($result)>0):
			return $result;
		else:
			return false;
		endif;
	}
	function cek_user_akses_bappenas($username,$password)
	{
		$this->db->where('username',$username);
		$this->db->where('password',$password);
		$query = $this->db->get('tb_akses_bapenas');
		$result = $query->row();
		if(count($result)>0):
			return $result;
		else:
			return false;
		endif;
	}
	
	function cek_user_akses_dja($username,$password)
	{
		$this->db->where('username',$username);
		$this->db->where('password',$password);
		$query = $this->db->get('tb_akses_dja');
		$result = $query->row();
		if(count($result)>0):
			return $result;
		else:
			return false;
		endif;
	}
	
	//Dita 
	function getsatker($userid)
	{
		$string = 'select u.userid, u.jabid, u.kdsatker, s.nmsatker, j.jabatan, u.kdunit, u.kddept, u.nama from tb_user u, tb_jabatan j, t_satker s where u.jabid = j.id AND u.kdsatker = s.kdsatker WHERE u.userid = ?';
		$query = $this->db->query($string,$userid);
		$result = $query->row();
	}
	
	function getDept($kddept)
	{
		$string = 'SELECT * FROM t_dept WHERE kddept = ?';
		$query = $this->db->query($string,$kddept);
		return $query->result_array();
	}
	
	function getUnit($kddept,$kdunit)
	{
		$string = 'SELECT * FROM t_unit WHERE kdunit = '.$kdunit.' AND kddept = '.$kddept;
		$query = $this->db->query($string);
		return $query->result_array();
	}

}
?>