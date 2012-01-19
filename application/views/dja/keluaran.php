			<h1><?php echo $title;?></h1>
			<div id="search-box">
				
			</div>
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
								<form name="form1" action="<?php echo site_url('dja/keluaran_table');?>" method="POST">					
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
								<form name="form2" action="<?php echo site_url('dja/keluaran_table');?>" method="POST">
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
								<form name="form3" action="<?php echo site_url('dja/keluaran_table');?>" method="POST">
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
							<?php if(!isset($kddept)):?>
							<th>K/L</th>
							<?php endif;?>
							<?php if(!isset($kdunit)):?>
							<th>Eselon I</th>
							<?php endif;?>
							<?php if(!isset($kdprogram)):?>
							<th>Program</th>
							<?php endif;?>
							<th>Satker</th>
							<th>Kegiatan</th>					
						</thead>
						<tbody>
						<?php foreach($output as $output_item): ?>		
						<tr valign="top" onclick="javascript:window.location('<?php echo site_url()?>')">
							<?php if(!isset($kddept)):?>
							<td><?php echo $output_item->departemen;?></td>
							<?php endif;?>
							<?php if(!isset($kdunit)):?>
							<td><?php echo $output_item->eselon;?></td>
							<?php endif;?>
							<?php if(!isset($kdprogram)):?>
							<td><?php echo $output_item->program;?></td>
							<?php endif;?>
							<td><?php echo $output_item->satker;?></td>
							<td><?php echo $output_item->kegiatan;?></td>
						</tr>
						<?php endforeach;?>
						</tbody>
					</table>
					<?php else:?>
						<p class="alert-message block-message error laporan-alert">Tidak ada data</p>
					<?php endif; ?>
				</div>				
				
			</div>