<?php
session_start(); 
include '../loader.class.php';

function displayJson($result){
    header('Content-type: application/json');
    echo json_encode($result);
}

//------------------------ LOAD ALL DEPARTMENT ---------------------
if(ISSET($_POST['loadAllDepartments'])) {
    $dept = new Department();
    $result = $dept->getAllDepartments();
    displayJson($result);
}

//------------------------ LOAD DEPARTMENT INFO ---------------------
elseif(ISSET($_POST['loadDeptInfo'])){
    $deptID = htmlentities($_POST['deptID']);

    $dept = new Department();
    $result = $dept->getLoadDeptInfo($deptID);
    displayJson($result);
}

//------------------------ SAVE NEW DEPARTMENT ---------------------
elseif (ISSET($_POST['saveNewDept'])){
    $deptName = htmlentities($_POST['deptName']);
    $deptShortName = htmlentities($_POST['deptShortName']);
    $deptNotes = htmlentities($_POST['deptNotes']);

    $newDept = new Department();
    $newDept->setNewDept($deptName, $deptShortName, $deptNotes);

    $activity = "Added a new department: ".$deptName;
    saveUserLogs($activity);
}

//------------------------ UPDATE DEPARTMENT INFO ---------------------
elseif (ISSET($_POST['updateDeptInfo'])){
    $deptID = htmlentities($_POST['deptID']);
    $deptName = htmlentities($_POST['deptName']);
    $deptShortName = htmlentities($_POST['deptShortName']);
    $deptNotes = htmlentities($_POST['deptNotes']);

    $updateDept = new Department();
    $updateDept->setUpdateDeptInfo($deptName, $deptShortName, $deptNotes, $deptID);

    $activity = "Updated a department's info: ".$deptName;
    saveUserLogs($activity);
}

//------------------------ DELETE DEPARTMENT ---------------------
elseif(ISSET($_POST['deleteDept'])){
    $deptID = htmlentities($_POST['deptID']);
    $deptName = htmlentities($_POST['deptName']);

    $delDept = new Department();
    $delDept->setDeleteDept($deptID);

    $activity = "Deleted a department: ".$deptName;
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