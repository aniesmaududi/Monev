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