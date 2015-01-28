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
#DBI->trace(2);
use Database;
use LocalConfig;
my $fetchType = $ARGV[0];
my $qry = '';
my $value = '';
my $dbh = Database::getNewDbHandle(); 

if ($fetchType eq "local") {
	# use this query in the local server for backup
	$qry = "select value from config where name = 'backupEncryptionKey'"; 
} else {
	# use this query in the consolidated server for restore
	$qry = "select substring(eventParameters, 40,locate(?,eventParameters)-40)from eventLog where eventLog_id in (select max(eventLog_id) from eventLog where eventtype = ? and eventParameters like ?)";
}

my $result = $dbh->prepare($qry);
$result->execute();
#	my $endMatch = '"}';
#	my $eventtype = 'configChange';
#	my $param = '%backupEncryptionKey%';
#	my $result = $dbh->prepare($qry);
#	$result->execute($endMatch, $eventtype, $param);
while ( ($value) = $result->fetchrow_array() ) {
    	print "$value \n";
}
$result->finish();
$dbh->disconnect();