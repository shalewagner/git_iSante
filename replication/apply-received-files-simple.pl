#!/usr/bin/perl -w

use strict;
use warnings;

my $fileBaseDir = $ARGV[0];
my $targetConfigFile = '/etc/isante/my.cnf';

my @unappliedFiles = glob($fileBaseDir . '/*.csv.gz');
@unappliedFiles = sort(@unappliedFiles);

foreach my $unappliedFile (@unappliedFiles) {
    my $updateCommandString = 'perl updateTarget.pl --config "' . $targetConfigFile . '"';
    $updateCommandString .= ' --file "' . $unappliedFile . '"';
    $updateCommandString .= ' > "' . $unappliedFile . '-update-output.txt"';
    $updateCommandString .= ' 2> "' . $unappliedFile . '-update-errors.txt"';
    `$updateCommandString`;
}
