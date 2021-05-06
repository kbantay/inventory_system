<?php
//session_start();

// if (isset($_POST['btnClicked'])){
	session_start();
	session_unset();
	session_destroy();
	// $_SESSION = array(); // clear the $_SESSION variable
	header("Location: ../index");
	exit();
// } 

