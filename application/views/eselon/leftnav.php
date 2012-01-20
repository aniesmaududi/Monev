		<!-- leftnav belongs to eselon -->
		<div id="content-left">
			<a class="navigation-top" href="eselon" <?php if($this->uri->segment(2) == 'index' || $this->uri->segment(2) == ''):echo 'id="active-main"';endif;?>>Dashboard</a>
			<a class="navigation-title" href="eselon/iku" style="border-bottom:none;" <?php if($this->uri->segment(2) == 'iku'):echo 'id="active-main"';endif;?>>Indeks Kerja Utama</a>
			<a class="navigation-title" href="eselon/kegiatan" <?php if($this->uri->segment(2) == 'kegiatan' || $this->uri->segment(2) == 'revisi'):echo 'id="active-main"';endif;?>>Kegiatan</a>
			<div class="navigation-list">
				<ul>
					<li <?php if($this->uri->segment(2) == 'kegiatan'):echo 'id="active-list"';endif;?>><a href="eselon/kegiatan"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Semua Kegiatan</a></li>
					<li <?php if($this->uri->segment(2) == 'revisi'):echo 'id="active-list"';endif;?>><a href="eselon/revisi"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Hasil Perbaikan</a></li>
				</ul>
			</div><!-- end of navigation-list -->
			<a class="navigation-title" <?php echo ($this->uri->segment(2)=='laporan' || $this->uri->segment(2)=='penyerapan' || $this->uri->segment(2)=='konsistensi' || $this->uri->segment(2)=='keluaran' || $this->uri->segment(2)=='efisiensi') ? 'id="active-main"': ''; ?> href="eselon-laporan.html">Laporan</a>
			<div class="navigation-list">
				<ul>
					<li <?php if($this->uri->segment(2) == 'penyerapan'):echo 'id="active-list"';endif;?>><a href="eselon/penyerapan"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Penyerapan Anggaran</a></li>
					<li <?php if($this->uri->segment(2) == 'konsistensi'):echo 'id="active-list"';endif;?>><a href="eselon/konsistensi"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Konsistensi</a></li>
					<li <?php if($this->uri->segment(2) == 'keluaran'):echo 'id="active-list"';endif;?>><a href="eselon/keluaran"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Pencapaian Keluaran</a></li>
					<li <?php if($this->uri->segment(2) == 'efisiensi'):echo 'id="active-list"';endif;?>><a href="eselon/efisiensi"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Efisiensi</a></li>
					<!--
					<li><a href="eselon-hasil.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Pencapaian Hasil</a></li>
					<li><a href="eselon-evaluasi.html"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Evaluasi Kerja</a></li>
					-->
				</ul>
			</div><!-- end of navigation-list -->
			<a class="navigation-title" <?php echo ($this->uri->segment(2)=='monitoring' || $this->uri->segment(2)=='mpenyerapan' || $this->uri->segment(2)=='mkonsistensi' || $this->uri->segment(2)=='mkeluaran' || $this->uri->segment(2)=='mefisiensi') ? 'id="active-main"': ''; ?> href="eselon-monitoring.html">Monitoring</a>
			<div id="navigation-list">
				<ul>
					<li <?php if($this->uri->segment(2) == 'mpenyerapan'):echo 'id="active-list"';endif;?>><a href="eselon/mpenyerapan"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Penyerapan Anggaran</a></li>
					<li <?php if($this->uri->segment(2) == 'mkonsistensi'):echo 'id="active-list"';endif;?>><a href="eselon/mkonsistensi"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Konsistensi</a></li>
					<li <?php if($this->uri->segment(2) == 'mkeluaran'):echo 'id="active-list"';endif;?>><a href="eselon/mkeluaran"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Pencapaian Keluaran</a></li>
					<li <?php if($this->uri->segment(2) == 'mevaluasi'):echo 'id="active-list"';endif;?>><a href="eselon/mevaluasi"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Evaluasi Kerja</a></li>
				</ul>
			</div><!-- end of navigation-list -->

			
		</div><!-- end of content-left -->