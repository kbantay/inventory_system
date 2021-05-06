<?php

require 'databaseConn_handler.php';

if(isset($_POST['start'])){
    $start = $conn->real_escape_string($_POST['start']);

    $sql = $conn->query("SELECT * FROM supplies_tbl LIMIT $start, 50");
    $tbldata = "";
    while($data = $sql->fetch_assoc()){
        $tbldata .= $data['productID'].", ".$data['brandname'].", ".$data['productname']."\n";
    }
    exit(json_encode(array("data" => $tbldata)));
}
