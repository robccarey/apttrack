<?php

    if (isset($_GET['mode'])) {
        $MODE = $_GET['mode'];
    } else {
        $MODE = 'view';
    }

    $PAGE_TITLE = 'aptTrack';
    include_once('header.php');
    
    if (!isset($_GET['id'])) {
        ?>
            <div data-role="content">
                <h1>Invalid Job Identifier</h1>
            </div>
        <?php
    } else {
        // can the current user view the selected job?
        
        $job = new Job($_GET['id']);
        
        $canView = canReadJob($job, $CURRENT_USER);
        if (!$canView) {
            // NO
        ?>
            <div data-role="content">
                <h1>Unauthorised User</h1>
                <p>You are not authorised to view this item.</p>
            </div>
        <?php
        } else {
            // yes - do they want to edit the project?
            // can user edit?
            $canEdit = canEditJob($job, $CURRENT_USER);
            if ($MODE === 'edit') {
                // yes - is the user allowed to edit?
                if (!$canEdit) {
                    // no - show message
                    ?>
                        <div data-role="content">
                            <h1>Unauthorised Request</h1>
                            <p>You are not authorised to modify this item.</p>
                            <a href="job.php?id=<?php echo $_GET['id']; ?>&mode=view" data-role="button" data-prefetch>View Item</a>
                        </div>
                    <?php
                } else {
                    // yes - show edit form?
                    
                    ?>
                        <div data-role="content">
                            <input type="hidden" id="jobID" name="jobID" value="<?php echo $job->id; ?>" />
                            
                            <h1>Edit Item</h1>
                            <ul data-role="listview" data-inset="true">
                                <li data-role="fieldcontain" >
                                    <label for="jobTitle">Title</label>
                                    <input type="text" name="jobTitle" id="jobTitle" value="<?php echo $job->name; ?>" onchange="updateJob()" placeholder="Title" />
                                </li>
                                <li data-role="fieldcontain" >
                                    <label for="jobDesc">Description</label>
                                    <textarea col="40" rows="8" name="jobDesc" id="jobDesc" placeholder="Description" onchange="updateJob()"><?php
                                        echo $job->description;
                                  ?></textarea>
                                </li>
                                <li data-role="fieldcontain">
                                    <label for="jobOwner">Owner</label>
                                    <select name="jobOwner" id="jobOwner" data-native-menu="false" onchange="updateJob()">
                                        <option value="">Select Owner</option>
                                            <?php
                                                // retrieve users for owner option selector
                                                $qry_owner = "SELECT user.id as id, CONCAT(titles.title, '. ', user.forename, ' ', user.surname) as fullname, user.email as email FROM titles, user WHERE user.title=titles.id ORDER BY user.surname;";
                                                $res_owner = mysql_query($qry_owner);
                                                // query successful?
                                                if ($res_owner) {
                                                    // yes - rows returned?
                                                    if (mysql_num_rows($res_owner) > 0) {
                                                        while ($row_owner = mysql_fetch_assoc($res_owner)) {
                                                            echo '<option value="'.$row_owner['id'].'"';
                                                            if ($job->owner->id == $row_owner['id']) {
                                                                echo ' selected="selected"';
                                                            }
                                                            echo '>';
                                                            echo $row_owner['fullname'];
                                                            echo '</option>';

                                                        }
                                                        unset($row_owner);
                                                    } else {
                                                        echo '<option value="#">Server Error</option>';
                                                    }
                                                    mysql_free_result($res_owner);
                                                } 
                                            ?>
                                    </select>
                                </li>
                                <li data-role="fieldcontain" >
                                    <label for="jobStart">Start Date</label>
                                    <input type="date" name="jobStart" id="jobStart" value="<?php echo $job->date_start; ?>" placeholder="start date" onchange="updateJob()"/>
                                </li>
                                <li data-role="fieldcontain" >
                                    <label for="jobEnd">End Date</label>
                                    <input type="date" name="jobEnd" id="jobEnd" value="<?php echo $job->date_end; ?>" placeholder="end date" onchange="updateJob()"/>
                                </li>
                                <li data-role="fieldcontain" >
                                    <label for="jobStatus">Status</label>
                                    <select name="jobStatus" id="jobStatus" data-native-menu="false" onchange="updateJob()">
                                        <option value="">Select Status</option>
                                        <?php
                                            // retrieve possible statuses for status selector
                                            $qry_status = "SELECT id, name FROM status ORDER BY sort;";
                                            $res_status = mysql_query($qry_status);
                                            if ($res_status) {
                                                if (mysql_num_rows($res_status) > 0) {
                                                    while ($row_status = mysql_fetch_assoc($res_status)) {
                                                        echo '<option value="'.$row_status['id'].'"';
                                                        if ($job->status->id === $row_status['id']) {
                                                            echo ' selected="selected"';
                                                        }
                                                        echo '>';
                                                        echo $row_status['name'];
                                                        echo '</option>';
                                                    }
                                                    unset($row_status);
                                                } else {
                                                    echo '<option value="#">Server Error</option>';
                                                }
                                                mysql_free_result($res_status);
                                            }
                                        ?>
                                    </select>
                                </li>
                                
                                <li data-role="fieldcontain" >
                                    <label for="jobHealth">Health</label>
                                    <select name="jobHealth" id="jobHealth" data-native-menu="false" onchange="updateJob()">
                                        <option value="">Select Health</option>
                                        <?php
                                            // retrieve possible statuses for status selector
                                            $qry_health = "SELECT id, name FROM health ORDER BY sort;";
                                            $res_health = mysql_query($qry_health);
                                            if ($res_health) {
                                                if (mysql_num_rows($res_health) > 0) {
                                                    while ($row_health = mysql_fetch_assoc($res_health)) {
                                                        echo '<option value="'.$row_health['id'].'"';
                                                        if ($job->health->id === $row_health['id']) {
                                                            echo ' selected="selected"';
                                                        }
                                                        echo '>';
                                                        echo $row_health['name'];
                                                        echo '</option>';
                                                    }
                                                    unset($row_health);
                                                } else {
                                                    echo '<option value="#">Server Error</option>';
                                                }
                                                mysql_free_result($res_status);
                                            }
                                        ?>
                                    </select>
                                </li>
                                <li data-role="fieldcontain" >
                                    <label for="jobPri">Priority</label>
                                    <select name="jobPri" id="jobPri" data-native-menu="false" onchange="updateJob()">
                                        <option value="">Select Priority</option>
                                        <?php
                                            // retrieve possible statuses for status selector
                                            $qry_pri = "SELECT id, name FROM priority ORDER BY sort;";
                                            $res_pri = mysql_query($qry_pri);
                                            if ($res_pri) {
                                                if (mysql_num_rows($res_pri) > 0) {
                                                    while ($row_pri = mysql_fetch_assoc($res_pri)) {
                                                        echo '<option value="'.$row_pri['id'].'"';
                                                        if ($job->priority->id === $row_pri['id']) {
                                                            echo ' selected="selected"';
                                                        }
                                                        echo '>';
                                                        echo $row_pri['name'];
                                                        echo '</option>';
                                                    }
                                                    unset($row_pri);
                                                } else {
                                                    echo '<option value="#">Server Error</option>';
                                                }
                                                mysql_free_result($res_pri);
                                            }
                                        ?>
                                    </select>
                                </li>
                                <li>
                                    <div class="ui-grid-a">
                                        <div class="ui-block-a">
                                            <a align="center" href="job.php?id=<?php echo $job->id; ?>&mode=view" data-role="button">Close</a>
                                        </div>
                                        <div class="ui-block-b">
                                            <a align="center" href="#" ontouch="updateJob(true)" onclick="updateJob(true)" data-role="button" data-theme="b">Save</a>
                                        </div>
                                    </div><!-- /grid-a -->
                                </li>
                            </ul>
                        </div>
                    <?php
                }
            } else {
                // no - just show data
                
                // TODO: implement comments
                
                $job->getComments();
                $proj = new Project($job->project);
                $job->getRelated();
                $comments = $job->comments;
                $related = $job->related;
                
                
                
                ?>
                    <div data-role="content">
                        <h1><?php echo $job->name; ?></h1>
                        <?php
                            if ($canEdit) {
                                echo '<a href="job.php?id='.$job->id.'&mode=edit" data-role="button" data-inline="true" data-mini="true" data-ajax="false">edit</a>';
                            }
                        ?>  
                        <a href="#" data-role="button" data-inline="true" data-mini="true" data-ajax="false" onclick="showAlert('Alert', 'Requested action is not yet implemented.')">copy</a>
                        <p><?php echo $job->description; ?></p>
                        <p><strong>Owned by: </strong><a href="mailto:<?php echo $job->owner->email; ?>"><?php echo $job->owner->getFullName(); ?></a></p>
                        <p><strong>Project: </strong><a href="project.php?id=<?php echo $proj->id; ?>&mode=view"><?php echo $proj->name; ?></a></p>

                        <div data-role="collapsible-set">
                            <div data-role="collapsible" data-content-theme="c" data-collapsed="false">
                                <h3>Information</h3>
                                <table width="95%" id="tab-info" class="table-stroke">

                                    <tbody>
                                    <tr>
                                        <td width="30%" align="right"><label>Created</label></td>
                                        <td width="70%" align="left"><?php echo $job->created; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">by</td>
                                        <td align="left"><?php echo $job->creator->getFullName(); ?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Start date</td>
                                        <td align="left"><?php echo $job->date_start; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">End date</td>
                                        <td align="left"><?php echo $job->date_end; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Updated</td>
                                        <td align="left"><?php echo $job->updated; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">by</td>
                                        <td align="left"><?php echo $job->updater->getFullName(); ?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Status</td>
                                        <td align="left"><?php echo $job->status->name; ?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td align="right">Health</td>
                                        <td align="left"><?php echo $job->health->name; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Priority</td>
                                        <td align="left"><?php echo $job->priority->name; ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div data-role="collapsible" data-content-theme="c">
                                <h3>Comments</h3>
                                <p>No one has commented on this task.</p>
                            </div>

                            <div data-role="collapsible" data-content-theme="c">
                                <h3>Related Items</h3>
                                <ul data-role="listview" data-theme="d" data-divider-theme="d">
                                <?php
                                    if (count($related) > 0) {
                                        foreach ($related as $item) {
                                            echo '<li>';
                                            echo '<a href="job.php?mode=view&id='.$item->id.'">';
                                            echo '<h3>'.$item->name.'</h3>';
                                            echo '<p><strong>'.$item->description.'</strong></p>';
                                            echo '<p>'.$item->updated.'</p>';
                                            echo '</a>';
                                            echo '</li>';
                                        }
                                    } else {
                                        echo '<li>No related items.</li>';
                                    }
                                    echo '</ul>';
                                ?>
                            </div>

                        </div>
                    </div> <!-- close content -->
                <?php
            }
        }
    }
?>            
            <div data-role="footer" data-id="navFooter" data-position="fixed">
                <div data-role="navbar">
                    <ul>
                        <li><a href="home.php" data-transition="slide" data-direction="reverse">Home</a></li>
                        <li><a href="projects.php" class="ui-btn-active ui-state-persist">Projects</a></li>
                        <li><a href="reports.php" data-transition="slide">Reports</a></li>
                        <li><a href="people.php" data-transition="slide">People</a></li>
                    </ul>
                </div> <!-- close footer -->
            </div>
        </div> <!-- close page -->
 <?php include_once('footer.php'); ?>