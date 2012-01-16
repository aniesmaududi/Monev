
			<h1><?php echo $nmprogram;?></h1>
			<div id="search-box">
				<div id="search">
					<img src="<?php echo ASSETS_DIR_IMG.'magnifier.png'?>"/>
					<input type="text"/>
				</div>
			</div>
			<div id="nav-box">
				<p id="total">Total ada <?php echo count($kegiatan);?> kegiatan</p>
				<div class="clearfix"></div>
				
				<div id="box-title">
					<div class="column1">Daftar Kegiatan</div>
					<div class="clearfix"></div>
				</div>
				
				<?php foreach($kegiatan as $row):?>
				<a class="choice" href="satker/detail_giat/<?php echo $row['kdgiat'];?>"><div class="box-content box-end">
					<div class="box-content-left">
					<h3><?php echo $row['nmgiat']?></h3>
					<p>Kegiatan untuk pelaporan bulan Januari. Tenggat Waktu tanggal 20 Januari 2011</p>
					<br/>
					<p>Terakhir diakses pada tanggal 15 Januari 2011 , 07:23:25</p>
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
				<div class="clearfix"></div>
				
			</div><!-- end of nav-box -->