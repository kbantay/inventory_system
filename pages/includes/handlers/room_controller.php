<?php
session_start(); 
require 'databaseConn_handler.php';
include '../loader.class.php';

//------------------------ LOAD ALL ROOMS ---------------------
if(ISSET($_POST['loadAllRooms'])) {
    $person = new Room();
    $person->getAllRooms();
}

//------------------------ LOAD ALL ROOM PER BLDG ---------------------
 else if(ISSET($_POST['loadRoomPerBldg'])) {
    $bldgID = htmlentities($_POST['bldgID']);

    $person = new Room();
    $person->getRoomPerBldg($bldgID);
}
//------------------------ SAVE NEW ROOMS ---------------------
 else if(ISSET($_POST['saveNewRoom'])) {
    $bldgID = htmlentities($_POST['bldgID']);
    $bldgName = htmlentities($_POST['bldgName']);
    $roomName = htmlentities($_POST['roomName']);
    $roomNotes = htmlentities($_POST['roomNotes']);
    $location = htmlentities($_POST['location']);

    $saveRoom = new Room();
    $saveRoom->setNewRoom($bldgID, $bldgName, $roomName, $location, $roomNotes);
    

    $activity = "Added a new room: ".$roomName." under the building: ".$bldgName;
    saveUserLogs($activity);
}

//------------------------ DELETE A ROOMS ---------------------
else if(ISSET($_POST['deleteRoom'])) {
    $roomID = htmlentities($_POST['roomID']);
    $bldgName = htmlentities($_POST['bldgName']);
    $roomName = htmlentities($_POST['roomName']);

    $delRoom = new Room();
    $delRoom->setDeleteRoom($roomID);

    $activity = "A room has been deleted: ".$roomName." under the building: ".$bldgName;
    saveUserLogs($activity);
}

//------------------------ LOAD ROOM'S INFO ---------------------
else if(ISSET($_POST['editRoomInfo'])) {
    $roomID = htmlentities($_POST['roomID']);
    $loadRoom = new Room();
    $loadRoom->getRoomInfo($roomID);
}

//------------------------ UPDATE ROOM ---------------------
else if(ISSET($_POST['updateRoom'])) {
    $bldgID = htmlentities($_POST['bldgID']);
    $roomID = htmlentities($_POST['roomID']);
    $bldgName = htmlentities($_POST['bldgName']);
    $bldgShort = htmlentities($_POST['bldgShort']);
    $roomName = htmlentities($_POST['roomName']);
    $locationName = "$bldgShort $roomName";
    $roomNotes = htmlentities($_POST['roomNotes']);

    $updateRoom = new Room();
    $updateRoom->setUpdateRoomInfo($bldgID, $bldgName, $roomName, $locationName, $roomNotes, $roomID);
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
