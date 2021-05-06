<?php

class Outlet extends Database {

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

    public function getAllOutletSupplies(){
        $sql = "SELECT * FROM outletstocks_tbl;";
        $stmt = $this->dbconnect()->query($sql);
        $this->display($stmt);
    }

    public function getLoweringOutletStocks(){
        $sql = "SELECT * FROM outletstocks_tbl WHERE percentage < 50;";
        $stmt = $this->dbconnect()->query($sql);
        $this->display($stmt);
    }

    public function getPendingOutletRestockReqs(){
        $sql = "SELECT * FROM outletrstkrqst_tbl WHERE status='Pending'";
        $stmt = $this->dbconnect()->query($sql);
        $this->display($stmt);
    }

    public function getPendingOutletRestockItems($outletRstkID){
        $sql = "SELECT * FROM outletrstkditem_tbl ori LEFT JOIN warehousestocks_tbl whi ON whi.productID = ori.productID WHERE ori.outletRstkID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$outletRstkID]);
        $this->display($stmt);
    }

    //================================================= SETTERS ============================================

    public function setRestockSupplyInfo($dateRequested, $requestor, $department, $status, $remarks){
        $sql = "INSERT INTO outletrstkrqst_tbl (dateRequested, requestor, department, status, remarks) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$dateRequested, $requestor, $department, $status, $remarks]);

        $lastId = "SELECT outletRstkID FROM outletrstkrqst_tbl ORDER BY outletRstkID DESC;";
        $stmtId = $this->dbconnect()->query($lastId);
        $result = $stmtId->fetch();
        echo $result['outletRstkID'];
    }

    public function setNewRestockSupplyItems($outletRstkID, $productId, $brandname, $productname, $description, $itemName, $quantity, $unit, $unitPrice, $stocksFull, $type, $status){
        $sql = "INSERT INTO outletrstkditem_tbl (outletRstkID, productID, brandname, productname, description, item, quantity, unit, unitPrice, stocksFull, type, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$outletRstkID, $productId, $brandname, $productname, $description, $itemName, $quantity, $unit, $unitPrice, $stocksFull, $type, $status]);
        $this->errorChk($stmt);
    }

    public function setUpdateRestockSupplyInfo($status, $outletRstkID){
        $sql = "UPDATE outletrstkrqst_tbl SET status=? WHERE outletRstkID=?;";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$status, $outletRstkID]);
        $this->errorChk($stmt);
    }

    public function setApproveRestockSupplyItems($status, $outletRstkID){
        $sql = "UPDATE outletrstkditem_tbl SET status=? WHERE outletRstkID=?;";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$status, $outletRstkID]);
        $this->errorChk($stmt);
    }

    public function setUpdateOutletStockFull($stocksfull, $percentage, $productID){
        $sql = "UPDATE outletstocks_tbl SET stocksfull=?, percentage=? WHERE productID=?;";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$stocksfull, $percentage, $productID]);
        $this->errorChk($stmt);
    }

}