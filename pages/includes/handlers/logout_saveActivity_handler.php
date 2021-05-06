<?php
session_start(); 	

if (isset($_POST['userID'])){

	require 'databaseConn_handler.php';

	//-----------==================== For User Logs =====================------------
	$userId = $_SESSION['userID'];
	$username = $_SESSION['username'];
	$fullName = $_SESSION['currentUser'];
	$activity = "Logged-out of the system";
	$timezone = date_default_timezone_set('Asia/Manila');
	$dateTimeNow = date("M-d-Y")." ".date("h:i:s a", time());
	//$log = $userId." ".$username." ".$empName." ".$activity." ".$dateTimeNow;
	//--------------- Saving this activity to the User Logs ---------------
	$logsql = "INSERT INTO userlogs_tbl (userID, fullName, username, activity, dateAndTime) VALUES ('$userId', '$fullName', '$username', '$activity', '$dateTimeNow')";
	//mysqli_query($conn, $logsql);
	if (!mysqli_query($conn, $logsql)) {
		echo "Error on saving activity log: ".mysqli_error($conn);
	}
	else {
		echo "success";
	}
	//------------------------------ end of user logs ------------------------------
} 


else {
	if(isset($_SESSION['username'])){
		header("Location: ../../error403");
		exit();
	}
	else {
		header("Location: ../index");
		exit();
	}
}