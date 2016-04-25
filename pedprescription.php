<?php
echo "
<div id=\"tab-panes\">
<div id=\"pane1\">
";
$tabIndex = 1000;
include ("include/associatedForm.php");
$rxOtherRows = pedRxOtherRows (3001);
$rxRows = pedRxRows (2001);
echo"
</div>

<!-- ******************************************************************** -->
<!-- *********************** New Prescription *************************** -->
<!-- ******************* (tab indices 2001 - 3000) ********************** -->
<!-- ******************************************************************** -->
<div id=\"pane2\">
  <table class=\"b_header_nb\" cellspacing =\"0\" cellpadding=\"0\" border=\"0\">
   <tr>
    <td class=\"s_header\" colspan=\"6\" width=\"62%\">" . $newprescription_header[$lang][1] . "</td>
    <td class=\"s_header\" colspan=\"5\" width=\"35%\">" . $newprescription_header[$lang][2] . "</td>
   </tr>
   <tr>
    <td class=\"sm_header_lt\" width=\"15%\">&nbsp;</td>
	<td class=\"sm_header_lt\" width=\"5%\">&nbsp;</td>
    <td colspan=\"2\" class=\"sm_header_lt\" width=\"15%\">" . $pedRx[$lang][0] . "</td>
    <td class=\"sm_header_lt_pd\" width=\"20%\">" . $pedRx[$lang][1] . "</td>
    <td class=\"sm_header_lt_pd\" width=\"12%\">" . $newprescription_subhead1[$lang][2] . "</td>
    <td class=\"sm_header_lt\" width=\"5%\">" . $newprescription_subhead7[$lang][0] . "</td>
    <td class=\"sm_header_lt_pd\" width=\"15%\">" . $pedRx[$lang][2] . "</td>
    <td class=\"sm_header_lt_pd\" width=\"15%\">" . $pedRx[$lang][3] . " <i>" . $pedRx[$lang][4] . "</i></td>
	<td class=\"sm_header_lt_pd\" width=\"8%\">" . $newprescription_subhead91[$lang][1] ."</td>
   </tr>";
   
      echo '<tr><td colspan="11" class="top_line" style="padding:5px;"><b>(-) Regime ARV les plus courant</b>
<select name="regimen" id="regimen" style="height:25px">';
$options="";
$qry = "select r.shortName,(select drugName from drugLookup where drugID=r.drugID1)  as drug1, 
                  (select drugName from drugLookup where drugID=r.drugID2)  as drug2,
                  (select drugName from drugLookup where drugID=r.drugID3)  as drug3
 from regimen r where regID in (3,6,80,81,90,100,101,103,109,110)";
	$result = dbQuery ($qry);
	if (!$result)
		die("Could not query.");
	else {
		while ($row = psRowFetch ($result))
			$options=$options."<option value=\"".$row[1].":".$row[2].":".$row[3]."\">".$row[0]."</option>";
	}
    echo $options;
echo "</select> <p> </p></td></tr>";
   
   
   
   echo "
   <tr>
    <td class=\"top_line\" colspan=\"6\" width=\"62%\"><b>
      <a class=\"toggle_display\"
         onclick=\"toggleDisplay(0,$pedRxSubHeadElems[0]);\"
         title=\"Toggle display\">
           <span id=\"section0Y\" style=\"display:none\">(+)</span>
           <span id=\"section0N\">(-)&nbsp;</span>" .
             $newprescription_subhead2[$version][$lang][1] .
     "</a></b>
    </td>
    <td class=\"top_line\" colspan=\"4\" width=\"35%\">&nbsp;</td>
   </tr>
". $rxRows["full"] . "
   <tr>
    <td colspan=\"6\" width=\"62%\"><b>" . $pedRx[$lang][5] . "</b></td>
    <td colspan=\"5\" width=\"35%\">&nbsp;</td>
   </tr>
";

echo  $rxOtherRows["full"] . "
  </table>
";

$tabIndex = 4000;

echo '
 <script type="text/javascript" charset="utf8">
   $(document)
     .ready(function () {
         // On change of the dropdown do the ajax
         $("#regimen").change(function () {               
			   $drug=$("#regimen").val().split(":");
			   $druglist=$drug[0]+","+$drug[1]+ ","+ $drug[2];
               $r = confirm("Confirmer que vous voulez choisir le regime : "+ $druglist);
              if ($r == true) {
               $("#"+$drug[0]+"forPepPmtctRx").attr("checked", "checked");
			   $("#"+$drug[1]+"forPepPmtctRx").attr("checked", "checked");
			   $("#"+$drug[2]+"forPepPmtctRx").attr("checked", "checked");
			   
			   $("#"+$drug[0]+"StdDosage").attr("checked", "checked");
			   $("#"+$drug[1]+"StdDosage").attr("checked", "checked");
			   $("#"+$drug[2]+"StdDosage").attr("checked", "checked");
} else {
    alert("Choisir un nouveau régime");
}
		
             });
     });
</script> ';
echo "
<!-- ******************************************************************** -->
<!-- ***************** Information on Pick-Up Person ******************** -->
<!-- ******************* (tab indices 4001 - 6000) ********************** -->
<!-- ******************************************************************** -->
<div id=\"pane4\">
  <table class=\"header\">
   <tr>
    <td colspan=\"2\" class=\"under_header\" width=\"100%\">
    </td>
   </tr>
   <tr>
    <td class=\"s_header\" colspan=\"2\" width=\"100%\">" . $pedRx[$lang][6] . "</td>
   </tr>
   <tr>
    <td width=\"100%\"><textarea tabindex=\"4001\" name=\"drugComments\" rows=8 cols=80>".getData("drugComments", "textarea")."</textarea> </td>
   </tr>
  </table>
  <table class=\"header\">
   <tr>
    <td colspan=\"2\" class=\"under_header\" width=\"100%\">
    </td>
   </tr>
   <tr>
    <td class=\"s_header\" colspan=\"2\" width=\"100%\">" . $pickupPersonInfo[$lang][2] . "</td>
   </tr>
   <tr>
    <td colspan=\"2\" width=\"100%\">" . $pickupPersonInfo[$lang][3] . "</td>
   </tr>
   <tr>
    <td width=\"50%\">" . $pickupPersonName[$lang][1] . " <input tabindex=\"5001\" name=\"pickupPersonName\" " . getData ("pickupPersonName", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
    <td width=\"50%\">" . $pickupPersonRel[$lang][1] . " <input tabindex=\"5002\" name=\"pickupPersonRel\" " . getData ("pickupPersonRel", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
   </tr>
   </table>
 ";
$formName = "pedprescription";
$tabIndex = 6000;

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
    <td ><table><tr valign=\"bottom\"><td width=\"40%\" id=\"nxtVisitD2Title\">" . $nextDrugVisitDate[$lang][0]  . "&nbsp;&nbsp;</td><td width=\"20%\">
      <input tabindex=\"" . ($tabIndex + 2) . "\" id=\"nxtVisitD2\" name=\"nxtVisitD2\" value=\"" . getData ("nxtVisitDd", "textarea") . "/". getData ("nxtVisitMm", "textarea") ."/". getData ("nxtVisitYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
      <input id = \"nxtVisitDd\" name = \"nxtVisitDd\" type=\"hidden\">
      <input tabindex=\"" . ($tabIndex + 3) . "\" id = \"nxtVisitMm\" name = \"nxtVisitMm\" type=\"hidden\">
      <input tabindex=\"" . ($tabIndex + 4) . "\" id = \"nxtVisitYy\" name = \"nxtVisitYy\" type=\"hidden\">" .
    " </td><td><i>" . $firstTestYy[$lang][2] . "</i></td></tr></table>
    </td>
   </tr>
  </table>";

echo"
</div>
</div>
";
if ($tabsOn) {
  echo "</div>";
}
echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"include/nextVisitDate.js\"></script>";
echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"prescription/pedprescription.js\"></script>";
?>
