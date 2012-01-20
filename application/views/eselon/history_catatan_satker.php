			<h1><?php echo(isset($title))?$title:'Catatan Eselon';?></h1>
			<div id="search-box">
				<p><?php echo(isset($subtitle))?$subtitle:'Catatan Eselon';?>
				<a href="eselon/catatan"> Tambah Catatan</a></p>
			</div>
			<div id="nav-box">
				<!--
				<span class="custom-button-span"></span>				
				<div class="box-content box-report">
					<div class="filter-option-box">
						
					</div>
					<div class="clearfix">
					<div id="chart-container-1" class="chart-container"  style="width: 50%; float:left; height: 300px; margin: 0;left:-20px;position:relative"></div>
					
					<div id="chart-container-2" class="chart-container"  style="width: 50%; float:left; height: 300px; margin: 0"></div>
					</div>
				</div>
				-->
				<div class="box-content box-end">
					<table id="report">
						<thead>
							<th>Satker</th>
							<th>Catatan</th>
							<th>Tgl. Input</th>							
						</thead>
						<tbody>
							<?php foreach($catatan as $row): ?>
							<tr>
								<td align="left"><?php echo $row['kdsatker'];?></td>
								<td align="left"><?php echo $row['catatan'];?></td>
								<td align="center"><?php echo $row['tglupdate'];?></td>
							</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>