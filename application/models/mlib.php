<?php
class mlib extends CI_Model
{
	function getMonth(){
		$monthList = array("Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
		return $monthList;
	}
}
?>