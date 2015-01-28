<?php
chdir("..");
require_once "backend.php";
require_once "backend/fingerprint.php";      
$task = ($_REQUEST['task']) ? ($_REQUEST['task']) : null;
switch($task) {
	case "getFingerprintPid":
		$pid = getFingerprintPid($_REQUEST['leftbiodata']);
		break; 
	case "registerFingerprints":
		$pid = registerFingerprints($_REQUEST['Leftbiodata'],$_REQUEST['LeftbiodataType'],$_REQUEST['Rightbiodata'],$_REQUEST['RightbiodataType'],$_REQUEST['id']);
		break;
	case "deleteFingerprintPid":
		$pid = deleteFingerprintPid($_REQUEST['pid']);
		break;
	default:
		$pid = -1;
		break;
}//end switch 

if ($pid != '' && $pid != -1) {
	if ($task == "getinfo") {
		print $pid;
		exit; 
	} else  {
		$loc = "../patienttabs.php?pid=" . $pid . "&lang=" . $_REQUEST['lang'] . "&site=" . $_REQUEST['site']; 
	}
} else {
	$loc = "../find.php?qrystring=Patient%20inconnu&lang=" . $_REQUEST['lang'] . "&site=" . $_REQUEST['site'];
}
header("Location: " . $loc);
?>
