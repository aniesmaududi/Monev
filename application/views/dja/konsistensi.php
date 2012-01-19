			<h1><?php echo $title;?></h1>			        
			<div id="search-box">
			</div>
			<div id="nav-box">
				<span class="custom-button-span">
					<?php
					$konsistensi = get_konsistensi_perbulan($thang,null,$kddept,$kdunit,$kdprogram);
					if(isset($konsistensi->rpd)):
					?>
					<a type="button" class="custom-button" /><span class="icon pdf"></span>pdf</a>
					<a type="button" class="custom-button" /><span class="icon excel"></span>excel</a>
					<?php endif;?>
				</span>
				<div class="clearfix"></div>
				<div class="box-content box-report">
					<div class="filter-option-box">
						<table>
							<tr>
								<td width="150" class="bold">Kementrian / Lembaga</td>
								<td>:</td>
								<td>
								<form name="form1" action="<?php echo site_url('dja/konsistensi_table');?>" method="POST">					
									<select name="kddept" onchange="this.form.submit();" class="chzn-select" data-placeholder="PILIH KEMENTERIAN" tabindex="1">
										<option value="0" selected="selected">SEMUA KEMENTERIAN</option>
										<?php					
										foreach ($dept as $item):
											if($kddept == $item['kddept']){ $selected = 'selected';} else { $selected = "";}
										?>
											<option value="<?php echo $item['kddept'];?>" <?php echo $selected;?>>
											<?php echo $item['kddept'];?> &mdash; <?php echo $item['nmdept'];?>
											</option>				
										<?php endforeach; ?>
									</select>					
								</form>
								</td>
							</tr>
							<?php if(isset($kddept) && $kddept != 0): ?>	
							<tr>
								<td width="150" class="bold">Unit / Eselon</td>
								<td>:</td>
								<td>
								<form name="form2" action="<?php echo site_url('dja/konsistensi_table');?>" method="POST">
									<input type="hidden" name="kddept" value="<?php echo $kddept;?>"/>
									<select name="kdunit" onchange="this.form.submit();" class="chzn-select" data-placeholder="PILIH ESELON" tabindex="2">
										<option value="0" selected="selected">SEMUA ESELON</option>
										<?php
										foreach ($unit as $item):
											if($kdunit == $item['kdunit']){ $selected = 'selected';} else { $selected = "";}
										?>
										<option value="<?php echo $item['kdunit'];?>" <?php echo $selected;?>>
										<?php echo $item['kdunit'];?> &mdash; <?php echo $item['nmunit'];?>
										</option>				
									<?php endforeach ?>
									</select>					
								</form>
								</td>
							</tr>
							<?php endif;?>
							<?php if((isset($kddept) && $kddept != 0) && (isset($kdunit) && $kdunit != 0)): ?>
							<tr>
								<td width="150" class="bold">Nama Program</td>
								<td>:</td>
								<td>
								<form name="form3" action="<?php echo site_url('dja/konsistensi_table');?>" method="POST">
									<input type="hidden" name="kddept" value="<?php echo $kddept;?>"/>
									<input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/>
									<select name="kdprogram" onchange="this.form.submit();" class="chzn-select" data-placeholder="PILIH PROGRAM" tabindex="3">
										<option value="0" selected="selected">SEMUA PROGRAM</option>
										<?php
										foreach ($program as $item):
											if($kdprogram == $item['kdprogram']){ $selected = 'selected';} else { $selected = "";}
										?>
										<option value="<?php echo $item['kdprogram'];?>" <?php echo $selected;?>>
										<?php echo $item['kdprogram'];?> &mdash; <?php echo $item['nmprogram'];?>
										</option>				
									<?php endforeach ?>
									</select>					
								</form>
								</td>
							</tr>
							<?php endif; ?>
						</table>
					</div>
					<?php
					if(isset($konsistensi->rpd)):?>
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
								for($i=1;$i<=12;$i++):
								$rpd = get_konsistensi_perbulan($thang,format_bulan($i),$kddept,$kdunit,$kdprogram);
								$realisasi = get_konsistensi_perbulan($thang,format_bulan($i),$kddept,$kdunit,$kdprogram);
								$k = get_konsistensi_perbulan($thang,format_bulan($i),$kddept,$kdunit,$kdprogram);
								$nilai_k = ($k) ? $k->konsistensi : 0;
							?>
							<tr>
								<?php if($i==1):?>
								<td rowspan="12" align="center"><?php echo $thang?></td>
								<?php endif;?>
								<td><?php echo format_bulan($i,'long');?></td>
								<td align="right"><span class="rupiah">Rp.</span><span class="rupiah_number"><?php echo ($rpd) ? number_format($rpd->rpd): 0;?></span></td>
								<td align="right"><span class="rupiah">Rp.</span><span class="rupiah_number"><?php echo ($realisasi) ? number_format($realisasi->realisasi) : 0;?></span></td>
								<td align="center"><?php echo $nilai_k;?>%</td>
							</tr>
							<?php 
								$total_k += $nilai_k;
								endfor;
								$rata_k = round($total_k/12,2);
							?>
							<tr>
								<td align="right" colspan="4" class="row-grey"><b>Rata-rata</b></td>
								<td align="center" class="row-grey"><?php echo $rata_k?>%</td>
							</tr>
						</tbody>
					</table>
					
					<h3>Grafik Konsistensi Penyerapan Anggaran</h3>
					<table class="chart-line2" style="display:none; height:300px;" >
						<caption>Grafik Konsistensi Penyerapan Anggaran</caption>
						<thead>
							<tr>
								<td></td>
								<th scope="col">Jan</th>
								<th scope="col">Feb</th>
								<th scope="col">Mar</th>
								<th scope="col">Apr</th>
								<th scope="col">Mei</th>
								<th scope="col">Jun</th>
								<th scope="col">Jul</th>
								<th scope="col">Agu</th>
								<th scope="col">Sep</th>
								<th scope="col">Okt</th>
								<th scope="col">Nov</th>
								<th scope="col">Des</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th scope="row">Rencana Penarikan Anggaran(Juta)</th>
								<?php for($i=1;$i<=12;$i++):
									$rpd = get_konsistensi_perbulan('2011',format_bulan($i),$kddept,$kdunit,$kdprogram);
								?>
								<td><?php echo ($rpd) ? pembulatan_juta($rpd->rpd) : '0';?></td>
								<?php endfor;?>
							</tr>
							<tr>
								<th scope="row">Realisasi Anggaran(Juta)</th>
								<?php for($i=1;$i<=12;$i++):
									($i<10) ? $bulan='0'.$i : $bulan=$i;
									$realisasi = get_konsistensi_perbulan('2011',format_bulan($i),$kddept,$kdunit,$kdprogram);
								?>
								<td><?php echo ($realisasi) ? pembulatan_juta($realisasi->realisasi) : '0';?></td>
								<?php endfor;?>
							</tr>
						</tbody>
					</table>
					<?php else:?>
						<p class="alert-message block-message error laporan-alert">Tidak ada data</p>
					<?php endif;?>
				</div>
			</div>