<?php

require 'databaseConn_handler.php';

//print_r($_FILES['csvdata']);

    $file = $_FILES['csvdata']['tmp_name'];
    $data = file($file);
    $rowCount = count($data);
    echo "Row: $rowCount <br><br>";
    $fileOpen = fopen($file, "r"); //r = readonly
    $i=0;
    //--------- multiples values in one single sql stmt ----------
    $query="INSERT INTO role_tbl (roleName, roleDescription) VALUES ";
    while(($cont=fgetcsv($fileOpen,1000,","))!==false){ // 1000 = lenght ; "," = delimiter
        if ($i>0) {
            $rolename = $cont[0];
            $roledesc = $cont[1];
            
            $query .= "('$rolename', '$roledesc'), ";
        } 
        $i++;
    }
    $trimmed = rtrim($query, ", ");
    echo $trimmed . ";";
    //mysqli_query($conn, $query);


    // //--------- multiples values in multiple sql stmt ----------
    // while(($cont=fgetcsv($fileOpen,1000,","))!==false){
    //     if ($i>0) {
    //         $rolename = $cont[0];
    //         $roledesc = $cont[1];
            
    //         $query="INSERT INTO role_tbl (roleName, roleDescription) VALUES ('$rolename', '$roledesc');";
    //         echo $query . "<br>";
    //         //mysqli_query($conn, $query);
    //     } 
    //     $i++;
    // }