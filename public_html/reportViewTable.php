<table class="table table-hover table-condensed">
    <thead>
        <tr class="inverse">
            <th></th>
            <th>Field</th>
            <th>Label</th>
            <th>Visible</th>
            <th>Sort</th>
            <th>Criteria</th>
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
                                    if ($row['position'] === '0') {
                                        echo '<i class="icon-minus"></i>';
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
                                ?>
                            </td>    

                            <td><?php echo $row['reference']; ?></td>
                            <td><input type="text" class="input-medium" name="fldLabel" id="fldLabel<?php echo $row['field']; ?>" onblur="repSetLabel(<?php echo $row['field']; ?>)" placeholder="Label" value="<?php echo $row['label']; ?>"></td>
                            <td><input type="checkbox" name="fldVisib" id="fldVisib<?php echo $row['field']; ?>" value="1" onchange="repSetVisib(<?php echo $row['field']; ?>)"<?php if ($row['visible'] === '1') { echo ' checked="checked"'; } ?>></td>
                            <td>
                                <?php $sort_order = abs($row['sort']); ?>
                                <select class="input-small" name="fldSort" id="fldSort">
                                    <option value="0"<?php if ($row['sort'] === '0') { echo 'selected'; } ?>>none</option>
                                    <option value="desc"<?php if ($row['sort'] < 0) { echo 'selected'; } ?>>desc</option>
                                    <option value="asc"<?php if ($row['sort'] > 0) { echo 'selected'; } ?>>asc</option>
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
                            </form>
                        </tr>
                    <?php
                }
                mysql_free_result($res_flds);
            }
        ?>
                        <tr class="info">
                            <td colspan="6">new field</td>
                        </tr>
    </tbody>
</table>