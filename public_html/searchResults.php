<?php

    $qry_search = "SELECT type, id, name, description FROM
        (   SELECT 'project' as type, project.id as id, project.name as name, project.description as description FROM project UNION
            SELECT job_type.name as type, job.id as id, job.name as name, job.description as description  FROM job, job_type WHERE job.type=job_type.id
        ORDER BY id) as tmp 
        
        WHERE name LIKE '%".$query."%' OR description LIKE '%".$query."%'
        ORDER BY CASE WHEN name LIKE '".$query."' THEN 0
                      WHEN description LIKE '".$query."' THEN 1
                      WHEN name LIKE '".$query." %' THEN 2
                      WHEN name LIKE '% ".$query." %' THEN 3
                      WHEN name LIKE '".$query."%' THEN 4
                      WHEN name LIKE '% ".$query."%' THEN 5
                      WHEN name LIKE '%".$query."%' THEN 6
                      WHEN description LIKE '%".$query."%' THEN 7
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
