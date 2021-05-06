<?php
session_start(); 	
include '../loader.class.php';

//------------------------- LOAD ALL SUPPLIERS ----------------------------
if (ISSET($_POST['getAllSuppliers'])){
	$supplier = new Supplier();
	$supplier->getAllSupplier();
}

//------------------------- LOAD ALL SUPPLIERS ----------------------------
else if (ISSET($_POST['getConsSuppliers'])){
	$supplier = new Supplier();
	$supplier->getConsSupplier();
}

//------------------------- LOAD SPECIFIC SUPPLIER ----------------------------
else if(ISSET($_POST['getSpecificSupplier'])){
    $supplierId = htmlentities($_POST['supplierId']);

	$supplier = new Supplier();
	$supplier->getSpecificSupplier($supplierId);
}

//------------------------- SAVE NEW SUPPLIER ----------------------------
else if (ISSET($_POST['saveNewSupplier'])) {
	$supplierName = htmlentities($_POST['supplierName']);
    $supAddress = htmlentities($_POST['supAddress']);
    $supContactNum = htmlentities($_POST['supContactNum']);
    $supType = htmlentities($_POST['supType']);

	$newSup = new Supplier();
	$newSup->setNewSupplier($supplierName, $supAddress, $supContactNum, $supType);

	$activity = "Added a new supplier: $supplierName";
	saveUserLogs($activity);
}

//------------------------- DELETE SPECIFIC SUPPLIER ----------------------------
else if (ISSET($_POST['deleteSupplier'])) {
    $supplierId = htmlentities($_POST['supplierId']);
    $supplierName = htmlentities($_POST['supplierName']);

	$delSup = new Supplier();
	$delSup->setDeleteSupplier($supplierId);

	$activity = "Deleted the supplier: $supplierName";
	saveUserLogs($activity);
}

//------------------------- UPDATE SPECIFIC SUPPLIER ----------------------------
else if (ISSET($_POST['updateSupplierInfo'])) {
    $supplierId = htmlentities($_POST['supplierId']);
    $supplierName = htmlentities($_POST['supplierName']);
    $suppAddress = htmlentities($_POST['suppAddress']);
    $suppContactNum = htmlentities($_POST['suppContactNum']);
    $suppType = htmlentities($_POST['suppType']);

	$updateSup = new Supplier();
	$updateSup->setUpdateSupplier($supplierName, $suppAddress, $suppContactNum, $suppType, $supplierId);

	$activity = "Updated the supplier: $supplierName";
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