<?php

echo "
<!-- ******************************************************************** -->
<!-- **************************** Symptoms ****************************** -->
<!--  (tab indices " . ($tabIndex + 1) . " - " . ($tabIndex + 1000) . ")  -->
<!-- ******************************************************************** -->
";
if ($encType == "1" && $version == "1")
	$syHead = $intakeSectLabs1[$lang][12];
else
	$syHead = $symptoms_header_1[$lang][0];

echo "
   <tr>
    <td>
     <table class=\"b_header_nb\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">
      <tr>
       <td class=\"s_header\" colspan=\"4\">" . $symptoms_header[$lang][1] . "</td>
      </tr>
      <tr class=\"alt\">
       <td><input tabindex=\"" . ($tabIndex + 1) .
         "\" name=\"abPain\" " . getData ("abPain", "checkbox") .
         " type=\"checkbox\" value=\"On\"> " .
         $abPain[$lang][1] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 6) . "\" name=\"headache\" " . getData ("headache", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $headache[$lang][1] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 11) . "\" name=\"odynophagia\" " . getData ("odynophagia", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $odynophagia[$lang][1] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 14) . "\" name=\"sympOther\" " . getData ("sympOther", "checkbox") . " type=\"checkbox\" value=\"On\">" . $otherSymptoms[$lang][1] . "</td>
      
	  </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 2) . "\" name=\"anorexia\" " . getData ("anorexia", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $anorexia_1[$lang][1] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 7) . "\" name=\"hemoptysie\" " . getData ("hemoptysie", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $hemoptysie[$lang][1] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 12) . "\" name=\"sympRash\" " . getData ("sympRash", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $sympRash[$lang][1] . "</td>      
       <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class=\"small_cnt\" tabindex=\"" . ($tabIndex + 22) . "\" name=\"otherSymptoms\" " . getData ("otherSymptoms", "text") . " type=\"text\" size=\"30\" maxlength=\"255\"/></td>

      </tr>
      <tr class=\"alt\">
       <td><input tabindex=\"" . ($tabIndex + 3) . "\" name=\"cough\" " . getData ("cough", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $cough[$lang][1] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 8) . "\" name=\"nausea\" " . getData ("nausea", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $nausea[$lang][1] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 13) . "\" name=\"vomiting\" " . getData ("vomiting", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $vomiting[$lang][1] . "</td>
	   <td><input tabindex=\"" . ($tabIndex + 25) . "\" name=\"douleurThoracique\" " . getData ("douleurThoracique", "checkbox") . " type=\"checkbox\" value=\"On\">" . $douleurThoracique[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 4) . "\" name=\"expectoration\" " . getData ("expectoration", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $expectoration[$lang][1] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 9) . "\" name=\"nightSweats\" " . getData ("nightSweats", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $nightSweats[$lang][1] . "</td>
	   <td><input tabindex=\"" . ($tabIndex + 27) . "\" name=\"perteAppetit\" " . getData ("perteAppetit", "checkbox") . " type=\"checkbox\" value=\"On\">" . $perteAppetit[$lang][1] . "</td>";
        if (getUiConfig(getSessionUser()) == "2" || getUiConfig(getSessionUser()) == "3") {
          echo "
       <td class=\"POC\"><input tabindex=\"" . ($tabIndex + 15) . "\" name=\"prurigo\" " . getData ("prurigo", "checkbox") . " type=\"checkbox\" value=\"On\">" . "Prurigo" . "</td>";
        }
      echo "
      </tr>
      <tr>
       <td class=\"alt\"><input tabindex=\"" . ($tabIndex + 5) . "\" name=\"dyspnea\" " . getData ("dyspnea", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $dyspnea[$lang][1] . "</td>
       <td class=\"alt\"><input tabindex=\"" . ($tabIndex + 10) . "\" name=\"numbness\" " . getData ("numbness", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $numbness[$lang][1] . "</td>
	   <td><input tabindex=\"" . ($tabIndex + 26) . "\" name=\"fievreVesperale\" " . getData ("fievreVesperale", "checkbox") . " type=\"checkbox\" value=\"On\">" . $fievreVesperale[$lang][1] . "</td>	
<td><input tabindex=\"" . ($tabIndex + 24) . "\" name=\"adenopathies\" " . getData ("adenopathies", "checkbox") . " type=\"checkbox\" value=\"On\">" . $adenopathies[$lang][1] . "</td>	   
      </tr>
     </table>
    </td>
   </tr>
   <tr>
    <td>&nbsp;</td>
   <tr><td></td>
   </tr><tr>
    <td>
     <table class=\"b_header_nb\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">
      <tr>
       <td class=\"s_header\" colspan=\"4\">" . $syHead . "</td>
      </tr>
      <tr>
       <td width=\"20%\"><table><tr><td  id=\"whoStageTitle\"></td><td><b>" . $asymptomaticWho[$lang][0] . "</b></td></tr></table></td>
       <td width=\"20%\"><b>" . $weightLossLessTenPercMo[$lang][0] . "</b></td>
       <td width=\"30%\"><b>" . $weightLossPlusTenPercMo[$lang][0] . "</b></td>
       <td width=\"30%\"><b>" . $weightLossPlusTenPercWithDiarrheaPlusMo[$lang][0] . "</b></td>
      </tr>
      <tr>
       <td width=\"20%\"><input tabindex=\"" . ($tabIndex + 16) . "\" id=\"asymptomaticWho\" name=\"asymptomaticWho\" " . getData ("asymptomaticWho", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $asymptomaticWho[$lang][1] . "</td>
       <td width=\"20%\"><input tabindex=\"" . ($tabIndex + 18) . "\" id=\"weightLossLessTenPercMo\" name=\"weightLossLessTenPercMo\" " . getData ("weightLossLessTenPercMo", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $weightLossLessTenPercMo[$lang][1] . "</td>
       <td width=\"30%\"><input tabindex=\"" . ($tabIndex + 21) . "\" id=\"weightLossPlusTenPercMo\" name=\"weightLossPlusTenPercMo\" " . getData ("weightLossPlusTenPercMo", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $weightLossPlusTenPercMo[$lang][1] . "</td>
       <td valign=\"top\" rowspan=\"3\" width=\"30%\"><input tabindex=\"" . ($tabIndex + 24) . "\" id=\"wtLossTenPercWithDiarrMo\" name=\"wtLossTenPercWithDiarrMo\" " . getData ("wtLossTenPercWithDiarrMo", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $weightLossPlusTenPercWithDiarrheaPlusMo[$lang][1] . "</td>
      </tr>
      <tr>
       <td valign=\"top\" rowspan=\"2\" width=\"20%\"><input tabindex=\"" . ($tabIndex + 17) . "\" id=\"chronicWeakness\" name=\"chronicWeakness\" " . getData ("chronicWeakness", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $chronicWeakness[$lang][1] . "</td>
       <td width=\"20%\"><input tabindex=\"" . ($tabIndex + 19) . "\" id=\"feverLessMo\"  name=\"feverLessMo\" " . getData ("feverLessMo", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $feverLessMo[$lang][1] . "</td>
       <td width=\"30%\"><input tabindex=\"" . ($tabIndex + 22) . "\" id=\"feverPlusMo\" name=\"feverPlusMo\" " . getData ("feverPlusMo", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $feverPlusMo[$lang][1] . "</td>
      </tr>
      <tr>
       <td width=\"20%\"><input tabindex=\"" . ($tabIndex + 20) . "\" id=\"diarrheaLessMo\" name=\"diarrheaLessMo\" " . getData ("diarrheaLessMo", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $diarrheaLessMo[$lang][1] . "</td>
       <td width=\"30%\"><input tabindex=\"" . ($tabIndex + 23) . "\" id=\"diarrheaPlusMo\" name=\"diarrheaPlusMo\" " . getData ("diarrheaPlusMo", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $diarrheaPlusMo[$lang][1] . "</td>
      </tr>
     </table>
    </td>
   </tr>
";
?>
