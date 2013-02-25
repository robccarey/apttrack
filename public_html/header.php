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
        include_once('Classes/Health.php');
        include_once('Classes/Priority.php');
        include_once('Classes/JobType.php');
        include_once('Classes/Job.php');
        include_once('Classes/Task.php');
        include_once('Classes/Deliverable.php');
        include_once('Classes/ProjectComment.php');
        include_once('Classes/Project.php');
        include_once('Classes/Object.php');
        include_once('Classes/ReportField.php');
        include_once('Classes/Report.php');
        include_once('Classes/ReportTable.php');
        include_once('Classes/ReportList.php');
        
        $CURRENT_USER = new User($valid_session);
        //echo $CURRENT_USER->id;
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
        <
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
            </div> <!-- close header -->
            
            <div data-role="popup" id="popupError" data-position-to="#page-header" data-theme="a" class="ui-content" data-transition="slidedown">
                <p>null</p>
            </div>
            
            <script>
                $( "#popupError" ).on("popupafteropen", function() {
                   setTimeout(function() {
                       //console.log('after open popup');
                       $( "#popupError" ).popup( "close" );
                   }, 3000)
                });
            </script>
