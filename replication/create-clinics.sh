#!/bin/bash
perl readSource.pl \
    --readAll \
    --tableSet clinicLookup \
    --file clinics-Data.csv.gz \
    > clinics-Report.txt \
    2> clinics-Errors.txt
