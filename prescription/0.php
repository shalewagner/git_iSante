<?php
$rxOtherRows = rxOtherRows (4001);
$rxRows = rxRows (2001);
echo "
<!-- ******************************************************************** -->
<!-- ********************** Committee Approval ************************** -->
<!-- ******************* (tab indices 2001 - 3000) ********************** -->
<!-- ******************************************************************** -->

<div id=\"pane1\">
  <table class=\"header\">
   <tr>
    <td colspan=\"12\" class=\"under_header\" width=\"100%\">
    </td>
   </tr>
   <tr>
    <td class=\"s_header\" colspan=\"12\" width=\"100%\">" . $committeeApproval[$lang][2] . "</td>
   </tr>
   <tr>
    <td>" . $committeeApproval[$lang][3] . "&nbsp;<span>
      <input tabindex=\"2001\" name=\"committeeApproval[]\" " .
        getData ("committeeApproval", "checkbox", 1) .
        " type=\"radio\" value=\"1\">" .
        $committeeApproval[$lang][4] .
    " <input tabindex=\"2002\" name=\"committeeApproval[]\" " .
        getData ("committeeApproval", "checkbox", 2) .
        " type=\"radio\" value=\"2\">" . $committeeApproval[$lang][5] . "</span>
    </td>
    <td><table><tr><td id=\"committeeApprovalDateDtTitle\">" .
      $committeeApprovalDateDd[$lang][0] .
      "</td>
       <td>
       <input tabindex=\"2003\" id=\"committeeApprovalDateDt\" name=\"committeeApprovalDateDt\"  value=\"" . getData ("committeeApprovalDateDd", "textarea") . "/". getData ("committeeApprovalDateMm", "textarea") ."/". getData ("committeeApprovalDateYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\" />
       <input  									id=\"committeeApprovalDateDd\" name=\"committeeApprovalDateDd\" " . getData ("committeeApprovalDateDd", "text") . " type=\"hidden\">
       <input tabindex=\"2004\" id=\"committeeApprovalDateMm\" name=\"committeeApprovalDateMm\" " . getData ("committeeApprovalDateMm", "text") . " type=\"hidden\">
       <input tabindex=\"2005\" id=\"committeeApprovalDateYy\" name=\"committeeApprovalDateYy\" " . getData ("committeeApprovalDateYy", "text") . " type=\"hidden\">
       </td>
       <td><i>" . $committeeApprovalDateYy[$lang][2] . "</i></td></tr></table>
    </td>
   </tr>
  </table>
</div>

<!-- ******************************************************************** -->
<!-- *********************** New Prescription *************************** -->
<!-- ******************* (tab indices 3001 - 4000) ********************** -->
<!-- ******************************************************************** -->
<div id=\"pane2\">
  <table class=\"b_header_nb\" cellspacing =\"0\" cellpadding=\"0\" border=\"0\">
   <tr>
    <td class=\"s_header\" colspan=\"5\" width=\"45%\">" . $newprescription_header[$lang][1] . "</td>
    <td class=\"s_header\" colspan=\"5\" width=\"45%\">" . $newprescription_header[$lang][2] . "</td>
   </tr>
   <tr>
    <td class=\"sm_header_lt\" width=\"15%\">&nbsp;</td>
	<td class=\"sm_header_lt\" width=\"5%\">&nbsp;</td>
    <td colspan=\"2\" class=\"sm_header_lt\" width=\"15%\">" . $newprescription_subhead1[$lang][0] . "</td>
    <td class=\"sm_header_lt_pd\" width=\"13%\">" . $newprescription_subhead1[$lang][1] . "</td>
    <td class=\"sm_header_lt_pd\" width=\"9%\">" . $newprescription_subhead1[$lang][2] . "</td>
    <td class=\"sm_header_lt\" width=\"5%\">" . $newprescription_subhead7[$lang][0] . "</td>
    <td class=\"sm_header_lt_pd\" width=\"15%\">" . $newprescription_subhead8[$lang][0] . "</td>
    <td class=\"sm_header_lt_pd\" width=\"15%\">" . $newprescription_subhead7[$lang][1] . "</td>
    <td class=\"sm_header_lt_pd\" width=\"10%\">" . $newprescription_subhead7[$lang][2] . "</td>
   </tr>
   <tr>
    <td class=\"top_line\" colspan=\"5\" width=\"52%\"><b>
      <a class=\"toggle_display\"
         onclick=\"toggleDisplay(0,$rxSubHeadElems[0]);\"
         title=\"Toggle display\">
           <span id=\"section0Y\" style=\"display:none\">(+)</span>
           <span id=\"section0N\">(-)&nbsp;</span>" .
             $newprescription_subhead2[$version][$lang][1] .
     "</a></b>
    </td>
    <td class=\"top_line\" colspan=\"5\" width=\"45%\">&nbsp;</td>
   </tr>" . $rxRows["full"] . "
   <tr>
    <td colspan=\"12\" width=\"100%\">&nbsp;</td>
   </tr>
   <tr>
    <td class=\"s_header\" colspan=\"5\" width=\"45%\">" . $newprescription_header[$lang][1] . "</td>
    <td class=\"s_header\" colspan=\"5\" width=\"45%\">" . $newprescription_header[$lang][2] . "</td>
   </tr>
   <tr>
    <td class=\"sm_header_lt\" width=\"15%\">&nbsp;</td>
	<td class=\"sm_header_lt\" width=\"5%\">&nbsp;</td>
    <td colspan=\"3\" class=\"sm_header_lt_pd\" width=\"28%\">" . $newprescription_subhead2[$version][$lang][0] . "</td>
    <td class=\"sm_header_lt_pd\" width=\"9%\">" . $newprescription_subhead1[$lang][2] . "</td>
    <td class=\"sm_header_lt\" width=\"5%\">" . $newprescription_subhead7[$lang][0] . "</td>
    <td class=\"sm_header_lt_pd\" width=\"15%\">" . $newprescription_subhead8[$lang][0] . "</td>
    <td class=\"sm_header_lt_pd\" width=\"15%\">" . $newprescription_subhead7[$lang][1] . "</td>
    <td class=\"sm_header_lt_pd\" width=\"10%\">" . $newprescription_subhead7[$lang][2] . "</td>
   </tr>
   <tr>
    <td class=\"top_line\" colspan=\"5\" width=\"45%\"><b>" . $newprescription_subhead6[$lang][1] . "</b></td>
    <td class=\"top_line\" colspan=\"5\" width=\"45%\">&nbsp;</td>
   </tr>" . $rxOtherRows["full"] . "
  </table>
  </div>
";

$tabIndex = 5000;
echo "
<div id=\"pane3\">";
include ("include/adherenceCounseling.php");

echo "
  <table class=\"header\">
   <tr>
    <td valign=\"top\" width=\"54%\">
     <table>
      <tr>
       <td>" . $adherenceCounseling_subhead1[$lang][1] . " <i>" . $adherenceCounseling_subhead1[$lang][2] . "</i></td>
      </tr>
      <tr>
       <td><input tabindex=\"6001\" name=\"reasonNotAvail\" " . getData ("reasonNotAvail", "checkbox") . " type=\"checkbox\" value=\"On\">" . showValidationIcon ($type, "reasonNotAvail") . " " . $reasonNotAvail[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6002\" name=\"reasonForgot\" " . getData ("reasonForgot", "checkbox") . " type=\"checkbox\" value=\"On\">" . showValidationIcon ($type, "reasonForgot") . " " . $reasonForgot[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6003\" name=\"reasonSideEff\" " . getData ("reasonSideEff", "checkbox") . " type=\"checkbox\" value=\"On\">" . showValidationIcon ($type, "reasonSideEff") . " " . $reasonSideEff[$lang][1] . " <i>" . $reasonSideEff[$lang][2] . "</i></td>
      </tr>
      <tr>
       <td><input tabindex=\"6004\" name=\"reasonPrison\" " . getData ("reasonPrison", "checkbox") . " type=\"checkbox\" value=\"On\">" . showValidationIcon ($type, "reasonPrison") . " " . $reasonPrison[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6005\" name=\"reasonTooSick\" " . getData ("reasonTooSick", "checkbox") . " type=\"checkbox\" value=\"On\">" . showValidationIcon ($type, "reasonTooSick") . " " . $reasonTooSick[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6006\" name=\"reasonFinished\" " . getData ("reasonFinished", "checkbox") . " type=\"checkbox\" value=\"On\">" . showValidationIcon ($type, "reasonFinished") . " " . $reasonFinished[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6007\" name=\"reasonFeelWell\" " . getData ("reasonFeelWell", "checkbox") . " type=\"checkbox\" value=\"On\">" . showValidationIcon ($type, "reasonFeelWell") . " " . $reasonFeelWell[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6008\" name=\"reasonLost\" " . getData ("reasonLost", "checkbox") . " type=\"checkbox\" value=\"On\">" . showValidationIcon ($type, "reasonLost") . " " . $reasonLost[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6009\" name=\"reasonDidNotWant\" " . getData ("reasonDidNotWant", "checkbox") . " type=\"checkbox\" value=\"On\">" . showValidationIcon ($type, "reasonDidNotWant") . " " . $reasonDidNotWant[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6010\" name=\"reasonNotComf\" " . getData ("reasonNotComf", "checkbox") . " type=\"checkbox\" value=\"On\">" . showValidationIcon ($type, "reasonNotComf") . " " . $reasonNotComf[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6011\" name=\"reasonNoSwallow\" " . getData ("reasonNoSwallow", "checkbox") . " type=\"checkbox\" value=\"On\">" . showValidationIcon ($type, "reasonNoSwallow") . " " . $reasonNoSwallow[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6012\" name=\"reasonTravel\" " . getData ("reasonTravel", "checkbox") . " type=\"checkbox\" value=\"On\">" . showValidationIcon ($type, "reasonTravel") . " " . $reasonTravel[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6013\" name=\"reasonNoFood\" " . getData ("reasonNoFood", "checkbox") . " type=\"checkbox\" value=\"On\">" . showValidationIcon ($type, "reasonNoFood") . " " . $reasonNoFood[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6014\" name=\"reasonOther\" " . getData ("reasonOther", "checkbox") . " type=\"checkbox\" value=\"On\">" . showValidationIcon ($type, "reasonOther") . " " . $reasonOther[$lang][1] . " <input tabindex=\"6015\" name=\"reasonOtherText\" " . getData ("reasonOtherText", "text") . " type=\"text\" size=\"50\" maxlength=\"255\">" . showValidationIcon ($type, "reasonOtherText") . "</td>
      </tr>
     </table>
    </td>
    <td class=\"vert_line\" width=\"1%\">&nbsp;</td>
    <td class=\"left_pad\" valign=\"top\" width=\"45%\">
     <table>
      <tr>
       <td><b>" . $adherenceCounseling_subhead2[$lang][1] . "</b></td>
       <td align=\"center\">" . $adherenceCounseling_subhead3[$lang][0] . "</td>
       <td align=\"center\">" . $adherenceCounseling_subhead3[$lang][1] . "</td>
       <td align=\"center\">" . $adherenceCounseling_subhead3[$lang][2] . "</td>
      </tr>
      <tr>
       <td>" . $sideNausea[$lang][0] . "</td>
       <td align=\"center\"><input tabindex=\"6101\" name=\"sideNausea[]\" " . getData ("sideNausea", "checkbox", 1) . " type=\"checkbox\" value=\"1\"></td>
       <td align=\"center\"><input tabindex=\"6102\" name=\"sideNausea[]\" " . getData ("sideNausea", "checkbox", 2) . " type=\"checkbox\" value=\"2\"></td>
       <td align=\"center\"><input tabindex=\"6103\" name=\"sideNausea[]\" " . getData ("sideNausea", "checkbox", 4) . " type=\"checkbox\" value=\"4\"></td>
      </tr>
      <tr>
       <td>" . $sideDiarrhea[$lang][0] . "</td>
       <td align=\"center\"><input tabindex=\"6104\" name=\"sideDiarrhea[]\" " . getData ("sideDiarrhea", "checkbox", 1) . " type=\"checkbox\" value=\"1\"></td>
       <td align=\"center\"><input tabindex=\"6105\" name=\"sideDiarrhea[]\" " . getData ("sideDiarrhea", "checkbox", 2) . " type=\"checkbox\" value=\"2\"></td>
       <td align=\"center\"><input tabindex=\"6106\" name=\"sideDiarrhea[]\" " . getData ("sideDiarrhea", "checkbox", 4) . " type=\"checkbox\" value=\"4\"></td>
      </tr>
      <tr>
       <td>" . $sideRash[$lang][0] . "</td>
       <td align=\"center\"><input tabindex=\"6107\" name=\"sideRash[]\" " . getData ("sideRash", "checkbox", 1) . " type=\"checkbox\" value=\"1\"></td>
       <td align=\"center\"><input tabindex=\"6108\" name=\"sideRash[]\" " . getData ("sideRash", "checkbox", 2) . " type=\"checkbox\" value=\"2\"></td>
       <td align=\"center\"><input tabindex=\"6109\" name=\"sideRash[]\" " . getData ("sideRash", "checkbox", 4) . " type=\"checkbox\" value=\"4\"></td>
      </tr>
      <tr>
       <td>" . $sideHeadache[$lang][0] . "</td>
       <td align=\"center\"><input tabindex=\"6110\" name=\"sideHeadache[]\" " . getData ("sideHeadache", "checkbox", 1) . " type=\"checkbox\" value=\"1\"></td>
       <td align=\"center\"><input tabindex=\"6111\" name=\"sideHeadache[]\" " . getData ("sideHeadache", "checkbox", 2) . " type=\"checkbox\" value=\"2\"></td>
       <td align=\"center\"><input tabindex=\"6112\" name=\"sideHeadache[]\" " . getData ("sideHeadache", "checkbox", 4) . " type=\"checkbox\" value=\"4\"></td>
      </tr>
      <tr>
       <td>" . $sideAbPain[$lang][0] . "</td>
       <td align=\"center\"><input tabindex=\"6113\" name=\"sideAbPain[]\" " . getData ("sideAbPain", "checkbox", 1) . " type=\"checkbox\" value=\"1\"></td>
       <td align=\"center\"><input tabindex=\"6114\" name=\"sideAbPain[]\" " . getData ("sideAbPain", "checkbox", 2) . " type=\"checkbox\" value=\"2\"></td>
       <td align=\"center\"><input tabindex=\"6115\" name=\"sideAbPain[]\" " . getData ("sideAbPain", "checkbox", 4) . " type=\"checkbox\" value=\"4\"></td>
      </tr>
      <tr>
       <td>" . $sideWeak[$lang][0] . "</td>
       <td align=\"center\"><input tabindex=\"6116\" name=\"sideWeak[]\" " . getData ("sideWeak", "checkbox", 1) . " type=\"checkbox\" value=\"1\"></td>
       <td align=\"center\"><input tabindex=\"6117\" name=\"sideWeak[]\" " . getData ("sideWeak", "checkbox", 2) . " type=\"checkbox\" value=\"2\"></td>
       <td align=\"center\"><input tabindex=\"6118\" name=\"sideWeak[]\" " . getData ("sideWeak", "checkbox", 4) . " type=\"checkbox\" value=\"4\"></td>
      </tr>
      <tr>
       <td>" . $sideNumb[$lang][0] . "</td>
       <td align=\"center\"><input tabindex=\"6119\" name=\"sideNumb[]\" " . getData ("sideNumb", "checkbox", 1) . " type=\"checkbox\" value=\"1\"></td>
       <td align=\"center\"><input tabindex=\"6120\" name=\"sideNumb[]\" " . getData ("sideNumb", "checkbox", 2) . " type=\"checkbox\" value=\"2\"></td>
       <td align=\"center\"><input tabindex=\"6121\" name=\"sideNumb[]\" " . getData ("sideNumb", "checkbox", 4) . " type=\"checkbox\" value=\"4\"></td>
      </tr>
      <tr>
       <td class=\"top_pad\" colspan=\"4\"><i>" . $adherenceCounseling_subhead4[$lang][1] . "</i></td>
      </tr>
     </table>
    </td>
   </tr>
  </table>
</div>

<!-- ******************************************************************** -->
<!-- ***************** Information on Pick-Up Person ******************** -->
<!-- ******************* (tab indices 7001 - 9000) ********************** -->
<!-- ******************************************************************** -->
<div id=\"pane4\">
  <table class=\"header\">
   <tr>
    <td colspan=\"2\" class=\"under_header\" width=\"100%\">
    </td>
   </tr>
   <tr>
    <td class=\"s_header\" colspan=\"2\" width=\"100%\">" . $pickupPersonInfo[$lang][1] . "</td>
   </tr>
   <tr>
    <td width=\"50%\">" . $pickupPersonName[$lang][1] . " <input tabindex=\"7001\" name=\"pickupPersonName\" " . getData ("pickupPersonName", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
    <td width=\"50%\">" . $pickupPersonRel[$lang][1] . " <input tabindex=\"7002\" name=\"pickupPersonRel\" " . getData ("pickupPersonRel", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
   </tr>
  </table>
";
$tabIndex = 8000;

$formName = "rx";

$nextVisitDateLabel = ($formName == "rx" && $version == 0) ? $nextDrugVisitDate[$lang][0] : $nextVisitDate[$lang][0];
if ($_GET['title'] > 14)
	$nxtLabel = $pedNextVisit[$lang][10];
else
	$nxtLabel = ($formName == "rx") ? $nextDrugVisitDate[$lang][0] : $nextVisitDate[$lang][0];

echo "
<!-- ************************************************************* -->
<!-- ********************** Next Visit Date ******************** -->
<!--  (tab indices " . ($tabIndex + 1) . " - " . ($tabIndex + 1000) . ")  -->
<!-- ************************************************************* -->
  <table class=\"header\" border=\"0\" width=\"100%\">
     <tr>
    <td>&nbsp;</td>
   </tr>
   <tr>
    <td ><table><tr valign=\"bottom\"><td width=\"40%\" id=\"nxtVisitD2Title\">" . $nxtLabel . "&nbsp;&nbsp;</td><td width=\"20%\">
      <input tabindex=\"" . ($tabIndex + 2) . "\" id=\"nxtVisitD2\" name=\"nxtVisitD2\" value=\"" . getData ("nxtVisitDd", "textarea") . "/". getData ("nxtVisitMm", "textarea") ."/". getData ("nxtVisitYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
      <input id = \"nxtVisitDd\" name = \"nxtVisitDd\" type=\"hidden\">
      <input tabindex=\"" . ($tabIndex + 3) . "\" id = \"nxtVisitMm\" name = \"nxtVisitMm\" type=\"hidden\">
      <input tabindex=\"" . ($tabIndex + 4) . "\" id = \"nxtVisitYy\" name = \"nxtVisitYy\" type=\"hidden\">" .
    " </td><td><i>" . $firstTestYy[$lang][2] . "</i></td></tr></table>
    </td>
   </tr>
  </table>
";

echo"
</div>";
echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"prescription/0.js\"></script>";
?>