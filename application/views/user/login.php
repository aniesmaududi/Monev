<!DOCTYPE html>
<html>
	<head>
		<title>LOGIN MONEV</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="<?php echo ASSETS_DIR_CSS.'style.css'?>" rel="stylesheet" type="text/css">
		<link href="<?php echo ASSETS_DIR_CSS.'backend.css'?>" rel="stylesheet" type="text/css">
		<link rel="icon" type="image/png" href="images/favicon.png"/>		
	</head>
	
	<body style="padding-top:80px;">
		<div id="login-container">
		<form action="<?php echo site_url('user/login')?>" method="post">

		<div id="content">
			<img src="<?php echo ASSETS_DIR_IMG.'title.png'?>" id="logo"/>
			<div class="clearfix"></div>
			<!-- -->
			<div id="login-box">
				<?php if($this->session->flashdata('message')):?>
				<div class="alert-message <?php echo $this->session->flashdata('message_type')?> no-margin-bottom" data-alert="alert">
						<a class="close" href="#">&times;</a>
						<p><?php echo $this->session->flashdata('message')?></p>
				</div>
				<?php endif;?>
				<table class="login">
					<tr>
						<td class="login-label">username</td>
						<td><input type="text" name="user_name" value="" class="input-text"/></td>
					</tr>
					<tr>
						<td class="login-label">password</td>
						<td><input type="password" name="user_password" class="input-text" />
							<br/><div class="error">
							<?php //if(isset($error)) echo "<b><span style='color:red;'>$error</span></b>";
//if(isset($logout)) echo "<b><span style='color:red;'>$logout</span></b>"; ?>
<?php if(isset($error)) echo $error;
if(isset($logout)) echo $logout; ?>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<div id="button-box" class="login-button">
				<input type="submit" name="submit" class="btn primary action-login" value="login">
				<input type="reset" value="reset" class="btn">
			</div>
			</form>
		</div>
		<p id="copyright">Copyright &copy; <?php echo date('Y');?> Kementerian Keuangan RI - DJA</p>
		</div>
		<script src="<?php echo ASSETS_DIR_JS?>jquery-1.7.1.min.js"></script>
		<script src="<?php echo ASSETS_DIR_JS?>bootstrap-alerts.js"></script>
	</body>
	
</html>