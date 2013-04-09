<?php
    // TODO: home page design
?>

<?php
    $NAV_TAB = 'H';
    include('header.php');
    
    if ($valid_session) {
?>

    <div class="container-fluid">
        <div class="page-header visible-phone">
            <h1>Home<small> Welcome, <?php echo $CURRENT_USER->getForename(); ?>!</small></h1> 
        </div>
        <div class="row-fluid">
            <div class="span3">
                <div class="sidebar-nav-fixed">
                    <div class="well" style="max-width: 340px; padding: 8px 0;">
                        <ul class="nav nav-list">
                            <li class="nav-header">Quick Links</li>
                            <li><a href="projects.php"><i class="icon-folder-open"></i> Projects</a></li>
                            <li><a href="reports.php"><i class="icon-print"></i> Reports</a></li>
                        
                            <li class="nav-header">Jump To...</li>
                            <li><a href="#myprojects"><i class="icon-folder-open"></i> My Projects</a></li>
                            <li><a href="#mytasks"><i class="icon-tasks"></i> My Tasks</a></li>
                            <li><a href="#mydelivs"><i class="icon-folder-close"></i> My Deliverables</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="span9">
                <div class="page-header hidden-phone">
                    <p class="pull-right muted">Last login: <strong><?php echo $CURRENT_USER->getPrevLogin(); ?></strong></p>
                    <h1>Home<small> Welcome, <?php echo $CURRENT_USER->getForename(); ?>!</small></h1> 
                </div>
                
                <section id="myprojects">
                    <?php
                        $mp = new ReportList(2, $CURRENT_USER->getID());
                        echo '<h2>'.$mp->getName().'</h2>';
                        echo '<ul class="nav nav-tabs nav-stacked">';
                        echo $mp->getContent();
                        echo '</ul>';
                    ?>
                </section>
                
                <section id="mytasks">
                    <?php
                        $mt = new ReportList(5, $CURRENT_USER->getID());
                        echo '<h2>'.$mt->getName().'</h2>';
                        echo '<ul class="nav nav-tabs nav-stacked">';
                        echo $mt->getContent();
                        echo '</ul>';
                    ?>
                </section>
                
                <section id="mydelivs">
                    <?php
                        $md = new ReportList(6, $CURRENT_USER->getID());
                        echo '<h2>'.$md->getName().'</h2>';
                        echo '<ul class="nav nav-tabs nav-stacked">';
                        echo $md->getContent();
                        echo '</ul>';
                    ?>
                </section>
            </div>
        </div>
    </div>    
 <?php include('footer.php'); } ?>