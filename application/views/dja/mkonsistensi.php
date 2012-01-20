			
			<h1><?php echo $title;?></h1>			        
			<div id="search-box">
			</div>
			<div id="nav-box">
				<span class="custom-button-span"></span>
				<div class="clearfix"></div>
				<div class="box-content box-report">
					<div class="filter-option-box">
						<?php $this->view('dja/mfilter-box')?>
					</div>
					<?php if($konsistensi):?>
					<?php $this->view('dja/_chart_konsistensi');?>
					<table id="report">
						<thead>
							<th width="140">Tahun Anggaran</th>
							<th>Bulan</th>
							<th width="150">RPD Kumulatif</th>
							<th width="150">Realisasi Kumulatif</th>
							<th width="100">Tk. Penyerapan</th>						
						</thead>
						<tbody>
							<?php 
								$total_k = 0;
								$i = 1;
								$count = count($konsistensi);
								foreach($konsistensi as $konsistensi_data):
								$nilai_k = $konsistensi_data->konsistensi;
							?>
							<tr>
								<?php if($i==1):?>
								<td rowspan="<?php echo $count;?>" align="center"><?php echo $thang?></td>
								<?php endif;?>
								<td><?php echo format_bulan($konsistensi_data->bulan,'long_from0');?></td>
								<td align="right"><span class="rupiah">Rp.</span><span class="rupiah_number"><?php echo number_format($konsistensi_data->jmlrpd);?></span></td>
								<td align="right"><span class="rupiah">Rp.</span><span class="rupiah_number"><?php echo number_format($konsistensi_data->jmlrealisasi);?></span></td>
								<td align="center"><?php echo $nilai_k;?>%</td>
							</tr>
							<?php 
								$total_k += $nilai_k;
								$i++;
								endforeach;
								$rata_k = round($total_k/$i,2);
							?>
							<tr>
								<td align="right" colspan="4" class="row-grey"><b>Rata-rata</b></td>
								<td align="center" class="row-grey"><?php echo $rata_k?>%</td>
							</tr>
						</tbody>
					</table>
					<br><br>
					<div class="clearfix">
					<div id="chart-container-konsistensi" class="chart-container"  style="width: 100%; float:left; height: 300px; margin: 0;"></div>
					</div>
					<?php else:?>
						<p class="alert-message block-message error laporan-alert">Tidak ada data</p>
					<?php endif;?>
				</div>
			</div>