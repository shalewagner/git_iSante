#!/usr/bin/perl -w

use strict;
use warnings;

use Encode;
use JSON;
use URI::Escape;
use HTML::Entities;

$| = 1;

binmode STDIN, ":utf8";
binmode STDOUT, ":utf8";
binmode STDERR, ":utf8";
my $defaultSourceLang = 'fr';

my $messageId = decode('utf8', $ENV{'MSGFILTER_MSGID'});
my $translation = '';
if ($translation eq '') {
    my $sourceLang = $defaultSourceLang;
    if ($messageId =~ /^([a-z][a-z]):(.*)$/) {
	$sourceLang = $1;
	$messageId = $2;
    }

    my $pwd = `pwd`;
    $pwd =~ /\/([a-z][a-z])[a-zA-Z_]+\/[a-zA-Z_]+$/;
    my $targetLang = $1;

    if ($targetLang eq $sourceLang) {
	#just echo text back if source and target languages are the same
	print $messageId;
    } else {
	print STDERR "Translate $sourceLang -> $targetLang\n";
	print STDERR $messageId . "\n";
	$translation = <STDIN>;
	chomp $translation;

	if (defined($translation)) {
	    #remove HTML entities
	    $translation = decode_entities($translation);
	    #Change apostrphes into right single quotation marks.
	    #Change double quotes into right double quotation marks.
	    #This is a hack to make sure strings are javascript, etc. compatible.
	    $translation =~ s/\N{U+0027}/\N{U+2019}/g;
	    $translation =~ s/\N{U+0022}/\N{U+201D}/g;
	    print $translation;
	} else {
	    die("problem\n");
	}
    }
} else {
    #should never get here
    print $translation;
}

exit;
