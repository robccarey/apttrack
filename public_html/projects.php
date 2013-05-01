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
                <div class="well" style="max-width: 340px; padding: 8px 0;">
                    <ul class="nav nav-list">
                        <li class="nav-header">Actions</li>
                        <li><a href="project.php?id=new&mode=edit"><i class="icon-plus"></i> New Project</a></li>
                        <li><a href="search.php"><i class="icon-search"></i> Search</a></li>
                    
                        <li class="nav-header">Jump To...</li>
                        <li><a href="#myproj">My Projects</a></li>
                        <li><a href="#invproj">Projects I'm Involved With</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="span9">
            <div class="page-header hidden-phone">
                <h1>Projects Home</h1>
            </div>
            <section id="myproj">
                <?php

                    $rl = new ReportList(2, $CURRENT_USER->getID());
                    echo '<h2>'.$rl->getName().'</h2>';
                    echo '<ul class="nav nav-tabs nav-stacked">';
                    echo $rl->getContent();
                    echo '</ul>';
                ?> 
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> top</a>
            </section>
            
            <section id="invproj">
                <h2>Projects I'm Involved With</h2>
                <?php
                    $query = "SELECT project.id, project.name, project.description, DATE_FORMAT(project.updated, '%d-%b-%y %H:%i') as updated FROM project, job
                        WHERE project.id=job.project AND project.owner!=".$CURRENT_USER->getID()." AND (job.owner=".$CURRENT_USER->getID()." OR job.creator=".$CURRENT_USER->getID().") GROUP BY project.id
                        
                        UNION
                        SELECT project.id, project.name, project.description, DATE_FORMAT(project.updated, '%d-%b-%y %H:%i') as updated FROM project, project_user WHERE project.owner!=".$CURRENT_USER->getID()." AND project.id=project_user.project AND project_user.user=".$CURRENT_USER->getID().";";
                    $result = mysql_query($query);
                    if ($result) {
                        echo '<ul class="nav nav-tabs nav-stacked">';
                        if (mysql_num_rows($result) > 0) {
                            while ($row = mysql_fetch_assoc($result)) {
                                echo '<li><a href="project.php?id='.$row['id'].'">';
                                echo '<h4 style="color: #000000;">'.$row['name'];
                                echo '<small> '.$row['description'].'</small></h4>';
                                echo '<p class="muted">Last updated:<strong> '.$row['updated'].'</strong></p>';
                                echo '</a></li>';
                            }
                        } else {
                            echo '<li><a class="muted">0 items found</a></li>';
                        }
                        echo '</ul>';
                        mysql_free_result($result);
                    }
                ?> 
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> top</a>
            </section>
            
            <ul class="nav nav-pills">
                <li><a href="help.php">Help</a></li>
                <li><a href="feedback.php">Feedback</a></li>
            </ul>
                
        </div>
    </div>    
</div>
    

 


        </div> <!-- close page -->
 <?php include_once('footer.php'); ?>

