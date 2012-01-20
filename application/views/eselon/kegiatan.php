			<h1><?php echo (isset($nmprogram))? $nmprogram: 'Tidak Ada Kegiatan';?></h1>
			<div id="search-box">
				<div id="search">
					<img src="<?php echo ASSETS_DIR_IMG.'magnifier.png'?>"/>
					<input type="text"/>
				</div>
			</div>
			<div id="nav-box">
				<?php 
				$count = 0;
				if(isset($kegiatan)):
				$count = count($kegiatan);
				?>
				<p id="total">Total ada <?php echo $count;?> kegiatan</p>
				<div class="clearfix"></div>
				
				<div id="box-title">
					<div class="column1">Daftar Kegiatan</div>
					<div class="clearfix"></div>
				</div>
				
				<?php foreach($kegiatan as $row):?>
				<a class="choice" href="eselon/detail_giat/<?php echo $row['kdgiat'];?>"><div class="box-content box-end">
					<div class="box-content-left">
					<h3><?php echo $row['nmgiat']?></h3>					
					<br/>
					<p>Terakhir diinput oleh Satker <?php echo $row['kdsatker'] .' -- '. $row['nmsatker'] ?> pada tanggal <?php echo $row['accsatker_date'];?></p>
					</div><!-- end of box-content-left -->
					
					<div class="box-content-right">
					<table>
						<tr>
							<td class="mark"></td>
						</tr>
					</table>
					</div><!-- end of box-content-right -->
					
					<div class="clearfix"></div>
				</div><!-- end of box-content -->
				</a>
				<?php endforeach;?>
				<?php else:?>
				<span class="custom-button-span"><p id="total">Total ada <?php echo $count;?> kegiatan</p></span>
				<div class="clearfix"></div>
				<div class="box-content box-report">
					<p class="alert-message block-message error">Tidak ada data</p>
				</div>
				<?php endif;?>
				<div class="clearfix"></div>
			</div><!-- end of nav-box -->