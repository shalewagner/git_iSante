<?php

require_once 'backendAddon.php';

if (isset($_REQUEST['dbSite'])) {
  passthru(getEncounterFilePath($_REQUEST['encounterId'], $_REQUEST['fileSuffix'],
				$_REQUEST['dbSite']));
} else {
  passthru(getEncounterFilePath($_REQUEST['encounterId'], $_REQUEST['fileSuffix']));
}
  
?>