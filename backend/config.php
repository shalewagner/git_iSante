<?php

session_start();

#database configuration file
define('DB_CONFIG_FILE', '/etc/isante/my.cnf');

#all constant global defines and arrays
require_once 'backend/constants.php';

#generate APP_VERSION constant
require_once 'backend/version.php';
define('APP_VERSION', __getAppVersion());
#some example version strings, the first is the longest string and the next two are typical release version strings
#define('APP_VERSION', '00.0.0 test (0000+)');
#define('APP_VERSION', '12.1 (5432)');
#define('APP_VERSION', '12.1.2 (5432)');

#set an appropriate timezone for Haiti
date_default_timezone_set('America/Port-au-Prince');

#create and define a temporary file location
define('TEMP_DIR', '/tmp/itech');
if (!is_dir(TEMP_DIR)) {
  if (!mkdir(TEMP_DIR, 0750)) {
    die('Could not create itech temp folder.');
  }
}

#load the right l10n based on request parameters or default to French
if (isset($_REQUEST['lang'])) {
  if ($_REQUEST['lang'] == 'en') {
    putenv('LANG=' . 'en_US');
    setlocale(LC_ALL, 'en_US');
  } else {
    putenv('LANG=' . $_REQUEST['lang'] . '_' . strtoupper($_REQUEST['lang']));
    setlocale(LC_ALL, $_REQUEST['lang'] . '_' . strtoupper($_REQUEST['lang']));
  }
} else {
  putenv('LANG=' . 'fr_FR');
  setlocale(LC_ALL, 'fr_FR');
}
bindtextdomain('messages', './locale');
textdomain('messages');
define('CHARSET', 'UTF-8');
bind_textdomain_codeset('messages', 'UTF-8');

#need database functions for the rest
require_once 'backend/database.php';

#This function gets local configuration settings stored in the `config` table. Returns $default if no value is found.
function getConfig($name, $default = null, $reread = false) {
  static $configItems = null;

  if (is_null($configItems) || $reread) {
    $configItems = array();
    $result = database()->query('select * from config;');
    while ($row = $result->fetch()) {
      $configItems[$row['name']] = $row;
    }
  }
  if (array_key_exists($name, $configItems)) {
    return $configItems[$name]['value'];
  } else {
    return $default;
  }
}

#define constants for commonly used config parameters
define('DB_SITE', getConfig('dbsite'));
define('DEF_SITE', getConfig('defsitecode'));
define('LDAP_HOST', getConfig('ldaphost', 'ldap://localhost/'));
define('LDAP_BASE_DN', getConfig('ldapbasedn'));
define('SERVER_ROLE', getConfig('serverRole'));

?>