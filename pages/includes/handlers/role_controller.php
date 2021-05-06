<?php
session_start(); 
require 'databaseConn_handler.php';
include '../loader.class.php';

//------------------------ LOAD ALL ROLES ---------------------
if(ISSET($_POST['loadAllRoles'])) {
    $role = new Roles();
    $role->getAllRoles();
}

//------------------------ LOAD SPECIFIC ROLE ---------------------
elseif(ISSET($_POST['loadSpecificRole'])) {
	$roleID = htmlentities($_POST['roleID']);

    $role = new Roles();
    $role->getSpecificRoles($roleID);
}

//------------------------ LOAD ROLE'S PERMISSIONS ---------------------
elseif(ISSET($_POST['loadPermissions'])) {
    $roleID = htmlentities($_POST['roleID']);
    $userID = htmlentities($_POST['userID']);

	if($userID==""){
		$role = new Roles();
	 	$role->getRolePermissions($roleID);
	}
	else {
		$role = new Roles();
		$role->getUserRolePermissions($roleID, $userID);
	}
    
}

//------------------------ LOAD SPECIFIC ROLE ---------------------
elseif(ISSET($_POST['loadSpecificRolePerm'])) {
	$roleID = htmlentities($_POST['roleID']);

    $role = new Roles();
    $role->getSpecificRolePerm($roleID);
}

//------------------------ SAVE NEW ROLE ---------------------
elseif(ISSET($_POST['saveNewRole'])) {
    $roleName = htmlentities($_POST['roleName']);
	$roleDesc = htmlentities($_POST['roleDesc']);

    $newRole = new Roles();
	$newRole->setNewRole($roleName, $roleDesc);
	
	$activity = "Added a new role: $roleName";
	saveUserLogs($activity);
}

//------------------------ SAVE NEW PERMISSION ---------------------
elseif(ISSET($_POST['savePermission'])) {
    //$userID = htmlentities($_POST['userId']);
	$roleID = htmlentities($_POST['roleId']);
	//$roleName = htmlentities($_POST['roleName']);
	
	$user_add = htmlentities($_POST['user_add']);
	$user_view = htmlentities($_POST['user_view']);
	$user_manage = htmlentities($_POST['user_manage']);
	$user_logs = htmlentities($_POST['user_logs']);
	$user_role = htmlentities($_POST['user_role']);
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


    $newPerm = new Roles();
    $newPerm->setNewPermission($roleID, $user_add, $user_view, $user_manage, $user_role, $user_logs,  $user_updateInfo, $outlet_suplist, $outlet_reqsup, $outlet_resitem, $outlet_pendingrestock, $warehouse_regitem, $warehouse_setupitem, $warehouse_suplist, $warehouse_encreqsup, $warehouse_encdel, $warehouse_mngdel, $warehouse_resreq, $asset_addnew, $asset_mngasset, $asset_disposed, $report_assets, $report_cons, $report_delsupplies, $report_delhistory, $report_userlogs, $settings_assetsubcat, $settings_outletemail, $settings_whemail, $settings_supplier, $settings_dept, $settings_location);
}

//------------------------ UPDATE ROLE AND PERMISSION ---------------------
elseif(ISSET($_POST['updateRolePermission'])) {
    //$selectedUser = htmlentities($_POST['selectedUser']);
	$roleID = htmlentities($_POST['roleID']);
	$roleName = htmlentities($_POST['roleName']);
	$roleDesc = htmlentities($_POST['roleDesc']);

	$user_add = htmlentities($_POST['user_add']);
	$user_view = htmlentities($_POST['user_view']);
	$user_manage = htmlentities($_POST['user_manage']);
	$user_logs = htmlentities($_POST['user_logs']);
	$user_role = htmlentities($_POST['user_role']);
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

    $updateRole = new Roles();
	$updateRole->setUpdateRole($roleName, $roleDesc, $roleID);
	$updatePerm = new Roles();
	$updatePerm->setUpdatePermission($user_add, $user_view, $user_manage, $user_role, $user_logs,  $user_updateInfo, $outlet_suplist, $outlet_reqsup, $outlet_resitem, $outlet_pendingrestock, $warehouse_regitem, $warehouse_setupitem, $warehouse_suplist, $warehouse_encreqsup, $warehouse_encdel, $warehouse_mngdel, $warehouse_resreq, $asset_addnew, $asset_mngasset, $asset_disposed, $report_assets, $report_cons, $report_delsupplies, $report_delhistory, $report_userlogs, $settings_assetsubcat, $settings_outletemail, $settings_whemail, $settings_supplier, $settings_dept, $settings_location, $roleID);
	
	$activity = "Updated the role: $roleName";
	saveUserLogs($activity);
}

//------------------------ DELETE ROLE AND PERMISSION ---------------------
elseif(ISSET($_POST['deleteRolePermission'])) {
    $roleName = htmlentities($_POST['roleName']);
	$roleID = htmlentities($_POST['roleID']);

    $delroleperm = new Roles();
	$delroleperm->setDeleteRole($roleID);

	$delroleperm->setDeletePerm($roleID);
	
	$activity = "Deleted the role: $roleName";
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