==============================
=     GOOGLE_PUBLIC_DATA     =
==============================
This script is used to create the dataset zip archive that can be uploaded to google public data explorer (http://www.google.com/publicdata/admin).
The latest zip archive will be created in the folder as DSPL.zip and archived as ARCHIVE/DSPL_yyyy-mm-dd.zip

====================================
=     SETUP GOOGLE_PUBLIC_DATA     =
====================================
- go to PENTAHO SETUP if that hasnt been done yet
- copy this folder on the server
- install python 2.6
- download dspltools from http://code.google.com/p/dspl/
- install the dspltools locally (cd into the dspltools folder and run /usr/local/python-2.6.8/bin/python setup.py install --prefix=~/google_public_data/dspltools)
- add execution rights to create_dspl_archive.sh (chmod +x create_dspl_archive.sh)
- add crontab to execute ./create_dspl_archive.sh daily

=================
=    FOLDERS    =
=================
ARCHIVE/: stores all the archives of the datasets as DSPL_yyyy-mm-dd.zip

output/: contains the output of the pentaho job master.kjb 
output/extract.csv: file containing the aggregated data table used by dsplgen to build the slices
output/clinic_table.csv: file containing a list of clinic information corresponding to the extract.csv, also used by dsplgen

dspl/: folder that contains all the necessary scripts to build the slices and the archive for Google Public Data Explorer

=========================
=     PENTAHO SETUP     =
=========================
This should be done once for all the pentaho jobs.
1. go to http://kettle.pentaho.com/ and download the latest stable release of Kettle in the Recent News and Releases section (can be done directly to the server with wget http://downloads.sourceforge.net/project/pentaho/Data%20Integration/4.2.0-stable/pdi-ce-4.2.0-stable.tar.gz)
2. extract it to the desired directory on the server (any directory would work) with tar -xvf pdi-ce-4.2.0-stable.tar.gz
3. cd data-integration
4. chmod +x *.sh
5. upload the google_public_data.tar archive and extract it in the data-integration directory
6. Import the google_public_data/database/google_public_data.sql file into the database
7. You can now run the Snapshot Job as follows: ./kitchen.sh -file="./google_public_data/master.kjb" -level=Minimal -param:DATABASE=<database name> -param:USER=<database user> -param:PASSWORD=<database password>

The job date should be the date of the day where the job is executed. It is the date that will be stored in the dw_snapshots table in the database.

More info on Kitchen: http://wiki.pentaho.com/display/EAI/Kitchen+User+Documentation