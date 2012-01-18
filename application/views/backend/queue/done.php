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
{   ?>
      <br><br>

    <table id="table1" class="backend-table">
        <thead>
        <th>K/L</th>
        <th>Eselon</th>
        <th>Satker</th>
        <th>Status</th>
        </thead>

        <tbody>
        <?php
			$temp = 0;
			foreach ($rows->result() as $value): ?>
			<tr style="font-size:10px;" class="flash" id="flash<?=$value->id?>">
				<td><?php echo $value->kddept.' -- '.$value->nmdept ?></td>
				<td><?php echo $value->kdunit.' -- '.$value->nmunit ?></td>
				<td><?php echo $value->kdsatker.' -- '.$value->nmsatker ?></td>            
				<td><?php if($value->is_done == 1){ echo "<img src= '".ASSETS_DIR_IMG."done.png' /><br>"; echo "Sukses"; } else { echo "<img src= '".ASSETS_DIR_IMG."notdone.png' />"; echo "Gagal"; } ?></td>
			</tr>
        <?php endforeach;?>
        </tbody>
			<?php }else{ echo '<br><br>No Data';}?>
    </table>
</div>

<div id="nav-box">
    <div class="clearfix"></div>
</div>