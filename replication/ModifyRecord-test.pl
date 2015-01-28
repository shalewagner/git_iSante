#!/usr/bin/perl -w

#The purpose of this program is to help test ModifyRecord.pm. It reads original records prints them out modifies them and prints out the modified version.

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

use Data::Dumper;
use DBI;
use Getopt::Long;

use Database;
use ReplicationFile;
use ModifyRecord;

#command line parameter values
#data file to apply
my $fileName;

#read values from the command line
if (!GetOptions(
	 'file=s' => \$fileName,
    )) {
    badCommandLine();
}

#if required parameters are missing
if (! defined $fileName) {
    badCommandLine();
}

sub badCommandLine {
    die "Usage: modify-test.pl --file inputFile\n\n";
}

#connect to database (use currently loaded config file data)
my $dbh = Database::getNewDbHandle();

#get site's version if available
my $siteVersion = '0.0 RC0';
{
    ReplicationFile::open($fileName, '<');
    if (ReplicationFile::readHeader('version')) {
	$siteVersion = ReplicationFile::readHeader('version');
    }
    ReplicationFile::close();
}

#load clinicPatientId values for current patients
initClinicPatientIdMap($dbh);

#output original and modified records
ReplicationFile::open($fileName, '<');
while (my @record = ReplicationFile::readRecord()) {
    if (! defined $record[0]) {last;}
    my ($origTableName, $origFieldHash) = @record;
    print "***ORIGINAL***\n";
    print "$origTableName\n";
    print Dumper($origFieldHash);
    map {
	my ($tableName, $fieldHash) = @{$_};
	print "***MODIFIED***\n";
	print "$tableName\n";
	print Dumper($fieldHash);
    } @{allRecordModifications($dbh, $siteVersion, $origTableName, $origFieldHash)};
}
ReplicationFile::close();

#disconnect from database
$dbh->disconnect;

exit();
