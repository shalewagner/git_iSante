<?php
$followType = 2;
if($type == 18 || $type == 19)
{
	$followType = 17;
} 
$followUpForms = getFollowupEncounters ($pid, $site, $followType);

$currVisitPointer = "";
if (isset($existingData['visitPointer'])) $currVisitPointer = $existingData['visitPointer'];
$intakeSelected = "";
$fupSelected = "";
$arvStartSelect = "";
$arvStartNot = "";

if (!empty($currVisitPointer)) {
	$visitID = getIntakeID($pid, $_GET['type']);
	if ($visitID == $currVisitPointer)
		$intakeSelected = "checked";
	else
		$fupSelected = "checked";
}
if ( isset($existingData['startedArv']) )
{
    if ( $existingData['startedArv'] == 1 )
        $arvStartSelect = "checked";
    else
        $arvStartNot = "checked";
}

$associatedFormHeader = (isset ($_GET['type']) && ((($_GET['type'] == 5 || $_GET['type'] == 6) && $version == 1) || $_GET['type'] == 18)) ? "
  <table class=\"b_header_nb\" cellspacing =\"0\" cellpadding=\"0\" border=\"0\">
   <tr>
    <td colspan=\"2\" class=\"under_header\" width=\"100%\">
    </td>
   </tr>
   <tr>
    <td class=\"s_header\" colspan=\"2\" width=\"100%\">" . $visitType_header[$lang][0] . "</td>
   </tr>
  </table>
" : "";

    echo $associatedFormHeader . "
    <!-- ******************************************************************** -->
    <!--       Form associated with a Lab or a Prescription Form              -->
    <!--   (tab indices " . ($tabIndex + 1) . " - " . ($tabIndex + 1000) . ") -->
    <!-- ******************************************************************** -->";

if ( isset($_GET['type']) && (($_GET['type'] == 5 && $version == 1) || $_GET['type'] == 18) ) {

   echo "
      <table class=\"b_header_nb\"  cellspacing =\"0\" cellpadding=\"0\" border=\"0\">
       <tr>
         <td width=\"40%\">
          <input type=\"radio\" name=\"formType\" value=\"intake\" " . $intakeSelected . "
            tabindex=\"" . ($tabIndex + 1) ."\">" . ((isset ($_GET['type']) && $_GET['type'] == 18) ? $associatedForm[1][$lang][3] : $associatedForm[$version][$lang][3]) . "
         </td>
         <td width=\"40%\">" .
            ((isset ($_GET['type']) && $_GET['type'] == 18) ? $arvVisitInfo[1][$lang][0] : $arvVisitInfo[$version][$lang][0]) . "
            <input type=\"radio\" id=\"startedArv1\" name=\"startedArv\" value=\"1\" " . $arvStartSelect . " tabindex=\"" . ($tabIndex + 3) ."\"/>" . $ARVexcl[$lang][1] . "
            <input type=\"radio\" id=\"startedArv0\" name=\"startedArv\" value=\"0\" " . $arvStartNot . " tabindex=\"" . ($tabIndex + 3) ."\"/>" . $ARVexcl[$lang][2] . "
         </td>
	 <td width=\"20%\">" .
            ((isset ($_GET['type']) && $_GET['type'] == 18) ? $dispcomm[1][$lang][0] : $dispcomm[$version][$lang][0]) . "
            <input type=\"checkbox\" id=\"dispComm\" name=\"dispComm\"  tabindex=\"" . ($tabIndex + 5) . "\" " . getData ("dispComm", "checkbox", 1) . " />
         </td>
       </tr>
       <tr>
        <td width=\"40%\">
          <input type=\"radio\" name=\"formType\" value=\"followUp\" " . $fupSelected . "
            tabindex=\"" . ($tabIndex + 1) ."\">" . ((isset ($_GET['type']) && $_GET['type'] == 18) ? $associatedForm[1][$lang][4] : $associatedForm[$version][$lang][4]) . "
            <select name=\"followUpFormId\" tabindex=\"" . ($tabIndex + 2) ."\">";
              while ($row = psRowFetchNum($followUpForms)) {
		if ($row[0] == $currVisitPointer) {
		  $currSelected = 'selected';
		} else {
		  $currSelected = '';
		}
		echo "<option value=\"" . $row[0] . "\" $currSelected>" . $row[1] . "/" .
		  $row[2] . "/" . $row[3];
              }
    echo "
            </select>
        </td>
        <td width=\"60%\"  colspan=\"2\"><table><tr><td width=\"50%\" id=\"arvStartDateDtTitle\">
            " . ((isset ($_GET['type']) && $_GET['type'] == 18) ? $arvVisitInfo[1][$lang][1] : $arvVisitInfo[$version][$lang][1]) . "</td><td>
            <input tabindex=\"" . ($tabIndex + 4) . "\" id=\"arvStartDate\" name=\"arvStartDateDt\"  value=\"" . getData ("arvStartDateDd", "textarea") . "/". getData ("arvStartDateMm", "textarea") ."/". getData ("arvStartDateYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\" />
            <input id=\"arvStartDateDd\" name=\"arvStartDateDd\" " . getData ("arvStartDateDd", "text") . " type=\"hidden\" />
            <input id=\"arvStartDateMm\" name=\"arvStartDateMm\" " . getData ("arvStartDateMm", "text") . " type=\"hidden\" />
            <input id=\"arvStartDateYy\" name=\"arvStartDateYy\" " . getData ("arvStartDateYy", "text") . " type=\"hidden\" />
        </td><td><span class=\"dateFormat\">" . $visitDate[$lang][2] . "</span></td></tr></table></td>
       </tr>
      </table>
    ";

} else {
	echo "
      <table class=\"b_header_nb_nw\"  cellspacing =\"0\" cellpadding=\"0\" border=\"0\">
       <tr>
        <td colspan=\"3\">&nbsp;</td>
       </tr>
       <tr>
        <td>" . ((isset ($_GET['type']) && $_GET['type'] == 19) ? $associatedForm[1][$lang][0] : $associatedForm[$version][$lang][0]) . "&nbsp;&nbsp;</td>
        <td>
          <input type=\"radio\" name=\"formType\" value=\"intake\" " . $intakeSelected . "
            tabindex=\"" . ($tabIndex + 1) ."\">" . ((isset ($_GET['type']) && $_GET['type'] == 19) ? $associatedForm[1][$lang][1] : $associatedForm[$version][$lang][1]) . "
        </td>
        <td>
          <input type=\"radio\" name=\"formType\" value=\"followUp\" " . $fupSelected . "
            tabindex=\"" . ($tabIndex + 1) ."\"/>" . ((isset ($_GET['type']) && $_GET['type'] == 19) ? $associatedForm[1][$lang][2] : $associatedForm[$version][$lang][2]) . "
            <select name=\"followUpFormId\" tabindex=\"" . ($tabIndex + 2) ."\">";
	      while ($row = psRowFetchNum($followUpForms)) {
		if ($row[0] == $currVisitPointer) {
		  $currSelected = "selected";
		} else {
		  $currSelected = "";
		}
		echo "<option value=\"" . $row[0] . "\" $currSelected>" . $row[1] . "/" .
		  $row[2] . "/" . $row[3];
              }
    echo "
            </select>
        </td>
       </tr>
      </table>
    ";
}

?>
