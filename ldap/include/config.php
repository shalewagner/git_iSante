<?php
/**
 * Local configuration
 *
 * See config.default.php for a description of each setting and the default
 * values.
 */

// Development settings
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Read LDAP settings from I-TECH application INI file.
$cwd = getcwd();
chdir('..');
require_once 'backend/config.php';
chdir($cwd);
$cfg['base_dn'] = 'ou=users,' . LDAP_BASE_DN;

$cfg['host'] = "localhost";
//$cfg['use_tls'] = false;
//$cfg['auth_type'] = "config";
$cfg['auth_type'] = "session";
//$cfg['bind_dn'] = "";
//$cfg['bind_pass'] = "";
//$cfg['base_dn'] = "";
//$cfg['pw_hash'] = "md5";
$cfg['pw_hash'] = "ssha";
$cfg['lang'] = "fr";
?>
