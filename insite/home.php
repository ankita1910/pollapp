<?php 
	session_start();
	include("db-connect.php");

	/* Redirect to login page if session variable is empty*/
	if(empty($_SESSION)) {
		header("Location: login.php");
		exit();
	}

?>
<!DOCTYPE html>
<head>
	<?php include('../common/common-resources.php'); ?>
	<link rel="stylesheet" type="text/css" href="../styles/home.css" />
	<script type="text/javascript" src="../scripts/home.js"></script>
</head>
<body>
	<div class="main-container">
		<?php include('../common/header.php') ?>
		<div class="qs-container" id="all-qs">
		</div>
		<?php include('../common/common-modals.html'); ?>
	</div>
</body>
</html>