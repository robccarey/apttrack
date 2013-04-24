<?php

    // connect to db
    require('../connect.php');
    
    if(isset($_POST['submit'])) {
        // clean all values
        $clean = array();
        $clean['title'] = mysql_real_escape_string($_POST['titleSelect']);
        $clean['fname'] = mysql_real_escape_string($_POST['fname']);
        $clean['sname'] = mysql_real_escape_string($_POST['sname']);
        $clean['email'] = mysql_real_escape_string($_POST['email']);
        $clean['password1'] = mysql_real_escape_string($_POST['password1']);
        $clean['password2'] = mysql_real_escape_string($_POST['password2']);
        
        
        // do passwords match?
        if ($clean['password1'] === $clean['password2']) {
            // yes - is there already an account with the provided email?
            $qry_used = "SELECT COUNT(*) as count FROM user WHERE email='".$clean['email']."';";
            $res_used = mysql_query($qry_used);
            if($res_used) {
                
                // query successful
                $row_email_used = mysql_fetch_assoc($res_used);
                $count_email_used = $row_email_used['count'];

                if ($count_email_used == 0) {
                    // all ok - add new user
                    $qry_create_user = "INSERT INTO user (title, forename, surname, email, password, account_status, account_type, created, login_token, login_timeout)
                        values (".$clean['title'].", '".$clean['fname']."', '".$clean['sname']."', '".$clean['email']."', md5('".$clean['password1']."'), 1, 2, NOW(), 'logged out', 0);";
                    if(mysql_query($qry_create_user)) {
                        // user added
                        $show_form = false;

                        include ('Classes/Notification.php');
                        $n = new Notification();
                        $n->setRecipient($clean['email']);
                        $n->setSubject('aptTrack - new user');
                        $msg = '<p>Hi '.$clean['fname'].',</p>';
                        $msg .= '<p>Welcome to <strong>aptTrack</strong></p>';
                        $msg .= '<p>You can now log in using the email address and password specified when you signed up.</p>';
                        $msg .= '<p>Happy tracking!</p>';
                        $msg .= '<p>aptTrack Team</p>';
                        $n->setBody($msg);
                        
                        $res = $n->sendMail();
                        $output = '<h1 align="center">Success!</h1>
                                <p align="center">You will receive an email shortly confirming your new account details. In the mean time, why not <a href="index.php">login</a> and have a look around?</p>';
                        if (!$res) {
                            $output .= '<p style="color: #ff0000;"><i>Error sending confirmation email.</i></p>';
                        }
                    } else {
                        // error in query
                        $show_form = true;
                        $error = 'Problem with create-user query.';
                    }

                } else {
                    // email used in another account
                    $show_form = true;
                    $error = 'The email address provided is already in use. Use the <a href="forgotpassword.php">password recovery</a> tool to reset your password.';
                    // TODO: link to account recovery
                }
                mysql_free_result($res_used);
            }
        } else {
            // no - passwords don't match
            $error = 'Your password confirmation does not match. Please try again.';
            $show_form = true;
        }
    } else {
        $show_form = true;
    }
    
        // prepare titles option content.
        $qry_tit = "SELECT * FROM titles ORDER BY title;";
        $res_tit = mysql_query($qry_tit);
        if ($res_tit) {
            $titles_selector_content = "";
            while ($row = mysql_fetch_assoc($res_tit)) {
                $titles_selector_content = $titles_selector_content.'<option value="'.$row['id'].'">'.$row['title'].'</option>';
            }
            mysql_free_result($res_tit);
        }
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include('headscripts.php'); ?>
        <title>aptTrack</title>
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="brand" href="index.php">aptTrack</a>
                </div>
            </div>
        </div>
            
        <div class="container">
            <h3>Sign Up</h3>
            <?php
                if($show_form) {
            ?>
            <p>Enter your details below.</p>
            <form class="form-horizontal" action="signup.php" method="post" id="signup" name="signup">
                <?php if (isset($error)) {
                    echo '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$error.'</div>';
                } ?>

                <div class="control-group">
                    <label class="control-label" for="titleSelect">Title</label>
                    <div class="controls">
                        <select name="titleSelect" id="titleSelect" required>
                        <?php echo $titles_selector_content; ?>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="fname">Forename</label>
                    <div class="controls">
                        <input type="text" name="fname" id="fname" value="" placeholder="First name" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="sname">Surname</label>
                    <div class="controls">
                        <input type="text" name="sname" id="sname" value="" placeholder="Last name" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="email">Email</label>
                    <div class="controls">
                        <input type="email" name="email" id="email" placeholder="Email" required>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="password1">Password</label>
                    <div class="controls">
                        <input type="password" name="password1" id="password1" placeholder="Password" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="password2">Confirm Password</label>
                    <div class="controls">
                        <input type="password" name="password2" id="password2" placeholder="Confirm password" required>
                    </div>
                </div>
                <div class="form-actions">
                    <a href="index.php" class="btn"><i class="icon-chevron-left"></i> Cancel</a>
                    <button type="submit" class="btn btn-primary"><i class="icon-plus"></i> Sign Up</button>
                    <input type="hidden" name="submit" value="submit">
                </div>
            </form>
            <?php
                } else {
                    echo $output;
                }
            ?>
            <ul class="nav nav-pills">
                <li><a href="help.php">Help</a></li>
                <li><a href="feedback.php">Feedback</a></li>
            </ul>
                
        </div> <!-- /container -->
 <?php include_once('footer.php'); ?>

