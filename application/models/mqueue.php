<?
class mqueue extends CI_Model
{
	function set_status($id)
	{
		$sql = 'UPDATE tb_upload SET is_done = 1 where id='.$id;
		//$this->db->update->
		$this->db->query($sql);
		$this->session->set_flashdata('message_type', 'success');
		$this->session->set_flashdata('message', 'Data berhasil diperbaharui');
	}
	
	function list_done()
	{
		$sql = 'SELECT u.id, u.is_done, satker.kdsatker, satker.nmsatker, 
					unit.kdunit, unit.nmunit, dept.kddept, dept.nmdept 
				FROM tb_upload u, t_satker satker, t_unit unit, t_dept dept 
				WHERE u.kddept = dept.kddept 
				AND u.kddept = unit.kddept 
				AND u.kdunit = unit.kdunit 
				AND u.kddept = satker.kddept 
				AND u.kdunit = satker.kdunit 
				AND u.kdsatker = satker.kdsatker 
				AND (u.is_done=1 OR u.is_done=2)
				ORDER BY id ASC';
		$query = $this->db->query($sql);
		return $query;
	}

	function list_fail()
	{
		$sql = 'SELECT u.id, u.is_done, u.filename, satker.kdsatker, satker.nmsatker, 
					unit.kdunit, unit.nmunit, dept.kddept, dept.nmdept 
				FROM tb_upload u, t_satker satker, t_unit unit, t_dept dept 
				WHERE u.kddept = dept.kddept 
				AND u.kddept = unit.kddept 
				AND u.kdunit = unit.kdunit 
				AND u.kddept = satker.kddept 
				AND u.kdunit = satker.kdunit 
				AND u.kdsatker = satker.kdsatker 
				AND u.is_done=2
				ORDER BY id ASC';
		$query = $this->db->query($sql);
		return $query;
	}

	function list_success()
	{
		$sql = 'SELECT u.id, u.is_done, satker.kdsatker, satker.nmsatker, 
					unit.kdunit, unit.nmunit, dept.kddept, dept.nmdept 
				FROM tb_upload u, t_satker satker, t_unit unit, t_dept dept 
				WHERE u.kddept = dept.kddept 
				AND u.kddept = unit.kddept 
				AND u.kdunit = unit.kdunit 
				AND u.kddept = satker.kddept 
				AND u.kdunit = satker.kdunit 
				AND u.kdsatker = satker.kdsatker 
				AND u.is_done=1
				ORDER BY id ASC';
		$query = $this->db->query($sql);
		return $query;
	}
	
	function download($id)
	{
		$sql = 'SELECT filename, data FROM tb_upload WHERE id='.$id;
		$query = $this->db->query($sql);

		//get extention automatic and concat filename
		$file = explode('.',$query->row()->filename);
		if($file==false)
		{
//			$ext=$query->row()->filename;
			redirect('backend/queue/index');
		}
		else
		{
			for($i=0;$i<count($file)-1;$i++)
			{
				$name.=$file[$i].'.';
			}
			$ext = $file[$i];
		}
		//end get extention

//	$this->output->set_content_type('rar')->set_output($query->row()->data);
	$this->output->set_content_type($ext)->set_output($query->row()->data);
	}
}
?>