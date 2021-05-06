<?php
session_start(); 
include '../loader.class.php';

//------------------------ LOAD ALL ASSETS ---------------------
if(ISSET($_POST['loadAllCategories'])) {
    $cat = new Category();
    $cat->getAllCategories();
}

//--------------- Load specific category ---------------
else if (ISSET($_POST['loadSpecificCategory'])){
	$catID = htmlentities($_POST['catID']);

    $cat = new Category();
    $cat->getSpecificCat($catID);
} 

//--------------- Update Category Info ---------------
else if (ISSET($_POST['updateCategoryInfo'])) {
	$catID = htmlentities($_POST['catID']);
    $catName = htmlentities($_POST['catName']);
    $catNotes = htmlentities($_POST['catNotes']);

    $updateCat = new Category();
    $updateCat->setUpdateCat($catName, $catNotes, $catID);

    $activity = "Updated the category: ".$catName;
    saveUserLogs($activity);
}

//--------------- Save new category ---------------
else if (ISSET($_POST['saveNewCategory'])) {
	$catName = htmlentities($_POST['catName']);
    $catNotes = htmlentities($_POST['catNotes']);

    $newCat = new Category();
    $newCat->setNewCategory($catName, $catNotes);

    $activity = "Added a new category: ". $catName;
    saveUserLogs($activity);

} 

//--------------- Delete category ---------------
else if (ISSET($_POST['deleteCategory'])) {
	$catID = htmlentities($_POST['catID']);
	$catName = htmlentities($_POST['catName']);
    
    $delCat = new Category();
    $delCat->setDeleteCat($catID);

    $activity = "Deleted th category: ".$catName;
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