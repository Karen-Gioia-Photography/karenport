<?php
    require_once "models/Gallery.php";
?>

<div class="stuckleft">
    <div id='logo'>
      <a href="."><img src="assets/logoandname.png"/></a>
    </div>
    
    <div id="menu">
        <div id='home_item' class='menuItem'>
            <a href=".">Home</a>
        </div>
        
        <?php 
            if( !empty($_GET) ){
                $selected_gallery = $_GET['id'];
                $portfolio_class = "";
            } else {
                $selected_gallery = null;
                $portfolio_class = "ninja";
            }
        ?>
        <div id='portflio_item' class='menuItem'>
            <a onclick="togglePortfolio();">Portfolio</a>
       
            <div id="portfolio" class='<?php echo $portfolio_class; ?>'>
                <?php
                    foreach(Gallery::all() as $gallery){
                        if( $gallery->id == $selected_gallery ){
                           $gallery_suffix = "&#9656;"; 
                        } else {
                            $gallery_suffix = "";
                        }

                        echo '<div class="gallery">';
                        echo '  <a href="gallery.php?id='.$gallery->id.'">';
                        echo      $gallery->name.'&nbsp;'.$gallery_suffix;
                        echo '  </a>';
                        echo '</div>';
                    }
                ?>
            </div>
        </div>
        
        <div id='about_item' class='menuItem'>
            <a href="about.php">About Me</a>
        </div>
        
        <div id='contact_item' class='menuItem'>
            <a href="contact.php">Contact</a>
        </div>
      
        <?php
             if( array_key_exists('password', $_COOKIE) && $_COOKIE['password'] == '3888cwrU' ){
                echo "<div id='admin_item' class='menuItem'>";
               echo "  <a href='admin' style='color:#d8d;'>Admin</a>";
                echo "</div>";
             }
        ?>

    </div>
    
    <div id="copyrights">
        &#169; 2014 Karen Gioia Photography
    </div>
   
</div>