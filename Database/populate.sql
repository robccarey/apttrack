# INSERT TEST DATA INTO DATABASE

# DEFAULT DATA
# TITLES
INSERT INTO titles(title) VALUES
	('Mr'),
	('Miss'),
	('Mrs'),
	('Ms'),
	('Dr');

# ACCOUNT STATUS
INSERT INTO account_status(name, description) VALUES('ACTIVE','Current user able to login and use all system features.');

# ACCOUNT TYPE
INSERT INTO account_type(name, description) VALUES
	('ADMIN','Administrative user with top-level privileges.'),
	('NORMAL','Normal user with read/write privileges.');

# VISIBILITY
INSERT INTO visibility(name, description, sort) VALUES
	('PRIVATE', 'Project is only visible to owner.', 1),
	('CLOSED', 'Project is only visible to specified users.', 2),
	('OPEN', 'Project is visible to all users.', 3);

# STATUS
INSERT INTO status(name, description, sort) VALUES
	('PENDING', 'Will begin in the future.', 1),
	('CURRENT', 'Currently in progress.', 2),
	('COMPLETE', '100% complete.', 3),
	('CLOSED', 'Closed before completion.', 4);

INSERT INTO health(name, description, sort) VALUES
        ('GREEN', 'Proceding as intended.', 1),
        ('AMBER', 'Minor setbacks experienced.', 2),
        ('RED', 'Progress has been significantly delayed.', 3);

INSERT INTO priority(name) VALUES
        ('HIGH'),
        ('MEDIUM'),
        ('LOW');

# OBJECTS
INSERT INTO object(name) VALUES
	('USER'),
	('PROJECT'),
        ('JOB');

# TEST DATA
# USERS
INSERT INTO user(title, forename, surname, email, password, account_status, account_type) VALUES
        (5, 'Administrative', 'User', 'robcarey1990@gmail.com', md5('password'), 1, 1),
	(1, 'Robert', 'Carey', 'robert.carey@mail.com', md5('password'), 1, 2),
	(5, 'Graham', 'Carey', 'graham.carey@oracle.com', md5('password'), 1, 2);

# TAGS
INSERT INTO tags(tag, created) VALUES
	('tag1', NOW()),
	('tag2', NOW()),
        ('tag3', NOW());

# PROJECTS
INSERT INTO project(name, description, owner, creator, created, date_start, updater, updated, status, visibility, health, priority) VALUES
	('Test Project 1', 'This project exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-11-27', 1, NOW(), 2, 3, 2, 2),
	('Test Project 2', 'This project exists only for test purposes. Please disregard.', 2, 1, NOW(), '2011-11-27', 1, NOW(), 2, 3, 2, 2),
	('Test Project 3', 'This project exists only for test purposes. Please disregard.', 3, 1, NOW(), '2011-11-27', 1, NOW(), 2, 3, 2, 2),
	('Test Project 4', 'This project exists only for test purposes. Please disregard.', 2, 1, NOW(), '2011-11-27', 1, NOW(), 2, 3, 2, 2),
	('Test Project 5', 'This project exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-11-27', 1, NOW(), 2, 3, 2, 2),
	('Test Project 6', 'This project exists only for test purposes. Please disregard.', 2, 1, NOW(), '2011-11-27', 1, NOW(), 2, 3, 2, 2),
	('Test Project 7', 'This project exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-11-27', 1, NOW(), 2, 3, 2, 2),
	('Test Project 8', 'This project exists only for test purposes. Please disregard.', 3, 1, NOW(), '2011-11-27', 1, NOW(), 2, 3, 2, 2),
	('Test Project 9', 'This project exists only for test purposes. Please disregard.', 3, 1, NOW(), '2011-11-27', 1, NOW(), 2, 3, 2, 2),
	('Test Project 10', 'This project exists only for test purposes. Please disregard.', 3, 1, NOW(), '2011-11-27', 1, NOW(), 2, 3, 2, 2);

# PROJECT COMMENTS
INSERT INTO project_comment(comment, user, time, project) VALUES
        ('Hello, World!', 1, NOW(), 1),
        ('Testing 123.', 2, NOW(), 1);


# JOB TYPES
INSERT INTO job_type(name) VALUES
        ('task'),
        ('deliverable');

# JOBS (prev. tasks and deliverables)
INSERT INTO job(name, description, owner, creator, created, date_start, date_end, updater, updated, project, status, type, health, priority) VALUES
	('Test Task 1', 'This task exists only for test purposes. Please disregard.', 1, 1, NOW(), '2012-11-27', '2011-12-27', 1, NOW(), 1, 1, 1, 2, 2),
	('Test Task 2', 'This task exists only for test purposes. Please disregard.', 1, 1, NOW(), '2012-11-27', '2011-12-27', 1, NOW(), 1, 2, 1, 2, 2),
	('Test Task 3', 'This task exists only for test purposes. Please disregard.', 2, 2, NOW(), '2012-11-27', '2011-12-27', 2, NOW(), 2, 3, 1, 2, 2),
	('Test Task 4', 'This task exists only for test purposes. Please disregard.', 2, 2, NOW(), '2012-11-27', '2011-12-27', 2, NOW(), 2, 4, 1, 2, 2),
	('Test Task 5', 'This task exists only for test purposes. Please disregard.', 2, 2, NOW(), '2012-11-27', '2013-12-27', 2, NOW(), 2, 1, 1, 2, 2),
	('Test Task 6', 'This task exists only for test purposes. Please disregard.', 3, 3, NOW(), '2012-11-27', '2013-12-27', 3, NOW(), 3, 2, 1, 2, 2),
	('Test Task 7', 'This task exists only for test purposes. Please disregard.', 3, 3, NOW(), '2012-11-27', '2013-12-27', 3, NOW(), 3, 3, 1, 2, 2),

        ('Test Deliverable 1', 'This deliverable exists only for test purposes. Please disregard.', 1, 1, NOW(), '2013-01-01', '2013-04-02', 1, NOW(), 1, 2, 2, 2, 2),
        ('Test Deliverable 2', 'This deliverable exists only for test purposes. Please disregard.', 1, 1, NOW(), '2013-01-01', '2013-04-02', 1, NOW(), 1, 2, 2, 2, 2),
        ('Test Deliverable 3', 'This deliverable exists only for test purposes. Please disregard.', 2, 1, NOW(), '2013-01-01', '2013-04-02', 2, NOW(), 2, 2, 2, 2, 2),
        ('Test Deliverable 4', 'This deliverable exists only for test purposes. Please disregard.', 3, 1, NOW(), '2013-01-01', '2013-04-02', 3, NOW(), 2, 2, 2, 2, 2),
        ('Test Deliverable 5', 'This deliverable exists only for test purposes. Please disregard.', 3, 1, NOW(), '2013-01-01', '2013-04-02', 3, NOW(), 3, 2, 2, 2, 2),
        ('Test Deliverable 6', 'This deliverable exists only for test purposes. Please disregard.', 3, 1, NOW(), '2013-01-01', '2013-04-02', 3, NOW(), 3, 2, 2, 2, 2),
        ('Test Deliverable 7', 'This deliverable exists only for test purposes. Please disregard.', 2, 1, NOW(), '2013-01-01', '2013-04-02', 2, NOW(), 4, 2, 2, 2, 2),
        ('Test Deliverable 8', 'This deliverable exists only for test purposes. Please disregard.', 3, 1, NOW(), '2013-01-01', '2013-04-02', 3, NOW(), 4, 2, 2, 2, 2),
        ('Test Deliverable 9', 'This deliverable exists only for test purposes. Please disregard.', 3, 1, NOW(), '2013-01-01', '2013-04-02', 3, NOW(), 5, 2, 2, 2, 2),
        ('Test Deliverable 10', 'This deliverable exists only for test purposes. Please disregard.', 2, 1, NOW(), '2013-01-01', '2013-04-02', 2, NOW(), 6, 2, 2, 2, 2),
        ('Test Deliverable 11', 'This deliverable exists only for test purposes. Please disregard.', 2, 1, NOW(), '2013-01-01', '2013-04-02', 2, NOW(), 7, 2, 2, 2, 2),
        ('Test Deliverable 12', 'This deliverable exists only for test purposes. Please disregard.', 2, 1, NOW(), '2013-01-01', '2013-04-02', 2, NOW(), 8, 2, 2, 2, 2);

INSERT INTO job_link(aid, bid, linker, linked) VALUES
        (1, 2, 1, NOW());

# PROJECT TAGS
INSERT INTO tag_project(project, tag, created, user) VALUES
	(1, 1, NOW(), 1),
	(1, 2, NOW(), 1),
	(1, 3, NOW(), 1),
	(2, 1, NOW(), 1),
	(2, 2, NOW(), 1),
	(2, 3, NOW(), 1),
	(3, 1, NOW(), 1);

# TASK TAGS
INSERT INTO tag_job(job, tag, created, user) VALUES
	(1, 1, NOW(), 1),
	(1, 2, NOW(), 1),
	(1, 3, NOW(), 1),
	(2, 1, NOW(), 1),
	(2, 2, NOW(), 1),
	(2, 3, NOW(), 1),
	(3, 1, NOW(), 1);


# PROJECT USER
INSERT INTO project_user(project, user, can_edit) VALUES
	(1, 2, 0),
	(2, 2, 1);


# REPORTS
INSERT INTO field_type(name) VALUES
        ('SINGLE'),
        ('LIST');

INSERT INTO field(object, reference, query, type, link_pre, link_query) VALUES
        (3, 'jobName', 'SELECT name as jobName FROM job WHERE id=', 1, 'job.php?id=', 'SELECT id FROM job WHERE id='),
        (3, 'jobOwner', 'SELECT CONCAT(user.forename, '' '', user.surname) as jobOwner FROM user, job WHERE job.owner=user.id AND job.id=', 1, 'mailto:', 'SELECT email FROM user, task WHERE user.id=job.owner AND job.id='),
        (3, 'jobStatus', 'SELECT status.name as jobStatus FROM status, job WHERE status.id=job.status AND job.id=', 1, '', ''),
        (3, 'jobStartDate', 'SELECT DATE_FORMAT(date_start, ''%d-%b-%y'') as jobStartDate FROM job WHERE id=', 1, '', ''),
        (3, 'jobEndDate', 'SELECT DATE_FORMAT(date_end, ''%d-%b-%y'') as jobEndDate FROM job WHERE id=', 1, '', ''),

        (2, 'projName', 'SELECT name as projName FROM project WHERE id=', 1, 'project.php?id=', 'SELECT id FROM project WHERE id='),
        (2, 'projDesc', 'SELECT description as projDesc FROM project WHERE id=', 1, '', ''),
        (2, 'projUpdated', 'SELECT DATE_FORMAT(updated, ''%d-%b-%y %H:%i'') as projUpdated FROM project WHERE id=', 1, '', ''),
        (2, 'projOwnerID', 'SELECT owner as projOwnerID FROM project WHERE id=', 1, 'mailto:', 'SELECT email FROM user, project WHERE user.id=project.owner AND project.id='),

        (3, 'jobDesc', 'SELECT description as jobDesc FROM job WHERE id=', 1, '', ''),
        (3, 'jobTypeID', 'SELECT type as jobTypeID FROM job WHERE id=', 1, '', ''),
        (3, 'jobUpdated', 'SELECT DATE_FORMAT(updated, ''%d-%b-%y %H:%i'') as jobUpdated FROM job WHERE id=', 1, '', '');


INSERT INTO report(name, instructions, creator, created, object, title, description) VALUES
        ('Overdue Tasks', 'test report', 1, NOW(), 3, 'Overdue Tasks', 'Incomplete tasks that are past their due date.'),
        ('My Projects', 'test report', 1, NOW(), 2, 'My Projects', 'Projects owned by the currently logged in user.'),
        ('Project Tasks', 'Report to show tasks belonging to project.', 1, NOW(), 3, 'Tasks', 'Tasks belonging to the current project.'),
        ('Project Deliverables', 'Report to show deliverables belonging to project.', 1, NOW(), 3, 'Deliverables', 'Deliverables belonging to the current project.');

INSERT INTO report_field(report, field, label, visible, sort, criteria, position) VALUES
        (1, 1, 'Name', 1, 1, '', 1),
        (1, 3, 'Status', 1, 0, '', 3),
        (1, 2, 'Owner', 1, 0, '', 4),
        (1, 4, 'Start Date', 1, 0, '', 5),
        (1, 5, 'End Date', 1, 0, '', 6),
        (2, 6, 'Name', 1, 0, '', 1),
        (2, 7, 'Description', 1, 0, '', 2),
        (2, 8, 'Last updated', 1, -1, '', 3),
        (2, 9, 'OwnerID', 0, 0, 'EQ::||me.id||', 0),
        (1, 10, 'Description', 1, 0, '', 2),
        (1, 11, 'Type', 0, 0, 'EQ::1', 0),

        (3, 1, 'Name', 1, 0, '', 1),
        (3, 10, 'Description', 1, 0, '', 2),
        (3, 12, 'Updated', 1, 0, '' , 3),
        (3, 2, 'Owner', 1, 0, '', 4),
        (3, 11, 'Type', 0, 0, 'EQ::1', 0),
        
        (4, 1, 'Name', 1, 0, '', 1),
        (4, 10, 'Description', 1, 0, '', 2),
        (4, 12, 'Updated', 1, 0, '' , 3),
        (4, 2, 'Owner', 1, 0, '', 4),
        (4, 11, 'Type', 0, 0, 'EQ::2', 0);