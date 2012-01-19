		<div id="content-left">
			<a class="navigation-top" href="dja" <?php if($this->uri->segment(2) == 'index' || $this->uri->segment(2) == ''):echo 'id="active-main"';endif;?>>Dashboard</a>
			<a class="navigation-title" <?php echo ($this->uri->segment(2)=='laporan' || $this->uri->segment(2)=='penyerapan' || $this->uri->segment(2)=='konsistensi' || $this->uri->segment(2)=='keluaran' || $this->uri->segment(2)=='efisiensi') ? 'id="active-main"': ''; ?> href="dja/laporan">Laporan</a>
			<div class="navigation-list">
				<ul>
					<li <?php if($this->uri->segment(2) == 'penyerapan'):echo 'id="active-list"';endif;?>><a href="dja/penyerapan"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Penyerapan Anggaran</a></li>
					<li <?php if($this->uri->segment(2) == 'konsistensi'):echo 'id="active-list"';endif;?>><a href="dja/konsistensi"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Konsistensi</a></li>
					<li <?php if($this->uri->segment(2) == 'keluaran'):echo 'id="active-list"';endif;?>><a href="dja/keluaran"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Pencapaian Keluaran</a></li>
					<li <?php if($this->uri->segment(2) == 'efisiensi'):echo 'id="active-list"';endif;?>><a href="dja/efisiensi"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Efisiensi</a></li>
					<!--
					<li <?php if($this->uri->segment(2) == 'capaian_hasil'):echo 'id="active-list"';endif;?>><a href="dja/capaian_hasil"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Pencapaian Hasil</a></li>
					<li <?php if($this->uri->segment(2) == 'aspek_evaluasi'):echo 'id="active-list"';endif;?>><a href="dja/aspek_evaluasi"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Evaluasi Kerja</a></li>
					-->
				</ul>
			</div><!-- end of navigation-list -->
			<a class="navigation-title" href="dja/monitoring"> Monitoring</a>
			<div id="navigation-list">
				<ul>
					<li><a href="dja/monitor_penyerapan"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Penyerapan Anggaran</a></li>
					<li><a href="dja/monitor_konsistensi"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Konsistensi</a></li>
					<li><a href="dja/monitor_keluaran"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Pencapaian Keluaran</a></li>
					<li><a href="dja/monitor_evaluasi"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Evaluasi Kerja</a></li>
				</ul>
			</div><!-- end of navigation-list -->		

			
		</div><!-- end of content-left -->	