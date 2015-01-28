<?php

echo "
<!-- ******************************************************************** -->
<!-- **************** Partner/Family Violence Assessment **************** -->
<!-- * (tab indices " . ($tabIndex + 1) . " - " . ($tabIndex + 1000) . ") -->
<!-- ******************************************************************** -->

  <table class=\"header\">
   <tr>
    <td class=\"s_header\" colspan=\"8\" width=\"100%\">" . $familyViolence[$lang][0] . "</td>
   </tr>
   <tr>
    <td width=\"25%\"><b>" . $familyViolence[$lang][1] . "</b></td>
    <td rowspan=\"4\" width=\"5%\">&nbsp;</td>
    <td class=\"sm_header_cnt\" width=\"10%\">" . $familyViolence[$lang][2] . "</td>
    <td class=\"sm_header_cnt\" width=\"10%\">" . $familyViolence[$lang][3] . "</td>
    <td class=\"sm_header_cnt\" width=\"10%\">" . $familyViolence[$lang][4] . "</td>
    <td class=\"sm_header_cnt\" width=\"10%\">" . $familyViolence[$lang][5] . "</td>
    <td valign=\"bottom\" rowspan=\"3\" align=\"right\" width=\"30%\">&nbsp;</td>
   </tr>
   <tr>
    <td width=\"25%\">" . $familyViolence[$lang][6] . "</td>
    <td class=\"sm_header_cnt\" width=\"10%\"><input tabindex=\"" . ($tabIndex + 1) . "\" name=\"familyViolenceEmo[]\" " . getData ("familyViolenceEmo", "checkbox", 1) . " type=\"checkbox\" value=\"1\"></td>
    <td class=\"sm_header_cnt\" width=\"10%\"><input tabindex=\"" . ($tabIndex + 2) . "\" name=\"familyViolenceEmo[]\" " . getData ("familyViolenceEmo", "checkbox", 2) . " type=\"checkbox\" value=\"2\"></td>
    <td class=\"sm_header_cnt\" width=\"10%\"><input tabindex=\"" . ($tabIndex + 3) . "\" name=\"familyViolenceEmo[]\" " . getData ("familyViolenceEmo", "checkbox", 4) . " type=\"checkbox\" value=\"4\"></td>
    <td class=\"sm_header_cnt\" width=\"10%\"><input tabindex=\"" . ($tabIndex + 4) . "\" name=\"familyViolenceEmo[]\" " . getData ("familyViolenceEmo", "checkbox", 8) . " type=\"checkbox\" value=\"8\"></td>
   </tr>
   <tr>
    <td width=\"25%\">" . $familyViolence[$lang][7] . "</td>
    <td class=\"sm_header_cnt\" width=\"10%\"><input tabindex=\"" . ($tabIndex + 5) . "\" name=\"familyViolenceVerb[]\" " . getData ("familyViolenceVerb", "checkbox", 1) . " type=\"checkbox\" value=\"1\"></td>
    <td class=\"sm_header_cnt\" width=\"10%\"><input tabindex=\"" . ($tabIndex + 6) . "\" name=\"familyViolenceVerb[]\" " . getData ("familyViolenceVerb", "checkbox", 2) . " type=\"checkbox\" value=\"2\"></td>
    <td class=\"sm_header_cnt\" width=\"10%\"><input tabindex=\"" . ($tabIndex + 7) . "\" name=\"familyViolenceVerb[]\" " . getData ("familyViolenceVerb", "checkbox", 4) . " type=\"checkbox\" value=\"4\"></td>
    <td class=\"sm_header_cnt\" width=\"10%\"><input tabindex=\"" . ($tabIndex + 8) . "\" name=\"familyViolenceVerb[]\" " . getData ("familyViolenceVerb", "checkbox", 8) . " type=\"checkbox\" value=\"8\"></td>
   </tr>
   <tr>
    <td width=\"25%\">" . $familyViolence[$lang][8] . "</td>
    <td class=\"sm_header_cnt\" width=\"10%\"><input tabindex=\"" . ($tabIndex + 9) . "\" name=\"familyViolencePhys[]\" " . getData ("familyViolencePhys", "checkbox", 1) . " type=\"checkbox\" value=\"1\"></td>
    <td class=\"sm_header_cnt\" width=\"10%\"><input tabindex=\"" . ($tabIndex + 10) . "\" name=\"familyViolencePhys[]\" " . getData ("familyViolencePhys", "checkbox", 2) . " type=\"checkbox\" value=\"2\"></td>
    <td class=\"sm_header_cnt\" width=\"10%\"><input tabindex=\"" . ($tabIndex + 11) . "\" name=\"familyViolencePhys[]\" " . getData ("familyViolencePhys", "checkbox", 4) . " type=\"checkbox\" value=\"4\"></td>
    <td class=\"sm_header_cnt\" width=\"10%\"><input tabindex=\"" . ($tabIndex + 12) . "\" name=\"familyViolencePhys[]\" " . getData ("familyViolencePhys", "checkbox", 8) . " type=\"checkbox\" value=\"8\"></td>
    <td width=\"30%\"><i>" . $familyViolence[$lang][9] . "</i></td>
   </tr>
  </table>
";
?>
