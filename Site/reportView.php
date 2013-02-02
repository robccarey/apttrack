<?php
    // TODO: report view page design
?>

<?php
    $PAGE_TITLE = 'aptTrack | Reports';
    $LOGGED_IN = true;
    include_once('header.php');
?>
        
            <div data-role="content">
                
                <h1>#Report Title</h1>
                
                <div data-role="controlgroup" data-type="horizontal">
                    <a href="#" data-role="button">New</a>
                    <a href="#" data-role="button">Copy</a>
                    <a href="#" data-role="button">Search</a>
                </div>
                
                <table width="95%" border="0">
                    <tr>
                        <td width="40%" align="right"><b>Title</b></td>
                        <td width="60%">Overdue Tasks</td>
                    </tr>
                    <tr>
                        <td align="right"><b>Description</b></td>
                        <td>All incomplete tasks that are past their due date.</td>
                    </tr>
                    <tr>
                        <td align="right"><b>Created by</b></td>
                        <td>Robert Carey</td>
                    </tr>
                    <tr>
                        <td align="right"><b>Created</b></td>
                        <td>2 weeks ago</td>
                    </tr>
                    <tr>
                        <td align="right"><b>Times generated</b></td>
                        <td>38</td>
                    </tr>
                    <tr>
                        <td align="right"><b>Last updated</b></td>
                        <td>40 minutes ago</td>
                    </tr>
                </table>
                
                <a href="TestPDF.php" data-role="button" data-ajax="false">Download PDF</a>
                <a href="#popupDialog" data-rel="popup" data-position-to="window" data-role="button" data-transition="pop">Send Report</a>
                <div data-role="popup" id="popupDialog" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
			<div data-role="header" data-theme="a" class="ui-corner-top">
				<h1>Send Report?</h1>
			</div>
			<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
				<h3 class="ui-title">This action will generate this report and send you a PDF attachment containing the output.</h3>
				<p>The report should arrive within 2 minutes.</p>
				<a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c">Cancel</a>    
				<a href="#" data-role="button" data-inline="true" data-rel="back" data-transition="flow" data-theme="b">Send</a>  
			</div>
		</div>
                
                
            </div> <!-- close content -->
            <div data-role="footer" data-id="navFooter" data-position="fixed">
                <div data-role="navbar">
                    <ul>
                        <li><a href="home.php" data-transition="slide" data-direction="reverse">Home</a></li>
                        <li><a href="projects.php" data-transition="slide" data-direction="reverse">Projects</a></li>
                        <li><a href="reports.php" class="ui-btn-active ui-state-persist">Reports</a></li>
                        <li><a href="people.php" data-transition="slide">People</a></li>
                    </ul>
                </div> <!-- close footer -->
            </div>
        </div> <!-- close page -->
 <?php include_once('footer.php'); ?>


