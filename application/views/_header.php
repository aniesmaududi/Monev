		<script type="text/javascript" src="<?php echo ASSETS_DIR_JS;?>fusioncharts.js"></script>
                <img src="<?php echo ASSETS_DIR_IMG.'title.png'?>" id="logo"/>
		<div id="user"><?php echo $this->session->userdata('nama');?></div>
		<div id="position"><?php echo $this->session->userdata('jabatan');?></div>
		<?php echo anchor('user/logout','Logout','class="custom floatright"');?>
		