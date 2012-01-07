			<h1><?php echo $title; ?></h1>
			<div id="search-box" style="min-height:400px;">
				<?php //if($user):?>
					<form action="backend/user_bappenas/simpan" class="backend-form" method="post">
						<h4><span>Data User BAPPENAS</span></h4>
						<?php
							if($this->session->flashdata('message')):
								echo flash_message($this->session->flashdata('message_type'));
							endif;
						?>
						<?php echo validation_errors('<div class="error">', '</div>'); ?>
						<div class="clearfix">
							<label for="username">Username</label>
							<input type="text" id="username" name="username" value="<?php echo set_value('username'); ?>"/>
						</div>
						<div class="clearfix">
							<label for="nama">Nama</label>
							<input type="text" id="nama" name="nama" value="<?php echo set_value('nama'); ?>"/>
						</div>
						<div class="clearfix">
							<label for="password">Password User</label>
							<input type="password" id="password" name="password" value=""/>
						</div>
						<div class="clearfix">
							<label for="konf_password">Konfirmasi Password</label>
							<input type="password" id="konf_password" name="konf_password" value=""/>
						</div>
						<div class="clearfix">
							<label for="nip">NIP</label>
							<input type="text" id="nip" name="nip" value="<?php echo set_value('nip'); ?>"/>
						</div>
						<div class="clearfix">
							<label for="email">Email</label>
							<input type="text" id="email" name="email" value="<?php echo set_value('email'); ?>"/>
						</div>
						<div class="clearfix">
							<label>&nbsp;</label>
							<input type="submit" value="Simpan" class="btn primary"> atau <?php echo anchor('backend','Kembali')?>
						</div>
					</form>
				<?php //else:?>
				<?php //endif;?>
			</div>
			<div id="nav-box"></div>