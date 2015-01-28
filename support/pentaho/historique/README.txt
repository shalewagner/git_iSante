======================
=     HISTORIQUE     =
======================
This script is used to create the daily snapshots on the iSanté Database.
It Extracts data from the iSanté production database, then Transforms it and computes relevant indicators, then Loads the result into the datawarehouse.


============================
=     HISTORIQUE SETUP     =
============================
Change parameters in historique.sh to allow it to connect to the local database.
Setup a cron task that will execute it daily.

=========================
=     PENTAHO SETUP     =
=========================
This should be done once for all the pentaho jobs.
1. go to http://kettle.pentaho.com/ and download the latest stable release of Kettle in the Recent News and Releases section (can be done directly to the server with wget http://downloads.sourceforge.net/project/pentaho/Data%20Integration/4.2.0-stable/pdi-ce-4.2.0-stable.tar.gz)
2. extract it to the desired directory on the server (any directory would work) with tar -xvf pdi-ce-4.2.0-stable.tar.gz
3. cd data-integration
4. chmod +x *.sh
5. upload the historique.tar archive and extract it in the data-integration directory
6. Import the historique/database/historique.sql file into the database
7. You can now run the Snapshot Job as follows: ./kitchen.sh -file="./historique/snapshot.kjb" -level=Minimal -param:JOB_DATE=2012-02-01 -param:DATABASE=<database name> -param:USER=<database user> -param:PASSWORD=<database password>

The job date should be the date of the day where the job is executed. It is the date that will be stored in the dw_snapshots table in the database.

More info on Kitchen: http://wiki.pentaho.com/display/EAI/Kitchen+User+Documentation