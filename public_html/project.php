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
                <h1>Invalid Project Identifier</h1>
            </div>
        <?php
    } else {
        // can the current user view the selected project?
        $proj = new Project($_GET['id']);
        
        
        $canView = canReadProject($proj, $CURRENT_USER);
        if (!$canView) {
            // NO
        ?>
            <div data-role="content">
                <h1>Unauthorised User</h1>
                <p>You are not authorised to view this project.</p>
            </div>
        <?php
        } else {
            $proj->getComments();
            $comments = $proj->comments;
            $canEdit = canEditProject($proj, $CURRENT_USER);
            // yes - do they want to edit the project?
            if ($MODE === 'edit') {
                // yes - is the user allowed to edit?
                
                if (!$canEdit) {
                    // no - show message
                    ?>
                        <div data-role="content">
                            <h1>Unauthorised Request</h1>
                            <p>You are not authorised to modify this project.</p>
                            <a href="project.php?id=<?php echo $_GET['id']; ?>&mode=view" data-role="button" data-prefetch>View Project</a>
                        </div>
                    <?php
                } else {
                    // yes - show edit form
                    
                    ?>
                        <div data-role="content">
                            <input type="hidden" id="projID" name="projID" value="<?php echo $proj->id; ?>" />
                            <h3>Edit Project</h3>
                            <ul data-role="listview" data-inset="true">
                                <li data-role="fieldcontain" >
                                    <label for="projTitle">Title</label>
                                    <input type="text" name="projTitle" id="projTitle" value="<?php echo $proj->name; ?>" onchange="updateProject()" placeholder="Project Title" />
                                </li>
                                <li data-role="fieldcontain" >
                                    <label for="projDesc">Description</label>
                                    <textarea col="40" rows="8" name="projDesc" id="projDesc" placeholder="Description" onchange="updateProject()"><?php
                                        echo $proj->description;
                                  ?></textarea>
                                </li>
                                <li data-role="fieldcontain">
                                    <label for="projOwner">Owner</label>
                                    <select name="projOwner" id="projOwner" data-native-menu="false" onchange="javascript:updateProject();">
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
                                                            if ($proj->owner->id == $row_owner['id']) {
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
                                    <label for="projStart">Start Date</label>
                                    <input type="date" name="projStart" id="projStart" value="<?php echo $proj->date_start; ?>" placeholder="start date" onchange="updateProject()"/>
                                </li>
                                <li data-role="fieldcontain" >
                                    <label for="projEnd">End Date</label>
                                    <input type="date" name="projEnd" id="projEnd" value="<?php echo $proj->date_end; ?>" placeholder="end date" onchange="updateProject()"/>
                                </li>
                                <li data-role="fieldcontain" >
                                    <label for="projStatus">Status</label>
                                    <select name="projStatus" id="projStatus" data-native-menu="false" onchange="updateProject()">
                                        <option value="">Select Status</option>
                                        <?php
                                            // retrieve possible statuses for status selector
                                            $qry_status = "SELECT id, name FROM status ORDER BY sort;";
                                            $res_status = mysql_query($qry_status);
                                            if ($res_status) {
                                                if (mysql_num_rows($res_status) > 0) {
                                                    while ($row_status = mysql_fetch_assoc($res_status)) {
                                                        echo '<option value="'.$row_status['id'].'"';
                                                        if ($proj->status->id === $row_status['id']) {
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
                                    <label for="projVis">Visibility</label>
                                    <select name="projVis" id="projVis" data-native-menu="false" onchange="updateProject()">
                                        <option value="">Select Visibility</option>
                                        <?php
                                            // retrieve possible statuses for status selector
                                            $qry_vis = "SELECT id, name FROM visibility ORDER BY sort;";
                                            $res_vis = mysql_query($qry_vis);
                                            if ($res_vis) {
                                                if (mysql_num_rows($res_vis) > 0) {
                                                    while ($row_vis = mysql_fetch_assoc($res_vis)) {
                                                        echo '<option value="'.$row_vis['id'].'"';
                                                        if ($proj->visibility->id === $row_vis['id']) {
                                                            echo ' selected="selected"';
                                                        }
                                                        echo '>';
                                                        echo $row_vis['name'];
                                                        echo '</option>';
                                                    }
                                                    unset($row_vis);
                                                } else {
                                                    echo '<option value="#">Server Error</option>';
                                                }
                                                mysql_free_result($res_vis);
                                            }
                                        ?>
                                    </select>
                                </li>
                                <li data-role="fieldcontain" >
                                    <label for="projHealth">Health</label>
                                    <select name="projHealth" id="projHealth" data-native-menu="false" onchange="updateProject()">
                                        <option value="">Select Health</option>
                                        <?php
                                            // retrieve possible statuses for status selector
                                            $qry_health = "SELECT id, name FROM health ORDER BY sort;";
                                            $res_health = mysql_query($qry_health);
                                            if ($res_health) {
                                                if (mysql_num_rows($res_health) > 0) {
                                                    while ($row_health = mysql_fetch_assoc($res_health)) {
                                                        echo '<option value="'.$row_health['id'].'"';
                                                        if ($proj->health->id === $row_health['id']) {
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
                                    <label for="projPri">Priority</label>
                                    <select name="projPri" id="projPri" data-native-menu="false" onchange="updateProject()">
                                        <option value="">Select Priority</option>
                                        <?php
                                            // retrieve possible statuses for status selector
                                            $qry_pri = "SELECT id, name FROM priority ORDER BY sort;";
                                            $res_pri = mysql_query($qry_pri);
                                            if ($res_pri) {
                                                if (mysql_num_rows($res_pri) > 0) {
                                                    while ($row_pri = mysql_fetch_assoc($res_pri)) {
                                                        echo '<option value="'.$row_pri['id'].'"';
                                                        if ($proj->priority->id === $row_pri['id']) {
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
                                            <a align="center" href="project.php?id=<?php echo $proj->id; ?>&mode=view" data-role="button">Close</a>
                                        </div>
                                        <div class="ui-block-b">
                                            <a align="center" href="#" ontouch="updateProject(true)" onclick="updateProject(true)" data-role="button" data-theme="b">Save</a>
                                        </div>
                                    </div><!-- /grid-a -->
                                </li>
                            </ul>
                        </div>
                    <?php
                    
                }
                
            } else {
                // no - just display read-only version
                
                ?>
                    <div data-role="content">
                        <input type="hidden" id="projID" name="projID" value="<?php echo $proj->id; ?>" />
                        <input type="hidden" id="projUpdated" name="projUpdated" value="<?php echo $proj->updated; ?>" />
                        <div class="ui-grid-a ui-responsive">
                            <div class="ui-block-a">
                                <h1><?php echo $proj->name; ?></h1>
                                <?php
                                    if ($canEdit) {
                                        echo '<a href="project.php?id='.$proj->id.'&mode=edit" data-role="button" data-inline="true" data-mini="true" data-ajax="false">edit</a>';
                                    }
                                ?>
                                <a href="#" data-role="button" data-inline="true" data-mini="true" data-ajax="false" onclick="showAlert('Alert', 'Requested action is not yet implemented.')">copy</a>
                                <p><?php echo $proj->description; ?></p>
                            </div>
                            <div class="ui-block-b">
                                <table width="100%" id="tab-info" class="table-stroke" align="center">
                                    <tbody>
                                        <tr height="40px">
                                            <td width="15%" align="right"><p>Owner</p></td>
                                            <td width="35%" align="left">
                                                <a href="#"><img src="images/glyphish/111-user.png" height="15px" width="15px" alt="owned by" /> <?php echo $proj->owner->getFullName(); ?></a>
                                            </td>
                                            <td width="15%" align="right"><p>Created</p></td>
                                            <td width="35%" align="left">
                                                <img src="images/glyphish/83-calendar.png" height="15px" width="15px" alt="date" /> <?php echo $proj->created_format; ?><br/>
                                                <a href="#"><img src="images/glyphish/111-user.png" height="15px" width="15px" alt="created by" /> <?php echo $proj->creator->getFullName(); ?></a>
                                            </td>
                                        </tr>
                                        <tr height="40px">
                                            <td width="15%" align="right"><p>Start</p></td>
                                            <td width="35%" align="left">
                                                <img src="images/glyphish/83-calendar.png" height="15px" width="15px" alt="date" /> <?php echo $proj->start_format; ?>
                                            </td>
                                            <td width="15%" align="right"><p>End</p></td>
                                            <td width="35%" align="left">
                                                <img src="images/glyphish/83-calendar.png" height="15px" width="15px" alt="date" /> <?php echo $proj->end_format; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- /grid-a -->
                        
                        
                        
                        
                        <p><img src="images/glyphish/111-user.png" height="15px" alt="owned by" />   <a href="mailto:<?php echo $proj->owner->email; ?>"><?php echo $proj->owner->getFullName(); ?></a></p>
                        
                        
                        
                        
                        
                        <div data-role="collapsible-set">
                            
                            <div data-role="collapsible" data-content-theme="c">
                                <h3>Information</h3>
                                <table width="95%" id="tab-info" class="table-stroke">
                                    
                                    
                                    <tbody>
                                    <tr>
                                        <td width="30%" align="right">Created</td>
                                        <td width="70%" align="left">
                                            <img src="images/glyphish/83-calendar.png" height="15px" width="15px" alt="date" /> <?php echo $proj->created_format; ?><br/>
                                           <img src="images/glyphish/111-user.png" height="15px" width="15px" alt="created by" /> <?php echo $proj->creator->getFullName(); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                    </tr>
                                    <tr>
                                        <td align="right">Start <img src="images/glyphish/83-calendar.png" height="15px" width="15px" alt="date" /></td>
                                        <td align="left"><?php echo $proj->start_format; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">End <img src="images/glyphish/83-calendar.png" height="15px" width="15px" alt="date" /></td>
                                        <td align="left"><?php echo $proj->end_format; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Updated</td>
                                        <td align="left">
                                            <img src="images/glyphish/83-calendar.png" height="15px" width="15px" alt="date" /> <?php echo $proj->updated_format; ?> <br/>
                                            <img src="images/glyphish/111-user.png" height="15px" width="15px" alt="updated by" /> <?php echo $proj->updater->getFullName(); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Status</td>
                                        <td align="left"><?php echo $proj->status->name; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Visibility</td>
                                        <td align="left"><?php echo $proj->visibility->name; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Health</td>
                                        <td align="left"><?php echo $proj->health->name; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Priority</td>
                                        <td align="left"><?php echo $proj->priority->name; ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        <?php
                            // list tasks belonging to current project.
                            echo '<div data-role="collapsible" data-content-theme="c">';
                            $tl = new ReportList(3, $CURRENT_USER->id, $proj->id);
                            echo '<h3>'.$tl->list_name.'</h3>';
                            echo '<ul data-role="listview" data-theme="d" data-divider-theme="d">';
                            ?><li data-role="list-divider">
                                <input type="hidden" id="projID" name="projID" value="<?php echo $proj->id; ?>" />
                                <a href="#" data-role="button" onclick="createNewJob('t')" data-mini="true" data-inline="true">new</a>
                            </li><?php
                            echo $tl->list_content;
                            echo '</ul></div>';

                            // list deliverables belonging to current project.
                            echo '<div data-role="collapsible" data-content-theme="c">';
                            $dl = new ReportList(4, $CURRENT_USER->id, $proj->id);
                            echo '<h3>'.$dl->list_name.'</h3>';
                            echo '<ul data-role="listview" data-theme="d" data-divider-theme="d">';
                            echo $dl->list_content;
                            echo '</ul></div>';
                        ?>
                        <div data-role="collapsible" data-content-theme="c">
                            <h3>Comments</h3>
                            <?php   if (count($comments) > 0) {
                                foreach ($comments as $com) {
                                    echo '<li>'.$com->message.'</li>';
                                }
                            } else {
                                echo '<p>No comments have been left against this project.</p>';
                            } ?>
                        </div>
                    </div>
                </div> <!-- close content -->
                <?php
            }
        }
//        $proj = new Project($_GET['id']);
//        $proj->getComments();
//        $comments = $proj->comments;
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