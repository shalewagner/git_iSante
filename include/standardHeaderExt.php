<?php
// Setting session variable 
require_once 'backend.php';
require_once 'backend/constants.php';
if (DEBUG_FLAG) {
	require_once 'firePHP/lib/FirePHPCore/FirePHP.class.php';
	require_once 'firePHP/lib/FirePHPCore/fb.php';
	ob_start();
	$firephp = FirePHP::getInstance(true);
}

$pid = "";
$lang = "fr";
$site = "";

if (isset ($_REQUEST['pid'])) $pid = $_REQUEST['pid'];
if (isset ($_REQUEST['lang'])) $lang = $_REQUEST['lang'];
if (isset ($_REQUEST['site'])) $site = $_REQUEST['site'];
if (isset ($_REQUEST['lastPid'])) $lastPid = $_REQUEST['lastPid'];

if ($pid != "")  $lastPid = $pid;
if (!isset($lastPid)) $lastPid = '';

$scriptName = basename($_SERVER["SCRIPT_NAME"]);

/*** This block of code saves the old-style form before displaying the patienttabs for that patient
 *** works by including genericsave.php, which handles all saving
 ***/
if (empty($_GET) && $scriptName == "patienttabs.php") { 
	// add the flag so that after a form save, patienttabs returns to the demo tab or the forms list, respectively, depending upon where the user started
	if (($_POST['type'] == 10 || $_POST['type'] == 15) && $_REQUEST['tabcall'] == 1) $_GET['tab'] = 'demo';
	else $_GET['tab'] = 'forms';
	require_once("genericsave.php");
	/* this code was needed for the old patient transfer protocol -- no longer used 
	if (isset($_POST['clinicName']) && isset($_POST['reasonDiscTransfer']) && $_POST['reasonDiscTransfer'] == "On") { 
		header ("Location: find.php?lang=$lang");  
	}  */
} 

require_once 'include/standardGets.php'; 

/*** This block of code merges patients together if selected as a pidCollection in the find page 
 *** all patients merged have their person_id and patientID change to the designated patient in all tables
 *** the merged patients registration records are deleted, with their masterPid set to the designated patient
 *** Added 10/23/2013 If patient being merged has a fingerprint on file, while the preferred patient doesn't--switch the fingerprint handle to the preferred patient
 ***/
if (empty($_POST) && $scriptName == "patienttabs.php" && !empty($_GET['pidCollection'])) {
	$pidArray = split(',', $_GET['pidCollection']);
	$flag = true;
	dbBeginTransaction();
	foreach ($pidArray as $curPid) {
		if ($curPid != $pid) { 
			// move fingerprint to the preferred patient if she doesn't have one and the merger does
			if (getConfig('fingerprintURL') != Null) {
				if (!hasFingerprints(getMasterPid($pid)) && hasFingerprints(getMasterPid($curPid))) $status = changeFingerprintID(getMasterPid($curPid), getMasterPid($pid));
				if (!$status) echo "failed to change fingerprint handle";
			}
			// set the old patient record status = 1 (patient was merged with another in the same site)
			$qry = "update patient set 
				masterPid = '" . $pid . "', 
				patStatus = 1 
				where patientid = '" . $curPid . "' and location_id = " . substr($curPid,0,5);
			$retVal = dbQuery($qry);
			if (!$retVal) {
				$flag = false;
				break;
			}
			// delete the registration record for the old patient
			$qry = "update encounter set 
				encStatus = 255, 
				lastModified = getDate() 
				where patientid = '" . $curPid . "' and sitecode = '" . substr($curPid,0,5) . "'   and encountertype in (10,15)";
			$retVal = dbQuery($qry);
			if (!$retVal) {
				$flag = false;
				break;
			}
			// get current max seqNum for preferred patient to use in updates
			$qry = "select max(seqNum) + 1 as 'theMax' from encounter where patientid = '" . $pid . "'";
			$retVal = dbQuery($qry);
			if (!$retVal) {
				$flag = false;
				break;
			} else {
				$row = psRowFetchAssoc($retVal);
				$maxSeqNum = $row['theMax'];
			} 
			// update the encounter records for the old patient to be the preferred pid  
			$qry = "update encounter set 
				patientid = '" . $pid . "', 
				lastModified = getDate(), 
				seqNum = seqNum + " . $maxSeqNum . " 
				where patientid = '" . $curPid . "' and sitecode = '" . substr($curPid,0,5) . "' and encStatus < 255";
			$retVal = dbQuery($qry);
			if (!$retVal) {
				$flag = false;
				break;
			}
			// update all tables in the database (except obs--see above) with the preferred patient pid
			foreach ($tables as $tab) {
				$qry = "update " . $tab . " set 
					patientid = '" . $pid . "', 
					seqNum = seqNum + " . $maxSeqNum . " 
					where patientid = '" . $curPid . "' and sitecode = '" . substr($curPid,0,5) . "'";
				$retVal = dbQuery($qry);
				if (!$retVal) {
					$flag = false;
					break;
				}
			}
			// shift obs old pid to the preferred pid
			$qry = "update obs set 
				person_id = " . substr($pid,5) . "  
				where person_id = " . substr($curPid,5) . " and location_id = " . substr($pid,0,5);    
			$retVal = dbQuery($qry);
			if (!$retVal) {
				$flag = false;
				break;
			}
		}  
	}
	if ($flag) {
		dbCommit();
	} else {
		dbRollback();
		header ("Location: error.php?type=patID&lang=$lang");
	}
}
/*** This block of code deletes the patient currently viewed in patienttabs and then displays the find page
 *** 
 ***/
if (empty($_GET) && $scriptName == "find.php" && isset($_POST['deletePatient']) && $_POST['deletePatient'] == "exists") { 
	if (hasFingerprints(getMasterPid($pid))) deleteFingerprints(getMasterPid($pid));
	$retCode = delPatient($pid);
	if ($retCode == false){
		header ("Location: error.php?type=patID&lang=$lang");
		exit;
	} else {
		$pid="";
		$lastPid = "";
	}
}

require_once 'labels/bannerLabels.php';
require_once 'labels/labels.php';
require_once 'labels/menu.php';
if (!headers_sent()) {
  header('Content-Type: text/html; charset=utf-8');
}
?><!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="x-ua-compatible" content="IE=8">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" type="text/css" href="ext-<?= EXTJS_VERSION ?>/resources/css/ext-all.css">
<link rel="stylesheet" type="text/css" href="ext-<?= EXTJS_VERSION ?>/resources/css/xtheme-gray.css">
<link rel="stylesheet" type="text/css" href="tabs.css?<?= urlencode(APP_VERSION) ?>">
<link rel="stylesheet" type="text/css" href="include/RadioColumn.css?<?= urlencode(APP_VERSION) ?>">
<link rel="stylesheet" type="text/css" href="ext-<?= EXTJS_VERSION ?>/resources/css/xtheme-blue.css">
<link rel="stylesheet" type="text/css" href="bootstrap.css?<?= urlencode(APP_VERSION) ?>">
<link rel="stylesheet" type="text/css" href="default.css?<?= urlencode(APP_VERSION) ?>">
<style type="text/css">
	.original-icon-save {
		background-image:url(images/silk_icons_v013/img/table_save.png) !important;
	}
</style>
<!--[if lte IE 7]>
  <link rel="stylesheet" type="text/css" href="default-ie7.css">
<![endif]-->
<!--[if ie 9]>
  <link rel="stylesheet" type="text/css" href="default-ie9.css">
<![endif]-->
<link rel="stylesheet" type="text/css" media="print" href="print.css">
<script type="text/javascript" src="jquery-<?= JQUERY_VERSION ?>.js"></script>
<script type="text/javascript" src="ext-<?= EXTJS_VERSION ?>/<?= EXTJS_ADAPTER ?>"></script>
<script type="text/javascript" src="ext-<?= EXTJS_VERSION ?>/ext-all.js"></script>
<script type="text/javascript" src="ext-<?= EXTJS_VERSION ?>/src/locale/ext-lang-<? echo $lang ?>.js"></script>
<script type="text/javascript" src="ext-<?= EXTJS_VERSION ?>/examples/ux/CheckColumn.js"></script>
<script type="text/javascript" src="include/jshashtable.js?<?= urlencode(APP_VERSION) ?>"></script>
<script type="text/javascript" src="include/RadioColumn.js?<?= urlencode(APP_VERSION) ?>"></script> 
<script type="text/javascript" src="include/ie-compatibility.js?<?= urlencode(APP_VERSION) ?>"></script> 
<script type="text/javascript" src="include/browserDetect.js?<?= urlencode(APP_VERSION) ?>"></script>
<script type="text/javascript" src="include/bootstrap-dropdown.js?<?= urlencode(APP_VERSION) ?>"></script>

<script type="text/javascript">
<?php if ($lang != 'fr') { ?>
    //force date format to be d/m/y no matter what language is being used
    //recklessly copied from ext-3.4.0/src/locale/ext-lang-fr.js
    if(Ext.util.Format){
	Ext.util.Format.date = function(v, format){
	    if(!v) return "";
	    if(!Ext.isDate(v)) v = new Date(Date.parse(v));
	    return v.dateFormat(format || "d/m/Y");
	};
	Ext.util.Format.plural = function(v, s, p) {
	    return v + ' ' + (v <= 1 ? s : (p ? p : s + 's'));
	};
    }
    if(Ext.DatePicker){
	Ext.apply(Ext.DatePicker.prototype, {
		format            : "d/m/y"
	});
    }
    if(Ext.form.DateField){
	Ext.apply(Ext.form.DateField.prototype, {
		format            : "d/m/y",
		altFormats        : "d/m/Y|d-m-y|d-m-Y|d/m|d-m|dm|dmy|dmY|d|Y-m-d"
	});
    }
    if(Ext.grid.PropertyColumnModel){
	Ext.apply(Ext.grid.PropertyColumnModel.prototype, {
		dateFormat : "d/m/Y"
    	});
    }
<?php } ?>


	Ext.BLANK_IMAGE_URL = 'ext-<?= EXTJS_VERSION ?>/resources/images/default/s.gif';
	function getCheckedValue(radioObj) {
		if (!radioObj) {
			return '0';
		}
		radioLength = radioObj.length;
		if (radioLength === undefined) {
			if(radioObj.checked) {
				return radioObj.value;
			}else{
				return '0'; 
			}
		}
		for (i = 0; i < radioLength; i++) {
			if (radioObj[i].checked) {
				return radioObj[i].value;
			}
		}
		return '0';
	}
        // some variables to hold values that should be changed in the banner
        // if/when the form is saved.
        var newHivLabel = '';
        var newSexLabel = '';
        var newClinSumLinkLabel = '';  
	function updateBannerIfChanged () {
	  // Update banner values, if changed
	  if (newHivLabel != '')
	    parent.document.getElementById('hivStatusId').firstChild.data = newHivLabel;
	  if (newSexLabel != '')
	    parent.document.getElementById('genderDisplayId').firstChild.data = newSexLabel;
	  if (newClinSumLinkLabel != '')
	    parent.document.getElementById('clinSumLinkId').innerHTML = newClinSumLinkLabel;
	}
</script>
<?
if ( $type != 0 ) {
	// Processing a form;
	if ($pid == ""){
		// must be a patient registration (no pid yet)
		require_once("banner.php");
	}
} else {
	// running a report or other non-form
	require_once("banner.php");
}
require_once 'include/errorHead.php';
echo "<script type=\"text/javascript\" src=\"include/util.js\"></script>";
?>
