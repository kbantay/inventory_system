<?php

class Subcategory extends Database {

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

    public function getAllSubcat(){
        $sql = "SELECT * FROM subcategory_tbl";
        $stmt = $this->dbconnect()->query($sql);
        $this->display($stmt);
    }

    public function getSpecificSubcat($subcategoryID){
        $sql = "SELECT * FROM subcategory_tbl WHERE subcategoryID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$subcategoryID]);
        $this->display($stmt);
    }

    public function getSubcatPerCategory($categoryID){
        $sql = "SELECT * FROM subcategory_tbl WHERE categoryID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$categoryID]);
        $this->display($stmt);
    }

    //---------------------------

    public function setNewSubcat($categoryID, $categoryName, $subcategoryName, $subcategoryNotes){
        $sql = "INSERT INTO subcategory_tbl (categoryID, categoryName, subcategoryName, subcatNotes) VALUES (?, ?, ?, ?)";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$categoryID, $categoryName, $subcategoryName, $subcategoryNotes]);
    }

    public function setUpdateSubcat($categoryID, $categoryName, $subcategoryName, $subcategoryNotes, $subcategoryID){
        $sql = "UPDATE subcategory_tbl SET categoryID=?, categoryName=?, subcategoryName=?, subcatNotes=? WHERE subcategoryID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$categoryID, $categoryName, $subcategoryName, $subcategoryNotes, $subcategoryID]);
    }

    public function setDeleteSubcat($subcategoryID){
        $sql = "DELETE FROM subcategory_tbl WHERE subcategoryID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$subcategoryID]);
    }
}