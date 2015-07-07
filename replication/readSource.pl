#!/usr/bin/perl -w

BEGIN {
    $main::isanteSource = $ENV{ISANTE_SOURCE} || '/usr/share/isante/htdocs';
    if (!scalar(stat($main::isanteSource))) {
        die('can not find iSanté source directory');
    }
    unshift(@INC, $main::isanteSource . '/replication');
}

use strict;
use warnings;
use utf8;
use feature 'switch';

use DBI;
use Digest::MD5 qw(md5_hex);
use Getopt::Long;

use Database;
use LocalConfig;
use ReplicationFile;

#values given from the command line
my $fileName = '';
my $lastModifiedDate = '';
my $restrictTo_PatientID = '';
my $restrictTo_PatientIdFile = '';
my $restrictTo_SiteCode = '';
my $deidentify = 0;
my $deidentifyMethod = 'null';
my $configFileName;
my $tableSet = 'replication';
my $readAll = 0;

#read command line parameters
if (!GetOptions(
	 'config:s' => \$configFileName,
	 'file=s' => \$fileName,
	 'date:s' => \$lastModifiedDate,
	 'patient:s' => \$restrictTo_PatientID,
	 'patientIdFile:s' => \$restrictTo_PatientIdFile,
	 'site:i' => \$restrictTo_SiteCode,
	 'deidentify' => \$deidentify,
	 'deidentifyMethod:s' => \$deidentifyMethod,
	 'tableSet:s' => \$tableSet,
	 'readAll' => \$readAll,
    )) {
    badCommandLine();
}

#date/time we started reading records from the db
my $startTime;
#the most recent encounter.lastModified date/time
my $mostRecentEncounterTime = "1970-01-01 00:00:00";


#used to interpret $lastModifiedDate
my $dateFormatDoc = "'yyyy-mm-dd hh:mm:ss'"; #human readable format for input date
my $dateFormatRegex = "^\'[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}\'\$";

#the tables to pull records from
my @tables = ();


#executed when a bad command line parameter is found
sub badCommandLine {
    printUsage();
    die "Bad command line argument or configuration file parameters missing.\n\n";
}

#print usage information to STDOUT
sub printUsage {
    print("
Program usage:
\treadSource.pl --file filename [--config configFile] [--date lastmodified] [--patient patientid] [--site siteCode] [--deidentify] [--deidentifyMethod {null|obfuscate}] [--tableSet tableSet] [--readAll]

\t--config\tNon-default config file (set this to the file's full path; default path [not required] is /etc/isante/my.cnf)
\t--file\t\tFilename for output (if the file name ends in .gz the the output will be compressed) 
\t--date\t\tGet all records updated on or after this date (the format must be \"$dateFormatDoc\")
\t--patient\tRestrict results to this patient (this parameter is a patientid)
\t--patientIdFile\tRead patient IDs from file and restrict to those patients (one patientid per line)
\t--site\t\tRestrict results to this sitecode (must be 5 numeric digits)
\t--deidentify\tWhen set identifying fields will be set according to deidentifyMethod
\t--deidentifyMethod\tnull means set identifiers to null, obfuscate means set identifiers to md5(identifier + random value based on patientID), defaults to null
\t--tableSet\t{replication, lookups, clinicLookup} Defaults to replication. What set of tables to read records from.
\t--readAll\tRead all records from each table without any where clause.

");
}

#returns undef if a field has identifying data in it
#otherwise returns the value of the field
{
    my %identifyingFields = (
	'adherenceCounseling' => {'pickupPersonName' => 1},
	'allowedDisclosures' => {'disclosureName' => 1},
	'buddies' => {'supportAccompName' => 1},
	'conditions' => {'conditionComment' => 1},
	'drugs' => {'reasonComments' => 1},
	'encounter' => {'encComments' => 1},
	'followupTreatment' => {'adherenceComments' => 1,
				'followupComments' => 1,},
	'householdComp' => {'householdName' => 1},
	'immunizations' => {'immunizationComment' => 1},
	'labMessageStorage' => {'message' => 1},
	'otherDrugs' => {'reasonComments' => 1},
	'patient' => {
	    'addrContact' => 1,
	    'addrDistrict' => 1,
	    'addrSection' => 1,
	    'addrTown' => 1,
	    'birthDistrict' => 1,
	    'birthSection' => 1,
	    'birthTown' => 1,
	    'contact' => 1,
	    'fname' => 1,
	    'fnameMother' => 1,
	    'homeDirections' => 1,
	    'lname' => 1,
	    'nationalID' => 1,
	    'occupation' => 1,
	    'phoneContact' => 1,
	    'telephone' => 1,
#	    'stID' => 1,
#	    'stid' => 1,
	},
	'referralLookup' => {'refName' => 1},
	'riskAssessments' => {'riskComment' => 1},
	'vitals' => {
	    'conditionComments' => 1,
	    'drugComments' => 1,
	    'treatmentComments' => 1,
	}
	);

    my $deidentifyRandom = rand();
    
    sub deidentify {
	my ($table, $record) = @_;
	if (defined $identifyingFields{$table}) {
	    while (my ($field, $value) = each(%$record)) {
		if (defined $identifyingFields{$table}->{$field}) {
		    if ($deidentifyMethod eq 'null') {
			$record->{$field} = undef;
		    } elsif ($deidentifyMethod eq 'obfuscate') {
			my $deidentifyKey = $deidentifyRandom;
			if (defined($record->{'patientID'})) {
			    $deidentifyKey = $deidentifyRandom . $record->{'patientID'};
			}
			$value = defined($value) ? $value : '';
			my $digest = md5_hex($value . $deidentifyKey);
			$digest =~ s/[a-f]//ig;
			$record->{$field} = substr($digest, 0, 8);
		    }
		}
	    }
	}
    }
}

#generates a prepared statement for retrieving records from a particular table
#uses command line arguments to define the where clause
sub getPreparedStatement {
    my ($dbHandle, $tableName) = @_;

    if ($readAll) {
	return $dbHandle->prepare("select * from $tableName");
    }

    my $sqlDateCondition = '';
    if ($lastModifiedDate eq '') {
	$sqlDateCondition = "1=1";
    } else {
	given ($tableName) {
	    when ('eventLog') {
		$sqlDateCondition = "eventDate >= $lastModifiedDate";
	    } when ('labMessageStorage') {
		$sqlDateCondition = "receiptDateTime >= $lastModifiedDate";
	    } when ('encounterQueue') {
		$sqlDateCondition = "lastStatusUpdate >= $lastModifiedDate";	    
	    } default {
		$sqlDateCondition = "(lastmodified >= $lastModifiedDate or lastmodified is null)";
	    }
	}
    }

    my $sql = '';
    my $sqlPatientCondition = '';
    my $sqlSiteCondition = '';
    given ($tableName) {
	when ('patient') {
	    if (! $restrictTo_PatientID eq '') {
		$sqlPatientCondition = "patientID = '$restrictTo_PatientID'";
	    } else {
		if (! $restrictTo_SiteCode eq '') {
		    $sqlSiteCondition = " AND sitecode = '$restrictTo_SiteCode'";
		}
		$sqlPatientCondition = "patientID IN (SELECT DISTINCT patientID FROM encounter WHERE $sqlDateCondition $sqlSiteCondition)";
	    }
	    $sql = "SELECT * FROM patient WHERE $sqlPatientCondition";
	} when ('encounter') {
	    if (! $restrictTo_PatientID eq '') {
		$sqlPatientCondition = " AND patientID = '$restrictTo_PatientID'";
	    } 
	    if (! $restrictTo_SiteCode eq '') {
	       $sqlSiteCondition = " AND siteCode = '$restrictTo_SiteCode'";
	    }
	    $sql = "SELECT * FROM encounter WHERE $sqlDateCondition $sqlSiteCondition $sqlPatientCondition";
	} when ('encounterQueue') {
	    if (! $restrictTo_PatientID eq '') {
		$sqlSiteCondition .= " AND 'a' = 'b'";
	    }
	    if (! $restrictTo_SiteCode eq '') {
		$sqlSiteCondition .= " AND siteCode = '$restrictTo_SiteCode'";
	    }
	    $sql = "SELECT * FROM encounterQueue WHERE $sqlDateCondition $sqlSiteCondition";
	} when ('eventLog') {
	    if (! $restrictTo_PatientID eq '') {
		$sqlSiteCondition .= " AND 'a' = 'b'";
	    }
	    if (! $restrictTo_SiteCode eq '') {
		$sqlSiteCondition .= " AND siteCode = '$restrictTo_SiteCode'";
	    }
	    $sql = "SELECT * FROM eventLog WHERE $sqlDateCondition $sqlSiteCondition";
	} when ('labMessageStorage') {
	    if ($restrictTo_SiteCode eq '' && $restrictTo_PatientID eq '') {
		$sql = "SELECT * FROM labMessageStorage WHERE $sqlDateCondition $sqlSiteCondition";
	    } else {
		#if we are restricting by site and/or patientId we have to get those values from labs and otherLabs
		if (! $restrictTo_PatientID eq '') {
		    $sqlPatientCondition .= " AND patientID = '$restrictTo_PatientID'";
		}
		if (! $restrictTo_SiteCode eq '') {
		    $sqlSiteCondition .= " AND siteCode = '$restrictTo_SiteCode'";
		}
		$sql = <<SQL;
select labMessageStorage.*
from labMessageStorage
join (select distinct *
      from (select dbSite, labMessageStorage_id
	    from labs
	    where labMessageStorage_id is not null $sqlPatientCondition $sqlSiteCondition
	    union
	    select dbSite, labMessageStorage_id
	    from otherLabs
	    where labMessageStorage_id is not null $sqlPatientCondition $sqlSiteCondition) allMatchedIds
) matchedIds using (dbSite, labMessageStorage_id)
where $sqlDateCondition
SQL
	    }
	} default {
	    if (! $restrictTo_PatientID eq '') {
		$sqlPatientCondition .= " AND e.patientID = '$restrictTo_PatientID'";
	    }
	    if (! $restrictTo_SiteCode eq '') {
		$sqlSiteCondition .= " AND e.siteCode = '$restrictTo_SiteCode'";
	    }
	    my $sqlEncounterMatchCondition = '';
	    if ($tableName eq 'obs') {
		$sqlEncounterMatchCondition = 
		    "e.encounter_id = t.encounter_id AND " .
		    "e.siteCode = t.location_id";
	    } else {
		$sqlEncounterMatchCondition = 
		    "e.siteCode = t.siteCode AND " .
		    "e.seqNum = t.seqNum AND " .
		    "e.visitdateDd = t.visitdateDd AND " .
		    "e.visitdateMm = t.visitdateMm AND " .
		    "e.visitdateYy = t.visitdateYy AND " .
		    "e.patientID = t.patientID";
	    }
	    $sql = "SELECT t.* FROM $tableName t, encounter e WHERE $sqlDateCondition AND $sqlEncounterMatchCondition $sqlPatientCondition $sqlSiteCondition";
	}
    }
    $dbHandle->prepare($sql);
}

#removes white space on the right side of a string
sub rtrim {
    my $string = shift;
    if (defined $string) {
	$string =~ s/\s+$//;
    }
    return $string;
}


#Program starts here

#if missing a required parameter
if ($fileName eq '') {
    badCommandLine();
}

#check $tableSet
if ($tableSet ne 'replication' && $tableSet ne 'lookups' && $tableSet ne 'clinicLookup') {
    die '--tableSet must be replication, lookups or clinicLookup';
}

#check date format
if (! $lastModifiedDate eq '') {
    if ($lastModifiedDate =~ m/$dateFormatRegex/ != 1) {
	die "Bad date. Format must be $dateFormatDoc.";
    }
}

#check format of restrictTo_PatientID if specified
if (! $restrictTo_PatientID eq '') {
    if ($restrictTo_PatientID =~ m/^[0-9]+$/ != 1) {
	die "Bad patient. Patient IDs are must be numeric digits only.";
    }
}

#can not have restrictTo_PatientID and restrictTo_PatientIdFile together
if ($restrictTo_PatientID ne '' && $restrictTo_PatientIdFile ne '') {
    die 'Can not use --patient and --patientIdFile together.';
}

#check format of restrictTo_SiteCode if specified
if (! $restrictTo_SiteCode eq '') {
    if ( ($restrictTo_SiteCode =~ m/^[0-9]+$/ != 1) || length($restrictTo_SiteCode) ne 5) {
	die "Bad sitecode. Sitecode must be exactly five numeric digits.";
    }
}

#check deidentifyMethod value
if ( ($deidentifyMethod ne 'null')
     && ($deidentifyMethod ne 'obfuscate') ) {
    die 'deidentifyMethod must be null or obfuscate';
}

given ($tableSet) {
    when ('replication') {
	@tables = (
	    'adherenceCounseling',
	    'allergies',
	    'allowedDisclosures',
	    'arvAndPregnancy',
	    'arvEnrollment',
	    'buddies',
	    'comprehension',
	    'conditions',
	    'discEnrollment',
	    'drugs',
	    'encounter',
	    'encounterQueue',
	    'eventLog',
	    'followupTreatment',
	    'homeCareVisits',
	    'householdComp',
	    'immunizations',
	    'labs',
	    'labMessageStorage',
	    'medicalEligARVs',
	    'needsAssessment',
	    'obs',
	    'otherDrugs',
	    'otherImmunizations',
	    'otherLabs',
	    'otherPrescriptions',
	    'patient',
	    'patientEducation',
	    'pedHistory',
	    'pedLabs',
	    'prescriptions',
	    'prescriptionOtherFields',
	    'referrals',
	    'riskAssessment',
	    'riskAssessments',
	    'symptoms',
	    'tbStatus',
	    'vitals',
	    );
    } when ('lookups') {
	@tables = (
	    'announcements',
	    'clinicLookup',
	    'concept',
	    'concept_class',
	    'concept_datatype',
	    'concept_name',
	    'conditionLookup',
	    'conditionOrder',
	    'cohortAsort',
	    'discReasonLookup',
	    'drugGroupLookup',
	    'drugLookup',
	    'drugVersionOrder',
	    'dw_merReportLookup',
	    'dw_dataqualityReportLookup',
	    'dw_malariaReportLookup',
	    'dw_nutritionReportLookup',
	    'dw_obgynReportLookup',
            'dw_measureForAgeLookup',
	    'dw_tbReportLookup',
            'dw_weightForHeightLookup',
	    'encTypeLookup',
	    'immunizationLookup',
	    'immunizationRendering',
	    'isanteConcepts',
	    'labelLookup',
	    'labGroupLookup',
	    'labLookup',
	    'labPanelLookup',
	    'nastadLookup',
	    'networkLookup',
	    'patientStatusLookup',
	    'pedLabsLookup',
	    'pedLabsRendering',
	    'queueStatusLookup',
	    'referralLookup',
	    'regimen',
	    'riskLookup',
	    'riskOrder',
	    'staticConcepts'
	    );
    } when ('clinicLookup') {
	@tables = (
	    'clinicLookup',
	    );
    }
}



#if a configFileName was specified load it, otherwise use the default
if (defined $configFileName) {
    LocalConfig::loadConfig($configFileName);
}

#connect to database (use currently loaded config file data)
my $dbHandle = Database::getNewDbHandle($configFileName);

#keep track of how many records were read
my $totalRecords = 0;
my %totalRecordsByType;
map {$totalRecordsByType{$_} = 0} @tables;
$startTime = time();

#get schema and application versions
my $schemaVersion = $dbHandle->selectrow_array("select max(version) from schemaVersion;");
if (!$schemaVersion) {
    die 'Could not read version from schemaVersion table.';
}
my $applicationVersion = `(cd $main::isanteSource && php -r "require_once 'backend/version.php'; print __getAppVersion();")`;
if ($? != 0) {
    die 'Could not get application version string.';
}


#@patientIdList hold a list of all patients to read data for, or '' if it should read for all patients
my @patientIdList = ('');
if ($restrictTo_PatientID ne '') {
    @patientIdList = ($restrictTo_PatientID);
}
if ($restrictTo_PatientIdFile ne '') {
    my $patientIdFile;
    open($patientIdFile, '<', $restrictTo_PatientIdFile) 
	or die 'cannot open patientId file.';

    @patientIdList = ();
    while (my $patientId = <$patientIdFile>) {
	chomp($patientId);
	if ($patientId =~ m/^[0-9]+$/ != 1) {
	    die "Bad patient. Patient IDs are must be numeric digits only.";
	}
	if ($patientId ne '') {
	    push @patientIdList, $patientId;
	}
    }
    
    close($patientIdFile);
}



#open output file
{
    my $dbSite = getConfig('dbsite');
    if (! defined($dbSite)) {
	die "Couldn't find configuration value for dbsite.\n";
    }

    my $headerExtras = {
	'version' => $applicationVersion,
	'schemaVersion' => $schemaVersion,
	'dbSite' => $dbSite,
	'tableSet' => $tableSet,
	'deidentify' => $deidentify ? 'True' : 'False',
    };
    if ($lastModifiedDate ne '') {
	$lastModifiedDate =~ /^'(.*?)'$/;
	$headerExtras->{'lastModifiedGE'} = $1;
    }
    if ($deidentify) {
	$headerExtras->{'deidentifyMethod'} = $deidentifyMethod;
    }
    ReplicationFile::open($fileName, '>', $headerExtras);
}

#send a query for each table and format and print each row to the output file
foreach my $patientId (@patientIdList) {
    $restrictTo_PatientID = $patientId;

    foreach my $table (@tables) {
	my $statementHandle = getPreparedStatement($dbHandle, $table);
	if (! $statementHandle) {
	    next;
	}
	if (! $statementHandle->execute) {
	    next;
	}
	while (my $rowref = $statementHandle->fetchrow_arrayref()) {
	    my %outputData;
	    for (my $i=0; $i < $statementHandle->{NUM_OF_FIELDS}; $i++) {
		my $field = $statementHandle->{NAME}->[$i];
		my $value = rtrim($rowref->[$i]);
		$outputData{$field} = $value;
	    }

	    if ($deidentify) {
		deidentify($table, \%outputData);
	    }
	    ReplicationFile::writeRecord($table, \%outputData);
	    
	    $totalRecords += 1;
	    $totalRecordsByType{$table} += 1;
	    
	    #update $mostRecentEncounterTime
	    if ( ($table eq 'encounter') && (defined $outputData{'lastModified'}) ) {
		if (! defined $mostRecentEncounterTime) {
		    $mostRecentEncounterTime = $outputData{'lastModified'};
		} else {
		    if ($mostRecentEncounterTime lt $outputData{'lastModified'}) {
			$mostRecentEncounterTime = $outputData{'lastModified'};
		    }
		}
	    }
	}
	$statementHandle->finish;
    }
}

$dbHandle->disconnect;
ReplicationFile::close();



#find the lower of the (greatest encounter time) or (startTime - 24 hours)
#the reason we subract 24 hours from startTime is to capture records that will be entered from all timezones
{
    my $startTimeString;
    my @timeParts = localtime($startTime - 24*60*60);
    $startTimeString = sprintf("%04d-%02d-%02d %02d:%02d:%02d",
			       $timeParts[5] + 1900, $timeParts[4] + 1, $timeParts[3],
			       $timeParts[2], $timeParts[1], $timeParts[0]);
    if ($mostRecentEncounterTime lt $startTimeString) {
		print "Most recent change: $mostRecentEncounterTime\n"; 
    } else {
		print "Most recent change: $startTimeString\n"; 
    }
}

print "Application version: $applicationVersion\n";
print "Schema version: $schemaVersion\n";

#print a small timing report
my $duration = time() - $startTime;
print "Seconds elapsed: $duration\n";
print "Total records read: $totalRecords\n";
if ($duration == 0) {
    $duration = 1;
}
print "Records per second: " . (($totalRecords/$duration) . "\n\n");
print "Record counts by table:\n";
foreach my $table (@tables) {
    printf("%-25s%6d\n", $table, $totalRecordsByType{$table});
}

exit();
