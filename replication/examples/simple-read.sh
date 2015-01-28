#!/bin/bash

#    --site 81100 \
perl readSource.pl --config /etc/isante/my.cnf --date "'1970-01-01 00:00:00'" \
    --file simple-Data.csv.gz \
    > simple-Report.txt \
    2> simple-Errors.txt
