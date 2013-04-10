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
            foreach (glob("Classes/*.php") as $filename)
            {
                require($filename);
            }
            //require('Classes/User.php');
            //require('Classes/Title.php');
            $CURRENT_USER = new User($valid_session);
            
            if (isset($_POST['method'])) {
                $meth = $_POST['method'];
            } else {
                $meth = $_GET['method'];
            }
            
            // what is requested method?
            switch ($meth) {
                
                case 'relatedSearch':
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
                    break;
                
                case 'toggleRelated':
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
                    break;
                
                case 'addTag':
                    $tag = mysql_escape_string($_POST['tag']);
                    $query = "INSERT INTO tags (tag, created) VALUES ('".$tag."', NOW());";
                    mysql_query($query);
                    if (mysql_affected_rows() > 0) {
                        http_response_code(200);
                        echo mysql_insert_id();
                    } else {
                        http_response_code(500);
                    }
                    break;
                
                case 'jobTagSearch':
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
                    break;
                
                case 'toggleJobTag':
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
                    break;
                
                case 'projTagSearch':
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
                    break;
                
                case 'toggleProjTag':
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
                    break;
                
                case 'searchPersonnel':
                    $term = mysql_escape_string($_POST['term']);
                    $pid = mysql_escape_string($_POST['pid']);
                    $proj = new Project($pid);
                    $canEdit = $proj->userCanEdit($CURRENT_USER->getID());
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
                                            if ($canEdit) {
                                                if ($row_sel['can_edit'] === '1') {
                                                    $output .= '<td><button class="btn btn-small" onclick="togglePersonEdit('.$row['id'].', true)"><i class="icon-ban-circle hidden-phone"></i> revoke edit</button></td>';
                                                } else {
                                                    $output .= '<td><button class="btn btn-small" onclick="togglePersonEdit('.$row['id'].', false)"><i class="icon-pencil hidden-phone"></i> enable edit</button></td>';
                                                }
                                                $output .= '<td><button class="btn btn-danger btn-small" onclick="removePerson('.$row['id'].')"><i class="icon-remove icon-white hidden-phone"></i> remove</button></td>';
                                            } else {
                                                $output .= '<td colspan="2">';
                                                if ($row_sel['can_edit'] === '1') {
                                                    $output .= 'can edit';
                                                } else {
                                                    $output .= 'read only';
                                                }
                                                $output .= '</td>';
                                            }
                                        $output .= '</tr>';
                                    } else {
                                        if ($canEdit) {
                                            $output .= '<tr onclick="addPerson('.$row['id'].')">';
                                        } else {
                                            $output .= '<tr>';
                                        }
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
                    break;
                
                case 'addProjPerson':
                    $uid = mysql_escape_string($_POST['uid']);
                    $pid = mysql_escape_string($_POST['pid']);
                    $proj = new Project($pid);
                    if ($proj->userCanEdit($CURRENT_USER->getID())) {
                        $query = "INSERT INTO project_user(project, user, since, can_edit) VALUES (".$pid.", ".$uid.", NOW(), 0);";
                        mysql_query($query);
                        if (mysql_affected_rows() > 0) {
                            // success
                            http_response_code(200);
                        } else {
                            // error
                            http_response_code(500);
                        }
                    } else {
                        // user not allowed to modify personnel list
                        http_response_code(200);
                        echo 'You cannot modify user privileges for this project.';
                    }
                    break;
                    
                case 'remProjPerson':
                    $uid = mysql_escape_string($_POST['uid']);
                    $pid = mysql_escape_string($_POST['pid']);
                    $proj = new Project($pid);
                    if ($proj->userCanEdit($CURRENT_USER->getID())) {
                        $query = "DELETE FROM project_user WHERE project=".$pid." AND user=".$uid." LIMIT 1;";
                        mysql_query($query);
                        if (mysql_affected_rows() > 0) {
                            // success
                            http_response_code(200);
                        } else {
                            // error
                            http_response_code(500);
                        }
                    } else {
                        // user not allowed to modify personnel list
                        http_response_code(200);
                        echo 'You cannot modify user privileges for this project.';
                    }
                    break;
                
                case 'togProjPerson':
                    $uid = mysql_escape_string($_POST['uid']);
                    $pid = mysql_escape_string($_POST['pid']);
                    $proj = new Project($pid);
                    if ($proj->userCanEdit($CURRENT_USER->getID())) {
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
                        // user not allowed to modify personnel list
                        http_response_code(200);
                        echo 'You cannot modify user privileges for this project.';
                    }
                    break;
                
                case 'deleteJob':
                    $jid = mysql_escape_string($_POST['jid']);

                    //include('Classes/Job.php');
                    //include('Classes/Project.php');
                    $job = new Job($jid);
                    $proj = new Project($job->getProjectID());
                    if ($proj->userCanEdit($CURRENT_USER->getID())) {
                        $query = array();
                        $query[] = "DELETE FROM job_comment WHERE job=".$jid.";";
                        $query[] = "DELETE FROM tag_job WHERE job=".$jid.";";
                        $query[] = "DELETE FROM job_link WHERE aid=".$jid." OR bid=".$jid.";";
                        $query[] = "DELETE FROM job WHERE id=".$jid." LIMIT 1;";

                        $ok = true;
                        foreach($query as $q) {
                            if(!mysql_query($q)) {
                                $ok = false;
                            }
                        }
                        if ($ok) {
                            // successfully deleted
                            http_response_code(200);
                        } else {
                            // error
                            http_response_code(500);
                        }

                    } else {
                        // user does not have required priviliges
                        http_response_code(403);
                    }
                    break;
                
                case 'deleteProject':
                    $pid = mysql_escape_string($_POST['pid']);
                    $ok = true;
                    // loop through jobs belonging to project, delete each one
                    $qry_jobs = "SELECT id FROM job WHERE project=".$pid.";";
                    $res_jobs = mysql_query($qry_jobs);
                    if ($res_jobs) {
                        while ($row = mysql_fetch_assoc($res_jobs)) {
                            $jid = $row['id'];
                            $qry_del_jobs = array();
                            $qry_del_jobs[] = "DELETE FROM job_comment WHERE job=".$jid.";";
                            $qry_del_jobs[] = "DELETE FROM tag_job WHERE job=".$jid.";";
                            $qry_del_jobs[] = "DELETE FROM job_link WHERE aid=".$jid." OR bid=".$jid.";";
                            $qry_del_jobs[] = "DELETE FROM job WHERE id=".$jid." LIMIT 1;";
                            foreach($qry_del_jobs as $q) {
                                if (!mysql_query($q)) {
                                    $ok = false;
                                }
                            }
                        }
                        mysql_free_result($res_jobs);
                    }
                    // delete project comments, tags, users
                    $qry_del_proj = array();
                    $qry_del_proj[] = "DELETE FROM project_comment WHERE project=".$pid.";";
                    $qry_del_proj[] = "DELETE FROM tag_project WHERE project=".$pid.";";
                    $qry_del_proj[] = "DELETE FROM project_user WHERE project=".$pid.";";
                    $qry_del_proj[] = "DELETE FROM project WHERE id=".$pid." LIMIT 1;";
                    foreach($qry_del_proj as $q) {
                        if (!mysql_query($q)) {
                            $ok = false;
                        }
                    }

                    if($ok) {
                        http_response_code(200);
                    } else {
                        http_response_code(500);
                    }
                    break;
                    
                case 'refreshReportViewTable':
                    $id = mysql_escape_string($_POST['rid']);
                    $rep = new Report($id, $CURRENT_USER->getID());
                    
                    include('reportViewTable.php');
                    break;
                
                case 'repSetLabel':
                    $rid = mysql_escape_string($_POST['rid']);
                    $fid = mysql_escape_string($_POST['fid']);
                    $label = mysql_escape_string($_POST['label']);
                    echo $rid.' '.$fid.' '.$label;
                    $query = "UPDATE report_field SET label='".$label."' WHERE report=".$rid." AND field=".$fid.";";

                    if (mysql_query($query)) {
                        http_response_code(200);
                    } else {
                        http_response_code(501);
                    }
                    break;
                
                case 'repSetVisib':
                    $rid = mysql_escape_string($_POST['rid']);
                    $fid = mysql_escape_string($_POST['fid']);
                    $visib = mysql_escape_string($_POST['visib']);
                    
                    if ($visib === '1') {
                        // setting hidden field to visible
                        // what is appropriate field position?
                        $qry_pos = "SELECT (MAX(position)+1) as res FROM report_field WHERE report=".$rid.";";
                        $res_pos = mysql_query($qry_pos);
                        if($res_pos) {
                            $row_pos = mysql_fetch_assoc($res_pos);
                            $new_pos = $row_pos['res'];
                            mysql_free_result($res_pos);
                            
                            $qry_set = "UPDATE report_field SET visible=1, position=".$new_pos." WHERE report=".$rid." AND field=".$fid.";";
                            if (mysql_query($qry_set)) {
                                http_response_code(200);
                            } else {
                                http_response_code(501);
                            }
                        }
                        
                    } else {
                        // setting visible field to hidden
                        // 
                        // get old position
                        $qry_pos = "SELECT position FROM report_field WHERE report=".$rid." AND field=".$fid." LIMIT 1;";
                        $res_pos = mysql_query($qry_pos);
                        if ($res_pos) {
                            $row_pos = mysql_fetch_assoc($res_pos);
                            $old_pos = $row_pos['position'];
                            mysql_free_result($res_pos);
                            
                            // set new position for field
                            $qry_new = "UPDATE report_field SET position=0, visible=0 WHERE report=".$rid." AND field=".$fid." LIMIT 1;";
                            if (mysql_query($qry_new)) {
                                // loop through fields after specified position
                                $qry_aft = "SELECT field FROM report_field WHERE report=".$rid." AND position > ".$old_pos.";";
                                $res_aft = mysql_query($qry_aft);
                                $new_pos = $old_pos;
                                if ($res_aft) {
                                    $qry_upd = array();
                                    while ($row = mysql_fetch_assoc($res_aft)) {
                                        // update field position
                                        $qry_upd[] = "UPDATE report_field SET position=".$new_pos." WHERE report=".$rid." AND field=".$row['field']." LIMIT 1;";
                                        $new_pos++;
                                    }
                                    $ok = true;
                                    foreach($qry_upd as $q) {
                                        if (!mysql_query($q)) {
                                            $ok = false;
                                        }
                                    }
                                    if ($ok) {
                                        // everything updated ok
                                        http_response_code(200);
                                    } else {
                                        // something went wrong.
                                        http_response_Code(500);
                                    }
                                    mysql_free_result($res_aft);
                                }
                            } else {
                                // error updating new position
                                http_response_code(500);
                            }
                        } else {
                            // error getting old position
                            http_response_code(500);
                        }
                    }
                    break;
                    
                case 'repMoveFieldLeft':
                    $rid = mysql_escape_string($_POST['rid']);
                    $fid = mysql_escape_string($_POST['fid']);
                    
                    // get old position
                    $qry_pos = "SELECT position FROM report_field WHERE report=".$rid." AND field=".$fid." LIMIT 1;";
                    $res_pos = mysql_query($qry_pos);
                    if ($res_pos) {
                        $row_pos = mysql_fetch_assoc($res_pos);
                        $old_pos = $row_pos['position'];
                        $new_pos = $old_pos - 1;
                        // can we move left?
                        if ($old_pos !== '1') {
                            // yes - do it
                            
                            // get fid for field to swap
                            $qry_to_swap = "SELECT field FROM report_field WHERE report=".$rid." AND position=".$new_pos." LIMIT 1";
                            $res_to_swap = mysql_query($qry_to_swap);
                            if ($res_to_swap) {
                                $row_to_swap = mysql_fetch_assoc($res_to_swap);
                                $fld_to_swap = $row_to_swap['field'];
                                mysql_free_result($res_to_swap);
                                
                                $qry_upd = array();
                                // fld_to_swap position to $old_pos
                                $qry_upd[] = "UPDATE report_field SET position=".$old_pos." WHERE report=".$rid." AND field=".$fld_to_swap." LIMIT 1;";
                                // set fid position to $new_pos
                                $qry_upd[] = "UPDATE report_field SET position=".$new_pos." WHERE report=".$rid." AND field=".$fid." LIMIT 1;";
                                
                                $ok = true;
                                foreach ($qry_upd as $q) {
                                    if (!mysql_query($q)) {
                                        $ok = false;
                                    }
                                }
                                if ($ok) {
                                    // all is fine
                                    http_response_code(200);
                                } else {
                                    // error!
                                    http_response_code(500);
                                }
                                
                            } else {
                                // server error - couldn't determine field to swap
                                http_response_code(500);
                            }
                            
                        } else {
                            // no - client error
                            http_response_code(418);
                        }
                        mysql_free_result($res_pos);
                    } else {
                        // error - couldn't get old position
                        http_response_code(500);
                    }
                    break;
                    
                case 'repMoveFieldRight':
                    $rid = mysql_escape_string($_POST['rid']);
                    $fid = mysql_escape_string($_POST['fid']);
                    
                    // get old position
                    $qry_pos = "SELECT position FROM report_field WHERE report=".$rid." AND field=".$fid." LIMIT 1;";
                    $res_pos = mysql_query($qry_pos);
                    if ($res_pos) {
                        $row_pos = mysql_fetch_assoc($res_pos);
                        $old_pos = $row_pos['position'];
                        $new_pos = $old_pos + 1;
                        // can we move right? get max position
                        $qry_max = "SELECT MAX(position) as max FROM report_field WHERE report=".$rid.";";
                        $res_max = mysql_query($qry_max);
                        if ($res_max) {
                            $row_max = mysql_fetch_assoc($res_max);
                            if ($old_pos !== $row_max['max']) {
                                // yes - do it

                                // get fid for field to swap
                                $qry_to_swap = "SELECT field FROM report_field WHERE report=".$rid." AND position=".$new_pos." LIMIT 1";
                                $res_to_swap = mysql_query($qry_to_swap);
                                if ($res_to_swap) {
                                    $row_to_swap = mysql_fetch_assoc($res_to_swap);
                                    $fld_to_swap = $row_to_swap['field'];
                                    mysql_free_result($res_to_swap);

                                    $qry_upd = array();
                                    // fld_to_swap position to $old_pos
                                    $qry_upd[] = "UPDATE report_field SET position=".$old_pos." WHERE report=".$rid." AND field=".$fld_to_swap." LIMIT 1;";
                                    // set fid position to $new_pos
                                    $qry_upd[] = "UPDATE report_field SET position=".$new_pos." WHERE report=".$rid." AND field=".$fid." LIMIT 1;";

                                    $ok = true;
                                    foreach ($qry_upd as $q) {
                                        if (!mysql_query($q)) {
                                            $ok = false;
                                        }
                                    }
                                    if ($ok) {
                                        // all is fine
                                        http_response_code(200);
                                    } else {
                                        // error!
                                        http_response_code(500);
                                    }

                                } else {
                                    // server error - couldn't determine field to swap
                                    http_response_code(500);
                                }

                            } else {
                                // no - client error
                                http_response_code(418);
                            }
                            mysql_free_result($res_max);
                        }
                        mysql_free_result($res_pos);
                    } else {
                        // error - couldn't get old position
                        http_response_code(500);
                    }
                    break;
                    
                default:
                    http_response_code(405);
                    break;
            }
            
        } else {
            // invalid user
            http_response_code(401);
        }
    } else {
        http_response_code(400);
    }
?>
