<?php
    $NAV_TAB = 'PR';
    include('header.php');
    
    if ($valid_session) {
        
        if (isset($_POST['details'])) {
            // prepare variables for updating details
            $title = mysql_escape_string($_POST['title']);
            $fname = mysql_escape_string($_POST['fname']);
            $sname = mysql_escape_string($_POST['sname']);
            $email = mysql_escape_string($_POST['email']);
            
            // prep query
            $qry_det = "UPDATE user SET title=".$title.", forename='".$fname."', surname='".$sname."', email='".$email."' WHERE id=".$CURRENT_USER->getID().";";
            mysql_query($qry_det);
            if (mysql_affected_rows() > 0) {
                // success!
                $det_msg = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Success!</strong> Details updated.</div>';
                $CURRENT_USER->refresh();
            } else {
                // failure
                $det_msg = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Error!</strong> Something went wrong updating your details. Please try again later.</div>';
            }
            
        }
        
        if (isset($_POST['passwd'])) {
            // get values
            $curPass = mysql_escape_string($_POST['curPass']);
            $newPass = mysql_escape_string($_POST['newPass']);
            $confPass = mysql_escape_string($_POST['confPass']);
            
            // do new passwords match?
            if ($newPass === $confPass) {
                // yes - update db
                $qry_pass = "UPDATE user SET password=md5('".$newPass."') WHERE password=md5('".$curPass."') AND id=".$CURRENT_USER->getID().";";
                mysql_query($qry_pass);
                
                // query successful?
                if (mysql_affected_rows() > 0) {
                    // yes
                    $pass_msg = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Success!</strong> Password updated.</div>';
                } else {
                    // no
                    $pass_msg = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Error!</strong> You existing password did not match. Your password has not been updated.</div>';
                }
            } else {
                // no - password mismatch
                $pass_msg = '<div class="alert alert-block"><button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Alert!</strong> Your new passwords must match. Your password has not been updated.</div>';
            }
        }
    
?>

    <div class="container-fluid">
        
        <div class="row-fluid">
            <div class="span3 bs-docs-sidebar">
                <div class="sidebar-nav-fixed">
                    <div class="page-header visible-phone">
                        <h1>Profile <small><?php echo $CURRENT_USER->getFormalName(); ?></small></h1>
                        <p class="muted">Not you? <a href="logout.php">Log in as someone else</a>.</p>
                    </div>
                    <div class="well" style="max-width: 340px; padding: 8px 0;">
                        <ul class="nav nav-list">
                            <li class="nav-header">Quick Links</li>
                            <li><a href="home.php"><i class="icon-home"></i> Home</a></li>
                            <li><a href="projects.php"><i class="icon-folder-open"></i> Projects</a></li>
                            <li><a href="reports.php"><i class="icon-print"></i> Reports</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="span9">
                <div class="page-header hidden-phone">
                    <h1>Profile <small><?php echo $CURRENT_USER->getFormalName(); ?></small></h1>
                    <p class="muted">Not you? <a href="logout.php">Log in as someone else</a>.</p>
                </div>
                
                <section id="details">
                    <div class="page-header">
                        <h3>Details</h3>
                    </div>
                    <?php echo $det_msg; ?>
                    <form class="form-horizontal" action="profile.php#details" method="POST">
                        <input type="hidden" name="details" value="details"/>
                        
                        <div class="control-group">
                            <label class="control-label" for="title">Title</label>
                            <div class="controls">
                                <select name="title" id="title">
                                    <?php
                                        $qry_tit = "SELECT * FROM titles ORDER BY title;";
                                        $res_tit = mysql_query($qry_tit);
                                        if ($res_tit) {
                                            while ($row = mysql_fetch_assoc($res_tit)) {
                                                echo '<option value="'.$row['id'].'"';
                                                if ($CURRENT_USER->getTitleID() === $row['id']) {
                                                    echo ' selected="selected"';
                                                }
                                                echo '>'.$row['title'].'</option>';
                                            }
                                            mysql_free_result($res_tit);
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label" for="fname">Forename</label>
                            <div class="controls">
                                <input type="text" id="fname" name="fname" value="<?php echo $CURRENT_USER->getForename(); ?>"placeholder="Forename">
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label" for="sname">Surname</label>
                            <div class="controls">
                                <input type="text" id="sname" name="sname" value="<?php echo $CURRENT_USER->getSurname(); ?>" placeholder="Surname">   
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label" for="email">Email</label>
                            <div class="controls">
                                <input type="email" id="email" name="email" value="<?php echo $CURRENT_USER->getEmail(); ?>" placeholder="Email">   
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary"><i class="icon-refresh"></i> Update Details</button>
                        </div>
                    </form>
                    
                    <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
                </section>
                
                <section id="password">
                    <div class="page-header">
                        <h3>Password</h3>
                    </div>
                    <?php echo $pass_msg; ?>
                    <form class="form-horizontal" action="profile.php#passwd" method="POST">
                        <input type="hidden" name="passwd" value="passwd"/>
                        <div class="control-group">
                            <label class="control-label" for="curPass">Current Password</label>
                            <div class="controls">
                                <input type="password" id="curPass" name="curPass" placeholder="Current Password">
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label" for="newPass">New Password</label>
                            <div class="controls">
                                <input type="password" id="newPass" name="newPass" placeholder="New Password">   
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label" for="confPass">Confirm New Password</label>
                            <div class="controls">
                                <input type="password" id="confPass" name="confPass" placeholder="Confirm Password">   
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary"><i class="icon-refresh"></i> Update Password</button>
                        </div>
                    </form>
                    
                    <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
                </section>
                <ul class="nav nav-pills">
                    <li><a href="help.php">Help</a></li>
                    <li><a href="feedback.php">Feedback</a></li>
                </ul>
                
            </div>
        </div>
    </div>    
 <?php include('footer.php'); } ?>