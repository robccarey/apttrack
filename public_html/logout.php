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
        
        
        // get cookie details
        list($identifier, $token) = explode(':', $_COOKIE['at']);
        
        if ('x'.$identifier === 'x' || 'x'.$token === 'x')
        {
            // cookie does not exist - return 0
            return 0;
        }
    
        // cookie exists - cookie has valid information?
        $clean = array();
        if (ctype_alnum($identifier) && ctype_alnum($token))
        {
            $clean['identifier'] = $identifier;
            $clean['token'] = $token;
        }
        $query = "DELETE FROM session WHERE identifier='".$clean['identifier']."' AND token='".$clean['token']."';";
        //$query = "UPDATE session SET login_token='logged out', login_timeout=0 WHERE id=".$CURRENT_USER->getID().";";
        mysql_query($query);
    }

    setcookie('at','deleted',time(),'/');
    session_start();
    session_destroy();
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