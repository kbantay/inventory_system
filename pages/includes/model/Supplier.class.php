<?php

class Supplier extends Database {

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

    public function getAllSupplier(){
        $sql = "SELECT * FROM supplier_tbl ORDER BY supplierName ASC;";
        $stmt = $this->dbconnect()->query($sql);
        $this->display($stmt);
    }

    public function getConsSupplier(){
        $sql = "SELECT * FROM supplier_tbl WHERE suppType='Supplies' ORDER BY supplierName ASC;";
        $stmt = $this->dbconnect()->query($sql);
        $this->display($stmt);
    }

    public function getSpecificSupplier($supplierId){
        $sql = "SELECT * FROM supplier_tbl WHERE supplierId=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$supplierId]);
        $this->display($stmt);
    }

    //---------------------------

    public function setNewSupplier($supplierName, $supAddress, $supContactNum, $supType){
        $sql = "INSERT INTO supplier_tbl (supplierName, suppAddress, suppContactNum, suppType) VALUES (?, ?, ?, ?)";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$supplierName, $supAddress, $supContactNum, $supType]);
    }

    public function setUpdateSupplier($supplierName, $suppAddress, $suppContactNum, $suppType, $supplierId){
        $sql = "UPDATE supplier_tbl SET supplierName=?, suppAddress=?, suppContactNum=?, suppType=? WHERE supplierId=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$supplierName, $suppAddress, $suppContactNum, $suppType, $supplierId]);
    }

    public function setDeleteSupplier($supplierId){
        $sql = "DELETE FROM supplier_tbl WHERE supplierId=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$supplierId]);
    }
}