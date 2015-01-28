<?php
require_once 'backend/database.php';

function recordSchemaUpdate($version, $upgradeFileName) {
  if (databaseTableExists('schemaVersion')) {
    database()->query('insert into schemaVersion set version=?, scriptName=?;',
		      array($version, $upgradeFileName));
  } else if (databaseTableExists('appVersion')) {
    //try the old appVersion table
    database()->query('insert into appVersion set verOrder=?, scriptName=?, whenUpgraded=now();',
		      array($version, $upgradeFileName));
  } else {
    _isante_dbError('schemaVersion or appVersion must exist.', array());
  }
}

/* uses schemaVersion or appVersion table to apply any required script upgrades to the database */
function applyDbUpgrade() {
  $mysqlCommandPrefix = 'mysql --defaults-file=' . DB_CONFIG_FILE;

  // add mysql procedures for dropping and adding indexes and adding columns to tables into db unless they are already there 
  system($mysqlCommandPrefix . ' < support/schema-procedures.sql');

  $currentSchemaVersion = getCurrentSchemaVersion();
  $schemaUpgradeFileAndVersion = getDatabaseSchemaUpgradeFiles();

  foreach ($schemaUpgradeFileAndVersion as $version => $upgradeFileName) {
    //skip upgrade files that have already been applied
    if ($version <= $currentSchemaVersion) {
      continue;
    }

    echo "\nScript: " . $upgradeFileName . "\n";
    $fileHandle = fopen($upgradeFileName, 'r');
    $buffer = '';
    while ($cmd = fgets($fileHandle)) {
      if (substr($cmd,0,2) != "/*" && strlen($cmd) > 0) {
	if (strtolower(substr($cmd,0,2)) == 'go') {
	  preprocessAndDbQuery(ltrim($buffer));
	  $buffer = '';
	} else {
	  $buffer .= ' ' . $cmd;
	}
      }
    }
    fclose($fileHandle);

    //special version 26 procedures (support/schema-updates/0026-90rc2updates.sql)
    if ($version == 26) {
      $configInsert = database()->prepare('insert into config set `name`=?, `value`=?');

      //load configuration parameters from config.ini and then remove it
      $legacyConfig = parse_ini_file('/etc/itech/config.ini');
      $configInsert->execute(array('dbsite', $legacyConfig['dbsite']));
      $configInsert->execute(array('defsitecode', $legacyConfig['defsitecode']));
      
      if (array_key_exists('serverRole', $legacyConfig)) {
	$serverRole = $legacyConfig['serverRole'];
      } else {
	$serverRole = 'production';
      }
      $configInsert->execute(array('serverRole', $serverRole));
      
      $ldapbasednMatches = array();
      preg_match('/^ou=users,(.*)/', $legacyConfig['ldapbasedn'], $ldapbasednMatches);
      $configInsert->execute(array('ldapbasedn', $ldapbasednMatches[1]));
      
      system('rm -rf /etc/itech');
      
      //remove old replication files since we are restarting replication from scratch
      system('rm -rf /var/backups/itech/replication');
    }

    recordSchemaUpdate($version, $upgradeFileName);
  }

  echo "\n";
  system($mysqlCommandPrefix . ' < support/schema-views.sql');
  echo "Completed view refresh\n"; 

  /* In some cases, the isanteForms table didn't get created, which causes a huge amount of error messages
   * in the lookup table updating below.
   * Just in case, drop and create it again here.
   */
  database()->exec('drop table if exists isanteForms');
  database()->exec('CREATE TABLE isanteForms ( 
encType int(11) NOT NULL ,
formVersion tinyint(4) NOT NULL ,
section tinyint(4) NOT NULL ,
field int(4) NOT NULL ,
labelEn varchar(50) default NULL ,
labelFr varchar(50) default NULL ,
conceptKey varchar(50) default NULL ,
default_value varchar(50) default NULL ,
conceptOrTable varchar(30) default NULL ,
UNIQUE KEY dictionaryIndex (encType, formVersion , section , field) 
) ENGINE = InnoDB DEFAULT CHARSET = utf8'); 

  echo "\n";
  echo "Updating lookup tables...\n";
  $currentDir = getcwd();
  chdir('replication');
  system('perl updateTarget.pl --truncateTables --file lookups.csv.gz');
  chdir($currentDir);
  echo "Completed updating lookup tables\n";

  // put guids on any patients that don't have them
  genGuids(); 

  /* truncate pepfar table so we are sure it is up to date */
  database()->exec('truncate table pepfarTable');
                            
  /* truncate hivQual table so we are sure it is up to date */
  database()->exec('truncate table hivQual');
                            
  /* ditto for healthQual table */
  database()->exec('truncate table healthQual');
                            
  /* repair issue #55 (cause #2) by deleting encounters for deleted patients */
  database()->exec('
 UPDATE encounter SET encStatus = 255, lastModified = now()
 WHERE patientID IN (SELECT patientID FROM patient WHERE patStatus = 255)');

  /* promote all UI config values, 0 and 1 are no longer supported, should
   become 2 and 3 respectively */
  database()->exec('
 UPDATE userPrivilege SET uiConfiguration = uiConfiguration + 2
 WHERE uiConfiguration IN (0, 1)');

  /* run batch jobs so splash screen is ok. */
  system('php batch-jobs.php -f');
  /* 
   * takes too long to run this during upgrade -- it can run the next time cron runs
  system('php patientStatusBatch.php'); 
   */

  echo "Upgrade finished\n";
}

function preprocessAndDbQuery ($buffer) {
  echo $buffer;
  $bufArray = explode (' ', $buffer);
  if (strtolower($bufArray[0]) . strtolower($bufArray[1]) == 'createindex') {
    // don't create the index if it already exists
    $qry = 'show index from ' . $bufArray[4];
    $result = dbQuery($qry);
    $flag = false;
    while ($row = psRowFetch($result)) {
      if ($row['Key_name'] == $bufArray[2]) $flag = true;
      if ($flag) break;
    }
    if (! $flag) dbQuery($buffer);
  } elseif (strtolower($bufArray[0]) . strtolower($bufArray[1]) . strtolower($bufArray[3]) == 'altertableadd') {
    $qry = "
select 'yes' from information_schema.columns where table_schema = '" . DB_NAME . "' and
table_name = '" . $bufArray[2] . "' and column_name = '" . $bufArray[4] . "'";
    echo $qry;
    $result = dbQuery ($qry);
    $row = psRowFetch($result);
    if ($row[0] != 'yes') dbQuery ($buffer);
  } else {
    dbQuery($buffer);
  }
}

function genGuids () {
  // Populate the 'patGuid' column for all existing patients that don't have one
  $cnt = 0;
  $uuids = array ();
  $pids = array ();
  $result = dbQuery ("select patientID from patient where patGuid is null or patGuid = ''");
  while ($row = psRowFetch($result)) {
    array_push ($pids, $row[0]);
  }
  $cnt = count ($pids);
  if ($cnt > 0) {
    exec ("java -cp support uuidGen $cnt", $uuids);
    for ($i = 0; $i < $cnt; $i++) {
      $result = dbQuery ("update patient set patGuid = '" . $uuids[$i] . "' where patientID = '" . $pids[$i] . "'");
    }
  }
}

?>
