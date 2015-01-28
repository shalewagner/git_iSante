<?php

require_once 'backend.php';
require_once 'labels/nastad1.php';
require_once 'labels/report.php';
require_once 'labels/reportSetupLabels.php';

if (!empty ($_GET['lang'])) $lang = $_GET['lang'];
if (!empty ($_POST['lang'])) $lang = $_POST['lang'];
$lang = (empty ($lang) || !in_array ($lang, $langs)) ? $def_lang : $lang;

$site = (!empty ($_GET['site'])) ? $_GET['site'] : "";

if (!empty ($_GET['pid'])) {
	$pid = $_GET['pid'];
	// getting intake form data...
	$eid = getEidByPidAndType ($pid, "1");
	getExistingData ($eid, $tables);
}

getPatientData ($pid);

$errors = array ();

echo "
<html>
 <head>
  <meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-1\">
  <title>" . "NASTAD Case Form" . "</title>
  <link href=\"default.css\" type=\"text/css\" rel=\"StyleSheet\">
  <script language=\"JavaScript\" type=\"text/javascript\" src=\"include/formSubmit.js\"></script>
 </head>
 <body>";

if (getAccessLevel (getSessionUser ()) === 0) echo "
  <h4 align=\"center\" class=\"warning\">" . $errorMsg[$lang][1] . "</h4>";

if (!empty ($errors)) echo "
  <h4 align=\"center\" class=\"error\">" . $errorMsg[$lang][0] . "</h4>";

echo "
<table class=\"header\">
	<tr>
		<td class=\"m_header\">" .
			$mainTitle[$lang][1] . "
		</td>
	</tr>
</table>
<input type=\"button\" name=\"ret1\" value=\"" . $repReturn[$lang] . "\" onclick=\"history.back()\" />
<table>
	<tr>
		<td class=\"bold\" width=\"40%\">" .
			$reportedBy[$lang][1] . "_____________________________	________________________
			<br>			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" .
			$lastName[$lang][1] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . 	$firstName[$lang][1] . "
		</td>
		<td class=\"bold\" width=\"20%\">" .
			$reportDate[$lang][1];
			if ($lang == "fr")
				echo date("d/m/Y");
			else
				echo date("m/d/Y");
			echo "
			<br>			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $monDayYear[$lang][1] . "
		</td>
	</tr>
	<tr>
		<td class=\"bold\" colspan=\"10\">" .
			$siteName[$lang][1] . " " . getSiteName ($site,$lang) . "
		</td>
	</tr>
</table>
<table class=\"b_header\">
   <tr>
    	<td class=\"m_header\">" . $subHead1[$lang][1] . "</td>
   </tr>
   <tr>
    	<td>
     		<table class=\"header\">
      			<tr>
					 <td class=\"sm_header_lt_pd\">" .
					 	$addrDistrict[$lang][1] . ": " . getData ("addrDistrict", "textarea") . " " .
						$addrSection[$lang][1] . ": " . getData ("addrSection", "textarea") . "/" .
						$addrTown[$lang][1]    . ": " . getData ("addrTown", "textarea")  . "
					 </td>
					 <td class=\"sm_header_lt_pd\">
					 	Num&eacute;ro du dossier: ____________________
					 </td>
		  		</tr>
		  		<tr>
		  			<td class=\"sm_lt_pd\" align=\"center\">
		  				Commune&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Section communale / Ville
		  			</td>
		  		</tr>
		  		<tr>
					<td class=\"sm_header_lt_pd\">" .
							$fnameMother[$lang][1] . ": " . getData ("fnameMother", "textarea") . "
					</td>
					<td class=\"sm_header_lt_pd\">" .
							$nationalID[$lang][1] . "<br>" . getData ("nationalID", "textarea") . "
					</td>
				</tr>
		  		<tr>
					<td class=\"sm_header_lt_pd\">" .
							$birthDistrict[$lang][1] . ": " . getData ("birthDistrict", "textarea") . " " .
							$addrSection[$lang][1] . ": " . getData ("birthSection", "textarea") . "/" .
							$addrTown[$lang][1]    . ": " . getData ("birthTown", "textarea") . "
					</td>
				</tr>
		  		<tr>
		  			<td class=\"sm_lt_pd\" align=\"center\">
		  				Commune&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Section communale / Ville
		  			</td>
		  		</tr>
		     </table>
		</td>
	</tr>
	<tr>
		<td>
			  <table border=\"1\" class=\"header\">
			  <tr>
				   <td class=\"sm_header_lt_pd\">" .
					   $sex[$lang][0] . ": <input name=\"sex[]\" " . getData ("sex", "checkbox", 1) . " type=\"checkbox\" value=\"1\"> " . $sex[$lang][1] . " <input name=\"sex[]\" " . getData ("sex", "checkbox", 2) . " type=\"checkbox\" value=\"2\"> " . $sex[$lang][2] . "<br><br>" .
					   $pregnant[$lang][0] . "
					   <input name=\"pregnant[]\" " . getData ("pregnant", "checkbox", 1) .
							" type=\"checkbox\" value=\"1\">" . $pregnant[$lang][1] . "
					   <input name=\"pregnant[]\" " . getData ("pregnant", "checkbox", 2) .
							" type=\"checkbox\" value=\"2\">" . $pregnant[$lang][2] . "
				   </td>
				   <td class=\"sm_header_lt_pd\">" .
					   $dobDd[$lang][1] . ": &nbsp;" . getData ("dobDd", "textarea") . "/&nbsp;" . getData ("dobMm", "textarea") . "/&nbsp;" . getData ("dobYy", "textarea") . "
					   <br>
					   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $monDayYear[$lang][1] . "
					   <br><br>" .
					   $ifDOBUnk[$lang][1] . "
					   <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" .
					   $ageYears[$lang][1] . "&nbsp;" . getData ("ageYears", "textarea") . "
				   </td>
				   <td>
				   		<table>
				   			<tr>
								<td class=\"sm_header_lt_pd\" colspan=\"3\">" . $occupation[$lang][1] . ": " .
									getData ("occupation", "textarea") . "
								</td>
							</tr>
							<tr>
								<td class=\"sm_header_lt_pd\">" .
										$maritalStatus[$lang][0] . "
								</td>
								<td class=\"sm_header_lt_pd\">
								 	<input name=\"maritalStatus[]\" " . getData ("maritalStatus", "checkbox", 1) . " type=\"checkbox\" value=\"1\"> " . $maritalStatus[$lang][1] . "</td>
								<td class=\"sm_header_lt_pd\">
								 	<input name=\"maritalStatus[]\" " . getData ("maritalStatus", "checkbox", 2) . " type=\"checkbox\" value=\"2\"> " . $maritalStatus[$lang][2] . "
								</td>
							</tr>
							<tr>
								</td><td>
								<td class=\"sm_header_lt_pd\">
								 <input name=\"maritalStatus[]\" " . getData ("maritalStatus", "checkbox", 4) . " type=\"checkbox\" value=\"4\"> " . $maritalStatus[$lang][3] . "
								 </td>
								 <td class=\"sm_header_lt_pd\">
								 <input name=\"maritalStatus[]\" " . getData ("maritalStatus", "checkbox", 8) . " type=\"checkbox\" value=\"8\"> " . $maritalStatus[$lang][4] . "
								 </td>
							</tr>
							<tr>
								</td><td>
								<td class=\"sm_header_lt_pd\">
								 <input name=\"maritalStatus[]\" " . getData ("maritalStatus", "checkbox", 16) . " type=\"checkbox\" value=\"16\"> " . $maritalStatus[$lang][5] . "
								 </td>
								 <td class=\"sm_header_lt_pd\">
								 <input name=\"maritalStatus[]\" " . getData ("maritalStatus", "checkbox", 32) . " type=\"checkbox\" value=\"32\"> " . $maritalStatus[$lang][6] . "
								 </td>
							</tr>
						</table>
				    </td>
			    </tr>
			</table>
		 </td>
	  </tr>
  </table>";

// Mode of transmission
  $eid = getEidByPidAndType ($pid, "1");
  if (!empty($eid)) {
	  $tables = array ("adherenceCounseling", "allergies", "allowedDisclosures", "arvAndPregnancy", "arvEnrollment", "buddies", "comprehension", "conditions", "discEnrollment", "drugs", "followupTreatment", "homeCareVisits", "householdComp", "labs", "medicalEligARVs", "needsAssessment", "otherDrugs", "otherLabs", "otherPrescriptions", "patientEducation", "prescriptions", "referrals", "riskAssessment", "symptoms", "tbStatus", "vitals");

	echo "<table class=\"b_header\">
	   <tr>
			<td class=\"m_header\" colspan=\"10\">" . $subHead2[$lang][1] . "</td>
	   </tr>
				<tr>
				 <td class=\"sm_header_lt_pd\">" . $sexWithHomoBi[$lang][0] . "</td>
				 <td class=\"sm_header_lt_pd\"><input name=\"sexWithHomoBi[]\" " . getData ("sexWithHomoBi", "checkbox", 1) . " type=\"checkbox\" value=\"1\">" . showValidationIcon ("1", "sexWithHomoBi") . " " . $sexWithHomoBi[$lang][1] . " <input name=\"sexWithHomoBi[]\" " . getData ("sexWithHomoBi", "checkbox", 2) . " type=\"checkbox\" value=\"2\">" . showValidationIcon ("1", "sexWithHomoBi") . " " . $sexWithHomoBi[$lang][2] . " <input name=\"sexWithHomoBi[]\" " . getData ("sexWithHomoBi", "checkbox", 4) . " type=\"checkbox\" value=\"4\">" . showValidationIcon ("1", "sexWithHomoBi") . " " . $sexWithHomoBi[$lang][3] . "
				 </td>
				<td class=\"sm_header_lt_pd\">" .
					$stdHistory[$lang][0] . "
				</td>
				 <td class=\"sm_header_lt_pd\"><input name=\"stdHistory[]\" " . getData ("stdHistory", "checkbox", 1) . " type=\"checkbox\" value=\"1\">" . showValidationIcon ("1", "stdHistory") . " " . $stdHistory[$lang][1] . " <input name=\"stdHistory[]\" " . getData ("stdHistory", "checkbox", 2) . " type=\"checkbox\" value=\"2\">" . showValidationIcon ("1", "stdHistory") . " " . $stdHistory[$lang][2] . " <input name=\"stdHistory[]\" " . getData ("stdHistory", "checkbox", 4) . " type=\"checkbox\" value=\"4\">" . showValidationIcon ("1", "stdHistory") . " " . $stdHistory[$lang][3] . "</td>
				</tr>

				<tr>
				 <td class=\"sm_header_lt_pd\">" . $sexWithoutCondom[$lang][0] . "</td>
				 <td class=\"sm_header_lt_pd\"><input name=\"sexWithoutCondom[]\" " . getData ("sexWithoutCondom", "checkbox", 1) . " type=\"checkbox\" value=\"1\"> " . $sexWithoutCondom[$lang][1] . " <input name=\"sexWithoutCondom[]\" " . getData ("sexWithoutCondom", "checkbox", 2) . " type=\"checkbox\" value=\"2\"> " . $sexWithoutCondom[$lang][2] . " <input name=\"sexWithoutCondom[]\" " . getData ("sexWithoutCondom", "checkbox", 4) . " type=\"checkbox\" value=\"4\"> " . $sexWithoutCondom[$lang][3] . "</td>

				 <td class=\"sm_header_lt_pd\">" . $injectionDrugs[$lang][0] . "</td>
				 <td class=\"sm_header_lt_pd\"><input name=\"injectionDrugs[]\" " . getData ("injectionDrugs", "checkbox", 1) . " type=\"checkbox\" value=\"1\"> " . $injectionDrugs[$lang][1] . " <input name=\"injectionDrugs[]\" " . getData ("injectionDrugs", "checkbox", 2) . " type=\"checkbox\" value=\"2\"> " . $injectionDrugs[$lang][2] . " <input name=\"injectionDrugs[]\" " . getData ("injectionDrugs", "checkbox", 4) . " type=\"checkbox\" value=\"4\"> " . $injectionDrugs[$lang][3] . "</td>
				 </tr>
				<tr>
				 <td class=\"sm_header_lt_pd\">" . $sexWithCommercialSexWorker[$lang][0] . "</td>
				 <td class=\"sm_header_lt_pd\"><input name=\"sexWithCommercialSexWorker[]\" " . getData ("sexWithCommercialSexWorker", "checkbox", 1) . " type=\"checkbox\" value=\"1\">" . showValidationIcon ("1", "sexWithCommercialSexWorker") . " " . $sexWithCommercialSexWorker[$lang][1] . " <input name=\"sexWithCommercialSexWorker[]\" " . getData ("sexWithCommercialSexWorker", "checkbox", 2) . " type=\"checkbox\" value=\"2\">" . showValidationIcon ("1", "sexWithCommercialSexWorker") . " " . $sexWithCommercialSexWorker[$lang][2] . " <input name=\"sexWithCommercialSexWorker[]\" " . getData ("sexWithCommercialSexWorker", "checkbox", 4) . " type=\"checkbox\" value=\"4\">" . showValidationIcon ("1", "sexWithCommercialSexWorker") . " " . $sexWithCommercialSexWorker[$lang][3] . "</td>

				 <td class=\"sm_header_lt_pd\">" . $sexAssault[$lang][0] . "</td>
				 <td class=\"sm_header_lt_pd\"><input name=\"sexAssault[]\" " . getData ("sexAssault", "checkbox", 1) . " type=\"checkbox\" value=\"1\">" . showValidationIcon ("1", "sexAssault") . " " . $sexAssault[$lang][1] . " <input name=\"sexAssault[]\" " . getData ("sexAssault", "checkbox", 2) . " type=\"checkbox\" value=\"2\">" . showValidationIcon ("1", "sexAssault") . " " . $sexAssault[$lang][2] . " <input name=\"sexAssault[]\" " . getData ("sexAssault", "checkbox", 4) . " type=\"checkbox\" value=\"4\">" . showValidationIcon ("1", "sexAssault") . " " . $sexAssault[$lang][3] . "</td>

				</tr>

				<tr>
				 <td class=\"sm_header_lt_pd\">" . $bloodTrans[$lang][0] . "</td>
				 <td class=\"sm_header_lt_pd\"><input name=\"bloodTrans[]\" " . getData ("bloodTrans", "checkbox", 1) . " type=\"checkbox\" value=\"1\">" . showValidationIcon ("1", "bloodTrans") . " " . $bloodTrans[$lang][1] . " <input name=\"bloodTrans[]\" " . getData ("bloodTrans", "checkbox", 2) . " type=\"checkbox\" value=\"2\">" . showValidationIcon ("1", "bloodTrans") . " " . $bloodTrans[$lang][2] . " <input name=\"bloodTrans[]\" " . getData ("bloodTrans", "checkbox", 4) . " type=\"checkbox\" value=\"4\">" . showValidationIcon ("1", "bloodTrans") . " " . $bloodTrans[$lang][3] . "</td>

				 <td class=\"sm_header_lt_pd\">" . $bloodExp[$lang][0] . "</td>
				 <td class=\"sm_header_lt_pd\"><input name=\"bloodExp[]\" " . getData ("bloodExp", "checkbox", 1) . " type=\"checkbox\" value=\"1\">" . showValidationIcon ("1", "bloodExp") . " " . $bloodExp[$lang][1] . " <input name=\"bloodExp[]\" " . getData ("bloodExp", "checkbox", 2) . " type=\"checkbox\" value=\"2\">" . showValidationIcon ("1", "bloodExp") . " " . $bloodExp[$lang][2] . " <input name=\"bloodExp[]\" " . getData ("bloodExp", "checkbox", 4) . " type=\"checkbox\" value=\"4\">" . showValidationIcon ("1", "bloodExp") . " " . $bloodExp[$lang][3] . "</td>
				</tr>
				<tr>
				  <td class=\"sm_header_lt_pd\">&nbsp;&nbsp;" . $bloodTransYear[$lang][1] . "</td>
				 <td class=\"sm_header_lt_pd\"><input name=\"bloodTransYear\" " . getData ("bloodTransYear", "text") . " type=\"text\" size=\"10\" maxlen=\"16\">" . showValidationIcon ("1", "bloodTransYear") . "" . $bloodTransYear[$lang][2] . "</td>
				 <td class=\"sm_header_lt_pd\">" . $verticalTransmission[$lang][0] . "</td>
				 <td class=\"sm_header_lt_pd\"><input name=\"verticalTransmission[]\" " . getData ("verticalTransmission", "checkbox", 1) . " type=\"checkbox\" value=\"1\">" . showValidationIcon ("1", "verticalTransmission") . " " . $verticalTransmission[$lang][1] . " <input name=\"verticalTransmission[]\" " . getData ("verticalTransmission", "checkbox", 2) . " type=\"checkbox\" value=\"2\">" . showValidationIcon ("1", "verticalTransmission") . " " . $verticalTransmission[$lang][2] . " <input name=\"verticalTransmission[]\" " . getData ("verticalTransmission", "checkbox", 4) . " type=\"checkbox\" value=\"4\">" . showValidationIcon ("1", "verticalTransmission") . " " . $verticalTransmission[$lang][3] . "</td>
		 </tr>
		</table>";
  }

// Enrollment info
  $eid = getEidByPidAndType ($pid, "1");
  if (!empty($eid)) {
	  $tables = array ("adherenceCounseling", "allergies", "allowedDisclosures", "arvAndPregnancy", "arvEnrollment", "buddies", "comprehension", "conditions", "discEnrollment", "drugs", "followupTreatment", "homeCareVisits", "householdComp", "labs", "medicalEligARVs", "needsAssessment", "otherDrugs", "otherLabs", "otherPrescriptions", "patientEducation", "prescriptions", "referrals", "riskAssessment", "symptoms", "tbStatus", "vitals");

	  echo "
	  <table class=\"b_header\">
		<tr>
			<td class=\"m_header\" colspan=\"10\">" . $subHead3[$lang][1] . "</td>
		</tr>
		<tr>
			<td class=\"sm_header_lt_pd\">" .
				$diagnosisDate[$lang][1] . "<br><br>" .
				 getData ("visitDateMm", "textarea") . "/20" . getData ("visitDateYy", "textarea") . "<br><br>" .
				 $diagnosisSite[$lang][1] . getSiteName (getData ("siteCode","textarea") ) . "

			</td>
			<td rowspan=\"6\" class=\"vert_line\">&nbsp;</td>
			<td class=\"sm_header_lt_pd\">";
				$theDate = getData ("visitDateMm", "textarea") . "/20" . getData ("visitDateYy", "textarea");
				if (strlen($theDate) == 3) $theDate = "";
				echo $visitDate[$lang][1] . "<br><br>" .
					$theDate . "<br>" . $monthYear[$lang][1] . "<br><br>" .
					$visitSite . "&nbsp;" . getSiteName (getData ("siteCode","textarea") ) . "
				<br>
			</td>
			<td rowspan=\"6\" class=\"vert_line\">&nbsp;</td>
			<td class=\"sm_header_lt_pd\">" .
				$cd4Result[$lang][1] .
				getData ("CD4", "textarea") . $cd4Result[$lang][2] . getData ("CD4", "textarea") . "%<br>";
				$theDate = getData ("CD4DateMM", "textarea") . "/20" . getData ("CD4DateYY", "textarea");
				if (strlen($theDate) == 3) $theDate = "";
				echo "Date du test: " . $theDate . "<br>" . $monthYear[$lang][1] . "<br><br>";
				$checkFlag = "checked";
				if ( getData ("CD4", "textarea") != "" ) $checkFlag = "";
				echo "Non disponible <input type=\"checkbox\" " . $checkFlag . ">
			</td>
		</tr>
	  </table>";
  }

// Diagnosis info
  $eid = getEidByPidAndType ($pid, "1");
  if (!empty($eid)) {
	  $tables = array ("adherenceCounseling", "allergies", "allowedDisclosures", "arvAndPregnancy", "arvEnrollment", "buddies", "comprehension", "conditions", "discEnrollment", "drugs", "followupTreatment", "homeCareVisits", "householdComp", "labs", "medicalEligARVs", "needsAssessment", "otherDrugs", "otherLabs", "otherPrescriptions", "patientEducation", "prescriptions", "referrals", "riskAssessment", "symptoms", "tbStatus", "vitals");

	  echo "
	 <table class=\"b_header\">
	   <tr>
			<td class=\"m_header\" colspan=\"10\">" . $subHead4[$lang][1] . "</td>
	   </tr>
	   <tr>
			<td class=\"sm_header_lt_pd\">
				Date de premier diagnostic de SIDA<br>";
				$theDate = getData ("visitDateMm", "textarea") . "/20" . getData ("visitDateYy", "textarea");
				if (strlen($theDate) == 3) $theDate = "";
				echo "(Stade 3 ou Stade 4): " . $theDate . "&nbsp;&nbsp;&nbsp;<input " . getData ("currentHivStage", "checkbox", 2) . " type=\"checkbox\" value=\"2\"> Stade 3 <input " . getData ("currentHivStage", "checkbox", 4) . " type=\"checkbox\" value=\"4\"> Stade 4 <br><br>
				Pr&eacute;sence de tuberculose: <input " . getData ("suspectedTb", "checkbox", 1) . " type=\"checkbox\" value=\"1\"> Oui <input " . getData ("asymptomaticTb", "checkbox", 1) . " type=\"checkbox\" value=\"1\"> Non<br><br>
				Etablissement o&ugrave; le diagnostic a &eacute;t&eacute; r&eacute;alis&eacute;: " . getData ("currentTreatFac", "textarea") . "
			</td>
			<td rowspan=\"6\" class=\"vert_line\">&nbsp;</td>
			<td class=\"sm_header_lt_pd\">
				<b>R&eacute;sultat du plus r&eacute;cent test de CD4:</b><br>
				(&agrave; la date de diagnostic de SIDA)<br><br>" .
				getData ("CD4", "textarea") . "  cellules/ml et/ou  " . getData ("cellsPmm", "textarea") . " %<br>";
				$theDate = getData ("CD4DateMM", "textarea") . "/20" . getData ("CD4DateYY", "textarea");
				if (strlen($theDate) == 3) $theDate = "";
				echo "Date du test: " . $theDate . "<br>" . $monthYear[$lang][1] . "<br><br>";
				$checkFlag = "checked";
				if ( getData ("CD4", "textarea") != "" ) $checkFlag = "";
				echo "Non disponible <input type=\"checkbox\" " . $checkFlag . ">
			</td>
	   </tr>
	 </table>";
   }

// Treatment info

  // getting 1st prescription data
  $eid = getEidByPidAndType ($pid, "5");
  if (!empty($eid)) {
  	  $tables = array ( "drugs", "prescriptions");
	  getExistingData ($eid, $tables);

	  echo "<table class=\"b_header\">
	   <tr>
			<td class=\"m_header\" colspan=\"10\">" . $subHead5[$lang][1] . "</td>
		</tr>
		<tr>
				<td class=\"sm_header_lt_pd\">";
				$theDate = getData ("visitDateMm", "textarea") . "/20" . getData ("visitDateYy", "textarea");
				if (strlen($theDate) == 3) $theDate = "";
				echo "Date de la premi&egrave;r prescription de ARV: " . $theDate . "  Etablissement o&ugrave; l'ARV a &eacute;t&eacute; prescrit: " . getData ("siteCode", "textarea") . "<br>" . $monthYear[$lang][1] . "
				</td>
		</tr>
	   </table>";
   }

// Death

  // getting discontinuation data
  $eid = getEidByPidAndType ($pid, "12");
  if (!empty($eid)) {
  	  $tables = array ("discEnrollment");
	  getExistingData ($eid, $tables);

	  echo "<table class=\"b_header\">
	  <tr>
			<td class=\"m_header\" colspan=\"10\">" . $subHead6[$lang][1] . "</td>
	   </tr>
	   <tr>
			<td class=\"sm_header_lt_pd\">";
				$theDate = getData ("reasonDiscDeathMm", "textarea") . "/20" . getData ("reasonDiscDeathYy", "textarea");
				if (strlen($theDate) == 3) $theDate = "";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si le patient est d&eacute;c&eacute;d&eacute;, date du d&eacute;c&egrave;s: " . $theDate . "<br>" . $monthYear[$lang][1] . "
			</td>
	   </tr>
	 </table>";
  }
 echo "<input type=\"button\" name=\"ret2\" value=\"" . $repReturn[$lang] . "\" onclick=\"history.back()\" />
 </body>
</html>
";

?>
