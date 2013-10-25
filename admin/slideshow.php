<?php 
    require_once '../models/Photo.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Homepage Slideshow</title>
        <link rel="stylesheet" type="text/css" href="/assets/admin.css"/>
    </head>
    <body>

        <div id="main">
        <div class="header">Homepage Slideshow</div>
        
        <div class="righty"><a href="/admin">Admin Home</a></div>
        <div id="warnbox" class="clefairy"></div>
        
        <form method="POST" name="slideshow_form" action="/task/post_slideshow.php" onsubmit="return validateSlideshow();">
            <div id="slideshow_photos">
                <div class="headline">
                    Current Slideshow &nbsp;&nbsp;
                    <button type="submit">Save</button>
                </div>

                <?php
                    foreach( Photo::allForHomepage() as $hpphoto ){
                        echo '<div class="lefty charmander hpphoto in">';
                        echo "  <img src='".$hpphoto->path."'  onclick='removeFromSlideshow(this);'/>";
                        echo "  <input type='hidden' class='id' name='id[]' value='".$hpphoto->id."'/>";
                        echo "  <input type='number' class='position' name='position[]' value='".$hpphoto->homepage_position."'/>";
                        echo "  <span>".$hpphoto->name."</span>";
                        echo '</div>';
                    }
                ?>

                
            </div>
        </form>
        
        <div  id="available_photos">
            <div class="headline">Available Photos</div>
            <?php
                foreach( Photo::allNotForHomepage() as $hpphoto ){
                    echo '<div class="lefty charmander hpphoto out">';
                    echo "  <img src='".$hpphoto->path."' onclick='addToSlideshow(this);'/>";
                    echo "  <input type='hidden' class='id' name='id[]' value='".$hpphoto->id."'/>";
                    echo "  <input type='number' class='position' name='position[]' value='".$hpphoto->homepage_position."'/>";
                    echo "  <span>".$hpphoto->name."</span>";
                    echo '</div>';
                }
            ?>
        </div>
        
        
        
        <script type="text/javascript">
            function removeFromSlideshow( hpphoto ){
                var container = hpphoto.parentNode;
                container.className = container.className.replace('in','out');
                document.getElementById("available_photos").appendChild(container);
                container.getElementsByClassName("position")[0].value = '';
                hpphoto.onclick = function(){ addToSlideshow(this); };
            }
            
            function addToSlideshow( hpphoto ){
                var container = hpphoto.parentNode;
                container.className = container.className.replace('out','in');
                var slideshowPhotos = document.getElementById("slideshow_photos");
                slideshowPhotos.appendChild(container);
                container.getElementsByClassName("position")[0].value = slideshowPhotos.getElementsByClassName('in').length;
                hpphoto.onclick = function(){ removeFromSlideshow(this);};
            }
            
            function validateSlideshow(){
                var elements = document.forms['slideshow_form'].elements;
                for( var i=0; i < elements.length; i++ ){
                    var element = elements[i];
                    console.log(element);
                    if( element.type === 'number' && element.value === ''){
                        document.getElementById('warnbox').innerHTML = 'Please Enter all Position Values';
                        return false;
                    }
                }
            }
        </script>
    </body>
</html>
