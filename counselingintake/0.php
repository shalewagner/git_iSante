<?php
/*include("include/standardHeaderExt.php");
$type = '3';
//  echo "<title>" . ${$typeArray[$type] . 'FormTitle'}[$lang][1] . "</title>";

//counsIntakeTabs.php does not exist yet!!!
  //if($tabsOn) include("include/tabs/counsIntakeTabs.php");

  echo "
   </head>
   <body>
  <form name=\"mainForm\" target=\"mainWindow\" action=\"patienttabs.php\" method=\"post\">";
      include ("include/patientIdClinicVisitDate.php"); */
echo"
<div class=\"formArea\">
";
  $tabIndex = 0;
echo"
<!-- ******************************************************************** -->
<!-- ********************** Household Composition *********************** -->
<!-- ******************** (tab indices 2001 - 3000) ********************* -->
<!-- ******************************************************************** -->

  <table class=\"header\">
   <tr>
    <td>
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"8\" width=\"100%\">" . $householdComp_header[$lang][1] . "</td>
      </tr>
      <tr>
       <td class=\"sm_header_lt\" width=\"25%\">" . $householdComp_householdName[$lang][1] . "</td>
       <td class=\"sm_header_lt\" width=\"10%\">" . $householdComp_householdAge[$lang][1] . "</td>
       <td class=\"sm_header_lt\" width=\"20%\">" . $householdComp_householdRel[$lang][1] . "</td>
       <td rowspan=\"" . ($max_householdComp + 1) . "\" width=\"5%\">&nbsp;</td>
       <td class=\"sm_header_lt\" width=\"20%\">" . $householdComp_hivStatus[$lang][0] . "</td>
       <td rowspan=\"" . ($max_householdComp + 1) . "\" class=\"vert_line\">&nbsp;</td>
       <td rowspan=\"" . ($max_householdComp + 1) . "\" width=\"5%\">&nbsp;</td>
       <td class=\"sm_header_lt\" width=\"15%\">" . $householdComp_disclosure[$lang][0] . "</td>
      </tr>" . houseCompCols ($max_householdComp, 2001) . "
     </table>
    </td>
   </tr>

<!-- ******************************************************************** -->
<!-- *************************** Home Visits **************************** -->
<!-- ******************** (tab indices 3001 - 4000) ********************* -->
<!-- ******************************************************************** -->

   <tr>
    <td>
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\">" . $homeFollowUp_header[$lang][1] . "</td>
      </tr>
      <tr>
       <td>" . $homeDirections[$lang][1] . "</td>
      </tr>
      <tr>
       <td><textarea tabindex=\"3001\" name=\"homeDirections\" cols=\"80\" rows=\"4\">" . getData ("homeDirections", "textarea") . "</textarea></td>
      </tr>
     </table>
    </td>
   </tr>
  </table>

<!-- ******************************************************************** -->
<!-- ************************* General Info ***************************** -->
<!-- ******************* (tab indices 4001 - 5000) ********************** -->
<!-- ******************************************************************** -->

  <table class=\"header\">
   <tr>
    <td class=\"s_header\" colspan=\"4\" width=\"100%\">" . $support_header[$lang][1] . "</td>
   </tr>
   <tr>
    <td valign=\"top\" width=\"45%\">
     <table class=\"b_header_nb\">
      <tr>
       <td colspan=\"2\">" . $supportAccomp[$lang][0] . "</td>
      </tr>
      <tr>
       <td colspan=\"2\"><span><input tabindex=\"4001\" name=\"supportAccomp[]\" " . getData ("supportAccomp", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $supportAccomp[$lang][1] . " <input tabindex=\"4002\" name=\"supportAccomp[]\" " . getData ("supportAccomp", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $supportAccomp[$lang][2] . " <input tabindex=\"4003\" name=\"supportAccomp[]\" " . getData ("supportAccomp", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $supportAccomp[$lang][3] . "</span></td>
      </tr>
      <tr>
       <td colspan=\"2\">" . $supportAccompVisit[$lang][0] . "</td>
      </tr>
      <tr>
       <td colspan=\"2\"><span><input tabindex=\"4004\" name=\"supportAccompVisit[]\" " . getData ("supportAccompVisit", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $supportAccompVisit[$lang][1] . " <input tabindex=\"4005\" name=\"supportAccompVisit[]\" " . getData ("supportAccompVisit", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $supportAccompVisit[$lang][2] . " <input tabindex=\"4006\" name=\"supportAccompVisit[]\" " . getData ("supportAccompVisit", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $supportAccompVisit[$lang][3] . "</span></td>
      </tr>
      <tr>
       <td colspan=\"2\">" . $supportAccompName[$lang][0] . "</td>
      </tr>
      <tr>
       <td>" . $supportAccompName[$lang][1] . "</td>
       <td><input tabindex=\"4007\" name=\"supportAccompName\" " . getData ("supportAccompName", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td>" . $supportAccompAddr[$lang][1] . "</td>
       <td><input tabindex=\"4008\" name=\"supportAccompAddr\" " . getData ("supportAccompAddr", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td>" . $supportAccompTel[$lang][1] . "</td>
       <td><input tabindex=\"4009\" name=\"supportAccompTel\" " . getData ("supportAccompTel", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
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
       <td><span><input tabindex=\"4101\" name=\"educationLevel[]\" " . getData ("educationLevel", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $educationLevel[$lang][1] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4102\" name=\"educationLevel[]\" " . getData ("educationLevel", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $educationLevel[$lang][2] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4103\" name=\"educationLevel[]\" " . getData ("educationLevel", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $educationLevel[$lang][3] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4104\" name=\"educationLevel[]\" " . getData ("educationLevel", "checkbox", 8) . " type=\"radio\" value=\"8\"> " . $educationLevel[$lang][4] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4105\" name=\"educationLevel[]\" " . getData ("educationLevel", "checkbox", 16) . " type=\"radio\" value=\"16\"> " . $educationLevel[$lang][5] . "</span> <input tabindex=\"4106\" name=\"educationLevelText\" " . getData ("educationLevelText", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
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
       <td><span><input tabindex=\"4201\" name=\"placeOfResidence[]\" " . getData ("placeOfResidence", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $placeOfResidence[$lang][1] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4202\" name=\"placeOfResidence[]\" " . getData ("placeOfResidence", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $placeOfResidence[$lang][2] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4203\" name=\"placeOfResidence[]\" " . getData ("placeOfResidence", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $placeOfResidence[$lang][3] . "</span></td>
      </tr>
     </table>

     <table>
      <tr>
       <td>&nbsp;</td>
      </tr>
      <tr>
       <td>" . $meansOfTransport[$lang][0] . "</td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4301\" name=\"meansOfTransport[]\" " . getData ("meansOfTransport", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $meansOfTransport[$lang][1] . "</span> <input tabindex=\"4302\" name=\"meansOfTransportText\" " . getData ("meansOfTransportText", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4303\" name=\"meansOfTransport[]\" " . getData ("meansOfTransport", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $meansOfTransport[$lang][2] . "</span></td>
      </tr>
     </table>

     <table>
      <tr>
       <td>&nbsp;</td>
      </tr>
      <tr>
       <td>" . $availabilityContact[$lang][0] . "</td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4401\" name=\"availabilityContact[]\" " . getData ("availabilityContact", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $availabilityContact[$lang][1] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4402\" name=\"availabilityContact[]\" " . getData ("availabilityContact", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $availabilityContact[$lang][2] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4403\" name=\"availabilityContact[]\" " . getData ("availabilityContact", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $availabilityContact[$lang][3] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4404\" name=\"availabilityContact[]\" " . getData ("availabilityContact", "checkbox", 8) . " type=\"radio\" value=\"8\"> " . $availabilityContact[$lang][4] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4405\" name=\"availabilityContact[]\" " . getData ("availabilityContact", "checkbox", 16) . " type=\"radio\" value=\"16\"> " . $availabilityContact[$lang][5] . "</span></td>
      </tr>
     </table>

     <table>
      <tr>
       <td>&nbsp;</td>
      </tr>
      <tr>
       <td>" . $frequency[$lang][0] . "</td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4501\" name=\"frequency[]\" " . getData ("frequency", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $frequency[$lang][1] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4502\" name=\"frequency[]\" " . getData ("frequency", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $frequency[$lang][2] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4503\" name=\"frequency[]\" " . getData ("frequency", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $frequency[$lang][3] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4504\" name=\"frequency[]\" " . getData ("frequency", "checkbox", 8) . " type=\"radio\" value=\"8\"> " . $frequency[$lang][4] . "</span></td>
      </tr>
     </table>
    </td>
    <td valign=\"top\" class=\"vert_line\" width=\"5%\">&nbsp;</td>
    <td valign=\"top\" class=\"left_pad\" width=\"50%\">
     <table class=\"b_header_nb\">
      <tr>
       <td>" . $supportAccompContactMethod[$lang][0] . "</td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4601\" name=\"supportAccompContactMethod[]\" " . getData ("supportAccompContactMethod", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $supportAccompContactMethod[$lang][1] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4601\" name=\"supportAccompContactMethod[]\" " . getData ("supportAccompContactMethod", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $supportAccompContactMethod[$lang][2] . "</span> <input tabindex=\"4603\" name=\"supportAccompContactMethodOth\" " . getData ("supportAccompContactMethodOth", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
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
       <td><span><input tabindex=\"4701\" name=\"relationshipTo[]\" " . getData ("relationshipTo", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $relationshipTo[$lang][1] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4702\" name=\"relationshipTo[]\" " . getData ("relationshipTo", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $relationshipTo[$lang][2] . "</span></td>
      </tr>
      <tr>
       <td colspan=\"2\"><span><input tabindex=\"4703\" name=\"relationshipTo[]\" " . getData ("relationshipTo", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $relationshipTo[$lang][3] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4704\" name=\"relationshipTo[]\" " . getData ("relationshipTo", "checkbox", 8) . " type=\"radio\" value=\"8\"> " . $relationshipTo[$lang][4] . "</span> <input tabindex=\"4705\" name=\"relationshipToText\" " . getData ("relationshipToText", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4706\" name=\"relationshipTo[]\" " . getData ("relationshipTo", "checkbox", 16) . " type=\"radio\" value=\"16\"> " . $relationshipTo[$lang][5] . "</span> <input tabindex=\"4707\" name=\"relationshipToTextOther\" " . getData ("relationshipToTextOther", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
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
       <td><span><input tabindex=\"4801\" name=\"availAccompany[]\" " . getData ("availAccompany", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $availAccompany[$lang][1] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4802\" name=\"availAccompany[]\" " . getData ("availAccompany", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $availAccompany[$lang][2] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4803\" name=\"availAccompany[]\" " . getData ("availAccompany", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $availAccompany[$lang][3] . "</span></td>
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
       <td><span><input tabindex=\"4804\" name=\"availPickUp[]\" " . getData ("availPickUp", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $availPickUp[$lang][1] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4805\" name=\"availPickUp[]\" " . getData ("availPickUp", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $availPickUp[$lang][2] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4806\" name=\"availPickUp[]\" " . getData ("availPickUp", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $availPickUp[$lang][3] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4807\" name=\"availPickUp[]\" " . getData ("availPickUp", "checkbox", 8) . " type=\"radio\" value=\"8\"> " . $availPickUp[$lang][4] . "</span></td>
      </tr>
     </table>

     <table>
      <tr>
       <td>&nbsp;</td>
      </tr>
      <tr>
       <td>" . $availTraining[$lang][0] . "</td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4808\" name=\"availTraining[]\" " . getData ("availTraining", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $availTraining[$lang][1] . " <input tabindex=\"4809\" name=\"availTraining[]\" " . getData ("availTraining", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $availTraining[$lang][2] . "</span></td>
      </tr>
      <tr>
       <td>" . $availTraining[$lang][3] . " <input tabindex=\"4810\" name=\"availTrainingText\" " . getData ("availTrainingText", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td>" . $availSupportGroup[$lang][0] . "</td>
      </tr>
      <tr>
       <td><span><input tabindex=\"4811\" name=\"availSupportGroup[]\" " . getData ("availSupportGroup", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $availSupportGroup[$lang][1] . " <input tabindex=\"4812\" name=\"availSupportGroup[]\" " . getData ("availSupportGroup", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $availSupportGroup[$lang][2] . "</span></td>
      </tr>
      <tr>
       <td>" . $availSupportGroup[$lang][3] . " <input tabindex=\"4813\" name=\"availSupportGroupText\" " . getData ("availSupportGroupText", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
      </tr>
     </table>

     <table>
      <tr>
       <td>&nbsp;</td>
      </tr>
      <tr>
       <td><b>" . $supportAccompBackup[$lang][0] . "</b></td>
      </tr>
      <tr>
       <td>" . $supportAccompBackup[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"4901\" name=\"backupAccompName\" " . getData ("backupAccompName", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td>" . $supportAccompBackup[$lang][2] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"4902\" name=\"backupAccompRel\" " . getData ("backupAccompRel", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td>" . $supportAccompBackup[$lang][3] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"4903\" name=\"backupAccompContact\" " . getData ("backupAccompContact", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
      </tr>
     </table>
    </td>
   </tr>
  </table>

<!-- ******************************************************************** -->
<!-- *********** Assessment of Support/Obstacles to Follow-up *********** -->
<!-- ******************* (tab indices 5001 - 6000) ********************** -->
<!-- ******************************************************************** -->

  <table class=\"header\">
   <tr>
    <td class=\"s_header\" colspan=\"4\" width=\"100%\">" . $supportAssessment_header[$lang][1] . "</td>
   </tr>
   <tr>
    <td valign=\"top\" width=\"45%\">
     <table class=\"b_header_nb\">
      <tr>
       <td>" . $supportDiscPartner[$lang][0] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6001\" id=\"supportDiscPartner\" name=\"supportDiscPartner\" " . getData ("supportDiscPartner", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $supportDiscPartner[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6002\" id=\"supportDiscParent\" name=\"supportDiscParent\" " . getData ("supportDiscParent", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $supportDiscParent[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6003\" id=\"supportDiscChild\" name=\"supportDiscChild\" " . getData ("supportDiscChild", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $supportDiscChild[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6004\" id=\"supportDiscFriend\" name=\"supportDiscFriend\" " . getData ("supportDiscFriend", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $supportDiscFriend[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6005\" id=\"supportDiscOther\" name=\"supportDiscOther\" " . getData ("supportDiscOther", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $supportDiscOther[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6006\" id=\"supportDiscNobody\" name=\"supportDiscNobody\" " . getData ("supportDiscNobody", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $supportDiscNobody[$lang][1] . "</td>
      </tr>
     </table>

     <table>
      <tr>
       <td>&nbsp;</td>
      </tr>
      <tr>
       <td>" . $supportLevel[$lang][0] . "</td>
      </tr>
      <tr>
       <td><span><input tabindex=\"6101\" name=\"supportLevel[]\" " . getData ("supportLevel", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $supportLevel[$lang][1] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"6102\" name=\"supportLevel[]\" " . getData ("supportLevel", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $supportLevel[$lang][2] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"6103\" name=\"supportLevel[]\" " . getData ("supportLevel", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $supportLevel[$lang][3] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"6104\" name=\"supportLevel[]\" " . getData ("supportLevel", "checkbox", 8) . " type=\"radio\" value=\"8\"> " . $supportLevel[$lang][4] . "</span></td>
      </tr>
     </table>

     <table>
      <tr>
       <td>&nbsp;</td>
      </tr>
      <tr>
       <td>" . $infoByBuddy[$lang][0] . "</td>
      </tr>
      <tr>
       <td><span><input tabindex=\"6201\" name=\"infoByBuddy[]\" " . getData ("infoByBuddy", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $infoByBuddy[$lang][1] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"6202\" name=\"infoByBuddy[]\" " . getData ("infoByBuddy", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $infoByBuddy[$lang][2] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"6203\" name=\"infoByBuddy[]\" " . getData ("infoByBuddy", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $infoByBuddy[$lang][3] . "</span></td>
      </tr>
     </table>";

echo "

     <table>
      <tr>
       <td>&nbsp;</td>
      </tr>
      <tr>
       <td>" . $supportByBuddy[$lang][0] . "</td>
      </tr>
      <tr>
       <td><span><input tabindex=\"6301\" name=\"supportByBuddy[]\" " . getData ("supportByBuddy", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $supportByBuddy[$lang][1] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"6302\" name=\"supportByBuddy[]\" " . getData ("supportByBuddy", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $supportByBuddy[$lang][2] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"6303\" name=\"supportByBuddy[]\" " . getData ("supportByBuddy", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $supportByBuddy[$lang][3] . "</span></td>
      </tr>
     </table>";

echo "
    </td>
    <td valign=\"top\" class=\"vert_line\" width=\"5%\">&nbsp;</td>
    <td valign=\"top\" class=\"left_pad\" width=\"50%\">
     <table class=\"b_header_nb\">";



echo "
      <tr>
       <td>" . $acceptHomeVisits[$lang][0] . "</td>
      </tr>
      <tr>
       <td><span><input tabindex=\"6401\" name=\"acceptHomeVisits[]\" " . getData ("acceptHomeVisits", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $acceptHomeVisits[$lang][1] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"6402\" name=\"acceptHomeVisits[]\" " . getData ("acceptHomeVisits", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $acceptHomeVisits[$lang][2] . "</span></td>
      </tr>
      <tr>
       <td><span><input tabindex=\"6403\" name=\"acceptHomeVisits[]\" " . getData ("acceptHomeVisits", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $acceptHomeVisits[$lang][3] . "</span></td>
      </tr>
     </table>

     <table>
      <tr>
       <td>&nbsp;</td>
      </tr>
      <tr>
       <td>" . $barriersToHomeVisits[$lang][0] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6501\" name=\"barriersToHomeVisits[]\" " . getData ("barriersToHomeVisits", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $barriersToHomeVisits[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6502\" name=\"barriersToHomeVisits[]\" " . getData ("barriersToHomeVisits", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $barriersToHomeVisits[$lang][2] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6503\" name=\"barriersToHomeVisits[]\" " . getData ("barriersToHomeVisits", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $barriersToHomeVisits[$lang][3] . "</td>
      </tr>
     </table>

     <table>
      <tr>
       <td>&nbsp;</td>
      </tr>
      <tr>
       <td>" . $barriersToAppts[$lang][0] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6601\" name=\"barriersToAppts[]\" " . getData ("barriersToAppts", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $barriersToAppts[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6602\" name=\"barriersToAppts[]\" " . getData ("barriersToAppts", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $barriersToAppts[$lang][2] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6603\" name=\"barriersToAppts[]\" " . getData ("barriersToAppts", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $barriersToAppts[$lang][3] . "</td>
      </tr>";

 echo "
      <tr>
       <td><input tabindex=\"6604\" name=\"barriersToAppts[]\" " . getData ("barriersToAppts", "checkbox", 8) . " type=\"radio\" value=\"8\"> " . $barriersToAppts[$lang][4] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"6605\" name=\"barriersToAppts[]\" " . getData ("barriersToAppts", "checkbox", 16) . " type=\"radio\" value=\"16\"> " . $barriersToAppts[$lang][5] . " <input tabindex=\"6606\" name=\"barriersToApptsText\" " . getData ("barriersToApptsText", "text") . " type=\"text\" size=\"20\" maxlength=\"255\"></td>
      </tr>";

echo "
     </table>
    </td>
   </tr>
  </table>

<!-- ******************************************************************** -->
<!-- ******************* Patient Education on ARV *********************** -->
<!-- ******************* (tab indices 7001 - 8000) ********************** -->
<!-- ******************************************************************** -->

  <table class=\"header\">
   <tr>
    <td class=\"s_header\" colspan=\"5\" width=\"100%\">" . $patientEducation_header[$lang][0] . "</td>
   </tr>
   <tr>
    <td class=\"sm_header_lt\" width=\"65%\">" . $patientEducation_header[$lang][1] . "</td>
    <td rowspan=\"11\" width=\"5%\">&nbsp;</td>
    <td class=\"sm_header_lt\" colspan=\"3\" width=\"30%\">" . $patientEducation_header[$lang][2] . "</td>
   </tr>
   <tr>
    <td colspan=\"5\" class=\"top_line\">&nbsp;</td>
   </tr>
   <tr>
    <td width=\"65%\">" . $regularFollowup[$lang][0] . "</td>
    <td width=\"10%\"><input tabindex=\"7001\" name=\"regularFollowup[]\" " . getData ("regularFollowup", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $regularFollowup[$lang][1] . "</td>
    <td width=\"10%\"><input tabindex=\"7002\" name=\"regularFollowup[]\" " . getData ("regularFollowup", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $regularFollowup[$lang][2] . "</td>
    <td width=\"10%\"><input tabindex=\"7003\" name=\"regularFollowup[]\" " . getData ("regularFollowup", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $regularFollowup[$lang][3] . "</td>
   </tr>
   <tr>
    <td class=\"top_pad\" width=\"65%\">" . $doNotCure[$lang][0] . "</td>
    <td class=\"top_pad\" width=\"10%\"><input tabindex=\"7004\" name=\"doNotCure[]\" " . getData ("doNotCure", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $doNotCure[$lang][1] . "</td>
    <td class=\"top_pad\" width=\"10%\"><input tabindex=\"7005\" name=\"doNotCure[]\" " . getData ("doNotCure", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $doNotCure[$lang][2] . "</td>
    <td class=\"top_pad\" width=\"10%\"><input tabindex=\"7006\" name=\"doNotCure[]\" " . getData ("doNotCure", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $doNotCure[$lang][3] . "</td>
   </tr>
   <tr>
    <td class=\"top_pad\" width=\"65%\">" . $canStillTransmit[$lang][0] . "</td>
    <td class=\"top_pad\" width=\"10%\"><input tabindex=\"7007\" name=\"canStillTransmit[]\" " . getData ("canStillTransmit", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $canStillTransmit[$lang][1] . "</td>
    <td class=\"top_pad\" width=\"10%\"><input tabindex=\"7008\" name=\"canStillTransmit[]\" " . getData ("canStillTransmit", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $canStillTransmit[$lang][2] . "</td>
    <td class=\"top_pad\" width=\"10%\"><input tabindex=\"7009\" name=\"canStillTransmit[]\" " . getData ("canStillTransmit", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $canStillTransmit[$lang][3] . "</td>
   </tr>
   <tr>
    <td class=\"top_pad\" width=\"65%\">" . $canMinimizeRisk[$lang][0] . "</td>
    <td class=\"top_pad\" width=\"10%\"><input tabindex=\"7010\" name=\"canMinimizeRisk[]\" " . getData ("canMinimizeRisk", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $canMinimizeRisk[$lang][1] . "</td>
    <td class=\"top_pad\" width=\"10%\"><input tabindex=\"7011\" name=\"canMinimizeRisk[]\" " . getData ("canMinimizeRisk", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $canMinimizeRisk[$lang][2] . "</td>
    <td class=\"top_pad\" width=\"10%\"><input tabindex=\"7012\" name=\"canMinimizeRisk[]\" " . getData ("canMinimizeRisk", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $canMinimizeRisk[$lang][3] . "</td>
   </tr>
   <tr>
    <td class=\"top_pad\" width=\"65%\">" . $adherenceAbove95[$lang][0] . "</td>
    <td class=\"top_pad\" width=\"10%\"><input tabindex=\"7013\" name=\"adherenceAbove95[]\" " . getData ("adherenceAbove95", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $adherenceAbove95[$lang][1] . "</td>
    <td class=\"top_pad\" width=\"10%\"><input tabindex=\"7014\" name=\"adherenceAbove95[]\" " . getData ("adherenceAbove95", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $adherenceAbove95[$lang][2] . "</td>
    <td class=\"top_pad\" width=\"10%\"><input tabindex=\"7015\" name=\"adherenceAbove95[]\" " . getData ("adherenceAbove95", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $adherenceAbove95[$lang][3] . "</td>
   </tr>
   <tr>
    <td class=\"top_pad\" width=\"65%\">" . $stopAll[$lang][0] . "</td>
    <td class=\"top_pad\" width=\"10%\"><input tabindex=\"7016\" name=\"stopAll[]\" " . getData ("stopAll", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $stopAll[$lang][1] . "</td>
    <td class=\"top_pad\" width=\"10%\"><input tabindex=\"7017\" name=\"stopAll[]\" " . getData ("stopAll", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $stopAll[$lang][2] . "</td>
    <td class=\"top_pad\" width=\"10%\"><input tabindex=\"7018\" name=\"stopAll[]\" " . getData ("stopAll", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $stopAll[$lang][3] . "</td>
   </tr>
   <tr>
    <td class=\"top_pad\" width=\"65%\">" . $patientEducation_sideEffects[$lang][0] . "</td>
    <td class=\"top_pad\" width=\"10%\"><input tabindex=\"7019\" name=\"sideEffectsComp[]\" " . getData ("sideEffectsComp", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $patientEducation_sideEffects[$lang][1] . "</td>
    <td class=\"top_pad\" width=\"10%\"><input tabindex=\"7020\" name=\"sideEffectsComp[]\" " . getData ("sideEffectsComp", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $patientEducation_sideEffects[$lang][2] . "</td>
    <td class=\"top_pad\" width=\"10%\"><input tabindex=\"7021\" name=\"sideEffectsComp[]\" " . getData ("sideEffectsComp", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $patientEducation_sideEffects[$lang][3] . "</td>
   </tr>
   <tr>
    <td class=\"top_pad\" width=\"65%\">" . $canExplain[$lang][0] . "</td>
    <td class=\"top_pad\" width=\"10%\"><input tabindex=\"7022\" name=\"canExplain[]\" " . getData ("canExplain", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $canExplain[$lang][1] . "</td>
    <td class=\"top_pad\" width=\"10%\"><input tabindex=\"7023\" name=\"canExplain[]\" " . getData ("canExplain", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $canExplain[$lang][2] . "</td>
    <td class=\"top_pad\" width=\"10%\"><input tabindex=\"7024\" name=\"canExplain[]\" " . getData ("canExplain", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $canExplain[$lang][3] . "</td>
   </tr>
   <tr>
    <td class=\"top_pad\" width=\"65%\">" . $pregnantFemale[$lang][0] . "</td>
    <td class=\"top_pad\" width=\"10%\"><input tabindex=\"7025\" name=\"pregnantFemale[]\" " . getData ("pregnantFemale", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $pregnantFemale[$lang][1] . "</td>
    <td class=\"top_pad\" width=\"10%\"><input tabindex=\"7026\" name=\"pregnantFemale[]\" " . getData ("pregnantFemale", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $pregnantFemale[$lang][2] . "</td>
    <td class=\"top_pad\" width=\"10%\"><input tabindex=\"7027\" name=\"pregnantFemale[]\" " . getData ("pregnantFemale", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $pregnantFemale[$lang][3] . "</td>
   </tr>
  </table>
";

$tabIndex = 8000;
include ("include/violenceAssessment.php");

$tabIndex = 9000;
include ("include/needsAssessment.php");

$tabIndex = 10000;
include ("include/commentsActionPlan.php");

$tabIndex = 11000;
$formName = "counsIntake";

?>
