<?php

class Building extends Database{

    function display($stmt){
        $result = array();
        while ($row = $stmt->fetchAll()) {
            $result = $row;
            header('Content-type: application/json');
            echo json_encode($result);
        }
    }
    
    public function getAllBuilding(){
        $sql = "SELECT * FROM building_tbl";
        $stmt = $this->dbconnect()->query($sql);
        $this->display($stmt);
    }

    public function getBldgInfo($bldgid){
        $sql = "SELECT * FROM building_tbl WHERE bldgID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$bldgid]);
        $this->display($stmt);
    }

    //----------------------------------------------

    public function setNewBldg($bldgName, $bldgShortName, $bldgNotes){
        $sql = "INSERT INTO building_tbl(bldgName, bldgShortName, bldgNotes) VALUES (?, ?, ?)";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$bldgName, $bldgShortName, $bldgNotes]);
    }

    public function setUpdateBldgInfo($bldgName, $bldgShortName, $bldgNotes, $bldgID){
        $sql = "UPDATE building_tbl SET bldgName=?, bldgShortName=?, bldgNotes=? WHERE bldgID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$bldgName, $bldgShortName, $bldgNotes, $bldgID]);
    }

    public function setDeleteBldg($bldgID){
        $sql = "DELETE FROM building_tbl WHERE bldgID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$bldgID]);
    }	

}