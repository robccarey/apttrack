<?php
    $rep = new Report($id, $CURRENT_USER->getID());
?>

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <div class="sidebar-nav-fixed">
                <div class="page-header visible-phone">
                    <h1><?php echo $rep->getName(); ?></h1>
                </div>
                <div class="well" style="max-width: 340px; padding: 8px 0;">
                    <ul class="nav nav-list">
                        <li class="nav-header">Actions</li>
                        <li><a href="#newReport" role="button" data-toggle="modal"><i class="icon-plus"></i> New Report</a></li>
                        <?php if ($rep->getCreatorID() === $CURRENT_USER->getID()) { ?>
                            <li><a href="report.php?id=<?php echo $id; ?>&mode=edit"><i class="icon-pencil"></i> Edit Report</a></li>
                        <?php } ?>
                        <li><a href="report.php?id=<?php echo $id; ?>&mode=gen"><i class="icon-file"></i> Generate Report</a></li>
                        <li><a href="reports.php"><i class="icon-print"></i> Reports Menu</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="span9">
            <div class="page-header hidden-phone">
                <h1><?php echo $rep->getName(); ?></h1>
            </div>
            <p class="lead"><?php echo $rep->getInstructions(); ?></p>
            <a onclick="refreshReportViewTable()" class="btn"><i class="icon-refresh"></i> Refresh Table</a>
            <input type="hidden" name="repID" id="repID" value="<?php echo $rep->getID(); ?>">
            <div id="repViewTab">
            <?php include('reportViewTable.php'); ?>
            </div>
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
    
    <?php if ($rep->getCreatorID() === $CURRENT_USER->getID()) { ?>
    <!-- edit report modal -->
    <div id="editreportsort" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="edrepsort" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="edrepsort">Report Sorting</h3><br>
        </div>
        <div class="modal-body" id="edrepcont">

        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button>
        </div>
    </div> <!-- /edit report modal -->
    
    <!-- edit criteria modal -->
    <div id="editCriteria" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="edcrit" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="edcrit">Field Criteria</h3><br>
        </div>
        <div class="modal-body" id="edcritcont">

        </div>
    </div> <!-- /edit criteria modal -->
    <?php } ?>
    
</div> <!-- close container -->
