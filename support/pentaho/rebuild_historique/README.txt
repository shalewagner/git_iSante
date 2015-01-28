This script will be used once to rebuild history from patientStatusTemp. It will use all the available dates and create snapshots for these dates.

1. Put the rebuild_historique folder in the data-integration folder
2. cd to the data-integration folder
3. You can run the Snapshot Job as follows: nohup ./kitchen.sh -file="rebuild_historique/master.kjb" -level=Minimal -param:DATABASE=<database> -param:USER=<user> -param:PASSWORD=<password> &
* nophup starts the task as a background task so that it will continue running even if you close the terminal.

The job date should be the date of the day where the job is executed. It is the date that will be stored in the dw_snapshots table in the database.

More info on Kitchen: http://wiki.pentaho.com/display/EAI/Kitchen+User+Documentation