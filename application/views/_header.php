		<div class="clearfix user-profile">
			<div id="position"><?php echo $this->session->userdata('jabatan_name');?></div>
			<div id="user"><?php echo $this->session->userdata('nama');?></div>
		</div>
		<div class="clearfix" style="padding-bottom:10px;">
		<img src="<?php echo ASSETS_DIR_IMG.'title.png'?>" id="logo"/>
		<?php  echo anchor('user/logout','Logout','class="custom floatright" id="logout"');?>
		</div>
		
		
		
		