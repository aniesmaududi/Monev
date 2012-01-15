			<h1><?php echo $title;?></h1>			
			<div id="search-box">		
				<div class="filter-option-box">
					<form name="form1" action="<?php echo site_url('dja/penyerapan_table');?>" method="POST">					
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
					<form name="form2" action="<?php echo site_url('dja/penyerapan_table');?>" method="POST">
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
					<form name="form3" action="<?php echo site_url('dja/penyerapan_table');?>" method="POST">
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
					<form name="form4" action="<?php echo site_url('dja/penyerapan_table');?>" method="POST">
						<?php if(isset($kddept)) { ?><input type="hidden" name="kddept" value="<?php echo $kddept;?>"/><?php } ?>
						<?php if(isset($kdunit)) { ?><input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/><?php } ?>
						<?php if(isset($kdprogram)) { ?><input type="hidden" name="kdprogram" value="<?php echo $kdprogram;?>"/><?php } ?>
						<input type="submit" name="submit-p" value="Tampilkan" class="custom" />					
					</form>
					</span>
				</div>
			</div>
			<div id="nav-box">
				<div class="box-content">
				<?php if(isset($submitP)): ?>
					<table id="report">
						<thead>
							<th>Program</th>
							<th>Pagu Anggaran</th>
							<th>Realisasi Anggaran</th>
							<th width="80">Persentase</th>				
						</thead>
						<tbody>
							<tr>
								<td><?php if(isset($nmprogram)) { echo $nmprogram; } else { echo 'Semua Program';}?></td>
								<td align="right">
									<?php if(empty($total_pagu)) { $total_pagu = 0; } ?>
									<input type="hidden" class="realisasi" name="pagu" value="<?php echo $total_pagu;?>"/>
									Rp. <?php echo $this->mdja->formatMoney($total_pagu);?>
								</td>
								<td align="right">
									<?php if(empty($total_realisasi)) { $total_realisasi = 0; } ?>
									<input type="hidden" class="realisasi" name="realisasi" value=""/>
									Rp. <?php echo $this->mdja->formatMoney($total_realisasi);?>
								</td>
								<td align="right">
									<input type="hidden" class="realisasi" name="persentase" value=""/>
									<?php
										if($total_pagu > 0) {
										$P = round(($total_realisasi/$total_pagu)*100,2);
										} else {
										$P = 0;	
										}
										echo $P;
									?>
									%
								</td>
							</tr>
						</tbody>
					</table>
					<?php echo $graph_P;?>
					<div class="clearfix"></div>
				<?php endif; ?>
				</div><!-- end of box-content -->
				
			</div>