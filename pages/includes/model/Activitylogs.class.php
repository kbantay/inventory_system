<?php

class Activitylogs extends Database{

    public function setNewLog($userID, $fullname, $username, $activity, $dateAndTime){
        $sql = "INSERT INTO userlogs_tbl (userID, fullname, username, activity, dateAndTime)  VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$userID, $fullname, $username, $activity, $dateAndTime]);
    }

}