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


    foreach (glob("Classes/*.php") as $filename)
    {
        //include($filename);
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
            if ($meth === 'relatedSearch') {
                $term = mysql_escape_string($_POST['term']);
                $jid = mysql_escape_string($_POST['jid']);
                if ('x'.$term === 'x') {
                    // no query specified
                    $query = "SELECT job.id as id, job.name as name FROM job, job_link WHERE (job.id=job_link.bid AND job_link.aid=".$jid.") OR (job.id=job_link.aid AND job_link.bid=".$jid.");";
                } else {
                    // query specified
                    $query = "SELECT * FROM job WHERE name LIKE '%".$term."%' AND id!=".$jid.";";
                }
                $result = mysql_query($query);
                if ($result) {
                    // all ok
                    
                    
                    $output = '<ul class="nav nav-tab nav-stacked">';
                    while ($row = mysql_fetch_assoc($result)) {
                        // is current item selected?
                        $qry_rel = "SELECT COUNT(*) as res FROM job_link WHERE (aid=".$jid." AND bid=".$row['id'].") OR (aid=".$row['id']." AND bid=".$jid.");";
                        $res_rel = mysql_query($qry_rel);
                        if ($res_rel) {
                            $row_rel = mysql_fetch_assoc($res_rel);
                            
                            $output .= '<li>';
                            $alert = 'console.log("'.$row['id'].'");';
                            $output .= '<input type="checkbox" name="relatedItem" value="'.$row['id'].'" onchange="relatedToggle('.$row['id'];
                            if( $row_rel['res'] == '1') {
                                $output .= ', true)" checked="checked"';
                            } else {
                                $output .= ', false)"';
                            }
                            
                            $output .= '>';
                            $output .= $row['name'].'</li>';
                            mysql_free_result($res_rel);
                        } else {
                            http_response_code(500);
                        }
                    }
                    $output .= '</ul>';
                    http_response_code(200);
                    echo $output;
                    mysql_free_result($result);
                } else {
                    // error
                    http_response_code(500);
                }
            } else if ($meth === 'toggleRelated') {
                $jid = mysql_escape_string($_POST['jid']);
                $rid = mysql_escape_string($_POST['rid']);
                $type = mysql_escape_string($_POST['type']);
                if ($type === 'false') {
                    $query = "INSERT INTO job_link (aid, bid, linker, linked) VALUES (".$jid.", ".$rid.", ".$CURRENT_USER->getID().", NOW());";
                } else {
                    $query = "DELETE FROM job_link WHERE (aid=".$jid." AND bid=".$rid.") OR (aid=".$rid." AND bid=".$jid.");";
                }
                mysql_query($query);
                if (mysql_affected_rows() > 0) {
                    $qry_rel = "SELECT job.id as id, job.name as name, job.description as description, DATE_FORMAT(job.updated, '%d-%b-%y %H:%i') as updated_format FROM job, job_link WHERE (job.id=job_link.bid AND job_link.aid=".$jid.") OR (job.id=job_link.aid AND job_link.bid=".$jid.");";
                    $res_rel = mysql_query($qry_rel);
                    if ($res_rel) {
                        $output = '';
                        if (mysql_num_rows($res_rel) > 0) {
                            while ($row = mysql_fetch_assoc($res_rel)) {
                                $output .= '<li><a href="job.php?mode=view&id='.$row['id'].'">';
                                $output .= '<h4 style="color: #000000;">'.$row['name'];
                                $output .= '<small> '.$row['description'].'</small></h4>';
                                $output .= '<p class="muted">Last updated:<strong> '.$row['updated_format'].'</strong></p></a></li>';
                            }
                        } else {
                            $output = '<li><a class="muted">No related items.</a></li>';
                        }
                        mysql_free_result($result);
                        http_response_code(200);
                        echo $output;
                    } else {
                        http_response_code(501);
                    }
                } else {
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
