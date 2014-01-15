<?php
  ob_start();
  require_once "../../models/Photo.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Update Photo</title>
      <link rel="stylesheet" type="text/css" href="../../assets/admin.css"/>
    </head>
    <body>
        
        <div id="main">
            <div class="header"><span>Update Photo</span></div>

            <div>
                <?php
                    $valid = true;
                    $validation_keys = array("id", "name", "position", "gallery", "description", "link");
                    foreach( $validation_keys as $validation ){
                        if( !array_key_exists($validation, $_POST) ){
                            echo ("<div>Must supply ".$validation."</div>");
                            $valid = false;
                        }
                    }

                    if( $valid ){
                        $photo = Photo::find($_POST['id']);
                        echo "<div class='lefty'>";
                        if( $photo ){
                            $photo->update($_POST['name'], $_POST['position'], $_POST['description'], $_POST['link']);
                            header("Location: ../gallery.php?id=".$_POST['gallery'], true, 303);
                            die();
                        } else {
                            echo "Could not Find Photo.";
                        }
                        echo "</div>";
                        echo "<div class='righty'><a href='../gallery.php?id=".$_POST['gallery']."'>Back to Gallery</a>";
                    }

                ?>
            </div>
        </div>
    </body>
</html>
