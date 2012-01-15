<?php
					if($this->session->flashdata('message')):
					echo flash_message($this->session->flashdata('message_type'));
				endif;

echo form_open('');
echo form_hidden('id',$user->id);
echo '<br>Nama Departemen = ' ;
echo form_label($user->nmdept,'Nama_Dept');
echo '<br>Nama Unit = ' ;
echo form_label($user->nmunit,'Nama_Unit');
echo '<br>Nama satker = ' ;
echo form_label($user->nmsatker,'Nama_Satker');

echo '<br> tanggal mulai : ';
echo form_input('Start_time',$user->start_time);
echo '<br> tanggal selesai : ';
echo form_input('End_time',$user->end_time);
echo '<br>';
echo form_submit('update_date/', 'Update');
//echo form_
echo form_close();
?>

