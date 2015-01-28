#!/usr/bin/perl -w

use strict;
use warnings;

use IPC::Open2;
use Data::Dumper;

while (my $line = <STDIN>) {
    chomp $line;

    if ($line =~ /^msgid "(.*?)"$/) {
	filterMsg(adjustNewLines($1), join(' ', @ARGV));
    } else {
	print "$line\n";
    }
}

sub adjustNewLines {
    my $string = shift;
    if ($string =~ /^(.*?)\\n$/) {
	return $1 . "\n";
    } else {
	return $string;
    }
}

sub filterMsg {
    my $msgid = shift;
    my $filterCommand = shift;
    my $msgstr;

    my $finishedMsgId = 0;
    my $finishedMsgStr = 0;

    while ($finishedMsgId == 0) {
	my $line = <STDIN>;
	chomp $line;
	if ($line =~ /^"(.*?)"$/) {
	    if ($msgid eq '') {
		$msgid = adjustNewLines($1);
	    } else {
		$msgid = $msgid . adjustNewLines($1);
	    }
	} else {
	    $line =~ /^msgstr "(.*?)"$/;
	    $msgstr = adjustNewLines($1);
	    $finishedMsgId = 1;
	}
    }

    my $msgStrNewLine = 0;
    while ($finishedMsgStr == 0) {
	my $line = <STDIN>;
	if (defined($line)) {
	    chomp $line;
	    if ($line eq '') {
		$finishedMsgStr = 1;
		$msgStrNewLine = 1;
	    } else {
		$line =~ /^"(.*?)"$/;
		if ($msgstr eq '') {
		    $msgstr = adjustNewLines($1);
		} else {
		    $msgstr = $msgstr . adjustNewLines($1);
		}
	    }
	} else {
	    $finishedMsgStr = 1;
	}
    }

    if (defined($filterCommand)) {
	$ENV{'MSGFILTER_MSGID'} = $msgid;

	my ($out, $in);
	my $pid = open2($out, $in, $filterCommand);

	my $newMsgStr = '';
	print $in $msgstr;
	close $in;
	while (my $line = <$out>) {
	    $newMsgStr .= $line;
	}
	$msgstr = $newMsgStr;

	waitpid($pid, 0);
	if ($? != 0) {
	    die('Problem running filter on message.' . "\n\n");
	}
    }

    print 'msgid ' . formatMsg($msgid);
    print 'msgstr ' . formatMsg($msgstr);
    if ($msgStrNewLine) {
	print "\n";
    }
}

sub formatMsg {
    my $msg = shift;

    if ($msg eq '') {
	return "\"\"\n";
    }

    my @messages = split(/(\n)/, $msg);
    for (my $i=1; $i<@messages; $i++) {
	if ($messages[$i] eq "\n") {
	    $messages[$i] = undef;
	    $messages[$i - 1] = $messages[$i - 1] . '\n';
	}
    }
    @messages = grep {defined} @messages;

    if (@messages > 1) {
	my $output = "\"\"\n";
	foreach my $message (@messages) {
	    $output .= "\"$message\"\n";
	}
	return $output;
    } else {
	return '"' . $messages[0] . "\"\n";
    }
}
