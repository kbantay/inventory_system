<?php
session_start(); 	
include '../loader.class.php';

//-------------------- Load all subcategories ------------------
if (ISSET($_POST['loadAllSubcat'])){
	$subcat = new Subcategory();
	$subcat->getAllSubcat();
} 

//-------------------- Load specific subcategory ------------------
else if (ISSET($_POST['loadSpecificSubcat'])){
	$subcategoryID = htmlentities($_POST['subcategoryID']);
	
	$subcat = new Subcategory();
	$subcat->getSpecificSubcat($subcategoryID);
} 

//-------------------- Load Subcategories per Category ------------------
else if (ISSET($_POST['loadPerCategory'])){
	$categoryID = htmlentities($_POST['categoryID']);

	$subcat = new Subcategory();
	$subcat->getSubcatPerCategory($categoryID);
} 

//-------------------- Saving the new subcategory ------------------
else if (ISSET($_POST['saveNewCategory'])) {
	$categoryID = htmlentities($_POST['categoryID']);
    $categoryName = htmlentities($_POST['categoryName']);
    $subcategoryName = htmlentities($_POST['subcategoryName']);
	$subcategoryNotes = htmlentities($_POST['subcategoryNotes']);
	
	$newsubcat = new Subcategory();
	$newsubcat->setNewSubcat($categoryID, $categoryName, $subcategoryName, $subcategoryNotes);

	$activity = "Added a new subcategory: $subcategoryName under the category: $categoryName";
	saveUserLogs($activity);
} 

//-------------------- Update subcategory info ------------------
else if (ISSET($_POST['updateSubcategory'])) {
	$subcategoryID = htmlentities($_POST['subcategoryID']);
    $categoryID = htmlentities($_POST['categoryID']);
    $categoryName = htmlentities($_POST['category']);
    $subcategoryName = htmlentities($_POST['subcategory']);
	$subcategoryNotes = htmlentities($_POST['subcatNotes']);
	
	$updatesubcat = new Subcategory();
	$updatesubcat->setUpdateSubcat($categoryID, $categoryName, $subcategoryName, $subcategoryNotes, $subcategoryID);

	$activity = "Updated the subcategory: $subcategoryName under the category: $categoryName";
	saveUserLogs($activity);
}

//-------------------- Delete a subcategory ------------------
else if (ISSET($_POST['deleteSubcategory'])) {
	$subcategoryID = htmlentities($_POST['subcategoryID']);
    $categoryName = htmlentities($_POST['categoryName']);
    $subcategoryName = htmlentities($_POST['subcategoryName']);

	$delsubcat = new Subcategory();
	$delsubcat->setDeleteSubcat($subcategoryID);
	
	$activity = "Deleted the subcategory: $subcategoryName under the category: $categoryName";
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