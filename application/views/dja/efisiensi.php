			<h1><?php echo $title;?></h1>
			<table>
				<tr>
					<td>Program</td>
					<td>:</td>
					<td><?php echo $program;?></td>
				</tr>
				<tr>
					<td>Unit / Eselon I</td>
					<td>:</td>
					<td><?php echo $unit;?></td>
				</tr>
				<tr>
					<td>Kementrian / Lembaga</td>
					<td>:</td>
					<td><?php echo $dept;?></td>
				</tr>
			</table>                        
			<div id="search-box">
				<!--<p>20 laporan masih bermasalah</p>-->
				<div id="search">
					<img src="<?php echo ASSETS_DIR_IMG.'magnifier.png'?>"/>
					<input type="text"/>
				</div>
			</div>
			<div>
			<?php echo form_open('');?>					
				<!--<input type="hidden" name="kddept" value="<?php echo $kddept;?>"/>
				<input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/>
				<input type="hidden" name="kdprogram" value="<?php echo $kdprogram;?>"/>
				-->
				<table style="border:1px solid #bebebe;" border=1 cellpadding="2" cellspacing="0">
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
				endforeach
				?>
					</tbody>
				</table>
				<div class="box-content" style="background:#333;color:#fff;">					
					<div class="column1">
						Efisiensi
					</div>					
					<div class="column4">
						<?php						
						$E = round($total_ek/$n,2);
						echo $E; ?>
						%
					</div>
					<div class="clearfix"></div>				
				</div><!-- end of box-content -->
			</form>
			</div>