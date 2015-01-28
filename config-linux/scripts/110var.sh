#!/bin/sh -vx

#this directory hold the output from the 10 minute job
mkdir -p /var/log/itech
chown itech:www-data /var/log/itech
chmod 771 /var/log/itech

#this directory holds the daily full database backups
mkdir -p /var/backups/itech
chown itech:itech /var/backups/itech
chmod 771 /var/backups/itech

#this directory holds patient transfer data
mkdir -p /var/backups/itech/patientTransfer/processed
chown -R itech:www-data /var/backups/itech/patientTransfer
chmod -R 771 /var/backups/itech/patientTransfer

#this directory holds fingerprint duplicates data
mkdir -p /var/backups/itech/fpDuplicateLogs/processed
chown -R itech:www-data /var/backups/itech/fpDuplicateLogs
chmod -R 771 /var/backups/itech/fpDuplicateLogs

#this directory holds encounter files data
mkdir -p /var/backups/itech/encounterFiles
chown itech:www-data /var/backups/itech/encounterFiles
chmod 771 /var/backups/itech/encounterFiles
