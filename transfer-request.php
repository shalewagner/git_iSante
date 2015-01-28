<?php 
require_once 'include/AJAX_PROGRESS.class.php';
require_once 'backend.php';
  
$msgArray = array (
	"en" => array ("Connecting", "Exporting...Connection took ", "Importing..Exporting took ","Finished...Importing took "),
	"fr" => array ("Connexion en cours", "Exportation... Dur&eacute;e de la connexion:  ", "Importation en cours... Dur&eacute;e de l'exportation: ","Termin&eacute;...Dur&eacute;e de l'importation:")
);

list($usec, $sec) = explode(' ', microtime());
$script_start = (float) $sec + (float) $usec;
$script_begin = $script_start;

$pb=new AJAX_PROGRESS();

/*** include routine to generate and fetch tar file from national server 
 *** tar file contains data for transfer record, registration record and clinical summary file 
 *** intermediate timing for the connection is part of the routine, thus progress 2 is inside it
***/ 
if ($progress) $pb->advance(1/5,'Start', $msgArray[$_REQUEST['lang']][0]);
include "natlServerProxy.php";

list($usec, $sec) = explode(' ', microtime());
$script_end = (float) $sec + (float) $usec;
$elapsed = round($script_end - $script_start, 5);
$script_start = $script_end;
if ($progress) $pb->advance(3/5,'Import', $msgArray[$_REQUEST['lang']][2] . " " . $elapsed);
  
/*** include routine to process the tar file and generate new pid and eid for transfer record on the local server; if newpid is given, don't generate new pid
 *** 
 ***/ 
include "import-request.php";

if ($progress) $pb->advance(4/5,'Finishing', $timing); 
if ($progress) $pb->advance(5/5,'Finished request', $output);
$pb=null;
?>
