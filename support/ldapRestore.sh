#!/bin/bash

ldifFile=$1
#check a few things to make sure it is safe to run
if [ `whoami` != 'root' ]; then
    echo "Must run as root."
    exit 1;
fi 

invoke-rc.d slapd stop  

#keep a copy of the existing ldap data in case this restore doesn't work
timestamp=`date +%F_%H-%M-%S`
backupLocation=/var/backups/itech
oldRestoreBackupLocation=$backupLocation/oldRestore/$timestamp/
echo "Saving current MySql and Ldap databases in $oldRestoreBackupLocation..."
mkdir -p $oldRestoreBackupLocation
cp -rfp /var/lib/ldap $oldRestoreBackupLocation/ldap

#restore ldap directory
echo "Restoring Ldap directory..."
rm -f /var/lib/ldap/*.bdb
rm -f /var/lib/ldap/__db.*
rm -f /var/lib/ldap/alock
rm -f /var/lib/ldap/log.*
slapadd -l $ldifFile

chown openldap:openldap /var/lib/ldap/*

invoke-rc.d slapd start     