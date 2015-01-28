<?php
echo "
<!-- ******************************************************************** -->
<!-- **************************** Symptoms ****************************** -->
<!-- * (tab indices " . ($tabIndex + 1) . " - " . ($tabIndex + 200) . ") * -->
<!-- ********************************************************************* -->
";

echo "
   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"4\">" . $pedSymp[$lang][0] . "</td>
      </tr>
      <tr class=\"alt\">
       <td><input tabindex=\"" . ($tabIndex + 1) . "\" name=\"anorexia\" " . getData ("anorexia", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][1] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 9) . "\" name=\"sympRash\" " . getData ("sympRash", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][9] . " <i>" . $pedSymp[$lang][10] . "</i></td>
       <td><input tabindex=\"" . ($tabIndex + 17) . "\" name=\"odynophagia\" " . getData ("odynophagia", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][16] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 24) . "\" name=\"pedSympRegurg\" " . getData ("pedSympRegurg", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][23] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 2) . "\" name=\"pedSympAsthenia\" " . getData ("pedSympAsthenia", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][2] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 10) . "\" name=\"pedSympRashText\" " . getData ("pedSympRashText", "text") . " type=\"text\" size=\"25\" maxlength=\"64\">" . showValidationIcon ($encType, "pedSympRashText") . "</td>
       <td><input tabindex=\"" . ($tabIndex + 18) . "\" name=\"pedSympEarache\" " . getData ("pedSympEarache", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][17] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 25) . "\" name=\"nightSweats\" " . getData ("nightSweats", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][24] . "</td>
      </tr>
      <tr class=\"alt\">
       <td><input tabindex=\"" . ($tabIndex + 3) . "\" name=\"headache\" " . getData ("headache", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][3] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 11) . "\" name=\"feverLessMo\" " . getData ("feverLessMo", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][11] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 19) . "\" name=\"numbness\" " . getData ("numbness", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][18] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 26) . "\" name=\"cough\" " . getData ("cough", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][25] . " <i>" . $pedSymp[$lang][10] . "</i></td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 4) . "\" name=\"pedSympSeizure\" " . getData ("pedSympSeizure", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][4] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 12) . "\" name=\"hemoptysie\" " . getData ("hemoptysie", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][12] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 20) . "\" name=\"pedSympInsuffWt\" " . getData ("pedSympInsuffWt", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][19] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 27) . "\" name=\"pedSympCoughText\" " . getData ("pedSympCoughText", "text") . " type=\"text\" size=\"25\" maxlength=\"64\">" . showValidationIcon ($encType, "pedSympCoughText") . "</td>
      </tr>
      <tr class=\"alt\">
       <td><input tabindex=\"" . ($tabIndex + 5) . "\" name=\"pedSympDiarrhea\" " . getData ("pedSympDiarrhea", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][5] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 13) . "\" name=\"pedSympIrritability\" " . getData ("pedSympIrritability", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][13] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 21) . "\" name=\"pedSympWtLoss\" " . getData ("pedSympWtLoss", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][20] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 28) . "\" name=\"sympOther\" " . getData ("sympOther", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][26] . " <i>" . $pedSymp[$lang][10] . "</i></td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 6) . "\" name=\"abPain\" " . getData ("abPain", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][6] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 14) . "\" name=\"pedSympLethargy\" " . getData ("pedSympLethargy", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][14] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 22) . "\" name=\"pedSympVision\" " . getData ("pedSympVision", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][21] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 29) . "\" name=\"otherSymptoms\" " . getData ("otherSymptoms", "text") . " type=\"text\" size=\"25\" maxlength=\"64\">" . showValidationIcon ($encType, "otherSymptoms") . "</td>
      </tr>
      <tr class=\"alt\">
       <td><input tabindex=\"" . ($tabIndex + 7) . "\" name=\"pedSympMuscPain\" " . getData ("pedSympMuscPain", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][7] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 15) . "\" name=\"nausea\" " . getData ("nausea", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][15] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 23) . "\" name=\"pedSympPrurigo\" " . getData ("pedSympPrurigo", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][22] . "</td>
       <td>&nbsp;</td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 8) . "\" name=\"dyspnea\" " . getData ("dyspnea", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][8] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 16) . "\" name=\"pedSympNutritionalEdema\" " . getData ("pedSympNutritionalEdema", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSymp[$lang][27] . "</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
      </tr>
     </table>
    </td>
   </tr>
   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"4\">" . $pedSympWho[$lang][0] . "</td>
      </tr>
      <tr>
       <td width=\"20%\"><table><tr><td id=\"whoStageTitle\"></td><td><b>" . $pedSympWho[$lang][1] . "</b></td></tr></table></td>
       <td width=\"20%\"><b>" . $pedSympWho[$lang][2] . "</b></td>
       <td width=\"30%\"><b>" . $pedSympWho[$lang][3] . "</b></td>
       <td width=\"30%\"><b>" . $pedSympWho[$lang][4] . "</b></td>
      </tr>
      <tr>
       <td width=\"20%\"><input tabindex=\"" . ($tabIndex + 29) . "\" id=\"asymptomaticWho\" name=\"asymptomaticWho\" " . getData ("asymptomaticWho", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSympWho[$lang][5] . "</td>
       <td width=\"20%\"><input tabindex=\"" . ($tabIndex + 30) . "\" id=\"pedSympWhoDiarrhea\" name=\"pedSympWhoDiarrhea\" " . getData ("pedSympWhoDiarrhea", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSympWho[$lang][6] . "</td>
       <td width=\"30%\"><input tabindex=\"" . ($tabIndex + 31) . "\" id=\"pedSympWhoWtLoss2\" name=\"pedSympWhoWtLoss2\" " . getData ("pedSympWhoWtLoss2", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSympWho[$lang][7] . "</td>
       <td valign=\"top\" width=\"30%\"><input tabindex=\"" . ($tabIndex + 32) . "\" id=\"pedSympWhoWtLoss3\" name=\"pedSympWhoWtLoss3\" " . getData ("pedSympWhoWtLoss3", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSympWho[$lang][8] . "</td>
      </tr>
      <tr>
       <td width=\"20%\">&nbsp;</td>
       <td valign=\"top\" width=\"20%\"><input tabindex=\"" . ($tabIndex + 33) . "\" id=\"feverPlusMo\" name=\"feverPlusMo\" " . getData ("feverPlusMo", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedSympWho[$lang][9] . "</td>
       <td width=\"30%\">&nbsp;</td>
       <td width=\"30%\">&nbsp;</td>
      </tr>
     </table>
    </td>
   </tr>
";
?>
