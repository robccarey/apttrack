<?php
    require('../connect.php');
    include('functions.php');
    $valid_session = checkLogin();
    if ($valid_session <= 0) { 
        ?>
            <!DOCTYPE html>
            <html>
                <head>
                    <meta HTTP-EQUIV="REFRESH" content="0; url=index.php?e=s">
                </head>
                <body>
                    <p>Session timeout.</p>
                    <p>Click <a href="index.php">here</a> to log in again.</p>
                </body>
            </html>
        <?php
        return;
    } else {
        foreach (glob("Classes/*.php") as $filename)
        {
            include $filename;
        }
        $CURRENT_USER = new User($valid_session);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include('headscripts.php'); ?>
        <title>aptTrack</title>
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="brand" href="home.php">aptTrack</a>
                    <div class="nav-collapse collapse pull-right">
                        <ul class="nav">
                            <li><a href="home.php"><i class="icon-home icon-white"></i> Home</a></li>
                            <li><a href="#"><i class="icon-user icon-white"></i> Profile</a></li>
                            <li><a href="logout.php"><i class="icon-lock icon-white"></i> Log Out</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>