<?php
    // TODO: project home page design
?>

<?php
    include_once('header.php');  
?>

<div class="container">
    <h3>Projects</h3>
</div>
                
<script>
    $( "#newProject" ).click(function() {
        createNewProject();
    });
</script>
   
<div class="container">
    <div class="row">
        <div class="span3">
            <p>Some stuff goes in here that will appear either on the left of
                the page, or at the top if viewed on a device with a smaller viewport.</p>
        </div>
        <div class="span9">
            <div class="btn-group">
                <a class="btn" href="#" id="newProject" data-role="button" onclick="createNewProject()"><i class="icon-plus"></i> New</a>
                <a class="btn" href="#" data-role="button"><i class="icon-file"></i> Copy</a>
                <a class="btn" href="#" data-role="button"><i class="icon-search"></i> Search</a>
            </div>

                <?php

                    $rl = new ReportList(2, $CURRENT_USER->id);
                    echo '                        <h4>'.$rl->list_name.'</h4>';
                    echo '<ul class="nav nav-tabs nav-stacked">';
                    echo $rl->list_content;
                    echo '</ul>';
                ?> 
        </div>
    </div>    
</div>
    

 


        </div> <!-- close page -->
 <?php include_once('footer.php'); ?>

