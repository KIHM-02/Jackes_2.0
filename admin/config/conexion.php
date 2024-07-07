<?php

    $host = "localhost";
    $database = "jackes";
    $user  = "root";
    $pwd = "";

    try{
        $conection = new PDO("mysql:host=$host;dbname=$database", $user, $pwd);
    }catch(Exception $er){
        echo $er->getMessage();
    }

?>