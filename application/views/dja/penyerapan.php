			<h1><?php echo $title;?></h1>			
			<div id="search-box">				
				<form name="form1" action="<?php echo base_url();?>dja/penyerapan_table" method="POST">					
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
				<form name="form2" action="<?php echo base_url();?>dja/penyerapan_table" method="POST">
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
				<form name="form3" action="<?php echo base_url();?>dja/penyerapan_table" method="POST">
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
				<form name="form4" action="<?php echo base_url();?>dja/penyerapan_table" method="POST">
					<?php if(isset($kddept)) { ?><input type="hidden" name="kddept" value="<?php echo $kddept;?>"/><?php } ?>
					<?php if(isset($kdunit)) { ?><input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/><?php } ?>
					<?php if(isset($kdprogram)) { ?><input type="hidden" name="kdprogram" value="<?php echo $kdprogram;?>"/><?php } ?>
					<input type="submit" name="submit-p" value="Kirim"/>					
				</form>
			</div>
			<div id="nav-box">								
				<?php if(isset($submitK)){ ?>
				
				<div id="box-title">
					<div class="column1">Program</div>
					<div class="column2 borderright borderleft">Pagu Anggaran</div>
					<div class="column3 borderright">Realisasi Anggaran</div>
					<div class="column4">Persentase</div>
					<div class="clearfix"></div>
				</div><!-- end of box-title -->
				<div class="box-content">					
					<div class="column1">
						<?php if(isset($nmprogram)) { echo $nmprogram; } else { echo 'Semua Program';}?>
					</div>
					<div class="column2">
						<?php if(empty($total_pagu)) { $total_pagu = 0; } ?>
						<input type="hidden" class="realisasi" name="pagu" value="<?php echo $total_pagu;?>"/>
						Rp. <?php echo $this->mdja->formatMoney($total_pagu);?>
					</div>
					<div class="column3">
						<?php if(empty($total_realisasi)) { $total_realisasi = 0; } ?>
						<input type="hidden" class="realisasi" name="realisasi" value=""/>
						Rp. <?php echo $this->mdja->formatMoney($total_realisasi);?>
					</div>
					<div class="column4">
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
					</div>
					<?php echo $graph_P;?>
					<div class="clearfix"></div>
				</div><!-- end of box-content -->
				<?php } ?>
			</div>