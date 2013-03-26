<?php
    // TODO: project home page design
?>

<?php
    $NAV_TAB='P';
    include_once('header.php');  
?>
         
<script>
    $( "#newProject" ).click(function() {
        createNewProject();
    });
</script>
   
<div class="container-fluid">
    <div class="page-header visible-phone">
        <h1>Projects Home</h1>
    </div>
    <div class="row-fluid">
        <div class="span3">
            <div class="sidebar-nav-fixed">
                <h5>Actions</h5>
                <ul class="nav nav-tabs nav-stacked">
                    <li><a href="project.php?id=new&mode=edit"><i class="icon-plus"></i> New Project</a></li>
                    <li><a href="#"><i class="icon-file"></i> Copy</a></li>
                    <li><a href="#"><i class="icon-search"></i> Search</a></li>
                </ul>

                <h5>Jump To...</h5>
                <ul class="nav nav-tabs nav-stacked" >
                    <li><a href="#rl2">My Projects</a></li>
                    <li><a href="#rl2b">Something else.</a></li>
                    <li><a href="#rl2c">Bottom of page.</a></li>
                </ul>
            </div>
        </div>
        <div class="span9">
            <div class="page-header hidden-phone">
                <h1>Projects Home</h1>
            </div>
            <div id="rl2">
                <?php

                    $rl = new ReportList(2, $CURRENT_USER->getID());
                    echo '<h2>'.$rl->getName().'</h2>';
                    echo '<ul class="nav nav-tabs nav-stacked">';
                    echo $rl->getContent();
                    echo '</ul>';
                ?> 
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> top</a>
            </div>
            
            <div id="rl2b">
                <?php

                    $rl2b = new ReportList(2, $CURRENT_USER->getID());
                    echo '<h2>'.$rl2b->getName().' (test B)</h2>';
                    echo '<ul class="nav nav-tabs nav-stacked">';
                    echo $rl2b->getContent();
                    echo '</ul>';
                ?> 
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> top</a>
            </div>
            
            <div id="rl2c">
                <?php

                    $rl2c = new ReportList(2, $CURRENT_USER->getID());
                    echo '<h2>'.$rl2c->getName().' (test C)</h2>';
                    echo '<ul class="nav nav-tabs nav-stacked">';
                    echo $rl2c->getContent();
                    echo '</ul>';
                ?> 
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> top</a>
            </div>
        </div>
    </div>    
</div>
    

 


        </div> <!-- close page -->
 <?php include_once('footer.php'); ?>

