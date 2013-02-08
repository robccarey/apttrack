# user titles
CREATE TABLE titles(
	id		INT			NOT NULL AUTO_INCREMENT,
	title 	VARCHAR(10)		NOT NULL,
	PRIMARY KEY (id)
);
# user account statuses
CREATE TABLE account_status(
	id				INT 			NOT NULL AUTO_INCREMENT,
	name			VARCHAR(10)		NOT NULL,
	description		TEXT,
	PRIMARY KEY(id));

# user account types
CREATE TABLE account_type(
	id				INT 			NOT NULL AUTO_INCREMENT,
	name			VARCHAR(10)		NOT NULL,
	description		TEXT,
	PRIMARY KEY(id));

# system user
CREATE TABLE user(
	id			INT 			NOT NULL AUTO_INCREMENT,
	title			INT 			NOT NULL,
	forename		VARCHAR(20)		NOT NULL,
	surname			VARCHAR(30)		NOT NULL,
	email			VARCHAR(50)		NOT NULL,
	password		VARCHAR(32)		NOT NULL,
	# AUTHENTICATION START
	identifier		VARCHAR(32),
	login_token		VARCHAR(32),
	login_timeout		INT,
	# AUTH END

        # NOTIFICATION OPTIONS
        not_proj_add            INT,
        not_task_add            INT,
        not_proj_dead           INT,
        not_proj_odue           INT,
        # NOTIF END

	account_status		INT 			NOT NULL,
	account_type		INT 			NOT NULL,
	created			DATETIME		NOT NULL,
	last_login		DATETIME		NOT NULL,
	prev_login		DATETIME		NOT NULL,
	PRIMARY KEY (id));
ALTER TABLE user ADD FOREIGN KEY (title) REFERENCES titles(id);
ALTER TABLE user ADD FOREIGN KEY (account_status) REFERENCES account_status(id);
ALTER TABLE user ADD FOREIGN KEY (account_type) REFERENCES account_type(id);

# user sessions
CREATE TABLE session(
	session 	VARCHAR(32) 	NOT NULL,
	timeout 	INT,
	user 		INT 			NOT NULL,
	PRIMARY KEY(session)
);
ALTER TABLE session ADD FOREIGN KEY (user) REFERENCES user(id);

# possible actions, used by change table
CREATE TABLE action(
	id			INT 			NOT NULL AUTO_INCREMENT,
	short		VARCHAR(10)		NOT NULL,
	value		VARCHAR(20)		NOT NULL,
	PRIMARY KEY (id));

# changes made
CREATE TABLE changes(
	id			INT 			NOT NULL AUTO_INCREMENT,
	user		INT 	 		NOT NULL,
	action		INT 			NOT NULL,
	object		VARCHAR(45)		NOT NULL,
	created	DATETIME		NOT NULL,
	PRIMARY KEY(id));
ALTER TABLE changes ADD FOREIGN KEY (user) REFERENCES user(id);
ALTER TABLE changes ADD FOREIGN KEY (action) REFERENCES action(id);

# tags for multiple uses
CREATE TABLE tags(
	id		INT 			NOT NULL AUTO_INCREMENT,
	tag		VARCHAR(20)		NOT NULL,
	created	DATETIME		NOT NULL,
	PRIMARY KEY(id));

# visibility options
CREATE TABLE visibility(
	id				INT 			NOT NULL AUTO_INCREMENT,
	name			VARCHAR(10)		NOT NULL,
	description		TEXT,
	PRIMARY KEY(id));

# statuses for multiple uses
CREATE TABLE status(
	id				INT 			NOT NULL AUTO_INCREMENT,
	name			VARCHAR(10)		NOT NULL,
	description		TEXT,
	PRIMARY KEY(id));

CREATE TABLE health(
        id          INT             NOT NULL AUTO_INCREMENT,
        name        VARCHAR(5)     NOT NULL,
        description TEXT,
        PRIMARY KEY(id));

CREATE TABLE priority(
        id          INT             NOT NULL AUTO_INCREMENT,
        name        VARCHAR(7)     NOT NULL,
        PRIMARY KEY(id));

# projects
CREATE TABLE project(
	id				INT 			NOT NULL AUTO_INCREMENT,
	name			VARCHAR(50)		NOT NULL,
	description		TEXT,
	owner			INT 			NOT NULL,
	creator			INT 			NOT NULL,
	created			DATETIME		NOT NULL,
	date_start		DATE 			NOT NULL,
	updater			INT 			NOT NULL,
	updated			DATETIME		NOT NULL,
	status			INT 			NOT NULL,
	visibility		INT 			NOT NULL,
	PRIMARY KEY(id));
ALTER TABLE project ADD FOREIGN KEY (owner) REFERENCES user(id);
ALTER TABLE project ADD FOREIGN KEY (creator) REFERENCES user(id);
ALTER TABLE project ADD FOREIGN KEY (updater) REFERENCES user(id);
ALTER TABLE project ADD FOREIGN KEY (status) REFERENCES status(id);
ALTER TABLE project ADD FOREIGN KEY (visibility) REFERENCES visibility(id);

# tasks
CREATE TABLE task(
	id				INT 			NOT NULL AUTO_INCREMENT,
	name			VARCHAR(50)		NOT NULL,
	description		TEXT,
	owner			INT 			NOT NULL,
	creator			INT 			NOT NULL,
	created			DATETIME		NOT NULL,
	date_start		DATE,
	date_end		DATE,
	updater			INT 			NOT NULL,
	updated			DATETIME		NOT NULL,
	project			INT 			NOT NULL,
	status			INT 			NOT NULL,
	PRIMARY KEY(id));
ALTER TABLE task ADD FOREIGN KEY (owner) REFERENCES user(id);
ALTER TABLE task ADD FOREIGN KEY (creator) REFERENCES user(id);
ALTER TABLE task ADD FOREIGN KEY (updater) REFERENCES user(id);
ALTER TABLE task ADD FOREIGN KEY (project) REFERENCES project(id);
ALTER TABLE task ADD FOREIGN KEY (status) REFERENCES status(id);

# deliverables
CREATE TABLE deliverable(
	id				INT 			NOT NULL AUTO_INCREMENT,
	name			VARCHAR(50)		NOT NULL,
	description		TEXT,
	owner			INT 			NOT NULL,
	creator			INT 			NOT NULL,
	created			DATETIME		NOT NULL,
	date_end		DATE,
        updater                 INT                     NOT NULL,
        updated                 DATETIME                NOT NULL,
	project			INT 			NOT NULL,
	status			INT 			NOT NULL,
	PRIMARY KEY(id));
ALTER TABLE deliverable ADD FOREIGN KEY (owner) REFERENCES user(id);
ALTER TABLE deliverable ADD FOREIGN KEY (creator) REFERENCES user(id);
ALTER TABLE deliverable ADD FOREIGN KEY (project) REFERENCES project(id);
ALTER TABLE deliverable ADD FOREIGN KEY (status) REFERENCES status(id);
ALTER TABLE deliverable ADD FOREIGN KEY (updater) REFERENCES user(id);

# tags assigned to projects
CREATE TABLE tag_project(
	project		INT 			NOT NULL,
	tag			INT 			NOT NULL,
	created		DATETIME		NOT NULL,
	user		INT 		 	NOT NULL,
	PRIMARY KEY (project, tag));
ALTER TABLE tag_project ADD FOREIGN KEY (project) REFERENCES project(id);
ALTER TABLE tag_project ADD FOREIGN KEY (tag) REFERENCES tags(id);
ALTER TABLE tag_project ADD FOREIGN KEY (user) REFERENCES user(id);

# tags assigned to tasks
CREATE TABLE tag_task(
	task		INT 			NOT NULL,
	tag 		INT 			NOT NULL,
	created		DATETIME		NOT NULL,
	user		INT 			NOT NULL,
	PRIMARY KEY (task, tag));
ALTER TABLE tag_task ADD FOREIGN KEY (task) REFERENCES task(id);
ALTER TABLE tag_task ADD FOREIGN KEY (tag) REFERENCES tags(id);
ALTER TABLE tag_task ADD FOREIGN KEY (user) REFERENCES user(id);

# tags assigned to deliverables
CREATE TABLE tag_deliverable(
	deliverable		INT 			NOT NULL,
	tag				INT 			NOT NULL,
	created 		DATETIME 		NOT NULL,
	user 			INT 			NOT NULL,
	PRIMARY KEY (deliverable, tag));
ALTER TABLE tag_deliverable ADD FOREIGN KEY (deliverable) REFERENCES deliverable(id);
ALTER TABLE tag_deliverable ADD FOREIGN KEY (tag) REFERENCES tags(id);
ALTER TABLE tag_deliverable ADD FOREIGN KEY (user) REFERENCES user(id);

# database objects for use in reports
CREATE TABLE object(
	id			INT 			NOT NULL AUTO_INCREMENT,
	name			VARCHAR(15)		NOT NULL,
	PRIMARY KEY (id));

# possible field types
CREATE TABLE field_type(
        id              INT             NOT NULL AUTO_INCREMENT,
        name            VARCHAR(6)     NOT NULL,
        PRIMARY KEY (id));

# possible fields for reports
CREATE TABLE field(
	id			INT 			NOT NULL AUTO_INCREMENT,
	object		INT 			NOT NULL,
        type            INT                     NOT NULL,
	# database reference info
	reference	VARCHAR(15)		NOT NULL,
	query		TEXT 			NOT NULL,
        link_pre        VARCHAR(30),
        link_query      TEXT,
	PRIMARY KEY (id));
ALTER TABLE field ADD FOREIGN KEY (object) REFERENCES object(id);
ALTER TABLE field ADD FOREIGN KEY (type) REFERENCES field_type(id);

# reports
CREATE TABLE report(
	id			INT 			NOT NULL AUTO_INCREMENT,
	name			VARCHAR(20)		NOT NULL,
	instructions	TEXT,
	creator			INT 			NOT NULL,
	created			DATETIME		NOT NULL,
        object                  INT                     NOT NULL,
        gen_count               INT                     NOT NULL,
	# to be displayed - report content
	title			VARCHAR(20)		NOT NULL,
	description		TEXT,
	PRIMARY KEY (id));
ALTER TABLE report ADD FOREIGN KEY (creator) REFERENCES user(id);
ALTER TABLE report ADD FOREIGN KEY (object) REFERENCES object(id);

# fields used within report
CREATE TABLE report_field(
	report 		INT 			NOT NULL,
	field		INT 			NOT NULL,
        label           VARCHAR(20)             NOT NULL,
	visible 	INT 			NOT NULL DEFAULT 0,
	sort 		INT 			NOT NULL DEFAULT 0,
	criteria	VARCHAR(20),
	position	INT 			NOT NULL,
	PRIMARY KEY (report, field));
ALTER TABLE report_field ADD FOREIGN KEY (report) REFERENCES report(id);
ALTER TABLE report_field ADD FOREIGN KEY (field) REFERENCES field(id);

# subcription of user to projects
CREATE TABLE project_user(
	project 			INT 			NOT NULL,
	user				INT 			NOT NULL,
	PRIMARY KEY (project, user));
ALTER TABLE project_user ADD FOREIGN KEY (project) REFERENCES project(id);
ALTER TABLE project_user ADD FOREIGN KEY (user) REFERENCES user(id);