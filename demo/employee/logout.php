<?php
	# Initialize the session.
	session_start();
 
	# Unset all of the session variables.
	#$_SESSION = array();
 
	# Destroy the whole session.
	#session_destroy();

	# Destroy the session of employee only.
	unset($_SESSION["employee_loggedin"]);
 
	# Redirect to login page.
	header("location: ../employee/login.php");
	exit;
?>
