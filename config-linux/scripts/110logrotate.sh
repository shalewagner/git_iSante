#!/bin/sh -vx

. ./script-functions.sh

#remove old log file from versions earlier than 9.0RC2 (5412)
if [ $UPGRADE ]; then
    rm -f /etc/logrotate.d/itech-10job
fi

logrotateConf=/etc/logrotate.conf
divert $logrotateConf
cp -f templates-output/logrotate.conf $logrotateConf

logrotateRsyslog=/etc/logrotate.d/rsyslog
divert $logrotateRsyslog
cp -f templates-output/logrotate-rsyslog $logrotateRsyslog

cp -f templates-output/logrotate-isante /etc/logrotate.d/isante
