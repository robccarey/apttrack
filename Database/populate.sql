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
	('PRIVATE', 'Project is only visible only to owner.', 1),
	('CLOSED', 'Project is only visible to specified users.', 2),
	('OPEN', 'Project is visible to all users.', 3);

# STATUS
INSERT INTO status(name, description, sort) VALUES
	('PENDING', 'Will begin in the future.', 1),
	('CURRENT', 'Currently in progress.', 2),
	('COMPLETE', '100% complete.', 3),
	('CLOSED', 'Closed before completion.', 4);

INSERT INTO health(name, description, sort) VALUES
        ('GREEN', 'Proceeding as intended.', 1),
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
/*INSERT INTO user(title, forename, surname, email, password, account_status, account_type, login_token, login_timeout) VALUES
        (5, 'Administrative', 'User', 'k0909651@kingston.ac.uk', md5('password'), 1, 1, 'logged out', 0),
	(1, 'Robert', 'Carey', 'robert.carey@mail.com', md5('password'), 1, 2, 'logged out', 0),
	(5, 'Graham', 'Carey', 'graham.carey@oracle.com', md5('password'), 1, 2, 'logged out', 0),
        (1, 'Ahmet', 'Abdi', 'ahmetabdi@gmail.com', md5('password'), 1, 2, 'logged out', 0);*/

# TAGS
/*INSERT INTO tags(tag, created) VALUES
	('tag1', NOW()),
	('tag2', NOW()),
        ('tag3', NOW());*/

# PROJECTS
/*INSERT INTO project(name, description, owner, creator, created, date_start, date_end, updater, updated, status, visibility, health, priority) VALUES
	('Final Year Project', 'Create project management system and produce report.', 3, 3, '2012-09-01 16:00:00', '2012-09-01', '2013-05-01', 3, NOW(), 2, 2, 2, 1),
	('Test Project 2', 'This project exists only for test purposes. Please disregard.', 2, 1, NOW(), '2011-11-27', '2013-05-01', 1, NOW(), 2, 3, 2, 2),
	('Test Project 3', 'This project exists only for test purposes. Please disregard.', 3, 1, NOW(), '2011-11-27', '2013-05-01', 1, NOW(), 2, 3, 2, 2),
	('Test Project 4', 'This project exists only for test purposes. Please disregard.', 2, 1, NOW(), '2011-11-27', '2013-05-01', 1, NOW(), 2, 3, 2, 2),
	('Test Project 5', 'This project exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-11-27', '2013-05-01', 1, NOW(), 2, 3, 2, 2),
	('Test Project 6', 'This project exists only for test purposes. Please disregard.', 2, 1, NOW(), '2011-11-27', '2013-05-01', 1, NOW(), 2, 3, 2, 2),
	('Test Project 7', 'This project exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-11-27', '2013-05-01', 1, NOW(), 2, 3, 2, 2),
	('Test Project 8', 'This project exists only for test purposes. Please disregard.', 3, 1, NOW(), '2011-11-27', '2013-05-01', 1, NOW(), 2, 3, 2, 2),
	('Test Project 9', 'This project exists only for test purposes. Please disregard.', 3, 1, NOW(), '2011-11-27', '2013-05-01', 1, NOW(), 2, 3, 2, 2),
	('Test Project 10', 'This project exists only for test purposes. Please disregard.', 3, 1, NOW(), '2011-11-27', '2013-05-01', 1, NOW(), 2, 3, 2, 2);*/

# PROJECT COMMENTS
/*INSERT INTO project_comment(comment, user, time, project) VALUES
        ('Hello, World!', 1, NOW(), 1),
        ('Testing 123.', 2, NOW(), 1);*/


# JOB TYPES
INSERT INTO job_type(name) VALUES
        ('task'),
        ('deliverable');

# JOBS (prev. tasks and deliverables)
/*INSERT INTO job(name, description, owner, creator, created, date_start, date_end, updater, updated, project, status, type, health, priority) VALUES
	('Create database', 'Produce full relational database for project management system.', 2, 2, NOW(), '2012-10-01', '2013-02-13', 2, NOW(), 1, 3, 1, 1, 1),
	('Project management system', 'Deliver fully functioning project management system to client.', 2, 2, NOW(), '2012-09-01', '2013-05-01', 2, NOW(), 1, 2, 1, 2, 2),
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
        ('Test Deliverable 12', 'This deliverable exists only for test purposes. Please disregard.', 2, 1, NOW(), '2013-01-01', '2013-04-02', 2, NOW(), 8, 2, 2, 2, 2);*/

/*INSERT INTO job_link(aid, bid, linker, linked) VALUES
        (1, 2, 1, NOW());*/

# PROJECT TAGS
/*INSERT INTO tag_project(project, tag, created, user) VALUES
	(1, 1, NOW(), 1),
	(1, 2, NOW(), 1),
	(1, 3, NOW(), 1),
	(2, 1, NOW(), 1),
	(2, 2, NOW(), 1),
	(2, 3, NOW(), 1),
	(3, 1, NOW(), 1);*/

# TASK TAGS
/*INSERT INTO tag_job(job, tag, created, user) VALUES
	(1, 1, NOW(), 1),
	(1, 2, NOW(), 1),
	(1, 3, NOW(), 1),
	(2, 1, NOW(), 1),
	(2, 2, NOW(), 1),
	(2, 3, NOW(), 1),
	(3, 1, NOW(), 1);*/


# PROJECT USER
/*INSERT INTO project_user(project, user, can_edit) VALUES
	(1, 2, 0),
	(2, 2, 1);*/


# REPORTS
INSERT INTO field_type(name) VALUES
        ('SINGLE'),
        ('LIST');

INSERT INTO field(object, reference, query, type, link_pre, link_query) VALUES
        (3, 'jobName', 'SELECT name as jobName FROM job WHERE id=', 1, 'job.php?id=', 'SELECT id FROM job WHERE id='),
        (3, 'jobOwner', 'SELECT CONCAT(user.forename, '' '', user.surname) as jobOwner FROM user, job WHERE job.owner=user.id AND job.id=', 1, 'mailto:', 'SELECT email FROM user, job WHERE user.id=job.owner AND job.id='),
        (3, 'jobStatus', 'SELECT status.name as jobStatus FROM status, job WHERE status.id=job.status AND job.id=', 1, '', ''),
        (3, 'jobStartDate', 'SELECT DATE_FORMAT(date_start, ''%d-%b-%y'') as jobStartDate FROM job WHERE id=', 1, '', ''),
        (3, 'jobEndDate', 'SELECT DATE_FORMAT(date_end, ''%d-%b-%y'') as jobEndDate FROM job WHERE id=', 1, '', ''),

        (2, 'projName', 'SELECT name as projName FROM project WHERE id=', 1, 'project.php?id=', 'SELECT id FROM project WHERE id='),
        (2, 'projDesc', 'SELECT description as projDesc FROM project WHERE id=', 1, '', ''),
        (2, 'projUpdated', 'SELECT DATE_FORMAT(updated, ''%d-%b-%y %H:%i'') as projUpdated FROM project WHERE id=', 1, '', ''),
        (2, 'projOwnerID', 'SELECT owner as projOwnerID FROM project WHERE id=', 1, '', ''),

        (3, 'jobDesc', 'SELECT description as jobDesc FROM job WHERE id=', 1, '', ''),
        (3, 'jobTypeID', 'SELECT type as jobTypeID FROM job WHERE id=', 1, '', ''),
        (3, 'jobUpdated', 'SELECT DATE_FORMAT(updated, ''%d-%b-%y %H:%i'') as jobUpdated FROM job WHERE id=', 1, '', ''),
        (3, 'jobOwnerID', 'SELECT owner as jobOwnerID FROM job WHERE id=', 1, '', ''),
        (3, 'jobStartDateNum', 'SELECT UNIX_TIMESTAMP(date_start) as jobStartDateNum FROM job WHERE id=', 1, '', ''),
        (3, 'jobEndDateNum', 'SELECT UNIX_TIMESTAMP(date_end) as jobEndDateNum FROM job WHERE id=', 1, '', ''),
        (3, 'jobCreatedNum', 'SELECT UNIX_TIMESTAMP(created) as jobCreatedNum FROM job WHERE id=', 1, '', ''),
        (3, 'jobUpdatedNum', 'SELECT UNIX_TIMESTAMP(updated) as jobUpdatedNum FROM job WHERE id=', 1, '', ''),
        (3, 'jobRecentComment', 'SELECT comment as jobRecentComment FROM (SELECT * FROM job_comment ORDER BY time DESC) as temp WHERE job=', 1, '', ''),
        (2, 'projRecentComment', 'SELECT comment as projRecentComment FROM (SELECT * FROM project_comment ORDER BY time DESC) as temp WHERE project=', 1, '', ''),
        (2, 'projStartDate', 'SELECT DATE_FORMAT(date_start, ''%d-%b-%y'') as projStartDate FROM project WHERE id=', 1, '', ''),
        (2, 'projEndDate', 'SELECT DATE_FORMAT(date_end, ''%d-%b-%y'') as projEndDate FROM project WHERE id=', 1, '', ''),
        (2, 'projStartDateNum', 'SELECT UNIX_TIMESTAMP(date_start) as projStartDateNum FROM project WHERE id=', 1, '', ''),
        (2, 'projEndDateNum', 'SELECT UNIX_TIMESTAMP(date_end) as projEndDateNum FROM project WHERE id=', 1, '', ''),
        (2, 'projUpdatedNum', 'SELECT UNIX_TIMESTAMP(updated) as projUpdatedNum FROM project WHERE id=', 1, '', ''),
        (2, 'projCreatedNum', 'SELECT UNIX_TIMESTAMP(created) as projCreatedNum FROM project WHERE id=', 1, '', ''),
        (3, 'jobTags', 'SELECT GROUP_CONCAT(tags.tag SEPARATOR '', '') as jobTags FROM tags, tag_job WHERE tag_job.tag=tags.id AND tag_job.job=', 2, '', ''),
        (2, 'projTags', 'SELECT GROUP_CONCAT(tags.tag SEPARATOR '', '') as projTags FROM tags, tag_project WHERE tag_project.tag=tags.id AND tag_project.project=', 2, '', ''),
        (2, 'projOwner', 'SELECT CONCAT(user.forename, '' '', user.surname) as projOwner FROM user, project WHERE project.owner=user.id AND project.id=', 1, 'mailto:', 'SELECT email FROM user, project WHERE user.id=project.owner AND project.id='),
        (2, 'projUpdaterID', 'SELECT updater as projUpdaterID FROM project WHERE id=', 1, '', ''),
        (2, 'projUpdater', 'SELECT CONCAT(user.forename, '' '', user.surname) as projUpdater FROM user, project WHERE project.updater=user.id AND project.id=', 1, 'mailto:', 'SELECT email FROM user, project WHERE user.id=project.updater AND project.id='),
        (2, 'projCreatorID', 'SELECT creator as projCreator FROM project WHERE id=' , 1, '', ''),
        (2, 'projCreator', 'SELECT CONCAT(user.forename, '' '', user.surname) as projCreator FROM user, project WHERE project.creator=user.id AND project.id=', 1, 'mailto:', 'SELECT email FROM user, project WHERE user.id=project.creator AND project.id='),
        (3, 'jobUpdaterID', 'SELECT updater as jobUpdaterID FROM job WHERE id=', 1, '', ''),
        (3, 'jobCreatorID', 'SELECT creator as jobCreatorID FROM job WHERE id=', 1, '', ''),
        (3, 'jobUpdater', 'SELECT CONCAT(user.forename, '' '', user.surname) as jobUpdater FROM user, job WHERE job.updater=user.id AND job.id=', 1, 'mailto:', 'SELECT email FROM user, job WHERE user.id=job.updater AND job.id='),
        (3, 'jobCreator', 'SELECT CONCAT(user.forename, '' '', user.surname) as jobCreator FROM user, job WHERE job.creator=user.id AND job.id=', 1, 'mailto:', 'SELECT email FROM user, job WHERE user.id=job.creator AND job.id=')
        (1, 'userID', 'SELECT id as userID FROM user WHERE id=', 1, '', ''),
        (1, 'userTitle', 'SELECT titles.title as userTitle FROM titles, user WHERE titles.id=user.title AND user.id=', 1, '', ''),
        (1, 'userForename', 'SELECT forename as userForename FROM user WHERE id=', 1, '', ''),
        (1, 'userSurname', 'SELECT surname as userSurname FROM user WHERE id=', 1, '', ''),
        (1, 'userEmail', 'SELECT email as userEmail FROM user WHERE id=', 1, 'mailto:', 'SELECT email FROM user WHERE id='),
        (1, 'userCreated', 'SELECT DATE_FORMAT(created, ''%d-%b-%y %H:%i'') as userCreated FROM user WHERE id=', 1, '', ''),
        (1, 'userCreatedNum', 'SELECT UNIX_TIMESTAMP(created) as userCreatedNum FROM user WHERE id=', 1, '', ''),
        (1, 'userNumOwnedProj', 'SELECT count(*) as userNumOwnedProj FROM project WHERE owner=', 1, '', ''),
        (1, 'userNumOwnedTask', 'SELECT count(*) as userNumOwnedTask FROM job WHERE type=1 AND owner=', 1, '', ''),
        (1, 'userNumOwnedDeliv', 'SELECT count(*) as userNumOwnedDeliv FROM job WHERE type=2 AND owner=', 1, '', ''),
        (1, 'userFullName', 'SELECT CONCAT(forename, '' '', surname) as userFullName FROM user WHERE id=', 1, 'mailto:', 'SELECT email FROM user WHERE id='),
        (1, 'userFormalName', 'SELECT CONCAT(titles.title, ''. '', forename, '' '', surname) FROM titles, user WHERE titles.id=user.title AND user.id=', 1, 'mailto:', 'SELECT email FROM user WHERE id=');


INSERT INTO report(name, instructions, creator, created, object, title, description) VALUES
        ('Overdue Tasks', 'test report', 1, NOW(), 3, 'Overdue Tasks', 'Incomplete tasks that are past their due date.'),
        ('My Projects', 'test report', 1, NOW(), 2, 'My Projects', 'Projects owned by the currently logged in user.'),
        ('Project Tasks', 'Report to show tasks belonging to project.', 1, NOW(), 3, 'Tasks', 'Tasks belonging to the current project.'),
        ('Project Deliverables', 'Report to show deliverables belonging to project.', 1, NOW(), 3, 'Deliverables', 'Deliverables belonging to the current project.'),
        ('My Tasks', 'test report', 1, NOW(), 3, 'My Tasks', 'Tasks owned by the currently logged in user.'),
        ('My Deliverables', 'test report', 1, NOW(), 3, 'My Deliverables', 'Deliverables owned by the currently logged in user.');

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
        (4, 11, 'Type', 0, 0, 'EQ::2', 0),

        (5, 1, 'Name', 1, 0, '', 1),
        (5, 10, 'Description', 1, 0, '', 2),
        (5, 12, 'Updated', 1, 0, '', 3),
        (5, 13, 'OwnerID', 0, 0, 'EQ::||me.id||', 0),
        (5, 11, 'Type', 0, 0, 'EQ::1', 0),

        (6, 1, 'Name', 1, 0, '', 1),
        (6, 10, 'Description', 1, 0, '', 2),
        (6, 12, 'Updated', 1, 0, '', 3),
        (6, 13, 'OwnerID', 0, 0, 'EQ::||me.id||', 0),
        (6, 11, 'Type', 0, 0, 'EQ::2', 0);