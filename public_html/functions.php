<?php

function checkLogin()
    {
        // does cookie exist?
        list($identifier, $token) = explode(':', $_COOKIE['auth']);
        
        if ('x'.$identifier === 'x' || 'x'.$token === 'x')
        {
            // cookie does not exist - return 0
            return 0;
        }
    
        // cookie exists - cookie has valid information?
        $clean = array();
        if (ctype_alnum($identifier) && ctype_alnum($token))
        {
            $clean['identifier'] = $identifier;
            $clean['token'] = $token;
        }
        else
        {
            // cookie holds invalid information - return -1
            return -1;
        }
        
        // check cookie content against database
        $mysql = array();
        
        // clean $identifier for mysql use
        $mysql['identifier'] = mysql_real_escape_string($clean['identifier']);
        
        // query database for user 
        $query = "SELECT id, email, login_token, login_timeout FROM user WHERE identifier='".$mysql['identifier']."'";
        
        // execute query
        $result = mysql_query($query);
        if ($result)
        {
            // query was successful so check number of rows
            if (mysql_num_rows($result))
            {
                // at least one row in results
                
                // prep variables
                $now = time();
                $salt = "abcdef";
                
                // prepare results array
                $record = mysql_fetch_assoc($result);
                
                // check tokens
                if ($clean['token'] !== $record['login_token'])
                {
                    // login invalid - wrong token - return -2
                    return -2;
                }
                // check timout
                elseif ($now > $record['login_timeout'])
                {
                    // login invalid - timeout expired - return -3
                    return -3;
                }
                // check identifier - $identifier = md5($salt . md5($userEMAIL . $salt));
                elseif ($clean['identifier'] != md5($salt . md5($record['email'] . $salt)))
                {
                    // login invalid - wrong identifier - return -4
                    return -4;
                }
                else
                {
                    // successful authentication
                    return $record['id'];
                }
            }
            else
            {
                // invalid identifier - return -5
                return -5;
            }
        }
        else
        {
            echo "Database error: ".mysql_error();
            return -6;
        }
    }

function canReadProject(Project $p, User $u) {
    if (isset($p) && isset($u)) {
        
        // is the project open?
        if ($p->getVisibilityID() === '3') {
            return true;
        }
        
        // does $user OWN $project
        if ($p->getOwnerID() === $u->getID()) {
            // yes
            return true;
        // no - did $user CREATE $project
        } else if ($p->getCreatorID() === $u->getID()) {
            // yes
            return true;
        } else {
            // no - does $user own/create job belonging to project?
            $qry = "SELECT COUNT(*) as res FROM job WHERE (owner=".$u->getID()." OR creator=".$u->getID().") and project=".$p->getID()." LIMIT 1;";
            $res = mysql_query($qry);
            if ($res) {
                $row = mysql_fetch_assoc($res);
                mysql_free_result($res);
            }
            if ($row['res'] >= '1') {
                return true;
            } else {
                // is $user on the $project read list
                return $p->userCanRead($u->getID());
            }
        }
    } else {
        return false;
    }
}

function canEditProject(Project $p, User $u) {
    if (isset($p) && isset($u)) {
        
        // does $user OWN $project
        $o = $p->getOwnerID();
        if ($o === $u->getID()) {
            return true;
        } else {
            // no - is $user on the $project edit list
            return $p->userCanEdit($u->getID());
        }
    } else {
        return false;
    }
}

function canReadJob(Job $j, User $u) {
    if (isset($j) && isset($u)) {
        
        // does $u OWN $j
        $o = $j->getOwnerID();
        if ($o === $u->getID()) {
            return true;
        } else {
            // no - is $user on the $job's parent $project's read list
            $p = new Project($j->getProjectID());
            return canReadProject($p, $u);
        }
    } else {
        return false;
    }
}

function canEditJob(Job $j, User $u) {
    if (isset($j) && isset($u)) {
        
        // does $user OWN $job
        $o = $j->getOwnerID();
        if ($o === $u->getID()) {
            return true;
        } else {
            // no - is $user on the $job's parent $project's edit list
            $p = new Project($j->getProjectID());
            return canEditProject($p, $u);
        }
    } else {
        return false;
    }
}

function decodeReportVar($in) {
    $bits0 = explode('||', $in);
    $bits1 = explode('(', $bits0[1]);
    $func = $bits1[0];
    if (isset($bits1[1])) {
        $bits2 = explode(')', $bits1[1]);
        $var = $bits2[0];
    }
    //var_dump($bits0);
    
    //echo "||";
    switch ($func) {
        case 'me.id':
            $out = 'current-user';
            break;
        case 'now':
            $out = 'current-time';
            break;
         case 'days':
            if ($var > 0) {
                $out = abs($var).' days from now';
            } else {
                $out = abs($var).' days before now';
            }
            break;
        case 'weeks':
            if ($var > 0) {
                $out = abs($var).' weeks from now';
            } else {
                $out = abs($var).' weeks before now';
            }
            break;
        default:
            $out = $in;
    }
    return $out;
    
}

function decodeReportVal($in) {
     $bits0 = explode('||', $in);
    $bits1 = explode('(', $bits0[1]);
    $func = $bits1[0];
    if (isset($bits1[1])) {
        $bits2 = explode(')', $bits1[1]);
        $var = $bits2[0];
    }
    //var_dump($bits0);
    
    //echo "||";
    switch ($func) {
        case 'me.id':
            $out = $CURRENT_USER->getID();
            break;
        case 'now':
            $out = time();
            break;
        case 'days':
            if ($var > 0) {
                $out = time() + (abs($var) * 86400);
            } else {
                $out = time() - (abs($var) * 86400);
            }
            break;
        case 'weeks':
            if ($var > 0) {
                $out = time() + (abs($var) * 86400 * 7);
            } else {
                $out = time() - (abs($var) * 86400 * 7);
            }
            break;
        default:
            $out = $in;
    }
    return $out;
}
?>