		<img src="<?php echo ASSETS_DIR_IMG.'title.png'?>" id="logo"/>
		<div id="user"><?php echo $this->session->userdata('nama');?></div>
		<div id="position"><?php if($this->session->userdata('jabatan')==1)
		echo 'SATKER';
		elseif($this->session->userdata('jabatan')==2)
		echo 'ESELON';
		elseif($this->session->userdata('jabatan')==3)
		echo 'K/L';
		elseif($this->session->userdata('jabatan')==4)
		echo 'DJA';
		?></div>
		<?php echo anchor('user/logout','Logout','class="custom floatright"');?>
		