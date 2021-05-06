<?php
    session_start(); 
    include '../loader.class.php';

    if (isset($_POST['uploadPhoto'])) {
        $userID = htmlentities($_POST['userID']);
        $sysuserID = htmlentities($_POST['sysuserID']);

        $file = $_FILES['file'];

        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $validExtensions = array('jpg', 'jpeg', 'png');

        if (in_array(strtolower($fileActualExt), $validExtensions)) {
           if ($fileError===0) {
               if ($fileSize < 1048576 ) {
                 $fileNameNew = uniqid('', true).".".$fileActualExt;
                 $filePath = '../../../dist/img/uploads/'.$fileNameNew;
                 move_uploaded_file($fileTmpName, $filePath);

                 $userPic = new Users();
                 $userPic->setNewUserPhoto($fileNameNew, $userID);
                 if ($userID==$sysuserID) {
                    $_SESSION['profilePic'] = "../dist/img/uploads/".$fileNameNew;
                 }
                    echo "1-$fileNameNew";
               } else {
                    echo "0-File size too big";
               }
               
           } else {
                echo "0-Error upon uploading";
           }
        }
        else {
            echo "0-Invalid file type";
        }
    }
    else {
        if(ISSET($_SESSION['username'])){
            header("Location: ../../error403");
            exit();
        }
        else {
            header("Location: ../index");
            exit();
        }
    }
    