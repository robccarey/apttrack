<?php
    // TODO: project home page design
?>

<?php
    include_once('header.php');  
?>
            <div data-role="content">
                
                <h1>Projects</h1>
                
                <script>
                    $( "#newProject" ).click(function() {
                        createNewProject();
                    });
                </script>
                
                
                <div data-role="controlgroup" data-type="horizontal">
                    <a href="#" id="newProject" data-role="button" onclick="createNewProject()">New</a>
                    <a href="#" data-role="button">Copy</a>
                    <a href="#" data-role="button">Search</a>
                </div>
                
                <div data-role="collapsible-set">
                    <div data-role="collapsible" data-content-theme="c" data-collapsed="false">
<?php

    $rl = new ReportList(2, $CURRENT_USER->id);
    echo '                        <h3>'.$rl->list_name.'</h3>';
    echo $rl->list_content;
?>  
                    </div>
                    <div data-role="collapsible" data-content-theme="c">
                        <h3>Projects I'm Involved With</h3>
                        <ul data-role="listview" data-theme="d" data-divider-theme="d">
                            <li><a href="project.php?id=1">
                                    <h3>Test Project 1</h3>
                                    <p><strong>This project exists only for test purposes. Please disregard.</strong></p>
                                    <p>2013-02-08 18:15:20</p>
                            </a></li>
                            <li><a href="project.php?id=2">
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

