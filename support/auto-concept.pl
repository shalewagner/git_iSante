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

use DBI;

use Database;
use LocalConfig;

=pod
Here's an example input file. It won't add concepts that already exist.

htapregnancyA,Boolean
htapregnancyG,Boolean
=cut

my $dbHandle = Database::getNewDbHandle();

my $fileHandle;
open($fileHandle, $ARGV[0]);

while (my $line = <$fileHandle>) {
    chomp $line;
    my ($shortName, $type) = split(/,/, $line);

    my $conceptRecords = $dbHandle->selectall_arrayref('select * from concept where short_name = ?', undef, $shortName);

    if (scalar(@$conceptRecords) == 0) {
	my $lastConceptId = $dbHandle->selectrow_array('select max(concept_id) from concept');
	my $conceptId = $lastConceptId + 1;

	my $dataType;
	if ($type eq 'varchar') {
	    $dataType = 3;
	} elsif ($type eq 'Numeric') {
	    $dataType = 1;
	} elsif ($type eq 'Datetime') {
	    $dataType = 8; 
	} elsif ($type eq 'Boolean') {
	    $dataType = 10;
	} else {
	    die $type;
	}

	my $newConceptSql = 'insert concept (
concept_id, retired, short_name, description, form_text, datatype_id, class_id, is_set, creator, date_created) values (?, 0, ?, ?, ?, ?, 13, 0, 1, now())';
	$dbHandle->do($newConceptSql, undef, $conceptId, $shortName, $shortName, $shortName, $dataType);

	my $newConceptNameSql = 'insert into concept_name(concept_id,name,short_name,description,locale,creator,date_created)
 values (?, ?, ?, ?, ?, 1, now())';
	$dbHandle->do($newConceptNameSql, undef, $conceptId, $shortName, $shortName, $shortName, 'fr');
	$dbHandle->do($newConceptNameSql, undef, $conceptId, $shortName, $shortName, $shortName, 'en');
	print "$conceptId\n";
    }
}



