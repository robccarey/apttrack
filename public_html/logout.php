<?php
    require('../connect.php');
    include('functions.php');
    $valid_session = checkLogin();
    if ($valid_session > 0) { 
        foreach (glob("Classes/*.php") as $filename)
        {
            include $filename;
        }
        $CURRENT_USER = new User($valid_session);
        
        $query = "UPDATE user SET login_token='logged out', login_timeout=0 WHERE id=".$CURRENT_USER->getID().";";
        mysql_query($query);
    }

    setcookie('auth','deleted',time(),'/');
    
?>

<html>
    <head>
        <meta http-equiv="refresh" content="0; URL=index.php">
        <meta name="keywords" content="automatic redirection">
    </head>
    <body>
        <p>Logging out...</p>
    </body>
</html>