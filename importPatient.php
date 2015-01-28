<?php
require_once 'include/standardHeaderExt.php';
require_once 'labels/findLabels.php';
require_once 'labels/menu.php';

if (empty ($site)) {
  header ("Location: error.php?type=auth&lang=$lang");
  exit;
}
$currentqry = (!empty ($_REQUEST['qrystring'])) ? $_REQUEST['qrystring'] : "";
if  (DEBUG_FLAG) print_r ($_REQUEST);
$pageNum = (!empty ($_POST['pageNum'])) ? $_POST['pageNum'] : 1;
$filename = (!empty ($_POST['upload'])) ? $_POST['upload'] : "";
$patType = (!empty ($_POST['patType'])) ? $_POST['patType'] : 0;
$index = (!empty ($_POST['selPatient'])) ? $_POST['selPatient'] : 0;
$existingData = array ("lastPage" => 1);

$titleLabel = ($lang == "fr") ? "Importer requ&ecirc;te de dossier ou transfert" : "Import records request or transfer";
$newPatLabel = ($lang == "fr") ? "Importer comme nouveau patient" : "Import as new patient";
$existPatLabel = ($lang == "fr") ? "Importer pour patient existant (rechercher ci-dessous)" : "Import for existing patient (search below)";
$fileUploadLabel = ($lang == "fr") ? "Le nom du dossier pour importer" : "Name of import file";
$orLabel = ($lang == "fr") ? " - ou - " : " - or - ";
$searchAgainLabel = ($lang == "fr") ? "Rechercher encore svp." : "Please search again.";
$importButtonLabel = ($lang == "fr") ? "Importer" : "Import";
$needFileLabel = ($lang == "fr") ? "Dossier est n\\351cessaire." : "Filename is required.";
$needPatTypeLabel = ($lang == "fr") ? "Type de importation est n\\351cessaire." : "Type of import is required.";
$needPatLabel = ($lang == "fr") ? "Patient existant est n\\351cessaire." : "Existing patient required.";
$siteMismatch = ($lang == "fr") ? "L\\047\\351tablissement actuel ne correspond pas \\340 celui dans le dossier d\\047importation." : "Selected clinic site does not match the site in import file.";
$badParams = ($lang == "fr") ? "Erreur fatale. S\\047il vous pla\\356t contacter un administrateur." : "Fatal error. Please contact an administrator.";

# Process POST, if available
$isError = 0;
if (!empty ($_POST)) {
  if (empty ($_POST['upload']) || empty ($_POST['patType']) || ($_POST['patType'] == 2 && empty ($_POST['selPatient']))) {
  } else {
    list ($_REQUEST['pid'], $_REQUEST['source'], $_REQUEST['target']) = explode ("_", substr ($_POST['upload'], 9, strlen ($_POST['upload']) - 13));
    if ($_POST['patType'] == 2) $_REQUEST['newpid'] = $_POST['selPatient'];
    include ("import-request.php");
    $result = ob_get_clean ();
    if (strpos ($result, "{\"success\"") > 0) {
      $begin = strpos ($result, "{\"success\"");
      $end = strpos ($result, "}", $begin);
      list ($junk, $junk, $junk, $junk, $junk, $myPid, $junk, $junk, $junk, $myEid) = explode ("\"", substr ($result, $begin, $end - $begin));
      header ("Location: patienttabs.php?lang=$lang&site=$site&pid=$myPid&fid=$myEid");
    } else {
      $isError = 1;
    }
  }
}

echo "
<title>" . $titleLabel . "</title>
<script language=\"javascript\" type=\"text/javascript\">
<!--
function impSubmit() {
	if (document.forms['mainForm'].upload.value == '' || document.forms['mainForm'].upload.value == 'no file') {
          alert ('" . $needFileLabel . "');
          document.forms['mainForm'].upload.focus();
          return (false);
        }
	if (document.forms['mainForm'].upload.value.substr(document.forms['mainForm'].upload.value.length - 9, 5) != document.forms['mainForm'].selectedSite.value) {
          alert ('" . $siteMismatch . "');
          document.forms['mainForm'].siteCode.focus();
          return (false);
        }
	if (!document.forms['mainForm'].patType[0].checked && !document.forms['mainForm'].patType[1].checked) {
          alert ('" . $needPatTypeLabel . "');
          document.forms['mainForm'].patType[0].focus();
          return (false);
        }
	if (document.forms['mainForm'].patType[1].checked && document.forms['mainForm'].selectedPatient.value == '') {
          alert ('" . $needPatLabel . "');
          document.forms['mainForm'].qrystring.focus();
          return (false);
        }
	document.forms['mainForm'].submit();
}
function onSubmit() {
	document.forms['mainForm'].pageNum.value = 1;
	document.forms['mainForm'].submit()
}
function submitIt (num) {
  //document.forms['mainForm'].qrystring.value = qrystring;
  document.forms['mainForm'].pageNum.value = num;
  document.forms['mainForm'].submit()
}
function selPat() {
  pid = document.forms['mainForm'].selectedPatient.value;
  if (pid == '') {
	alert('" . $find_labels['notSelected'][$lang] . "')
  } else {
	newUrl = 'patienttabs.php?pid=' + pid + '&lang=$lang&site=$site';
	location.href = newUrl;
  }

}
function saveCurrLine (pid) {
  document.forms['mainForm'].selectedPatient.value=pid;
}
function mySetParam (theType, theValue) {
	var newLoc = 'importPatient.php?lang=';
	if (theType == 'site')
		newLoc = newLoc + '$lang&site=' + theValue;
	else
		newLoc = newLoc + theValue + '&site=$site';
	window.location = newLoc;
};
// -->
</script>
</head>
<body";
if ($isError) echo " onLoad=\"alert('" . $badParams . "');\">"; else echo ">";
if(!empty($pid) && $pid != ""){
echo"
<script type=\"text/javascript\">
document.getElementById('" . $pid . "').checked = 'checked';
</script>
";
}
echo"
<form name=\"mainForm\" action=\"importPatient.php\" method=\"post\">
<input tabindex=\"0\" name=\"type\" value=\"$type\" type=\"hidden\" />
<input tabindex=\"0\" name=\"version\" value=\"$version\" type=\"hidden\"  />
<input tabindex=\"0\" name=\"eid\" value=\"$eid\" type=\"hidden\" />
<input tabindex=\"0\" name=\"pid\" value=\"$pid\" type=\"hidden\" />
<input type=\"hidden\" name=\"lang\" value=\"$lang\"/>
<input type=\"hidden\" name=\"pageNum\" value=\"$pageNum\" />
<input type=\"hidden\" name=\"clinicNumber\" value=\"" . $site . "\" />
<input type=\"hidden\" name=\"selectedPatient\" />
<input type=\"hidden\" name=\"selectedPatientName\" />
<input type=\"hidden\" name=\"selectedSite\" value=\"$site\" />";

include 'bannerbody.php';

echo "
<div class=\"contentArea\">
<table class=\"header\" >
	<tr>
		<td class=\"m_header\">" . $titleLabel . "</td>
	</tr>
</table>
<table>
	<tr>
		<td>" . $fileUploadLabel . ":</td>
		<td><input type=\"text\" id=\"upload\"  name=\"upload\" value=\"" . (!empty ($filename) ? $filename : "") . "\" /></td>
	</tr>
	<tr>
		<td colspan=\"2\"><input type=\"radio\" id=\"patType\" name=\"patType\" value=\"1\"" . ($patType == 1 ? "checked" : "") . "> " . $newPatLabel . "</td>
        </tr>
        <tr>
                <td colspan=\"2\">" . $orLabel . "</td>
	<tr>
		<td colspan=\"2\"><input type=\"radio\" id=\"patType\" name=\"patType\" value=\"2\"" . ($patType == 2 ? "checked" : "") . "> " . $existPatLabel . "</td>
        </tr>
        <tr>
		<td>
			<input type=\"button\" name=\"importButton\" onclick=\"impSubmit()\" value=\"" . $importButtonLabel . "\" />
		</td>
        </tr>
        <tr>
                <td colspan=\"2\"><hr /></td>
        </tr>
	<tr>
		<td>" . $find_labels['clinicIdLabel'][$lang]  .", ". $find_labels['fnameLabel'][$lang].", ".$find_labels['nameLabel'][$lang]. ":</td>
		<td><input type=\"text\" id=\"qrystring\"  name=\"qrystring\" value=\"" . $currentqry . "\" /></td>
	</tr>
	<tr>
		<td >
			<input type=\"button\" name=\"submitButton\" onclick=\"onSubmit()\" value=\"" . $find_labels['formSubmit'][$lang] . "\" />
		</td>
	</tr>
	</table>
";

	if (!empty($currentqry)) {
  		$results = findByName ($currentqry,$site,$lang,$pageNum, false);

	// output the result header
	$qryArray = explode(" ",$currentqry);
	if(!empty($results)){
		echo "
			<table id=\"findResults\" name=\"findResults\" border=\"0\" class=\"header\">
			<tr>
			<th class=\"sm_header_lt\">
			<th class=\"sm_header_lt\">" . $find_labels['column6'][$lang] . "</th>
			<th class=\"sm_header_lt\">" . $find_labels['column2'][$lang] . "</th>
			<th class=\"sm_header_lt\">" . $find_labels['column1'][$lang] . "</th>
			<th class=\"sm_header_lt\">" . $find_labels['column3'][$lang] . "</th>
			<th class=\"sm_header_lt\">" . $find_labels['column4'][$lang] . "</th>
			<th class=\"sm_header_lt\">" . $find_labels['column5'][$lang] . "</th>
			</tr>";
		$j = 0;
		foreach ($results as $row) {
		   $natID = $row['nationalID'];
		   $stID = $row['clinicPatientID'];
		   $fname = $row['fname'];
		   $lname = $row['lname'];
		   $checked = "";

		   foreach($qryArray as $token) {
		        $token = ucfirst($token);
				$natID = str_ireplace($token, "<span style = \"background-color:lightblue;\">".$token."</span>", $natID);
				$stID = str_ireplace($token, "<span style = \"background-color:lightblue;\">".$token."</span>", $stID);
				$fname = str_ireplace($token, "<span style = \"background-color:lightblue;\">".$token."</span>", $fname);
				$lname = str_ireplace($token, "<span style = \"background-color:lightblue;\">".$token."</span>", $lname);
		   }

		   $j++;
		   if (isset($index) && $row['patientID'] == $index) {
		   		$checked = "checked";
		   }
		   else
		   {
		   		$checked = "";
		   }
		   if ($j % 2 == 0)
			  echo "<tr>";
		   else
			  echo "<tr bgcolor=\"Silver\">";
		   echo "
		   <td align=\"center\"><input type=\"radio\" name=\"selPatient\" id=\"". $row['patientID']." \"" .  $checked . " value=\"" . $row['patientID'] . "\" onClick=\"saveCurrLine('". $row['patientID'] . "')\" />
		   <td>".$stID."</td>
		   <td>".$fname."</td>
		   <td>".$lname."</td>";
		   if (strlen(trim($row['dobDd'])) == 1)
			  $row['dobDd'] = "0" . trim($row['dobDd']);
		   if (strlen(trim($row['dobMm'])) == 1)
			  $row['dobMm'] = "0" . trim($row['dobMm']);
		   if ($lang == "fr")
			  echo "<td>" . $row['dobDd'] . "/" . $row['dobMm'];
		   else
			  echo "<td>" . $row['dobDd'] . "/" . $row['dobMm'];
		   echo "/" . $row['dobYy'] . "</td>
		   <td>".$row['fnameMother']."</td>
		   <td>".$natID."</td>
		   </tr>";
		}
		// Previous/Next Page
		if ($pageNum > 1 || $pageNum < $existingData['lastPage']) {
		  echo "
			 <tr height=\"50\">
			  <td align=\"left\" colspan=\"10\">" . $allEnc[$lang][11] . " " . $pageNum . " " . $allEnc[$lang][12] . " " . $existingData['lastPage'] . "&nbsp;&nbsp;&nbsp;";
			  echo ($pageNum > 1) ? "<a class=\"onWhite\"  onClick=\"submitIt ('" . ($pageNum - 1) . "'); return false;\" href=\"javascript:void(0)\">" . $allEnc[$lang][4] . "</a>" : $allEnc[$lang][4];
			  echo " | ";
			  echo ($pageNum < $existingData['lastPage']) ? "<a  class=\"onWhite\"  onClick=\"submitIt ('" . ($pageNum + 1) . "'); return false;\" href=\"javascript:void(0)\">" . $allEnc[$lang][5] . "</a>" : $allEnc[$lang][5];
			  echo "
			  </td>
			 </tr>";
		}
		echo "
		  </table>";
  } else {
	echo "<b>" . $find_labels['error1'][$lang] . " " . $searchAgainLabel . "</b>";
  }
}
?></div>
</form>
</body>
</html>
