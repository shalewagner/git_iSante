<?php
if ($tabsOn) {
  echo $tabHeaders;
}
echo "
<div id=\"tab-panes\">
";
if (!$tabsOn) {
  include ("include/nurseSection.php");
}
$date=explode('-',getData ("cancerColon", "textarea"));
$dateProcedure=explode('-',getData ("procedureDate", "textarea"));
//print_r($GLOBALS['errors']);
echo "
<div id=\"pane1\">
  <table class=\"header\">
   <tr>
    <td valign=\"top\" width=\"50%\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"4\">" . $vitalTemp[$lang][0] . "</td>
      </tr>
      <tr>
	    <td  id=\"vitalTempTitle\" width=\"5%\">" . $vitalTemp[$lang][1] . "</td>
	    <td  colspan=\"3\" width=\"45%\"><table><tr><td><input tabindex=\"1101\" id=\"vitalTemp\" name=\"vitalTemp\" " . getData ("vitalTemp", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"/><i>" . $vitalTempUnits[$lang][0] . " </i></td><td id=\"vitalTempUnitTitle\"> </td><td><input tabindex=\"1102\" id=\"vitalTempUnit1\" name=\"vitalTempUnits[]\" " . getData ("vitalTempUnits", "radio", 1) . " type=\"radio\" value=\"1\"/>" . $vitalTempUnits[$lang][1] . " <input tabindex=\"1103\" id=\"vitalTempUnit2\" name=\"vitalTempUnits[]\" " . getData ("vitalTempUnits", "radio", 2) . " type=\"radio\" value=\"2\"/>" . $vitalTempUnits[$lang][2] . "</i></td></tr></table></td>
      </tr>
      <tr>
       <td id=\"vitalBp1Title\">" . $vitalBp1[$lang][1] . "</td>
       <td colspan=\"3\"><table><tr><td><input tabindex=\"1104\" id=\"vitalBp1\"  name=\"vitalBp1\" " . getData ("vitalBp1", "text") . " type=\"text\" size=\"10\" maxlength=\"64\">&nbsp;/</td><td  id=\"vitalBp2Title\"></td>
       <td><input tabindex=\"1105\" id=\"vitalBp2\" name=\"vitalBp2\" " . getData ("vitalBp2", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"></td></tr></table></td>
      </tr>
      <tr>
      	<td>&nbsp;</td>
     	<td valign=\"top\" colspan=\"3\"><table><tr><td><i>" . $vitalBPUnits[$lang][0] . " </td><td id=\"vitalBpUnitTitle\"></td><td><input tabindex=\"1106\" id=\"vitalBpUnit1\" name=\"vitalBPUnits[]\" " . getData ("vitalBPUnits", "radio", 1) . " type=\"radio\" value=\"1\">" . $vitalBPUnits[$lang][1] . " <input tabindex=\"1107\" id=\"vitalBpUnit2\" name=\"vitalBPUnits[]\" " . getData ("vitalBPUnits", "radio", 2) . " type=\"radio\" value=\"2\">" . $vitalBPUnits[$lang][2] . "</i></td></tr></table></td>
      <tr>
       <td id=\"vitalHrTitle\">" . $vitalHr[$lang][1] . "</td>
       <td colspan=\"3\" width=\"45%\"><input tabindex=\"1108\" id=\"vitalHr\" name=\"vitalHr\" " . getData ("vitalHr", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"></td>
      </tr>
      <tr>
       <td id=\"vitalWeightTitle\">" . $vitalWeight[$lang][1] . "</td>
       <td colspan=\"3\" width=\"45%\"><table><tr><td><input tabindex=\"1109\" id=\"vitalWeight\" name=\"vitalWeight\" " . getData ("vitalWeight", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"><i>" . $vitalWeightUnits[$lang][0] . " </i><td id=\"vitalWeightUnitTitle\"></td><td><input tabindex=\"1110\" id=\"vitalWeightUnit1\" name=\"vitalWeightUnits[]\" " . getData ("vitalWeightUnits", "radio", 1) . " type=\"radio\" value=\"1\"> " . $vitalWeightUnits[$lang][1] . " <input tabindex=\"1111\" id=\"vitalWeightUnit2\" name=\"vitalWeightUnits[]\" " . getData ("vitalWeightUnits", "radio", 2) . " type=\"radio\" value=\"2\">" . $vitalWeightUnits[$lang][2] . "</i></td></tr></table></td>
      </tr>
      <tr>
       <td id=\"vitalRrTitle\">" . $vitalRr[$lang][1] . "</td>
       <td width=\"10%\" ><input tabindex=\"1112\" id=\"vitalRr\" name=\"vitalRr\" " . getData ("vitalRr", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"></td>
       <td id=\"vitalHeightTitle\">&nbsp;" . $vitalHeight[$lang][0] . "</td>
       <td><table><tr><td><input tabindex=\"1113\" id=\"vitalHeight\" name=\"vitalHeight\" " . getData ("vitalHeight", "text") . " type=\"text\" size=\"3\" maxlength=\"64\"/> <i>" . $vitalHeight[$lang][1] . " </i></td><td id=\"vitalHeightCmTitle\"></td><td><input tabindex=\"1114\"  id=\"vitalHeightCm\" name=\"vitalHeightCm\" " . getData ("vitalHeightCm", "text") . " type=\"text\" size=\"3\" maxlength=\"64\"/><i>" . $vitalHeight[$lang][2] . "</i></td></tr></table></td>
      </tr>
     </table>

     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\">" . $functionalStatus[$lang][0] . "</td>
      </tr>
      <tr>
       <td><table><tr><td id=\"functionalStatusTitle\"></td><td><i>" . $functionalStatus[$lang][1] . "</i></td></tr></table></td>
      </tr>
      <tr>
       <td><input tabindex=\"1201\" id=\"functionalStatus1\" name=\"functionalStatus[]\" " . getData ("functionalStatus", "radio", 1) . " type=\"radio\" value=\"1\">" . $functionalStatus[$lang][2] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"1202\" id=\"functionalStatus2\" name=\"functionalStatus[]\" " . getData ("functionalStatus", "radio", 2) . " type=\"radio\" value=\"2\">" . $functionalStatus[$lang][3] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"1203\" id=\"functionalStatus4\" name=\"functionalStatus[]\" " . getData ("functionalStatus", "radio", 4) . " type=\"radio\" value=\"4\">" . $functionalStatus_1[$lang][0] . "</td>
      </tr>
     </table>

     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"4\">" . $sexInt[$lang][0] . "</td>
      </tr>
      <tr>
       <td colspan=\"4\"><i>" . $sexInt[$lang][1] . "</i></td>
      </tr>
      <tr>
       <td>" . $sexInt[$lang][2] . "</td>
       <td><input tabindex=\"1301\" name=\"sexInt[]\" " . getData ("sexInt", "radio", 1) . " type=\"radio\" value=\"1\">" . $sexInt[$lang][3] . "</td>
       <td><input tabindex=\"1302\" name=\"sexInt[]\" " . getData ("sexInt", "radio", 2) . " type=\"radio\" value=\"2\">" . $sexInt[$lang][4] . "</td>
       <td><input tabindex=\"1303\" name=\"sexInt[]\" " . getData ("sexInt", "radio", 4) . " type=\"radio\" value=\"4\">" . $sexInt[$lang][5] . "</td>
      </tr>
      <tr>
       <td>" . $sexIntWOcondom[$lang][0] . "</td>
       <td><input tabindex=\"1304\" name=\"sexIntWOcondom[]\" " . getData ("sexIntWOcondom", "radio", 1) . " type=\"radio\" value=\"1\">" . $sexIntWOcondom[$lang][1] . "</td>
       <td><input tabindex=\"1305\" name=\"sexIntWOcondom[]\" " . getData ("sexIntWOcondom", "radio", 2) . " type=\"radio\" value=\"2\">" . $sexIntWOcondom[$lang][2] . "</td>
       <td><input tabindex=\"1306\" name=\"sexIntWOcondom[]\" " . getData ("sexIntWOcondom", "radio", 4) . " type=\"radio\" value=\"4\">" . $sexIntWOcondom[$lang][3] . "</td>
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
    <td valign=\"top\" class=\"vert_line\">&nbsp;</td>
    <td valign=\"top\" class=\"left_pad\" width=\"50%\">
     <table id=\"Table\" class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"4\">" . $pregnant[$lang][0] . "</td>
      </tr>
	  
	  <tr><td colspan=\"2\"><b> " . $pregnant[$lang][4]. "</b></td></tr>
      <tr>
       <td colspan=\"4\"><span><label><input class=\"preg\" tabindex=\"1501\"  id=\"pregY\" name=\"pregnant[]\"" . getData ("pregnant", "radio", 1) . " type=\"radio\" value=\"1\"/>" . $pregnant[$lang][1] . "</label>
       <label><input class=\"preg\" tabindex=\"1502\" id=\"pregN\"  name=\"pregnant[]\"" . getData ("pregnant", "radio", 2) . "
       type=\"radio\" " . $gray . " value=\"2\">" . $pregnant[$lang][2] . "</label>
       <label><input class=\"preg\" tabindex=\"1503\"  id=\"pregU\" name=\"pregnant[]\"" . getData ("pregnant", "radio", 4) . " type=\"radio\" " . $gray . " value=\"4\">" . $pregnant[$lang][3] . "</label></span></td>
      </tr>
      <tr>
       <td width=\"40%\">" . $pregnantLmpDd[$lang][0] . "</td>
 	   <td id = \"pregnantLmpDtTitle\" width=\"5%\">&nbsp;</td>
       <td width=\"20%\"><input tabindex=\"1504\" id=\"pregnantLmpDt\" name=\"pregnantLmpDt\" value=\"" . getData ("pregnantLmpDd", "textarea") . "/". getData ("pregnantLmpMm", "textarea") ."/". getData ("pregnantLmpYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\"> <input class=\"femOnly\" id=\"pregnantLmpDd\" name=\"pregnantLmpDd\" " . getData ("pregnantLmpDd", "text") . " type=\"hidden\" ><input tabindex=\"1505\" class=\"femOnly\" id=\"pregnantLmpMm\" name=\"pregnantLmpMm\" " . getData ("pregnantLmpMm", "text") . " type=\"hidden\" ><input class=\"femOnly\" tabindex=\"1506\" id=\"pregnantLmpYy\" name=\"pregnantLmpYy\" " . getData ("pregnantLmpYy", "text") . " type=\"hidden\" ></td>
	   <td width=\"35%\">&nbsp;<i>" . $pregnantLmpYy[$lang][2] . "</i></td>
      </tr>
      <tr>
       <td colspan=\"4\">" . $pregnantPrenatal[$lang][0] . "
      	<span><label><input class=\"pregPrenat\" tabindex=\"1507\" id=\"pregPrenatY\" name=\"pregnantPrenatal[]\" " . getData ("pregnantPrenatal", "radio", 1) . "  type=\"radio\" value=\"1\">" . showValidationIcon ($encType, "pregnantPrenatal") . " " . $pregnantPrenatal[$lang][1] . " </label><label><input class=\"pregPrenat\" tabindex=\"1508\" name=\"pregnantPrenatal[]\" id=\"pregPrenatN\" " . getData ("pregnantPrenatal", "radio", 2) . "  type=\"radio\" value=\"2\">" . $pregnantPrenatal[$lang][2] . "</label></span></td>
	  <tr>
       <td >" . $pregnantPrenatalFirstDd[$lang][0] . "</td>
       <td id=\"pregnantPrenatalFirstDtTitle\">&nbsp;</td>
       <td><input class=\"pregPrenat\" tabindex=\"1509\" id=\"pregnantPrenatalFirstDt\" name=\"pregnantPrenatalFirstDt\" value=\"" . getData ("pregnantPrenatalFirstDd", "textarea") . "/". getData ("pregnantPrenatalFirstMm", "textarea") ."/". getData ("pregnantPrenatalFirstYy", "textarea") . "\" " . $gray . " type=\"text\" size=\"8\" maxlength=\"8\"><input class=\"femOnly\" id=\"pregnantPrenatalFirstDd\"  name=\"pregnantPrenatalFirstDd\" " . getData ("pregnantPrenatalFirstDd", "text") . " type=\"hidden\"><input class=\"femOnly\" tabindex=\"1510\" id=\"pregnantPrenatalFirstMm\" name=\"pregnantPrenatalFirstMm\" " . getData ("pregnantPrenatalFirstMm", "text") . " type=\"hidden\"><input class=\"femOnly\" tabindex=\"1511\" id=\"pregnantPrenatalFirstYy\" name=\"pregnantPrenatalFirstYy\" " . getData ("pregnantPrenatalFirstYy", "text") . " type=\"hidden\"></td>
	   <td><i>" . $pregnantPrenatalFirstYy[$lang][2] . "</i></td>
      </tr>
      <tr>
       <td>" . $pregnantPrenatalLastDd[$lang][0] . "</td>
       <td id=\"pregnantPrenatalLastDtTitle\">&nbsp;</td>
 <td><input class=\"pregPrenat\" tabindex=\"1512\" id=\"pregnantPrenatalLastDt\" name=\"pregnantPrenatalLastDt\" value=\"" . getData ("pregnantPrenatalLastDd", "textarea") . "/". getData ("pregnantPrenatalLastMm", "textarea") ."/". getData ("pregnantPrenatalLastYy", "textarea") . "\" " . $gray . " type=\"text\" size=\"8\" maxlength=\"8\"> <input class=\"femOnly\" id=\"pregnantPrenatalLastDd\" name=\"pregnantPrenatalLastDd\" " . getData ("pregnantPrenatalLastDd", "text") . " type=\"hidden\"><input class=\"femOnly\" tabindex=\"1513\" id=\"pregnantPrenatalLastMm\" name=\"pregnantPrenatalLastMm\" " . getData ("pregnantPrenatalLastMm", "text") . " type=\"hidden\"><input class=\"femOnly\" tabindex=\"1514\" id=\"pregnantPrenatalLastYy\" name=\"pregnantPrenatalLastYy\" " . getData ("pregnantPrenatalLastYy", "text") . " type=\"hidden\"> </td>
       <td><i>" . $pregnantPrenatalLastYy[$lang][2] . "</i></td>
";
echo "
      </tr>
      <tr>
       <td colspan=\"4\"><i>" . $pregnantNoPrenatal[$lang][1] . "</i></td>
      </tr>
	        <tr>
      	<td>&nbsp;
      	</td>
      </tr>
     <tr>
	  <td colspan=\"2\">
	  <table><tr><td colspan=\"2\"><b> " . $ConcerColonStatus[$lang][6]. "</b> : <input class=\"oh3\" tabindex=\"1600\" id=\"screeneddone1\" name=\"screeneddone[]\" " . getData ("screeneddone", "radio", 1) . " type=\"radio\" value=\"1\" />" . $pregnantPrenatal[$lang][1]. "
			<input class=\"oh3\" tabindex=\"1601\" id=\"screeneddone2\" name=\"screeneddone[]\" " . getData ("screeneddone", "radio", 2) . " type=\"radio\" value=\"2\" />" . $pregnantPrenatal[$lang][2] . "</td></tr>
	  <tr><td id=\"cancerColonDtTitle\"> " . $ConcerColonStatus[$lang][5] . "</td><td><input class=\"oh2\" tabindex=\"1524\" type=\"text\" id=\"cancerColonDt\" name=\"cancerColon\" value= \"" .substr($date[0],-2)."/".$date[1]."/".substr($date[2],0,2)."\" size=\"8\" maxlength=\"8\"\></td></tr>
	  <tr><td>".$ConcerColonStatus[$lang][4]."
	   <input class=\"oh3\" tabindex=\"1519\" id=\"screenedMethode1\" name=\"screenedMethode[]\" " . getData ("screenedMethode", "radio", 1) . " type=\"radio\" value=\"1\" />" . $ConcerColonStatus[$lang][7] . "
			<input class=\"oh3\" tabindex=\"1520\" id=\"screenedMethode2\" name=\"screenedMethode[]\" " . getData ("screenedMethode", "radio", 2) . " type=\"radio\" value=\"2\" />" . $ConcerColonStatus[$lang][8] . "</td><tr>
			<tr><td><span style=\"white-space: nowrap;\">
			 ". $ConcerColonStatus[$lang][3] . " : <span style=\"white-space: nowrap;\">
			<input class=\"oh3\" tabindex=\"1521\" id=\"cancerColonStatus1\" name=\"cancerColonStatus[]\" " . getData ("cancerColonStatus", "radio", 1) . " type=\"radio\" value=\"1\" />" . $ConcerColonStatus[$lang][0] . "
			<input class=\"oh3\" tabindex=\"1522\" id=\"cancerColonStatus2\" name=\"cancerColonStatus[]\" " . getData ("cancerColonStatus", "radio", 2) . " type=\"radio\" value=\"2\" />" . $ConcerColonStatus[$lang][1] . "
			<input class=\"oh3\" tabindex=\"1523\" id=\"cancerColonStatus3\" name=\"cancerColonStatus[]\" " . getData ("cancerColonStatus", "radio", 4) . " type=\"radio\" value=\"4\" />" . $ConcerColonStatus[$lang][2] .
       "</span>	</td>
	   </tr></table>
	  </td>
	  </tr>	  
	  
     </table>
";

$tabIndex = 1600;
echo "
<table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"2\">" . $genStat[$lang][0] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"1601\" name=\"genStat[]\" " . getData ("genStat", "radio", 1) . " type=\"radio\" value=\"1\">" . $genStat[$lang][1] . "</td>
      </tr>
       <td><input tabindex=\"1604\" name=\"genStat[]\" " . getData ("genStat", "radio", 2) . " type=\"radio\" value=\"2\">" . $genStat[$lang][2] . "</td>
      <tr>
       <td><input tabindex=\"1602\" name=\"genStat[]\" " . getData ("genStat", "radio", 4) . " type=\"radio\" value=\"4\">" . $genStat[$lang][3] . "</td>
       <td><input tabindex=\"1605\" name=\"genStat[]\" " . getData ("genStat", "radio", 8) . " type=\"radio\" value=\"8\">" . $genStat[$lang][4] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"1603\" name=\"genStat[]\" " . getData ("genStat", "radio", 16) . " type=\"radio\" value=\"16\">" . $genStat[$lang][5] . "</td>
       <td>&nbsp;</td>
      </tr>
      <tr>
       <td>" . $hospitalized[$lang][0] . " </td>
       <td><input tabindex=\"1606\" name=\"hospitalized[]\" " . getData ("hospitalized", "radio", 1) . " type=\"radio\" value=\"1\">" . $hospitalized[$lang][1] . " <input tabindex=\"1607\" name=\"hospitalized[]\" " . getData ("hospitalized", "radio", 2) . " type=\"radio\" value=\"2\"> " . $hospitalized[$lang][2] . " <input tabindex=\"1608\" name=\"hospitalized[]\" " . getData ("hospitalized", "radio", 4) . " type=\"radio\" value=\"4\"> " . $hospitalized[$lang][3] . "</td>
      </tr>
      <tr>
       <td colspan=\"2\">" . $hospitalizedText[$lang][1] . "</td>
      </tr>
      <tr>
       <td colspan=\"2\"><textarea tabindex=\"1609\" name=\"hospitalizedText\" rows=\"2\" cols=\"60\">" . getData ("hospitalizedText", "textarea") . "</textarea></td>
      </tr>
     </table>
 ";

echo"
    </td>
   </tr>
  </table>
  </div>
";
$tabIndex = 1700;
if(getUiConfig(getSessionUser()) == "3" || getUiConfig(getSessionUser()) == "2")
{
echo "<div>";
include ("include/tbStatus_followup.php");
echo "</td><td valign=\"top\" class=\"vert_line\">&nbsp;</td>
       <td valign=\"top\" class=\"left_pad\" width=\"50%\">
        <table class=\"b_header_nb\">
         <tr>
          <td class=\"s_header\" colspan=\"3\">" . $famPlan[$lang][0] . "</td>
         </tr>
         <tr class=\"POC\">
          <td colspan=\"2\">
            <input tabindex=\"2001\" id=\"fp1\" name=\"famPlan[]\" " .
              getData ("famPlan", "radio", 1) .
              " type=\"radio\" value=\"1\">" .
              $famPlan[$lang][1] . "
            <input tabindex=\"2002\" id=\"fp2\" name=\"famPlan[]\" " .
              getData ("famPlan", "radio", 2) .
              " type=\"radio\" value=\"2\">" .
              $famPlan[$lang][2] . "
          </td>
          <td>" . $famPlanMethodTubalLig[$lang][0] .
            " &nbsp;&nbsp;&nbsp; <span>
            <input tabindex=\"2009\" id=\"famPlanMethodTubalLi1\" name=\"famPlanMethodTubalLig[]\" " .
              getData ("famPlanMethodTubalLig", "radio", 1) .
              " type=\"radio\" value=\"1\" class=\"famPlan\">" .
              $famPlanMethodTubalLig[$lang][1] . "
            <input tabindex=\"2010\" id=\"famPlanMethodTubalLi2\" name=\"famPlanMethodTubalLig[]\" " .
              getData ("famPlanMethodTubalLig", "radio", 2) .
              " type=\"radio\" value=\"2\" class=\"famPlan\">" .
              $famPlanMethodTubalLig[$lang][2] . "</span>
          </td>
         </tr>
         <tr class=\"POC\">
          <td colspan=\"2\"><b>" . $famPlanMethodCondom[$lang][0] . "</b></td>
          <td>
            <input tabindex=\"2011\" id=\"famPlanOther\" name=\"famPlanOther\" " .
              getData ("famPlanOther", "checkbox") .
              " type=\"radio\" value=\"On\" class=\"famPlan\">" .
              $famPlanOther[$lang][1] . "
          </td>
         </tr>
         <tr class=\"POC\">
          <td>" . $famPlanMethodCondom[$lang][1] . "</td>
          <td>
            <input tabindex=\"2003\" id=\"famPlanMethodCondom1\" name=\"famPlanMethodCondom[]\" " .
              getData ("famPlanMethodCondom", "radio", 1) .
              " type=\"radio\" value=\"1\" class=\"famPlan\">" .
              $famPlanMethodCondom[$lang][2] . "
            <input tabindex=\"2004\" id=\"famPlanMethodCondom2\" name=\"famPlanMethodCondom[]\" " .
              getData ("famPlanMethodCondom", "radio", 2) .
              " type=\"radio\" value=\"2\" class=\"famPlan\">" .
              $famPlanMethodCondom[$lang][3] . "
          </td>
          <td valign=\"top\" rowspan=\"3\">
            <input tabindex=\"2012\" id=\"famPlanOtherText\" name=\"famPlanOtherText\" " . getData ("famPlanOtherText", "text") . " type=\"text\" size=\"30\" maxlength=\"255\" class=\"famPlan\"></td>
         </tr>
         <tr class=\"POC\">
          <td>" . $famPlanMethodDmpa[$lang][0] . "</td>
          <td>
            <input tabindex=\"2005\" id=\"famPlanMethodDmpa1\" name=\"famPlanMethodDmpa[]\" " .
              getData ("famPlanMethodDmpa", "radio", 1) .
              " type=\"radio\" value=\"1\" class=\"famPlan\">" .
              $famPlanMethodDmpa[$lang][1] . "
            <input tabindex=\"2006\" id=\"famPlanMethodDmpa2\" name=\"famPlanMethodDmpa[]\" " .
              getData ("famPlanMethodDmpa", "radio", 2) .
              " type=\"radio\" value=\"2\" class=\"famPlan\">" .
              $famPlanMethodDmpa[$lang][2] . "
          </td>
         </tr>
         <tr class=\"POC\">
          <td>" . $famPlanMethodOcPills[$lang][0] . "</td>
          <td>
            <input tabindex=\"2007\" id=\"famPlanMethodOcPills1\" name=\"famPlanMethodOcPills[]\" " .
              getData ("famPlanMethodOcPills", "radio", 1) .
              " type=\"radio\" value=\"1\" class=\"famPlan\">" .
              $famPlanMethodOcPills[$lang][1] . "
            <input tabindex=\"2008\" id=\"famPlanMethodOcPills2\" name=\"famPlanMethodOcPills[]\" " .
              getData ("famPlanMethodOcPills", "radio", 2) .
              " type=\"radio\" value=\"2\" class=\"famPlan\">" .
              $famPlanMethodOcPills[$lang][2] . "
           </td>
         </tr>
        </table>
       </td></tr></table></div>";
}


if (!$tabsOn) {
  include ("include/doctorSection.php");
}


$tabIndex = 2000;
echo "<div id=\"pane2\"><table width=\"100%\">";
include ("symptoms/fup1.php");
echo "\n</table></div>";



$tabIndex = 3000;
echo "<div id=\"pane4\"><table  width=\"100%\">";
include ("clinicalExam/1.php");
echo "\n</table></div>";

if(getUiConfig(getSessionUser()) == "3" || getUiConfig(getSessionUser()) == "2"){
echo "
<div>
<table width=\"100%\">
	<tr class=\"POC\">
	 <td>

<!-- ******************************************************************** -->
<!-- ******************** TB Evaluation ******************** -->
<!-- ******************** (tab indices 3500 - 4000) ******************** -->
<!-- ******************************************************************** -->
  <table width=\"100%\">
   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"8\">" . $tbEval[$lang][0] . "</td>
      </tr>
      <tr>
       <td colspan=\"2\">" . $tbEval[$lang][1] . "</td>
      </tr>
      <tr>
       <td>
         <input tabindex=\"3501\" name=\"presenceBCG\" " .
           getData ("presenceBCG", "checkbox", 0) .
           " type=\"checkbox\" value=\"1\">" .
           $tbEval[$lang][2] . "
       </td>
       <td>
         <input tabindex=\"3502\" name=\"suspicionTBwSymptoms\" " .
           getData ("suspicionTBwSymptoms", "checkbox", 0) .
           " type=\"checkbox\" value=\"1\">" .

           $tbEval[$lang][3] . "
       </td>
      </tr>
      <tr>
       <td>
         <input tabindex=\"3503\" name=\"recentNegPPD\" " .
           getData ("recentNegPPD", "checkbox", 0) .
           " type=\"checkbox\" value=\"1\">" .
           $tbEval[$lang][4] . "
       </td>
       <td>
         <input tabindex=\"3504\" name=\"noTBsymptoms\" " .
           getData ("noTBsymptoms", "checkbox", 0) .
           " type=\"checkbox\" value=\"1\">" .
           $tbEval[$lang][5] . "
       </td>
      </tr>
      <tr>
       <td>
         <input tabindex=\"3505\" name=\"statusPPDunknown\" " .
           getData ("statusPPDunknown", "checkbox", 0) .
           " type=\"checkbox\" value=\"1\">" .
           $tbEval[$lang][6] . "
       </td>
       <td>
       		&nbsp;
       </td>
      </tr>
      <tr>
       <td>
        <table>
         <tr>
          <td id=\"propINHTitle\"></td>
          <td>
			 <input tabindex=\"3506\" id=\"propINH\" name=\"propINH\" " .
			   getData ("propINH", "checkbox", 0) .
			   " type=\"checkbox\" value=\"1\">" .
			   $tbEval[$lang][7] . "
          </td>
         </tr>
        </table>
       </td>
       <td colspan=\"2\">" . $tbEval[$lang][8] . "<table><tr><td id=\"debutINHStartTitle\"></td><td><input tabindex=\"3507\" id=\"debutINHStartMM\" name=\"debutINHMm\" " . getData ("debutINHMm", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"3508\" id=\"debutINHStartYY\"  name=\"debutINHYy\" " . getData ("debutINHYy", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"><i>" . $tbEval[$lang][9] . "</i></td></tr></table></td>
       </td>
       <td>" .
           $tbEval[$lang][10] . "<table><tr><td id=\"debutINHStopTitle\"></td><td><input tabindex=\"3509\" id=\"debutINHStopMM\" name=\"arretINHMm\" " . getData ("arretINHMm", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"3510\" id=\"debutINHStopYY\" name=\"arretINHYy\" " . getData ("arretINHYy", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"> " . $tbEval[$lang][9] . "</td></tr></table>
       </td>
       <td>
       		&nbsp;
       </td>
      </tr>
     </table>
    <td>
   </tr>

    </table>
   </td>
  </tr>
 </table>
</div>";
}
$tabIndex = 4000;
echo "<div id=\"pane3\"><table>";
include ("conditions/1.php");
//include ("include/conditions.php");
echo "\n</table></div>";


echo "<div id=\"pane3\">
<table width=\"100%\">
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
      </tr> \n</table></div>";	  









echo "
<!-- ******************************************************************** -->
<!-- ******************************* ARV ******************************** -->
<!-- ********************* (tab indices 5001 - 6000) ******************** -->
<!-- ******************************************************************** -->
";

//$arv_cols = arvColumns (1);
$arv_rows = arvRows (5101, 1);

echo "<div id=\"pane5\">
<table>
   <tr>
    <td>
     <table class=\"b_header_nb\" width=\"100%\" cellspacing =\"0\" cellpadding=\"0\" border=\"0\">
      <tr>
       <td class=\"s_header\" colspan=\"17\" width=\"100%\">" . $followupTreatment_header[$lang][1] . "</td>
      </tr>
      <tr>
       <td colspan=\"17\">" . $arvEver_1[$lang][0] . " <span><input tabindex=\"5001\" id=\"arvY\" name=\"arvEver[]\" " . getData ("arvEver", "radio", 1) . " type=\"radio\" value=\"1\">" . $arvEver[$lang][1] . " <input  id=\"arvN\" tabindex=\"5002\" name=\"arvEver[]\" " . getData ("arvEver", "radio", 2) . " type=\"radio\" value=\"2\"> " . $arvEver_1[$lang][3] . "</span></td>
      </tr>
      <tr>
       <td colspan=\"17\"><i>" . $arv_header[$lang][3] . "</i></td>
      </tr>
      <tr>
       <td rowspan=\"3\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
       <td class=\"sm_header_cnt_np\">" . $followupTreatment_subhead1[$lang][0] . "</td>
       <td width=\"3%\">&nbsp;</td>
       <td class=\"sm_header_lt_np\">" . $followupTreatment_subhead1[$lang][1] . "</td>
       <td colspan=\"5\" class=\"sm_header_lt_np\">" . $followupTreatment_subhead1[$lang][2] . "</td>
       <td width=\"3%\">&nbsp;</td>
       <td colspan=\"7\" class=\"sm_header_lt_np\">" . $followupTreatment_subhead1[$lang][3] . "</td>
      </tr>
      <tr>
       <td class=\"sm_header_cnt_np\">" . $followupTreatment_subhead2[$lang][0] . "</td>
       <td width=\"3%\">&nbsp;</td>
       <td class=\"sm_header_lt_np\">" . $followupTreatment_subhead2[$lang][1] . "</td>
       <td colspan=\"2\">&nbsp;</td>
       <td class=\"sm_header_cnt_np\">" . $followupTreatment_subhead2[$lang][2] . "</td>
       <td class=\"sm_header_cnt_np\">" . $followupTreatment_subhead2[$lang][3] . "</td>
       <td class=\"sm_header_cnt_np\">" . $followupTreatment_subhead2[$lang][4] . "</td>
       <td colspan=\"8\">&nbsp;</td>
      </tr>
      <tr>
       <td colspan=\"3\">&nbsp;</td>
       <td class=\"sm_header_cnt_np\">" . $followupTreatment_subhead3[$lang][0] . "</td>
       <td class=\"sm_header_cnt_np\">" . $followupTreatment_subhead3[$lang][1] . "</td>
       <td class=\"sm_header_cnt_np\">" . $followupTreatment_subhead3[$lang][2] . "</td>
       <td class=\"sm_header_cnt_np\">" . $followupTreatment_subhead3[$lang][3] . "</td>
       <td class=\"sm_header_cnt_np\">" . $followupTreatment_subhead3[$lang][4] . "</td>
       <td width=\"3%\">&nbsp;</td>
       <td class=\"sm_header_cnt_np\">" . $arv_subhead9[$lang][0] . "</td>
       <td class=\"sm_header_cnt_np\">" . $arv_subhead9[$lang][1] . "</td>
       <td class=\"sm_header_cnt_np\">" . $arv_subhead9[$lang][2] . "</td>
       <td class=\"sm_header_cnt_np\">" . $arv_subhead10[$lang][0] . "</td>
       <td class=\"sm_header_cnt_np\">" . $arv_subhead10[$lang][1] . "</td>
       <td class=\"sm_header_cnt_np\">" . $arv_subhead10[$lang][2] . "</td>
       <td class=\"sm_header_cnt_np\">" . $arv_subhead11[$lang][0] . "</td>
      </tr>
      <tr>
       <td class=\"top_line\" colspan=\"17\">&nbsp;</td>
      </tr>
      <tr>
       <td colspan=\"9\"><b>
         <a class=\"toggle_display\"
            onclick=\"toggleDisplay(0,$arvSubHeadElems[0]);\"
            title=\"Toggle display\">
            <span id=\"section0Y\" style=\"display:none\">(+)</span>
            <span id=\"section0N\">(-)&nbsp;</span>" .
              $arv_subhead3[$version][$lang][1] .
         "</a></b></td>
       <!--td rowspan=\"22\" class=\"vert_line\" width=\"5%\">&nbsp;</td>-->
       <td>&nbsp;</td>
       <td colspan=\"7\">&nbsp;</td>
      </tr>" . $arv_rows . "
      <tr>
       <td class=\"sm_lt\" colspan=\"17\"><b>" . $arv_subhead14[$lang][0] . "</b> &nbsp;" . $arv_subhead12[$lang][1] . " &nbsp;" . $arv_subhead14[$lang][1] . " &nbsp;" . $arv_subhead18[$lang][0] . " &nbsp;" . $arv_subhead18[$lang][1] . " &nbsp;" . $arv_subhead18[$lang][2] . " &nbsp;" . $arv_subhead14[$lang][2] . " &nbsp;" . $arv_subhead13[$lang][0] . " &nbsp;" . $arv_subhead15[$lang][0] . " &nbsp;" . $arv_subhead13[$lang][1] . " &nbsp;" . $arv_subhead15[$lang][1] . " &nbsp;" . $arv_subhead13[$lang][2] . " &nbsp;" . $arv_subhead15[$lang][2] . "</td>
      </tr>
     </table>
    </td>
   </tr>

<!-- ******************************************************************** -->
<!-- ************************* Toxicity/Adherence *********************** -->
<!-- ********************* (tab indices 6001 - 7000) ******************** -->
<!-- ******************************************************************** -->

   <tr>
    <td>
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\">" . $currToxicity_header_1[$lang][1] . "</td>
      </tr>
      <tr>
       <td><b>" . $currToxicityText[$lang][1] . "</b> <input tabindex=\"6001\" name=\"currToxicityText\" " . getData ("currToxicityText", "text") . " type=\"text\" size=\"80\" maxlength=\"255\">" . showValidationIcon ($encType, "currToxicityText") . "</td>
      </tr>
      <tr>
       <td>
        <span><input tabindex=\"6002\" name=\"currToxRash\" " . getData ("currToxRash", "checkbox") . " type=\"checkbox\" value=\"On\">" . $currToxRash[$lang][1] . "</span>
        <span><input tabindex=\"6003\" name=\"currToxAnemia\" " . getData ("currToxAnemia", "checkbox") . " type=\"checkbox\" value=\"On\">" . $currToxAnemia[$lang][1] . "</span>
        <span><input tabindex=\"6004\" name=\"currToxHep\" " . getData ("currToxHep", "checkbox") . " type=\"checkbox\" value=\"On\">" . $currToxHep[$lang][1] . "</span>
        <span><input tabindex=\"6005\" name=\"currToxCNS\" " . getData ("currToxCNS", "checkbox") . " type=\"checkbox\" value=\"On\">" . $currToxCNS[$lang][1] . "</span>
        <span><input tabindex=\"6006\" name=\"currToxHyper\" " . getData ("currToxHyper", "checkbox") . " type=\"checkbox\" value=\"On\">" . $currToxHyper[$lang][1] . "</span>
        <span><input tabindex=\"6007\" name=\"currToxOther\" " . getData ("currToxOther", "checkbox") . " type=\"checkbox\" value=\"On\">" . $currToxOther[$lang][1] . "
        <input tabindex=\"6008\" name=\"currToxText\" " . getData ("currToxText", "text") . " type=\"text\" size=\"40\" maxlength=\"20\"></span>
       </td>
      </tr>
      <tr>
	   <td>&nbsp;</td>
      </tr>
      <tr>
       <td class=\"s_header\">" . $adherenceComments[$lang][1] . "</td>
      </tr>
      <tr>
       <td><textarea tabindex=\"6301\" name=\"adherenceComments\" cols=\"80\" rows=\"5\">" . getData ("adherenceComments", "textarea") . "</textarea></td>
      </tr>
     </table>
    </td>
   </tr>

<!-- ******************************************************************** -->
<!-- ********************** Other Current Treatments ******************** -->
<!-- ********************* (tab indices 7001 - 8000) ******************** -->
<!-- ******************************************************************** -->

   <tr>
    <td>
     <table class=\"b_header_nb\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">
      <tr>
       <td class=\"s_header\" colspan=\"9\">" . $allergies_header[$lang][0] . "</td>
      </tr>
      <tr>
       <td colspan=\"9\"><i>" . $allergies_header[$lang][3] . "</i></td>
      </tr>
      <tr>
       <td class=\"bottom_line\" colspan=\"9\" width=\"100%\">&nbsp;</td>
      </tr>
      <tr>
       <td class=\"sm_header_lt\">&nbsp;</td>
       <td class=\"sm_header_cnt\">" . $allergies_subhead2[$lang][0] . "</td>
       <td class=\"sm_header_lt\">&nbsp;</td>
       <td class=\"sm_header_lt\">" . $allergies_subhead1[$lang][2] . "</td>
       <td class=\"sm_header_lt\">&nbsp;</td>
       <td class=\"sm_header_lt\">&nbsp;</td>
       <td class=\"sm_header_cnt\">" . $allergies_subhead2[$lang][0] . "</td>
       <td class=\"sm_header_lt\">&nbsp;</td>
       <td class=\"sm_header_lt\">" . $allergies_subhead1[$lang][2] . "</td>
      </tr>
      <tr>
       <td class=\"top_line\" colspan=\"9\" width=\"100%\">&nbsp;</td>
      </tr>
      <tr>
       <td colspan=\"5\"><b>" . $allergies_subhead11[$lang][0] . "</b></td>
       <td colspan=\"4\"><b>" . $allergies_subhead11[$lang][1] . "</b></td>
      </tr>
      <tr class=\"alt\">
       <td class=\"small_cnt\" id=\"ethambutolContinuedTitle\">" . $ethambutolMM[$lang][0] . "</td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"7001\" id=\"ethambutolContinued\" name=\"ethambutolContinued\" " .
             getData ("ethambutolContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td id=\"ethambutolStopTitle\">&nbsp;</td>
       <td><input tabindex=\"7002\" id =\"ethambutolStopMm\" name=\"ethambutolStopMm\" " .
          getData ("ethambutolStopMm", "text") .
         " type=\"text\" size=\"2\" maxlength=\"2\" class=\"small_cnt\">/<input tabindex=\"7003\" id=\"ethambutolStopYy\" name=\"ethambutolStopYy\" " .
           getData ("ethambutolStopYy", "text") .
         " type=\"text\" size=\"2\" maxlength=\"2\" class=\"small_cnt\"></td>
       <td >&nbsp;</td>
       <td class=\"small_cnt\" id=\"acyclovirContinuedTitle\">" . $acyclovirMM[$lang][0] . "</td>
       <td  class=\"sm_header_cnt_np\">
         <input tabindex=\"7016\" id=\"acyclovirContinued\" name=\"acyclovirContinued\" " . getData ("acyclovirContinued", "checkbox") .
           " type=\"checkbox\" value=\"On\"></td>
       <td id=\"acyclovirStopTitle\">&nbsp;</td>
       <td>
         <input tabindex=\"7017\"  id=\"acyclovirStopMm\"  name=\"acyclovirStopMm\" " .
           getData ("acyclovirStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\" class=\"small_cnt\">/<input tabindex=\"7018\" id=\"acyclovirStopYy\" name=\"acyclovirStopYy\" " .
            getData ("acyclovirStopYy", "text") . " type=\"text\" size=\"2\"
            maxlength=\"2\" class=\"small_cnt\"></td>
      </tr>
      <tr>
       <td class=\"small_cnt\" id=\"isoniazidContinuedTitle\">" . $isoniazidMM[$lang][0] . "</td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"7004\" id=\"isoniazidContinued\" name=\"isoniazidContinued\" " . getData ("isoniazidContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td id=\"isoniazidStopTitle\">&nbsp;</td>
       <td><input tabindex=\"7005\" id=\"isoniazidStopMm\" name=\"isoniazidStopMm\" " .
           getData ("isoniazidStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\" class=\"small_cnt\">/<input tabindex=\"7006\" id=\"isoniazidStopYy\" name=\"isoniazidStopYy\" " .
           getData ("isoniazidStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\" class=\"small_cnt\"></td>
       <td>&nbsp;</td>
       <td class=\"small_cnt\" id=\"cotrimoxazoleContinuedTitle\">" . $cotrimoxazoleMM[$lang][0] . "</td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"7019\" id=\"cotrimoxazoleContinued\" name=\"cotrimoxazoleContinued\" " . getData ("cotrimoxazoleContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td id=\"cotrimoxazoleStopTitle\">&nbsp;</td>
       <td><input tabindex=\"7020\" id=\"cotrimoxazoleStopMm\" name=\"cotrimoxazoleStopMm\" " .
           getData ("cotrimoxazoleStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\" class=\"small_cnt\">/<input tabindex=\"7021\" id=\"cotrimoxazoleStopYy\" name=\"cotrimoxazoleStopYy\" " .
             getData ("cotrimoxazoleStopYy", "text") .
             " type=\"text\" size=\"2\" maxlength=\"2\" class=\"small_cnt\"></td>
      </tr>
      <tr class=\"alt\">
       <td class=\"small_cnt\" id=\"pyrazinamideContinuedTitle\">" . $pyrazinamideMM[$lang][0] . "</td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"7007\" id=\"pyrazinamideContinued\" name=\"pyrazinamideContinued\" " . getData ("pyrazinamideContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td id=\"pyrazinamideStopTitle\">&nbsp;</td>
       <td><input tabindex=\"7008\" id=\"pyrazinamideStopMm\" name=\"pyrazinamideStopMm\" " .
           getData ("pyrazinamideStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\" class=\"small_cnt\">/<input tabindex=\"7009\" id=\"pyrazinamideStopYy\" name=\"pyrazinamideStopYy\" " .
           getData ("pyrazinamideStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\" class=\"small_cnt\"></td>
       <td>&nbsp;</td>
       <td class=\"small_cnt\" id=\"fluconazoleContinuedTitle\">" . $fluconazoleMM[$lang][0] . "</td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"7022\" id=\"fluconazoleContinued\" name=\"fluconazoleContinued\" " . getData ("fluconazoleContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td id=\"fluconazoleStopTitle\">&nbsp;</td>
       <td><input tabindex=\"7023\" id=\"fluconazoleStopMm\" name=\"fluconazoleStopMm\" " .
           getData ("fluconazoleStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\" class=\"small_cnt\">/<input tabindex=\"7024\" id=\"fluconazoleStopYy\" name=\"fluconazoleStopYy\" " .
           getData ("fluconazoleStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\" class=\"small_cnt\"></td>
      </tr>
      <tr>
       <td class=\"small_cnt\" id=\"rifampicineContinuedTitle\">" . $rifampicineMM[$lang][0] . "</td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"7010\" id=\"rifampicineContinued\" name=\"rifampicineContinued\" " . getData ("rifampicineContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td id=\"rifampicineStopTitle\">&nbsp;</td>
       <td><input tabindex=\"7011\" id=\"rifampicineStopMm\" name=\"rifampicineStopMm\" " .
           getData ("rifampicineStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\" class=\"small_cnt\">/<input tabindex=\"7012\" id=\"rifampicineStopYy\" name=\"rifampicineStopYy\" " .
           getData ("rifampicineStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\" class=\"small_cnt\"></td>
       <td>&nbsp;</td>
       <td class=\"small_cnt\" id=\"ketaconazoleContinuedTitle\">" . $ketaconazoleMM[$lang][0] . "</td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"7025\" id=\"ketaconazoleContinued\" name=\"ketaconazoleContinued\" " . getData ("ketaconazoleContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td id=\"ketaconazoleStopTitle\" >&nbsp;</td>
       <td><input tabindex=\"7026\" id=\"ketaconazoleStopMm\" name=\"ketaconazoleStopMm\" " .
           getData ("ketaconazoleStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\" class=\"small_cnt\">/<input tabindex=\"7027\" id=\"ketaconazoleStopYy\" name=\"ketaconazoleStopYy\" " .
           getData ("ketaconazoleStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\" class=\"small_cnt\"></td>
      </tr>
      <tr class=\"alt\">
       <td class=\"small_cnt\" id=\"streptomycineContinuedTitle\" >" . $streptomycineMM[$lang][0] . "</td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"7013\" id=\"streptomycineContinued\" name=\"streptomycineContinued\" " . getData ("streptomycineContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td id=\"streptomycineStopTitle\">&nbsp;</td>
       <td><input tabindex=\"7014\" id=\"streptomycineStopMm\" name=\"streptomycineStopMm\" " .
           getData ("streptomycineStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\" class=\"small_cnt\">/<input tabindex=\"7015\" id=\"streptomycineStopYy\" name=\"streptomycineStopYy\" " .
           getData ("streptomycineStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\" class=\"small_cnt\"></td>
       <td>&nbsp;</td>
       <td class=\"small_cnt\" id=\"traditionalContinuedTitle\" >" . $traditionalStartMm[$lang][0] . "</td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"7028\" id=\"traditionalContinued\" name=\"traditionalContinued\" " . getData ("traditionalContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td id=\"traditionalStopTitle\">&nbsp;</td>
       <td><input tabindex=\"7029\" id=\"traditionalStopMm\" name=\"traditionalStopMm\" " .
           getData ("traditionalStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\" class=\"small_cnt\">/<input tabindex=\"7030\" id=\"traditionalStopYy\" name=\"traditionalStopYy\" " .
           getData ("traditionalStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\" class=\"small_cnt\"></td>
      </tr>
      <tr>
       <td colspan=\"5\">&nbsp;</td>
       <td class=\"small_cnt\"><table><tr><td>" .
         $other1Text[$lang][1] .
         " <input tabindex=\"7031\" name=\"other3Text\" " .
           getData ("other3Text", "text") .
           " type=\"text\" size=\"20\" maxlength=\"255\" class=\"small_cnt\"></td><td id=\"other3ContinuedTitle\" align=\"right\">&nbsp;</td></tr></table></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"7032\" id=\"other3Continued\" name=\"other3Continued\" " . getData ("other3Continued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td id=\"other3StopTitle\">&nbsp;</td>
       <td class=\"small_cnt\"><input tabindex=\"7033\" id=\"other3StopMm\" name=\"other3SpMM\" " .
           getData ("other3SpMM", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\" class=\"small_cnt\">/<input tabindex=\"7034\" id=\"other3StopYy\" name=\"other3SpYY\" " .
             getData ("other3SpYY", "text") .
             " type=\"text\" size=\"2\" maxlength=\"2\" class=\"small_cnt\"></td>
      </tr>
     </table>
    </td>
   </tr>
";

echo "\n</table></div>";

$tabIndex = 8000;
echo "<div id=\"pane6\"><table width=\"100%\">";
include ("medicalEligibility/".$version . ".php");
echo "\n</table></div>";


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
  









$formName = "followup";
echo "
   <div id=\"pane7\"><table  width=\"100%\">
   <tr>
    <td>
     <table class=\"b_header_nb\" width=\"100%\" border=\"0\">
      <tr>
       <td class=\"s_header\">" . $followupComments_1[$lang][0] . "</td>
      </tr>
      <tr>
       <td>
        " . $followupComments_1[$lang][1] . "
       </td>
      </tr>
      <tr>
       <td><textarea tabindex=\"10001\" name=\"followupComments\" cols=\"80\" rows=\"5\">" . getData ("followupComments", "textarea") . "</textarea></td>
      </tr>
	  	  <tr>
			 <td class=\"s_header\"><b>" . $assessmentPlan_header[$lang][4] . "</b></td>
			</tr>
	<tr>
	<td id=\"pprocedureDateFDtTitle\">" . $intervention[$lang][6]. "<input class=\"oh2\" tabindex=\"9999\" id=\"procedureDateFDt\" name=\"procedureDate\" value= \"" .substr($dateProcedure[0],-2)."/".$dateProcedure[1]."/".substr($dateProcedure[2],0,2)."\" type=\"text\" size=\"8\" maxlength=\"8\"\></td>
			</tr>		
	<tr><td><input id=\"cryotherapie\" name=\"cryotherapie\"  tabindex=\"" . ($tabIndex + 5) . "\" " . getData ("cryotherapie", "checkbox", 1) . " type=\"checkbox\" value=\"On\">".$intervention[$lang][1]."</td></tr>
	<tr>   <td><input id=\"leep\" name=\"leep\"  tabindex=\"" . ($tabIndex + 5) . "\" " . getData ("leep", "checkbox", 1) . " type=\"checkbox\" value=\"On\">".$intervention[$lang][2]."</td></tr>
	<tr>   <td><input id=\"thermocoagulation\" name=\"thermocoagulation\"  tabindex=\"" . ($tabIndex + 5) . "\" " . getData ("thermocoagulation", "checkbox", 1) . " type=\"checkbox\" value=\"On\">".$intervention[$lang][3]."</td></tr>
	<tr>   <td><input id=\"conisation\" name=\"conisation\"  tabindex=\"" . ($tabIndex + 5) . "\" " . getData ("conisation", "checkbox", 1) . " type=\"checkbox\" value=\"On\">".$intervention[$lang][4]."</td></tr>
	<tr>   <td><input id=\"hysterectomie\" name=\"hysterectomie\"  tabindex=\"" . ($tabIndex + 5) . "\" " . getData ("hysterectomie", "checkbox", 1) . " type=\"checkbox\" value=\"On\">".$intervention[$lang][5]."</td></tr>	  
     
	  
     </table>
    </td>
   </tr></table>
   </div>";
   $tabIndex = 12500;
  include ("include/nextVisitDate.php");
echo"
</div>";
echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"followup/1.js\"></script>";
?>


