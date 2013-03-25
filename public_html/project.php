<?php

    if (isset($_GET['mode'])) {
        $MODE = $_GET['mode'];
    } else {
        $MODE = 'view';
    }
    $NAV_TAB = 'P';
    include('header.php');
    
    if (!isset($_GET['id'])) {
        ?>
            <div class="container">
                <h3 class="text-center">Invalid Project</h3>
                <p class="text-center">Click <a href="projects.php">here</a> to select a different project.</p>
            </div>
        <?php
    } else {
        
        // are we creating a new project?
        if ($_GET['id'] === 'new') {
            // yes
            $qry_new = "INSERT INTO project (owner, creator, created, updater, updated) VALUES
                (".$CURRENT_USER->getID().", ".$CURRENT_USER->getID().", NOW(), ".$CURRENT_USER->getID().", NOW());";
            mysql_query($qry_new);
            if (mysql_affected_rows() > 0) {
                $id = mysql_insert_id();
            }
        } else {
            $id = $_GET['id'];
        }
        
        // do we have a comment to add?
        if (isset($_POST['newcom'])) {
            // prepare values
            $comment = mysql_escape_string($_POST['comment']);
            $projid = mysql_escape_string($_POST['projID']);
            $userid = mysql_escape_string($CURRENT_USER->getID());
            
            // prep query
            $qry_com = "INSERT INTO project_comment (comment, user, time, project) VALUES
                ('".$comment."', ".$userid.", NOW(), ".$projid.");";
            mysql_query($qry_com);
            if (mysql_affected_rows() > 0) {
                // success
                $msg_com = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Success!</strong> Your comment has been added.</div>';
            } else {
                // failure
                $msg_com = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Error!</strong> Unable to add your comment at this time. Please try again later.</div>';
            }
            
        }
        
        // should we update the project?
        if (isset($_POST['update'])) {
            // yes - get variables
            $id = mysql_escape_string($_POST['projID']);
            $title = mysql_escape_string($_POST['projTitle']);
            $desc = mysql_escape_string($_POST['projDesc']);
            $owner = mysql_escape_string($_POST['projOwner']);
            $start = mysql_escape_string($_POST['projStart']);
            $end = mysql_escape_string($_POST['projEnd']);
            $status = mysql_escape_string($_POST['projStatus']);
            $visib = mysql_escape_string($_POST['projVis']);
            $health = mysql_escape_string($_POST['projHealth']);
            $prior = mysql_escape_string($_POST['projPri']);
            $updater = $CURRENT_USER->getID();
            
            // prep query
            $qry_upd = "UPDATE project SET
                name='".$title."',
                description='".$desc."',
                owner=".$owner.",
                date_start='".$start."',
                date_end='".$end."',
                updater=".$updater.",
                updated=NOW(),
                status=".$status.",
                visibility=".$visib.",
                health=".$health.",
                priority=".$prior."
                
                WHERE id=".$id.";";
            mysql_query($qry_upd);
            if (mysql_affected_rows() > 0) {
                // success
                $msg_edit = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Success!</strong> Your changes have been saved.</div>';
            } else {
                // problem
                $msg_edit = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Error!</strong> Something went wrong updating this project. Please try again later.</div>';
            }
        }
        
        // can the current user view the selected project?
        $proj = new Project($id);
        $canView = canReadProject($proj, $CURRENT_USER);
        if (!$canView) {
            // NO
        ?>
            <div class="container">
                <h3 class="text-center">Unauthorised Request</h3>
                <p class="text-center">You are not authorised to view the selected project.</p>
                <p class="text-center">Click <a href="projects.php">here</a> to select a different project.</p>
                <p class="text-center">Speak to the project manager if you require access to this project.</p>
            </div>
        <?php
        } else {
            $proj->getComments();
            $comments = $proj->comments;
            $canEdit = canEditProject($proj, $CURRENT_USER);
            // yes - do they want to edit the project?
            if ($MODE === 'edit') {
                // yes - is the user allowed to edit?
                
                if (!$canEdit) {
                    // no - show message
                    ?>
                        <div class="container">
                            <h3 class="text-center">Unauthorised Request</h3>
                            <p class="text-center">You are not authorised to edit the selected project.</p>
                            <p class="text-center">Click <a href="projects.php">here</a> to select a different project.</p>
                            <p class="text-center">Speak to the project manager if you need to modify this project.</p>
                        </div>
                    <?php
                } else {
                    // yes - show edit form
                    include('projectEdit.php');
                }
            } else {
                // no - just display read-only version
                include('projectView.php');
            }
        }
    }
?>
 <?php include_once('footer.php'); ?>