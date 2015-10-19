<?php

require_once 'backend/config.php';
require_once 'backend/database-mysql.php';
require_once 'backendAddon.php';

#Change a config item to a new value. A value of '' means use the default (aka null).
function editConfig($name, $value) {
  $allConfigParameters = getConfigParameters();

  if (isset($allConfigParameters[$name])) {
    $configParameters = $allConfigParameters[$name];
  } else {
    die('No configuration parameter with that name.');
  }

  if (!$configParameters['changeable']) {
    die('This configuration parameter can not be changed.');
  }

  if (isset($configParameters['validationRegexp'])
      && isset($value)
      && $value != ''
      && preg_match("/$configParameters[validationRegexp]/", $value) == 0) {
    die('Not a valid value for this configuration parameter.');
  }
  
  database()->query('delete from config where `name`=?', array($name));
  if (isset($value)
      && $value != '') {
    database()->query('insert into config set `name`=?, `value`=?', array($name, $value));
    recordEvent('configChange', array('name' => $name, 'value' => $value));
  } else {
    recordEvent('configChange', array('name' => $name, 'value' => null));
  }

  #Force reloading update value.
  getConfig($name, '', true);
}

#Definitions of all available configuration parameters. This array is used to drive the UI for the config page and also contains some simple validation hints.
function getConfigParameters() {
  return array(
	'serverRole' => array('name' => _('Server Role'),
		'description' => _('What is the purpose of this server? ‘Testing’ is for servers which will contain fake data or be used for evaluation purposes. ‘Production’ is for servers which will contain real patient data and be configured with a real dbSite code value. ‘Consolidated’ is for servers which will contain aggregated data from production servers obtained through replication only.'),
		'required' => true,
		'changeable' => true,
		'validationRegexp' => '^(test|production|consolidated)$',
		'enumerations' => array('test' => _(
			'Testing'),
			'production' => _('Production'),
			'consolidated' => _('Consolidated'))), 
	'labOrderUrl' => array(
		'name' => _('URL pour les ordres de laboratoire'),
		'description' => _('URL à utiliser pour les ordres de laboratoire, par example : ') . 'http://localhost:8180/haitiOpenElis/OrderRequest',
		'required' => false,
		'changeable' => true,
		'validationRegexp' => null,
		'enumerations' => null),
	'fingerprintURL' => array(
		'name' => _('Fingerprint URL'),
		'description' => _('URL à utiliser pour le M2SYS serveur d’empreintes digitales, par example : ') . 'https://192.168.1.51/bioplugin.asmx?wsdl',
		'required' => false,
		'changeable' => true,
		'validationRegexp' => null,
		'enumerations' => null),  
	'replicationTargets' => array(
		'name' => _('Replication Targets'),
		'description' => _('This is a list of target information for where replicated data should be sent. Its value is a list that looks like : targetName,targetUrl,identified,targetName,targetUrl,identified... Every set of three values represents one replication target. ‘targetName’ is a unique name for each replication. ‘targetUrl’ is the URL where the read files will be sent. ‘identified’ has a value of either ‘identified’ or ‘deidentified’ [only identified is valid beginning with 15.1]. By default, identified data will be sent to isante-consolidated.cirg.washington.edu (I-TECH) and to isante.ugp.ht (UGP) with this target list : itechConsolidated,https://isante-consolidated.cirg.washington.edu/receiver/receive-file.pl,identified,papConsolidated,https://isante.ugp.ht/consolidatedId/receiver/receive-file.pl,identified'),
		'required' => false,
		'changeable' => true,
		'validationRegexp' => null,
		'enumerations' => null), 
	'backupEncryptionKey' => array(
		'name' => _('Backup Encryption Key'),
		'description' => _('This value is used to encrypt backup files. If no value is provided backup files will not be encrypted. Encrypted backup files can not be used unless the encryption key is known.'),
		'required' => false,
		'changeable' => true,
		'validationRegexp' => null,
		'enumerations' => null),
	'dbsite' => array('name' => _(
		'dbSite Code'),
		'description' => _('The numeric dbSite code for this database. dbSite codes are unique to particular site and should never be changed.'),
		'required' => true,
		'changeable' => false,
		'validationRegexp' => '^[0-9]{1,3}$',
		'enumerations' => null),              
	'defsitecode' => array('name' => _(
		'Default siteCode'),
		'description' => _('The default siteCode used for new users.'),
		'required' => true,
		'changeable' => false,
		'validationRegexp' => '^[0-9]{5}$',
		'enumerations' => null),  
	'ldapbasedn' => array('name' => _(
		'LDAP Directory Base DN'),
		'description' => _('This is an LDAP DN containing the users and groups OU that iSanté uses for authentication. e.g.') . ' ou=itech-dev,dc=uccmspp,dc=org',
		'required' => true,
		'changeable' => true,
		'validationRegexp' => null,
		'enumerations' => null), 
	'ldaphost' => array('name' => _(
		'LDAP Directory Server URI'),
		'description' => _('This is the URI of the LDAP server. By default the value is') . ' ldap://localhost/',
		'required' => false,
		'changeable' => true,
		'validationRegexp' => null,
		'enumerations' => null)
	);
}

?>
