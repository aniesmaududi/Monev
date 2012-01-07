<?php
if(!defined('BASEPATH'))
	exit('No direct script access allowed');
	
class Manakses_model extends CI_Model
{

	function __construct()
    {
        parent::__construct();
    }
	
	function get_all_akses_bappenas()
	{
		$query = $this->db->query('select * from tb_akses_bapenas');
		return $query->result_array();	
	}
	
	function get_limited_akses_bappenas($limit1,$limit2)
	{
		$query = $this->db->query('select * from tb_akses_bapenas limit '.$limit1.','.$limit2);		
		return $query->result_array();
	}
	
	function get_all_departemen()
	{
		$query = $this->db->query('select * from t_dept');
		return $query->result_array();
	}
	
	function get_limited_departemen($limit1,$limit2){
		$query = $this->db->query('select * from t_dept limit '.$limit1.','.$limit2);		
		return $query->result_array();
	}
	
	function get_group_unit($kdkementerian)
	{
		$query = $this->db->query('select * from t_unit '.
					'where kddept='.$kdkementerian);
		return $query->result_array();
	}
	
	function get_group_satker($kddept,$kdunit)
	{
		$query = $this->db->query('select * from t_satker '.
				'where kddept='.$kddept.
				' and kdunit='.$kdunit);
		return $query->result_array();
	}

	function get_all_satker()
	{
		//get all satker
		$query = $this->db->query('select * from t_satker');
		return $query->result_array();	
	}
	
	function get_all_user_dja()
	{
		//get all satker
		$query = $this->db->query('select * from tb_akses_dja');
		
		return $query->result_array();	
	}
	
	function get_limited_user_dja($limit1,$limit2)
	{
		$query = $this->db->query('select * from tb_akses_dja limit '.$limit1.','.$limit2);
		return $query->result_array();
	}
	
	function get_all_jabatan_dja()
	{
		//get all jenis jabatan dja
		$query = $this->db->query('select * from tb_jabatan_dja');
		return $query->result_array();
	}
	
	function get_all_akses_kl()
	{
		$query = $this->db->query('select * from tb_akses_kl');
		return $query->result_array();
	}
	
	function get_akses_kl($kddept)
	{
		$query = $this->db->query('select * from tb_akses_kl where kddept = '.$kddept);
		return $query->result_array();
	}
		
	function insert_user_dja($data)
	{
		$this->db->insert('tb_akses_dja',$data);
	}

	function insert_user_bappenas($data)
	{
		$this->db->insert('tb_akses_bapenas',$data);
	}
	
	function insert_akses_satker($data)
	{
		$this->db->insert('tb_akses',$data);
	}
	
	function insert_akses_kl($data)
	{
		$this->db->insert('tb_akses_kl',$data);
	}
	
	function get_departemen_by_id($kddept)
	{
		$query = $this->db->query('SELECT nmdept FROM t_dept WHERE kddept = '.$kddept);
		$row = $query->row();
		return $row->nmdept;
	}
}