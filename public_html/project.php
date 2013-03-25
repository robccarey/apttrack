<?php

    if (isset($_GET['mode'])) {
        $MODE = $_GET['mode'];
    } else {
        $MODE = 'view';
    }
    $NAV_TAB = 'P';
    include_once('header.php');
    
    if (!isset($_GET['id'])) {
        ?>
            <div class="container">
                <h3 class="text-center">Invalid Project</h3>
                <p class="text-center">Click <a href="projects.php">here</a> to select a different project.</p>
            </div>
        <?php
    } else {
        // can the current user view the selected project?
        $proj = new Project($_GET['id']);
        $canView = canReadProject($proj, $CURRENT_USER);
        if (!$canView) {
            // NO
        ?>
            <div class="container">
                <h3 class="text-center">Unauthorised Request</h3>
                <p class="text-center">You are not authorised to view the selected project.</p>
                <p class="text-center">Click <a href="projects.php">here</a> to select a different project.</p>
                <p class="text-center">Speak to the project manager if you require access to this project.</p>
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
                        <div class="container">
                            <h3 class="text-center">Unauthorised Request</h3>
                            <p class="text-center">You are not authorised to edit the selected project.</p>
                            <p class="text-center">Click <a href="projects.php">here</a> to select a different project.</p>
                            <p class="text-center">Speak to the project manager if you need to modify this project.</p>
                        </div>
                    <?php
                } else {
                    // yes - show edit form
                    
                    ?>
                        <div class="container">
                            <form class="form-horizontal">
                                <input type="hidden" id="projID" name="projID" value="<?php echo $proj->id; ?>" />
                                <h3>Edit Project</h3>

                                <div class="control-group">
                                    <label class="control-label" for="projTitle">Title</label>
                                    <div class="controls">
                                        <input type="text" name="projTitle" id="projTitle" value="<?php echo $proj->name; ?>" onchange="updateProject()" placeholder="Project Title" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="projDesc">Description</label>
                                    <div class="controls">
                                        <textarea col="40" rows="8" name="projDesc" id="projDesc" placeholder="Description" onchange="updateProject()"><?php echo $proj->description; ?></textarea>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="projOwner">Owner</label>
                                    <div class="controls">
                                        <select name="projOwner" id="projOwner" data-native-menu="false" onchange="javascript:updateProject();" data-mini="true">
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
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="projStart">Start Date</label>
                                    <div class="controls">
                                        <input type="date" name="projStart" id="projStart" value="<?php echo $proj->date_start; ?>" placeholder="start date" onchange="updateProject()">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="projEnd">End Date</label>
                                    <div class="controls">
                                        <input type="date" name="projEnd" id="projEnd" value="<?php echo $proj->date_end; ?>" placeholder="end date" onchange="updateProject()">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="projStatus">Status</label>
                                    <div class="controls">
                                        <select name="projStatus" id="projStatus" onchange="updateProject()">
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
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="projVis">Visibility</label>
                                    <div class="controls">
                                        <select name="projVis" id="projVis" onchange="updateProject()">
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
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="projHealth">Health</label>
                                    <div class="controls">
                                        <select name="projHealth" id="projHealth" onchange="updateProject()">
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
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="projPri">Priority</label>
                                    <div class="controls">
                                        <select name="projPri" id="projPri" onchange="updateProject()">
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
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <a class="btn" href="project.php?id=<?php echo $proj->id; ?>&mode=view">Close</a>
                                    <a class="btn btn-primary" href="#" ontouch="updateProject(true)" onclick="updateProject(true)">Save</a>
                                </div>
                            </form>
                        </div>
                    <?php
                    
                }
                
            } else {
                // no - just display read-only version
?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <div class="sidebar-nav-fixed">
                <h5>Actions</h5>
                <ul class="nav nav-tabs nav-stacked">
                    <?php
                        if ($canEdit) {
                            echo '<li><a href="project.php?id='.$proj->id.'&mode=edit"><i class="icon-pencil"></i> Edit</a></li>';
                        }
                    ?>
                    <li><a href="#"><i class="icon-tasks"></i> New Task</a></li>
                    <li><a href="#"><i class="icon-folder-close"></i> New Deliverable</a></li>
                    <li><a href="#"><i class="icon-comment"></i> New Comment</a></li>
                </ul>

                <h5>Jump To...</h5>
                <ul class="nav nav-tabs nav-stacked" >
                    <li><a href="#info"><i class="icon-info-sign"></i> Information</a></li>
                    <li><a href="#tasks"><i class="icon-tasks"></i> Tasks</a></li>
                    <li><a href="#deliv"><i class="icon-folder-close"></i> Deliverables</a></li>
                    <li><a href="#comments"><i class="icon-comment"></i> Comments</a></li>
                </ul>
            </div> <!-- /nav-fixed -->
        </div> <!-- /span3 -->
        <div class="span9">
            <input type="hidden" id="projID" name="projID" value="<?php echo $proj->id; ?>" />
            <input type="hidden" id="projUpdated" name="projUpdated" value="<?php echo $proj->updated; ?>" />
            <div class="row-fluid">
                <div class="span6">
                    <h1><?php echo $proj->name; ?></h1>
                    <p><?php echo $proj->description; ?></p>
                </div> <!-- /span6 - title/desc -->
                <div class="span3">
                    <section id="info">
                        <div class="page-header">
                            <h2>Information</h2>
                        </div>
                        <table class="table table-condensed">
                            <tbody>
                                <tr>
                                    <td><span class="label">Owner</span></td>
                                    <td><a href="#"><i class="icon-user"></i> <?php echo $proj->owner->getFullName(); ?></a></td>
                                </tr><tr>
                                    <td><span class="label">Updated</span></td>
                                    <td>
                                        <i class="icon-calendar"></i> <?php echo $proj->created_format; ?><br/>
                                        <a href="#"><i class="icon-user"></i> <?php echo $proj->creator->getFullName(); ?></a>
                                    </td>
                                </tr><tr>
                                    <td><span class="label">Created</span></td>
                                    <td>
                                        <i class="icon-calendar"></i> <?php echo $proj->updated_format; ?><br/>
                                        <a href="#"><i class="icon-user"></i> <?php echo $proj->updater->getFullName(); ?></a>
                                    </td>
                                </tr><tr>
                                    <td><span class="label">Project Start</span></td>
                                    <td>
                                        <i class="icon-calendar"></i> <?php echo $proj->start_format; ?>
                                    </td>
                                </tr><tr>
                                    <td><span class="label">Project End</span></td>
                                    <td>
                                        <i class="icon-calendar"></i> <?php echo $proj->end_format; ?>
                                    </td>
                                </tr><tr>
                                    <td><span class="label">Health</span></td>
                                    <td>
                                        <?php echo $proj->health->name; ?>
                                    </td>
                                </tr><tr>
                                    <td><span class="label">Status</span></td>
                                    <td>
                                        <?php echo $proj->status->name; ?>
                                    </td>
                                </tr><tr>
                                    <td><span class="label">Visibility</span></td>
                                    <td>
                                        <i class="icon-eye-open"></i> <?php echo $proj->visibility->name; ?>
                                    </td>
                                </tr><tr>
                                    <td><span class="label">Priority</span></td>
                                    <td>
                                        <?php echo $proj->priority->name; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
                    </section>
                </div> <!-- /span - information -->
            </div><!-- /row - title/desc/info -->
                        
            <div class="row-fluid">
                <div class="span9">
                    <section id="tasks">
                        <div class="page-header">
                            <h2>Tasks</h2>
                        </div>
                        <?php
                            // list tasks belonging to current project.
                            $tl = new ReportList(3, $CURRENT_USER->id, $proj->id);
                            echo '<ul class="nav nav-tabs nav-stacked">';
                            ?><li data-role="list-divider">
                                <input type="hidden" id="projID" name="projID" value="<?php echo $proj->id; ?>" />
                                <a href="#" class="btn" onclick="createNewJob('t')" ><i class="icon-plus"></i>New Task</a>
                            </li><?php
                            echo $tl->list_content;
                            echo '</ul>';
                        ?>
                        <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
                    </section>

                    <section id="deliv">
                        <div class="page-header">
                            <h2>Deliverables</h2>
                        </div>
                        <?php
                            // list deliverables belonging to current project.
                            $dl = new ReportList(4, $CURRENT_USER->id, $proj->id);
                            echo '<ul class="nav nav-tabs nav-stacked">';
                            ?><li data-role="list-divider">
                                <input type="hidden" id="projID" name="projID" value="<?php echo $proj->id; ?>" />
                                <a href="#" class="btn" onclick="createNewJob('d')" ><i class="icon-plus"></i>New Deliverable</a>
                            </li><?php
                            echo $dl->list_content;
                            echo '</ul>';
                        ?>
                        <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
                    </section>

                    <section id="comments">
                        <div class="page-header">
                            <h2>Comments</h2>
                        </div>
                            <?php   if (count($comments) > 0) {
                                foreach ($comments as $com) {
                                    echo '<li>'.$com->message.'</li>';
                                }
                            } else {
                                echo '<p>No comments have been left against this project.</p>';
                            } ?>
                        <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
                    </section>
                </div> <!-- /span9 - tasks/delivs/comms -->
            </div> <!-- /row -->
        </div> <!-- /span9 - everything -->
    </div> <!-- /row -->
</div> <!-- /container -->
                        

                <?php
            }
        }
    }
?>
 <?php include_once('footer.php'); ?>