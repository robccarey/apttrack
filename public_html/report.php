<?php
    // TODO: report view page design
?>

<?php

    $NAV_TAB = 'R';
    include_once('header.php');
    
    
    if (!isset($_GET['id'])) {
        ?>
            <div class="container">
                <h3 class="text-center">Invalid Report</h3>
                <p class="text-center">Click <a href="reports.php">here</a> to select a different report.</p>
            </div>
        <?php
    } else {
        
        // are we creating a new report?
        if ($_GET['id'] === 'new') {
            // yes
            
            // has object been specified?
            if (isset($_GET['obj'])) {
                switch ($_GET['obj']) {
                    case 'user':
                        $obj = 1;
                        break;
                    case 'proj':
                        $obj = 2;
                        break;
                    case 'task':
                        $obj = 3;
                        break;
                    case 'deliv':
                        $obj = 3;
                }
                
                $qry_new = "INSERT INTO report (creator, created, object, gen_count) VALUES (".$CURRENT_USER->getID().", NOW(), ".$obj.", 0);";
                mysql_query($qry_new);
                if (mysql_affected_rows() > 0) {
                    $id = mysql_insert_id();
                    
                    if ($obj === 3) {
                        // auto add field to specify task/deliv
                        if ($_GET['obj'] === 'task') {
                            $qry_auto = "INSERT INTO report_field (report, field, label, visible, sort, criteria, position) VALUES
                                (".$id.", 11, 'Type', 0, 0, 'EQ::1', 0);";
                        } else {
                            $qry_auto = "INSERT INTO report_field (report, field, label, visible, sort, criteria, position) VALUES
                                (".$id.", 11, 'Type', 0, 0, 'EQ::2', 0);";
                        }
                        mysql_query($qry_auto);
                    }
                }
                
                
                
            } else {
                ?>
                    <div class="container">
                        <h3 class="text-center">Insufficient Parameters</h3>
                        <p class="text-center">Click <a href="reports.php">here</a> to go to the reports menu.</p>
                    </div>
                <?php
            }
            
        } else {
            $id = $_GET['id'];
        }
        
        // should we update the report?
        if (isset($_POST['update'])) {
            // yes - get variables
            $id = mysql_escape_string($_POST['repID']);
            $title = mysql_escape_string($_POST['repTitle']);
            $instr = mysql_escape_string($_POST['repInstr']);
            $name = mysql_escape_string($_POST['repName']);
            $desc = mysql_escape_string($_POST['repDesc']);
            
            $qry_upd = "UPDATE report SET
                title='".$title."',
                instructions='".$instr."',
                name='".$name."',
                description='".$desc."'
                
                WHERE id=".$id.";";
            
            if (mysql_query($qry_upd)) {
                // success
                $msg_edit = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Success!</strong> Your changes have been saved.</div>';
            } else {
                // problem?
                $msg_edit = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Error!</strong> Something went wrong updating this report. Please try again later.</div>';
            }
        }
        
        // how are we displaying the report?
        if (isset($_GET['mode'])) {
            $mode = $_GET['mode'];
        } else {
            $mode = 'gen';
        }
        
        switch($mode) {
            case 'gen':
                include('reportGen.php');
                break;
            case 'view':
                include('reportView.php');
                break;
            case 'edit':
                include('reportEdit.php');
                break;
            default:
                include('reportGen.php');
                break;
        }
    }
?>
        
            
 <?php include_once('footer.php'); ?>


