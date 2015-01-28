#!/bin/bash

backupFile=$1 

conffile=/etc/isante/my.cnf
mysqlDatafiles="/var/lib/mysql/ibdata* /var/lib/mysql/ib_logfile* /var/lib/mysql/itech"


#check a few things to make sure it is safe to run
if [ `whoami` != 'root' ]; then
    echo "Must run as root."
    exit 1;
fi

if [ ! -f "$conffile" ]; then
    echo "Must run setup-isante.pl first."
    exit 1;
fi

if [ ! -f "$backupFile" ]; then
    echo "Can't find file $1."
    exit 1;
fi

parseini () {
    varname=$1
    grep "^[[:space:]]*$varname[[:space:]]*=" < $conffile | \
        sed -r 's/[^=]*=[[:space:]]*"?([^"]*)"?/\1/' | \
        tail -n 1
}
getConfig () {
    varname=$1
    mysql --defaults-file=$conffile <<EOF | tail -n 1
select value from config where name = '$varname'
EOF
}    

# determine whether we are recovering from an encrypted or an older, unencrypted file
E_fullpath=$backupFile
filename=$(basename $E_fullpath) 
NotE_filename=${filename#E_}

if [ $filename != $NotE_filename ]; then
# try getting encryption key from command line; then locally, then from consolidated database [currently commented out]
eKey=$2  
if [ "$eKey" = "" ]; then
	echo "Encryption key was not provided on the command line, will try to fetch it from the local database..."
	echo " "
	eKey=$(getConfig backupEncryptionKey)
fi 
#if [ "$eKey" = "" ]; then
#	echo "Encryption key is not available locally, try to fetch it from the consolidated database (this will take some time)..."
#	echo " "
#	eKey=`perl /var/www/isante/support/fetchKey.pl` 
#fi 
if [ "$eKey" = "" ]; then
	echo "Encryption key not automatically fetched; Please obtain it manually by running this query on a consolidated database:"
	echo "--------------------------------------------------------------------------------------------" 
	echo "select substr(eventParameters, 40,locate('\"}',eventParameters)-40) "
	echo "from eventLog where dbsite=$(getConfig dbsite) and eventLog_id in ("
	echo "     select max(eventLog_id) from eventLog where eventtype = 'configChange' and eventParameters like '%backupEncryptionKey%'"
	echo ")"
	echo "--------------------------------------------------------------------------------------------"
	exit 1; 
fi
fi

#Figure out what kind of backup file we are dealing with.
#Older backup files were .tar.bz2 format (9.0RC1 and older)
#Newer ones are just .tar (9.0RC2 and newer)
fileType=tar
if [[ "$backupFile" =~ \.tar\.bz2$ ]]; then
    fileType=bzip
fi

#decrypt the backup file prior to doing the restore 
if [ $filename != $NotE_filename ]; then
backupFile=$(dirname $backupFile)"/"$NotE_filename
#commented out line should only be used for testing on sodium (unorthodox path)
#`perl /home/websites/haiti-dev.cirg.washington.edu/steve/replication/util-aes-file.pl decrypt $eKey $E_fullpath $backupFile`
`perl /var/www/isante/replication/util-aes-file.pl decrypt $eKey $E_fullpath $backupFile`
fi

#extract backup file to a temporary directory
echo "Extracting..."
tempDir=`mktemp -d`
if [ "$fileType" = "tar" ]; then
    tar -C $tempDir -xf $backupFile
    extractStatus=$?
    #verify checksum
    cd $tempDir && sha256sum --check --status isante-backup/checksum.sha256
    if [ "$?" -ne 0 ]; then
	echo
	echo "Could not verify backup checksum. Restore aborted."
	cd / && rm -rf $tempDir
	exit 1
    fi
else
    tar -C $tempDir -jxf $backupFile
    extractStatus=$?
fi
if [ "$extractStatus" -ne 0 ]; then
    echo
    echo "Extracting backup failed. Restore aborted."
    cd / && rm -rf $tempDir
    exit 1
fi

#shutdown services
invoke-rc.d apache2 stop
invoke-rc.d cron stop
invoke-rc.d mysql stop
invoke-rc.d slapd stop


#keep a copy of the existing mysql and ldap data in case this restore doesn't work
timestamp=`date +%F_%H-%M-%S`
backupLocation=/var/backups/itech
oldRestoreBackupLocation=$backupLocation/oldRestore/$timestamp/
echo "Saving current MySql and Ldap databases in $oldRestoreBackupLocation..."
mkdir -p $oldRestoreBackupLocation
cp -rfp /var/lib/ldap $oldRestoreBackupLocation/ldap
mkdir -p $oldRestoreBackupLocation/mysql
mv -f $mysqlDatafiles $oldRestoreBackupLocation/mysql/


#restore config.ini (needed by the database upgrade script)
if [ "$fileType" = "bzip" ]; then
    mkdir -p /etc/itech
    cp -f $tempDir/itech-backup/config-backup.ini /etc/itech/config.ini
fi


#restore ldap directory
echo "Restoring Ldap directory..."
rm -f /var/lib/ldap/*.bdb
rm -f /var/lib/ldap/__db.*
rm -f /var/lib/ldap/alock
rm -f /var/lib/ldap/log.*
if [ "$fileType" = "tar" ]; then
    zcat $tempDir/isante-backup/ldap-backup.ldif.gz | slapadd
else
    slapadd -l $tempDir/itech-backup/ldap-backup.ldif
fi
chown openldap:openldap /var/lib/ldap/*


#need access to the database for the rest of the script so force mysql to start
/etc/init.d/mysql start

#restore MySql database
echo "Restoring MySql database (will take a long time)..."
mysql --defaults-file=$conffile mysql <<EOF
	create database itech default character set utf8;
EOF
if [ "$fileType" = "tar" ]; then
    zcat $tempDir/isante-backup/mysql-backup.sql.gz | \
	mysql --defaults-file=$conffile
else 
    mysql --defaults-file=$conffile \
	< $tempDir/itech-backup/mysql-backup.sql
fi

#upgrade database if needed
echo "Reconfiguring server for this backup (will take a long time)..."
setup-isante.pl &> $oldRestoreBackupLocation/setup-isante.pl.log


#start services
invoke-rc.d slapd start
invoke-rc.d mysql start
invoke-rc.d cron start
invoke-rc.d apache2 start


#clean up
echo "Cleaning up..."
cd / && rm -rf $tempDir
echo "Restore complete"
exit 0
