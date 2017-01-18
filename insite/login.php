<?php 
	session_start();
?>

<!DOCTYPE html>
<head>
	<?php include('../common/common-resources.php'); ?>
	<link rel="stylesheet" type="text/css" href="../styles/login.css" />
	<script type="text/javascript" src="../scripts/login.js"></script>
</head>
<body>
	<div class="main-container">
		<div class="login-container">
			<div class="email-address field">
				<label for="email-id">Email - ID</label>
				<input type="email" id="email-id" autocomplete="off">
			</div>
			<div class="user-password field">
				<label for="password">Password</label>
				<input type="password" id="password" autocomplete="off">
			</div>
			<div class="action-btn" id="login-action">LOGIN
			</div>
			<div class="action-btn" id="register-redirection">SIGNUP
			</div>
		</div>
		<div class="registration-container">
			<div class="firstname field">
				<label for="reg-firstname">Firstname</label>
				<input type="email" id="reg-firstname">
			</div>
			<div class="lastname field">
				<label for="reg-lastname">Lastname</label>
				<input type="email" id="reg-lastname">
			</div>
			<div class="email-address field">
				<label for="reg-email-id">Email - ID</label>
				<input type="email" id="reg-email-id">
			</div>
			<div class="user-password field">
				<label for="reg-password">Password</label>
				<input type="password" id="reg-password">
			</div>
			<div class="action-btn" id="register-action">SIGNUP
			</div>
		</div>
	</div>
</body>
</html>