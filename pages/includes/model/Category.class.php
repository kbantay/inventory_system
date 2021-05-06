<?php

class Category extends Database {

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


    public function getAllCategories(){
        $sql = "SELECT * FROM category_tbl";
        $stmt = $this->dbconnect()->query($sql);
        $this->display($stmt);
    }

    public function getSpecificCat($catID){
        $sql = "SELECT * FROM category_tbl WHERE categoryID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$catID]);
        $this->display($stmt);
    }

    //------------------------------------------------

    public function setUpdateCat($catName, $catNotes, $catID){
        $sql = "UPDATE category_tbl SET categoryName=?, categoryNotes=? WHERE categoryID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$catName, $catNotes, $catID]);
    }

    public function setNewCategory($catName, $catNotes){
        $sql = "INSERT INTO category_tbl (categoryName, categoryNotes) VALUES (?, ?)";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$catName, $catNotes]);
    }

    public function setDeleteCat($catID){
        $sql = "DELETE FROM category_tbl WHERE categoryID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$catID]);
    }
    
}