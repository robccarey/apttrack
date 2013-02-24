<?php

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
        $canView = canViewProject();
        if (!$canView) {
            // NO
        ?>
            <div data-role="content">
                <h1>Unauthorised User</h1>
                <p>You are not authorised to view the specified project.</p>
            </div>
        <?php
        } else {
            // yes
            // can they edit the project?
            $canEdit = canModifyProject();
        }
        $proj = new Project($_GET['id']);
        $proj->getComments();
        $comments = $proj->comments;
    }
?>

            <div data-role="content">
                <h1><?php echo $proj->name; ?></h1>
                <p><?php echo $proj->description; ?></p>
                <p><strong>Owned by: </strong><a href="mailto:<?php echo $proj->owner->email; ?>"><?php echo $proj->owner->getFullName(); ?></a></p>
                
                <div data-role="collapsible-set">
                    <div data-role="collapsible" data-content-theme="c" data-collapsed="false">
                        <h3>Information</h3>
                        <table width="95%" id="tab-info" class="table-stroke">
                            
                            <tbody>
                            <tr>
                                <td width="30%" align="right"><label>Created</label></td>
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
                            </tbody>
                        </table>
                    </div>
                    
                    <?php
                        // list tasks belonging to current project.
                        echo '<div data-role="collapsible" data-content-theme="c">';
                        $rl = new ReportList(3, $CURRENT_USER->id, $proj->id);
                        echo '<h3>'.$rl->list_name.'</h3>';
                        echo $rl->list_content;
                        echo '</div>';
                    
                        // list deliverables belonging to current project.
                        echo '<div data-role="collapsible" data-content-theme="c">';
                        $rl = new ReportList(4, $CURRENT_USER->id, $proj->id);
                        echo '<h3>'.$rl->list_name.'</h3>';
                        echo $rl->list_content;
                        echo '</div>';
                        
                        
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