<?php

    if(isset($_POST['method'])) {
        
        require('../Database/connect.php');
        require('functions.php');
        $valid_session = checkLogin();
        if ($valid_session > 0) {
            require('../Classes/User.php');
            require('../Classes/Title.php');
            $CURRENT_USER = new User($valid_session);
            
            $meth = $_POST['method'];

            if ($meth === 'settingsNotifications') {
                $not_proj_add = mysql_real_escape_string($_POST['notProjAdd']);
                $not_task_add = mysql_real_escape_string($_POST['notTaskAdd']);
                $not_proj_dead = mysql_real_escape_string($_POST['notProjDead']);
                $not_proj_odue = mysql_real_escape_string($_POST['notProjOdue']);
                $query = "UPDATE user SET not_proj_add=".$not_proj_add.", not_task_add=".$not_task_add.", not_proj_dead=".$not_proj_dead.", not_proj_odue=".$not_proj_odue." WHERE id=".$CURRENT_USER->getID().";";
                $result = mysql_query($query);
                if ($result) {
                    print 'ok';
                } else {
                    print 'error';
                }
            }
        }
        
        
        
            
    } else {
        // invalid method
    }

?>
