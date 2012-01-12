<?php
class Mlaporan extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    
    /*----------------------------------------- for CH chart ---------------------------------------*/
    public function getAllThang(){
		$sql = "SELECT DISTINCT(thang) from tb_capaian_hasil";
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0){ 
			return $result = $query->result('array');
		} else {
			return FALSE;
		}
	}
    
	public function getAllProgram(){
		$sql = "SELECT kdprogram from tb_capaian_hasil";
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0){ 
			return $result = $query->result('array');
		} else {
			return FALSE;
		}
	}
	
	public function getUnit($kdunit = NULL){
		$sql = "SELECT DISTINCT(tch.kdunit), tu.nmunit 
				FROM tb_capaian_hasil tch LEFT JOIN t_unit tu ON tch.kdunit = tu.kdunit AND tch.kddept = tu.kddept";
		$sqlWhere = "";
		if($kdunit){
			$sqlWhere .= " AND tch.kdunit = '$kdunit' ";			
		}
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0){ 
			return $result = $query->result('array');
		} else {
			return FALSE;
		}
	}
	
	public function getDept($kddept = NULL){
		$sql = "SELECT DISTINCT(tch.kddept), td.nmdept 
				FROM tb_capaian_hasil tch LEFT JOIN t_dept td ON tch.kddept = td.kddept";
		$sqlWhere = "";
		if($kddept){
			$sqlWhere .= " AND tch.kddept = '$kddept' ";			
		}
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0){ 
			return $result = $query->result('array');
		} else {
			return FALSE;
		}
	}
	
	public function getSerapanAnggaran($thang,$kdProg = NULL,$kdUnit = NULL,$kdDept = NULL, $iskl = NULL){
		$nextThang = $thang+1;
		$sqlWhere = "";
		if($kdProg){
			$sqlWhere .= " AND kdprogram = '$kdProg' ";			
		}
		if($kdUnit){
			$sqlWhere .= " AND kdunit = '$kdUnit' ";			
		}	
		if($kdUnit){
			$sqlWhere .= " AND kddept = '$kdDept' ";			
		}	
		
		$sqlOrganic = "SELECT AVG(CH) AS value, substring(tgldoc,1,7) as monthly FROM tb_capaian_hasil 
				WHERE thang = '".$thang."' AND substring(tgldoc,6,2) < 12  AND substring(tgldoc,1,4) != '".$nextThang."'";
		$sqlOrganic .= $sqlWhere;
		$sqlOrganic .= "GROUP BY monthly
				ORDER BY substring(tgldoc,6,2) ASC";
		
		// echo $sqlOrganic;
		
		$sqlAnorganic = "SELECT AVG(CH) AS value, (SELECT '".$thang."-12') as monthly FROM tb_capaian_hasil 
		WHERE thang = '".$thang."' AND substring(tgldoc,1,7) BETWEEN '".$thang."-12' AND '".$nextThang."-01'";		
		$sqlAnorganic .= $sqlWhere;
		$sqlAnorganic .= "ORDER BY substring(tgldoc,6,2) ASC";
		
		// echo $sqlAnorganic;
		
		$queryOrganic = $this->db->query($sqlOrganic);
		$queryAnorganic = $this->db->query($sqlAnorganic);
		
		if($queryOrganic->num_rows() > 0){ 
			$rOrg = $queryOrganic->result('array');
		} else {
			$rOrg = array();
		}
		
		if($queryAnorganic->num_rows() > 0){ 
			$rAnorg = $queryAnorganic->result('array');
		} else {
			$rAnorg = array();
		}
		
		$results = array_merge($rOrg,$rAnorg);
		
		if($results[0]['value']){
			return $results;
		} else {
			return FALSE;
		}
	}
	
	public function getSerapanYearly($thang,$kdDept = NULL,$kdUnit = NULL,$kdProgram = NULL){
		$sqlWhere = "";
		if($kdUnit){
			$sqlWhere .= " AND kdunit = '$kdUnit' ";			
		}	
		if($kdDept){
			$sqlWhere .= " AND kddept = '$kdDept' ";			
		}		
		if($kdProgram){
			$sqlWhere .= " AND kdprogram = '$kdProgram' ";			
		}	
		$sql = "SELECT AVG(CH) AS value FROM tb_capaian_hasil 
				WHERE thang = '$thang'";
		$sql .= $sqlWhere;
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0){ 
			$ch = $query->result('array');
			return $ch[0]['value'];
		} else {
			return FALSE;
		}
	}    
}