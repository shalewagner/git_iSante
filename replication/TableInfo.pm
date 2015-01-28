
package TableInfo;

use strict;
use warnings;
use utf8;


BEGIN {
    use Exporter ();
    our ($VERSION, @ISA, @EXPORT);

    @ISA = qw(Exporter);
    @EXPORT = qw(&getAllTableNames &getTableInfo &getTableInfoTotalsByKeys
		 &getTableInfoParts &recordTableInfo &incrementTableInfo);
}


my %tableInfo = ();

sub getAllTableNames {
    return keys(%tableInfo);
}

sub getTableInfo {
    my ($tableName, $infoKey) = @_;

    if (defined $tableInfo{$tableName}) {
	return $tableInfo{$tableName}->{$infoKey};
    } else {
	return undef;
    }
}

sub getTableInfoTotalsByKeys {
    my @keys = @_;

    my $results = {};
    
    foreach my $key (@keys) {
	my $total = 0;
	foreach my $table (keys(%tableInfo)) {
	    if (defined($tableInfo{$table}->{$key})) {
		$total += $tableInfo{$table}->{$key};
	    }
	}
	$results->{$key} = $total;
    }

    return $results;
}

sub getTableInfoParts {
    my @keys = @_;
    
    my $results = {};

    foreach my $table (keys(%tableInfo)) {
	$results->{$table} = {};
	foreach my $key (@keys) {
	    if (defined($tableInfo{$table}->{$key})) {
		$results->{$table}->{$key} = $tableInfo{$table}->{$key};
	    }
	}
    }

    return $results;
}

sub recordTableInfo {
    my ($tableName, $infoKey, $infoValue) = @_;

    if (!defined $tableInfo{$tableName}) {
	$tableInfo{$tableName} = {};
    }

    $tableInfo{$tableName}->{$infoKey} = $infoValue;
}

sub incrementTableInfo {
    my ($tableName, $infoKey, $num) = @_;

    if (!defined $tableInfo{$tableName}) {
	$tableInfo{$tableName} = {};
    }

    if (!defined $tableInfo{$tableName}->{$infoKey}) {
	$tableInfo{$tableName}->{$infoKey} = 0;
    }

    $tableInfo{$tableName}->{$infoKey} += $num;
}

1;
