<?php

class Department extends Database {

    function errorChk($stmt){
        if($stmt->errorCode() == 0) {
            $result = "1";
            
        } else {
            $error = $stmt->errorInfo();
            $result = $error[2];
        }
        print_r($result);
    }


    public function getAllDepartments(){
        $sql = "SELECT * FROM department_tbl";
        $stmt = $this->dbconnect()->query($sql);
        $resultArray = $stmt->fetchAll();
        return $resultArray;
    }

    public function getLoadDeptInfo($deptID){
        $sql = "SELECT * FROM department_tbl WHERE deptID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$deptID]);
        $resultArray = $stmt->fetchAll();
        return $resultArray;
    }

    //-------------------------------

    public function setNewDept($deptName, $deptShortName, $deptNotes){
        $sql = "INSERT INTO department_tbl(deptName, deptShortName, deptNotes) VALUES (?, ?, ?)";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$deptName, $deptShortName, $deptNotes]);
        $this->errorChk($stmt);
    }

    public function setUpdateDeptInfo($deptName, $deptShortName, $deptNotes, $deptID){
        $sql = "UPDATE department_tbl SET deptName=?, deptShortName=?, deptNotes=? WHERE deptID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$deptName, $deptShortName, $deptNotes, $deptID]);
        $this->errorChk($stmt);
    }

    public function setDeleteDept($deptID){
        $sql = "DELETE FROM department_tbl WHERE deptID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$deptID]);
        $this->errorChk($stmt);
    }
}