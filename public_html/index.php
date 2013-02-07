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
                
                <form action="login.php" method="post" id="login" name="login" data-ajax="false">
                    <p style="color: #ff0000;"><?php echo $message; ?></p>
                    <div data-role="fieldcontain" class="ui-hide-label">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="" placeholder="Email" />
                    </div>
                    
                    <div data-role="fieldcontain" class="ui-hide-label">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" value="" placeholder="Password" />
                    </div>
                    
                    <div id="error" style="display: none;">
                        <p><i>You must enter both an email address and a password to login.</i></p>
                    </div>
                    
                    <script type="text/javascript">
                        $('#login').submit(function() {
                            // if email and password fields are blank
                            if ((!$('div').find('#email').val()) || (!$('div').find('#password').val())) {
                                // show error
                                $('#error').show();
                                // do not submit form
                                return false;
                            }
                        });	
                    </script>
                    
                    <div class="ui-grid-a">
                        <div class="ui-block-a">
                            <a href="signup.php" data-role="button" data-transition="slide" data-ajax="false">Sign Up</a>
                        </div>
                        <div class="ui-block-b">
                            <input type="hidden" name="submit" value="submit"/>
                            <input type="submit" value="Log In" />
                        </div>
                    </div>
                </form>
                <a href="forgotpassword.php" data-transition="slidedown" data-prefetch>Forgot your password?</a>
                <br><br><br>
                <a href="attributions.php">Attributions</a>
            </div> <!-- close content -->
            
        </div> <!-- close page -->
 <?php include_once('footer.php'); ?>
