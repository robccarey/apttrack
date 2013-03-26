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
        $rep = new ReportTable($_GET['id'], $CURRENT_USER->getID());
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
                        <h1><?php echo $rep->getReportName(); ?></h1>
                        <p><?php echo $rep->getReportDescription(); ?></p>
                        <?php 
                            echo $rep->getStart();
                            echo $rep->getHeader();
                            echo $rep->getBody();
                            echo $rep->getFooter();
                            echo $rep->getEnd();
                        ?>
                    </div>
                </div> <!-- close row -->   
            </div> <!-- close container -->
 <?php include_once('footer.php'); ?>


