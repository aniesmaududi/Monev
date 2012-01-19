		<div id="content-left">
			<a class="navigation-top" href="satker/index" <?php if($this->uri->segment(2) == 'index'):echo 'id="active-main"';endif;?>>Dashboard</a>
			<a class="navigation-title" href="satker/kegiatan"<?php if($this->uri->segment(2) == 'kegiatan'):echo 'id="active-main"';endif;?>>Kegiatan</a>
			<div class="navigation-list">
				<ul>
					<li <?php if($this->uri->segment(2) == 'kegiatan'):echo 'id="active-list"';endif;?>><a href="satker/kegiatan"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Semua Kegiatan</a></li>
					<li><a href="#"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Perlu Perbaikan</a></li>
					<li <?php if($this->uri->segment(2) == 'catatan'):echo 'id="active-list"';endif;?>><a href="satker/catatan"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Catatan</a></li>
				</ul>
			</div><!-- end of navigation-list -->
			<a class="navigation-title" href="satker/laporan">Laporan</a>
			<div class="navigation-list">
				<ul>
					<li><a href="satker/penyerapan"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Penyerapan Anggaran</a></li>
					<li><a href="satker-ketepatan.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Konsistensi</a></li>
					<li><a href="satker-keluaran.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Pencapaian Keluaran</a></li>
					<li><a href="satker/efisien"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Efisiensi</a></li>
					<li><a href="satker-hasil.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Pencapaian Hasil</a></li>
					<li><a href="satker-evaluasi.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Evaluasi Kerja</a></li>
				</ul>
			</div><!-- end of navigation-list -->
			<a class="navigation-title" href="satker-monitoring.html"> Monitoring</a>
			<div class="navigation-list">
				<ul>
					<li><a href="satker-mpenyerapan.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Penyerapan Anggaran</a></li>
					<li><a href="satker-mketepatan.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Ketepatan Waktu</a></li>
					<li><a href="satker-mkeluaran.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Pencapaian Keluaran</a></li>
					<li><a href="satker-mevaluasi.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Evaluasi Kerja</a></li>
				</ul>
			</div><!-- end of navigation-list -->
			<a class="navigation-bottom bordertop" href="satker/upload"> Unggah Berkas</a>			

			
		</div><!-- end of content-left -->	