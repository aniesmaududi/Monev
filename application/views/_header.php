        <img src="<?php echo ASSETS_DIR_IMG.'title.png'?>" id="logo"/>
		<?php echo anchor('user/logout','Logout','class="custom floatright" id="logout"');?>
		<div id="position"><?php echo $this->session->userdata('jabatan');?></div>
		<div id="user"><?php echo $this->session->userdata('nama');?></div>
		
		
		