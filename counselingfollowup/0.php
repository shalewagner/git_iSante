<?php
/*include ("include/standardHeaderExt.php");

echo "<title>" . ${$typeArray[$type] . 'FormTitle'}[$lang][1] . "</title>";

echo"
 </head>
 <body>
<form name=\"mainForm\" target=\"mainWindow\" action=\"patienttabs.php\" method=\"post\">";
include ("include/patientIdClinicVisitDate.php");
*/

//echo"
// <input id=\"errorSave\" name =\"errorSave\" type=\"hidden\" value=\"\"/>
//
//";

$tabIndex = 1000;
//$type = 4;
echo"
<div id=\"tab-panes\">
<div id=\"pane1\">
<!-- ******************************************************************** -->
<!-- ************************* Support System *************************** -->
<!-- ******************** (tab indices 2001 - 3000) ********************* -->
<!-- ******************************************************************** -->

  <table class=\"header\">
   <tr>
    <td class=\"under_header\">
    </td>
   <tr>
    <td class=\"s_header\" colspan=\"3\" width=\"100%\">" . $supportSystem_header[$lang][1] . "</td>
   </tr>
   <tr>
    <td valign=\"top\" width=\"45%\">
     <table class=\"b_header_nb\">
      <tr>
       <td>" . $supportSystemAccomp[$lang][0] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"2001\" name=\"supportAccomp[]\" " . getData ("supportAccomp", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $supportSystemAccomp[$lang][1] . " <input tabindex=\"2002\" name=\"supportAccomp[]\" " . getData ("supportAccomp", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $supportSystemAccomp[$lang][2] . " <input tabindex=\"2003\" name=\"supportAccomp[]\" " . getData ("supportAccomp", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $supportSystemAccomp[$lang][3] . "</td>
      </tr>
      <tr>
       <td>" . $supportSystemAccompVisit[$lang][0] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"2004\" name=\"supportAccompVisit[]\" " . getData ("supportAccompVisit", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $supportSystemAccompVisit[$lang][1] . " <input tabindex=\"2005\" name=\"supportAccompVisit[]\" " . getData ("supportAccompVisit", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $supportSystemAccompVisit[$lang][2] . " <input tabindex=\"2006\" name=\"supportAccompVisit[]\" " . getData ("supportAccompVisit", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $supportSystemAccompVisit[$lang][3] . "</td>
      </tr>
      <tr>
       <td>" . $supportAccompTrained[$lang][0] . "</td>
      </tr>
      <tr>";

if ($lang == "en") echo "
       <td><table><tr><td><span><input tabindex=\"2007\" name=\"supportAccompTrained[]\" " . getData ("supportAccompTrained", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $supportAccompTrained[$lang][2] . " <input tabindex=\"2008\" name=\"supportAccompTrained[]\" " . getData ("supportAccompTrained", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $supportAccompTrained[$lang][1] . "</span> &nbsp;</td><td id=\"supportAccompTrainedTitle\"> <span>" . $supportAccompTrainedDate[$lang][0] . " </span></td><td><input tabindex=\"2009\" id=\"supportAccompTrainedMm\" name=\"supportAccompTrainedMm\" " . getData ("supportAccompTrainedMm", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"2010\" id=\"supportAccompTrainedYy\" name=\"supportAccompTrainedYy\" " . getData ("supportAccompTrainedYy", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"> </td><td><span><i>" . $supportAccompTrainedDate[$lang][2] . "</i></span></td></tr></table></td>";
else echo "
       <td><table><tr><td><span><input tabindex=\"2007\" name=\"supportAccompTrained[]\" " . getData ("supportAccompTrained", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $supportAccompTrained[$lang][1] . "</span> &nbsp;</td><td id=\"supportAccompTrainedTitle\"> <span>" . $supportAccompTrainedDate[$lang][0] . " </td><td><input tabindex=\"2008\" id=\"supportAccompTrainedMm\" name=\"supportAccompTrainedMm\" " . getData ("supportAccompTrainedMm", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"2009\" id=\"supportAccompTrainedYy\"name=\"supportAccompTrainedYy\" " . getData ("supportAccompTrainedYy", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"> </td><td><i>" . $supportAccompTrainedDate[$lang][2] . "</i></span> &nbsp; <span><input tabindex=\"2010\" name=\"supportAccompTrained[]\" " . getData ("supportAccompTrained", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $supportAccompTrained[$lang][2] . "</span></td></tr></table></td>";

echo "
      </tr>
     </table>
    </td>
    <td valign=\"top\" width=\"5%\">&nbsp;</td>
    <td valign=\"top\" class=\"left_pad\" width=\"50%\">
     <table class=\"b_header_nb\">
      <tr>
       <td colspan=\"2\">" . $hasBuddyChanged[$lang][0] . "</td>
      </tr>
      <tr>
       <td><span><input tabindex=\"2101\" name=\"hasBuddyChanged[]\" " . getData ("hasBuddyChanged", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $hasBuddyChanged[$lang][1] . "</span></td>
       <td rowspan=\"2\"><textarea tabindex=\"2102\" name=\"hasBuddyChangedText\" cols=\"30\" rows=\"4\">" . getData ("hasBuddyChangedText", "textarea") . "</textarea></td>
      </tr>
      <tr>
       <td valign=\"top\"><i>" . $hasBuddyChanged[$lang][2] . "</i></td>
      </tr>
      <tr>
       <td colspan=\"2\"><span><input tabindex=\"2103\" name=\"hasBuddyChanged[]\" " . getData ("hasBuddyChanged", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $hasBuddyChanged[$lang][3] . "</span></td>
      </tr>
     </table>
    </td>
   </tr>
  </table>

<!-- ******************************************************************** -->
<!-- *********************** New Treatment Buddy ************************ -->
<!-- ******************** (tab indices 3001 - 4000) ********************* -->
<!-- ******************************************************************** -->

  <table class=\"header\">
   <tr>
    <td class=\"under_header\">
    </td>
   <tr>
    <td class=\"s_header\" colspan=\"3\" width=\"100%\">" . $newBuddy_header[$lang][1] . "</td>
   </tr>
   <tr>
    <td valign=\"top\" width=\"45%\">
     <table class=\"b_header_nb\">
      <tr>
       <td>" . $supportAccompName[$lang][1] . "</td>
       <td> <input tabindex=\"3001\" name=\"supportAccompName\" " . getData ("supportAccompName", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td>" . $supportAccompAddr[$lang][1] . "</td>
       <td><input tabindex=\"3002\" name=\"supportAccompAddr\" " . getData ("supportAccompAddr", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td>" . $supportAccompTel[$lang][1] . "</td>
       <td><input tabindex=\"3003\" name=\"supportAccompTel\" " . getData ("supportAccompTel", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
      </tr>
     </table>

     <table class=\"b_header_nb\">
      <tr>
       <td>&nbsp;</td>
      </tr>
      <tr>
       <td>" . $supportAccompContactMethod2[$lang][0] . "</td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3101\" name=\"supportAccompContactMethod[]\" " . getData ("supportAccompContactMethod", "checkbox", 1) . " type=\"checkbox\" value=\"1\"> " . $supportAccompContactMethod2[$lang][1] . " <input tabindex=\"3102\" name=\"supportAccompContactMethod[]\" " . getData ("supportAccompContactMethod", "checkbox", 2) . " type=\"checkbox\" value=\"2\"> " . $supportAccompContactMethod2[$lang][2] . "</span> <input tabindex=\"3104\" name=\"supportAccompContactMethodOth\" " . getData ("supportAccompContactMethodOth", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
      </tr>
     </table>

     <table>
      <tr>
       <td>&nbsp;</td>
      </tr>
      <tr>
       <td>" . $relationshipTo[$lang][0] . "</td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3201\" name=\"relationshipTo[]\" " . getData ("relationshipTo", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $relationshipTo[$lang][1] . " <input tabindex=\"3202\" name=\"relationshipTo[]\" " . getData ("relationshipTo", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $relationshipTo[$lang][2] . " <input tabindex=\"3203\" name=\"relationshipTo[]\" " . getData ("relationshipTo", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $relationshipTo[$lang][3] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3204\" name=\"relationshipTo[]\" " . getData ("relationshipTo", "checkbox", 8) . " type=\"radio\" value=\"8\"> " . $relationshipTo[$lang][4] . "</span> <input tabindex=\"3205\" name=\"relationshipToText\" " . getData ("relationshipToText", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3206\" name=\"relationshipTo[]\" " . getData ("relationshipTo", "checkbox", 16) . " type=\"radio\" value=\"16\"> " . $relationshipTo[$lang][5] . "</span> <input tabindex=\"3207\" name=\"relationshipToTextOther\" " . getData ("relationshipToTextOther", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
      </tr>
     </table>

     <table>
      <tr>
       <td>&nbsp;</td>
      </tr>
      <tr>
       <td>" . $educationLevel[$lang][0] . "</td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3301\" name=\"educationLevel[]\" " . getData ("educationLevel", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $educationLevel[$lang][1] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3302\" name=\"educationLevel[]\" " . getData ("educationLevel", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $educationLevel[$lang][2] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3303\" name=\"educationLevel[]\" " . getData ("educationLevel", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $educationLevel[$lang][3] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3304\" name=\"educationLevel[]\" " . getData ("educationLevel", "checkbox", 8) . " type=\"radio\" value=\"8\"> " . $educationLevel[$lang][4] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3305\" name=\"educationLevel[]\" " . getData ("educationLevel", "checkbox", 16) . " type=\"radio\" value=\"16\"> " . $educationLevel[$lang][5] . "</span> <input tabindex=\"3306\" name=\"educationLevelText\" " . getData ("educationLevelText", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
      </tr>
     </table>

     <table>
      <tr>
       <td>&nbsp;</td>
      </tr>
      <tr>
       <td>" . $placeOfResidence[$lang][0] . "</td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3401\" name=\"placeOfResidence[]\" " . getData ("placeOfResidence", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $placeOfResidence[$lang][1] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3402\" name=\"placeOfResidence[]\" " . getData ("placeOfResidence", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $placeOfResidence[$lang][2] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3403\" name=\"placeOfResidence[]\" " . getData ("placeOfResidence", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $placeOfResidence[$lang][3] . "</span></td>
      </tr>
     </table>

     <table>
      <tr>
       <td>&nbsp;</td>
      </tr>
      <tr>
       <td>" . $meansOfTransport2[$lang][0] . "</td>
      </tr>
      <tr>";

if ($lang == "en") echo "
       <td><span><input tabindex=\"3501\" name=\"meansOfTransport[]\" " . getData ("meansOfTransport", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $meansOfTransport[$lang][1] . "</span> <input tabindex=\"3502\" name=\"meansOfTransportText\" " . getData ("meansOfTransportText", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3503\" name=\"meansOfTransport[]\" " . getData ("meansOfTransport", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $meansOfTransport[$lang][2] . "</span></td>";

else echo "
       <td><span><input tabindex=\"3501\" name=\"meansOfTransport[]\" " . getData ("meansOfTransport", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $meansOfTransport2[$lang][2] . " <input tabindex=\"3502\" name=\"meansOfTransport[]\" " . getData ("meansOfTransport", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $meansOfTransport2[$lang][1] . "</span> <input tabindex=\"3503\" name=\"meansOfTransportText\" " . getData ("meansOfTransportText", "text") . " type=\"text\" size=\"30\" maxlength=\"255\"></td>";

echo "
      </tr>
     </table>

     <table>
      <tr>
       <td>&nbsp;</td>
      </tr>
      <tr>
       <td>" . $availabilityContact2[$lang][0] . "</td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3601\" name=\"availabilityContact[]\" " . getData ("availabilityContact", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $availabilityContact2[$lang][1] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3602\" name=\"availabilityContact[]\" " . getData ("availabilityContact", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $availabilityContact2[$lang][2] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3603\" name=\"availabilityContact[]\" " . getData ("availabilityContact", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $availabilityContact2[$lang][3] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3604\" name=\"availabilityContact[]\" " . getData ("availabilityContact", "checkbox", 8) . " type=\"radio\" value=\"8\"> " . $availabilityContact2[$lang][4] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3605\" name=\"availabilityContact[]\" " . getData ("availabilityContact", "checkbox", 16) . " type=\"radio\" value=\"16\"> " . $availabilityContact2[$lang][5] . "</span></td>
      </tr>
     </table>
    </td>
    <td valign=\"top\" width=\"5%\">&nbsp;</td>
    <td valign=\"top\" class=\"left_pad\" width=\"50%\">
     <table class=\"b_header_nb\">
      <tr>
       <td>" . $frequency[$lang][0] . "</td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3701\" name=\"frequency[]\" " . getData ("frequency", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $frequency[$lang][1] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3702\" name=\"frequency[]\" " . getData ("frequency", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $frequency[$lang][2] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3703\" name=\"frequency[]\" " . getData ("frequency", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $frequency[$lang][3] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3704\" name=\"frequency[]\" " . getData ("frequency", "checkbox", 8) . " type=\"radio\" value=\"8\"> " . $frequency[$lang][4] . "</span></td>
      </tr>
     </table>

     <table>
      <tr>
       <td>&nbsp;</td>
      </tr>
      <tr>
       <td>" . $availAccompany[$lang][0] . "</td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3801\" name=\"availAccompany[]\" " . getData ("availAccompany", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $availAccompany[$lang][1] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3802\" name=\"availAccompany[]\" " . getData ("availAccompany", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $availAccompany[$lang][2] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3803\" name=\"availAccompany[]\" " . getData ("availAccompany", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $availAccompany[$lang][3] . "</span></td>
      </tr>
     </table>

     <table>
      <tr>
       <td>&nbsp;</td>
      </tr>
      <tr>
       <td>" . $availPickUp[$lang][0] . "</td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3804\" name=\"availPickUp[]\" " . getData ("availPickUp", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $availPickUp[$lang][1] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3805\" name=\"availPickUp[]\" " . getData ("availPickUp", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $availPickUp[$lang][2] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3806\" name=\"availPickUp[]\" " . getData ("availPickUp", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $availPickUp[$lang][3] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3807\" name=\"availPickUp[]\" " . getData ("availPickUp", "checkbox", 8) . " type=\"radio\" value=\"8\"> " . $availPickUp[$lang][4] . "</span></td>
      </tr>
     </table>

     <table>
      <tr>
       <td>&nbsp;</td>
      </tr>
      <tr>
       <td>" . $availTraining2[$lang][0] . "</td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3808\" name=\"availTraining[]\" " . getData ("availTraining", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $availTraining2[$lang][1] . " <input tabindex=\"3809\" name=\"availTraining[]\" " . getData ("availTraining", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $availTraining2[$lang][2] . "</span></td>
      </tr>
      <tr>
       <td>" . $availTraining2[$lang][3] . " <input tabindex=\"3810\" name=\"availTrainingText\" " . getData ("availTrainingText", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td>" . $availSupportGroup2[$lang][0] . "</td>
      </tr>
      <tr>
       <td><span><input tabindex=\"3811\" name=\"availSupportGroup[]\" " . getData ("availSupportGroup", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $availSupportGroup2[$lang][1] . " <input tabindex=\"3812\" name=\"availSupportGroup[]\" " . getData ("availSupportGroup", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $availSupportGroup2[$lang][2] . "</span></td>
      </tr>
      <tr>
       <td>" . $availSupportGroup2[$lang][3] . " <input tabindex=\"3813\" name=\"availSupportGroupText\" " . getData ("availSupportGroupText", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
      </tr>
     </table>

     <table>
      <tr>
       <td colspan=\"2\">&nbsp;</td>
      </tr>
      <tr>
       <td colspan=\"2\">" . $supportAccompBackup2[$lang][0] . "</td>
      </tr>
      <tr>
       <td>" . $supportAccompBackup2[$lang][1] . "</td>
       <td><input tabindex=\"3901\" name=\"backupAccompName\" " . getData ("backupAccompName", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td>" . $supportAccompBackup2[$lang][2] . "</td>
       <td><input tabindex=\"3902\" name=\"backupAccompRel\" " . getData ("backupAccompRel", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td>" . $supportAccompBackup2[$lang][3] . "</td>
       <td><input tabindex=\"3903\" name=\"backupAccompContact\" " . getData ("backupAccompContact", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
      </tr>
     </table>
    </td>
   </tr>
  </table>

<!-- ******************************************************************** -->
<!-- ******************** Follow-Up HIV/AIDS Care *********************** -->
<!-- ******************* (tab indices 4001 - 5000) ********************** -->
<!-- ******************************************************************** -->

  <table class=\"header\">
   <tr>
    <td class=\"under_header\">
    </td>
   <tr>
    <td class=\"s_header\">" . $discEnrollment_header1[$lang][1] . "</td>
   </tr>
   <tr>
    <td>" . $receiveReferrals[$lang][0] . "</td>
   </tr>
   <tr>
    <td><span><input tabindex=\"4001\" name=\"receiveReferrals[]\" " . getData ("receiveReferrals", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $receiveReferrals[$lang][1] . " <input tabindex=\"4002\" name=\"receiveReferrals[]\" " . getData ("receiveReferrals", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $receiveReferrals[$lang][2] . "</span> <input tabindex=\"4003\" name=\"receiveReferralsText\" " . getData ("receiveReferralsText", "text") . " type=\"text\" size=\"80\" maxlength=\"255\"></td>
   </tr>
   <tr>
    <td class=\"top_pad\">" . $missAppointment[$lang][0] . "</td>
   </tr>
   <tr>
    <td><span><input tabindex=\"4004\" name=\"missAppointment[]\" " . getData ("missAppointment", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $missAppointment[$lang][1] . "</span> &nbsp; <table><tr><td id=\"missDateDtTitle\">" . $missDateDd[$lang][0] . "</td><td> <input tabindex=\"4005\" id=\"missDateDt\"  name=\"missDateDt\" value=\"" . getData ("missDateDd", "textarea") . "/". getData ("missDateMm", "textarea") ."/". getData ("missDateYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\"><input id=\"missDateDd\" name=\"missDateDd\" " . getData ("missDateDd", "text") . " type=\"hidden\"><input tabindex=\"4006\" id=\"missDateMm\" name=\"missDateMm\" " . getData ("missDateMm", "text") . " type=\"hidden\"><input tabindex=\"4007\" id=\"missDateYy\" name=\"missDateYy\" " . getData ("missDateYy", "text") . " type=\"hidden\"></td><td> <i>" . $missDateYy[$lang][2] . "</i></td></tr></table></td>
   </tr>
   <tr>
    <td><span><input tabindex=\"4008\" name=\"missAppointment[]\" " . getData ("missAppointment", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $missAppointment[$lang][2] . "</span></td>
   </tr>
   <tr>
    <td class=\"top_pad\">" . $missOtherAppointment[$lang][0] . "</td>
   </tr>
   <tr>
    <td><span><input tabindex=\"4009\" name=\"missOtherAppointment[]\" " . getData ("missOtherAppointment", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $missOtherAppointment[$lang][1] . "</span> &nbsp; <table><tr><td id=\"missOtherDateDtTitle\">" . $missOtherDateDd[$lang][0] . " </td><td> <input tabindex=\"4010\" id=\"missOtherDateDt\"  name=\"missOtherDateDt\" value=\"" . getData ("missOtherDateDd", "textarea") . "/". getData ("missOtherDateMm", "textarea") ."/". getData ("missOtherDateYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
    <input id=\"missOtherDateDd\" name=\"missOtherDateDd\" " . getData ("missOtherDateDd", "text") . " type=\"hidden\">
    <input tabindex=\"4011\" id=\"missOtherDateMm\" name=\"missOtherDateMm\" " . getData ("missOtherDateMm", "text") . " type=\"hidden\">
    <input tabindex=\"4012\" id=\"missOtherDateYy\" name=\"missOtherDateYy\" " . getData ("missOtherDateYy", "text") . " type=\"hidden\"></td>
    <td><span><i>" . $missOtherDateYy[$lang][2] . "</i></span></td></tr></table></td>
   </tr>
   <tr>
    <td><span><input tabindex=\"4013\" name=\"missOtherAppointment[]\" " . getData ("missOtherAppointment", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $missOtherAppointment[$lang][2] . "</span></td>
   </tr>
   <tr>
    <td class=\"top_pad\"><i>" . $missExplain[$lang][1] . "</i></td>
   </tr>
   <tr>
    <td class=\"top_pad\">" . $alreadyEnrolled[$lang][0] . " <span><input tabindex=\"4014\" name=\"alreadyEnrolled[]\" " . getData ("alreadyEnrolled", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $alreadyEnrolled[$lang][1] . " <input tabindex=\"4015\" name=\"alreadyEnrolled[]\" " . getData ("alreadyEnrolled", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $alreadyEnrolled[$lang][2] . "</span></td>
   </tr>
   <tr>
    <td class=\"top_pad\">" . $recommendCommittee[$lang][0] . " <span><input tabindex=\"4016\" name=\"recommendCommittee[]\" " . getData ("recommendCommittee", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $recommendCommittee[$lang][1] . " <input tabindex=\"4017\" name=\"recommendCommittee[]\" " . getData ("recommendCommittee", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $recommendCommittee[$lang][2] . "</span></td>
   </tr>
  </table>
";

$tabIndex = 5000;
include ("include/violenceAssessment.php");

$tabIndex = 6000;
include ("include/needsAssessment.php");

echo "
<!-- ******************************************************************** -->
<!-- ************************* Clinic Transfer ************************** -->
<!-- ******************** (tab indices 7001 - 8000) ********************* -->
<!-- ******************************************************************** -->

  <table class=\"header\">
   <tr>
    <td class=\"under_header\">
    </td>
   <tr>
    <td class=\"s_header\">" . $transferClinics[$lang][0] . "</td>
   </tr>
   <tr>
    <td>" . $transferClinics[$lang][1] . " <span><input tabindex=\"7001\" name=\"transferClinics[]\" " . getData ("transferClinics", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $transferClinics[$lang][2] . " <input tabindex=\"7002\" name=\"transferClinics[]\" " . getData ("transferClinics", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $transferClinics[$lang][3] . "</span></td>
   </tr>
   <tr>
    <td><table><tr><td id=\"transferDateD2Title\">" . $transferDateDd[$lang][0] . " </td>
    				<td><input tabindex=\"7003\" id=\"transferDateD2\" name=\"transferDateDt\" value=\"" . getData ("transferDateDd", "textarea") . "/". getData ("transferDateMm", "textarea") ."/". getData ("transferDateYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\"></td>
    				<td><input id=\"transferDateDd\" name=\"transferDateDd\" " . getData ("transferDateDd", "text") . " type=\"hidden\">
    					<input tabindex=\"7004\" id=\"transferDateMm\" name=\"transferDateMm\" " . getData ("transferDateMm", "text") . " type=\"hidden\">
    					<input tabindex=\"7005\" id=\"transferDateYy\" name=\"transferDateYy\" " . getData ("transferDateYy", "text") . " type=\"hidden\"></td>
    				<td><i>" . $transferDateYy[$lang][2] . "</i>
    				</td></tr></table></td>
   </tr>
   <tr>
    <td>" . $clinicName[$lang][1] . " <input tabindex=\"7006\" name=\"clinicName\" " . getData ("clinicName", "text") . " type=\"text\" size=\"80\" maxlength=\"255\"></td>
   </tr>
   <tr>
    <td>" . $transferPrepared[$lang][0] . " <span><input tabindex=\"7007\" name=\"transferPrepared[]\" " . getData ("transferPrepared", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $transferPrepared[$lang][1] . " <input tabindex=\"7008\" name=\"transferPrepared[]\" " . getData ("transferPrepared", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $transferPrepared[$lang][2] . "</span></td>
   </tr>
  </table>
";

$tabIndex = 8000;
include ("include/commentsActionPlan.php");
?>
