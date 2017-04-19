<?php
$nextVisitDateLabel = ($formName == "rx" && $version == 0) ? $nextDrugVisitDate[$lang][0] : $nextVisitDate[$lang][0];
if (isset($_GET['title']) && $_GET['title'] > 14)
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
      <input tabindex=\"" . ($tabIndex + 2) . "\" id=\"nxtVisitD2\" name=\"nxtVisitD2\" value=\"" . getData ("nxtVisitDd", "textarea") . "/". getData ("nxtVisitMm", "textarea") ."/". getData ("nxtVisitYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\" required='required'>
      <input id = \"nxtVisitDd\" name = \"nxtVisitDd\" type=\"hidden\">
      <input tabindex=\"" . ($tabIndex + 3) . "\" id = \"nxtVisitMm\" name = \"nxtVisitMm\" type=\"hidden\">
      <input tabindex=\"" . ($tabIndex + 4) . "\" id = \"nxtVisitYy\" name = \"nxtVisitYy\" type=\"hidden\">" .
    " </td><td><i>" . $firstTestYy[$lang][2] . "</i></td></tr></table>
    </td>
   </tr>
  </table>
";
echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"include/nextVisitDate.js\"></script>";
?>
