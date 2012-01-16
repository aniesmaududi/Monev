			<h1><?php echo $title;?></h1>
			<div id="search-box" style="min-height:400px;">
				<?php if($user):?>
					<form action="" class="backend-form" method="post">
						<h4><span>Data Pengguna</span></h4>
						<div class="clearfix">
							<label for="userid">Username</label>
							<input type="text" id="userid" name="userid" value="<?php echo $user->userid;?>">
						</div>
						<div class="clearfix">
							<label for="nama">Nama</label>
							<input type="text" id="nama" name="nama" value="<?php echo $user->nama;?>">
						</div>
						<div class="clearfix">
							<label for="jabid">Jabatan</label>
							<?php
							$attr = 'id="jabid"';
							$options = array(
								'1' => 'SATKER',
								'2' => 'ESELON',
								'3' => 'KEMENTRIAN/LEMBAGA',
								'4' => 'DJA'
							);
							echo form_dropdown('jabid', $options, $user->jabid, $attr);
							?>
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
							<input type="hidden" name="id" value="<?php echo $user->id;?>">
							<input type="submit" value="Simpan" class="btn primary"> atau <?php echo anchor('backend/user','Kembali')?>
						</div>
					</form>
				<?php else:?>
					no data
				<?php endif;?>
			</div>
			<div id="nav-box">
			</div>