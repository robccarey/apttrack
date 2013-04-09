<?php
    // TODO: report home page design
?>

<?php
    $NAV_TAB = 'R';
    include_once('header.php');
?>
        
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <div class="sidebar-nav-fixed">
                <div class="well" style="max-width: 340px; padding: 8px 0;">
                    <ul class="nav nav-list">
                        <li class="nav-header">Actions</li>
                        <li><a onclick="alert('todo: create/edit reprots');"><i class="icon-plus"></i> New Report</a></li>
                        <li><a href="#"><i class="icon-file"></i> Copy</a></li>
                        <li><a href="#"><i class="icon-search"></i> Search</a></li>
                    
                        <li class="nav-header">Jump To...</li>
                        <li><a href="#poprep">Popular Reports</a></li>
                        <li><a href="#">Something else.</a></li>
                        <li><a href="#">Bottom of page.</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="span9">       
            <div id="poprep">
                <div class="page-header">
                    <h2>Popular Reports</h2>
                </div>
                <ul class="nav nav-tabs nav-stacked">
                <?php
                    $qry_pop_rep = "SELECT id, name, gen_count as counter FROM report ORDER BY gen_count DESC;";
                    $res_pop_rep = mysql_query($qry_pop_rep);
                    if ($res_pop_rep) {
                        while ($row = mysql_fetch_assoc($res_pop_rep)) {
                            echo '<li>';
                            echo '<a href="report.php?id='.$row['id'].'">';
                            echo '<h4 style="color: #000000;">'.$row['name'].'</h4>';
                            echo '<p class="muted"><strong>Generated:</strong> '.$row['counter'].'</p>';
                            echo '</a>';
                            echo '</li>';
                        }
                        mysql_free_result($res_pop_rep);
                    }
                ?>
                </ul>
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> top</a>
            </div>
                
                <div data-role="collapsible-set">
                    <div data-role="collapsible" data-content-theme="c">
                        <h3>My Reports</h3>
                        <ul data-role="listview">
                            <li><a href="report.php?id=1">Overdue Tasks</a></li>
                            <li><a href="#">Report 2</a></li>
                            <li><a href="#">Report 3</a></li>
                            <li><a href="#">Report 4</a></li>
                            <li><a href="#">Report 5</a></li>
                            <li><a href="#">Report 6</a></li>
                        </ul>
                    </div>
                    <div data-role="collapsible" data-content-theme="c">
                        <h3>Popular Reports</h3>
                        <ul data-role="listview">
                            <li><a href="#">Report 1</a></li>
                            <li><a href="#">Report 2</a></li>
                            <li><a href="#">Report 3</a></li>
                            <li><a href="#">Report 4</a></li>
                            <li><a href="#">Report 5</a></li>
                            <li><a href="#">Report 6</a></li>
                        </ul>
                    </div>
                </div>    
    </div> <!-- close container -->
 <?php include_once('footer.php'); ?>

