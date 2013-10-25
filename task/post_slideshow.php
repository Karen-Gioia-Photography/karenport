<?php
    require_once "../models/Photo.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
       <title>Update Slideshow</title>
        <link rel="stylesheet" type="text/css" href="/assets/admin.css"/>
    </head>
    <body>
        <div id="main">
            <div class="header"><span>Update Slideshow</span></div>

            <div class='righty'><a href='/admin/slideshow.php'>Back to Slideshow Management</a></div>
            
            <div>
            <?php
                $ids = $_POST['id'];
                $positions = $_POST['position'];

                foreach( Photo::allForHomepage() as $photo ){
                    $photo->updateSlideshow(null);
                }
                
                for( $i =0 ; $i < sizeof($ids) ; $i++ ){
                    if( sizeof($positions) < $i+1){
                        continue;
                    }
                    $photo = Photo::find($ids[$i]);
                    if( $photo ){
                        $photo->updateSlideshow($positions[$i]);
                    }
                }

                echo 'Successfully Updated Slideshow';
            ?>
            </div>
    </body>
</html>
