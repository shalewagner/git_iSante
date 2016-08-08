#!/usr/bin/perl -w

BEGIN {
    $main::isanteSource = $ENV{ISANTE_SOURCE} || '/usr/share/isante/htdocs';
#    $main::isanteSource = '/Volumes/halfTera/Users/dad/git_iSante';
    if (!scalar(stat($main::isanteSource))) {
        die('can not find iSanté source directory');
    }
    unshift(@INC, $main::isanteSource . '/replication');
}

use strict;
use warnings;
use utf8;
use feature 'switch';

use Data::Dumper;
use DBI;
use Getopt::Long;
use List::Util qw(reduce);

use Database;
use LocalConfig;
use ReplicationFile;
use ModifyRecord;
use TableInfo;

#command line parameter values
#data file to apply
my $fileName;

#config file to read db name, user name and password from
my $configFileName;

#set to 1 if the file should not have any records with dbSite of 0
#only files from server itech should have these kinds of records
my $noDbSiteZero = 0;

#set to target sitecode when transferring a patient's data from another site
#could be obtained from the filename of the file used to transfer the data (i.e. transferxxxxToYYYYY.csv.gz. where YYYYY is the sitecode)
#currently passed as a command line value
my $transferSite = '';

#set to stid provided by RIO when doing a patient import (transfer in)
my $stID = '';

#we will be generating a new patientid if this is a transfer (location_id + person_id concatenated together = patientid from 7.0 on)
my $newPatientID = '';
my $person_id = 0;
my $location_id = 0;

#set to 1 if tables should be truncated before inserting any records
my $truncateTables = 0;

#read values from the command line
if (!GetOptions(
	 'config:s' => \$configFileName,
	 'file=s' => \$fileName,
	 'noDbSiteZero' => \$noDbSiteZero,
	 'transferSite:i' => \$transferSite,
	 'stID:s' => \$stID,
	 'truncateTables' => \$truncateTables,
    )) {
    badCommandLine();
}

#if required parameters are missing
if (! defined $fileName) {
    badCommandLine();
}
if ( ($transferSite eq '') xor ($stID eq '') ) {
    badCommandLine();
}

#hash to hold timing info for different parts of the script
my %timings;
$timings{'scriptStart'} = time;

sub printUsage {
    print("
Program usage:
\tupdateTarget.pl --file dataFileName [--config configFilePath] [--noDbSiteZero] [--transferSite sitecode --stID stid] [--truncateTables]
\t--config\tConfig file (set this to the file's full path; default path is: /etc/isante/my.cnf )
\t--file\t\tFilename for input (.csv or .csv.gz)
\t--noDbSiteZero\tQuit if records with dbSite of 0 are found
\t--transferSite\tNew sitecode for patient being transferred (must be 5 numeric digits, stID must also be provided)
\t--stID\t\tST-ID for patient transferring in to a site (transferSite must also be provided) 
\t--truncateTables\ttruncate all data from a table before inserting the first record
");
}

sub badCommandLine {
    printUsage();
    die "Bad command line argument or configuration file parameters missing.\n\n";
}


{
    #see rebuildIndexes.php for the authoritative list
    my @logicalKeyFieldNames = (
				'sitecode', 'patientid', 'location_id', 'person_id', 
				'visitdatedd', 'visitdatemm', 'visitdateyy', 'seqNum',
				'allergySlot', 'referral', 'conditionID', 'disclosureSlot',
				'drugID', 'drugName', 'drug', 'drugSlot', 'rxSlot',
				'encounterType', 'householdSlot', 'immunizationID', 'immunizationSlot',
				'labID', 'labSlot', 'pedlabsID', 'pedlabsSlot', 'reasonID', 'riskID'
				);
    my %logicalKeyFieldNames;
    map { $logicalKeyFieldNames{lc($_)}=1 } @logicalKeyFieldNames;

    sub getLogicalKeyFields {
	my $tableName = shift;
	my @fieldList = @_;

	given ($tableName) {
	    when ('patient') {
		return ('patientID');
	    } when ('encounterQueue') {
		return ('sitecode', 'encounter_id', 'dbSite');
	    } when ('eventLog') {
		return ('eventLog_id', 'siteCode', 'username', 'eventDate');
	    } when ('labMessageStorage') {
		return ('labMessageStorage_id', 'senderName', 'senderSiteCode', 'originalXmitDateTime');
	    } default {
		my @keyFieldList;
		foreach my $field (@fieldList) {
		    if (defined($logicalKeyFieldNames{lc($field)})) {
			push(@keyFieldList, $field);
		    }
		}
		return sort(@keyFieldList);
	    }
	}
    }
}

sub getIdField {
    my $tableName = shift;
    if ($tableName eq 'patient') {
	return 'person_id';
    } else {
	return $tableName . '_id';
    }
}

{
    my %deletePSs = (); #cache prepared statements for deleting

    my %preDeleteTables = (
	allergies => 1,
	allowedDisclosures => 1,
	conditions => 1,
	drugs => 1, 
	encounterQueue => 1,
	eventLog => 1,
	householdComp => 1,
	labs => 1,
	labMessageStorage => 1,
	obs => 1,
	otherDrugs => 1,
	otherLabs => 1,
	otherPrescriptions => 1,
	pedLabs => 1,
	prescriptions => 1,
	referrals => 1,
	riskAssessments => 1,
	);

    my $deleteWhereFields = [
			     'siteCode',
			     'patientID',
			     'visitDateDd', 'visitDateMm', 'visitDateYy',
			     'seqNum',
			     ];

    my %deleteWhereFieldsTable = (
	'encounterQueue' => ['sitecode', 'encounter_id', 'dbSite'],
	'eventLog' => ['eventLog_id', 'dbSite'],
	'labMessageStorage' => ['labMessageStorage_id', 'dbSite'],
	'obs' => ['person_id', 'encounter_id', 'location_id'],
	);
    
    sub preDeleteRecord {
	my ($dbHandle, $tableName, $fieldHash) = @_;
	
	if (defined $preDeleteTables{$tableName}) {
	    my $whereFields;
	    if (defined($deleteWhereFieldsTable{$tableName})) {
		$whereFields = $deleteWhereFieldsTable{$tableName};
	    } else {
		$whereFields = $deleteWhereFields;
	    }
	    
	    if (! defined(getTableInfo($tableName, 'deletePS'))) {
		my $sql = 'delete from ' . $dbHandle->quote_identifier($tableName) . ' where ';
		my $sqlCondition = reduce {"$a AND $b"} map("$_ = ?" , @$whereFields);
		$sql = $sql . $sqlCondition;
		recordTableInfo($tableName, 'deleteSQL', $sql);
		recordTableInfo($tableName, 'deletePS', $dbHandle->prepare($sql));
	    }
	    
	    my $deletePS = getTableInfo($tableName, 'deletePS');
	    my $numRows = $deletePS->execute(map {$fieldHash->{$_}} @$whereFields);
	    if ($numRows > 0) {
		incrementTableInfo($tableName, 'preDeleteC', $numRows);
	    }
	}
    }
}

sub createPatient {
	my ($dbHandle, $tableName, $fieldHash) = @_;
	# remove fields that are generated for the patient at the transfer site
	delete $fieldHash->{'patientID'};
	delete $fieldHash->{'person_id'};	
	# apply adjusted values for the patient at the transfer site
	$fieldHash->{'location_id'} = "$transferSite";
	$fieldHash->{'clinicPatientID'} = "$stID";
	$fieldHash->{'stid'} = "$stID";
	$fieldHash->{'stid'} =~ s/\D//g;
	$fieldHash->{'patStatus'} = 0;
	my $insertFieldNames = '(';
	my $insertFieldValues = '(';
	my $first = 0;
	foreach my $key (keys(%$fieldHash)) {
		if (defined $fieldHash->{$key}) {
			if ($first == 0) {
				$first = 1;
			} else {
				$insertFieldNames .= ",";
				$insertFieldValues .= ",";
			}
			$insertFieldNames .= "$key";
			$insertFieldValues .= "'$fieldHash->{$key}'" ;
		}
	}
	$insertFieldNames .= ')';
	$insertFieldValues .= ')';
	print "\ninsert into patient $insertFieldNames values $insertFieldValues\n";
	$dbHandle->begin_work;
	my $numRows = $dbHandle->do("insert into patient $insertFieldNames values $insertFieldValues");
	if ($numRows == 1) {
	        $numRows = $dbHandle->do("update patient set patientid = concat('$transferSite',last_insert_id()) where person_id = last_insert_id() and location_id = $transferSite");
		if ($numRows == 1) {
			$dbHandle->commit;
			my $Sql = "SELECT last_insert_id() as 'foo'";
			my $lastIDrow = $dbHandle->selectrow_hashref($Sql);
			$person_id = $lastIDrow->{'foo'};
			print "\nupdate patient set patientid = '$transferSite$person_id' where location_id = $transferSite and person_id = $person_id\n";
		} else {
			print "update of patient did not work";
			$dbHandle->rollback;
			exit;
		}
		$newPatientID = "$transferSite$person_id";
		print "\n\n newPatientID = $newPatientID\n\n";
	} else {
		print "insert of patient did not work";
		$dbHandle->rollback;
		exit;
	}
}

sub updateRecord {
    my ($dbHandle, $tableName, $fieldHash) = @_;
    if (! $transferSite eq '') {
	if (defined$fieldHash->{getIdField($tableName)}) {delete $fieldHash->{getIdField($tableName)};}
    }
    my @fieldHashKeys;
    my $tableIDField;

    if (! defined(getTableInfo($tableName, 'tableNameSafe'))) { #only need to do this once per table
	recordTableInfo($tableName, 'tableNameSafe', $dbHandle->quote_identifier($tableName));
	@fieldHashKeys = @{recordTableInfo($tableName, 'fieldHashKeys', [sort(keys %$fieldHash)])};
	$tableIDField = recordTableInfo($tableName, 'tableIDField', getIdField($tableName));
	recordTableInfo($tableName, 'tableIDFieldSafe',	$dbHandle->quote_identifier($tableIDField));
	recordTableInfo($tableName, 'logicalKeyFieldList',
			[getLogicalKeyFields($tableName, @fieldHashKeys)]);
	recordTableInfo($tableName, 'updatableFields', [grep {$_ ne $tableIDField} @fieldHashKeys]);
    }
	
    my $tableNameSafe = getTableInfo($tableName, 'tableNameSafe');
    @fieldHashKeys = @{getTableInfo($tableName, 'fieldHashKeys')};
    $tableIDField = getTableInfo($tableName, 'tableIDField');
    my $tableIDFieldSafe = getTableInfo($tableName, 'tableIDFieldSafe');
    my @logicalKeyFieldList = @{getTableInfo($tableName, 'logicalKeyFieldList')};
    my @updatableFields = @{getTableInfo($tableName, 'updatableFields')};
    
    if (! defined(getTableInfo($tableName, 'insertPS'))) { #only need to do this once per table
	my $sqlSiteConditionPS;
	if ( ($tableName eq 'patient')
	     || ($tableName eq 'obs') ) {
	    $sqlSiteConditionPS = '1=1';
	} else {
	    $sqlSiteConditionPS = 'dbSite = ?';
	}
    
	my $sqlLogicalKeyConditionPS = reduce {"$a AND $b"} map("$_ = ?", @logicalKeyFieldList);
	$sqlLogicalKeyConditionPS = defined($sqlLogicalKeyConditionPS) ? $sqlLogicalKeyConditionPS : '';
	my $insertFieldNamesPS = '(' . (reduce {"$a, $b"} 
				      map($dbHandle->quote_identifier($_), @fieldHashKeys)) . ')';
	my $insertFieldParamsPS = '(' . (reduce {"$a, $b"} map('?', @fieldHashKeys)) . ')';
	my $updateFieldsPS = reduce {"$a, $b"} map($dbHandle->quote_identifier($_) . ' = ?',
						   @updatableFields);

	recordTableInfo($tableName, 'insertSQL',
			"INSERT INTO $tableNameSafe $insertFieldNamesPS VALUES $insertFieldParamsPS");
	recordTableInfo($tableName, 'update1SQL',
			"UPDATE $tableNameSafe SET $updateFieldsPS WHERE $sqlSiteConditionPS AND "
			. $sqlLogicalKeyConditionPS);
	recordTableInfo($tableName, 'update2SQL',
			"UPDATE $tableNameSafe SET $updateFieldsPS WHERE $sqlSiteConditionPS AND "
			. $tableIDFieldSafe . " = ?");

	recordTableInfo($tableName, 'insertPS',
			$dbHandle->prepare(getTableInfo($tableName, 'insertSQL')));
	recordTableInfo($tableName, 'update1PS',
			$dbHandle->prepare(getTableInfo($tableName, 'update1SQL')));
	recordTableInfo($tableName, 'update2PS',
			$dbHandle->prepare(getTableInfo($tableName, 'update2SQL')));
    }

    my $insertPS = getTableInfo($tableName, 'insertPS');
    my $update1PS = getTableInfo($tableName, 'update1PS');
    my $update2PS = getTableInfo($tableName, 'update2PS');

#bind this record's parameters to the prepared statements for this table
    #parameters for insert statement
    my @insertPsValues = map {$fieldHash->{$_}} @fieldHashKeys;

    #parameters for update matching logical keys
    my @update1PsValues = map {$fieldHash->{$_}} @updatableFields;
    #parameters in the where clause
    if ( ($tableName ne 'patient')
	 && ($tableName ne 'obs') ) {
	push @update1PsValues, $fieldHash->{'dbSite'};
    }
    push @update1PsValues, map {$fieldHash->{$_}} @logicalKeyFieldList;
    
    #parameters for update matching *_id key
    my @update2PsValues = map {$fieldHash->{$_}} @updatableFields;
    #parameters in the where clause
    if ( ($tableName ne 'patient')
	 && ($tableName ne 'obs') ) {
	push @update2PsValues, $fieldHash->{'dbSite'};
    }
    push @update2PsValues, $fieldHash->{$tableIDField};


#execute prepared statements in order until one is a success
    my $insertCount = $insertPS->execute(@insertPsValues);
    if ( (defined $insertCount) && ($insertCount == 1) ) {
	incrementTableInfo($tableName, 'insertC', 1);
    } else { #insert failed
	my $insertErrorString = $insertPS->errstr;
#=pod
	my $update1Count = $update1PS->execute(@update1PsValues);
	if ( (defined $update1Count) && ($update1Count == 1) ) {
	    incrementTableInfo($tableName, 'update1C', 1);
	} else { #update1 failed
	    my $update1ErrorString = $update1PS->errstr;
	    my $update2Count = $update2PS->execute(@update2PsValues);
	    if ( (defined $update2Count) && ($update2Count == 1) ) {
		incrementTableInfo($tableName, 'update2C', 1);
	    } else { #update2 failed
		my $update2ErrorString = $update2PS->errstr;
		#if we get a blank error here assume it is ok but mark it as unknown
		if ($update2ErrorString eq '') {
		    incrementTableInfo($tableName, 'unknownC', 1);
		} else {
#=cut
		    incrementTableInfo($tableName, 'errorC', 1);
		    print "Couldn't insert/update record.\n";
		    print "INSERT ERROR: $insertErrorString\n";
		    print getTableInfo($tableName, 'insertSQL') . "\n";
		    print "UPDATE1 ERROR: $update1ErrorString\n";
		    print getTableInfo($tableName, 'update1SQL') . "\n";
		    print "UPDATE2 ERROR: $update2ErrorString\n";
		    print getTableInfo($tableName, 'update2SQL') . "\n";
		    print Dumper($fieldHash);
		    print "\n\n\n";
#=pod
		}
	    }
	}
#=cut
    }
}

#Program starts execution here.

#load the configuration file's data if passed on the command line
if (defined $configFileName) {
    LocalConfig::loadConfig($configFileName);
}

#connect to database (use currently loaded config file data)
my $dbh = Database::getNewDbHandle($configFileName);

#Get application and schema version for this replication file.
#Verify that the replication schema version is <= that of the database.
my $applicationVersion = undef;
my $schemaVersion = undef;
{
    ReplicationFile::open($fileName, '<');

    if (ReplicationFile::readHeader('version')) {
	$applicationVersion = ReplicationFile::readHeader('version');
    } else {
	#replication files prior to 9.0 RC1 didn't have a header so try and get the version from the report file
	my $reportFileName = $fileName . '-report.txt';
	my $reportFile;
	my $reportFileOpen = 
	    open($reportFile, '<', $reportFileName) or print "Can't open report file.\n";
	if (defined $reportFileOpen) {
	    my $versionString = <$reportFile>; #read first line
	    $versionString = <$reportFile>; #read second line
	    $versionString =~ /Installation version: (.*)/;
	    $applicationVersion = $1;
	    close($reportFile);
	} else {
	    die 'Could not get application version from file header or report file.';
	}
    }

    if (ReplicationFile::readHeader('schemaVersion')) {
	$schemaVersion = ReplicationFile::readHeader('schemaVersion') + 0;
    } else {
	#versions <= 9.0RC3 did not include schemaVersion so figure it out from the application version
	my %versionMap = ('7.0 RC1' => 19,
			  '7.0 RC2' => 20,
			  '8.0 RC1' => 21,
			  '8.0 RC2' => 23,
			  '9.0 RC1' => 25,
			  '9.0 RC2' => 26,
			  '9.0 RC3' => 27);
	if (defined($versionMap{$applicationVersion})) {
	    $schemaVersion = $versionMap{$applicationVersion};
	} else {
	    die 'Could not get schema version from application version.';
	}
    }

    ReplicationFile::close();

    #Find the schema version of the current database.
    my $databaseSchemaVersion = $dbh->selectrow_array('select max(version) from schemaVersion;');
    if (!defined($databaseSchemaVersion)) {
	die 'Could not get current database schema version number.';
    }

    #Find the schema version of the application.
    my $applicationSchemaVersion;
    {
	my @schemaUpgradeFiles = sort(glob($main::isanteSource . '/support/schema-updates/[0-9]*-*.sql'));
	my $newestSchemaUpgradeFile = pop(@schemaUpgradeFiles);
	if (!defined($newestSchemaUpgradeFile)) {
	    die 'Could not find application schema version number';
	}
	if ($newestSchemaUpgradeFile =~ /support\/schema-updates\/([0-9]+)-.*?\.sql$/) {
	    $applicationSchemaVersion = $1;
	} else {
	    die 'Could not find application schema version number';
	}
    }

    #Make sure the application and database schema versions match.
	
    if ($databaseSchemaVersion != $applicationSchemaVersion) {
	print "App Version: " . $applicationSchemaVersion . " DB Version: " . $databaseSchemaVersion . "\n";
	die 'Application and database schema versions do not match.';
    }

    #Make sure the replication file schema version is not for a future version.
    if ($schemaVersion > $applicationSchemaVersion) {
	die 'Replication file is from a newer version of iSanté.';
    }
}

#PASS truncate
if ($truncateTables) {
    #key is a table name if a record from that table has been processed by pass1
    my %seenTables = ();

    ReplicationFile::open($fileName, '<');
    while (my @record = ReplicationFile::readRecord()) {
	if (! defined $record[0]) {last;}
	my ($origTableName, $origFieldHash) = @record;
	if (!defined($seenTables{$origTableName})) {
	    $seenTables{$origTableName} = 1;
	    $dbh->do("truncate table $origTableName");
	}
    }
    ReplicationFile::close();
}

#this must be done after the truncate pass
#load clinicPatientId values for current patients
initClinicPatientIdMap($dbh);

#PASS transfer
#if this is a patient transfer pass, get the patient record and create a new patient so we have the correct id for all other encounters
if ($transferSite ne '') {
    ReplicationFile::open($fileName, '<');
    while (my @record = ReplicationFile::readRecord()) {
	if (! defined $record[0]) {last;}
	my ($origTableName, $origFieldHash) = @record;
	if ($origTableName eq 'patient') {
	    map {
		my ($tableName, $fieldHash) = @{$_};
		createPatient($dbh, $tableName, $fieldHash);
	    } @{allRecordModifications($dbh, $schemaVersion, $origTableName, $origFieldHash)};
	    last;
	}
    }
    ReplicationFile::close();
}

#PASS 1
#for allRecordModifications to work properly we need to have all the encounter records loaded
$timings{'pass1Start'} = time;
ReplicationFile::open($fileName, '<');
while (my @record = ReplicationFile::readRecord()) {
    if (! defined $record[0]) {last;}
    my ($origTableName, $origFieldHash) = @record;
    if ($origTableName eq 'encounter') {
	if (!$transferSite eq '') {
	    if (defined$origFieldHash->{'siteCode'}) {
		#change sitecode before doing allRecordModifications
		$origFieldHash->{'siteCode'} = $transferSite;
	    }
	    if (defined$origFieldHash->{'patientID'}) {
		#change patientid before doing allRecordModifications
		$origFieldHash->{'patientID'} = $newPatientID;
	    }
	    (my $day, my $month, my $year) = (localtime)[3,4,5];
	    my $mTime = sprintf("%04d-%02d-%02d", $year+1900, $month+1, $day);
	    if (defined$origFieldHash->{'lastModified'}) {
		#change lastModified before doing allRecordModifications
		$origFieldHash->{'lastModified'} = $mTime;
	    }
	}
	map {
	    my ($tableName, $fieldHash) = @{$_};
	    if (!$transferSite eq '') {
		if (defined $fieldHash->{'siteCode'}) {$fieldHash->{'siteCode'} = $transferSite;}
		if (defined $fieldHash->{'patientID'}) {$fieldHash->{'patientID'} = $newPatientID;}
	    }
	    updateRecord($dbh, $tableName, $fieldHash);
	} @{allRecordModifications($dbh, $schemaVersion, $origTableName, $origFieldHash)};
    }
}
ReplicationFile::close();

#PASS 2
#some tables need records deleted before they are updated
$timings{'pass2Start'} = time;
ReplicationFile::open($fileName, '<');
while (my @record = ReplicationFile::readRecord()) {
    if (! defined $record[0]) {last;}
    my ($origTableName, $origFieldHash) = @record;

    map {
	my ($tableName, $fieldHash) = @{$_};

	if ($noDbSiteZero) {
	    if ( (exists($fieldHash->{'dbSite'})) && ($fieldHash->{'dbSite'} eq '0') ) {
		die "Found record with dbSite of 0 but --noDbSiteZero parameter was given.\n";
	    }
	}
	
	preDeleteRecord($dbh, $tableName, $fieldHash);
    } @{allRecordModifications($dbh, $schemaVersion, $origTableName, $origFieldHash)};
}
ReplicationFile::close();

#PASS 3
#apply replication data, gather a unique list of siteCodes
$timings{'pass3Start'} = time;
my %uniqueSiteCodes = ();
ReplicationFile::open($fileName, '<');
while (my @record = ReplicationFile::readRecord()) {
    if (! defined $record[0]) {last;}
    my ($origTableName, $origFieldHash) = @record;
    if ($origTableName eq 'encounter') {next;} #encounter records loaded in PASS 1
    if ($origTableName eq 'patient' and ! $transferSite eq '') {next;}#patient record loaded in PASS 0
    map {
	my ($tableName, $fieldHash) = @{$_};
	if (!$transferSite eq '') {
		if (defined $fieldHash->{'siteCode'}) {$fieldHash->{'siteCode'} = $transferSite;}
		if (defined $fieldHash->{'patientID'}) {$fieldHash->{'patientID'} = $newPatientID;}
	}
	if ( (defined $fieldHash->{'siteCode'}) && ($fieldHash->{'siteCode'} ne '') ) {
	    $uniqueSiteCodes{$fieldHash->{'siteCode'} + 0} = 1;
	}
	if ( (defined $fieldHash->{'location_id'}) && ($fieldHash->{'location_id'} ne '') ) {
	    $uniqueSiteCodes{$fieldHash->{'location_id'} + 0} = 1;
	}

	updateRecord($dbh, $tableName, $fieldHash);
    } @{allRecordModifications($dbh, $schemaVersion, $origTableName, $origFieldHash)};
}
ReplicationFile::close();
$timings{'pass3End'} = time;


#update the siteCode column in the clinicLookup table with the correct version number
if (!$truncateTables && $transferSite eq '') {
    foreach my $siteCode (keys %uniqueSiteCodes) {
	$dbh->do("update clinicLookup set dbVersion = ? where siteCode = ?",
		 undef, $applicationVersion, $siteCode);
    }
}

#disconnect from database
$dbh->disconnect;

#print a summary of what happend
my $duration = time() - $timings{'scriptStart'};
print "$duration seconds elapsed\n";
print "total records processed\n";
print Dumper(getTableInfoTotalsByKeys('preDeleteC', 'insertC', 'update1C', 'update2C', 
				      'unknownC', 'errorC')) . "\n";
print Dumper(getTableInfoParts('preDeleteC', 'insertC', 'update1C', 'update2C',
			       'unknownC', 'errorC')) . "\n";

if ($duration == 0) {
    $duration = 1;
}

my $totalRecords = getTableInfoTotalsByKeys('insertC', 'update1C', 'update2C',
					    'unknownC', 'errorC');
print (((reduce {$a + $b} values(%{$totalRecords}))/$duration) . " records per second\n");
print 'Pass 1 duration ' . ($timings{'pass2Start'} - $timings{'pass1Start'}) . " seconds.\n";
print 'Pass 2 duration ' . ($timings{'pass3Start'} - $timings{'pass2Start'}) . " seconds.\n";
print 'Pass 3 duration ' . ($timings{'pass3End'} - $timings{'pass3Start'}) . " seconds.\n";
print "\n";

print 'Application version ' . $applicationVersion . "\n";
print 'Schema version ' . $schemaVersion . "\n";
print 'Site codes ' . join(', ', keys(%uniqueSiteCodes)) . "\n";
print "\n";

foreach my $tableName (getAllTableNames()) {
    print $tableName . "\n";
    print (getTableInfo($tableName, 'insertSQL') or '');
    print "\n";
    print (getTableInfo($tableName, 'update1SQL') or '');
    print "\n";
    print (getTableInfo($tableName, 'update2SQL') or '');
    print "\n";
    print (getTableInfo($tableName, 'deleteSQL') or '');
    print "\n\n";
}

exit();
