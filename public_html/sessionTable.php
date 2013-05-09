<?php

    $query = "SELECT id, browser, identifier, token, created FROM session WHERE user=".$CURRENT_USER->getID().";";
    $result = mysql_query($query);
    if ($result) {
        if (mysql_num_rows($result) > 0) {
            echo '<p class="muted">'.mysql_num_rows($result).' active session(s).</p>';
            ?>
                <table class="table table-condensed table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Browser</th>
                            <th>First logged in</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
            <?php
                    // get cookie details
                    list($identifier, $token) = explode(':', $_COOKIE['at']);

                    if ('x'.$identifier === 'x' || 'x'.$token === 'x')
                    {
                        // cookie does not exist - return 0
                        
                    } else {

                        // cookie exists - cookie has valid information?
                        $clean = array();
                        if (ctype_alnum($identifier) && ctype_alnum($token))
                        {
                            $clean['identifier'] = $identifier;
                            $clean['token'] = $token;
                        }
                    }
                    
                    
                    while ($row = mysql_fetch_assoc($result)) {
                        
                        if (($row['identifier'] === $clean['identifier']) && ($row['token'] === $clean['token'])) {
                            $current = true;
                        } else {
                            $current = false;
                        }
                        
                        
                        echo '<tr>';
                        echo '<td>'.$row['browser'];
                            if ($current) {
                                echo ' <span class="label">current session</span>';
                            }
                        echo '</td>';
                        echo '<td>'.$row['created'].'</td>';
                            echo '<td>';
                                echo '<a onclick="deleteSession('.$row['id'].')" class="btn btn-primary btn-small"><i class="icon-remove"></i></a>';
                            echo '</td>';
                        echo '</tr>';
                    }
            ?>
                    </tbody>
                </table>
            <?php
        } else {
            echo '<p>All your sessions have been terminated.</p>';
        }
        mysql_free_result($result);
    } else {
        echo 'query issue';
    }
?>
