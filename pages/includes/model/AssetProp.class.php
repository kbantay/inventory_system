<?php

class AssetProp extends Database{

    function display($stmt){
        $result = array();
        while ($row = $stmt->fetchAll()) {
            $result = $row;
            header('Content-type: application/json');
            echo json_encode($result);
        }
    }

    function errorChk($stmt){
        if($stmt->errorCode() == 0) {
            $result = "1";
        } else {
            $error = $stmt->errorInfo();
            $result = $error[2];
        }
        print_r($result);
    }


    public function getAllAssets(){
        $sql = "SELECT * FROM assets_tbl WHERE status='active'";
        $stmt = $this->dbconnect()->query($sql);
        $this->display($stmt);
    }

    public function getAssetsPerCategory($category){
        $sql = "SELECT * FROM assets_tbl WHERE classification=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$category]);
        $this->display($stmt);
    }

    public function getAssetsPerLocation($location){
        $sql = "SELECT * FROM assets_tbl WHERE location=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$location]);
        $this->display($stmt);
    }

    public function getSpecificAsset($itemID){
        $sql = "SELECT * FROM assets_tbl WHERE itemID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$itemID]);
        $this->display($stmt);
    }

    public function getItemID(){
        $sql = "SELECT * FROM assets_tbl ORDER BY itemID DESC";
        $stmt = $this->dbconnect()->query($sql);
        $row = $stmt->fetch();
        $curID = $row['itemID'];
        echo $curID+1;
    }

    public function getTotalAssetCount(){
        $sql = "SELECT * FROM assets_tbl WHERE status='active'";
        $stmt = $this->dbconnect()->query($sql);
        echo $stmt->rowCount();
    }

    public function getTotalAssetCost(){
        $sql = "SELECT unitcost FROM assets_tbl WHERE status='active'";
        $stmt = $this->dbconnect()->query($sql);
        $qty= 0;
        while ($row = $stmt->fetch()) {
            $num = $row['unitcost'];
            $amt = floatval($num);
            $qty += $amt;
        }
        echo number_format($qty, 2, '.', ',');
    }

    public function getAssetLocations(){
        $sql = "SELECT * FROM assetlocation_tbl ORDER BY location ASC";
        $stmt = $this->dbconnect()->query($sql);
        $this->display($stmt);
    }

    public function getAssetsOnLocation($location){
        $sql = "SELECT * FROM assets_tbl WHERE location=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$location]);
        $this->display($stmt);
    }

    public function getRecentlyAddedAsset(){
        $sql = "SELECT * FROM assets_tbl ORDER BY itemID DESC LIMIT 30";
        $stmt = $this->dbconnect()->query($sql);
        $this->display($stmt);
    }

    public function getSearchedAsset($searchedItem){
        $sql = "SELECT * FROM assets_tbl WHERE brandmodel LIKE CONCAT('%', ?, '%') OR category LIKE CONCAT('%', ?, '%') OR description LIKE CONCAT('%', ?, '%') OR location LIKE CONCAT('%', ?, '%');";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$searchedItem, $searchedItem, $searchedItem, $searchedItem]);
        $this->display($stmt);
    }

    public function getSearchedActiveAsset($searchedItem){
        $sql = "SELECT * FROM assets_tbl WHERE (brandmodel LIKE CONCAT('%', ?, '%') OR category LIKE CONCAT('%', ?, '%') OR description LIKE CONCAT('%', ?, '%') OR location LIKE CONCAT('%', ?, '%')) AND status='active';";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$searchedItem, $searchedItem, $searchedItem, $searchedItem]);
        $this->display($stmt);
    }

    public function getDateAcquired($itemID){
        $sql = "SELECT * FROM assets_tbl where itemID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$itemID]);
        $result = $stmt->fetch();
        echo $result['dateacquired'];
    }

    public function getAssetHistory($itemID){
        $sql = "SELECT * FROM assethistory_tbl WHERE itemID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$itemID]);
        $this->display($stmt);
    }

    public function getCheckAssetLocationExistence($location){
        $sql = "SELECT assetLocID, location, numOfItems FROM assetlocation_tbl WHERE location=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$location]);
        $this->display($stmt);
    }

    public function getTotalAssetCountLocation($location){
        $sql = "SELECT * FROM assets_tbl WHERE location=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$location]);
        echo $stmt->rowCount();
    }

    public function getDisposedAssets(){
        $sql = "SELECT * FROM assets_tbl WHERE status='disposed'";
        $stmt = $this->dbconnect()->query($sql);
        $this->display($stmt);
    }

    //===================================== SETTERS =======================================

    public function setUpdateLifeYears($lifeInYears, $itemID){
        $sql = "UPDATE assets_tbl SET lifeinyears=? WHERE itemID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$lifeInYears, $itemID]);
    }

    public function setNewAssetHistory($itemID, $newActivity, $activityDate, $curUser, $dateTimeNow){
        $sql = "INSERT INTO assethistory_tbl (itemID, report, activitydate, updatedby, dateupdated) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$itemID, $newActivity, $activityDate, $curUser, $dateTimeNow]);
    }

    public function setNewAsset($dateAcquired, $category, $brandModel, $description, $quantity, $location, $personInCharge, $department, $serialNumber, $referenceNum, $unitCost, $supplier, $tagNum, $remarks, $curUser, $dateTimeNow, $status, $classification){
        $sql = "INSERT INTO assets_tbl (dateAcquired, category, brandmodel, description, quantity, location, personincharge, department, serialnum, reference, unitcost, supplier, tagnum, remarks, lastedit, dateupdated, status, classification) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$dateAcquired, $category, $brandModel, $description, $quantity, $location, $personInCharge, $department, $serialNumber, $referenceNum, $unitCost, $supplier, $tagNum, $remarks, $curUser, $dateTimeNow, $status, $classification]);
    }

    public function setDisposeAsset($delReasonMdl, $status, $delType, $disposedDateMdl, $itemid){
        $sql = "UPDATE assets_tbl SET remarks=?, status=?, disposetype=?, datedisposed=?  WHERE itemID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$delReasonMdl, $status, $delType, $disposedDateMdl, $itemid]);
    }

    public function setUpdateTotalAssetCountLocation($totalAssets, $assetLocID) {
        $sql = "UPDATE assetlocation_tbl SET numOfItems=? WHERE assetLocID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$totalAssets, $assetLocID]);
    }

    public function setNewLocationItemsCount($location, $numOfItems, $lastUpdated){
        $sql = "INSERT INTO assetlocation_tbl (location, numOfItems, lastUpdated) VALUES (?, ?, ?)";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$location, $numOfItems, $lastUpdated]);
    }

    public function setUpdateAssetDetails($itemID, $category, $serialnum, $brandmodel, $description, $quantity, $amount, $purchasedDate, $classification, $supplier, $location, $personInCharge, $remarks){
        $sql = "UPDATE assets_tbl SET dateacquired=?, category=?, brandmodel=?, description=?, quantity=?, location=?, personincharge=?, serialnum=?, unitcost=?, supplier=?, remarks=?, classification=? WHERE itemID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$purchasedDate, $category, $brandmodel, $description, $quantity, $location, $personInCharge, $serialnum, $amount, $supplier, $remarks, $classification, $itemID]);
    }

    public function setUpdateTotalAssetLocation($location, $totalCount){
        $sql = "UPDATE assetlocation_tbl SET numOfItems=? WHERE location=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$totalCount, $location]);
    }

}