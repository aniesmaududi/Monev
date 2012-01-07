			<table>			
			<tr>
				<td valign="top">Kementrian / Lembaga</td>
				<td valign="top"> : </td>
				<td><?php echo $nmdept;?></td>
			</tr>
			</table>		
			<div id="search-box">
				Eselon I yang telah mengesahkan outcome
			</div>
			<div id="nav-box">
				<div id="box-title">
					<div class="column1" style="width:500px;"></div>
					<div class="clearfix"></div>
				</div>
				<?php
                                foreach ($unit as $unit_item):
                                ?>
				<div class="box-content">
					<div class="box-content-left">
					<h3 style="width:450px;"><?php echo $unit_item['nmunit'];?></h3>					
					<br/>
					</div><!-- end of box-content-left -->

					<div class="box-content-right">
					<table>
						<tr>
							<td class="button">
							<form name="unit-outcome" method="POST" action="<?php echo base_url();?>kementrian/outcome">
								<input type="hidden" name="kddept" value="<?php echo $unit_item['kddept'];?>"/>
								<input type="hidden" name="kdunit" value="<?php echo $unit_item['kdunit'];?>"/>
								<input type="submit" value="Lihat Outcome"/>
							</td>
							<td class="mark"><!--<img src="http://localhost/monev/assets/img/new.png" class="round-mark"/>--></td>
						</tr>
					</table>
					</div><!-- end of box-content-right -->
					
					<div class="clearfix"></div>
				</div><!-- end of box-content -->
				<?php endforeach ?>
			</div>