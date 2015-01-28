<?php

$drugStr = ($formName == "rx") ? "Drug" : "";
$nextVisitDateLabel = ($formName == "rx" && $version == 0) ? $nextDrugVisitDate[$lang][0] : $nextVisitDate_1[$lang][0];
$nxtVisitDd = 'nxt' . $drugStr . 'VisitDd';
$nxtVisitMm = 'nxt' . $drugStr . 'VisitMm';
$nxtVisitYy = 'nxt' . $drugStr . 'VisitYy';

echo "

<!-- -------------------------------------------------------------------- -->
<!-- --------------------------- Next Visit Date ------------------------ -->
<!-- -------------------- (tab indices " . ($tabIndex + 1) . " - " . ($tabIndex + 1000) . ") --------------------- -->
<!-- -------------------------------------------------------------------- -->

  <table class=\"b_header_nb\" border=\"0\" width=\"100%\">
";

echo "
     <tr>
    <td class=\"s_header\">&nbsp;</td>
   </tr>
   <tr>
    <td class=\"nowrap\" id=\"nxtVisitD2Title\"><div style=\"float: left\">" . $nextVisitDateLabel . "&nbsp;&nbsp;
	   <input tabindex=\"" . ($tabIndex + 2) . "\" id=\"nxtVisitDt\" name=\"nxtVisitDt\" value=\"" . getData (" . $nxtVisitDd .", "textarea") . "/". getData (". $nxtVisitMm .", "textarea") ."/". getData (". $nxtVisitYy.", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
       <input  id = \"" . $nxtVisitDd . "\" name = \"" . $nxtVisitDd . "\" type=\"hidden\" " . getData($nxtVisitDd, "text") .">
       <input tabindex=\"" . ($tabIndex + 3) . "\" id = \"" . $nxtVisitMm . "\" name = \"" . $nxtVisitMm . "\" type=\"hidden\" " . getData($nxtVisitMm, "text") .">
       <input tabindex=\"" . ($tabIndex + 4) . "\" id = \"" . $nxtVisitYy . "\"  name = \"" . $nxtVisitYy . "\" type=\"hidden\"  " . getData($nxtVisitYy, "text") .">" .
        showValidationIcon ($encType, $nxtVisitYy) .
    " <i>" . $firstTestYy[$lang][2] . "</i></div>
    </td>
   </tr>
  </table>
";

?>
