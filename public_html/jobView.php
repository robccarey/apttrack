<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <div class="sidebar-nav-fixed">
                <div class="page-header visible-phone">
                    <h1><?php echo $job->name; ?><small> Owned by: <strong><?php echo $job->owner->getFullName(); ?></strong></small></h1>
                </div>
                <h5>Actions</h5>
                <ul class="nav nav-tabs nav-stacked">
                    <?php
                        if ($canEdit) {
                            echo '<li><a href="job.php?id='.$job->id.'&mode=edit"><i class="icon-pencil"></i> Edit</a></li>';
                        }
                    ?>
                    <li><a href="#newcom" role="button" data-toggle="modal"><i class="icon-comment"></i> New Comment</a></li>
                </ul>

                <h5>Jump To...</h5>
                <ul class="nav nav-tabs nav-stacked" >
                    <li><a href="#info" role="button" data-toggle="modal"><i class="icon-info-sign"></i> Information</a></li>
                    <li><a href="#comments"><i class="icon-comment"></i> Comments</a></li>
                    <li><a href="#related"><i class="icon-comment"></i> Related Items</a></li>
                    <li><a href="#tags"><i class="icon-tags"></i> Tags</a></li>
                </ul>
            </div> <!-- /nav-fixed -->
        </div> <!-- /span3 -->
        <div class="span9">
            <div class="page-header hidden-phone">
                <h1><?php echo $job->name; ?><small> Owned by: <strong><?php echo $job->owner->getFullName(); ?></strong></small></h1>
            </div>
            <p class="lead"><?php echo $job->description; ?></p>
            <span class="label label-info">PROJECT</span> <a href="project.php?id=<?php echo $proj->id; ?>&mode=view"><?php echo $proj->name; ?></a>
            <br><br>
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
            
            <section id="related">
                <h2>Related Items</h2>
                <a href="#edrel" class="btn" role="button" data-toggle="modal"><i class="icon-pencil"></i> Edit</a><br><br>
                <ul class="nav nav-tabs nav-stacked">
                <?php
                    if (count($related) > 0) {
                        foreach ($related as $item) {
                            echo '<li>';
                            echo '<a href="job.php?mode=view&id='.$item->id.'">';
                            echo '<h4 style="color: #000000;">'.$item->name;
                            echo '<small> '.$item->description.'</small></h4>';
                            echo '<p class="muted">Last updated:<strong> '.$item->updated.'</strong></p>';
                            echo '</a>';
                            echo '</li>';
                        }
                    } else {
                        echo '<li><a class="muted">No related items.</a></li>';
                    }
                    echo '</ul>';
                ?>
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
            </section>
            
            <section id="tags">
                <h2>Tags</h2>
                <p><strong>TO DO:</strong> Implement tags.</p>
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
            </section>
        </div>
    </div> <!-- /row -->
    
    <!-- new comment modal -->
    <div id="newcom" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="newcomment" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="newcomment">New Comment</h3>
        </div>
        <form class="form-horizontal" action="job.php?id=<?php echo $job->id; ?>&mode-view#comments" method="POST">
            <input type="hidden" name="newcom" value="newcom"/>
            <input type="hidden" name="jobID" value="<?php echo $job->id; ?>"/>
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
    <div id="info" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="jobinfo" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="jobinfo">Information</h3>
        </div>
        
        <div class="modal-body">
            <table class="table table-stroke table-condensed">
                <tbody>
                    <tr>
                        <td><span class="label">Owner</span></td>
                        <td><a href="#"><i class="icon-user"></i> <?php echo $job->owner->getFullName(); ?></a></td>
                    </tr><tr>
                        <td><span class="label">Updated</span></td>
                        <td>
                            <i class="icon-calendar"></i> <?php echo $job->created_format; ?><br/>
                            <a href="#"><i class="icon-user"></i> <?php echo $job->creator->getFullName(); ?></a>
                        </td>
                    </tr><tr>
                        <td><span class="label">Created</span></td>
                        <td>
                            <i class="icon-calendar"></i> <?php echo $job->updated_format; ?><br/>
                            <a href="#"><i class="icon-user"></i> <?php echo $job->updater->getFullName(); ?></a>
                        </td>
                    </tr><tr>
                        <td><span class="label">Project Start</span></td>
                        <td>
                            <i class="icon-calendar"></i> <?php echo $job->start_format; ?>
                        </td>
                    </tr><tr>
                        <td><span class="label">Project End</span></td>
                        <td>
                            <i class="icon-calendar"></i> <?php echo $job->end_format; ?>
                        </td>
                    </tr><tr>
                        <td><span class="label">Health</span></td>
                        <td>
                            <?php echo $job->health->name; ?>
                        </td>
                    </tr><tr>
                        <td><span class="label">Status</span></td>
                        <td>
                            <?php echo $job->status->name; ?>
                        </td>
                    </tr><tr>
                        <td><span class="label">Priority</span></td>
                        <td>
                            <?php echo $job->priority->name; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button>
        </div>
    </div> <!-- /information modal -->
    
    <!-- related items modal -->
    <div id="edrel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="editrelated" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="editrelated">Related Items</h3>
            
        </div>
        
        <div class="modal-body">
            <div class="navbar">
                <div class="navbar-inner">
                    <form class="navbar-search">
                        <input type="text" class="search-query input-block-level" id="relSearch" onkeyup="searchRelated()" placeholder="Search">
                    </form>
                </div>
            </div>
            <div class="container-fluid" id="relResults">
                <p class="muted">Start typing above to search... </p>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button>
        </div>
    </div> <!-- /related items modal -->
</div> <!-- /container -->