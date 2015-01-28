#!/bin/sh -vx

#add itech user on first install if it doesn't already exist
if [ ! $UPGRADE ]; then
    cat /etc/passwd | grep ^itech: -q
    if [ $? -ne 0 ]; then
	addgroup itech
	adduser --ingroup itech --disabled-password --gecos '' itech
	#must be run with LANG=C because expect relies on localized strings produced by passwd
	LANG=C /usr/bin/expect -f templates-output/itech-password
    fi
fi

#add itech user to these groups
addgroup itech adm
addgroup itech www-data

#add some convenient links in itech's home dir
homedir=/home/itech
ln -snf /var/backups/itech $homedir/isante-backups
ln -snf /var/log/itech $homedir/isante-logs
ln -snf /var/backups/itech/patientTransfer $homedir/isante-patientTransfer
ln -snf /etc/isante/my.cnf $homedir/.my.cnf

#remove symlinks that may have been created by accident
rm -f /var/backups/itech/itech /var/log/itech/itech /var/backups/itech/patientTransfer/patientTransfer
