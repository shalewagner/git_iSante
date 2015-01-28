#!/usr/bin/perl -w

use strict;
use warnings;

use Crypt::CBC;

if ($#ARGV != 3) {
    printUsageDie();
}

my $mode = $ARGV[0];
my $key = $ARGV[1];
my $inFileName = $ARGV[2];
my $outFileName = $ARGV[3];

if ( ($mode ne 'encrypt') && ($mode ne 'decrypt') ) {
    printUsageDie();
}

my $cipher = Crypt::CBC->new(-key => $key, -cipher => 'Rijndael', -salt => 1)
    || die "Couldn't create CBC object";

$cipher->start($mode);

my ($inFileHandle, $outFileHandle);
open($inFileHandle, '<',$inFileName ) or die "$inFileName: $!";
binmode($inFileHandle);
open($outFileHandle, '>', $outFileName) or die "$outFileName: $!";
binmode($outFileHandle);
    
my $dataBuffer;
while (read($inFileHandle, $dataBuffer, 1024)) {
    print $outFileHandle $cipher->crypt($dataBuffer);
}
print $outFileHandle $cipher->finish;
close $inFileHandle;
close $outFileHandle;

sub printUsageDie {
    print 'usage: util-aes-file.pl {encrypt|decrypt} key inFileName outFileName' . "\n";
    die;
}

exit();
