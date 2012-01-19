<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo (isset($title)) ? $title . ' - ' : ''; ?>Monev Administrator</title>
		
        <!-- HTML5, for IE6-8 support of HTML elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
 
        <base href="<?php echo base_url(); ?>"></base>
        <!-- styles load below -->
        <link href="<?php echo ASSETS_DIR_CSS.'style.css'?>" rel="stylesheet" type="text/css">
		<link href="<?php echo ASSETS_DIR_CSS.'backend.css'?>" rel="stylesheet" type="text/css">
		<link rel="icon" type="image/png" href="images/favicon.png"/>
    </head>
    <body>
		<!-- template load below -->
		<div id="container">
		
		<div id="content">
			<?php $this->view('backend/_header');?>
			<div class="clearfix"></div>
			<?php $this->view('backend/_leftnav');?>
		
			<div id="content-right">
				<!-- change this with parameter from controller -->
				<?php $this->view('backend/'.$template);?>
			</div><!-- end of content-right -->
		
			<div class="clearfix"></div>
		
		</div><!-- end of content -->
		
		</div><!-- end of container -->
		<!-- javascript load below -->
		<script src="<?php echo ASSETS_DIR_JS.'jquery-1.7.1.min.js'?>"></script>
		 <script src="<?php echo ASSETS_DIR_JS.'chosen.jquery.min.js'?>"></script>
		<script src="<?php echo ASSETS_DIR_JS.'bootstrap-alerts.js'?>"></script>
	</body>
</html>