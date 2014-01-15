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
            <div id="gallery_container">
				<div id="scrollist">
					<?php
					$gallery = Gallery::find($_GET['id']);
					if( $gallery ){
					?> 
					<h1><?php echo $gallery->name ?> </h1> 
					<?php
						foreach($gallery->getPhotos() as $photo){ 
							?>
							<div class="scrollistItem">
								<a href="<?php echo $photo->link ?>">
									<span class="scrollistImage">
										<img src="<?php echo $photo->path ?>"/>
									</span>
									<span class="scrollistDescription">
										<?php echo htmlspecialchars($photo->description) ?>
									</span>
								</a>
							</div>
							<?php
						}
					}
					?>
				</div>
			</div>
        </div>
        
    </body>
</html>
