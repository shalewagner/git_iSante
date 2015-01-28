#!/bin/sh

#must be executed in the iSante source root

conffile=/etc/isante/my.cnf

if [ ! -f "$conffile" ]; then
    echo "Must run setup-isante.pl first."
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

function setBackupEncryptionKey() {
    backupEncryptionKey=`pwgen -1s 12`
    `php setConfig-cli.php backupEncryptionKey $backupEncryptionKey`
}

php -r "require_once 'backend/database-upgrade.php'; applyDbUpgrade();"
# set encryption key if not already set

eKey=$(getConfig backupEncryptionKey) 
if [ "$eKey" = "" ]; then 
	setBackupEncryptionKey
fi
