			<h1><?php echo $title;?></h1>			        
			<div id="search-box">
				<form name="form1" action="<?php echo base_url();?>dja/efisiensi_table" method="POST">					
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
				<form name="form2" action="<?php echo base_url();?>dja/efisiensi_table" method="POST">
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
				<form name="form3" action="<?php echo base_url();?>dja/efisiensi_table" method="POST">
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
				<form name="form4" action="<?php echo base_url();?>dja/efisiensi_table" method="POST">
					<?php if(isset($kddept)) { ?><input type="hidden" name="kddept" value="<?php echo $kddept;?>"/><?php } ?>
					<?php if(isset($kdunit)) { ?><input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/><?php } ?>
					<?php if(isset($kdprogram)) { ?><input type="hidden" name="kdprogram" value="<?php echo $kdprogram;?>"/><?php } ?>
					<input type="submit" name="submit-e" value="Tampilkan"/>					
				</form>
			</div>
			<div>
				<?php
				if(isset($submitE))
				{
				?>
				<table style="border:1px solid #bebebe;" width="100%" border=1 cellpadding="2" cellspacing="0">
					<thead>
						<th>Keluaran</th>
						<th>Target</th>
						<th>Realisasi</th>
						<th>Pagu Anggaran</th>
						<th>Realisasi Anggaran</th>
						<th>Efisiensi</th>
					</thead>
					<tbody>
				<?php
				if(count($output) > 0)
				{
				$total_ek = 0;
				foreach($output as $output_item):
				?>					
					<tr style="font-size:11px;">					
						<td>
							<?php echo $output_item['nmoutput'];?>
						</td>
						<td>
							<?php
							$TVK = $output_item['tvk'];
							echo $TVK.' '.$output_item['sat'];
							?>
						</td>
						<td>
							<?php
							$RVK = $output_item['rvk'];
							echo $RVK.' '.$output_item['sat'];
							?>
						</td>
						<td align="right">
							<?php
							$pagu = $this->mdja->get_pagu_anggaran_keluaran($output_item['kddept'], $output_item['kdunit'], $output_item['kdsatker'], $output_item['kdprogram'], $output_item['kdgiat'], $output_item['kdoutput']);
							$PAK = $pagu['pagu'];
							echo $PAK;
							?>
						</td>
						<td align="right">
							<?php
							$realisasi = $this->mdja->get_realisasi_anggaran_keluaran($output_item['kddept'], $output_item['kdunit'], $output_item['kdsatker'], $output_item['kdprogram'], $output_item['kdgiat'], $output_item['kdoutput']);
							$RAK = $realisasi['total'];
							echo $RAK;
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
				<?php
				$total_ek += $ek;
				endforeach;
				}
				?>
					</tbody>
				</table>
				<div class="box-content" style="background:#333;color:#fff;">					
					<div class="column1">
						Efisiensi
					</div>					
					<div class="column4">
						<?php						
						if(count($output) > 0){
						$E = round($total_ek/$n,2);
						echo $E;
						}
						else
						{
						echo 0;	
						}
						?>
						%
					</div>
					<div class="clearfix"></div>				
				</div><!-- end of box-content -->
				<?php } ?>
			</div>