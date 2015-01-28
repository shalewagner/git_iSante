<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
/* This program:
 *** matches fp patients to iSanté patients
 *** adds missing patients to iSanté
 *** changes the fingerprint key in the fingerprint database from nationalid to patientid
 *** after the conversion, it is assumed that the patient table in the fingerprint database will no longer be used; instead, the patient table in iSanté will be used
 * It requires:
 *** working configuration of the iSanté-M2Sys fingerprint server integration
 *** a copy of the bioplugin database exported from the M2Sys Server and installed in the MySql instance on the iSanté server
 *** matching requires that the patient.registrationno collation be altered to utf8_general_ci
 *** run with the URL: <https://192.168.1.50/isante/fpConvert.php>
 * It outputs:
 *** a formatted list for each matched patient listing fp and iSanté values, for comparison purposes
 *** a formatted list for each added patient listing fp values applied to the new iSanté patient
 *** the fingerprint database key (previously nationalID) is switched to the iSanté patient.patientID column                   
 */
 
/*
 this is the format of the bioplugin.patient table, for reference purposes only 
CREATE TABLE `patient` (
  `NOM` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PRENOM` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `INSTITUTION` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SEXE` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `REGISTRATIONNO` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `PMERE` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DATENAISSANCE` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FINGERLOADED` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `STATUT` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ADRESSE` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datecreation` datetime DEFAULT NULL,
  `datemodification` datetime DEFAULT NULL,
  PRIMARY KEY (`REGISTRATIONNO`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 
*/  

require_once 'backend.php';

$sitecode = getDefaultSite(getSessionUser());

$status = getFingerprintServerStatus();
if (is_null($status[0])) {
        echo $status[1];
        exit;
} 

error_reporting(E_WARNING);

$maritalMapFp = array (
	'Mariage' => 1,
	'Union libre' => 2,  
	'Divorce' => 8,
	'celibat' => 16, 
);

$maritalMapIsante = array(
	1 => 'Marié (e)', 
	2 => 'Concubinage', 
	4 => 'Veuf (ve)', 
	8 => 'Séparé (e)',  
	16 => 'Célibataire', 
	32 => 'Inconnu'
); 

$genderMapFp = array (
	'feminin' => 1,
	'masculin' => 2
);

$genderMapIsante = array (
	1 => 'Féminin',
	2 => 'Masculin'
);

// Loop on patient table in fingerprint db
$fpArray = database()->query('select * from bioplugin.patient')->fetchAll();  
$targetList = 'select patientID, lname, fname, location_id, sex, nationalID, fnameMother, maritalStatus, addrDistrict, ymdToDate(dobyy,dobmm,dobdd) as dob from itech.patient where location_id = ' . $sitecode . ' and ';
foreach ($fpArray as $fpRow) {
	// first, try to match based upon registrationno directly against nationalid
	// second, try based on constructing the nationalid from other iSante attributes
	// third, match on first name, last name, and date of birth 
	$isanteArray = database()->query($targetList . 'nationalID = ?', array($fpRow['registrationno']))->fetchAll();
	if (count($isanteArray) !== 1)  
		$isanteArray = database()->query($targetList . 'concat(left(fname,1), left(lname,1), dobmm, substr(dobyy,3), left(fnamemother,1)) = ?', array($fpRow['registrationno']))->fetchAll(); 
	if (count($isanteArray) !== 1)
		$isanteArray = database()->query($targetList . 'fname = ? and lname = ? and dobYy = ? and dobMm = ? and dobDd = ?' , array($fpRow['PRENOM'], $fpRow['NOM'], substr($fpRow['DATENAISSANCE'],0,4), substr($fpRow['DATENAISSANCE'],5,2), substr($fpRow['DATENAISSANCE'],8,2)))->fetchAll();  
	if (count($isanteArray) !== 1) {
		// build the patientArray
		$dd = substr($fpRow['datecreation'],8,2);
		$mm = substr($fpRow['datecreation'],5,2);
		$yy = substr($fpRow['datecreation'],2,2);
		$type = (2011 - intval(substr($fpRow['DATENAISSANCE'],0,4)) < 16) ? 15: 10;		
		$patientValueArray = array(
		'lname' => $fpRow['NOM'],
		'fname' => $fpRow['PRENOM'],
		'sex' => $genderMapFp[$fpRow['SEXE']],
		'nationalID' => $fpRow['REGISTRATIONNO'],
		'fnameMother' => $fpRow['PMERE'],
		'dobYy' => substr($fpRow['DATENAISSANCE'],0,4),
		'dobMm' => substr($fpRow['DATENAISSANCE'],5,2), 
		'dobDd' => substr($fpRow['DATENAISSANCE'],8,2), 
		'maritalStatus' => $maritalMapFp[$fpRow['STATUT']],
		'addrDistrict' => $fpRow['ADRESSE'] 
		); 
		$pid = addFpPatient($sitecode, $dd, $mm, $yy, $type, $patientValueArray);
		// switch marital status and gender codes back to readable format for printing  
		$patientValueArray['maritalStatus'] = $maritalMapIsante[$patientValueArray['maritalStatus']];
		$patientValueArray['sex'] = $genderMapIsante[$patientValueArray['sex']];
		printPatientAdded ($fpRow, $patientValueArray);  
	} else {
		$isanteRow = $isanteArray[0];
		// switch marital status and gender codes to readable format for comparison 
		$isanteRow['maritalStatus'] = $maritalMapIsante[$isanteRow['maritalStatus']];
		$isanteRow['sex'] = $genderMapIsante[$isanteRow['sex']];
		printCompareMatch($fpRow, $isanteRow);
		$pid = $isanteRow['patientID'];  
	}
	// change the fingerprint key from REGISTRATIONNO to patientID
	if (changeFingerprintID($fpRow['registrationno'], $pid) == false) {
		echo "Failed to change fingerprint key, something wrong, quitting...";
		exit;
	}; 
} 

function addFpPatient($sitecode, $dd, $mm, $yy, $type, $patientArray) {
	// create the patient
	$pid = addPatient($sitecode, $patientArray); 
	// create the encounter
	$eid = addEncounter ($pid, $dd, $mm, $yy, $sitecode, date ("Y-m-d H:i:s"), $type, 'added from fingerprint database', 'm2sys', 'm2sys', 0, '', '', '', 0, getSessionUser(), date ("Y-m-d H:i:s")); 
	return $pid;
}
function printPatientAdded($fpRow, $isante) {
	echo "
		<table border=\"1\">
		<tr><th>Added patient...iSante Attribute</th><th>iSante Value</tr>
	";
	foreach ($isante as $key => $value) {
		echo "<tr><th align=\"left\">" . $key . "</th><td>" . $value . "</td></tr>"; 
	} 
	echo "</table>";
} 
function printCompareMatch($fp, $isante) {
	$columnMap = array(
	'NOM' => 'lname',
	'PRENOM' => 'fname',
	'INSTITUTION' => 'location_id',
	'SEXE' => 'sex',
	'REGISTRATIONNO' => 'nationalID',
	'PMERE' => 'fnameMother',
	'DATENAISSANCE' => 'dob',
	'STATUT' => 'maritalStatus',
	'ADRESSE' => 'addrDistrict'
	);
	echo "
		<table border=\"1\">
		<tr><th>Matched patient...</th><th>FP Value</th><th>iSanté Value</th></tr>
	";
	foreach ($columnMap as $key => $value) {
		echo "<tr><th align=\"left\">" . $key . "</th><td>" . $fp[$key] . "</td><td>" . $isante[$value] . "</td></tr>"; 
	} 
	echo "</table>";
} 
?>