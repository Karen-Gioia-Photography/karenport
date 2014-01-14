<?php
    if( !array_key_exists('password', $_COOKIE) ){
        header("Location: login.php", true, 303);
        die();
    } else if( $_COOKIE['password'] != '3888cwrU' ){
        header("Location: login.php?msg=invalidpassword", true, 303);
        die();
    }
?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Karen Gioia Admin</title>
<link rel="stylesheet" type="text/css" href="../assets/admin.css"/>
