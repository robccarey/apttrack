<?php

    // connect to db
    require('../Database/connect.php');
    
    if(isset($_POST['submit'])) {
        // clean all values
        $clean = array();
        $clean['title'] = mysql_real_escape_string($_POST['titleSelect']);
        $clean['fname'] = mysql_real_escape_string($_POST['fname']);
        $clean['sname'] = mysql_real_escape_string($_POST['sname']);
        $clean['email'] = mysql_real_escape_string($_POST['email']);
        $clean['password1'] = mysql_real_escape_string($_POST['password1']);
        $clean['password2'] = mysql_real_escape_string($_POST['password2']);
        
        // are values ok?
        $integrity = true;
        
            // do passwords match? ...should have been checked by client prior to sending
            if($clean['password1']!=$clean['password2']) {
                $integrity = false;
            }
            
            // TODO: check all signup fields are populated.
            
        if ($integrity == true) {
            // is there already an account with the provided email?
            $qry_email_used = "SELECT COUNT(*) as count FROM user WHERE email='".$clean['email']."';";
            $res_email_used = mysql_query($qry_email_used);
            if(!$res_email_used) {
                // error in query
            } else {
                if (mysql_num_rows($res_email_used) == 0) {
                    // error in query - should always be 1 row
                    $error = 'Problem with count-email query.';
                } else {
                    // query successful
                    $row_email_used = mysql_fetch_assoc($res_email_used);
                    $count_email_used = $row_email_used['count'];
                    
                    if ($count_email_used == 0) {
                        // all ok - add new user
                        $qry_create_user = "INSERT INTO user (title, forename, surname, email, password, account_status, account_type, created)
                            values (".$clean['title'].", '".$clean['fname']."', '".$clean['sname']."', '".$clean['email']."', md5('".$clean['password1']."'), 1, 2, NOW());";
                        $res_create_user = mysql_query($qry_create_user);
                        if($res_create_user) {
                            // user added
                            $show_form = false;
                            
                            include ('../Classes/Notification.php');
                            $n = new Notification();
                            $n->setRecipient($clean['email']);
                            $n->setSubject('aptTrack - new user');
                            $n->setBody('test email');
                            $res = $n->sendMail();
                            if ($res) {
                                $output = '<h1 align="center">Success!</h1>
                                    <p align="center">You will receive an email shortly confirming your new account details. In the mean time, why not <a href="index.php">login</a> and have a look around?</p>';
                            } else {
                                $output = '<h1 align="center">Success!</h1>
                                    <p align="center">You will receive an email shortly confirming your new account details. In the mean time, why not <a href="index.php">login</a> and have a look around?</p>
                                    <p style="color: #ff0000;"><i>Error sending confirmation email.</i></p>';
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
                }
            }
        } else {
            // TODO: output error when invalid values provided
            $error = 'Invalid parameters received.';
        }
    } else {
        $show_form = true;
    }
        // prepare titles option content.
        $titles_query = "SELECT * FROM titles ORDER BY title;";
        if ($results = mysql_query($titles_query)) {
            if (mysql_num_rows($results)) {
                $titles_selector_content = "";
                while ($row = mysql_fetch_assoc($results)) {
                    $titles_selector_content = $titles_selector_content.'<option value="'.$row['id'].'">'.$row['title'].'</option>';
                }
            }
        }
    
?>

<html>
    <head>
        <?php include_once('headscripts.php'); ?>
        <title>aptTrack</title>
    </head>
    <body>
        <div data-role="page" id="main">
            <div data-role="header" data-theme="b">
                <h1>aptTrack</h1>
            </div>    
            <div data-role="content">
                <?php
                    if($show_form) {
                ?>
                <p>Enter your details below.</p>
                <form action="signup.php" method="post" id="signup" name="signup" data-ajax="false">
                    <p style="color: #ff0000;"><?php echo $error; ?></p>
                    <div data-role="fieldcontain" class="ui-hide-label">
                        <label for="titleSelect" class="select">Title</label>
                        <select name="titleSelect" id="titleSelect" data-native-menu="false">
                            <option value="">Title</option>
                            <?php echo $titles_selector_content; ?>
                        </select>
                    </div>
                    <div data-role="fieldcontain" class="ui-hide-label">
                        <label for="fname">Forename</label>
                        <input type="text" name="fname" id="fname" value="" placeholder="First name" />
                    </div>
                    <div data-role="fieldcontain" class="ui-hide-label">
                        <label for="sname">Surname</label>
                        <input type="text" name="sname" id="sname" value="" placeholder="Last name" />
                    </div>
                    <div data-role="fieldcontain" class="ui-hide-label">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="" placeholder="Email" />
                    </div>
                    
                    <div data-role="fieldcontain" class="ui-hide-label">
                        <label for="password1">Password</label>
                        <input type="password" name="password1" id="password1" value="" placeholder="Password" />
                    </div>
                    <div data-role="fieldcontain" class="ui-hide-label">
                        <label for="password2">Password</label>
                        <input type="password" name="password2" id="password2" value="" placeholder="Confirm password" />
                    </div>
                    <div id="error-tit" style="display: none;">
                        <p><i>Please select your title.</i></p>
                    </div>
                    <div id="error-val" style="display: none;">
                        <p><i>All fields are required.</i></p>
                    </div>
                    <div id="error-pwd" style="display: none;">
                        <p><i>Please ensure both passwords match.</i></p>
                    </div>
                    <script type="text/javascript">
                        $('#signup').submit(function() {
                            // has a title been chosen?
                            if (!$('div').find('#titleSelect').val()) {
                                // not yet...
                                $('#error-val').hide();
                                $('#error-pwd').hide();
                                $('#error-tit').show();
                                return false;
                            } else {
                                $('#error-tit').hide();
                                // if email and password fields are blank
                                if ((!$('div').find('#fname').val()) || (!$('div').find('#sname').val()) || (!$('div').find('#email').val()) || (!$('div').find('#password1').val()) || (!$('div').find('#password2').val())) {
                                    $('#error-pwd').hide();
                                    $('#error-val').show();
                                    // do not submit form
                                    return false;
                                } else {
                                    $('#error-val').hide();
                                    if (($('div').find('#password1').val() !== $('div').find('#password2').val())) {
                                        $('#error-pwd').show();
                                        return false;
                                    } else {
                                        $('#error-pwd').hide();
                                    }
                                }
                            }
                        });	
                    </script>
                    
                    <div class="ui-grid-a">
                        <div class="ui-block-a">
                            <a href="index.php" data-role="button" data-transition="slide" data-direction="reverse" data-prefetch>Cancel</a>
                        </div>
                        <div class="ui-block-b">
                            <input type="hidden" name="submit" value="submit"/>
                            <input type="submit" value="Sign Up" />
                        </div>
                    </div>
                </form>
                <?php
                    } else {
                        echo $output;
                    }
                ?>
            </div> <!-- close content -->
            
        </div> <!-- close page -->
 <?php include_once('footer.php'); ?>

