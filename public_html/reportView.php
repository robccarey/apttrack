<?php
    // TODO: report view page design
?>

<?php
    $HELP_CONTENT = '<h1>Help</h1>
        <h3>View Report</h3>
        <p>To improve compatibility with smaller screens, some columns will be hidden by default when viewing
        content from a device with a narrower view port. Select which columns are shown/hidden by using the \'Columns...\' button to the right.</p>
        ';

    $PAGE_TITLE = 'aptTrack | Reports | Overdue Tasks';
    include_once('header.php');
    
    if (!isset($_GET['rid'])) {
        ?>
            <div data-role="content">
                <h1>Invalid Report Identifier</h1>
            </div>
        <?php
    } else {
        $rep = new ReportTable($_GET['rid'], $CURRENT_USER->id);
    }
?>
        
            <div data-role="content">
                
                <h1><?php echo $rep->report->name; ?></h1>
                <p><?php echo $rep->report->description; ?></p>
                <?php 
                echo $rep->table_start;
                echo $rep->table_header;
                echo $rep->table_body;
                echo $rep->table_footer;
                echo $rep->table_end;
                ?>

                
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


