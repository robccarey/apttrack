#!/bin/bash

# GET PATHS
MYSQL=$(which mysql)
AWK=$(which awk)
GREP=$(which grep)
ECHO=$(which echo)
SCP=$(which scp)
SSH=$(which ssh)
RSYNC=$(which rsync)

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
DB_SCRIPT="/home/rcarey/NetBeansProjects/apttrack/Database/rebuild.sh"
DB_CMD="$DB_SCRIPT --deploy"
REQ_FILES=($DB_SCRIPT)

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


# REBUILD REMOTE DATABASE?
out_blue "Do you wish to rebuild the remote database? [y/n]\n"
read ANS
if [[ $ANS == "y" || $ANS == "Y" ]]
then
	out_normal "Calling rebuild script...\n"
	$DB_CMD
	out_normal "Remote database rebuilt.\n\n"
else
	out_normal "Skipping remote database rebuild.\n\n"
fi


# GIT PULLED?
out_blue "REMINDER: This script assumes you have the\n\t
			latest copy of the codebase on your system.\n\t
			If you're unsure, it is recommended that you\n\t
			check out the latest version from the github\n\t
			repository before continuing.\n\n"
out_blue "Continue?\n"
read NOTHING


### DEPLOY WEB FILES
RM_USER="a1570"
RM_HOST="rcarey.co.uk"
RM_PATH="/home/a1570"
RM_OLD="$RM_PATH/fyp_backup"
RM_NEW="$RM_PATH"

LC_PATH="/home/rcarey/NetBeansProjects/apttrack/public_html/"

# BACK UP OLD FILES
out_normal "Removing old backup directory..."

# REMOVE OLD BACKUP
RESULT=`$SSH $RM_USER@$RM_HOST rm -rf $RM_OLD`
RES=$?
if [[ $RES -eq 0 ]]
then
	out_green "OK\n"
else
	out_red "FAILED ($RES)\n"
	out_normal "\tSomething went wrong removing the old backup directory.\n"
	exit 1
fi

# COPY NEW FILES
out_normal "Deploying new files to $RM_HOST..."
RESULT=`$RSYNC -r -a -v -e "$SSH -l $RM_USER" --delete $LC_PATH $RM_HOST:/$RM_NEW/public_html`
RES=$?
if [[ $RES -eq 0 ]]
then
	out_green "OK\n"
else
	out_red "FAILED\n"
	out_normal "\tSomething went wrong deploying the latest files.\n"
	exit 1
fi

# BACKING UP DEPLOYED FILES
out_normal "Backing up existing files..."
RESULT=`$SSH $RM_USER@$RM_HOST cp -r $RM_NEW/public_html $RM_OLD`
RES=$?
if [[ $RES -eq 0 ]]
then
	out_green "OK\n"
else
	out_red "FAILED ($RES)\n"
	out_normal "\tSomething went wrong backing up the existing files.\n"
fi

out_normal "Complete.\n\n"