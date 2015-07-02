#!/bin/sh

if [ `whoami` != 'root' ]; then
    echo "Must run as root."
    exit 1;
fi

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

#this script gets run from cron so we can't assume a good PATH
PATH="/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/X11R6/bin"
export PATH=$PATH

#backup files get placed here
backupLocation=/var/backups/itech
database=$(parseini database)
timestamp=`date +%F_%H-%M-%S`
tempDir=`mktemp -d`
backupDir=isante-backup
backupArchiveFileName=isante-backup-$timestamp-d$(getConfig dbsite)s$(getConfig defsitecode).tar

#generate the files
mkdir $tempDir/$backupDir

#mysql (don't back up tables that are recomputed every day/do the biggest tables first in the backup)
TABLES="eventLog prescriptions arvEnrollment arvAndPregnancy encounter patientEducation labs comprehension tbStatus pedHistory buddies prescriptionOtherFields needsAssessment discEnrollment followupTreatment homeCareVisits vitals medicalEligARVs drugs riskAssessments otherPrescriptions eligibility otherDrugs conditions patient allowedDisclosures householdComp bloodeval1 cohortTable immunizations labMessageStorage encounterQueue symptoms pedLabs siteAccess otherLabs concept_name otherImmunizations concept dw_measureForAgeLookup isanteConcepts staticReportData allergies clinicLookup labLookup dw_weightForHeightLookup bloodeval2 conditionLookup userPrivilege conditionOrder referrals dw_malariaReportLookup pepfarRecords regimen healthQual drugLookup riskOrder drugVersionOrder nastadLookup dw_tbReportLookup labPanelLookup networkLookup riskLookup announcements encTypeLookup immunizationRendering dw_dataqualityReportLookup cohortAsort referralLookup concept_class dw_obgynReportLookup schemaVersion discReasonLookup dw_nutritionReportLookup labGroupLookup immunizationLookup concept_datatype patientStatusLookup drugGroupLookup queueStatusLookup config pedLabsLookup pedLabsRendering lastJobRun encounterOtherFields validVitals validations isanteForms hivQual labelLookup drugGroupVersionOrder dw_hivstatusReportLookup startARV cohort formErrors maxPatientID"
mysqldump --defaults-file=$conffile --add-drop-table --skip-extended-insert --skip-quick $database $TABLES 2> /dev/null \
| gzip > $tempDir/$backupDir/mysql-backup.sql.gz

#ldap
slapcat | gzip > $tempDir/$backupDir/ldap-backup.ldif.gz

#checksum
cd $tempDir && sha256sum --binary $backupDir/mysql-backup.sql.gz $backupDir/ldap-backup.ldif.gz > $tempDir/$backupDir/checksum.sha256

#package them up
cd $tempDir && tar cf $backupArchiveFileName $backupDir/checksum.sha256 $backupDir/ldap-backup.ldif.gz $backupDir/mysql-backup.sql.gz 

#encrypt the backup file using util-aex-file.pl
#commented out line should only be used for testing on sodium (unorthodox path)
#`perl /home/websites/haiti-dev.cirg.washington.edu/steve/replication/util-aes-file.pl encrypt $(getConfig backupEncryptionKey) $tempDir/$backupArchiveFileName $tempDir/E_$backupArchiveFileName`
`perl /var/www/isante/replication/util-aes-file.pl encrypt $(getConfig backupEncryptionKey) $tempDir/$backupArchiveFileName $tempDir/E_$backupArchiveFileName`

chown itech:itech $tempDir/E_$backupArchiveFileName
chmod o-rwx $tempDir/E_$backupArchiveFileName
mv $tempDir/E_$backupArchiveFileName $backupLocation
rm -rf $tempDir

#clean up and copy files to any USB drives
find $backupLocation -name "E_isante-backup-*.tar" -mtime +28 -type f -delete
find $backupLocation -name "isante-backup-*.tar" -mtime +28 -type f -delete
find $backupLocation -name "itech-backup-*.tar.bz2" -mtime +28 -type f -delete

for usbDir in `grep media/usb /proc/mounts | cut -f 2 -d ' '`; do
  cp -f $backupLocation/E_$backupArchiveFileName $usbDir
  find $usbDir -name "E_isante-backup-*.tar" -mtime +28 -type f -delete
  find $usbDir -name "isante-backup-*.tar" -mtime +28 -type f -delete
  find $usbDir -name "itech-backup-*.tar.bz2" -mtime +28 -type f -delete
done

for tapeDev in `ls /dev/st[0-9] 2> /dev/null`; do
    mt -f $tapeDev status &> /dev/null
    if [ $? -eq 0 ]; then
	mt -f $tapeDev rewind
	cat $backupLocation/E_$backupArchiveFileName > /dev/st0
	mt -f $tapeDev rewind
    fi
done

sync
