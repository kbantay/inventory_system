<?php
//session_start(); 	

if (isset($_POST['userID'])){

	require 'databaseConn_handler.php';

	$userID = htmlentities($_POST['userID']);

	$sql = "SELECT is_PwChanged FROM users_tbl WHERE userid='$userID';";
	$result = mysqli_query($conn, $sql);

	if (!$result) {
	 	echo "SQL Error ".mysqli_error($conn);
	}
	else {
		$row = mysqli_fetch_assoc($result);
		$value = $row['is_PwChanged'];
		echo $value;
	}
	//---------------
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