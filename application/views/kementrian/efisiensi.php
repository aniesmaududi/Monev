			<h1><?php echo $title;?></h1>			        
			<div id="search-box"></div>
				
			<div id="nav-box">
				<span class="custom-button-span">
				<?php if($output): ?>
				<a type="button" class="custom-button" /><span class="icon pdf"></span>pdf</a>
				<a type="button" class="custom-button" /><span class="icon excel"></span>excel</a>
				<?php endif;?>
				</span>
				<div class="clearfix"></div>
				<div class="box-content box-report">
				<div class="filter-option-box">
					<?php $this->view('kementrian/filter-box')?>
				</div>
				<?php if($output):?>
					<table id="report">
						<thead>
							<tr>
								<th rowspan="2">Keluaran</th>
								<th colspan="2">Volume</th>
								<th colspan="2">Anggaran</th>
								<th rowspan="2" width="50">Efisiensi</th>
							</tr>
							<tr>
								<th width="80">Target</th>
								<th width="80">Realisasi</th>
								<th width="100">Pagu</th>
								<th width="100">Realisasi</th>
							</tr>
						</thead>
						<tbody>
							<?php $total_ek = 0; foreach($output as $output_item): ?>					
							<tr style="font-size:12px;" valign="top">					
								<td><?php echo $output_item->nmoutput;?></td>
								<td align="center"><?php $TVK = $output_item->tvk; echo $TVK.'<br>
									<span class="gray small-text">('.$output_item->sat.')</span>'; ?></td>
								<td align="center"><?php $RVK = $output_item->rvk; echo $RVK.'<br>
									<span class="gray small-text">('.$output_item->sat.')</span>'; ?></td>
								<td align="right">
									<?php 
									$pagu = $this->mdja->get_pagu_anggaran_keluaran($output_item->kddept, $output_item->kdunit, $output_item->kdsatker, $output_item->kdprogram, $output_item->kdgiat, $output_item->kdoutput);
									$PAK = $pagu['pagu'];
									echo number_format($PAK);
									?>
								</td>
								<td align="right">
									<?php
									$realisasi = $this->mdja->get_realisasi_anggaran_keluaran($output_item->kddept, $output_item->kdunit, $output_item->kdsatker, $output_item->kdprogram, $output_item->kdgiat, $output_item->kdoutput);
									$RAK = $realisasi['total'];
									echo number_format($RAK);
									?>
								</td>						
								<td align="right">
									<?php
									$ek =round(1-( ($RAK/$RVK) / ($PAK/$TVK) * 100),2);
									echo $ek;
									?>
									%
								</td>					
							</tr>								
							<?php $total_ek += $ek; endforeach;?>
							<tr class="row-grey">
								<td colspan="5" align="right"><b>Efisiensi</b></td>
								<td align="right"><b>
								<?php						
								if(count($output) > 0):
									$E = round($total_ek/$n,2);
									echo $E;
								else:
									echo 0;	
								endif;
								?>
								%</b>
								</td>
							</tr>
						</tbody>
					</table>
				
				<?php else:?>
					<p class="alert-message block-message error laporan-alert">Tidak ada data</p>
				<?php endif; ?>
				</div>
			</div>