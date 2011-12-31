		<div id="content-left">
			<div id="navigation-title"><!--Eselon XIV-->
			<?php if($this->session->userdata('jabatan')==1)
		echo 'Satker';
		elseif($this->session->userdata('jabatan')==2)
		echo 'Eselon';
		elseif($this->session->userdata('jabatan')==3)
		echo 'K/L';
		elseif($this->session->userdata('jabatan')==4)
		echo 'DJA';
		?></div>
			<div id="navigation-list">
				<ul>
					<li><a href="#"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Semua Laporan</a></li>
<?php if($this->session->userdata('jabatan')==1): ?>
					<li><a href="#"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Belum Terisi (15)</a></li>
					<li><a href="#"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Terisi Lengkap (20)</a></li>
					<li><a href="#"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Perlu Revisi (5)</a></li>
<?php elseif($this->session->userdata('jabatan')==2): ?>
					<li><a href="#"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Baru (10)</a></li>
					<li><a href="#"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Belum Divalidasi (10)</a></li>
					<li><a href="#"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Perlu Revisi (10)</a></li>
					<li><a href="#"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Diagram Kinerja</a></li>
<?php elseif($this->session->userdata('jabatan')==3): ?>
					<li><a href="#"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Baru (10)</a></li>
					<li><a href="#"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Belum Divalidasi (10)</a></li>
					<li><a href="#"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Perlu Revisi (10)</a></li>
					<li><a href="#"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Diagram Kinerja</a></li>
<?php endif;?>
				</ul>
			</div><!-- end of navigation-list -->

		</div><!-- end of content-left -->