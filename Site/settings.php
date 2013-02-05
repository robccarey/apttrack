<?php
    // TODO: settings screen design
?>

<?php
    $PAGE_TITLE = 'aptTrack | Reports';
    $LOGGED_IN = true;
    include_once('header.php');
?>
        
            <div data-role="content">
                
                <h1>Settings</h1>
                
                <div data-role="collapsible-set">
                    <div data-role="collapsible" data-content-theme="c">
                        <h3>Notifications</h3>
                        <p>Every now and then aptTrack will send you email updates to alert you to changes that have been made. Control what you get sent below.</p>
                        <table border="0" width="95%">
                            <tr>
                                <td width="60%" align="right">When someone adds me to a project's interest list.</td>
                                <td width="40%" align="center">
                                    <select name="flip-1" id="flip-1" data-role="slider">
                                        <option value="off">Off</option>
                                        <option value="on">On</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td width="60%" align="right">When someone assigns me as manager of a task.</td>
                                <td width="40%" align="center">
                                    <select name="flip-1" id="flip-1" data-role="slider">
                                        <option value="off">Off</option>
                                        <option value="on">On</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td width="60%" align="right">When a project I am associated with is approaching it's deadline.</td>
                                <td width="40%" align="center">
                                    <select name="flip-1" id="flip-1" data-role="slider">
                                        <option value="off">Off</option>
                                        <option value="on">On</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td width="60%" align="right">When a project I am associated with is overdue.</td>
                                <td width="40%" align="center">
                                    <select name="flip-1" id="flip-1" data-role="slider">
                                        <option value="off">Off</option>
                                        <option value="on">On</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        
                    </div>
                    <div data-role="collapsible" data-content-theme="c">
                        <h3>Home Page Content</h3>
                        <p>Use the following controls to select the content you see displayed when you first login.</p>
                        
                    </div>
                    <div data-role="collapsible" data-content-theme="c">
                        <h3>Projects Dashboard</h3>
                        <p>Not everyone prioritises their work in the same way so aptTrack shows you what you want to see. Control what reports are represented on your project dashboard below.</p>
                    </div>
                </div>
                
                <a href="#" data-role="button">Save Changes</a>
            </div> <!-- close content -->
            <div data-role="footer" data-id="navFooter" data-position="fixed">
                <div data-role="navbar">
                    <ul>
                        <li><a href="home.php">Home</a></li>
                        <li><a href="projects.php">Projects</a></li>
                        <li><a href="reports.php">Reports</a></li>
                        <li><a href="people.php">People</a></li>
                    </ul>
                </div> <!-- close footer -->
            </div>
        </div> <!-- close page -->
 <?php include_once('footer.php'); ?>

