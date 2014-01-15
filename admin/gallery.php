<?php 
    ob_start();
    require_once '../models/Gallery.php';
    require_once '../models/Photo.php';
?>
<!DOCTYPE html>
<html>
    <head>
      <?php require '_headers.php' ?>
    </head>
    <body>
        <?php
            if( !array_key_exists("id", $_GET) ){
                echo ("<div>Must supply key to view Gallery Images</div>");
            } else {
                $gallery = Gallery::find($_GET['id']);
 
        ?>
        <div id="main">
            <div class="header"><span>Gallery: </span><span><?php echo $gallery->name ?></span></div>
            
            <div class="righty"><a href=".">Admin Home</a></div>
            <div class="righty"><a href="galleries.php">Manage Galleries</a></div>
            
            
            <div class="lefty"><span>Homepage Position: </span><span><?php echo $gallery->homepage_position ?></span></div>   
            <div class="lefty"><span>Description: </span><span><?php echo $gallery->description ?></span></div>   
            
                
            <div class="images">
                <br/><br/>
                <table id="galleries">
                    <thead>
                        <tr>
                            <th>Position</th>
                            <th>Name & Image</th>
                            <th>Link & Description</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $photos = $gallery->getPhotos();
                            $max_gal_position = 0;
                            foreach ( $photos as $photo ): 
                        ?>
                      <form action="task/post_update_photo.php" method="post">
                            <input type="hidden" name="gallery" value="<?php echo $gallery->id ?>"/>
                            <input type="hidden" name="id" value="<?php echo $photo->id ?>"/>
                            <tr class="gallery <?php echo ($photo->gallery_position % 2) ? "even" : "odd" ?>">
                                <?php if( $photo->gallery_position > $max_gal_position ){ $max_gal_position = $photo->gallery_position; }  ?>
                                <td><input type="number" name="position" value="<?php echo $photo->gallery_position ?>"/></td>
                                <td class="nameimag">
									<input type="text"   name="name"     value="<?php echo $photo->name ?>"/>
									<img src="<?php echo "../".$photo->path ?>"/>
								</td>
                                <td class="linkdesc">
									<input type="text" name="link" value="<?php echo htmlspecialchars($photo->link) ?>"></input>
									<textarea name="description"><?php echo htmlspecialchars($photo->description) ?></textarea>
								</td>
                                <td><button type="submit">Update</button><a name="<?php echo $photo->id ?>"></a></td>
                              <td><a href="task/get_delete_photo.php?id=<?php echo $photo->id; ?>"><button type="button">Delete</button</a></td>
                            </tr>
                        </form>
                        <?php endforeach; ?>

						<form action="task/post_new_photo.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="gallery" value="<?php echo $gallery->id ?>"/>
                            <tr class="new gallery">
                                <?php $new_gal_position = $max_gal_position + 5; ?>
                                <td><input type="text" readonly="readonly" name="position" value="<?php echo $new_gal_position ?>"></input></td>
                                <td class="nameimag">
									<input type="text"    name="name"   value="New Image"></input>
									<input type="text"    name="image_file" value="File Name"></input>
								</td>
                                <td class="linkdesc">
									<input type="text"	  name="link" value="Link"></input>
									<textarea name="description">Description</textarea>	
								</td>
                                <td><button type="submit">Create</button></td>
                                <td></td>
                            </tr>
                        </form>
                    </tbody>
                </table>
                
                
                
            </div>
        <?php
            }
        ?>
        </div>
    </body>
</html>
