<?php
$decStatus = getStatusByEncounterID($eid);
if($decStatus != 255 ) {
	$binStatusStr = sprintf("%03d", decbin($decStatus));
	$incomplete = ((substr($binStatusStr,0,1)=="1")) ? "checked=\"checked\"" : "";
	$complete = ((substr($binStatusStr,0,1)=="0")) ? "checked=\"checked\"" : "";
	$review = ((substr($binStatusStr,1,1)=="1")) ? "checked=\"checked\"" : "";
	$signatures = "";
	if(isset($formSubmitNames[$type])) {
	$signatures = $formSubmitNames[$type];
} else {
	$signatures = $formSubmitNames[""];
}
$signNum = sizeof($signatures[$lang]);

echo "
<!-- ******************************************************************** -->
<!-- *************************** Save Buttons *************************** -->
<!--  (tab indices " . ($tabIndex + 1) . " - " . ($tabIndex + 1000) . ")  -->
<!-- ******************************************************************** -->

<table class=\"header\" border=\"0\">
<tr>
<td>&nbsp;</td>
</tr>
<tr>
";
if(1 <= $signNum){
	echo "
		<td>" .
			$signatures[$lang][0] . ":" . "&nbsp;&nbsp;<input tabindex=\"" . ($tabIndex + 1) . "\" type=\"text\" name=\"formAuthor\" " . getData("formAuthor", "text") . " size=\"75\" maxlength=\"255\" />
		</td>
	</tr>";
}
if (2 == $signNum || 3 == $signNum || ($version == 1 && $type == 5) ){
echo "
<tr>
	<td>" .
		$signatures[$lang][1] . ":" . "&nbsp;&nbsp;<input tabindex=\"" . ($tabIndex + 2) . "\" type=\"text\" name=\"formAuthor2\" " . getData("formAuthor2", "text") . " size=\"75\" maxlength=\"255\" />
	</td>
</tr>";
}
echo "
<tr>
<td>&nbsp;</td>
</tr>
<!-- radio buttons -->
<tr>
<td>" . $formSubmit[$lang][1] . "</td>
</tr>
<tr>
<td>
<!-- incomplete status -->
<input tabindex=\"" . ($tabIndex + 3) . "\" name=\"errorOverride\" type=\"radio\" value=\"1\" " . $incomplete . " /> " . $formSubmit[$lang][2] . "
</td>
</tr>
<tr>
<td>
<!-- complete -->
<input tabindex=\"" . ($tabIndex + 4) . "\" name=\"errorOverride\" type=\"radio\" value=\"0\" " . $complete . " /> " . $formSubmit[$lang][3]. "
</td>
</tr>
<tr>
<td>
<!-- mark for review  -->
<input tabindex=\"" . ($tabIndex + 5) . "\" name=\"review\" type=\"checkbox\" value=\"1\" " . $review . "/> " . $formSubmit[$lang][4] . "
</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td>" .
	$formSubmit[$lang][7] . "<br /><textarea tabindex=\"" . ($tabIndex + 6) . "\" name=\"encComments\" rows=\"3\" cols=\"80\">" . ((empty ($eid)) ? "\n\n\n----------------- " . getSessionUser() . ", " . date ("d-M-Y g:i A") : getData ("encComments", "textarea")) . "</textarea>
</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td>
<!-- save button -->";

if (getAccessLevel (getSessionUser ()) == 0 || SERVER_ROLE == "consolidated") $disabled = "disabled";
else $disabled = "";

if (SERVER_ROLE == "production" || SERVER_ROLE == "test") {
	if(($type =="17" || $type =="2") && $mf == "2" ) {
		echo "<input tabindex=\"" . ($tabIndex + 7) . "\" class=\"button-maker button14\" type=\"button\" onClick=\"checkValuesM(null,'" . $formSubmit[$lang][6] . "')\" value=\"" . $formSubmit[$lang][5] . "\" id=\"formSaveButton\" " . $disabled . " />";
	} else {
		echo "<input tabindex=\"" . ($tabIndex + 7) . "\" class=\"button-maker button14\" type=\"button\" onClick=\"combineValues(null,'" . $formSubmit[$lang][6] . "')\" value=\"" . $formSubmit[$lang][5] . "\" id=\"formSaveButton\" " . $disabled . " />";
	}                                                           
}  
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <!-- cancel button -->";
if ($pid != "" && $_GET['tabcall'] != 1){
echo "
<input tabindex=\"" . ($tabIndex + 101) . "\" type=\"button\" class=\"button-maker button12-short\" onClick='location.href=\"allEnc.php?pid=$pid&amp;lang=$lang&amp;site=$site\";' value=\"" . $allEnc[$lang][0] . "/".$formCancel[$lang][1]."\" />
";
}
if (! DEBUG_FLAG) $filler = "";
else $filler = " Form Type:" . $type . " Form Version:" . $version;
echo $filler . "
</td>
</tr>
<tr>
<td>";
echo (!empty ($pid)) ? "
<input type=\"hidden\" name=\"page\" value=\"" . ((getAccessLevel (getSessionUser ()) !=  0) ? "allEnc.php" : "find.php") . "\" />" : "
<input type=\"hidden\" name=\"page\" value=\"find.php\" />";
if (!empty ($pid) && isset($GLOBALS['checkedBoxes']) && count($GLOBALS['checkedBoxes'] > 0)) {	
	echo "<input type=\"hidden\" name=\"checkedBoxes\" value=\"" . implode(",",$GLOBALS['checkedBoxes']) . "\">";
	$GLOBALS['checkedBoxes'] = array();
}

//echo "<input type=\"hidden\" id=\"checkedRadios\" name=\"checkedRadios\" value=\"\">";

$footer_version= "";
if ($version <> "0") {
	$footer_version = "_" . $formVersion[$type];
}
if (!isset(${$typeArray[$type] . "FormVersion" . $footer_version}[$lang][1])) {
	$footer_version = "";
}
$formVersion = ${$typeArray[$type]. "FormVersion" .$footer_version}[$lang][1];
echo "
</td>
</tr>
<tr>
<td class=\"formVersion\" align=\"right\">" . $formVersion . "</td>
</tr>
<tr>
<td>";
$subject = str_replace("'","X", $errorType[$lang][0] . $formVersion);
$linkText = $bugLabels[$lang][0];
echo "
<input id=\"bugButton\" type=\"button\" name=\"bugButton\" value=\"$linkText\" onclick=\"bugPopUp('" . $subject . "','" . $lang . "','" . getSessionUser() . "');\" />
</td>
</tr>
</table>
";
} 
?>
