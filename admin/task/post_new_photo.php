<?php
    ob_start();
  require_once "../../models/Gallery.php";
  require_once "../../models/Photo.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>New Photo</title>
      <link rel="stylesheet" type="text/css" href="../../assets/admin.css"/>
    </head>
    <body>
        <div id="main">
            <div class="header"><span>Photo Creation</span></div>

            <div class="lefty">
            <?php
                $valid = true;
                $validation_keys = array("name","position","image_file","description", "link");
                foreach( $validation_keys as $validation ){
                    if( !array_key_exists($validation, $_POST) ){
                        echo ("<div>Must supply ".$validation."</div>");
                        $valid = false;
                    }
                }

                if( $valid ){
                    $gallery = Gallery::find(intval($_POST['gallery']));
                    $new_path = "photos/".$gallery->description."/".$_POST["image_file"];
                    $photo = Photo::create( $_POST['name'], $new_path, $gallery->id, intval($_POST['position']), $_POST['description'], $_POST['link'] );
                    if( $photo ){  
                      header("Location: ../gallery.php?id=".$gallery->id."#".$photo->id, true, 303);
                        die();
                    } else {
                        echo "<div>New Photo Creation Failed. You may have already used this file.</div>";
                    }
                    echo "<div class='righty'><a href='../gallery.php?id=".$_POST['gallery']."'>Back to Gallery</a></div>";
                }
            ?>
            </div>
    </body>
</html>
