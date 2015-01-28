<?php

echo "
<!-- *************************************************************** -->
<!-- ******************** Medication Allergies ******************* -->
<!-- ***************************************************************** -->

   <tr>
    <td>
     <table class=\"b_header_nb\">
      <tr>
       <td colspan=\"10\">&nbsp;</td>
      </tr>
      <tr>
       <td class=\"s_header\" colspan=\"10\">" . $noneTreatments[$lang][1] . "</td>
      </tr>
      <tr>
       <td colspan=\"3\">
         <input tabindex=\"" . ($tab ++) . "\"  id=\"noneTreatments\" name=\"noneTreatments\" " . getData ("noneTreatments", "checkbox") . " 
type=\"checkbox\" value=\"On\">" . showValidationIcon ($type, "noneTreatments") . " " . $noneTreatments[$lang][2] . "</td>
       <td colspan=\"7\" align=\"center\"><b>" . $noneTreatments[$lang][3] . "</b></td>
      </tr>
      <tr>
       <td class=\"sm_header_lt\">" . $allergies_subhead[$lang][0] . "</td>
       <td class=\"sm_header_lt\">" . $allergies_subhead[$lang][1] . "</td>
       <td class=\"sm_header_lt\">" . $allergies_subhead[$lang][2] . "</td>
       <td class=\"sm_header_cnt\">" . $allergies_subhead12[$lang][1] . "</td>
       <td class=\"sm_header_cnt\">" . $allergies_subhead13[$lang][1] . "</td>
       <td class=\"sm_header_cnt\">" . $allergies_subhead14[$lang][1] . "</td>
       <td class=\"sm_header_cnt\">" . $allergies_subhead15[$lang][1] . "</td>
       <td class=\"sm_header_cnt\">" . $allergies_subhead16[$lang][1] . "</td>
       <td class=\"sm_header_cnt\">" . $allergies_subhead17[$lang][1] . "</td>
       <td class=\"sm_header_cnt\">" . $allergies_subhead18[$lang][1] . "</td>
      </tr>
";

for ($i = 1; $i <= $max_allergies; $i++) {
  echo "
      <tr>
       <td><input class=\"aMed\" tabindex=\"" . ($tab ++) . "\"  name=\"aMed$i\" " . getData ("aMed" . $i, "text") . " type=\"text\" size=\"30\" maxlength=\"255\"></td>
       <td><table><tr><td  id=\"aMed" . $i . "StartTitle\">&nbsp;</td><td><input class=\"aMed\" tabindex=\"" . ($tab++) . "\" id=\"aMed" . $i . "StartMM\" name=\"aMed" . $i . "MM\" " . getData ("aMed" . $i . "MM", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input class=\"aMed\" tabindex=\"" . ($tab ++) . "\" id=\"aMed" . $i . "StartYY\" name=\"aMed" . $i . "YY\" " . getData ("aMed" . $i . "YY", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"></td></tr></table></td>
       <td><table><tr><td id=\"aMed" . $i . "StopTitle\">&nbsp;</td><td><input tabindex=\"" . ($tab++) . "\" class=\"aMed\"  id=\"aMed" . $i . "StopMM\" name=\"aMed" . $i . "SpMM\" " . getData ("aMed" . $i . "SpMM", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input class=\"aMed\"  tabindex=\"" . ($tab + 5) . "\" id=\"aMed" . $i . "StopYY\" name=\"aMed" . $i . "SpYY\" " . getData ("aMed" . $i . "SpYY", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"></td></tr></table></td>
       <td align=\"center\">
         <input tabindex=\"" . ($tab++) . "\" class=\"aMed\" id=\"aMed" . $i . "Rash\" name=\"aMed" . $i . "Rash\" " . getData ("aMed" . $i . "Rash", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input tabindex=\"" . ($tab++) . "\" class=\"aMed\" id=\"aMed" . $i . "RashF\" name=\"aMed" . $i . "RashF\" " . getData ("aMed" . $i . "RashF", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input tabindex=\"" . ($tab++) . "\" class=\"aMed\" id=\"aMed" . $i . "ABC\"  name=\"aMed" . $i . "ABC\" " . getData ("aMed" . $i . "ABC", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input tabindex=\"" . ($tab++) . "\" class=\"aMed\" id=\"aMed" . $i . "Hives\"  name=\"aMed" . $i . "Hives\" " . getData ("aMed" . $i . "Hives", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input tabindex=\"" . ($tab++) . "\" class=\"aMed\" id=\"aMed" . $i . "SJ\"  name=\"aMed" . $i . "SJ\" " . getData ("aMed" . $i . "SJ", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input tabindex=\"" . ($tab++) . "\" class=\"aMed\" id=\"aMed" . $i . "Anaph\"  name=\"aMed" . $i . "Anaph\" " . getData ("aMed" . $i . "Anaph", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td align=\"center\">
         <input tabindex=\"" . ($tab++) . "\" class=\"aMed\" id=\"aMed" . $i . "Other\"  name=\"aMed" . $i . "Other\" " . getData ("aMed" . $i . "Other", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
      </tr>";
}

echo "
      <tr>
       <td colspan=\"10\" align=\"center\" class=\"top_line\">
        <table class=\"b_header_nb\">
         <tr>
		  <td><b>" . $allergies_codes[$lang][0] . " </b>&nbsp; " . $allergies_subhead5[$lang][1] . "&nbsp; " . $allergies_subhead6[$lang][1] . "&nbsp; " . $allergies_subhead7[$lang][1] . "&nbsp; " . $allergies_subhead8[$lang][1] . "&nbsp; " . $allergies_subhead9[$lang][1] . "&nbsp; " . $allergies_subhead10[$lang][1] . "</td>
         </tr>
        </table>
       </td>
      </tr>
     </table>
    </td>
   </tr>";


?>
