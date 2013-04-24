<?php
    $TITLE = 'aptTrack - help';
    include('header.php');
    if ($valid_session) {
        ?>

<div class="container-fluid">
    <div class="page-header visible-phone">
        <h1>Help and Documentation<small> Get started with aptTrack</small></h1>
    </div>
    <div class="row-fluid">
        <div class="span3">
            <div class="sidebar-nav-fixed">
                <div class="well" style="max-width: 340px; padding: 8px;">
                    <h3>Contents</h3>
                    <ul class="nav nav-list">
                        <li><a href="#intro">Introduction</a></li>
                        
                        <li class="nav-header">General</li>
                        <li><a href="#oview">Overview</a></li>
                        <li><a href="#proj">Projects</a></li>
                        <li><a href="#tandd">Tasks and Deliverables</a></li>
                        <li><a href="#reports">Reports</a></li>
                        <li><a href="#search">Search</a></li>
                        <li><a href="#account">User Accounts</a></li>
                        
                        <li class="nav-header">In Depth</li>
                        <li><a href="#status">Statuses</a></li>
                        <li><a href="#visib">Visibility</a></li>
                        <li><a href="#health">Health</a></li>
                        <li><a href="#prior">Priority</a></li>
                        <li><a href="#comments">Comments</a></li>
                        <li><a href="#persons">Personnel</a></li>
                        <li><a href="#tags">Tags</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="span9">
            <div class="page-header hidden-phone">
                <h1>Help and Documentation</h1>
            </div>
            <section id="intro">
                <p class="lead"><strong>aptTrack</strong> provides you with the
                    unique ability to track all of your various responsibilities
                    in a simple yet adaptable manner. By forcing you to divide
                    your tasks into distinct projects, <strong>aptTrack</strong>
                    can help you stay on top of what you need to do.</p>
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
            </section>
            
            <h1>General<small> Getting started with aptTrack</small></h1>
            <p>Whether you're new to <strong>aptTrack</strong> or have been using
                it for a while, it can be useful to look over the following
                guide to ensure that you get the most from your experience.</p>
            
            <section id="oview">
                <div class="page-header">
                    <h2>Overview<small> General terms explained</small></h2>
                </div>
                <p><strong>aptTrack</strong> may refer to things slightly differently than you would normally.
                Use the following definitions to ensure we're on the same page.</p>
                
                <dl class="dl-horizontal">
                    <dt>Project</dt>
                    <dd>A project is a high level target or goal. It often takes
                    place over a longer time-frame than the tasks it contains
                    and may also involve a collection of deliverables that need
                    to be considered. <small><a href="#proj">more info</a></small></dd>
                    
                    <dt>Task</dt>
                    <dd>A task is a small chunk of work. When collaborating on a
                    project, a team leader may assign a task to a team member,
                    or if working alone a task may represent a component of a
                    larger objective. <small><a href="#tandd">more info</a></small></dd>
                
                    <dt>Deliverable</dt>
                    <dd>A deliverable is a form of task that is often the way that
                    one or more tasks' success is measured. <small><a href="#tandd">more info</a></small></dd>
                </dl>
                
                <h3>Example</h3>
                <p>Consider planning a holiday abroad and think about the
                    different aspects that you need to consider:</p>
                <ul>
                    <li>Where are you going to go? Europe? North America?
                        Asia?</li>
                    <li>How are you going to get there? Are you going to fly?
                        Drive your car? Take the bus? Use a ferry?</li>
                    <li>Where will you stay when you get there? In a caravan?
                        In a hotel? In a hostel?</li>
                    <li>What will do you while your there? Ski? Sunbathe?
                        Visit museums?</li>
                </ul>
                <p>You get the picture. There's a lot to consider. This is where
                    tasks come in. They can help you to ensure that you consider
                    all the necessary aspects of planning your trip.</p>
                <p>This is by no means everything, though, as you also need to
                    have airline tickets, passports, driving licences, ready to
                    take with you. These are the deliverables.</p>
                <p>Using <strong>aptTrack</strong> to help you remember all this is one way of
                    ensuring your trip is successful.</p>
                
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
            </section> <!-- /general -->
            
            <section id="proj">
                <div class="page-header">
                    <h2>Projects<small></small></h2>
                </div>
                <p>A great place to get started with <strong>aptTrack</strong> is
                    with projects, the home for all tasks and deliverables you may
                    create.</p>
                <p><strong>aptTrack</strong> is designed to give you the freedom to track your
                    work as you see fit but some understanding of how features
                    have been designed will give you valuable insight in how you
                    can maximise your experience.</p>
                
                <h3>Creating a Project</h3>
                <p>Your first step in getting started with <strong>aptTrack</strong> is probably
                    going to be creating your first project. Do this by clicking
                    <a href="projects.php" target="_blank">here</a> <small>(opens in a new tab)</small> and clicking on the 'New
                    Project' option in the navigation panel.</p>
                
                <p>You will see the following list of options that allow you to configure
                    various aspects of your project. For a more in depth explanation, either
                    follow the link on the navigation panel of this page, or use the in-line links below.</p>
                
                <dl class="dl-horizontal">
                    <dt>Title</dt>
                    <dd>This is the name of your project and will show up in
                        search results and in reports.</dd>
                    
                    <dt>Description</dt>
                    <dd>Add more in depth information about your project and it's
                        goals</dd>
                    
                    <dt>Owner</dt>
                    <dd>Defaults to you. Who is in charge of the project?</dd>
                    
                    <dt>Start Date</dt>
                    <dd>Defaults to today. The expected start date of your project.</dd>
                    
                    <dt>End Date</dt>
                    <dd>Default is empty. The deadline for your project.</dd>
                    
                    <dt>Status</dt>
                    <dd>Where is your project in its lifespan? <small><a href="#status">more info</a></small></dd>
                    
                    <dt>Visibility</dt>
                    <dd>Who can see your project? <small><a href="#visib">more info</a></small></dd>
                    
                    <dt>Health</dt>
                    <dd>How is progress on your project? <small><a href="#health">more info</a></small></dd>
                    
                    <dt>Priority</dt>
                    <dd>How urgent is your project? <small><a href="#prior">more info</a></small></dd>
                    
                </dl>
                
                <p>When you are happy with the initial configuration of your 
                    project, click 'Save' and 'Close' to close the project
                    editor.</p>
                
                
                
                <h3>Using Projects</h3>
                <p>With your first project created and configured, you should be
                    able to see some of the details on the page in front of you.</p>
                
                <p><strong>aptTrack</strong> has been designed to be intuitive to use but the following
                    areas may be of interest to new users.</p>
                
                <dl class="dl-horizontal">
                    <dt>Information</dt>
                    <dd>View all project information using the link on the navigation panel.</dd>
                    
                    <dt>Comments</dt>
                    <dd>Leave a note for yourself or other collaborators. <small><a href="#comments">more info</a></small></dd>
                    
                    <dt>Tasks and Deliverables</dt>
                    <dd>Add tasks or deliverables to your project. <small><a href="#tandd">more info</a></small></dd>
                    
                    <dt>Tags</dt>
                    <dd>Categorise your project dynamically. <small><a href="#tags">more info</a></small></dd>
                    
                    <dt>Personnel</dt>
                    <dd>Control who you work with on your project. <small><a href="#persons">more info</a></small></dd>
                </dl>
                
                
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
            </section> <!-- /projects -->
            
            <section id="tandd">
                <div class="page-header">
                    <h2>Tasks and Deliverables<small></small></h2>
                </div>
                <p>By this point you should have configured your first project and 
                    be ready to start adding tasks and deliverables. These will form
                    the bulk of your activities on <strong>aptTrack</strong>.</p>
                
                <h3>Creating a Task or Deliverable</h3>
                <p>To get started with tasks and deliverables, go to the
                    <a href="projects.php" target="_blank">projects homepage</a>
                    <small>(opens in a new tab)</small> and select the project
                    you want to add a task or deliverable to.</p>
                <p>Within the project view, you should see a list of existing tasks
                    and deliverables - this will be empty if you have chosen a new project.
                    Click the 'Add' button corresponding to the item you wish to add or use
                    the links on the navigation panel.</p>
                <p>You should be presented with a edit view similar to that which you used
                    to add a project earlier.</p>
                <p>Many of the fields correspond to those associated with projects but here's
                    an overview just in case:</p>
                <dl class="dl-horizontal">
                    <dt>Title</dt>
                    <dd>This is the name of your task/deliverable and will show
                        up in search results and reports.</dd>
                    
                    <dt>Description</dt>
                    <dd>Use this field to add additional information about the specifics
                        of your task/deliverable.</dd>
                    
                    <dt>Owner</dt>
                    <dd>Defaults to creator. Who's in charge of the task/deliverable?</dd>
                    
                    <dt>Start Date</dt>
                    <dd>Defaults to today. When is the task/deliverable scheduled to begin?</dd>
                    
                    <dt>End Date</dt>
                    <dd>Default is empty. When is the task/deliverable's deadline?</dd>
                    
                    <dt>Status</dt>
                    <dd>Where is your task/deliverable in its lifespan? <small><a href="#status">more info</a></small></dd>
                    
                    <dt>Health</dt>
                    <dd>How is progress on your task/deliverable? <small><a href="#health">more info</a></small></dd>
                    
                    <dt>Priority</dt>
                    <dd>How urgent is your task/deliverable? <small><a href="#prior">more info</a></small></dd>
                </dl>
                <blockquote><span class="label label-info">Note:</span> Owner will only appear where
                the project visibility is not set to 'private'. In this case, you will automatically
                become the owner of any tasks or deliverables that you add.</blockquote>
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
            </section> <!-- /tandd -->
            
            
            
            <section id="reports">
                <div class="page-header">
                    <h2>Reports<small> dynamic reports tailored to you</small></h2>
                </div>
                <p>Custom report generation is key in using <strong>aptTrack</strong> to help you
                    manage your workload. Reporting on any of Projects, Tasks,
                    Deliverables and Users will help you to decide what
                    activities you should prioritise to help meet your deadlines.
                    Reports are also handy when producing lists of what you've
                    achieved for superiors.</p>
                
                <h3>Basics</h3>
                <p>To get started with reports, click <a href="reports.php">here</a>
                    and click 'New Report' in the navigation panel. You'll see a
                    dialog which allows you to select what you'd like your report
                    to be based on. For the purpose of this exercise, choose
                    'Projects' and click 'Create Report'.</p>
                
                <p>The next thing you need to do is provide some static text for
                    your report. These are divided into two types; un-generated
                    and generated.</p>
                
                <p>Un-generated values apply to how you will refer to your report
                    when you are modifying it, prior to populating it with about
                    projects. Generated values will appear in the report itself,
                    for example on the printout should you decide to print your
                    report.</p>
                
                <dl class="dl-horizontal">
                    <dt>Name</dt>
                    <dd>This is the name of your report.</dd>
                    
                    <dt>Instructions</dt>
                    <dd>This explains to other users who may want to use your
                        report what they should do to ensure that they see what
                        they need to.</dd>
                    
                    <dt>Title</dt>
                    <dd>This will be the title of your report once generated.</dd>
                    
                    <dt>Description</dt>
                    <dd>This will also appear on your generated report and can
                        be used to describe what is represented by the report
                        content.</dd>
                </dl>
                <p>When you have entered these values click 'Save' and then,
                    when ready, click 'Close' to move to the next step.</p>
                
                <h3>Selecting Fields</h3>
                <p>You should now see the name and instructions you entered
                    previously, followed by a number of headings across your
                    screen below which is a selector for choosing new fields.
                    Use this selector to choose the 'projName' field and add it
                    to the report using the corresponding button.</p>
                
                <p>This field should now appear above. Note that by default the
                    field is added with a blank label, no sorting, no criteria
                    and with its visibility set to hidden.</p>
                
                <p>Make the field visible (by clicking the button in the
                    corresponding column) and choose 'Generate Report' from the
                    navigation panel</p>
                
                <p>Try adding a few more fields to see how your report is affected.</p>
                
                <blockquote><span class="label label-info">Hint:</span> Use two
                    windows when designing a report; one to design your report
                    and the other to generate it and see your changes.</blockquote>
                
                <h3>Labels</h3>
                <p>Custom labels give you the freedom to name each column in
                    your report as you want it, leaving blank if necessary.</p>
                
                <h3>Visibility</h3>
                <p>As mentioned above, you have the option to toggle the
                    visibility of fields within your report. This allows the
                    inclusion of certain fields where you want to filter the
                    content of the report based on this field, without
                    displaying the specific values within the report.</p>
                
                <h3>Positioning</h3>
                <p>When a new field is added, by default it's visibility is set
                    to hidden and the field will appear towards the top of the
                    field list in customisation table. Once you select to make
                    a field visible, it will automatically move to the bottom of
                    the table as the last column in the generated report.</p>
                
                <p>To customise the position of this field within the generated
                    report, use the arrows on the left to move a field up or
                    down the list.</p>
                
                <p>Note that the position of hidden fields is not modifiable.</p>
                
                <h3>Sorting</h3>
                <p>To add sorting to your report, choose from the drop-down list
                    for the field that you want to sort whether you want to sort
                    it in ascending or descending order.</p>
                
                <p>If you are sorting multiple fields, you may want to specify
                    which field should be sorted first. To do this, select the
                    'edit' link from next to the Sort header to show a dialog.</p>
                
                <p>Using this dialog, you will be able to specify the sort
                    priority in the same way that you positioned fields in your
                    report.</p>
                
                <h3>Criteria</h3>
                <p>To limit the number of rows that are displayed in your report,
                    you can filter the data in various ways, depending on the
                    aim of your report.</p>
                
                <p><strong>aptTrack</strong> allows you to choose either specific values for
                    your reports or dynamic values which may be different for
                    each user or instance that the report is generated.</p>
                
                <h4>Basics of Criteria</h4>
                <p>To get started with criteria, choose the 'edit criteria'
                    link for a field that you wish to apply a filter to.
                    This will display a dialog that you can use to make changes.</p>
                
                <p>Expand the drop-down list to show the range of criteria
                    functions that you can choose from. Changing the selected
                    function will result in various inputs being displayed or
                    hidden to help you define the criteria.</p>
                
                <dl class="dl-horizontal" id="descList">
                    <dt>no criteria</dt>
                    <dd>Applies no filtering to the selected field.</dd>
                    
                    <dt>equal to</dt>
                    <dd>Filters out rows that are not equal to the specified value.</dd>
                    
                    <dt>not equal to</dt>
                    <dd>Filters out rows that are equal to the specified value.</dd>
                    
                    <dt>greater than</dt>
                    <dd>Filters out rows that are less than or equal to the specified value.</dd>
                    
                    <dt>less than</dt>
                    <dd>Filters out rows that are greater than or equal to the specified value.</dd>
                    
                    <dt>greater than or equal to</dt>
                    <dd>Filters out rows that are less than the specified value.</dd>
                    
                    <dt>less than or equal to</dt>
                    <dd>Filters out rows that are greater than the specified value.</dd>
                    
                    <dt>between</dt>
                    <dd>Filters out rows that have values outside the specified range.</dd>
                    
                    <dt>not between</dt>
                    <dd>Filters out rows that have values within the specified range.</dd>
                </dl>
                
                <h4>Criteria and Tags</h4>
                <p>As mentioned above, tags provide a powerful and flexible way
                    to categorise your projects, tasks and deliverables but they
                    aren't just used when it comes to searching.</p>
                <p>When creating a report, you can use tags to specify which
                    records you would like to see.</p>
                <p>To filter on tags, first select either the 'projTags' or 'jobTags'
                    field and then click the 'edit criteria' link.</p>
                <p>In the dialog, select the 'equals' function and in the value
                    box, enter a comma separated list of tags that you wish to
                    filter on.</p>
                <p>The items that get through this filter will be tagged with all
                    tags specified in the value input.</p>
                
                <h4>Dynamic Criteria</h4>
                <p>In some circumstances it is sufficient to just use
                    combinations of static criteria to filter your reports
                    but sometimes that just doesn't provide the flexibility
                    that you may need.</p>
                
                <p>The following inputs can be used to help you make reports
                    that are reusable and efficient.</p>
                
                <table class="table table-condensed table-stroke">
                    <thead>
                        <tr>
                            <th>Input</th>
                            <th>Description</th>
                            <th>Fields to use it with</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>||me.id||</td>
                            <td>Returns the ID of the currently logged in user.</td>
                            <td>projOwnerID, projUpdaterID, projCreatorID, jobOwnerID, jobUpdaterID, jobCreatorID</td>
                        </tr>
                        <tr>
                            <td>||now||</td>
                            <td>Returns the current date and time.</td>
                            <td>projStartNum, projEndNum, projCreatedNum, projUpdatedNum, jobStartNum, jobEndNum, jobCreatedNum, jobUpdatedNum</td>
                        </tr>
                        <tr>
                            <td>||days(n)||</td>
                            <td>Returns the current date and time plus n days.</td>
                            <td>projStartNum, projEndNum, projCreatedNum, projUpdatedNum, jobStartNum, jobEndNum, jobCreatedNum, jobUpdatedNum</td>
                        </tr>
                        <tr>
                            <td>||weeks(n)||</td>
                            <td>Returns the current date and time, plus n weeks.</td>
                            <td>projStartNum, projEndNum, projCreatedNum, projUpdatedNum, jobStartNum, jobEndNum, jobCreatedNum, jobUpdatedNum</td>
                        </tr>
                    </tbody>
                </table>
                
                <blockquote><span class="label label-info">Note:</span> Where
                    used above, n can either be a positive or negative value.</blockquote>
                
                <p>Some fields have references that are job*. <strong>aptTrack</strong> stores
                    both tasks and deliverables in a similar fashion so uses
                    the same fields when reporting on either.</p>
                
                <h3>PDF Reports</h3>
                <p>In addition to on-screen reports, you can also generate
                    your reports as PDF documents.</p>
                
                <p>To do this, generate your report on-screen and choose the
                    'Mail Report' option from the navigation panel. Confirm
                    your intentions at the prompt and check your email inbox:
                    your report will be attached to an email.</p>
                
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
            </section>
            
            <section id="search">
                <div class="page-header">
                    <h2>Search</h2>
                    <p class="muted">Help using search to find what you need.</p>
                </div>
                <p>todo</p>
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
            </section>
            
             <section id="account">
                <div class="page-header">
                    <h2>User Account<small> passwords and other account matters</small></h2>
                </div>
                
                
                <h3>Personal Details</h3>
                <p>Keep your details up-to-date to ensure that your name appears
                    correctly within projects, tasks and deliverables, and
                any emails intended for you make their way into your inbox.</p>
                
                <p>Update your details using the Profile link in the navigation
                    bar, or click <a href="profile.php">here</a>.</p>
                
                <h3>Passwords</h3>
                <p><strong>aptTrack</strong> does not enforce automatic password expiry nor does
                    it restrict what you choose to use as your password. It does
                    go without saying though that you should update this
                    regularly to prevent unauthorised access to your account.</p>
                
                <p>Use the Profile link in the navigation bar to change your
                    password, or click <a href="profile.php">here</a>.</p>
                
                <p>If you ever happen to forget your password, use the forgotten
                    password link on the login page to reset it. A new, randomly
                    generated password will then be sent to you which can be
                    used to sign in as usual. Of course, once you have signed
                    in, it is recommended that you update this to something more
                    memorable (see above).</p>
                
                <h3>Authentication</h3>
                <p>To make it more convenient for you to use <strong>aptTrack</strong> when it
                    suits you, simultaneous persistent logins are supported.
                    This means that when you log in from your desktop computer,
                    you can close the browser and come back to <strong>aptTrack</strong> later to
                    find that you are still logged in. Logging in from your
                    mobile phone and laptop will give the same result.
                    Essentially you can log in on as many devices that you own
                    and you will stay logged in between visits.</p>
                
                <p>When you click the logout button on the navigation bar,
                    this is set to automatically log you out of all the devices
                    that you have logged in from, giving you a means to secure
                    you account if you think it may have been compromised.</p>
                
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
            </section> <!-- /accounts -->
            
            
                <h1 style="padding-top: 30px;">In Depth<small> More information, just in case.</small></h1>
            <section id="status">
                <div class="page-header">
                    <h2>Statuses<small> track your activities</small></h2>
                </div>
                <p>Applicable to <a href="#proj">projects</a> as well as
                    <a href="#tandd">tasks</a> and <a href="#tandd">deliverables</a>,
                    the status field allows you to track the progress of an
                    activity.</p>
                <p>A status can be selected from the following four options:</p>
                <dl class="dl-horizontal">
                    <dt>Pending</dt>
                    <dd>Shows that the project has not begun yet and is due to
                        start in the future.</dd>
                    
                    <dt>Current</dt>
                    <dd>The project is currently in progress and being worked on.</dd>
                    
                    <dt>Complete</dt>
                    <dd>The project is complete and no longer being worked on.</dd>
                    
                    <dt>Closed</dt>
                    <dd>The project did not complete but is no longer valid.</dd>
                </dl>
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
            </section>
            
            <section id="visib">
                <div class="page-header">
                    <h2>Visibility<small>secure your projects from prying eyes</small></h2>
                </div>
                <p>Every time you create a new project you have the option as to
                    how it should be classified in terms of visibility. The
                    chosen classification is then inherited by tasks and
                    deliverables that belong to the project giving you the peace
                    of mind that private or confidential material will not be
                    accessible to all users.</p>
                
                <p>The following classifications give you a range of options
                    for your projects:</p>
                
                <dl class="dl-horizontal">
                    <dt>Private</dt>
                    <dd>Only you can view and modify.</dd>
                    <dt>Closed</dt>
                    <dd>Only specified users can view the project. Edit
                        privileges can be assigned as required.</dd>
                    <dt>Open</dt>
                    <dd>All user can view the project. Only specified users,
                        or owners of Tasks and Deliverables can make modifications.</dd>
                </dl>
                <blockquote><span class="label label-info">Note:</span> Users
                    who you assign ownership of a task or deliverable will
                    automatically get edit privileges for the entire project.</blockquote>
                
                <p>For help creating a project, click <a href="#proj">here</a>.</p>
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
            </section>
            
            <section id="health">
                <div class="page-header">
                    <h2>Health<small> track progress the right way</small></h2>
                </div>
                <p>The health of a project, task or deliverable refers to the
                    progress towards completion given the proximity of the
                    activity's deadline. For example, a project that is only
                    20% completed, with an approaching deadline is going to have
                    considerably lower health than a project that is 95%
                    complete with 2 months until the deadline.</p>
                
                <p>Health can be specified by one of the 3 following options:</p>
                <dl class="dl-horizontal">
                    <dt>Green</dt>
                    <dd>Proceeding as intended.</dd>
                    <dt>Amber</dt>
                    <dd>Minor setbacks experienced.</dd>
                    <dt>Red</dt>
                    <dd>Progress has been significantly delayed.</dd>
                </dl>
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
            </section>
            
            <section id="prior">
                <div class="page-header">
                    <h2>Priority<small> specify levels of urgency</small></h2>
                </div>
                <p>Projects, tasks and deliverables can be assigned a priority to
                    give an indication of how important the work is. This is
                    independent of health but they can be used in conjunction 
                    with one another to produce reports that filter and sort
                    projects (and tasks or deliverables) in a useful manner.</p>
                
                <p>Priority can be specified using one of the following
                    options:</p>
                
                <dl class="dl-horizontal">
                    <dt>High</dt>
                    <dd>A very important activity.</dd>
                    <dt>Medium</dt>
                    <dd>A mid-importance activity.</dd>
                    <dt>Low</dt>
                    <dd>A relatively unimportant activity.</dd>
                </dl>
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
            </section>
            
            <section id="comments">
                <div class="page-header">
                    <h2>Comments<small> log changes and make notes</small></h2>
                </div>
                <p>When collaborating, communication between team members is
                    vital in ensuring a successful effort.</p>
                <p>Use of comments in <strong>aptTrack</strong> is a great way to leave a short message
                    for future viewers of a item.</p>
                
                <p>Adding a comment is easy. Simply click the 'New Comment' link
                    in the navigation panel, or the 'New' button above existing
                    comments in the project, task or deliverable view.</p>
                <p>Simply enter your comment into the dialog and click 'Save' to add it.</p>
                
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
            </section>
            
            
            <section id="persons">
                <div class="page-header">
                    <h2>Personnel<small> understanding project rosters and privileges</small></h2>
                </div>
                <p>Used in combination with the Visibility classification
                    explained <a href="#visib">here</a>, <strong>aptTrack</strong> enables the
                    linking of users to projects to encourage collaboration in
                    a secure way.</p>
                
                <p>Any user that can view a project can access the list of
                    personnel associated with it, but only those who already
                    have edit privileges can make modifications to the list.</p>
                
                <p>To view the list, select the 'Personnel' option from the
                    navigation panel in the project view. When the dialog appears,
                    search through the list, or identify new users to add by
                    using the search field.</p>
                
                <h5>Some notes on Visibility and Personnel</h5>
                <p><small>
                        <ul>
                            <li>Users that are not allowed to view a project may
                                see it's name, or the name of tasks and deliverables
                                belonging to it, in search results but should
                                they visit the project, they will be presented
                                with a message informing them that they are not
                                allowed to access that content.</li>
                            <li>Users that can view a project can leave comments
                                and view all aspects but will not be able to
                                make changes to any of the information,
                                personnel or tags associated with the Project,
                                or any of its tasks and deliverables.</li>
                            <li>Users that can edit a project will be able to
                                modify all information associated with the
                                project, add personnel to the project roster and
                                create tasks and deliverables.</li>
                        </ul>
                </small></p>
                <blockquote><span class="label label-info">Note:</span> The personnel
                    link will only be visible when the project's visibility is not
                    set to 'Private'.</blockquote>
                
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
            </section>
            
            
            
            <section id="tags">
                <div class="page-header">
                    <h2>Tags<small> categorise your way</small></h2>
                </div>
                <p>To give you the freedom to choose how to categorise your projects,
                    tasks and deliverables, <strong>aptTrack</strong> uses tags.</p>
                <p>Tags are designed to be words or short phrases that you can
                    assign to various items in order to link them to others of
                    a similar type.</p>
                <p>Take the holiday example above. If a similar trip was organised
                    numerous times, searching or producing a report on 'holiday' tags
                    is a convenient way to identify related activities that may be
                    worth referencing.</p>
                <p>Existing tags will be listed towards the bottom of the project,
                    task or deliverable view (use the 'Tag' link on the navigation
                    panel to jump there quickly).</p>
                <p>If you have modification privileges, you can modify this list
                    by clicking the 'Edit' button.</p>
                <p>In the dialog, toggle tags by clicking on them, or use the search
                    to identify a new tag. Where a tag doesn't yet exist, a button
                    will appear allowing you to add the tag to the system.</p>
                <blockquote><span class="label label-info">Hint:</span> Using lots of
                    general tags is often better than using only a few specific tags.</blockquote>
                <a href="#top" class="visible-phone pull-right"><i class="icon-arrow-up"></i> Top</a>
            </section>
            
            
            <div class="form-actions">
                <ul class="nav nav-pills">
                    <li><a href="help.php">Help</a></li>
                    <li><a href="feedback.php">Feedback</a></li>
                </ul>
            </div>
                
            
        </div>
    </div>
</div>


        <?php
    }
?>
