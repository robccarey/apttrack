<?php
    // references: http://stackoverflow.com/questions/3258634/php-how-to-send-http-response-code
    if (!function_exists('http_response_code'))
    {
        function http_response_code($newcode = NULL)
        {
            static $code = 200;
            if($newcode !== NULL)
            {
                header('X-PHP-Response-Code: '.$newcode, true, $newcode);
                if(!headers_sent())
                    $code = $newcode;
            }       
            return $code;
        }
    }

    // has a method been specified?
    if(isset($_POST['method']) || (isset($_GET['method']))) {
        
        require('../connect.php');
        require('functions.php');
        $valid_session = checkLogin();
        // is user authenticated?
        if ($valid_session > 0) {
            require('Classes/User.php');
            require('Classes/Title.php');
            $CURRENT_USER = new User($valid_session);
            
            if (isset($_POST['method'])) {
                $meth = $_POST['method'];
            } else {
                $meth = $_GET['method'];
            }
            // what is requested method?
            if ($meth === 'settingsNotifications') {
                $not_proj_add = mysql_real_escape_string($_POST['notProjAdd']);
                $not_task_add = mysql_real_escape_string($_POST['notTaskAdd']);
                $not_proj_dead = mysql_real_escape_string($_POST['notProjDead']);
                $not_proj_odue = mysql_real_escape_string($_POST['notProjOdue']);
                $query = "UPDATE user SET not_proj_add=".$not_proj_add.", not_task_add=".$not_task_add.", not_proj_dead=".$not_proj_dead.", not_proj_odue=".$not_proj_odue." WHERE id=".$CURRENT_USER->getID().";";
                $result = mysql_query($query);
                if ($result) {
                    print 'ok';
                    http_response_code(200);
                } else {
                    print 'error';
                    http_response_code(500);
                }
            } else if ($meth === 'newProject') {
                // does a 'clean' project exist?
                $qry_proj_clean = "SELECT id FROM project WHERE clean=1 AND creator=".$CURRENT_USER->getID()." LIMIT 1;";
                $res_proj_clean = mysql_query($qry_proj_clean);
                // valid query?
                if ($res_proj_clean)  {
                    // yes
                    $row_proj_clean = mysql_fetch_assoc($res_proj_clean);
                    
                    // valid result?
                    if (!isset($row_proj_clean['id'])) {
                        // no - insert new project
                        $qry_proj_create = "INSERT INTO project(clean, owner, creator, created) VALUES (1, ".$CURRENT_USER->getID().", ".$CURRENT_USER->getID().", NOW());";
                        $res_proj_create = mysql_query($qry_proj_create);
                        
                        // query success?
                        if (mysql_affected_rows() > 0) {
                            // yes
                            $res_proj_created = mysql_query($qry_proj_clean);
                            // query success?
                            if ($res_proj_created) {
                                // yes
                                $row_proj_cleaned = mysql_fetch_assoc($res_proj_created);
                                // valid result?
                                if (isset($row_proj_cleaned['id'])) {
                                    // yes
                                    print $row_proj_cleaned['id'];
                                    http_response_code(200);
                                } else {
                                    // error retrieving id of new project
                                    http_response_code(500);
                                }
                            } else {
                                // no
                                http_response_code(500);
                            }
                        } else {
                            // error creating project
                            http_response_code(500);
                        }
                    } else {
                        // yes 
                        print $row_proj_clean['id'];
                        http_response_code(200);
                    }
                } else {
                    // no - invalid query
                    http_response_code(500);
                }
            } else {
                // invalid requested method
                http_response_code(405);
            }
        } else {
            // invalid user
            http_response_code(401);
        }
          
    } else {
        http_response_code(400);
    }

?>
