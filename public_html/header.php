<?php
    require('../connect.php');
    include('functions.php');
    $valid_session = checkLogin();
    if ($valid_session <= 0) { 
        ?>
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
        include_once('Classes/Title.php');
        include_once('Classes/User.php');
        include_once('Classes/Visibility.php');
        include_once('Classes/Tag.php');
        include_once('Classes/Status.php');
        include_once('Classes/Task.php');
        include_once('Classes/Deliverable.php');
        include_once('Classes/Project.php');
        include_once('Classes/Object.php');
        include_once('Classes/ReportField.php');
        include_once('Classes/Report.php');
        
        $CURRENT_USER = new User($valid_session);
    }
?>

<?php
    // is $PAGE_TITLE set?
    if (!isset($PAGE_TITLE)) {
        $PAGE_TITLE = 'aptTrack';
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <?php include_once('headscripts.php'); ?>
        <title><?php echo $PAGE_TITLE; ?></title>
    </head>
    <body>
        <div data-role="page">
            <div data-role="header" data-id="header" data-position="fixed">
                <h1>aptTrack</h1>
                
                 <a href="#popupMenu" data-rel="popup" data-rel="true" class="ui-btn-right">Menu</a>
                 <div data-role="popup" id="popupMenu">
                    <ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="b">
                        <li data-role="divider" data-theme="a"><?php echo $CURRENT_USER->getFormalName(); ?></li>
                        <li><a href="#">Profile</a></li>
                        <li><a href="settings.php">Settings</a></li>
                        <li><a href="logout.php" data-ajax="false">Log Out</a></li>
                    </ul>
                </div>
            </div> <!-- close header -->
