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
                    // all ok
                    http_response_code(201);
                    mysql_free_result($result);
                } else {
                    // error
                    http_response_code(500);
                }
                
            } else if ($meth === 'newProject') {
                // does a 'clean' project exist?
                $qry_proj_clean = "SELECT id FROM project WHERE clean=1 AND creator=".$CURRENT_USER->id." LIMIT 1;";
                $res_proj_clean = mysql_query($qry_proj_clean);
                // valid query?
                if ($res_proj_clean) {
                    // yes - clean project found?
                    if (mysql_num_rows($res_proj_clean) < 1)  {
                        // no - insert new project
                        $qry_proj_create = "INSERT INTO project(clean, owner, creator, created) VALUES (1, ".$CURRENT_USER->getID().", ".$CURRENT_USER->getID().", NOW());";
                        $res_proj_create = mysql_query($qry_proj_create);

                        // query success?
                        if (mysql_affected_rows($res_proj_create) > 0) {
                            // yes - can we get ID?
                            $res_proj_created = mysql_query($qry_proj_clean);
                            if ($res_proj_created) {
                                // yes - row found?
                                if (mysql_num_rows($res_proj_created) > 0) {
                                    // yes
                                    $row_proj_created = mysql_fetch_assoc($res_proj_created);
                                    http_response_code(200);
                                    print $row_proj_created['id'];
                                    unset($row_proj_created);
                                } else {
                                    http_response_code(500);
                                }
                                mysql_free_result($res_proj_created);
                            } else {
                                // no
                                http_response_code(500);
                            }
                        } else {
                            // error creating project
                            http_response_code(500);
                        }
                    } else {
                        $row_proj_clean = mysql_fetch_assoc($res_proj_clean);
                        // yes 
                        http_response_code(200);
                        print $row_proj_clean['id'];
                        unset($row_proj_clean);
                    }
                    mysql_free_result($res_proj_clean);
                } else {
                    // no - invalid query
                    http_response_code(500);
                }
            } else if ($meth === 'updateProject') {
                
                $mysql = array();
                $mysql['id'] = mysql_real_escape_string($_POST['pID']);
                $mysql['title'] = mysql_real_escape_string($_POST['pTitle']);
                $mysql['desc'] = mysql_real_escape_string($_POST['pDesc']);
                $mysql['owner'] = mysql_real_escape_string($_POST['pOwner']);
                $mysql['start'] = mysql_real_escape_string($_POST['pStart']);
                $mysql['end'] = mysql_real_escape_string($_POST['pEnd']);
                $mysql['status'] = mysql_real_escape_string($_POST['pStatus']);
                $mysql['visibility'] = mysql_real_escape_string($_POST['pVisib']);
                $mysql['health'] = mysql_real_escape_string($_POST['pHealth']);
                $mysql['priority'] = mysql_real_escape_string($_POST['pPriority']);
                
                $query = "UPDATE project SET name='".$mysql['title']."'";
                
                $query .= ", description='".$mysql['desc']."'";
                
                if (is_numeric($mysql['owner'])) {
                    $query .= ", owner=".$mysql['owner'];
                }
                
                $query .= ", date_start='".$mysql['start']."'";
                $query .= ", date_end='".$mysql['end']."'";
                $query .= ", updater=".$CURRENT_USER->id;
                $query .= ", updated=NOW()";
                
                if (is_numeric($mysql['status'])) {
                    $query .= ", status=".$mysql['status'];
                }
                
                if (is_numeric($mysql['visibility'])) {
                    $query .= ", visibility=".$mysql['visibility'];
                }
                
                if (is_numeric($mysql['health'])) {
                    $query .= ", health=".$mysql['health'];
                }
                
                if (is_numeric($mysql['priority'])) {
                    $query .= ", priority=".$mysql['priority'];
                }
                $query .= ", clean=0";
                $query .= " WHERE id=".$mysql['id'].";";
                
                $result = mysql_query($query);
                if ($result) {
                    if (mysql_affected_rows() == 1) {
                        print $query;
                        http_response_code(200);
                    } else {
                        http_response_code(501);
                        print 'affected: '.mysql_affected_rows().'\n';
                        print $query;
                    }
                    mysql_free_result($result);
                } else {
                    http_response_code(500);
                    print mysql_error();
                    print $query;
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
