#!/usr/bin/perl -w

use strict;
use warnings;

{
    my $line = <STDIN>;
    my @recordLines = ();

    my $versionCurrent = `php -r "require_once 'backend/config.php'; print __getAppVersion('debian/version.ini');"`;
    $versionCurrent =~ /(.*?) \(/;
    my $versionPrefix = $1;
    $versionPrefix =~ s/ /-/;

    my $addPlus = 0;
    if ($versionCurrent =~ /\+/) {
	$addPlus = 1;
    }

    while ($line = <STDIN>) {
	chomp $line;
	if ($line =~ /^-+$/) {
	    printRecord($versionPrefix, $addPlus, @recordLines);
	    $addPlus = 0;
	    @recordLines = ();
	} else {
	    push @recordLines, $line;
	}
    }
}

sub printRecord {
    my $versionPrefix = shift;
    my $addPlus = shift;
    my $header = shift;
    my @lines = grep {$_ ne ''} @_;

    if ($header =~ /^r(.+?) \| (.+?) \| (.+?) \| .+$/) {
	my $rev = $1;
	my $user = $2;
	my $dateTime = $3;

	$dateTime =~ /^\S+? (.+?) \((.+)\)$/;
	my $time = $1;
	my $date = $2;

	if ($addPlus) {
	    $rev = $rev . '+';
	}
	
	print 'isante ('. $versionPrefix . '~' . $rev . '-1) UNRELEASED; urgency=low' . "\n\n";
	map {print '  * ' . $_ . "\n"} @lines;
	print "\n" . ' -- ' . $user . ' <' . $user . '@uw.edu>  ' . $date . ' ' . $time . "\n\n";
    }
}
