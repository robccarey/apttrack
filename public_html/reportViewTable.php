<table class="table table-hover table-condensed">
    <thead>
        <tr class="inverse">
            <th>Pos</th>
            <th>Field</th>
            <th>Label</th>
            <th>Visible</th>
            <th>Sort <?php if ($rep->getCreatorID() === $CURRENT_USER->getID()) { ?><a href="#editreportsort" role="button" data-toggle="modal">edit</a><?php } ?></th>
            <th colspan="2">Criteria</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $qry_flds = "SELECT report_field.field,
                report_field.label,
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
                            <form class="form-inline" id="form<?php echo $row['field']; ?>" action="report.php?id=<?php echo $id; ?>&mode=view" method="POST">
                            <td>
                                <?
                                if ($rep->getCreatorID() === $CURRENT_USER->getID()) {
                                    if ($row['position'] === '0') {
                                        echo '<a onclick="repRemoveField('.$row['field'].')"><i class="icon-minus"></i></a>';
                                    } else {
                                        if (!$first) {
                                            echo '<a onclick="repMoveFieldUp('.$row['field'].')"><i class="icon-arrow-up"></i></a>';
                                        } else {
                                            echo '<i class="icon-arrow-up icon-white"></i>';
                                            $first = false;
                                        }

                                        if ($count != $num) {
                                            echo '<a onclick="repMoveFieldDown('.$row['field'].')"><i class="icon-arrow-down"></i></a>';
                                        } else {
                                            echo '<i class="icon-arrow-down icon-white"></i>';
                                        }
                                    }
                                } else {
                                    echo $row['position'];
                                }
                                ?>
                            </td>    

                            <td><?php echo $row['reference']; ?></td>
                            <td>
                                <?php if ($rep->getCreatorID() === $CURRENT_USER->getID()) { ?>
                                <input type="text" class="input-medium" name="fldLabel" id="fldLabel<?php echo $row['field']; ?>" onblur="repSetLabel(<?php echo $row['field']; ?>)" placeholder="Label" value="<?php echo $row['label']; ?>">
                                <?php } else { echo $row['label']; }?>
                            </td>
                            <td><?php 
                                if ($rep->getCreatorID() === $CURRENT_USER->getID()) {
                                    if ($row['visible'] === '1') {
                                        // show tick
                                        ?>
                                            <a onclick="repSetVisib(<?php echo $row['field']; ?>, true)" class="btn"><i class="icon-ok"></i></a>     
                                        <?php
                                    } else {
                                        ?>
                                            <a onclick="repSetVisib(<?php echo $row['field']; ?>, false)" class="btn"><i class="icon-minus"></i></a>     
                                        <?php
                                    }
                                } else { 
                                    if ($row['visible'] === '1') {
                                        echo 'yes';
                                    } else {
                                        echo 'no';
                                    }
                                    
                                }?>
                            </td>
                            <td>
                                <?php if ($rep->getCreatorID() === $CURRENT_USER->getID()) { ?>
                                    <select class="input-small" name="fldSort<?php echo $row['field']; ?>" id="fldSort<?php echo $row['field']; ?>" onchange="repSetSort(<?php echo $row['field']; ?>)">
                                        <option value="0"<?php if ($row['sort'] === '0') { echo 'selected'; } ?>>--</option>
                                        <option value="desc"<?php if ($row['sort'] < 0) { echo 'selected'; } ?>>desc</option>
                                        <option value="asc"<?php if ($row['sort'] > 0) { echo 'selected'; } ?>>asc</option>
                                    </select>
                                <?php } else { 
                                        if ($row['sort'] === '0') {
                                            echo '--';
                                        } else if ($row['sort'] < 0) {
                                            echo 'desc';
                                        } else if ($row['sort'] > 0) {
                                            echo 'asc';
                                        }
                                    
                                    }?>
                            </td>
                            <td>
                                <?php
                                    $keywords = array('||me.id||', '||now||');
                                    $new = array('current user', 'current time');
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
                            
                                <td><?php if ($rep->getCreatorID() === $CURRENT_USER->getID()) { ?>
                                <a onclick="repShowCritModal(<?php echo $row['field']; ?>)">edit criteria</a>
                                <?php } ?></td>
                            </form>
                        </tr>
                    <?php
                }
                mysql_free_result($res_flds);
            }
        ?>
    </tbody>
</table>

<?php if ($rep->getCreatorID() === $CURRENT_USER->getID()) { 
    
    $qry_new_flds = "SELECT * FROM field WHERE object=".$rep->getObjectID()." ORDER BY reference;";
    $res_new_flds = mysql_query($qry_new_flds);
    if ($res_new_flds) {
        $rows = array();
        while ($row = mysql_fetch_assoc($res_new_flds)) {
            // is field already in report?
            $qry_fld = "SELECT COUNT(*) as res FROM report_field WHERE report=".$rep->getID()." AND field=".$row['id']." LIMIT 1;";
            $res_fld = mysql_query($qry_fld);
            if ($res_fld) {
                $row_res = mysql_fetch_assoc($res_fld);
                $res = $row_res['res'];
                if ($res === '0') {
                    // output row info
                    $rows[] = '<option value="'.$row['id'].'">'.$row['reference'].'</option>';
                }
                mysql_free_result($res_fld);
            }
        }
        if (count($rows) > 0) {
            ?>
            <form class="form-horizontal" id="repNewField" name="repNewField">
                <div class="control-group">
                    <label class="control-label" for="newRepField">New field</label>
                        
                    <div class="controls">
                        <div class="input-append">
                            <div class="btn-group">
                                <select name="newRepField" id="newRepField">
                                <?php
                                    foreach ($rows as $r) {
                                        echo $r;
                                    }
                                ?>
                                </select>
                                <a class="btn" onclick="repAddField()"><i class="icon-plus"></i> Add Field</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <?php
        } else {
            echo '<p class="muted">No additional fields are available.</p>';
        }
        mysql_free_result($res_new_flds);
    }
}
?>