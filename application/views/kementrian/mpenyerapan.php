			<h1><?php echo $title;?></h1>			
			<div id="search-box">		
				
			</div>
			<div id="nav-box">
				<span class="custom-button-span">
					
				</span>
				<div class="clearfix"></div>
				<div class="box-content box-report">
					<div class="filter-option-box">
						<?php $this->view('kementrian/mfilter-box');?>
					</div>
					<?php if($penyerapan):?>
					<table id="report">
						<thead>
							<th>Tahun Anggaran</th>
							<th>Pagu Anggaran</th>
							<th>Realisasi Anggaran</th>
							<th>Persentase</th>				
						</thead>
						<tbody>
							<tr>
								<td align="center"><?php echo $penyerapan->tahun?></td>
								<td align="right">
									<span class="rupiah">Rp.</span><span class="rupiah_number"><?php echo number_format($penyerapan->pagu)?></span>
								</td>
								<td align="right">
									<span class="rupiah">Rp.</span><span class="rupiah_number"><?php echo number_format($penyerapan->realisasi)?></span>
								</td>
								<td align="right">
									<?php echo $penyerapan->penyerapan?>%
								</td>
							</tr>
						</tbody>
					</table>
					<?php  $this->view('chart/_chart_penyerapan');?>
					<br><br>
					<div class="clearfix">
					<div id="chart-container-penyerapan" class="chart-container"  style="width: 100%; float:left; height: 300px; margin: 0;"></div>
					</div>
					<?php else:?>
						<p class="alert-message block-message error">Tidak ada data</p>
					<?php endif; ?>
				</div><!-- end of box-content -->
				
			</div>