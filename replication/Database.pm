
package Database;

use strict;
use warnings;

use DBI;
use JSON;

BEGIN {
    our ($VERSION, @ISA);
    @ISA = qw();
}

#used to store the connection shared by every instance that doesn't request its own
#nothing uses this
my $globalDbHandle = undef;

#private function used to get new database handles
sub getNewDbHandle {
    my $defaultsFile = shift || '/etc/isante/my.cnf';
    my $dbDsn = 'dbi:mysql:;mysql_read_default_file=' . $defaultsFile;
    my $dbHandle = DBI->connect($dbDsn, undef, undef, { PrintError => 1 }) or die $DBI::errstr;
    $dbHandle->do('SET CHARACTER SET utf8');
    return $dbHandle;
};

sub new() {
    my $class = shift;
    my $parameterHash = shift;

    my $self = {};

    my $dbHandle;

    #by default every instance uses the same connection
    #an instance can get its own connection by setting notShared => 1
    if (! defined $parameterHash->{notShared}) {
	if (! defined $globalDbHandle) {
	    $globalDbHandle = getNewDbHandle();
	}
	$dbHandle = $globalDbHandle;
    } else {
	$self->{notShared} = 1;
	$dbHandle = getNewDbHandle();
    }
    $self->{dbHandle} = $dbHandle;
    
    bless ($self, $class);
    return $self;
}

sub getDbHandle {
    my $self = shift;
    return $self->{dbHandle};
}

sub recordEvent {
    my $self = shift;
    my ($eventType, $eventParameters) = @_;
    my $dbHandle = $self->{dbHandle};
    
    my $eventParametersString = to_json($eventParameters);
    my $dbSite = LocalConfig::getConfig('dbsite');
    if (! defined($dbSite)) {
	die "Couldn't find configuration value for dbsite.\n";
    }

    sleep 1; #make sure we don't insert a duplicate key
    return $dbHandle->do('
insert into eventLog (dbSite, siteCode, username, eventDate, eventType, eventParameters)
values (?, \'\', \'\', now(), ?, ?)
', undef, $dbSite, $eventType, $eventParametersString);
}

sub close {
    my $self = shift;
    my $dbHandle = $self->{dbHandle};

    if ($dbHandle == $globalDbHandle) {
	return 1; 
    } else {
	return $dbHandle->disconnect or warn $dbHandle->errstr;
    }
}

require LocalConfig;
import LocalConfig;

1;
