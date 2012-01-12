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
				<form name="form-outcome" action="<?php echo base_url();?>eselon/ikk" method="POST">					
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
				<form name="form-outcome" action="<?php echo base_url();?>eselon/ikk" method="POST">
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
			<?php if($kdprogram != 0 && $kdgiat != 0){
			echo form_open('eselon/do_ikk_approval');
			?>
				<p id="total"><img src="<?php echo ASSETS_DIR_IMG.'notdone.png';?>" class="notify"/>Daftar hasil IKK untuk Anda setujui/tidak</p>				
				<input type="submit" name="submit" value="Proses" id="incomplete" class="blackbg"/>
				<div class="clearfix"></div>
				
				<input type="hidden" name="kddept" value="<?php echo $kddept;?>"/>
				<input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/>
				<input type="hidden" name="kdsatker" value="<?php echo $kdsatker;?>"/>
				<input type="hidden" name="kdprogram" value="<?php echo $kdprogram;?>"/>
				<input type="hidden" name="kdgiat" value="<?php echo $kdgiat;?>"/>
				
				<div id="box-title">
					<div class="column1">IKK</div>
					<div class="column2 borderright borderleft">Target</div>
					<div class="column3 borderright">Realisasi</div>
					<div class="column4">Status</div>
					<div class="clearfix"></div>
				</div><!-- end of box-title -->
				<?php
				$i = 1;
				foreach($ikk as $item):
				?>
				<div class="box-content">					
					<div class="column1">
						<input type="hidden" class="realisasi" name="kdikk_<?php echo $i;?>" value="<?php echo $item['kdikk'];?>"/>
						<?php echo $item['nmikk'];?>
					</div>
					<div class="column2">						
						<?php echo $item['tkk'].' '.$item['sat'];?>
					</div>
					<div class="column3">
						<?php echo $item['rkk'].' '.$item['sat'];?>
					</div>
					<div class="column4" style="padding:0;margin:0;width:120px;">
						<?php
						if($item['accsatker'] == 1 && $item['accunit'] == 1 && $item['accdept'] == 0){
						  echo '<img src="'.ASSETS_DIR_IMG.'done.png"> <br>
						<p style="font-size:9px;">Dalam proses : K/L</p>';	
							
						} elseif($item['accsatker'] == 1 && $item['accunit'] == 1 && $item['accdept'] == 1){
						  echo '<img src="'.ASSETS_DIR_IMG.'done.png"> <br>
						<p style="font-size:9px;">Telah dieskalasi ke DJA</p>';	
						
						} else {
							if($item['accdept_date'] != "0000-00-00 00:00:00")
							{ echo '<img src="'.ASSETS_DIR_IMG.'notdone.png"><br>
							<p style="font-size:9px;">Dikembalikan oleh K/L</p>'; }
							elseif($item['accunit_date'] != "0000-00-00 00:00:00" && $item['accdept_date'] == "0000-00-00 00:00:00")
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
			</form>
			<?php } ?>
			</div>