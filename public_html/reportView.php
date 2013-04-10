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
                        <li><a href="report.php?id=<?php echo $id; ?>&mode=gen"><i class="icon-envelope"></i> Generate This Report</a></li>
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
            
            <table class="table table-hover table-condensed">
                <thead>
                    <tr class="inverse">
                        <th></th>
                        <th>Field</th>
                        <th>Label</th>
                        <th>Visible</th>
                        <th>Sort</th>
                        <th>Criteria</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $qry_flds = "SELECT report_field.label,
                            report_field.visible,
                            report_field.sort,
                            report_field.criteria,
                            report_field.position,
                            field.reference FROM report_field, field WHERE report_field.report=".$id." AND report_field.field=field.id ORDER BY position;";
                        $res_flds = mysql_query($qry_flds);
                        if ($res_flds) {
                            $num = mysql_num_rows($res_flds);
                            $first = true;
                            $count = 0;
                            while ($row = mysql_fetch_assoc($res_flds)) {
                                $count++;
                                ?>
                                    <tr <?php if ($row['position'] === '0') { echo ' class="warning"'; } ?>>
                                        <form class="form-inline" action="report.php?id=<?php echo $id; ?>&mode=view" method="POST">
                                        <td>
                                            <?
                                                if ($row['position'] === '0') {
                                                    echo '<i class="icon-minus"></i>';
                                                } else {
                                                    if (!$first) {
                                                        echo '<a href=""><i class="icon-arrow-up"></i></a>';
                                                    } else {
                                                        echo '<i class="icon-arrow-up icon-white"></i>';
                                                        $first = false;
                                                    }
                                                    
                                                    if ($count != $num) {
                                                        echo '<a href=""><i class="icon-arrow-down"></i></a>';
                                                    } else {
                                                        echo '<i class="icon-arrow-down icon-white"></i>';
                                                    }
                                                }
                                            ?>
                                        </td>    
                                            
                                        <td><?php echo $row['reference']; ?></td>
                                        <td><input type="text" name="fldLabel" id="fldLabel" placeholder="Label" value="<?php echo $row['label']; ?>"></td>
                                        <td><input type="checkbox" name="fldVisib" id="fldVisib"<?php if ($row['visible'] === '1') { echo ' checked="checked"'; } ?>></td>
                                        <td>
                                            <?php $sort_order = abs($row['sort']); ?>
                                            <select class="input-small" name="fldSort" id="fldSort">
                                                <option value="0"<?php if ($row['sort'] === '0') { echo 'selected'; } ?>>none</option>
                                                <option value="-<?php echo $sort_order;?>"<?php if ($row['sort'] < 0) { echo 'selected'; } ?>>desc</option>
                                                <option value="+<?php echo $sort_order;?>"<?php if ($row['sort'] > 0) { echo 'selected'; } ?>>asc</option>
                                            </select>
                                        </td>
                                        <td>
                                            <?php
                                                $keywords = '||me.id||';
                                                $new = 'current user';
                                                $temp_crit = str_replace($keywords, $new, $row['criteria']);

                                                $crit_bits = explode('::', $temp_crit);
                                                $func = $crit_bits[0];
                                                switch ($func) {
                                                    case "EQ":
                                                        echo '<span class="label">=</span> '.$crit_bits[1];
                                                        break;
                                                    case "NE":
                                                        echo '<span class="label">!=</span> '.$crit_bits[1];
                                                        break;
                                                    case "GT":
                                                        echo '<span class="label">&gt;</span> '.$crit_bits[1];
                                                        break;
                                                    case "LT":
                                                        echo '<span class="label">&lt;</span> '.$crit_bits[1];
                                                        break;
                                                    case "GE":
                                                        echo '<span class="label">$gt;=</span> '.$crit_bits[1];
                                                        break;
                                                    case "LE":
                                                        echo '<span class="label">$lt;=</span> '.$crit_bits[1];
                                                        break;
                                                    case "BT":
                                                        echo '<span class="label">between</span> '.$crit_bits[1]." and ".$crit_bits[2];
                                                        break;
                                                    case "NB":
                                                        echo '<span class="label">not between</span> '.$crit_bits[1]." and ".$crit_bits[2];
                                                        break;
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <button type="reset" class="btn">Reset</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </td>
                                        </form>
                                    </tr>
                                <?php
                            }
                            mysql_free_result($res_flds);
                        }
                    ?>
                </tbody>
            </table>
            
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
