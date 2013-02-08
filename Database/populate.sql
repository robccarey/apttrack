# INSERT TEST DATA INTO DATABASE

### DEFAULT DATA
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

# ACTIONS
INSERT INTO action(short, value) VALUES
	('CREATE','created a'),
	('COMMENT','commented on'),
	('UPDATE','updated'),
	('ASSIGN','assigned a');

# VISIBILITY
INSERT INTO visibility(name, description) VALUES
	('PRIVATE', 'Project is only visible to owner.'),
	('CLOSED', 'Project is only visible to specified users.'),
	('OPEN', 'Project is visible to all users.');

# STATUS
INSERT INTO status(name, description) VALUES
	('PENDING', 'Will begin in the future.'),
	('CURRENT', 'Currently in progress.'),
	('COMPLETE', '100% complete.'),
	('CLOSED', 'Closed before completion.');

INSERT INTO health(name, description) VALUES
        ('GREEN', 'Proceding as intended.'),
        ('AMBER', 'Minor setbacks experienced.'),
        ('RED', 'Progress has been significantly delayed.');

INSERT INTO priority(name) VALUES
        ('HIGH'),
        ('MEDIUM'),
        ('LOW');

# OBJECTS
INSERT INTO object(name) VALUES
	('USER'),
	('PROJECT'),
	('TASK'),
	('DELIVERABLE');



# TEST DATA
# USERS
INSERT INTO user(title, forename, surname, email, password, account_status, account_type) VALUES
	(1, 'Robert', 'Carey', 'robert.carey@mail.com', md5('password'), 1, 2),
	(1, 'Graham', 'Carey', 'graham.carey@oracle.com', md5('password'), 1, 2);

# TAGS
INSERT INTO tags(tag, created) VALUES
	('test tag 1', NOW()),
	('test tag 2', NOW());

# PROJECTS
INSERT INTO project(name, description, owner, creator, created, date_start, updater, updated, status, visibility) VALUES
	('Test Project 1', 'This project exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-11-27', 1, NOW(), 2, 3),
	('Test Project 2', 'This project exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-11-27', 1, NOW(), 2, 3),
	('Test Project 3', 'This project exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-11-27', 1, NOW(), 2, 3),
	('Test Project 4', 'This project exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-11-27', 1, NOW(), 2, 3),
	('Test Project 5', 'This project exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-11-27', 1, NOW(), 2, 3),
	('Test Project 6', 'This project exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-11-27', 1, NOW(), 2, 3),
	('Test Project 7', 'This project exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-11-27', 1, NOW(), 2, 3),
	('Test Project 8', 'This project exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-11-27', 1, NOW(), 2, 3),
	('Test Project 9', 'This project exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-11-27', 1, NOW(), 2, 3),
	('Test Project 10', 'This project exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-11-27', 1, NOW(), 2, 3);

# TASKS
INSERT INTO task(name, description, owner, creator, created, date_start, date_end, updater, updated, project, status) VALUES
	('Test Task 1', 'This task exists only for test purposes. Please disregard.', 1, 1, NOW(), '2012-11-27', '2011-12-27', 1, NOW(), 1, 2),
	('Test Task 2', 'This task exists only for test purposes. Please disregard.', 1, 1, NOW(), '2012-11-27', '2011-12-27', 1, NOW(), 1, 2),
	('Test Task 3', 'This task exists only for test purposes. Please disregard.', 1, 1, NOW(), '2012-11-27', '2011-12-27', 1, NOW(), 1, 2),
	('Test Task 4', 'This task exists only for test purposes. Please disregard.', 1, 1, NOW(), '2012-11-27', '2011-12-27', 1, NOW(), 1, 2),
	('Test Task 5', 'This task exists only for test purposes. Please disregard.', 1, 1, NOW(), '2012-11-27', '2013-12-27', 1, NOW(), 1, 2),
	('Test Task 6', 'This task exists only for test purposes. Please disregard.', 1, 1, NOW(), '2012-11-27', '2013-12-27', 1, NOW(), 1, 2),
	('Test Task 7', 'This task exists only for test purposes. Please disregard.', 1, 1, NOW(), '2012-11-27', '2013-12-27', 1, NOW(), 1, 2);

# DELIVERABLES
INSERT INTO deliverable(name, description, owner, creator, created, date_end, project, status, updater, updated) VALUES
	('Test Deliverable 1', 'This deliverable exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-12-27', 1, 2, 1, NOW()),
	('Test Deliverable 2', 'This deliverable exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-12-27', 1, 2, 1, NOW()),
	('Test Deliverable 3', 'This deliverable exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-12-27', 1, 2, 1, NOW()),
	('Test Deliverable 4', 'This deliverable exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-12-27', 1, 2, 1, NOW()),
	('Test Deliverable 5', 'This deliverable exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-12-27', 1, 2, 1, NOW()),
	('Test Deliverable 6', 'This deliverable exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-12-27', 1, 2, 1, NOW()),
	('Test Deliverable 7', 'This deliverable exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-12-27', 1, 2, 1, NOW()),
	('Test Deliverable 8', 'This deliverable exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-12-27', 1, 2, 1, NOW()),
	('Test Deliverable 9', 'This deliverable exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-12-27', 1, 2, 1, NOW());

# PROJECT TAGS
INSERT INTO tag_project(project, tag, created, user) VALUES
	(1, 1, NOW(), 1),
	(2, 1, NOW(), 1),
	(3, 1, NOW(), 1),
	(4, 1, NOW(), 1),
	(5, 1, NOW(), 1),
	(6, 1, NOW(), 1),
	(7, 1, NOW(), 1);

# TASK TAGS
INSERT INTO tag_task(task, tag, created, user) VALUES
	(1, 1, NOW(), 1),
	(2, 1, NOW(), 1),
	(3, 1, NOW(), 1),
	(4, 1, NOW(), 1),
	(5, 1, NOW(), 1),
	(6, 1, NOW(), 1),
	(7, 1, NOW(), 1);

# DELIVERABLE TAGS
INSERT INTO tag_deliverable(deliverable, tag, created, user) VALUES
	(1, 1, NOW(), 1),
	(2, 1, NOW(), 1),
	(3, 1, NOW(), 1),
	(4, 1, NOW(), 1),
	(5, 1, NOW(), 1),
	(6, 1, NOW(), 1),
	(7, 1, NOW(), 1);

# PROJECT USER
INSERT INTO project_user(project, user) VALUES
	(1, 1),
	(2, 2);


# REPORTS
INSERT INTO field_type(name) VALUES
        ('SINGLE'),
        ('LIST');

INSERT INTO field(object, reference, query, type, link_pre, link_query) VALUES
        (3, 'taskName', 'SELECT name as taskName FROM task WHERE id=', 1, 'taskView.php?tid=', 'SELECT id FROM task WHERE id='),
        (3, 'taskOwner', 'SELECT CONCAT(user.forename, '' '', user.surname) as taskOwner FROM user, task WHERE task.owner=user.id AND task.id=', 1, 'mailto:', 'SELECT email FROM user, task WHERE user.id=task.owner AND task.id='),
        (3, 'taskStatus', 'SELECT status.name as taskStatus FROM status, task WHERE status.id=task.status AND task.id=', 1, '', ''),
        (3, 'taskStartDate', 'SELECT date_start as taskStartDate FROM task WHERE id=', 1, '', ''),
        (3, 'taskEndDate', 'SELECT date_end as taskEndDate FROM task WHERE id=', 1, '', ''),

        (2, 'projName', 'SELECT name as projName FROM project WHERE id=', 1, 'projectView.php?pid=', 'SELECT id FROM project WHERE id='),
        (2, 'projDesc', 'SELECT description as projDesc FROM project WHERE id=', 1, '', ''),
        (2, 'projUpdated', 'SELECT updated as projUpdated FROM project WHERE id=', 1, '', ''),
        (2, 'projOwnerID', 'SELECT owner as projOwnerID FROM project WHERE id=', 1, '', '');


INSERT INTO report(name, instructions, creator, created, object, title, description) VALUES
        ('Overdue Tasks', 'test report', 1, NOW(), 3, 'Overdue Tasks', 'Incomplete tasks that are past their due date.'),
        ('My Projects', 'test report', 1, NOW(), 2, 'My Projects', 'Projects owned by the currently logged in user.');

INSERT INTO report_field(report, field, label, visible, sort, criteria, position) VALUES
        (1, 1, 'Name', 1, -1, '', 1),
        (1, 3, 'Status', 1, 0, '', 2),
        (1, 2, 'Owner', 1, 0, '', 3),
        (1, 4, 'Start Date', 1, 0, '', 4),
        (1, 5, 'End Date', 1, 0, '', 5),
        (2, 6, 'Name', 1, 0, '', 1),
        (2, 7, 'Description', 1, 0, '', 2),
        (2, 8, 'Last updated', 1, -1, '', 3),
        (2, 9, 'OwnerID', 1, 0, 'EQ::||me.id||', 4);
           
