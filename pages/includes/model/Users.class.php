<?php

class Users extends Database {
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

    function getUserIDbyUsername($username){
        $sql = "SELECT userid FROM users_tbl WHERE username=?";
        $stmt=$this->dbconnect()->prepare($sql);
        $stmt->execute([$username]);
        while ($row = $stmt->fetch()) {
            return $row['userid'];
        }
    }

    public function getAllUsers(){
        $sql = "SELECT * FROM users_tbl";
        $stmt = $this->dbconnect()->query($sql);
        $this->display($stmt);
    }

    public function getSpecificUser($userID){
        $sql = "SELECT * FROM users_tbl WHERE userid=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$userID]);
        $this->display($stmt);
    }

    public function getUsername($username){
        $sql = "SELECT userid, username, fullname, secquestion FROM users_tbl WHERE username=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$username]);
        $this->display($stmt);
    }

    public function getUserAnswerPerID($userID){
        $sql = "SELECT secanswer FROM users_tbl WHERE userid=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$userID]);
        $result = $stmt->fetch();
        echo $result['secanswer'];
    }

    public function getUserPermission($userID){
        $sql = "SELECT * FROM permission_tbl WHERE userID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$userID]);
        $this->display($stmt);
    }

    public function getSpecificUserRolePermission($userID){
        $sql = "SELECT * FROM users_tbl usr INNER JOIN role_tbl rol ON usr.role = rol.roleID INNER JOIN permission_tbl prm ON prm.userID = usr.userID WHERE usr.userID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$userID]);
        $this->display($stmt);
    }

    public function getUserLogs(){
        $sql = "SELECT * FROM userlogs_tbl";
        $stmt = $this->dbconnect()->query($sql);
        $this->display($stmt);
    }

    public function getCheckUserExists($username){
        $sql = "SELECT username FROM users_tbl WHERE username=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$username]);
        $this->display($stmt);
    }

    public function getSearchedName($searchedName){
        $sql = "SELECT * FROM users_tbl WHERE email LIKE CONCAT('%', ?, '%') OR fullname LIKE CONCAT('%', ?, '%');";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$searchedName, $searchedName]);
        $this->display($stmt);
    }

    public function getCurrentEmailReceiver($designation){
        $sql = "SELECT * FROM emailreceiver_tbl WHERE designation=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$designation]);
        $this->display($stmt);
    }

    //------------------------------------

    public function setNewUser($username, $hashedPwd, $userRole, $assetAccess, $email, $fullname, $designation, $department, $secquestion, $secanswer, $passChanged){
        $sql = "INSERT INTO users_tbl (username, password, role, assetaccess, email, fullname, designation, department, secquestion, secanswer, is_password_changed) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$username, $hashedPwd, $userRole, $assetAccess, $email, $fullname, $designation, $department, $secquestion, $secanswer, $passChanged]);
    }

    public function setNewUserPerm($username, $userRole){
        $userID = $this->getUserIDbyUsername($username);
        $sql = "SELECT * FROM permission_tbl WHERE roleID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$userRole]);
        $row = $stmt->fetch();
        $roleID = $row['roleID'];
        $user_add = $row['user_add'];
        $user_view = $row['user_view'];
        $user_manage = $row['user_manage'];
        $user_logs = $row['user_logs'];
        $user_role = $row['user_role'];
        $user_updateInfo = $row['user_updateInfo'];
                    
        $outlet_suplist = $row['outlet_suplist'];
        $outlet_reqsup = $row['outlet_reqsup'];
        $outlet_resitem = $row['outlet_resitem'];
        $outlet_pendingrestock = $row['outlet_pendingrestock'];

        $warehouse_regitem = $row['warehouse_regitem'];
        $warehouse_setupitem = $row['warehouse_setupitem'];
        $warehouse_suplist = $row['warehouse_suplist'];
        $warehouse_encreqsup = $row['warehouse_encreqsup'];
        $warehouse_encdel = $row['warehouse_encdel'];
        $warehouse_mngdel = $row['warehouse_mngdel'];
        $warehouse_resreq = $row['warehouse_resreq'];

        $asset_addnew = $row['asset_addnew'];
        $asset_mngasset = $row['asset_mngasset'];
        $asset_disposed = $row['asset_disposed'];

        $report_assets = $row['report_assets'];
        $report_cons = $row['report_cons'];
        $report_delsupplies = $row['report_delsupplies'];
        $report_delhistory = $row['report_delhistory'];
        $report_userlogs = $row['report_userlogs'];

        $settings_assetsubcat = $row['settings_assetsubcat'];
        $settings_outletemail = $row['settings_outletemail'];
        $settings_whemail = $row['settings_whemail'];
        $settings_supplier = $row['settings_supplier'];
        $settings_dept = $row['settings_dept'];
        $settings_location = $row['settings_location'];

        $permsql = "INSERT INTO permission_tbl (roleID, userID, user_add, user_view, user_manage, user_logs, user_role, user_updateInfo, outlet_suplist, outlet_reqsup, outlet_resitem, outlet_pendingrestock, warehouse_regitem, warehouse_setupitem, warehouse_suplist, warehouse_encreqsup, warehouse_encdel, warehouse_mngdel, warehouse_resreq, asset_addnew, asset_mngasset, asset_disposed, report_assets, report_cons, report_delsupplies, report_delhistory, report_userlogs, settings_assetsubcat, settings_outletemail, settings_whemail, settings_supplier, settings_dept, settings_location) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->dbconnect()->prepare($permsql);
        //$this->errorChk($stmt);
        $stmt->execute([$roleID, $userID, $user_add, $user_view, $user_manage, $user_logs, $user_role, $user_updateInfo, $outlet_suplist, $outlet_reqsup, $outlet_resitem, $outlet_pendingrestock, $warehouse_regitem, $warehouse_setupitem, $warehouse_suplist, $warehouse_encreqsup, $warehouse_encdel, $warehouse_mngdel, $warehouse_resreq, $asset_addnew, $asset_mngasset, $asset_disposed, $report_assets, $report_cons, $report_delsupplies, $report_delhistory, $report_userlogs, $settings_assetsubcat, $settings_outletemail, $settings_whemail, $settings_supplier, $settings_dept, $settings_location]);
    }


    public function setUpdateUserProfile($userName, $userRole, $fullName, $designation, $email, $department, $secquestion, $secanswer, $userID){
        $sql = "UPDATE users_tbl SET username=?, role=?, fullName=?, designation=?, email=?, department=?, secquestion=?, secanswer=? WHERE userid=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$userName, $userRole, $fullName, $designation, $email, $department, $secquestion, $secanswer, $userID]);
    }

    public function setResetUserPassword($hashedPwd, $userid){
        $sql = "UPDATE users_tbl SET password=?, is_password_changed='0' WHERE userid='$userid';";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$hashedPwd, $userid]);
    }

    public function setResetOwnPassword($hashedPwd, $userId){
        $sql = "UPDATE users_tbl SET password=?, is_password_changed='1' WHERE userid=?;";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$hashedPwd, $userId]);
    }

    public function setDeleteUser($userid){
        $sql = "DELETE FROM users_tbl WHERE userid=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$userid]);
    }

    public function setDeleteUserPermission($userid){
        $sql = "DELETE FROM permission_tbl WHERE userid=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$userid]);
    }

    public function setUpdateUserPermission($user_add, $user_view, $user_manage, $user_role, $user_logs, $user_updateInfo, $outlet_suplist, $outlet_reqsup, $outlet_resitem, $outlet_pendingrestock, $warehouse_regitem, $warehouse_setupitem, $warehouse_suplist, $warehouse_encreqsup, $warehouse_encdel, $warehouse_mngdel, $warehouse_resreq, $asset_addnew, $asset_mngasset, $asset_disposed, $report_assets, $report_cons, $report_delsupplies, $report_delhistory, $report_userlogs, $settings_assetsubcat, $settings_outletemail, $settings_whemail, $settings_supplier, $settings_dept, $settings_location, $userID){
        $sql = "UPDATE permission_tbl SET user_add=?, user_view=?, user_manage=?, user_role=?, user_logs=?, user_updateInfo=?, outlet_suplist=?, outlet_reqsup=?, outlet_resitem=?, outlet_pendingrestock=?, warehouse_regitem=?, warehouse_setupitem=?, warehouse_suplist=?, warehouse_encreqsup=?, warehouse_encdel=?, warehouse_mngdel=?, warehouse_resreq=?, asset_addnew=?, asset_mngasset=?, asset_disposed=?, report_assets=?, report_cons=?, report_delsupplies=?, report_delhistory=?, report_userlogs=?, settings_assetsubcat=?, settings_outletemail=?, settings_whemail=?, settings_supplier=?, settings_dept=?, settings_location=? WHERE userID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$user_add, $user_view, $user_manage, $user_role, $user_logs, $user_updateInfo, $outlet_suplist, $outlet_reqsup, $outlet_resitem, $outlet_pendingrestock, $warehouse_regitem, $warehouse_setupitem, $warehouse_suplist, $warehouse_encreqsup, $warehouse_encdel, $warehouse_mngdel, $warehouse_resreq, $asset_addnew, $asset_mngasset, $asset_disposed, $report_assets, $report_cons, $report_delsupplies, $report_delhistory, $report_userlogs, $settings_assetsubcat, $settings_outletemail, $settings_whemail, $settings_supplier, $settings_dept, $settings_location, $userID]);
    }

    public function downloadSCV(){
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=userslist.csv');
        $output = fopen("php://output", "w");
        fputcsv($output, array('userid','fullname','username','designation'));
        $query = "SELECT userid, fullname, username, designation FROM users_tbl ORDER BY fullname ASC";
        $stmt = $this->dbconnect()->query($query);
        while ($row = $stmt->fetch()) {
            fputcsv($output, $row);
        }
        fclose($output);
    }

    public function setNewUserPhoto($fileNameNew, $userID){
        $sql = "UPDATE users_tbl SET profilePhoto=? WHERE userid=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$fileNameNew, $userID]);
    }

    public function setUpdateCurrentEmailReceiver($fullname, $emailaddress, $designation){
        $sql = "UPDATE emailreceiver_tbl SET fullname=?, emailaddress=? WHERE designation=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$fullname, $emailaddress, $designation]);
        $this->errorChk($stmt);
    }
}