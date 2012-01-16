			<h1><?php echo $title;?></h1>			        
			<div id="search-box">				
				<div class="filter-option-box">
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
					<?php if(isset($kddept) && $kddept != 0): ?>				
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
					<?php endif;?>
					
					<?php if((isset($kddept) && $kddept != 0) && (isset($kdunit) && $kdunit != 0)): ?>				
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
					<?php endif; ?>
					<span class="form-tampilkan">
					<form name="form4" action="<?php echo site_url('dja/konsistensi_table');?>" method="POST">
						<?php if(isset($kddept)) { ?><input type="hidden" name="kddept" value="<?php echo $kddept;?>"/><?php } ?>
						<?php if(isset($kdunit)) { ?><input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/><?php } ?>
						<?php if(isset($kdprogram)) { ?><input type="hidden" name="kdprogram" value="<?php echo $kdprogram;?>"/><?php } ?>
						<input type="submit" name="submit-k" value="Tampilkan" class="custom" />					
					</form>
					</span>
				</div>
				
			</div>
			<div id="nav-box">
				<div class="box-content">
				<?php if(isset($submitK)): ?>
					<?php if(isset($realisasi)):?>
					<table id="report">
						<thead>
							<th width="60">Tahun</th>
							<th>Bulan</th>
							<th width="150">RPD Kumulatif</th>
							<th width="150">Realisasi Kumulatif</th>
							<th width="100">Tk. Penyerapan</th>						
						</thead>
						<tbody>
							<tr><td rowspan="12" align="center"><?php echo $thang?></td></tr>
							<?php
							for($i=1;$i<12;$i++):
								$bulan = $i;
								if($i<10):
									$bulan = '0'.$i;
								endif;
								switch($i){
									case 1 : $m = "Januari"; break;
									case 2 : $m = "Februari"; break;
									case 3 : $m = "Maret"; break;
									case 4 : $m = "April"; break;
									case 5 : $m = "Mei"; break;
									case 6 : $m = "Juni"; break;
									case 7 : $m = "Juli"; break;
									case 8 : $m = "Agustus"; break;
									case 9 : $m = "September"; break;
									case 10 : $m = "Oktober"; break;
									case 11 : $m = "November"; break;
									case 12 : $m = "Desember"; break;
								}								
							?>
							<tr>
								
								<td><?php echo $m;?></td>
								<td align="right"><span class="rupiah">Rp.</span><span class="rupiah_number"><?php echo number_format(get_konsistensi_perbulan($thang,$bulan,$kddept,$kdunit,$kdprogram)->rpd);?></span></td>
								<td align="right"><span class="rupiah">Rp.</span><span class="rupiah_number"><?php echo number_format(get_konsistensi_perbulan($thang,$bulan,$kddept,$kdunit,$kdprogram)->realisasi);?></span></td>
								<td align="center"><?php echo get_konsistensi_perbulan($thang,$bulan,$kddept,$kdunit,$kdprogram)->konsistensi;?></td>
							</tr>
							<?php endfor; ?>
						</tbody>
					</table>
					<?php else:?>
						<p class="alert-message block-message error laporan-alert">Tidak ada data</p>
					<?php endif;?>
				<?php endif;?>
				</div>
			</div>