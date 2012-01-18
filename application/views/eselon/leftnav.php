		<!-- leftnav belongs to eselon -->
		<div id="content-left">
			<a class="navigation-top" href="eselon-dashboard.html" <?php if($this->uri->segment(2) == 'index'):echo 'id="active-main"';endif;?>>Dashboard</a>
			<a class="navigation-title" href="eselon-iku.html" style="border-bottom:none;">Indeks Kerja Utama</a>
			<a class="navigation-title" href="eselon-kegiatan.html">Kegiatan</a>
			<div class="navigation-list">
				<ul>
					<li><a href="eselon-kegiatan.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Semua Kegiatan</a></li>
					<li><a href="eselon-revisi.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Hasil Perbaikan</a></li>
				</ul>
			</div><!-- end of navigation-list -->
			<a class="navigation-title" href="eselon-laporan.html">Laporan</a>
			<div class="navigation-list">
				<ul>
					<li><a href="eselon-penyerapan.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Penyerapan Anggaran</a></li>
					<li><a href="eselon-ketepatan.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Konsistensi</a></li>
					<li><a href="eselon-keluaran.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Pencapaian Keluaran</a></li>
					<li><a href="eselon-efisiensi.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Efisiensi</a></li>
					<li><a href="eselon-hasil.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Pencapaian Hasil</a></li>
					<li><a href="eselon-evaluasi.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Evaluasi Kerja</a></li>
				</ul>
			</div><!-- end of navigation-list -->
			<a class="navigation-title" href="eselon-monitoring.html">Monitoring</a>
			<div id="navigation-list">
				<ul>
					<li><a href="eselon-mpenyerapan.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Penyerapan Anggaran</a></li>
					<li><a href="eselon-mketepatan.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Ketepatan Waktu</a></li>
					<li><a href="eselon-mkeluaran.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Pencapaian Keluaran</a></li>
					<li><a href="eselon-mevaluasi.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Evaluasi Kerja</a></li>
				</ul>
			</div><!-- end of navigation-list -->

			
		</div><!-- end of content-left -->