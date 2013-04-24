<?php
    $NAV_TAB = 'PR';
    include('header.php');
    
    if ($valid_session) {
        
        if (isset($_POST['fback'])) {
            // prepare variables for updating details
            $pos = mysql_escape_string($_POST['pos']);
            $neg = mysql_escape_string($_POST['neg']);
            
            if (('x'.$pos !== 'x')||('x'.$neg !== 'x')) {
                $n = new Notification();
                $n->setRecipient('robcarey1990@gmail.com');
                $n->setSubject('[feedback] - '.$CURRENT_USER->getFullName());
                $msg = '<p>Hi Robert,</p>';
                $msg .= '<p>'.$CURRENT_USER->getFullName().' left some feedback about your project.</p>';
                $msg .= '<h3>Postive Comments</h3>';
                if ('x'.$pos === 'x') {
                    $msg .= '<p>-- null --</p>';
                } else {
                    $msg .= '<p>'.$pos.'</p>';
                }

                $msg .= '<h3>Negative Comments</h3>';
                if ('x'.$neg === 'x') {
                    $msg .= '<p>-- null --</p>';
                } else {
                    $msg .= '<p>'.$neg.'</p>';
                }


                $msg .= '<p>Hope it goes well.</p>';
                $msg .= '<p>aptTrack</p>';
                $n->setBody($msg);

                $res = $n->sendMail();

                if ($res) {
                    $output = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> <strong>Success!</strong> Thank you for taking the time to leave some comments.</div>';
                } else {
                    $output .= '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button> <strong>Error!</strong> Could not submit your feedback at this time.</div>';
                }
            }
        }
?>

    <div class="container-fluid">
        
        <div class="row-fluid">
            <div class="span3 bs-docs-sidebar">
                <div class="sidebar-nav-fixed">
                    <div class="page-header visible-phone">
                        <h1>Feedback <small>let us know what you think</small></h1>
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
                    <h1>Feedback <small>let us know what you think</small></h1>
                </div>
                
                <section id="details">
                    <?php 
                        if (isset($output)) {
                            echo $output;
                        } else {
                            ?>
                    <p>Your thoughts and comments are greatly valued in helping identify areas where aptTrack can be improved.</p>
                    <p>Thank you in advance for taking the time to let us know about your experience.</p>
                            <?php
                        }
                     ?>
                    <form class="form-horizontal" action="feedback.php" method="POST">
                        <input type="hidden" name="fback" value="fback"/>
                        
                        
                        
                        <div class="control-group">
                            <label class="control-label" for="pos">Positives</label>
                            <div class="controls">
                                <textarea id="pos" name="pos"></textarea>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label" for="neg">Negatives</label>
                            <div class="controls">
                                  <textarea id="neg" name="neg"></textarea>
                            </div>
                        </div>
                        
                        
                        
                        <div class="form-actions">
                            <button type="reset" class="btn">Cancel</button>
                            <button type="submit" class="btn btn-primary"><i class="icon-refresh"></i> Submit Feedback</button>
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