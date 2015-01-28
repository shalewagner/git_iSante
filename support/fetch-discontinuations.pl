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

use Cwd 'realpath';
use File::Path 'mkpath';
use Time::Local;

use LocalConfig;
use Database;

$| = 1; #always flush stdout

my $backupDir = '/var/backups/itech';

my $database = Database->new();
my $dbSite = getConfig('dbsite');
if (! defined($dbSite)) {
    die "Couldn't find configuration value for dbsite.\n";
}

#figure out where files should be stored
my $dataFilePath;
my $dataFileAppliedPath;
{
    my $replicationBasePath = $backupDir . '/patientTransfer';
    $dataFilePath = $replicationBasePath . '/discontinuationsReceived';
    $dataFileAppliedPath = $replicationBasePath . '/discontinuationsReceived/applied';
    mkpath($dataFilePath, {mode => 0750});
    mkpath($dataFileAppliedPath, {mode => 0750});
}

#Attempt to query consolidated site for new discontinuation that should be applied
{
    my $durationStart = time();

    my $command = 'curl --user ' . join(':', consolidatedUserPass())
	. ' --url https://isante-consolidated.cirg.washington.edu/discontinuation/getDiscontinuations.php'
        . ' --form "dbSite=' . $dbSite . '"';
    my $curlReturn = '';
    
    my $retryCount = 0;
    my $maxRetryCount = 8;
    my $curlSuccess = 0; #false
    while ($retryCount < $maxRetryCount) {
	$curlReturn = `$command`;
	my $returnStatus = $?;
	if ($returnStatus != 0) {
	    print "Curl had an error. Curl said \n$curlReturn\n" 
		. "Return status $returnStatus\n"; 
	    $retryCount = $retryCount + 1;
	} else {
	    $curlSuccess = 1; #true
	    last;
	}
	sleep 7;
    }

    if ($curlSuccess) {
	if ($curlReturn ne '') {
	    my $outputFileName = $dataFilePath . '/' . time() . '.genericsave';
	    my $outputFile;
	    open($outputFile, '>', $outputFileName) or die 'Can not open output file.';
	    print $outputFile $curlReturn;
	    close($outputFile);
	    $database->recordEvent('discontinuePullOk', 
				   {'dbSite' => $dbSite,
				    'duration' => time() - $durationStart});
	}
    } else {
	print "Could not get discontinuation data.\n";
	$database->recordEvent('discontinuePullFail',
			       {'dbSite' => $dbSite,
				'duration' => time() - $durationStart});
    }
}

#apply any received files
foreach my $fileName (glob($dataFilePath . '/*.genericsave')) {
    `perl "$main::isanteSource/genericsave-file.pl" "$fileName"`;
    `mv "$fileName" "$dataFileAppliedPath"`;
    $database->recordEvent('discontinuesApplied', {'dbSite' => $dbSite});
}

exit();
