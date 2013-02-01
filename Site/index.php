<?php
    $PAGE_TITLE = 'aptTrack';
    include_once('header.php');
?>
            <div data-role="content">
                
                <form action="login.php" method="post" data-ajax="false">
                    <div data-role="fieldcontain" class="ui-hide-label">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="" placeholder="Email" />
                    </div>
                    
                    <div data-role="fieldcontain" class="ui-hide-label">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" value="" placeholder="Password" />
                    </div>
                    
                    <div class="ui-grid-a">
                        <div class="ui-block-a">
                            <a href="signup.php" data-role="button" data-transition="slide" data-prefetch>Sign Up</a>
                        </div>
                        <div class="ui-block-b">
                            <input type="hidden" name="submit" value="submit"/>
                            <input type="submit" value="Log In" />
                        </div>
                    </div>
                </form>
                <a href="forgotpassword.php" data-transition="slidedown" data-prefetch>Forgot your password?</a>
            </div> <!-- close content -->
            
        </div> <!-- close page -->
 <?php include_once('footer.php'); ?>
