<?php

require_once 'include/standardHeaderExt.php';
require_once 'labels/findLabels.php';
require_once 'labels/gender.php';

// Check for blank site
if (empty ($site)) {
  header ("Location: error.php?type=auth&lang=$lang");
  exit;
}

$page = (getAccessLevel (getSessionUser ()) === 0) ? "find.php" : "newEnc.php";
$pageNum = (!empty ($_POST['pageNum'])) ? $_POST['pageNum'] : 1;
$existingData = array ("lastPage" => 1);

$unassignedFlg = (isset ($_POST['unassignedFlg1'])) ? $_POST['unassignedFlg1'] : "N";
$updateGender = (isset($_POST['updateGender'])) ? $_POST['updateGender'] : "0";
$orderID = (!empty ($_POST['orderID'])) ? $_POST['orderID'] : "1";

echo "
<title>" . $assignTitle[$lang][0] . "</title>
<script language=\"javascript\" type=\"text/javascript\">
function doPrint() {
	window.print();
}
function setOrder(orderID) {
  document.forms[0].orderID.value =  orderID;
  document.forms[0].submit();
}
function submitUpdateGender() {
  document.forms[0].updateGender.value = '1';
  document.forms[0].submit();
}
function submitIt (natid,clinicId, name,fname,lang,num) {
	 document.forms['mainForm'].nationalID.value = natid;
	 document.forms['mainForm'].clinicNumber.value = '$site';
	 document.forms['mainForm'].clinicID.value = clinicId;
	 document.forms['mainForm'].firstName.value = fname;
	 document.forms['mainForm'].lastName.value = name;
	 document.forms['mainForm'].lang.value = lang;
	 document.forms['mainForm'].pageNum.value = num;
	 document.forms[0].submit();
}
</script>
<body>
<form name=\"mainForm\" action=\"assignGender.php\" method=\"post\">";
include 'bannerbody.php';
echo "
	<input type=\"hidden\" name=\"type\" value=\"$type\" />
	<input type=\"hidden\" name=\"version\" value=\"$version\" />
	<input type=\"hidden\" name=\"eid\" value=\"$eid\" />
	<input type=\"hidden\" name=\"pid\" value=\"$pid\" />
	<input type=\"hidden\" name=\"lang\" value=\"$lang\" />
	<input type=\"hidden\" name=\"clinicNumber\" value=\"$site\" />
	<input type=\"hidden\" name=\"siteCode\" value=\"$site\" />
	<input type=\"hidden\" name=\"updateGender\" value=\"$updateGender\" />
	<input type=\"hidden\" name=\"orderID\" value=\"1\" />
	<input type=\"hidden\" name=\"selectedPatient\" />
	<input type=\"hidden\" name=\"selectedSite\" />
	<input type=\"hidden\" name=\"clinicID\" value=\"$clinicID\" />
	<input type=\"hidden\" name=\"unassignedFlg\" value=\"$unassignedFlg\" />";

	echo "
	<table class=\"formType\">
		<tr >
		<td id=\"title\" class=\"m_header\" width=\"50%\">" . $assignTitle[$lang][0] . "</td>
			<td id=\"errorText\" width=\"50%\"></td>
		</tr>
	</table>";

	$updated  = 0;
	$errorFlg = 0;
	echo "
	   <table width=\"100%\">
		<tr>
		 <td width=\"30%\">
		  <input type=\"button\" name=\"submitGender0\" onClick=\"submitUpdateGender();\" value = \"" .  $formSubmit[$lang][5] . "\" />
		 </td>
		 <td width=\"70%\">
		 	<input type=\"button\" name=\"print0\" onclick=\"doPrint();\" value = \"" .  $printerButton[$lang][0] . "\" />
		 </td>
		</tr>
	   </table>
	";
	if($updateGender) {
		$postkeys = array_keys($_POST);
		$msg = $updateMsg[$lang][0];
		foreach($postkeys as $postkey) {
			if(strlen($postkey) > 9 && substr($postkey,0,9) == 'PatientID') {
				$updateSex = 0;
				if(!empty($_POST[$postkey][0])) {
					$updateSex  += $_POST[$postkey][0];
				}
				if(!empty($_POST[$postkey][1])) {
					$updateSex  += $_POST[$postkey][1];
					$errorFlg = 1;
				}
				$oldSex = $_POST[substr($postkey, 9)];
				if($updateSex != $oldSex){
					$qry = "update patient set sex = '" . $updateSex . "' where patientID = '" . substr($postkey, 9) . "'" ;
					$result = dbQuery($qry);
					if($result > 0) {
						$updated = 1;
					}
				}
			} else if (strlen($postkey) > 9 && substr($postkey,0,9) == 'newFNMMom') {
				$newFNMMom = $_POST[$postkey];
				$oldFNMMom = $_POST[substr($postkey,3)];

				if($newFNMMom != $oldFNMMom){
					$qry = "update patient set fnameMother = '" . trim($newFNMMom) . "' where patientID = '" . substr($postkey, 9) . "'" ;
					$result = dbQuery($qry);
					if($result > 0) {
						$updated = 1;
					}
				}
			}
		}
	}
	$queryFlag = 0;
	if (!empty($unassignedFlg))
	$queryFlag = 1;

	$pageNum = 0;
	if ($queryFlag) {
	  $results = findGender ($site, $unassignedFlg , $orderID );
	  // output the result header
	  if (!empty ($results)) {
	    if($errorFlg) {
	    	echo "<br/><font color='red'>";
			echo $GenderStatus[$lang][1];
			echo "</font><br/>";
	    }
	    else if($updated) {
			echo "<br/>";
			echo $updateMsg[$lang][0];
			echo "<br/>";
		}

		echo "
		<table border=\"0\" class=\"header\">
		<tr>

		<td class=\"sm_header_lt\" width=\"8%\"><a class=\"onWhite\" href=\"#\" onclick=\"setOrder(1);\">" . $find_labels['column6'][$lang] . "</a></td>
		<td class=\"sm_header_lt\" width=\"8%\"><a class=\"onWhite\" href=\"#\" onclick=\"setOrder(2);\">" . $find_labels['column1'][$lang] . "</a></td>
		<td class=\"sm_header_lt\" width=\"8%\"><a class=\"onWhite\" href=\"#\" onclick=\"setOrder(3);\">" . $find_labels['column2'][$lang] . "</a></td>
		<td class=\"sm_header_lt\" width=\"8%\">" . $find_labels['column3'][$lang] . "</td>
		<td class=\"sm_header_lt\" width=\"8%\">" . $find_labels['column5'][$lang] . "</td>
		<td class=\"sm_header_lt\" width=\"1%\" >" . $gender_current[$lang][0] . "</td>
		<td class=\"sm_header_lt\" width=\"12%\">" . $gender_reassign[$lang][0] . "</td>
		<td class=\"sm_header_lt\" width=\"15%\">" . $find_labels['column4'][$lang] . "</td>
		</tr>";
		$j = 0;
		foreach ($results as $row) {
		   $j++;
		   if ($j % 2 == 0)
			  echo "<tr>";
		   else
			  echo "<tr bgcolor=\"Silver\">";
		   echo "
		   <td>".$row['clinicPatientID']."</td>
		   <td>".$row['lname']."</td>
		   <td>".$row['fname']."</td>";
		   if (strlen(trim($row['dobDd'])) == 1)
			  $row['dobDd'] = "0" . trim($row['dobDd']);

		   if (strlen(trim($row['dobMm'])) == 1)
			  $row['dobMm'] = "0" . trim($row['dobMm']);
		   if ($lang == "fr")
			  echo "<td>" . $row['dobDd'] . "/" . $row['dobMm'];
		   else
			  echo "<td>" . $row['dobDd'] . "/" . $row['dobMm'];


		   echo "/" . $row['dobYy'] . "</td>
			<td>" . $row['nationalID'] . "</td>";
		   echo "<td ><div align=\"middle\">";
		   if(1==$row['sex']||2==$row['sex']) {
		   	echo $gender[$lang][$row['sex']];
		   }
		   else {
		   	echo $other_gender[$lang][0];
		   }
		   echo "
		   </div></td>
		   <td align=\"left\" ". showGenderError($row['sex']) . " nowrap ><input type=\"radio\" name=\"PatientID" . $row['patientID'] . "[]\"  value=\"1\" " .isChecked(1, $row['sex'])  ." />" . $gender[$lang][1] . " &nbsp;<input type=\"radio\" name=\"PatientID" . $row['patientID'] . "[]\"  value=\"2\" " . isChecked(2, floor($row['sex'])) ." />" . $gender[$lang][2] . "
		   <input type=\"hidden\" name=\"". $row['patientID'] . "\"  value=\"". $row['sex'] . "\" ></td>
		   <td><input type=\"text\" name=\"newFNMMom" . $row['patientID'] . "\" value=\"".$row['fnameMother'] . "\" size=\"10\" maxsize=\"50\">
		   <input type=\"hidden\" name=\"FNMMom". $row['patientID'] . "\"  value=\"". $row['fnameMother'] . "\" ></td></td>
		   </tr>";
		}
	   }
	  }
echo "
   </table>
   <table width=\"100%\">
	<tr>
	 <td width=\"30%\">
	  <input type=\"button\" name=\"submitGender\" onClick=\"submitUpdateGender();\" value = \"" .  $formSubmit[$lang][5] . "\" />
	 </td>
	 <td width=\"70%\">
	 	<input type=\"button\" name=\"print\" onclick=\"doPrint();\" value = \"" .  $printerButton[$lang][0] . "\" />
	 </td>
	</tr>
   </table>
  </body>
</html>
";
function isChecked($origin,$current) {
	$value = "";
	if ($origin == $current){
		$value = "checked";
	}
	return $value;
}
function showGenderError($sex) {
	$error = "";
	if($sex < 1 || $sex > 2) {
		$error = "style=\"background-color: " . ERR_COLOR . "\"";
	}
	return $error;
}
?>
