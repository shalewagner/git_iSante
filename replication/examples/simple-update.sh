#!/bin/bash

dataFile=$1

perl updateTarget.pl --config /etc/isante/my.cnf --file $dataFile \
    > $dataFile-update-output.txt \
    2> $dataFile-update-errors.txt
