DROP TABLE IF EXISTS titles;
CREATE TABLE IF NOT EXISTS titles(
	id      INT		NOT NULL AUTO_INCREMENT,
	title 	VARCHAR(10)	NOT NULL,
	PRIMARY KEY (id));


DROP TABLE IF EXISTS account_status;
CREATE TABLE IF NOT EXISTS account_status(
	id		INT 			NOT NULL AUTO_INCREMENT,
	acstatus	VARCHAR(10)		NOT NULL,
	description	TEXT,
	PRIMARY KEY(id));


DROP TABLE IF EXISTS account_type;
CREATE TABLE IF NOT EXISTS account_type(
	id		INT 			NOT NULL AUTO_INCREMENT,
	actype		VARCHAR(10)		NOT NULL,
	description 	TEXT,
	PRIMARY KEY(id));


DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users(
	id		INT 			NOT NULL AUTO_INCREMENT,
	title		INT 			REFERENCES tblTITLE(tiID),
	forename	VARCHAR(20)		NOT NULL,
	surname 	VARCHAR(30)		NOT NULL,
	email		VARCHAR(50)		NOT NULL,
	# AUTHENTICATION START
	password	VARCHAR(32)		NOT NULL,
	identifier	VARCHAR(32),
	login_token	VARCHAR(32),
	login_timout	INT,
	# AUTHENTICATION END
	account_status	INT 			REFERENCES tblACSTATUS(asID),
	account_type	INT 			REFERENCES tblACTYPE(atID),
	user_created	DATETIME		NOT NULL,
	user_lastlogin	DATETIME		NOT NULL,
        user_prevlogin  DATETIME                NOT NULL,
	PRIMARY KEY (id));


DROP TABLE IF EXISTS tags;
CREATE TABLE IF NOT EXISTS tag(
	id		INT 			NOT NULL AUTO_INCREMENT,
	tag		VARCHAR(20)		NOT NULL,
	created 	DATETIME		NOT NULL,
	PRIMARY KEY(id));


DROP TABLE IF EXISTS visibility;
CREATE TABLE IF NOT EXISTS visibility(
	id		INT 			NOT NULL AUTO_INCREMENT,
        name            VARCHAR(10)		NOT NULL,
	description		TEXT,
	PRIMARY KEY(id));


DROP TABLE IF EXISTS status;
CREATE TABLE IF NOT EXISTS status(
	id		INT 			NOT NULL AUTO_INCREMENT,
	status		VARCHAR(10)		NOT NULL,
	description	TEXT,
	PRIMARY KEY(id));


DROP TABLE IF EXISTS project;
CREATE TABLE IF NOT EXISTS project(
	id			INT 			NOT NULL AUTO_INCREMENT,
	name			VARCHAR(50)		NOT NULL,
	description		TEXT,
	owner			INT 			NOT NULL REFERENCES tblUSER(usID),
	creater 		INT 			NOT NULL REFERENCES tblUSER(usID),
	created 		DATETIME		NOT NULL,
	start_date		DATE,
	updater 		INT 			NOT NULL REFERENCES tblUSER(usID),
	updated 		DATETIME		NOT NULL,
	status  		INT 			NOT NULL REFERENCES tblSTATUS(stID),
	visibility      	INT 			NOT NULL REFERENCES tblVISIBILITY(vsID),
	PRIMARY KEY(id));


DROP TABLE IF EXISTS task;
CREATE TABLE IF NOT EXISTS task(
	id			INT 			NOT NULL AUTO_INCREMENT,
	name			VARCHAR(50)		NOT NULL,
	description		TEXT,
	owner			INT 			NOT NULL REFERENCES tblUSER(usID),
	creater 		INT 			NOT NULL REFERENCES tblUSER(usID),
	created 		DATETIME		NOT NULL,
	start_date		DATE,
	end_date		DATE,
	updater 		INT 			NOT NULL REFERENCES tblUSER(usID),
	updated         	DATETIME		NOT NULL,
	project 		INT 			NOT NULL REFERENCES tblPROJECT(pjID),
	status  		INT 			NOT NULL REFERENCES tblSTATUS(stID),
	PRIMARY KEY(id));


DROP TABLE IF EXISTS deliverable;
CREATE TABLE IF NOT EXISTS deliverable(
	id			INT 			NOT NULL AUTO_INCREMENT,
	name			VARCHAR(50)		NOT NULL,
	description		TEXT,
	owner   		INT 			NOT NULL REFERENCES tblUSER(usID),
	creater 		INT 			NOT NULL REFERENCES tblUSER(usID),
	created 		DATETIME		NOT NULL,
	deadline		DATE,
	project 		INT 			NOT NULL REFERENCES tblPROJECT(pjID),
	status  		INT 			NOT NULL REFERENCES tblSTATUS(stID),
	PRIMARY KEY(id));


DROP TABLE IF EXISTS tag_project;
CREATE TABLE IF NOT EXISTS tag_project(
	project		INT 			NOT NULL REFERENCES tblPROJECT(pjID),
	tag		INT 			NOT NULL REFERENCES tblTAG(tgID),
	tagged      	DATETIME		NOT NULL,
	tagger  	INT 		 	NOT NULL REFERENCES tblUSER(usID),
	PRIMARY KEY (project, tag));


DROP TABLE IF EXISTS tag_task;
CREATE TABLE IF NOT EXISTS tag_task(
	task		INT 			NOT NULL REFERENCES tblTASK(tkID),
	tag 		INT 			NOT NULL REFERENCES tblTAG(tgID),
	tagged		DATETIME		NOT NULL,
	tagger		INT 			NOT NULL REFERENCES tblUSER(usID),
	PRIMARY KEY (task, tag));


DROP TABLE IF EXISTS tag_deliverable;
CREATE TABLE IF NOT EXISTS tag_deliverable(
	deliverable	INT 			NOT NULL REFERENCES tblDELIV(dlID),
	tag		INT 			NOT NULL REFERENCES tblTAG(tgID),
	tagged 		DATETIME 		NOT NULL,
	tagger 		INT 			NOT NULL REFERENCES tblUSER(usID),
	PRIMARY KEY (deliverable, tag));


DROP TABLE IF EXISTS field_object;
CREATE TABLE IF NOT EXISTS field_object(
	id			INT 			NOT NULL AUTO_INCREMENT,
	name			VARCHAR(15)		NOT NULL,
	PRIMARY KEY (id));


DROP TABLE IF EXISTS fields;
CREATE TABLE IF NOT EXISTS fields(
	id			INT 			NOT NULL AUTO_INCREMENT,
	name			VARCHAR(50)		NOT NULL,
	field_object		INT 			NOT NULL REFERENCES tblFDOBJ(foID),

	# database reference info
	db_reference		VARCHAR(15)		NOT NULL,
	db_sql			TEXT 			NOT NULL,
	PRIMARY KEY (id));


DROP TABLE IF EXISTS report;
CREATE TABLE IF NOT EXISTS report(
	id			INT 			NOT NULL AUTO_INCREMENT,
	name			VARCHAR(20)		NOT NULL,
	description		TEXT,
	creater                 INT 			NOT NULL REFERENCES tblUSER(usID),
	created                 DATETIME		NOT NULL,


	# to be displayed - report content
	out_title		VARCHAR(20)		NOT NULL,
	out_description		TEXT,

	PRIMARY KEY (id));


DROP TABLE IF EXISTS report_field;
CREATE TABLE IF NOT EXISTS report_field(
	report  			INT 			NOT NULL REFERENCES tblREPORT(rpID),
	field				INT 			NOT NULL REFERENCES tblFIELD(fdID),
	visible 			INT 			NOT NULL DEFAULT 0,
	sort 				INT 			NOT NULL DEFAULT 0,
	criteria			VARCHAR(20),
	posit				INT 			NOT NULL,
	PRIMARY KEY (report, field));


DROP TABLE IF EXISTS project_user;
CREATE TABLE IF NOT EXISTS project_user(
	project 			INT 			NOT NULL REFERENCES tblPROJECT(pjID),
	user				INT 			NOT NULL REFERENCES tblUSER(usID),
	PRIMARY KEY (project, user));
