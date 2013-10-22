<?php
    require_once "../models/Gallery.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
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
                
                echo "<div>New Gallery Creation Succeeded With the Following Values:</div>";
                echo print_r($gallery);
            }
        
        ?>
    </body>
</html>
