# user titles
CREATE TABLE titles(
	id	INT			NOT NULL AUTO_INCREMENT,
	title 	VARCHAR(10)		NOT NULL,
	PRIMARY KEY (id)
);
# user account statuses
CREATE TABLE account_status(
	id			INT 			NOT NULL AUTO_INCREMENT,
	name			VARCHAR(10)		NOT NULL,
	description		TEXT,
	PRIMARY KEY(id));

# user account types
CREATE TABLE account_type(
	id			INT 			NOT NULL AUTO_INCREMENT,
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

	account_status		INT 			NOT NULL,
	account_type		INT 			NOT NULL,
	created			DATETIME		NOT NULL,
	last_login		DATETIME		NOT NULL,
	prev_login		DATETIME		NOT NULL,
	PRIMARY KEY (id));
ALTER TABLE user ADD FOREIGN KEY (title) REFERENCES titles(id);
ALTER TABLE user ADD FOREIGN KEY (account_status) REFERENCES account_status(id);
ALTER TABLE user ADD FOREIGN KEY (account_type) REFERENCES account_type(id);

# tags for multiple uses
CREATE TABLE tags(
	id		INT 			NOT NULL AUTO_INCREMENT,
	tag		VARCHAR(20)		NOT NULL,
	created         DATETIME		NOT NULL,
	PRIMARY KEY(id));

# visibility options
CREATE TABLE visibility(
	id			INT 			NOT NULL AUTO_INCREMENT,
	name			VARCHAR(10)		NOT NULL,
	description		TEXT,
        sort                    INT,
	PRIMARY KEY(id));

# statuses for multiple uses
CREATE TABLE status(
	id			INT 			NOT NULL AUTO_INCREMENT,
	name			VARCHAR(10)		NOT NULL,
	description		TEXT,
        sort                    INT,
	PRIMARY KEY(id));

CREATE TABLE health(
        id          INT            NOT NULL AUTO_INCREMENT,
        name        VARCHAR(5)     NOT NULL,
        description TEXT,
        sort        INT,
        PRIMARY KEY(id));

CREATE TABLE priority(
        id          INT            NOT NULL AUTO_INCREMENT,
        name        VARCHAR(7)     NOT NULL,
        sort        INT,
        PRIMARY KEY(id));

# projects
CREATE TABLE project(
	id			INT 			NOT NULL AUTO_INCREMENT,
	name			VARCHAR(50),
	description		TEXT,
	owner			INT,
	creator			INT                     NOT NULL,
	created			DATETIME                NOT NULL,
	date_start		DATE,
        date_end                DATE,
	updater			INT,
	updated			DATETIME,
	status			INT,
	visibility		INT,
        health                  INT,
        priority                INT,
	PRIMARY KEY(id));
ALTER TABLE project ADD FOREIGN KEY (owner) REFERENCES user(id);
ALTER TABLE project ADD FOREIGN KEY (creator) REFERENCES user(id);
ALTER TABLE project ADD FOREIGN KEY (updater) REFERENCES user(id);
ALTER TABLE project ADD FOREIGN KEY (status) REFERENCES status(id);
ALTER TABLE project ADD FOREIGN KEY (visibility) REFERENCES visibility(id);
ALTER TABLE project ADD FOREIGN KEY (health) REFERENCES health(id);
ALTER TABLE project ADD FOREIGN KEY (priority) REFERENCES priority(id);

# project comments
CREATE TABLE project_comment(
        id          INT             NOT NULL AUTO_INCREMENT,
        comment     TEXT            NOT NULL,
        user        INT             NOT NULL,
        time        DATETIME        NOT NULL,
        project     INT             NOT NULL,
        PRIMARY KEY(id));
ALTER TABLE project_comment ADD FOREIGN KEY (user) REFERENCES user(id);
ALTER TABLE project_comment ADD FOREIGN KEY (project) REFERENCES project(id);

# job types
CREATE TABLE job_type(
        id          INT             NOT NULL AUTO_INCREMENT,
        name        VARCHAR(11)     NOT NULL,
        PRIMARY KEY(id));

# jobs (prev. tasks and deliverables)
CREATE TABLE job(
	id			INT 		NOT NULL AUTO_INCREMENT,
	name			VARCHAR(50),
	description		TEXT,
	owner			INT,
	creator			INT,
	created			DATETIME,
	date_start		DATE,
	date_end		DATE,
	updater			INT,
	updated			DATETIME,
	project			INT,
	status			INT,
        type                    INT,
        health                  INT,
        priority                INT,
	PRIMARY KEY(id));
ALTER TABLE job ADD FOREIGN KEY (owner) REFERENCES user(id);
ALTER TABLE job ADD FOREIGN KEY (creator) REFERENCES user(id);
ALTER TABLE job ADD FOREIGN KEY (updater) REFERENCES user(id);
ALTER TABLE job ADD FOREIGN KEY (project) REFERENCES project(id);
ALTER TABLE job ADD FOREIGN KEY (status) REFERENCES status(id);
ALTER TABLE job ADD FOREIGN KEY (type) REFERENCES job_type(id);
ALTER TABLE job ADD FOREIGN KEY (health) REFERENCES health(id);
ALTER TABLE job ADD FOREIGN KEY (priority) REFERENCES priority(id);

# job association
CREATE TABLE job_link(
        aid                 INT         NOT NULL,
        bid                 INT         NOT NULL,
        linker              INT         NOT NULL,
        linked              DATETIME    NOT NULL,
        PRIMARY KEY (aid, bid));
ALTER TABLE job_link ADD FOREIGN KEY (aid) REFERENCES job(id);
ALTER TABLE job_link ADD FOREIGN KEY (bid) REFERENCES job(id);
ALTER TABLE job_link ADD FOREIGN KEY (linker) REFERENCES user(id);

# job comments
CREATE TABLE job_comment(
        id          INT             NOT NULL AUTO_INCREMENT,
        comment     TEXT            NOT NULL,
        user        INT             NOT NULL,
        time        DATETIME        NOT NULL,
        job     INT             NOT NULL,
        PRIMARY KEY(id));
ALTER TABLE job_comment ADD FOREIGN KEY (user) REFERENCES user(id);
ALTER TABLE job_comment ADD FOREIGN KEY (job) REFERENCES job(id);


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

# tags assigned to jobs
CREATE TABLE tag_job(
	job		INT 			NOT NULL,
	tag 		INT 			NOT NULL,
	created		DATETIME		NOT NULL,
	user		INT 			NOT NULL,
	PRIMARY KEY (job, tag));
ALTER TABLE tag_job ADD FOREIGN KEY (job) REFERENCES job(id);
ALTER TABLE tag_job ADD FOREIGN KEY (tag) REFERENCES tags(id);
ALTER TABLE tag_job ADD FOREIGN KEY (user) REFERENCES user(id);


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
	reference	VARCHAR(50)		NOT NULL,
	query		TEXT 			NOT NULL,
        link_pre        VARCHAR(30),
        link_query      TEXT,
	PRIMARY KEY (id));
ALTER TABLE field ADD FOREIGN KEY (object) REFERENCES object(id);
ALTER TABLE field ADD FOREIGN KEY (type) REFERENCES field_type(id);

# reports
CREATE TABLE report(
	id			INT 			NOT NULL AUTO_INCREMENT,
	name			VARCHAR(20),
	instructions            TEXT,
	creator			INT 			NOT NULL,
	created			DATETIME		NOT NULL,
        object                  INT                     NOT NULL,
        gen_count               INT                     NOT NULL,
	# to be displayed - report content
	title			VARCHAR(20),
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
        since                           DATETIME                NOT NULL,
        can_edit                        INT                     NOT NULL,
	PRIMARY KEY (project, user));
ALTER TABLE project_user ADD FOREIGN KEY (project) REFERENCES project(id);
ALTER TABLE project_user ADD FOREIGN KEY (user) REFERENCES user(id);