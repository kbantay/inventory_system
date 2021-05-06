<?php
session_start(); 
include '../loader.class.php';

//------------------------ LOAD ALL ASSETS ---------------------loadAssetCategory
if(ISSET($_POST['loadAllAssets'])) {
    $asset = new AssetProp();
    $asset->getAllAssets();
}

//------------------------ LOAD ASSETS PER CATEGORY---------------------
elseif(ISSET($_POST['loadAssetCategory'])) {
    $category = htmlentities($_POST['category']);
    $asset = new AssetProp();
    $asset->getAssetsPerCategory($category);
}

//----------------- LOAD SPECIFIC ASSET ----------------
elseif (ISSET($_POST['assetLoadSpecific'])) {
    $itemID = htmlentities($_POST['itemID']);
    $asset = new AssetProp();
    $asset->getSpecificAsset($itemID);
}

//----------------- LOAD SPECIFIC ASSET PER LOCATION ----------------
elseif (ISSET($_POST['loadAllAssetsPerLocation'])) {
    $location = htmlentities($_POST['location']);
    $asset = new AssetProp();
    $asset->getAssetsPerLocation($location);
}

//----------------- LOAD SEARCHED ASSET ----------------
elseif (ISSET($_POST['loadSearchAsset'])) {
    $searchedItem = htmlentities($_POST['searchedItem']);
    $asset = new AssetProp();
    $asset->getSearchedAsset($searchedItem);
}

//----------------- LOAD SEARCHED ACTIVE ASSET ----------------
elseif (ISSET($_POST['loadSearchActiveAsset'])) {
    $searchedItem = htmlentities($_POST['searchedItem']);
    $asset = new AssetProp();
    $asset->getSearchedActiveAsset($searchedItem);
}

//----------------- LOAD HISTORY DETAILS ----------------
elseif (ISSET($_POST['loadAssetHistory'])) {
    $itemID = htmlentities($_POST['itemID']);
    $assetHistory = new AssetProp();
    $assetHistory->getAssetHistory($itemID);
}

//----------------- LOAD RECENTLY ADDED ASSET ----------------
elseif (ISSET($_POST['loadRecentlyAdded'])) {
    $asset = new AssetProp();
    $asset->getRecentlyAddedAsset();
}

//----------------- LOAD ASSET DATE ACQUIRED ----------------
elseif (ISSET($_POST['loadDateAcquired'])) {
    $itemID = htmlentities($_POST['itemID']);
    $asset = new AssetProp();
    $asset->getDateAcquired($itemID);
}

//------------------------ LOAD ASSET LOCATIONS ---------------------
elseif(ISSET($_POST['loadLocations'])) {
    $asset = new AssetProp();
    $asset->getAssetLocations();
}

//------------------------ LOAD ASSETS LIST ON LOCATION ---------------------
elseif(ISSET($_POST['loadAssetsLocation'])) {
    $location = htmlentities($_POST['location']);
    $asset = new AssetProp();
    $asset->getAssetsOnLocation($location);
}

//------------------------ LOAD ROOM'S INFO ---------------------
else if(ISSET($_POST['totalNumAssetLoc'])) {
    $location = htmlentities($_POST['location']);
    $totalAssets = new AssetProp();
    $totalAssets->getTotalAssetCountLocation($location);
}

//------------------------ LOAD ROOM'S INFO ---------------------
else if(ISSET($_POST['updateTotalNumAssetLoc'])) {
    $totalAssets = htmlentities($_POST['totalAssets']);
    $assetLocID = htmlentities($_POST['assetLocID']);
    
    $updateAssets = new AssetProp();
    $updateAssets->setUpdateTotalAssetCountLocation($totalAssets, $assetLocID);
}

//------------------------ LOAD ROOM'S INFO ---------------------
else if(ISSET($_POST['saveNewLocationItemsCount'])) {
    $location = htmlentities($_POST['location']);
    $numOfItems = htmlentities($_POST['numOfItems']);
    $lastUpdated = htmlentities($_POST['lastUpdated']);

    $updateAssets = new AssetProp();
    $updateAssets->setNewLocationItemsCount($location, $numOfItems, $lastUpdated);
}

//------------------------ LOAD ROOM'S INFO ---------------------
else if(ISSET($_POST['checkAssetLocationExistence'])) {
    $location = htmlentities($_POST['location']);

    $updateAssets = new AssetProp();
    $updateAssets->getCheckAssetLocationExistence($location);
}

//----------------- ASSET ITEM ID IDENTIFIER ----------------
elseif (ISSET($_POST['assetIDidentifier'])) {
    $assetid = new AssetProp();
    $assetid->getItemID();
}

//----------------- GET TOTAL ASSET COUNT ----------------
elseif (ISSET($_POST['getTotalAssetCount'])) {
    $assetCnt = new AssetProp();
    $assetCnt->getTotalAssetCount();
}

//----------------- GET TOTAL ASSET COST ----------------
elseif (ISSET($_POST['getTotalAssetCost'])) {
    $assetCost = new AssetProp();
    $assetCost->getTotalAssetCost();
}

//----------------- GET DISPOSED ASSETS ----------------
elseif (ISSET($_POST['loadDisposedItems'])) {
    $assetCost = new AssetProp();
    $assetCost->getDisposedAssets();
}

//----------------- UDPATE ASSET DETAILS DETAILS ----------------
elseif (ISSET($_POST['updateAssetTotalLocation'])) {
    $location = htmlentities($_POST['location']);
    $totalCount = htmlentities($_POST['totalCount']);

    $updateAsset = new AssetProp();
    $updateAsset->setUpdateTotalAssetLocation($location, $totalCount);
}


//----------------- UDPATE ASSET DETAILS DETAILS ----------------
elseif (ISSET($_POST['updateAssetDetails'])) {
    $itemID = htmlentities($_POST['itemID']);
    $category = htmlentities($_POST['category']);
    $serialnum = htmlentities($_POST['serialnum']);
    $brandmodel = htmlentities($_POST['brandmodel']);
    $description = htmlentities($_POST['description']);
    $quantity = htmlentities($_POST['quantity']);
    $amount = htmlentities($_POST['amount']);
    $purchasedDate = htmlentities($_POST['purchasedDate']);
    $classification = htmlentities($_POST['classification']);
    $supplier = htmlentities($_POST['supplier']);
    $location = htmlentities($_POST['location']);
    $personInCharge = htmlentities($_POST['personInCharge']);
    $remarks = htmlentities($_POST['remarks']);

    $updateAsset = new AssetProp();
    $updateAsset->setUpdateAssetDetails($itemID, $category, $serialnum, $brandmodel, $description, $quantity, $amount, $purchasedDate, $classification, $supplier, $location, $personInCharge, $remarks);
}

//----------- UPDATE ASSET LIFE IN YEARS PER VIEW ------------
elseif (ISSET($_POST['updateLifeYears'])) {
    $itemID = htmlentities($_POST['itemID']);
    $lifeInYears = htmlentities($_POST['lifeInYears']);

    $assetAge = new AssetProp();
    $assetAge->setUpdateLifeYears($lifeInYears, $itemID);
}

//----------- SAVE NEW ASSET ------------
elseif (ISSET($_POST['saveNewAsset'])) {
    $dateAcquired = htmlentities($_POST['dateAcquired']);
    $classification = htmlentities($_POST['classification']);
    $category = htmlentities($_POST['category']);
    $brandModel = htmlentities($_POST['brandModel']);
    $description = htmlentities($_POST['description']);
    $quantity = htmlentities($_POST['quantity']);
    $location = htmlentities($_POST['location']);
    $personInCharge = htmlentities($_POST['personInCharge']);
    $department = htmlentities($_POST['department']);
    $serialNumber = htmlentities($_POST['serialNumber']);
    $referenceNum = htmlentities($_POST['referenceNum']);
    $unitCost = htmlentities($_POST['unitCost']);
    $supplier = htmlentities($_POST['supplier']);
    $tagNum = htmlentities($_POST['tagNum']);
    $remarks = htmlentities($_POST['remarks']);
    $dateUpdated = htmlentities($_POST['dateUpdated']);
    $status = htmlentities($_POST['status']);
    $timezone = date_default_timezone_set('Asia/Manila');
    $dateTimeNow = date("M-d-Y")." ".date("h:i:s a", time());
    $curUser = $_SESSION['currentUser'];

    $newAsset = new AssetProp();
    $newAsset->setNewAsset($dateAcquired, $category, $brandModel, $description, $quantity, $location, $personInCharge, $department, $serialNumber, $referenceNum, $unitCost, $supplier, $tagNum, $remarks, $curUser, $dateTimeNow, $status, $classification);

    $activity = "A new asset has been added: $brandModel";
    saveUserLogs($activity);
}

//----------------- SAVE ASSET HISTORY ----------------
elseif (ISSET($_POST['saveHistory'])) {
    $itemID = htmlentities($_POST['itemID']);
    $brandmodel = htmlentities($_POST['brandmodel']);
    $newActivity = htmlentities($_POST['newActivity']);
    $activityDate = htmlentities($_POST['activityDate']);
    $timezone = date_default_timezone_set('Asia/Manila');
    $dateTimeNow = date("M-d-Y")." ".date("h:i:s a", time());
    $curUser = $_SESSION['currentUser'];

    $newHistory = new AssetProp();
    $newHistory->setNewAssetHistory($itemID, $newActivity, $activityDate, $curUser, $dateTimeNow);

    $activity = "New activity has been made to: $brandmodel";
    saveUserLogs($activity);
}

//----------------- DISPOSE AN ASSET ----------------
elseif (ISSET($_POST['disposeAsset'])) {
    $itemid = htmlentities($_POST['itemid']);
    $brandmodel = htmlentities($_POST['brandmodel']);
    $status = "disposed";
    $disposedDateMdl = htmlentities($_POST['disposedDateMdl']);
    $delType = htmlentities($_POST['delType']);
    $delReasonMdl = htmlentities($_POST['delReasonMdl']);

    $dispose = new AssetProp();
    $dispose->setDisposeAsset($delReasonMdl, $status, $delType, $disposedDateMdl, $itemid);

    $activity = "Disposed an asset: $brandmodel";
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