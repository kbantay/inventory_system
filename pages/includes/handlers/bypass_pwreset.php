<?php
session_start(); 	

require 'databaseConn_handler.php';

$userid = "54";
$hnewPassword = "password";

$hashedPwd = password_hash($hnewPassword, PASSWORD_DEFAULT);
$updatesql = "UPDATE users_tbl SET password='$hashedPwd', is_password_changed='0' WHERE userid='$userid';";
if (!mysqli_query($conn, $updatesql)) {
    echo "Error on updating new password: ".mysqli_error($conn);
}
else {
    echo "User $userid has been updated successfully!";
}
