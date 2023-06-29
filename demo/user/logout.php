<?php
	# Initialize the session.
	session_start();
 
	# Unset all of the session variables.
	# $_SESSION = array();

	# Destroy the whole session.
	#session_destroy();
	
	# Destroy the session of user only.
	unset($_SESSION["user_loggedin"]);
 
	# Redirect to login page.
	header("location: ../user/login.php");
	exit;
?>
