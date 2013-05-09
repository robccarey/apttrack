<?php
    $NAV_TAB = 'M';
    include('header.php');
    
    if ($valid_session) {
        
?>

    <div class="container-fluid">
        
        <div class="row-fluid">
            <div class="span3 bs-docs-sidebar">
                <div class="sidebar-nav-fixed">
                    <div class="page-header visible-phone">
                        <h1>Manage Sessions</h1>
                    </div>
                    <div class="well" style="max-width: 340px; padding: 8px 0;">
                        <ul class="nav nav-list">
                            <li class="nav-header">Quick Links</li>
                            <li><a href="home.php"><i class="icon-home"></i> Home</a></li>
                            <li><a href="projects.php"><i class="icon-folder-open"></i> Projects</a></li>
                            <li><a href="reports.php"><i class="icon-print"></i> Reports</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="span9">
                <div class="page-header hidden-phone">
                    <h1>Manage Sessions</h1>
                </div>
                
                <p class='lead'>Make sure you're in control of which devices allow you to automatically log in to aptTrack.</p>
                <p>By default, aptTrack uses cookies to store a small token, or key, on your computer each time you login to make
                it easier to authenticate you each time you visit.</p>
                <section id="sessions">
                    <div class="page-header">
                        <h3>My Sessions</h3>
                    </div>
                    
                    <div id="sessionTab">
                        <div id="msgbox"></div>
                    <?php include('sessionTable.php'); ?>
                    </div>
                    
                    <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
                </section>
                
                
                
                <ul class="nav nav-pills">
                    <li><a href="help.php">Help</a></li>
                    <li><a href="feedback.php">Feedback</a></li>
                </ul>
                
            </div>
        </div>
    </div>    
 <?php include('footer.php'); } ?>