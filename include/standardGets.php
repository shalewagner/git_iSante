<?php
$user = getSessionUser ();
$userAccessLevel = getAccessLevel ($user);

//if (empty($lang)) $lang = "fr";
if (empty($site)) $site = getDefaultSite($user);

// only set $code if $_GET['code'] is set
//if  (isset ($_GET['code']) ) $code = $_GET['code'];

if (!empty ($_GET['type'])) {
	$type = $_GET['type'];
} else {
	$type = "0";
	$formNm = ""; 
}

if($type == "0" || !is_numeric($type)){
	$version = 0;
} else {
	if (isset($_GET['version']))
		$version = $_GET['version'];
	else if (in_array($type,array(6,19)) && getConfig('labOrderUrl') != Null && !isset($_REQUEST['eid'])) 
		$version = 3;
	else 
		$version = $formVersion[$type];
}

if ($type == "10" && empty($_GET['pid'])) $version = "1";
$rtype = (!empty ($_GET['rtype'])) ? $_GET['rtype'] : "qualityCare";

// Pre-populate fields if an encounter ID or patient ID was given
$existingData = array ();
if (!empty ($_GET['eid']) && preg_match ('/^\d+$/', $_GET['eid'])) {
	$eid = $_GET['eid'];
	getExistingData ($eid, $tables);
} else {
	$eid = "";
}

// Shouldn't need this anymore because getPatientData is part of getExistingData
// if (!empty ($_GET['pid']) && preg_match ('/^\d+$/', $_GET['pid'])) {
if ($pid != "") {
	//$pid = $_GET['pid'];
	getPatientData ($pid); 
} 

if(isset($_GET['nationalID'])){
	$natID=$_GET['nationalID'];
}
if(isset($_GET['clinicPatientID'])){
	$clinicID=$_GET['clinicPatientID'];
}
?>
