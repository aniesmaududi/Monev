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
							<?php if((isset($kddept) && $kddept != 0) && (isset($kdunit) && $kdunit != 0) && (isset($kdprogram) && $kdprogram != 0)): ?>
							<tr>
								<td width="150" class="bold">Satuan Kerja</td>
								<td>:</td>
								<td>
								<form name="form3" action="<?php echo site_url('dja/konsistensi_table');?>" method="POST">
									<input type="hidden" name="kddept" value="<?php echo $kddept;?>"/>
									<input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/>
									<input type="hidden" name="kdprogram" value="<?php echo $kdprogram;?>"/>
									<select name="kdsatker" onchange="this.form.submit();" class="chzn-select" data-placeholder="PILIH PROGRAM" tabindex="3">
										<option value="0" selected="selected">SEMUA SATKER</option>
										<?php
										foreach ($satker as $item):
											if($kdsatker == $item['kdsatker']){ $selected = 'selected';} else { $selected = "";}
										?>
										<option value="<?php echo $item['kdsatker'];?>" <?php echo $selected;?>>
										<?php echo $item['kdsatker'];?> &mdash; <?php echo $item['nmsatker'];?>
										</option>				
									<?php endforeach ?>
									</select>					
								</form>
								</td>
							</tr>
							<?php endif;?>
						</table>
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