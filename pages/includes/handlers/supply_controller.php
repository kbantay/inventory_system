<?php
session_start(); 	
include '../loader.class.php';

//------------------------- LOAD ALL SUPPLIERS ----------------------------
if (ISSET($_POST['getAllSupplies'])){
	$supplier = new Supply();
	$supplier->getAllSupplies();
}

//------------------------- LOAD SEARCHED SUPPLY ----------------------------
else if (ISSET($_POST['getSearchedItem'])){
	$searchedItem = htmlentities($_POST['searchedItem']);

	$supply = new Supply();
	$supply->getSearchedItem($searchedItem);
}

//------------------------- LOAD SEARCHED STOCK FROM WAREHOUSE ----------------------------
else if (ISSET($_POST['loadSearchedSupply'])){
	$searchedItem = htmlentities($_POST['searchedItem']);

	$supply = new Supply();
	$supply->getSearchedSupply($searchedItem);
}

//------------------------- LOAD ALL STOCKS ----------------------------
else if (ISSET($_POST['getAllWhStocks'])){
	$stocks = new Supply();
	$stocks->getAllWarehouseStocks();
}

//------------------------- LOAD STOCKS LEFT FROM WAREHOUSE SUPPLY ----------------------------
else if (ISSET($_POST['loadStockLeft'])){
	$productId = htmlentities($_POST['productId']);
	$stocks = new Supply();
	$stocks->getStocksLeft($productId);
}

//------------------------- LOAD LOWERING STOCKS ----------------------------
else if (ISSET($_POST['getLoweringStocks'])){
	$stocks = new Supply();
	$stocks->getLoweringWhStocks();
}

//------------------------- LOAD ALL REQUESTED SUPPLIES INFO ----------------------------
else if (ISSET($_POST['loadRequestedSupplies'])){
	$stocks = new Supply();
	$stocks->getAllRequestedSuppliesInfo();
}

//------------------------- LOAD REQUESTED SUPPLIES PER USER ----------------------------
else if (ISSET($_POST['loadUserRequestedSupplies'])){
	$currentUser = htmlentities($_POST['currentUser']);
	$supplies = new Supply();
	$supplies->getRequestedSuppliesInfoPerUser($currentUser);
}

//------------------------- LOAD REQUESTED SUPPLY ITEMS ----------------------------
else if (ISSET($_POST['loadRequestedSupplyItems'])){
	$rqstSupID = htmlentities($_POST['rqstSupID']);
	$supItem = new Supply();
	$supItem->getRequestedSupplyItems($rqstSupID);
}

//------------------------- LOAD CONSUMED SUPPLIES RECORDS ----------------------------
else if (ISSET($_POST['loadAllConsumedRecords'])){
	$year = date("Y");

	$consRecord = new Supply();
	$consRecord->getAllConsumedRecordInfo($year);
}

//---------------------- LOAD CONSUMED SUPPLIES RECORDS PER DEPARTMENT ------------------------
else if (ISSET($_POST['loadConsumedRecordsPerDepartment'])){
	$department = htmlentities($_POST['department']);
	$year = date("Y");
	$consRecord = new Supply();
	$consRecord->getConsumedRecordPerDept($department, $year);
}

//---------------------- LOAD CONSUMED SUPPLIES RECORDS PER MONTH ------------------------
else if (ISSET($_POST['loadConsumedRecordsPerMonth'])){
	$month = htmlentities($_POST['month']);
	$year = date("Y");
	$consRecord = new Supply();
	$consRecord->getConsumedRecordPerMonth($month, $year);
}

//------------------------- LOAD CONSUMED SUPPLIES RECORDS ----------------------------
else if (ISSET($_POST['loadConsumedRecords'])){
	$dept = htmlentities($_POST['dept']);
	$month = htmlentities($_POST['month']);
	$year = htmlentities($_POST['year']);

	$consRecord = new Supply();
	$consRecord->getConsumedRecordInfo($dept, $month, $year);
}

//------------------------- LOAD LOWERING WAREHOUSE STOCKS ----------------------------
else if (ISSET($_POST['getTotalLoweringWHstocks'])){
	$lowStocks = new Supply();
	$lowStocks->getWHloweringStocks();
}

//------------------------- UPDATE CONSUMED SUPPLIES RECORDS ----------------------------
else if (ISSET($_POST['saveNewConsumedRecord'])){
	$dept = htmlentities($_POST['dept']);
	$totalAmt = htmlentities($_POST['totalAmt']);
	$month = htmlentities($_POST['month']);
	$year = htmlentities($_POST['year']);

	$consRecord = new Supply();
	$consRecord->setNewConsumedRecordInfo($dept, $totalAmt, $month, $year);
}

//------------------------- UPDATE CONSUMED SUPPLIES RECORDS ----------------------------
else if (ISSET($_POST['updateConsumedRecord'])){
	$newTotalAmt = htmlentities($_POST['newTotalAmt']);
	$consrecordID = htmlentities($_POST['consrecordID']);

	$consRecord = new Supply();
	$consRecord->setUpdateConsumedRecordInfo($newTotalAmt, $consrecordID);
}

//------------------------- REGISTER NEW SUPPLY ----------------------------
else if (ISSET($_POST['registerNewItem'])) {
	$brandname = htmlentities($_POST['brandname']);
    $productName = htmlentities($_POST['productName']);
    $description = htmlentities($_POST['description']);
    $amount = htmlentities($_POST['amount']);
    $unit = htmlentities($_POST['unit']);
    $stocksFull = htmlentities($_POST['stocksFull']);
    $type = htmlentities($_POST['type']);
    $itemname = "$productName $productName $description";

	$newSup = new Supply();
	$newSup->setNewSupply($brandname, $productName, $description, $amount, $unit, $stocksFull, $type, $itemname);

	$activity = "Registered a new item: $brandname $productName";
	saveUserLogs($activity);
}

//------------------------- UPDATE SUPPLY'S INFO ----------------------------
else if(ISSET($_POST['updateSupplyInfo'])){
    $productId = htmlentities($_POST['productId']);
    $unitcost = htmlentities($_POST['unitcost']);
    $stocksFull = htmlentities($_POST['stocksFull']);
    $itemName = htmlentities($_POST['itemName']);

	$supply = new Supply();
    $supply->setUpdateSupplyInfo($productId, $unitcost, $stocksFull);
    
    $activity = "Updated an info from: $itemName";
	saveUserLogs($activity);
}

//------------------------- SAVE REQUEST SUPPLY'S INFO ----------------------------
else if(ISSET($_POST['saveRequestedSuppliesInfo'])){
    $employeeName = htmlentities($_POST['employeeName']);
    $department = htmlentities($_POST['department']);
    $totalAmount = htmlentities($_POST['totalAmount']);
    $dateRequested = htmlentities($_POST['dateRequested']);
	$purpose = htmlentities($_POST['purpose']);
	$status = htmlentities($_POST['status']);
	$dateClaimed = htmlentities($_POST['dateClaimed']);
	$month = htmlentities($_POST['month']);
	$year = htmlentities($_POST['year']);
	$quarter = htmlentities($_POST['quarter']);

	$supply = new Supply();
    $supply->setRequestedSupplyInfo($dateRequested, $employeeName, $department, $purpose, $totalAmount, $status, $dateClaimed, $month, $year, $quarter);
    
    $activity = "Encoded a requested supplies of: $employeeName";
	saveUserLogs($activity);
}

//------------------------- SUBMIT REQUESTED SUPPLIES ITEMS FILED BY USER ----------------------------
else if(ISSET($_POST['submitRequestedItems'])){
    $reqSupID = htmlentities($_POST['reqSupID']);
    $productId = htmlentities($_POST['productId']);
    $itemName = htmlentities($_POST['itemName']);
    $quantity = htmlentities($_POST['quantity']);
	$unit = htmlentities($_POST['unit']);
	$unitPrice = htmlentities($_POST['unitPrice']);
	$subtotal = htmlentities($_POST['subtotal']);
	$type = htmlentities($_POST['type']);
	$department = htmlentities($_POST['department']);
	$status = htmlentities($_POST['status']);
	$employeeName = htmlentities($_POST['employeeName']);
	$dateClaimed = "";
	$month = htmlentities($_POST['month']);
	$year = htmlentities($_POST['year']);
	$quarter = htmlentities($_POST['quarter']);

	$supply = new Supply();
    $supply->setRequestedSupplyItems($reqSupID, $productId, $itemName, $quantity, $unit, $unitPrice, $subtotal, $type, $department, $status, $employeeName, $dateClaimed, $month, $year, $quarter);

	$activity = "Submitted a supplies request";
	saveUserLogs($activity);
}

//------------------------- SAVE REQUESTED SUPPLIES ITEMS ----------------------------
else if(ISSET($_POST['saveRequestedItems'])){
    $reqSupID = htmlentities($_POST['reqSupID']);
    $productId = htmlentities($_POST['productId']);
    $itemName = htmlentities($_POST['itemName']);
    $quantity = htmlentities($_POST['quantity']);
	$unit = htmlentities($_POST['unit']);
	$unitPrice = htmlentities($_POST['unitPrice']);
	$subtotal = htmlentities($_POST['subtotal']);
	$type = htmlentities($_POST['type']);
	$department = htmlentities($_POST['department']);
	$status = htmlentities($_POST['status']);
	$employeeName = htmlentities($_POST['employeeName']);
	$dateClaimed = htmlentities($_POST['dateClaimed']);
	$month = htmlentities($_POST['month']);
	$year = htmlentities($_POST['year']);
	$quarter = htmlentities($_POST['quarter']);

	$newStocksLeft = htmlentities($_POST['newStocksLeft']);
	$percentage = htmlentities($_POST['percentage']);

	$supply = new Supply();
    $supply->setRequestedSupplyItems($reqSupID, $productId, $itemName, $quantity, $unit, $unitPrice, $subtotal, $type, $department, $status, $employeeName, $dateClaimed, $month, $year, $quarter);

	$updateStock = new Supply();
	$updateStock->setUpdateNewStocks($productId, $newStocksLeft, $percentage);
}

//----------------------- APPROVE DELIVERY - UPDATE STOCK INVENTORY ----------------------
else if (ISSET($_POST['deliveryUpdateStocks'])) {
	$stocksLeft = htmlentities($_POST['stocksLeft']);
	$percentage = htmlentities($_POST['percentage']);
	$productId = htmlentities($_POST['productId']);

	$updateStock = new Supply();
	$updateStock->setDeliveryUpdateStock($stocksLeft, $percentage, $productId);
}

//--------------------------- APPROVE DELIVERY - NEW STOCK ENTRY ----------------------------
else if(ISSET($_POST['deliverySaveNewStocks'])){
    $productId = htmlentities($_POST['productId']);
    $brandname = htmlentities($_POST['brandname']);
	$productname = htmlentities($_POST['productname']);
	$description = htmlentities($_POST['description']);
	$unit = htmlentities($_POST['unit']);
	$unitPrice = htmlentities($_POST['unitPrice']);
	$stocksFull = htmlentities($_POST['stocksFull']);
	$stocksLeft = htmlentities($_POST['stocksLeft']);
	$percentage = htmlentities($_POST['percentage']);

	$newStock = new Supply();
    $newStock->setDeliveryNewStock($brandname, $productname, $description, $unitPrice, $unit, $stocksFull, $stocksLeft, $percentage, $productId);
}


//----------------------- APPROVE: UPDATE REQUESTED SUPPLY INFO ----------------------
else if (ISSET($_POST['updateRequestedSupplyInfo'])) {
	$rqstSupID = htmlentities($_POST['rqstSupID']);
	$status = htmlentities($_POST['status']);
	$dateClaimed = htmlentities($_POST['dateClaimed']);

	$updateRqstSupply = new Supply();
	$updateRqstSupply->setUpdateRequestedSupplyInfo($rqstSupID, $status, $dateClaimed);
}

//----------------------- APPROVE: UPDATE REQUESTED SUPPLY ITEMS ----------------------
else if (ISSET($_POST['updateRequestedItems'])) {
	$rqstSupID = htmlentities($_POST['rqstSupID']);
	$status = htmlentities($_POST['status']);
	$dateClaimed = htmlentities($_POST['dateClaimed']);

	$updateRqstSupply = new Supply();
	$updateRqstSupply->setUpdateRequestedItems($rqstSupID, $status, $dateClaimed);

	$productId = htmlentities($_POST['productId']);
	$newStocksLeft = htmlentities($_POST['newStocksLeft']);
	$percentage = htmlentities($_POST['percentage']);

	$updateStocks = new Supply();
	$updateStocks->setUpdateOutletStocks($productId, $newStocksLeft, $percentage);
}

//------------------------- DELETE THE CURRENT USER SUPPLIES REQUEST ----------------------------
else if (ISSET($_POST['cancelRequestedSupply'])) {
    $rqstSupID = htmlentities($_POST['rqstSupID']);

	$delSup = new Supply();
	$delSup->setDeleteRequestedSupplies($rqstSupID);
	
	$delItems = new Supply();
	$delItems->setDeleteRequestedItems($rqstSupID);

	$activity = "Cancelled a supplies request";
	saveUserLogs($activity);
}


//------------------------- DELETE AN ITEM ----------------------------
else if (ISSET($_POST['deleteItem'])) {
    $productId = htmlentities($_POST['productId']);
    $itemName = htmlentities($_POST['itemName']);

	$delSup = new Supply();
	$delSup->setDeleteItem($productId);

	$activity = "Deleted the item: $itemName";
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
    $timezone = date_default_timezone_set('Asia/Manila');
    $dateTimeNow = date("M-d-Y")." ".date("h:i:s a", time());
	$curUser = $_SESSION['currentUser']; // Fullname of current logged in user
    $saveLog = new Activitylogs();
    $saveLog->setNewLog($userId, $curUser, $username, $activity, $dateTimeNow);
}