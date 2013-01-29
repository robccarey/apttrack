# INSERT VALUES

INSERT INTO titles(title) VALUES
	('Mr'),
	('Miss'),
	('Mrs'),
	('Ms'),
	('Dr');

INSERT INTO account_status(acstatus, description) VALUES('ACTIVE','Current user able to login and use all system features.');

INSERT INTO account_type(actype, description) VALUES
	('ADMIN','Administrative user with top-level privileges.'),
	('NORMAL','Normal user with read/write privileges.');

INSERT INTO users(title, forename, surname, email, password, account_status, account_type) VALUES
	(1, 'Robert', 'Carey', 'robert.carey@mail.com', md5('password'), 1, 2),
	(1, 'Graham', 'Carey', 'robcarey1990@gmail.com', md5('password'), 1, 2);

INSERT INTO tags(tag, created) VALUES
	('test tag 1', NOW()),
	('test tag 2', NOW());

INSERT INTO visibility(name, description) VALUES
	('PRIVATE', 'Project is only visible to owner.'),
	('CLOSED', 'Project is only visible to specified users.'),
	('OPEN', 'Project is visible to all users.');

INSERT INTO status(status, description) VALUES
	('PENDING', 'Will begin in the future.'),
	('CURRENT', 'Currently in progress.'),
	('COMPLETE', '100% complete.'),
	('CLOSED', 'Closed before completion.');

INSERT INTO project(name, description, owner, creater, created, start_date, updater, updated, status, visibility) VALUES
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

INSERT INTO task(name, description, owner, creater, created, start_date, end_date, updater, updated, project, status) VALUES
	('Test Task 1', 'This task exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-11-27', '2011-12-27', 1, NOW(), 1, 2),
	('Test Task 2', 'This task exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-11-27', '2011-12-27', 1, NOW(), 1, 2),
	('Test Task 3', 'This task exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-11-27', '2011-12-27', 1, NOW(), 1, 2),
	('Test Task 4', 'This task exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-11-27', '2011-12-27', 1, NOW(), 1, 2),
	('Test Task 5', 'This task exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-11-27', '2011-12-27', 1, NOW(), 1, 2),
	('Test Task 6', 'This task exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-11-27', '2011-12-27', 1, NOW(), 1, 2),
	('Test Task 7', 'This task exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-11-27', '2011-12-27', 1, NOW(), 1, 2);

INSERT INTO deliverable(name, description, owner, creater, created, deadline, project, status) VALUES
	('Test Deliverable 1', 'This deliverable exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-12-27', 1, 2),
	('Test Deliverable 2', 'This deliverable exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-12-27', 1, 2),
	('Test Deliverable 3', 'This deliverable exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-12-27', 1, 2),
	('Test Deliverable 4', 'This deliverable exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-12-27', 1, 2),
	('Test Deliverable 5', 'This deliverable exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-12-27', 1, 2),
	('Test Deliverable 6', 'This deliverable exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-12-27', 1, 2),
	('Test Deliverable 7', 'This deliverable exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-12-27', 1, 2),
	('Test Deliverable 8', 'This deliverable exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-12-27', 1, 2),
	('Test Deliverable 9', 'This deliverable exists only for test purposes. Please disregard.', 1, 1, NOW(), '2011-12-27', 1, 2);

INSERT INTO tag_project(project, tag, tagged, tagger) VALUES
	(1, 1, NOW(), 1),
	(2, 1, NOW(), 1),
	(3, 1, NOW(), 1),
	(4, 1, NOW(), 1),
	(5, 1, NOW(), 1),
	(6, 1, NOW(), 1),
	(7, 1, NOW(), 1);

INSERT INTO tag_task(task, tag, tagged, tagger) VALUES
	(1, 1, NOW(), 1),
	(2, 1, NOW(), 1),
	(3, 1, NOW(), 1),
	(4, 1, NOW(), 1),
	(5, 1, NOW(), 1),
	(6, 1, NOW(), 1),
	(7, 1, NOW(), 1);

INSERT INTO tag_deliverable(deliverable, tag, tagged, tagger) VALUES
	(1, 1, NOW(), 1),
	(2, 1, NOW(), 1),
	(3, 1, NOW(), 1),
	(4, 1, NOW(), 1),
	(5, 1, NOW(), 1),
	(6, 1, NOW(), 1),
	(7, 1, NOW(), 1);

INSERT INTO field_object(name) VALUES
	('USER'),
	('PROJECT'),
	('TASK'),
	('DELIVERABLE');

INSERT INTO fields(name, field_object, db_reference, db_sql) VALUES
	('user\'s full name', 1, 'userfullname', 'SELECT CONCAT(usFNAME, \' \', usSNAME) as userfullname FROM tblUSER WHERE usID=');

INSERT INTO project_user(project, user) VALUES
	(1, 1),
	(2, 2);