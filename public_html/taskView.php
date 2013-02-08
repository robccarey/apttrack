<?php

    $PAGE_TITLE = 'aptTrack';
    include_once('header.php');
    
    if (!isset($_GET['tid'])) {
        ?>
            <div data-role="content">
                <h1>Invalid Task Identifier</h1>
            </div>
        <?php
    } else {
        $task = new Task($_GET['tid']);
    }
?>

            <div data-role="content">
                <h1><?php echo $task->name; ?></h1>
                <p><?php echo $task->description; ?></p>
                <p><strong>Owned by: </strong><a href="mailto:<?php echo $task->owner->email; ?>"><?php echo $task->owner->getFullName(); ?></a></p>
                <p><strong>Project: </strong><a href="projectView.php?pid=<?php echo $task->project_id; ?>"><?php echo $task->project_name; ?></a></p>
                
                <div data-role="collapsible-set">
                    <div data-role="collapsible" data-content-theme="c" data-collapsed="false">
                        <h3>Information</h3>
                        <table width="95%" id="tab-info" class="table-stroke">
                            
                            <tbody>
                            <tr>
                                <td width="30%" align="right"><label>Created</label></td>
                                <td width="70%" align="left"><?php echo $task->created; ?></td>
                            </tr>
                            <tr>
                                <td align="right">by</td>
                                <td align="left"><?php echo $task->creator->getFullName(); ?></td>
                            </tr>
                            <tr>
                                <td align="right">Start date</td>
                                <td align="left"><?php echo $task->date_start; ?></td>
                            </tr>
                            <tr>
                                <td align="right">End date</td>
                                <td align="left"><?php echo $task->date_end; ?></td>
                            </tr>
                            <tr>
                                <td align="right">Updated</td>
                                <td align="left"><?php echo $task->updated; ?></td>
                            </tr>
                            <tr>
                                <td align="right">by</td>
                                <td align="left"><?php echo $task->updater->getFullName(); ?></td>
                            </tr>
                            <tr>
                                <td align="right">Status</td>
                                <td align="left"><?php echo $task->status->name; ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div data-role="collapsible" data-content-theme="c">
                        <h3>Comments</h3>
                        <p>No one has commented on this task.</p>
                    </div>
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
