<?php
    // TODO: report view page design
?>

<?php

    $NAV_TAB = 'R';
    include_once('header.php');
    
    if (!isset($_GET['id'])) {
        ?>
            <div data-role="content">
                <h1>Invalid Report Identifier</h1>
            </div>
        <?php
    } else {
        $rep = new ReportTable($_GET['id'], $CURRENT_USER->id);
        //var_dump($rep);
    }
?>
        
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span3">
                        <div class="sidebar-nav-fixed">
                            <h5>Actions</h5>
                                <ul class="nav nav-tabs nav-stacked">
                                    <li><a href="#" onclick="alert('todo: create/edit reprots');"><i class="icon-plus"></i> New Report</a></li>
                                    <li><a href="#"><i class="icon-envelope"></i> Mail This Report</a></li>
                                    <li><a href="reports.php"><i class="icon-print"></i> Reports Menu</a></li>
                                </ul>
                        </div>
                    </div>
                    <div class="span9">
                        <h1><?php echo $rep->report->name; ?></h1>
                        <p><?php echo $rep->report->description; ?></p>
                        <?php 
                            echo $rep->table_start;
                            echo $rep->table_header;
                            echo $rep->table_body;
                            echo $rep->table_footer;
                            echo $rep->table_end;
                        ?>
                    </div>
                </div> <!-- close row -->   
            </div> <!-- close container -->
 <?php include_once('footer.php'); ?>


