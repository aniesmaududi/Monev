			<h1><?php echo $title;?></h1>
			<div id="search-box">
				<form name="form1" action="<?php echo base_url();?>dja/keluaran_table" method="POST">					
					<select name="kddept" onchange="this.form.submit();" style="width:650px;">
						<option value="0" selected="selected">Semua Kementerian</option>
					<?php					
					foreach ($dept as $item):
						if($kddept == $item['kddept']){ $selected = 'selected';} else { $selected = "";}
					?>
						<option value="<?php echo $item['kddept'];?>" <?php echo $selected;?>>
						<?php echo $item['kddept'];?> -- <?php echo $item['nmdept'];?>
						</option>				
					<?php endforeach ?>
					</select>					
				</form>
				<?php				
				if(isset($kddept) && $kddept != 0){					
				?>				
				<form name="form2" action="<?php echo base_url();?>dja/keluaran_table" method="POST">
					<input type="hidden" name="kddept" value="<?php echo $kddept;?>"/>
					<select name="kdunit" onchange="this.form.submit();" style="width:650px;">
						<option value="0" selected="selected">Semua Eselon</option>
					<?php
					foreach ($unit as $item):
						if($kdunit == $item['kdunit']){ $selected = 'selected';} else { $selected = "";}
					?>
						<option value="<?php echo $item['kdunit'];?>" <?php echo $selected;?>>
						<?php echo $item['kdunit'];?> -- <?php echo $item['nmunit'];?>
						</option>				
					<?php endforeach ?>
					</select>					
				</form>
				<?php
				} 				
				if((isset($kddept) && $kddept != 0) && (isset($kdunit) && $kdunit != 0)){					
				?>				
				<form name="form3" action="<?php echo base_url();?>dja/keluaran_table" method="POST">
					<input type="hidden" name="kddept" value="<?php echo $kddept;?>"/>
					<input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/>
					<select name="kdprogram" onchange="this.form.submit();" style="width:650px;">
						<option value="0" selected="selected">Semua Program</option>
					<?php
					foreach ($program as $item):
						if($kdprogram == $item['kdprogram']){ $selected = 'selected';} else { $selected = "";}
					?>
						<option value="<?php echo $item['kdprogram'];?>" <?php echo $selected;?>>
						<?php echo $item['kdprogram'];?> -- <?php echo $item['nmprogram'];?>
						</option>				
					<?php endforeach ?>
					</select>					
				</form>
				<?php } ?>
				<br>
				<form name="form4" action="<?php echo base_url();?>dja/keluaran_table" method="POST">
					<?php if(isset($kddept)) { ?><input type="hidden" name="kddept" value="<?php echo $kddept;?>"/><?php } ?>
					<?php if(isset($kdunit)) { ?><input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/><?php } ?>
					<?php if(isset($kdprogram)) { ?><input type="hidden" name="kdprogram" value="<?php echo $kdprogram;?>"/><?php } ?>
					<input type="submit" name="submit-pk" value="Tampilkan"/>					
				</form>
			</div>
			<div style="overflow:auto;">
				<?php if(isset($submitPK)) {
					//echo 'kddept : '.$kddept.' kdunit : '.$kdunit.' kdprogram : '.$kdprogram;
				?>
				<table border="1" width="200%" cellpadding="2" cellspacing="0" style="border: 1px solid #cecece;">
					<thead>
						<th>K/L</th>
						<th>Eselon I</th>
						<th>Satker</th>
						<th>Program</th>
						<th>Kegiatan</th>
						<th>Keluaran</th>
						<th>Target</th>
						<th>Realisasi</th>
						<th>Penc. Keluaran</th>						
					</thead>
					<tbody>
					<?php
					$total_k = 0;
					foreach($output as $output_item):
					?>					
					<tr>
						<td>
							<?php echo $output_item['nmdept'];?>
						</td>
						<td>
							<?php echo $output_item['nmunit'];?>
						</td>
						<td>
							<?php echo $output_item['nmsatker'];?>
						</td>
						<td>
							<?php echo $output_item['nmprogram'];?>
						</td>
						<td>
							<?php echo $output_item['nmgiat'];?>
						</td>
						<td>
							<?php echo $output_item['nmoutput'];?>
						</td>
						<td>
							<?php echo $output_item['tvk'].' '.$output_item['sat'];?>
						</td>
						<td>
							<?php echo $output_item['rvk'].' '.$output_item['sat'];?>
						</td>
						<td>
							<?php
							$k = round($output_item['rvk']/$output_item['tvk']*100,2);
							echo $k;
							?>
							%
						</td>
					</tr>					
					<?php
					$total_k += $k;
					endforeach
					?>
					</tbody>
				</table>
				<div class="box-content" style="width:200%;background:#333;color:#fff;">					
					<div class="column1" style="font-size:14px;">
						Pencapaian Keluaran
					</div>					
					<div class="column4" style="font-size:14px;">
						<?php						
						if(isset($total_k) && $n > 0)
						{
							$PK = round($total_k/$n,2);
							echo $PK.'%';
						} else {
							echo 0 . '%';
						}
						?>						
					</div>
					<div class="clearfix"></div>				
				</div><!-- end of box-content -->
				<?php } ?>
			</div>