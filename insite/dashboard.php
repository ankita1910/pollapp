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
	<script type="text/javascript" src="http://d3js.org/d3.v3.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../styles/dashboard.css" />
	<script type="text/javascript" src="../scripts/dashboard.js"></script>
</head>
<body>
	<div class="main-container">
		<?php include('../common/header.php') ?>
		<div class="qs-container" id="all-qs">
		</div>
		<?php include('../common/common-modals.html'); ?>
	</div>
	<div class="response-overlay-stats">
		<div class="response-container">
			<div class="heading">
				<span class="__text">Response Statistics
				</span>
				<span class="__close">x
				</span>
			</div>
			<div class="response-content">
				<div id="response-popup"></div>
			</div>
		</div>
	</div>
</body>
</html>