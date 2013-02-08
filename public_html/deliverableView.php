<?php

    $PAGE_TITLE = 'aptTrack';
    include_once('header.php');
    
    if (!isset($_GET['did'])) {
        ?>
            <div data-role="content">
                <h1>Invalid Deliverable Identifier</h1>
            </div>
        <?php
    } else {
        $deliv = new Deliverable($_GET['did']);
    }
?>

            <div data-role="content">
                <h1><?php echo $deliv->name; ?></h1>
                <p><?php echo $deliv->description; ?></p>
                <p><strong>Owned by: </strong><a href="mailto:<?php echo $deliv->owner->email; ?>"><?php echo $deliv->owner->getFullName(); ?></a></p>
                <p><strong>Project: </strong><a href="projectView.php?pid=<?php echo $deliv->project_id; ?>"><?php echo $deliv->project_name; ?></a></p>
                
                <div data-role="collapsible-set">
                    <div data-role="collapsible" data-content-theme="c" data-collapsed="false">
                        <h3>Information</h3>
                        <table width="95%" id="tab-info" class="table-stroke">
                            
                            <tbody>
                            <tr>
                                <td width="30%" align="right"><label>Created</label></td>
                                <td width="70%" align="left"><?php echo $deliv->created; ?></td>
                            </tr>
                            <tr>
                                <td align="right">by</td>
                                <td align="left"><?php echo $deliv->creator->getFullName(); ?></td>
                            </tr>
                            <tr>
                                <td align="right">Start date</td>
                                <td align="left"><?php echo $deliv->date_start; ?></td>
                            </tr>
                            <tr>
                                <td align="right">End date</td>
                                <td align="left"><?php echo $deliv->date_end; ?></td>
                            </tr>
                            <tr>
                                <td align="right">Updated</td>
                                <td align="left"><?php echo $deliv->updated; ?></td>
                            </tr>
                            <tr>
                                <td align="right">by</td>
                                <td align="left"><?php echo $deliv->updater->getFullName(); ?></td>
                            </tr>
                            <tr>
                                <td align="right">Status</td>
                                <td align="left"><?php echo $deliv->status->name; ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div data-role="collapsible" data-content-theme="c">
                        <h3>Comments</h3>
                        <p>No one has commented on this deliverable.</p>
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
