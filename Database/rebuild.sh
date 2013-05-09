#!/bin/bash

# GET PATHS
MYSQL=$(which mysql)
AWK=$(which awk)
GREP=$(which grep)
ECHO=$(which echo)

# COLOR VARIABLES
bldred='\e[1;31m'       # red    - Bold
bldgrn='\e[1;32m'       # green
bldylw='\e[1;33m'       # yellow
bldblu='\e[1;34m'       # blue
txtrst='\e[0m'          # Text reset

# COLOURED OUTPUT
out_normal(){ $ECHO -n -e $@;}
out_red(){ $ECHO -n -e ${bldred}$@${txtrst};}
out_green(){ $ECHO -n -e ${bldgrn}$@${txtrst};}
out_yellow(){ $ECHO -n -e ${bldylw}$@${txtrst};}
out_blue(){ $ECHO -n -e ${bldblu}$@${txtrst};}



# FILE LOCATIONS
BASE_DIR="/home/rcarey/NetBeansProjects/apttrack/Database"
DB_CON="$BASE_DIR/construct.sql"
DB_POP="$BASE_DIR/populate.sql"
REQ_FILES=($DB_CON $DB_POP)

# CHECK REQUIRED FILES
out_normal "Checking required files..."
for f in ${REQ_FILES[@]}
do
	if [[ ! -f $f ]]
	then
		out_red "\n\tERROR: $f is missing or incorrectly named.\n"
		exit 1
	fi
done
out_green "OK\n"


# DATABASE VARIABLES
if [[ $1 == "--deploy" ]]
then
	out_normal "Selecting remote DB credentials..."
	DB_HOST='rcarey.co.uk'
	DB_NAME='a2033_apttrack'
	DB_USER='a2033_apttrack'
	DB_PASS='aptTrack247'
	out_green "OK\n"
else
	out_normal "Selecting local DB credentials..."
	DB_HOST='localhost'
	DB_NAME='rcarey_apttrack'
	DB_USER='rcarey_apttrack'
	DB_PASS='metro01'
	out_green "OK\n"
fi


# CLEAN DATABASE
clean_database() {
	TABLES=$($MYSQL -h $DB_HOST -u $DB_USER -p$DB_PASS $DB_NAME -e 'show tables' | $AWK '{ print $1}' | $GREP -v '^Tables')
	if [[ "x$TABLES" != "x" ]]
	then
		#out_normal "Cleaning database..."
		for t in $TABLES
		do
			#echo -n -e "\tDeleting "; out_blue "$t"; echo -n " table from "; out_yellow "$DB_NAME"; echo -n -e " database..."
			OUTPUT=`$MYSQL -h $DB_HOST -u $DB_USER -p$DB_PASS $DB_NAME -e "drop table $t" 2> /dev/null`
			RESULT=$?
			#if [[ $RESULT -eq 0 ]]
			#then
			#	out_green "OK\n"
			#else
			#	out_red "FAIL\n"
			#fi
		done
		#out_green "OK\n"
	fi
}


out_normal "Cleaning database..."
TABLES=$($MYSQL -h $DB_HOST -u $DB_USER -p$DB_PASS $DB_NAME -e 'show tables' | $AWK '{ print $1}' | $GREP -v '^Tables')
let x=0
for t in $TABLES
do
	let x=$x+1
done
NUM_TABLES=$x

while [[ $NUM_TABLES -gt 0 ]]
do
	clean_database

	#out_normal "Recounting tables..."
		
		let x=0
		for t in $TABLES
		do
			let x=$x+1
		done
		NUM_TABLES=$x
done
out_green "OK\n"

MYSQL_CMD="$MYSQL --host=$DB_HOST --user=$DB_USER --pass=$DB_PASS $DB_NAME"

# REBUILD DATABASE
out_normal "Constructing database..."
OUTPUT=`$MYSQL_CMD < $DB_CON`
RESULT=$?
if [[ $RESULT -eq 0 ]]
then
	out_green "OK\n"
else
	out_red "FAILED\n"
	out_normal "\tThere is an error in your SQL construction file.\n"
	exit 1
fi

# CONFIRM TABLE CREATION
out_normal "Recounting tables..."
	TABLES=$($MYSQL -h $DB_HOST -u $DB_USER -p$DB_PASS $DB_NAME -e 'show tables' | $AWK '{ print $1}' | $GREP -v '^Tables')
	let x=0
	for t in $TABLES
	do
		let x=$x+1
	done
	if [[ $x -eq 0 ]]
	then
		out_red "\n\tERROR: Unable to create tables.\n"
		exit 1
	else
		out_green "OK\n"
	fi


# REPOPULATE DATABASE
out_normal "Populating database..."
OUTPUT=`$MYSQL_CMD < $DB_POP`
RESULT=$?
if [[ $RESULT -eq 0 ]]
then
	out_green "OK\n"
else
	out_red "FAILED\n"
	out_normal "\tThere is an error in your SQL population file.\n"
	exit 1
fi

out_normal "Complete.\n\n"