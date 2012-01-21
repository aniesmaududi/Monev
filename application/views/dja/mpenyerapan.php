			<h1><?php echo $title;?></h1>			
			<div id="search-box">		
				
			</div>
			<div id="nav-box">
				<span class="custom-button-span">
					
				</span>
				<div class="clearfix"></div>
				<div class="box-content box-report">
					<div class="filter-option-box">
						<table>
							<tr>
								<td width="150" class="bold">Tahun Anggaran</td>
								<td>:</td>
								<td>
								<form name="form" action="" method="POST">					
									<select name="thang" onchange="this.form.submit();" class="chzn-select" style="width:519px;" data-placeholder="PILIH TAHUN ANGGARAN" tabindex="1">
											<?php					
											foreach (get_thang() as $item):
												if($thang == $item->thang){ $selected = 'selected';} else { $selected = "";}
											?>
											<option value="<?php echo $item->thang;?>" <?php echo $selected;?>>
											<?php echo $item->thang;?>
											</option>				
										<?php endforeach; ?>
									</select>					
								</form>
								</td>
							</tr>
							<tr>
								<td width="150" class="bold">Kementrian / Lembaga</td>
								<td>:</td>
								<td>
								<form name="form1" action="" method="POST">					
									<select name="kddept" onchange="this.form.submit();" class="chzn-select" style="width:519px;" data-placeholder="PILIH KEMENTERIAN" tabindex="1">
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
								<form name="form2" action="" method="POST">
									<input type="hidden" name="kddept" value="<?php echo $kddept;?>"/>
									<select name="kdunit" onchange="this.form.submit();" class="chzn-select" style="width:519px;" data-placeholder="PILIH ESELON" tabindex="2">
										<option value="0" selected="selected">SEMUA ESELON</option>
										<?php
										foreach ($unit as $item):
											if($kdunit == $item->kdunit){ $selected = 'selected';} else { $selected = "";}
										?>
										<option value="<?php echo $item->kdunit;?>" <?php echo $selected;?>>
										<?php echo $item->kdunit;?> &mdash; <?php echo $item->nmunit;?>
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
								<form name="form3" action="" method="POST">
									<input type="hidden" name="kddept" value="<?php echo $kddept;?>"/>
									<input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/>
									<select name="kdprogram" onchange="this.form.submit();" class="chzn-select" style="width:519px;" data-placeholder="PILIH PROGRAM" tabindex="3">
										<option value="0" selected="selected">SEMUA PROGRAM</option>
										<?php
										foreach ($program as $item):
											if($kdprogram == $item->kdprogram){ $selected = 'selected';} else { $selected = "";}
										?>
										<option value="<?php echo $item->kdprogram;?>" <?php echo $selected;?>>
										<?php echo $item->kdprogram;?> &mdash; <?php echo $item->nmprogram;?>
										</option>				
									<?php endforeach ?>
									</select>					
								</form>
								</td>
							</tr>
							<?php endif; ?>
						</table>
					</div>
					<?php // if(isset($submitP)): ?>
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
					<?php // endif; ?>
				</div><!-- end of box-content -->
				
			</div>