<?php
require_once 'include/standardHeader.php';
require_once 'labels/labels.php';
require_once 'labels/menu.php';
require_once 'labels/newEnc.php';

if (DEBUG_FLAG) fb($_GET, 'get arr in allEnc');

initPidList();
addPidList($pid);
$pageNum = (!empty ($_GET['pageNum'])) ? $_GET['pageNum'] : 1;
if (!empty ($_POST)) {
  $deleteFlag = false;
  foreach ($_POST as $name => $val) {
    switch (substr ($name, strpos ($name, '_') + 1)) {
      case 'disabled':
        if (!isset ($_POST[$val . "_disable"])) setStatusByEncounterID ($val, 0,"",FALSE);
        break;
      case 'disable':
      	 if (!isset ($_POST[$val . "_disabled"])) setStatusByEncounterID ($val, 1,"",FALSE);
        break;
      case 'delete':
	$deleteFlag = true;
        setStatusByEncounterID ($val, 255,"",TRUE);
	// if this encounter happens to be a lab order, set its status to cancelled
        setQueueStatusById ($val, 5);
        break;
      default:
        break;
    }
  }
  if ($deleteFlag) {
    resetHivStatus($pid);
    // if deleted encounter was Rx, need to do updates (no good way to tell what
    // the encounterType is here, so just do the updates anyway)
    updateDrugTableAll($pid);
    updatePepfarTable($pid);
  }
} 

echo "
  <title>" . $allEnc[$lang][0] . "</title>
  <script type=\"text/javascript\">

function confirmDel () {
	var noneChecked = true;
	for (i = 0; i < document.forms.mainForm.length; i++){
		if (document.mainForm.elements[i].name.indexOf ('delete') !== -1 && document.mainForm.elements[i].checked) {
			noneChecked = false;
			if (confirm ('" . html_entity_decode($allEnc[$lang][10],ENT_QUOTES, CHARSET). "')) {
				document.mainForm.method = 'post';
				document.mainForm.submit();
				break;
			} else {
				break; 
			}
		}
	}
	if (noneChecked)  {
		alert('" . html_entity_decode($allEnc[$lang][31],ENT_QUOTES, CHARSET) . "');
	}
}
function removeMsg() {
	if(document.getElementById('saveMessage')){
		var msg = document.getElementById('saveMessage');
		document.mainForm.removeChild(msg);
	}
}
  </script>
 </head>
 <body>";
if ($deleteFlag) {
	$patientStatus = getPatientStatus($pid);
	$label = (empty ($patientStatus)) ? $patStatusLabels[$lang][11] : $patStatusLabels[$lang][$patientStatus];
	echo "
<script type=\"text/javascript\">";
	if ($patientStatus > 0) {
		echo "
		parent.document.getElementById('hivStatusId').firstChild.data = '" . $label . "';";
	} else { 
		echo "
		parent.document.getElementById('hivStatusId').firstChild.data = '" . $patStatusLabels[$lang][13] . "';";      
	}
        $hivPos = getHivPositive ($pid);
	echo " 
		parent.document.getElementById('clinSumLinkId').innerHTML = '<a onclick=\"launchClinicalSummary($hivPos)\" href=\"#\">" . $sumTitle[$lang] . "</a>';
</script>
";
}
echo "
<form name=\"mainForm\" action=\"allEnc.php?site=$site&amp;lang=$lang&amp;pid=$pid&amp;lastPid=$lastPid\" method=\"get\"> 
<div id=\"encsMain\">
<input type=\"hidden\" name=\"site\" value=\"$site\" >
<input type=\"hidden\" name=\"lang\" value=\"$lang\" >
<input type=\"hidden\" name=\"pid\" value=\"$pid\" >
<input type=\"hidden\" name=\"lastPid\" value=\"$lastPid\" >
<input type=\"hidden\" name=\"pageNum\" value=\"$pageNum\" >
";

$tabIndex = 0;

  // Display 'Successfully Saved' message, if code passed in
if (isset($code)) {
	if ($code == 1)
		echo "<h4 class=\"statusFormError\">" . $formStatus[$lang][1] . "</h4><p>";
	else
		echo "<h4 class=\"statusFormOk\">" . $formStatus[$lang][0] . "</h4><p>";
}

if (getAccessLevel (getSessionUser ()) != 0 && SERVER_ROLE != "consolidated") {
	echo "
        <table class=\"header\">
            <tr>
                <td class=\"m_header\">" . $newEnc_header[$lang]. "</td>
            </tr>
            <tr>
                <td class=\"newForms\">
	";
	$menuOrder = array();
	if (isPediatric($pid)) {
		if (PC_AUTH) array_push($menuOrder, $newEnc_sections[$lang][0], 29, 31); 
		array_push($menuOrder, $newEnc_sections[$lang][1], 19, 32, 18);
		if (OB_AUTH) if (isFemale()) array_push($menuOrder, $newEnc_sections[$lang][2], 24, 25, 26); 
		if (HIV_AUTH) array_push($menuOrder, $newEnc_sections[$lang][3], 16, 17, 20, 21); 
	} else {
		if (PC_AUTH) array_push($menuOrder, $newEnc_sections[$lang][0], 27, 28); 
		array_push($menuOrder, $newEnc_sections[$lang][1], 6, 32, 5);
		if (OB_AUTH) if (isFemale()) array_push($menuOrder, $newEnc_sections[$lang][2], 24, 25, 26); 
		if (HIV_AUTH) array_push($menuOrder, $newEnc_sections[$lang][3], 1, 2, 3, 4, 14, 7, 9, 11, 12); 
	}   

        // PHP to check whether IE (for fingerprint scanning). Could (should?) be done with javascript? Need be able to tell if scanner is available.
        $ub = '';
        if (preg_match('/MSIE/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('/Trident/i', $_SERVER['HTTP_USER_AGENT'])) {
                $ub = "ie";
        }
        // Check whether fingerprintURL is not null. FIXME: Doesn't necessarily mean that it's working properly & software is installed.
        $fingerprintStatusUI = false;
        if (getConfig('fingerprintURL') != Null) {
            $fingerprintStatusUI = true;
        }

        if ($ub == "ie" && $fingerprintStatusUI == true)
	  array_push($menuOrder, $newEnc_sections[$lang][4], 30, 33);
        else
	  array_push($menuOrder, $newEnc_sections[$lang][4], 30);

	$firstFlag = false; 
  	foreach ($menuOrder as $i) {
		if (is_String($i)) {
            		if ($firstFlag) echo "<p>";
            		echo "<b>" . $i . "&nbsp;:&nbsp;</b>";
            		$heading = true;
            		continue;
        	}
        	if (!$heading) echo " | ";
        	$firstFlag = true;
        	if ($i == 30) echo "<a class=\"newForm\" href=\"findGlobal.php?lang=$lang&amp;pid=$pid&amp;type=$i&amp;site=$site\">" . $encType[$lang][$i] . "</a>";
        	else if ($i == 33) echo "<a class=\"newForm\" href=\"readSmartcard.php?lang=$lang&amp;pid=$pid&amp;type=$i&amp;site=$site\">" . $encType[$lang][$i] . "</a>";
        	else echo "<a class=\"newForm\" href=\"" . $typeArray[$mapArray[$i]] . ".php?lang=$lang&amp;pid=$pid&amp;type=$i&amp;site=$site\">" . $encType[$lang][$i] . "</a>"; 
 		//if (($i == 6 || $i == 19) && getConfig('labOrderUrl') != Null) echo " | <a class=\"newForm\" href=\"" . $typeArray[$mapArray[$i]] . ".php?lang=$lang&amp;pid=$pid&amp;type=$i&amp;eid=&amp;site=$site\">" . "Forme de laboratoire" . "</a>"; 
        	$heading = false;
	}
	echo "
        </td></tr>
        <tr><td class=\"m_header\">" . $allEnc[$lang][1] . "</td>
        </tr>
        </table>
        ";
}
// If patient ID given, display all encounters
if (!empty ($pid) && preg_match ('/^\d+$/', $pid)) {
	$existingData = array ();
	getPatientData ($pid);  
	getRecentEncounters ($pid, $site, $lang, $pageNum); 
	if (!empty ($existingData['encounters'])) {
		echo "
		<table class=\"header2\">";
		if ($pageNum > 1 || $pageNum < $existingData['lastPage']) {
			echo "
			<caption class=\"pages\">" . $allEnc[$lang][11] . " " . $pageNum . " " . $allEnc[$lang][12] . " " . $existingData['lastPage'] . "<br>";
			echo ($pageNum > 1) ? "<a  class=\"pages\" href=\"allEnc.php?pid=$pid&amp;lang=$lang&amp;site=$site&amp;pageNum=" . ($pageNum - 1) . "\">" . $allEnc[$lang][4] . "</a>" : $allEnc[$lang][4];
			echo " | ";
			echo ($pageNum < $existingData['lastPage']) ? "<a  class =\"pages\" href=\"allEnc.php?pid=$pid&amp;lang=$lang&amp;site=$site&amp;pageNum=" . ($pageNum + 1) . "\">" . $allEnc[$lang][5] . "</a>" : $allEnc[$lang][5];
			echo "
			</caption>
			";
		}
		echo "
			<tr>
			<th class=\"allEncsH\" width=\"5%\"><b>" . $menuPatients[$lang][6] . "</b></th>
			<th class=\"allEncsH\" width=\"17%\"><b>" . $menuPatients[$lang][21] . "</b></th>
			<th class=\"allEncsH\" width=\"10%\"><b>" . $formSubmit[$lang][1] ."</b></th>
			<th class=\"allEncsH\" width=\"7%\"><b>" . $formHeadings[$lang][0] . "</b></th>
			<th class=\"allEncsH\" width=\"7%\"><b>" . $formHeadings[$lang][1] ."</b></th>
			<th class=\"allEncsH\" width=\"15%\"><b>" . $allEnc[$lang][3] . "</b></th>
			<th class=\"allEncsH\" width=\"7%\"><b>" . $formHeadings[$lang][2] . "</b></th>
			<th class=\"allEncsH\" width=\"3%\"><b>" . $formHeadings[$lang][3] . "</b></th>
			</tr>";
		$line = 0;
		foreach ($existingData['encounters'] as $eid => $encArr) {
			$review='';
			$complete='';
			$error='';
			$deleted='';
			$incomplete = '';
			$form = $typeArray[$mapArray[$encArr['encounterType']]] . ".php";
			$version = $encArr['formVersion'];
			$type = $encArr['encounterType']; 
			if ($type == 13) continue;
			$sname = $encType[$lang][$encArr['encounterType']];
			$author = $encArr['formAuthor'];
			$creator = $encArr['creator'];
			$lastMod = $encArr['lastMod'];
			$formAuthor2 = $encArr['formAuthor2'];
			$dataEntry = '';
			$pid = $encArr['pid'];
			if(strlen($creator) > 0){
				$dataEntry = $creator;
			}
			if($type == '15'){
				$form = 'register.php';
			}
			if(strlen($lastMod) > 0){
				if(strlen($dataEntry) > 0){
					$dataEntry .= "/";
				}
				$dataEntry .= $lastMod; 
			}

			if($line % 2 == 0){
				$lineColor = "#dcdcdc";
			} else {
				$lineColor = "#FFFFFF";
			}

			$line++;

			$x = $encArr['encStatus'];
			// lab status
			$isLab = (in_array($type,array(6,19)) && $version == 3) ? true:false;
			$labStatus = $encArr['encounterStatus'];
			
			if (in_array($x,array(2,3,6,7)) || ($isLab && $labStatus == 2)) {
				$review = 'R';
				if (in_array($x,array(1,3,5,7))) $lineColor = "#FFF8C6";
			}
			if (in_array($x,array(1,3,5,7)) || ($isLab && in_array($labStatus,array(3,4)))) {
				$error = 'E';
				$lineColor = "#E77471";
			}
			if (in_array($x,array(4,5,6,7)) || ($isLab && is_null($labStatus) && $encArr['toOE'] == 1)) {
				$incomplete = 'I'; 
				$lineColor = "#FFF8C6";
			} else if ($isLab && ($labStatus == 6 || $encArr['toOE'] == 2)) {
				$complete = 'C';
				
			} else {
				if ($x == 255 || ($isLab && $labStatus == 5)) {
					$deleted = $formStatus[$lang][7];
					$lineColor = "#B0C4DE";
				} else {
					if (!$isLab) $complete = 'C';
				} 
			}

			$disable = "";
			if($type == 10 || $type == 15 || SERVER_ROLE == "consolidated") $disable = "disabled";
			else {
				if($deleted == $formStatus[$lang][7]) {
					$disable = "disabled";
				} else {
					$disable = "";
				}
			}
			echo "
			<tr style=\"background-color: " . $lineColor . ";\">
			<td class=\"allEncs\" width =\"5%\">" . zpad (trim($encArr['visitDateDd']), 2) . "/" . zpad (trim ($encArr['visitDateMm']), 2) . "/" . zpad (trim ($encArr['visitDateYy']), 2) . "</td>
			<td class=\"allEncs\" width=\"17%\"><a href=\"$form?lang=$lang&amp;pid=$pid&amp;eid=$eid&amp;type=$type&amp;version=$version&amp;site=$site\" >$sname</a></td>
			<td class=\"allEncs\" style=\"text-align: center;\" width=\"10%\">";
			if ($deleted == $formStatus[$lang][7]) echo "<span class=\"deletedStat\">$deleted</span>";
			if ($error == "E") echo "<span class=\"errorStat\">$error</span>";
			if ($complete == "C") echo "<span class=\"complete\">$complete</span>";
			if ($review == "R") echo "<span class=\"review\">$review</span>";
			if ($incomplete == "I") echo "<span class=\"incomplete\">$incomplete</span>";
			echo "
                    </td>
                    <td class=\"allEncs\" width=\"7%\">" . $author . "</td>
                    <td class=\"allEncs\" width=\"7%\">" . $formAuthor2 . "</td>
                    <td class=\"allEncs\" width=\"15%\">" . datetime_conv ($encArr['lastModified'], 1) . "</td>
                    <td class=\"allEncs\" width=\"7%\">" . $dataEntry . "</td>
                    <td class=\"allEncs\" width=\"3%\"><input type=\"checkbox\" id=\"delete" . $eid . "\" name=\"" . $eid . "_delete\" value=\"" . $eid . "\" " . $disable . "></td>
                </tr>";
		}
		$genStatCodes = ($lang == 'fr') ? "Des codes d’état":"Status codes";
		$labStatCodes = ($lang == 'fr') ? "Codes de statut de laboratoire":"Lab status codes";
		echo "
            </table>
            <table width=\"100%\">
                <tr>
                    <td class=\"key\">
			<b>" . $genStatCodes . " :</b>&nbsp;&nbsp;".
				$formStatus[$lang][2] . " = <span class=\"errorStat\">'E'&nbsp;&nbsp;&nbsp;&nbsp;</span>" . 
				$formStatus[$lang][3] . " = <span class=\"complete\">'C'&nbsp;&nbsp;&nbsp;&nbsp;</span>" . 
				$formStatus[$lang][4] . " = <span class=\"review\">'R'&nbsp;&nbsp;&nbsp;&nbsp;</span>" . 
				$formStatus[$lang][5] . " = <span class=\"incomplete\">'I'&nbsp;&nbsp;&nbsp;&nbsp;</span>" . 
				$formStatus[$lang][6] . " = <span class=\"deletedStat\">'" . 
				$formStatus[$lang][7] . "'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		if (getConfig('labOrderUrl') != Null) echo "<br />
			<b>" . $labStatCodes . " :</b>&nbsp;&nbsp;".
				$formStatus[$lang][9] . " = <span class=\"errorStat\">'E'&nbsp;&nbsp;&nbsp;&nbsp;</span>" . 
				$formStatus[$lang][11] . " = <span class=\"complete\">'C'&nbsp;&nbsp;&nbsp;&nbsp;</span>" .  
				$formStatus[$lang][10] . " = <span class=\"review\">'R'&nbsp;&nbsp;&nbsp;&nbsp;</span>" . 
				$formStatus[$lang][8] . " = <span class=\"incomplete\">'I'&nbsp;&nbsp;&nbsp;&nbsp;</span>"; 
		echo "
		    </td>
                    <td id=\"delete\"><input type=\"button\" name=\"deleteForm\" id=\"deleteForm\" value=\"" . $allEnc[$lang][7]."\" onclick=\"confirmDel();\">
                    </td>
                </tr>
            </table>";
		// Previous/Next Page
		if ($pageNum > 1 || $pageNum < $existingData['lastPage']) {
			echo "
			<table class=\"header2\">
			<caption class=\"pages\">" . $allEnc[$lang][11] . " " . $pageNum . " " . $allEnc[$lang][12] . " " . $existingData['lastPage'] . "<br>";
			echo ($pageNum > 1) ? "<a  class=\"pages\" href=\"allEnc.php?pid=$pid&amp;lang=$lang&amp;site=$site&amp;pageNum=" . ($pageNum - 1) . "\">" . $allEnc[$lang][4] . "</a>" : $allEnc[$lang][4];
			echo " | ";
			echo ($pageNum < $existingData['lastPage']) ? "<a  class =\"pages\" href=\"allEnc.php?pid=$pid&amp;lang=$lang&amp;site=$site&amp;pageNum=" . ($pageNum + 1) . "\">" . $allEnc[$lang][5] . "</a>" : $allEnc[$lang][5];
			echo "</caption>
			<tr><td></td></tr>
			</table>";  
		}
	} else {
		echo "<h4 align=\"center\">" . $menuPatients[$lang][10] . "</h4>";
	}
} else {
	echo "<h4 align=\"center\">" . $allEnc[$lang][2] . "</h4>";
} 
echo "
	   </div>
	  </form>
	 </body>
	</html>";

/***
 *** 	set hivPositive = 0 if there aren't any encounters that indicate positive 
 ***/ 
function resetHivStatus ($pid) {
	// has to be zero undeleted intake/followup forms (not deleted) remaining to trigger toggle
	$qry = "select count(*) from encounter where encounterType in (1,2,16,17) and encStatus < 255 and patientid = '" . $pid . "'";
	$result = dbQuery($qry);
	$row = psRowFetch($result);
	if ($row[0] == 0) {
		// has to be zero undeleted primary care/ob-gyn forms with hivPositiveN/hivPositiveA
		$qry2 = "select count(*) from obs o, concept c, encounter e 
			where o.concept_id = c.concept_id and c.short_name in ('hivPositiveN','hivPositiveA') and
			o.encounter_id = e.encounter_id and o.location_id = e.sitecode and o.person_id = right(e.patientid,6) and
			e.encStatus < 255 and e.encounterType in (24,25,27,28,29,31) and e.patientid = '" . $pid . "'"; 
		$result = dbQuery($qry2);
		$row2 = psRowFetch($result);
		if ($row2[0] == 0) {
			$retCode = dbQuery("update patient set hivPositive = 0, patientStatus = 0 where patientID = '" . $pid . "'");
			return true; 
		}
	} else {
		return false;
	} 
	return false;	
}  

function getRecentEncounters ($pid, $site, $lang, $pg = 1) {
  if (!empty ($pid)) { 
	if (strpos($pid, ",") > 0) 
		$queryStmt = "SELECT count(*) AS total FROM encounter WHERE patientID in ($pid) AND siteCode = '$site' AND (encStatus < 255 or (encounterType in (12,21))) AND encounterType <> 13";
	else
    		$queryStmt = "SELECT count(*) AS total FROM encounter WHERE patientID = '$pid' AND siteCode = '$site' AND (encStatus < 255 or (encounterType in (12,21))) AND encounterType <> 13"; 
    $result = dbQuery ($queryStmt) or die ("FATAL ERROR: Couldn't search encounter table.");
    $row = psRowFetch ($result);
    $GLOBALS['existingData']['lastPage'] = ceil ($row['total'] / ENCOUNTERS_PER_PAGE);
    if ($GLOBALS['existingData']['lastPage'] < $pg) $pg = $GLOBALS['existingData']['lastPage'];
    $cnt = $pg * ENCOUNTERS_PER_PAGE;
    if (strpos($pid, ",") > 0) {
      $patientIdWhere = "patientID in ($pid)";
    } else {
      $patientIdWhere = "patientID = '$pid'";
    }
    $result = dbQuery("
	SELECT top $cnt e.encounter_id, rtrim(visitDateDd) as visitDateDd,rtrim(visitDateMm) as visitDateMm, rtrim(visitDateYy) as visitDateYy, e.encounterType, lastModified, encStatus, formVersion, dbo.ymdToDate(visitdateyy,visitdatemm,visitdatedd) as visitDate, formAuthor, e.creator, formAuthor2, lastmodifier, patientid as pid, q.encounterStatus, o.value_numeric 
	FROM encounter e 
	left join encounterQueue q on e.encounter_id = q.encounter_id and e.sitecode = q.sitecode
	left join obs o on e.encounter_id = o.encounter_id and e.sitecode = o.location_id and o.concept_id = 71445
	WHERE $patientIdWhere
	 AND e.siteCode = '$site' AND e.encounterType <> 13 
	 AND (encStatus < 255 or (e.encounterType in (12,21)))
	ORDER BY dbo.ymdToDate(visitdateyy,visitdatemm,visitdatedd) DESC, e.encounter_id desc") or die("FATAL ERROR: Couldn't search encounter table.");
	$i = 0;
	while ($row = psRowFetch($result)) {
		$i++;
		if ($pg > 0 && ($i < ($pg - 1) * ENCOUNTERS_PER_PAGE + 1 || $i > ($pg * ENCOUNTERS_PER_PAGE))) continue;
		$GLOBALS['existingData']['encounters'][$row[0]] = array (
			'visitDateDd' => trim ($row[1]),
			'visitDateMm' => trim ($row[2]),
			'visitDateYy' => trim ($row[3]),
			'encounterType' => $row[4],
			'lastModified' => $row[5],
			'encStatus' => $row[6],
			'formVersion' => $row[7],
			'formAuthor' => $row[9],
			'creator' => $row[10],
			'formAuthor2' => $row[11],
			'lastMod' => $row[12],
			'pid' => $row[13],
			'encounterStatus' => $row[14],
			'toOE' => $row[15]
		);  
	} 
  }
}
?>
