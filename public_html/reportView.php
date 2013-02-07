<?php
    // TODO: report view page design
?>

<?php
    $PAGE_TITLE = 'aptTrack | Reports | Overdue Tasks';
    include_once('header.php');
    
    if (!isset($_GET['rid'])) {
        ?>
            <div data-role="content">
                <h1>Invalid Report Identifier</h1>
            </div>
        <?php
    } else {
        $rep = new Report($_GET['rid']);
    }
?>
        
            <div data-role="content">
                
                <h1><?php echo $rep->name; ?></h1>
                <table border="1" width="95%">
                    
<?php
    $headers = $rep->headers;
    $num_cols = count($headers);
    echo '<tr>';
    for ($i=1; $i<=$num_cols; $i++)
    {
        $tmp = $headers[$i];
        echo '<th>'.$tmp['label'].'</th>';
    }
    echo '</tr>';
    
    $data = $rep->all_data;
    $num_rows = count($data);
    for ($i=0; $i<$num_rows; $i++)
    {
        $row = $data[$i];
        echo '<tr>';
        for ($j=1; $j<=$num_cols; $j++)
        {
            $col = $headers[$j];
            echo '<td>';
            echo $row[$col['ref']];
            echo '</td>';
        }
        echo '</tr>';
    }
    
?>
                </table>
                
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


