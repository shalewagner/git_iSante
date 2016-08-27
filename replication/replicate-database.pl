#!/usr/bin/perl -w

BEGIN {
    $main::isanteSource = $ENV{ISANTE_SOURCE} || '/usr/share/isante/htdocs';
    if (!scalar(stat($main::isanteSource))) {
        die('can not find iSantŽ source directory');
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

=begin comment
  This code unloads a site and sends it to a receiver's /home/itech/replication/data dir via curl 
  The send side is automatically set up in the standard iSantŽ install
  For information on setting up the receiver, see the comments in ~replication/consolidated/receiver/receive-file.pl
=cut

#never run as root
if ($> == 0) {
    die('Must not run as Root.');
}

my $backupDir = '/var/backups/itech';

#convert an SQL datetime string into a unix time stamp
sub dateTimeStringToTime {
    my $dateTime = shift;
    $dateTime =~ /^([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2}).*$/;
    return timelocal($6, $5, $4, $3, $2 - 1, $1);
}

#convert a unix time stamp into an SQL datetime string
sub timeToSqlDateTime {
    my $time = shift;
    my @timeParts = localtime($time);
    return sprintf("%04d-%02d-%02d %02d:%02d:%02d",
		   $timeParts[5] + 1900, $timeParts[4] + 1, $timeParts[3],
		   $timeParts[2], $timeParts[1], $timeParts[0]);
}

my $database = Database->new();
my $dbHandle = $database->getDbHandle();

my $dbSite = getConfig('dbsite');
if (! defined($dbSite)) {
    die "Couldn't find configuration value for dbsite.\n";
}
my $siteCode = getConfig('defsitecode');
if (! defined($siteCode)) {
    die "Couldn't find configuration value for defsitecode.\n";
}
my $serverId = 'd' . $dbSite . 's' . $siteCode;

my $replicationTargets = getConfig('replicationTargets');
if (! defined($replicationTargets)) {
#   modified in 16.2 to send to the UGP consolidated server by default; use the replicationTargets config item to modify this behavior
    $replicationTargets = 'papConsolidated,https://isante.ugp.ht/consolidatedId/receiver/receive-file.pl,identified';
}
my @replicationTargetParts = split(/,/, $replicationTargets);
if (@replicationTargetParts % 3 != 0) {
    die "replicationTargets not formatted properly.\n";
}

#figure out where files should be stored
my $dataFilePath;
my $dataFileSentPath;
{
    my $replicationBasePath = $backupDir . '/replication';
    $dataFilePath = $replicationBasePath . '/data';
    $dataFileSentPath = $replicationBasePath . '/data-sent';
    mkpath($dataFilePath, {mode => 0750});
    mkpath($dataFileSentPath, {mode => 0750});
}


while (my $currentTargetName = shift(@replicationTargetParts)) {
    my $currentTargetUrl = shift(@replicationTargetParts);
    my $deidentifyMode = shift(@replicationTargetParts);

    my $durationStart = time();

    my $currentDeidentify;
    my $currentDeidentifySwitch;
    if ($deidentifyMode eq 'identified') {
	$currentDeidentify = 0;
	$currentDeidentifySwitch = '';
    } elsif ($deidentifyMode eq 'deidentified') {
	$currentDeidentify = 1;
	$currentDeidentifySwitch = '--deidentify';
    } else {
	die "replicationTargets not formatted properly.\n";
    }
    
    #figure out when the last read ended for this particular target
    my $lastReadTime; #when to start reading from
    my $lastReadUniqueNumber; #unique number generated from last read
    {
	my $lastReadRecord = $dbHandle->selectrow_hashref('
           select * from replicationRead 
           where targetName = ? 
           order by stopTime desc, replicationRead_id desc
           ', undef, $currentTargetName);
  
	if (defined $lastReadRecord) {
	    $lastReadTime = dateTimeStringToTime($lastReadRecord->{'stopTime'});
	    $lastReadUniqueNumber = 1 + $lastReadRecord->{'replicationRead_id'};
	} else {
	    $lastReadTime = 0; #1970-01-01 GMT
	    $lastReadUniqueNumber = 0;
	}
    }

    #read the data from the database and write the three files (data, report, errors)
    my $dataFileName;
    my $reportFileName;
    my $errorFileName;
    {
	my $dateTime = timeToSqlDateTime($lastReadTime);
	my @timeParts = localtime($lastReadTime);
	my $dateTimeFile = sprintf("%04d-%02d-%02d_%02d",
				   $timeParts[5] + 1900, $timeParts[4] + 1, $timeParts[3],
				   $lastReadUniqueNumber);

	my $databaseName = 'itech';
	$dataFileName = "$dataFilePath/$dateTimeFile-$serverId"
	    . '_' . "$databaseName-$currentTargetName"
	    . '.csv.gz';
	$reportFileName = $dataFileName . '-report.txt';
	$errorFileName = $dataFileName . '-errors.txt';

	`perl "$main::isanteSource/replication/readSource.pl" $currentDeidentifySwitch --date "'$dateTime'" --file "$dataFileName" > "$reportFileName" 2> "$errorFileName"`;
	my $returnStatus = $?;
	if ($returnStatus != 0) {
	    die "readSource.pl had an error. Giving up.\n";
	}
    }

    #Look for the time of the most recently changed record that was read.
    #If we can't find this then it means the read did not finish properly.
    my $mostRecentChangeTime;
    {
	my $reportFile;
	open($reportFile, '<', $reportFileName) or die "Can't open report file.\n";
	my $changeString = <$reportFile>;
	$changeString =~ /Most recent change: (.*)/;
	my $mostRecentChangeTimeString = $1;
	if (! defined $mostRecentChangeTimeString) {
	    die "readSource.pl had an error. Giving up.\n";
	}
	$mostRecentChangeTime = dateTimeStringToTime($mostRecentChangeTimeString);
	close($reportFile);
    }

    #make a record in replicationRead that documents this read
    {
	$dbHandle->do('
        insert into replicationRead 
         (targetName, targetUrl, startTime,
          stopTime, dataFileName, reportFileName,
          errorFileName, deidentified, transmitted) 
         values (?,?,?,?,?,?,?,?,?)', undef,
		      $currentTargetName, $currentTargetUrl, timeToSqlDateTime($lastReadTime),
		      timeToSqlDateTime($mostRecentChangeTime), $dataFileName, $reportFileName,
		      $errorFileName, $currentDeidentify, 0)
	    or die "Can't insert replicationRead record.\n";
    }

    #record this replication read in the event log
    {
	$database->recordEvent('replicationRead',
			       {'targetName' => $currentTargetName,
				'targetUrl' => $currentTargetUrl,
				'dataFileName' => $dataFileName,
				'stopTime' => timeToSqlDateTime($mostRecentChangeTime), 
				'deidentified' => $currentDeidentify,
				'duration' => time() - $durationStart});
    }
}

#Attempt to transmit any files that have not been transmitted. Mark them as transmitted on 
#success and move them into $dataFileSentPath
{
    my $allTargets = $dbHandle->selectcol_arrayref('
       select targetName from replicationRead group by targetName');

    #Handle each target separately. This means that if we are sending data to two different machines
    #and one is not responding, the other will still get data.

    foreach my $targetName (@$allTargets) {

	my $untransmittedRecords = $dbHandle->selectall_arrayref('
           select * from replicationRead 
           where transmitted = ? 
           and targetName = ?
           order by startTime asc 
           ', { Slice => {} }, 0, $targetName); #the Slice thing makes it an array of hashes

	foreach my $untransmitted (@$untransmittedRecords) {
	    my $durationStart = time();
	    my $command = 'curl -k -3 --user ' . join(':', consolidatedUserPass())
		. ' --url ' . $untransmitted->{targetUrl}
	        . ' --form "startTime=' . $untransmitted->{startTime} . '"'
		. ' --form "stopTime=' . $untransmitted->{stopTime} . '"'
		. ' --form "serverName=' . $serverId . '"'
		. ' --form "databaseName=itech"'
		. ' --form "targetName=' . $untransmitted->{targetName} . '"'
		. ' --form "dataFileName=@' . $untransmitted->{dataFileName} . '"'
		. ' --form "reportFileName=@' . $untransmitted->{reportFileName} . '"'
		. ' --form "errorFileName=@' . $untransmitted->{errorFileName} . '"';

	    my $retryCount = 0;
	    my $maxRetryCount = 16;
	    my $sendSuccess = 0; #false
	    while ($retryCount < $maxRetryCount) {
		my $curlReturn = `$command`;
		my $returnStatus = $?;
		if (($returnStatus != 0) || ($curlReturn !~ /success/)) { 
		    print "Curl had an error. Curl said \n$curlReturn\n" 
			. "Return status $returnStatus\n"; 
		    $retryCount = $retryCount + 1;
		    print $command;
		    die $command;
		} else {
		    $sendSuccess = 1; #true
		    last;
		}
		sleep 7;
	    }
	    if (! $sendSuccess) {
		$database->recordEvent('replicationXmitFail', 
				       {'targetName' => $untransmitted->{targetName},
					'targetUrl' => $untransmitted->{targetUrl},
					'dataFileName' => $untransmitted->{dataFileName},
					'stopTime' => $untransmitted->{stopTime},
					'deidentified' => $untransmitted->{deidentified},
					'duration' => time() - $durationStart});
		die "Could not send file.\n";
	    }

	    $dbHandle->do('
             update replicationRead 
             set transmitted = ? 
             where replicationRead_id = ?
             ', undef, 1, $untransmitted->{replicationRead_id}) 
		or die "Can't update replicationRead record.\n";

	    map {`mv "$_" "$dataFileSentPath"`} ($untransmitted->{dataFileName},
						 $untransmitted->{reportFileName},
						 $untransmitted->{errorFileName});

	    $database->recordEvent('replicationXmitOk', 
				   {'targetName' => $untransmitted->{targetName},
				    'targetUrl' => $untransmitted->{targetUrl},
				    'dataFileName' => $untransmitted->{dataFileName},
				    'stopTime' => $untransmitted->{stopTime},
				    'deidentified' => $untransmitted->{deidentified},
				    'duration' => time() - $durationStart});
	}
    }
}
