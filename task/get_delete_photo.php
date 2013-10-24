<?php
    require_once "../models/Photo.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Delete Photo</title>
        <link rel="stylesheet" type="text/css" href="/assets/admin.css"/>
    </head>
    <body>
        <div id="main">
            <div class="header"><span>Photo Deletion</span></div>

            <div class="lefty">
            <?php
                $photo = Photo::find($_GET['id']);
                if( $photo ){
                    $photo->delete();
                    header("Location: /admin/gallery.php?id=".$photo->gallery_id, true, 303);
                    die();
                } else {
                    echo 'Unable to find photo. Photo was not deleted.';
                }
            ?>
            </div>
            
                        
            <div class="righty"><a href="/admin">Admin Home</a></div>
            <div class="righty"><a href="/admin/galleries.php">Manage Galleries</a></div>
            <?php 
                if($photo){ 
                    echo "<div class='righty'><a href='gallery.php?id=".$photo->gallery_id.">Back to Gallery</a></div>";
                }
            ?>
                
        </div>
    </body>
</html>
