<?php
$encType = 17;
if ($tabsOn) {
  include("include/tabs/followUpTabs.php");
}
echo "
<div id=\"tab-panes\">";

if (!$tabsOn) {
  include ("include/nurseSection.php");
}

// Nurse tab
echo "
<div id=\"pane1\">
  <table class=\"header\">

<!-- ******************************************************************** -->
<!-- ********************* Disclosure of HIV Status ********************* -->
<!-- ********************* (tab indices 1001 - 1100) ******************** -->
<!-- ******************************************************************** -->

   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"4\">" . $pedDisclosure[$lang][1] . "</td>
      </tr>
      <tr>
	    <td width=\"35%\">" . $pedChildAware[$lang][0] . "</td>
	    <td width=\"65%\"><span ><input tabindex=\"1001\" name=\"pedChildAware[]\" " . getData ("pedChildAware", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input tabindex=\"1002\" name=\"pedChildAware[]\" " . getData ("pedChildAware", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input tabindex=\"1003\" name=\"pedChildAware[]\" " . getData ("pedChildAware", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</span></td>
      </tr>
      <tr>
	    <td width=\"35%\">" . $pedParentAware[$lang][0] . "</td>
	    <td width=\"65%\"><span ><input tabindex=\"1004\" name=\"pedParentAware[]\" " . getData ("pedParentAware", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input tabindex=\"1005\" name=\"pedParentAware[]\" " . getData ("pedParentAware", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input tabindex=\"1006\" name=\"pedParentAware[]\" " . getData ("pedParentAware", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</span></td>
      </tr>
     </table>
    </td>
   </tr>

<!-- ******************************************************************** -->
<!-- ************************** Immunizations *************************** -->
<!-- ********************* (tab indices 1201 - 1400) ******************** -->
<!-- ******************************************************************** -->

   <tr>
    <td colspan=\"3\">
     <table cellspacing=\"0\">
      <tr>
       <td valign=\"top\" width=\"45%\">
        <table class=\"b_header_nb\">
         <tr>
          <td class=\"s_header\" colspan=\"3\">" . $pedFollowup[$lang][0] . "</td>
         </tr>
         <tr>
          <td colspan=\"3\" width=\"100%\"><i>" . $pedFollowup[$lang][1] . "</i></td>
         </tr>
         <tr>
          <td width=\"30%\">&nbsp;</td>
          <td class=\"sm_header_lt_np\" width=\"20%\">" . $pedFollowup[$lang][2] . "</td>
          <td class=\"sm_header_lt_np\" width=\"50%\">" . $pedFollowup[$lang][3] . "</td>
         </tr>";

$tabIndex = 1201;
$followup = 1;
include ("include/pedImmunizations.php");
echo "
        </table>
       </td>
       <td valign=\"top\" class=\"vert_line\" width=\"1%\">&nbsp;</td>

<!-- ******************************************************************** -->
<!-- ************************** General Status ************************** -->
<!-- ********************* (tab indices 1401 - 1600) ******************** -->
<!-- ******************************************************************** -->

       <td valign=\"top\" class=\"left_pad\" width=\"54%\">
        <table class=\"b_header_nb\">
         <tr>
          <td class=\"s_header\" colspan=\"3\">" . $genStat[$lang][0] . "</td>
         </tr>
         <tr>
          <td ><input tabindex=\"1401\" name=\"genStat[]\" " . getData ("genStat", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $genStat[$lang][1] . "</td>
          <td ><input tabindex=\"1404\" name=\"genStat[]\" " . getData ("genStat", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $genStat[$lang][2] . "</td>
         </tr>
         <tr>
          <td ><input tabindex=\"1402\" name=\"genStat[]\" " . getData ("genStat", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $genStat[$lang][3] . "</td>
          <td ><input tabindex=\"1405\" name=\"genStat[]\" " . getData ("genStat", "checkbox", 8) . " type=\"radio\" value=\"8\">" . $genStat[$lang][4] . "</td>
         </tr>
         <tr>
          <td ><input tabindex=\"1403\" name=\"genStat[]\" " . getData ("genStat", "checkbox", 16) . " type=\"radio\" value=\"16\">" . $genStat[$lang][5] . "</td>
          <td>&nbsp;</td>
         </tr>
         <tr>
          <td>" . $pedFollowup[$lang][4] . " </td>
          <td ><input tabindex=\"1406\" name=\"hospitalized[]\" " . getData ("hospitalized", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $hospitalized[$lang][1] . " <input tabindex=\"1407\" name=\"hospitalized[]\" " . getData ("hospitalized", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $hospitalized[$lang][2] . " <input tabindex=\"1408\" name=\"hospitalized[]\" " . getData ("hospitalized", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $hospitalized[$lang][3] . "</td>
         </tr>
         <tr>
          <td ><i>" . $pedFollowup[$lang][5] . "</i></td>
          <td ><input tabindex=\"1409\" name=\"hospitalizedText\" " . getData ("hospitalizedText", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
         </tr>

<!-- ******************************************************************** -->
<!-- ************************* Functional Status ************************ -->
<!-- ********************* (tab indices 1601 - 1800) ******************** -->
<!-- ******************************************************************** -->

         <tr>
          <td class=\"s_header\" colspan=\"2\">" . $functionalStatus[$lang][0] . "</td>
         </tr>
         <tr>
          <td colspan=\"2\"><table><tr><td id=\"functionalStatusTitle\"></td><td><i>" . $functionalStatus[$lang][1] . "</i></td></tr></table></td>
         </tr>
         <tr>
          <td colspan=\"2\"><input tabindex=\"1601\" id=\"functionalStatus1\" name=\"functionalStatus[]\" " . getData ("functionalStatus", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedFollowup[$lang][6] . "</td>
         </tr>
         <tr>
          <td colspan=\"2\"><input tabindex=\"1602\" id=\"functionalStatus2\" name=\"functionalStatus[]\" " . getData ("functionalStatus", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedFollowup[$lang][7] . "</td>
         </tr>
         <tr>
          <td colspan=\"2\"><input tabindex=\"1603\" id=\"functionalStatus4\" name=\"functionalStatus[]\" " . getData ("functionalStatus", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $pedFollowup[$lang][8] . "</td>
         </tr>

<!-- ******************************************************************** -->
<!-- ************************ Evaluation of Risk ************************ -->
<!-- ********************* (tab indices 1801 - 2000) ******************** -->
<!-- ******************************************************************** -->

         <tr>
          <td class=\"s_header\" colspan=\"2\">" . $pedFollowup[$lang][9] . "</td>
         </tr>
         <tr>
          <td colspan=\"2\"><b>" . $pedFollowup[$lang][10] . "</b></td>
         </tr>
         <tr>
          <td colspan=\"2\"><i>" . $pedFollowup[$lang][11] . "</i></td>
         </tr>
         <tr>
          <td>" . $sexInt[$lang][2] . "</td>
          <td ><input tabindex=\"1801\" name=\"sexInt[]\" " . getData ("sexInt", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $sexInt[$lang][3] . " <input tabindex=\"1802\" name=\"sexInt[]\" " . getData ("sexInt", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $sexInt[$lang][4] . " <input tabindex=\"1803\" name=\"sexInt[]\" " . getData ("sexInt", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $sexInt[$lang][5] . "</td>
         </tr>
         <tr>
          <td><i>" . $pedFollowup[$lang][12] . "</i></td>
          <td ><input tabindex=\"1804\" name=\"sexIntWOcondom[]\" " . getData ("sexIntWOcondom", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $sexIntWOcondom[$lang][1] . " <input tabindex=\"1805\" name=\"sexIntWOcondom[]\" " . getData ("sexIntWOcondom", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $sexIntWOcondom[$lang][2] . " <input tabindex=\"1806\" name=\"sexIntWOcondom[]\" " . getData ("sexIntWOcondom", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $sexIntWOcondom[$lang][3] . "</td>
         </tr>
		 
	  <tr>
       <td style=\"font-weight: bold;\" colspan=\"4\">" .$PopulationCle[$lang][0] . "  </td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 1) .  "\" name=\"harsahRisk\" " . getData ("harsahRisk", "checkbox") .  " type=\"checkbox\" value=\"On\">" .  $PopulationCle[$lang][1] . "</td> 
       <td colspan=\"2\"><input tabindex=\"" . ($tabIndex + 2) . "\" name=\"sexProfessionelRisk\" " . getData ("sexProfessionelRisk", "checkbox") . " type=\"checkbox\" value=\"On\">" . $PopulationCle[$lang][2] . "</td>
	   </tr>
      <tr>       
       <td><input tabindex=\"" . ($tabIndex + 4) . "\" name=\"transgenreRisk\" " . getData ("transgenreRisk", "checkbox") . " type=\"checkbox\" value=\"On\">" . $PopulationCle[$lang][4] . "</td>
	   <td colspan=\"2\"><input tabindex=\"" . ($tabIndex + 5) . "\" name=\"drugUserRisk\" " . getData ("drugUserRisk", "checkbox") . " type=\"checkbox\" value=\"On\">" . $PopulationCle[$lang][5] . "</td>
	   </tr>
       <tr>       
       <td><input tabindex=\"" . ($tabIndex + 3) . "\" name=\"prisonierRisk\" " . getData ("prisonierRisk", "checkbox") . " type=\"checkbox\" value=\"On\">" . $PopulationCle[$lang][3] . "</td>
      </tr>
		 
		 
		 
        </table>
       </td>
      </tr>
     </table>
    </td>
   </tr>
   
         

<!-- ******************************************************************** -->
<!-- ******************* Adolescent Reproductive Health ***************** -->
<!-- ********************* (tab indices 3001 - 3200) ******************** -->
<!-- ******************************************************************** -->

    <tr>
     <td colspan=\"3\">
      <table class=\"b_header_nb\">
       <tr>
        <td class=\"s_header\" colspan=\"4\">" . $pedReproHealth[$lang][0] . "</td>
       </tr>
       <tr>
        <td width=\"25%\"><b>" . $pedReproHealth[$lang][1] . "</b></td>
        <td width=\"25%\"><input  tabindex=\"3001\" class=\"pedMenses\" id=\"pedMensesY\" name=\"pedReproHealthMenses[]\" " . getData ("pedReproHealthMenses", "radio", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input tabindex=\"3002\" class=\"pedMenses\" id=\"pedMensesN\" name=\"pedReproHealthMenses[]\" " . getData ("pedReproHealthMenses", "radio", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input tabindex=\"3003\" class=\"pedMenses\" id=\"pedMensesU\" name=\"pedReproHealthMenses[]\" " . getData ("pedReproHealthMenses", "radio", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</td>
        <td width=\"25%\" id=\"pregnantLmpDtTitle\">" . $pedReproHealth[$lang][2] . "</td>

        <td width=\"25%\"><table><tr><td><input tabindex=\"1504\" class=\"pedMenses\" id=\"pregnantLmpDt\" name=\"pregnantLmpDt\" value=\"" . getData ("pregnantLmpDd", "textarea") . "/". getData ("pregnantLmpMm", "textarea") ."/". getData ("pregnantLmpYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\"> <input  id=\"pregnantLmpDd\" name=\"pregnantLmpDd\" " . getData ("pregnantLmpDd", "text") . " type=\"hidden\" ><input tabindex=\"1505\" id=\"pregnantLmpMm\" name=\"pregnantLmpMm\" " . getData ("pregnantLmpMm", "text") . " type=\"hidden\" ><input tabindex=\"1506\" id=\"pregnantLmpYy\" name=\"pregnantLmpYy\" " . getData ("pregnantLmpYy", "text") . " type=\"hidden\" ></td><td><i>" . $pregnantLmpYy[$lang][2] . "</i></td></tr></table></td>
       </tr>
       <tr>
        <td colspan=\"4\" width=\"100%\"><i>" . $pedFollowup[$lang][13] . "</i></td>
       </tr>
       <tr>
        <td width=\"25%\"><b>" . $pedReproHealth[$lang][4] . "</b></td>
        <td width=\"25%\"><input tabindex=\"3007\" class=\"pedPreg\" id=\"pedPregY\" name=\"pregnant[]\" " . getData ("pregnant", "radio", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input class=\"pedPreg\" id=\"pedPregN\" tabindex=\"3008\" name=\"pregnant[]\" " . getData ("pregnant", "radio", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input tabindex=\"3009\" class=\"pedPreg\" id=\"pedPregU\" name=\"pregnant[]\" " . getData ("pregnant", "radio", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</td>
        <td width=\"25%\">" . $pedFollowup[$lang][14] . "</td>
        <td width=\"25%\"><input tabindex=\"3010\"  class=\"pedPregPrenat\" id=\"pedPregPrenatY\" name=\"pregnantPrenatal[]\" " . getData ("pregnantPrenatal", "radio", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input tabindex=\"3011\" class=\"pedPregPrenat\" id=\"pedPregPrenatN\" name=\"pregnantPrenatal[]\" " . getData ("pregnantPrenatal", "radio", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input tabindex=\"3012\" class=\"pedPregPrenat\" id=\"pedPregPrenatU\"name=\"pregnantPrenatal[]\" " . getData ("pregnantPrenatal", "radio", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</td>
       </tr>
       <tr>
        <td width=\"25%\">&nbsp;</td>
        <td width=\"25%\" id=\"pregnantPrenatalFirstDtTitle\"><i>" . $pedReproHealth[$lang][6] . "</i></td>
        <td width=\"25%\"><table><tr><td><input class=\"pedPregPrenat\" tabindex=\"1509\" id=\"pregnantPrenatalFirstDt\" name=\"pregnantPrenatalFirstDt\" value=\"" . getData ("pregnantPrenatalFirstDd", "textarea") . "/". getData ("pregnantPrenatalFirstMm", "textarea") ."/". getData ("pregnantPrenatalFirstYy", "textarea") . "\" " . $gray . " type=\"text\" size=\"8\" maxlength=\"8\"><input id=\"pregnantPrenatalFirstDd\"  name=\"pregnantPrenatalFirstDd\" " . getData ("pregnantPrenatalFirstDd", "text") . " type=\"hidden\"><input tabindex=\"1510\" id=\"pregnantPrenatalFirstMm\" name=\"pregnantPrenatalFirstMm\" " . getData ("pregnantPrenatalFirstMm", "text") . " type=\"hidden\"><input tabindex=\"1511\" id=\"pregnantPrenatalFirstYy\" name=\"pregnantPrenatalFirstYy\" " . getData ("pregnantPrenatalFirstYy", "text") . " type=\"hidden\"></td><td><i>" . $pregnantLmpYy[$lang][2] . "</i></td></tr></table></td>
        	   <td >&nbsp;</td>

       </tr>
       <tr>
        <td width=\"25%\">&nbsp;</td>
        <td width=\"25%\" id=\"pregnantPrenatalLastDtTitle\"><i>" . $pedReproHealth[$lang][7] . "</i></td>
        <td width=\"25%\"><table><tr><td><input class=\"pedPregPrenat\" tabindex=\"1512\" id=\"pregnantPrenatalLastDt\" name=\"pregnantPrenatalLastDt\" value=\"" . getData ("pregnantPrenatalLastDd", "textarea") . "/". getData ("pregnantPrenatalLastMm", "textarea") ."/". getData ("pregnantPrenatalLastYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\"> <input id=\"pregnantPrenatalLastDd\" name=\"pregnantPrenatalLastDd\" " . getData ("pregnantPrenatalLastDd", "text") . " type=\"hidden\"><input tabindex=\"1513\" id=\"pregnantPrenatalLastMm\" name=\"pregnantPrenatalLastMm\" " . getData ("pregnantPrenatalLastMm", "text") . " type=\"hidden\"><input id=\"pregnantPrenatalLastYy\" name=\"pregnantPrenatalLastYy\" " . getData ("pregnantPrenatalLastYy", "text") . " type=\"hidden\"></td><td><i>" . $pregnantLmpYy[$lang][2] . "</i></td></tr></table> </td>
        	   <td >&nbsp;</td>
       </tr>
       <tr>
        <td colspan=\"4\" width=\"100%\"><i>" . $pedFollowup[$lang][15] . "</i></td>
       </tr>
       <tr>
        <td width=\"25%\"><b>" . $pedReproHealth[$lang][8] . "</b></td>
        <td width=\"25%\"><input tabindex=\"3019\" class=\"papTest\" id=\"papTestY\" name=\"papTest[]\" " . getData ("papTest", "radio", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input tabindex=\"3020\" class=\"papTest\" id=\"papTestN\" name=\"papTest[]\" " . getData ("papTest", "radio", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input tabindex=\"3021\" class=\"papTest\" id=\"papTestU\" name=\"papTest[]\" " . getData ("papTest", "radio", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</td>
        <td width=\"25%\" id=\"papTestDtTitle\"><i>" . $pedReproHealth[$lang][12] . "</i></td>
        <td width=\"25%\"><table><tr><td><input tabindex=\"3022\" size=\"8\"  class=\"papTestResult\" id=\"papTestDt\"  name=\"papTestDt\" value=\"" . getData ("papTestDd", "textarea") . "/". getData ("papTestMm", "textarea") ."/". getData ("papTestYy", "textarea") . "\" /><input type = \"hidden\" id=\"papTestDd\" name = \"papTestDd\" ".getData("papTestDd", "text") . " /><input  id=\"papTestMm\" name=\"papTestMm\" " . getData ("papTestMm", "text") . " type=\"hidden\" /><input id=\"papTestYy\" name=\"papTestYy\" " . getData ("papTestYy", "text") . " type=\"hidden\" /></td><td><i>" . $jma[$lang][1] . "</i></td></tr></table></td>
       </tr>
       <tr>
        <td width=\"25%\"><i>" . $pedReproHealth[$lang][9] . "</i></td>
        <td width=\"25%\"><input tabindex=\"3025\" class=\"papTestResult\" id=\"papTestResultY\" name=\"pedPapTestRes[]\" " . getData ("pedPapTestRes", "radio", 1) . " type=\"radio\" value=\"1\">" . $pedReproHealth[$lang][10] . " <input tabindex=\"3026\"  class=\"papTestResult\" id=\"papTestResultN\"  name=\"pedPapTestRes[]\" " . getData ("pedPapTestRes", "radio", 2) . " type=\"radio\" value=\"2\">" . $pedReproHealth[$lang][11] . "</td>
        <td colspan=\"2\" width=\"50%\">&nbsp;</td>
       </tr>
      </table>
     </td>
   </tr>
";

$tabIndex = 3400;
include ("include/pedFeeding.php");

echo "

<!-- ******************************************************************** -->
<!-- *************************** Current Vitals ************************* -->
<!-- ********************* (tab indices 3801 - 4000) ******************** -->
<!-- ******************************************************************** -->

   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"4\">" . $pedFollowup[$lang][16] . "</td>
      </tr>
      <tr>
       <td width=\"15%\" id=\"vitalTempTitle\" >" . $pedVitCur[$lang][1] . "</td>
       <td width=\"35%\"><table><tr><td><input tabindex=\"3801\" id=\"vitalTemp\" name=\"vitalTemp\" " . getData ("vitalTemp", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"/><i>" . $pedVitCur[$lang][2] . "</td><td id=\"vitalTempUnitTitle\" ></td><td><input tabindex=\"3802\" id=\"vitalTempUnit1\" name=\"vitalTempUnits[]\" " . getData ("vitalTempUnits", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedVitCur[$lang][3] . " <input tabindex=\"3803\" id=\"vitalTempUnit2\" name=\"vitalTempUnits[]\" " . getData ("vitalTempUnits", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedVitCur[$lang][4] . "</i></span></td></tr></table></td>
       <td width=\"15%\" id=\"vitalHrTitle\">" . $pedVitCur[$lang][5] . "</td>
       <td width=\"35%\"><input tabindex=\"3804\" id=\"vitalHr\" name=\"vitalHr\" " . getData ("vitalHr", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"><i>" . $pedVitCur[$lang][6] . "</i></td>
      </tr>
      <tr>
       <td width=\"15%\" id=\"vitalBp1Title\">" . $pedVitCur[$lang][7] . "</td>
       <td width=\"35%\"><table><tr><td><input tabindex=\"3805\" id=\"vitalBp1\" name=\"vitalBp1\" " . getData ("vitalBp1", "text") . " type=\"text\" size=\"5\" maxlength=\"64\"> /</td><td  id=\"vitalBp2Title\"></td><td><input tabindex=\"3806\" id=\"vitalBp2\" name=\"vitalBp2\" " . getData ("vitalBp2", "text") . " type=\"text\" size=\"5\" maxlength=\"64\"><i>" . $pedVitCur[$lang][2] . " </td><td id=\"vitalBpUnitTitle\" ></td><td><input tabindex=\"3807\"  id=\"vitalBpUnit1\" name=\"vitalBPUnits[]\" " . getData ("vitalBPUnits", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedVitCur[$lang][8] . " <input tabindex=\"3808\"  id=\"vitalBpUnit2\" name=\"vitalBPUnits[]\" " . getData ("vitalBPUnits", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedVitCur[$lang][9] . "</i></span></td></tr></table></td>
       <td width=\"15%\" id=\"vitalRrTitle\">" . $pedVitCur[$lang][10] . "</td>
       <td width=\"35%\"><input tabindex=\"3809\" id=\"vitalRr\" name=\"vitalRr\" " . getData ("vitalRr", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"><i>" . $pedVitCur[$lang][6] . "</i></td>
      </tr>
      <tr>
       <td width=\"15%\" id=\"vitalWeightTitle\">" . $pedVitCur[$lang][11] . "</td>
       <td width=\"35%\"><table><tr><td><input tabindex=\"3810\" id=\"vitalWeight\" name=\"vitalWeight\" " . getData ("vitalWeight", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"><i>" . $pedVitCur[$lang][2] . "</i></td><td id=\"vitalWeightUnitTitle\" ></td><td> <input tabindex=\"3811\" id=\"vitalWeightUnit1\" name=\"vitalWeightUnits[]\" " . getData ("vitalWeightUnits", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedVitCur[$lang][12] . " <input tabindex=\"3812\" id=\"vitalWeightUnit2\" name=\"vitalWeightUnits[]\" " . getData ("vitalWeightUnits", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedVitCur[$lang][13] . "</i></td></tr></table></td>
       <td width=\"15%\" id=\"vitalHeightTitle\">" . $pedVitCur[$lang][14] . "</td>
       <td width=\"35%\"><table><tr><td><input tabindex=\"3813\" id=\"vitalHeight\" name=\"vitalHeight\" " . getData ("vitalHeight", "text") . " type=\"text\" size=\"1\" maxlength=\"1\"><i>" . $pedVitCur[$lang][15] . "</i></td><td id=\"vitalHeightCmTitle\">&nbsp;</td><td><input tabindex=\"3814\" id=\"vitalHeightCm\" name=\"vitalHeightCm\" " . getData ("vitalHeightCm", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"><i>" . $pedVitCur[$lang][16] . "</i></td></tr></table></td>
      </tr>
      <tr>
       <td width=\"15%\" id=\"pedVitCurWtLastTitle\">" . $pedVitCur[$lang][17] . "</td>
       <td width=\"35%\"><table><tr><td><input tabindex=\"3815\" id=\"pedVitCurWtLast\" name=\"pedVitCurWtLast\" " . getData ("pedVitCurWtLast", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"><i>" . $pedVitCur[$lang][2] . " </td><td id=\"pedVitCurWtLastUnitTitle\" ></td><td><input tabindex=\"3816\" id=\"pedVitCurWtLastUnit1\" name=\"pedVitCurWtLastUnits[]\" " . getData ("pedVitCurWtLastUnits", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedVitCur[$lang][12] . " <input tabindex=\"3817\" id=\"pedVitCurWtLastUnit2\" name=\"pedVitCurWtLastUnits[]\" " . getData ("pedVitCurWtLastUnits", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedVitCur[$lang][13] . "</i></span></td></tr></table></td>
       <td width=\"15%\" id=\"pedVitCurPt2Title\">" . $pedVitCur[$lang][18] . "</td>
       <td width=\"35%\"><input tabindex=\"3818\" id=\"pedVitCurPt2\" name=\"pedVitCurPt2\" " . getData ("pedVitCurPt2", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"><i>" . $pedVitCur[$lang][19] . "</i></td>
      </tr>
      <tr>
       <td width=\"15%\" id=\"pedVitCurHeadCircTitle\">" . $pedVitCur[$lang][20] . "</td>
       <td width=\"35%\"><input tabindex=\"3819\" id=\"pedVitCurHeadCirc\" name=\"pedVitCurHeadCirc\" " . getData ("pedVitCurHeadCirc", "text") . " type=\"text\" size=\"10\" maxlength=\"64\">" . $pedVitCur[$lang][16] . " <i>" . $pedVitCur[$lang][21] . "</i></td>
       <td width=\"15%\" id=\"pedVitCurCircCircTitle\">" . $pedVitCur[$lang][22] . "</td>
       <td width=\"35%\"><input tabindex=\"3820\" id=\"pedVitCurCircCirc\" name=\"pedVitCurCircCirc\" " . getData ("pedVitCurCircCirc", "text") . " type=\"text\" size=\"10\" maxlength=\"64\">" . $pedVitCur[$lang][23] . " <i>" . $pedVitCur[$lang][24] . "</i></td>
      </tr>
      <tr>
       <td width=\"15%\" id=\"pedVitCurBracCircTitle\">" . $pedVitCur[$lang][25] . "</td>
       <td width=\"35%\"><input tabindex=\"3821\" id=\"pedVitCurBracCirc\"  name=\"pedVitCurBracCirc\" " . getData ("pedVitCurBracCirc", "text") . " type=\"text\" size=\"10\" maxlength=\"64\">" . $pedVitCur[$lang][16] . " <i>" . $pedVitCur[$lang][24] . "</i></td>
       <td width=\"15%\" id=\"pedVitCurOxySatTitle\">" . $pedVitCur[$lang][26] . "</td>
       <td width=\"35%\"><input tabindex=\"3822\" id=\"pedVitCurOxySat\" name=\"pedVitCurOxySat\" " . getData ("pedVitCurOxySat", "text") . " type=\"text\" size=\"3\" maxlength=\"3\">" . $pedVitCur[$lang][23] . "</td>
      </tr>
      <tr>
       <td colspan=\"4\" width=\"100%\"><i>" . $pedVitCur[$lang][27] . "</i></td>
      </tr>
     </table>
    </td>
   </tr>
  </table>
</div>
";
$tabIndex = 3900;
echo "<div><table width=\"100%\"><tr><td>";
include ("include/tbStatus_followup.php");
echo "</td></tr></table></div>";

if (!$tabsOn) {
  include ("include/doctorSection.php");
}

// symptoms                    tabstart:4000
echo "
<div id=\"pane2\">
<table class=\"header\">";
$tabIndex = 4000;
include ("symptoms/ped.php");
echo "
<!-- ******************************************************************** -->
<!-- ************************ Psychomotor Eval ************************** -->
<!-- ******************** (tab indices 4201 - 4400) ********************- -->
<!-- ******************************************************************** -->

   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"4\">" . $pedPsychoMotor[$lang][0] . "</td>
      </tr>
      <tr>
       <td colspan=\"4\" width=\"100%\"><i>" . $pedPsychoMotor[$lang][1] . "</i></td>
      </tr>
      <tr>
       <td width=\"25%\"><b>" . $pedPsychoMotor[$lang][2] . "</b></td>
       <td width=\"25%\"><b>" . $pedPsychoMotor[$lang][3] . "</b></td>
       <td width=\"25%\"><b>" . $pedPsychoMotor[$lang][4] . "</b></td>
       <td width=\"25%\"><b>" . $pedPsychoMotor[$lang][5] . "</b></td>
      </tr>
      <tr>
       <td width=\"25%\"><input tabindex=\"4201\" name=\"pedPsychoMotorGross[]\" " . getData ("pedPsychoMotorGross", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedPsychoMotor[$lang][6] . "</td>
       <td width=\"25%\"><input tabindex=\"4203\" name=\"pedPsychoMotorFine[]\" " . getData ("pedPsychoMotorFine", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedPsychoMotor[$lang][6] . "</td>
       <td width=\"25%\"><input tabindex=\"4205\" name=\"pedPsychoMotorLang[]\" " . getData ("pedPsychoMotorLang", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedPsychoMotor[$lang][6] . "</td>
       <td valign=\"top\" width=\"25%\"><input tabindex=\"4207\" name=\"pedPsychoMotorSocial[]\" " . getData ("pedPsychoMotorSocial", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedPsychoMotor[$lang][6] . "</td>
      </tr>
      <tr>
       <td width=\"25%\"><input tabindex=\"4202\" name=\"pedPsychoMotorGross[]\" " . getData ("pedPsychoMotorGross", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedPsychoMotor[$lang][7] . "</td>
       <td width=\"25%\"><input tabindex=\"4204\" name=\"pedPsychoMotorFine[]\" " . getData ("pedPsychoMotorFine", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedPsychoMotor[$lang][7] . "</td>
       <td width=\"25%\"><input tabindex=\"4206\" name=\"pedPsychoMotorLang[]\" " . getData ("pedPsychoMotorLang", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedPsychoMotor[$lang][7] . "</td>
       <td valign=\"top\" width=\"25%\"><input tabindex=\"4208\" name=\"pedPsychoMotorSocial[]\" " . getData ("pedPsychoMotorSocial", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedPsychoMotor[$lang][7] . "</td>
      </tr>
     </table>
    </td>
   </tr>
 </table>
 </div>";

// Physical                    tabstart:4400
echo "
<div id=\"pane3\">
<table class=\"header\">";
$tabIndex = 4400;
include ("include/pedClinicalExam.php");
echo "

<!-- ******************************************************************** -->
<!-- ************************** TB Evaluation *************************** -->
<!-- ******************** (tab indices 4601 - 4800) ********************* -->
<!-- ******************************************************************** -->

   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"4\">" . $pedTbEval[$lang][0] . "</td>
      </tr>
      <tr>
       <td colspan=\"4\"><table><tr><td id=\"tbEvaluationTitle\" ></td><td><b>" . $pedTbEval[$lang][9] . "</b></td></tr></table></td>
      </tr>
      <tr>
       <td colspan=\"2\"><input tabindex=\"4601\" id=\"pedTbEvalRecentExp\" name=\"pedTbEvalRecentExp\" " . getData ("pedTbEvalRecentExp", "checkbox") . " type=\"radio\" value=\"On\">" . $pedTbEval[$lang][10] . "</td>
       <td colspan=\"2\"><input tabindex=\"4603\" id=\"suspicionTBwSymptoms\" name=\"suspicionTBwSymptoms\" " . getData ("suspicionTBwSymptoms", "checkbox") . " type=\"radio\" value=\"On\">" . $pedTbEval[$lang][11] . "</td>
      </tr>
      <tr>
       <td colspan=\"2\"><input tabindex=\"4602\" id=\"presenceBCG\" name=\"presenceBCG\" " . getData ("presenceBCG", "checkbox") . " type=\"radio\" value=\"On\">" . $pedTbEval[$lang][12] . "</td>
       <td colspan=\"2\"><input tabindex=\"4604\" id=\"noTBsymptoms\" name=\"noTBsymptoms\" " . getData ("noTBsymptoms", "checkbox") . " type=\"radio\" value=\"On\">" . $pedTbEval[$lang][13] . "</td>
      </tr>
      <tr>
       <td colspan=\"2\">" . $pedTbEval[$lang][14] . " <input tabindex=\"4605\" name=\"pedTbEvalPpdRecent[]\" " . getData ("pedTbEvalPpdRecent", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input tabindex=\"4606\" name=\"pedTbEvalPpdRecent[]\" " . getData ("pedTbEvalPpdRecent", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input tabindex=\"4607\" name=\"pedTbEvalPpdRecent[]\" " . getData ("pedTbEvalPpdRecent", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</td>
       <td width=\"5%\" id=\"pedTbEvalPpdRecentTitle\"><i>" . $pedTbEval[$lang][15] . "</i> " . $pedTbEval[$lang][16] . " </td><td><input tabindex=\"4608\" id=\"pedTbEvalPpdRecentMm\" name=\"pedTbEvalPpdRecentMm\" " . getData ("pedTbEvalPpdRecentMm", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"4609\" id=\"pedTbEvalPpdRecentYy\" name=\"pedTbEvalPpdRecentYy\" " . getData ("pedTbEvalPpdRecentYy", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"><i>" . $ma[$lang][1] . "</i>&nbsp;&nbsp;&nbsp;&nbsp; " . $pedTbEval[$lang][17] . " <input tabindex=\"4610\" name=\"pedTbEvalPpdRecentRes\" " . getData ("pedTbEvalPpdRecentRes", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">" . $pedTbEval[$lang][18] . "</td>
      </tr>
      <tr>
       <td colspan=\"4\"><i>" . $pedTbEval[$lang][19] . "</i></td>
      </tr>
     </table>
    <td>
   </tr>

<!-- ******************************************************************** -->
<!-- *********************** Current HIV Status ************************- -->
<!-- ******************** (tab indices 4801 - 5000) ********************- -->
<!-- ******************************************************************** -->

   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"4\">" . $pedCurrHiv[$lang][0] . "</td>
      </tr>
      <tr>
       <td valign=\"top\" width=\"25%\"><input tabindex=\"4801\" id=\"pedCurrHiv0\" name=\"pedCurrHiv[]\" " . getData ("pedCurrHiv", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedCurrHiv[$lang][1] . "</td>
       <td width=\"5%\">&nbsp;</td>
       <td colspan=\"2\" width=\"75%\"><input tabindex=\"4804\" id=\"pedCurrHiv3\" name=\"pedCurrHiv[]\" " . getData ("pedCurrHiv", "checkbox", 8) . " type=\"radio\" value=\"8\">" . $pedCurrHiv[$lang][4] . " <i>" . $pedCurrHiv[$lang][5] . "</i></td>
      </tr>
      <tr>
       <td valign=\"top\" width=\"25%\"><input tabindex=\"4802\" id=\"pedCurrHiv1\" name=\"pedCurrHiv[]\" " . getData ("pedCurrHiv", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedCurrHiv[$lang][2] . "</td>
       <td width=\"5%\">&nbsp;</td>
       <td width=\"5%\">&nbsp;</td>
       <td valign=\"top\" width=\"70%\"><input tabindex=\"4805\" id=\"pedCurrHivProb1\" name=\"pedCurrHivProb[]\" " . getData ("pedCurrHivProb", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedCurrHiv[$lang][6] . "</td>
      </tr>
      <tr>
       <td valign=\"top\" width=\"25%\"><input tabindex=\"4803\" id=\"pedCurrHiv2\" name=\"pedCurrHiv[]\" " . getData ("pedCurrHiv", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $pedCurrHiv[$lang][3] . "</td>
       <td width=\"5%\">&nbsp;</td>
       <td width=\"5%\">&nbsp;</td>
       <td valign=\"top\" width=\"70%\"><input tabindex=\"4806\" id=\"pedCurrHivProb2\" name=\"pedCurrHivProb[]\" " . getData ("pedCurrHivProb", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedCurrHiv[$lang][7] . "</td>
      </tr>
      <tr>
       <td colspan=\"4\" width=\"100%\"><i>" . $pedCurrHiv[$lang][8] . "</i></td>
      </tr>
     </table>
    </td>
   </tr>
   </table>
  </div>";

// Conditions                  tabstart:5000
echo "
<div id=\"pane4\">
<table class=\"header\">";
$tabIndex = 5000;
include ("include/pedConditions.php");
echo "
  </table>
</div>";

// Medication Allergies        tabs 6001-6200
echo "
<div id=\"pane5\">
<table class=\"header\">
   <tr>
    <td colspan=\"4\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"9\" width=\"100%\">" . $pedAllergies[$lang][0] . "</td>
      </tr>
      <tr>
       <td colspan=\"9\" width=\"100%\">
         <input tabindex=\"6001\" id=\"pedMedAllergY\" name=\"pedMedAllerg[]\" " . getData ("pedMedAllerg", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input tabindex=\"6002\" id=\"pedMedAllergN\" name=\"pedMedAllerg[]\" " . getData ("pedMedAllerg", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input tabindex=\"6003\" id=\"pedMedAllergU\" name=\"pedMedAllerg[]\" " . getData ("pedMedAllerg", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . " &nbsp; &nbsp; <i>" . $pedAllergies[$lang][1] . "</i></td>
      </tr>
      <tr>
       <td colspan=\"9\" width=\"100%\">
         <input tabindex=\"6005\" class=\"pedMedAllerg\" name=\"pedFoodAllerg\" " . getData ("pedFoodAllerg", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedAllergies[$lang][2] . " <i>" . $pedAllergies[$lang][3] . "</i> <input class=\"pedMedAllerg\" tabindex=\"6005\" name=\"pedFoodAllergText\" " . getData ("pedFoodAllergText", "text") . " type=\"text\" size=\"125\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td colspan=\"9\" width=\"100%\">
         <input tabindex=\"6006\" class=\"pedMedAllerg\" name=\"pedOtherAllerg\" " . getData ("pedOtherAllerg", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedAllergies[$lang][4] . " <i>" . $pedAllergies[$lang][3] . "</i> <input class=\"pedMedAllerg\" tabindex=\"6007\" name=\"aMedOther\" " . getData ("aMedOther", "text") . " type=\"text\" size=\"125\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td width=\"44%\">
         <input tabindex=\"6008\" class=\"pedMedAllerg\" name=\"pedMedAllergMeds\" " . getData ("pedMedAllergMeds", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedAllergies[$lang][5] . " <i>" . $pedAllergies[$lang][3] . "</i></td>
       <td class=\"sm_header_lt\" colspan=\"8\" width=\"56%\">" . $pedAllergies[$lang][7] . "</td>
      </tr>
      <tr>
       <td class=\"sm_header_lt\" width=\"44%\">" . $pedAllergies[$lang][6] . "</td>
       <td class=\"sm_header_cnt\" width=\"5%\">" . $pedAllergies[$lang][8] . "</td>
       <td class=\"sm_header_cnt\" width=\"5%\">" . $pedAllergies[$lang][9] . "</td>
       <td class=\"sm_header_cnt\" width=\"5%\">" . $pedAllergies[$lang][10] . "</td>
       <td class=\"sm_header_cnt\" width=\"5%\">" . $pedAllergies[$lang][11] . "</td>
       <td class=\"sm_header_cnt\" width=\"5%\">" . $pedAllergies[$lang][12] . "</td>
       <td class=\"sm_header_cnt\" width=\"5%\">" . $pedAllergies[$lang][13] . "</td>
       <td width=\"1%\">&nbsp;</td>
       <td class=\"top_pad_cnt\" rowspan=\"4\" width=\"25%\"><b>" . $pedAllergies[$lang][14] . "</b><br><b>" . $pedAllergies[$lang][8] . "</b>" . $pedAllergies[$lang][15] . "<br><b>" . $pedAllergies[$lang][9] . "</b>" . $pedAllergies[$lang][16] . "<br><b>" . $pedAllergies[$lang][10] . "</b>" . $pedAllergies[$lang][17] . "<br><b>" . $pedAllergies[$lang][11] . "</b>" . $pedAllergies[$lang][18] . "<br><b>" . $pedAllergies[$lang][12] . "</b>" . $pedAllergies[$lang][19] . "</td>
      </tr>
";

$tabIndex = 6100;
for ($i = 1; $i <= $max_allergies; $i++) {
  echo "
      <tr>
       <td><input class=\"pedMedAllerg\" tabindex=\"" . ($tabIndex + 1) . "\" name=\"aMed$i\" " . getData ("aMed" . $i, "text") . " type=\"text\" size=\"70\" maxlength=\"255\"></td>
       <td align=\"center\">
         <input class=\"pedMedAllerg\" tabindex=\"" . ($tabIndex + 6) . "\" name=\"aMed" . $i . "Rash\" " . getData ("aMed" . $i . "Rash", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input class=\"pedMedAllerg\" tabindex=\"" . ($tabIndex + 7) . "\" name=\"aMed" . $i . "RashF\" " . getData ("aMed" . $i . "RashF", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input class=\"pedMedAllerg\" tabindex=\"" . ($tabIndex + 9) . "\" name=\"aMed" . $i . "Hives\" " . getData ("aMed" . $i . "Hives", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input class=\"pedMedAllerg\" tabindex=\"" . ($tabIndex + 10) . "\" name=\"aMed" . $i . "SJ\" " . getData ("aMed" . $i . "SJ", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input class=\"pedMedAllerg\" tabindex=\"" . ($tabIndex + 11) . "\" name=\"aMed" . $i . "Anaph\" " . getData ("aMed" . $i . "Anaph", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input class=\"pedMedAllerg\" tabindex=\"" . ($tabIndex + 12) . "\" name=\"aMed" . $i . "Other\" " . getData ("aMed" . $i . "Other", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"vert_line\" rowspan=\"3\" width=\"1%\">&nbsp;</td>
      </tr>";
  $tabIndex += 12;
}

echo "
     </table>
    </td>
   </tr>
  </table>
</div>";



// grossesse et allaitement
	echo " 
	<div id=\"pane5\">
    <table class=\"header\">
	<tr>
       <td class=\"s_header\" colspan=\"10\">" . $GrossessAllaitement[$lang][0] . "</td>
      </tr> 
	<tr>       
       <td> ".$GrossessAllaitement[$lang][1]."
	        <input  tabindex=\"5519\" id=\"grossesseOuiNon1\" name=\"grossesseOuiNon[]\" " . getData ("grossesseOuiNon", "radio", 1) . " type=\"radio\" value=\"1\" />Oui
			<input  tabindex=\"5520\" id=\"grossesseOuiNon2\" name=\"grossesseOuiNon[]\" " . getData ("grossesseOuiNon", "radio", 2) . " type=\"radio\" value=\"2\" />Non<br /> <span style=\"white-space: nowrap;\">
        </td>
		<td> ".$GrossessAllaitement[$lang][3]."
	        <input  tabindex=\"5517\" id=\"grossesseStartDate\" name=\"grossesseStartDate\"  type=\"date\" value=\"" . getData ("grossesseStartDate", "textarea", 0) . "\" />			
        </td>
		<td> ".$GrossessAllaitement[$lang][4]."
	        <input  tabindex=\"5518\" id=\"grossesseEndDate\" name=\"grossesseEndDate\"  type=\"date\" value=\"" . getData ("grossesseEndDate", "textarea", 0) . "\" />
        </td>
      </tr>  
	  <tr>       
       <td> ".$GrossessAllaitement[$lang][2]."
	        <input  tabindex=\"5521\" id=\"allaitementOuiNon1\" name=\"allaitementOuiNon[]\" " . getData ("allaitementOuiNon", "radio", 1) . " type=\"radio\" value=\"1\" />Oui
			<input  tabindex=\"5522\" id=\"allaitementOuiNon2\" name=\"allaitementOuiNon[]\" " . getData ("allaitementOuiNon", "radio", 2) . " type=\"radio\" value=\"2\" />Non<br /> <span style=\"white-space: nowrap;\">
        </td>
		<td> ".$GrossessAllaitement[$lang][3]."
	        <input  tabindex=\"5523\" id=\"allaitementStartDate\" name=\"allaitementStartDate\"  type=\"date\" value=\"" . getData ("allaitementStartDate", "textarea", 0) . "\" />			
        </td>
		<td> ".$GrossessAllaitement[$lang][4]."
	        <input  tabindex=\"5524\" id=\"allaitementEndDate\" name=\"allaitementEndDate\"  type=\"date\" value=\"" . getData ("allaitementEndDate", "textarea", 0) . "\" />
        </td>
      </tr> 
	  </table>
</div>";





// Treatments                  tabstart:6201
echo "
<div id=\"pane6\">
<table class=\"header\">";
$ped_arv_rows = pedArvRows (6203, 1);
include ("include/pedArvs.php");
echo "
  </table>
</div>";



 echo "
<div id=\"pane7\">
  <table class=\"header\">";
$tabIndex = 30000;
      echo "<tr>
       <td class=\"s_header\" colspan=\"10\"> Surveillance du traitement TB </td>
      </tr> 
      <tr>
       <td>
<table class=\"b_header_nb\" border=\"1\">
<thead>
  <tr>
    <th rowspan=\"3\">Mois</th>
    <th colspan=\"6\">Résultats de l’examen d’expectoration</th>
    <th rowspan=\"3\">poids</th>
  </tr>
  <tr>
    <th rowspan=\"2\">Date</th>
    <th rowspan=\"2\">Bacilloscopie</th>
    <th colspan=\"2\">GeneXpert</th>
    <th rowspan=\"2\">Culture</th>
    <th rowspan=\"2\">DST</th>
  </tr>
  <tr>
    <th>BK</td>
    <th>RIF</td>
  </tr>
</thead>
<tbody>
  <tr class=\"alt\">
    <td>0</td>
    <td><input  tabindex=\"5523\" id=\"surveillanceTbDatemois0\" name=\"surveillanceTbDatemois0\"  type=\"date\" value=\"" . getData ("surveillanceTbDatemois0", "textarea", 0) . "\" /></td>
    <td> <input tabindex=\"110018\" id=\"bacilloscopiemois00\" name=\"bacilloscopiemois0[]\" " . getData("bacilloscopiemois0", "radio", 1) . " type=\"radio\" value=\"1\">Negatif
         <input tabindex=\"110019\" id=\"bacilloscopiemois01\" name=\"bacilloscopiemois0[]\" " . getData ("bacilloscopiemois0", "radio", 2) . " type=\"radio\" value=\"2\">Positif+<br/>
         <input tabindex=\"110020\" id=\"bacilloscopiemois02\" name=\"bacilloscopiemois0[]\" " . getData ("bacilloscopiemois0", "radio", 4) . " type=\"radio\" value=\"4\">Positif++
		 <input tabindex=\"110021\" id=\"bacilloscopiemois03\" name=\"bacilloscopiemois0[]\" " . getData ("bacilloscopiemois0", "radio", 8) . " type=\"radio\" value=\"8\">Positif+++
       <br /></td>
    <td><input tabindex=\"11005\" id=\"geneXpertBkmois00\" name=\"geneXpertBkmois0[]\" " . getData("geneXpertBkmois0", "radio", 1) . " type=\"radio\" value=\"1\">Positif
         <input tabindex=\"11006\" id=\"geneXpertBkmois01\" name=\"geneXpertBkmois0[]\" " . getData ("geneXpertBkmois0", "radio", 2) . " type=\"radio\" value=\"2\">Negatif<br/>
         <input tabindex=\"11007\" id=\"geneXpertBkmois02\" name=\"geneXpertBkmois0[]\" " . getData ("geneXpertBkmois0", "radio", 4) . " type=\"radio\" value=\"4\">Indetermine
       <br/></td>
    <td><input tabindex=\"11008\" id=\"geneXpertRifmois00\" name=\"geneXpertRifmois0[]\" " . getData("geneXpertRifmois0", "radio", 1) . " type=\"radio\" value=\"1\">Sensible
         <input tabindex=\"11009\" id=\"geneXpertRifmois01\" name=\"geneXpertRifmois0[]\" " . getData ("geneXpertRifmois0", "radio", 2) . " type=\"radio\" value=\"2\">Resistant
       <br /></td>
    <td><input tabindex=\"110010\" id=\"culturemois00\" name=\"culturemois0[]\" " . getData("culturemois0", "radio", 1) . " type=\"radio\" value=\"1\">Positif pour MTB
         <input tabindex=\"110011\" id=\"culturemois01\" name=\"culturemois0[]\" " . getData ("culturemois0", "radio", 2) . " type=\"radio\" value=\"2\">Positif pour Non MTB<br/>
         <input tabindex=\"110012\" id=\"culturemois02\" name=\"culturemois0[]\" " . getData ("culturemois0", "radio", 4) . " type=\"radio\" value=\"4\">Negatif
		 <input tabindex=\"110013\" id=\"culturemois03\" name=\"culturemois0[]\" " . getData ("culturemois0", "radio", 8) . " type=\"radio\" value=\"8\">Contaminee
       <br /></td>
    <td><input tabindex=\"110014\" id=\"dstmois00\" name=\"dstmois0[]\" " . getData("dstmois0", "radio", 1) . " type=\"radio\" value=\"1\">Sensible à la rifampicine<br/>
         <input tabindex=\"110015\" id=\"dstmois01\" name=\"dstmois0[]\" " . getData ("dstmois0", "radio", 2) . " type=\"radio\" value=\"2\">Résistant à la Rifampicine
         <input tabindex=\"110016\" id=\"dstmois02\" name=\"dstmois0[]\" " . getData ("dstmois0", "radio", 4) . " type=\"radio\" value=\"4\">Indéterminé
       <br /></td>
    <td><input  tabindex=\"110017\" id=\"poidsmois0\" name=\"poidsmois0\" " . getData ("poidsmois0", "text") . " type=\"text\" size=\"10\"></td>
  </tr>
  <tr>
    <td>1</td>
    <td><input  tabindex=\"5524\" id=\"surveillanceTbDatemois1\" name=\"surveillanceTbDatemois1\"  type=\"date\" value=\"" . getData ("surveillanceTbDatemois1", "textarea", 0) . "\" /></td>
    <td> <input tabindex=\"110022\" id=\"bacilloscopiemois10\" name=\"bacilloscopiemois1[]\" " . getData("bacilloscopiemois1", "radio", 1) . " type=\"radio\" value=\"1\">Negatif
         <input tabindex=\"110023\" id=\"bacilloscopiemois11\" name=\"bacilloscopiemois1[]\" " . getData ("bacilloscopiemois1", "radio", 2) . " type=\"radio\" value=\"2\">Positif+<br/>
         <input tabindex=\"110024\" id=\"bacilloscopiemois12\" name=\"bacilloscopiemois1[]\" " . getData ("bacilloscopiemois1", "radio", 4) . " type=\"radio\" value=\"4\">Positif++
		 <input tabindex=\"110025\" id=\"bacilloscopiemois13\" name=\"bacilloscopiemois1[]\" " . getData ("bacilloscopiemois1", "radio", 8) . " type=\"radio\" value=\"8\">Positif+++
       <br /></td>
    <td><input tabindex=\"110026\" id=\"geneXpertBkmois10\" name=\"geneXpertBkmois1[]\" " . getData("geneXpertBkmois1", "radio", 1) . " type=\"radio\" value=\"1\">Positif
         <input tabindex=\"110027\" id=\"geneXpertBkmois11\" name=\"geneXpertBkmois1[]\" " . getData ("geneXpertBkmois1", "radio", 2) . " type=\"radio\" value=\"2\">Negatif<br/>
         <input tabindex=\"110028\" id=\"geneXpertBkmois12\" name=\"geneXpertBkmois1[]\" " . getData ("geneXpertBkmois1", "radio", 4) . " type=\"radio\" value=\"4\">Indetermine
       <br/></td>
    <td><input tabindex=\"110029\" id=\"geneXpertRifmois10\" name=\"geneXpertRifmois1[]\" " . getData("geneXpertRifmois1", "radio", 1) . " type=\"radio\" value=\"1\">Sensible
         <input tabindex=\"110030\" id=\"geneXpertRifmois11\" name=\"geneXpertRifmois1[]\" " . getData ("geneXpertRifmois1", "radio", 2) . " type=\"radio\" value=\"2\">Resistant
       <br /></td>
    <td><input tabindex=\"110031\" id=\"culturemois10\" name=\"culturemois1[]\" " . getData("culturemois1", "radio", 1) . " type=\"radio\" value=\"1\">Positif pour MTB
         <input tabindex=\"110032\" id=\"culturemois11\" name=\"culturemois1[]\" " . getData ("culturemois1", "radio", 2) . " type=\"radio\" value=\"2\">Positif pour Non MTB<br/>
         <input tabindex=\"110033\" id=\"culturemois12\" name=\"culturemois1[]\" " . getData ("culturemois1", "radio", 4) . " type=\"radio\" value=\"4\">Negatif
		 <input tabindex=\"110034\" id=\"culturemois13\" name=\"culturemois1[]\" " . getData ("culturemois1", "radio", 8) . " type=\"radio\" value=\"8\">Contaminee
       <br /></td>
    <td><input tabindex=\"110035\" id=\"dstmois10\" name=\"dstmois1[]\" " . getData("dstmois1", "radio", 1) . " type=\"radio\" value=\"1\">Sensible à la rifampicine<br/>
         <input tabindex=\"110036\" id=\"dstmois11\" name=\"dstmois1[]\" " . getData ("dstmois1", "radio", 2) . " type=\"radio\" value=\"2\">Résistant à la Rifampicine
         <input tabindex=\"110037\" id=\"dstmois12\" name=\"dstmois1[]\" " . getData ("dstmois1", "radio", 4) . " type=\"radio\" value=\"4\">Indéterminé
       <br /></td>
    <td><input  tabindex=\"110038\" name=\"poidsmois1\" " . getData ("poidsmois1", "text") . " type=\"text\" size=\"10\"></td>
  </tr>
  <tr class=\"alt\">
    <td>2</td>
    <td><input  tabindex=\"5525\" id=\"surveillanceTbDatemois2\" name=\"surveillanceTbDatemois2\"  type=\"date\" value=\"" . getData ("surveillanceTbDatemois2", "textarea", 0) . "\" /></td>
    <td> <input tabindex=\"110039\" id=\"bacilloscopiemois20\" name=\"bacilloscopiemois2[]\" " . getData("bacilloscopiemois2", "radio", 1) . " type=\"radio\" value=\"1\">Negatif
         <input tabindex=\"110040\" id=\"bacilloscopiemois21\" name=\"bacilloscopiemois2[]\" " . getData ("bacilloscopiemois2", "radio", 2) . " type=\"radio\" value=\"2\">Positif+<br/>
         <input tabindex=\"110041\" id=\"bacilloscopiemois22\" name=\"bacilloscopiemois2[]\" " . getData ("bacilloscopiemois2", "radio", 4) . " type=\"radio\" value=\"4\">Positif++
		 <input tabindex=\"110042\" id=\"bacilloscopiemois23\" name=\"bacilloscopiemois2[]\" " . getData ("bacilloscopiemois2", "radio", 8) . " type=\"radio\" value=\"8\">Positif+++
       <br /></td>
    <td><input tabindex=\"110043\" id=\"geneXpertBkmois20\" name=\"geneXpertBkmois2[]\" " . getData("geneXpertBkmois2", "radio", 1) . " type=\"radio\" value=\"1\">Positif
         <input tabindex=\"110044\" id=\"geneXpertBkmois21\" name=\"geneXpertBkmois2[]\" " . getData ("geneXpertBkmois2", "radio", 2) . " type=\"radio\" value=\"2\">Negatif<br/>
         <input tabindex=\"110045\" id=\"geneXpertBkmois22\" name=\"geneXpertBkmois2[]\" " . getData ("geneXpertBkmois2", "radio", 4) . " type=\"radio\" value=\"4\">Indetermine
       <br/></td>
    <td><input tabindex=\"110046\" id=\"geneXpertRifmois20\" name=\"geneXpertRifmois2[]\" " . getData("geneXpertRifmois2", "radio", 1) . " type=\"radio\" value=\"1\">Sensible
         <input tabindex=\"110047\" id=\"geneXpertRifmois21\" name=\"geneXpertRifmois2[]\" " . getData ("geneXpertRifmois2", "radio", 2) . " type=\"radio\" value=\"2\">Resistant
       <br /></td>
    <td><input tabindex=\"110048\" id=\"culturemois20\" name=\"culturemois2[]\" " . getData("culturemois2", "radio", 1) . " type=\"radio\" value=\"1\">Positif pour MTB
         <input tabindex=\"110049\" id=\"culturemois21\" name=\"culturemois2[]\" " . getData ("culturemois2", "radio", 2) . " type=\"radio\" value=\"2\">Positif pour Non MTB<br/>
         <input tabindex=\"110050\" id=\"culturemois22\" name=\"culturemois2[]\" " . getData ("culturemois2", "radio", 4) . " type=\"radio\" value=\"4\">Negatif
		 <input tabindex=\"110051\" id=\"culturemois23\" name=\"culturemois2[]\" " . getData ("culturemois2", "radio", 8) . " type=\"radio\" value=\"8\">Contaminee
       <br /></td>
    <td><input tabindex=\"110052\" id=\"dstmois20\" name=\"dstmois2[]\" " . getData("dstmois2", "radio", 1) . " type=\"radio\" value=\"1\">Sensible à la rifampicine<br/>
         <input tabindex=\"110053\" id=\"dstmois21\" name=\"dstmois2[]\" " . getData ("dstmois2", "radio", 2) . " type=\"radio\" value=\"2\">Résistant à la Rifampicine
         <input tabindex=\"110054\" id=\"dstmois22\" name=\"dstmois2[]\" " . getData ("dstmois2", "radio", 4) . " type=\"radio\" value=\"4\">Indéterminé
       <br /></td>
    <td><input  tabindex=\"110055\" name=\"poidsmois2\" " . getData ("poidsmois2", "text") . " type=\"text\" size=\"10\"></td>
  </tr>
  <tr>
    <td>3</td>
    <td><input  tabindex=\"5526\" id=\"surveillanceTbDatemois3\" name=\"surveillanceTbDatemois3\"  type=\"date\" value=\"" . getData ("surveillanceTbDatemois3", "textarea", 0) . "\" /></td>
    <td> <input tabindex=\"110056\" id=\"bacilloscopiemois30\" name=\"bacilloscopiemois3[]\" " . getData("bacilloscopiemois3", "radio", 1) . " type=\"radio\" value=\"1\">Negatif
         <input tabindex=\"110057\" id=\"bacilloscopiemois31\" name=\"bacilloscopiemois3[]\" " . getData ("bacilloscopiemois3", "radio", 2) . " type=\"radio\" value=\"2\">Positif+<br/>
         <input tabindex=\"110058\" id=\"bacilloscopiemois32\" name=\"bacilloscopiemois3[]\" " . getData ("bacilloscopiemois3", "radio", 4) . " type=\"radio\" value=\"4\">Positif++
		 <input tabindex=\"110059\" id=\"bacilloscopiemois33\" name=\"bacilloscopiemois3[]\" " . getData ("bacilloscopiemois3", "radio", 8) . " type=\"radio\" value=\"8\">Positif+++
       <br /></td>
    <td><input tabindex=\"110060\" id=\"geneXpertBkmois30\" name=\"geneXpertBkmois3[]\" " . getData("geneXpertBkmois3", "radio", 1) . " type=\"radio\" value=\"1\">Positif
         <input tabindex=\"110061\" id=\"geneXpertBkmois31\" name=\"geneXpertBkmois3[]\" " . getData ("geneXpertBkmois3", "radio", 2) . " type=\"radio\" value=\"2\">Negatif<br/>
         <input tabindex=\"110062\" id=\"geneXpertBkmois32\" name=\"geneXpertBkmois3[]\" " . getData ("geneXpertBkmois3", "radio", 4) . " type=\"radio\" value=\"4\">Indetermine
       <br/></td>
    <td><input tabindex=\"110063\" id=\"geneXpertRifmois30\" name=\"geneXpertRifmois3[]\" " . getData("geneXpertRifmois3", "radio", 1) . " type=\"radio\" value=\"1\">Sensible
         <input tabindex=\"110064\" id=\"geneXpertRifmois31\" name=\"geneXpertRifmois3[]\" " . getData ("geneXpertRifmois3", "radio", 2) . " type=\"radio\" value=\"2\">Resistant
       <br /></td>
    <td><input tabindex=\"110065\" id=\"culturemois30\" name=\"culturemois3[]\" " . getData("culturemois3", "radio", 1) . " type=\"radio\" value=\"1\">Positif pour MTB
         <input tabindex=\"110066\" id=\"culturemois31\" name=\"culturemois3[]\" " . getData ("culturemois3", "radio", 2) . " type=\"radio\" value=\"2\">Positif pour Non MTB<br/>
         <input tabindex=\"110067\" id=\"culturemois32\" name=\"culturemois3[]\" " . getData ("culturemois3", "radio", 4) . " type=\"radio\" value=\"4\">Negatif
		 <input tabindex=\"110068\" id=\"culturemois33\" name=\"culturemois3[]\" " . getData ("culturemois3", "radio", 8) . " type=\"radio\" value=\"8\">Contaminee
       <br /></td>
    <td><input tabindex=\"110069\" id=\"dstmois30\" name=\"dstmois3[]\" " . getData("dstmois3", "radio", 1) . " type=\"radio\" value=\"1\">Sensible à la rifampicine<br/>
         <input tabindex=\"110070\" id=\"dstmois31\" name=\"dstmois3[]\" " . getData ("dstmois3", "radio", 2) . " type=\"radio\" value=\"2\">Résistant à la Rifampicine
         <input tabindex=\"110071\" id=\"dstmois32\" name=\"dstmois3[]\" " . getData ("dstmois3", "radio", 4) . " type=\"radio\" value=\"4\">Indéterminé
       <br /></td>
    <td><input  tabindex=\"110072\" name=\"poidsmois3\" " . getData ("poidsmois3", "text") . " type=\"text\" size=\"10\"></td>
  </tr>
  <tr class=\"alt\">
    <td>4</td>
    <td><input  tabindex=\"5527\" id=\"surveillanceTbDatemois4\" name=\"surveillanceTbDatemois4\"  type=\"date\" value=\"" . getData ("surveillanceTbDatemois4", "textarea", 0) . "\" /></td>
    <td> <input tabindex=\"110073\" id=\"bacilloscopiemois40\" name=\"bacilloscopiemois4[]\" " . getData("bacilloscopiemois4", "radio", 1) . " type=\"radio\" value=\"1\">Negatif
         <input tabindex=\"110074\" id=\"bacilloscopiemois41\" name=\"bacilloscopiemois4[]\" " . getData ("bacilloscopiemois4", "radio", 2) . " type=\"radio\" value=\"2\">Positif+<br/>
         <input tabindex=\"110075\" id=\"bacilloscopiemois42\" name=\"bacilloscopiemois4[]\" " . getData ("bacilloscopiemois4", "radio", 4) . " type=\"radio\" value=\"4\">Positif++
		 <input tabindex=\"110076\" id=\"bacilloscopiemois43\" name=\"bacilloscopiemois4[]\" " . getData ("bacilloscopiemois4", "radio", 8) . " type=\"radio\" value=\"8\">Positif+++
       <br /></td>
    <td><input tabindex=\"110077\" id=\"geneXpertBkmois40\" name=\"geneXpertBkmois4[]\" " . getData("geneXpertBkmois4", "radio", 1) . " type=\"radio\" value=\"1\">Positif
         <input tabindex=\"110078\" id=\"geneXpertBkmois41\" name=\"geneXpertBkmois4[]\" " . getData ("geneXpertBkmois4", "radio", 2) . " type=\"radio\" value=\"2\">Negatif<br/>
         <input tabindex=\"110079\" id=\"geneXpertBkmois42\" name=\"geneXpertBkmois4[]\" " . getData ("geneXpertBkmois4", "radio", 4) . " type=\"radio\" value=\"4\">Indetermine
       <br/></td>
    <td><input tabindex=\"110080\" id=\"geneXpertRifmois40\" name=\"geneXpertRifmois4[]\" " . getData("geneXpertRifmois4", "radio", 1) . " type=\"radio\" value=\"1\">Sensible
         <input tabindex=\"110081\" id=\"geneXpertRifmois41\" name=\"geneXpertRifmois4[]\" " . getData ("geneXpertRifmois4", "radio", 2) . " type=\"radio\" value=\"2\">Resistant
       <br /></td>
    <td><input tabindex=\"110082\" id=\"culturemois40\" name=\"culturemois4[]\" " . getData("culturemois4", "radio", 1) . " type=\"radio\" value=\"1\">Positif pour MTB
         <input tabindex=\"110083\" id=\"culturemois41\" name=\"culturemois4[]\" " . getData ("culturemois4", "radio", 2) . " type=\"radio\" value=\"2\">Positif pour Non MTB<br/>
         <input tabindex=\"110084\" id=\"culturemois42\" name=\"culturemois4[]\" " . getData ("culturemois4", "radio", 4) . " type=\"radio\" value=\"4\">Negatif
		 <input tabindex=\"110085\" id=\"culturemois43\" name=\"culturemois4[]\" " . getData ("culturemois4", "radio", 8) . " type=\"radio\" value=\"8\">Contaminee
       <br /></td>
    <td><input tabindex=\"110086\" id=\"dstmois40\" name=\"dstmois4[]\" " . getData("dstmois4", "radio", 1) . " type=\"radio\" value=\"1\">Sensible à la rifampicine<br/>
         <input tabindex=\"110087\" id=\"dstmois41\" name=\"dstmois4[]\" " . getData ("dstmois4", "radio", 2) . " type=\"radio\" value=\"2\">Résistant à la Rifampicine
         <input tabindex=\"110088\" id=\"dstmois42\" name=\"dstmois4[]\" " . getData ("dstmois4", "radio", 4) . " type=\"radio\" value=\"4\">Indéterminé
       <br /></td>
    <td><input  tabindex=\"110089\" name=\"poidsmois4\" " . getData ("poidsmois4", "text") . " type=\"text\" size=\"10\"></td>
  </tr>
  <tr>
    <td>5</td>
    <td><input  tabindex=\"5528\" id=\"surveillanceTbDatemois5\" name=\"surveillanceTbDatemois5\"  type=\"date\" value=\"" . getData ("surveillanceTbDatemois5", "textarea", 0) . "\" /></td>
    <td> <input tabindex=\"110090\" id=\"bacilloscopiemois50\" name=\"bacilloscopiemois5[]\" " . getData("bacilloscopiemois5", "radio", 1) . " type=\"radio\" value=\"1\">Negatif
         <input tabindex=\"110091\" id=\"bacilloscopiemois51\" name=\"bacilloscopiemois5[]\" " . getData ("bacilloscopiemois5", "radio", 2) . " type=\"radio\" value=\"2\">Positif+<br/>
         <input tabindex=\"110092\" id=\"bacilloscopiemois52\" name=\"bacilloscopiemois5[]\" " . getData ("bacilloscopiemois5", "radio", 4) . " type=\"radio\" value=\"4\">Positif++
		 <input tabindex=\"110093\" id=\"bacilloscopiemois53\" name=\"bacilloscopiemois5[]\" " . getData ("bacilloscopiemois5", "radio", 8) . " type=\"radio\" value=\"8\">Positif+++
       <br /></td>
    <td><input tabindex=\"110094\" id=\"geneXpertBkmois50\" name=\"geneXpertBkmois5[]\" " . getData("geneXpertBkmois5", "radio", 1) . " type=\"radio\" value=\"1\">Positif
         <input tabindex=\"110095\" id=\"geneXpertBkmois51\" name=\"geneXpertBkmois5[]\" " . getData ("geneXpertBkmois5", "radio", 2) . " type=\"radio\" value=\"2\">Negatif<br/>
         <input tabindex=\"110096\" id=\"geneXpertBkmois52\" name=\"geneXpertBkmois5[]\" " . getData ("geneXpertBkmois5", "radio", 4) . " type=\"radio\" value=\"4\">Indetermine
       <br/></td>
    <td><input tabindex=\"110097\" id=\"geneXpertRifmois50\" name=\"geneXpertRifmois5[]\" " . getData("geneXpertRifmois5", "radio", 1) . " type=\"radio\" value=\"1\">Sensible
         <input tabindex=\"110098\" id=\"geneXpertRifmois51\" name=\"geneXpertRifmois5[]\" " . getData ("geneXpertRifmois5", "radio", 2) . " type=\"radio\" value=\"2\">Resistant
       <br /></td>
    <td><input tabindex=\"110099\" id=\"culturemois50\" name=\"culturemois5[]\" " . getData("culturemois5", "radio", 1) . " type=\"radio\" value=\"1\">Positif pour MTB
         <input tabindex=\"1100100\" id=\"culturemois51\" name=\"culturemois5[]\" " . getData ("culturemois5", "radio", 2) . " type=\"radio\" value=\"2\">Positif pour Non MTB<br/>
         <input tabindex=\"1100101\" id=\"culturemois52\" name=\"culturemois5[]\" " . getData ("culturemois5", "radio", 4) . " type=\"radio\" value=\"4\">Negatif
		 <input tabindex=\"1100102\" id=\"culturemois53\" name=\"culturemois5[]\" " . getData ("culturemois5", "radio", 8) . " type=\"radio\" value=\"8\">Contaminee
       <br /></td>
    <td><input tabindex=\"1100103\" id=\"dstmois50\" name=\"dstmois5[]\" " . getData("dstmois5", "radio", 1) . " type=\"radio\" value=\"1\">Sensible à la rifampicine<br/>
         <input tabindex=\"1100104\" id=\"dstmois51\" name=\"dstmois5[]\" " . getData ("dstmois5", "radio", 2) . " type=\"radio\" value=\"2\">Résistant à la Rifampicine
         <input tabindex=\"1100105\" id=\"dstmois52\" name=\"dstmois5[]\" " . getData ("dstmois5", "radio", 4) . " type=\"radio\" value=\"4\">Indéterminé
       <br /></td>
    <td><input  tabindex=\"1100106\" name=\"poidsmois5\" " . getData ("poidsmois5", "text") . " type=\"text\" size=\"10\"></td>
  </tr>
  <tr class=\"alt\">
    <td>6</td>
    <td><input  tabindex=\"5523\" id=\"surveillanceTbDatemois6\" name=\"surveillanceTbDatemois6\"  type=\"date\" value=\"" . getData ("surveillanceTbDatemois6", "textarea", 0) . "\" /></td>
    <td> <input tabindex=\"1100107\" id=\"bacilloscopiemois60\" name=\"bacilloscopiemois6[]\" " . getData("bacilloscopiemois6", "radio", 1) . " type=\"radio\" value=\"1\">Negatif
         <input tabindex=\"1100108\" id=\"bacilloscopiemois61\" name=\"bacilloscopiemois6[]\" " . getData ("bacilloscopiemois6", "radio", 2) . " type=\"radio\" value=\"2\">Positif+<br/>
         <input tabindex=\"1100109\" id=\"bacilloscopiemois62\" name=\"bacilloscopiemois6[]\" " . getData ("bacilloscopiemois6", "radio", 4) . " type=\"radio\" value=\"4\">Positif++
		 <input tabindex=\"1100110\" id=\"bacilloscopiemois63\" name=\"bacilloscopiemois6[]\" " . getData ("bacilloscopiemois6", "radio", 8) . " type=\"radio\" value=\"8\">Positif+++
       <br /></td>
    <td><input tabindex=\"1100111\" id=\"geneXpertBkmois60\" name=\"geneXpertBkmois6[]\" " . getData("geneXpertBkmois6", "radio", 1) . " type=\"radio\" value=\"1\">Positif
         <input tabindex=\"1100112\" id=\"geneXpertBkmois61\" name=\"geneXpertBkmois6[]\" " . getData ("geneXpertBkmois6", "radio", 2) . " type=\"radio\" value=\"2\">Negatif<br/>
         <input tabindex=\"1100113\" id=\"geneXpertBkmois62\" name=\"geneXpertBkmois6[]\" " . getData ("geneXpertBkmois6", "radio", 4) . " type=\"radio\" value=\"4\">Indetermine
       <br/></td>
    <td><input tabindex=\"1100114\" id=\"geneXpertRifmois60\" name=\"geneXpertRifmois6[]\" " . getData("geneXpertRifmois6", "radio", 1) . " type=\"radio\" value=\"1\">Sensible
         <input tabindex=\"1100115\" id=\"geneXpertRifmois61\" name=\"geneXpertRifmois6[]\" " . getData ("geneXpertRifmois6", "radio", 2) . " type=\"radio\" value=\"2\">Resistant
       <br /></td>
    <td><input tabindex=\"1100116\" id=\"culturemois60\" name=\"culturemois6[]\" " . getData("culturemois6", "radio", 1) . " type=\"radio\" value=\"1\">Positif pour MTB
         <input tabindex=\"1100117\" id=\"culturemois61\" name=\"culturemois6[]\" " . getData ("culturemois6", "radio", 2) . " type=\"radio\" value=\"2\">Positif pour Non MTB<br/>
         <input tabindex=\"1100118\" id=\"culturemois62\" name=\"culturemois6[]\" " . getData ("culturemois6", "radio", 4) . " type=\"radio\" value=\"4\">Negatif
		 <input tabindex=\"1100119\" id=\"culturemois63\" name=\"culturemois6[]\" " . getData ("culturemois6", "radio", 8) . " type=\"radio\" value=\"8\">Contaminee
       <br /></td>
    <td><input tabindex=\"1100120\" id=\"dstmois60\" name=\"dstmois6[]\" " . getData("dstmois6", "radio", 1) . " type=\"radio\" value=\"1\">Sensible à la rifampicine<br/>
         <input tabindex=\"1100121\" id=\"dstmois61\" name=\"dstmois6[]\" " . getData ("dstmois6", "radio", 2) . " type=\"radio\" value=\"2\">Résistant à la Rifampicine
         <input tabindex=\"1100122\" id=\"dstmois62\" name=\"dstmois6[]\" " . getData ("dstmois6", "radio", 4) . " type=\"radio\" value=\"4\">Indéterminé
       <br /></td>
    <td><input  tabindex=\"1100123\" name=\"poidsmois6\" " . getData ("poidsmois6", "text") . " type=\"text\" size=\"10\"></td>
  </tr>
  <tr>
    <td>fin TX</td>
    <td><input  tabindex=\"5529\" id=\"surveillanceTbDateFinTx\" name=\"surveillanceTbDateFinTx\"  type=\"date\" value=\"" . getData ("surveillanceTbDateFinTx", "textarea", 0) . "\" /></td>
    <td> <input tabindex=\"1100123\" id=\"bacilloscopieFinTx0\" name=\"bacilloscopieFinTx[]\" " . getData("bacilloscopieFinTx", "radio", 1) . " type=\"radio\" value=\"1\">Negatif
         <input tabindex=\"1100124\" id=\"bacilloscopieFinTx1\" name=\"bacilloscopieFinTx[]\" " . getData ("bacilloscopieFinTx", "radio", 2) . " type=\"radio\" value=\"2\">Positif+<br/>
         <input tabindex=\"1100125\" id=\"bacilloscopieFinTx2\" name=\"bacilloscopieFinTx[]\" " . getData ("bacilloscopieFinTx", "radio", 4) . " type=\"radio\" value=\"4\">Positif++
		 <input tabindex=\"1100126\" id=\"bacilloscopieFinTx3\" name=\"bacilloscopieFinTx[]\" " . getData ("bacilloscopieFinTx", "radio", 8) . " type=\"radio\" value=\"8\">Positif+++
       <br /></td>
    <td><input tabindex=\"1100127\" id=\"geneXpertBkFinTx0\" name=\"geneXpertBkFinTx[]\" " . getData("geneXpertBkFinTx", "radio", 1) . " type=\"radio\" value=\"1\">Positif
         <input tabindex=\"1100128\" id=\"geneXpertBkFinTx1\" name=\"geneXpertBkFinTx[]\" " . getData ("geneXpertBkFinTx", "radio", 2) . " type=\"radio\" value=\"2\">Negatif<br/>
         <input tabindex=\"1100129\" id=\"geneXpertBkFinTx2\" name=\"geneXpertBkFinTx[]\" " . getData ("geneXpertBkFinTx", "radio", 4) . " type=\"radio\" value=\"4\">Indetermine
       <br/></td>
    <td><input tabindex=\"1100130\" id=\"geneXpertRifFinTx0\" name=\"geneXpertRifFinTx[]\" " . getData("geneXpertRifFinTx", "radio", 1) . " type=\"radio\" value=\"1\">Sensible
         <input tabindex=\"1100131\" id=\"geneXpertRifFinTx1\" name=\"geneXpertRifFinTx[]\" " . getData ("geneXpertRifFinTx", "radio", 2) . " type=\"radio\" value=\"2\">Resistant
       <br /></td>
    <td><input tabindex=\"1100132\" id=\"cultureFinTx0\" name=\"cultureFinTx[]\" " . getData("cultureFinTx", "radio", 1) . " type=\"radio\" value=\"1\">Positif pour MTB
         <input tabindex=\"1100133\" id=\"cultureFinTx1\" name=\"cultureFinTx[]\" " . getData ("cultureFinTx", "radio", 2) . " type=\"radio\" value=\"2\">Positif pour Non MTB<br/>
         <input tabindex=\"1100134\" id=\"cultureFinTx2\" name=\"cultureFinTx[]\" " . getData ("cultureFinTx", "radio", 4) . " type=\"radio\" value=\"4\">Negatif
		 <input tabindex=\"1100135\" id=\"cultureFinTx3\" name=\"cultureFinTx[]\" " . getData ("cultureFinTx", "radio", 8) . " type=\"radio\" value=\"8\">Contaminee
       <br /></td>
    <td><input tabindex=\"1100136\" id=\"dstFinTx0\" name=\"dstFinTx[]\" " . getData("dstFinTx", "radio", 1) . " type=\"radio\" value=\"1\">Sensible à la rifampicine<br/>
         <input tabindex=\"1100137\" id=\"dstFinTx1\" name=\"dstFinTx[]\" " . getData ("dstFinTx", "radio", 2) . " type=\"radio\" value=\"2\">Résistant à la Rifampicine
         <input tabindex=\"1100138\" id=\"dstFinTx2\" name=\"dstFinTx[]\" " . getData ("dstFinTx", "radio", 4) . " type=\"radio\" value=\"4\">Indéterminé
       <br /></td>
    <td><input  tabindex=\"1100139\" name=\"poidsFinTx\" " . getData ("poidsFinTx", "text") . " type=\"text\" size=\"10\"></td>
  </tr>
</tbody>
</table>
	   
	   
	   </td> 
	   </tr>
	   
";

echo "
	</table>
  </div>"; 










// Eligibility                 tabstart:7000
echo "
<div id=\"pane7\">
<table class=\"header\">";
$tabIndex = 7000;
include ("include/pedMedicalEligibility.php");
echo "
	</table>
</div>";



// Non Eligibility                 tabstart:30000
echo "
<div id=\"pane7\">
  <table class=\"header\">";
$tabIndex = 30000;
      echo "<tr>
       <td class=\"s_header\" colspan=\"10\">" . $nonEligibility[$lang][0] . "</td>
      </tr> 
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 1) .  "\" name=\"refusVolontaireArv\" " . getData ("refusVolontaireArv", "checkbox") .  " type=\"checkbox\" value=\"On\">" .  $nonEligibility[$lang][1] . "</td> 
	   </tr>
	   <tr>
       <td colspan=\"2\"><input tabindex=\"" . ($tabIndex + 2) . "\" name=\"decisionMedicaleARV\" " . getData ("decisionMedicaleARV", "checkbox") . " type=\"checkbox\" value=\"On\">" . $nonEligibility[$lang][2] . "</td>
	   </tr>
	   <tr>
	   <td colspan=\"2\" style=\"padding-left:50px\"><input tabindex=\"" . ($tabIndex + 3) . "\" name=\"infectionOpportunistesARV\" " . getData ("infectionOpportunistesARV", "checkbox") . " type=\"checkbox\" value=\"On\">" . $nonEligibility[$lang][3] . "</td>
      </tr>
      <tr>       
       <td colspan=\"2\" style=\"padding-left:50px\"><input tabindex=\"" . ($tabIndex + 4) . "\" name=\"troublePsychiatriquesARV\" " . getData ("troublePsychiatriquesARV", "checkbox") . " type=\"checkbox\" value=\"On\">" . $nonEligibility[$lang][4] . "</td>
	   </tr>
	   <tr>
	   <td colspan=\"2\" style=\"padding-left:50px\"><input tabindex=\"" . ($tabIndex + 5) . "\" name=\"deniARV\" " . getData ("deniARV", "checkbox") . " type=\"checkbox\" value=\"On\">" . $nonEligibility[$lang][5] . "</td>
	   </tr>
	   <tr>
	   <td colspan=\"2\" style=\"padding-left:50px\"><input tabindex=\"" . ($tabIndex + 5) . "\" name=\"maladieIntercurrentesARV\" " . getData ("maladieIntercurrentesARV", "checkbox") . " type=\"checkbox\" value=\"On\">" . $nonEligibility[$lang][6] . "</td>
	   </tr>
	   <tr>
       <td colspan=\"2\"><input tabindex=\"" . ($tabIndex + 2) . "\" name=\"autreCausesARV\" " . getData ("autreCausesARV", "checkbox") . " type=\"checkbox\" value=\"On\">" . $nonEligibility[$lang][7] . " <input tabindex=\"1106\" id=\"autreCausesARVSpecify\" name=\"autreCausesARVSpecify\" " . getData ("autreCausesARVSpecify", "text") . " type=\"text\" size=\"100\" ></td>
	   </tr>
";

echo "
	</table>
  </div>";  
  




// Plan                        tabstart:7200
echo "
<div id=\"pane8\">
<table class=\"header\">";

$formName = "pedfollowup";

echo "
   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\">" . $pedPlan[$lang][0] . "</td>
      </tr>
      <tr>
       <td><i>" . $pedPlan[$lang][1] . "</i></td>
      </tr>
      <tr>
       <td><textarea tabindex=\"7201\" name=\"assessmentPlan\" cols=\"80\" rows=\"15\">" . getData ("assessmentPlan", "textarea") . "</textarea>" . showValidationIcon ($encType, "assessmentPlan") . "</td>
      </tr>
     </table>
    </td>
   </tr>

   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td>&nbsp;</td>
      </tr>
	 </table>
	</table>
</div>";
if ($tabsOn) {
  echo "</div>";
}
echo "
	<table>
	 <tr>
	  <td >" . $pedNextVisit[$lang][0] . "</td>
          <td ><input tabindex=\"7301\" id=\"labOrDrugForm1\" name=\"labOrDrugForm1\" " . getData ("labOrDrugForm", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedNextVisit[$lang][1] . " <i>" . $pedNextVisit[$lang][2] . "</i></td>
          <td ><input tabindex=\"7302\" id=\"labOrDrugForm2\" name=\"labOrDrugForm1\" " . getData ("labOrDrugForm", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedNextVisit[$lang][3] . "</td>
	 </tr>
	 <tr>
	  <td >" . $pedNextVisit[$lang][4] . "</td>
	  <td ><input tabindex=\"7303\" id=\"labOrDrugForm3\" name=\"labOrDrugForm2\" " . getData ("labOrDrugForm", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $pedNextVisit[$lang][1] . " <i>" . $pedNextVisit[$lang][5] . "</i></td>
          <td ><input tabindex=\"7304\" id=\"labOrDrugForm4\" name=\"labOrDrugForm2\" " . getData ("labOrDrugForm", "checkbox", 8) . " type=\"radio\" value=\"8\">" . $pedNextVisit[$lang][3] . "
          <input type=\"hidden\" id=\"labOrDrugForm\" name=\"labOrDrugForm\" value = \"". getData ("labOrDrugForm", "textarea") . "\" ></td>
         </tr>
         <tr>
          <td>" . $pedNextVisit[$lang][6] . "</td>
	  <td><table><tr><td id=\"pedNextVisitDaysTitle\">&nbsp;</td><td><input tabindex=\"7305\" id=\"pedNextVisitDays\" name=\"pedNextVisitDays\" " . getData ("pedNextVisitDays", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">" . $pedNextVisit[$lang][7] . "</td><td id=\"pedNextVisitWeeksTitle\">&nbsp;</td><td> <input tabindex=\"7306\" id=\"pedNextVisitWeeks\" name=\"pedNextVisitWeeks\" " . getData ("pedNextVisitWeeks", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">" . $pedNextVisit[$lang][8] . " </td><td id=\"pedNextVisitMosTitle\">&nbsp;</td><td><input tabindex=\"7307\" id=\"pedNextVisitMos\" name=\"pedNextVisitMos\" " . getData ("pedNextVisitMos", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">" . $pedNextVisit[$lang][9] . "</td></tr></table></td>
         </tr>
	</table>";
	include ("include/nextVisitDate.php");
echo "
<p>
<input type=\"hidden\" name=\"encounterType\" value=\"17\"></div>
";
$tabIndex = 7400;
$encounterType = 17;
echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"followup/pedfollowup.js\"></script>";
?>
