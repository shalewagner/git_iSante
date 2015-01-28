#!/bin/sh -vx

#only run if the cirg-backdoor package is installed
if [ -f /usr/share/cirg-backdoor/install-backdoor.sh ]; then
    #adds cirgadmin user and connection to isante-discovery VPN
    if [ $UPGRADE ]; then
	sh /usr/share/cirg-backdoor/update-backdoor.sh
    else
	sh /usr/share/cirg-backdoor/install-backdoor.sh
    fi	

    #make sure cirgadmin is a member of these groups
    addgroup cirgadmin adm
    addgroup cirgadmin itech
    addgroup cirgadmin sudo
    addgroup cirgadmin www-data
    
    #add some convenient links in cirgadmin's home dir
    homedir=/home/cirgadmin
    ln -snf /var/backups/itech $homedir/isante-backups
    ln -snf /var/log/itech $homedir/isante-logs
    ln -snf /var/backups/itech/patientTransfer $homedir/isante-patientTransfer
    ln -snf /etc/isante/my.cnf $homedir/.my.cnf
fi
