<?php
session_start(); 	

if (isset($_POST['userID'])){

	require 'databaseConn_handler.php';

	$userID = htmlentities($_POST['userID']);
	$hcurrentPassd = htmlentities($_POST['currentPass']);
	$hnewPassword = htmlentities($_POST['newPassword']);
	$activity = htmlentities($_POST['activity']);


//error handlers

	$sql = "SELECT * FROM users_tbl WHERE userid='$userID';";
	$result = mysqli_query($conn, $sql);
	$numOfResults = mysqli_num_rows($result);

	if ($numOfResults==0) {
		echo "No username found!";
	}

	else {
		if ($row = mysqli_fetch_assoc($result)) {
			//dehashing the password from the DB  
			$pwdCheck = password_verify($hcurrentPassd, $row['password']);
				if ($pwdCheck == false) {
					echo "Incorrect Current Password!";
				} 
				elseif ($pwdCheck == true) {
					//Getting the user credentials on session
					$hashedPwd = password_hash($hnewPassword, PASSWORD_DEFAULT);
					$updatesql = "UPDATE users_tbl SET password='$hashedPwd' WHERE userid='$userID';";
					if (!mysqli_query($conn, $updatesql)) {
					 	echo "Error on updating new password: ".mysqli_error($conn);
					}
					else {
						//echo "success";

						//-----------==================== For User Logs =====================------------
						$userId = $_SESSION['userID'];
						$username = $_SESSION['username'];
						$fullName = $_SESSION['currentUser'];
						//$activity = "Changed the user own password";
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
					//--------------------
				} 
				else {
					echo "SQL Error!";
				}
		} 
		else {
			echo "Invalid Username";
		}
	}


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