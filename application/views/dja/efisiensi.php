			<h1><?php echo $title;?></h1>			        
			<div id="search-box"></div>
				
			<div id="nav-box">
				<span class="custom-button-span"></span>
				<div class="clearfix"></div>
				<div class="box-content box-report">
				<div class="filter-option-box">
					<table>
						<tr>
							<td width="150" class="bold">Kementrian / Lembaga</td>
							<td>:</td>
							<td>
							<form name="form1" action="<?php echo site_url('dja/efisiensi_table');?>" method="POST">					
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
							<form name="form2" action="<?php echo site_url('dja/efisiensi_table');?>" method="POST">
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
							<form name="form3" action="<?php echo site_url('dja/efisiensi_table');?>" method="POST">
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
				<?php if($output):?>
					<table id="report">
						<thead>
							<tr>
								<th>Keluaran</th>
								<th>Target</th>
								<th>Realisasi</th>
								<th width="100">Pagu Anggaran</th>
								<th width="100">Realisasi Anggaran</th>
								<th>Efisiensi</th>
							</tr>
						</thead>
						<tbody>
							<?php $total_ek = 0; foreach($output as $output_item): ?>					
							<tr style="font-size:12px;" valign="top">					
								<td><?php echo $output_item['nmoutput'].'<br>
									<span class="gray small-text">('.$output_item['sat'].')</span>';?></td>
								<td align="right"><?php $TVK = $output_item['tvk']; echo $TVK; ?></td>
								<td align="right"><?php $RVK = $output_item['rvk']; echo $RVK; ?></td>
								<td align="right">
									<?php 
									$pagu = $this->mdja->get_pagu_anggaran_keluaran($output_item['kddept'], $output_item['kdunit'], $output_item['kdsatker'], $output_item['kdprogram'], $output_item['kdgiat'], $output_item['kdoutput']);
									$PAK = $pagu['pagu'];
									echo number_format($PAK);
									?>
								</td>
								<td align="right">
									<?php
									$realisasi = $this->mdja->get_realisasi_anggaran_keluaran($output_item['kddept'], $output_item['kdunit'], $output_item['kdsatker'], $output_item['kdprogram'], $output_item['kdgiat'], $output_item['kdoutput']);
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
							<tr style="font-size:12px;">
								<td colspan="5"><b>Efisiensi</b></td>
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