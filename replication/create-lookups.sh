#!/bin/bash
perl readSource.pl \
    --readAll \
    --tableSet lookups \
    --file lookups-Data.csv.gz \
    > lookups-Report.txt \
    2> lookups-Errors.txt
cp lookups.csv.gz old.csv.gz
cp lookups-Data.csv.gz new.csv.gz
gunzip old.csv.gz
gunzip new.csv.gz
diff old.csv new.csv
rm -f old.csv new.csv
