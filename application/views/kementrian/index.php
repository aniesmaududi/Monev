            <h1><?php echo(isset($title))?$title:'Dashboard Kementrian';?></h1>
			<div id="search-box" style="min-height:400px;">
				<div class="filter-option-box">
					<?php if(isset($kddept) && $kddept != 0): ?>				
					<form name="form2" action="<?php echo site_url('kementrian');?>" method="POST">
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
					<form name="form3" action="<?php echo site_url('kementrian');?>" method="POST">
						<input type="hidden" name="kddept" value="<?php echo $kddept;?>"/>
						<input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/>
						<select name="kdprogram" onchange="this.form.submit();" class="chzn-select" data-placeholder="PILIH PROGRAM" tabindex="3">
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
					<?php endif; ?>
					<span class="form-tampilkan">
					<form name="form4" action="<?php echo site_url('kementrian');?>" method="POST">
						<?php if(isset($kddept)) { ?><input type="hidden" name="kddept" value="<?php echo $kddept;?>"/><?php } ?>
						<?php if(isset($kdunit)) { ?><input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/><?php } ?>
						<?php if(isset($kdprogram)) { ?><input type="hidden" name="kdprogram" value="<?php echo $kdprogram;?>"/><?php } ?>
						<input type="submit" name="submit-pk" value="Tampilkan" class="custom" />					
					</form>
					</span>
				</div>
				<h3>Grafik Indikator Kerja</h3>
				<table class="chart-bar accessHide" >
					<caption>Grafik Indikator Kerja</caption>
					<thead>
						<tr>
							<td></td>
							<th scope="col">Penyerapan</th>
							<th scope="col">Konsistensi</th>
							<th scope="col">Keluaran</th>
							<th scope="col">Efisiensi</th>
							<th scope="col">Manfaat</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th scope="row">Bobot Total</th>
							<td>9.7</td>
							<td>18.2</td>
							<td>43.5</td>
							<td>28.6</td>
							<td>0</td>
						</tr>
						<tr>
							<th scope="row">Pencapaian</th>
							<td><?php echo round($penyerapan->p/100*9.7,2);?></td>
							<td><?php echo round($konsistensi->k/100*18.2,2);?></td>
							<td><?php echo round($keluaran->pk/100*43.5,2);?></td>
							<td><?php echo round($efisiensi->e/100*28.6,2);?></td>
							<td>0</td>
						</tr>		
					</tbody>
				</table>
			</div>
			<div id="nav-box">
				
				
				
			</div>