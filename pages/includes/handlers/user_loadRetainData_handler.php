<?php
session_start(); 	

if (ISSET($_POST['userID'])){

    require 'databaseConn_handler.php';
    
    $userID = htmlentities($_POST['userID']);

	$sql = "SELECT * FROM users_tbl WHERE userid='$userID';";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);

	$rtnData = $row['is_retaindata'];

	echo $rtnData;
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