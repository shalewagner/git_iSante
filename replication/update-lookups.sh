#!/bin/bash
perl updateTarget.pl \
    --truncateTables \
    --file lookups.csv.gz \
    > lookupsUp-Report.txt \
    2> lookupsUp-Errors.txt
