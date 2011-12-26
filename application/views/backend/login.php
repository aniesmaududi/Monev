<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title><?php echo($title)? $title.' - ' : ''; ?>MONEV</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="<?php echo ASSETS_DIR_CSS.'style.css'?>" rel="stylesheet" type="text/css">
		<link rel="icon" type="image/png" href="images/favicon.png"/>		
	</head>
	
	<body>
		<div id="login-container">
		<div id="content">
			<img src="<?php echo ASSETS_DIR_IMG.'title.png'?>" id="logo"/><span style="font-size:1.3em;font-weight:bold;">Administrator</span>
			<br/>
			<form action="<?php site_url('backend/login')?>" method="post">
			<div id="login-box">
				<table class="login">
					<tr>
						<td class="words">Username</td>
						<td><input type="text" name="admin_username" value=""/></td>
					</tr>
					<tr>
						<td class="words">Password</td>
						<td><input type="password" name="admin_password" />
							<!--<br/><div class="error">password tidak benar</div>-->
						</td>
					</tr>
				</table>
			</div>
			<div id="button-box">
				<table class="login">
					<tr>
						<td><input type="submit" name="submit" value="Login"></td>
						<td><input type="reset" value="reset"></td>
					</tr>
				</table>
			</div>
			</form>
		</div>
		</div>
	</body>
	
</html>