<?php 
require_once 'backend/fingerprint.php';
require_once 'labels/labels.php';

if (isset($_REQUEST['deletePrints']) && $_REQUEST['deletePrints'] == 'true') {
  deleteFingerprints($pid);
}

if(isset($_POST['errorSave'])) {
  $errorSave = $_POST['errorSave'];
} else {
  $errorSave = "";
} 

// figure out which ID to display in the header
$idLabel = array( 
"fr" => array('No. de code PC','No. de code OD','No. de code ST'),
"en" => array('PC code', 'OB code', 'ST code')
);
if (getHivPositive($pid)) $id = $idLabel[$lang][2] . $colon[$lang][0] ." <em class=\"patInfo\">" . getData ("clinicPatientID", "textarea");
else { 
	$id = getID($pid,'pc');
	if ($id != "") $id = $idLabel[$lang][0] . $colon[$lang][0] ." <em class=\"patInfo\">" . $id;
	else {
		$id = $idLabel[$lang][1] . $colon[$lang][0] ." <em class=\"patInfo\">" . getID($pid,'ob');
	} 
}

if (! DEBUG_FLAG) $filler = "";
else $filler = "&nbsp;<a href=\"javascript:fillFields()\">[FILL]</a>";
$delPatient = ""; 
if ($userAccessLevel >= ADMIN && SERVER_ROLE != "consolidated") {
	$delPatient = '<button class="button-maker button10" type="button" onclick="delPatFromHeader()">' . $cmdLabel[$lang][6] . '</button>';
}

$sumButton = '<button class="button-maker button10" type="button" onclick="launchClinicalSummary(' . getHivPositive ($pid) . ')">' . $sumTitle[$lang] . '</button>';

$hivPositive = (empty ($patientStatus) ? $patStatusLabels[$lang][12] : $patStatusLabels[$lang][$patientStatus]);
$hivPositive = "<em id=\"hivStatusId\">$hivPositive</em></td>";
$hivInitDate = getARTstart($pid);
if ($hivInitDate != '') {
	$hivInitDate = "Début TAR : <em class=\"patInfo\" id=\"hivInitDateId\">" . $hivInitDate . "</em>";
	$hivPositive .= "<td class=\"sm_patHead\">" . $hivInitDate . " " . $patStatusLabels[$lang][13] . " :<em class=\"patInfo\">" . $patientRegimen . "</em></td>";
} else
	$hivPositive .= "<td>&nbsp;</td>";
$hivNegative = (($lang == "en") ? "HIV negative" : "VIH n&eacute;gatif"); 
$hivNegative = "<em id=\"hivStatusId\">$hivNegative</em></td><td>&nbsp;</td>";
// TODO: we probably shouldn't even have an HIV status element if the patient isn't HIV positive, but this can wait until we rework the whole patient header and confidentiality
$statusDisplay = (getHivPositive($pid)) ? $patStatusLabels[$lang][0] . $colon[$lang][0] . " <em class=\"patInfo\">" . $hivPositive : "<td>&nbsp;</td>";
echo '<table id="head" cellspacing="0" cellpadding="0"><tr>' . get_fingerprintLink($pid,$lang) . ' <td class="patName"> ' . $fname . '<br />' . $lname . '</td><td><table cellspacing="0" cellpadding="0"><tr class="patHeader"><td class="sm_patHead" style="min-width: 124px">'. $id . '</em></td><td class="sm_patHead">' . $statusDisplay . ' <td class="sm_patHead"><em id="clinSumLinkId">' . $sumButton . '</em></td> </tr> <tr class="patHeader"> <td class="sm_patHead">' . $ageYears[$lang][4] . $colon[$lang][0] .' <em class="patInfo"><span id="patAge">' . $curAge . '</span>';
if ($patientDOB != '//') { // Only displays if there is a birthdate
    echo " (" . $patientDOB . ")";
}
echo "</em></td><td class=\"sm_patHead\">" . $patName[$lang][4] . $colon[$lang][0] . " <em class=\"patInfo\" >" . $fnamemom . "</em></td><td class=\"sm_patHead\">" . $nationalID[$lang][1] . $colon[$lang][0] . " <em class=\"patInfo\">" .$natID . "</em></td><td class=\"sm_patHead\">" . $sex[$lang][0] . $colon[$lang][0] ." <em class=\"patInfo\"><span id=\"genderDisplayId\">". getSex() ."</span>" . $filler . $delPatient . "</em></td></tr></table></td></tr></table>";

//This should probably live somewhere more generic but it is only used here for now.
function get_user_browser() {
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $ub = ''; 
    if(preg_match('/MSIE/i',$u_agent) || preg_match('/Trident/i',$u_agent)) { 
        $ub = "ie"; 
    } elseif(preg_match('/Firefox/i',$u_agent)) { 
        $ub = "firefox";
    } elseif(preg_match('/Chrome/i',$u_agent)) { 
        $ub = "chrome"; 
    } elseif(preg_match('/Safari/i',$u_agent)) { 
        $ub = "safari"; 
    } else {
        $ub = "unknown";
    }     
    return $ub; 
} 

//render html for print and smartcard information for patient header
function get_fingerprintLink($pid,$lang) {
        $fpLabels = array(
                'addFp' => array(
                        'en' => 'Add fingerprints',
                        'fr' => 'Ajoutez les empreintes digitales'
                ),
                'writeCard' => array(
                        'en' => 'Write Smartcard',
                        'fr' => 'Écriture de smartcard'
                )
        );
	$addFPbutton = '<button type="button" class="button-maker button10" onclick="submitPrints()">' . $fpLabels['addFp'][$lang] . '</button>';  
	$issueSCbutton = '<button class="button-maker button10" type="button" onclick="issueSmartcard()">' . $fpLabels['writeCard'][$lang] . '</button>';  
	$browser = get_user_browser();
	if (getConfig('fingerprintURL') == Null) 
	        $addButtons = '<td>&nbsp;</td>';
	else if (hasFingerprints(getMasterPid($pid))) {
            if ($browser != 'ie') 
                $addButtons = '<td id="fpheader"><img src="images/thumb.jpg" onclick="deletePrints()" title="' . _('en:Click to delete these prints') . '" alt="' . _('Empreintes digitales') . '" /></td>';
            else 
                $addButtons = '<td>' . $issueSCbutton . '</td>';
        } else
            if ($browser == 'ie')  
                $addButtons = '<td id="nofpheader-ie">' . $addFPbutton . '</td>';
	return $addButtons; 
}  

// ART initiation date
function getARTstart ($pid) {
	$arr = database()->query("select substring(min(visitdate),1,10) as vd from pepfarTable where patientID = ? and (forPepPmtct = 0 OR forPepPmtct IS NULL)", array($pid))->fetchAll(PDO::FETCH_ASSOC);
	if (count($arr) > 0 && $arr[0]['vd'] != '') { 
		$dArray = explode('-',$arr[0]['vd']);
		return $dArray[2] . "/" . $dArray[1] . "/" . $dArray[0]; 
	}
	else return '';
} 

function getSex() { 
	$mf = getData("sex", "textarea"); 
        switch ($mf) {
	case 1:
		return "F";
		break;
	case 2: 
		return "H";
		break;
	default:
		return "I";
	}
}
?>
