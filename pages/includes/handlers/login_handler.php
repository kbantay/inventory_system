<?php
//session_start(); 	

if (isset($_POST['login'])){

	require 'databaseConn_handler.php';

	$hUsername = htmlentities($_POST['username']);
	$hPassword = htmlentities($_POST['password']);
	$hactivity = "Logged-in to the system";
	$timezone = date_default_timezone_set('Asia/Manila');
	$dateTimeNow = date("M-d-Y")." ".date("h:i:s a", time());

//error handlers
	//check if inputs are empty
	if (empty($hUsername) || empty($hPassword)) {
		header("Location: ../../../index?login=empty");
		exit();
	} 

	else {
		$sql = "SELECT * FROM users_tbl usr LEFT JOIN role_tbl rol ON usr.role = rol.roleID WHERE username='$hUsername';";
		$result = mysqli_query($conn, $sql);
		$numOfResults = mysqli_num_rows($result);

		if ($numOfResults==0) {
			header("Location: ../../../index?error=nouserfound");
			exit();
		}

		else {
			if ($row = mysqli_fetch_assoc($result)) {
				//dehashing the password from the DB  
				$pwdCheck = password_verify($hPassword, $row['password']);
					if ($pwdCheck == false) {
						header("Location: ../../../index?error=invalidpassword");
						exit();
					} 
					elseif ($pwdCheck == true) {
						$userId = $row['userid'];
						$fullName = $row['fullname'];
						$username = $row['username'];

						//--------------- Saving this activity to the User Logs ---------------
						$logsql = "INSERT INTO userlogs_tbl (userID, fullName, username, activity, dateAndTime) VALUES ('$userId', '$fullName', '$username', '$hactivity', '$dateTimeNow')";
						mysqli_query($conn, $logsql);

						session_start();
						//------------ loading the user's permission access -----------
						$permsql = "SELECT * FROM permission_tbl WHERE userID='$userId';";
						$permresult = mysqli_query($conn, $permsql);
						$permrow = mysqli_fetch_assoc($permresult);

						//Getting the user credentials on session
						$_SESSION['username'] = $row['username'];
						$_SESSION['userID'] = $row['userid'];
						$_SESSION['roleID'] = $row['role'];
						$_SESSION['roleName'] = $row['roleName'];
						$_SESSION['assetaccess'] = $row['assetaccess'];
						$_SESSION['department'] = $row['department'];
						$_SESSION['currentUser'] = $row['fullname'];
						$_SESSION['userPosition'] = $row['designation'];
						if ($row['profilePhoto']=="") {
							$_SESSION['profilePic'] = "../dist/img/user.jpg";
						} else {
							$_SESSION['profilePic'] = "../dist/img/uploads/".$row['profilePhoto'];
						}
						
						//--- permission ----
						$_SESSION['user_add'] = $permrow['user_add'];
						$_SESSION['user_view'] = $permrow['user_view'];
						$_SESSION['user_manage'] = $permrow['user_manage'];
						$_SESSION['user_logs'] = $permrow['user_logs'];
						$_SESSION['user_role'] = $permrow['user_role'];
						$_SESSION['user_updateInfo'] = $permrow['user_updateInfo'];

						$_SESSION['outlet_suplist'] = $permrow['outlet_suplist'];
						$_SESSION['outlet_reqsup'] = $permrow['outlet_reqsup'];
						$_SESSION['outlet_resitem'] = $permrow['outlet_resitem'];
						$_SESSION['outlet_pendingrestock'] = $permrow['outlet_pendingrestock'];

						$_SESSION['warehouse_regitem'] = $permrow['warehouse_regitem'];
						$_SESSION['warehouse_setupitem'] = $permrow['warehouse_setupitem'];
						$_SESSION['warehouse_suplist'] = $permrow['warehouse_suplist'];
						$_SESSION['warehouse_encreqsup'] = $permrow['warehouse_encreqsup'];
						$_SESSION['warehouse_encdel'] = $permrow['warehouse_encdel'];
						$_SESSION['warehouse_mngdel'] = $permrow['warehouse_mngdel'];
						$_SESSION['warehouse_resreq'] = $permrow['warehouse_resreq'];

						$_SESSION['asset_addnew'] = $permrow['asset_addnew'];
						$_SESSION['asset_mngasset'] = $permrow['asset_mngasset'];
						$_SESSION['asset_disposed'] = $permrow['asset_disposed'];

						$_SESSION['report_assets'] = $permrow['report_assets'];
						$_SESSION['report_cons'] = $permrow['report_cons'];
						$_SESSION['report_delsupplies'] = $permrow['report_delsupplies'];
						$_SESSION['report_delhistory'] = $permrow['report_delhistory'];
						$_SESSION['report_userlogs'] = $permrow['report_userlogs'];

						$_SESSION['settings_assetsubcat'] = $permrow['settings_assetsubcat'];
						$_SESSION['settings_outletemail'] = $permrow['settings_outletemail'];
						$_SESSION['settings_whemail'] = $permrow['settings_whemail'];
						$_SESSION['settings_supplier'] = $permrow['settings_supplier'];
						$_SESSION['settings_dept'] = $permrow['settings_dept'];
						$_SESSION['settings_location'] = $permrow['settings_location'];

						$_SESSION['allOutletAccess'] = $permrow['outlet_suplist']=="true" || $permrow['outlet_reqsup']=="true" || $permrow['outlet_resitem']=="true" || $permrow['outlet_pendingrestock']=="true";

						$_SESSION['allWarehouseAccess'] = $permrow['warehouse_regitem']=="true" || $permrow['warehouse_setupitem']=="true" || $permrow['warehouse_suplist']=="true" || $permrow['warehouse_encreqsup']=="true" || $permrow['warehouse_encdel']=="true" || $permrow['warehouse_mngdel']=="true" || $permrow['warehouse_resreq']=="true";

						$_SESSION['allAssetAccess'] = $permrow['asset_addnew']=="true" || $permrow['asset_mngasset']=="true" || $permrow['asset_disposed']=="true";

						$_SESSION['allReportsAccess'] = $permrow['report_assets']=="true" || $permrow['report_cons']=="true" || $permrow['report_delsupplies']=="true" || $permrow['report_delhistory']=="true" || $permrow['report_userlogs']=="true";

						$_SESSION['allUsersAccess'] = $permrow['user_add']=="true" || $permrow['user_view']=="true" || $permrow['user_manage']=="true" || $permrow['user_logs']=="true" || $permrow['user_role']=="true"|| $permrow['user_updateInfo']=="true";

						$_SESSION['allSettingsAccess'] = $permrow['settings_assetsubcat']=="true" || $permrow['settings_outletemail']=="true" || $permrow['settings_whemail']=="true" || $permrow['settings_supplier']=="true" || $permrow['settings_dept']=="true"|| $permrow['settings_location']=="true";

						header("Location: ../../home");
						exit();
					} 
					else {
						header("Location: ../../../index?error=invalidlogin");
						exit();
					}
			} 
			else {
				header("Location: ../../../index?error=invalidusername");
				exit();
			}
		}
	}
} 

else {
	if(isset($_SESSION['username'])){
		header("Location: ../../error403");
		exit();
	}
	else {
		header("Location: ../index");
		exit();
	}
}