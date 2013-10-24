<?php
    require_once "../models/Gallery.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>New Gallery</title>
        <link rel="stylesheet" type="text/css" href="/assets/admin.css"/>
    </head>
    <body>
        <div id="main">
            <div class="header"><span>Gallery Creation</span></div>

            <div class="lefty">
            <?php
                $valid = true;
                $validation_keys = array("name","description","position");
                foreach( $validation_keys as $validation ){
                    if( !array_key_exists($validation, $_POST) ){
                        echo ("<div>Must supply ".$validation."</div>");
                        $valid = false;
                    }
                }

                if( $valid ){
                    $gallery = Gallery::create( $_POST['name'], $_POST['description'], intval($_POST['position']) );
                    header('Location: /admin/galleries.php', true, 303);
                    die();
                } else {
                     echo "<div class='righty'><a href='gallery.php?id=".$gallery->id.">View This Gallery</a></div>";
                }

            ?>
            </div>
    </body>
</html>
