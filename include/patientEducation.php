<?php

echo "
<!-- -------------------------------------------------------------------- -->
<!-- ----------------------- Patient Education -------------------------- -->
<!-- ------------------- (tab indices " . ($tabIndex + 1) . " - " . ($tabIndex + 100) . ") -------------------- -->
<!-- -------------------------------------------------------------------- -->
";

echo "
   <tr>
    <td>
     <table class=\"b_header\">
      <tr>
       <td class=\"s_header\" colspan=\"2\">" . $patientEducation_header[$lang][1] . "</td>
      </tr>
      <tr>
       <td><b>" . $supportDiscPartner[$lang][0] . "</b></td>
       <td><b>" . $supportServArvEduc[$lang][0] . "</b></td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 1) . "\" name=\"supportDiscPartner\" " . getData ("supportDiscPartner", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $supportDiscPartner[$lang][1] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 11) . "\" name=\"supportServArvEduc\" " . getData ("supportServArvEduc", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $supportServArvEduc[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 2) . "\" name=\"supportDiscParent\" " . getData ("supportDiscParent", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $supportDiscParent[$lang][1] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 12) . "\" name=\"supportServNutr\" " . getData ("supportServNutr", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $supportServNutr[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 3) . "\" name=\"supportDiscChild\" " . getData ("supportDiscChild", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $supportDiscChild[$lang][1] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 13) . "\" name=\"supportServPatho\" " . getData ("supportServPatho", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $supportServPatho[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 4) . "\" name=\"supportDiscFriend\" " . getData ("supportDiscFriend", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $supportDiscFriend[$lang][1] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 14) . "\" name=\"supportServCoun\" " . getData ("supportServCoun", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $supportServCoun[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 5) . "\" name=\"supportDiscOther\" " . getData ("supportDiscOther", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $supportDiscOther[$lang][1] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 15) . "\" name=\"supportServPreAdher\" " . getData ("supportServPreAdher", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $supportServPreAdher[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 6) . "\" name=\"supportDiscNobody\" " . getData ("supportDiscNobody", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $supportDiscNobody[$lang][1] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 16) . "\" name=\"supportServTransport\" " . getData ("supportServTransport", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $supportServTransport[$lang][1] . "</td>
      </tr>
      <tr>
       <td>&nbsp;</td>
       <td><input tabindex=\"" . ($tabIndex + 17) . "\" name=\"supportServPrev\" " . getData ("supportServPrev", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $supportServPrev[$lang][1] . "</td>
      </tr>
      <tr>
       <td><b>" . $supportLevel[$lang][0] . "</b></td>
       <td><input tabindex=\"" . ($tabIndex + 18) . "\" name=\"supportServGroup\" " . getData ("supportServGroup", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $supportServGroup[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 7) . "\" name=\"supportLevel[]\" " . getData ("supportLevel", "checkbox", 1) . " type=\"checkbox\" value=\"1\"> " . $supportLevel[$lang][1] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 19) . "\" name=\"supportServOngAdher\" " . getData ("supportServOngAdher", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $supportServOngAdher[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 8) . "\" name=\"supportLevel[]\" " . getData ("supportLevel", "checkbox", 2) . " type=\"checkbox\" value=\"2\"> " . $supportLevel[$lang][2] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 20) . "\" name=\"supportServOther\" " . getData ("supportServOther", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $supportOtherCounsel[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 9) . "\" name=\"supportLevel[]\" " . getData ("supportLevel", "checkbox", 4) . " type=\"checkbox\" value=\"4\"> " . $supportLevel[$lang][3] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 21) . "\" name=\"supportOtherCounsel\" " . getData ("supportOtherCounsel", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 10) . "\" name=\"supportLevel[]\" " . getData ("supportLevel", "checkbox", 8) . " type=\"checkbox\" value=\"8\"> " . $supportLevel[$lang][4] . "</td>
      </tr>
     </table>
    </td>
   </tr>
";
?>
