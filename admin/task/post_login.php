<?php

    if( !array_key_exists('password', $_POST) ){
        $location = "../login.php?msg=missingpassword";
    } else {
        setcookie('password', $_POST['password'], time()+3600, '/');
        $location = "../index.php";
    }
    header("Location: ".$location, true, 303);
    die();
