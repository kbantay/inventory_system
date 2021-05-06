<?php
session_start(); 	
include '../loader.class.php';

//--------------------- LOAD ALL SUPPLIERS --------------------
if (ISSET($_POST['getAllOutletStocks'])){
	$supplier = new Outlet();
	$supplier->getAllOutletSupplies();
}

//-------------------- LOAD LOWERING STOCKS ---------------------
else if (ISSET($_POST['getLoweringStocks'])){
	$stocks = new Outlet();
	$stocks->getLoweringOutletStocks();
}

//------------------ LOAD LOWERING STOCKS INFO ---------------------
else if (ISSET($_POST['getPendingOutletRestockRequest'])){
	$stocks = new Outlet();
	$stocks->getPendingOutletRestockReqs();
}

//------------------ LOAD LOWERING STOCKS DETAILS ---------------------
else if (ISSET($_POST['loadOutletRestockRequestItems'])){
	$outletRstkID = htmlentities($_POST['outletRstkID']);

	$stocks = new Outlet();
	$stocks->getPendingOutletRestockItems($outletRstkID);
}


//==================================================== SETTERS ============================================


//------------------ SAVE REQUEST SUPPLY'S INFO ----------------------
else if(ISSET($_POST['saveRestockRequestInfo'])){
    $dateRequested = htmlentities($_POST['dateRequested']);
    $department = htmlentities($_POST['department']);
    $requestor = htmlentities($_POST['requestor']);
    $remarks = htmlentities($_POST['remarks']);
	$status = htmlentities($_POST['status']);

	$supply = new Outlet();
    $supply->setRestockSupplyInfo($dateRequested, $requestor, $department, $status, $remarks);
    
    $activity = "Submitted a restock request of supplies for reception outlet";
	saveUserLogs($activity);
}

//------------------ SAVE NEW REQUEST SUPPLIES RESTOCK ITEMS ----------------------
else if(ISSET($_POST['saveOutletRestockItems'])){
    $outletRstkID = htmlentities($_POST['outletRstkID']);
	$productId = htmlentities($_POST['productId']);
	$brandname = htmlentities($_POST['brandname']);
	$productname = htmlentities($_POST['productname']);
	$description = htmlentities($_POST['description']);
	$itemName = htmlentities($_POST['itemName']);
    $quantity = htmlentities($_POST['quantity']);
	$unit = htmlentities($_POST['unit']);
	$unitPrice = htmlentities($_POST['unitPrice']);
	$stocksFull = htmlentities($_POST['stocksFull']);
	$type = htmlentities($_POST['type']);
	$status = htmlentities($_POST['status']);

	$outletRstkRqst = new Outlet();
	$outletRstkRqst->setNewRestockSupplyItems($outletRstkID, $productId, $brandname, $productname, $description, $itemName, $quantity, $unit, $unitPrice, $stocksFull, $type, $status);

}

//------------------ APPROVE REQUESTED SUPPLIES RESTOCK INFO ----------------------
else if(ISSET($_POST['approveOutletRestockRequest'])){
    $outletRstkID = htmlentities($_POST['outletRstkID']);
    $status = htmlentities($_POST['status']);

	$supply = new Outlet();
    $supply->setUpdateRestockSupplyInfo($status, $outletRstkID);
    
    $activity = "Approved the requested restock request of outlet reception";
	saveUserLogs($activity);
}

//------------------ APPROVE OUTLET REQUEST REQUEST ITEMS ----------------------
else if(ISSET($_POST['approveOutletRestockItems'])){
    $outletRstkID = htmlentities($_POST['outletRstkID']);
	$productId = htmlentities($_POST['productId']);
	$newStocksLeft = htmlentities($_POST['newStocksLeft']);
	$percentage = htmlentities($_POST['percentage']);
	$status = htmlentities($_POST['status']);

	$updateOutletReq = new Outlet();
	$updateOutletReq->setApproveRestockSupplyItems($status, $outletRstkID);

	$updateOutletReq = new Supply();
	$updateOutletReq->setUpdateNewStocks($productId, $newStocksLeft, $percentage);

}

//------------------ UPDATE STOCKS IN FULL OUTLET ITEMS ---------------------
else if (ISSET($_POST['updateStocksFullOutletStocks'])){
	$stocksfull = htmlentities($_POST['stocksfull']);
	$percentage = htmlentities($_POST['percentage']);
	$productID = htmlentities($_POST['productID']);

	$stocks = new Outlet();
	$stocks->setUpdateOutletStockFull($stocksfull, $percentage, $productID);
}

// //-------------------- DELETE AN ITEM ----------------------
// else if (ISSET($_POST['deleteItem'])) {
//     $productId = htmlentities($_POST['productId']);
//     $itemName = htmlentities($_POST['itemName']);

// 	$delSup = new Outlet();
// 	$delSup->setDeleteItem($productId);

// 	$activity = "Deleted the item: $itemName";
// 	saveUserLogs($activity);
// }

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
    $timezone = date_default_timezone_set('Asia/Manila');
    $dateTimeNow = date("M-d-Y")." ".date("h:i:s a", time());
	$curUser = $_SESSION['currentUser']; // Fullname of current logged in user
    $saveLog = new Activitylogs();
    $saveLog->setNewLog($userId, $curUser, $username, $activity, $dateTimeNow);
}