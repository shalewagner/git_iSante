<?php

echo "
<!-- ******************************************************************** -->
<!-- ********************** Adherence Counseling ************************ -->
<!-- **** (tab indices " . ($tabIndex + 1) . " - " . ($tabIndex + 1000) . ") *** -->
<!-- ******************************************************************** -->
";

echo "
  <table class=\"header\">
   <tr>
    <td class=\"under_header\">
    </td>
   </tr>
   <tr>
    <td class=\"s_header\">" . $adherenceCounseling_header[$lang][1] . "</td>
   </tr>
   <tr>
    <td>" . $missedDoses[$lang][0] . " &nbsp; <span><input tabindex=\"" . ($tabIndex + 1) . "\" name=\"missedDoses[]\" " . getData ("missedDoses", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $missedDoses[$lang][1] . " &nbsp;&nbsp; <input tabindex=\"" . ($tabIndex + 2) . "\" name=\"missedDoses[]\" " . getData ("missedDoses", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $missedDoses[$lang][2] . " &nbsp;&nbsp; <input tabindex=\"" . ($tabIndex + 3) . "\" name=\"missedDoses[]\" " . getData ("missedDoses", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $missedDoses[$lang][3] . " &nbsp;&nbsp; <input tabindex=\"" . ($tabIndex + 4) . "\" name=\"missedDoses[]\" " . getData ("missedDoses", "checkbox", 8) . " type=\"radio\" value=\"8\">" . $missedDoses[$lang][4] . " &nbsp;&nbsp; <input tabindex=\"" . ($tabIndex + 5) . "\" name=\"missedDoses[]\" " . getData ("missedDoses", "checkbox", 16) . " type=\"radio\" value=\"16\">" . $missedDoses[$lang][5] . "</span></td>
   </tr>
   <tr>
    <td>" . $doseProp[$lang][0] . "</td>
   </tr>
   <tr>
    <td><input tabindex=\"" . ($tabIndex + 6) . "\" name=\"doseProp[]\" " . getData ("doseProp", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $doseProp[$lang][1] . " &nbsp;&nbsp;&nbsp;&nbsp; <input tabindex=\"" . ($tabIndex + 7) . "\" name=\"doseProp[]\" " . getData ("doseProp", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $doseProp[$lang][2] . " &nbsp;&nbsp;&nbsp;&nbsp; <input tabindex=\"" . ($tabIndex + 8) . "\" name=\"doseProp[]\" " . getData ("doseProp", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $doseProp[$lang][3] . " &nbsp;&nbsp;&nbsp;&nbsp; <input tabindex=\"" . ($tabIndex + 9) . "\" name=\"doseProp[]\" " . getData ("doseProp", "checkbox", 8) . " type=\"radio\" value=\"8\">" . $doseProp[$lang][4] . " &nbsp;&nbsp;&nbsp;&nbsp; <input tabindex=\"" . ($tabIndex + 10) . "\" name=\"doseProp[]\" " . getData ("doseProp", "checkbox", 16) . " type=\"radio\" value=\"16\">" . $doseProp[$lang][5] . " &nbsp;&nbsp;&nbsp;&nbsp; <input tabindex=\"" . ($tabIndex + 11) . "\" name=\"doseProp[]\" " . getData ("doseProp", "checkbox", 32) . " type=\"radio\" value=\"32\">" . $doseProp[$lang][6] . " &nbsp;&nbsp;&nbsp;&nbsp; <input tabindex=\"" . ($tabIndex + 12) . "\" name=\"doseProp[]\" " . getData ("doseProp", "checkbox", 64) . " type=\"radio\" value=\"64\">" . $doseProp[$lang][7] . " &nbsp;&nbsp;&nbsp;&nbsp; <input tabindex=\"" . ($tabIndex + 13) . "\" name=\"doseProp[]\" " . getData ("doseProp", "checkbox", 128) . " type=\"radio\" value=\"128\">" . $doseProp[$lang][8] . " &nbsp;&nbsp;&nbsp;&nbsp; <input tabindex=\"" . ($tabIndex + 14) . "\" name=\"doseProp[]\" " . getData ("doseProp", "checkbox", 256) . " type=\"radio\" value=\"256\">" . $doseProp[$lang][9] . " &nbsp;&nbsp;&nbsp;&nbsp; <input tabindex=\"" . ($tabIndex + 15) . "\" name=\"doseProp[]\" " . getData ("doseProp", "checkbox", 512) . " type=\"radio\" value=\"512\">" . $doseProp[$lang][10] . " &nbsp;&nbsp;&nbsp;&nbsp; <input tabindex=\"" . ($tabIndex + 16) . "\" name=\"doseProp[]\" " . getData ("doseProp", "checkbox", 1024) . " type=\"radio\" value=\"1024\">" . $doseProp[$lang][11] . "</td>
   </tr>
   <tr>
    <td class=\"bottom_line\"><i>" . $doseProp[$lang][12] . "</i></td>
   </tr>
  </table>
";
?>
