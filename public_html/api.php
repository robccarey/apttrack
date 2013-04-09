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
                    
                    if (mysql_num_rows($result) > 0) {
                        $output = '<ul class="nav nav-pills nav-stacked">';
                        while ($row = mysql_fetch_assoc($result)) {
                            // is current item selected?
                            $qry_rel = "SELECT COUNT(*) as res FROM job_link WHERE (aid=".$jid." AND bid=".$row['id'].") OR (aid=".$row['id']." AND bid=".$jid.");";
                            $res_rel = mysql_query($qry_rel);
                            if ($res_rel) {
                                $row_rel = mysql_fetch_assoc($res_rel);


                                $alert = 'console.log("'.$row['id'].'");';
                                $output .= '<li';
                                if( $row_rel['res'] == '1') {
                                    $output .= ' class="active"><a onclick="relatedToggle('.$row['id'].', true)"><i class="icon-ok"></i>';
                                } else {
                                    $output .= '><a onclick="relatedToggle('.$row['id'].', false)"><i class="icon-minus"></i>';
                                }
                                $output .= ' '.$row['name'].'</a></li>';
                                mysql_free_result($res_rel);
                            } else {
                                http_response_code(500);
                            }
                        }
                        $output .= '</ul>';
                    } else {
                        $output = '<p class="muted">No items found.</p>';
                    }
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
                        mysql_free_result($res_rel);
                        http_response_code(200);
                        echo $output;
                    } else {
                        http_response_code(501);
                    }
                } else {
                    http_response_code(500);
                }
            } else if ($meth === 'addTag') {
                $tag = mysql_escape_string($_POST['tag']);
                $query = "INSERT INTO tags (tag, created) VALUES ('".$tag."', NOW());";
                mysql_query($query);
                if (mysql_affected_rows() > 0) {
                    http_response_code(200);
                    echo mysql_insert_id();
                } else {
                    http_response_code(500);
                }
            } else if ($meth === 'jobTagSearch') {
                $term = mysql_escape_string($_POST['term']);
                $jid = mysql_escape_string($_POST['jid']);
                $output = '';
                if ('x'.$term === 'x') {
                    // no query specified
                    $query = "SELECT tags.id as id, tags.tag as tag FROM tags, tag_job WHERE tags.id=tag_job.tag AND tag_job.job=".$jid.";";
                } else {
                    // query specified
                    
                    // does tag exist? if not, show add option
                    $qry_tag = "SELECT COUNT(*) as res FROM tags WHERE tag='".$term."';";
                    $res_tag = mysql_query($qry_tag);
                    if ($res_tag) {
                        $row_tag = mysql_fetch_assoc($res_tag);
                        if ($row_tag['res'] === '0') {
                            // does not exist
                            $output .= '<div id="addTagRes"><input type="hidden" id="newTag" value="'.$term.'">
                                <button class="btn btn-block btn-success" onclick="addJobTag()" type="button">Create this tag?</button></div>';
                        }
                        mysql_free_result($res_tag);
                    }
                    // search for existing tags
                    $query = "SELECT * FROM tags WHERE tag LIKE '%".$term."%';";
                }
                $result = mysql_query($query);
                if ($result) {
                    // all ok
                    
                    if ((mysql_num_rows($result) > 0) || ('x'.$output != 'x')) {
                        $output .= '<ul class="nav nav-pills nav-stacked">';
                        while ($row = mysql_fetch_assoc($result)) {
                            // is current item selected?
                            $qry_rel = "SELECT COUNT(*) as res FROM tag_job WHERE job=".$jid." AND tag=".$row['id'].";";
                            $res_rel = mysql_query($qry_rel);
                            if ($res_rel) {
                                $row_rel = mysql_fetch_assoc($res_rel);


                                $alert = 'console.log("'.$row['id'].'");';
                                $output .= '<li';
                                if( $row_rel['res'] == '1') {
                                    $output .= ' class="active"><a onclick="jobTagToggle('.$row['id'].', true)"><i class="icon-ok"></i>';
                                } else {
                                    $output .= '><a onclick="jobTagToggle('.$row['id'].', false)"><i class="icon-minus"></i>';
                                }
                                $output .= ' '.$row['tag'].'</a></li>';
                                mysql_free_result($res_rel);
                            } else {
                                http_response_code(500);
                            }
                        }
                        $output .= '</ul>';
                    } else {
                        $output = '<p class="muted">No tags have been assigned.</p>';
                    }
                    http_response_code(200);
                    echo $output;
                    mysql_free_result($result);
                } else {
                    // error
                    http_response_code(500);
                }
            }  else if ($meth === 'toggleJobTag') {
                $jid = mysql_escape_string($_POST['jid']);
                $tag = mysql_escape_string($_POST['tag']);
                $type = mysql_escape_string($_POST['type']);
                if ($type === 'false') {
                    $query = "INSERT INTO tag_job (job, tag, created, user) VALUES (".$jid.", ".$tag.", NOW(), ".$CURRENT_USER->getID().");";
                } else {
                    $query = "DELETE FROM tag_job WHERE job=".$jid." AND tag=".$tag.";";
                }
                mysql_query($query);
                if (mysql_affected_rows() > 0) {
                    $qry_rel = "SELECT tags.id as id, tags.tag as tag FROM tags, tag_job WHERE tags.id=tag_job.tag AND tag_job.job=".$jid.";";
                    $res_rel = mysql_query($qry_rel);
                    if ($res_rel) {
                        $output = '';
                        if (mysql_num_rows($res_rel) > 0) {
                            while ($row = mysql_fetch_assoc($res_rel)) {
                                $output .= '<a href="#" class="btn btn-inverse">'.$row['tag'].'</a> ';
                            }
                        } else {
                            $output = '<p class="muted">No tags have been assigned.</p>';
                        }
                        mysql_free_result($res_rel);
                        http_response_code(200);
                        echo $output;
                    } else {
                        http_response_code(501);
                    }
                } else {
                    http_response_code(500);
                }
            } else if ($meth === 'projTagSearch') {
                $term = mysql_escape_string($_POST['term']);
                $pid = mysql_escape_string($_POST['pid']);
                $output = '';
                if ('x'.$term === 'x') {
                    // no query specified
                    $query = "SELECT tags.id as id, tags.tag as tag FROM tags, tag_project WHERE tags.id=tag_project.tag AND tag_project.project=".$pid.";";
                } else {
                    // query specified
                    
                    // does tag exist? if not, show add option
                    $qry_tag = "SELECT COUNT(*) as res FROM tags WHERE tag='".$term."';";
                    $res_tag = mysql_query($qry_tag);
                    if ($res_tag) {
                        $row_tag = mysql_fetch_assoc($res_tag);
                        if ($row_tag['res'] === '0') {
                            // does not exist
                            $output .= '<div id="addTagRes"><input type="hidden" id="newTag" value="'.$term.'">
                                <button class="btn btn-block btn-success" onclick="addProjTag()" type="button">Create this tag?</button></div>';
                        }
                        mysql_free_result($res_tag);
                    }
                    // search for existing tags
                    $query = "SELECT * FROM tags WHERE tag LIKE '%".$term."%';";
                }
                $result = mysql_query($query);
                if ($result) {
                    // all ok
                    
                    if ((mysql_num_rows($result) > 0) || ('x'.$output != 'x')) {
                        $output .= '<ul class="nav nav-pills nav-stacked">';
                        while ($row = mysql_fetch_assoc($result)) {
                            // is current item selected?
                            $qry_rel = "SELECT COUNT(*) as res FROM tag_project WHERE project=".$pid." AND tag=".$row['id'].";";
                            $res_rel = mysql_query($qry_rel);
                            if ($res_rel) {
                                $row_rel = mysql_fetch_assoc($res_rel);


                                $alert = 'console.log("'.$row['id'].'");';
                                $output .= '<li';
                                if( $row_rel['res'] == '1') {
                                    $output .= ' class="active"><a onclick="projTagToggle('.$row['id'].', true)"><i class="icon-ok"></i>';
                                } else {
                                    $output .= '><a onclick="projTagToggle('.$row['id'].', false)"><i class="icon-minus"></i>';
                                }
                                $output .= ' '.$row['tag'].'</a></li>';
                                mysql_free_result($res_rel);
                            } else {
                                http_response_code(500);
                            }
                        }
                        $output .= '</ul>';
                    } else {
                        $output = '<p class="muted">No tags have been assigned.</p>';
                    }
                    http_response_code(200);
                    echo $output;
                    mysql_free_result($result);
                } else {
                    // error
                    http_response_code(500);
                }
            } else if ($meth === 'toggleProjTag') {
                $pid = mysql_escape_string($_POST['pid']);
                $tag = mysql_escape_string($_POST['tag']);
                $type = mysql_escape_string($_POST['type']);
                if ($type === 'false') {
                    $query = "INSERT INTO tag_project (project, tag, created, user) VALUES (".$pid.", ".$tag.", NOW(), ".$CURRENT_USER->getID().");";
                } else {
                    $query = "DELETE FROM tag_project WHERE project=".$pid." AND tag=".$tag.";";
                }
                mysql_query($query);
                if (mysql_affected_rows() > 0) {
                    $qry_rel = "SELECT tags.id as id, tags.tag as tag FROM tags, tag_project WHERE tags.id=tag_project.tag AND tag_project.project=".$pid.";";
                    $res_rel = mysql_query($qry_rel);
                    if ($res_rel) {
                        $output = '';
                        if (mysql_num_rows($res_rel) > 0) {
                            while ($row = mysql_fetch_assoc($res_rel)) {
                                $output .= '<a href="#" class="btn btn-inverse">'.$row['tag'].'</a> ';
                            }
                        } else {
                            $output = '<p class="muted">No tags have been assigned.</p>';
                        }
                        mysql_free_result($res_rel);
                        http_response_code(200);
                        echo $output;
                    } else {
                        http_response_code(501);
                    }
                } else {
                    http_response_code(500);
                }
            } else if ($meth === 'searchPersonnel') {
                $term = mysql_escape_string($_POST['term']);
                $pid = mysql_escape_string($_POST['pid']);
                if ('x'.$term === 'x') {
                    // no term specified
                    $query = "SELECT user.id, CONCAT(user.forename, ' ', user.surname) as fullname FROM user, project_user WHERE user.id=project_user.user AND project_user.project=".$pid.";";
                } else {
                    // term specified
                    $query = "SELECT user.id as id, CONCAT(forename, ' ', surname) as fullname FROM user WHERE forename LIKE '%".$term."%' OR surname LIKE '%".$term."%' OR CONCAT(forename, ' ', surname) LIKE '%".$term."%' ORDER BY surname, forename;";
                }
                $result = mysql_query($query);
                if ($result) {
                    $output = '';
                    if (mysql_num_rows($result) > 0) {
                        $output .= '<table class="table table-hover table-condensed table-bordered">';
                        while ($row = mysql_fetch_assoc($result)) {
                            $qry_sel = "SELECT can_edit FROM project_user WHERE user=".$row['id']." AND project=".$pid." LIMIT 1;";
                            $res_sel = mysql_query($qry_sel);
                            if ($res_sel) {
                                if (mysql_num_rows($res_sel) > 0) {
                                    $row_sel = mysql_fetch_assoc($res_sel);
                                    $output .= '<tr class="info">';
                                        $output .= '<td><i class="icon-ok"></i>';
                                        $output .= ' '.$row['fullname'].'</td>';
                                        if ($row_sel['can_edit'] === '1') {
                                            $output .= '<td><button class="btn btn-small" onclick="togglePersonEdit('.$row['id'].', true)"><i class="icon-ban-circle"></i> revoke edit</button></td>';
                                        } else {
                                            $output .= '<td><button class="btn btn-small" onclick="togglePersonEdit('.$row['id'].', false)"><i class="icon-pencil"></i> enable edit</button></td>';
                                        }
                                        $output .= '<td><button class="btn btn-danger btn-small" onclick="removePerson('.$row['id'].')"><i class="icon-remove icon-white"></i> remove</button></td>';
                                    $output .= '</tr>';
                                } else {
                                    $output .= '<tr onclick="addPerson('.$row['id'].')">';
                                        $output .= '<td colspan="3"><i class="icon-minus"></i>';
                                        $output .= ' '.$row['fullname'].'</td>';
                                    $output .= '</tr>';
                                        
                                }
                                
                                mysql_free_result($res_sel);
                            } else {
                                // bad query
                                http_response_code(500);
                            }
                        }
                        $output .= '</table>';
                        http_response_code(200);
                        echo $output;
                    } else {
                        $output = '<p class="muted">No people found.</p>';
                    }
                    mysql_free_result($result);
                } else {
                    // bad query
                    http_response_code(500);
                }
            } else if ($meth === 'addProjPerson') {
                $uid = mysql_escape_string($_POST['uid']);
                $pid = mysql_escape_string($_POST['pid']);
                $query = "INSERT INTO project_user(project, user, since, can_edit) VALUES (".$pid.", ".$uid.", NOW(), 0);";
                mysql_query($query);
                if (mysql_affected_rows() > 0) {
                    // success
                    http_response_code(200);
                } else {
                    // error
                    http_response_code(500);
                }
            } else if ($meth === 'remProjPerson') {
                $uid = mysql_escape_string($_POST['uid']);
                $pid = mysql_escape_string($_POST['pid']);
                $query = "DELETE FROM project_user WHERE project=".$pid." AND user=".$uid." LIMIT 1;";
                mysql_query($query);
                if (mysql_affected_rows() > 0) {
                    // success
                    http_response_code(200);
                } else {
                    // error
                    http_response_code(500);
                }
            } else if ($meth === 'togProjPerson') {
                $uid = mysql_escape_string($_POST['uid']);
                $pid = mysql_escape_string($_POST['pid']);
                $state = mysql_escape_string($_POST['state']);
                if ($state === 'true') {
                    // person currenty can edit
                    $query = "UPDATE project_user SET can_edit=0 WHERE project=".$pid." AND user=".$uid." LIMIT 1;";
                } else {
                    $query = "UPDATE project_user SET can_edit=1 WHERE project=".$pid." AND user=".$uid." LIMIT 1;";
                }
                mysql_query($query);
                if (mysql_affected_rows() > 0) {
                    // success
                    http_response_code(200);
                } else {
                    // error
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
