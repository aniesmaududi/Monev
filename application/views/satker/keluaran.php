			<h1><?php echo $title;?></h1>
			<div id="search-box">
				
			</div>
			<div id="nav-box">
				<span class="custom-button-span" style="text-align:right;padding-right:10px;">
				<?php 
				if($output && isset($kdgiat)):?>
					<a type="button" class="custom-button" /><span class="icon pdf"></span>pdf</a>
					<a type="button" class="custom-button" /><span class="icon excel"></span>excel</a>
				<?php else:
					echo $page;
				endif;?>
				</span>
				<div class="clearfix"></div>
				<div class="box-content box-report">
					<div class="filter-option-box">
						<?php $this->view('satker/filter-box');?>
					</div>
					<?php if($output && !isset($kdgiat)):?>
					<table id="report">
						<thead>
							<?php if(!isset($kddept)):?>
							<th>K/L</th>
							<?php endif;?>
							<?php if(!isset($kdunit)):?>
							<th>Eselon I</th>
							<?php endif;?>
							<?php if(!isset($kdprogram)):?>
							<th>Program</th>
							<?php endif;?>
							<th>Kegiatan</th>					
						</thead>
						<tbody>
						<?php foreach($output as $output_item): ?>		
						<tr valign="top" onclick="javascript:window.location('<?php echo site_url()?>')">
							<?php if(!isset($kddept)):?>
							<td><?php echo $output_item->nmdept;?></td>
							<?php endif;?>
							<?php if(!isset($kdunit)):?>
							<td><?php echo $output_item->nmunit;?></td>
							<?php endif;?>
							<?php if(!isset($kdprogram)):?>
							<td><?php echo $output_item->nmprogram;?></td>
							<?php endif;?>
							<td><?php echo $output_item->nmgiat;?></td>
						</tr>
						<?php endforeach;?>
						</tbody>
					</table>
					<?php elseif($output && isset($kdgiat)):?>
						<table id="report">
							<thead>
								<tr>
									<th rowspan="2" width="300">Keluaran</th>
									<th colspan="2">Volume Keluaran</th>
									<th rowspan="2" width="80">Tk. Penc Keluaran</th>		
								</tr>
								<tr>
									<th width="100">Target</th>
									<th width="100">Realisasi</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$total_k =0;
								$i = 0;
								foreach($output as $output_item):?>
								<tr>
									<td><?php echo $output_item->nmoutput?><br>
										<span class="gray small-text">(<?php echo $output_item->sat?>)</span></td>
									<td align="center"><?php echo $output_item->tvk?></td>
									<td align="center"><?php echo $output_item->rvk?></td>
									<td align="center"><?php $k = round($output_item->rvk/$output_item->tvk*100,2);echo $k;?>%</td>
								</tr>
								<?php 
								$total_k += $k; 
								$i++;
								endforeach;?>
								<tr class="row-grey">
									<td colspan="3" align="right"><b>Rata-rata Pencapaian Keluaran</b></td>
									<td align="center"><b><?php $PK = round($total_k/$i,2);
										echo $PK.'%';?></b></td>
								</tr>
							</tbody>
						</table>
					<?php else:?>
						<p class="alert-message block-message error laporan-alert">Tidak ada data</p>
					<?php endif; ?>
				</div>				
			</div>