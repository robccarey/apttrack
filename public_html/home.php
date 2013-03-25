<?php
    // TODO: home page design
?>

<?php
    $NAV_TAB = 'H';
    include('header.php');
    
    if ($valid_session) {
?>

    <div class="container-fluid">
        
        <div class="row-fluid">
            <div class="span3 bs-docs-sidebar">
                <div class="sidebar-nav-fixed">
                    <h4>Quick Links</h4>
                    <ul class="nav nav-tabs nav-stacked">
                        <li><a href="projects.php"><i class="icon-folder-open"></i> Projects</a></li>
                        <li><a href="reports.php"><i class="icon-print"></i> Reports</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="span9">
                <h2>Home<small> Welcome, <?php echo $CURRENT_USER->getForename(); ?>!</small></h2>
                <h4>other content</h4>
                <p>Last login: <strong><?php echo $CURRENT_USER->getPrevLogin(); ?></strong>.</p>
                
                
            </div>
        </div>
    </div>    
 <?php include('footer.php'); } ?>