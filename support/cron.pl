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
use feature 'switch';

use Fcntl qw(:flock);
use POSIX qw(strftime);

use LocalConfig;

#execute everything from the iSanté source directory so that php can find it's libraries
chdir($main::isanteSource);

my $logDir = '/var/log/itech';
my $logFile = $logDir . '/cron.log';
if (!scalar(stat($logFile))) {
    `touch $logFile`;
}
my $logFileHandle;
open($logFileHandle, '>>', $logFile);

sub waitAndLock {
    flock($logFileHandle, LOCK_EX);
}

sub lockOrExit {
    if (!flock($logFileHandle, LOCK_EX | LOCK_NB)) {
	exit 0;
    }
}

sub unlock {
    flock($logFileHandle, LOCK_UN);
}

sub logMessage {
    print $logFileHandle (strftime('%Y-%m-%d %H:%M:%S', localtime()) . ' ' . shift() . "\n");
}

sub runJob {
    my ($name, $command) = @_;

    logMessage('Starting ' . $name);
    `$command`;
    logMessage('Finished ' . $name);
}

sub runPatientStatus {
    runJob('patientStatus', "/usr/bin/sudo -u www-data /usr/bin/php \"$main::isanteSource/patientStatusBatch.php\" >> \"$logDir/patient-status.log\" 2>&1");
}

sub run10minute {
    runJob('10minute', "/usr/bin/sudo -u www-data /usr/bin/php \"$main::isanteSource/batch-jobs.php\" >> \"$logDir/ten-minute.log\" 2>&1");
}

sub run10minuteForce {
    runJob('10minuteForce', "/usr/bin/sudo -u www-data /usr/bin/php \"$main::isanteSource/batch-jobs.php\" -f >> \"$logDir/ten-minute.log\" 2>&1");
}

sub runBackup {
    runJob('backup', "/bin/bash \"$main::isanteSource/support/backup-db-linux.sh\"");
}

sub runCaseNotif {
    runJob('caseNotif', "/usr/bin/sudo -u www-data /usr/bin/php \"$main::isanteSource/runCaseNotif.php\" >> \"$logDir/caseNotif.log\" 2>&1");
}

my $timeframe = $ARGV[0];
if (!defined($timeframe) || $timeframe eq '') {
    die('no timeframe specified');
}

if ($timeframe eq '10minute') {
    lockOrExit(); #ok to skip the 10 minute job is something else is already running
} else {
    waitAndLock(); #if it's not the 10 minute job then wait our turn
}

my $serverRole = getConfig('serverRole');
if (! defined($serverRole)) {
    die "Couldn't find configuration value for serverRole.\n";
}

given ($timeframe) {
    when ('10minute') {
	if ($serverRole eq 'production' || $serverRole eq 'test') {
	    run10minute();
	}
    }
    when ('reboot') {
	if ($serverRole eq 'production' || $serverRole eq 'test') {
	    runPatientStatus();
	    runJob('databaseStatistics', "/usr/bin/mysqlcheck --defaults-file=/etc/isante/my.cnf -Aa");
	}
    }
    when ('midnight') {
	if ($serverRole eq 'consolidated') {
	    run10minuteForce();
	}
	if ($serverRole eq 'production' || $serverRole eq 'test') {
		runPatientStatus();
	}
	if ($serverRole eq 'consolidated') {
	    runBackup();
	}
	runJob('databaseStatistics', "/usr/bin/mysqlcheck --defaults-file=/etc/isante/my.cnf -Aa");
    }
    when ('afterNoon') {
	if ($serverRole eq 'production') {
	    runJob('replication', "/usr/bin/sudo -u itech /usr/bin/perl \"$main::isanteSource/replication/replicate-database.pl\"");
	}
	if ($serverRole eq 'production' || $serverRole eq 'test') {
	    runBackup();
	}
    }
    when ('discontinuation') {
	if ($serverRole eq 'production') {
	    runJob('fetchDiscontinuations', "/usr/bin/sudo -u www-data /usr/bin/perl \"$main::isanteSource/support/fetch-discontinuations.pl\"");
	}
    }
    when ('caseNotif') {
        # this should only get called from the primary consolidated server,
        # so make sure there's a cron task added there to call this.
	if ($serverRole eq 'consolidated') {
		# removing this in 18.1 because Solutions is now using a different process (and this one is not working)
	    #runCaseNotif();
	}
    }
}

unlock;
exit 0;
