<?php
session_start(); 	
include '../loader.class.php';

//------------------------- LOAD ALL PENDING ENCODED DELIVERY ----------------------------

if (ISSET($_POST['loadEncodedDelivery'])){
	$supplier = new Delivery();
	$supplier->getEncodedDelivery();
}

//------------------------- LOAD APPROVED DELIVERIES ----------------------------
else if (ISSET($_POST['loadApprovedDeliveries'])){
	$supplier = new Delivery();
	$supplier->getApprovedDeliveries();
}

//------------------------- LOAD PENDING DELIVERIES ----------------------------
else if (ISSET($_POST['getTotalPendingDeliveries'])){
	$supplier = new Delivery();
	$supplier->getTotalPendingDelivery();
}



//----------------------- ENCODE DELIVERY - DELIVERY INFORMARTION ----------------------

else if (ISSET($_POST['saveDeliveryInfo'])) {
	$supplier = htmlentities($_POST['supplier']);
    $invoiceNum = htmlentities($_POST['invoiceNum']);
	$dateDelivered = htmlentities($_POST['dateDelivered']);
	$totalAmount = htmlentities($_POST['totalAmount']);
    $remarks = htmlentities($_POST['remarks']);
    $status = "Pending";

	$encDel = new Delivery();
	$encDel->setNewDeliveryInfo($supplier, $invoiceNum, $totalAmount, $dateDelivered, $remarks, $status);


	$email = htmlentities($_POST['email']);
    $subject = htmlentities($_POST['subject']);
	$message = htmlentities($_POST['message']);

	$emailnotif = new Emailsender();
	$emailnotif->sendemail($email, $subject, $message);

	$activity = "Encoded a new delivery from: $supplier";
	saveUserLogs($activity);

}



//----------------------- LOAD PENDING DELIVERY ITEMS ----------------------

else if (ISSET($_POST['loadDeliveredItems'])) {

	$dlvrdSupID = htmlentities($_POST['dlvrdSupID']);



	$encDel = new Delivery();

	$encDel->getDeliveryItems($dlvrdSupID);

}



//--------------------------- ENCODE DELIVERY - DELIVERY ITEMS ----------------------------

else if(ISSET($_POST['saveDeliveryItems'])){

    $productId = htmlentities($_POST['productId']);

    $delSuppId = htmlentities($_POST['delSuppId']);

    $brandname = htmlentities($_POST['brandname']);

	$productname = htmlentities($_POST['productname']);

	$description = htmlentities($_POST['description']);

	$quantity = htmlentities($_POST['quantity']);

	$unit = htmlentities($_POST['unit']);

	$unitPrice = htmlentities($_POST['unitPrice']);

	$subtotal = htmlentities($_POST['subtotal']);

	$stocksFull = htmlentities($_POST['stocksFull']);



	$supply = new Delivery();

    $supply->setDeliveryItems($delSuppId, $productId, $brandname, $productname, $description, $quantity, $unit, $unitPrice, $subtotal, $stocksFull);

    

    $activity = "Encoded delivery items";

	saveUserLogs($activity);

}





//------------------------- GET CURRENT STOCKS INFO OF AN ITEM ----------------------------

else if (ISSET($_POST['loadStocksInfo'])) {

	$productId = htmlentities($_POST['productId']);



	$getStock = new Delivery();

	$getStock->getCurrentStocksInfo($productId);

	//print_r($getStock);

}



//------------------------- UPDATE DELIVERED SUPPLIES UPON APPROVAL ----------------------------

else if (ISSET($_POST['updateDeliveredSup'])) {

	$dlvrdSupID = htmlentities($_POST['dlvrdSupID']);

	$supplierName = htmlentities($_POST['supplierName']);



	$update = new Delivery();

	$update->setUpdateDeliveredSupplies($dlvrdSupID);



	$activity = "Approved the delivered items from $supplierName";

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