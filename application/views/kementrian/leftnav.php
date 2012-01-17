		<!-- leftnav belongs to DJA -->
		<div id="content-left">
			<a class="navigation-top" href="dja/index" <?php if($this->uri->segment(2) == 'index' || $this->uri->segment(2) == ''):echo 'id="active-main"';endif;?>>Dashboard</a>
			<a class="navigation-title" href="satker/laporan">Laporan</a>
			<div class="navigation-list">
				<ul>
					<li <?php if($this->uri->segment(2) == 'penyerapan_table'):echo 'id="active-list"';endif;?>><a href="dja/penyerapan_table"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Penyerapan Anggaran</a></li>
					<li <?php if($this->uri->segment(2) == 'konsistensi_table'):echo 'id="active-list"';endif;?>><a href="dja/konsistensi_table"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Ketepatan Waktu</a></li>
					<li <?php if($this->uri->segment(2) == 'keluaran_table'):echo 'id="active-list"';endif;?>><a href="dja/keluaran_table"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Pencapaian Keluaran</a></li>
					<li <?php if($this->uri->segment(2) == 'efisiensi_table'):echo 'id="active-list"';endif;?>><a href="dja/efisiensi_table"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Efisiensi</a></li>
					<li <?php if($this->uri->segment(2) == 'capaian_hasil'):echo 'id="active-list"';endif;?>><a href="dja/capaian_hasil"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Pencapaian Hasil</a></li>
					<li <?php if($this->uri->segment(2) == 'aspek_evaluasi'):echo 'id="active-list"';endif;?>><a href="dja/aspek_evaluasi"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Evaluasi Kerja</a></li>
				</ul>
			</div><!-- end of navigation-list -->
			<a class="navigation-title" href="satker-monitoring.html"> Monitoring</a>
			<div id="navigation-list">
				<ul>
					<li><a href="satker-mpenyerapan.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Penyerapan Anggaran</a></li>
					<li><a href="satker-mketepatan.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Ketepatan Waktu</a></li>
					<li><a href="satker-mkeluaran.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Pencapaian Keluaran</a></li>
					<li><a href="satker-mevaluasi.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Evaluasi Kerja</a></li>
				</ul>
			</div><!-- end of navigation-list -->		

			
		</div><!-- end of content-left -->	