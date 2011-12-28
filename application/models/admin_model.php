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
	
}