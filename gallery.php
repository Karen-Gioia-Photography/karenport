<?php
    require_once "models/Gallery.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Karen Gioia Photography</title>
        <link rel="stylesheet" type="text/css" href="/assets/index.css"/>
        <script type="text/javascript" src="/assets/index.js"></script>
    </head>
    <body>
        
        <?php require '_left_area.php' ?>
        
        <div class="content">
            <div id="gallery_container"></div>
        </div>
        
        <script type="text/javascript">
            var reel;
            domLoaded( function(){ 
                if( reel === undefined ){            
                    reel = new Reel(
                        document.getElementById('gallery_container'),
                        <?php 
                            $gallery = Gallery::find($_GET['id']);
                            if( $gallery ){
                                $photo_paths = array();
                                foreach( $gallery->getPhotos() as $photo){ array_push($photo_paths, ($photo->path)); }
                                echo '["'.join('", "',$photo_paths).'"]';
                            }
                        ?>,
                        { autoplay: 0, thumbnails: true, arrows: true }
                    );
                }
            });
        </script>
        
    </body>
</html>
