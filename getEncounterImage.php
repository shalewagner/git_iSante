<?php

require_once ("backendAddon.php");

// open the file in a binary mode
$fp = fopen (getEncounterFilePath ($_REQUEST['eid'], $_REQUEST['fname'], DB_SITE), 'rb');

// send the right headers
header ("Content-Type: image/png");
header ("Content-Length: " . filesize(getEncounterFilePath ($_REQUEST['eid'], $_REQUEST['fname'], DB_SITE)));

// dump the picture and stop the script
fpassthru ($fp);
exit;

?>
