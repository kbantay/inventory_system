    <?php

class Roles extends Database {
    function display($stmt){
        $result = array();
        while ($row = $stmt->fetchAll()) {
            $result = $row;
            header('Content-type: application/json');
            echo json_encode($result, true);
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


    public function getAllRoles(){
        $sql = "SELECT * FROM role_tbl";
        $stmt = $this->dbconnect()->query($sql);
        $this->display($stmt);
    }

    public function getSpecificRoles($roleID){
        $sql = "SELECT * FROM role_tbl WHERE roleID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$roleID]);
        $this->display($stmt);
    }

    public function getRolePermissions($roleID){
        $sql = "SELECT * FROM permission_tbl WHERE roleID=? AND userID IS NULL";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$roleID]); 
        $this->display($stmt);
    }

    public function getUserRolePermissions($roleID, $userID){
        $sql = "SELECT * FROM permission_tbl WHERE roleID=? AND userID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$roleID, $userID]);
        $this->display($stmt);
    }

    public function getSpecificRolePerm($roleID){
        $sql = "SELECT * FROM role_tbl rol INNER JOIN permission_tbl per ON rol.roleID = per.roleID WHERE rol.roleID=? AND per.userID IS NULL";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$roleID]);
        $this->display($stmt);
    }

    //-----------------------------------------

    public function setNewRole($roleName, $roleDesc){
        $sql = "INSERT INTO role_tbl (roleName, roleDescription) VALUES (?, ?)";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$roleName, $roleDesc]);
        $rolesql = "SELECT roleID FROM role_tbl WHERE roleName=? AND roleDescription=?";
        $stmt = $this->dbconnect()->prepare($rolesql);
        $stmt->execute([$roleName, $roleDesc]);
        while ($row = $stmt->fetch()) {
            echo $row['roleID'];
        }
    }

    public function setNewPermission($roleID, $user_add, $user_view, $user_manage, $user_role, $user_logs,  $user_updateInfo, $outlet_suplist, $outlet_reqsup, $outlet_resitem, $outlet_pendingrestock, $warehouse_regitem, $warehouse_setupitem, $warehouse_suplist, $warehouse_encreqsup, $warehouse_encdel, $warehouse_mngdel, $warehouse_resreq, $asset_addnew, $asset_mngasset, $asset_disposed, $report_assets, $report_cons, $report_delsupplies, $report_delhistory, $report_userlogs, $settings_assetsubcat, $settings_outletemail, $settings_whemail, $settings_supplier, $settings_dept, $settings_location){
        $sql = "INSERT INTO permission_tbl (roleID, user_add, user_view, user_manage, user_role, user_logs, user_updateInfo, outlet_suplist, outlet_reqsup, outlet_resitem, outlet_pendingrestock, warehouse_regitem, warehouse_setupitem, warehouse_suplist, warehouse_encreqsup, warehouse_encdel, warehouse_mngdel, warehouse_resreq, asset_addnew, asset_mngasset, asset_disposed, report_assets, report_cons, report_delsupplies, report_delhistory, report_userlogs, settings_assetsubcat, settings_outletemail, settings_whemail, settings_supplier, settings_dept, settings_location) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$roleID, $user_add, $user_view, $user_manage, $user_role, $user_logs,  $user_updateInfo, $outlet_suplist, $outlet_reqsup, $outlet_resitem, $outlet_pendingrestock, $warehouse_regitem, $warehouse_setupitem, $warehouse_suplist, $warehouse_encreqsup, $warehouse_encdel, $warehouse_mngdel, $warehouse_resreq, $asset_addnew, $asset_mngasset, $asset_disposed, $report_assets, $report_cons, $report_delsupplies, $report_delhistory, $report_userlogs, $settings_assetsubcat, $settings_outletemail, $settings_whemail, $settings_supplier, $settings_dept, $settings_location]);
    }

    public function setUpdateRole($roleName, $roleDesc, $roleID){
        $sql = "UPDATE role_tbl SET roleName=?, roleDescription=? WHERE roleID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$roleName, $roleDesc, $roleID]);
    }

    public function setUpdatePermission($user_add, $user_view, $user_manage, $user_role, $user_logs,  $user_updateInfo, $outlet_suplist, $outlet_reqsup, $outlet_resitem, $outlet_pendingrestock, $warehouse_regitem, $warehouse_setupitem, $warehouse_suplist, $warehouse_encreqsup, $warehouse_encdel, $warehouse_mngdel, $warehouse_resreq, $asset_addnew, $asset_mngasset, $asset_disposed, $report_assets, $report_cons, $report_delsupplies, $report_delhistory, $report_userlogs, $settings_assetsubcat, $settings_outletemail, $settings_whemail, $settings_supplier, $settings_dept, $settings_location, $roleID){
        $sql = "UPDATE permission_tbl SET user_add=?, user_view=?, user_manage=?, user_role=?, user_logs=?, user_updateInfo=?, outlet_suplist=?, outlet_reqsup=?, outlet_resitem=?, outlet_pendingrestock=?, warehouse_regitem=?, warehouse_setupitem=?, warehouse_suplist=?, warehouse_encreqsup=?, warehouse_encdel=?, warehouse_mngdel=?, warehouse_resreq=?, asset_addnew=?, asset_mngasset=?, asset_disposed=?, report_assets=?, report_cons=?, report_delsupplies=?, report_delhistory=?, report_userlogs=?, settings_assetsubcat=?, settings_outletemail=?, settings_whemail=?, settings_supplier=?, settings_dept=?, settings_location=? WHERE roleID=? AND userID IS NULL";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$user_add, $user_view, $user_manage, $user_role, $user_logs,  $user_updateInfo, $outlet_suplist, $outlet_reqsup, $outlet_resitem, $outlet_pendingrestock, $warehouse_regitem, $warehouse_setupitem, $warehouse_suplist, $warehouse_encreqsup, $warehouse_encdel, $warehouse_mngdel, $warehouse_resreq, $asset_addnew, $asset_mngasset, $asset_disposed, $report_assets, $report_cons, $report_delsupplies, $report_delhistory, $report_userlogs, $settings_assetsubcat, $settings_outletemail, $settings_whemail, $settings_supplier, $settings_dept, $settings_location, $roleID]);
    }

    public function setDeleteRole($roleID){
        $sql = "DELETE FROM role_tbl WHERE roleID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $this->errorChk($stmt);
        $stmt->execute([$roleID]);
    }

    public function setDeletePerm($roleID){
        $sql = "DELETE FROM permission_tbl WHERE roleID=? AND userID IS NULL";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$roleID]);
    }

    public function setDeletePermPerUser($userID){
        $sql = "DELETE FROM permission_tbl WHERE userID=?";
        $stmt = $this->dbconnect()->prepare($sql);
        $stmt->execute([$userID]);
    }
}