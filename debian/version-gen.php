#!/usr/bin/php
<?php

$versionConfig = parse_ini_file('support/version.ini');

print 'version = ' . $versionConfig['version'] . "\n";
print 'planned = ' . $versionConfig['planned'] . "\n";
print 'unplanned = ' . $versionConfig['unplanned'] . "\n";

if (isset($argv[1])) {
  print 'type = "' . $argv[1] . "\"\n";
}

$versionFull = exec("php -r \"require_once 'backend/version.php'; print __getAppVersion();\"");
preg_match('/\((.*?)\)/', $versionFull, $matches);
print 'revision = "' . $matches[1] . "\"\n";

?>