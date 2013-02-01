<?php
    // TODO: home page design
?>

<?php
    $PAGE_TITLE = 'aptTrack | Home';
    $LOGGED_IN = true;
    include_once('header.php');
?>
            <div data-role="content">
                
                <h1>Welcome #User</h1>
                <p>Home</p>
                
            </div> <!-- close content -->
            <div data-role="footer" data-id="navFooter" data-position="fixed">
                <div data-role="navbar">
                    <ul>
                        <li><a href="home.php" class="ui-btn-active ui-state-persist">Home</a></li>
                        <li><a href="projects.php" data-transition="slide">Projects</a></li>
                        <li><a href="reports.php" data-transition="slide">Reports</a></li>
                        <li><a href="people.php" data-transition="slide">People</a></li>
                    </ul>
                </div> <!-- close footer -->
            </div>
        </div> <!-- close page -->
 <?php include_once('footer.php'); ?>

