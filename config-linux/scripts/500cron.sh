#!/bin/sh -vx

#remove old cron files from previous versions (changed around 9.0RC2 (5412)
if [ $UPGRADE ]; then
    rm -f /etc/cron.d/itech*
fi

#install crontab file
cp -f templates-output/batch-jobs.cronfile /etc/cron.d/isante

#log file for cron activities
cronlog=/var/log/itech/cron.log
touch $cronlog
chown itech:www-data $cronlog
chmod 664 $cronlog
