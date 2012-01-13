<?php
class maccess_management extends CI_Model{
function getdata()
	{
		$hasil = $this->db->get('v_user');
		//$result = $hasil->row();
		return $hasil->result();
	}
function selectdata()
	{
//		$hasil = this->db->get('v_user');
//		return $hasil->result();
	}
}
?>