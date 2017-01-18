<?php 
	$serverName = "localhost";
	$userName = "root";
	$password = "ankita";
	$databaseName = "pollapp";

	$conn = new mysqli($serverName, $userName, $password, $databaseName);
	if($conn ->connect_error) {
		die("Error: Could not connect" . $conn ->connect_error);
	}
?>