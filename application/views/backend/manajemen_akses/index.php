			<h1><?php echo $title;?></h1>
			<div id="search-box" style="min-height:400px;">
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
							<td>.....</td>
						</tr>
						<?php endforeach; ?>
					</table>					
			</div>
			<div id="nav-box">
				<div class="clearfix"></div>
			</div>