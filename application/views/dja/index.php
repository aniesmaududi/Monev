<<<<<<< HEAD
=======
			<?php $this->view('_charts');?>
>>>>>>> 632013b0353ed3beebd36dfa26dc508698a933b9
			<h1><?php echo(isset($title))?$title:'Dashboard DJA';?></h1>
			<div id="search-box">
				
				<div class="filter-option-box">
					<!-- combo box semua kementrian -->
					<form name="form1" action="<?php echo site_url('dja');?>" method="POST">					
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
					
					<!-- combo box semua eselon -->
					<?php if(isset($kddept) && $kddept != 0): ?>				
					<form name="form2" action="<?php echo site_url('dja');?>" method="POST">
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
					
					<!-- combo box semua program -->
					<?php if((isset($kddept) && $kddept != 0) && (isset($kdunit) && $kdunit != 0)): ?>				
					<form name="form3" action="<?php echo site_url('dja');?>" method="POST">
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
					
					<!-- this part is tombol tampilkan -->
					<span class="form-tampilkan">
					<form name="form4" action="<?php echo site_url('dja');?>" method="POST">
						<?php if(isset($kddept)) { ?><input type="hidden" name="kddept" value="<?php echo $kddept;?>"/><?php } ?>
						<?php if(isset($kdunit)) { ?><input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/><?php } ?>
						<?php if(isset($kdprogram)) { ?><input type="hidden" name="kdprogram" value="<?php echo $kdprogram;?>"/><?php } ?>
						<input type="submit" name="submit-pk" value="Tampilkan" class="custom" />					
					</form>
					</span>	
				</div><!-- end of filter-option-box -->
				
				</div><!-- end of search-box -->
				<div id="nav-box">
				
				<h2>Grafik Penyerapan Anggaran</h2>
				
				<div class="box-content">
				<table class="chart-line" style="display:none; height:300px;" >
					<caption>Grafik Penyerapan Anggaran</caption>
					<thead>
						<tr>
							<td></td>
							<th scope="col">Jan</th>
							<th scope="col">Feb</th>
							<th scope="col">Mar</th>
							<th scope="col">Apr</th>
							<th scope="col">Mei</th>
							<th scope="col">Jun</th>
							<th scope="col">Jul</th>
							<th scope="col">Agu</th>
							<th scope="col">Sep</th>
							<th scope="col">Okt</th>
							<th scope="col">Nov</th>
							<th scope="col">Des</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th scope="row">Rencana Penarikan Anggaran(Juta)</th>
							<?php for($i=1;$i<=12;$i++):
								($i<10) ? $bulan='0'.$i : $bulan=$i;
								$rpd = get_konsistensi_perbulan('2011',$bulan,$kddept,$kdunit,$kdprogram);
							?>
							<td><?php echo ($rpd) ? pembulatan_juta($rpd->rpd) : '0';?></td>
							<?php endfor;?>
						</tr>
						<tr>
							<th scope="row">Realisasi Anggaran(Juta)</th>
							<?php for($i=1;$i<=12;$i++):
								($i<10) ? $bulan='0'.$i : $bulan=$i;
								$realisasi = get_konsistensi_perbulan('2011',$bulan,$kddept,$kdunit,$kdprogram);
							?>
							<td><?php echo ($realisasi) ? pembulatan_juta($realisasi->realisasi) : '0';?></td>
							<?php endfor;?>
						</tr>
					</tbody>
				</table>
				</div><!-- end of box-content -->
				
				<br/>
				<h2>Grafik Indikator Kerja</h2>
				
				<div class="box-content">
				<table class="chart-bar" style="display:none; height:200px;" >
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
				</div><!-- end of box-content -->
			</div><!-- end of nav-box -->
			
