<?php

    // TODO: sign up form
    // TODO: query DB for titles option group
?>
<?php
    $PAGE_TITLE = 'aptTrack | Sign Up';
    include_once('header.php');
?>
        
            <div data-role="content">
                
                <form action="signup.php" method="post" data-ajax="false">
                    
                    <div data-role="fieldcontain" class="ui-hide-label">
                        <label for="titleSelect" class="select">Title</label>
                        <select name="titleSelect" id="titleSelect" data-native-menu="false">
                            <option value="">Title</option>
                            <option value="#">Dr</option>
                            <option value="#">Miss</option>
                            <option value="#">Mr</option>
                            <option value="#">Mrs</option>
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
            </div> <!-- close content -->
            
        </div> <!-- close page -->
 <?php include_once('footer.php'); ?>

