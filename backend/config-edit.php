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
	'serverRole' => array('name' => _('en:Server Role'),
		'description' => _('en:What is the purpose of this server? ‘Testing’ is for servers which will contain fake data or be used for evaluation purposes. ‘Production’ is for servers which will contain real patient data and be configured with a real dbSite code value. ‘Consolidated’ is for servers which will contain aggregated data from production servers obtained through replication only.'),
		'required' => true,
		'changeable' => true,
		'validationRegexp' => '^(test|production|consolidated)$',
		'enumerations' => array('test' => _(
			'en:Testing'),
			'production' => _('en:Production'),
			'consolidated' => _('en:Consolidated'))), 
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
		'name' => _('en:Replication Targets'),
		'description' => _('en:This is a list of target information on where replicated data should be sent. Its value is a list that looks like') . ' targetName,targetUrl,identified,targetName,targetUrl,identified... ' 
		. _('en:Every set of three values represents one replication target. ‘targetName’ is a unique name for this replication. ‘targetUrl’ is the URL where the read files should be sent to. ‘identified’ has either a value of either ‘identified’ or ‘deidentified’. When the value is ‘deidentified’ certain identifying fields will be set to null.') . ' '
		. _('en:By default identified and deidentified data will be sent to isante-consolidated.cirg.washington.edu and forwarded to isante.ugp.ht'),
		'required' => false,
		'changeable' => true,
		'validationRegexp' => null,
		'enumerations' => null), 
	'backupEncryptionKey' => array(
		'name' => _('en:Backup Encryption Key'),
		'description' => _('en:This value is used to encrypt backup files. If no value is provided backup files will not be encrypted. Encrypted backup files can not be used unless the encryption key is known.'),
		'required' => false,
		'changeable' => true,
		'validationRegexp' => null,
		'enumerations' => null),
	'dbsite' => array('name' => _(
		'en:dbSite Code'),
		'description' => _('en:The numeric dbSite code for this database. dbSite codes are unique to particular site and should never be changed.'),
		'required' => true,
		'changeable' => false,
		'validationRegexp' => '^[0-9]{1,3}$',
		'enumerations' => null),              
	'defsitecode' => array('name' => _(
		'en:Default siteCode'),
		'description' => _('en:The default siteCode used for new users.'),
		'required' => true,
		'changeable' => false,
		'validationRegexp' => '^[0-9]{5}$',
		'enumerations' => null),  
	'ldapbasedn' => array('name' => _(
		'en:LDAP Directory Base DN'),
		'description' => _('en:This is an LDAP DN containing the users and groups OU that iSanté uses for authentication. e.g.') . ' ou=itech-dev,dc=uccmspp,dc=org',
		'required' => true,
		'changeable' => true,
		'validationRegexp' => null,
		'enumerations' => null), 
	'ldaphost' => array('name' => _(
		'en:LDAP Directory Server URI'),
		'description' => _('en:This is the URI of the LDAP server. By default the value is') . ' ldap://localhost/',
		'required' => false,
		'changeable' => true,
		'validationRegexp' => null,
		'enumerations' => null)
	);
}

?>
