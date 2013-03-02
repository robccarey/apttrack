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
        foreach (glob("Classes/*.php") as $filename)
        {
            include $filename;
        }
        $CURRENT_USER = new User($valid_session);
        
    }
?>

<?php
    // is $PAGE_TITLE set?
    if (!isset($PAGE_TITLE)) {
        $PAGE_TITLE = 'aptTrack';
    }
    
    // help content provided?
    if (!isset($HELP_CONTENT)) {
        $HELP_CONTENT = '<h1>Demo Content</h1>
                <p>Text in here looks kind of nice and will be a perfect way of showing
                    helpful information. The design is unintrusive so ideal for providing
                    new users with additional tips while allowing more experienced users
                    the space to get down to business.</p>
                <h3>Tips</h3>
                <ul>
                    <li>Use the <a href="settings.php">settings menu</a> to customise what reports you receive.</li>
                    <li>Create your own report and add it to your home screen for convenient access.</li>
                    <li>More soon.</li>
                </ul>';
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <?php include_once('headscripts.php'); ?>
        <title><?php echo $PAGE_TITLE; ?></title>
    </head>
    <body>
        <div id="pageid" data-role="page">
            <div data-role="panel" id="help-panel" data-position-fixed="true" data-theme="a">
                <?php echo $HELP_CONTENT; ?>
            </div> <!-- close panel -->
            <div data-role="header" id="page-header"data-id="header" data-position="fixed" data-theme="b">
                
                <a href="#help-panel" data-role="button" data-icon="info" data-iconpos="notext">Help</a>
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
                 
                <div data-role="popup" id="popupError" data-position-to="#page-header" data-theme="a" class="ui-content" data-transition="slidedown">
                </div>
                <div data-role="popup" id="popupAlert" data-position-to="#page-header" data-theme="e" class="ui-content" data-transition="slidedown">
                </div>
            </div> <!-- close header -->
            
            
