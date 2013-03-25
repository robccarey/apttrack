<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <div class="sidebar-nav-fixed">
                <div class="page-header visible-phone">
                    <h1><?php echo $proj->name; ?><small> Owned by: <strong><?php echo $proj->owner->getFullName(); ?></strong></small></h1>
                </div>
                <h5>Actions</h5>
                <ul class="nav nav-tabs nav-stacked">
                    <?php
                        if ($canEdit) {
                            echo '<li><a href="project.php?id='.$proj->id.'&mode=edit"><i class="icon-pencil"></i> Edit</a></li>';
                        }
                    ?>
                    <li><a href="job.php?id=new&mode=edit&type=t&proj=<?php echo $proj->id; ?>"><i class="icon-tasks"></i> New Task</a></li>
                    <li><a href="job.php?id=new&mode=edit&type=d&proj=<?php echo $proj->id; ?>"><i class="icon-folder-close"></i> New Deliverable</a></li>
                    <li><a href="#newcom" role="button" data-toggle="modal"><i class="icon-comment"></i> New Comment</a></li>
                </ul>

                <h5>Jump To...</h5>
                <ul class="nav nav-tabs nav-stacked" >
                    <li><a href="#info" role="button" data-toggle="modal"><i class="icon-info-sign"></i> Information</a></li>
                    <li><a href="#comments"><i class="icon-comment"></i> Comments</a></li>
                    <li><a href="#tasks"><i class="icon-tasks"></i> Tasks</a></li>
                    <li><a href="#deliv"><i class="icon-folder-close"></i> Deliverables</a></li>
                </ul>
            </div> <!-- /nav-fixed -->
        </div> <!-- /span3 -->
        <div class="span9">
            <div class="page-header hidden-phone">
                <h1><?php echo $proj->name; ?><small> Owned by: <strong><?php echo $proj->owner->getFullName(); ?></strong></small></h1>
            </div>
            <p class="lead"><?php echo $proj->description; ?></p>
            
            <section id="comments">
                <h2>Comments</h2>
                <?php echo $msg_com; ?>
                <a href="#newcom" class="btn" role="button" data-toggle="modal"><i class="icon-plus"></i> New</a><br><br>
                <ul class="nav nav-tabs nav-stacked">
                <?php   if (count($comments) > 0) {
                    foreach ($comments as $com) {
                        echo '<li><a>';
                        echo '<p class="muted pull-right">'.$com->time.'</p>';
                        echo '<p class="muted">'.$com->user->getFullName().' said:</p>';

                        echo $com->message;
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
                <a href="job.php?id=new&mode=edit&type=t&proj=<?php echo $proj->id; ?>" class="btn"><i class="icon-plus"></i> New</a><br><br>
                <?php
                    // list tasks belonging to current project.
                    $tl = new ReportList(3, $CURRENT_USER->id, $proj->id);
                    echo '<ul class="nav nav-tabs nav-stacked">';
                    echo $tl->list_content;
                    echo '</ul>';
                ?>
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
            </section>

            <section id="deliv">
                <h2>Deliverables</h2>
                <a href="job.php?id=new&mode=edit&type=d&proj=<?php echo $proj->id; ?>" class="btn"><i class="icon-plus"></i> New</a><br><br>
                <?php
                    // list deliverables belonging to current project.
                    $dl = new ReportList(4, $CURRENT_USER->id, $proj->id);
                    echo '<ul class="nav nav-tabs nav-stacked">';
                    echo $dl->list_content;
                    echo '</ul>';
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
        <form class="form-horizontal" action="project.php?id=<?php echo $proj->id; ?>&mode-view#comments" method="POST">
            <input type="hidden" name="newcom" value="newcom"/>
            <input type="hidden" name="projID" value="<?php echo $proj->id; ?>"/>
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
                        <td><a href="#"><i class="icon-user"></i> <?php echo $proj->owner->getFullName(); ?></a></td>
                    </tr><tr>
                        <td><span class="label">Updated</span></td>
                        <td>
                            <i class="icon-calendar"></i> <?php echo $proj->created_format; ?><br/>
                            <a href="#"><i class="icon-user"></i> <?php echo $proj->creator->getFullName(); ?></a>
                        </td>
                    </tr><tr>
                        <td><span class="label">Created</span></td>
                        <td>
                            <i class="icon-calendar"></i> <?php echo $proj->updated_format; ?><br/>
                            <a href="#"><i class="icon-user"></i> <?php echo $proj->updater->getFullName(); ?></a>
                        </td>
                    </tr><tr>
                        <td><span class="label">Project Start</span></td>
                        <td>
                            <i class="icon-calendar"></i> <?php echo $proj->start_format; ?>
                        </td>
                    </tr><tr>
                        <td><span class="label">Project End</span></td>
                        <td>
                            <i class="icon-calendar"></i> <?php echo $proj->end_format; ?>
                        </td>
                    </tr><tr>
                        <td><span class="label">Health</span></td>
                        <td>
                            <?php echo $proj->health->name; ?>
                        </td>
                    </tr><tr>
                        <td><span class="label">Status</span></td>
                        <td>
                            <?php echo $proj->status->name; ?>
                        </td>
                    </tr><tr>
                        <td><span class="label">Visibility</span></td>
                        <td>
                            <i class="icon-eye-open"></i> <?php echo $proj->visibility->name; ?>
                        </td>
                    </tr><tr>
                        <td><span class="label">Priority</span></td>
                        <td>
                            <?php echo $proj->priority->name; ?>
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