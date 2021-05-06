<?php

class Room extends Database{

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
    
    public function getAllRooms(){
        $sql = "SELECT * FROM room_tbl";
        $stmt = $this->dbconnect()->query($sql);
        $this->display($stmt);
    }

    public function getRoomInfo($roomid){
        $sql = "SELECT * FROM room_tbl WHERE roomID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$roomid]);
        $this->display($stmt);
    }

    public function getRoomPerBldg($bldgid){
        $sql = "SELECT * FROM room_tbl WHERE bldgID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$bldgid]);
        $this->display($stmt);
    }

    //------------------------------------

    public function setNewRoom($bldgID, $bldgName, $roomName, $location, $roomNotes){
        $sql = "INSERT INTO room_tbl(bldgID, bldgName, roomName, locationName, roomNotes) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$bldgID, $bldgName, $roomName, $location, $roomNotes]);
        $this->errorChk($stmt);
        // $stmt = $this->dbconnect()->query("SELECT LAST_INSERT_ID()");
        // $lastId = $stmt->fetchColumn();
        // print_r($lastId);
    }

    public function setDeleteRoom($roomID){
        $sql = "DELETE FROM room_tbl WHERE roomID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$roomID]);
    }

    public function setUpdateRoomInfo($bldgID, $bldgName, $roomName, $locationName, $roomNotes, $roomID){
        $sql = "UPDATE room_tbl SET bldgID=?, bldgName=?, roomName=?, locationName=?, roomNotes=? WHERE roomID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$bldgID, $bldgName, $roomName, $locationName, $roomNotes, $roomID]);  
    }
	

}