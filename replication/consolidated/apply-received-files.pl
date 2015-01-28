#!/usr/bin/perl -w

use strict;
use warnings;

chdir('/usr/share/isante/htdocs/replication');

=begin comment
 this program loads gz files in /home/itech/replication/data (/var/backups/itech/replication/data) into the target database and 
   moves those files to /home/itech/replication/data/imported-d<target-database>s<target-site>
=cut

my $fileBaseDir = '/home/itech/replication/data/';

my @unappliedFiles = glob($fileBaseDir . '*.csv.gz');
@unappliedFiles = sort(@unappliedFiles);

#for each gz file in ~data
foreach my $unappliedFile (@unappliedFiles) {
    my @errorFileStat = stat $unappliedFile . '-errors.txt';
    if (@errorFileStat && ($errorFileStat[7] != 0)) {
#	die $unappliedFile . " has had an error\n";
    }
    
    my $parameterHash;
    my $metaDataFile;
    open($metaDataFile, '<', $unappliedFile . '-meta.txt');
    eval(<$metaDataFile>);
    close($metaDataFile);

    my $updateCommandString = 'perl updateTarget.pl --config /etc/isante/my.cnf ';
    $updateCommandString .= ' --file "' . $unappliedFile . '"';
    $updateCommandString .= ' > "' . $unappliedFile . '-update-output.txt"';
    $updateCommandString .= ' 2> "' . $unappliedFile . '-update-errors.txt"';
    `$updateCommandString`;

    my $importDirectory = 
	$fileBaseDir . 'imported-' . $parameterHash->{targetName} . '-' . $parameterHash->{serverName};
    
    my $mkdirCommandString = 'mkdir -p "' . $importDirectory . '"';
    `$mkdirCommandString`;

    #this file doesn't have anything useful in it so get rid of it
    my $deleteUpdateErrorsFile = 'rm "' . $unappliedFile . '-update-errors.txt"';
    `$deleteUpdateErrorsFile`;

    my $moveFilesCommandString = 'mv ' . $unappliedFile . '* ' . $importDirectory;
    `$moveFilesCommandString`;
}
