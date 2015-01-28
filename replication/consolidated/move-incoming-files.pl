#!/usr/bin/perl -w

use strict;
use warnings;

use Getopt::Long;
use Mail::SendEasy;

my $replicationDir = '/home/itech/replication';


#these targets indicate where the various filenames in incoming will end up after they are moved
my @targets = (
    {name => 'arsenic',
     fileMatchRe => 'itechUWfailover',
     action => 'cp',
     actionLastArg => "$replicationDir/data/"},
    {name => 'national-id',
     fileMatchRe => 'itechUWfailover',
     action => 'scp',
     actionLastArg => 'itech@172.20.2.50:~/replication/data/'}
    ); 

#process command line parameters
my $force = 0;
GetOptions('force' => \$force);

#Look for any non-incremental replication data. These usually need to be taken care of manually.
# 12/04/2013 commenting this out because these are always forced anyway (there is no criteria for NOT forcing)
#if (!$force) {
#    my @unCopiedFiles = glob($replicationDir . '/incoming/19*.csv.gz'); #starts with 19...
#    if (scalar(@unCopiedFiles) > 0) {
#	my $mailer = new Mail::SendEasy();
#	$mailer->send(from => 'shw2@uw.edu',
#		      reply => 'shw2@uw.edu',
#		      to => 'shw2@uw.edu',
#		      subject => 'iSante: non-incremental replication data waiting',
#		      msg => ('non-incremental replication data waiting in ' . $replicationDir
#			      . ' To import run `move-incoming-files.pl --force`')
#	    );
#	exit;
#    }
#}

#copy the files into their matching for-* directories and remove the originals
my @unCopiedFiles = glob($replicationDir . '/incoming/*.csv.gz');
foreach my $unCopiedFile (@unCopiedFiles) {
    my $fileMatched = 0; #
    foreach my $target (@targets) {
	if ($unCopiedFile =~ $target->{fileMatchRe}) {
	    $fileMatched = 1;
	    my $commandCopy = 
		'cp ' . $unCopiedFile . '* ' . $replicationDir . '/for-' . $target->{name} . '/';
	    `$commandCopy`;
	    if ($? != 0) { #did it work?
		die('original file could not be copied');
	    }
	}
    }
    if ($fileMatched) {
	#file was copied into at least one for-* directory so remove the original
	my $commandRemove = 'rm -f ' . $unCopiedFile . '*';
    `$commandRemove`;
	if ($? != 0) { #did it work?
	    die('original file could not be removed');
	}
    } else {
	#file was not copied into any for-* directory so move it into incoming-orphans/
	my $commandMove = 'mv -f ' . $unCopiedFile . '* incoming-orphans/';
	`$commandMove`;
	if ($? != 0) { #did it work?
	    die('original file could not be moved into incoming-orphans/');
	}
    }
}

#now for each target perform the action on all the files in the for-* directory and remove the file
TARGET: foreach my $target (@targets) {
    my @unHandledFiles = glob($replicationDir . '/for-' . $target->{name} . '/*.csv.gz');
    foreach my $unHandledFile (@unHandledFiles) {
	my $commandAction = $target->{action} . ' ' . $unHandledFile . '* ' . $target->{actionLastArg};
	`$commandAction`;
	if ($? == 0) { #did it work?
	    my $commandRemove = 'rm -f ' . $unHandledFile . '*';
	    `$commandRemove`;
	    if ($? != 0) { #did it work?
		die('file in for-' . $target->{name} . ' could not be removed');
	    }
	} else {
	    #failed so move on to the next target
	    next TARGET;
	}
    }
}

1;
