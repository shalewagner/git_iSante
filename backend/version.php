<?php

function __getAppVersion($versionIniFile = 'support/version.ini') {
  $versionConfig = parse_ini_file($versionIniFile);
  $appVersion = $versionConfig['version'] . '.' . $versionConfig['planned'];
  if ($versionConfig['unplanned'] != 0) {
    $appVersion = $appVersion . '.' . $versionConfig['unplanned'];
  }
  if (isset($versionConfig['type']) && $versionConfig['type'] != '') {
    $appVersion = $appVersion . ' ' . $versionConfig['type'];
  }
  if (isset($versionConfig['revision']) && $versionConfig['revision'] != '') {
    $revision = $versionConfig['revision'];
  } else {
    $revision = exec('LANG=C svn info | grep "Last Changed Rev:" | grep -o [0-9]*');
    if (strlen(exec('LANG=C svn status')) != 0) {
      $revision = $revision . '+';
    }
  }
  $appVersion = $appVersion . ' (' . $revision . ')';
  return $appVersion;
}

?>