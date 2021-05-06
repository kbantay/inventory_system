<?php
session_start(); 
require 'databaseConn_handler.php';
include '../loader.class.php';


//------------------------ LOAD ALL BUILDING ---------------------
if(ISSET($_POST['loadAllBldg'])) {
    $person = new Building();
    $person->getAllBuilding();
}

//------------------------ ADD a NEW BUILDING ---------------------
else if(ISSET($_POST['addNewBldg'])){
    $bldgName = htmlentities($_POST['bldgName']);
    $bldgShortName = htmlentities($_POST['bldgShortName']);
    $bldgNotes = htmlentities($_POST['bldgNotes']);

    $saveNew = new Building();
    $saveNew->setNewBldg($bldgName, $bldgShortName, $bldgNotes);

    $activity = "Added a new building: ".$bldgName;
    saveUserLogs($activity);
}

//------------------------ EDIT BUILDING INFO ---------------------
else if(ISSET($_POST['editBldgInfo'])){
    $bldgID = htmlentities($_POST['bldgID']);

    $editBldg = new Building();
    $editBldg->getBldgInfo($bldgID);
}

//------------------------ UPDATE BUILDING INFO ---------------------
else if(ISSET($_POST['updateBldgInfo'])){
    $bldgID = htmlentities($_POST['bldgID']);
    $bldgName = htmlentities($_POST['bldgName']);
    $bldgShortName = htmlentities($_POST['bldgShortName']);
    $bldgNotes = htmlentities($_POST['bldgNotes']);

    $updateBldg = new Building();
    $updateBldg->setUpdateBldgInfo($bldgName, $bldgShortName, $bldgNotes, $bldgID);

    $activity = "Updated info on building: ".$bldgName;
    saveUserLogs($activity);
}

//------------------------ DELETE BUILDING ---------------------
else if(ISSET($_POST['deleteBldg'])){
    $bldgID = htmlentities($_POST['bldgID']);
    $bldgName = htmlentities($_POST['bldgName']);
    
    $deleteBldg = new Building();
    $deleteBldg->setDeleteBldg($bldgID);

    $activity = "Deleted the building: ". $bldgName;
    saveUserLogs($activity);
}

//----------- Invalid Access: error403 ------------
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


function saveUserLogs($activity){
    $userId = $_SESSION['userID'];
    $username = $_SESSION['username'];
    $curUser = $_SESSION['currentUser'];
    $timezone = date_default_timezone_set('Asia/Manila');
    $dateTimeNow = date("M-d-Y")." ".date("h:i:s a", time());

    $saveLog = new Activitylogs();
    $saveLog->setNewLog($userId, $curUser, $username, $activity, $dateTimeNow);
}
