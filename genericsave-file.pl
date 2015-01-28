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

use Data::Dumper;

use LocalConfig;
use ReplicationFile;

my @fileNames;
if (@ARGV > 0) {
    @fileNames = @ARGV;
}

chdir($main::isanteSource);

foreach my $fileName (@fileNames) {
    my $fileHandle = ReplicationFile::open($fileName, '<') or die('can not open file');
    
    while (my ($version, $parameterHash) = ReplicationFile::readRecord($fileHandle)) {
	if (!defined($version)) {last;}

	my $command = 'php genericsave-cli.php ';
	while (my ($key, $value) = each(%$parameterHash)) {
	    if (defined($value)) {
		$command .= '"' . ReplicationFile::escapeSpecial($key) . '" ';
		$command .= '"' . ReplicationFile::escapeSpecial($value) . '" ';
	    }
	}
	`$command`;
    }

    ReplicationFile::close($fileHandle);
}
