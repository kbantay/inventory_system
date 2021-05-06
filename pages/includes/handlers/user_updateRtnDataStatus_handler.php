<?php
session_start(); 	

if (ISSET($_POST['userID'])){

    require 'databaseConn_handler.php';
    
    $userID = htmlentities($_POST['userID']);
    $rtnData = htmlentities($_POST['rtnData']);

	$updatesql = "UPDATE users_tbl SET is_retaindata='$rtnData' WHERE userid='$userID';";
	if (!mysqli_query($conn, $updatesql)) {
		echo "Error on updating retain data status: ". mysqli_error($conn);
	}	
	else {
		echo "success";
	}
} 

else {
	if(ISSET($_SESSION['username'])){
		header("Location: ../../error403");
		exit();
	}
	else {
		header("Location: ../index");
		exit();
	}
}