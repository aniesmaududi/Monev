			<h1><?php echo $title;?></h1>
			<div id="search-box" style="min-height:400px;">				
					<form action="" class="backend-form" method="post">
						<h4><span>Data Pengguna</span></h4>
						<div class="clearfix">
							<label for="userid">Username</label>
							<input type="text" id="userid" name="userid" value="<?php ///echo $user->userid;?>">
						</div>
						<div class="clearfix">
							<label for="nama">Nama</label>
							<input type="text" id="nama" name="nama" value="<?php //echo $user->nama;?>">
						</div>
						<div class="clearfix">
							<label for="jabid">Jabatan</label>
							
						</div>
						<br><br>
						<h4><span>Ubah Password</span></h4>
						<div class="clearfix">
							<label for="passwd">Password Baru</label>
							<input type="password" id="passwd" name="passwd">
						</div>
						<div class="clearfix">
							<label for="passwd2">Ulangi Password Baru</label>
							<input type="password" id="passwd2" name="passwd2">
						</div>
						<div class="clearfix">
							<label>&nbsp;</label>
							<input type="hidden" name="id" value="<?php //echo $user->id;?>">
							<input type="submit" value="Simpan" class="btn primary"> atau <?php echo anchor('backend/user','Kembali')?>
						</div>
					</form>
			</div>
			<div id="nav-box">
			</div>