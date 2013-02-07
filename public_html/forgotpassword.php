<?php
    // TODO: forgotten password reset form
?>

<?php
    $PAGE_TITLE = 'aptTrack | Reset Password';
    include_once('header.php');
?>
       
            <div data-role="content">
                
                <form action="forgotpassword.php" method="post" data-ajax="false">
                    <p>Enter your email below to reset your password.</p>
                    <div data-role="fieldcontain" class="ui-hide-label">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="" placeholder="Email" />
                    </div>
                    
                    <div class="ui-grid-a">
                        <div class="ui-block-a">
                            <a href="index.php" data-role="button" data-transition="slidedown" data-direction="reverse" data-prefetch>Cancel</a>
                        </div>
                        <div class="ui-block-b">
                            <input type="submit" value="Go" />
                        </div>
                    </div>
                </form>
                
                
            </div> <!-- close content -->
            
        </div> <!-- close page -->
 <?php include_once('footer.php'); ?>
