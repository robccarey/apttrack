<?php
    $NAV_TAB = 'R';
    include_once('header.php');
    
    if (((isset($_GET['mode']))&&($_GET['mode'] === 'adv')) || (isset($_GET['tag'])) || (isset($_GET['type'])))  {
        $advanced = true;
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
                    if (isset($_GET['type'])) {
                        $type = $_GET['type'];
                    } else {
                        $type = 'a';
                    }
                    ?>
                        <form class="form-horizontal">
                            
                            <div class="control-group">
                                <label class="control-label" for="search">Term</label>
                                <div class="controls">
                                    <input type="text" name="search" id="search" value="<?php echo $_GET['search']; ?>" placeholder="Search" onkeyup="mainSearch()">
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label" for="type">Type</label>
                                <div class="controls">
                                    <select name="type" id="type" onchange="mainSearch()">
                                        <option value="a" <?php if ($type === 'a') { echo 'selected'; } ?>>All</option>
                                        <option value="p" <?php if ($type === 'p') { echo 'selected'; } ?>>Projects</option>
                                        <option value="t" <?php if ($type === 't') { echo 'selected'; } ?>>Tasks</option>
                                        <option value="d" <?php if ($type === 'd') { echo 'selected'; } ?>>Deliverables</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label" for="tag">Tag</label>
                                <div class="controls">
                                    <input type="text" name="tag" id="tag" value="<?php echo $_GET['tag']; ?>" placeholder="Tag" onkeyup="mainSearch()">
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <a href="search.php?search=<?php echo $_GET['search']; ?>">Basic search</a>
                                <button type="submit" class="btn btn-primary"><i class="icon-search"></i> Search</button>
                            </div>
                        </form>
                    <?php
                        
                } else {
                    // show basic search
                    ?><input type="hidden" name="type" id="type" value="a">
                            <input type="hidden" name="tag" id="tag" value="">
                        <form class="form-inline">
                            
                            <input type="text" name="search" id="search" value="<?php echo $_GET['search']; ?>" placeholder="Search" onkeyup="mainSearch()">
                            <button type="submit" class="btn btn-primary"><i class="icon-search"></i> Search</button>
                            <a href="search.php?mode=adv&search=<?php echo $_GET['search']; ?>">Advanced search</a>
                        </form>
                    <?php
                }
            ?>
            <div id="searchResults">
                <?php
                    
                    $search = mysql_escape_string($_GET['search']);
                    if (isset($_GET['type'])) {
                        $type = mysql_escape_string($_GET['type']);
                    } else { $type = 'a';}
                    if (isset($_GET['tag'])) {
                        $tag = mysql_escape_String($_GET['tag']);
                    } else { $tag = '';}
                    include('searchResults.php');
                ?>
            </div>    
            <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> top</a>
        </div> <!-- /span -->
    </div> <!-- /row -->
</div> <!-- /container -->
<?php include_once('footer.php'); ?>