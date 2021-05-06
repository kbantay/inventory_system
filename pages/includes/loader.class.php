<?php

    spl_autoload_register('myAutoloader');

    function myAutoloader($className) {
        $url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        if(strpos($url, 'includes')!==false){
            $path = "../model/";
        }
        else {
            $path = "model/";
        }
        
        $ext = ".class.php";
        $fullPath = $path.$className.$ext;  

        include_once $fullPath;
    }