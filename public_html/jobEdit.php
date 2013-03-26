<div class="container-fluid">
    <div class="row-fluid">
        <div class="span4 offset2">
            <form class="form-horizontal" action="job.php?id=<?php echo $job->getID(); ?>&mode=edit" method="POST">
                <input type="hidden" name="update" value="update"/>
                <input type="hidden" name="jobID" value="<?php echo $job->getID(); ?>" />
                <h3>Edit Item</h3>
                <?php echo $msg_edit; ?>
                <div class="control-group">
                    <label class="control-label" for="jobTitle">Title</label>
                    <div class="controls">
                        <input class="input-block-level" type="text" name="jobTitle" id="jobTitle" value="<?php echo $job->getName(); ?>" placeholder="Title" required>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="jobDesc">Description</label>
                    <div class="controls">
                        <textarea class="input-block-level" name="jobDesc" id="jobDesc" placeholder="Description"><?php echo $job->getDescription(); ?></textarea>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="jobOwner">Owner</label>
                    <div class="controls">
                        <select class="input-block-level" name="jobOwner" id="jobOwner" required>
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
                                            if ($job->getOwnerID() == $row_owner['id']) {
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
                    <label class="control-label" for="jobStart">Start Date</label>
                    <div class="controls">
                        <input class="input-block-level" type="date" name="jobStart" id="jobStart" value="<?php echo $job->getStartDate(); ?>" placeholder="start date"/>
                    </div>
                </div>


                <div class="control-group">
                    <label class="control-label" for="jobEnd">End Date</label>
                    <div class="controls">
                        <input class="input-block-level" type="date" name="jobEnd" id="jobEnd" value="<?php echo $job->getEndDate(); ?>" placeholder="end date"/>
                    </div>
                </div>


                <div class="control-group">
                    <label class="control-label" for="jobStatus">Status</label>
                    <div class="controls">
                        <select class="input-block-level" name="jobStatus" id="jobStatus" required>
                        <?php
                            // retrieve possible statuses for status selector
                            $qry_status = "SELECT id, name FROM status ORDER BY sort;";
                            $res_status = mysql_query($qry_status);
                            if ($res_status) {
                                if (mysql_num_rows($res_status) > 0) {
                                    while ($row_status = mysql_fetch_assoc($res_status)) {
                                        echo '<option value="'.$row_status['id'].'"';
                                        if ($job->getStatusID() === $row_status['id']) {
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
                    <label class="control-label" for="jobHealth">Health</label>
                    <div class="controls">
                        <select class="input-block-level" name="jobHealth" id="jobHealth" required>
                        <?php
                            // retrieve possible statuses for status selector
                            $qry_health = "SELECT id, name FROM health ORDER BY sort;";
                            $res_health = mysql_query($qry_health);
                            if ($res_health) {
                                if (mysql_num_rows($res_health) > 0) {
                                    while ($row_health = mysql_fetch_assoc($res_health)) {
                                        echo '<option value="'.$row_health['id'].'"';
                                        if ($job->getHealth() === $row_health['id']) {
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
                    <label class="control-label" for="jobPri">Priority</label>
                    <div class="controls">
                        <select class="input-block-level" name="jobPri" id="jobPri" required>
                        <?php
                            // retrieve possible statuses for status selector
                            $qry_pri = "SELECT id, name FROM priority ORDER BY sort;";
                            $res_pri = mysql_query($qry_pri);
                            if ($res_pri) {
                                if (mysql_num_rows($res_pri) > 0) {
                                    while ($row_pri = mysql_fetch_assoc($res_pri)) {
                                        echo '<option value="'.$row_pri['id'].'"';
                                        if ($job->getPriorityID() === $row_pri['id']) {
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
                    <a class="btn" href="job.php?id=<?php echo $job->getID(); ?>&mode=view"><i class="icon-remove"></i> Close</a>
                    <button type="submit" class="btn btn-primary"><i class="icon-refresh"></i> Save</button>
                </div>
            </form>
        </div> <!-- /span -->
    </div> <!-- /row -->
</div> <!-- /container -->