<?php

    if (isset($_GET['mode'])) {
        $MODE = $_GET['mode'];
    } else {
        $MODE = 'view';
    }

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
            // yes - do they want to edit the project?
            if ($MODE === 'edit') {
                // yes - is the user allowed to edit?
                $canEdit = canModifyProject();
                if (!$canEdit) {
                    // no - show message
                    ?>
                        <div data-role="content">
                            <h1>Unauthorised Request</h1>
                            <p>You are not authorised to modify this project.</p>
                            <a href="project.php?id=<?php echo $_GET['id']; ?>&mode=view" data-role="button" prefetch>View Project</a>
                        </div>
                    <?php
                } else {
                    // yes - show edit form
                    $proj = new Project($_GET['id']);
                    // TODO: do we need a <form>?
                    ?>
                        <div data-role="content">
                            <h1>Edit Project</h1>
                            <ul data-role="listview" data-inset="true">
                                <li data-role="fieldcontain" >
                                    <label for="projTitle">Project Title</label>
                                    <input type="text" name="projTitle" id="projTitle" value="<?php echo $proj->name; ?>" placeholder="Project Title" />
                                </li>
                                <li data-role="fieldcontain" >
                                    <label for="projDesc">Description</label>
                                    <textarea col="40" rows="8" name="projDesc" id="projDesc" placeholder="Description"><?php echo $proj->desc; ?></textarea>
                                </li>
                                
                                <script>
                                    $( document ).on( "pageinit", "#pageid", function() {
                                        $( "#projOwner" ).on( "listviewbeforefilter", function ( e, data ) {
                                            var $ul = $( this ),
                                                $input = $( data.input ),
                                                value = $input.val(),
                                                html = "";
                                            $ul.html( "" );
                                            if ( value && value.length > 2 ) {
                                                $ul.html( "<li><div class='ui-loader'><span class='ui-icon ui-icon-loading'></span></div></li>" );
                                                $ul.listview( "refresh" );
                                                $.ajax({
                                                    url: "http://gd.geobytes.com/AutoCompleteCity",
                                                    dataType: "jsonp",
                                                    crossDomain: true,
                                                    data: {
                                                        q: $input.val()
                                                    }
                                                })
                                                .then( function ( response ) {
                                                    $.each( response, function ( i, val ) {
                                                        html += "<li>" + val + "</li>";
                                                    });
                                                    $ul.html( html );
                                                    $ul.listview( "refresh" );
                                                    $ul.trigger( "updatelayout");
                                                });
                                            }
                                        });
                                    });
                                </script>
                                
                                
                                <li data-role="fieldcontain">
                                    <label for="projOwner">Owner</label>
                                    <h3>Cities worldwide</h3>
                                    <p>After you enter <strong>at least three characters</strong> the autocomplete function will show all possible matches.</p>
                                    <ul id="projOwner" data-role="listview" data-filter="true" data-filter-placeholder="Find a city..." data-filter-theme="d"></ul>
                                </li>
                                <li data-role="fieldcontain" >
                                    <label for="projTitle">Project Title</label>
                                    <input type="text" name="projTitle" id="projTitle" value="<?php echo $proj->name; ?>" placeholder="Project Title" />
                                </li>
                                <li data-role="fieldcontain" >
                                    <label for="projTitle">Project Title</label>
                                    <input type="text" name="projTitle" id="projTitle" value="<?php echo $proj->name; ?>" placeholder="Project Title" />
                                </li>
                                
                            </ul>
                        </div>
                    <?php
                    
                }
                
            } else {
                // no - just display read-only version
                
                $proj = new Project($_GET['id']);
                $proj->getComments();
                $comments = $proj->comments;
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
                <?php
            }
        }
        $proj = new Project($_GET['id']);
        $proj->getComments();
        $comments = $proj->comments;
    }
?>

            
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