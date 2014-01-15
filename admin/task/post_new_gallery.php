<?php
    ob_start();
  require_once "../../models/Gallery.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>New Gallery</title>
      <link rel="stylesheet" type="text/css" href="../../assets/admin.css"/>
    </head>
    <body>
        <div id="main">
            <div class="header"><span>Gallery Creation</span></div>

            <div>
            <?php
                $valid = true;
                $validation_keys = array("name","description","layout","position");
                foreach( $validation_keys as $validation ){
                    if( !array_key_exists($validation, $_POST) ){
                        echo ("<div class='lefty'>Must supply ".$validation."</div>");
                        $valid = false;
                    }
                }

                if( $valid ){
                    $gallery = Gallery::create( $_POST['name'], $_POST['description'], $_POST['layout'], intval($_POST['position']) );
                    if( $gallery ){
                        $gallery_path_relative = "photos/".$gallery->description;
                        $gallery_path_absolute = $_SERVER["DOCUMENT_ROOT"]."/".$gallery_path_relative;
                        if( file_exists($gallery_path_absolute) ){
                            $photo_paths = scandir($gallery_path_absolute);
                            $ii = 0;
                            foreach( $photo_paths as $photo ){
							  $revpath = strrev($photo);
                              if( (stripos($revpath, 'gpj') === 0) || (stripos($revpath, 'gnp') === 0) ){ 
                                $photoname = substr($photo, 0, -4);
                                Photo::create( $photoname, $gallery_path_relative."/".$photo, $gallery->id, $ii );
                                $ii+=5;
                              }
                            }                  
                            header("Location: ../gallery.php?id=".$gallery->id, true, 303);
                            die();
                        } else {
                            echo ("<div class='lefty'>Couldn't find Directory ".$gallery_path_absolute."</div>");
                        }
                    } else {
                        echo ("<div class='lefty'>Couldn't create gallery</div>");
                    }
                } 
                echo "<div class='righty'><a href='../galleries.php>Back to Galleries</a></div>";
            ?>
            </div>
    </body>
</html>
