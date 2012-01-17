		<script type="text/javascript" src="<?php echo ASSETS_DIR_JS;?>fusioncharts.js"></script>
        <img src="<?php echo ASSETS_DIR_IMG.'title.png'?>" id="logo"/>
        <a href="user/logout" class="custom floatright" id="logout">Logout</a>
		<div id="position"><?php echo $this->session->userdata('jabatan');?></div>
		<div id="user"><?php echo $this->session->userdata('nama');?></div>
		
		
		