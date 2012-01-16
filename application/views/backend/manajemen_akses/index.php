			<h1><?php echo $title;?></h1>
			<div id="search-box" style="min-height:400px;">
				<?php echo $this->session->flashdata('message');
				if(count($hasil)>0):?>
				<?php
				if($this->session->flashdata('message')):
					echo flash_message($this->session->flashdata('message_type'));
				endif;
				?>
					<table class="backend-table">
						<thead>
							<th>Nama Department</th>
							<th>Nama Unit</th>
							<th>Nama Satker</th>
							<th>Start</th>
							<th>End</th>
							<th class="option-table">Option</th>
						</thead>
						<?php foreach($hasil as $row):?>
						<tr>
							<td><?php echo $row->nmdept; ?></td>
							<td><?php echo $row->nmunit; ?></td>
							<td><?php echo $row->nmsatker; ?></td>
							<td><?php echo $row->start_time; ?></td>
							<td><?php echo $row->end_time; ?></td>
							<td><?php echo anchor('backend/access_management/edit/'.$row->id,'Edit');?></td>
						</tr>
						<?php endforeach; ?>
					</table>					
				<?php else:?>
					no data
				<?php endif;?>
			</div>
			<div id="nav-box">
				<div class="clearfix"></div>
			</div>