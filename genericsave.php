<?php
require_once 'backend/concept.php';
require_once 'backendAddon.php';

//if (!empty ($_POST)) $_POST = array_map ("urlencode", $_POST);
//print_r ($_POST);
//exit;

$errFields =  '';
if (isset ($_POST['errFields']) && !empty ($_POST['errFields'])) {
	$errFields = $_POST['errFields'];
}
$errMsgs =  '';
if (isset ($_POST['errMsgs']) && !empty ($_POST['errMsgs'])) {
	$errMsgs = $_POST['errMsgs'];
}

// If user is view-only, bail out
if (getAccessLevel (getSessionUser ()) === 0) {
  header ("Location: error.php?type=auth&lang=$lang");
  exit;
}

// Site *must* be provided.  Nothing else will work properly otherwise.
if (!isset ($_POST['site']) || empty ($_POST['site'])) {
  header ("Location: error.php?type=site&lang=$lang");
  exit;
} else {
  // Site *must* also be valid.  Nothing else will work properly otherwise.
  $site = lookupSite ($_POST['site']);
  if (!isset ($site) || empty ($site)) {
    header ("Location: error.php?type=site&lang=$lang");
    exit;
  }
}
// Type *must* be provided.
if (!isset ($_POST['type']) || empty ($_POST['type'])) {
  header ("Location: error.php?type=type&lang=$lang");
  exit;
} else {
	$type = $_POST['type'];
}
// Visit date must be provided and it must be a valid date
if (!isset ($_POST['visitDateYy']) || !isset ($_POST['visitDateMm']) || !isset ($_POST['visitDateDd']) || 
	empty ($_POST['visitDateYy']) || empty ($_POST['visitDateMm']) || empty ($_POST['visitDateDd']) ||
	strtotime($_POST['visitDateYy'] . "-" . $_POST['visitDateMm'] . "-" .  $_POST['visitDateDd']) === false) {
  header ("Location: error.php?type=badDate&lang=$lang");
  exit;
}

$encID = "";
if (!empty ($_POST['eid']) && preg_match ('/^\d+$/', $_POST['eid'])) $encID = $_POST['eid'];

if (!empty($_POST['jsonData'])) {
	$postAddon = json_decode($_POST['jsonData'],true);
	$_POST = array_merge($_POST, $postAddon); 
	unset($_POST['jsonData']);
}

// Sum multi-choice option arrays
// Also, escape single quotes and backslashes for MySql
foreach ($_POST as $name => $val) {
  if (is_array($val)) {
    $_POST[$name] = array_sum($val);
  } else {
    $_POST[$name] = str_replace('\'', '\'\'', $val);
    $_POST[$name] = str_replace('\\', '\\\\', $_POST[$name]);
  }
}

/* No longer using the 'checkedBoxes' and 'checkedRadios' arrays as they were */
/* causing errors where you couldn't uncheck a previously checked box or */
/* radio on an exisiting encounter.  Instead, we are now just nuking all */
/* previously existing data for the encounter before saving the POST data. */

// add unchecked checkboxes into the POST array
//if (isset($_POST['checkedBoxes']) && !empty($_POST['checkedBoxes'])) {
//	$ckList = split(",", $_POST['checkedBoxes']);
//	foreach ($ckList as $ck) {
//		if (array_key_exists ($ck,$_POST)) continue;
//		else $_POST[$ck] = "0";
//	}
//}

// add unchecked radios into the POST array
//if (isset($_POST['checkedRadios']) && !empty($_POST['checkedRadios'])) {
//	$cbList = split(",", $_POST['checkedRadios']);
//	foreach ($cbList as $cb) {
//		if (array_key_exists ($cb,$_POST)) continue;
//		else $_POST[$cb] = "0";
//	
//	}
//}

// Special case if patient is switching between pediatric and adult
if ($_POST['isPediatric'] && $type == "10") $type = "15";
if (! $_POST['isPediatric'] && $type == "15") $type = "10";

// Special case for ped. intake & followup forms. If 'nausea' was checked,
// also set 'vomiting' in the db.
if (($type == 16 || $type == 17) && isset ($_POST['nausea']) && $_POST['nausea'] == "On") $_POST['vomiting'] = "On";

// If no data entry comments were entered, don't append anything
$_POST['encComments'] = preg_replace ('/^\s*----------------- .*/', '', $_POST['encComments']);
if (preg_match ('/^\s*$/', $_POST['encComments'])) $_POST['encComments'] = NULL;

$pid = (empty ($_POST['pid']) || !preg_match ('/^\d+$/', $_POST['pid'])) ? "" : $_POST['pid'];
if ($encID != "") {
	// this is an already existing transaction
	// Fatal error if no pid or patient has been deleted at this point
	if (empty ($pid) || (!empty ($pid) && getStatusByPatientID ($pid) > 254)) {
		header ("Location: error.php?type=patID&lang=$lang&site=$site");
		exit;
	}
	$where = encounterKeysChanged ($site, $encID, $_POST['visitDateDd'], $_POST['visitDateMm'], $_POST['visitDateYy']);
	if ($where != "") {
		// If key fields for visitDatexx have changed, update the keys
                // Need to find highest value of seqNum for any existing
                // encounters with the new keys and inc. by 1. Use 0 if none.
                $newSeqNum = 0;
		$newWhere = " WHERE siteCode = '" . $site . "' AND patientID = '$pid' AND visitDateDd = '" . $_POST['visitDateDd'] . "' AND visitDateMm = '" . $_POST['visitDateMm'] . "' AND visitDateYy = '" . $_POST['visitDateYy'] . "'";
                $queryStmt = "SELECT TOP 1 seqNum FROM encounter " . $newWhere . " ORDER BY seqNum DESC";
                $result = dbQuery ($queryStmt); 
                $keys = psRowFetch ($result);
                if (is_numeric($keys['seqNum'])) 
                        $newSeqNum = $keys['seqNum'] + 1;

		foreach ($tables as $tab) {
			updEncounterKeys ($encID, $tab, $_POST['visitDateDd'], $_POST['visitDateMm'], $_POST['visitDateYy'], $newSeqNum, $where);
		}
		updEncounterKeys ($encID, "encounter", $_POST['visitDateDd'], $_POST['visitDateMm'], $_POST['visitDateYy'], $newSeqNum, $where);
	}
	// get the standard whereClause
	$encWhere = " WHERE " . getEncounterWhere ($encID, $pid);
	// Update encounter record for existing encounter
        // Set lastModified to NULL as a pseudo-transaction feature -
        // fill it in with the current time stamp at the end
	$tmpVisitDt = '';
	if(isset($_POST['visitDateYy']) && isset($_POST['visitDateMm']) && isset($_POST['visitDateDd'])) {
		$tmpVisitYy = $_POST['visitDateYy'];
		switch(strlen($tmpVisitYy)) {
			case 1: 
				$tmpVisitYy = '200' . $tmpVisitYy;
				break;
			case 2: 
				if($tmpVisitYy > 20)
					$tmpVisitYy = '19' . $tmpVisitYy;
				else
					$tmpVisitYy = '20' . $tmpVisitYy;
				break;
			case 3: 
				$tmpVisitYy = '0' . $tmpVisitYy;
				break;
			default:
		}
		$tmpVisitMm = $_POST['visitDateMm'];
		if(strlen($tmpVisitMm) == 1) {
			$tmpVisitMm = '0'.$tmpVisitMm;
		}
		$tmpVisitDd = $_POST['visitDateDd'];
		if(strlen($tmpVisitDd) == 1) {
			$tmpVisitDd = '0'.$tmpVisitDd;
		}
	}
	$tmpVisitDt = $tmpVisitYy . '-' . $tmpVisitMm . '-' . $tmpVisitDd;
	setByEncounterID ($encID, $encWhere, "encounter", array (
		"lastModifier" => getSessionUser(),
		"lastModified" => NULL,
		"encComments" => getFieldValue('encComments'),
		"formAuthor" => getFieldValue('formAuthor'),
		"formAuthor2" => getFieldValue('formAuthor2'),
		"labOrDrugForm" => getFieldValue('labOrDrugForm'),
		"nxtVisitDd" => getFieldValue('nxtVisitDd'),
		"nxtVisitMm" => getFieldValue('nxtVisitMm'),
		"nxtVisitYy" => getFieldValue('nxtVisitYy'),
		"visitDate" =>  $tmpVisitDt,
		"encounterType" => $type));
	/* toggle hiv Positive On/Off in primary care/ob-gyn forms
	if (in_array($type, array(24,25,27,28,29,31))) {
		$insertVals = array (); 
		if ($_POST['hivPositiveN'] == "On" || $_POST['hivPositiveA'] == "On") {
			$insertVals['hivPositive'] = 1; 
		} else {
			$insertVals['hivPositive'] = 0; 
		}
		setByEncounterID ($encID, $encWhere, "patient", $insertVals); 
	}*/
	$new = 0; 
	if(!empty($_POST['version'])) $curVersion = $_POST['version'];
	else $curVersion = $formVersion[$type];   
} else {
	// this is a new transaction
	if ($type == "10" || $type == "15") {
		// this is a new patient, but check if the patient already exists
        $insertVals = generateInsertArray ("patient");
        $pid = checkForExistingPatient($_POST['lname'],$_POST['fname'],$_POST['dobDd'],$_POST['dobMm'],$_POST['dobYy']);
        if (empty($pid) || $pid == "") {
        	$pid = addPatient ($site, $insertVals);
        } else {
			header ("Location: error.php?type=dupePatient&lang=$lang&pid=$pid");
			exit;
		}
	}

	// Fatal error if no pid at this point
	if (empty($pid) || $pid == "") {
		header ("Location: error.php?type=patID&lang=$lang&site=$site&eid=");
		exit;
	} else {
		$_POST['pid'] = $pid;
	}

	$_SESSION['pidList'] = $pid;
	// If there should only be one form of this type and a form already exists for this patient, bail out.
	if (($type == 10 && verifyExistingForm ($pid, 10)) ||
		($type == 1 && verifyExistingForm ($pid, 1)) ||
		($type == 15 && verifyExistingForm ($pid, 15)) ||
		($type == 16 && verifyExistingForm ($pid, 16))) {
    	header ("Location: error.php?type=dupe&lang=$lang");
    	exit;
	}
	// Check to see if all the keys match for this transaction, if it is a duplicate, bail out.
	$dupFlag = checkForDuplicateForm($type, $site, $pid, $_POST['visitDateDd'], $_POST['visitDateMm'], $_POST['visitDateYy']);
	if($dupFlag != ""){
    	header ("Location: error.php?type=dupekey&lang=$lang&dup=$dupFlag&encType=$type&pid=$pid");
    	exit;
	}
	if(!empty($_POST['version'])) $curVersion = $_POST['version'];
	else $curVersion = $formVersion[$type]; 

	$encID = addEncounter ($pid, $_POST['visitDateDd'], $_POST['visitDateMm'], $_POST['visitDateYy'], $site, date ("Y-m-d H:i:s"),
		$type, getFieldValue('encComments'), getFieldValue('formAuthor'), getFieldValue('formAuthor2'), getFieldValue('labOrDrugForm'),
		getFieldValue('nxtVisitDd'), getFieldValue('nxtVisitMm'), getFieldValue('nxtVisitYy'), $curVersion, getSessionUser(), date ("Y-m-d H:i:s"));
	$_POST['eid'] = $encID;
	$encWhere = " WHERE " . getEncounterWhere ($encID, $pid); 
	// set the patient to HIV positive status if adding a traditional adult/pediatric intake or followup form (implies HIV+) or any of the primary care/ob-gyn intake/fo forms
	if (in_array($type, array(1,2,16,17)) || (in_array($type, array(24,25,27,28,29,31)) && (isset($_POST['hivPositiveN']) || isset($_POST['hivPositiveA'])))) {
		$insertVals = array ();
		$insertVals['hivPositive'] = 1; 
		setByEncounterID ($encID, $encWhere, "patient", $insertVals); 
		if (in_array($type, array(1,16))) { 
			$_POST['hivPositiveN'] = 'On'; 
		} 
		if (in_array($type, array(2,17))) {
			$_POST['hivPositiveA'] = 'On';		
		}
	}
	$new = 1;

        // If this is a registration encounter, then also
        // create the 'external labs' encounter (type = 13)
        // to use for all external lab results for this patient.
        if (($type == 10 || $type == 15) && !verifyExistingForm ($pid, 13)) {
          addEncounter ($pid, $_POST['visitDateDd'], $_POST['visitDateMm'], $_POST['visitDateYy'], $site, date ("Y-m-d H:i:s"), 13, "External Lab Results Container", getFieldValue('formAuthor'), getFieldValue('formAuthor2'), getFieldValue('labOrDrugForm'), getFieldValue('nxtVisitDd'), getFieldValue('nxtVisitMm'), getFieldValue('nxtVisitYy'), NULL, getSessionUser(), date ("Y-m-d H:i:s"));
        }
}
if ($encWhere == "" || $encWhere == " WHERE ") die ("Failed to construct proper where clause");
 
// homeDirections is on the adult counseling enrollment form and needs to be
// stored in the patient table for both new and existing forms
if ($type == "3") {
  $insertVals = array ();
  $insertVals = generateInsertArray ("patient");
  if (!empty ($insertVals)) setByEncounterID ($encID, $encWhere, "patient", $insertVals);
}

// update the patient record if changing the registration form
if (!$new && in_array($type, array(10,15,24,25,27,28,29,31))) {
	// Update patient record
	$insertVals = array ();
	$insertVals = generateInsertArray ("patient");
	if (isset($insertVals['clinicPatientID'])) $insertVals['stid'] = preg_replace('/[^0-9]/', '', $insertVals['clinicPatientID']);
	unset ($insertVals['homeDirections']);
	if ($type == "10") {
		// this will preserve previous entries in pediatric patient record if status is switched back
		unset ($insertVals['fnameFather']);
		unset ($insertVals['medicalPoa']);
		unset ($insertVals['relationMedicalPoa']);
		unset ($insertVals['addrMedicalPoa']);
		unset ($insertVals['phoneMedicalPoa']);
		unset ($insertVals['addrMedicalPoaSection']);
		unset ($insertVals['addrMedicalPoaTown']);
		unset ($insertVals['addrContactSection']);
		unset ($insertVals['addrContactTown']);
	} else {
		// this will preserve previous values in adult patient record if status is switched back
		unset ($insertVals['occupation']);
	} 
	if ($insertVals['deathDt'] != '') {
		$deathDate = explode('/', $insertVals['deathDt']);
		$insertVals['deathDt'] = implode('-', array_reverse($deathDate)); 
	}
	if (!empty ($insertVals)) setByEncounterID ($encID, $encWhere, "patient", $insertVals);
}

// insert all concepts from all forms
insertConceptValues ($_POST);

// Allergies
if ($type == "1" || $type == "16" || $type == "17" || $type == "24" || $type == "25") {
  $allergyLabels = array (
  "Name" => array ("name" => "allergyName", "type" => "text"),
  "MM" => array ("name" => "allergyStartMm", "type" => "text"),
  "YY" => array ("name" => "allergyStartYy", "type" => "text"),
  "SpMM" => array ("name" => "allergyStopMm", "type" => "text"),
  "SpYY" => array ("name" => "allergyStopYy", "type" => "text"),
  "Rash" => array ("name" => "rash", "type" => "checkbox"),
  "RashF" => array ("name" => "rashF", "type" => "checkbox"),
  "ABC" => array ("name" => "ABC", "type" => "checkbox"),
  "Hives" => array ("name" => "hives", "type" => "checkbox"),
  "SJ" => array ("name" => "SJ", "type" => "checkbox"),
  "Anaph" => array ("name" => "anaph", "type" => "checkbox"),
  "Other" => array ("name" => "allergyOther", "type" => "checkbox")
  );

  // Remove any existing data
  if (!$new) delByEncounterID ($encID, $encWhere, "allergies");
  if($type == "24" || $type == "25")
	$alergy_count = $max_allergies ;
  else
    $alergy_count = $max_allergies;
  for ($i = 1; $i <= $alergy_count; $i++) {
    $insertVals = array ();
    foreach ($allergyLabels as $name => $labArr) {
      if ($name == "Name") $name = "";
      if (isset ($_POST['aMed' . $i . $name]) && (!empty ($_POST['aMed' . $i . $name]) || trim ($_POST['aMed' . $i . $name]) == "0")) {
        if ($_POST['aMed' . $i . $name] == "On" && $labArr['type'] == "checkbox") {
          $insertVals[$labArr['name']] = 1;
        } else if ($labArr['type'] == "text") {
          $insertVals[$labArr['name']] = $_POST['aMed' . $i . $name];
        }
        $insertVals['allergySlot'] = $i;
      }
    }

    if (!empty ($insertVals)) setByEncounterID ($encID, $encWhere, "allergies", $insertVals, "allergySlot = '$i'");
  }
}




// Allowed Disclosures
if ($type == "10" || $type == "15") {
  $allowedDiscLabels = array (
  "Name" => array ("name" => "disclosureName", "type" => "text"),
  "Rel" => array ("name" => "disclosureRel", "type" => "text"),
  "Address" => array ("name" => "disclosureAddress", "type" => "text"),
  "Telephone" => array ("name" => "disclosureTelephone", "type" => "text")
  );

  // Remove any existing data
  if (!$new) delByEncounterID ($encID, $encWhere, "allowedDisclosures");

  for ($i = 1; $i <= $max_disclose; $i++) {
    $insertVals = array ();
    foreach ($allowedDiscLabels as $name => $labArr) {
	  $tmpDS = $_POST['discloseStatus' . $name . $i];
      if (isset ($tmpDS) && (!empty ($tmpDS) || trim ($tmpDS) == "0")) {
        $insertVals[$labArr['name']] = $tmpDS;
        $insertVals['disclosureSlot'] = $i;
      }
    }

    if (!empty ($insertVals)) setByEncounterID ($encID, $encWhere, "allowedDisclosures", $insertVals, "disclosureSlot = '$i'");
  }
}

// Conditions
if ($type == "1" || $type == "2" || $type == "16" || $type == "17" || $type == "24"|| $type == "25") {
  $conds = doLookup ("conditionLookup", "conditionsID", "conditionCode");
  $conditionLabels = array (
  "Mm" => array ("name" => "conditionMm", "type" => "text"),
  "Yy" => array ("name" => "conditionYy", "type" => "text"),
  "Active" => array ("name" => "conditionActive", "type" => "checkbox"),
  "Comment" => array ("name" => "conditionComment", "type" => "text")
  );

  // Remove any existing data
  if (!$new) delByEncounterID ($encID, $encWhere, "conditions");
  foreach ($conds as $id => $name) {
    $insertVals = array ();
    foreach ($conditionLabels as $lab => $labArr) {
      if (isset ($_POST[$name . $lab]) && (!empty ($_POST[$name . $lab]) || trim ($_POST[$name . $lab]) == "0")) {
        $insertVals['conditionID'] = $id;
        if ($_POST[$name . $lab] == "On" && $labArr['type'] == "checkbox") {
          $insertVals[$labArr['name']] = 1;
        } else if ($labArr['type'] == "text") {
          $insertVals[$labArr['name']] = $_POST[$name . $lab];
        } else if ($labArr['type'] == "checkbox" && preg_match ('/^\d+$/', $_POST[$name . $lab])) {
          $insertVals[$labArr['name']] = $_POST[$name . $lab];
        }
      }
    }

    if (!empty ($insertVals)) setByEncounterID ($encID, $encWhere, "conditions", $insertVals, "conditionID = '" . $insertVals['conditionID'] . "'");
  }
}

// Drugs
if ($type == "1" || $type == "2" || $type == "16" || $type == "17" || $type == "24" || $type == "25") {
  $drugs = doLookup ("drugLookup", "drugID", "drugName");

  $arvLabels = array (
  "StartMm" => array ("name" => "startMm", "type" => "text"),
  "StartYy" => array ("name" => "startYy", "type" => "text"),
  "Continued" => array ("name" => "isContinued", "type" => "checkbox"),
  "StopMm" => array ("name" => "stopMm", "type" => "text"),
  "StopYy" => array ("name" => "stopYy", "type" => "text"),
  "DiscTox" => array ("name" => "toxicity", "type" => "checkbox"),
  "ProphDose" => array ("name" => "prophDose", "type" => "checkbox"),
  "DiscIntol" => array ("name" => "intolerance", "type" => "checkbox"),
  "DiscFail" => array ("name" => "failure", "type" => "checkbox"),
  "DiscFailVir" => array ("name" => "failureVir", "type" => "checkbox"),
  "DiscFailImm" => array ("name" => "failureImm", "type" => "checkbox"),
  "DiscFailClin" => array ("name" => "failureClin", "type" => "checkbox"),
  "DiscProph" => array ("name" => "failureProph", "type" => "checkbox"),
  "DiscUnknown" => array ("name" => "discUnknown", "type" => "checkbox"),
  "InterStock" => array ("name" => "stockOut", "type" => "checkbox"),
  "InterPreg" => array ("name" => "pregnancy", "type" => "checkbox"),
  "InterHop" => array ("name" => "patientHospitalized", "type" => "checkbox"),
  "InterMoney" => array ("name" => "lackMoney", "type" => "checkbox"),
  "InterAlt" => array ("name" => "alternativeTreatments", "type" => "checkbox"),
  "InterLost" => array ("name" => "missedVisit", "type" => "checkbox"),
  "InterPref" => array ("name" => "patientPreference", "type" => "checkbox"),
  "InterUnk" => array ("name" => "interUnk", "type" => "checkbox"),
  "Comments" => array ("name" => "reasonComments", "type" => "text"),
  "forPepPmtct" => array("name" => "forPepPmtct", "type" => "checkbox"),
  "finPTME" => array("name" => "finPTME", "type" => "checkbox")
  );

  // Remove any existing data
  if (!$new) delByEncounterID ($encID, $encWhere, "drugs");

  foreach ($drugs as $id => $name) {
    $insertVals = array ();
    foreach ($arvLabels as $lab => $labArr) {
      if (isset ($_POST[$name . $lab]) && (!empty ($_POST[$name . $lab]) || trim ($_POST[$name . $lab]) == "0")) {
        $insertVals['drugID'] = $id;
        if ($_POST[$name . $lab] == "On" && $labArr['type'] == "checkbox") {
          $insertVals[$labArr['name']] = 1;
        } else if ($labArr['type'] == "text") {
          $insertVals[$labArr['name']] = $_POST[$name . $lab];
        }
      }
    }

    if (!empty ($insertVals)) setByEncounterID ($encID, $encWhere, "drugs", $insertVals, "drugID = '" . $insertVals['drugID'] . "'");
  }
}

// Household Composition
if ($type == "3" || $type =="26") {
  $householdCompLabels = array (
  "householdName" => array ("name" => "householdName", "type" => "text"),
  "householdAge" => array ("name" => "householdAge", "type" => "text"),
  "householdRel" => array ("name" => "householdRel", "type" => "text"),
  "householdHiv" => array ("name" => "hivStatus", "type" => "radio"),
  "householdDisc" => array ("name" => "householdDisc", "type" => "radio"),
  );

  // Remove any existing data
  if (!$new) delByEncounterID ($encID, $encWhere, "householdComp");

  for ($i = 1; $i <= $max_householdComp; $i++) {
    $insertVals = array ();
    foreach ($householdCompLabels as $name => $labArr) {
      if (isset ($_POST[$name . $i]) && (!empty ($_POST[$name . $i]) || trim ($_POST[$name . $i]) == "0")) {
        if ($_POST[$name . $i] == "On" && $labArr['type'] == "radio") {
          $insertVals[$labArr['name']] = 1;
        } else if ($labArr['type'] == "radio" && preg_match ('/^\d+$/', $_POST[$name . $i])) {
          $insertVals[$labArr['name']] = $_POST[$name . $i];
        } else if ($labArr['type'] == "text") {
          $insertVals[$labArr['name']] = $_POST[$name . $i];
        }
        $insertVals['householdSlot'] = $i;
      }
    }

    if (!empty ($insertVals)) setByEncounterID ($encID, $encWhere, "householdComp", $insertVals, "householdSlot = '$i'");
  }
}

// Immunizations
if ($type == "16" || $type == "17" || $type == "24" || $type == "25") {
  $imms = doLookup ("immunizationLookup", "immunizationID", "immunizationCode");

  $immLabels = array (
  "Dd" => array ("name" => "immunizationDd", "type" => "text"),
  "Mm" => array ("name" => "immunizationMm", "type" => "text"),
  "Yy" => array ("name" => "immunizationYy", "type" => "text"),
  "Given" => array ("name" => "immunizationGiven", "type" => "checkbox"),
  "Doses" => array ("name" => "immunizationDoses", "type" => "text")
  );

  // Remove any existing data
  if (!$new) delByEncounterID ($encID, $encWhere, "immunizations");

  foreach ($imms as $id => $name) {
	for ($i = 1; $i <= $max_immunizations; $i++) {
		$insertVals = array ();
		foreach ($immLabels as $lab => $labArr) {
			if (isset ($_POST[$name . $lab . $i]) && (!empty ($_POST[$name . $lab . $i]) || trim ($_POST[$name . $lab . $i]) == "0")) {
				$insertVals['immunizationID'] = $id;
				if ($_POST[$name . $lab . $i] == "On" && $labArr['type'] == "checkbox") {
					$insertVals[$labArr['name']] = 1;
				} else if ($labArr['type'] == "text") {
					$insertVals[$labArr['name']] = $_POST[$name . $lab . $i];
				}
				$insertVals['immunizationSlot'] = $i;
				if (isset ($_POST[$name . "Text"]) && (!empty ($_POST[$name . "Text"]) || trim ($_POST[$name . "Text"]) == "0")) $insertVals['immunizationComment'] = $_POST[$name . "Text"];
			}
		}
		if (!empty ($insertVals)) setByEncounterID ($encID, $encWhere, "immunizations", $insertVals, "immunizationID = '" . $insertVals['immunizationID'] . "' AND immunizationSlot = '$i'");
	}
  } 

	// may be "otherImmunizations" 

	// Remove any existing data
	if (!$new) delByEncounterID ($encID, $encWhere, "otherImmunizations"); 

	for ($i = 1; $i <= $max_otherImmunizations; $i++) {
		$insertVals = array ();
		foreach ($immLabels as $name => $labArr) { 
			if ($name == "Type") continue;
                        if (!empty ($_POST['immunOtherText']) || $_POST['immunOtherText'] == "0") {
			  if (isset ($_POST['immunOther' . $name . $i]) && (!empty ($_POST['immunOther' . $name . $i]) || trim ($_POST['immunOther' . $name . $i]) == "0")) {		      
				  if ($_POST['immunOther' . $name . $i] == "On" && $labArr['type'] == "checkbox") {
					$insertVals[$labArr['name']] = 1;
				  } else if ($labArr['type'] == "text") {
					$insertVals[$labArr['name']] = $_POST['immunOther' . $name . $i];
				  }
				  $insertVals['immunizationSlot'] = $i; 
				  $insertVals['immunizationName'] = $_POST['immunOtherText'];
			  }
                        }
		}
		if (!empty ($insertVals)) { 
			setByEncounterID ($encID, $encWhere, "otherImmunizations", $insertVals, "immunizationSlot = '$i'");
		}
	}
}


// Labs
if (in_array($type, array(6,19,24,25,27,28,29,31,32)) && $curVersion < 3) {
  // Special case for ped. lab form. Set correct result value for 'amylase' and
  // 'lipase' tests.
  if ($type == "19") {
    $lases = array ("amylase", "lipase");
    foreach ($lases as $lase) {
      if (isset ($_POST[$lase . 'TestResult3']) && (isset ($_POST[$lase . 'TestResult']) && (!empty ($_POST[$lase . 'TestResult']) || trim ($_POST[$lase . 'TestResult']) == "0"))) {
        switch ($_POST[$lase . 'TestResult3']) {
          case 2:
            $_POST[$lase . 'TestResult2'] = $_POST[$lase . 'TestResult'];
            unset ($_POST[$lase . 'TestResult']);
            break;
          case 3:
            $_POST[$lase . 'TestResult2'] = $_POST[$lase . 'TestResult'];
            break;
          default:
            break;
        }
      }
    }
  }

  // Need to add where clause parameter since there are duplicate 'labName'
  // values in the labLookup table
  if ($type == "19")
    $labs = doLookup ("labLookup", "labID", "labName", "version1 = '1' or (version0 = '19' and version1 = '19')");
  else if ($type == "24" || $type == "25" || $type == "27" || $type == "28" || $type == "29" || $type == "31")
    $labs = doLookup ("labLookup", "labID", "labName", "version1 = '1'");
  else if ($type == "32")
    $labs = doLookup ("labLookup", "labID", "labName", "labid in (137,138,179,200,201,202)");
  else
    $labs = doLookup ("labLookup", "labID", "labName", "version" . $curVersion . " = '1'"); 

  $labLabels = array (
  "Test" => array ("name" => "ordered", "type" => "checkbox"),
  "TestResult" => array ("name" => "result", "type" => "text"),
  "TestResult2" => array ("name" => "result2", "type" => "text"),
  "TestResult3" => array ("name" => "result3", "type" => "text"),
  "TestResult4" => array ("name" => "result4", "type" => "text"),
  "TestDd" => array ("name" => "resultDateDd", "type" => "text"),
  "TestMm" => array ("name" => "resultDateMm", "type" => "text"),
  "TestYy" => array ("name" => "resultDateYy", "type" => "text"),
  "TestAbnormal" => array ("name" => "resultAbnormal", "type" => "checkbox"),
  "TestRemarks" => array ("name" => "resultRemarks", "type" => "text"),
  );

  // Remove any existing data
  if (!$new) delByEncounterID ($encID, $encWhere, "labs");

  foreach ($labs as $id => $name) {
    $insertVals = array ();
    foreach ($labLabels as $lab => $labArr) {
      if (isset ($_POST[$name . $lab]) && (!empty ($_POST[$name . $lab]) || trim ($_POST[$name . $lab]) == "0")) {
        $insertVals['labID'] = $id;
        if ($_POST[$name . $lab] == "On" && $labArr['type'] == "checkbox") {
          $insertVals[$labArr['name']] = 1;
        } else if ($labArr['type'] == "text") {
          $insertVals[$labArr['name']] = $_POST[$name . $lab];
        }
      }
    }
    if (!empty ($insertVals)) setByEncounterID ($encID, $encWhere, "labs", $insertVals, "labID = '" . $insertVals['labID'] . "'");
  }
}

// Other Drugs
if ($type == "1" || $type == "2" || $type == "16" || $type == "17" || $type == "24" || $type == "25") {
  $otherDrugLabels = array (
  "Text" => array ("name" => "drugName", "type" => "text"),
  "MM" => array ("name" => "startMm", "type" => "text"),
  "YY" => array ("name" => "startYy", "type" => "text"),
  "Continued" => array ("name" => "isContinued", "type" => "checkbox"),
  "SpMM" => array ("name" => "stopMm", "type" => "text"),
  "SpYY" => array ("name" => "stopYy", "type" => "text"),
  "DiscTox" => array ("name" => "toxicity", "type" => "checkbox"),
  "ProphDose" => array ("name" => "prophDose", "type" => "checkbox"),
  "DiscIntol" => array ("name" => "intolerance", "type" => "checkbox"),
  "DiscFail" => array ("name" => "failure", "type" => "checkbox"),
  "DiscFailVir" => array ("name" => "failureVir", "type" => "checkbox"),
  "DiscFailImm" => array ("name" => "failureImm", "type" => "checkbox"),
  "DiscFailClin" => array ("name" => "failureClin", "type" => "checkbox"),
  "DiscProph" => array ("name" => "failureProph", "type" => "checkbox"),
  "DiscUnknown" => array ("name" => "discUnknown", "type" => "checkbox"),
  "InterStock" => array ("name" => "stockOut", "type" => "checkbox"),
  "InterPreg" => array ("name" => "pregnancy", "type" => "checkbox"),
  "InterHop" => array ("name" => "patientHospitalized", "type" => "checkbox"),
  "InterMoney" => array ("name" => "lackMoney", "type" => "checkbox"),
  "InterAlt" => array ("name" => "alternativeTreatments", "type" => "checkbox"),
  "InterLost" => array ("name" => "missedVisit", "type" => "checkbox"),
  "InterPref" => array ("name" => "patientPreference", "type" => "checkbox"),
  "InterUnk" => array ("name" => "interUnk", "type" => "checkbox"),
  "Comments" => array ("name" => "reasonComments", "type" => "text"),
  "finPTME" => array ("name" => "finPTME", "type" => "checkbox")
  );

  // Remove any existing data
  if (!$new) delByEncounterID ($encID, $encWhere, "otherDrugs");  

	if($type =="24" || $type == "25") {
		$_POST['other1Text'] = "other1";
		$_POST['other2Text'] = "other2";
		insertToOtherDrugs ($otherDrugLabels, 1, 3, $encID, $encWhere);
	} else {
		insertToOtherDrugs ($otherDrugLabels, 1, $max_otherDrugs, $encID, $encWhere);
	}
}   

function insertToOtherDrugs ($labels, $start, $end, $encID, $encWhere) {
	for ($i = $start; $i <= $end; $i++) {
		$insertVals = array ();
		foreach ($labels as $name => $labArr) {
			if (isset ($_POST['other' . $i . $name]) && (!empty ($_POST['other' . $i . $name]) || trim ($_POST['other' . $i . $name]) == "0")) {
				if ($_POST['other' . $i . $name] == "On" && $labArr['type'] == "checkbox") {
					$insertVals[$labArr['name']] = 1;
				} else if ($labArr['type'] == "text") {
					$insertVals[$labArr['name']] = $_POST['other' . $i . $name];
				}
				$insertVals['drugSlot'] = $i;
			} 
		}
		if (!empty ($insertVals)) {
			setByEncounterID ($encID, $encWhere, "otherDrugs", $insertVals, "drugSlot = '$i'");
		} 
	} 
}

// Other Labs
if (in_array($type,array(6,19)) && $curVersion < 3) {
  $otherLabLabels = array (
  "TestText" => array ("name" => "labName", "type" => "text"),
  "Test" => array ("name" => "ordered", "type" => "checkbox"),
  "TestResult" => array ("name" => "result", "type" => "text"),
  "TestDd" => array ("name" => "resultDateDd", "type" => "text"),
  "TestMm" => array ("name" => "resultDateMm", "type" => "text"),
  "TestYy" => array ("name" => "resultDateYy", "type" => "text"),
  "TestAbnormal" => array ("name" => "resultAbnormal", "type" => "checkbox"),
  );

  // Remove any existing data
  if (!$new) delByEncounterID ($encID, $encWhere, "otherLabs");

  for ($i = 1; $i <= $max_otherLabs; $i++) {
    $insertVals = array ();
    foreach ($otherLabLabels as $name => $labArr) {
      if (isset ($_POST['otherLab' . $i . $name]) && (!empty ($_POST['otherLab' . $i . $name]) || trim ($_POST['otherLab' . $i . $name]) == "0")) {
        if ($_POST['otherLab' . $i . $name] == "On" && $labArr['type'] == "checkbox") {
          $insertVals[$labArr['name']] = 1;
        } else if ($labArr['type'] == "text") {
          $insertVals[$labArr['name']] = $_POST['otherLab' . $i . $name];
        }
        $insertVals['labSlot'] = $i;
      }
    }

    if (!empty ($insertVals)) setByEncounterID ($encID, $encWhere, "otherLabs", $insertVals, "labSlot = '$i'");
  }
}

// Other Prescriptions
if ($type == "5" || $type == "18") {
  $otherRxLabels = array (
  "RxText" => array ("name" => "drug", "type" => "text"),
  "StdDosage" => array ("name" => "stdDosage", "type" => "checkbox"),
  "StdDosageSpecify" => array ("name" => "stdDosageSpecify", "type" => "text"),
  "PedDosageSpecify" => array ("name" => "pedDosageDesc", "type" => "text"),
  "PedPresSpecify" => array ("name" => "pedPresentationDesc", "type" => "text"),
  "AltDosage" => array ("name" => "altDosage", "type" => "checkbox"),
  "AltDosageSpecify" => array ("name" => "altDosageSpecify", "type" => "text"),
  "NumDays" => array ("name" => "numDays", "type" => "checkbox"),
  "NumDaysDesc" => array ("name" => "numDaysDesc", "type" => "text"),
  "Dispensed" => array ("name" => "dispensed", "type" => "checkbox"),
  "DispDateDd" => array ("name" => "dispDateDd", "type" => "text"),
  "DispDateMm" => array ("name" => "dispDateMm", "type" => "text"),
  "DispDateYy" => array ("name" => "dispDateYy", "type" => "text"),
  "DispAltDosage" => array ("name" => "dispAltDosage", "type" => "checkbox"),
  "DispAltDosageSpecify" => array ("name" => "dispAltDosageSpecify", "type" => "text"),
  "DispAltNumDays" => array ("name" => "dispAltNumDays", "type" => "checkbox"),
  "DispAltNumDaysSpecify" => array ("name" => "dispAltNumDaysSpecify", "type" => "text"),
  "DispAltNumPills" => array ("name" => "dispAltNumPills", "type" => "text")
  );

  // Remove any existing data
  if (!$new) delByEncounterID ($encID, $encWhere, "otherPrescriptions");
  
  $otherRxs_count = $max_otherRxs;

  for ($i = 1; $i <= $otherRxs_count; $i++) {
    $insertVals = array ();
    foreach ($otherRxLabels as $name => $labArr) {
      if (isset ($_POST['other' . $i . $name]) && (!empty ($_POST['other' . $i . $name]) || trim ($_POST['other' . $i . $name]) == "0")) {
        if ($_POST['other' . $i . $name] == "On" && $labArr['type'] == "checkbox") {
          $insertVals[$labArr['name']] = 1;
        } else if ($labArr['type'] == "text") {
          $insertVals[$labArr['name']] = $_POST['other' . $i . $name];
        }
        $insertVals['rxSlot'] = $i;
      }
    }

    if (!empty ($insertVals)) {
      setByEncounterID ($encID, $encWhere, "otherPrescriptions", $insertVals, "rxSlot = '$i'");
    }
  }
}
 

// Ped Labs
if ($type == "16") {
  $labs = doLookup ("pedLabsLookup", "pedLabsID", "pedLabsCode");

  $pedLabsLabels = array (
  "Age" => array ("name" => "pedLabsResultAge", "type" => "text"),
  "AgeUnits" => array ("name" => "pedLabsResultAgeUnits", "type" => "checkbox"),
  "Res" => array ("name" => "pedLabsResult", "type" => "checkbox")
  );

  // Remove any existing data
  if (!$new) delByEncounterID ($encID, $encWhere, "pedLabs");
  if (!$new) delByEncounterID ($encID, $encWhere, "labs");

  foreach ($labs as $id => $name) {
    for ($i = 1; $i <= $max_pedLabs; $i++) {
      $insertVals = array ();
      foreach ($pedLabsLabels as $lab => $labArr) {
        if (isset ($_POST[$name . $lab . $i]) && (!empty ($_POST[$name . $lab . $i]) || trim ($_POST[$name . $lab . $i]) == "0")) {
          $insertVals['pedLabsID'] = $id;
          if ($_POST[$name . $lab . $i] == "On" && $labArr['type'] == "checkbox") {
            $insertVals[$labArr['name']] = 1;
          } else if ($labArr['type'] == "text") {
            $insertVals[$labArr['name']] = $_POST[$name . $lab . $i];
          } else if ($labArr['type'] == "checkbox" && preg_match ('/^\d+$/', $_POST[$name . $lab . $i])) {
            $insertVals[$labArr['name']] = $_POST[$name . $lab . $i];
          }
          $insertVals['pedLabsSlot'] = $i;
          if (isset ($_POST[$name . "Ordered"]) && (!empty ($_POST[$name . "Ordered"]) || trim ($_POST[$name . "Ordered"]) == "0")) $insertVals['pedLabsOrdered'] = $_POST[$name . "Ordered"];
        }
      }

      if (!empty ($insertVals)) {
        setByEncounterID ($encID, $encWhere, "pedLabs", $insertVals, "pedLabsID = '" . $insertVals['pedLabsID'] . "' AND pedLabsSlot = '$i'");

        // Also add lab result into labs table

        // Translate lab test ID
        switch ($insertVals['pedLabsID']) {
          case "1": $labID = "100"; break;
          case "2": $labID = "101"; break;
          case "3": $labID = "181"; break;
          case "4": $labID = "182"; break;
        }
        $res = $insertVals['pedLabsResult'];
        $ord = ($insertVals['pedLabsOrdered'] == 1) ? "1" : "0";

        // Use dob to calculate lab result date, if available
        $resDate = array ();
        if (preg_match ('/^\d+$/', $insertVals['pedLabsResultAge']) &&
            $insertVals['pedLabsResultAgeUnits'] <= 2 &&
            $insertVals['pedLabsResultAgeUnits'] >= 1) {
          $resDate = calcPedLabsResultDate ($pid, $insertVals['pedLabsResultAge'], $insertVals['pedLabsResultAgeUnits']);
        }

        // Reset insert array
        $insertVals = array ();
        $insertVals['labID'] = $labID;
        $insertVals['ordered'] = $ord;
        $insertVals['result'] = $res;
        if (!empty ($resDate['Dd'])) $insertVals['resultDateDd'] = $resDate['Dd'];
        if (!empty ($resDate['Mm'])) $insertVals['resultDateMm'] = $resDate['Mm'];
        if (!empty ($resDate['Yy'])) $insertVals['resultDateYy'] = $resDate['Yy'];
        setByEncounterID ($encID, $encWhere, "labs", $insertVals, "labID = '" . $insertVals['labID'] . "' AND result = '" . $insertVals['result'] . "'");
      }
    }
  }
}

// Prescriptions
if ($type == "5" || $type == "18") {
  $drugs = doLookup ("drugLookup", "drugID", "drugName");
  $rxLabels = array (
  "StdDosage" => array ("name" => "stdDosage", "type" => "checkbox"),
  "StdDosageSpecify" => array ("name" => "stdDosageSpecify", "type" => "text"),
  "PedDosageSpecify" => array ("name" => "pedDosageDesc", "type" => "text"),
  "PedPresSpecify" => array ("name" => "pedPresentationDesc", "type" => "text"),
  "AltDosage" => array ("name" => "altDosage", "type" => "checkbox"),
  "AltDosageSpecify" => array ("name" => "altDosageSpecify", "type" => "text"),
  "NumDays" => array ("name" => "numDays", "type" => "checkbox"),
  "NumDaysDesc" => array ("name" => "numDaysDesc", "type" => "text"),
  "Dispensed" => array ("name" => "dispensed", "type" => "checkbox"),
  "DispDateDd" => array ("name" => "dispDateDd", "type" => "text"),
  "DispDateMm" => array ("name" => "dispDateMm", "type" => "text"),
  "DispDateYy" => array ("name" => "dispDateYy", "type" => "text"),
  "DispAltDosage" => array ("name" => "dispAltDosage", "type" => "checkbox"),
  "DispAltDosageSpecify" => array ("name" => "dispAltDosageSpecify", "type" => "text"),
  "DispAltNumDays" => array ("name" => "dispAltNumDays", "type" => "checkbox"),
  "DispAltNumDaysSpecify" => array ("name" => "dispAltNumDaysSpecify", "type" => "text"),
  "forPepPmtct" => array ("name" => "forPepPmtct", "type" => "radio"),
  "DispAltNumPills" => array ("name" => "dispAltNumPills", "type" => "text")
  );

  // Remove any existing data
  if (!$new) {
	delByEncounterID ($encID, $encWhere, "prescriptions");
  }
  $drugList = array();
  foreach ($drugs as $id => $name) {
    $insertVals = array ();
    foreach ($rxLabels as $lab => $labArr) {
      if (isset ($_POST[$name . $lab]) && (!empty ($_POST[$name . $lab]) || trim ($_POST[$name . $lab]) == "0")) {
		//echo "<br>" . $name . $lab . " = " . $_POST[$name . $lab];
        $insertVals['drugID'] = $id;
        if ($_POST[$name . $lab] == "On" && $labArr['type'] == "checkbox") {
          $insertVals[$labArr['name']] = 1;
        } else if ($labArr['type'] == "text") {
          $insertVals[$labArr['name']] = $_POST[$name . $lab];
        } else if ($labArr['type'] == "checkbox" && preg_match ('/^\d+$/', $_POST[$name . $lab])) {
          $insertVals[$labArr['name']] = $_POST[$name . $lab];
        } else if ($labArr['type'] == "radio" ) {
          $insertVals[$labArr['name']] = $_POST[$name . $lab][0];
        }
      }
    }
    if (!empty ($insertVals)) setByEncounterID ($encID, $encWhere, "prescriptions", $insertVals, "drugID = '" . $insertVals['drugID'] . "'");
  }

  // update patient's regimens in pepfarTable
  updateDrugTableAll($pid);
  updatePepfarTable($pid);
}

// Referrals
if ($type == "9") {
  $refs = doLookup ("referralLookup", "refSequence", "refName");

  $refLabels = array (
  "Checked" => array ("name" => "referralChecked", "type" => "checkbox"),
  "Clinic" => array ("name" => "refClinic", "type" => "text"),
  "AdateDd" => array ("name" => "refAdateDd", "type" => "text"),
  "AdateMm" => array ("name" => "refAdateMm", "type" => "text"),
  "AdateYy" => array ("name" => "refAdateYy", "type" => "text"),
  "FdateDd" => array ("name" => "refFdateDd", "type" => "text"),
  "FdateMm" => array ("name" => "refFdateMm", "type" => "text"),
  "FdateYy" => array ("name" => "refFdateYy", "type" => "text"),
  "Akept" => array ("name" => "refAkept", "type" => "checkbox")
  );

  // Remove any existing data
  if (!$new) delByEncounterID ($encID, $encWhere, "referrals");

  foreach ($refs as $id => $name) {
    $insertVals = array ();
    foreach ($refLabels as $lab => $labArr) {
      if (isset ($_POST[$name . $lab]) && (!empty ($_POST[$name . $lab]) || trim ($_POST[$name . $lab]) == "0")) {
        $insertVals['referral'] = $name;
        if ($_POST[$name . $lab] == "On" && $labArr['type'] == "checkbox") {
          $insertVals[$labArr['name']] = 1;
        } else if ($labArr['type'] == "text") {
          $insertVals[$labArr['name']] = $_POST[$name . $lab];
        } else if ($labArr['type'] == "checkbox" && preg_match ('/^\d+$/', $_POST[$name . $lab])) {
          $insertVals[$labArr['name']] = $_POST[$name . $lab];
        }
      }
    }
    if (!empty ($insertVals)) setByEncounterID ($encID, $encWhere, "referrals", $insertVals, "referral = '" . $insertVals['referral'] . "'");
  }
}

// RiskAssessments
if ($type == "1" || $type == "16" || $type == "24" || $type == "25") {
  $risks = doLookup ("riskLookup", "riskID", "fieldName");

  $riskLabels = array (
	  "Answer"  => array ("name" => "riskAnswer", "type" => "checkbox"),
	  "Dd"      => array ("name" => "riskDd",     "type" => "text"),
	  "Mm"      => array ("name" => "riskMm",     "type" => "text"),
	  "Yy"      => array ("name" => "riskYy",     "type" => "text"),
	  "Comment" => array ("name" => "riskComment","type" => "text")
  );


  // Remove any existing data
  if (!$new) delByEncounterID ($encID, $encWhere, "riskAssessments");

  foreach ($risks as $id => $name) {
    $insertVals = array ();
    foreach ($riskLabels as $lab => $labArr) {
      if (isset ($_POST[$name . $lab]) && (!empty ($_POST[$name . $lab]) || trim ($_POST[$name . $lab]) == "0")) {
        $insertVals['riskID'] = $id;
        if ($_POST[$name . $lab] == "On" && $labArr['type'] == "checkbox") {
          $insertVals[$labArr['name']] = 1;
        } else if ($labArr['type'] == "text") {
          $insertVals[$labArr['name']] = $_POST[$name . $lab];
        } else if ($labArr['type'] == "checkbox" && preg_match ('/^\d+$/', $_POST[$name . $lab])) {
          $insertVals[$labArr['name']] = $_POST[$name . $lab];
        }
      }
    }
    if (!empty ($insertVals)) setByEncounterID ($encID, $encWhere, "riskAssessments", $insertVals, "riskID = '" . $insertVals['riskID'] . "'");
  }
}

// Loop through tables and insert data from form, excluding tables done above.
foreach ($tables as $tab) {
  if (in_array ($tab, $norm_tables)) continue;

  // Remove any existing data
  if (!$new) delByEncounterID ($encID, $encWhere, $tab);

  $insertVals = generateInsertArray ($tab);
  if (count($insertVals) > 0)
  	setByEncounterID ($encID, $encWhere, $tab, $insertVals);
}

// Hook up prescription and lab forms to their respective input or followup form
//if (isset($_POST['formType'])) {
	//$type == "5" || $type == "6") {
	$visitID = "";
	switch ($_POST['formType']) {
		case "intake":
			// need encounter_id of intake form--stuff it into
			$visitID = getIntakeID($pid, $type);
			break;
		case "followUp":
			// fetch selected followup form id
			if (isset($_POST['followUpFormId'])) $visitID = $_POST['followUpFormId'];
			break;
		default:
	}
        /* Need to unset visitPointer if it's not in the POST (has been */
        /* un-checked on the form) */
	setVisitPointer($encID, $visitID);
//}

// All data saved, set lastModified date - pseudo-transaction complete
setByEncounterID ($encID, $encWhere, "encounter", array ("lastModified" => "getDate()"));

// Check for required fields and validate user input
// Send back to populated form for corrections if errors were found and not
// over-ridden
$binstring = $_POST['errorOverride']; //tells whether form is Incomplete (1) or not (0)

//tells whether the form is marked for review or not
$binstring .= (isset($_POST['review'])) ? 1 : 0;
$errCount = insertFormErrors ($encID, $errFields, $errMsgs);

//tells whether the form has errors or not
//if (!empty ($errors)) { //form has errors
if ( $errCount > 0 ){
  $binstring .= '1';
  $loc = "patienttabs.php?lang=$lang&pid=$pid&site=$site&code=1";
  $code = 1;
} else { //form does not have errors
  $binstring .= '0';
  $loc = "patienttabs.php?lang=$lang&pid=$pid&site=$site&code=0";
  $code = 0;
} 

//saves status into the database
$status = bindec($binstring);
setStatusByEncounterID ($encID, $status, "", FALSE);  
if (in_array($type, array(6,13,19,24,25,27,28,29,31))) {
	if ($code == 0)
		echo "{ \"retcode\":" . $code . " }";
	else
		echo "{ \"retcode\":" . $errCount . " }";
} 
?>
