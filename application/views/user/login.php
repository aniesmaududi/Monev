<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title><?php echo($title)? $title.' - ' : ''; ?>MONEV</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="<?php echo ASSETS_DIR_CSS.'style.css'?>" rel="stylesheet" type="text/css">
		<link href="<?php echo ASSETS_DIR_CSS.'backend.css'?>" rel="stylesheet" type="text/css">
		<link rel="icon" type="image/png" href="images/favicon.png"/>		
	</head>
	
	<body>
		<div id="login-container">
		<form action="<?php site_url('user/login')?>" method="post">

		<div id="content">
			<img src="<?php echo ASSETS_DIR_IMG.'title.png'?>" id="logo"/>
			<br/>
			<!-- -->
			<div id="login-box">
				<table class="login">
					<tr>
						<td class="words">Username</td>
						<td><input type="text" name="user_name" value=""/></td>
					</tr>
					<tr>
						<td class="words">Password</td>
						<td><input type="password" name="user_password" />
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
			<div id="button-box">
				<input type="submit" name="submit" class="btn primary action-login" value="login">
				<input type="reset" value="reset" class="btn">
			</div>
			</form>
		</div>
		</div>
	</body>
	
</html>