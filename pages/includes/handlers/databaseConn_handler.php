<?php

	$dbServername = "localhost";
	$dbUsername	 = "root";
	$dbPassword = "";
	$dbName = "suppliesmngt_db";

	$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
	//$conn = mysqli_connect("localhost", "root", "", "igsladmission_db");

	if (!$conn) {
		die("Connection Failed: ".mysqli_connect_error());
	}
	

