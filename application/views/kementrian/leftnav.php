		<div id="content-left">
			<a class="navigation-top" href="kementrian" <?php if($this->uri->segment(2) == 'index' || $this->uri->segment(2) == ''):echo 'id="active-main"';endif;?>>Dashboard</a>
			<a class="navigation-title" href="kementrian/kegiatan" <?php if($this->uri->segment(2) == 'kegiatan' || $this->uri->segment(2) == 'revisi'):echo 'id="active-main"';endif;?>>Kegiatan</a>
			<div class="navigation-list">
				<ul>
					<li <?php if($this->uri->segment(2) == 'kegiatan'):echo 'id="active-list"';endif;?>><a href="kementrian/kegiatan"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Semua Kegiatan</a></li>
					<li <?php if($this->uri->segment(2) == 'revisi'):echo 'id="active-list"';endif;?>><a href="kementrian/revisi"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Hasil Perbaikan</a></li>
					<li <?php if($this->uri->segment(2) == 'catatan' || $this->uri->segment(2) == 'history_catatan'):echo 'id="active-list"';endif;?>><a href="kementrian/catatan"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Catatan</a></li>
					<li <?php if($this->uri->segment(2) == 'catatan_eselon'):echo 'id="active-list"';endif;?>><a href="kementrian/catatan_eselon"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Catatan dari Eselon I</a></li>
				</ul>
			</div><!-- end of navigation-list -->
			<a class="navigation-title" <?php echo ($this->uri->segment(2)=='laporan' || $this->uri->segment(2)=='penyerapan' || $this->uri->segment(2)=='konsistensi' || $this->uri->segment(2)=='keluaran' || $this->uri->segment(2)=='efisiensi') ? 'id="active-main"': ''; ?> href="kementrian/laporan">Laporan</a>
			<div class="navigation-list">
				<ul>
					<li <?php if($this->uri->segment(2) == 'penyerapan'):echo 'id="active-list"';endif;?>><a href="kementrian/penyerapan"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Penyerapan Anggaran</a></li>
					<li <?php if($this->uri->segment(2) == 'konsistensi'):echo 'id="active-list"';endif;?>><a href="kementrian/konsistensi"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Konsistensi</a></li>
					<li <?php if($this->uri->segment(2) == 'keluaran'):echo 'id="active-list"';endif;?>><a href="kementrian/keluaran"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Pencapaian Keluaran</a></li>
					<li <?php if($this->uri->segment(2) == 'efisiensi'):echo 'id="active-list"';endif;?>><a href="kementrian/efisiensi"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Efisiensi</a></li>					
					<li <?php if($this->uri->segment(2) == 'capaian_hasil'):echo 'id="active-list"';endif;?>><a href="kementrian/capaian_hasil"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Pencapaian Hasil</a></li>
					<li <?php if($this->uri->segment(2) == 'aspek_evaluasi'):echo 'id="active-list"';endif;?>><a href="kementrian/aspek_evaluasi"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Evaluasi Kerja</a></li>					
				</ul>
			</div><!-- end of navigation-list -->
			<a class="navigation-title" <?php echo ($this->uri->segment(2)=='monitoring' || $this->uri->segment(2)=='mpenyerapan' || $this->uri->segment(2)=='mkonsistensi' || $this->uri->segment(2)=='mkeluaran' || $this->uri->segment(2)=='mefisiensi') ? 'id="active-main"': ''; ?> href="kementrian/monitoring"> Monitoring</a>
			<div id="navigation-list">
				<ul>
					<li <?php if($this->uri->segment(2) == 'mpenyerapan'):echo 'id="active-list"';endif;?>><a href="kementrian/mpenyerapan"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Penyerapan Anggaran</a></li>
					<li <?php if($this->uri->segment(2) == 'mkonsistensi'):echo 'id="active-list"';endif;?>><a href="kementrian/mkonsistensi"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Konsistensi</a></li>
					<li <?php if($this->uri->segment(2) == 'mkeluaran'):echo 'id="active-list"';endif;?>><a href="kementrian/mkeluaran"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Pencapaian Keluaran</a></li>
					<li <?php if($this->uri->segment(2) == 'mevaluasi'):echo 'id="active-list"';endif;?>><a href="kementrian/mevaluasi"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Evaluasi Kerja</a></li>
				</ul>
			</div><!-- end of navigation-list -->		

		</div><!-- end of content-left -->	