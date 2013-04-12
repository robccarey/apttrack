<?php
    $NAV_TAB = 'R';
    include_once('header.php');
    
    if (isset($_GET['mode'])) {
        if ($_GET['mode'] === 'adv') {
            $advanced = true;
        } else {
            $advanced = false;
        }
    } else {
        $advanced = false;
    }
?>

<div class="container-fluid">
    <div class="page-header visible-phone">
            <h1>Search</h1> 
        </div>
    <div class="row-fluid">
        <div class="span3">
            <div class="sidebar-nav-fixed">
                <div class="well" style="max-width: 340px; padding: 8px 0;">
                    <ul class="nav nav-list">
                        <li class="nav-header">Quick Links</li>
                        <li><a href="projects.php"><i class="icon-folder-open"></i> Projects</a></li>
                        <li><a href="reports.php"><i class="icon-print"></i> Reports</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="span9">       
            <div class="page-header hidden-phone">
                <h1>Search</h1>
            </div>
            <?php
                if ($advanced) {
                    // show advanced search
                    ?>
                        <form class="form-inline">
                            
                        </form>
                    <?php
                        
                } else {
                    // show basic search
                    ?>
                        <form class="form-inline">
                            <input type="text" name="search" id="search" value="" placeholder="Search" onkeyup="mainSearch()">
                            <button type="submit" class="btn btn-primary"><i class="icon-search"></i> Search</button>
                            <a href="search.php?mode=adv&search=<?php echo $_GET['search']; ?>">Advanced search</a>
                        </form>
                    <?php
                }
            ?>
            <div id="searchResults">
                <?php if (isset($_GET['search'])) {
                    $query = mysql_escape_string($_GET['search']);
                    include('searchResults.php'); 
                } else {
                    echo '<p class="muted">Enter a search term above.</p>';
                } ?>
            </div>    
            <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> top</a>
        </div> <!-- /span -->
    </div> <!-- /row -->
</div> <!-- /container -->
<?php include_once('footer.php'); ?>