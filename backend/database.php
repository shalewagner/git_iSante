<?php

#If no DB_CONFIG_FILE is defined then define a default one.
#This is normally defined in backend/config.php but some scripts can't use it.
if (! defined('DB_CONFIG_FILE')) {
  define('DB_CONFIG_FILE', '/etc/isante/my.cnf');
}
$databaseConfig = parse_ini_file(DB_CONFIG_FILE, true);
define('DB_NAME', $databaseConfig['client']['database']);
define('TEMP_DB', DB_NAME);
define('DB_SERV', $databaseConfig['client']['host']);
define('DB_USER', $databaseConfig['client']['user']);
define('DB_PASS', $databaseConfig['client']['password']);

require_once 'backend/database-mssql.php';
require_once 'backend/database-mysql.php';

//return true if the table named $tableName exists in the database named $databaseName, false otherwise
function databaseTableExists($tableName, $databaseName = null) {
  if (is_null($databaseName)) {
    $databaseName = DB_NAME;
  }

  $tableExists = database()->query('
SELECT * FROM information_schema.TABLES
where TABLE_SCHEMA = ?
 and TABLE_NAME = ?;', array($databaseName, $tableName));
  
  return (count($tableExists->fetchAll()) == 1);
}

function getDatabaseSchemaUpgradeFiles() {
  $schemaUpgradeFiles = glob('support/schema-updates/[0-9]*-*.sql');
  $schemaUpgradeFileAndVersion = array();
  foreach ($schemaUpgradeFiles as $schemaUpgradeFile) {
    $preg_matches = array();
    if (preg_match('/support\/schema-updates\/([0-9]+)-.*?\.sql$/',
		   $schemaUpgradeFile, $preg_matches) == 1) {
      $schemaUpgradeFileAndVersion[$preg_matches[1]+0] = $schemaUpgradeFile;
    }
  }
  ksort($schemaUpgradeFileAndVersion);
  return $schemaUpgradeFileAndVersion;
}

function getCurrentSchemaVersion() {
  if (databaseTableExists('schemaVersion')) {
    return database()->query('select max(version) from schemaVersion;')->fetchColumn();
  } else if (databaseTableExists('appVersion')) {
    //New installs of 9.0RC2 got the wrong value put in verOrder. This first query fixes that.
    database()->query('
update appVersion 
set verOrder = 26 
where dbVersion = ?
 and scriptName = ?
 and verOrder = 25
 and proofColumn = ?', array('9.0 RC2', 'dummy', 'dummy'));
    return database()->query('select max(verOrder) from appVersion;')->fetchColumn();
  } else {
    _isante_dbError('schemaVersion or appVersion must exist.', array());
  }
}

function isDatabaseSchemaUpToDate() {
  if (isset($_SESSION) && isset($_SESSION['currentSchemaVersion'])) {
    $currentSchemaVersion = $_SESSION['currentSchemaVersion'];
  } else {
    $currentSchemaVersion = getCurrentSchemaVersion();
    if (isset($_SESSION)) {
      $_SESSION['currentSchemaVersion'] = $currentSchemaVersion;
    }
  }

  if (isset($_SESSION) && isset($_SESSION['lastSchemaUpgradeFile'])) {
    $lastSchemaUpgradeFile = $_SESSION['lastSchemaUpgradeFile'];
  } else {
    $schemaUpgradeFileAndVersion = getDatabaseSchemaUpgradeFiles();
    end($schemaUpgradeFileAndVersion);
    $lastSchemaUpgradeFile = key($schemaUpgradeFileAndVersion);
    if (isset($_SESSION)) {
      $_SESSION['lastSchemaUpgradeFile'] = $lastSchemaUpgradeFile;
    }
  }

  $isisDatabaseSchemaUpToDate = $currentSchemaVersion >= $lastSchemaUpgradeFile;

  if (! $isisDatabaseSchemaUpToDate) {
    //if schema is not up to date make sure we check again next time
    unset($_SESSION['currentSchemaVersion']);
    unset($_SESSION['lastSchemaUpgradeFile']);
  }

  return $isisDatabaseSchemaUpToDate;
}

?>