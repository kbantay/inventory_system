<?php

class Supply extends Database {

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

    public function getAllSupplies(){
        $sql = "SELECT * FROM supplies_tbl;";
        $stmt = $this->dbconnect()->query($sql);
        $this->display($stmt);
    }

    public function getAllWarehouseStocks(){
        $sql = "SELECT * FROM warehousestocks_tbl;";
        $stmt = $this->dbconnect()->query($sql);
        $this->display($stmt);
    }

    public function getStocksLeft($productId){
        $sql = "SELECT stocksleft FROM warehousestocks_tbl WHERE productID=?;";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$productId]);
        $result = $stmt->fetch();
        echo $result['stocksleft'];
    }

    public function getLoweringWhStocks(){
        $sql = "SELECT * FROM warehousestocks_tbl WHERE percentage < 50;";
        $stmt = $this->dbconnect()->query($sql);
        $this->display($stmt);
    }

    public function getWHloweringStocks(){
        $sql = "SELECT * FROM warehousestocks_tbl WHERE percentage < 50;";
        $stmt = $this->dbconnect()->query($sql);
        echo $stmt->rowCount();
    }

    public function getAllRequestedSuppliesInfo(){
        $sql = "SELECT * FROM suppliesrqst_tbl WHERE rqstStats='Pending';";
        $stmt = $this->dbconnect()->query($sql);
        $this->display($stmt);
    }

    public function getRequestedSuppliesInfoPerUser($currentUser){
        $sql = "SELECT * FROM suppliesrqst_tbl WHERE requestor=? AND rqstStats='Pending';";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$currentUser]);
        $this->display($stmt);
    }

    public function getSearchedItem($searchedItem){
        $sql = "SELECT * FROM supplies_tbl WHERE brandname LIKE CONCAT('%', ?, '%') OR productname LIKE CONCAT('%', ?, '%') OR description LIKE CONCAT('%', ?, '%');";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$searchedItem, $searchedItem, $searchedItem]);
        $this->display($stmt);
    }


    public function getRequestedSupplyItems($rqstSupID){
        $sql = "SELECT * FROM rqstditem_tbl rq INNER JOIN outletstocks_tbl os ON os.productID = rq.productID WHERE rq.rqstSupID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$rqstSupID]);
        $this->display($stmt);
    }


    public function getSearchedSupply($searchedItem){
        $sql = "SELECT * FROM warehousestocks_tbl WHERE brandname LIKE CONCAT('%', ?, '%') OR productname LIKE CONCAT('%', ?, '%') OR description LIKE CONCAT('%', ?, '%');";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$searchedItem, $searchedItem, $searchedItem]);
        $this->display($stmt);
    }

    public function getAllConsumedRecordInfo($year){
        $sql = "SELECT * FROM consumption_tbl WHERE year=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$year]);
        $this->display($stmt);
    }

    public function getConsumedRecordInfo($dept, $month, $year){
        $sql = "SELECT * FROM consumption_tbl WHERE department=? AND month=? AND year=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$dept, $month, $year]);
        $this->display($stmt);
    }

    public function getConsumedRecordPerDept($department, $year){
        $sql = "SELECT * FROM consumption_tbl WHERE department=? AND year=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$department, $year]);
        $this->display($stmt);
    }

    public function getConsumedRecordPerMonth($month, $year){
        $sql = "SELECT * FROM consumption_tbl WHERE month=? AND year=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$month, $year]);
        $this->display($stmt);
    }

    //-----------------------------

    public function setNewSupply($brandname, $productName, $description, $amount, $unit, $stocksFull, $type, $itemname){
        $sql = "INSERT INTO supplies_tbl (brandname, productname, description, unitcost, unit, stocksFull, type, itemname) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$brandname, $productName, $description, $amount, $unit, $stocksFull, $type, $itemname]);
    }

    public function setUpdateSupplyInfo($productId, $unitcost, $stocksFull){
        $sql = "UPDATE supplies_tbl SET unitcost=?, stocksFull=? WHERE productId=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$unitcost, $stocksFull, $productId]);
    }

    public function setNewConsumedRecordInfo($dept, $totalAmt, $month, $year){
        $sql = "INSERT INTO consumption_tbl (department, totalamount, month, year) VALUES (?, ?, ?, ?);";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$dept, $totalAmt, $month, $year]);
    }

    public function setUpdateConsumedRecordInfo($newTotalAmt, $consrecordID){
        $sql = "UPDATE consumption_tbl SET totalamount=? WHERE consrecordID=?;";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$newTotalAmt, $consrecordID]);
    }

    public function setDeliveryNewStock($brandname, $productname, $description, $unitPrice, $unit, $stocksFull, $stocksLeft, $percentage, $productId){
        $sql = "INSERT INTO warehousestocks_tbl (brandname, productname, description, unitcost, unit, stocksfull, stocksleft, percentage, productID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$brandname, $productname, $description, $unitPrice, $unit, $stocksFull, $stocksLeft, $percentage, $productId]);
    }

    public function setDeliveryUpdateStock($stocksLeft, $percentage, $productId){
        $sql = "UPDATE warehousestocks_tbl SET stocksleft=?, percentage=? WHERE productID=?;";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$stocksLeft, $percentage, $productId]);
    }


    public function setDeleteItem($productId){
        $sql = "DELETE FROM supplies_tbl WHERE productID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$productId]);
    }
    
    public function setDeleteRequestedSupplies($rqstSupID){
        $sql = "DELETE FROM suppliesrqst_tbl WHERE rqstSupID=?;";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$rqstSupID]);
    }
    public function setDeleteRequestedItems($rqstSupID){
        $sql = "DELETE FROM rqstditem_tbl WHERE rqstSupID=?;";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$rqstSupID]);
        $this->errorChk($stmt);
    }

    public function setRequestedSupplyInfo($dateRequested, $employeeName, $department, $purpose, $totalAmount, $status, $dateClaimed, $month, $year, $quarter){
        $sql = "INSERT INTO suppliesrqst_tbl (dateRequested, requestor, department, purpose, monthOf, year, rqstStats, claimedby, dateclaimed, totalamount, quarter) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$dateRequested, $employeeName, $department, $purpose, $month, $year, $status, $employeeName, $dateClaimed, $totalAmount, $quarter]);

        $lastId = "SELECT rqstSupID FROM suppliesrqst_tbl ORDER BY rqstSupID DESC;";
        $stmtId = $this->dbconnect()->query($lastId);
        $result = $stmtId->fetch();
        echo $result['rqstSupID'];
    }

    public function setRequestedSupplyItems($reqSupID, $productId, $itemName, $quantity, $unit, $unitPrice, $subtotal, $type, $department, $status, $employeeName, $dateClaimed, $month, $year, $quarter){
        $sql = "INSERT INTO rqstditem_tbl (rqstSupID, productID, item, quantity, unit, unitPrice, subAmount, type, department, status, claimedby, dateclaimed, monthOf, year, quarter) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$reqSupID, $productId, $itemName, $quantity, $unit, $unitPrice, $subtotal, $type, $department, $status, $employeeName, $dateClaimed, $month, $year, $quarter]);
        $this->errorChk($stmt);
    }

    public function setUpdateNewStocks($productId, $newStocksLeft, $percentage){
        $sql = "UPDATE warehousestocks_tbl SET stocksleft=?, percentage=? WHERE productID=?;";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$newStocksLeft, $percentage, $productId]);
    }

    public function setUpdateRequestedSupplyInfo($rqstSupID, $status, $dateClaimed){
        $sql = "UPDATE suppliesrqst_tbl SET rqstStats=?, dateclaimed=? WHERE rqstSupID=?;";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$status, $dateClaimed, $rqstSupID]);
        $this->errorChk($stmt);
    }

    public function setUpdateRequestedItems($rqstSupID, $status, $dateClaimed){
        $sql = "UPDATE rqstditem_tbl SET status=?, dateclaimed=? WHERE rqstSupID=?;";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$status, $dateClaimed, $rqstSupID]);
        $this->errorChk($stmt);
    }

    public function setUpdateOutletStocks($productId, $newStocksLeft, $percentage){
        $sql = "UPDATE outletstocks_tbl SET stocksleft=?, percentage=? WHERE productID=?;";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$newStocksLeft, $percentage, $productId]);
    }

}