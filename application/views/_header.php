		<img src="<?php echo ASSETS_DIR_IMG.'title.png'?>" id="logo"/>
		<div id="user"><?php echo $this->session->userdata('nama');?></div>
		<div id="position">SATKER</div>
		<?php echo anchor('user/logout','Logout','class="custom floatright"');?>
		