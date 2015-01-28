<?php

exit(); #this script normally shouldn't be run

$_REQUEST['noid'] = 'true';
chdir('/var/www/isante');
require_once 'backendAddon.php';

$dbSite = $_REQUEST['dbSite'];
$discontinuationsPath = getPatientTransferDir() . '/discontinuationsPending';

#figure out which sites are included at this dbSite and have a directory in $discontinuationsPath
$sitesToCheck = array();
$rows = dbSelectQuery("select siteCode from clinicLookup where dbSite = '$dbSite'");
while ($row = psRowFetch($rows)) {
  if (stat($discontinuationsPath . '/' . $row['siteCode']) != false) {
    array_push($sitesToCheck, $row['siteCode']);
  }
}

#output the contents of any pending *.genericsave files
$filesToXmit = array();
foreach ($sitesToCheck as $site) {
  $sitePath = $discontinuationsPath . '/' . $site;
  $sentPath = $sitePath . '/sent';
  mkdir($sentPath, 0770, true);
  foreach (glob($sitePath . '/*.genericsave') as $fileName) {
    $filesToXmit[$fileName] = $sentPath;
    readfile($fileName);
  }
}

#try to make sure everything has been written to the client
flush();

#move transmitted files into /sent folders
foreach ($filesToXmit as $fileName => $newPath) {
  exec("mv \"$fileName\" \"$newPath\"");
}

?>