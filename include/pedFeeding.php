<?php

echo "
<!-- ******************************************************************** -->
<!-- ********************* Infant & Child Feeding *********************** -->
<!-- * (tab indices " . ($tabIndex + 1) . " - " . ($tabIndex + 200) . ") * -->
<!-- ******************************************************************** -->
";

echo "
   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"6\">" . $pedFeed[$lang][0] . "</td>
      </tr>
      <tr>
       <td width=\"16%\">" . $pedFeed[$lang][1] . "</td>
       <td width=\"16%\"><input class=\"pedFeed\" tabindex=\"" . ($tabIndex + 1) . "\" name=\"pedFeedBreast[]\" " . getData ("pedFeedBreast", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedFeed[$lang][2] . "</td>
       <td width=\"16%\"><input class=\"pedFeed\" tabindex=\"" . ($tabIndex + 2) . "\" name=\"pedFeedBreast[]\" " . getData ("pedFeedBreast", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedFeed[$lang][3] . "</td>
       <td width=\"16%\"><input class=\"pedFeed\" tabindex=\"" . ($tabIndex + 3) . "\" name=\"pedFeedBreast[]\" " . getData ("pedFeedBreast", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $pedFeed[$lang][4] . "</td>
       <td width=\"10%\"><input class=\"pedFeed\" tabindex=\"" . ($tabIndex + 4) . "\" name=\"pedFeedBreast[]\" " . getData ("pedFeedBreast", "checkbox", 8) . " type=\"radio\" value=\"8\">" . $pedFeed[$lang][5] . "</td>
       <td width=\"36%\"><table><tr><td id=\"pedFeedBreastAgeTitle\"><i>" . $pedFeed[$lang][6] . "</i></td><td> <input class=\"pedFeed\" tabindex=\"" . ($tabIndex + 5) . "\" id=\"pedFeedBreastAge\" name=\"pedFeedBreastAge\" " . getData ("pedFeedBreastAge", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">" . showValidationIcon ($encType, "pedFeedBreastAge") . "</td></tr></table></td>
      </tr>
      <tr>
       <td width=\"16%\">" . $pedFeed[$lang][7] . "</td>
       <td width=\"16%\"><input class=\"pedFeed\" tabindex=\"" . ($tabIndex + 6) . "\" name=\"pedFeedFormula[]\" " . getData ("pedFeedFormula", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedFeed[$lang][2] . "</td>
       <td width=\"16%\"><input class=\"pedFeed\" tabindex=\"" . ($tabIndex + 7) . "\" name=\"pedFeedFormula[]\" " . getData ("pedFeedFormula", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedFeed[$lang][3] . "</td>
       <td width=\"16%\"><input class=\"pedFeed\" tabindex=\"" . ($tabIndex + 8) . "\" name=\"pedFeedFormula[]\" " . getData ("pedFeedFormula", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $pedFeed[$lang][4] . "</td>
       <td width=\"10%\"><input class=\"pedFeed\" tabindex=\"" . ($tabIndex + 9) . "\" name=\"pedFeedFormula[]\" " . getData ("pedFeedFormula", "checkbox", 8) . " type=\"radio\" value=\"8\">" . $pedFeed[$lang][5] . "</td>
       <td width=\"36%\"><table><tr><td id=\"pedFeedFormulaAgeTitle\"><i>" . $pedFeed[$lang][6] . "</i> </td><td><input class=\"pedFeed\" tabindex=\"" . ($tabIndex + 10) . "\" id=\"pedFeedFormulaAge\" name=\"pedFeedFormulaAge\" " . getData ("pedFeedFormulaAge", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">" . showValidationIcon ($encType, "pedFeedFormulaAge") . "</td></tr></table></td>
      </tr>
      <tr>
       <td width=\"16%\">" . $pedFeed[$lang][8] . "</td>
       <td width=\"16%\"><input class=\"pedFeed\" tabindex=\"" . ($tabIndex + 11) . "\" name=\"pedFeedMixed[]\" " . getData ("pedFeedMixed", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedFeed[$lang][2] . "</td>
       <td width=\"16%\"><input class=\"pedFeed\" tabindex=\"" . ($tabIndex + 12) . "\" name=\"pedFeedMixed[]\" " . getData ("pedFeedMixed", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedFeed[$lang][3] . "</td>
       <td width=\"16%\"><input class=\"pedFeed\" tabindex=\"" . ($tabIndex + 13) . "\" name=\"pedFeedMixed[]\" " . getData ("pedFeedMixed", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $pedFeed[$lang][4] . "</td>
       <td width=\"10%\"><input class=\"pedFeed\" tabindex=\"" . ($tabIndex + 14) . "\" name=\"pedFeedMixed[]\" " . getData ("pedFeedMixed", "checkbox", 8) . " type=\"radio\" value=\"8\">" . $pedFeed[$lang][5] . "</td>
       <td width=\"36%\"><table><tr><td id=\"pedFeedMixedAgeTitle\"><i>" . $pedFeed[$lang][6] . "</i> </td><td><input class=\"pedFeed\" tabindex=\"" . ($tabIndex + 15) . "\" id=\"pedFeedMixedAge\" name=\"pedFeedMixedAge\" " . getData ("pedFeedMixedAge", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">" . showValidationIcon ($encType, "pedFeedMixedAge") . "</td></tr></table></td>
      </tr>
      <tr>
       <td width=\"16%\">" . $pedFeed[$lang][9] . "</td>
       <td width=\"16%\"><input class=\"pedFeed\" tabindex=\"" . ($tabIndex + 16) . "\" name=\"pedFeedOther[]\" " . getData ("pedFeedOther", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedFeed[$lang][2] . "</td>
       <td width=\"16%\"><input class=\"pedFeed\" tabindex=\"" . ($tabIndex + 17) . "\" name=\"pedFeedOther[]\" " . getData ("pedFeedOther", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $pedFeed[$lang][3] . "</td>
       <td width=\"16%\"><input class=\"pedFeed\" tabindex=\"" . ($tabIndex + 18) . "\" name=\"pedFeedOther[]\" " . getData ("pedFeedOther", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $pedFeed[$lang][4] . "</td>
       <td width=\"10%\"><input class=\"pedFeed\" tabindex=\"" . ($tabIndex + 19) . "\" name=\"pedFeedOther[]\" " . getData ("pedFeedOther", "checkbox", 8) . " type=\"radio\" value=\"8\">" . $pedFeed[$lang][5] . "</td>
       <td width=\"36%\"><table><tr><td id=\"pedFeedOtherAgeTitle\"><i>" . $pedFeed[$lang][6] . "</i> </td><td><input class=\"pedFeed\" tabindex=\"" . ($tabIndex + 20) . "\" id=\"pedFeedOtherAge\"  name=\"pedFeedOtherAge\" " . getData ("pedFeedOtherAge", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">" . showValidationIcon ($encType, "pedFeedOtherAge") . "</td></tr></table></td>
      </tr>
      <tr>
       <td colspan=\"6\" width=\"100%\"><i>" . $pedFeed[$lang][10] . "</i> <input class=\"pedFeed\" tabindex=\"" . ($tabIndex + 21) . "\" name=\"pedFeedMixedType\" " . getData ("pedFeedMixedType", "text") . " type=\"text\" size=\"80\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td colspan=\"6\" width=\"100%\"><i>" . $pedFeed[$lang][11] . "</i> <input class=\"pedFeed\" tabindex=\"" . ($tabIndex + 22) . "\" name=\"pedFeedOtherType\" " . getData ("pedFeedOtherType", "text") . " type=\"text\" size=\"80\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td colspan=\"6\" width=\"100%\"><i>" . $pedFeed[$lang][12] . "</i></td>
      </tr>
     </table>
    </td>
   </tr>
";
?>
