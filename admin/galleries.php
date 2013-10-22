<?php    
    require_once '../models/Gallery.php';
    require_once '../models/Photo.php';
?>


<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Karen Gioia Admin</title>
        <link rel="stylesheet" type="text/css" href="/assets/admin.css"/>
    </head>
    <body>
        <div id="main">
        <div class="header">Galleries</div>
        
        <div class="righty"><a href="/admin">Admin Home</a></div>
        
        <table id="galleries">
            <thead>
                <tr>
                    <th>Position</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>View Images</th>
                    <th>Action</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                    $galleries = Gallery::all();
                    foreach ( $galleries as $gallery ): 
                ?>
                <form action="/task/post_update_gallery.php" method="post">
                    <tr class="gallery <?php echo ($gallery->homepage_position % 2) ? "even" : "odd" ?>">
                    
                        <td><input type="number" name="position" value="<?php echo $gallery->homepage_position ?>"/></td>
                        <td><input type="text"   name="name"     value="<?php echo $gallery->name ?>"/></td>
                        <td><textarea            name='description'><?php echo $gallery->description ?></textarea></td>
                        <td><a href="gallery.php?id=<?php echo $gallery->id ?>">View Images</a></td>
                        <td><button type="submit"/>Update</td>
                    </tr>
                </form>
                <?php endforeach; ?>
                
                <form action="/task/post_new_gallery.php" method="post">
                    <tr class="new gallery">
                        <?php $new_gal_position = sizeof($galleries)*5; ?>
                        <td><input type="hidden"  name="position" value="<?php echo $new_gal_position ?>"></input><div><?php echo $new_gal_position ?></div></td>
                        <td><input type="text"    name="name"   value="New Gallery"></input></td>
                        <td><textarea name='description'></textarea></td>
                        <td></td>
                        <td><button type="submit"/>Create</td>
                   
                    </tr>
                </form>
            </tbody>
        </table>
        </div>
        
        

    </body>
</html>
