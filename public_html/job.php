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
                <h3 class="text-center">Invalid Item</h3>
                <p class="text-center">Click <a href="projects.php">here</a> to select a project.</p>
            </div>
        <?php
    } else {
        
        // are we creating a new job?
        if ($_GET['id'] === 'new') {
            // yes - get type
            $t = mysql_escape_string($_GET['type']);
            if ($t === 't') {
                // task
                $type = 1;
            } else {
                // deliv
                $type = 2;
            }
            $proj = mysql_escape_string($_GET['proj']);
            
            $qry_new = "INSERT INTO job (owner, creator, created, updater, updated, type, project, date_start) VALUES
                (".$CURRENT_USER->getID().", ".$CURRENT_USER->getID().", NOW(), ".$CURRENT_USER->getID().", NOW(), ".$type.", ".$proj.", NOW());";
            mysql_query($qry_new);
            if (mysql_affected_rows() > 0) {
                $id = mysql_insert_id();
            } else {
                // error
                echo $qry_new;
                echo 'error creating job';
            }
        } else {
            $id = $_GET['id'];
        }
        
        // do we have a comment to add?
        if (isset($_POST['newcom'])) {
            // prepare values
            $comment = mysql_escape_string($_POST['comment']);
            $jobid = mysql_escape_string($_POST['jobID']);
            $userid = mysql_escape_string($CURRENT_USER->getID());
            
            // prep query
            $qry_com = "INSERT INTO job_comment(comment, user, time, job) VALUES
                ('".$comment."', ".$userid.", NOW(), ".$jobid.");";
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
        
        // should we update the job?
        if (isset($_POST['update'])) {
            // yes - get variables
            $id = mysql_escape_string($_POST['jobID']);
            $title = mysql_escape_string($_POST['jobTitle']);
            $desc = mysql_escape_string($_POST['jobDesc']);
            $owner = mysql_escape_string($_POST['jobOwner']);
            $start = mysql_escape_string($_POST['jobStart']);
            $end = mysql_escape_string($_POST['jobEnd']);
            $status = mysql_escape_string($_POST['jobStatus']);
            $health = mysql_escape_string($_POST['jobHealth']);
            $prior = mysql_escape_string($_POST['jobPri']);
            $updater = $CURRENT_USER->getID();
            
            // prep query
            $qry_upd = "UPDATE job SET
                name='".$title."',
                description='".$desc."',
                owner=".$owner.",
                date_start='".$start."',
                date_end='".$end."',
                updater=".$updater.",
                updated=NOW(),
                status=".$status.",
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
                            <strong>Error!</strong> Something went wrong updating this item. Please try again later.</div>';
            }
        }
        
        // can the user view the selected job?
        $job = new Job($id);
        $canView = canReadJob($job, $CURRENT_USER);
        if (!$canView) {
            // NO
        ?>
            <div class="container">
                <h3 class="text-center">Unauthorised Request</h3>
                <p class="text-center">You are not authorised to view the selected item.</p>
                <p class="text-center">Click <a href="projects.php">here</a> to select a project.</p>
                <p class="text-center">Speak to the project manager if you require access to this item.</p>
            </div>
        <?php
        } else {
            $job->getComments();
            $comments = $job->comments;
            $proj = new Project($job->project);
            $job->getRelated();
            $related = $job->related;
            
            // yes - do they want to edit the job?
            $canEdit = canEditJob($job, $CURRENT_USER);
            if ($MODE === 'edit') {
                // yes - is the user allowed to edit?
                if (!$canEdit) {
                    // no - show message
                    ?>
                        <div class="container">
                            <h3 class="text-center">Unauthorised Request</h3>
                            <p class="text-center">You are not authorised to edit the selected item.</p>
                            <p class="text-center">Click <a href="job.php?id=<?php echo $job->id; ?>&mode=view">here</a> to view this item.</p>
                            <p class="text-center">Speak to the project manager if you need to modify this item.</p>
                        </div>
                    <?php
                } else {
                    // yes - show edit form?
                    include('jobEdit.php');
                }
            } else {
                // no - just show data
                include('jobView.php');
            }
        }
    }
include_once('footer.php'); ?>