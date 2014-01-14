<?php
  ob_start();
  require_once "../../models/Gallery.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Update Gallery</title>
      <link rel="stylesheet" type="text/css" href="../../assets/admin.css"/>
    </head>
    <body>
        
        <div id="main">
            <div class="header"><span>Update Gallery</span></div>

            <div class="lefty">
                <?php
                    $valid = true;
                    $validation_keys = array("id", "name", "description", "position");
                    foreach( $validation_keys as $validation ){
                        if( !array_key_exists($validation, $_POST) ){
                            echo ("<div>Must supply ".$validation."</div>");
                            $valid = false;
                        }
                    }

                    if( $valid ){
                        $gallery = Gallery::find($_POST['id']);
                        echo "<div class='lefty'>";
                        if( $gallery ){
                            $gallery->update($_POST['name'], $_POST['description'], $_POST['position']);
                            header('Location: ../galleries.php', true, 303);
                            die();
                        } else {
                            echo "Could not Find Gallery.";
                        }
                        echo "</div>";
                        echo "<div class='righty'><a href='../galleries.php'>Back to Galleries</a>";
                    }
                ?>
            </div>
        </div>
    </body>
</html>
