		<img src="<?php echo ASSETS_DIR_IMG.'title.png'?>" id="logo"/>
		
		<a href="<?php echo site_url('backend/logout');?>" class="custom floatright" id="logout">Logout</a>
		<div id="position">ADMINISTRATOR</div>
		<div id="user"><?php echo $this->session->userdata('admin_username');?></div>
		