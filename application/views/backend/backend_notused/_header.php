		<img src="<?php echo ASSETS_DIR_IMG.'title.png'?>" id="logo"/>
		<div id="user"><?php echo $this->session->userdata('admin_username');?></div>
		<div id="position">ADMINISTRATOR</div>
		<a href="<?php echo site_url('backend/logout');?>" class="btn info floatright">Logout</a>
		