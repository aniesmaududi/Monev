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
				<form name="form-outcome" action="<?php echo base_url();?>satker/output" method="POST">					
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
				<?php
				if($kdprogram != 0){
				?>
				Kegiatan
				<form name="form-outcome" action="<?php echo base_url();?>satker/output" method="POST">
					<input type="hidden" name="program" value="<?php echo $kdprogram;?>"/>
					<select name="kegiatan" onchange="this.form.submit();" style="width:650px;">
						<option value="0" selected="selected">Pilih Kegiatan</option>
					<?php
					foreach ($kegiatan as $kegiatan_item):
						if($kdgiat == $kegiatan_item['kdgiat']){ $selected = 'selected';} else { $selected = "";}
					?>
						<option value="<?php echo $kegiatan_item['kdgiat'];?>" <?php echo $selected;?>>
						<?php echo $kegiatan_item['nmgiat'];?>
						</option>				
					<?php endforeach ?>
					</select>					
				</form>
				<?php } ?>
			</div>
			<div id="nav-box">
			<?php if($kdprogram != 0 && $kdgiat != 0){ ?>
				<?php echo form_open('satker/do_real_output');?>				
				<p id="total"><img src="<?php echo ASSETS_DIR_IMG.'notdone.png';?>" class="notify"/>Daftar Output yang harus diisikan nilai realisasinya.</p>
				<input type="submit" name="submit" value="Simpan" class="blackbg"/>
				<input type="submit" name="submit" value="Proses" id="incomplete" class="blackbg"/>
				<div class="clearfix"></div>
				
				<input type="hidden" name="kddept" value="<?php echo $kddept;?>"/>
				<input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/>
				<input type="hidden" name="kdsatker" value="<?php echo $kdsatker;?>"/>
				<input type="hidden" name="kdprogram" value="<?php echo $kdprogram;?>"/>				
				<input type="hidden" name="kdgiat" value="<?php echo $kdgiat;?>"/>
				
				<div id="box-title">
					<div class="column1">Output</div>
					<div class="column2 borderright borderleft">Target</div>
					<div class="column3 borderright">Realisasi</div>
					<div class="column4">Status</div>
					<div class="clearfix"></div>
				</div><!-- end of box-title -->
				<?php				
				$i = 1;
				$notif = "";
				foreach($output as $output_item):
				?>
				<div class="box-content">					
					<div class="column1">
						<input type="hidden" class="realisasi" name="kdoutput_<?php echo $i;?>" value="<?php echo $output_item['kdoutput'];?>"/>
						<?php echo $output_item['nmoutput'];?>
					</div>
					<div class="column2">
						<input type="hidden" class="realisasi" name="tvk_<?php echo $i;?>" value="<?php echo $output_item['vol'];?>"/>
						<?php echo $output_item['vol'].' '.$output_item['sat'];?>
					</div>
					<div class="column3">
						<?php
						if($output_item['accsatker'] == 1 && $output_item['accunit'] == 1){
							if(isset($output_item['rvk'])) echo $output_item['rvk'].' '.$output_item['sat'];
						}
						else
						{
						?>
						<input type="hidden" class="realisasi" name="sat_<?php echo $i;?>" value="<?php if(isset($output_item['sat'])) echo $output_item['sat'];?>"/>
						<input type="text" class="realisasi" name="rvk_<?php echo $i;?>" value="<?php if(isset($output_item['rvk'])) echo $output_item['rvk'];?>"/> <?php echo $output_item['sat'];?>
						<?php } ?>
					</div>
					<div class="column4" style="padding:0;margin:0;width:120px;">
						<?php
						if($output_item['accsatker'] == 1 && $output_item['accunit'] == 0){
						  echo '<img src="'.ASSETS_DIR_IMG.'done.png"> <br>
						<p style="font-size:9px;">[Dalam proses : Eselon I]</p>';	
						}
						
						elseif($output_item['accsatker'] == 1 && $output_item['accunit'] == 1 && $output_item['accdept'] == 0)
						{ echo '<img src="'.ASSETS_DIR_IMG.'done.png"> <br>
						<p style="font-size:9px;">[Dalam proses : K/L]</p>'; }
						
						elseif($output_item['accsatker'] == 1 && $output_item['accunit'] == 1 && $output_item['accdept'] == 1)
						{ echo '<img src="'.ASSETS_DIR_IMG.'done.png"> <br>
						<p style="font-size:9px;">[FINAL]</p>'; }
						
						else
						{
							if($output_item['accsatker_date'] == "0")
							{ $notif = "Isi Realisasi";}
							elseif($output_item['accunit_date'] != "0000-00-00 00:00:00" && $output_item['accdept_date'] != "0000-00-00 00:00:00")
							{ $notif = "Dikembalikan oleh K/L"; }
							elseif($output_item['accunit_date'] != "0000-00-00 00:00:00" && $output_item['accdept_date'] == "0000-00-00 00:00:00")
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
				</form>
			<?php } ?>
			</div>