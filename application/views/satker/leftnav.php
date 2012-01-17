		<!-- leftnav belongs to satker -->
		<div id="content-left">
			<a class="navigation-top" href="satker/index" <?php if($this->uri->segment(2) == 'index' || $this->uri->segment(2) == '' ):echo 'id="active-main"';endif;?>>Dashboard</a>
			<a class="navigation-title" href="satker/kegiatan"<?php if($this->uri->segment(2) == 'kegiatan'):echo 'id="active-main"';endif;?>>Kegiatan</a>
			<div class="navigation-list">
				<ul>
					<li 
					<?php if($this->uri->segment(2) == 'kegiatan'):echo 'id="active-list"';endif;?>><a href="satker/kegiatan"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Semua Kegiatan</a></li>
					<li><a href="#"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Perlu Perbaikan</a></li>
				</ul>
			</div><!-- end of navigation-list -->
			<a class="navigation-title" href="satker/laporan"
				<?php if(	$this->uri->segment(2) == 'laporan' || 
							$this->uri->segment(2) == 'penyerapan_table' ||
							$this->uri->segment(2) == 'konsistensi_table' ||
							$this->uri->segment(2) == 'keluaran_table' ||
							$this->uri->segment(2) == 'efisiensi' ||
							$this->uri->segment(2) == 'capaian_hasil' ||
							$this->uri->segment(2) == 'aspek_evaluasi'
						):echo 'id="active-main"';endif;?>>Laporan</a>
			<div class="navigation-list">
				<ul>
					<li <?php if($this->uri->segment(2) == 'penyerapan_table'):echo 'id="active-list"';endif;?>><a href="satker/penyerapan_table"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Penyerapan Anggaran</a></li>
					<li <?php if($this->uri->segment(2) == 'konsistensi_table'):echo 'id="active-list"';endif;?>><a href="satker/konsistensi_table"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Ketepatan Waktu</a></li>
					<li <?php if($this->uri->segment(2) == 'keluaran_table'):echo 'id="active-list"';endif;?>><a href="satker/keluaran_table"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Pencapaian Keluaran</a></li>
					<li <?php if($this->uri->segment(2) == 'efisiensi'):echo 'id="active-list"';endif;?>><a href="satker/efisiensi"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Efisiensi</a></li>
					<li <?php if($this->uri->segment(2) == 'capaian_hasil'):echo 'id="active-list"';endif;?>><a href="satker/capaian_hasil"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Pencapaian Hasil</a></li>
					<li <?php if($this->uri->segment(2) == 'aspek_evaluasi'):echo 'id="active-list"';endif;?>><a href="satker/aspek_evaluasi"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Evaluasi Kerja</a></li>
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
			<a class="navigation-bottom bordertop" href="satker/upload" <?php if($this->uri->segment(2) == 'upload'):echo 'id="active-main"';endif;?>> Unggah Berkas</a>			

			
		</div><!-- end of content-left -->	