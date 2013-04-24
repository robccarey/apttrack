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
    if(!isset($NAV_TAB)) {
        $NAV_TAB = '';
    }
    if (!isset($TITLE)) {
        $TITLE = 'aptTrack';
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include('headscripts.php'); ?>
        <title><?php echo $TITLE; ?></title>
    </head>
    <body data-spy="scroll" data-target=".nav-list">
        <a href="#" id="top" class="visible-phone"></a>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="brand" href="home.php">aptTrack</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li class="divider-vertical"></li>
                            <li<?php if ($NAV_TAB === 'H') { echo ' class="active"'; } ?>><a href="home.php"><i class="icon-home icon-white"></i> Home</a></li>
                            <li<?php if ($NAV_TAB === 'P') { echo ' class="active"'; } ?>><a href="projects.php"><i class="icon-folder-open icon-white"></i> Projects</a></li>
                            <li<?php if ($NAV_TAB === 'R') { echo ' class="active"'; } ?>><a href="reports.php"><i class="icon-print icon-white"></i> Reports</a></li>
                            <li class="divider-vertical"></li>
                            <li<?php if ($NAV_TAB === 'PR') { echo ' class="active"'; } ?>><a href="profile.php"><i class="icon-user icon-white"></i> Profile</a></li>
                            <li><a href="logout.php"><i class="icon-lock icon-white"></i> Log Out</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>