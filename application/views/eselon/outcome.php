			<table>			
			<tr>
				<td valign="top">Unit / Eselon I </td>
				<td valign="top"> : </td>
				<td><?php echo $nmunit;?></td>
			</tr>
			<tr>
				<td valign="top">Kementrian / Lembaga</td>
				<td valign="top"> : </td>
				<td><?php echo $nmdept;?></td>
			</tr>
			</table>		
			<div id="search-box">
				Program
				<form name="form-outcome" action="<?php echo base_url();?>eselon/outcome" method="POST">					
					<select name="program" onchange="this.form.submit();">
						<option value="0" selected="selected">Pilih Program</option>
					<?php
					foreach ($program as $program_item):
						if($kdprogram == $program_item['kdprogram']){ $selected = 'selected';} else { $selected = "";}
					?>
						<option value="<?php echo $program_item['kdprogram'];?>" <?php echo $selected;?>>
						<?php echo $program_item['nmprogram'];?>
						</option>				
					<?php endforeach ?>
					</select>					
				</form>
			</div>
			<div id="nav-box">
				<?php echo form_open('eselon/do_outcome_approval');?>
				<?php if($kdprogram != 0){ ?>
				<p id="total"><img src="<?php echo ASSETS_DIR_IMG.'notdone.png';?>" class="notify"/>Daftar IKU yang harus disahkan nilai realisasinya.</p>				
				<input type="submit" name="submit" value="Proses" id="incomplete" class="blackbg"/>
				<?php } ?>
				<div class="clearfix"></div>
				
				<input type="hidden" name="kddept" value="<?php echo $kddept;?>"/>
				<input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/>				
				<input type="hidden" name="kdprogram" value="<?php echo $kdprogram;?>"/>				
				
				<div id="box-title">
					<div class="column1">IKU</div>
					<div class="column2 borderright borderleft">Target</div>
					<div class="column3 borderright">Realisasi</div>
					<div class="column4">Status</div>
					<div class="clearfix"></div>
				</div><!-- end of box-title -->
				<?php
				if($kdprogram != 0){
				$i = 1;				
				foreach($outcome as $outcome_item):
				?>
				<div class="box-content">
					<input type="hidden" name="kdsatker_<?php echo $i;?>" value="<?php echo $outcome_item['kdsatker'];?>"/>
					<div class="column1">
						<input type="hidden" class="realisasi" name="kdiku_<?php echo $i;?>" value="<?php echo $outcome_item['kdiku'];?>"/>
						<?php echo $outcome_item['nmiku'];?>
					</div>
					<div class="column2">						
						<?php echo $outcome_item['tku'].' '.$outcome_item['sat'];?>
					</div>
					<div class="column3">
						<?php echo $outcome_item['rku'].' '.$outcome_item['sat'];?>
					</div>
					<div class="column4" style="padding:0;margin:0;width:120px;">
						<?php
						if($outcome_item['accsatker'] == 1 && $outcome_item['accunit'] == 1 && $outcome_item['accdept'] == 0){
						  echo '<img src="'.ASSETS_DIR_IMG.'done.png"> <br>
						<p style="font-size:9px;">[Dalam proses : K/L]</p>';	
							
						} elseif($outcome_item['accsatker'] == 1 && $outcome_item['accunit'] == 1 && $outcome_item['accdept'] == 1){
						  echo '<img src="'.ASSETS_DIR_IMG.'done.png"> <br>
						<p style="font-size:9px;">[Telah dieskalasi ke DJA]</p>';	
						
						} else {
							if($outcome_item['accdept_date'] != "0000-00-00 00:00:00")
							{ echo '<img src="'.ASSETS_DIR_IMG.'notdone.png"><br>
							<p style="font-size:9px;">Dikembalikan oleh K/L</p>'; }
							elseif($outcome_item['accunit_date'] != "0000-00-00 00:00:00" && $outcome_item['accdept_date'] == "0000-00-00 00:00:00")
							{ echo '<img src="'.ASSETS_DIR_IMG.'notdone.png"><br>
							<p style="font-size:9px;">Dikembalikan ke Satker</p>'; }
							else
							{
						?>
							<input type="radio" name="status_<?php echo $i;?>" value="ok"/>Disahkan <br>
							<input type="radio" name="status_<?php echo $i;?>" value="nok" checked/>Tidak disahkan
						<?php
							}
						}
						?>
					</div>
					<div class="clearfix"></div>
				</div><!-- end of box-content -->
				<?php
				$i++;
				endforeach;				
				$n = $i-1;				
				?>
				<input type="hidden" class="realisasi" name="n" value="<?php echo $n;?>"/>
				<?php } ?>
				</form>
			</div>