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
			<tr>
				<td valign="top">Program</td>
				<td valign="top"> : </td>
				<td><?php echo strtoupper($program);?></td>
			</tr>
			<tr>
				<td valign="top">Kegiatan</td>
				<td valign="top"> : </td>
				<td><?php echo strtoupper($kegiatan);?></td>
			</tr>
			</table>
			<h1></h1>
			<div id="search-box">
				<p>Terakhir kali diakses: Muhammad Nur Hidayat, 15 Agustus 2011, 17:24:00.</p>
			</div>
			<div id="nav-box">
			<?php echo form_open('satker/do_realisasi');?>				
				<p id="total"><img src="<?php echo ASSETS_DIR_IMG.'notdone.png';?>" class="notify"/>4 kolom masih bermasalah, silahkan diperbaiki.</p>
				<input type="submit" name="submit" value="Simpan" class="blackbg"/>
				<input type="submit" name="submit" value="Eskalasi" id="incomplete" class="blackbg"/>
				<div class="clearfix"></div>
				
				<input type="hidden" name="kddept" value="<?php echo $kddept;?>"/>
				<input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/>
				<input type="hidden" name="kdsatker" value="<?php echo $kdsatker;?>"/>
				<input type="hidden" name="kdprogram" value="<?php echo $kdprogram;?>"/>
				<input type="hidden" name="kdgiat" value="<?php echo $kdgiat;?>"/>
				
				<div id="box-title">
					<div class="column1">Keluaran</div>
					<div class="column2 borderright borderleft">Target</div>
					<div class="column3 borderright">Realisasi</div>					
					<div class="clearfix"></div>
				</div><!-- end of box-title -->
				<?php
				$i = 1;
				foreach($output as $output_item):
				?>
				<div class="box-content">					
					<div class="column1">
						<input type="hidden" class="realisasi" name="kdoutput_<?php echo $i;?>" value="<?php echo $output_item['kdoutput'];?>"/>
						<?php echo $output_item['nmoutput'];?>
					</div>
					<div class="column2">
						<input type="hidden" class="realisasi" name="tvk_<?php echo $i;?>" value="<?php echo $output_item['vol'];?>"/>
						<?php echo $output_item['vol'];?>
					</div>
					<div class="column3">
						<input type="text" class="realisasi" name="rvk_<?php echo $i;?>"/>
					</div>	
					<div class="clearfix"></div>
				</div><!-- end of box-content -->
				<?php
				$i++;
				endforeach;
				$n = $i-1;
				?>
				<input type="hidden" class="realisasi" name="n" value="<?php echo $n;?>"/>
				<!--
				<div class="box-yellow">
					<div class="column1">Keluaran 1 (Program)</div>
					<div class="column2">15.000.000.000</div>
					<div class="column3">
						<input type="text" class="realisasi" value=""/>
						<div class="error">realisasi belum terisi</div>
					</div>					
					<div class="clearfix"></div>
				</div>
				-->
			</form>
			</div>
			
		</div><!-- end of content-right -->
		
		<div class="clearfix"></div>
		
		</div><!-- end of content -->
		
		</div><!-- end of container -->
	</body>
	
</html>