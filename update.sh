#!/bin/bash

# functions
notify() {
	IMG_DIR='/usr/share/icons/Mint-X/status/48'

	if [[ "x$1" == "x" ]]
	then
		NOTIFY_TITLE='--title not set--'
	else
		NOTIFY_TITLE="$1"
	fi
	if [[ "x$2" == "x" ]]
	then
		NOTIFY_MSG=''
	else
		NOTIFY_MSG="$2"
	fi

	notify-send "$NOTIFY_TITLE" "$NOTIFY_MSG"
}

check_dir() {
	if [[ ! -e $DIR ]]
	then
		mkdir $DIR
	elif [[ ! -d $DIR ]]
	then
		#echo "$DIR exists but isn't a directory!"
		#echo "exiting..."
		exit 1
	fi
}
get_old_ip() {
	if [[ ! -e $IP_FILE ]]
	then
		touch $IP_FILE
	fi

	cat $IP_FILE
}

get_cur_ip() {
	curl -s "http://checkip.dyndns.com/" | grep -Eo "[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+"
}

make_page() {
	if [[ -f $TMP_FILE ]]
	then
		rm -rf $TMP_FILE
	elif [[ -d $TMP_FILE ]]
	then
		#echo '$TMP_FILE is a directory!'
		#echo 'exiting...'
		exit 1
	fi
	echo "<?php" >> $TMP_FILE
	echo " \$ip = '${CUR_IP}';" >> $TMP_FILE
	echo "?>" >> $TMP_FILE
}

send_page() {
	#echo "sending file..."
	aaa=$(date | rev 2> /dev/null)
	NULL=$(scp $TMP_FILE $USER@$HOST:$REM_LOC/$REM_FILE 2> /dev/null)
	#echo "file sent"
}

clean_up() {
	rm -rf $TMP_FILE
}



# variables
DIR="/home/rcarey/NetBeansProjects/apttrack/ip"
IP_FILE="$DIR/ip-address"
USER='a2033'
HOST='rcarey.co.uk'
REM_LOC='/home/a2033/public_html'
REM_FILE='desktop-ip.php'
TMP_FILE="$DIR/`date +%s`"


# method
check_dir
OLD_IP=`get_old_ip`
CUR_IP=`get_cur_ip`

#echo "Old IP: $OLD_IP"
#echo "Cur IP: $CUR_IP"

if [[ "$OLD_IP" != "$CUR_IP" ]]
then
	#echo 'IPs are different.'
	echo $CUR_IP > $IP_FILE

	make_page
	send_page
	notify-send "IP updater" "Page redirect at rcarey.co.uk has been updated to forward to the new external IP address."
	echo "You have been assigned a new external IP address: $CUR_IP" | mail -s "IP updater: new external IP address" "robcarey1990@gmail.com"
else
	notify-send "UP updater" "No change to current external IP address."
fi

if [[ "x$1" != "x" ]]
then
	echo $CUR_IP
fi