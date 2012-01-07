<?php
class msms extends CI_Model
{
	function getAllKeyword(){
		$sql = "SELECT * FROM tb_keyword_sms";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0){ 
			return $query->result('array');
		} else {
			return FALSE;
		}
	}
	
	function getKeyword($id){
		$sql = "SELECT * FROM tb_keyword_sms WHERE id = '$id'";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0){ 
			return $query->result('array');
		} else {
			return FALSE;
		}
	}
	
	function createToken($idBroadcast,$tokenCode,$verCode,$sendTime,$expTime)
	{
		$sql = "INSERT INTO tb_kd_token (idbroadcast,token,vercode,sendtime,exptime)
				VALUES ('$idBroadcast','$tokenCode','$verCode','$sendTime','$expTime')";
		$query = $this->db->query($sql);
	}
	
	function getIdBroadcast($idSatker)
	{
		$sql = "SELECT id FROM tb_user_broadcast WHERE kdsatker = '$idSatker'";
		$query = $this->db->query($sql);
        
		return $query->result('array');
	}
	
	function getResponse($arrText)
	{
		$sqlKW = "SELECT * FROM tb_keyword_sms WHERE UPPER(keyword) = '".trim(strtoupper($arrText[0]))."'";
		$queryKW = $this->db->query($sqlKW);
		$cRecord = $queryKW->num_rows();
		if($cRecord > 1){
			$sqlSKW = "SELECT * FROM tb_keyword_sms 
							WHERE UPPER(keyword) = '".trim(strtoupper($arrText[0]))."' AND UPPER(subkeyword) = '".trim(strtoupper($arrText[1]))."'";
			$querySKW = $this->db->query($sqlSKW);
			if($querySKW->num_rows() > 0){
				return $querySKW->result('array');
			} else {
				return array(0 => array('reply' => "Maaf, Format SMS tidak dikenali"));
			}
		} else if($cRecord > 0) { 
			return $queryKW->result('array');
		} else {
			return array(0 => array('reply' => "Maaf, Format SMS tidak dikenali"));
		}
		
        
		
	}
	
	function getVerCode($phone, $token)
	{
		$sqlGetId = "SELECT id FROM tb_user_broadcast WHERE nomor = '$phone'";
		$queryGetId = $this->db->query($sqlGetId);
		$resGetId = $queryGetId->result('array');
		
		$now = date('Y-m-d H:i:s');
		
		$sqlGetVerCode = "SELECT id, vercode FROM tb_kd_token 
							WHERE idbroadcast = '".$resGetId[0]['id']."' AND token = '$token' AND status = '0' AND exptime > '$now'";
		
		$queryGetVerCode = $this->db->query($sqlGetVerCode);
		
		if($queryGetVerCode->num_rows() > 0){ 
			$resGetVerCode = $queryGetVerCode->result('array');
			$this->updateStatus($resGetVerCode[0]['id']);
			return $resGetVerCode;
		} else {
			return FALSE;
		}
	}
	
	function codeVerification($tokencode, $vercode)
	{
		$now = date('Y-m-d H:i:s');
		
		$sql = "SELECT * FROM tb_kd_token 
							WHERE token = '$tokencode' AND vercode = '$vercode' AND exptime > '$now'";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0){ 
			return TRUE;
		} else {
			return FALSE;
		}
	}	
	
	function numberVerification($number)
	{
		$sql = "SELECT * FROM tb_user_broadcast WHERE nomor = '$number'";
		
		$query = $this->db->query($sql);
		if($query->num_rows() > 0){ 
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function checkExist($tablename, $array){
		$sql = "SELECT * FROM $tablename WHERE ";
		
		$c = count($array);
		$i = 1;
		foreach($array as $idx => $val){
			$sql .= "$idx = '$val'";
			if($c > $i) { $sql .= " AND "; }
			$i++;
		}
		
		$query = $this->db->query($sql);
		if($query->num_rows() > 0){ 
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function checkContent($array){
		
		foreach($array as $idx => $val){
			if(trim($val) == "") { 
				return FALSE;
			}
		}
		
		return TRUE;
	}
	
	function insertKeyword($array){
		$data = array(
               'keyword' => $array['keyword'],
               'subkeyword' => $array['subkeyword'],
               'reply' => $array['reply']
            );
		
		$dCheck = $data;
		$cCheck = $data;
		unset($dCheck['reply']);
		unset($cCheck['subkeyword']);
		
		$checkExist = $this->checkExist('tb_keyword_sms',$dCheck);
		if(!$this->checkContent($cCheck)){
			return "Input gagal, keyword dan reply harus diisi";
		}
		
		if($checkExist == TRUE){
			return "Input gagal karena terjadi duplikasi data";
		} else {
			$this->db->insert('tb_keyword_sms', $data); 
			return "Input data berhasil";
		}
	}
	
	function updateKeyword($array){
		$data = array(
               'keyword' => $array['keyword'],
               'subkeyword' => $array['subkeyword'],
               'reply' => $array['reply']
            );
		$cCheck = $data;
		unset($cCheck['subkeyword']);
		if(!$this->checkContent($cCheck)){
			return "Input gagal, keyword dan reply harus diisi";
		}
		
		$sqlCheck = "SELECT * FROM tb_keyword_sms 
						WHERE keyword = '".$array['keyword']."' AND subkeyword = '".$array['subkeyword']."' AND id != '".$array['id']."'";
		
		$queryCheck = $this->db->query($sqlCheck);
		
		if($queryCheck->num_rows() > 0){ 
			return "Update gagal karena terjadi duplikasi data";
		} else {
			$data = array(
               'keyword' => $array['keyword'],
               'subkeyword' => $array['subkeyword'],
               'reply' => $array['reply']
            );
			$this->db->update('tb_keyword_sms', $data, "id = '".$array['id']."'");
			return "Update data berhasil";
		}	
	}
	
	function deleteKeyword($id){
		$data = array(
               'id' => $id
            );
		$checkExist = $this->checkExist('tb_keyword_sms',$data);
		
		if($checkExist == TRUE){
			$this->db->delete('tb_keyword_sms', array('id' => $id)); 
			return "Delete data berhasil";
		} else {
			return "Delete data gagal, data tidak ditemukan";
		}
	}
	
	function updateStatus($id){
		$data = array('status'=>1);
		$this->db->update('tb_kd_token', $data, "id = '$id'");
	}
	
}
?>