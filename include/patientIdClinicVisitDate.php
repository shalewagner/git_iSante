<?php

$site = $_GET['site'];
echo "
<!-- ******************************************************************** -->
<!-- ***************** Patient ID / Clinic Site ***************** -->
<!-- ******************************************************************** -->
<input tabindex=\"0\" name=\"site\" value=\"$site\" type=\"hidden\" />
<input tabindex=\"0\" name=\"lang\" value=\"$lang\" type=\"hidden\"  />
<input tabindex=\"0\" name=\"type\" value=\"$type\" type=\"hidden\" />
<input tabindex=\"0\" name=\"version\" type=\"hidden\" value=\"$version\" />
<input tabindex=\"0\" id=\"eid\" name=\"eid\" value=\"$eid\" type=\"hidden\" />
<input tabindex=\"0\" name=\"pid\" value=\"$pid\" type=\"hidden\" />
<input tabindex=\"0\" name=\"siteName\" value=\"\" type=\"hidden\" />";

if($type != '15' && $type != '10') {
	echo "
	<input tabindex=\"0\" name=\"fname\" " . getData ("fname", "text") . " type=\"hidden\" />
	<input tabindex=\"0\" name=\"lname\" " . getData ("lname", "text") . " type=\"hidden\" />
	<input tabindex=\"0\" name=\"nationalID\" " . getData ("nationalID", "text") . " type=\"hidden\" />
	<input tabindex=\"0\" name=\"clinicPatientID\" " . getData ("clinicPatientID", "text") . " type=\"hidden\" />";
}
echo "
<input tabindex=\"0\" id=\"errFields\" name=\"errFields\" type=\"hidden\"  >
<input tabindex=\"0\" id=\"errMsgs\" name=\"errMsgs\" type=\"hidden\" >
<div id=\"formheader\">
<table  class=\"pidSection\" cellspacing = \"4\" width=\"500px\" >
<tr width=\"95%\">
	<td>";
	if (!empty ($type)) {
		echo "
		<table class=\"formType\">
		<tr >
			<td id=\"title\" class=\"m_header\" >" . ${$typeArray[$type] . 'FormTitle'}[$lang][1] . "</td>";
if ($type == "10" || $type == "15") {
	$pedLabel = ($lang == "fr") ? "P&eacute;diatrique" : "Pediatric"; 
	$tabCall = "0";
	if (isset($_REQUEST['tabcall'])) $tabCall = "1";
    echo "
		<td>
		<input tabindex=\"1\" onclick=\"callOtherReg(10," . $tabCall . ")\" name=\"isPediatric[]\" value=\"0\" type=\"radio\" " . $adultChecked . ">Adult
		<input tabindex=\"2\" onclick=\"callOtherReg(15," . $tabCall . ")\" name=\"isPediatric[]\" value=\"1\" type=\"radio\" " . $pedChecked . ">" . $pedLabel . "
		</td>
	"; 
}
echo "
			<td id=\"errorText\" ></td>
		</tr>
		</table>";
		echo "
		<table width=\"100%\" border=\"0\">";
		if (getAccessLevel (getSessionUser ()) === 0 ) {
			echo "
			<tr >
				<td colspan=\"2\"><h4 align=\"center\" class=\"warning\">" . $errorMsg[$lang][1] . "</h4></td>
			</tr>";
			}
		else if($type == 21 || $type == 12) {
			$fromStatus = getStatusByEncounterID($eid);
			if($fromStatus == 255) {
				echo "
				<tr >
					<td colspan=\"2\"><h4 align=\"center\" class=\"warning\">" . $errorMsg[$lang][1] . "</h4></td>
				</tr>";
			}
		}
		if (!empty ($errors)){
			echo "
			<tr>
				<td colspan=\"2\"><h4  class=\"error\">" . $errorMsg[$lang][0] . "</h4></td>
			</tr>";
			} else {
			echo "
			<tr>
				<td colspan=\"2\"><p id=\"errorMsg\">&nbsp;</p></td>
			</tr>";
			}
		echo "
		</table>
		<table width=\"70%\" border=\"0\">
			<tr>
				<td id=\"vDateTitle\" width=\"15%\">";
					$vstDate = getData ("visitDateDd", "textarea") . "/" . getData ("visitDateMm", "textarea") . "/" . getData ("visitDateYy", "textarea");
					if ($vstDate == "//") $vstDate = "";
					echo
					$visitDate[$lang][1] . "
					<input type=\"hidden\" name=\"vDateVal\" value=\"". $vstDate . "\" >
					<input type=\"hidden\" id=\"visitDateDd\" name=\"visitDateDd\">
					<input type=\"hidden\" id=\"visitDateMm\" name=\"visitDateMm\">
					<input type=\"hidden\" id=\"visitDateYy\" name=\"visitDateYy\">
				</td>
				<td width=\"15%\">
					<input tabindex=\"" . (-1) . "\" id=\"vDate\" name=\"vDate\" value=\"" . $vstDate . "\" type=\"text\" size=\"8\" maxlength=\"8\"/>
				</td>
				<td width=\"15%\">" . 
					$visitDate[$lang][2] . "
				</td>
				<td id=\"backButton\" width=\"55%\" align=\"center\">";
				if ($pid !="" && !isset($_REQUEST['tabcall'])){
					echo "
						<input type=\"button\" id=\"goBack\" name=\"goBack\" value=\"" . $allEnc[$lang][0] . "/". $formCancel[$lang][1] . "\" onclick='location.href=\"allEnc.php?pid=$pid&amp;lang=$lang&amp;site=$site\";'/>";
				} else {
					echo "&nbsp;";
				}
				echo "
				</td>
			</tr>
		</table>
		";
	};
	echo "
		</td>
	</tr>
</table></div>";
if ( $type != 0 ) {
	echo "<script type=\"text/javascript\" src=\"include/formSubmit.js\"></script>";
}
?>
