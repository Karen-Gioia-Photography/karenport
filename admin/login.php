<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="../assets/admin.css"/>
    </head>
    <body>
        <div id="main">
            <div class="header">Login</div>
            <?php 
            if(array_key_exists('msg', $_GET)){
                echo '<div>';
                if( $_GET['msg'] == 'invalidpassword' ){
                    echo 'Invalid Password';
                } else if( $_GET['msg'] == 'missingpassword' ){
                    echo 'You must enter a password';
                }
                echo '</div>';
            } 
            ?>
            <form method="POST" action="task/post_login.php">
                <span>Password:</span>
                <input name="password" type='password'/> 
                <button type="submit">Enter</button>
            </form>
        </div>
    </body>
</html>
