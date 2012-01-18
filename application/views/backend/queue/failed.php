	<h1><?php echo $title;?></h1>
	<div id="search-box" style="min-height:400px;">
				<span class="custom-button-span"></span>
    <?php
    if ($this->session->flashdata('message')):
        echo flash_message($this->session->flashdata('message_type'));
    endif;
   ?>
   <?
   echo anchor('backend/queue/index','Sedang di Proses','class=custom');
   echo anchor('backend/queue/done','Sudah di Proses','class=custom');
   echo anchor('backend/queue/success','Berhasil Proses','class=custom');
   echo anchor('backend/queue/fail','Gagal Proses','class=custom');
if($rows->num_rows()>0)
{
   echo form_open('');
   ?>
   <br><br>
   
    <table id="table1" class="backend-table">
        <thead>
        <th>K/L</th>
        <th>Eselon</th>
        <th>Satker</th>
        <th>Status</th>
        <th>Option</th>
        </thead>

        <tbody>
        <?php
			$temp = 0;
			foreach ($rows->result() as $value): ?>
			<tr style="font-size:10px;" class="flash" id="flash<?=$value->id?>">
				<td><?php echo $value->kddept.' -- '.$value->nmdept ?></td>
				<td><?php echo $value->kdunit.' -- '.$value->nmunit ?></td>
				<td><?php echo $value->kdsatker.' -- '.$value->nmsatker ?></td>            
				<td><?php if($value->is_done == 1){ echo "Sukses"; } else { echo "<img src= '".ASSETS_DIR_IMG."notdone.png' /><br>";echo "Gagal"; } ?></td>
				<td><?php 
							echo anchor('backend/queue/get_file/'.$value->id.'/'.$value->filename,'File','class=custom');
					?>
				</td>
			</tr>
        <?php endforeach;?>
        </tbody>
    </table>
	<?php echo form_close(); }else{ echo '<br><br>No Data';}?>
</div>

<div id="nav-box">
    <div class="clearfix"></div>
</div>