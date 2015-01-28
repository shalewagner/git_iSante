<?php
include("include/standardHeaderExt.php");
$type = 7;
echo"
<title>" . ${$typeArray[$type] . 'FormTitle'}[$lang][1] . "</title>
</head>
 <body>

  <form id=\"mainForm\" name=\"mainForm\" target=\"mainWindow\" action=\"patienttabs.php\" method=\"post\">
 <input id=\"errorSave\" name =\"errorSave\" type=\"hidden\" value=\"\"/>

";
$tabIndex = 0;
include ("include/patientIdClinicVisitDate.php");
echo "
<div id=\"tab-panes\">
<div id=\"pane1\">
</div>

<!-- ******************************************************************** -->
<!-- ************************ Reason for Visit ************************** -->
<!-- ******************** (tab indices 2001 - 3000) ********************* -->
<!-- ******************************************************************** -->

  <table class=\"header\">
   <tr>
    <td colspan=\"3\" class=\"under_header\">&nbsp;</td>
   </tr>
   <tr>
    <td colspan=\"3\" class=\"s_header\">" . $reasonVisit_header[$lang][1] . "</td>
   </tr>
   <tr>
    <td width=\"35%\"><span><input tabindex=\"2001\" name=\"reasonVisit[]\" " . getData ("reasonVisit", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $reasonVisit[$lang][0] . "</span></td>
    <td width=\"35%\"><span><input tabindex=\"2003\" name=\"reasonVisit[]\" " . getData ("reasonVisit", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $reasonVisit[$lang][2] . "</span></td>
    <td width=\"30%\"><span><input tabindex=\"2005\" name=\"reasonVisit[]\" " . getData ("reasonVisit", "checkbox", 16) . " type=\"radio\" value=\"16\"> " . $reasonVisit[$lang][4] . "</span></td>
   </tr>
   <tr>
    <td width=\"35%\"><span><input tabindex=\"2002\" name=\"reasonVisit[]\" " . getData ("reasonVisit", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $reasonVisit[$lang][1] . "</span></td>
    <td width=\"35%\"><span><input tabindex=\"2004\" name=\"reasonVisit[]\" " . getData ("reasonVisit", "checkbox", 8) . " type=\"radio\" value=\"8\"> " . $reasonVisit[$lang][3] . "</span></td>
    <td width=\"30%\"><input tabindex=\"2006\" name=\"reasonVisitOther\" " . getData ("reasonVisitOther", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
   </tr>
  </table>

<!-- ******************************************************************** -->
<!-- ************************* Follow-Up Care *************************** -->
<!-- ******************** (tab indices 3001 - 4000) ********************* -->
<!-- ******************************************************************** -->

  <table class=\"header\">
   <tr>
    <td colspan=\"3\" class=\"s_header\">" . $homeCareVisits_header[$lang][1] . "</td>
   </tr>
   <tr>
    <td valign=\"top\" rowspan=\"2\" width=\"35%\" id =\"contactDuringVisit1Title\">" . $contactDuringVisit[$lang][0] . "<input type=\"hidden\" name=\"contactDuringVisit\" /></td>
    <td width=\"35%\"><span><input tabindex=\"3001\" id=\"contactDuringVisit1\" name=\"contactDuringVisit1\" " . getData ("contactDuringVisit", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $contactDuringVisit[$lang][1] . "</span></td>
    <td width=\"30%\"><table><tr><td  id =\"contactDuringVisit3Title\"></td><td><span><input tabindex=\"3003\" id=\"contactDuringVisit3\"  name=\"contactDuringVisit3\" " . getData ("contactDuringVisit", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $contactDuringVisit[$lang][3] . "</span></td></tr></table></td>
   </tr>
   <tr>
    <td width=\"35%\"><span><input tabindex=\"3002\" id=\"contactDuringVisit2\" name=\"contactDuringVisit1\" " . getData ("contactDuringVisit", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $contactDuringVisit[$lang][2] . "</span></td>
    <td width=\"30%\"><span><input tabindex=\"3004\" id=\"contactDuringVisit4\" name=\"contactDuringVisit3\" " . getData ("contactDuringVisit", "checkbox", 8) . " type=\"radio\" value=\"8\"> " . $contactDuringVisit[$lang][4] . "</span></td>
   </tr>
   <tr>
    <td colspan=\"3\" width=\"100%\">" . $freqSupportBuddy[$lang][0] . "</td>
   </tr>
   <tr>
    <td colspan=\"3\" width=\"100%\"><span><input tabindex=\"3005\" name=\"freqSupportBuddy[]\" " . getData ("freqSupportBuddy", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $freqSupportBuddy[$lang][1] . " <input tabindex=\"3006\" name=\"freqSupportBuddy[]\" " . getData ("freqSupportBuddy", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $freqSupportBuddy[$lang][2] . " <input tabindex=\"3007\" name=\"freqSupportBuddy[]\" " . getData ("freqSupportBuddy", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $freqSupportBuddy[$lang][3] . " <input tabindex=\"3008\" name=\"freqSupportBuddy[]\" " . getData ("freqSupportBuddy", "checkbox", 8) . " type=\"radio\" value=\"8\"> " . $freqSupportBuddy[$lang][4] . " <input tabindex=\"3009\" name=\"freqSupportBuddy[]\" " . getData ("freqSupportBuddy", "checkbox", 16) . " type=\"radio\" value=\"16\"> " . $freqSupportBuddy[$lang][5] . " <input tabindex=\"3010\" name=\"freqSupportBuddy[]\" " . getData ("freqSupportBuddy", "checkbox", 32) . " type=\"radio\" value=\"32\"> " . $freqSupportBuddy[$lang][6] . "</span></td>
   </tr>
   <tr>
    <td colspan=\"3\"width=\"100%\">" . $missedAppointment[$lang][0] . "</td>
   </tr>
   <tr>
    <td colspan=\"3\" width=\"100%\"><span><input tabindex=\"3011\" name=\"missedAppointment[]\" " . getData ("missedAppointment", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $missedAppointment[$lang][2] . " <input tabindex=\"3012\" name=\"missedAppointment[]\" " . getData ("missedAppointment", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $missedAppointment[$lang][1] . "</span> &nbsp; <table><tr><td id=\"missedDateDtTitle\">" . $missedDateDd[$lang][0] . " </td><td><input tabindex=\"3013\" id=\"missedDateDt\" name=\"missedDateDt\" value=\"" . getData ("missedDateDd", "textarea") . "/". getData ("missedDateMm", "textarea") ."/". getData ("missedDateYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\"><input id=\"missedDateDd\" name=\"missedDateDd\" " . getData ("missedDateDd", "text") . " type=\"hidden\"><input tabindex=\"3014\" id=\"missedDateMm\" name=\"missedDateMm\" " . getData ("missedDateMm", "text") . " type=\"hidden\"><input tabindex=\"3015\" id=\"missedDateYy\" name=\"missedDateYy\" " . getData ("missedDateYy", "text") . " type=\"hidden\"></td><td> <i>" . $missedDateYy[$lang][2] . "</i></td></tr></table></td>
   </tr>
   <tr>
    <td colspan=\"3\" width=\"100%\">" . $reasonMissed[$lang][0] . "</td>
   </tr>
   <tr>
    <td width=\"35%\"><input tabindex=\"3016\" name=\"reasonMissed[]\" " . getData ("reasonMissed", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $reasonMissed[$lang][1] . "</td>
    <td width=\"35%\"><input tabindex=\"3021\" name=\"reasonMissed[]\" " . getData ("reasonMissed", "checkbox", 8) . " type=\"radio\" value=\"8\"> " . $reasonMissed[$lang][2] . "</td>
    <td width=\"30%\"><input tabindex=\"3024\" name=\"reasonMissed[]\" " . getData ("reasonMissed", "checkbox", 64) . " type=\"radio\" value=\"64\"> " . $reasonMissed[$lang][3] . "</td>
   </tr>
   <tr>
    <td valign=\"top\" width=\"35%\"><input tabindex=\"3017\" name=\"reasonMissed[]\" " . getData ("reasonMissed", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $reasonMissed[$lang][4] . "</td>
    <td valign=\"top\" width=\"35%\"><input tabindex=\"3022\" name=\"reasonMissed[]\" " . getData ("reasonMissed", "checkbox", 16) . " type=\"radio\" value=\"16\"> " . $reasonMissed[$lang][5] . "</td>
    <td valign=\"top\" rowspan=\"2\" width=\"30%\"><input tabindex=\"3025\" name=\"reasonMissed[]\" " . getData ("reasonMissed", "checkbox", 128) . " type=\"radio\" value=\"128\"> " . $reasonMissed[$lang][6] . "</td>
   </tr>
   <tr>
    <td width=\"35%\"><input tabindex=\"3018\" name=\"reasonMissed[]\" " . getData ("reasonMissed", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $reasonMissed[$lang][7] . "</td>
    <td width=\"35%\"><input tabindex=\"3023\" name=\"reasonMissed[]\" " . getData ("reasonMissed", "checkbox", 32) . " type=\"radio\" value=\"32\"> " . $reasonMissed[$lang][8] . "</td>
   </tr>
   <tr>
    <td colspan=\"3\" width=\"100%\"><input tabindex=\"3019\" name=\"reasonMissed[]\" " . getData ("reasonMissed", "checkbox", 256) . " type=\"radio\" value=\"256\"> " . $reasonMissed[$lang][9] . " <input tabindex=\"3020\" name=\"reasonMissedText\" " . getData ("reasonMissedText", "text") . " type=\"text\" size=\"80\" maxlength=\"255\"></td>
   </tr>
   <tr>
    <td colspan=\"3\" width=\"100%\"><i>" . $reasonMissed[$lang][10] . "</i></td>
   </tr>
  </table>

<!-- ******************************************************************** -->
<!-- *********************** Illness Description ************************ -->
<!-- ******************** (tab indices 4001 - 5000) ********************* -->
<!-- ******************************************************************** -->

  <table class=\"header\">
   <tr>
    <td colspan=\"3\" class=\"s_header\">" . $illnessDescription[$lang][0] . "</td>
   </tr>
   <tr>
    <td width=\"35%\"><input tabindex=\"4001\" name=\"illnessDescription[]\" " . getData ("illnessDescription", "checkbox", 1) . " type=\"checkbox\" value=\"1\"> " . $illnessDescription[$lang][1] . "</td>
    <td width=\"35%\"><input tabindex=\"4004\" name=\"illnessDescription[]\" " . getData ("illnessDescription", "checkbox", 8) . " type=\"checkbox\" value=\"8\"> " . $illnessDescription[$lang][4] . "</td>
    <td width=\"30%\"><input tabindex=\"4006\" name=\"illnessDescription[]\" " . getData ("illnessDescription", "checkbox", 32) . " type=\"checkbox\" value=\"32\"> " . $illnessDescription[$lang][6] . "</td>
   </tr>
   <tr>
    <td width=\"35%\"><input tabindex=\"4002\" name=\"illnessDescription[]\" " . getData ("illnessDescription", "checkbox", 2) . " type=\"checkbox\" value=\"2\"> " . $illnessDescription[$lang][2] . "</td>
    <td width=\"35%\"><input tabindex=\"4005\" name=\"illnessDescription[]\" " . getData ("illnessDescription", "checkbox", 16) . " type=\"checkbox\" value=\"16\"> " . $illnessDescription[$lang][5] . "</td>
    <td width=\"30%\"><input tabindex=\"4007\" name=\"illnessDescriptionOther\" " . getData ("illnessDescriptionOther", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
   </tr>
   <tr>
    <td colspan=\"3\" width=\"100%\"><input tabindex=\"4003\" name=\"illnessDescription[]\" " . getData ("illnessDescription", "checkbox", 4) . " type=\"checkbox\" value=\"4\"> " . $illnessDescription[$lang][3] . "</td>
   </tr>
  </table>
";

$tabIndex = 5000;
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
       <td><input tabindex=\"6001\" name=\"reasonNotAvail\" " . getData ("reasonNotAvail", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonNotAvail[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6002\" name=\"reasonForgot\" " . getData ("reasonForgot", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonForgot[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6003\" name=\"reasonSideEff\" " . getData ("reasonSideEff", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonSideEff[$lang][1] . " <i>" . $reasonSideEff[$lang][2] . "</i></td>
      </tr>
      <tr>
       <td><input tabindex=\"6004\" name=\"reasonPrison\" " . getData ("reasonPrison", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonPrison[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6005\" name=\"reasonTooSick\" " . getData ("reasonTooSick", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonTooSick[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6006\" name=\"reasonFinished\" " . getData ("reasonFinished", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonFinished[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6007\" name=\"reasonFeelWell\" " . getData ("reasonFeelWell", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonFeelWell[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6008\" name=\"reasonLost\" " . getData ("reasonLost", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonLost[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6009\" name=\"reasonDidNotWant\" " . getData ("reasonDidNotWant", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonDidNotWant[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6010\" name=\"reasonNotComf\" " . getData ("reasonNotComf", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonNotComf[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6011\" name=\"reasonNoSwallow\" " . getData ("reasonNoSwallow", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonNoSwallow[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6012\" name=\"reasonTravel\" " . getData ("reasonTravel", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonTravel[$lang][1] . "</td>
      </tr>";


echo "
     </table>
    </td>
    <td class=\"vert_line\" width=\"1%\">&nbsp;</td>
    <td class=\"left_pad\" valign=\"top\" width=\"45%\">
     <table>";

echo "
      <tr>
       <td colspan=\"4\"><input tabindex=\"6013\" name=\"reasonNoFood\" " . getData ("reasonNoFood", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonNoFood[$lang][1] . "</td>
      </tr>";

echo "
      <tr>
       <td colspan=\"4\"><input tabindex=\"6014\" name=\"reasonOther\" " . getData ("reasonOther", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $reasonOther[$lang][1] . " <input tabindex=\"6015\" name=\"reasonOtherText\" " . getData ("reasonOtherText", "text") . " type=\"text\" size=\"30\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td colspan=\"4\" class=\"under_header\">&nbsp;</td>
      </tr>
      <tr>
       <td><b>" . $adherenceCounseling_subhead2[$lang][1] . "</b></td>
       <td align=\"center\">" . $adherenceCounseling_subhead3[$lang][0] . "</td>
       <td align=\"center\">" . $adherenceCounseling_subhead3[$lang][1] . "</td>
       <td align=\"center\">" . $adherenceCounseling_subhead3[$lang][2] . "</td>
      </tr>
      <tr>
       <td>" . $sideNausea[$lang][0] . "</td>
       <td align=\"center\"><input tabindex=\"6101\" name=\"sideNausea[]\" " . getData ("sideNausea", "checkbox", 1) . " type=\"radio\" value=\"1\"></td>
       <td align=\"center\"><input tabindex=\"6102\" name=\"sideNausea[]\" " . getData ("sideNausea", "checkbox", 2) . " type=\"radio\" value=\"2\"></td>
       <td align=\"center\"><input tabindex=\"6103\" name=\"sideNausea[]\" " . getData ("sideNausea", "checkbox", 4) . " type=\"radio\" value=\"4\"></td>
      </tr>
      <tr>
       <td>" . $sideDiarrhea[$lang][0] . "</td>
       <td align=\"center\"><input tabindex=\"6104\" name=\"sideDiarrhea[]\" " . getData ("sideDiarrhea", "checkbox", 1) . " type=\"radio\" value=\"1\"></td>
       <td align=\"center\"><input tabindex=\"6105\" name=\"sideDiarrhea[]\" " . getData ("sideDiarrhea", "checkbox", 2) . " type=\"radio\" value=\"2\"></td>
       <td align=\"center\"><input tabindex=\"6106\" name=\"sideDiarrhea[]\" " . getData ("sideDiarrhea", "checkbox", 4) . " type=\"radio\" value=\"4\"></td>
      </tr>
      <tr>
       <td>" . $sideRash[$lang][0] . "</td>
       <td align=\"center\"><input tabindex=\"6107\" name=\"sideRash[]\" " . getData ("sideRash", "checkbox", 1) . " type=\"radio\" value=\"1\"></td>
       <td align=\"center\"><input tabindex=\"6108\" name=\"sideRash[]\" " . getData ("sideRash", "checkbox", 2) . " type=\"radio\" value=\"2\"></td>
       <td align=\"center\"><input tabindex=\"6109\" name=\"sideRash[]\" " . getData ("sideRash", "checkbox", 4) . " type=\"radio\" value=\"4\"></td>
      </tr>
      <tr>
       <td>" . $sideHeadache[$lang][0] . "</td>
       <td align=\"center\"><input tabindex=\"6110\" name=\"sideHeadache[]\" " . getData ("sideHeadache", "checkbox", 1) . " type=\"radio\" value=\"1\"></td>
       <td align=\"center\"><input tabindex=\"6111\" name=\"sideHeadache[]\" " . getData ("sideHeadache", "checkbox", 2) . " type=\"radio\" value=\"2\"></td>
       <td align=\"center\"><input tabindex=\"6112\" name=\"sideHeadache[]\" " . getData ("sideHeadache", "checkbox", 4) . " type=\"radio\" value=\"4\"></td>
      </tr>
      <tr>
       <td>" . $sideAbPain[$lang][0] . "</td>
       <td align=\"center\"><input tabindex=\"6113\" name=\"sideAbPain[]\" " . getData ("sideAbPain", "checkbox", 1) . " type=\"radio\" value=\"1\"></td>
       <td align=\"center\"><input tabindex=\"6114\" name=\"sideAbPain[]\" " . getData ("sideAbPain", "checkbox", 2) . " type=\"radio\" value=\"2\"></td>
       <td align=\"center\"><input tabindex=\"6115\" name=\"sideAbPain[]\" " . getData ("sideAbPain", "checkbox", 4) . " type=\"radio\" value=\"4\"></td>
      </tr>
      <tr>
       <td>" . $sideWeak[$lang][0] . "</td>
       <td align=\"center\"><input tabindex=\"6116\" name=\"sideWeak[]\" " . getData ("sideWeak", "checkbox", 1) . " type=\"radio\" value=\"1\"></td>
       <td align=\"center\"><input tabindex=\"6117\" name=\"sideWeak[]\" " . getData ("sideWeak", "checkbox", 2) . " type=\"radio\" value=\"2\"></td>
       <td align=\"center\"><input tabindex=\"6118\" name=\"sideWeak[]\" " . getData ("sideWeak", "checkbox", 4) . " type=\"radio\" value=\"4\"></td>
      </tr>
      <tr>
       <td>" . $sideNumb[$lang][0] . "</td>
       <td align=\"center\"><input tabindex=\"6119\" name=\"sideNumb[]\" " . getData ("sideNumb", "checkbox", 1) . " type=\"radio\" value=\"1\"></td>
       <td align=\"center\"><input tabindex=\"6120\" name=\"sideNumb[]\" " . getData ("sideNumb", "checkbox", 2) . " type=\"radio\" value=\"2\"></td>
       <td align=\"center\"><input tabindex=\"6121\" name=\"sideNumb[]\" " . getData ("sideNumb", "checkbox", 4) . " type=\"radio\" value=\"4\"></td>
      </tr>
      <tr>
       <td class=\"top_pad\" colspan=\"4\"><i>" . $adherenceCounseling_subhead4[$lang][1] . "</i></td>
      </tr>
     </table>
    </td>
   </tr>
  </table>

<!-- ******************************************************************** -->
<!-- ************************* Service Delivery ************************* -->
<!-- ******************** (tab indices 7001 - 8000) ********************* -->
<!-- ******************************************************************** -->

  <table class=\"header\">
   <tr>
    <td colspan=\"2\" class=\"s_header\">" . $serviceDelivery_header[$lang][1] . "</td>
   </tr>";

echo "
   <tr>
    <td width=\"50%\">" . $serviceDelivery[$lang][0] . "</td>
    <td width=\"50%\"><input tabindex=\"7004\" name=\"serviceDelivery[]\" " . getData ("serviceDelivery", "checkbox", 4) . " type=\"checkbox\" value=\"4\"> " . $serviceDelivery[$lang][3] . "</td>
   </tr>
   <tr>
    <td width=\"50%\"><input tabindex=\"7001\" name=\"serviceDelivery[]\" " . getData ("serviceDelivery", "checkbox", 1) . " type=\"checkbox\" value=\"1\"> " . $serviceDelivery[$lang][1] . "</td>
    <td width=\"50%\"><input tabindex=\"7005\" name=\"serviceDelivery[]\" " . getData ("serviceDelivery", "checkbox", 8) . " type=\"checkbox\" value=\"8\"> " . $serviceDelivery[$lang][4] . "</td>
   </tr>
   <tr>
    <td width=\"50%\"><input tabindex=\"7002\" name=\"serviceDelivery[]\" " . getData ("serviceDelivery", "checkbox", 16) . " type=\"checkbox\" value=\"16\"> " . $serviceDelivery[$lang][5] . "</td>
    <td width=\"35%\"><input tabindex=\"7006\" name=\"serviceDelivery[]\" " . getData ("serviceDelivery", "checkbox", 32) . " type=\"checkbox\" value=\"32\"> " . $serviceDelivery[$lang][6] . "</td>
   </tr>
   <tr>
    <td width=\"50%\"><input tabindex=\"7003\" name=\"serviceDelivery[]\" " . getData ("serviceDelivery", "checkbox", 2) . " type=\"checkbox\" value=\"2\"> " . $serviceDelivery[$lang][2] . "</td>
    <td width=\"50%\"><input tabindex=\"7007\" name=\"serviceDeliveryOther\" " . getData ("serviceDeliveryOther", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
   </tr>";

echo "
  </table>

<!-- ******************************************************************** -->
<!-- ************************ Follow-Up Plan **************************** -->
<!-- ******************* (tab indices 8001 - 9000) ********************** -->
<!-- ******************************************************************** -->

  <table class=\"header\">
   <tr>
    <td colspan=\"2\" class=\"s_header\" width=\"100%\">" . $homeCareVisits_subhead1[$lang][1] . "</td>
   </tr>";

 echo "
   <tr>
    <td id=\"nextClinicVisitDaysTitle\" width=\"50%\">" . $nextClinicVisitDays[$lang][1] . "</td>
    <td  width=\"50%\"><input tabindex=\"8001\" id=\"nextClinicVisitDays\" name=\"nextClinicVisitDays\" " . getData ("nextClinicVisitDays", "text") . " type=\"text\" size=\"3\" maxlength=\"8\"> " . $nextClinicVisitDays[$lang][2] . "</td>
   </tr>
   <tr>
    <td id=\"nextClinicVisitDtTitle\" width=\"50%\">" . $nextClinicVisitDd[$lang][0] . "</td>
    <td width=\"50%\"><table><tr><td><input tabindex=\"8002\" id=\"nextClinicVisitDt\" name=\"nextClinicVisitDt\" value=\"" . getData ("nextClinicVisitDd", "textarea") . "/". getData ("nextClinicVisitMm", "textarea") ."/". getData ("nextClinicVisitYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\"><input id=\"nextClinicVisitDd\" name=\"nextClinicVisitDd\" " . getData ("nextClinicVisitDd", "text") . " type=\"hidden\"><input tabindex=\"8003\" id=\"nextClinicVisitMm\" name=\"nextClinicVisitMm\" " . getData ("nextClinicVisitMm", "text") . " type=\"hidden\"><input tabindex=\"8004\" id=\"nextClinicVisitYy\" name=\"nextClinicVisitYy\" " . getData ("nextClinicVisitYy", "text") . " type=\"hidden\"></td><td> <i>" . $nextClinicVisitYy[$lang][2] . "</i></td></tr></table></td>
   </tr>
   <tr>
    <td id=\"nextHomeVisitDaysTitle\" width=\"50%\">" . $nextHomeVisitDays[$lang][1] . "</td>
    <td width=\"50%\"><input tabindex=\"8101\" id=\"nextHomeVisitDays\" name=\"nextHomeVisitDays\" " . getData ("nextHomeVisitDays", "text") . " type=\"text\" size=\"3\" maxlength=\"8\"> " . $nextHomeVisitDays[$lang][2] . "</td>
   </tr>
   <tr>
    <td id=\"nextHomeVisitDtTitle\"width=\"50%\">" . $nextHomeVisitDd[$lang][0] . "</td>
    <td width=\"50%\"><table><tr><td ></td><td><input tabindex=\"8002\" id=\"nextHomeVisitDt\" name=\"nextHomeVisitDt\" value=\"" . getData ("nextHomeVisitDd", "textarea") . "/". getData ("nextHomeVisitMm", "textarea") ."/". getData ("nextHomeVisitYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\"><input id=\"nextHomeVisitDd\" name=\"nextHomeVisitDd\" " . getData ("nextHomeVisitDd", "text") . " type=\"hidden\"><input tabindex=\"8103\" id=\"nextHomeVisitMm\" name=\"nextHomeVisitMm\" " . getData ("nextHomeVisitMm", "text") . " type=\"hidden\"><input tabindex=\"8104\" id=\"nextHomeVisitYy\" name=\"nextHomeVisitYy\" " . getData ("nextHomeVisitYy", "text") . " type=\"hidden\"> </td><td><i>" . $nextHomeVisitYy[$lang][2] . "</i></td></tr></table></td>
   </tr>";

echo "
  </table>

<!-- ******************************************************************** -->
<!-- ************************* Discontinuation ************************** -->
<!-- ******************** (tab indices 9001 - 10000) ******************** -->
<!-- ******************************************************************** -->

  <table class=\"header\">
   <tr>
    <td colspan=\"3\" class=\"s_header\" width=\"100%\">" . $homeVisitDisc_header[$lang][1] . "</td>
   </tr>";

echo "
   <tr>
    <td colspan=\"3\" width=\"100%\">" . $arvDiscontinuation[$lang][0] . "</td>
   </tr>
   <tr>
    <td id=\"arvDiscontinuationDtTitle\" width=\"16%\"><input tabindex=\"9001\" name=\"arvDiscontinuation[]\" " . getData ("arvDiscontinuation", "checkbox", 1) . " type=\"radio\" value=\"1\"/> " . $arvDiscontinuation[$lang][1] . "</td>
    <td align=\"left\" width=\"8%\"><table><tr><td><input tabindex=\"9003\" id=\"arvDiscontinuationDt\" name=\"arvDiscontinuationDt\" value=\"" . getData ("arvDiscontinuationDd", "textarea") . "/". getData ("arvDiscontinuationMm", "textarea") ."/". getData ("arvDiscontinuationYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\"><input  id=\"arvDiscontinuationDd\" name=\"arvDiscontinuationDd\" " . getData ("arvDiscontinuationDd", "text") . " type=\"hidden\"><input tabindex=\"9004\" id=\"arvDiscontinuationMm\" name=\"arvDiscontinuationMm\" " . getData ("arvDiscontinuationMm", "text") . " type=\"hidden\"><input tabindex=\"9005\" id=\"arvDiscontinuationYy\" name=\"arvDiscontinuationYy\" " . getData ("arvDiscontinuationYy", "text") . " type=\"hidden\"></td><td><i>" . $arvDiscontinuationYy[$lang][2] . "</i> &nbsp; <input tabindex=\"9005\" name=\"arvDiscontinuation[]\" " . getData ("arvDiscontinuation", "checkbox", 2) . " type=\"radio\" value=\"2\"><i> " . $arvDiscontinuation[$lang][2] . "</i></td></tr></table>
    </td>

   </tr>";

if ($lang == "en") echo "
   <tr>
    <td colspan=\"3\" width=\"100%\">" . $careDiscontinuation[$lang][0] . " <span><input tabindex=\"9006\" name=\"careDiscontinuation[]\" " . getData ("careDiscontinuation", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $careDiscontinuation[$lang][1] . " <input tabindex=\"9007\" name=\"careDiscontinuation[]\" " . getData ("careDiscontinuation", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $careDiscontinuation[$lang][2] . " <input tabindex=\"9008\" name=\"careDiscontinuation[]\" " . getData ("careDiscontinuation", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $careDiscontinuation[$lang][3] . "</span></td>
   </tr>
   <tr>
    <td colspan=\"3\" width=\"100%\"><i>" . $careDiscontinuation[$lang][4] . "</i></td>
   </tr>";

else echo "
   <tr>
    <td colspan=\"3\" width=\"100%\">" . $careDiscontinuation[$lang][0] . "</td>
   </tr>
   <tr>
    <td colspan=\"3\" width=\"100%\"><span><input tabindex=\"9006\" name=\"careDiscontinuation[]\" " . getData ("careDiscontinuation", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $careDiscontinuation[$lang][1] . "</span> &nbsp; <i>" . $careDiscontinuation[$lang][4] . "</i> <span><input tabindex=\"9007\" name=\"careDiscontinuation[]\" " . getData ("careDiscontinuation", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $careDiscontinuation[$lang][2] . " <input tabindex=\"9008\" name=\"careDiscontinuation[]\" " . getData ("careDiscontinuation", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $careDiscontinuation[$lang][3] . "</span></td>
   </tr>";

echo "
   <tr>
    <td valign=\"top\" rowspan=\"2\" width=\"20%\">" . $careDiscReason[$lang][0] . "</td>
    <td width=\"45%\"><table><tr><td><input tabindex=\"9009\" name=\"careDiscReason[]\" " . getData ("careDiscReason", "checkbox", 1) . " type=\"radio\" value=\"1\"></td><td  id=\"careDiscDeathDateDtTitle\"> " . $careDiscReason[$lang][1] . " </td><td><input tabindex=\"9010\" id=\"careDiscDeathDateDt\" name=\"careDiscDeathDateDt\" value=\"" . getData ("careDiscDeathDateDd", "textarea") . "/". getData ("careDiscDeathDateMm", "textarea") ."/". getData ("careDiscDeathDateYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\"><input id=\"careDiscDeathDateDd\" name=\"careDiscDeathDateDd\" " . getData ("careDiscDeathDateDd", "text") . " type=\"hidden\"><input tabindex=\"9011\" id=\"careDiscDeathDateMm\" name=\"careDiscDeathDateMm\" " . getData ("careDiscDeathDateMm", "text") . " type=\"hidden\"><input tabindex=\"9012\" id=\"careDiscDeathDateYy\"  name=\"careDiscDeathDateYy\" " . getData ("careDiscDeathDateYy", "text") . " type=\"hidden\"></td><td> <i>" . $careDiscDeathDateYy[$lang][2] . "</i></td></tr></table></td>
    <td width=\"35%\"><span><input tabindex=\"9015\" name=\"careDiscReason[]\" " . getData ("careDiscReason", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $careDiscReason[$lang][3] . "</span></td>
   </tr>
   <tr>
    <td width=\"45%\"><span><input tabindex=\"9013\" name=\"careDiscReason[]\" " . getData ("careDiscReason", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $careDiscReason[$lang][2] . "</span> <input tabindex=\"9014\" name=\"careDiscTransferText\" " . getData ("careDiscTransferText", "text") . " type=\"text\" size=\"20\" maxlength=\"255\"></td>
    <td width=\"35%\"><span><input tabindex=\"9016\" name=\"careDiscReason[]\" " . getData ("careDiscReason", "checkbox", 8) . " type=\"radio\" value=\"8\"> " . $careDiscReason[$lang][4] . "</span></td>
   </tr>
  </table>

<!-- ******************************************************************** -->
<!-- **************************** Remarks ******************************* -->
<!-- ****************** (tab indices 10001 - 11000) ********************* -->
<!-- ******************************************************************** -->

  <table class=\"header\">
   <tr>
    <td>
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\">" . $homeVisitRemarks[$lang][1] . "</td>
      </tr>
      <tr>
       <td><textarea tabindex=\"10001\" name=\"homeVisitRemarks\" cols=\"80\" rows=\"10\">" . getData ("homeVisitRemarks", "textarea") . "</textarea></td>
      </tr>
     </table>
    </td>
   </tr>
  </table>
  </div>
<div id=\"saveButtons\">";
include ("include/saveButtons.php");

echo "
</div>
</form>
 </body>
</html>
";
echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"homevisit/0.js\"></script>";
?>
