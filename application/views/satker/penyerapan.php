<h1>Pengukuran Penyerapan Anggaran</h1>
			<div id="search-box"></div>
			<div id="nav-box">
				<span class="custom-button-span">
					<?php if($penyerapan):?>
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
								<form name="form1" action="" method="POST">					
									<select name="kddept" onchange="this.form.submit();" disabled=disabled class="chzn-select" style="width:519px" data-placeholder="PILIH KEMENTERIAN" tabindex="1">
										<option value="<?php echo $kddept?>"><?php echo get_detail_data('t_dept',array('kddept'=>$kddept),'nmdept');?></option>
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
									<select name="kdunit" onchange="this.form.submit();" disabled=disabled class="chzn-select" style="width:519px" data-placeholder="PILIH ESELON" tabindex="2">
										<option value="<?php echo $kdunit?>"><?php echo get_detail_data('t_unit',array('kddept'=>$kddept,'kdunit'=>$kdunit),'nmunit');?></option>
									</select>					
								</form>
								</td>
							</tr>
							<?php endif;?>
							<?php if((isset($kddept) && $kddept != 0) && (isset($kdunit) && $kdunit != 0)): ?>
							<tr>
								<td width="150" class="bold">Program</td>
								<td>:</td>
								<td>
								<form name="form3" action="" method="POST">
									<input type="hidden" name="kddept" value="<?php echo $kddept;?>"/>
									<input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/>
									<select name="kdprogram" onchange="this.form.submit();" class="chzn-select" style="width:519px" data-placeholder="PILIH PROGRAM" tabindex="3">
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
							<?php if((isset($kddept) && $kddept != 0) && (isset($kdunit) && $kdunit != 0)&& (isset($kdprogram) && $kdprogram != 0)): ?>
							<tr>
								<td width="150" class="bold">Kegiatan</td>
								<td>:</td>
								<td>
								<form name="form3" action="" method="POST">
									<input type="hidden" name="kddept" value="<?php echo $kddept;?>"/>
									<input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/>
									<input type="hidden" name="kdprogram" value="<?php echo $kdprogram;?>"/>
									<select name="kdgiat" onchange="this.form.submit();" class="chzn-select" style="width:519px" data-placeholder="PILIH KEGIATAN" tabindex="3">
										<option value="0" selected="selected">SEMUA KEGIATAN</option>
										<?php
										foreach ($giat as $item):
											if($kdgiat == $item->kdgiat){ $selected = 'selected';} else { $selected = "";}
										?>
										<option value="<?php echo $item->kdgiat;?>" <?php echo $selected;?>>
										<?php echo $item->kdgiat;?> &mdash; <?php echo $item->nmgiat;?>
										</option>				
									<?php endforeach ?>
									</select>					
								</form>
								</td>
							</tr>
							<?php endif; ?>
						</table>
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
								<td align="center"><?php echo $thang?></td>
								<td align="right">
									<span class="rupiah">Rp.</span><span class="rupiah_number"><?php echo number_format($penyerapan->jmlpagu)?></span>
								</td>
								<td align="right">
									<span class="rupiah">Rp.</span><span class="rupiah_number"><?php echo number_format($penyerapan->jmlrealisasi)?></span>
								</td>
								<td align="right">
									<?php echo ($penyerapan->p) ? $penyerapan->p : 0;?>%
								</td>
							</tr>
						</tbody>
					</table>
					<?php else:?>
						<p class="alert-message block-message error">Tidak ada data</p>
					<?php endif; ?>
				</div><!-- end of box-content -->
			</div><!-- end of nav-box -->