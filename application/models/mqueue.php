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
}
?>