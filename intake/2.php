<?php
if ($tabsOn) {
  echo $tabHeaders;
}
echo "
<div id=\"tab-panes\">
";
$date=explode('-',getData ("cancerColon", "textarea"));
$dateProcedure=explode('-',getData ("procedureDate", "textarea"));

$date0=explode('-',getData ("surveillanceTbDatemois0", "textarea"));
$date1=explode('-',getData ("surveillanceTbDatemois1", "textarea"));
$date2=explode('-',getData ("surveillanceTbDatemois2", "textarea"));
$date3=explode('-',getData ("surveillanceTbDatemois3", "textarea"));
$date4=explode('-',getData ("surveillanceTbDatemois4", "textarea"));
$date5=explode('-',getData ("surveillanceTbDatemois5", "textarea"));



if (!$tabsOn) {
  include ("include/nurseSection.php");
}
echo"
<div id=\"pane1\">
  <table class=\"header\">
   <tr>
    <td valign=\"top\" width=\"60%\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"4\">" . $vitalTemp[$lang][0] . "</td>
      </tr>
      <tr><td>&nbsp;</td></tr>
      <tr>
	    <td id=\"vitalTempTitle\" width=\"5%\">" . $vitalTemp[$lang][1] . "</td>
	    <td colspan=\"3\" width=\"45%\"><table><tr><td><input tabindex=\"1101\"  id=\"vitalTemp\" name=\"vitalTemp\" " . getData ("vitalTemp", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"> <span ><i>" . $vitalTempUnits[$lang][0] . " </td><td id=\"vitalTempUnitTitle\"></td><td><input tabindex=\"1103\" id=\"vitalTempUnit1\" name=\"vitalTempUnits[]\" " . getData ("vitalTempUnits", "radio", 1) . " type=\"radio\" value=\"1\"> " . $vitalTempUnits[$lang][1] . " <input tabindex=\"1104\" id=\"vitalTempUnit2\" name=\"vitalTempUnits[]\" " . getData ("vitalTempUnits", "radio", 2) . " type=\"radio\" value=\"2\">" . $vitalTempUnits[$lang][2] . "</i></span></td></tr></table>
      </tr>
      <tr>
       <td id=\"vitalBp1Title\">" . $vitalBp1[$lang][1] . "</td>
       <td colspan=\"3\"><table><tr><td><input tabindex=\"1105\" id=\"vitalBp1\" name=\"vitalBp1\" " . getData ("vitalBp1", "text") . " type=\"text\" size=\"10\" maxlength=\"64\">&nbsp;/</td><td  id=\"vitalBp2Title\"></td>
       <td><input tabindex=\"1106\" id=\"vitalBp2\" name=\"vitalBp2\" " . getData ("vitalBp2", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"></td><td><span><i>" . $vitalBPUnits[$lang][0] . " <td id=\"vitalBpUnitTitle\"></td><td><input tabindex=\"1107\" id=\"vitalBpUnit1\" name=\"vitalBPUnits[]\" " . getData ("vitalBPUnits", "radio", 1) . " type=\"radio\" value=\"1\">" . $vitalBPUnits[$lang][1] . " <input tabindex=\"1108\" id=\"vitalBpUnit2\" name=\"vitalBPUnits[]\" " . getData ("vitalBPUnits", "radio", 2) . " type=\"radio\" value=\"2\">" . $vitalBPUnits[$lang][2] . "</i></span></td></tr></table></td>
      </tr>
      <tr>
       <td id=\"vitalHrTitle\">" . $vitalHr[$lang][1] . "</td>
       <td><input tabindex=\"1109\" id=\"vitalHr\" name=\"vitalHr\" " . getData ("vitalHr", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"></td>
       <td id=\"vitalWeightTitle\">" . $vitalWeight[$lang][1] . "</td>
       <td>
        <table><tr><td>
         <input tabindex=\"1110\"  id=\"vitalWeight\" name=\"vitalWeight\" " .
           getData ("vitalWeight", "text") .
           " type=\"text\" size=\"10\" maxlength=\"64\"><i>" .
         $vitalWeightUnits[$lang][0] .
         " </td><td id = \"vitalWeightUnitTitle\" > </td><td>
         <input tabindex=\"1111\" id=\"vitalWeightUnit1\" name=\"vitalWeightUnits[]\" " .
           getData ("vitalWeightUnits", "radio", 1) .
           " type=\"radio\" value=\"1\">" .
           $vitalWeightUnits[$lang][1] .
         " <input tabindex=\"1112\" id=\"vitalWeightUnit2\" name=\"vitalWeightUnits[]\" " .
           getData ("vitalWeightUnits", "radio", 2) .
           " type=\"radio\" value=\"2\">" .
           showValidationIcon ($type, "vitalWeightUnits") . " " .
           $vitalWeightUnits[$lang][2] . "</i></td></tr></table></td>
      </tr>
      <tr>
       <td id=\"vitalRrTitle\">" . $vitalRr[$lang][1] . "</td>
       <td><input tabindex=\"1113\" id=\"vitalRr\" name=\"vitalRr\" " . getData ("vitalRr", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"></td>
       <td id=\"vitalPrevWtTitle\">" . $vitalPrevWt[$lang][1] . "</td>
       <td><table><tr><td><input tabindex=\"1114\" id=\"vitalPrevWt\" name=\"vitalPrevWt\" " .
         getData ("vitalPrevWt", "text") .
         " type=\"text\" size=\"10\" maxlength=\"64\"></span> <span><i>" . $vitalPrevWtUnits[$lang][0] .
       "
       </td><td id = \"vitalPrevWtUnitTitle\" ></td><td>
       <input tabindex=\"1115\" id=\"vitalPrevWtUnit1\" name=\"vitalPrevWtUnits[]\" " .
         getData ("vitalPrevWtUnits", "radio", 1) .
         " type=\"radio\" value=\"1\">" .
         $vitalPrevWtUnits[$lang][1] .
       " <input tabindex=\"1116\" id=\"vitalPrevWtUnit2\" name=\"vitalPrevWtUnits[]\" " .
         getData ("vitalPrevWtUnits", "radio", 2) .
         " type=\"radio\" value=\"2\">" .
         $vitalPrevWtUnits[$lang][2] . "</i>
         </td></tr></table></td>
      </tr>
      <tr>
       <td id=\"vitalHeightTitle\">" . $vitalHeight[$lang][0] . "</td>
       <td  colspan=\"3\"><table><tr><td><input tabindex=\"1117\" id=\"vitalHeight\" name=\"vitalHeight\" " . getData ("vitalHeight", "text") . " type=\"text\" size=\"3\" maxlength=\"64\"></td><td  id=\"vitalHeightCmTitle\"> <i>" . $vitalHeight[$lang][1] . "</i></td><td> <input tabindex=\"1118\" id=\"vitalHeightCm\" name=\"vitalHeightCm\" " . getData ("vitalHeightCm", "text") . " type=\"text\" size=\"3\" maxlength=\"64\"><i>" . $vitalHeight[$lang][2] . "</i></td></tr></table></td>
      </tr>
      <tr><td>&nbsp;</td></tr>
     </table>
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"2\">" . $firstTest[$lang][1] . "</td>
      </tr>
      <tr>&nbsp;</tr>
      <tr>
       <td id=\"firstTestDtTitle\">" . $firstTestMm[$lang][0] . "</td>
       <td><table><tr><td><input tabindex=\"1201\" id=\"firstTestDt\" name=\"firstTestDt\" value=\"" . getData ("firstTestDd", "textarea") . "/". getData ("firstTestMm", "textarea") ."/". getData ("firstTestYy", "textarea") . "\"  type=\"text\" size=\"8\" maxlength=\"8\"><input id=\"firstTestDd\" name=\"firstTestDd\" type=\"hidden\" ><input tabindex=\"1202\" id=\"firstTestMm\" name=\"firstTestMm\"  type=\"hidden\" ><input tabindex=\"1203\" id=\"firstTestYy\" name=\"firstTestYy\"  type=\"hidden\" ></td><td> <i>" . $firstTestYy[$lang][2] . "</i></td></tr></table></td>
";
echo "
      </tr>
      <tr>
       <td>" . $firstTestThisFac[$lang][0] . "</td>
       <td></td>
      </tr>
      <tr>
       <td><input tabindex=\"1204\" id=\"firstTestThisFac\" name=\"firstTestThisFac\" " .
         getData ("firstTestThisFac", "radio") .
         " type=\"radio\" value=\"On\">" .
         $firstTestThisFac[$lang][1] .
       " <input tabindex=\"1205\" id=\"firstTestOtherFac\" name=\"firstTestOtherFac\" " .
         getData ("firstTestOtherFac", "radio") .
         " type=\"radio\" value=\"On\">" .
         $firstTestOtherFac[$lang][1] . "</td>
       <td><input tabindex=\"1206\" name=\"firstTestOtherFacText\" " . getData ("firstTestOtherFacText", "text") . " type=\"text\" size=\"30\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td id = \"repeatTestDtTitle\">" . $repeatTestMm[$lang][0] . "</td>
       <td><table><tr><td><input tabindex=\"1207\" id=\"repeatTestDt\" name=\"repeatTestDt\"  value=\"" . getData ("repeatTestDd", "textarea") . "/". getData ("repeatTestMm", "textarea") ."/". getData ("repeatTestYy", "textarea") . "\"  type=\"text\" size=\"8\" maxlength=\"8\"><input id=\"repeatTestDd\" name=\"repeatTestDd\" " . getData ("repeatTestDd", "text") . " type=\"hidden\" ><input tabindex=\"1208\" id=\"repeatTestMm\" name=\"repeatTestMm\" " . getData ("repeatTestMm", "text") . " type=\"hidden\"><input tabindex=\"1209\" id=\"repeatTestYy\" name=\"repeatTestYy\" " . getData ("repeatTestYy", "text") . " type=\"hidden\" ></td><td> <i>" . $repeatTestYy[$lang][2] . "</i></td></tr></table></td>
      </tr>
      <tr>
       <td>" . $firstTestResultsReceived[$lang][0] . "</td>
       <td><input tabindex=\"1210\" name=\"firstTestResultsReceived[]\" " .
         getData ("firstTestResultsReceived", "radio", 1) .
         " type=\"radio\" value=\"1\">" .
         $firstTestResultsReceived[$lang][1] .
       " <input tabindex=\"1211\" name=\"firstTestResultsReceived[]\" " .
         getData ("firstTestResultsReceived", "radio", 2) .
         " type=\"radio\" value=\"2\">" .
         $firstTestResultsReceived[$lang][2] . "</td>
	  </tr>
     </table>
    </td>
<!-- ******************************************************************** -->
<!-- ******************** Referral ****************************** -->
<!-- ******************** (tab indices 1400 - 1500) ******************** -->
<!-- ******************************************************************** -->
    <td valign=\"top\" class=\"vert_line\" width=\"1%\">&nbsp;</td>
    <td valign=\"top\" class=\"left_pad\" width=\"39%\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"2\">" . $referSelf[$lang][0] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"1401\" name=\"referHosp\" " .
             getData ("referHosp", "checkbox") .
             " type=\"checkbox\" value=\"On\">" .
             $referHosp[$lang][1] .
      "</td>
      </tr>
      <tr>
       <td><input tabindex=\"1402\" name=\"referVctCenter\" " .
          getData ("referVctCenter", "checkbox") .
          " type=\"checkbox\" value=\"On\">" .
          $referVctCenter[$lang][1] . "
       </td>
      </tr>
      <tr>
       <td><input tabindex=\"1403\" name=\"referPmtctProg\" " .
           getData ("referPmtctProg", "checkbox") .
           " type=\"checkbox\" value=\"On\">" . $referPmtctProg[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"1404\" name=\"referOutpatStd\" " .
            getData ("referOutpatStd", "checkbox") .
            " type=\"checkbox\" value=\"On\">" .
            $referOutpatStd[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"1405\" name=\"referCommunityBasedProg\" " .
          getData ("referCommunityBasedProg", "checkbox") .
          " type=\"checkbox\" value=\"On\">" . $referCommunityBasedProg[$lang][1] . "</td>
      </tr>
      <tr>
       <td colspan=\"2\"><table><tr><td id=\"transferInTitle\"></td><td><input tabindex=\"1406\" id=\"transferIn\" name=\"transferIn\" " .
         getData ("transferIn", "checkbox") .
         " type=\"checkbox\" value=\"On\"><b>" .
         $transferIn[$lang][1] .
      "  </b></td></tr></table>
       </td>
      </tr>
      <tr>
       <td>" . $firstCareOtherFacText[$lang][1] . "</td>
      </tr>
      <tr>
       <td><table><tr><td id=\"firstCareOtherFacTextTitle\"></td><td><input tabindex=\"1407\" id=\"firstCareOtherFacText\" name=\"firstCareOtherFacText\" " . getData ("firstCareOtherFacText", "text") . " type=\"text\" size=\"30\" maxlength=\"255\"></td></tr></table></td>
      </tr>
      <tr>
       <td>" . $firstCareOtherMm[$lang][0] . "</td>
      </tr>
      <tr >
       <td><table><tr><td id=\"firstCareOtherDTTitle\"></td><td><input tabindex=\"1408\" id=\"firstCareOtherDT\" name=\"firstCareOtherDt\"  value=\"" . getData ("firstCareOtherDd", "textarea") . "/". getData ("firstCareOtherMm", "textarea") ."/". getData ("firstCareOtherYy", "textarea") . "\"  type=\"text\" size=\"8\" maxlength=\"8\"><input id=\"firstCareOtherDd\" name=\"firstCareOtherDd\" " . getData ("firstCareOtherDd", "text") . " type=\"hidden\"><input tabindex=\"1409\" id=\"firstCareOtherMm\" name=\"firstCareOtherMm\" " . getData ("firstCareOtherMm", "text") . " type=\"hidden\"><input tabindex=\"1410\" id=\"firstCareOtherYy\" name=\"firstCareOtherYy\"  type=\"hidden\"></td><td><i>" . $firstCareOtherYy[$lang][2] . "</i></td></tr></table></td>
      </tr>
      <tr>
       <td>" . $medRecord[$lang][0] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"1411\" name=\"medRecord[]\" " .
           getData ("medRecord", "radio", 1) .
           " type=\"radio\" value=\"1\">" .
           $medRecord[$lang][1] . "
         <input tabindex=\"1412\" name=\"medRecord[]\" " .
           getData ("medRecord", "radio", 2) .
           " type=\"radio\" value=\"2\">" .
           $medRecord[$lang][2] .
       "</td>
      </tr>
      <tr>
       <td>" . $transferOnArv[$lang][0] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"1413\" name=\"transferOnArv[]\" " .
           getData ("transferOnArv", "checkbox", 1) .
           " type=\"radio\" value=\"1\">" .
           $transferOnArv[$lang][1] . "
         <input tabindex=\"1414\" name=\"transferOnArv[]\" " . getData ("transferOnArv", "radio", 2) . " type=\"radio\" value=\"2\">" . $transferOnArv[$lang][2] .
      "</td>
      </tr>
	   <tr> 
	     <td> ".$arvTransfer[$lang][0]."
	        <input  tabindex=\"1519\" id=\"debutArtReference\" name=\"debutArtReference\"  type=\"date\" value=\"" . getData ("debutArtReference", "textarea", 0) . "\" />			
        </td>
	   </tr>
     </table>
    </td>
   </tr>
<!-- ******************************************************************** -->
<!-- ******************** Pregnancy ******************** -->
<!-- ******************** (tab indices 1501 - 1600) ******************** -->
<!-- ******************************************************************** -->
	<tr>
	 <td colspan=\"5\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"8\">" . $pregnant1[$lang][0] . "</td>
      </tr>
      <tr>
      	<td id=\"gravidaTitle\">" . $pregnant1[$lang][1] . "</td>
       <td><input tabindex=\"1500\" type=\"text\" id=\"gravida\" class=\"oh1\" name=\"gravida\" size=\"4\" " . getData ("gravida", "text") . " />
       <td rowspan=\"6\" class=\"vert_line\">&nbsp;</td>
       <td rowspan=\"6\" class=\"left_pad\"></td>
       <td><table><tr><td colspan=\"2\"><b> " . $ConcerColonStatus[$lang][6]. "</b> : <input class=\"oh3\" tabindex=\"1600\" id=\"screeneddone1\" name=\"screeneddone[]\" " . getData ("screeneddone", "radio", 1) . " type=\"radio\" value=\"1\" />" . $pregnantPrenatal[$lang][1]. "
			<input class=\"oh3\" tabindex=\"1601\" id=\"screeneddone2\" name=\"screeneddone[]\" " . getData ("screeneddone", "radio", 2) . " type=\"radio\" value=\"2\" />" . $pregnantPrenatal[$lang][2] . " </td>
		   		</tr></table></td>
      </tr>
      <tr>
       <td id=\"paraTitle\">" . $pregnant1[$lang][2] . "</td>
       <td><input class=\"oh1\" tabindex=\"1505\" type=\"text\" id=\"para\" name=\"para\" size=\"4\" " . getData ("para", "text") . " />
       <td id=\"papTestTitle\">" . $ConcerColonStatus[$lang][5] . "<input class=\"oh2\" tabindex=\"1513\" type=\"text\" id=\"papTestDT\" name=\"cancerColon\" value= \"" .substr($date[0],-2)."/".$date[1]."/".substr($date[2],0,2)."\" type=\"text\" size=\"8\" maxlength=\"8\"></td>
       <td>" . $pregnant1[$lang][8] . "</td>
      </tr>
      <tr>
       <td id=\"abortaTitle\">" . $pregnant1[$lang][3] . "</td>
       <td><input class=\"oh1\" tabindex=\"1506\" type=\"text\" id=\"aborta\" name=\"aborta\" size=\"4\" " . getData ("aborta", "text") . " /></td>
       <td>".$ConcerColonStatus[$lang][4]."
	   <input class=\"oh2\" tabindex=\"1519\" id=\"screenedMethode1\" name=\"screenedMethode[]\" " . getData ("screenedMethode", "radio", 1) . " type=\"radio\" value=\"1\" />" . $ConcerColonStatus[$lang][7] . "
			<input class=\"oh2\" tabindex=\"1520\" id=\"screenedMethode2\" name=\"screenedMethode[]\" " . getData ("screenedMethode", "radio", 2) . " type=\"radio\" value=\"2\" />" . $ConcerColonStatus[$lang][8] . "<br /> <span style=\"white-space: nowrap;\">
			 ". $ConcerColonStatus[$lang][3] . " : <span style=\"white-space: nowrap;\">
			<input class=\"oh3\" tabindex=\"1521\" id=\"cancerColonStatus1\" name=\"cancerColonStatus[]\" " . getData ("cancerColonStatus", "radio", 1) . " type=\"radio\" value=\"1\" />" . $ConcerColonStatus[$lang][0] . "
			<input class=\"oh3\" tabindex=\"1522\" id=\"cancerColonStatus2\" name=\"cancerColonStatus[]\" " . getData ("cancerColonStatus", "radio", 2) . " type=\"radio\" value=\"2\" />" . $ConcerColonStatus[$lang][1] . "
			<input class=\"oh3\" tabindex=\"1523\" id=\"cancerColonStatus3\" name=\"cancerColonStatus[]\" " . getData ("cancerColonStatus", "radio", 4) . " type=\"radio\" value=\"4\" />" . $ConcerColonStatus[$lang][2] .
       "</span>	</td>
			
       <td id=\"pregnantLmpTitle\"><table><tr><td id=\"pregnantLmpDtTitle\"></td><td><input class=\"oh2\" tabindex=\"1510\" id=\"pregnantLmpDt\" name=\"pregnantLmpDt\" value=\"" . getData ("pregnantLmpDd", "textarea") . "/". getData ("pregnantLmpMm", "textarea") ."/". getData ("pregnantLmpYy", "textarea") . "\"  type=\"text\" size=\"8\" maxlength=\"8\"><input class=\"femOnly\" id=\"pregnantLmpDd\" name=\"pregnantLmpDd\"  type=\"hidden\"><input tabindex=\"1511\" id=\"pregnantLmpMm\" name=\"pregnantLmpMm\"  type=\"hidden\" ><input class=\"femOnly\" tabindex=\"1512\" id=\"pregnantLmpYy\" name=\"pregnantLmpYy\"  type=\"hidden\"> </td><td><i>" . $pregnantPrenatalFirstYy[$lang][2] . "</i></td></tr></table></td>
      </tr>
      <tr>
        <td  id=\"childrenTitle\">" . $pregnant1[$lang][4] . "</td>
       <td><input class=\"oh1\" tabindex=\"1513\" type=\"text\" id=\"children\" name=\"children\" size=\"4\" " . getData ("children", "text") . " />
	  		<td colspan=\"2\">" . $pregnant1[$lang][9] . "
				<input class=\"oh3\" tabindex=\"1514\" id=\"pregnantPrenatal1\" name=\"pregnantPrenatal[]\" " . getData ("pregnantPrenatal", "radio", 1) . " type=\"radio\" value=\"1\">" . $pregnantPrenatal[$lang][1] . "
				<input class=\"oh3\" tabindex=\"1515\" id=\"pregnantPrenatal2\" name=\"pregnantPrenatal[]\" " . getData ("pregnantPrenatal", "radio", 2) . " type=\"radio\" value=\"2\">" . $pregnantPrenatal[$lang][2] .
       "</td>
       </tr>
       <tr>	   
	  <td colspan=\"2\">" . $pregnant1[$lang][5] . "<br /><span style=\"white-space: nowrap;\">
			<input class=\"oh3\" tabindex=\"1516\" id=\"pregnant1\" name=\"pregnant[]\" " . getData ("pregnant", "radio", 1) . " type=\"radio\" value=\"1\" />" . $pregnant[$lang][1] . "
			<input class=\"oh3\" tabindex=\"1517\" id=\"pregnant2\" name=\"pregnant[]\" " . getData ("pregnant", "radio", 2) . " type=\"radio\" value=\"2\" />" . $pregnant[$lang][2] . "
			<input class=\"oh3\" tabindex=\"1518\" id=\"pregnant3\" name=\"pregnant[]\" " . getData ("pregnant", "radio", 4) . " type=\"radio\" value=\"4\" />" . $pregnant[$lang][3] .
       "</span></td>
       <td colspan=\"2\"><i>" . $pregnant1[$lang][10] . "</i></td>
      </tr>
	  
     </table>
    </td>
   </tr>
<!-- ******************************************************************** -->
<!-- ******************** Functionality & Family Planning ******************** -->
<!-- ******************** (tab indices 1901-2008) ******************** -->
<!-- ******************************************************************** -->
   <tr>
    <td colspan=\"3\">
     <table>
      <tr>
       <td valign=\"top\" width=\"50%\">
        <table class=\"b_header_nb\">
         <tr>
          <td class=\"s_header\">" . $functionalStatus[$lang][0] . "</td>
         </tr>
         <tr>
          <td><table><tr><td id=\"functionalStatusTitle\"></td><td><i>" . $functionalStatus[$lang][1] . "</i></td></tr></table></td>
         </tr>
         <tr>
          <td><input tabindex=\"1901\" id=\"functionalStatus1\" name=\"functionalStatus[]\" " . getData ("functionalStatus", "radio", 1) . " type=\"radio\" value=\"1\">" . $functionalStatus[$lang][2] . "</td>
         </tr>
         <tr>
          <td><input tabindex=\"1902\" id=\"functionalStatus2\" name=\"functionalStatus[]\" " . getData ("functionalStatus", "radio", 2) . " type=\"radio\" value=\"2\">" . $functionalStatus[$lang][3] . "</td>
         </tr>
         <tr>
          <td><input tabindex=\"1903\" id=\"functionalStatus4\" name=\"functionalStatus[]\" " . getData ("functionalStatus", "radio", 4) . " type=\"radio\" value=\"4\">" . $functionalStatus[$lang][4] . "</td>
         </tr>
        </table>
       </td>
       <td valign=\"top\" class=\"vert_line\">&nbsp;</td>
       <td valign=\"top\" class=\"left_pad\" width=\"50%\">
        <table class=\"b_header_nb\">
         <tr>
          <td class=\"s_header\" colspan=\"3\">" . $famPlan[$lang][0] . "</td>
         </tr>
         <tr>
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
         <tr>
          <td colspan=\"2\"><b>" . $famPlanMethodCondom[$lang][0] . "</b></td>
          <td>
            <input tabindex=\"2011\" id=\"famPlanOther\" name=\"famPlanOther\" " .
              getData ("famPlanOther", "radio") .
              " type=\"radio\" value=\"On\" class=\"famPlan\">" .
              $famPlanOther[$lang][1] . "
          </td>
         </tr>
         <tr>
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
         <tr>
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
         <tr>
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
       </td>
      </tr>
    </td>
   </tr>
<!-- ******************************************************************** -->
<!-- ******************** Risk Assessment ******************** -->
<!-- ******************** (tab indices 6001 - 7000) ******************** -->
<!-- ******************************************************************** -->
";
echo "
   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"5\">" . $intakeSectLabs1[$lang][6] . "</td>
      </tr>
      <tr>";
      	$where = getEncounterWhere ($eid, $pid);
      	queryBlock($lang, $where, 1, 2500, 3000);
	  echo "
	  	</tr>
     </table>
    </td>
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
   
<!-- ******************************************************************** -->
<!-- ******************** SEX Last 3 Months ******************** -->
<!-- ******************** (tab indices 7001 - 8000) ******************** -->
<!-- ******************************************************************** -->
   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"8\">" . $riskassessment_subhead2[$lang][1] . "</td>
      </tr>
      <tr>
       <td>" . $lastQuarterSex[$lang][0] . "</td>
       <td>
         <input tabindex=\"7801\" name=\"lastQuarterSex[]\" " .
           getData ("lastQuarterSex", "radio", 1) .
           " type=\"radio\" value=\"1\"> " .
           $lastQuarterSex[$lang][1] . "
       </td>
       <td>
         <input tabindex=\"7802\" name=\"lastQuarterSex[]\" " .
           getData ("lastQuarterSex", "radio", 2) .
           " type=\"radio\" value=\"2\">" .
           $lastQuarterSex[$lang][2] . "
       </td>
       <td>
         <input tabindex=\"7803\" name=\"lastQuarterSex[]\" " .
           getData ("lastQuarterSex", "radio", 4) .
           " type=\"radio\" value=\"4\">" .
           $lastQuarterSex[$lang][3] . "
       </td>
	  <td class=\"left_pad\">" . $lastQuarterSerologicStatusPartner[$lang][0] . "</td>
	  <td>
		<input tabindex=\"7807\" name=\"lastQuarterSeroStatPart[]\" " .
		  getData ("lastQuarterSeroStatPart", "radio", 1) .
		  " type=\"radio\" value=\"1\">" .
		  $lastQuarterSerologicStatusPartner[$lang][1] . "
	  </td>
	  <td>
		<input tabindex=\"7808\" name=\"lastQuarterSeroStatPart[]\" " .
		  getData ("lastQuarterSeroStatPart", "radio", 2) .
		  " type=\"radio\" value=\"2\">" .
		  $lastQuarterSerologicStatusPartner[$lang][2] . "
	  </td>
	  <td>
		<input tabindex=\"7809\" name=\"lastQuarterSeroStatPart[]\" " .
		  getData ("lastQuarterSeroStatPart", "radio", 4) .
		  " type=\"radio\" value=\"4\">" .
		  $lastQuarterSerologicStatusPartner[$lang][3] . "
       </td>
      </tr>
      <tr>
       <td>" . $lastQuarterSexWithoutCondom[$lang][0] . "</td>
       <td>
         <input tabindex=\"7810\" name=\"lastQuarterSexWithoutCondom[]\" " .
           getData ("lastQuarterSexWithoutCondom", "radio", 1) .
           " type=\"radio\" value=\"1\">" .
           $lastQuarterSexWithoutCondom[$lang][1] . "
       </td>
       <td>
         <input tabindex=\"7811\" name=\"lastQuarterSexWithoutCondom[]\" " .
           getData ("lastQuarterSexWithoutCondom", "radio", 2) .
           " type=\"radio\" value=\"2\">" .
           $lastQuarterSexWithoutCondom[$lang][2] . "
       </td>
       <td>
         <input tabindex=\"7812\" name=\"lastQuarterSexWithoutCondom[]\" " .
         getData ("lastQuarterSexWithoutCondom", "radio", 4) .
         " type=\"radio\" value=\"4\">" .
          $lastQuarterSexWithoutCondom[$lang][3] . "
       </td>
      </tr>
     </table>
    </td>
   </tr>
<!-- ******************************************************************** -->
<!-- ******************** CD4 Status ******************** -->
<!-- ******************** (tab indices 8001 - 9000) ******************** -->
<!-- ******************************************************************** -->
   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"3\">" . $lowestCd4Cnt[$lang][0] . "</td>
      </tr>
      <tr>
       <td id=\"lowestCd4CntTitle\">" . $lowestCd4Cnt[$lang][1] . "</td>
       <td><input tabindex=\"8001\" id=\"lowestCd4Cnt\" name=\"lowestCd4Cnt\" " . getData ("lowestCd4Cnt", "text") . " type=\"text\" size=\"10\" maxlength=\"64\">" . $lowestCd4Cnt[$lang][2] . "
	   </td>
	   <td>" . $lowestCd4CntYy[$lang][0] . "<table><tr><td id=\"lowestCd4CntDTTitle\"></td><td><input tabindex=\"8002\" id=\"lowestCd4CntDT\" name=\"lowestCd4CntDt\"  type=\"text\" size=\"8\" maxlength=\"8\" value=\"".getData ("lowestCd4CntDd", "textarea") ."/". getData ("lowestCd4CntMm", "textarea") ."/". getData ("lowestCd4CntYy", "textarea") ."\" ><input  id=\"lowestCd4CntDd\" name=\"lowestCd4CntDd\"  type=\"hidden\" ><input tabindex=\"8003\" id=\"lowestCd4CntMm\" name=\"lowestCd4CntMm\"  type=\"hidden\" ><input tabindex=\"8004\" id=\"lowestCd4CntYy\" name=\"lowestCd4CntYy\" type=\"hidden\" ></td><td><i>" . $lowestCd4CntYy[$lang][2] . "</i></td></tr></table></td>
	   </td>
      </tr>
      <tr>
       <td colspan=\"3\">
         <input tabindex=\"8005\" name=\"lowestCd4CntNotDone\" " .
           getData ("lowestCd4CntNotDone", "checkbox") .
           " type=\"checkbox\" value=\"On\"> " .
           $lowestCd4CntNotDone[$lang][1] . "
       </td>
      </tr>
      <tr>
       <td id=\"firstViralLoadTitle\">" . $firstViralLoad[$lang][1] . "</td>
       <td><input tabindex=\"8006\" id=\"firstViralLoad\" name=\"firstViralLoad\" " . getData ("firstViralLoad", "text") . " type=\"text\" size=\"10\" maxlength=\"64\">" . $firstViralLoad[$lang][2] . "</td>
       <td>" . $firstViralLoadYy[$lang][0] . "<table><tr><td id=\"firstViralLoadDTTitle\"></td><td><input tabindex=\"8007\" id=\"firstViralLoadDT\" name=\"firstViralLoadDt\"  type=\"text\" size=\"8\" maxlength=\"8\" value=\"".getData ("firstViralLoadDd", "textarea") ."/". getData ("firstViralLoadMm", "textarea") ."/". getData ("firstViralLoadYy", "textarea") ."\" ><input id=\"firstViralLoadDd\" name=\"firstViralLoadDd\"  type=\"hidden\" ><input tabindex=\"8008\" id=\"firstViralLoadMm\" name=\"firstViralLoadMm\"  type=\"hidden\" ><input tabindex=\"8009\" id=\"firstViralLoadYy\" name=\"firstViralLoadYy\"  type=\"hidden\" ></td><td><i>" . $firstViralLoadYy[$lang][2] . "</i></td></tr></table></td>
";
echo "
	  </tr>
      <tr>
       <td colspan=\"3\">
         <input tabindex=\"8010\" name=\"firstViralLoadNotDone\" " .
           getData ("firstViralLoadNotDone", "checkbox") .
           " type=\"checkbox\" value=\"On\">" .
           $firstViralLoadNotDone[$lang][1] . "
       </td>
      </tr>
     </table>
    </td>
   </tr>
";
$tabIndex = 9001;
include ("include/tbStatus_followup.php");
echo "</tr>
<!-- ******************************************************************** -->
<!-- ******************** Vaccinations ******************** -->
<!-- ******************** (tab indices 10001 - 11000) ******************** -->
<!-- ******************************************************************** -->
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"10\">" . $vaccNone[$lang][0] . "</td>
      </tr>
      <tr>
      	<td id=\"vaccHepBRadioTitle\" valign=\"top\">&nbsp;</td>
       <td>" . $vaccHepBMm[$lang][0] . "&nbsp;
       	 <input tabindex=\"11001\" id=\"vaccHepB1\" name=\"vaccHepB[]\" " . getData("vaccHepB", "radio", 1) . " type=\"radio\" value=\"1\">" . $vaccHepB[$lang][1] . "
         <input tabindex=\"11002\" id=\"vaccHepB2\" name=\"vaccHepB[]\" " . getData ("vaccHepB", "radio", 2) . " type=\"radio\" value=\"2\">" . $vaccHepB[$lang][2] . "
         <input tabindex=\"11003\" id=\"vaccHepB3\" name=\"vaccHepB[]\" " . getData ("vaccHepB", "radio", 4) . " type=\"radio\" value=\"4\">" . $vaccHepB[$lang][3] .
       "<br />
       <table><tr><td  id=\"vaccHepBTitle\"></td><td><input tabindex=\"11004\" id=\"vaccHepBMm\" name=\"vaccHepBMm\" " . getData ("vaccHepBMm", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"11005\" id=\"vaccHepBYy\" name=\"vaccHepBYy\" " . getData ("vaccHepBYy", "text") . " type=\"text\" size=\"2\" maxlength=\"2\" > <i>" . $vaccHepBYy[$lang][2] . "</i>&nbsp;&nbsp;" . $doseLabel[$lang][0] . "&nbsp;</td><td id=\"hepBdosesTitle\"></td><td><input tabindex=\"11006\" id=\"hepBdoses\" name=\"hepBdoses\" " . getData("hepBdoses", "text") . " size=\"2\"></td></tr></table>
       </td>
       <td rowspan=\"2\" class=\"vert_line\">&nbsp;</td>
       <td id=\"vaccTetanusRadioTitle\"  valign=\"top\">&nbsp;</td>
       <td valign=\"top\">" . $vaccTetanusMm[$lang][0] . "
         <input tabindex=\"11007\" id=\"vaccTetanus1\" name=\"vaccTetanus[]\" " .
           getData ("vaccTetanus", "radio", 1) .
           " type=\"radio\" value=\"1\">" .
           $vaccTetanus[$lang][1] . "
         <input tabindex=\"11008\" id=\"vaccTetanus2\" name=\"vaccTetanus[]\" " .
           getData ("vaccTetanus", "radio", 2) .
           " type=\"radio\" value=\"2\">" .
           $vaccTetanus[$lang][2] . "
         <input tabindex=\"11009\" id=\"vaccTetanus3\" name=\"vaccTetanus[]\" " .
           getData ("vaccTetanus", "checkbox", 4) .
           " type=\"radio\" value=\"4\">" .
           $vaccTetanus[$lang][3] .
      "<br />
      <table><tr><td id=\"vaccTetanusTitle\"></td><td><input tabindex=\"11010\" id=\"vaccTetanusMm\" name=\"vaccTetanusMm\" " . getData ("vaccTetanusMm", "text") . " type=\"text\" size=\"2\" maxlength=\"2\" >/<input tabindex=\"11011\" id=\"vaccTetanusYy\" name=\"vaccTetanusYy\" " . getData ("vaccTetanusYy", "text") . " type=\"text\" size=\"2\" maxlength=\"2\" > <i>" . $vaccTetanusYy[$lang][2] . "</i>&nbsp;&nbsp;" . $doseLabel[$lang][0] . "&nbsp;</td><td id=\"tetDosesTitle\"></td><td><input tabindex=\"11012\" id=\"tetDoses\" name=\"tetDoses\" " . getData("tetDoses", "text") . " size=\"2\"></td></tr></table></td>
        <td rowspan=\"2\" class=\"vert_line\">&nbsp;</td>
        <td>" . $otherVaccLabel[$lang][0] . "<br /><input tabindex=\"11013\" name=\"otherVaccination\" " . getData("otherVaccination", "text") . " size=\"20\"></td>
      </tr>
     </table>
	 </td>
	</tr>
  </table>
</div>
";
if (!$tabsOn) {
  include ("include/doctorSection.php");
}
// symptoms                    tabstart:12000
echo "
<div id=\"pane2\">
 <table class=\"header\">";
$tabIndex = 12000;
include ("symptoms/adult.php");
echo "
	</table>
  </div>";
// Physical/TB Eval            tabstart:13000
echo "
<div id=\"pane3\">
  <table class=\"header\">";
$tabIndex = 13000;
include ("include/clinicalExam.php");
echo "
<!-- ******************************************************************** -->
<!-- ******************** TB Evaluation ******************** -->
<!-- ******************** (tab indices 14001 - 15000) ******************** -->
<!-- ******************************************************************** -->
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
         <input tabindex=\"14001\" name=\"presenceBCG\" " .
           getData ("presenceBCG", "checkbox", 0) .
           " type=\"checkbox\" value=\"1\">" .
           $tbEval[$lang][2] . "
       </td>
       <td>
         <input tabindex=\"14002\" name=\"suspicionTBwSymptoms\" " .
           getData ("suspicionTBwSymptoms", "checkbox", 0) .
           " type=\"checkbox\" value=\"1\">" .
           $tbEval[$lang][3] . "
       </td>
      </tr>
      <tr>
       <td>
         <input tabindex=\"14003\" name=\"recentNegPPD\" " .
           getData ("recentNegPPD", "checkbox", 0) .
           " type=\"checkbox\" value=\"1\">" .
           $tbEval[$lang][4] . "
       </td>
       <td>
         <input tabindex=\"14004\" name=\"noTBsymptoms\" " .
           getData ("noTBsymptoms", "checkbox", 0) .
           " type=\"checkbox\" value=\"1\">" .
           $tbEval[$lang][5] . "
       </td>
      </tr>
      <tr>
       <td>
         <input tabindex=\"14005\" name=\"statusPPDunknown\" " .
           getData ("statusPPDunknown", "checkbox", 0) .
           " type=\"checkbox\" value=\"1\">" .
           $tbEval[$lang][6] . "
       </td>
       <td> &nbsp;</td>
      </tr>
	  <tr>
	  <td style=\"font-weight:bold\">
       		" . $tbEval[$lang][11] . "
       </td>
      </tr>
      <tr>
       <td>
        <table>
         <tr>
          <td id=\"propINHTitle\"></td>
          <td>
			 <input tabindex=\"14006\" id=\"propINH\" name=\"propINH\" " .
			   getData ("propINH", "checkbox", 0) .
			   " type=\"checkbox\" value=\"1\">" .
			   $tbEval[$lang][7] . "
          </td>
         </tr>
        </table>
       </td>
       <td>" . $tbEval[$lang][8] . "<table><tr><td id=\"debutINHStartTitle\"></td><td><input tabindex=\"14007\" id=\"debutINHStartMM\" name=\"debutINHMm\" " . getData ("debutINHMm", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"14008\" id=\"debutINHStartYY\"  name=\"debutINHYy\" " . getData ("debutINHYy", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"><i>" . $tbEval[$lang][9] . "</i></td></tr></table>
       </td>
       <td>" .
           $tbEval[$lang][10] . "<table><tr><td id=\"debutINHStopTitle\"></td><td><input tabindex=\"14009\" id=\"debutINHStopMM\" name=\"arretINHMm\" " . getData ("arretINHMm", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"14010\" id=\"debutINHStopYY\" name=\"arretINHYy\" " . getData ("arretINHYy", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"> " . $tbEval[$lang][9] . "</td></tr></table>
       </td>
       <td>
       		&nbsp;
       </td>
      </tr>
      <tr>
       <td>
        <table>
         <tr>
          <td id=\"propINHRifaTitle\"></td>
          <td>
			 <input tabindex=\"14006\" id=\"propINHRifa\" name=\"propINHRifa\" " .
			   getData ("propINHRifa", "checkbox", 0) .
			   " type=\"checkbox\" value=\"1\">" .
			   $tbEval[$lang][12] . "
          </td>
         </tr>
        </table>
       </td>
       <td colspan=\"1\">" . $tbEval[$lang][8] . "<table><tr><td id=\"debutINHRifaStartTitle\"></td><td><input tabindex=\"14007\" id=\"debutINHRifaStartMM\" name=\"debutINHRifaMm\" " . getData ("debutINHRifaMm", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"14008\" id=\"debutINHRifaStartYY\"  name=\"debutINHRifaYy\" " . getData ("debutINHRifaYy", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"><i>" . $tbEval[$lang][9] . "</i></td></tr></table></td>
       </td>
       <td>" .
           $tbEval[$lang][10] . "<table><tr><td id=\"debutINHRifaStopTitle\"></td><td><input tabindex=\"14009\" id=\"debutINHRifaStopMM\" name=\"arretINHRifaMm\" " . getData ("arretINHRifaMm", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"14010\" id=\"debutINHRifaStopYY\" name=\"arretINHRifaYy\" " . getData ("arretINHRifaYy", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"> " . $tbEval[$lang][9] . "</td></tr></table>
       </td>
       <td>
       		&nbsp;
       </td>
      </tr>
	  
	  <tr>
	  <td style=\"font-weight:bold\">
       		" . $tbEval[$lang][13] . "
       </td>
      </tr>
      <tr>
       <td>
        <table>
         <tr>
          <td id=\"propINHTitle\"></td>
          <td>
			 <input tabindex=\"14006\" id=\"propSecINH\" name=\"propSecINH\" " .
			   getData ("propSecINH", "checkbox", 0) .
			   " type=\"checkbox\" value=\"1\">" .
			   $tbEval[$lang][7] . "
          </td>
         </tr>
        </table>
       </td>
       <td>" . $tbEval[$lang][8] . "<table><tr><td id=\"debutSecINHStartTitle\"></td><td><input tabindex=\"14007\" id=\"debutSecINHStartMM\" name=\"debutSecINHMm\" " . getData ("debutSecINHMm", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"14008\" id=\"debutSecINHStartYY\"  name=\"debutSecINHYy\" " . getData ("debutSecINHYy", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"><i>" . $tbEval[$lang][9] . "</i></td></tr></table>
       </td>
       <td>" .
           $tbEval[$lang][10] . "<table><tr><td id=\"debutSecINHStopTitle\"></td><td><input tabindex=\"14009\" id=\"debutSecINHStopMM\" name=\"arretSecINHMm\" " . getData ("arretSecINHMm", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"14010\" id=\"debutSecINHStopYY\" name=\"arretSecINHYy\" " . getData ("arretSecINHYy", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"> " . $tbEval[$lang][9] . "</td></tr></table>
       </td>
       <td>
       		&nbsp;
       </td>
      </tr>
	  
	  
	  
     </table>
    <td>
   </tr>
   
   
</table>
</div>";
// Conditions                  tabstart:15000
echo "
<div id=\"pane4\">
  <table class=\"header\">";
$tabIndex = 15000;
include ("conditions/1.php");
echo "
	</table>
</div>";
// Medication Allergies        tabs 16001-17000
echo "
<div id=\"pane5\">
  <table class=\"header\">
   <tr>
    <td>
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"10\">" . $noneTreatments[$lang][1] . "</td>
      </tr>
      <tr>
       <td colspan=\"3\">
         <input tabindex=\"16001\" name=\"noneTreatments\" id=\"noneTreatments\" " . getData ("noneTreatments", "checkbox") . " type=\"checkbox\"  value=\"On\">" . $noneTreatments[$lang][2] . "</td>
       <td colspan=\"7\"><b>" . $noneTreatments[$lang][3] . "</b></td>
      </tr>
      <tr>
       <td class=\"sm_header_lt\">" . $allergies_subhead3[$lang][0] . "</td>
       <td class=\"sm_header_lt\">" . $allergies_subhead3[$lang][1] . "</td>
       <td class=\"sm_header_lt\">" . $allergies_subhead3[$lang][2] . "</td>
       <td class=\"sm_header_cnt\">" . $allergies_subhead12[$lang][1] . "</td>
       <td class=\"sm_header_cnt\">" . $allergies_subhead13[$lang][1] . "</td>
       <td class=\"sm_header_cnt\">" . $allergies_subhead14[$lang][1] . "</td>
       <td class=\"sm_header_cnt\">" . $allergies_subhead15[$lang][1] . "</td>
       <td class=\"sm_header_cnt\">" . $allergies_subhead16[$lang][1] . "</td>
       <td class=\"sm_header_cnt\">" . $allergies_subhead17[$lang][1] . "</td>
       <td class=\"sm_header_cnt\">" . $allergies_subhead18[$lang][1] . "</td>
      </tr>
";
$tabIndex = 16100;
for ($i = 1; $i <= $max_allergies; $i++) {
  echo "
      <tr>
       <td><input class=\"medAllergy\" tabindex=\"" . ($tabIndex + 1) . "\" name=\"aMed$i\" " . getData ("aMed" . $i, "text") . " type=\"text\" size=\"30\" maxlength=\"255\"></td>
       <td><table><tr><td  id=\"aMed" . $i . "StartTitle\">&nbsp;</td><td><input class=\"medAllergy\" tabindex=\"" . ($tabIndex + 2) . "\" id=\"aMed" . $i . "StartMM\" name=\"aMed" . $i . "MM\" " . getData ("aMed" . $i . "MM", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input class=\"medAllergy\" tabindex=\"" . ($tabIndex + 3) . "\" id=\"aMed" . $i . "StartYY\" name=\"aMed" . $i . "YY\" " . getData ("aMed" . $i . "YY", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"></td></tr></table></td>
       <td><table><tr><td  id=\"aMed" . $i . "StopTitle\">&nbsp;</td><td><input class=\"medAllergy\" tabindex=\"" . ($tabIndex + 4) . "\" id=\"aMed" . $i . "StopMM\" name=\"aMed" . $i . "SpMM\" " . getData ("aMed" . $i . "SpMM", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 5) . "\" id=\"aMed" . $i . "StopYY\" name=\"aMed" . $i . "SpYY\" " . getData ("aMed" . $i . "SpYY", "text") . " type=\"text\" size=\"2\" maxlength=\"2\" class=\"medAllergy\"></td></tr></table></td>
       <td align=\"center\">
         <input class=\"medAllergy\" tabindex=\"" . ($tabIndex + 6) . "\" name=\"aMed" . $i . "Rash\" " . getData ("aMed" . $i . "Rash", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input class=\"medAllergy\" tabindex=\"" . ($tabIndex + 7) . "\" name=\"aMed" . $i . "RashF\" " . getData ("aMed" . $i . "RashF", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input class=\"medAllergy\" tabindex=\"" . ($tabIndex + 8) . "\" name=\"aMed" . $i . "ABC\" " . getData ("aMed" . $i . "ABC", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input class=\"medAllergy\" tabindex=\"" . ($tabIndex + 9) . "\" name=\"aMed" . $i . "Hives\" " . getData ("aMed" . $i . "Hives", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input class=\"medAllergy\" tabindex=\"" . ($tabIndex + 10) . "\" name=\"aMed" . $i . "SJ\" " . getData ("aMed" . $i . "SJ", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input class=\"medAllergy\" tabindex=\"" . ($tabIndex + 11) . "\" name=\"aMed" . $i . "Anaph\" " . getData ("aMed" . $i . "Anaph", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input class=\"medAllergy\" tabindex=\"" . ($tabIndex + 12) . "\" name=\"aMed" . $i . "Other\" " . getData ("aMed" . $i . "Other", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
      </tr>";
  $tabIndex += 12;
}
echo "
      <tr>
       <td  colspan=\"10\">" . $aMedOther[$lang][1] . " <input class=\"medAllergy\" tabindex=\"16201\" name=\"aMedOther\" " . getData ("aMedOther", "text") . " type=\"text\" size=\"120\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td colspan=\"10\" align=\"center\" class=\"top_line\">
        <table class=\"b_header_nb\">
         <tr>
          <th>" . $allergies_subhead4[$lang][1] . "</th>
          <td>" . $allergies_subhead5[$lang][1] . "</td>
          <td>" . $allergies_subhead6[$lang][1] . "</td>
          <td>" . $allergies_subhead7[$lang][1] . "</td>
         </tr>
         <tr>
          <td>&nbsp;</td>
          <td>" . $allergies_subhead8[$lang][1] . "</td>
          <td>" . $allergies_subhead9[$lang][1] . "</td>
          <td>" . $allergies_subhead10[$lang][1] . "</td>
         </tr>
        </table>
       </td>
      </tr>";
if($mf==1)	  
	 echo 
	 "<tr>
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
      </tr>"; 
	  
	  
	  echo "
	  
	  
     </table>
    </td>
   </tr>
 </table>
</div>";
// Treatments                  tabstart:17001
echo "
<div id=\"pane6\">
  <table class=\"header\">";
$arv_rows = arvRows (17005);
include ("include/arvs.php");
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
    <td><input  tabindex=\"5523\" id=\"surveillanceTbDatemois0\" name=\"surveillanceTbDatemois0\"  type=\"date\" value=\"" . substr(getData ("surveillanceTbDatemois0", "textarea"),0,10) . "\" /></td>
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
    <td><input  tabindex=\"5524\" id=\"surveillanceTbDatemois1\" name=\"surveillanceTbDatemois1\"  type=\"date\" value=\"" . substr(getData ("surveillanceTbDatemois1", "textarea"),0,10) . "\" /></td>
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
    <td><input  tabindex=\"5525\" id=\"surveillanceTbDatemois2\" name=\"surveillanceTbDatemois2\"  type=\"date\" value=\"" .substr(getData ("surveillanceTbDatemois2", "textarea"),0,10)."\" /></td>
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
    <td><input  tabindex=\"5526\" id=\"surveillanceTbDatemois3\" name=\"surveillanceTbDatemois3\"  type=\"date\" value=\"" .substr(getData ("surveillanceTbDatemois3", "textarea"),0,10). "\" /></td>
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
    <td><input  tabindex=\"5527\" id=\"surveillanceTbDatemois4\" name=\"surveillanceTbDatemois4\"  type=\"date\" value=\"" .substr(getData ("surveillanceTbDatemois4", "textarea"),0,10). "\" /></td>
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
    <td><input  tabindex=\"5528\" id=\"surveillanceTbDatemois5\" name=\"surveillanceTbDatemois5\"  type=\"date\" value=\"" .substr(getData ("surveillanceTbDatemois5", "textarea"),0,10). "\" /></td>
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
    <td><input  tabindex=\"5523\" id=\"surveillanceTbDatemois6\" name=\"surveillanceTbDatemois6\"  type=\"date\" value=\"" .substr(getData ("surveillanceTbDatemois6", "textarea"),0,10). "\" /></td>
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
    <td><input  tabindex=\"5529\" id=\"surveillanceTbDateFinTx\" name=\"surveillanceTbDateFinTx\"  type=\"date\" value=\"" .substr(getData ("surveillanceTbDateFinTx", "textarea"),0,10). "\" /></td>
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
   
  
  
  
  
// Eligibility                 tabstart:20000
echo "
<div id=\"pane7\">
  <table class=\"header\">";
$tabIndex = 20000;
include ("medicalEligibility/".$version . ".php");
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
  
  
// Plan                        tabstart:20009
echo "
<div id=\"pane8\">
  <table class=\"header\">";
$formName = "intake";
echo "
   <tr>
    <td>
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\">&nbsp;</td>
      </tr>
   </table>
   </table>
";
$tabIndex = 21000;
include ("include/nextVisitDate.php");
echo "
  <table class=\"header\">
   <tr>
		<td>
		 <table>
			<tr>
			 <td><b>" . $labOrDrugForm[$lang][0] . "</b></td>
			</tr>
			<tr>
       <td><input tabindex=\"22000\" id=\"labOrDrugForm1\" name=\"labOrDrugForm1\" " . getData ("labOrDrugForm", "radio", 1) . " type=\"radio\" value=\"1\">" . $labOrDrugForm[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"22001\" id=\"labOrDrugForm2\" name=\"labOrDrugForm1\" " . getData ("labOrDrugForm", "radio", 2) . " type=\"radio\" value=\"2\">" . $labOrDrugForm[$lang][2] . "</td>
	      </tr>
				<tr>
				 <td><b>" . $labOrDrugForm[$lang][3] . "</b></td>
				</tr>
				<tr>
	       <td><input tabindex=\"22002\" id=\"labOrDrugForm4\" name=\"labOrDrugForm2\" " . getData ("labOrDrugForm", "radio", 4) . " type=\"radio\" value=\"4\">" . $labOrDrugForm[$lang][4] . "</td>
	      </tr>
	      <tr>
	       <td><input tabindex=\"22003\" id=\"labOrDrugForm8\" name=\"labOrDrugForm2\" " . getData ("labOrDrugForm", "radio", 8) . " type=\"radio\" value=\"8\">" . $labOrDrugForm[$lang][5] . "
	       <input type=\"hidden\" id=\"labOrDrugForm\" name=\"labOrDrugForm\" value = \"". getData ("labOrDrugForm", "textarea") . "\" > </td>
		  </tr>
		  <tr><td>&nbsp;</td></tr>
	     </table>
	    </td>
   </tr>
   <tr>
    <td>
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\">" . $assessmentPlan_header[$lang][2] . "</td>
      </tr>
      <tr>
       <td><i>" . $assessmentPlan_header[$lang][3] . "</i></td>
      </tr>
      <tr>
       <td><textarea tabindex=\"22004\" name=\"assessmentPlan\" cols=\"80\" rows=\"5\">" . getData ("assessmentPlan", "textarea") . "</textarea></td>
      </tr>
	  <tr>
		<td class=\"s_header\">" . $assessmentPlan_header[$lang][4] . "</td>
	  </tr>
			
		<tr>
	<td >" . $intervention[$lang][6]. "<input class=\"oh3\" tabindex=\"1599\" type=\"text\" id=\"expFromD1\" name=\"procedureDate\" value= \"" .substr($dateProcedure[0],-2)."/".$dateProcedure[1]."/".substr($dateProcedure[2],0,2)."\" type=\"text\" size=\"8\" maxlength=\"8\"></td>
			</tr>			
	<tr><td><input type=\"checkbox\" id=\"cryotherapie\" name=\"cryotherapie\"  tabindex=\"" . ($tabIndex + 5) . "\" " . getData ("cryotherapie", "checkbox", 1) . " type=\"checkbox\" value=\"On\">".$intervention[$lang][1]."</td></tr>
	<tr>   <td><input type=\"checkbox\" id=\"leep\" name=\"leep\"  tabindex=\"" . ($tabIndex + 5) . "\" " . getData ("leep", "checkbox", 1) . " type=\"checkbox\" value=\"On\">".$intervention[$lang][2]."</td></tr>
	<tr>   <td><input type=\"checkbox\" id=\"thermocoagulation\" name=\"thermocoagulation\"  tabindex=\"" . ($tabIndex + 5) . "\" " . getData ("thermocoagulation", "checkbox", 1) . " type=\"checkbox\" value=\"On\">".$intervention[$lang][3]."</td></tr>
	<tr>   <td><input type=\"checkbox\" id=\"conisation\" name=\"conisation\"  tabindex=\"" . ($tabIndex + 5) . "\" " . getData ("conisation", "checkbox", 1) . " type=\"checkbox\" value=\"On\">".$intervention[$lang][4]."</td></tr>
	<tr>   <td><input type=\"checkbox\" id=\"hysterectomie\" name=\"hysterectomie\"  tabindex=\"" . ($tabIndex + 5) . "\" " . getData ("hysterectomie", "checkbox", 1) . " type=\"checkbox\" value=\"On\">".$intervention[$lang][5]."</td></tr>	  
     </table>
    </td>
   </tr>
  </table>
  </div>
  </div>
  ";
  echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"intake/1.js\"></script>";
?>