<?php
    // TODO: report home page design
?>

<?php
    $PAGE_TITLE = 'aptTrack | Reports';
    $LOGGED_IN = true;
    include_once('header.php');
?>
        
            <div data-role="content">
                
                <h1>Reports</h1>
                
                <div data-role="controlgroup" data-type="horizontal">
                    <a href="#" data-role="button">New</a>
                    <a href="#" data-role="button">Copy</a>
                    <a href="#" data-role="button">Search</a>
                </div>
                
                <div data-role="collapsible-set">
                    <div data-role="collapsible" data-content-theme="c">
                        <h3>My Reports</h3>
                        <ul data-role="listview">
                            <li><a href="reportView.php?rid=1">Overdue Tasks</a></li>
                            <li><a href="#">Report 2</a></li>
                            <li><a href="#">Report 3</a></li>
                            <li><a href="#">Report 4</a></li>
                            <li><a href="#">Report 5</a></li>
                            <li><a href="#">Report 6</a></li>
                        </ul>
                    </div>
                    <div data-role="collapsible" data-content-theme="c">
                        <h3>Popular Reports</h3>
                        <ul data-role="listview">
                            <li><a href="#">Report 1</a></li>
                            <li><a href="#">Report 2</a></li>
                            <li><a href="#">Report 3</a></li>
                            <li><a href="#">Report 4</a></li>
                            <li><a href="#">Report 5</a></li>
                            <li><a href="#">Report 6</a></li>
                        </ul>
                    </div>
                </div>
            </div> <!-- close content -->
            <div data-role="footer" data-id="navFooter" data-position="fixed">
                <div data-role="navbar">
                    <ul>
                        <li><a href="home.php" data-transition="slide" data-direction="reverse">Home</a></li>
                        <li><a href="projects.php" data-transition="slide" data-direction="reverse">Projects</a></li>
                        <li><a href="reports.php" class="ui-btn-active ui-state-persist">Reports</a></li>
                        <li><a href="people.php" data-transition="slide">People</a></li>
                    </ul>
                </div> <!-- close footer -->
            </div>
        </div> <!-- close page -->
 <?php include_once('footer.php'); ?>

