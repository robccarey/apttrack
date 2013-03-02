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
        if ($result = mysql_query($query))
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
        $project = &$p;
        $user = &$u;
        
        // does $user OWN $project
        $owner = &$project->owner->id;
        if ($owner === $user->id) {
            return true;
        } else {
            // no - is $user on the $project read list
            return $project->userCanRead($user->id);
        }
    } else {
        return false;
    }
}

function canEditProject(Project $p, User $u) {
    if (isset($p) && isset($u)) {
        $project = &$p;
        $user = &$u;
        
        // does $user OWN $project
        $owner = &$project->owner->id;
        if ($owner === $user->id) {
            return true;
        } else {
            // no - is $user on the $project edit list
            return $project->userCanEdit($user->id);
        }
    } else {
        return false;
    }
}

function canReadJob(Job $j, User $u) {
    if (isset($j) && isset($u)) {
        $job = &$j;
        $user = &$u;
        
        // does $user OWN $job
        $owner = &$job->owner->id;
        if ($owner === $user->id) {
            return true;
        } else {
            // no - is $user on the $job's parent $project's read list
            $project = new Project($job->project);
            return canReadProject($project, $user);
        }
    }
}

function canEditJob(Job $j, User $u) {
    if (isset($j) && isset($u)) {
        $job = &$j;
        $user = &$u;
        
        // does $user OWN $job
        $owner = &$job->owner->id;
        if ($owner === $user->id) {
            return true;
        } else {
            // no - is $user on the $job's parent $project's edit list
            $project = new Project($job->project);
            return canEditProject($project, $user);
        }
    }
}
?>