<?php
    // is $PAGE_TITLE set?
    if (!isset($PAGE_TITLE)) {
        $PAGE_TITLE = 'aptTrack';
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
        <script type="text/javascript">

            var _gaq = _gaq || []; _gaq.push(['_setAccount', 'UA-34975820-1']); _gaq.push(['_trackPageview']);
            (function() {
              var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
              ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
              var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
        </script>
        
        <title><?php echo $PAGE_TITLE; ?></title>
    </head>
    <body>
        <div data-role="page">
            <div data-role="header" data-id="header" data-position="fixed">
                <h1>aptTrack</h1>
                <?php
                    if (isset($LOGGED_IN)) {
                        // TODO: change for actual login check
                        ?>
                            <a href="#popupMenu" data-rel="popup" data-rel="true" class="ui-btn-right">Menu</a>
                            <div data-role="popup" id="popupMenu">
                                <ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="b">
                                    <li data-role="divider" data-theme="a">Full Name</li>
                                    <li><a href="#">Profile</a></li>
                                    <li><a href="settings.php">Settings</a></li>
                                    <li><a href="logout.php" data-ajax="false">Log Out</a></li>
                                </ul>
                            </div>
                        <?php
                    }
                ?>
            </div> <!-- close header -->
