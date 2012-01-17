		<div id="content-left">
			<a class="navigation-top" href="<?php echo site_url('backend')?>" <?php if($this->uri->segment(2) == ''):echo 'id="active-main"';endif;?>>Dashboard</a>
			<a class="navigation-title" href="<?php echo site_url('backend/user')?>" style="border-bottom:none;" <?php if($this->uri->segment(2) == 'user'):echo 'id="active-main"';endif;?>>Manajemen Administrator</a>
			<a class="navigation-title" href="<?php echo site_url('backend/access_management')?>" style="border-bottom:none;" <?php if($this->uri->segment(2) == 'access_management'):echo 'id="active-main"';endif;?>>Manajemen Akses</a>
			<a class="navigation-title" href="<?php echo site_url('backend/sms/outbox')?>" style="border-bottom:none" <?php if($this->uri->segment(2) == 'sms'):echo 'id="active-main"';endif;?>>Broadcast SMS</a>
			<a class="navigation-title" href="<?php echo site_url('backend/ref')?>" style="border-bottom:none;" <?php if($this->uri->segment(2) == 'ref'):echo 'id="active-main"';endif;?>>Pemeliharaan Referensi</a>
			<a class="navigation-title" href="<?php echo site_url('backend/audit')?>" <?php if($this->uri->segment(2) == 'audit'):echo 'id="active-main"';endif;?>>Audit Trail</a>
			<a class="navigation-bottom" href="<?php echo site_url('backend/queue')?>" <?php if($this->uri->segment(2) == 'queue'):echo 'id="active-main"';endif;?>>Antrian</a>			

		</div><!-- end of content-left -->
		