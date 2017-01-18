<div class="header">
	<div class="left-container">
		<a href="../insite/home.php"><div class="app-title menu-item">PollApp</div></a>
	</div>
	<div class="right-container">
		<div class="add-qs menu-item">Ask Question 
		</div>
		<?php if(isset($_SESSION["firstname"]) && !empty($_SESSION["firstname"])) { ?>
			<div class="user-name menu-item">Hi, <?php echo $_SESSION["firstname"]; ?>
				<img src="../resources/dropdown-arrow.png" />
			</div>
			<div class="addons-container">
				<a href="../insite/dashboard.php"><div class="profile addon">My Dashboard</div></a>
				<a href="../insite/logout.php"><div class="logout addon">Logout</div></a>
			</div>
		<?php } ?>
	</div>
</div>