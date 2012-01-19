			<h1><?php echo $title;?></h1>			        
			<div id="search-box">
			</div>
			<div id="nav-box">
				<span class="custom-button-span">
					<?php
					if($konsistensi):
					?>
					<a type="button" class="custom-button" /><span class="icon pdf"></span>pdf</a>
					<a type="button" class="custom-button" /><span class="icon excel"></span>excel</a>
					<?php endif;?>
				</span>
				<div class="clearfix"></div>
				<div class="box-content box-report">
					<div class="filter-option-box">
						<?php $this->view('kementrian/filter-box')?>
					</div>
					<?php if($konsistensi):?>
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
								foreach($konsistensi as $konsistensi):
								$nilai_k = $konsistensi->konsistensi;
							?>
							<tr>
								<?php if($i==1):?>
								<td rowspan="12" align="center"><?php echo $thang?></td>
								<?php endif;?>
								<td><?php echo format_bulan($i,'long');?></td>
								<td align="right"><span class="rupiah">Rp.</span><span class="rupiah_number"><?php echo number_format($konsistensi->jmlrpd);?></span></td>
								<td align="right"><span class="rupiah">Rp.</span><span class="rupiah_number"><?php echo number_format($konsistensi->jmlrealisasi);?></span></td>
								<td align="center"><?php echo $nilai_k;?>%</td>
							</tr>
							<?php 
								$total_k += $nilai_k;
								$i++;
								endforeach;
								$rata_k = round($total_k/12,2);
							?>
							<tr>
								<td align="right" colspan="4" class="row-grey"><b>Rata-rata</b></td>
								<td align="center" class="row-grey"><?php echo $rata_k?>%</td>
							</tr>
						</tbody>
					</table>
					<?php else:?>
						<p class="alert-message block-message error laporan-alert">Tidak ada data</p>
					<?php endif;?>
				</div>
			</div>