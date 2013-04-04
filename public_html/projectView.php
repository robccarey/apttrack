<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <div class="sidebar-nav-fixed">
                <div class="page-header visible-phone">
                    <h1><?php echo $proj->getName(); ?><small> Owned by: <strong><?php echo $proj->getOwnerFullName(); ?></strong></small></h1>
                </div>
                <h5>Actions</h5>
                <ul class="nav nav-tabs nav-stacked">
                    <?php
                        if ($canEdit) {
                            echo '<li><a href="project.php?id='.$proj->getID().'&mode=edit"><i class="icon-pencil"></i> Edit</a></li>';
                        }
                    ?>
                    <li><a href="job.php?id=new&mode=edit&type=t&proj=<?php echo $proj->getID(); ?>"><i class="icon-tasks"></i> New Task</a></li>
                    <li><a href="job.php?id=new&mode=edit&type=d&proj=<?php echo $proj->getID(); ?>"><i class="icon-folder-close"></i> New Deliverable</a></li>
                    <li><a href="#newcom" role="button" data-toggle="modal"><i class="icon-comment"></i> New Comment</a></li>
                </ul>

                <h5>Jump To...</h5>
                <ul class="nav nav-tabs nav-stacked" >
                    <li><a href="#info" role="button" data-toggle="modal"><i class="icon-info-sign"></i> Information</a></li>
                    <li><a href="#comments"><i class="icon-comment"></i> Comments</a></li>
                    <li><a href="#tasks"><i class="icon-tasks"></i> Tasks</a></li>
                    <li><a href="#deliv"><i class="icon-folder-close"></i> Deliverables</a></li>
                    <li><a href="#tags"><i class="icon-tags"></i> Tags</a></li>
                </ul>
            </div> <!-- /nav-fixed -->
        </div> <!-- /span3 -->
        <div class="span9">
            <div class="page-header hidden-phone">
                <h1><?php echo $proj->getName(); ?><small> Owned by: <strong><?php echo $proj->getOwnerFullName(); ?></strong></small></h1>
            </div>
            <p class="lead"><?php echo $proj->getDescription(); ?></p>
            
            <section id="comments">
                <h2>Comments</h2>
                <?php echo $msg_com; ?>
                <a href="#newcom" class="btn" role="button" data-toggle="modal"><i class="icon-plus"></i> New</a><br><br>
                <ul class="nav nav-tabs nav-stacked">
                <?php   if (count($comments) > 0) {
                    foreach ($comments as $com) {
                        echo '<li><a>';
                        echo '<p class="muted pull-right">'.$com->getTime().'</p>';
                        echo '<p class="muted">'.$com->getUserFullName().' said:</p>';

                        echo $com->getMessage();
                        echo '</a></li>';
                    }
                } else {
                    echo '<li><a class="muted">No comments have been left against this project.</a></li>';
                } ?>
                </ul>

                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
            </section>

            <section id="tasks">
                <h2>Tasks</h2>
                <a href="job.php?id=new&mode=edit&type=t&proj=<?php echo $proj->getID(); ?>" class="btn"><i class="icon-plus"></i> New</a><br><br>
                <?php
                    // list tasks belonging to current project.
                    $tl = new ReportList(3, $CURRENT_USER->getID(), $proj->getID());
                    echo '<ul class="nav nav-tabs nav-stacked">';
                    echo $tl->getContent();
                    echo '</ul>';
                ?>
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
            </section>

            <section id="deliv">
                <h2>Deliverables</h2>
                <a href="job.php?id=new&mode=edit&type=d&proj=<?php echo $proj->getID(); ?>" class="btn"><i class="icon-plus"></i> New</a><br><br>
                <?php
                    // list deliverables belonging to current project.
                    $dl = new ReportList(4, $CURRENT_USER->getID, $proj->getID);
                    echo '<ul class="nav nav-tabs nav-stacked">';
                    echo $dl->getContent();
                    echo '</ul>';
                ?>
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
            </section>
            
            <section id="tags">
                <h2>Tags</h2>
                <a href="#" class="btn">Edit</a><br><br>
                <?php
                    $tgs = $proj->getTags();
                    echo '<div class="well">';
                    foreach ($tgs as $tg) {
                        echo '<a href="#" class="btn btn-inverse">'.$tg->getTag().'</a> ';
                    }
                    echo '</div>';
                ?>
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
            </section>

        </div> <!-- /span9 - everything -->
    </div> <!-- /row -->
    
    <!-- new comment modal -->
    <div id="newcom" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="newcomment" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">New Comment</h3>
        </div>
        <form class="form-horizontal" action="project.php?id=<?php echo $proj->getID(); ?>&mode-view#comments" method="POST">
            <input type="hidden" name="newcom" value="newcom"/>
            <input type="hidden" name="projID" value="<?php echo $proj->getID(); ?>"/>
            <div class="modal-body">
                <p>Enter your comment below.</p>
                <div class="control-group">
                    <label class="control-label" for="comment">Comment</label>
                    <div class="controls">
                        <textarea name="comment" id="comment" placeholder="Comment" required></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="icon-refresh"></i> Save</button>
            </div>
        </form>
    </div> <!-- /new comment modal -->
    
    <!-- information modal -->
    <div id="info" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="projinfo" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="projinfo">Information</h3>
        </div>
        <div class="modal-body">
            <table class="table table-condensed">
                <tbody>
                    <tr>
                        <td><span class="label">Owner</span></td>
                        <td><a href="#"><i class="icon-user"></i> <?php echo $proj->getOwnerFullName(); ?></a></td>
                    </tr><tr>
                        <td><span class="label">Updated</span></td>
                        <td>
                            <i class="icon-calendar"></i> <?php echo $proj->getCreated(true); ?><br/>
                            <a href="#"><i class="icon-user"></i> <?php echo $proj->getCreatorFullName(); ?></a>
                        </td>
                    </tr><tr>
                        <td><span class="label">Created</span></td>
                        <td>
                            <i class="icon-calendar"></i> <?php echo $proj->getUpdated(true); ?><br/>
                            <a href="#"><i class="icon-user"></i> <?php echo $proj->getUpdaterFullName(); ?></a>
                        </td>
                    </tr><tr>
                        <td><span class="label">Project Start</span></td>
                        <td>
                            <i class="icon-calendar"></i> <?php echo $proj->getStartDate(true); ?>
                        </td>
                    </tr><tr>
                        <td><span class="label">Project End</span></td>
                        <td>
                            <i class="icon-calendar"></i> <?php echo $proj->getEndDate(true); ?>
                        </td>
                    </tr><tr>
                        <td><span class="label">Health</span></td>
                        <td>
                            <?php echo $proj->getHealthText(); ?>
                        </td>
                    </tr><tr>
                        <td><span class="label">Status</span></td>
                        <td>
                            <?php echo $proj->getStatusText(); ?>
                        </td>
                    </tr><tr>
                        <td><span class="label">Visibility</span></td>
                        <td>
                            <i class="icon-eye-open"></i> <?php echo $proj->getVisibilityText(); ?>
                        </td>
                    </tr><tr>
                        <td><span class="label">Priority</span></td>
                        <td>
                            <?php echo $proj->getPriorityText(); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button>
        </div>
    </div> <!-- /information modal -->
</div> <!-- /container -->