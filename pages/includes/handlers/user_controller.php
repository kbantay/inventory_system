<?php
session_start(); 
require 'databaseConn_handler.php';
include '../loader.class.php';

//------------------------ LOAD ALL USERS ---------------------
if(ISSET($_POST['loadAllUsers'])) {
    $users = new Users();
    $users->getAllUsers();
}

//------------------------ LOAD USER LOGS ---------------------
else if(ISSET($_POST['loadUserLogs'])) {
    $users = new Users();
    $users->getUserLogs();
}

//------------------------ LOAD SPECIFIC USER WITH ROLE AND PERMISSION ---------------------
else if(ISSET($_POST['loadUserWithRolePermission'])) {
    $userID = htmlentities($_POST['userID']);

    $users = new Users();
    $users->getSpecificUserRolePermission($userID);
}

//------------------------ LOAD SPECIFIC USER ---------------------
else if(ISSET($_POST['loadSpecificUser'])) {
    $userID = htmlentities($_POST['userID']);

    $users = new Users();
    $users->getSpecificUser($userID);
}

//------------------------ LOAD SPECIFIC USER PER USERNAME---------------------
else if(ISSET($_POST['loadUserPerUsername'])) {
    $username = htmlentities($_POST['username']);

    $user = new Users();
    $user->getUsername($username);
}

//------------------------ LOAD SPECIFIC USER ---------------------
else if(ISSET($_POST['loadUserPermission'])) {
    $userID = htmlentities($_POST['userID']);

    $users = new Users();
    $users->getUserPermission($userID);
}

//------------------------ Load user answer: Check if correct ------------------
else if(ISSET($_POST['verifyUserAnswer'])) {
    $userID = htmlentities($_POST['userID']);

    $users = new Users();
    $users->getUserAnswerPerID($userID);
}

//------------------------ Load current outlet admin email address ------------------
else if(ISSET($_POST['loadCurrentEmailReceiver'])) {
    $designation = htmlentities($_POST['designation']);

    $users = new Users();
    $users->getCurrentEmailReceiver($designation);
}


//------------------------ CHECK IF THE USER EXIST BEFORE SAVING ------------------
else if(ISSET($_POST['checkUserExists'])) {
    $username = htmlentities($_POST['username']);

    $users = new Users();
    $users->getCheckUserExists($username);
}

elseif (ISSET($_POST['loadSearchedName'])) {
    $searchedName = htmlentities($_POST['searchedName']);
    $name = new Users();
    $name->getSearchedName($searchedName);
}

//------------------------ REGISTER NEW  USER---------------------
else if(ISSET($_POST['registerNewUser'])) {
    $fullname = htmlentities($_POST['fullname']);
	$designation = htmlentities($_POST['designation']);
	$department = htmlentities($_POST['department']);
	$email = htmlentities($_POST['email']);
	$username = htmlentities($_POST['username']);
    $password = htmlentities($_POST['password']);
    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
	$passChanged = "0";
    $userRole = htmlentities($_POST['userRole']);
    $assetAccess = htmlentities($_POST['assetAccess']);
	$secquestion = htmlentities($_POST['secquestion']);
	$secanswer = htmlentities($_POST['secanswer']);

    $newUser = new Users();
    $newUser->setNewUser($username, $hashedPwd, $userRole, $assetAccess, $email, $fullname, $designation, $department, $secquestion, $secanswer, $passChanged);

    $activity = "Added a new uaser: $fullname";
    saveUserLogs($activity);
}

//------------------------ UPDATE USER PROFILE ---------------------
else if(ISSET($_POST['updateUserProfile'])) {
    $userID = htmlentities($_POST['userID']);
    $userName = htmlentities($_POST['userName']);
    $userRole = htmlentities($_POST['userRole']);
	$fullName = htmlentities($_POST['fullName']);
	$designation = htmlentities($_POST['designation']);
	$email = htmlentities($_POST['email']);
	$department = htmlentities($_POST['department']);
	$secquestion = htmlentities($_POST['secquestion']);
	$secanswer = htmlentities($_POST['secanswer']);

    $updateUser = new Users();
    $updateUser->setUpdateUserProfile($userName, $userRole, $fullName, $designation, $email, $department, $secquestion, $secanswer, $userID);

    $delPerm = new Roles();
    $delPerm->setDeletePermPerUser($userID);

    $userPerm = new Users();
    $userPerm->setNewUserPerm($userName, $userRole);

    $activity = "Updated the profile of $fullName";
    saveUserLogs($activity);
}

//------------------------ RESET USER PASSWORD  ---------------------
else if(ISSET($_POST['resetUserPassword'])) {
    $userid = htmlentities($_POST['userid']);
    $fullname = htmlentities($_POST['fullname']);
    $newPassword = htmlentities($_POST['newPassword']);
	$hashedPwd = password_hash($newPassword, PASSWORD_DEFAULT);

    $resetpass = new Users();
    $resetpass->setResetUserPassword($hashedPwd, $userid);

    $activity = "Reset the password of $fullname";
    saveUserLogs($activity);
}

//------------------------ RESET USER PASSWORD ON FORGOT PASSWORD PAGE ---------------------
else if(ISSET($_POST['resetOwnUserPassword'])) {
    $userId = htmlentities($_POST['userid']);
    $fullname = htmlentities($_POST['fullname']);
    $newPassword = htmlentities($_POST['newPassword']);
	$hashedPwd = password_hash($newPassword, PASSWORD_DEFAULT);

    $resetpass = new Users();
    $resetpass->setResetOwnPassword($hashedPwd, $userId);

    $username = htmlentities($_POST['username']);
    $curUser = $username;
    $activity = "Reset the password of $fullname";
    $timezone = date_default_timezone_set('Asia/Manila');
    $dateTimeNow = date("M-d-Y")." ".date("h:i:s a", time());

    $saveLog = new Activitylogs();
    $saveLog->setNewLog($userId, $curUser, $username, $activity, $dateTimeNow);
}

//------------------------ SAVE NEW USER PERMISSION  --------------------- 
else if(ISSET($_POST['saveUserPermission'])) {
    $username = htmlentities($_POST['username']);
	$userRole = htmlentities($_POST['userRole']);

    $userPerm = new Users();
    $userPerm->setNewUserPerm($username, $userRole);
    echo 1;
}

//------------------------ DELETE USER AND PERMISSION ---------------------
else if(ISSET($_POST['deleteUserAccount'])) {
    $userid = htmlentities($_POST['userid']);
    $fullname = htmlentities($_POST['fullname']);
     
    $delUser = new Users();
    $delUser->setDeleteUser($userid);
    $delUser->setDeleteUserPermission($userid);

    $activity = "Deleted the user $fullname";
    saveUserLogs($activity);
}

//------------------------ UPDATE USER'S PERMISSION ---------------------
else if(ISSET($_POST['updateUserPermission'])){
    $selectedUser = htmlentities($_POST['selectedUser']);
	//$roleID = htmlentities($_POST['roleID']);
	$userID = htmlentities($_POST['userID']);
	// $roleName = htmlentities($_POST['roleName']);
	// $roleDesc = htmlentities($_POST['department']);
	$user_add = htmlentities($_POST['user_add']);
	$user_view = htmlentities($_POST['user_view']);
    $user_manage = htmlentities($_POST['user_manage']);
    $user_role = htmlentities($_POST['user_role']);
    $user_logs = htmlentities($_POST['user_logs']);
    $user_updateInfo = htmlentities($_POST['user_updateInfo']);
    $outlet_suplist = htmlentities($_POST['outlet_suplist']);
    $outlet_reqsup = htmlentities($_POST['outlet_reqsup']);
    $outlet_resitem = htmlentities($_POST['outlet_resitem']);
    $outlet_pendingrestock = htmlentities($_POST['outlet_pendingrestock']);
    $warehouse_regitem = htmlentities($_POST['warehouse_regitem']);
    $warehouse_setupitem = htmlentities($_POST['warehouse_setupitem']);
    $warehouse_suplist = htmlentities($_POST['warehouse_suplist']);
    $warehouse_encreqsup = htmlentities($_POST['warehouse_encreqsup']);
    $warehouse_encdel = htmlentities($_POST['warehouse_encdel']);
    $warehouse_mngdel = htmlentities($_POST['warehouse_mngdel']);
    $warehouse_resreq = htmlentities($_POST['warehouse_resreq']);
    $asset_addnew = htmlentities($_POST['asset_addnew']);
    $asset_mngasset = htmlentities($_POST['asset_mngasset']);
    $asset_disposed = htmlentities($_POST['asset_disposed']);
    $report_assets = htmlentities($_POST['report_assets']);
    $report_cons = htmlentities($_POST['report_cons']);
    $report_delsupplies = htmlentities($_POST['report_delsupplies']);
    $report_delhistory = htmlentities($_POST['report_delhistory']);
    $report_userlogs = htmlentities($_POST['report_userlogs']);
    $settings_assetsubcat = htmlentities($_POST['settings_assetsubcat']);
    $settings_outletemail = htmlentities($_POST['settings_outletemail']);
    $settings_whemail = htmlentities($_POST['settings_whemail']);
    $settings_supplier = htmlentities($_POST['settings_supplier']);
    $settings_dept = htmlentities($_POST['settings_dept']);
    $settings_location = htmlentities($_POST['settings_location']);

    $updateUser = new Users();
    $updateUser->setUpdateUserPermission($user_add, $user_view, $user_manage, $user_role, $user_logs, $user_updateInfo, $outlet_suplist, $outlet_reqsup, $outlet_resitem, $outlet_pendingrestock, $warehouse_regitem, $warehouse_setupitem, $warehouse_suplist, $warehouse_encreqsup, $warehouse_encdel, $warehouse_mngdel, $warehouse_resreq, $asset_addnew, $asset_mngasset, $asset_disposed, $report_assets, $report_cons, $report_delsupplies, $report_delhistory, $report_userlogs, $settings_assetsubcat, $settings_outletemail, $settings_whemail, $settings_supplier, $settings_dept, $settings_location, $userID);

    $activity = "Updated the user permission of $selectedUser";
    saveUserLogs($activity);
}

//------------------------ UPDATE CURRENT EMAIL RECEIVER  ---------------------
else if(ISSET($_POST['updateCurrentEmailReceiver'])) {
	$fullname = htmlentities($_POST['name']);
	$emailaddress = htmlentities($_POST['email']);
    $designation = htmlentities($_POST['designation']);

    $user = new Users();
    $user->setUpdateCurrentEmailReceiver($fullname, $emailaddress, $designation);

    $activity = "Updated the current receiver of email notification for $designation";
    saveUserLogs($activity);
}


//------------------------ DELETE  ---------------------
else if(ISSET($_POST['downloadcsv'])) {
    $delUser = new Users();
    $delUser->downloadSCV();

    // $activity = "Deleted the user $fullName";
    // saveUserLogs($activity);
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