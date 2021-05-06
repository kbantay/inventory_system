<?php

class Delivery extends Database {

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

    public function getEncodedDelivery(){
        $sql = "SELECT * FROM deliveredsupplies_tbl WHERE status='Pending';";
        $stmt = $this->dbconnect()->query($sql);
        $this->display($stmt);
    }

    public function getDeliveryItems($dlvrdSupID){
        $sql = "SELECT * FROM delivereditem_tbl WHERE dlvrdSupID=?;";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$dlvrdSupID]);
        $this->display($stmt);
    }

    public function getApprovedDeliveries(){
        $sql = "SELECT * FROM deliveredsupplies_tbl WHERE status='Approved';";
        $stmt = $this->dbconnect()->query($sql);
        $this->display($stmt);
    }

    public function getTotalPendingDelivery(){
        $sql = "SELECT * FROM deliveredsupplies_tbl WHERE status='Pending';";
        $stmt = $this->dbconnect()->query($sql);
        echo $stmt->rowCount();
    }

    public function getCurrentStocksInfo($productId){
        $sql = "SELECT itemID,stocksfull,stocksleft,productID FROM warehousestocks_tbl WHERE productID=?;";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$productId]);
        $this->display($stmt);
    }

    //-----------------------------------

    public function setUpdateDeliveredSupplies($dlvrdSupID){
        $sql = "UPDATE deliveredsupplies_tbl SET status='Approved' WHERE dlvrdSupID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$dlvrdSupID]);
        $this->errorChk($stmt);
    }

    public function setNewDeliveryInfo($supplier, $invoiceNum, $totalAmount, $dateDelivered, $remarks, $status){
        $sql = "INSERT INTO deliveredsupplies_tbl (datedlvrd, suppliername, invoicenum, totalAmount, status, remarks) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$dateDelivered, $supplier, $invoiceNum, $totalAmount, $status, $remarks]);

        $lastId = "SELECT dlvrdSupID FROM deliveredsupplies_tbl ORDER BY dlvrdSupID DESC;";
        $stmtId = $this->dbconnect()->query($lastId);
        $result = $stmtId->fetch();
        echo $result['dlvrdSupID'];
    }

    public function setDeliveryItems($delSuppId, $productId, $brandname, $productname, $description, $quantity, $unit, $unitPrice, $subtotal, $stocksFull){
        $sql = "INSERT INTO delivereditem_tbl (dlvrdSupID, productID, brandname, productname, description, quantity, unit, unitPrice, subAmount, stocksFull) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$delSuppId, $productId, $brandname, $productname, $description, $quantity, $unit, $unitPrice, $subtotal, $stocksFull]);
    }


}