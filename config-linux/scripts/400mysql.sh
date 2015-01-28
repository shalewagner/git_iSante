#!/bin/sh -vx

#mysql server options
cp -f templates-output/mysql-options.cnf /etc/mysql/conf.d/itech-options.cnf
invoke-rc.d mysql restart

#mysql config file with hardcoded user/pass to make running mysql commands easy
cp -f templates-output/mysql-password.cnf /etc/isante/my.cnf
chown itech:www-data /etc/isante/my.cnf
chmod 440 /etc/isante/my.cnf

mysqlCommand='mysql --defaults-file=/etc/isante/my.cnf'

function setBackupEncryptionKey() {
    backupEncryptionKey=`pwgen -1s 12`
    (cd ../ && php setConfig-cli.php backupEncryptionKey $backupEncryptionKey)
}

if [ $UPGRADE ]; then
    #if upgrading then run any database upgrade scripts
    (cd ../ && sh support/upgrade-database.sh)

    if [[ $thisVersion =~ ^12\.3 ]]; then
	#before version 12.3 the backupEncryptionKey value was not used so set one here
	setBackupEncryptionKey
    fi
else
    #add mysql users for the application
    mysql -u root < templates-output/mysql-permissions.sql
    #create database
    mysql -u root << EOF
	create database itech default character set utf8;
EOF
    #add the schema
    $mysqlCommand < ../support/schema-tables.sql 
    #load functions
    $mysqlCommand < ../support/schema-user-functions/add-functions.sql
    #add views
    $mysqlCommand < ../support/schema-views.sql
    #initialize users/settings
    $mysqlCommand < templates-output/db-bootstrap.sql
    #load lookup tables
    (cd ../replication && perl updateTarget.pl --truncateTables --file lookups.csv.gz)
    #force splash to generate once so that the application looks correct on first use
    (cd ../ && php batch-jobs.php -f)
    #generate an encryption key for backup files
    setBackupEncryptionKey
fi

#remove any default mysql accounts
$mysqlCommand << EOF
drop user ''@'%';
EOF
$mysqlCommand << EOF
drop user 'root'@'127.0.0.1';
EOF
$mysqlCommand << EOF
drop user 'root'@'itech';
EOF
$mysqlCommand << EOF
drop user 'root'@'localhost';
EOF
