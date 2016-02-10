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

# backup only tables that cannot be restored as empty table definitions (the data warehouse tables and any temp tables in the database)
TABLES="adherenceCounseling allergies allowedDisclosures arvAndPregnancy arvEnrollment buddies clinicLookup cohort cohortAsort cohortTable comprehension concept concept_class concept_datatype concept_name conditionLookup conditionOrder conditions config discEnrollment discReasonLookup drugGroupLookup drugGroupVersionOrder drugLookup drugVersionOrder drugs dw_dataqualityReportLookup dw_malariaReportLookup dw_measureForAgeLookup dw_merReportLookup dw_nutritionReportLookup dw_obgynReportLookup dw_tbReportLookup dw_weightForHeightLookup eligibility encTypeLookup encounter encounterOtherFields encounterQueue followupTreatment formErrors homeCareVisits householdComp immunizationLookup immunizationRendering immunizations labGroupLookup labLookup labPanelLookup labelLookup labs lastJobRun maxPatientID medicalEligARVs needsAssessment obs otherDrugs otherImmunizations otherLabs otherPrescriptions patient patientEducation patientStatusLookup pedHistory pedLabs pedLabsLookup pedLabsRendering prescriptionOtherFields prescriptions queueStatusLookup referralLookup referrals regimen riskAssessment riskAssessments riskLookup riskOrder schemaVersion siteAccess startARV symptoms tbStatus tmpNxtDate userPrivilege validations vitals"
# use the --opt flag so that tables are written row by row instead of buffered in memory, which seems to cause dump failures
mysqldump --defaults-file=$conffile --opt $database $TABLES 2> /dev/null | gzip > $tempDir/$backupDir/mysql-backup.sql.gz

#ldap
slapcat | gzip > $tempDir/$backupDir/ldap-backup.ldif.gz

#checksum
cd $tempDir && sha256sum --binary $backupDir/mysql-backup.sql.gz $backupDir/ldap-backup.ldif.gz > $tempDir/$backupDir/checksum.sha256

#package them up
cd $tempDir && tar cf $backupArchiveFileName $backupDir/checksum.sha256 $backupDir/ldap-backup.ldif.gz $backupDir/mysql-backup.sql.gz 

#encrypt the backup file using util-aex-file.pl
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
