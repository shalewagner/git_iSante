#!/usr/bin/perl -w

#The purpose of this utility is to spoof meta data files from replication data that was not 
#sent via the https process. It takes a directory containing replication data as input.

use strict;
use Data::Dumper;


if ($#ARGV == -1) {
    print "Need a path.\n";
    exit;
}
my $fileBaseDir = $ARGV[0];

my @toSpoofFiles = glob($fileBaseDir . '*.csv.gz');
@toSpoofFiles = sort(@toSpoofFiles);

foreach my $toSpoofFile (@toSpoofFiles) {
    $toSpoofFile =~ /([0-9]{4}-[0-9]{2}-[0-9]{2}_[0-9]*-.*)/;
    my $fileBaseName = $1;

    my %parameterHash;
    $parameterHash{dataFileName} = $fileBaseName;
    $parameterHash{reportFileName} = $fileBaseName . '-report.txt';
    $parameterHash{errorFileName} = $fileBaseName . '-errors.txt';
    
    $fileBaseName =~ /^[0-9]{4}-[0-9]{2}-[0-9]{2}_[0-9]*-(.*?)_(.*?)-(.*?).csv.gz$/;
    $parameterHash{serverName} = $1;
    $parameterHash{databaseName} = $2;
    $parameterHash{targetName} = $3;

    my $reportFile;
    open($reportFile, '<', $toSpoofFile . '-report.txt') or die "Can't open report file.\n";
    my $changeString = <$reportFile>;
    $changeString =~ /Most recent change: (.*)/;
    my $mostRecentChangeTimeString = $1;
    if (! defined $mostRecentChangeTimeString) {
	die "Couldn't get date changed string from report.\n";
    }
    chop($mostRecentChangeTimeString);
    close($reportFile);

    $parameterHash{stopTime} = $mostRecentChangeTimeString;
    $parameterHash{startTime} = $mostRecentChangeTimeString;

    my $metaFileName = $toSpoofFile . '-meta.txt';
    my $metaFileHandle;
    open($metaFileHandle, '>', $metaFileName) or die "Can't open meta data file.\n";
    if (! defined $metaFileHandle) {
	print "Can not open meta data file.\n";
	exit;
    }

    local $Data::Dumper::Indent = 0;
    print $metaFileHandle (Data::Dumper->Dump([\%parameterHash], ['parameterHash']) . "\n");

    close($metaFileHandle);
}

