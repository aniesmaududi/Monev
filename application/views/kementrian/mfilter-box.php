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
							<?php if($this->uri->segment(2)=='mkonsistensi'):?>
							<tr>
								<td width="150" class="bold">Bulan</td>
								<td>:</td>
								<td>
								<form name="form" action="" method="POST">					
									<select name="bulan_awal" onchange="this.form.submit();" class="chzn-select" style="width:150px;" data-placeholder="PILIH TAHUN ANGGARAN" tabindex="1">
										<option value="">PILIH BULAN</option>	
										<?php for($i=1;$i<=12;$i++):
											if($bulan_awal == $i){ $selected = 'selected';} else { $selected = "";}
										?>
											<option value="<?php echo $i;?>" <?php echo $selected;?>>
											<?php echo format_bulan($i,'long');?>
											</option>				
										<?php endfor; ?>
									</select>
									<span class="sampai-bulan">sampai</span> 
									<select name="bulan_akhir" onchange="this.form.submit();" class="chzn-select" style="width:150px;" data-placeholder="PILIH TAHUN ANGGARAN" tabindex="1">
										<option value="">PILIH BULAN</option>	
										<?php for($i=1;$i<=12;$i++):
											if($bulan_akhir == $i){ $selected = 'selected';} else { $selected = "";}
										?>
											<option value="<?php echo $i;?>" <?php echo $selected;?>>
											<?php echo format_bulan($i,'long');?>
											</option>				
										<?php endfor; ?>
									</select>
								</form>
								</td>
							</tr>
							<?php endif;?>
							<tr>
								<td width="150" class="bold">Kementrian / Lembaga</td>
								<td>:</td>
								<td>
								<form name="form1" action="" method="POST">					
									<select name="kddept" onchange="this.form.submit();" class="chzn-select" disabled=disabled data-placeholder="PILIH KEMENTERIAN" tabindex="1">
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
									<select name="kdunit" onchange="this.form.submit();" class="chzn-select" data-placeholder="PILIH ESELON" tabindex="2">
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
									<select name="kdprogram" onchange="this.form.submit();" class="chzn-select" data-placeholder="PILIH PROGRAM" tabindex="3">
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
							<?php if(($this->uri->segment(2)!='mpenyerapan' && $this->uri->segment(2)!='mkeluaran') && (isset($kddept) && $kddept != 0) && (isset($kdunit) && $kdunit != 0) && (isset($kdprogram) && $kdprogram != 0)): ?>
							<tr>
								<td width="150" class="bold">Satuan Kerja</td>
								<td>:</td>
								<td>
								<form name="form4" action="" method="POST">
									<input type="hidden" name="kddept" value="<?php echo $kddept;?>"/>
									<input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/>
									<input type="hidden" name="kdprogram" value="<?php echo $kdprogram;?>"/>
									<select name="kdsatker" onchange="this.form.submit();" class="chzn-select" data-placeholder="PILIH SATKER" tabindex="3">
										<option value="0" selected="selected">SEMUA SATKER</option>
										<?php
										foreach ($satker as $item):
											if($kdsatker == $item->kdsatker){ $selected = 'selected';} else { $selected = "";}
										?>
										<option value="<?php echo $item->kdsatker;?>" <?php echo $selected;?>>
										<?php echo $item->kdsatker;?> &mdash; <?php echo $item->nmsatker;?>
										</option>				
									<?php endforeach ?>
									</select>					
								</form>
								</td>
							</tr>							
							<?php endif;?>
							<?php if(($this->uri->segment(2)!='mpenyerapan' && $this->uri->segment(2)=='mkeluaran') && (isset($kddept) && $kddept != 0) && (isset($kdunit) && $kdunit != 0) && (isset($kdprogram) && $kdprogram != 0)): ?>
							<tr>
								<td width="150" class="bold">Kegiatan</td>
								<td>:</td>
								<td>
								<form name="form5" action="" method="POST">
									<input type="hidden" name="kddept" value="<?php echo $kddept;?>"/>
									<input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/>
									<input type="hidden" name="kdprogram" value="<?php echo $kdprogram;?>"/>
									<select name="kdgiat" onchange="this.form.submit();" class="chzn-select" data-placeholder="PILIH KEGIATAN" tabindex="3">
										<option value="0" selected="selected">PILIH KEGIATAN</option>
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
							<?php endif;?>	
						</table>