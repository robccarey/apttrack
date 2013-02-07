<?php
    // TODO: project home page design
?>

<?php
    $PAGE_TITLE = 'aptTrack | Projects';
    $LOGGED_IN = true;
    include_once('header.php');  
    
?>
            
            <div data-role="content">
                
                <h1>Projects</h1>
                
                <div data-role="controlgroup" data-type="horizontal">
                    <a href="#" data-role="button">New</a>
                    <a href="#" data-role="button">Copy</a>
                    <a href="#" data-role="button">Search</a>
                </div>
                
                <div data-role="collapsible-set">
                    <div data-role="collapsible" data-content-theme="c">
                        <h3>My Projects</h3>
                        
<?php
    // list project owned by current user
    $qry_proj_own = "SELECT id FROM project WHERE owner=".$CURRENT_USER->getID().";";
    $res_proj_own = mysql_query($qry_proj_own);
    $count = 0;
    $own_projects = array();
    if ($res_proj_own) {
        // query successful
        while ($row_proj_own = mysql_fetch_assoc($res_proj_own)) {
            //echo 'found a project';
            $own_projects[] = new Project($row_proj_own['id']);
            $count++;
        }
    } else {
        //echo 'query error';
    }
    mysql_free_result($res_proj_own);
    
    if ($count > 0) {
        // some projects identified...
        echo '<ul data-role="listview" data-theme="d" data-divider-theme="d">';
        //var_dump($own_projects);
        foreach ($own_projects as $p) {
            // TODO: add link to project view page
            //if (isset($p->id)) {
                echo '<li><a href="projectView.php?pid='.$p->id.'">';
                echo '<h3>'. $p->name .'</h3>';
                echo '<p><strong>'.$p->description.'</strong></p>';
                echo '<p>Last updated: '.$p->updated.'</p>';
                echo '</a></li>';
            //}
        }
        echo '</ul>';
    } else {
        echo "<p><i>You don't own any projects yet.</i></p>";
    }
?>  
                    </div>
                    <div data-role="collapsible" data-content-theme="c">
                        <h3>Projects I'm Involved With</h3>
                        <ul data-role="listview" data-theme="d" data-divider-theme="d">
                            <li><a href="#">
                                    <h3>Project Name</h3>
                                    <p><strong>This line outlines the project description...</strong></p>
                                    <p>Last updated: 3 hours ago</p>
                            </a></li>
                            <li><a href="#">
                                    <h3>Project Name</h3>
                                    <p><strong>This line outlines the project description...</strong></p>
                                    <p>Last updated: 3 hours ago</p>
                            </a></li>
                            <li><a href="#">
                                    <h3>Project Name</h3>
                                    <p><strong>This line outlines the project description...</strong></p>
                                    <p>Last updated: 3 hours ago</p>
                            </a></li>
                            <li><a href="#">
                                    <h3>Project Name</h3>
                                    <p><strong>This line outlines the project description...</strong></p>
                                    <p>Last updated: 3 hours ago</p>
                            </a></li>
                            <li><a href="#">
                                    <h3>Project Name</h3>
                                    <p><strong>This line outlines the project description...</strong></p>
                                    <p>Last updated: 3 hours ago</p>
                            </a></li>
                            <li><a href="#">
                                    <h3>Project Name</h3>
                                    <p><strong>This line outlines the project description...</strong></p>
                                    <p>Last updated: 3 hours ago</p>
                            </a></li>
                            <li><a href="#">
                                    <h3>Project Name</h3>
                                    <p><strong>This line outlines the project description...</strong></p>
                                    <p>Last updated: 3 hours ago</p>
                            </a></li>
                        </ul>
                    </div>
                </div>
                
                
                
            </div> <!-- close content -->
            <div data-role="footer" data-id="navFooter" data-position="fixed">
                <div data-role="navbar">
                    <ul>
                        <li><a href="home.php" data-transition="slide" data-direction="reverse">Home</a></li>
                        <li><a href="projects.php" class="ui-btn-active ui-state-persist">Projects</a></li>
                        <li><a href="reports.php" data-transition="slide">Reports</a></li>
                        <li><a href="people.php" data-transition="slide">People</a></li>
                    </ul>
                </div> <!-- close footer -->
            </div>
        </div> <!-- close page -->
 <?php include_once('footer.php'); ?>

