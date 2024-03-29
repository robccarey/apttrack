<?php
    // does auth cookie exist?
    list($identifier, $token) = explode(':', $_COOKIE['auth']);
    if ('x'.$identifier !== 'x' || 'x'.$token !== 'x')
    {
        // yes
        
        // connect to db
        require('../connect.php');
        
        // include required code
        include('functions.php');
        
        // is login valid?
        if (checkLogin() > 0) {
            ?>
                <html>
                    <head>
                        <meta HTTP-EQUIV="REFRESH" content="0; url=home.php">
                    </head>
                    <body>
                        Logging in...
                    </body>
                </html>
            <?php
                return;
        }
    }
    
    // From this point, the user auth cookie either does not exist or is
    // invalid, requiring login/reauthentication.
    
//    <div class="alert">
//          <button type="button" class="close" data-dismiss="alert">&times;</button>
//          <strong>Warning!</strong> Best check yo self, you're not looking too good.
//      </div>
    
    
    // is login error flag set?
    if (isset($_GET['e'])) {
        $e = $_GET['e'];
        if ($e == 'i') {
            $message = 'Invalid email/password combination.';
        } else if ($e == 'd') {
            $message = 'Server error. Please try again later.';
        } else if ($e == 's') {
            $message = 'Session timeout. Please log in again.';
        }
        $display = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Error</strong> '.$message.'</div>';
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
            <h3>Login</h3>
            <form class="form-horizontal" action="login.php" method="post">
                <input type="hidden" name="submit" value="submit"/>
                <?php if(isset($display)) { echo $display; } ?>
                <div class="control-group">
                    <label class="control-label" for="email">Email</label>
                    <div class="controls">
                        <input type="email" name="email" id="email" placeholder="Email" required>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="password">Password</label>
                    <div class="controls">
                        <input type="password" name="password" id="password" placeholder="Password" required>  
                    </div>
                </div>

                <div class="form-actions">
                    <a href="signup.php" class="btn"><i class="icon-plus"></i> Sign Up</a>
                    <button type="submit" class="btn btn-primary"><i class="icon-lock"></i> Sign In</button>
                    <br><br>
                    <a href="#fgtpwd" role="button" data-toggle="modal">Forgot your password?</a>
                </div>
            </form>
        </div>
        
        <div id="fgtpwd" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Reset Password</h3>
            </div>
            <form class="form-horizontal" action="forgotpassword.php" method="POST">
                <div class="modal-body">
                
                    <input type="hidden" name="reset" value="reset"/>
                    <p>Enter your email below to reset your password.</p>
                    <div class="control-group">
                        <label class="control-label" for="email">Email</label>
                        <div class="controls">
                            <input type="email" id="email" name="email" placeholder="Email" required>   
                        </div>
                    </div>
                
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button>
                    <button type="submit" class="btn btn-primary"><i class="icon-refresh"></i> Save changes</button>
                </div>
            </form>
        </div>
        
<?php include('footer.php'); ?>