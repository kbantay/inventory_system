<?php

if (ISSET($_POST['userID'])) {
	
	require 'databaseConn_handler.php';

	$userID = htmlentities($_POST['userID']);
	
	// $sql = "SELECT * FROM users_tbl WHERE userid='$userID';";
	// $result = mysqli_query($conn, $sql);
	// $row = mysqli_fetch_assoc($result);
	// echo $row['is_PwChanged'];

	$sql = "UPDATE users_tbl SET is_PwChanged='1' WHERE userid='$userID';";
	if (!mysqli_query($conn, $sql)) {
		echo "SQL error: ".mysqli_error($conn);
	}
	else {
		echo "Success on updating is_PwChanged!";
	}
}