<?php

    $qry_search = "SELECT type, id, name, description ";
    if ('x'.$tag !== 'x') { $qry_search .= ", tags"; }
    
    $qry_search .= " FROM ( ";
    
    $first = true;
    if (($type === 'a') || ($type === 'p')) {
        $first = false;
        $qry_search .= "SELECT 'project' as type, project.id as id, project.name as name, project.description as description";
        if ('x'.$tag !== 'x') {
            $qry_search .= ", GROUP_CONCAT(tags.tag SEPARATOR ', ') as tags";
        }
        $qry_search .= " FROM project";
        
        if ('x'.$tag !== 'x') {
            $qry_search .= ", tag_project, tags WHERE tags.id=tag_project.tag AND tag_project.project=project.id AND tags.tag LIKE '%".$tag."%'  GROUP BY project.id";
        }
    }   
    
    if (($type !== 'p')) {
        if (!$first) { $qry_search .= " UNION "; }
        
        $qry_search .= "SELECT job_type.name as type, job.id as id, job.name as name, job.description as description";
        if ('x'.$tag !== 'x') {
            $qry_search .= ", GROUP_CONCAT(tags.tag SEPARATOR ', ') as tags";
        }
        $qry_search .= " FROM job, job_type";
        if ('x'.$tag !== 'x') {
            $qry_search .= ", tag_job, tags";
        }
        $qry_search .= " WHERE job.type=job_type.id ";
        ;
        if ('x'.$tag !== 'x') {
            $qry_search .= "AND tags.id=tag_job.tag AND tag_job.job=job.id AND tags.tag LIKE '%".$tag."%'";
        }
        
        
        
        if ($type === 't') {
            $qry_search .= " AND job.type=1 ";
        }
        if ($type === 'd') {
            $qry_search .= " AND job.type=2 ";
        }
        if ('x'.$tag !== 'x') {
            $qry_search .= " GROUP BY job.id ";
        }
    }   
    $qry_search .= ") as tmp ";

    $qry_search .= "WHERE name LIKE '%".$search."%' OR description LIKE '%".$search."%'
        ORDER BY CASE WHEN name LIKE '".$search."' THEN 0
                      WHEN description LIKE '".$search."' THEN 1
                      WHEN name LIKE '".$search." %' THEN 2
                      WHEN name LIKE '% ".$search." %' THEN 3
                      WHEN name LIKE '".$search."%' THEN 4
                      WHEN name LIKE '% ".$search."%' THEN 5
                      WHEN name LIKE '%".$search."%' THEN 6
                      WHEN description LIKE '%".$search."%' THEN 7
                      ELSE 8
                  END, name;"; 
    
//    SELECT max(id) id, name
//  FROM cards
// WHERE name like '%John%'
// GROUP BY name
// ORDER BY CASE WHEN name like 'John %' THEN 0
//               WHEN name like 'John%' THEN 1
//               WHEN name like '% John%' THEN 2
//               ELSE 3
//          END, name
    
    
    
    
    $res_search = mysql_query($qry_search);
    //echo '<p class="lead"><strong>Query: </strong> '.$qry_search.'</p>';  // uncomment for test/debug
    if ($res_search) {
        ?>
        <table class="table table-hover table-condensed table-stroke">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    
                </tr>
            </thead>
        <?
        if (mysql_num_rows($res_search) > 0) {
            while ($row = mysql_fetch_assoc($res_search)) {
                ?>
                    <tr>
                        <?php
                        //echo $row['type'];
                        switch ($row['type']) {
                            case 'project':
                                $icon = 'icon-folder-open';
                                $link = 'project.php?id='.$row['id'];
                                break;

                            case 'task':
                                $icon = 'icon-tasks';
                                $link = 'job.php?id='.$row['id'];
                                break;

                            case 'deliverable':
                                $icon = 'icon-folder-close';
                                $link = 'job.php?id='.$row['id'];
                                break;
                        }
                        ?>
                        <td><i class="<?php echo $icon; ?>"></i> <a href="<?php echo $link; ?>"><?php echo $row['name']; ?></a></td>
                        <td><?php echo $row['description']; ?></td>
                        <?php if ('x'.$tag !== 'x') { echo '<td>'.$row['tags'].'</td>'; } ?>
                    </tr>
                <?php
            }
        } else {
            ?>
                    <tr><td colspan="2"><p class="muted">No projects, tasks or deliverables match your search.</p></td></tr>
            <?php
        }
        ?>  
            </tbody>
        </table>
        <?php
        mysql_free_result($res_search);
    } else {
        echo 'query error
            ';
        echo $qry_search;
    }
?>
