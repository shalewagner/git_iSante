#!/usr/bin/perl -w

BEGIN {
    $main::isanteSource = $ENV{ISANTE_SOURCE} || '/usr/share/isante/htdocs';
    if (!scalar(stat($main::isanteSource))) {
        die('can not find iSanté source directory');
    }
    unshift(@INC, $main::isanteSource . '/replication');
}

use strict;
use warnings;

use DBI;
use Getopt::Long;
use Locale::gettext;
use POSIX qw(setlocale);
use Sys::Hostname;
use Template;

use LocalConfig;

#only run as root
if ($> != 0) {
    die(gettext('Must run as Root.'));
}

#make sure everything is executed from here
chdir($main::isanteSource . '/config-linux');

#load l10n
setlocale(LC_MESSAGES, '');
bindtextdomain('messages', 'locale');
textdomain('messages');

#config parameters
#fetch these from user or from existing configuration
my $adminPassword = undef;
my $siteCode = undef;
my $dbSite = undef;
#these have defaults or are generated from an existing configuration
my $serverRole;
my $itechappPassword;
my $consolidatedUrl;
my $ldapBaseDn;
my $hostname;
my $oldHostname;

#if set to true then avoid user prompts
my $quiet = 0;

#process command line arguments
if (!GetOptions(
         'adminPassword:s' => \$adminPassword,
         'siteCode:s' => \$siteCode,
         'dbSite:s' => \$dbSite,
         'quiet' => \$quiet,
    )) {
    die(gettext('Bad command line parameters.'));
}

#load existing configuration if one exists otherwise ask the user for input
my $isUpgrade = 0; #set to true when it's an upgrade

if (stat('/etc/itech/config.ini')) {
    #this is an upgrade from version 9.0RC1 or earlier so read parameters from old config.ini
    $isUpgrade = 1;

    $serverRole = 
	`grep ^[[:space:]]*serverRole[[:space:]]*[=] /etc/itech/config.ini | cut -f 3 -d " "`;
    chomp $serverRole;
    if ($serverRole eq '') {
	$serverRole = 'production';
    }

    #Could also be restoring a backup from 9.0RC1 or earlier. In that case get password from my.cnf
    if (stat('/etc/isante/my.cnf')) {
	$itechappPassword = 
	    `grep ^[[:space:]]*password[[:space:]]*[=] /etc/isante/my.cnf | cut -f 3 -d " "`;
	chomp $itechappPassword;
	$itechappPassword =~ s/\"//g;
    } else {
	$itechappPassword = 
	    `grep ^[[:space:]]*password[[:space:]]*[=] /etc/itech/config.ini | cut -f 3 -d " "`;
	chomp $itechappPassword;
    }

    $dbSite = `grep ^[[:space:]]*dbsite[[:space:]]*[=] /etc/itech/config.ini | cut -f 3 -d " "`;
    chomp $dbSite;

    $siteCode = `grep ^[[:space:]]*defsitecode[[:space:]]*[=] /etc/itech/config.ini | cut -f 3 -d " "`;
    chomp $siteCode;

    $ldapBaseDn = `grep ^[[:space:]]*ldapbasedn[[:space:]]*[=] /etc/itech/config.ini | cut -f 3 -d " "`;
    chomp $ldapBaseDn;
    $ldapBaseDn =~ s/\"//g;
    #remove the "ou=users," part
    $ldapBaseDn =~ /^ou=users,(.*)/;
    $ldapBaseDn = $1;
} elsif (stat('/etc/isante/my.cnf')) {
    #this is an upgrade from version 9.0RC2 or later so read parameters from the database
    $isUpgrade = 1;

    $serverRole = getConfig('serverRole');
    $dbSite = getConfig('dbsite');
    $siteCode = getConfig('defsitecode');
    $ldapBaseDn = getConfig('ldapbasedn');

    $itechappPassword = 
	`grep ^[[:space:]]*password[[:space:]]*[=] /etc/isante/my.cnf | cut -f 3 -d " "`;
    chomp $itechappPassword;
    $itechappPassword =~ s/\"//g;
} else {
    #initial setup so ask the user for config parameters or use what was given on the command line
    print "\n" . '*******************************************************************' . "\n";
    print '                     ' . gettext('INITIAL ISANTÉ SETUP') . "\n";
    print '*******************************************************************' . "\n\n";

    #itech system user and mysql/ldap admin user password
    if (!defined($adminPassword)) {
	$adminPassword = `pwgen -1 10`;
	chomp $adminPassword;
    }

    #sitecode
    if (!defined($siteCode)) {
	print gettext('What is your 5-digit sitecode value?') . ' ';
	$siteCode = <STDIN>;
	chomp $siteCode;
    }
    
    #dbsite
    if (!defined($dbSite)) {
	print gettext('What is the dbSite value?') . ' ';
	$dbSite = <STDIN>;
	chomp $dbSite;
    }

    #generated stuff
    $serverRole = 'test';
    $itechappPassword = `pwgen -1s 12`;
    chomp $itechappPassword;
    $ldapBaseDn = "ou=isante-$siteCode,dc=uccmspp,dc=org";
}

#default $consolidatedUrl to PaP server, make exception for Seattle
if ($ldapBaseDn =~ /itech-consolidated/) {
  $consolidatedUrl = "isante-consolidated.cirg.washington.edu";
} else {
  $consolidatedUrl = "isante.ugp.ht/consolidatedId";
}

#hostname is computed the same way for all cases
$hostname = 'isante-' . $siteCode;
$oldHostname = hostname();
chomp $oldHostname;

#common settings for all upgrades
if ($isUpgrade) {
    #Don't have a way to recover the admin password.
    #Scripts that need it will need to use the UPGRADE env. flag.
    $adminPassword = '';

    #Some install scripts should have a different behaviour when upgrading.
    #This allows them to test if they are running during an upgrade.
    $ENV{'UPGRADE'} = 1;

    #no need to prompt user
    $quiet = 1;
}

#validate siteCode
if (! ($siteCode =~ /^[0-9]{5}$/)) {
    print gettext('Sitecode must be a 5-digit number.') . "\n";
    exit(1);
}
if ($siteCode < 10000) {
    print gettext('Sitecode must not be less than 10000.') . "\n";
    exit(1);
}

#validate dbSite
if (! ($dbSite =~ /^[0-9]+$/)) {
    print gettext('dbSite must be a number between 1 and 255.') . "\n";
    exit(1);
}
if ($dbSite > 255) {
    print gettext('dbSite must not be greater than 255.') . "\n";
    exit(1);
}
if ($dbSite == 0) {
    print gettext('dbSite must not be 0.') . "\n";
    exit(1);
}

#show a summary of what we know and ask if it's ok to continue
if (!$quiet) {
    print "\n";
    print gettext('iSanté/LDAP administrator and ’itech’ system user password is') 
	. ' ' . $adminPassword . "\n";
    print "Site Code         = $siteCode\n";
    print "Site dbSite       = $dbSite\n\n";
    
    print gettext('Is this correct?') . ' (Y/N) ';
    my $shouldProceed = <STDIN>;
    chomp $shouldProceed;
    
    if (lc($shouldProceed) ne 'y') {
	print gettext('Aborted.');
	exit(1);
    }
}

#all variables to be substituted in templates
my $itechVars = {
    adminPassword => $adminPassword,
    siteCode => $siteCode,
    dbSite => $dbSite,
    serverRole => $serverRole,
    hostname => $hostname,
    oldHostname => $oldHostname,
    ldapBaseDn => $ldapBaseDn,
    itechappPassword => $itechappPassword,
    consolidatedUrl => $consolidatedUrl,
    cirgPasswordHashMysql => '*6C1770F3A13BE71D01494728FDDA920C35F69A5D',
    cirgPasswordHashPgsql => 'md54d326c8fc6c1f63480ee94453308a1a7',
    cirgPasswordHashLdap => '{SSHA}Ld12GNAAIy3agqzWAUJA91N8QvSjz3wR',
};

#process all templates
my $tt = Template->new({
    INCLUDE_PATH => './templates',
    OUTPUT_PATH => './templates-output',
}) || die "$Template::ERROR\n";

map {
    $_ =~ /^(.*?[\\\/])*(.*?)$/; #remove file path
    my $fileName = $2;
    $tt->process($fileName, $itechVars, $fileName)
	|| die $tt->error(), "\n";
} glob('templates/*');

#execute all scripts in order
my @scripts = glob('scripts/*.sh');
@scripts = sort(@scripts);
map {system("sh -vx $_")} @scripts;

#remove processed templates (they have passwords in them)
map {unlink($_)} (glob 'templates-output/*');

#let the user know we're done (if we're not quiet)
if (!$quiet) {
    print "\n" . '*******************************************************************' . "\n";
    print '                    ' . gettext('ISANTÉ SETUP COMPLETE') . "\n";
    print '*******************************************************************' . "\n\n";
}

1;
