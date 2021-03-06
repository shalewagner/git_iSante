<?php
$encType = 16;
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
<!-- ********************* Medical History of Mother ******************** -->
<!-- ********************* (tab indices 1101 - 1600) ******************** -->
<!-- ******************************************************************** -->

   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"5\">" . $pedMotherHistory[$lang][1] . "</td>
      </tr>
      <tr>
	    <td colspan=\"5\" width=\"100%\"><input tabindex=\"1101\" id=\"pedMotherHistUnk\" name=\"pedMotherHistUnk\" " . getData ("pedMotherHistUnk", "checkbox") . " type=\"checkbox\" value=\"1\">" . $pedMotherHistUnk[$lang][1] . "</td>
      </tr>
      <tr>
       <td width=\"25%\" id=\"pedMotherHistDobDtTitle\">" . $pedMotherHistDob[$lang][0] . "</td>
       <td width=\"20%\">
       <table><tr><td><input tabindex=\"1201\" class=\"pedMotherHist\" id=\"pedMotherHistDobDt\" name=\"pedMotherHistDobDt\"
       value=\"" . getData ("pedMotherHistDobDd", "textarea") . "/" . getData ("pedMotherHistDobMm", "textarea") . "/" .getData ("pedMotherHistDobYy", "textarea") . "\"
       type=\"text\" size=\"8\" maxlength=\"8\">
       <input id=\"pedMotherHistDobDd\" name=\"pedMotherHistDobDd\" " . getData ("pedMotherHistDobDd", "text") . " type=\"hidden\"><input tabindex=\"1202\" id=\"pedMotherHistDobMm\" name=\"pedMotherHistDobMm\" " . getData ("pedMotherHistDobMm", "text") . " type=\"hidden\"><input tabindex=\"1203\" id=\"pedMotherHistDobYy\" name=\"pedMotherHistDobYy\" " . getData ("pedMotherHistDobYy", "text") . " type=\"hidden\"></td><td><i>" . $jma[$lang][1] . "</i></td></tr></table></td>
       <td width=\"5%\"></td>
       <td width=\"25%\" id=\"pedMotherHistAgeTitle\"><i>" . $pedMotherHistAge[$lang][0] . "</i></td>
       <td width=\"25%\"><input tabindex=\"1204\" class=\"pedMotherHist\" id=\"pedMotherHistAge\" name=\"pedMotherHistAge\" " . getData ("pedMotherHistAge", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"></td>
      </tr>
      <tr>
       <td colspan=\"5\" width=\"100%\"><b>" . $pedMotherHistTb[$lang][0] . "</b></td>
      </tr>
      <tr>
	    <td width=\"25%\">" . $pedMotherHistTb[$lang][1] . "</td>
	    <td width=\"20%\"><span ><input class=\"pedMotherHist\" tabindex=\"1301\" name=\"pedMotherHistRecentTb[]\" " . getData ("pedMotherHistRecentTb", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input tabindex=\"1302\" class=\"pedMotherHist\" name=\"pedMotherHistRecentTb[]\" " . getData ("pedMotherHistRecentTb", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input tabindex=\"1303\" class=\"pedMotherHist\" name=\"pedMotherHistRecentTb[]\" " . getData ("pedMotherHistRecentTb", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</span></td>
       <td width=\"5%\"></td>
       <td width=\"25%\" ><i>" . $pedMotherHistTb[$lang][2] . "</i></td>
       <td width=\"25%\" ><input tabindex=\"1304\" class=\"pedMotherHist\" name=\"pedMotherHistTreatTb[]\" " . getData ("pedMotherHistTreatTb", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input class=\"pedMotherHist\" tabindex=\"1305\" name=\"pedMotherHistTreatTb[]\" " . getData ("pedMotherHistTreatTb", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . "</td>
      </tr>
      <tr>
	    <td width=\"25%\">" . $pedMotherHistTb[$lang][3] . "</td>
	    <td width=\"20%\"><span ><input tabindex=\"1306\" class=\"pedMotherHist\" name=\"pedMotherHistActiveTb[]\" " . getData ("pedMotherHistActiveTb", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input class=\"pedMotherHist\" tabindex=\"1307\" name=\"pedMotherHistActiveTb[]\" " . getData ("pedMotherHistActiveTb", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input class=\"pedMotherHist\" tabindex=\"1308\" name=\"pedMotherHistActiveTb[]\" " . getData ("pedMotherHistActiveTb", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</span></td>
       <td width=\"5%\"></td>
       <td width=\"25%\" id=\"pedMotherHistTreatTbDtTitle\"><i>" . $pedMotherHistTb[$lang][4] . "</i></td>
       <td width=\"25%\">
       <table><tr><td>
        <input class=\"pedMotherHist\" tabindex=\"1309\" id=\"pedMotherHistTreatTbDt\" name=\"pedMotherHistTreatTbDt\"
          value=\"" . getData ("pedMotherHistTreatTbDd", "textarea") . "/" . getData ("pedMotherHistTreatTbMm", "textarea") . "/" .getData ("pedMotherHistTreatTbYy", "textarea") . "\"
          type=\"text\" size=\"8\" maxlength=\"8\">
       <input id =\"pedMotherHistTreatTbDd\" name=\"pedMotherHistTreatTbDd\" " . getData ("pedMotherHistTreatTbDd", "text") . " type=\"hidden\">
       <input tabindex=\"1310\" id=\"pedMotherHistTreatTbMm\" name=\"pedMotherHistTreatTbMm\" " . getData ("pedMotherHistTreatTbMm", "text") . " type=\"hidden\">
       <input tabindex=\"1311\" id=\"pedMotherHistTreatTbYy\" name=\"pedMotherHistTreatTbYy\" " . getData ("pedMotherHistTreatTbYy", "text") . " type=\"hidden\">
       </td>
       <td><i>" . $jma[$lang][1] . "</i>
       </td>
       </tr></table></td>
      </tr>
      <tr>
       <td colspan=\"5\" width=\"100%\"><b>" . $pedMotherHistGros[$lang][0] . "</b></td>
      </tr>
      <tr>
       <td colspan=\"5\" width=\"100%\">
        <table>
         <tr>
          <td>" . $pedMotherHistGros[$lang][1] . "</td><td id=\"pedMotherHistGrosGravTitle\"></td>
          <td><input class=\"pedMotherHist\" tabindex=\"1401\" id=\"pedMotherHistGrosGrav\" name=\"pedMotherHistGrosGrav\" " . getData ("pedMotherHistGrosGrav", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"></td>
          <td>" . $pedMotherHistGros[$lang][2] . "</td><td  id=\"pedMotherHistGrosParaTitle\"></td>
          <td><input class=\"pedMotherHist\" tabindex=\"1402\" id=\"pedMotherHistGrosPara\" name=\"pedMotherHistGrosPara\" " . getData ("pedMotherHistGrosPara", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"></td>
          <td>" . $pedMotherHistGros[$lang][3] . " </td><td  id=\"pedMotherHistGrosAborTitle\"></td>
          <td><input class=\"pedMotherHist\" tabindex=\"1403\" id=\"pedMotherHistGrosAbor\" name=\"pedMotherHistGrosAbor\" " . getData ("pedMotherHistGrosAbor", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"></td>
          <td>" . $pedMotherHistGros[$lang][4] . " </td><td  id=\"pedMotherHistGrosVivaTitle\"></td>
          <td><input class=\"pedMotherHist\" tabindex=\"1404\" id=\"pedMotherHistGrosViva\" name=\"pedMotherHistGrosViva\" " . getData ("pedMotherHistGrosViva", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"></td>
         </tr>
        </table>
       </td>
      </tr>
      <tr>
       <td colspan=\"5\" width=\"100%\">
        <table cellspacing=\"0\">
         <tr>
          <td width=\"15%\" id=\"pedMotherHistGrosDeadAge1Title\">" . $pedMotherHistGros[$lang][5] . "</td>
          <td width=\"85%\"><span>" . $pedMotherHistGros[$lang][6] . " <input class=\"pedMotherHist\" tabindex=\"1405\" id=\"pedMotherHistGrosDeadAge1\" name=\"pedMotherHistGrosDeadAge1\" " . getData ("pedMotherHistGrosDeadAge1", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"></span> <span>" . $pedMotherHistGros[$lang][7] . " <input class=\"pedMotherHist\" tabindex=\"1406\" name=\"pedMotherHistGrosDeadCause1\" " . getData ("pedMotherHistGrosDeadCause1", "text") . " type=\"text\" size=\"50\" maxlength=\"255\"></span> <span><input class=\"pedMotherHist\" tabindex=\"1407\" name=\"pedMotherHistGrosDeadUnk1\" " . getData ("pedMotherHistGrosDeadUnk1", "checkbox", 1) . " type=\"checkbox\" value=\"1\">" . $pedMotherHistGros[$lang][8] . "</span></td>
         </tr>
         <tr>
          <td width=\"15%\" id=\"pedMotherHistGrosDeadAge2Title\"></td>
          <td width=\"85%\"><span>" . $pedMotherHistGros[$lang][6] . " <input class=\"pedMotherHist\" tabindex=\"1408\" id=\"pedMotherHistGrosDeadAge2\" name=\"pedMotherHistGrosDeadAge2\" " . getData ("pedMotherHistGrosDeadAge2", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"></span> <span>" . $pedMotherHistGros[$lang][7] . " <input class=\"pedMotherHist\" tabindex=\"1409\" name=\"pedMotherHistGrosDeadCause2\" " . getData ("pedMotherHistGrosDeadCause2", "text") . " type=\"text\" size=\"50\" maxlength=\"255\"></span> <span><input class=\"pedMotherHist\" tabindex=\"1410\" name=\"pedMotherHistGrosDeadUnk2\" " . getData ("pedMotherHistGrosDeadUnk2", "checkbox", 1) . " type=\"checkbox\" value=\"1\">" . $pedMotherHistGros[$lang][8] . "</span></td>
         </tr>
         <tr>
          <td width=\"15%\" id=\"pedMotherHistGrosDeadAge3Title\"></td>
          <td width=\"85%\"><span>" . $pedMotherHistGros[$lang][6] . " <input class=\"pedMotherHist\" tabindex=\"1411\" id=\"pedMotherHistGrosDeadAge3\" name=\"pedMotherHistGrosDeadAge3\" " . getData ("pedMotherHistGrosDeadAge3", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"></span> <span>" . $pedMotherHistGros[$lang][7] . " <input class=\"pedMotherHist\" tabindex=\"1412\" name=\"pedMotherHistGrosDeadCause3\" " . getData ("pedMotherHistGrosDeadCause3", "text") . " type=\"text\" size=\"50\" maxlength=\"255\"></span> <span><input class=\"pedMotherHist\" tabindex=\"1413\" name=\"pedMotherHistGrosDeadUnk3\" " . getData ("pedMotherHistGrosDeadUnk3", "checkbox", 1) . " type=\"checkbox\" value=\"1\">" . $pedMotherHistGros[$lang][8] . "</span></td>
         </tr>
        </table>
       </td>
      </tr>
      <tr>
	    <td width=\"25%\">" . $pedMotherHistGros[$lang][9] . "</td>
	    <td width=\"20%\"><span ><input class=\"pedMotherHist\" tabindex=\"1414\" name=\"pedMotherHistGrosIst[]\" " . getData ("pedMotherHistGrosIst", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input class=\"pedMotherHist\" tabindex=\"1415\" name=\"pedMotherHistGrosIst[]\" " . getData ("pedMotherHistGrosIst", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input class=\"pedMotherHist\" tabindex=\"1416\" name=\"pedMotherHistGrosIst[]\" " . getData ("pedMotherHistGrosIst", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</span></td>
       <td width=\"5%\"></td>
       <td width=\"25%\" ><i>" . $pedMotherHistGros[$lang][10] . "</i></td>
       <td width=\"25%\"><span ><input class=\"pedMotherHist\" tabindex=\"1417\" name=\"pedMotherHistGrosIstTri[]\" " . getData ("pedMotherHistGrosIstTri", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedMotherHistGros[$lang][11] . " <input class=\"pedMotherHist\" tabindex=\"1418\" name=\"pedMotherHistGrosIstTri[]\" " . getData ("pedMotherHistGrosIstTri", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedMotherHistGros[$lang][12] . " <input class=\"pedMotherHist\" tabindex=\"1419\" name=\"pedMotherHistGrosIstTri[]\" " . getData ("pedMotherHistGrosIstTri", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $pedMotherHistGros[$lang][13] . "</span></td>
      </tr>
      <tr>
	    <td width=\"25%\">" . $pedMotherHistGros[$lang][14] . "</td>
	    <td colspan=\"4\" width=\"75%\"><span ><input class=\"pedMotherHist\" tabindex=\"1420\" name=\"pedMotherHistGrosPreCare[]\" " . getData ("pedMotherHistGrosPreCare", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input class=\"pedMotherHist\" tabindex=\"1421\" name=\"pedMotherHistGrosPreCare[]\" " . getData ("pedMotherHistGrosPreCare", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input class=\"pedMotherHist\" tabindex=\"1422\" name=\"pedMotherHistGrosPreCare[]\" " . getData ("pedMotherHistGrosPreCare", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</span></td>
      </tr>
      <tr>
	    <td width=\"25%\"><i>" . $pedMotherHistGros[$lang][15] . "</i></td>
	    <td width=\"20%\"><span ><input class=\"pedMotherHist\" tabindex=\"1423\" name=\"pedMotherHistGrosPreCareSite\" " . getData ("pedMotherHistGrosPreCareSite", "text") . " type=\"text\" size=\"25\" maxlength=\"64\"></span></td>
       <td width=\"5%\"></td>
       <td width=\"25%\" ><i>" . $pedMotherHistGros[$lang][16] . "</i></td>
       <td width=\"25%\"><span ><input class=\"pedMotherHist\" tabindex=\"1424\" name=\"pedMotherHistGrosPreCareNum\" " . getData ("pedMotherHistGrosPreCareNum", "text") . " type=\"text\" size=\"25\" maxlength=\"64\"></span></td>
      </tr>
      <tr>
	    <td width=\"25%\">" . $pedMotherHistGros[$lang][17] . "</td>
	    <td colspan=\"4\" width=\"75%\"><span ><input class=\"pedMotherHist\" tabindex=\"1425\" name=\"pedMotherHistGrosMeth[]\" " . getData ("pedMotherHistGrosMeth", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedMotherHistGros[$lang][18] . " <input class=\"pedMotherHist\" tabindex=\"1426\" name=\"pedMotherHistGrosMeth[]\" " . getData ("pedMotherHistGrosMeth", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedMotherHistGros[$lang][19] . " <input class=\"pedMotherHist\" tabindex=\"1427\" name=\"pedMotherHistGrosMeth[]\" " . getData ("pedMotherHistGrosMeth", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $pedMotherHistGros[$lang][20] . "</span></td>
      </tr>
      <tr>
	    <td width=\"25%\">" . $pedMotherHistGros[$lang][21] . "</td>
	    <td colspan=\"4\" width=\"75%\"><span><input class=\"pedMotherHist\" tabindex=\"1428\" name=\"pedMotherHistGrosWhere[]\" " . getData ("pedMotherHistGrosWhere", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedMotherHistGros[$lang][22] . " <input class=\"pedMotherHist\" tabindex=\"1429\" name=\"pedMotherHistGrosWhere[]\" " . getData ("pedMotherHistGrosWhere", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedMotherHistGros[$lang][23] . " <input class=\"pedMotherHist\" tabindex=\"1430\" name=\"pedMotherHistGrosWhereHosp\" " . getData ("pedMotherHistGrosWhereHosp", "text") . " type=\"text\" size=\"25\" maxlength=\"64\"><input class=\"pedMotherHist\" tabindex=\"1431\" name=\"pedMotherHistGrosWhere[]\" " . getData ("pedMotherHistGrosWhere", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $pedMotherHistGros[$lang][24] . " <input class=\"pedMotherHist\" tabindex=\"1432\" name=\"pedMotherHistGrosWhereOther\" " . getData ("pedMotherHistGrosWhereOther", "text") . " type=\"text\" size=\"25\" maxlength=\"64\"></span></td>
      </tr>
      <tr>
       <td colspan=\"5\" width=\"100%\"><b>" . $pedMotherHistHiv[$lang][0] . "</b></td>
      </tr>
      <tr>
	    <td width=\"25%\">" . $pedMotherHistHiv[$lang][1] . "</td>
	    <td colspan=\"4\" width=\"75%\"><span ><input class=\"pedMotherHist\" tabindex=\"1501\" name=\"pedMotherHistHivStat[]\" " . getData ("pedMotherHistHivStat", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedMotherHistHiv[$lang][2] . " <input class=\"pedMotherHist\" tabindex=\"1502\" name=\"pedMotherHistHivStat[]\" " . getData ("pedMotherHistHivStat", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedMotherHistHiv[$lang][3] . " <input class=\"pedMotherHist\" tabindex=\"1503\" name=\"pedMotherHistHivStat[]\" " . getData ("pedMotherHistHivStat", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $pedMotherHistHiv[$lang][4] . " <input class=\"pedMotherHist\" tabindex=\"1504\" name=\"pedMotherHistHivStat[]\" " . getData ("pedMotherHistHivStat", "checkbox", 8) . " type=\"radio\" value=\"8\">" . $pedMotherHistHiv[$lang][5] . "</span></td>
      </tr>
      <tr>
	    <td width=\"25%\">" . $pedMotherHistHiv[$lang][6] . "</td>
	    <td width=\"20%\"><span ><input class=\"pedMotherHist\" tabindex=\"1505\" name=\"pedMotherHistHivPmtct[]\" " . getData ("pedMotherHistHivPmtct", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input class=\"pedMotherHist\" tabindex=\"1506\" name=\"pedMotherHistHivPmtct[]\" " . getData ("pedMotherHistHivPmtct", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input class=\"pedMotherHist\" tabindex=\"1507\" name=\"pedMotherHistHivPmtct[]\" " . getData ("pedMotherHistHivPmtct", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</span></td>
       <td width=\"5%\"></td>
       <td width=\"25%\" ><i>" . $pedMotherHistHiv[$lang][7] . "</i></td>
       <td width=\"25%\"><span ><input class=\"pedMotherHist\" tabindex=\"1508\" name=\"pedMotherHistHivPmtctWhere\" " . getData ("pedMotherHistHivPmtctWhere", "text") . " type=\"text\" size=\"25\" maxlength=\"64\"></span></td>
      </tr>
      <tr>
	    <td width=\"25%\">" . $pedMotherHistHiv[$lang][8] . "</td>
	    <td colspan=\"4\" width=\"75%\"><span ><input class=\"pedMotherHist\" tabindex=\"1509\" name=\"pedMotherHistHivArvPreg[]\" " . getData ("pedMotherHistHivArvPreg", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input class=\"pedMotherHist\" tabindex=\"1510\" name=\"pedMotherHistHivArvPreg[]\" " . getData ("pedMotherHistHivArvPreg", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input class=\"pedMotherHist\" tabindex=\"1511\" name=\"pedMotherHistHivArvPreg[]\" " . getData ("pedMotherHistHivArvPreg", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</span></td>
      </tr>
      <tr>
       <td id=\"pedMotherHistHivArvPregStartDtTitle\" width=\"25%\"><i>" . $pedMotherHistHiv[$lang][9] . "</i></td>
       <td width=\"20%\">
		<table><tr><td>
		<input class=\"pedMotherHist\"  tabindex=\"1512\" id=\"pedMotherHistHivArvPregStartDt\" name=\"pedMotherHistHivArvPregStartDt\"
       		value=\"" . getData ("pedMotherHistHivArvPregStartDd", "textarea") . "/" . getData ("pedMotherHistHivArvPregStartMm", "textarea") . "/" .getData ("pedMotherHistHivArvPregStartYy", "textarea") . "\"
       		type=\"text\" size=\"8\" maxlength=\"8\">
       <input id=\"pedMotherHistHivArvPregStartDd\" name=\"pedMotherHistHivArvPregStartDd\" " . getData ("pedMotherHistHivArvPregStartDd", "text") . " type=\"hidden\">
       <input tabindex=\"1513\" id=\"pedMotherHistHivArvPregStartMm\" name=\"pedMotherHistHivArvPregStartMm\" " . getData ("pedMotherHistHivArvPregStartMm", "text") . " type=\"hidden\">
       <input tabindex=\"1514\" id=\"pedMotherHistHivArvPregStartYy\" name=\"pedMotherHistHivArvPregStartYy\" " . getData ("pedMotherHistHivArvPregStartYy", "text") . " type=\"hidden\">
       </td><td>
       <i>" . $jma[$lang][1] . "</i>
       </td></tr></table>
       </td>
       <td width=\"5%\"></td>
       <td id=\"pedMotherHistHivArvPregStopDtTitle\" width=\"25%\"><i>" . $pedMotherHistHiv[$lang][10] . "</i></td>
       <td width=\"25%\">
       <table><tr><td>
        <input class=\"pedMotherHist\"  tabindex=\"1515\" id=\"pedMotherHistHivArvPregStopDt\" name=\"pedMotherHistHivArvPregStopDt\"
        	value=\"" . getData ("pedMotherHistHivArvPregStopDd", "textarea") . "/" . getData ("pedMotherHistHivArvPregStopMm", "textarea") . "/" .getData ("pedMotherHistHivArvPregStopYy", "textarea") . "\"
			type=\"text\" size=\"8\" maxlength=\"8\">
       <input id=\"pedMotherHistHivArvPregStopDd\" name=\"pedMotherHistHivArvPregStopDd\" " . getData ("pedMotherHistHivArvPregStopDd", "text") . " type=\"hidden\">
       <input tabindex=\"1516\" id=\"pedMotherHistHivArvPregStopMm\" name=\"pedMotherHistHivArvPregStopMm\" " . getData ("pedMotherHistHivArvPregStopMm", "text") . " type=\"hidden\">
       <input tabindex=\"1517\" id=\"pedMotherHistHivArvPregStopYy\" name=\"pedMotherHistHivArvPregStopYy\" " . getData ("pedMotherHistHivArvPregStopYy", "text") . " type=\"hidden\">
       </td><td>
	   <i>" . $jma[$lang][1] . "</i>
	   </td></tr></table>
       </td>
      </tr>
      <tr>
       <td width=\"25%\">" . $pedMotherHistHiv[$lang][11] . "</td>
       <td colspan=\"4\" width=\"75%\"><span ><input class=\"pedMotherHist\"  tabindex=\"1518\" name=\"pedMotherHistHivHaartPreg[]\" " . getData ("pedMotherHistHivHaartPreg", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input class=\"pedMotherHist\" tabindex=\"1519\" name=\"pedMotherHistHivHaartPreg[]\" " . getData ("pedMotherHistHivHaartPreg", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input class=\"pedMotherHist\"  tabindex=\"1520\" name=\"pedMotherHistHivHaartPreg[]\" " . getData ("pedMotherHistHivHaartPreg", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</span></td>
      </tr>
      <tr>
       <td width=\"25%\" id=\"pedMotherHistHivHaartPregStartDtTitle\"><i>" . $pedMotherHistHiv[$lang][9] . "</i></td>
       <td width=\"20%\">
		<table><tr><td>
        <input class=\"pedMotherHist\"  tabindex=\"1521\" id=\"pedMotherHistHivHaartPregStartDt\" name=\"pedMotherHistHivHaartPregStDt\"
        	value=\"" . getData ("pedMotherHistHivHaartPregStDd", "textarea") . "/" . getData ("pedMotherHistHivHaartPregStMm", "textarea") . "/" .getData ("pedMotherHistHivHaartPregStYy", "textarea") . "\"
			type=\"text\" size=\"8\" maxlength=\"8\">
       <input id=\"pedMotherHistHivHaartPregStartDd\" name=\"pedMotherHistHivHaartPregStDd\" " . getData ("pedMotherHistHivHaartPregStDd", "text") . " type=\"hidden\">
       <input tabindex=\"1522\" id=\"pedMotherHistHivHaartPregStartMm\" name=\"pedMotherHistHivHaartPregStMm\" " . getData ("pedMotherHistHivHaartPregStMm", "text") . " type=\"hidden\">
       <input tabindex=\"1523\" id=\"pedMotherHistHivHaartPregStartYy\" name=\"pedMotherHistHivHaartPregStYy\" " . getData ("pedMotherHistHivHaartPregStYy", "text") . " type=\"hidden\">
       </td><td>
	   <i>" . $jma[$lang][1] . "</i>
	   </td></tr></table>
       </td>
       <td width=\"5%\"></td>
       <td id=\"pedMotherHistHivHaartPregStopDtTitle\" width=\"25%\"><i>" . $pedMotherHistHiv[$lang][10] . "</i></td>
       <td width=\"25%\">
	   <table><tr><td>
        <input class=\"pedMotherHist\"  tabindex=\"1524\" id=\"pedMotherHistHivHaartPregStopDt\" name=\"pedMotherHistHivHaartPregSpDt\"
        	value=\"" . getData ("pedMotherHistHivHaartPregSpDd", "textarea") . "/" . getData ("pedMotherHistHivHaartPregSpMm", "textarea") . "/" .getData ("pedMotherHistHivHaartPregSpYy", "textarea") . "\"
			type=\"text\" size=\"8\" maxlength=\"8\">
       <input id=\"pedMotherHistHivHaartPregStopDd\" name=\"pedMotherHistHivHaartPregSpDd\" " . getData ("pedMotherHistHivHaartPregSpDd", "text") . " type=\"hidden\">
       <input tabindex=\"1525\" id=\"pedMotherHistHivHaartPregStopMm\" name=\"pedMotherHistHivHaartPregSpMm\" " . getData ("pedMotherHistHivHaartPregSpMm", "text") . " type=\"hidden\">
       <input tabindex=\"1526\" id=\"pedMotherHistHivHaartPregStopYy\" name=\"pedMotherHistHivHaartPregSpYy\" " . getData ("pedMotherHistHivHaartPregSpYy", "text") . " type=\"hidden\">
       </td><td>
	   <i>" . $jma[$lang][1] . "</i>
	   </td></tr></table>
       </td>
      </tr>
      <tr>
       <td width=\"25%\">" . $pedMotherHistHiv[$lang][12] . "</td>
       <td colspan=\"4\" width=\"75%\"><span ><input class=\"pedMotherHist\"  tabindex=\"1527\" name=\"pedMotherHistHivArvDel[]\" " . getData ("pedMotherHistHivArvDel", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input class=\"pedMotherHist\"  tabindex=\"1528\" name=\"pedMotherHistHivArvDel[]\" " . getData ("pedMotherHistHivArvDel", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input class=\"pedMotherHist\"  tabindex=\"1529\" name=\"pedMotherHistHivArvDel[]\" " . getData ("pedMotherHistHivArvDel", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</span></td>
      </tr>
      <tr>
       <td colspan=\"5\" width=\"100%\"><i>" . $pedMotherHistHiv[$lang][13] . "</i></td>
      </tr>
      <tr>
       <td colspan=\"5\" width=\"100%\" ><input class=\"pedMotherHist\"  tabindex=\"1530\" name=\"pedMotherHistHivReg\" " . getData ("pedMotherHistHivReg", "text") . " type=\"text\" size=\"120\" maxlength=\"255\"></td>
      </tr>
     </table>
    </td>
   </tr>

<!-- *******************************************************************- -->
<!-- ******************** Medical History of Siblings ******************* -->
<!-- ********************* (tab indices 1601 - 2000) ******************** -->
<!-- ******************************************************************** -->

   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"5\">" . $pedFratHistory[$lang][1] . "</td>
      </tr>
      <tr>
	    <td colspan=\"5\" width=\"100%\"><input tabindex=\"1601\" id=\"pedFratHistUnk\" name=\"pedFratHistUnk\" " . getData ("pedFratHistUnk", "checkbox") . " type=\"checkbox\" value=\"1\">" . $pedFratHistUnk[$lang][1] . "</td>
      </tr>
      <tr>
       <td colspan=\"5\" width=\"100%\"><b>" . $pedMotherHistTb[$lang][0] . "</b></td>
      </tr>
      <tr>
	    <td width=\"25%\">" . $pedMotherHistTb[$lang][1] . "</td>
	    <td width=\"20%\"><span ><input class=\"pedFratHist\" tabindex=\"1601\" name=\"pedFratHistRecentTb[]\" " . getData ("pedFratHistRecentTb", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input class=\"pedFratHist\"  tabindex=\"1602\" name=\"pedFratHistRecentTb[]\" " . getData ("pedFratHistRecentTb", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input class=\"pedFratHist\"  tabindex=\"1603\" name=\"pedFratHistRecentTb[]\" " . getData ("pedFratHistRecentTb", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</span></td>
       <td width=\"5%\"></td>
       <td width=\"25%\" ><i>" . $pedMotherHistTb[$lang][2] . "</i></td>
       <td width=\"25%\" ><input class=\"pedFratHist\" tabindex=\"1604\" name=\"pedFratHistTreatTb[]\" " . getData ("pedFratHistTreatTb", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input class=\"pedFratHist\" tabindex=\"1605\" name=\"pedFratHistTreatTb[]\" " . getData ("pedFratHistTreatTb", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . "</td>
      </tr>
      <tr>
	    <td width=\"25%\">" . $pedMotherHistTb[$lang][3] . "</td>
	    <td width=\"20%\"><span ><input class=\"pedFratHist\"  tabindex=\"1606\" name=\"pedFratHistActiveTb[]\" " . getData ("pedFratHistActiveTb", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input class=\"pedFratHist\"  tabindex=\"1607\" name=\"pedFratHistActiveTb[]\" " . getData ("pedFratHistActiveTb", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input class=\"pedFratHist\" tabindex=\"1608\" name=\"pedFratHistActiveTb[]\" " . getData ("pedFratHistActiveTb", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</span></td>
       <td width=\"5%\"></td>
       <td width=\"25%\" id=\"pedFratHistTreatTbDtTitle\"><i>" . $pedMotherHistTb[$lang][4] . "</i></td>
       <td width=\"25%\">
        <table><tr><td><input class=\"pedFratHist\" tabindex=\"1609\" id=\"pedFratHistTreatTbDt\" name=\"pedFratHistTreatTbDt\"
	           	value=\"" . getData ("pedFratHistTreatTbDd", "textarea") . "/" . getData ("pedFratHistTreatTbMm", "textarea") . "/" .getData ("pedFratHistTreatTbYy", "textarea") . "\"
				type=\"text\" size=\"8\" maxlength=\"8\">


       <input 					id=\"pedFratHistTreatTbDd\" name=\"pedFratHistTreatTbDd\" " . getData ("pedFratHistTreatTbDd", "text") . " type=\"hidden\">
       <input tabindex=\"1610\" id=\"pedFratHistTreatTbMm\" name=\"pedFratHistTreatTbMm\" " . getData ("pedFratHistTreatTbMm", "text") . " type=\"hidden\">
       <input tabindex=\"1611\" id=\"pedFratHistTreatTbYy\" name=\"pedFratHistTreatTbYy\" " . getData ("pedFratHistTreatTbYy", "text") . " type=\"hidden\">
       </td><td>
       <i>" . $jma[$lang][1] . "</i></td></tr></table></td>
      </tr>
      <tr>
       <td colspan=\"5\" width=\"100%\"><b>" . $pedFratHistHiv[$lang][0] . "</b></td>
      </tr>
      <tr>
       <td colspan=\"5\" width=\"100%\">
        <table cellspacing=\"0\">
         <tr>
	    <td width=\"25%\">" . $pedFratHistHiv[$lang][1] . "</td>
	    <td width=\"10%\"><span ><input class=\"pedFratHist\"  tabindex=\"1701\" name=\"pedFratHistHivStat[]\" " . getData ("pedFratHistHivStat", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedFratHistHiv[$lang][2] . "</span></td>
            <td width=\"10%\"><span ><input class=\"pedFratHist\" tabindex=\"1702\" name=\"pedFratHistHivStat[]\" " . getData ("pedFratHistHivStat", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedFratHistHiv[$lang][3] . "</span></td>
            <td width=\"15%\"><span ><input class=\"pedFratHist\" tabindex=\"1703\" name=\"pedFratHistHivStat[]\" " . getData ("pedFratHistHivStat", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $pedFratHistHiv[$lang][4] . "</span></td>
            <td width=\"40%\"><span ><input class=\"pedFratHist\" tabindex=\"1704\" name=\"pedFratHistHivStat[]\" " . getData ("pedFratHistHivStat", "checkbox", 8) . " type=\"radio\" value=\"8\">" . $pedFratHistHiv[$lang][5] . "</span></td>
         </tr>
         <tr>
	    <td width=\"25%\">" . $pedFratHistHiv[$lang][6] . "</td>
	    <td width=\"10%\"><span ><input class=\"pedFratHist\" tabindex=\"1801\" name=\"pedFratHistHivStatFrat[]\" " . getData ("pedFratHistHivStatFrat", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedFratHistHiv[$lang][2] . "</span></td>
            <td width=\"10%\"><span ><input class=\"pedFratHist\" tabindex=\"1802\" name=\"pedFratHistHivStatFrat[]\" " . getData ("pedFratHistHivStatFrat", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedFratHistHiv[$lang][3] . "</span></td>
            <td width=\"15%\"><span ><input class=\"pedFratHist\" tabindex=\"1803\" name=\"pedFratHistHivStatFrat[]\" " . getData ("pedFratHistHivStatFrat", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $pedFratHistHiv[$lang][4] . "</span></td>
            <td width=\"40%\"><span ><input class=\"pedFratHist\" tabindex=\"1804\" name=\"pedFratHistHivStatFrat[]\" " . getData ("pedFratHistHivStatFrat", "checkbox", 8) . " type=\"radio\" value=\"8\">" . $pedFratHistHiv[$lang][7] . "</span></td>
         </tr>
         <tr>
          <td width=\"25%\"><b>" . $pedFratHistHiv[$lang][8] . "</b></td>
          <td width=\"10%\"><table><tr><td id=\"pedFratHistHivStatNumNegTitle\" >&nbsp;</td><td> <span >&nbsp;&nbsp;&nbsp;&nbsp;<input class=\"pedFratHist\" tabindex=\"1901\" id=\"pedFratHistHivStatNumNeg\" name=\"pedFratHistHivStatNumNeg\" " . getData ("pedFratHistHivStatNumNeg", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"></span></td></tr></table></td>
          <td width=\"10%\"><table><tr><td id=\"pedFratHistHivStatNumPosTitle\" >&nbsp;</td><td> <span >&nbsp;&nbsp;&nbsp;&nbsp;<input class=\"pedFratHist\" tabindex=\"1902\" id=\"pedFratHistHivStatNumPos\" name=\"pedFratHistHivStatNumPos\" " . getData ("pedFratHistHivStatNumPos", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"></span></td></tr></table></td>
          <td width=\"15%\"><table><tr><td id=\"pedFratHistHivStatNumUnkTitle\" >&nbsp;</td><td> <span >&nbsp;&nbsp;&nbsp;&nbsp;<input class=\"pedFratHist\" tabindex=\"1903\" id=\"pedFratHistHivStatNumUnk\" name=\"pedFratHistHivStatNumUnk\" " . getData ("pedFratHistHivStatNumUnk", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"></span></td></tr></table></td>
          <td width=\"40%\"><table><tr><td id=\"pedFratHistHivStatNumDeadTitle\" >&nbsp;</td><td> <span >&nbsp;&nbsp;&nbsp;&nbsp;<input class=\"pedFratHist\" tabindex=\"1904\" id=\"pedFratHistHivStatNumDead\" name=\"pedFratHistHivStatNumDead\" " . getData ("pedFratHistHivStatNumDead", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"></span></td></tr></table></td>
         </tr>
        </table>
       </td>
      </tr>
     </table>
    </td>
   </tr>

<!-- ******************************************************************** -->
<!-- ****************** Neonatal and Infant Prophylaxis ***************** -->
<!-- ********************* (tab indices 2001 - 2200) ******************** -->
<!-- ******************************************************************** -->

   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"2\">" . $pedInfPro[$lang][0] . "</td>
      </tr>
      <tr>
       <td width=\"50%\">" . $pedInfPro[$lang][1] . "</td>
       <td width=\"50%\"><input tabindex=\"2001\" name=\"pedInfProArv[]\" " . getData ("pedInfProArv", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input tabindex=\"2002\" name=\"pedInfProArv[]\" " . getData ("pedInfProArv", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input tabindex=\"2003\" name=\"pedInfProArv[]\" " . getData ("pedInfProArv", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</td>
      </tr>
      <tr>
       <td width=\"50%\">" . $pedInfPro[$lang][2] . "</td>
       <td width=\"50%\"><input tabindex=\"2004\" name=\"pedInfProPcp[]\" " . getData ("pedInfProPcp", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input tabindex=\"2005\" name=\"pedInfProPcp[]\" " . getData ("pedInfProPcp", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input tabindex=\"2006\" name=\"pedInfProPcp[]\" " . getData ("pedInfProPcp", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</td>
      </tr>
      <tr>
       <td width=\"50%\">" . $pedInfPro[$lang][3] . "</td>
       <td width=\"50%\"><input tabindex=\"2007\" name=\"pedInfProMac[]\" " . getData ("pedInfProMac", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input tabindex=\"2008\" name=\"pedInfProMac[]\" " . getData ("pedInfProMac", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input tabindex=\"2009\" name=\"pedInfProMac[]\" " . getData ("pedInfProMac", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</td>
      </tr>
      <tr>
       <td colspan=\"2\" width=\"100%\"><i>" . $pedInfPro[$lang][4] . "</i></td>
      </tr>
     </table>
    </td>
   </tr>

<!-- ******************************************************************** -->
<!-- ************************** Antibody Tests ************************** -->
<!-- ********************* (tab indices 2201 - 2400) ******************** -->
<!-- ******************************************************************** -->

   <tr>
    <td colspan=\"3\">
     <table cellspacing=\"0\">
      <tr>
       <td valign=\"top\" width=\"45%\">
        <table class=\"b_header_nb\">
         <tr>
          <td class=\"s_header\" colspan=\"3\">" . $pedSero[$lang][0] . "</td>
         </tr>
         <tr><td class=\"sm_header_lt_np\" colspan=\"3\">&nbsp;</td></tr>
         <tr>
          <td class=\"sm_header_lt_np\" colspan=\"2\">" . $pedSero[$lang][1] . "</td>
          <td class=\"sm_header_lt_np\">" . $pedSero[$lang][2] . " <i>" . $pedSero[$lang][3] . "</i></td>
         </tr>
";

$tabIndex = 2201;
$labs_list = generatePedLabsList ($lang, $encType, $version, 1);
echo $labs_list . "
         <tr>
          <td colspan=\"3\"><i>" . $pedSero[$lang][8] . "</i></td>
         </tr>
        </table>
       </td>

<!-- ******************************************************************** -->
<!-- ************************* Virologic Tests ************************** -->
<!-- ********************* (tab indices 2401 - 2600) ******************** -->
<!-- ******************************************************************** -->

       <td valign=\"top\" class=\"vert_line\" width=\"1%\">&nbsp;</td>
       <td valign=\"top\" class=\"left_pad\" width=\"54%\">
        <table class=\"b_header_nb\">
         <tr>
          <td class=\"s_header\" colspan=\"3\">" . $pedViro[$lang][0] . "</td>
         </tr>
         <tr><td class=\"sm_header_lt_np\" colspan=\"3\">&nbsp;</td></tr>
         <tr>
          <td class=\"sm_header_lt_np\" colspan=\"2\">" . $pedViro[$lang][1] . "</td>
          <td class=\"sm_header_lt_np\">" . $pedViro[$lang][2] . " <i>" . $pedViro[$lang][3] . "</i></td>
         </tr>
";

$tabIndex = 2401;
$labs_list = generatePedLabsList ($lang, $encType, $version, 2);
echo $labs_list . "
         <tr>
          <td colspan=\"3\"><i>" . $pedViro[$lang][8] . "</i></td>
         </tr>
        </table>
       </td>
      </tr>
     </table>
    </td>
   </tr>

<!-- ******************************************************************** -->
<!-- ****************************** CD4 Count *************************** -->
<!-- **********************(tab indices 2601 - 2800) ******************** -->
<!-- ******************************************************************** -->

   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"3\">" . $pedCd4Cnt[$lang][0] . "</td>
      </tr>
      <tr>
       <td id=\"pedCd4CntPercTitle\">" . $pedCd4Cnt[$lang][1] . "</td>
       <td>
        <table>
         <tr>
          <td>
           <input tabindex=\"2601\" id=\"pedCd4CntPerc\" name=\"pedCd4CntPerc\" " . getData ("pedCd4CntPerc", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">" . $pedCd4Cnt[$lang][2] . "
          </td>
          <td id=\"lowestCd4CntTitle\">
          </td>
          <td>
           <input tabindex=\"2602\" id=\"lowestCd4Cnt\" name=\"lowestCd4Cnt\" " . getData ("lowestCd4Cnt", "text") . " type=\"text\" size=\"10\" maxlength=\"64\">" . $pedCd4Cnt[$lang][3] . "
          </td>
         </tr>
        </table>
       </td>
       <td>
       	<table><tr><td>" . $pedCd4Cnt[$lang][4] . "</td><td id=\"lowestCd4CntDTTitle\"></td>
                   <td><input tabindex=\"2603\" id=\"lowestCd4CntDT\" name=\"lowestCd4CntDt\" value=\"" . getData ("lowestCd4CntDd", "textarea") . "/" . getData ("lowestCd4CntMm", "textarea") . "/" .getData ("lowestCd4CntYy", "textarea") . "\"  type=\"text\" size=\"8\" maxlength=\"8\">
      				   <input tabindex=\"2604\" id=\"lowestCd4CntDd\" name=\"lowestCd4CntDd\" " . getData ("lowestCd4CntDd", "text") . " type=\"hidden\">
      				   <input tabindex=\"2605\" id=\"lowestCd4CntMm\" name=\"lowestCd4CntMm\" " . getData ("lowestCd4CntMm", "text") . " type=\"hidden\">
      				   <input tabindex=\"2606\" id=\"lowestCd4CntYy\" name=\"lowestCd4CntYy\" " . getData ("lowestCd4CntYy", "text") . " type=\"hidden\"></td>
      			   <td><i>" . $jma[$lang][1] . "</i>
      	</td></tr></table></td>
      </tr>
      <tr>
       <td colspan=\"3\">
         <input tabindex=\"2607\" name=\"lowestCd4CntNotDone\" " .
           getData ("lowestCd4CntNotDone", "checkbox") .
           " type=\"radio\" value=\"On\"> " .
           $pedCd4Cnt[$lang][5] . "</td>
      </tr>
      <tr>
       <td id=\"firstViralLoadTitle\">" . $pedCd4Cnt[$lang][6] . "</td>
       <td><input tabindex=\"2701\" id=\"firstViralLoad\" name=\"firstViralLoad\" " . getData ("firstViralLoad", "text") . " type=\"text\" size=\"10\" maxlength=\"64\">" . $pedCd4Cnt[$lang][7] . "</td>
       <td>
		<table><tr><td>" . $pedCd4Cnt[$lang][4] . "</td><td  id=\"firstViralLoadDTTitle\"></td>
                   <td><input tabindex=\"2702\" id=\"firstViralLoadDT\" name=\"lowestCd4CntDt\" value=\"" . getData ("firstViralLoadDd", "textarea") . "/" . getData ("firstViralLoadMm", "textarea") . "/" .getData ("firstViralLoadYy", "textarea") . "\"  type=\"text\" size=\"8\" maxlength=\"8\">
      				   <input id=\"firstViralLoadDd\" name=\"firstViralLoadDd\" " . getData ("firstViralLoadDd", "text") . " type=\"hidden\">
      				   <input tabindex=\"2703\" id=\"firstViralLoadMm\" name=\"firstViralLoadMm\" " . getData ("firstViralLoadMm", "text") . " type=\"hidden\">
      				   <input tabindex=\"2704\" id=\"firstViralLoadYy\" name=\"firstViralLoadYy\" " . getData ("firstViralLoadYy", "text") . " type=\"hidden\"></td>
      			   <td><i>" . $jma[$lang][1] . "</i>
      	</td></tr></table></td>
      <tr>
       <td colspan=\"3\">
         <input tabindex=\"2705\" name=\"firstViralLoadNotDone\" " .
           getData ("firstViralLoadNotDone", "checkbox") .
           " type=\"radio\" value=\"On\">" .
           showValidationIcon ($encType, "firstViralLoadNotDone") . " " .
           $pedCd4Cnt[$lang][5] . "
       </td>
      </tr>
     </table>
    </td>
   </tr>

<!-- ******************************************************************** -->
<!-- ******************* Probable Mode of Transmission ****************** -->
<!-- ********************* (tab indices 2801 - 2900) ******************** -->
<!-- ******************************************************************** -->

   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"5\">" . $pedTransMode[$lang][0] . "</td>
      </tr>
      <tr>
       <td colspan=\"5\"><i>" . $pedTransMode[$lang][1] . "</i></td>
      </tr>";
      	$where = getEncounterWhere ($eid, $pid);
      	queryBlock($lang, $where, 16, 2800, 2850);
echo "
      </tr>
     </table>
    </td>
   </tr>

<!-- ******************************************************************** -->
<!-- ************************* Risk Assessment ************************** -->
<!-- ********************* (tab indices 2901 - 3000) ******************** -->
<!-- ******************************************************************** -->

   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"5\">" . $pedRisk[$lang][0] . "</td>
      </tr>
      <tr>
       <td colspan=\"5\"><b>" . $pedRisk[$lang][1] . "</b> <i>" . $pedRisk[$lang][2] . "</i></td>
      </tr>
      <tr>
       <td valign=\"top\" width=\"25%\">" . $pedRisk[$lang][3] . "</td>
       <td valign=\"top\" width=\"25%\"><input tabindex=\"2901\" id=\"lastQuarterSex1\"  name=\"lastQuarterSex[]\" " . getData ("lastQuarterSex", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input tabindex=\"2902\" id=\"lastQuarterSex2\"  name=\"lastQuarterSex[]\" " . getData ("lastQuarterSex", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input tabindex=\"2903\" id=\"lastQuarterSex4\" name=\"lastQuarterSex[]\" " . getData ("lastQuarterSex", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</td>
       <td width=\"1%\">&nbsp;</td>
       <td valign=\"top\" class=\"left_pad\" width=\"24%\">" . $pedRisk[$lang][5] . "</td>
       <td valign=\"top\" width=\"25%\"><input tabindex=\"2907\" name=\"lastQuarterSeroStatPart[]\" " . getData ("lastQuarterSeroStatPart", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input tabindex=\"2908\" name=\"lastQuarterSeroStatPart[]\" " . getData ("lastQuarterSeroStatPart", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input tabindex=\"2909\" name=\"lastQuarterSeroStatPart[]\" " . getData ("lastQuarterSeroStatPart", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</td>
      </tr>
      <tr>
       <td valign=\"top\" width=\"25%\">" . $pedRisk[$lang][4] . "</td>
       <td valign=\"top\" width=\"25%\"><input tabindex=\"2904\" name=\"lastQuarterSexWithoutCondom[]\" " . getData ("lastQuarterSexWithoutCondom", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][0] . " <input tabindex=\"2905\" name=\"lastQuarterSexWithoutCondom[]\" " . getData ("lastQuarterSexWithoutCondom", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][1] . " <input tabindex=\"2906\" name=\"lastQuarterSexWithoutCondom[]\" " . getData ("lastQuarterSexWithoutCondom", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</td>
       <td colspan=\"3\" width=\"50%\">&nbsp;</td>
      </tr>
     </table>
    </td>
   </tr>

<!-- ******************************************************************** -->
<!-- ******************* Adolescent Reproductive Health ***************** -->
<!-- ********************* (tab indices 3001 - 3200)********************* -->
<!-- ******************************************************************** -->

   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"4\">" . $pedReproHealth[$lang][0] . "</td>
      </tr>
      <tr>
       <td width=\"25%\"><b>" . $pedReproHealth[$lang][1] . "</b></td>
       <td width=\"25%\"><input id=\"pedMensesY\"  tabindex=\"3001\" name=\"pedReproHealthMenses[]\" " . getData ("pedReproHealthMenses", "checkbox", 1) . " type=\"radio\" class=\"pedMenses\" value=\"1\">" . $ynu[$lang][0] . " <input id=\"pedMensesN\" class=\"pedMenses\"  tabindex=\"3002\" name=\"pedReproHealthMenses[]\" " . getData ("pedReproHealthMenses", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input  id=\"pedMensesU\" class=\"pedMenses\" tabindex=\"3003\" name=\"pedReproHealthMenses[]\" " . getData ("pedReproHealthMenses", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</td>
       <td width=\"25%\" id=\"pregnantLmpDtTitle\">" . $pedReproHealth[$lang][2] . "</td>
       <td width=\"25%\">
       	<table><tr><td>
       		<input class=\"pedMenses\" tabindex=\"3004\" id=\"pregnantLmpDt\" name=\"pregnantLmpDt\" value=\"" . getData ("pregnantLmpDd", "textarea") . "/" . getData ("pregnantLmpMm", "textarea") . "/" .getData ("pregnantLmpYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
       		<input id=\"pregnantLmpDd\" name=\"pregnantLmpDd\" " . getData ("pregnantLmpDd", "text") . " type=\"hidden\">
       		<input tabindex=\"3005\" id=\"pregnantLmpMm\" name=\"pregnantLmpMm\" " . getData ("pregnantLmpMm", "text") . " type=\"hidden\">
       		<input tabindex=\"3006\" id=\"pregnantLmpYy\" name=\"pregnantLmpYy\" " . getData ("pregnantLmpYy", "text") . " type=\"hidden\">
       	</td>
       	<td><i>" . $jma[$lang][1] . "</i></td></tr></table>
       	</td>
      </tr>
      <tr>
       <td colspan=\"4\" width=\"100%\"><i>" . $pedReproHealth[$lang][3] . "</i></td>
      </tr>
      <tr>
       <td width=\"25%\"><b>" . $pedReproHealth[$lang][4] . "</b></td>
       <td width=\"25%\"><input class=\"pedPreg\"  id=\"pedPregY\" tabindex=\"3007\" name=\"pregnant[]\" " . getData ("pregnant", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input  class=\"pedPreg\" id=\"pedPregN\" tabindex=\"3008\" name=\"pregnant[]\" " . getData ("pregnant", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input  id=\"pedPregU\" class=\"pedPreg\" tabindex=\"3009\" name=\"pregnant[]\" " . getData ("pregnant", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</td>
       <td width=\"25%\">" . $pedReproHealth[$lang][5] . "</td>
       <td width=\"25%\">
       <input class=\"pedPregPrenat\" tabindex=\"3010\" id=\"pedPregPrenatY\" name=\"pregnantPrenatal[]\" " . getData ("pregnantPrenatal", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input id=\"pedPregPrenatN\" tabindex=\"3011\" class=\"pedPregPrenat\" name=\"pregnantPrenatal[]\" " . getData ("pregnantPrenatal", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input id=\"pedPregPrenatU\" tabindex=\"3012\" class=\"pedPregPrenat\" name=\"pregnantPrenatal[]\" " . getData ("pregnantPrenatal", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</td>
      </tr>
      <tr>
       <td colspan=\"2\" width=\"50%\">&nbsp;</td>
       <td width=\"25%\" id=\"pregnantPrenatalFirstDtTitle\"><i>" . $pedReproHealth[$lang][6] . "</i></td>
       <td width=\"25%\">
        <table><tr><td>
	    	<input tabindex=\"3013\" class=\"pedPregPrenat\" id=\"pregnantPrenatalFirstDt\" name=\"pregnantPrenatalFirstDt\" value=\"" . getData ("pregnantPrenatalFirstDd", "textarea") . "/" . getData ("pregnantLmpMm", "textarea") . "/" .getData ("pregnantLmpYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
	        <input id=\"pregnantPrenatalFirstDd\" name=\"pregnantPrenatalFirstDd\" " . getData ("pregnantPrenatalFirstDd", "text") . " type=\"hidden\">
	        <input tabindex=\"3014\" id=\"pregnantPrenatalFirstMm\" name=\"pregnantPrenatalFirstMm\" " . getData ("pregnantPrenatalFirstMm", "text") . " type=\"hidden\">
	        <input tabindex=\"3015\" id=\"pregnantPrenatalFirstYy\" name=\"pregnantPrenatalFirstYy\" " . getData ("pregnantPrenatalFirstYy", "text") . " type=\"hidden\">
	    </td>
	     <td><i>" . $jma[$lang][1] . "</i></td></tr></table>
       	</td>
       </tr>
      <tr>
       <td colspan=\"2\" width=\"50%\">&nbsp;</td>
       <td width=\"25%\" id=\"pregnantPrenatalLastDtTitle\"><i>" . $pedReproHealth[$lang][7] . "</i></td>
       <td width=\"25%\">
        <table><tr><td>
	   	     <input tabindex=\"3016\" class=\"pedPregPrenat\" id=\"pregnantPrenatalLastDt\" name=\"pregnantPrenatalLastDt\" value=\"" . getData ("pregnantPrenatalLastDd", "textarea") . "/" . getData ("pregnantPrenatalLastMm", "textarea") . "/" .getData ("pregnantPrenatalLastYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
	   	     <input id=\"pregnantPrenatalLastDd\" name=\"pregnantPrenatalLastDd\" " . getData ("pregnantPrenatalLastDd", "text") . " type=\"hidden\">
	   	     <input tabindex=\"3017\" id=\"pregnantPrenatalLastMm\" name=\"pregnantPrenatalLastMm\" " . getData ("pregnantPrenatalLastMm", "text") . " type=\"hidden\">
	   	     <input tabindex=\"3018\" id=\"pregnantPrenatalLastYy\" name=\"pregnantPrenatalLastYy\" " . getData ("pregnantPrenatalLastYy", "text") . " type=\"hidden\">
	   	</td>
	   	<td><i>" . $jma[$lang][1] . "</i></td></tr></table>
       	</td>
      </tr>
      <tr>
       <td width=\"25%\"><b>" . $pedReproHealth[$lang][8] . "</b></td>
       <td width=\"25%\"><input id=\"papTestY\"  class=\"papTest\" tabindex=\"3019\" name=\"papTest[]\" " . getData ("papTest", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input  id = \"papTestN\"  class=\"papTest\" tabindex=\"3020\" name=\"papTest[]\" " . getData ("papTest", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input id=\"papTestU\"  tabindex=\"3021\" class=\"papTest\" name=\"papTest[]\" " . getData ("papTest", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</td>
       <td width=\"25%\">" . $pedReproHealth[$lang][9] . "</td>
       <td width=\"25%\"><input id=\"papTestResultY\" class=\"papTestResult\" tabindex=\"3022\" name=\"pedPapTestRes[]\" " . getData ("pedPapTestRes", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedReproHealth[$lang][10] . " <input id=\"papTestResultN\" class=\"papTestResult\" tabindex=\"3023\" name=\"pedPapTestRes[]\" " . getData ("pedPapTestRes", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedReproHealth[$lang][11] . "</td>
      </tr>
      <tr>
       <td colspan=\"2\" width=\"50%\">&nbsp;</td>
       <td width=\"25%\" id=\"papTestDtTitle\"><i>" . $pedReproHealth[$lang][12] . "</i></td>
	   <td width=\"25%\">
	     <table><tr><td >
	   	     <input class=\"papTestResult\" tabindex=\"3024\" id=\"papTestDt\" name=\"papTestDt\" value=\"" . getData ("papTestDd", "textarea") . "/" . getData ("papTestMm", "textarea") . "/" .getData ("papTestYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
	   	     <input id=\"papTestDd\" name=\"papTestDd\" " . getData ("papTestDd", "text") . " type=\"hidden\">
	   	     <input tabindex=\"3025\" id=\"papTestMm\" name=\"papTestMm\" " . getData ("papTestMm", "text") . " type=\"hidden\">
	   	     <input tabindex=\"3026\" id=\"papTestYy\" name=\"papTestYy\" " . getData ("papTestYy", "text") . " type=\"hidden\">
	   	</td>
	   	<td><i>" . $jma[$lang][1] . "</i></td></tr></table>
       	</td>
      </tr>
      <tr>
       <td colspan=\"4\" width=\"100%\"><i>" . $pedReproHealth[$lang][13] . "</i></td>
      </tr>
     </table>
    </td>
   </tr>

<!-- ******************************************************************** -->
<!-- ************************** Immunizations *************************** -->
<!-- ********************* (tab indices 3201 - 3400) ******************** -->
<!-- ******************************************************************** -->

   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"5\">" . $pedImm[$lang][0] . "</td>
      </tr>
      <tr>
       <td colspan=\"4\" width=\"100%\">" . $pedImm[$lang][1] . " <input id=\"pedImmVaccY\" tabindex=\"3201\" name=\"pedImmVacc[]\" " . getData ("pedImmVacc", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input  id=\"pedImmVaccN\" tabindex=\"3202\" name=\"pedImmVacc[]\" " . getData ("pedImmVacc", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input id=\"pedImmVaccU\"  tabindex=\"3203\" name=\"pedImmVacc[]\" " . getData ("pedImmVacc", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</td>
      </tr>
      <tr>
       <td colspan=\"4\" width=\"100%\"><i>" . $pedImm[$lang][2] . "</i></td>
      </tr>";

$tabIndex = 3204;
include ("include/pedImmunizations.php");
echo "
     </table>
    </td>
   </tr>
";

$tabIndex = 3400;
include ("include/pedFeeding.php");

echo "

<!-- ******************************************************************** -->
<!-- ************************** Vitals at Birth ************************* -->
<!-- ********************* (tab indices 3601 - 3800) ******************** -->
<!-- ******************************************************************** -->

   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"4\">" . $pedVitBir[$lang][0] . "</td>
      </tr>
      <tr>
       <td width=\"25%\" id=\"pedVitBirWtTitle\">" . $pedVitBir[$lang][1] . "</td>
       <td width=\"25%\"><table><tr><td><input tabindex=\"3601\" id=\"pedVitBirWt\" name=\"pedVitBirWt\" " . getData ("pedVitBirWt", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"><i>" . $pedVitBir[$lang][2] . "</i></td><td id=\"pedVitBirWtUnitTitle\"></td><td> <input tabindex=\"3602\" id=\"pedVitBirWtUnit1\" name=\"pedVitBirWtUnits[]\" " . getData ("pedVitBirWtUnits", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedVitBir[$lang][3] . " <input tabindex=\"3603\" id=\"pedVitBirWtUnit2\" name=\"pedVitBirWtUnits[]\" " . getData ("pedVitBirWtUnits", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedVitBir[$lang][4] . "</i></td></tr></table></td>
       <td width=\"25%\" id=\"pedVitBirLenTitle\">" . $pedVitBir[$lang][5] . "</td>
       <td width=\"25%\"><input tabindex=\"3604\" id=\"pedVitBirLen\" name=\"pedVitBirLen\" " . getData ("pedVitBirLen", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">" . $pedVitBir[$lang][6] . "</td>
      </tr>
      <tr>
       <td width=\"25%\" id=\"pedVitBirPcTitle\" >" . $pedVitBir[$lang][7] . "</td>
       <td width=\"25%\"><input tabindex=\"3605\" id=\"pedVitBirPc\" name=\"pedVitBirPc\" " . getData ("pedVitBirPc", "text") . " type=\"text\" size=\"10\" maxlength=\"64\">" . $pedVitBir[$lang][8] . "</td>
       <td width=\"25%\" id=\"pedVitBirGestTitle\">" . $pedVitBir[$lang][9] . "</td>
       <td width=\"25%\"><input tabindex=\"3606\" id=\"pedVitBirGest\" name=\"pedVitBirGest\" " . getData ("pedVitBirGest", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">" . $pedVitBir[$lang][10] . "</td>
      </tr>
     </table>
    </td>
   </tr>

<!-- ******************************************************************** -->
<!-- *************************** Current Vitals ************************* -->
<!-- ********************* (tab indices 3801 - 4000) ******************** -->
<!-- ******************************************************************** -->

   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"4\">" . $pedVitCur[$lang][0] . "</td>
      </tr>
      <tr>
       <td width=\"15%\" id=\"vitalTempTitle\">" . $pedVitCur[$lang][1] . "</td>
       <td width=\"35%\"><table><tr><td><input tabindex=\"3801\" id=\"vitalTemp\" name=\"vitalTemp\" " . getData ("vitalTemp", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"><i>" . $pedVitCur[$lang][2] . "</i></td><td id=\"vitalTempUnitTitle\"> </td><td> <input tabindex=\"3802\" id=\"vitalTempUnit1\" name=\"vitalTempUnits[]\" " . getData ("vitalTempUnits", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedVitCur[$lang][3] . " <input tabindex=\"3803\" id=\"vitalTempUnit2\" name=\"vitalTempUnits[]\" " . getData ("vitalTempUnits", "checkbox", 2) . " type=\"radio\" value=\"2\"><i>" . $pedVitCur[$lang][4] . "</i></td></tr></table></td>
       <td width=\"15%\" id=\"vitalHrTitle\">" . $pedVitCur[$lang][5] . "</td>
       <td width=\"35%\"><input tabindex=\"3804\" id=\"vitalHr\" name=\"vitalHr\" " . getData ("vitalHr", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"><i>" . $pedVitCur[$lang][6] . "</i></td>
      </tr>
      <tr>
       <td width=\"15%\" id=\"vitalBp1Title\">" . $pedVitCur[$lang][7] . "</td>
       <td width=\"35%\"><table><tr><td><input tabindex=\"3805\" id=\"vitalBp1\" name=\"vitalBp1\" " . getData ("vitalBp1", "text") . " type=\"text\" size=\"5\" maxlength=\"64\">&nbsp;/</td><td id=\"vitalBp2Title\"></td><td><input tabindex=\"3806\" id=\"vitalBp2\" name=\"vitalBp2\" " . getData ("vitalBp2", "text") . " type=\"text\" size=\"5\" maxlength=\"64\"><i>" . $pedVitCur[$lang][2] . "</i></td><td id=\"vitalBpUnitTitle\"></td><td> <input tabindex=\"3807\" id=\"vitalBpUnit1\" name=\"vitalBPUnits[]\" " . getData ("vitalBPUnits", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedVitCur[$lang][8] . " <input tabindex=\"3808\" id=\"vitalBpUnit2\" name=\"vitalBPUnits[]\" " . getData ("vitalBPUnits", "checkbox", 2) . " type=\"radio\" value=\"2\"></td><td><i>" . $pedVitCur[$lang][9] . "</i></td></tr></table></td>
       <td width=\"15%\" id=\"vitalRrTitle\">" . $pedVitCur[$lang][10] . "</td>
       <td width=\"35%\"><input tabindex=\"3809\" id=\"vitalRr\" name=\"vitalRr\" " . getData ("vitalRr", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"><i>" . $pedVitCur[$lang][6] . "</i></td>
      </tr>
      <tr>
       <td width=\"15%\" id=\"vitalWeightTitle\">" . $pedVitCur[$lang][11] . "</td>
       <td width=\"35%\"><table><tr><td><input tabindex=\"3810\" id=\"vitalWeight\"  name=\"vitalWeight\" " . getData ("vitalWeight", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"></td><td id=\"vitalWeightUnitTitle\"></td><td><i>" . $pedVitCur[$lang][2] . " <input tabindex=\"3811\" id=\"vitalWeightUnit1\" name=\"vitalWeightUnits[]\" " . getData ("vitalWeightUnits", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedVitCur[$lang][12] . " <input tabindex=\"3812\" id=\"vitalWeightUnit2\" name=\"vitalWeightUnits[]\" " . getData ("vitalWeightUnits", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedVitCur[$lang][13] . "</i></td></tr></table></td>
       <td width=\"15%\" id=\"vitalHeightTitle\">" . $pedVitCur[$lang][14] . "</td>
       <td width=\"35%\"><table><tr><td><input tabindex=\"3813\" id=\"vitalHeight\" name=\"vitalHeight\" " . getData ("vitalHeight", "text") . " type=\"text\" size=\"1\" maxlength=\"1\"></td><td id=\"vitalHeightCmTitle\" ><i>" . $pedVitCur[$lang][15] . "</i></td><td> <input tabindex=\"3814\" id=\"vitalHeightCm\" name=\"vitalHeightCm\" " . getData ("vitalHeightCm", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"></td><td><i>" . $pedVitCur[$lang][16] . "</i></td></tr></table></td>
      </tr>
      <tr>
       <td width=\"15%\" id=\"pedVitCurWtLastTitle\">" . $pedVitCur[$lang][17] . "</td>
       <td width=\"35%\"><table><tr><td><input tabindex=\"3815\" id=\"pedVitCurWtLast\" name=\"pedVitCurWtLast\" " . getData ("pedVitCurWtLast", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"></td><td id=\"pedVitCurWtLastUnitTitle\"></td><td><i>" . $pedVitCur[$lang][2] . " <input tabindex=\"3816\" id=\"pedVitCurWtLastUnit1\" name=\"pedVitCurWtLastUnits[]\" " . getData ("pedVitCurWtLastUnits", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedVitCur[$lang][12] . " <input tabindex=\"3817\" id=\"pedVitCurWtLastUnit2\" name=\"pedVitCurWtLastUnits[]\" " . getData ("pedVitCurWtLastUnits", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedVitCur[$lang][13] . "</i></td></tr></table></td>
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
       <td width=\"15%\" id=\"pedVitCurBracCircTitle\" >" . $pedVitCur[$lang][25] . "</td>
       <td width=\"35%\"><input tabindex=\"3821\" id=\"pedVitCurBracCirc\" name=\"pedVitCurBracCirc\" " . getData ("pedVitCurBracCirc", "text") . " type=\"text\" size=\"10\" maxlength=\"64\">" . $pedVitCur[$lang][16] . " <i>" . $pedVitCur[$lang][24] . "</i></td>
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
</table>
</div>
";

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
</table>
</div>";

// Physical                    tabstart:4200
echo "
<div id=\"pane3\">
<table class=\"header\">";
$tabIndex = 4200;
include ("include/pedClinicalExam.php");
echo "

<!-- ******************************************************************** -->
<!-- ************************ Psychomotor Eval ************************** -->
<!-- ******************** (tab indices 4401 - 4600) ********************* -->
<!-- ******************************************************************** -->

   </tr>
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
       <td width=\"25%\"><input tabindex=\"4401\" name=\"pedPsychoMotorGross[]\" " . getData ("pedPsychoMotorGross", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedPsychoMotor[$lang][6] . "</td>
       <td width=\"25%\"><input tabindex=\"4403\" name=\"pedPsychoMotorFine[]\" " . getData ("pedPsychoMotorFine", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedPsychoMotor[$lang][6] . "</td>
       <td width=\"25%\"><input tabindex=\"4405\" name=\"pedPsychoMotorLang[]\" " . getData ("pedPsychoMotorLang", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedPsychoMotor[$lang][6] . "</td>
       <td valign=\"top\" width=\"25%\"><input tabindex=\"4407\" name=\"pedPsychoMotorSocial[]\" " . getData ("pedPsychoMotorSocial", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedPsychoMotor[$lang][6] . "</td>
      </tr>
      <tr>
       <td width=\"25%\"><input tabindex=\"4402\" name=\"pedPsychoMotorGross[]\" " . getData ("pedPsychoMotorGross", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedPsychoMotor[$lang][7] . "</td>
       <td width=\"25%\"><input tabindex=\"4404\" name=\"pedPsychoMotorFine[]\" " . getData ("pedPsychoMotorFine", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedPsychoMotor[$lang][7] . "</td>
       <td width=\"25%\"><input tabindex=\"4406\" name=\"pedPsychoMotorLang[]\" " . getData ("pedPsychoMotorLang", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedPsychoMotor[$lang][7] . "</td>
       <td valign=\"top\" width=\"25%\"><input tabindex=\"4408\" name=\"pedPsychoMotorSocial[]\" " . getData ("pedPsychoMotorSocial", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedPsychoMotor[$lang][7] . "</td>
      </tr>
     </table>
    </td>
   </tr>

<!-- ******************************************************************** -->
<!-- *********************** Current HIV Status ************************* -->
<!-- *********************(tab indices 4601 - 4800) ********************* -->
<!-- ******************************************************************** -->

   </tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"4\">" . $pedCurrHiv[$lang][0] . "</td>
      </tr>
      <tr>
       <td valign=\"top\" width=\"25%\"><input tabindex=\"4601\" id=\"pedCurrHiv0\" name=\"pedCurrHiv[]\" " . getData ("pedCurrHiv", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedCurrHiv[$lang][1] . "</td>
       <td width=\"5%\">&nbsp;</td>
       <td colspan=\"2\" valign=\"top\" width=\"75%\"><input tabindex=\"4604\"  id=\"pedCurrHiv3\" name=\"pedCurrHiv[]\" " . getData ("pedCurrHiv", "checkbox", 8) . " type=\"radio\" value=\"8\">" . $pedCurrHiv[$lang][4] . " <i>" . $pedCurrHiv[$lang][5] . "</i></td>
      </tr>
      <tr>
       <td valign=\"top\" width=\"25%\"><input tabindex=\"4602\" id=\"pedCurrHiv1\" name=\"pedCurrHiv[]\" " . getData ("pedCurrHiv", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedCurrHiv[$lang][2] . "</td>
       <td width=\"5%\">&nbsp;</td>
       <td width=\"5%\">&nbsp;</td>
       <td valign=\"top\" width=\"70%\"><input tabindex=\"4605\" id=\"pedCurrHivProb1\" name=\"pedCurrHivProb[]\" " . getData ("pedCurrHivProb", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedCurrHiv[$lang][6] . "</td>
      </tr>
      <tr>
       <td valign=\"top\" width=\"25%\"><input tabindex=\"4603\" id=\"pedCurrHiv2\" name=\"pedCurrHiv[]\" " . getData ("pedCurrHiv", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $pedCurrHiv[$lang][3] . "</td>
       <td width=\"5%\">&nbsp;</td>
       <td width=\"5%\">&nbsp;</td>
       <td valign=\"top\" width=\"70%\"><input tabindex=\"4606\" id=\"pedCurrHivProb2\" name=\"pedCurrHivProb[]\" " . getData ("pedCurrHivProb", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedCurrHiv[$lang][7] . "</td>
      </tr>
      <tr>
       <td colspan=\"4\" width=\"100%\"><i>" . $pedCurrHiv[$lang][8] . "</i></td>
      </tr>
     </table>
    </td>
   </tr>

<!-- ******************************************************************** -->
<!-- ************************** TB Evaluation *************************** -->
<!-- ******************** (tab indices 4801 - 5000) ********************* -->
<!-- ******************************************************************** -->

   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"6\">" . $pedTbEval[$lang][0] . "</td>
      </tr>
      <tr>
       <td colspan=\"6\"><b>" . $pedTbEval[$lang][1] . "</b> <span ><input tabindex=\"4801\" id=\"asymptomaticTb\" name=\"asymptomaticTb\" " . getData ("asymptomaticTb", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedTbEval[$lang][2] . "</span></td>
      </tr>
      <tr>
       <td colspan=\"6\">
        <table>
         <tr>
          <td id=\"completeTreatTitle\"></td>
          <td><input tabindex=\"4802\" id=\"completeTreat\" name=\"completeTreat\" " . getData ("completeTreat", "checkbox") . " type=\"radio\" value=\"On\">" . $pedTbEval[$lang][3] . "</td>
         </tr>
        </table>
       </td>
      </tr>
      <tr>
       <td width=\"2%\" id=\"pedCompleteTreatStartTitle\">&nbsp;</td>
       <td width=\"32%\">" . $pedTbEval[$lang][4] . " <input tabindex=\"4803\" id=\"pedCompleteTreatStartMm\" name=\"pedCompleteTreatStartMm\" " . getData ("pedCompleteTreatStartMm", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"4804\" id=\"pedCompleteTreatStartYy\" name=\"pedCompleteTreatStartYy\" " . getData ("pedCompleteTreatStartYy", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"><i>" . $ma[$lang][1] . "</td>
       <td width=\"2%\" id=\"pedCompleteTreatStopTitle\">&nbsp;</td>
       <td width=\"32%\">" . $pedTbEval[$lang][5] . " <input tabindex=\"4805\" id=\"pedCompleteTreatStopMm\" name=\"completeTreatMm\" " . getData ("completeTreatMm", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"4806\" id=\"pedCompleteTreatStopYy\" name=\"completeTreatYy\" " . getData ("completeTreatYy", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"><i>" . $ma[$lang][1] . "</td>
       <td width=\"2%\" id=\"currentTreatTitle\">&nbsp;</td>
       <td width=\"30%\"><input tabindex=\"4807\" id=\"currentTreat\" name=\"currentTreat\" " . getData ("currentTreat", "checkbox") . " type=\"radio\" value=\"On\">" . $pedTbEval[$lang][6] . "</td>
      </tr>
      <tr>
       <td colspan=\"6\">
        <table>
         <tr>
          <td id=\"propINHTitle\"></td>
          <td>
           <input tabindex=\"4808\" id=\"propINH\" name=\"propINH\" " . getData ("propINH", "checkbox") . " type=\"radio\" value=\"On\">" . $pedTbEval[$lang][7] . "
          </td>
          </tr>
         </table>
        </td>
      </tr>
      <tr>
       <td width=\"2%\" id=\"debutINHStartTitle\">&nbsp;</td>
       <td width=\"32%\">" . $pedTbEval[$lang][4] . " <input tabindex=\"4809\" id=\"debutINHStartMm\" name=\"debutINHMm\" " . getData ("debutINHMm", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"4810\" id=\"debutINHStartYy\" name=\"debutINHYy\" " . getData ("debutINHYy", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"><i>" . $ma[$lang][1] . "</td>
       <td width=\"2%\" id=\"debutINHStopTitle\">&nbsp;</td>
       <td width=\"32%\">" . $pedTbEval[$lang][5] . " <input tabindex=\"4811\" id=\"debutINHStopMm\" name=\"arretINHMm\" " . getData ("arretINHMm", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"4812\" id=\"debutINHStopYy\" name=\"arretINHYy\" " . getData ("arretINHYy", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"><i>" . $ma[$lang][1] . "</td>
       <td width=\"2%\" id=\"currentPropTitle\">&nbsp;</td>
       <td width=\"30%\"><input tabindex=\"4813\" id=\"currentProp\" name=\"currentProp\" " . getData ("currentProp", "checkbox") . " type=\"radio\" value=\"On\">" . $pedTbEval[$lang][8] . "</td>
      </tr>
      <tr>
       <td colspan=\"6\"><table><tr><td id=\"tbStatusTitle\"></td><td><b>" . $pedTbEval[$lang][9] . "</b></td></tr></table></td>
      </tr>
      <tr>
       <td colspan=\"2\"><input tabindex=\"4901\" id=\"pedTbEvalRecentExp\" name=\"pedTbEvalRecentExp\" " . getData ("pedTbEvalRecentExp", "checkbox") . " type=\"radio\" value=\"On\">" . $pedTbEval[$lang][10] . "</td>
       <td colspan=\"4\"><input tabindex=\"4903\" id=\"suspicionTBwSymptoms\" name=\"suspicionTBwSymptoms\" " . getData ("suspicionTBwSymptoms", "checkbox") . " type=\"radio\" value=\"On\">" . $pedTbEval[$lang][11] . "</td>
      </tr>
      <tr>
       <td colspan=\"2\"><input tabindex=\"4902\" id=\"presenceBCG\" name=\"presenceBCG\" " . getData ("presenceBCG", "checkbox") . " type=\"radio\" value=\"On\">" . $pedTbEval[$lang][12] . "</td>
       <td colspan=\"4\"><input tabindex=\"4904\" id=\"noTBsymptoms\" name=\"noTBsymptoms\" " . getData ("noTBsymptoms", "checkbox") . " type=\"radio\" value=\"On\">" . $pedTbEval[$lang][13] . "</td>
      </tr>
      <tr>
       <td colspan=\"2\">" . $pedTbEval[$lang][14] . " <input tabindex=\"4905\" name=\"pedTbEvalPpdRecent[]\" " . getData ("pedTbEvalPpdRecent", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input tabindex=\"4906\" name=\"pedTbEvalPpdRecent[]\" " . getData ("pedTbEvalPpdRecent", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input tabindex=\"4907\" name=\"pedTbEvalPpdRecent[]\" " . getData ("pedTbEvalPpdRecent", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . "</td>
       <td width=\"2%\" id=\"pedTbEvalPpdRecentTitle\">&nbsp;</td>
       <td colspan=\"3\"><i>" . $pedTbEval[$lang][15] . "</i> " . $pedTbEval[$lang][16] . " <input tabindex=\"4908\" id=\"pedTbEvalPpdRecentMm\" name=\"pedTbEvalPpdRecentMm\" " . getData ("pedTbEvalPpdRecentMm", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"4909\" id=\"pedTbEvalPpdRecentYy\" name=\"pedTbEvalPpdRecentYy\" " . getData ("pedTbEvalPpdRecentYy", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"><i>" . $ma[$lang][1] . "</i>&nbsp;&nbsp;&nbsp;&nbsp; " . $pedTbEval[$lang][17] . " <input tabindex=\"4910\" name=\"pedTbEvalPpdRecentRes\" " . getData ("pedTbEvalPpdRecentRes", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">" . $pedTbEval[$lang][18] . "</td>
      </tr>
      <tr>
       <td colspan=\"6\"><i>" . $pedTbEval[$lang][19] . "</i></td>
      </tr>
     </table>
    <td>
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
         <input tabindex=\"6001\" id=\"pedMedAllergY\"  name=\"pedMedAllerg[]\" " . getData ("pedMedAllerg", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $ynu[$lang][0] . " <input id=\"pedMedAllergN\" tabindex=\"6002\" name=\"pedMedAllerg[]\" " . getData ("pedMedAllerg", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $ynu[$lang][1] . " <input id=\"pedMedAllergU\" tabindex=\"6003\" name=\"pedMedAllerg[]\" " . getData ("pedMedAllerg", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $ynu[$lang][2] . " &nbsp; &nbsp; <i>" . $pedAllergies[$lang][1] . "</i></td>
      </tr>
      <tr>
       <td colspan=\"9\" width=\"100%\">
         <input tabindex=\"6005\" class=\"pedMedAllergy\" name=\"pedFoodAllerg\" " . getData ("pedFoodAllerg", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedAllergies[$lang][2] . " <i>" . $pedAllergies[$lang][3] . "</i> <input class=\"pedMedAllergy\" tabindex=\"6005\" name=\"pedFoodAllergText\" " . getData ("pedFoodAllergText", "text") . " type=\"text\" size=\"125\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td colspan=\"9\" width=\"100%\">
         <input class=\"pedMedAllergy\" tabindex=\"6006\" name=\"pedOtherAllerg\" " . getData ("pedOtherAllerg", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedAllergies[$lang][4] . " <i>" . $pedAllergies[$lang][3] . "</i> <input class=\"pedMedAllergy\" tabindex=\"6007\" name=\"aMedOther\" " . getData ("aMedOther", "text") . " type=\"text\" size=\"125\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td width=\"44%\">
         <input class=\"pedMedAllergy\" tabindex=\"6008\" name=\"pedMedAllergMeds\" " . getData ("pedMedAllergMeds", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedAllergies[$lang][5] . " <i>" . $pedAllergies[$lang][3] . "</i></td>
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
       <td><input class=\"pedMedAllergy\" tabindex=\"" . ($tabIndex + 1) . "\" name=\"aMed$i\" " . getData ("aMed" . $i, "text") . " type=\"text\" size=\"70\" maxlength=\"255\"></td>
       <td align=\"center\">
         <input class=\"pedMedAllergy\" tabindex=\"" . ($tabIndex + 6) . "\" name=\"aMed" . $i . "Rash\" " . getData ("aMed" . $i . "Rash", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input class=\"pedMedAllergy\" tabindex=\"" . ($tabIndex + 7) . "\" name=\"aMed" . $i . "RashF\" " . getData ("aMed" . $i . "RashF", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input class=\"pedMedAllergy\" tabindex=\"" . ($tabIndex + 9) . "\" name=\"aMed" . $i . "Hives\" " . getData ("aMed" . $i . "Hives", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input class=\"pedMedAllergy\" tabindex=\"" . ($tabIndex + 10) . "\" name=\"aMed" . $i . "SJ\" " . getData ("aMed" . $i . "SJ", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input class=\"pedMedAllergy\" tabindex=\"" . ($tabIndex + 11) . "\" name=\"aMed" . $i . "Anaph\" " . getData ("aMed" . $i . "Anaph", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input class=\"pedMedAllergy\" tabindex=\"" . ($tabIndex + 12) . "\" name=\"aMed" . $i . "Other\" " . getData ("aMed" . $i . "Other", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
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

// Treatments                  tabstart:6201
echo "
<div id=\"pane6\">
<table class=\"header\">";
$ped_arv_rows = pedArvRows (6206);
include ("include/pedArvs.php");
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

// Plan                        tabstart:7200
echo "
<div id=\"pane8\">
<table class=\"header\">";
$formName = "pedintake";

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
       <td><textarea tabindex=\"7201\" name=\"assessmentPlan\" cols=\"80\" rows=\"15\">" . getData ("assessmentPlan", "textarea") . "</textarea></td>
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
	  <td ><input tabindex=\"7303\" id=\"labOrDrugForm3\"  name=\"labOrDrugForm2\" " . getData ("labOrDrugForm", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $pedNextVisit[$lang][1] . " <i>" . $pedNextVisit[$lang][5] . "</i></td>
          <td ><input tabindex=\"7304\" id=\"labOrDrugForm4\"  name=\"labOrDrugForm2\" " . getData ("labOrDrugForm", "checkbox", 8) . " type=\"radio\" value=\"8\">" . $pedNextVisit[$lang][3] . "
          <input type=\"hidden\" id=\"labOrDrugForm\" name=\"labOrDrugForm\" value = \"". getData ("labOrDrugForm", "textarea") . "\" ></td>
         </tr>
         <tr>
          <td>" . $pedNextVisit[$lang][6] . "</td>
	  <td><table><tr><td id=\"pedNextVisitDaysTitle\">&nbsp;</td><td><input tabindex=\"7305\" id=\"pedNextVisitDays\" name=\"pedNextVisitDays\" " . getData ("pedNextVisitDays", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">" . $pedNextVisit[$lang][7] . "</td><td id=\"pedNextVisitWeeksTitle\">&nbsp;</td><td><input tabindex=\"7306\" id=\"pedNextVisitWeeks\" name=\"pedNextVisitWeeks\" " . getData ("pedNextVisitWeeks", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">" . $pedNextVisit[$lang][8] . " </td><td id=\"pedNextVisitMosTitle\">&nbsp;</td><td><input tabindex=\"7307\" id=\"pedNextVisitMos\" name=\"pedNextVisitMos\" " . getData ("pedNextVisitMos", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">" . $pedNextVisit[$lang][9] . "</td></tr></table></td>
         </tr>
  </table>";
  include ("include/nextVisitDate.php");
echo "
<p>
<input type=\"hidden\" id=\"encounterType\" name=\"encounterType\" value=\"16\">";
$tabIndex = 7400;
$encounterType = 16;
echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"intake/pedintake.js\"></script>";
?>
