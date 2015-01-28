<?php

echo "
<!-- ******************************************************************** -->
<!-- ************************ Medical Eligibility *********************** -->
<!-- *(tab indices " . ($tabIndex + 1) . " - " . ($tabIndex + 1000) . ") * -->
<!-- ********************************************************************* -->
";

echo "
   <tr>
    <td>
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"3\">" . $medicalEligARVs_header[$lang][2] . "</td>
      </tr>
      <tr>
       <td colspan=\"3\"><b>" . $currentHivStage[$lang][0] . "</b> <span><input tabindex=\"" . ($tabIndex + 1) . "\" name=\"currentHivStage[]\" " . getData ("currentHivStage", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $currentHivStage[$lang][1] . " <input tabindex=\"" . ($tabIndex + 2) . "\" name=\"currentHivStage[]\" " . getData ("currentHivStage", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $currentHivStage[$lang][2] . " <input tabindex=\"" . ($tabIndex + 3) . "\" name=\"currentHivStage[]\" " . getData ("currentHivStage", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $currentHivStage[$lang][3] . "</span><td>
      </tr>
      <tr>
       <td colspan=\"2\"><b>" . $medicalEligARVs_subhead1[$lang][1] . "</b>" . $medicalEligARVs_subhead1[$lang][2] . "</td>
       <td><b>" . $medicalEligARVs_subhead2[$lang][1] . "</b> <i>" . $medicalEligARVs_subhead2[$lang][2] . "</i></td>
      </tr>
      <tr>
       <td colspan=\"2\"><input tabindex=\"" . ($tabIndex + 201) . "\" name=\"medElig[]\" " . getData ("medElig", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $medElig[$lang][1] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 301) . "\" name=\"cd4LT200\" " . getData ("cd4LT200", "checkbox") . " type=\"checkbox\" value=\"On\">" . showValidationIcon ($encType, "cd4LT200") . " " . $cd4LT200[$lang][1] . "</td>
      </tr>
      <tr>
       <td colspan=\"2\"><input tabindex=\"" . ($tabIndex + 202) . "\" name=\"medElig[]\" " . getData ("medElig", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $medElig[$lang][2] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 302) . "\" name=\"WHOIII\" " . getData ("WHOIII", "checkbox") . " type=\"checkbox\" value=\"On\">" . showValidationIcon ($encType, "WHOIII") . " " . $WHOIII[$lang][1] . "</td>
      </tr>
      <tr>
       <td colspan=\"2\"><input tabindex=\"" . ($tabIndex + 203) . "\" name=\"medElig[]\" " . getData ("medElig", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $medElig[$lang][3] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 303) . "\" name=\"PMTCT\" " . getData ("PMTCT", "checkbox") . " type=\"checkbox\" value=\"On\">" . showValidationIcon ($encType, "PMTCT") . " " . $PMTCT[$lang][1] . "</td>
      </tr>
      <tr>
       <td colspan=\"2\"><input tabindex=\"" . ($tabIndex + 204) . "\" name=\"medElig[]\" " . getData ("medElig", "checkbox", 8) . " type=\"radio\" value=\"8\">" . $medElig[$lang][4] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 304) . "\" name=\"tlcLT1200\" " . getData ("tlcLT1200", "checkbox") . " type=\"checkbox\" value=\"On\">" . showValidationIcon ($encType, "tlcLT1200") . " " . $tlcLT1200[$lang][1] . "</td>
      </tr>
      <tr>
       <td colspan=\"2\" rowspan=\"2\"><b>" . $medicalEligARVs_subhead1[$lang][0] . "</b></td>
       <td><input tabindex=\"" . ($tabIndex + 305) . "\" name=\"WHOIV\" " . getData ("WHOIV", "checkbox") . " type=\"checkbox\" value=\"On\">" . $WHOIV[$lang][1] . "</td>
      </tr>
      <tr>
       <td  colspan=\"2\"><input tabindex=\"" . ($tabIndex + 306) . "\" name=\"medEligHAART\" " . getData ("medEligHAART", "checkbox") . " type=\"checkbox\" value=\"On\">" . $medEligHAART[$lang][1] . "</td>
      </tr>
     </table>
    </td>
   </tr>
";
?>
