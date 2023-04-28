<?php
    require_once "../models/Gallery.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Delete Gallery</title>
        <link rel="stylesheet" type="text/css" href="/assets/admin.css"/>
    </head>
    <body>
         <div id="main">
            <div class="header"><span>Gallery Deletion</span></div>

            <div class="lefty">
                
            
            <?php
                $gallery = Gallery::find($_GET['id']);
                if( $gallery ){
                    $gallery->delete();
                    header('Location: /admin/galleries.php', true, 303);
                    die();
                } else {
                    echo 'Unable to find gallery. Gallery was not deleted.';
                }
            ?>
                
            </div>
            
            <div class="righty"><a href="/admin">Admin Home</a></div>
            <div class="righty"><a href="/admin/galleries.php">Manage Galleries</a></div>
    </body>
</html>
