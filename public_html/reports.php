<?php
    $NAV_TAB = 'R';
    include_once('header.php');
?>
        
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <div class="sidebar-nav-fixed">
                <div class="well" style="max-width: 340px; padding: 8px 0;">
                    <ul class="nav nav-list">
                        <li class="nav-header">Actions</li>
                        <li><a href="#newReport" role="button" data-toggle="modal"><i class="icon-plus"></i> New Report</a></li>
                    
                        <li class="nav-header">Jump To...</li>
                        <li><a href="#myrep">My Reports</a></li>
                        <li><a href="#poprep">Popular Reports</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="span9">
            <section id="myrep">
                <div class="page-header">
                    <h2>My Reports</h2>
                </div>
                <ul class="nav nav-tabs nav-stacked">
                <?php
                    $qry_my_rep = "SELECT id, name, gen_count as counter FROM report WHERE creator=".$CURRENT_USER->getID()." ORDER BY gen_count DESC;";
                    $res_my_rep = mysql_query($qry_my_rep);
                    if ($res_my_rep) {
                        if (mysql_num_rows($res_my_rep) > 0) {
                            while ($row = mysql_fetch_assoc($res_my_rep)) {
                                echo '<li>';
                                echo '<a href="report.php?id='.$row['id'].'">';
                                echo '<h4 style="color: #000000;">'.$row['name'].'</h4>';
                                echo '<p class="muted"><strong>Generated:</strong> '.$row['counter'].'</p>';
                                echo '</a>';
                                echo '</li>';
                            }
                        } else {
                            echo '<li><a class="muted">You have not yet made any reports.</a></li>';
                        }
                        mysql_free_result($res_my_rep);
                    }
                ?>
                </ul>
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> top</a>
            </section>
            
            
            
            <section id="poprep">
                <div class="page-header">
                    <h2>Popular Reports</h2>
                </div>
                <ul class="nav nav-tabs nav-stacked">
                <?php
                    $qry_pop_rep = "SELECT id, name, gen_count as counter FROM report ORDER BY gen_count DESC;";
                    $res_pop_rep = mysql_query($qry_pop_rep);
                    if ($res_pop_rep) {
                        while ($row = mysql_fetch_assoc($res_pop_rep)) {
                            echo '<li>';
                            echo '<a href="report.php?id='.$row['id'].'">';
                            echo '<h4 style="color: #000000;">'.$row['name'].'</h4>';
                            echo '<p class="muted"><strong>Generated:</strong> '.$row['counter'].'</p>';
                            echo '</a>';
                            echo '</li>';
                        }
                        mysql_free_result($res_pop_rep);
                    }
                ?>
                </ul>
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> top</a>
            </section>
            
            <ul class="nav nav-pills">
                <li><a href="help.php">Help</a></li>
                <li><a href="feedback.php">Feedback</a></li>
            </ul>
                
            
        </div> <!-- /span -->
    </div> <!-- /row -->
    
    <!-- create report modal -->
    <div id="newReport" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="newreplabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="newreplabel">Create Report</h3><br>
        </div>
        <form class="form-horizontal" action="report.php?id=new&mode=edit" method="GET">
            <input type="hidden" name="id" value="new">
            <input type="hidden" name="mode" value="edit">
            <div class="modal-body">
                <p class="muted">Select the object you would like to report on.</p>
                <div class="control-group">
                    <label class="control-label" for="obj">Object</label>
                    <div class="controls">
                        <select name="obj" id="obj">
                            <option value="proj">Project</option>
                            <option value="task">Task</option>
                            <option value="deliv">Deliverable</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="icon-plus"></i> Create Report</button>
            </div>
        </form>
    </div> <!-- /create report modal -->
    
</div> <!-- /container -->
 <?php include_once('footer.php'); ?>

