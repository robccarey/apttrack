<?php

    $PAGE_TITLE = 'aptTrack';
    include_once('header.php');
    
    if (!isset($_GET['pid'])) {
        ?>
            <div data-role="content">
                <h1>Invalid Project Identifier</h1>
            </div>
        <?php
    } else {
        $proj = new Project($_GET['pid']);
    }
?>

            <div data-role="content">
                <h1><?php echo $proj->name; ?></h1>
                <p><?php echo $proj->description; ?></p>
                <p><strong>Owned by: </strong><a href="mailto:<?php echo $proj->owner->email; ?>"><?php echo $proj->owner->getFullName(); ?></a></p>
                
                <div data-role="collapsible-set">
                    <div data-role="collapsible" data-content-theme="c">
                        <h3>Project Information</h3>
                        <table border="0" width="95%" align="center">
                            <tr>
                                <td width="30%" align="right">Created</td>
                                
                                <td width="70%" align="left"><?php echo $proj->created; ?></td>
                            </tr>
                            <tr>
                                <td align="right">by</td>
                                <td align="left"><?php echo $proj->creator->getFullName(); ?></td>
                            </tr>
                            <tr>
                                <td align="right">Start date</td>
                                <td align="left"><?php echo $proj->date_start; ?></td>
                            </tr>
                            <tr>
                                <td align="right">Updated</td>
                                <td align="left"><?php echo $proj->updated; ?></td>
                            </tr>
                            <tr>
                                <td align="right">by</td>
                                <td align="left"><?php echo $proj->updater->getFullName(); ?></td>
                            </tr>
                            <tr>
                                <td align="right">Status</td>
                                <td align="left"><?php echo $proj->status->name; ?></td>
                            </tr>
                            <tr>
                                <td align="right">Visibility</td>
                                <td align="left"><?php echo $proj->visibility->name; ?></td>
                            </tr>
                                
                        </table>
                    </div>
                    
                    <?php
                        // TODO: convert following to report
                        // list tasks belonging to current project.
                        $qry_tasks = "SELECT id FROM task WHERE project=".$proj->id.";";
                        $res_tasks = mysql_query($qry_tasks);
                        $count_t = 0;
                        $tasks = array();
                        if ($res_tasks) {
                            // query successful
                            while ($row_tasks = mysql_fetch_assoc($res_tasks)) {
                                $tasks[] = new Task($row_tasks['id']);
                                $count_t++;
                            }
                        } else {
                            echo 'query error.';
                        }
                        mysql_free_result($res_tasks);
                        
                        //var_dump($tasks);
                        echo '<div data-role="collapsible" data-content-theme="c">';
                        echo '<h3>Tasks</h3>';
                        if ($count_t > 0) {
                            // tasks IDed
                            echo '<ul data-role="listview" data-theme="d" data-divider-theme="d">';
                            foreach ($tasks as $task) {
                                echo '<li><a href="taskView.php?tid='.$task->id.'">';
                                echo '<h3>'.$task->name.'</h3>';
                                echo '<p><strong>'.$task->description.'</strong></p>';
                                echo '<p>Last updated: '.$task->updated.'</p>';
                                echo '</a></li>';
                            }
                            echo '</ul>';
                        } else {
                            echo "<p><i>There are no tasks associated with this project.</i></p>";
                        }
                        echo '</div>';
                        
                        
                        
                        
                        // TODO: convert following to report
                        // list deliverables belonging to current project.
                        $qry_deliv = "SELECT id FROM deliverable WHERE project=".$proj->id.";";
                        $res_deliv = mysql_query($qry_deliv);
                        $count_d = 0;
                        $delivs = array();
                        if ($res_deliv) {
                            // query successful
                            while ($row_deliv = mysql_fetch_assoc($res_deliv)) {
                                $delivs[] = new Deliverable($row_deliv['id']);
                                $count_d++;
                            }
                        } else {
                            echo 'query error.';
                        }
                        mysql_free_result($res_deliv);
                        
                        //var_dump($tasks);
                        echo '<div data-role="collapsible" data-content-theme="c">';
                        echo '<h3>Deliverables</h3>';
                        if ($count_d > 0) {
                            // tasks IDed
                            echo '<ul data-role="listview" data-theme="d" data-divider-theme="d">';
                            foreach ($delivs as $deliv) {
                                echo '<li><a href="taskView.php?tid='.$deliv->id.'">';
                                echo '<h3>'.$deliv->name.'</h3>';
                                echo '<p><strong>'.$deliv->description.'</strong></p>';
                                echo '<p>Last updated: '.$deliv->updated.'</p>';
                                echo '</a></li>';
                            }
                            echo '</ul>';
                        } else {
                            echo "<p><i>There are no deliverables associated with this project.</i></p>";
                        }
                        echo '</div>';
                    ?>
                </div>
                
            </div> <!-- close content -->
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