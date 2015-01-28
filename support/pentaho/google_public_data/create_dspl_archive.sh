#!/bin/bash

cd /home/tlabarre/google_public_data

# create extract with pentaho
../data-integration/kitchen.sh -file="master.kjb" -level=Minimal -param:DATABASE=itech -param:USER=itechapp -param:PASSWORD=eeneisheikah -param:START_DATE=2004-01-01

# copy extracted files from pentaho to dsplgen working directory
cp output/clinic_table.csv dspl/tables/clinic_table.csv
cp output/extract.csv dspl/extract.csv

# add headers to the datable.csv file that will be used
cat dspl/header.txt > dspl/datatable.csv
cat dspl/extract.csv >> dspl/datatable.csv

# execute dsplgen tool to generate all the slices for the dataset
/usr/local/python-2.6.8/bin/python dspl/dsplgen.py -o dspl/output dspl/datatable.csv
# apply relabeling script to the generated bare dataset.xml
/usr/local/python-2.6.8/bin/python dspl/relabel/relabel.py dspl/output/dataset.xml dspl/relabel/description.txt dspl/output/dataset.xml

# add new labeled concept tables and replace generated ones
for file in sex_table.csv department_table.csv clinic_table.csv pregnant_table.csv patientStatus_table.csv
do
	cp dspl/tables/$file dspl/output/$file
done

# generate DSPL.zip dataset
rm DSPL.zip
zip DSPL.zip dspl/output/*

# archive DSPL.zip
job_date=`date "+%Y-%m-%d"`
cp DSPL.zip ARCHIVE/DSPL_$job_date.zip
