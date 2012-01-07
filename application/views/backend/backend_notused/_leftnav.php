		<div id="content-left">
			<div id="navigation-title">Navigasi</div>
			<div id="navigation-list">
				<ul>
					<li><a href="<?php echo site_url('backend/user')?>"><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Data Pengguna</a></li>
					<li><a href=""><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Manajemen Akses</a></li>
						<ul>
								<li><a href="#">Bappenas</a></li>
								<li><a href="<?php echo site_url('backend/akses_kl')?>">K/L</a></li>
								<li><a href="#">Intern DJA</a></li>
						</ul>
					<li><a href=""><img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/> Manajemen User</a></li>
						<ul>
								<li><a href="<?php echo site_url('backend/user_bappenas')?>">Bappenas</a></li>
								<li><a href="#">K/L</a></li>
								<li><a href="<?php echo site_url('backend/user_dja')?>">Intern DJA</a></li>
						</ul>
                    <li><a href="<?php echo site_url('backend/monitoring_upload')?>">Monitor</a></li>
                    <li><a href="<?php echo site_url('backend/sms/inbox')?>">SMS Masuk</a></li>
                    <li><a href="<?php echo site_url('backend/sms/outbox')?>">SMS Keluar</a></li>
                    <li><a href="<?php echo site_url('backend/jadwal')?>">Jadwal User</a></li>
                    <li><a href="<?php echo site_url('backend/audit')?>">Audit Trail</a></li>
                    <li><a href="<?php echo site_url('backend/ref')?>">Pemeliharaan Referensi</a></li>
				</ul>
			</div><!-- end of navigation-list -->
		</div><!-- end of content-left -->