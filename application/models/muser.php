<?php
class Muser extends CI_Model
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
	
	function getdata()
	{
	//$getData = $this->db->get('laporan');
	//if($getData->num_rows() > 0)
	//return $getData->result_array();
	//else
	//return null;
	}
}
?>