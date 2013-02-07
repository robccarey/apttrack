<?php
    // TODO: people home page design
?>

<?php
    $PAGE_TITLE = 'aptTrack | People';
    $LOGGED_IN = true;
    include_once('header.php');
?>
        
            <div data-role="content">
                
                <h1>People</h1>
                
            </div> <!-- close content -->
            <div data-role="footer" data-id="navFooter" data-position="fixed">
                <div data-role="navbar">
                    <ul>
                        <li><a href="home.php" data-transition="slide" data-direction="reverse">Home</a></li>
                        <li><a href="projects.php" data-transition="slide" data-direction="reverse">Projects</a></li>
                        <li><a href="reports.php" data-transition="slide" data-direction="reverse">Reports</a></li>
                        <li><a href="people.php" class="ui-btn-active ui-state-persist">People</a></li>
                    </ul>
                </div> <!-- close footer -->
            </div>
        </div> <!-- close page -->
 <?php include_once('footer.php'); ?>

