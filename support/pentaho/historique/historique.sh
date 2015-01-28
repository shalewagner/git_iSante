#!/bin/bash

# script executed by the cron job daily
cd /home/tlabarre/historique

job_date=`date "+%Y-%m-%d"`

# create extract with pentaho
# change params to correct connection information
../data-integration/kitchen.sh -file="snapshot.kjb" -level=Minimal -param:JOB_DATE=$job_date -param:DATABASE=itech -param:USER=itechapp -param:PASSWORD=
