
package LocalConfig;

use strict;
use warnings;

use Database;

BEGIN {
    use Exporter ();
    our ($VERSION, @ISA, @EXPORT);

    @ISA = qw(Exporter);
    @EXPORT = qw(&getConfig &loadConfig &consolidatedUserPass);
}

my $config = {};
my $configLoaded = 0; #boolean

sub getConfig($) {
    my $configKey = shift;

    if (!$configLoaded) {
	loadConfig();
    }

    my $configValue = $config->{$configKey};
    if (defined $configValue) {
	return $configValue->{'value'};
    } else {
	return undef;
    }
}

sub loadConfig {
    my $databaseConfigFile = shift;
    my $dbHandle = Database::getNewDbHandle($databaseConfigFile);
    $config = $dbHandle->selectall_hashref('select * from config;', 'name');
    $configLoaded = 1;
}

sub consolidatedUserPass {
    return ('itech', 'jaif5Ahg5mei');
}

1;
