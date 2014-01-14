<?php
    require_once "models/Gallery.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Karen Gioia Photography</title>
        <?php require '_headers.php'?>
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
                                $gallery_paths = array();
                                foreach($gallery->getPhotos() as $photo){ 
                                    array_push($photo_paths,    $photo->path); 
                                    array_push($gallery_paths,  "gallery.php?id=".$photo->gallery_id);
                                }
                                echo '["'.join('", "',$photo_paths).'"]';
                                echo ',';
                                echo '["'.join('", "',$gallery_paths).'"]';
                            } else {
                                echo '[],[]';
                            }
                        ?>,
                          { autoplay: 0, thumbnails: true, arrows: true, linkingImages: false }
                    );
                }
            });
        </script>
        
    </body>
</html>
