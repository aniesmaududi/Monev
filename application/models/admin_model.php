<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

	function get_admin($params=FALSE,$limit=FALSE)
	{
		if($params):
			$query = $this->db->get_where('administrator', $params);
		else:
			$query = $this->db->get('administrator');
		endif;
        if($query->num_rows() > 0):
			if($limit==1):
				return $query->row();
			else:
				return $query->result();
			endif;
		else:
			return FALSE;
		endif;
	}
	
	function insert_admin($data)
    {
        $this->db->insert('administrator', $data);
    }
	
	function update_admin($data,$admin_ID)
	{
		$this->db->where('admin_ID', $admin_ID);
        $this->db->update('administrator', $data);
	}
	
	function delete_admin($admin_ID)
    {
        $this->db->where('admin_ID', $admin_ID);
        $this->db->delete('administrator');
    }
	
	/* user management */
	function get_user_list($limit=FALSE,$offset=FALSE)
	{
		$this->db->select('tb_user.id as id, tb_user.userid, tb_user.nama, tb_user.jabid, tb_jabatan.id as jabatanid, tb_jabatan.jabatan')
			->order_by('tb_user.id', 'desc')
			->where('Status','Y')
			->join('tb_jabatan','tb_jabatan.id=tb_user.jabid');
		if($limit):
			$this->db->limit($limit, $offset);
		endif;
		$query = $this->db->get('tb_user');
		return $query->result();
	}
	
	function get_user($id=FALSE)
	{
		if($id):
			$this->db->select('tb_user.id as id, tb_user.userid, tb_user.nama, tb_user.jabid, tb_jabatan.id as jabatanid, tb_jabatan.jabatan')
				->order_by('tb_user.id', 'desc')
				->join('tb_jabatan','tb_jabatan.id=tb_user.jabid')
				->where('tb_user.id',$id);
			$query = $this->db->get('tb_user');
			return $query->row();
		else:
			return false;
		endif;
	}
	
	function update_user($data,$id)
	{
		$this->db->where('id',$id)->update('tb_user',$data);
	}
	
	//-------
	function add_user()
	{
	$userid = $this->input->post('userid');
	$nama =  $this->input->post('nama');
	$pass = $this->input->post('passwd');
	$jabid = $this->input->post('jabid');

	if($this->input->post('kddept'))
	$kddept = $this->input->post('kddept');
	else
	$kddept='';
	
	if($this->input->post('kdunit'))
	$kdunit = $this->input->post('kdunit');
	else
	$kdunit='';

	if($this->input->post('kdsatker'))
	$kdsatker = $this->input->post('kdsatker');
	else
	$kdsatker='';
	
	$sql = 'INSERT into tb_user(userid,nama,passwd,jabid,kddept,kdunit,kdsatker)
			VALUES ("'.$userid.'", "'.$nama.'", md5("'.$pass.'"), "'.$jabid.'", "'.$kddept.'", "'.$kdunit.'", "'.$kdsatker.'");';
	$this->db->query($sql);
	}
	
	function delete_user($id)
	{
	$sql = 'UPDATE tb_user SET  status="N" WHERE id='.$id.';';
	$this->db->query($sql);
	}
	//---
	function get_departemen($id)
	{
	$sql = 'SELECT kddept, nmdept from t_dept;';
	$query = $this->db->query($sql);
	return $query->result();
	
	}
	function get_unit($id)
	{
	$sql = 'SELECT d.kddept, d.nmdept, u.kdunit, u.nmunit from t_dept d, t_unit u WHERE u.kddept=d.kddept AND u.kddept='.$id;
	$query = $this->db->query($sql);
	return $query->result();
	
	}
	function get_satker($idd,$idu)
	{
	$sql = 'SELECT d.kddept, d.nmdept, u.kdunit, u.nmunit, s.kdsatker, s.nmsatker from t_dept d, t_unit u, t_satker s WHERE u.kddept=d.kddept AND s.kdunit=u.kdunit AND s.kddept=d.kddept AND s.kdunit='.$idu.' AND s.kddept='.$idd;
	$query = $this->db->query($sql);
	return $query->result();
	
	}	
}