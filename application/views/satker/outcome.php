			<table>
			<tr>
				<td valign="top">Satuan Kerja</td>
				<td valign="top"> : </td>
				<td width="500"><?php echo $nmsatker;?></td>
			</tr>			
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
				<form name="form-outcome" action="<?php echo base_url();?>satker/outcome" method="POST">					
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
				<?php echo form_open('satker/do_real_outcome');?>				
				<p id="total"><img src="<?php echo ASSETS_DIR_IMG.'notdone.png';?>" class="notify"/>Daftar IKU yang harus diisikan nilai realisasinya.</p>
				<input type="submit" name="submit" value="Simpan" class="blackbg"/>
				<input type="submit" name="submit" value="Proses" id="incomplete" class="blackbg"/>
				<div class="clearfix"></div>
				
				<input type="hidden" name="kddept" value="<?php echo $kddept;?>"/>
				<input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/>
				<input type="hidden" name="kdsatker" value="<?php echo $kdsatker;?>"/>
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
					<div class="column1">
						<input type="hidden" class="realisasi" name="kdiku_<?php echo $i;?>" value="<?php echo $outcome_item['kdiku'];?>"/>
						<?php echo $outcome_item['nmiku'];?>
					</div>
					<div class="column2">
						<input type="hidden" class="realisasi" name="tku_<?php echo $i;?>" value="10"/>
						<?php echo "10%"; ?>
					</div>
					<div class="column3">
						<?php
						if($outcome_item['accsatker'] == 1 && $outcome_item['accunit'] == 1){
							if(isset($outcome_item['rku'])) echo $outcome_item['rku'].' '.$outcome_item['sat'];
						}
						else
						{
						?>
						<input type="text" class="realisasi" name="rku_<?php echo $i;?>" value="<?php if(isset($outcome_item['rku'])) { echo $outcome_item['rku'];} ?>"/>
						<input type="text" class="realisasi"
						       onfocus="if(this.value == 'satuan') { this.value = ''; }"
						       onblur="javascript:this.value == '' ? this.value = 'satuan' : '' "
						       name="sat_<?php echo $i;?>"
							value="<?php if(isset($outcome_item['sat'])) { echo $outcome_item['sat'];} else { echo "satuan"; } ?>"/>
						<?php } ?>
					</div>
					<div class="column4" style="padding:0;margin:0;width:120px;">
						<?php
						if($outcome_item['accsatker'] == 1 && $outcome_item['accunit'] == 0){
						  echo '<img src="'.ASSETS_DIR_IMG.'done.png"> <br>
						<p style="font-size:9px;">[Dalam proses : Eselon I]</p>';	
						}
						
						elseif($outcome_item['accsatker'] == 1 && $outcome_item['accunit'] == 1 && $outcome_item['accdept'] == 0)
						{ echo '<img src="'.ASSETS_DIR_IMG.'done.png"> <br>
						<p style="font-size:9px;">[Dalam proses : K/L]</p>'; }
						
						elseif($outcome_item['accsatker'] == 1 && $outcome_item['accunit'] == 1 && $outcome_item['accdept'] == 1)
						{ echo '<img src="'.ASSETS_DIR_IMG.'done.png"> <br>
						<p style="font-size:9px;">[Telah dieskalasi ke DJA]</p>'; }
						
						else
						{
							if($outcome_item['accsatker'] == "0" && ($outcome_item['accsatker_date'] == "0" || $outcome_item['accsatker_date'] == "0000-00-00 00:00:00"))
							{ $notif = "Isi Realisasi";}
							elseif($outcome_item['accunit_date'] != "0000-00-00 00:00:00" && $outcome_item['accdept_date'] != "0000-00-00 00:00:00")
							{ $notif = "Dikembalikan oleh K/L"; }
							elseif($outcome_item['accunit_date'] != "0000-00-00 00:00:00" && $outcome_item['accdept_date'] == "0000-00-00 00:00:00")
							{ $notif = "Dikembalikan oleh Eselon I"; }							
							
							echo '<img src="'.ASSETS_DIR_IMG.'notdone.png"><br>
							<p style="font-size:9px;">'.$notif.'</p>';
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