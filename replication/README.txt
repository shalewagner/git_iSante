
apply-received-files-simple.pl - applies a directory full of replication files on Linux
create-clinics.sh - creates a replication file with all clinicLookup records
create-lookups.sh - creates a replication file with records from all lookup tables
examples/ - examples for manually calling readSource.pl and updateTarget.pl
lookups.csv.gz - replication file that contains records for all lookup tables
lookups-Report.txt - summary of the number of records per table in lookups.csv.gz
readSource.pl - reads records from the database and stores them in a replication file
receiver/ - contains a CGI script for receiving replication data files
replicate-database.bat - calls replicate-database.pl on Windows
replicate-database.pl - creates and transmits daily replication files using readSource.pl
updateTarget.pl - applies a replication file to a target database
util-aes-file.pl - encrypt/decrypt a file using Rijndael (AES) encryption
util-spoof-meta.pl - Creates fake meta data for raw replication data files. This is sometimes needed for apply-received-files.pl.

-- The following are Perl libraries.
Database.pm - for creating database connections
JSON/ - Perl JSON library 
JSON.pm - interface to Perl JSON library
LocalConfig.pm - reading config parameters from a database
ModifyRecord.pm - for converting replication records from an old version of iSanté to a new one
ReplicationFile.pm - reading/writing replication data files
TableInfo.pm - used by replication to keep track of things for reporting
