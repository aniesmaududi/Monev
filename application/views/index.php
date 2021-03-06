<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo (isset($title)) ? $title . ' - ' : ''; ?>Monev</title>
		
        <!-- HTML5, for IE6-8 support of HTML elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <base href="<?php echo base_url(); ?>"></base>
        <!-- styles load below -->
        <link href="<?php echo ASSETS_DIR_CSS.'style.css'?>" rel="stylesheet" type="text/css">
		<link rel="icon" type="image/png" href="images/favicon.png"/>
		<script type="text/javascript" src="<?php echo ASSETS_DIR_JS.'jquery-1.7.1.min.js'?>"></script>
		<script type="text/javascript" src="<?php echo ASSETS_DIR_JS.'highcharts.js'?>"></script>
    </head>
    <body>
		<!-- template load below -->
		<div id="container">
		
		<div id="content">
			<?php $this->view('_header');?>
			<div class="clearfix"></div>
			<?php 
				$this->view($this->uri->segment(1).'/leftnav');
			?>
			
			<div id="content-right">
				<!-- change this with parameter from controller -->
				<?php $this->view($template);?>
			</div><!-- end of content-right -->
		
			<div class="clearfix"></div>
		
		</div><!-- end of content -->
		<p id="copyright">Copyright &copy; 2011 Kementerian Keuangan RI - DJA</p>
		</div><!-- end of container -->
		<!-- javascript load below -->
		
		<script type="text/javascript" src="<?php echo ASSETS_DIR_JS.'chosen.jquery.min.js'?>"></script>
		
		<script type="text/javascript" src="<?php echo ASSETS_DIR_JS.'enhance.js'?>"></script>
		<script type="text/javascript">
			// Run capabilities test
			enhance({
				loadScripts: [
					'<?php echo ASSETS_DIR_JS?>excanvas.js',
					'<?php echo ASSETS_DIR_JS?>visualize.jQuery.js',
					'<?php echo ASSETS_DIR_JS?>style.js',
				],
				loadStyles: [
					'<?php echo ASSETS_DIR_CSS?>visualize.css',
					'<?php echo ASSETS_DIR_CSS?>visualize-light.css'
				]	
			});   
	    </script>
	</body>
</html>