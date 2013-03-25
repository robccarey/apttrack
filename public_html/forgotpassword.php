<?php

    require('../connect.php');
    $updated = false;
    if (isset($_POST['reset'])) {
        $email = mysql_escape_string($_POST['email']);
        
        // does email match an account?
        $qry_mail = "SELECT id, COUNT(*) as res, password, forename FROM user WHERE email='".$email."' LIMIT 1;";
        $res_mail = mysql_query($qry_mail);
        if ($res_mail) {
            $row_mail = mysql_fetch_assoc($res_mail);
            if ($row_mail['res'] === '1') {
                // match found
                $found =  true;
                $userid = $row_mail['id'];
                $oldpass = $row_mail['password'];
            } else {
                $found = false;
            }
            mysql_free_result($res_mail);
        }
        
        if ($found) {
            // generate a random password
            $newPass = substr(md5(rand()), 0, 7);
            
            $qry_pass = "UPDATE user SET password=md5('".$newPass."') WHERE id=".$userid.";";
            mysql_query($qry_pass);
            if (mysql_affected_rows() > 0) {
                // success - send a mail
                include ('Classes/Notification.php');
                $n = new Notification();
                $n->setRecipient($email);
                $n->setSubject('aptTrack - password reset');
                $n->setBody("Hi, ".$clean['fname']."

You password has been reset.

Your new password is '".$newPass."'.

Be sure to change your password to something more memorable when you login next.

Thanks
aptTrack Team");
                $res = $n->sendMail();
                
                // did the mail send?
                if ($res) {
                    // yup!
                    $updated = true;
                } else {
                    // NO! can't send mail - change back password
                    $qry_old_pass = "UPDATE user SET password='".$oldpass."' WHERE id=".$userid.";";
                    mysql_query($qry_old_pass);
                    if (mysql_affected_rows() > 0) {
                        echo $qry_old_pass;
                        $msg = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Error(1)!</strong> Something went wrong. Please try again later.</div>';
                    }
                }
            } else {
                echo $qry_pass;
                // server error
                $msg = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Error(2)!</strong> Something went wrong. Please try again later.</div>';
            }
        } else {
            // show error
            $msg = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Error(3)!</strong> No account currently exists with the specified email address.</div>';
        }
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
                    <a class="brand" href="#">aptTrack</a>
                </div>
            </div>
        </div>
        <div class="container">
<?php
    if (!$updated) {
?>
        <div class="row"><div class="span12">
                <div class="page-header">
                    <h3>Reset Password</h3>
                </div>
            <form class="form-horizontal" action="forgotpassword.php" method="POST">
                 <input type="hidden" name="reset" value="reset"/>
                 <?php echo $msg; ?>
                 <p>Enter your email below to reset your password.</p>
                 <div class="control-group">
                     <label class="control-label" for="email">Email</label>
                     <div class="controls">
                         <input type="email" id="email" value="<?php echo $email; ?>" name="email" placeholder="Email" required>   
                     </div>
                 </div>
                 <div class="form-actions">
                     <button type="submit" class="btn btn-primary"><i clas="icon-refresh"></i> Reset Password</button>
                 </div>
             </form>
        </div></div>
<?php
    } else {
        // email reset - show confirmation
        ?>
            <h3 class="text-center">Password Reset</h3>
            <p class="text-center">You should receive an email shortly with your new password.</p>
            <p class="text-center">Click <a href="index.php">here</a> to log in.</p>
        <?php
    }
?>
            
        </div> <!-- /container -->
<?php include('footer.php'); ?>