<?php
class maccess_management extends CI_Model{
function getdata()
	{
		$hasil = $this->db->query('SELECT user.id, dept.nmdept, unit.nmunit, satker.nmsatker, 
									user.jabid, user.start_time, user.end_time 
									FROM t_dept dept, t_unit unit, t_satker satker, tb_user user 
									WHERE satker.kddept=dept.kddept
									AND satker.kdunit=unit.kdunit
									AND unit.kddept=dept.kddept
									AND user.kddept=dept.kddept 
									AND user.kdunit=unit.kdunit 
									AND user.kdsatker=satker.kdsatker;');
		//$result = $hasil->row();
		return $hasil->result();
	}
function get_user($id=FALSE)
	{
		if($id):
		$sql = 'SELECT tb_user.id, t_dept.nmdept, t_unit.nmunit, t_satker.nmsatker, 
				    tb_user.start_time, tb_user.end_time 
				  FROM tb_user, t_dept, t_unit, t_satker 
				  WHERE tb_user.kddept=t_dept.kddept 
				  AND tb_user.kdunit=t_unit.kdunit 
				  AND tb_user.kdsatker=t_satker.kdsatker;';
//			$this->db->select('tb_user.id as id, tb_user.userid, tb_user.nama, tb_user.jabid, tb_jabatan.id as jabatanid, tb_jabatan.jabatan,   tb_user.kddept, tb_user.kdunit, tb_user.kdsatker, tb_user.start_time, tb_user.end_time')			->join('tb_jabatan','tb_jabatan.id=tb_user.jabid')				->where('tb_user.id',$id);
			$query = $this->db->query($sql);
			return $query->row();
		else:
			return false;
		endif;	}

function get_departemen($id=FALSE)
	{
		if($id):
			$this->db->select('kddept, nmdept'); 
			$query = $this->db->get('t_dept');
			return $query->result();
		else:
			return false;
		endif;	}
		
function get_unit($id=FALSE)
	{
		if($id):
			$this->db->select('kdunit, nmunit'); 
			$query = $this->db->get('t_unit');
			return $query->result();
		else:
			return false;
		endif;	}
function get_satker($id=FALSE)
	{
		if($id):
			$this->db->select('kdsatker, nmsatker'); 
			$query = $this->db->get('t_satker');
			return $query->result();
		else:
			return false;
		endif;	}

function update_date($start,$end,$id)
	{
		$query='UPDATE tb_user SET start_time="'.$start.'", end_time="'.$end.'" WHERE id='.$id.';';
		$this->db->query($query);
//		$this->db->where('id',$id)->update('tb_user',$data)->set('start_time',$start)->set('end_time',$end);
	}
}
?>