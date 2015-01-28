<?php

$tabIndex = 1000;

echo "
<div id=\"tab-panes\">";

if (!$tabsOn) {
  include ("include/nurseSection.php");
}

echo "
<div id=\"pane1\">
  <table class=\"header\">
   <tr>
    <td valign=\"top\" width=\"69%\">
     <table class=\"b_header_nb\">
	     <tr>
	        <td class=\"s_header\" colspan=\"4\">" . $vitalTemp[$lang][0] . "</td>
	       </tr>
	       <tr>
	        <td id=\"vitalTempTitle\">" . $vitalTemp[$lang][1] . "</td>
	        <td colspan=\"3\"><input tabindex=\"1101\" id=\"vitalTemp\"  name=\"vitalTemp\" " . getData ("vitalTemp", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"><i>" . $vitalTemp[$lang][2] . "</i></td>
	       </tr>
	       <tr>
	        <td  id=\"vitalBp1Title\">" . $vitalBp1[$lang][1] . "</td>
	        <td><table><tr><td><input tabindex=\"1102\" id=\"vitalBp1\" name=\"vitalBp1\" " . getData ("vitalBp1", "text") . " type=\"text\" size=\"10\" maxlength=\"64\">&nbsp;/</td><td  id=\"vitalBp2Title\"></td>
	        <td><input tabindex=\"1103\" id=\"vitalBp2\" name=\"vitalBp2\" " . getData ("vitalBp2", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"></td></tr></table></td>
	        <td id=\"vitalHrTitle\">" . $vitalHr[$lang][1] . "</td>
	        <td><input tabindex=\"1112\" id=\"vitalHr\" name=\"vitalHr\" " . getData ("vitalHr", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"></td>
	       </tr>
	       <tr>
	        <td id=\"vitalWeightTitle\">" . $vitalWeight[$lang][1] . "</td>
	        <td>
	         <table><tr><td>
	          <input tabindex=\"1104\" id=\"vitalWeight\" name=\"vitalWeight\" " .
	            getData ("vitalWeight", "text") .
	            " type=\"text\" size=\"10\" maxlength=\"64\"><i>" .
	          $vitalWeightUnits[$lang][0] .
	          " </td>
	           <td id = \"vitalWeightUnitTitle\"></td><td>
	            <input tabindex=\"1105\" id=\"vitalWeightUnit1\" name=\"vitalWeightUnits[]\" " .
	            getData ("vitalWeightUnits", "radio", 1) .
	            " type=\"radio\" value=\"1\"> " .
	            $vitalWeightUnits[$lang][1] .
	          " <input tabindex=\"1106\" id=\"vitalWeightUnit2\" name=\"vitalWeightUnits[]\" " .
	            getData ("vitalWeightUnits", "radio", 2) .
	            " type=\"radio\" value=\"2\"><i>" .
	            $vitalWeightUnits[$lang][2] . "</i>
	           </td></tr></table>
	          </td>
	        <td id=\"vitalRrTitle\">" . $vitalRr[$lang][1] . "</td>
	        <td><input tabindex=\"1113\" id=\"vitalRr\" name=\"vitalRr\" " . getData ("vitalRr", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"></td>
	       </tr>
	       <tr>
	        <td id=\"vitalPrevWtTitle\">" . $vitalPrevWt[$lang][1] . "</td>
	        <td colspan=\"3\">
	         <table><tr><td>
	          <input tabindex=\"1107\" id=\"vitalPrevWt\" name=\"vitalPrevWt\" " .
	          getData ("vitalPrevWt", "text") .
	          " type=\"text\" size=\"10\" maxlength=\"64\"><i>" . $vitalPrevWtUnits[$lang][0] .
	        " </i>
	        </td>
			<td id=\"vitalPrevWtUnitTitle\"></td><td>
	        <input tabindex=\"1108\" id=\"vitalPrevWtUnit1\" name=\"vitalPrevWtUnits[]\" " .
	          getData ("vitalPrevWtUnits", "radio", 1) .
	          " type=\"radio\" value=\"1\">" .
	          $vitalPrevWtUnits[$lang][1] .
	        " <input tabindex=\"1109\" id=\"vitalPrevWtUnit2\" name=\"vitalPrevWtUnits[]\" " .
	          getData ("vitalPrevWtUnits", "radio", 2) .
	          " type=\"radio\" value=\"2\"><i>" .
	          $vitalPrevWtUnits[$lang][2] . "</i>
	         </td></tr></table></td>
	       </tr>
	       <tr>
	        <td id=\"vitalHeightTitle\">" . $vitalHeight[$lang][0] . "</td>
	        <td colspan=\"3\">
	          <table><tr><td><input tabindex=\"1110\" id=\"vitalHeight\" name=\"vitalHeight\" " . getData ("vitalHeight", "text") . " type=\"text\" size=\"3\" maxlength=\"64\"></td><td id=\"vitalHeightCmTitle\"></td><td><i>" . $vitalHeight[$lang][1] . " <input tabindex=\"1111\" id=\"vitalHeightCm\" name=\"vitalHeightCm\" " . getData ("vitalHeightCm", "text") . " type=\"text\" size=\"3\" maxlength=\"64\">" . $vitalHeight[$lang][2] . "</i></td></tr></table></td>
	       </tr>
     </table>

     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"2\">" . $firstTest[$lang][1] . "</td>
      </tr>
      <tr>
       <td id=\"firstTestDtTitle\">" . $firstTestMm[$lang][0] . "</td>
";
echo "
       <td>
	   <table><tr><td>
       <input tabindex=\"1201\" id=\"firstTestDt\" name=\"firstTestDt\"  value=\"" . getData ("firstTestDd", "textarea") . "/". getData ("firstTestMm", "textarea") ."/". getData ("firstTestYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
       <input 					id=\"firstTestDd\" name=\"firstTestDd\" " . getData ("firstTestDd", "text") . " type=\"hidden\" >
       <input tabindex=\"1202\" id=\"firstTestMm\" name=\"firstTestMm\" " . getData ("firstTestMm", "text") . " type=\"hidden\">
       <input tabindex=\"1203\" id=\"firstTestYy\" name=\"firstTestYy\" " . getData ("firstTestYy", "text") . " type=\"hidden\">
       </td><td><i>" . $firstTestYy[$lang][2] . "</i></td></tr></table>
       </td>";
echo "
      </tr>
      <tr>
       <td>" . $firstTestThisFac[$lang][0] . "</td>
       <td></td>
      </tr>
      <tr>
       <td><input tabindex=\"1204\" id=\"firstTestThisFac\" name=\"firstTestThisFac\" " .
         getData ("firstTestThisFac", "radio") .
         " type=\"radio\" value=\"On\"> ".
         $firstTestThisFac[$lang][1] .
       " <input tabindex=\"1205\" id=\"firstTestOtherFac\" name=\"firstTestOtherFac\" " .
         getData ("firstTestOtherFac", "radio") .
         " type=\"radio\" value=\"On\">" .
         $firstTestOtherFac[$lang][1] . "</td>
       <td><input tabindex=\"1206\" name=\"firstTestOtherFacText\" " . getData ("firstTestOtherFacText", "text") . " type=\"text\" size=\"30\" maxlength=\"255\">" . showValidationIcon ($type, "firstTestOtherFacText") . "</td>
      </tr>
      <tr>
       <td id=\"repeatTestDtTitle\">" . $repeatTestMm[$lang][0] . "</td>
";
echo "
       <td>
		<table><tr><td>
       <input tabindex=\"1207\" id=\"repeatTestDt\" name=\"repeatTestDt\"  value=\"" . getData ("repeatTestDd", "textarea") . "/". getData ("repeatTestMm", "textarea") ."/". getData ("repeatTestYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
       <input 					id=\"repeatTestDd\" name=\"repeatTestDd\" " . getData ("repeatTestDd", "text") . " type=\"hidden\" >
       <input tabindex=\"1208\" id=\"repeatTestMm\" name=\"repeatTestMm\" " . getData ("repeatTestMm", "text") . " type=\"hidden\">
       <input tabindex=\"1209\" id=\"repeatTestYy\" name=\"repeatTestYy\" " . getData ("repeatTestYy", "text") . " type=\"hidden\">
       </td><td><i>" . $firstTestYy[$lang][2] . "</i></td></tr></table>
	   </td>";
echo "
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
     </table>

     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"4\" width=\"70%\">" . $pregnant[$lang][0] . "</td>
      </tr>
      <tr>
       <td colspan=\"2\"><input class=\"oh2\" tabindex=\"1301\" id=\"pregnant1\" name=\"pregnant[]\" " .
         getData ("pregnant", "radio", 1) . " type=\"radio\" value=\"1\">" . $pregnant[$lang][1] .
       "<input class=\"oh2\" tabindex=\"1302\" id=\"pregnant2\" name=\"pregnant[]\" " .
         getData ("pregnant", "radio", 2) . " type=\"radio\" value=\"2\">" . $pregnant[$lang][2] .
       "<input class=\"oh2\" tabindex=\"1303\" id=\"pregnant3\" name=\"pregnant[]\" " .
         getData ("pregnant", "radio", 4) . " type=\"radio\" value=\"4\">" . $pregnant[$lang][3] .
       "</td>
       <td rowspan=\"6\" class=\"vert_line\">&nbsp;</td>
       <td rowspan=\"6\" class=\"left_pad\" width=\"30%\"><i>" . $pregnantNoPrenatal[$lang][1] . "</i></td>
      </tr>
      <tr>
       <td id = \"pregnantLmpDtTitle\">" . $pregnantLmpDd[$lang][0] . "</td>
";
echo "
       <td>
       <table><tr><td>
		<input class=\"oh2\" tabindex=\"1304\" id=\"pregnantLmpDt\" name=\"pregnantLmpDt\" value=\"" . getData ("pregnantLmpDd", "textarea") . "/". getData ("pregnantLmpMm", "textarea") ."/". getData ("pregnantLmpYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
		<input  class=\"femOnly\" id=\"pregnantLmpDd\" name=\"pregnantLmpDd\" " . getData ("pregnantLmpDd", "text") . " type=\"hidden\" >
		<input class=\"femOnly\" tabindex=\"1305\" id=\"pregnantLmpMm\" name=\"pregnantLmpMm\" " . getData ("pregnantLmpMm", "text") . " type=\"hidden\" >
		<input class=\"femOnly\" tabindex=\"1306\" id=\"pregnantLmpYy\" name=\"pregnantLmpYy\" " . getData ("pregnantLmpYy", "text") . " type=\"hidden\" ></td>
       </td><td><i>" . $pregnantLmpYy[$lang][2] . "</i></td></tr></table></td>
";
echo "
      </tr>
      <tr>
       <td colspan=\"2\">" . $pregnantPrenatal[$lang][0] . "</td>
      </tr>
      <tr>
       <td colspan=\"2\"><input class=\"oh2_sub\" tabindex=\"1307\" id=\"pregnantPrenatal1\"  name=\"pregnantPrenatal[]\" " .
         getData ("pregnantPrenatal", "radio", 1) .
         " type=\"radio\" value=\"1\">" .
         $pregnantPrenatal[$lang][1] .
       " <input class=\"oh2_sub\" tabindex=\"1308\" id=\"pregnantPrenatal2\" name=\"pregnantPrenatal[]\" " .
         getData ("pregnantPrenatal", "radio", 2) .
         " type=\"radio\" value=\"2\">" .
         $pregnantPrenatal[$lang][2] .
       "</td>
      </tr>
      <tr>
       <td id=\"pregnantPrenatalFirstDtTitle\">" . $pregnantPrenatalFirstDd[$lang][0] . "</td>
";
echo "
       <td>
       <table><tr><td>
		<input class=\"oh2_sub\" tabindex=\"1309\" id=\"pregnantPrenatalFirstDt\" name=\"pregnantPrenatalFirstDt\" value=\"" . getData ("pregnantPrenatalFirstDd", "textarea") . "/". getData ("pregnantPrenatalFirstMm", "textarea") ."/". getData ("pregnantPrenatalFirstYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
		<input class=\"femOnly\" id=\"pregnantPrenatalFirstDd\" name=\"pregnantPrenatalFirstDd\" " . getData ("pregnantPrenatalFirstDd", "text") . " type=\"hidden\" >
		<input class=\"femOnly\" tabindex=\"1310\" id=\"pregnantPrenatalFirstMm\" name=\"pregnantPrenatalFirstMm\" " . getData ("pregnantPrenatalFirstMm", "text") . " type=\"hidden\" >
		<input class=\"femOnly\" tabindex=\"1311\" id=\"pregnantPrenatalFirstYy\" name=\"pregnantPrenatalFirstYy\" " . getData ("pregnantPrenatalFirstYy", "text") . " type=\"hidden\" ></td>
       </td><td><i>" . $pregnantPrenatalFirstYy[$lang][2] . "</i></td></tr></table></td>
";
echo "
      </tr>
      <tr>
       <td id=\"pregnantPrenatalLastDtTitle\">" . $pregnantPrenatalLastDd[$lang][0] . "</td>
";
echo "
       <td>
	  <table><tr><td>
	   <input class=\"oh2_sub\" tabindex=\"1312\" id=\"pregnantPrenatalLastDt\" name=\"pregnantPrenatalLastDt\" value=\"" . getData ("pregnantPrenatalLastDd", "textarea") . "/". getData ("pregnantPrenatalLastMm", "textarea") ."/". getData ("pregnantPrenatalLastYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
	   <input class=\"femOnly\" id=\"pregnantPrenatalLastDd\" name=\"pregnantPrenatalLastDd\" " . getData ("pregnantPrenatalLastDd", "text") . " type=\"hidden\" >
	   <input class=\"femOnly\" tabindex=\"1313\" id=\"pregnantPrenatalLastMm\" name=\"pregnantPrenatalLastMm\" " . getData ("pregnantPrenatalLastMm", "text") . " type=\"hidden\" >
	   <input class=\"femOnly\" tabindex=\"1314\" id=\"pregnantPrenatalLastYy\" name=\"pregnantPrenatalLastYy\" " . getData ("pregnantPrenatalLastYy", "text") . " type=\"hidden\" ></td>
       </td><td><i>" . $pregnantPrenatalLastYy[$lang][2] . "</i></td></tr></table></td>
";
echo "
      </tr>
     </table>
    </td>
    <td valign=\"top\" class=\"vert_line\" width=\"1%\">&nbsp;</td>
    <td valign=\"top\" class=\"left_pad\" width=\"30%\">
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
      <tr>
";
echo "
       <td>
       <table><tr><td  id=\"firstCareOtherDTTitle\"></td><td>
	   	   <input tabindex=\"1408\" id=\"firstCareOtherDT\" name=\"firstCareOtherDt\" value=\"" . getData ("firstCareOtherDd", "textarea") . "/". getData ("firstCareOtherMm", "textarea") ."/". getData ("firstCareOtherYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
	   	   <input  		         	id=\"firstCareOtherDd\" name=\"firstCareOtherDd\" " . getData ("firstCareOtherDd", "text") . " type=\"hidden\" >
	   	   <input tabindex=\"1409\" id=\"firstCareOtherMm\" name=\"firstCareOtherMm\" " . getData ("firstCareOtherMm", "text") . " type=\"hidden\" >
	   	   <input tabindex=\"1410\" id=\"firstCareOtherYy\" name=\"firstCareOtherYy\" " . getData ("firstCareOtherYy", "text") . " type=\"hidden\" ></td>
       </td><td><i>" . $firstCareOtherYy[$lang][2] . "</i></td></tr></table></td>
";
echo "
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
           getData ("transferOnArv", "radio", 1) .
           " type=\"radio\" value=\"1\">" .
           $transferOnArv[$lang][1] . "
         <input tabindex=\"1414\" name=\"transferOnArv[]\" " .
           getData ("transferOnArv", "radio", 2) .
           " type=\"radio\" value=\"2\">" .
           $transferOnArv[$lang][2] .
      "</td>
      </tr>
     </table>

     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"2\">" . $vaccNone[$lang][0] . "</td>
      </tr>
      <tr>
       <td>" . $vaccHepBMm[$lang][0] . "</td>
       <td><input tabindex=\"1501\" name=\"vaccHepB[]\" " .
           getData("vaccHepB", "radio", 1) .
           " type=\"radio\" value=\"1\">" .
           $vaccHepB[$lang][1] . "
         <input tabindex=\"1502\" name=\"vaccHepB[]\" " .
           getData ("vaccHepB", "radio", 2) .
           " type=\"radio\" value=\"2\">" .
           $vaccHepB[$lang][2] . "
         <input tabindex=\"1503\" name=\"vaccHepB[]\" " .
           getData ("vaccHepB", "radio", 4) .
           " type=\"radio\" value=\"4\">" .
           $vaccHepB[$lang][3] .
       "</td>
      </tr>
      <tr>
       <td id=\"vaccHepBTitle\"></td>
       <td><input tabindex=\"1504\" id=\"vaccHepBMm\" name=\"vaccHepBMm\" " . getData ("vaccHepBMm", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"1505\" id=\"vaccHepBYy\" name=\"vaccHepBYy\" " . getData ("vaccHepBYy", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"> <i>" . $vaccHepBYy[$lang][2] . "</i></td>
      </tr>
      <tr>
       <td>" . $vaccTetanusMm[$lang][0] . "</td>
       <td><input tabindex=\"1506\" name=\"vaccTetanus[]\" " .
           getData ("vaccTetanus", "radio", 1) .
           " type=\"radio\" value=\"1\">" .
           $vaccTetanus[$lang][1] . "
         <input tabindex=\"1507\" name=\"vaccTetanus[]\" " .
           getData ("vaccTetanus", "radio", 2) .
           " type=\"radio\" value=\"2\">" .
           $vaccTetanus[$lang][2] . "
         <input tabindex=\"1508\" name=\"vaccTetanus[]\" " .
           getData ("vaccTetanus", "radio", 4) .
           " type=\"radio\" value=\"4\">" .
           $vaccTetanus[$lang][3] .
      "</td>
      </tr>
      <tr>
       <td id=\"vaccTetanusTitle\"></td>
       <td><input tabindex=\"1509\" id=\"vaccTetanusMm\" name=\"vaccTetanusMm\" " . getData ("vaccTetanusMm", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"1510\" id=\"vaccTetanusYy\" name=\"vaccTetanusYy\" " . getData ("vaccTetanusYy", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"><i>" . $vaccTetanusYy[$lang][2] . "</i></td>
      </tr>
     </table>
    </td>
   </tr>
   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"3\"  id=\"lowestCd4CntTitle\">" . $lowestCd4Cnt[$lang][0] . "</td>
      </tr>
      <tr>
       <td id=\"lowestCd4CntTitle\">" . $lowestCd4Cnt[$lang][1] . "</td>
       <td><input tabindex=\"1601\" id=\"lowestCd4Cnt\" name=\"lowestCd4Cnt\" " . getData ("lowestCd4Cnt", "text") . " type=\"text\" size=\"10\" maxlength=\"64\">" . showValidationIcon ($type, "lowestCd4Cnt") . " " . $lowestCd4Cnt[$lang][2] . "</td>
";
echo "
       <td>" . $lowestCd4CntYy[$lang][0] . "
       <table><tr>
       	   <td id=\"lowestCd4CntDTTitle\">
       	   </td>
       	   <td>
	   	   <input tabindex=\"1602\" id=\"lowestCd4CntDT\" name=\"lowestCd4CntDt\" value=\"" . getData ("lowestCd4CntDd", "textarea") . "/". getData ("lowestCd4CntMm", "textarea") ."/". getData ("lowestCd4CntYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
	   	   <input  		         	id=\"lowestCd4CntDd\" name=\"lowestCd4CntDd\" " . getData ("lowestCd4CntDd", "text") . " type=\"hidden\" >
	   	   <input tabindex=\"1603\" id=\"lowestCd4CntMm\" name=\"lowestCd4CntMm\" " . getData ("lowestCd4CntMm", "text") . " type=\"hidden\" >
	   	   <input tabindex=\"1604\" id=\"lowestCd4CntYy\" name=\"lowestCd4CntYy\" " . getData ("lowestCd4CntYy", "text") . " type=\"hidden\" ></td>
       </td><td><i>" . $lowestCd4CntYy[$lang][2] . "</i></td></tr></table></td>
";
echo "
      </tr>
      <tr>
       <td colspan=\"3\">
         <input tabindex=\"1605\" name=\"lowestCd4CntNotDone\" " .
           getData ("lowestCd4CntNotDone", "checkbox") .
           " type=\"checkbox\" value=\"On\">" .
           $lowestCd4CntNotDone[$lang][1] . "
       </td>
      </tr>
      <tr>
       <td id=\"firstViralLoadTitle\">" . $firstViralLoad[$lang][1] . "</td>
       <td><input tabindex=\"1606\" id=\"firstViralLoad\" name=\"firstViralLoad\" " . getData ("firstViralLoad", "text") . " type=\"text\" size=\"10\" maxlength=\"64\">" . $firstViralLoad[$lang][2] . "</td>
";
echo "
       <td>" . $firstViralLoadYy[$lang][0] . "
		<table><tr>
       	   <td id=\"firstViralLoadDTTitle\">
       	   </td>
       	   <td>
	   	   <input tabindex=\"1607\" id=\"firstViralLoadDT\" name=\"firstViralLoadDt\" value=\"" . getData ("firstViralLoadDd", "textarea") . "/". getData ("firstViralLoadMm", "textarea") ."/". getData ("firstViralLoadYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
	   	   <input  		         	id=\"firstViralLoadDd\" name=\"firstViralLoadDd\" " . getData ("firstViralLoadDd", "text") . " type=\"hidden\" >
	   	   <input tabindex=\"1608\" id=\"firstViralLoadMm\" name=\"firstViralLoadMm\" " . getData ("firstViralLoadMm", "text") . " type=\"hidden\" >
	   	   <input tabindex=\"1609\" id=\"firstViralLoadYy\" name=\"firstViralLoadYy\" " . getData ("firstViralLoadYy", "text") . " type=\"hidden\" ></td>
       </td><td><i>" . $firstViralLoadYy[$lang][2] . "</i></td></tr></table></td>
";
echo "
      </tr>
      <tr>
       <td colspan=\"3\">
         <input tabindex=\"1610\" name=\"firstViralLoadNotDone\" " .
           getData ("firstViralLoadNotDone", "checkbox") .
           " type=\"checkbox\" value=\"On\"> " .
           $firstViralLoadNotDone[$lang][1] . "
       </td>
      </tr>
     </table>
    </td>
   </tr>
";

$tabIndex = 1700;
include ("include/tbStatus.php");

echo "
   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td>" . $lastQuarterSex[$lang][0] . "</td>
       <td>
         <input tabindex=\"1801\" name=\"lastQuarterSex[]\" " .
           getData ("lastQuarterSex", "radio", 1) .
           " type=\"radio\" value=\"1\">" .
           $lastQuarterSex[$lang][1] . "
       </td>
       <td>
         <input tabindex=\"1802\" name=\"lastQuarterSex[]\" " .
           getData ("lastQuarterSex", "radio", 2) .
           " type=\"radio\" value=\"2\">" .
           $lastQuarterSex[$lang][2] . "
       </td>
       <td>
         <input tabindex=\"1803\" name=\"lastQuarterSex[]\" " .
           getData ("lastQuarterSex", "radio", 4) .
           " type=\"radio\" value=\"4\">" .
           $lastQuarterSex[$lang][3] . "
       </td>
      </tr>
      <tr>
       <td>" . $lastQuarterSexWithoutCondom[$lang][0] . "</td>
       <td>
         <input tabindex=\"1804\" name=\"lastQuarterSexWithoutCondom[]\" " .
           getData ("lastQuarterSexWithoutCondom", "radio", 1) .
           " type=\"radio\" value=\"1\">" .
           $lastQuarterSexWithoutCondom[$lang][1] . "
       </td>
       <td>
         <input tabindex=\"1805\" name=\"lastQuarterSexWithoutCondom[]\" " .
           getData ("lastQuarterSexWithoutCondom", "radio", 2) .
           " type=\"radio\" value=\"2\">" .
           $lastQuarterSexWithoutCondom[$lang][2] . "
       </td>
       <td>
         <input tabindex=\"1806\" name=\"lastQuarterSexWithoutCondom[]\" " .
         getData ("lastQuarterSexWithoutCondom", "radio", 4) .
         " type=\"radio\" value=\"4\">" .
         $lastQuarterSexWithoutCondom[$lang][3] . "
       </td>
      </tr>
      <tr>
       <td>" . $lastQuarterSerologicStatusPartner[$lang][0] . "</td>
       <td>
         <input tabindex=\"1807\" name=\"lastQuarterSeroStatPart[]\" " .
           getData ("lastQuarterSeroStatPart", "radio", 1) .
           " type=\"radio\" value=\"1\">" .
           $lastQuarterSerologicStatusPartner[$lang][1] . "
       </td>
       <td>
         <input tabindex=\"1808\" name=\"lastQuarterSeroStatPart[]\" " .
           getData ("lastQuarterSeroStatPart", "radio", 2) .
           " type=\"radio\" value=\"2\">" .
           $lastQuarterSerologicStatusPartner[$lang][2] . "
       </td>
       <td>
         <input tabindex=\"1809\" name=\"lastQuarterSeroStatPart[]\" " .
           getData ("lastQuarterSeroStatPart", "radio", 4) .
           " type=\"radio\" value=\"4\">" .
           $lastQuarterSerologicStatusPartner[$lang][3] . "
       </td>
      </tr>
     </table>
    </td>
   </tr>
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
          <td><input tabindex=\"1901\" id=\"functionalStatus1\"  name=\"functionalStatus[]\" " . getData ("functionalStatus", "radio", 1) . " type=\"radio\" value=\"1\">" . $functionalStatus[$lang][2] . "</td>
         </tr>
         <tr>
          <td><input tabindex=\"1902\" id=\"functionalStatus2\" name=\"functionalStatus[]\" " . getData ("functionalStatus", "radio", 2) . " type=\"radio\" value=\"2\">" . $functionalStatus[$lang][3] . "</td>
         </tr>
         <tr>
          <td ><input tabindex=\"1903\" id=\"functionalStatus4\" name=\"functionalStatus[]\" " . getData ("functionalStatus", "radio", 4) . " type=\"radio\" value=\"4\">" . $functionalStatus[$lang][4] . "</td>
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
            <input tabindex=\"2009\" id=\"famPlanMethodTubalLig1\" name=\"famPlanMethodTubalLig[]\" " .
              getData ("famPlanMethodTubalLig", "radio", 1) .
              " type=\"radio\" value=\"1\" class=\"famPlan\">" .
              $famPlanMethodTubalLig[$lang][1] . "
            <input tabindex=\"2010\" id=\"famPlanMethodTubalLig2\" name=\"famPlanMethodTubalLig[]\" " .
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
            <input tabindex=\"2003\" id=\"famPlanMethodCondom1\"  name=\"famPlanMethodCondom[]\" " .
              getData ("famPlanMethodCondom", "radio", 1) .
              " type=\"radio\" value=\"1\" class=\"famPlan\">" .
              $famPlanMethodCondom[$lang][2] . "
            <input tabindex=\"2004\" id=\"famPlanMethodCondom2\" name=\"famPlanMethodCondom[]\" " .
              getData ("famPlanMethodCondom", "radio", 2) .
              " type=\"radio\" value=\"2\" class=\"famPlan\">" .
              $famPlanMethodCondom[$lang][3] . "
          </td>
          <td valign=\"top\" rowspan=\"3\">
            <input tabindex=\"2012\" id=\"famPlanOtherText\"  name=\"famPlanOtherText\" " . getData ("famPlanOtherText", "text") . " type=\"text\" size=\"30\" maxlength=\"255\" class=\"famPlan\"></td>
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
     </table>
    </td>
   </tr>
   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"5\">" . $riskassessment_header[$lang][1] . "</td>
      </tr>
      <tr>
       <td colspan=\"5\">" . $riskassessment_subhead1[$lang][1] . "</td>
      </tr>
      <tr>";
        $where = getEncounterWhere ($eid, $pid);
      	queryBlock($lang, $where, 0, 2500, 3000);
      echo "
     </table>
    </td>
   </tr>
  </table>
  </div>
";

if (!$tabsOn) {
  include ("include/doctorSection.php");
}

$tabIndex = 3000;
echo "
  <div id=\"pane2\">
  <table class=\"header\">";
include ("symptoms/adult.php");
 echo "
 </table>
</div>";

$tabIndex = 4000;
echo "
  <div id=\"pane3\">
  <table class=\"header\">";
include ("include/conditions.php");
echo "
	</table>
	</div>";

$tabIndex = 5000;
echo "
  <div id=\"pane4\">
  <table class=\"header\">";
include ("clinicalExam/pmtct.php");
echo "
</table>
</div>

<!-- *************************************************************** -->
<!-- ******************** Medication Allergies ******************* -->
<!-- **************** (tab indices 6001 - 7000) ****************** -->
<!-- ***************************************************************** -->

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
         <input tabindex=\"6001\" id=\"noneTreatments\" name=\"noneTreatments\" " . getData ("noneTreatments", "checkbox") . " type=\"checkbox\" value=\"On\">" . showValidationIcon ($type, "noneTreatments") . " " . $noneTreatments[$lang][2] . "</td>
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

$tabIndex = 6100;
for ($i = 1; $i <= $max_allergies; $i++) {
  echo "
      <tr>
       <td><input  class=\"medAllergy\" tabindex=\"" . ($tabIndex + 1) . "\"  name=\"aMed$i\" " . getData ("aMed" . $i, "text") . " type=\"text\" size=\"30\" maxlength=\"255\"></td>
       <td><table><tr><td  id=\"aMed" . $i . "StartTitle\">&nbsp;</td><td><input  class=\"medAllergy\" tabindex=\"" . ($tabIndex + 2) . "\" id=\"aMed" . $i . "StartMM\" name=\"aMed" . $i . "MM\" " . getData ("aMed" . $i . "MM", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input  class=\"medAllergy\" tabindex=\"" . ($tabIndex + 3) . "\" id=\"aMed" . $i . "StartYY\" name=\"aMed" . $i . "YY\" " . getData ("aMed" . $i . "YY", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"></td></tr></table></td>
       <td><table><tr><td  id=\"aMed" . $i . "StopTitle\">&nbsp;</td><td><input tabindex=\"" . ($tabIndex + 4) . "\"  class=\"medAllergy\" id=\"aMed" . $i . "StopMM\" name=\"aMed" . $i . "SpMM\" " . getData ("aMed" . $i . "SpMM", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input  class=\"medAllergy\" tabindex=\"" . ($tabIndex + 5) . "\" id=\"aMed" . $i . "StopYY\" name=\"aMed" . $i . "SpYY\" " . getData ("aMed" . $i . "SpYY", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"></td></tr></table></td>
       <td align=\"center\">
         <input  class=\"medAllergy\" tabindex=\"" . ($tabIndex + 6) . "\" name=\"aMed" . $i . "Rash\" " . getData ("aMed" . $i . "Rash", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input  class=\"medAllergy\" tabindex=\"" . ($tabIndex + 7) . "\" name=\"aMed" . $i . "RashF\" " . getData ("aMed" . $i . "RashF", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input  class=\"medAllergy\" tabindex=\"" . ($tabIndex + 8) . "\" name=\"aMed" . $i . "ABC\" " . getData ("aMed" . $i . "ABC", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input  class=\"medAllergy\" tabindex=\"" . ($tabIndex + 9) . "\" name=\"aMed" . $i . "Hives\" " . getData ("aMed" . $i . "Hives", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input  class=\"medAllergy\" tabindex=\"" . ($tabIndex + 10) . "\" name=\"aMed" . $i . "SJ\" " . getData ("aMed" . $i . "SJ", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input  class=\"medAllergy\" tabindex=\"" . ($tabIndex + 11) . "\" name=\"aMed" . $i . "Anaph\" " . getData ("aMed" . $i . "Anaph", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input  class=\"medAllergy\" tabindex=\"" . ($tabIndex + 12) . "\" name=\"aMed" . $i . "Other\" " . getData ("aMed" . $i . "Other", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
      </tr>";
  $tabIndex += 12;
}

echo "
      <tr>
       <td colspan=\"10\">" . $aMedOther[$lang][1] . " <input tabindex=\"6201\" class=\"medAllergy\" name=\"aMedOther\" " . getData ("aMedOther", "text") . " type=\"text\" size=\"120\" maxlength=\"255\">" . showValidationIcon ($type, "aMedOther") . "</td>
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
      </tr>
     </table>
    </td>
   </tr>";
echo "
</table>
</div>";

// Treatment
echo "
  <div id=\"pane6\">
	<table class=\"header\">";
$arv_rows = arvRows (7001);
include ("include/arvs.php");
echo "
   </table>
  </div>";

$tabIndex = 10000;
echo "
   <div id=\"pane7\">
     <table class=\"header\">";
include ("include/medicalEligibility.php");
echo "
	</table>
  </div>";

echo "
  <div id=\"pane8\">
  <table class=\"header\">
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
       <td><textarea tabindex=\"11101\" name=\"assessmentPlan\" cols=\"80\" rows=\"5\">" . getData ("assessmentPlan", "textarea") . "</textarea></td>
      </tr>
     </table>
    </td>
   </tr>
  </table>
 </div>
</div>
";

$formName = "intake";

$tabIndex = 21000;
include ("include/nextVisitDate.php");
echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"intake/0.js\"></script>";
?>
