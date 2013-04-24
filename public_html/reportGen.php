<?php
    $rep = new ReportTable($id, $CURRENT_USER->getID());
?>

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <div class="sidebar-nav-fixed">
                <div class="well" style="max-width: 340px; padding: 8px 0;">
                    <ul class="nav nav-list">
                        <li class="nav-header">Actions</li>
                        <li><a href="#newReport" role="button" data-toggle="modal"><i class="icon-plus"></i> New Report</a></li>
                        <li><a href="report.php?id=<?php echo $id; ?>&mode=view"><i class="icon-cog"></i> Configure Report</a></li>
                        <li><a onclick="repEmailReport(<?php echo $id; ?>)"><i class="icon-envelope"></i> Mail This Report</a></li>
                        <li><a href="reports.php"><i class="icon-print"></i> Reports Menu</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="span9">
            <h1><?php echo $rep->getReportName(); ?></h1>
            <p><?php echo $rep->getReportDescription(); ?></p>
            <?php 
                echo $rep->getStart();
                echo $rep->getHeader();
                echo $rep->getBody();
                echo $rep->getFooter();
                echo $rep->getEnd();
            ?>
            <ul class="nav nav-pills">
                <li><a href="help.php">Help</a></li>
                <li><a href="feedback.php">Feedback</a></li>
            </ul>
                
        </div>
    </div> <!-- close row -->
    
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
</div> <!-- close container -->
