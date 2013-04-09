<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <div class="sidebar-nav-fixed">
                <div class="page-header visible-phone">
                    <h1><?php echo $job->getName(); ?><small> Owned by: <strong><?php echo $job->getOwnerFullName(); ?></strong></small></h1>
                    <span class="label label-info">PROJECT</span> <a href="project.php?id=<?php echo $proj->getID(); ?>&mode=view"><?php echo $proj->getName(); ?></a>
                </div>
                <div class="well" style="max-width: 340px; padding: 8px 0;">
                    <ul class="nav nav-list">
                        <li class="nav-header">Actions</li>
                        <?php
                            if ($canEdit) {
                                echo '<li><a href="job.php?id='.$job->getID().'&mode=edit"><i class="icon-pencil"></i> Edit</a></li>';
                            }
                        ?>
                        <li><a href="#newcom" role="button" data-toggle="modal"><i class="icon-comment"></i> New Comment</a></li>

                        <li class="nav-header">Jump To...</li>
                        <li><a href="#info" role="button" data-toggle="modal"><i class="icon-info-sign"></i> Information</a></li>
                        <li><a href="#comments"><i class="icon-comment"></i> Comments</a></li>
                        <li><a href="#related"><i class="icon-file"></i> Related Items</a></li>
                        <li><a href="#tags"><i class="icon-tags"></i> Tags</a></li>
                    </ul>
                </div>
            </div> <!-- /nav-fixed -->
        </div> <!-- /span3 -->
        <div class="span9">
            <div class="page-header hidden-phone">
                <h1><?php echo $job->getName(); ?><small> Owned by: <strong><?php echo $job->getOwnerFullName(); ?></strong></small></h1>
                <span class="label label-info">PROJECT</span> <a href="project.php?id=<?php echo $proj->getID(); ?>&mode=view"><?php echo $proj->getName(); ?></a>
            </div>
            <p class="lead"><?php echo $job->getDescription(); ?></p>
            <br><br>
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
            
            <section id="related">
                <h2>Related Items</h2>
                <a href="#edrel" class="btn" role="button" data-toggle="modal"><i class="icon-pencil"></i> Edit</a><br><br>
                <ul class="nav nav-tabs nav-stacked" id="jobrelcont">
                <?php
                    if (count($related) > 0) {
                        foreach ($related as $item) {
                            echo '<li>';
                            echo '<a href="job.php?mode=view&id='.$item->getID().'">';
                            echo '<h4 style="color: #000000;">'.$item->getName();
                            echo '<small> '.$item->getDescription().'</small></h4>';
                            echo '<p class="muted">Last updated:<strong> '.$item->getUpdated(true).'</strong></p>';
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
                <a href="#editjobtags" class="btn" role="button" data-toggle="modal"><i class="icon-pencil"></i> Edit</a><br><br>
                <?php
                    $tgs = $job->getTags();
                    echo '<div class="well" id="tagCont">';
                    if (count($tgs) > 0) {
                        foreach ($tgs as $tg) {
                            echo '<a href="#" class="btn btn-inverse">'.$tg->getTag().'</a> ';
                        }
                    } else {
                        echo '<p class="muted">No tags have been assigned.</p>';
                    }
                    echo '</div>';
                ?>
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
        <form class="form-horizontal" action="job.php?id=<?php echo $job->getID(); ?>&mode-view#comments" method="POST">
            <input type="hidden" name="newcom" value="newcom"/>
            <input type="hidden" name="jobID" value="<?php echo $job->getID(); ?>"/>
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
                        <td><a href="#"><i class="icon-user"></i> <?php echo $job->getOwnerFullName(); ?></a></td>
                    </tr><tr>
                        <td><span class="label">Updated</span></td>
                        <td>
                            <i class="icon-calendar"></i> <?php echo $job->getCreated(true); ?><br/>
                            <a href="#"><i class="icon-user"></i> <?php echo $job->getCreatorFullName(); ?></a>
                        </td>
                    </tr><tr>
                        <td><span class="label">Created</span></td>
                        <td>
                            <i class="icon-calendar"></i> <?php echo $job->getUpdated(true); ?><br/>
                            <a href="#"><i class="icon-user"></i> <?php echo $job->getUpdaterFullName(); ?></a>
                        </td>
                    </tr><tr>
                        <td><span class="label">Start</span></td>
                        <td>
                            <i class="icon-calendar"></i> <?php echo $job->getStartDate(true); ?>
                        </td>
                    </tr><tr>
                        <td><span class="label">End</span></td>
                        <td>
                            <i class="icon-calendar"></i> <?php echo $job->getEndDate(true); ?>
                        </td>
                    </tr><tr>
                        <td><span class="label">Health</span></td>
                        <td>
                            <?php echo $job->getHealthText(); ?>
                        </td>
                    </tr><tr>
                        <td><span class="label">Status</span></td>
                        <td>
                            <?php echo $job->getStatusText(); ?>
                        </td>
                    </tr><tr>
                        <td><span class="label">Priority</span></td>
                        <td>
                            <?php echo $job->getPriorityText(); ?>
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
            <h3 id="editrelated">Related Items</h3><br>
            <form>
                <input type="text" class="search-query input-block-level" id="relSearch" onkeyup="searchRelated()" placeholder="Search">
                <input type="hidden" id="jobID" name="jobID" value="<?php echo $job->getID(); ?>">
            </form>
        </div>
        
        <div class="modal-body">
            
            <div id="relMsg"></div>
            <div id="relResults">
                <p class="muted">Start typing above to search... </p>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button>
        </div>
    </div> <!-- /related items modal -->
    
    <!-- tags modal -->
    <div id="editjobtags" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="edittagslabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="edittagslabel">Tags</h3><br>
            <form>
                <input type="text" class="search-query input-block-level" id="tagSearch" onkeyup="searchJobTag()" placeholder="Search">
                <input type="hidden" id="jobID" name="jobID" value="<?php echo $job->getID(); ?>">
            </form>
        </div>
        
        <div class="modal-body">
            
            <div id="tagMsg"></div>
            <div id="tagResults">
                <p class="muted">Start typing above to search... </p>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button>
        </div>
    </div> <!-- /tags modal -->
</div> <!-- /container -->