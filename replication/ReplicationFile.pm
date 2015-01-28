
package ReplicationFile;

use strict;
use warnings;
use utf8;

use Encode qw(from_to);
use IO::Zlib;

use LocalConfig;

BEGIN {
    use Exporter ();
    our ($VERSION, @ISA, @EXPORT);

    @ISA = qw(Exporter);
    @EXPORT = qw();
}


my %fileHeader = ();
my $fileHandle;

my $databaseEncoding = 'UTF-8';


#This function escapes all character which would break the format of the records. It also converts undefined values to \0 (this value should be interpreted as SQL's NULL value).
#The converstions are \ -> \\, " -> \", new line character -> \n and undefined values -> \0
sub escapeSpecial {
    my $string = shift;
    if (! defined $string) {
        return '\0';
    } else {
        $string =~ s/\\/\\\\/g; #must be first
        $string =~ s/\"/\\\"/g;
        $string =~ s/\n/\\n/gm;
        return $string;
    }
}

#inverse of escapeSpecial (not in this file)
#converts \0 -> undef, \\ -> \, \" -> " and \n -> new line character(s)
sub unescapeSpecial {
    my $string = shift;
    if ($string eq '\0') {
        return undef;
    } else {
        $string =~ s/\\\\/\\/g;
        $string =~ s/\\\"/\"/g;
        $string =~ s/\\n/\n/g;
        return $string;
    }
}


sub open {
    my $fileName = shift;
    my $mode = shift;
    my $headerExtras = shift || {};

    if ($mode ne '>' && $mode ne '<') {
	die "Unknown mode for opening file.\n";
    }

    my $openFile = sub {
	if ($fileName =~ /^.*?\.gz$/) {
	    $fileHandle = IO::Zlib->new();
	    my $openMode;
	    if ($mode eq '>') {
		$openMode = 'wb9';
	    } elsif ($mode eq '<') {
		$openMode = 'rb';
	    }
	    $fileHandle->open($fileName, $openMode) or die "Cannot open transaction file $fileName.";
	} else {
	    open($fileHandle, $mode, $fileName) or die "Cannot open transaction file $fileName.";
	}
    };

    #Read file header here if one exists set defaults otherwise.
    if ($mode eq '<') {
	#first open the file and try to parse the file header
	$openFile->();
	$fileHeader{encoding} = 'UTF-8'; #header itself is always encoded as UTF-8
	my ($origTableName, $origFieldHash) = readRecord();
	if (! defined $origTableName) {
	    #file is empty and does not have a header
	    $fileHandle->close();
	    $openFile->();
            return;
	}

	if ($origTableName eq 'header') {
	    #file has a valid header row
	    %fileHeader = %$origFieldHash;
	    return;
	} else {
	    #no header so reopen the file so that the first line isn't lost
	    $fileHandle->close();
	    $openFile->();
	    #set required header elements to a default value
	    $fileHeader{encoding} = 'WINDOWS-1252';
	    return;
	}
    } 
    
    #Write header for new replication file.
    if ($mode eq '>') {
	$openFile->();
	%fileHeader = %$headerExtras;
	$fileHeader{encoding} = 'UTF-8';
	writeRecord('header', \%fileHeader);
	return;
    }
}

sub close {
    %fileHeader = ();
    $fileHandle->close();
}

sub writeRecord {
    my ($tableName, $dataHash) = @_;

    my @outputData = ($tableName);
    while (my ($field, $value) = each %$dataHash) {
	push @outputData, $field, $value;
    }
    my $outputRecord = join(',', map {'"' . escapeSpecial($_) . '"'} @outputData);
    if ($fileHeader{encoding} ne $databaseEncoding) {
	from_to($outputRecord, $databaseEncoding, $fileHeader{encoding});
    }
    print $fileHandle $outputRecord . "\n";
}

sub readHeader {
    return $fileHeader{shift()};
}

sub readRecord {
    my $record = <$fileHandle>;

    if (! defined $record) {
	return $record;
    }

    chomp($record);
    if ($fileHeader{encoding} ne $databaseEncoding) {
	from_to($record, $fileHeader{encoding}, $databaseEncoding);
    }

    if ($record =~ m/^\".*?(\",\".*?)*\"$/ != 1) {
        die "Couldn't parse record.\n" . $record . "\n\n";
    }

    #$record =~ /^\"(.*?(\",\".*?)*)\"$/;
    #my $recordValues = $1;
    my $recordValues = substr($record, 1, -1);
    my @recordValueList = split(/\",\"/, $recordValues);
    @recordValueList = map(unescapeSpecial($_), @recordValueList);

    my $tableName = shift @recordValueList;
    #if the last value element is "" then split() above wont catch it
    #detect this by looking for a list with an odd number of values and adding '' to it
    if (@recordValueList % 2 == 1) {
        push @recordValueList, '';
    }
    my %fieldHash = @recordValueList;

    return ($tableName, \%fieldHash);
}


1;
