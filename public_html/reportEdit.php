<?php
    $rep = new Report($id, $CURRENT_USER->getID());
?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span6 offset1">
            <form class="form-horizontal" action="report.php?id=<?php echo $rep->getID(); ?>&mode=edit" method="POST">
                <input type="hidden" name="update" value="update"/>
                <input type="hidden" name="repID" value="<?php echo $rep->getID(); ?>" />
                <h3>Edit Report</h3>
                <?php echo $msg_edit; ?>
                <div class="control-group">
                    <label class="control-label" for="repName">Name</label>
                    <div class="controls">
                        <input class="input-block-level" type="text" name="repName" id="repName" value="<?php echo $rep->getName(); ?>" placeholder="Report Name" required>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="repInstr">Instructions</label>
                    <div class="controls">
                        <textarea class="input-block-level" name="repInstr" id="repInstr" placeholder="Report Instructions"><?php echo $rep->getInstructions(); ?></textarea>
                    </div>
                </div>

                <p>The following fields will be visible on any report.</p>
                <div class="control-group">
                    <label class="control-label" for="repTitle">Title</label>
                    <div class="controls">
                        <input class="input-block-level" type="text" name="repTitle" id="repTitle" value="<?php echo $rep->getTitle(); ?>" placeholder="Report Title" required>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="repDesc">Description</label>
                    <div class="controls">
                        <textarea class="input-block-level" name="repDesc" id="repDesc" placeholder="Report Description"><?php echo $rep->getDescription(); ?></textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <a class="btn" href="report.php?id=<?php echo $rep->getID(); ?>&mode=view"><i class="icon-remove"></i> Close</a>
                    <button type="submit" class="btn btn-primary"><i class="icon-refresh"></i> Save</button>
                </div>
            </form>
        </div> <!-- /span -->
    </div> <!-- /row -->
</div> <!-- /container -->