<?php
    ob_start();
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Tue, 8 Mar 1988 06:00:00 GMT"); // Date in the past
    require_once "models/Photo.php";
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
                            $photo_paths = array();
                            $gallery_paths = array();
                            foreach(Photo::allForHomepage() as $photo){ 
                                array_push($photo_paths,    $photo->path); 
                                array_push($gallery_paths,  "gallery.php?id=".$photo->gallery_id);
                            }
                            echo '["'.join('", "',$photo_paths).'"]';
                            echo ',';
                            echo '["'.join('", "',$gallery_paths).'"]'
                        ?>,
                              { autoplay: 3888, thumbnails: false, arrows: false, linkingImages: true }
                    );
                }
            });
        </script>
    </body>
</html>
