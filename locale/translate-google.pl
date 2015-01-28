#!/usr/bin/perl -w

use strict;
use warnings;

use Encode;
use JSON;
use URI::Escape;
use HTML::Entities;

binmode STDIN, ":utf8";
binmode STDOUT, ":utf8";
my $defaultSourceLang = 'fr';

my $messageId = decode('utf8', $ENV{'MSGFILTER_MSGID'});
my $translation = '';
while (my $line = <STDIN>) {
    #existing translation is loaded here
    $translation .= $line;
}

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
	if (!defined($ENV{'ISANTE_TRANSLATE_KEY'})) {
	    die('ISANTE_TRANSLATE_KEY environment variable must be set to a valid Google API key.' 
		. "\n\n");
	}
	my $key = $ENV{'ISANTE_TRANSLATE_KEY'};
	my $googleUrlBase = 'https://www.googleapis.com/language/translate/v2?';
	my $restCall = $googleUrlBase 
	    . 'key=' . uri_escape($key)
	    . '&q=' . uri_escape(encode('utf8', $messageId)) 
	    . '&source=' . uri_escape($sourceLang) 
	    . '&target=' . uri_escape($targetLang);
	my $rawResult = `curl "$restCall"`;
	my $result = decode_json($rawResult);
	#sleep for 25ms to make sure we don't upset Google
	select(undef, undef, undef, 0.025);
	if (defined($result->{data})
	    && defined($result->{data}->{translations})
	    && defined($result->{data}->{translations}->[0])
	    && defined($result->{data}->{translations}->[0]->{translatedText})) {
	    #Got a translated result back from Google
	    my $translation = $result->{data}->{translations}->[0]->{translatedText};
	    #remove HTML entities
	    $translation = decode_entities($translation);
	    #Change apostrphes into right single quotation marks.
	    #Change double quotes into right double quotation marks.
	    #This is a hack to make sure strings are javascript, etc. compatible.
	    $translation =~ s/\N{U+0027}/\N{U+2019}/g;
	    $translation =~ s/\N{U+0022}/\N{U+201D}/g;
	    print $translation;
	} elsif (defined($result->{error})) {
	    #Got an error message from Google
	    die("Google Translate returned an error.\n" . $rawResult);
	} else {
	    #Got something unexpected from Google
	    die("Google Translate returned something unexpected.\n" . $rawResult);
	}
    }
} else {
    #just echo existing translated text if it exists
    print $translation;
}

exit;
