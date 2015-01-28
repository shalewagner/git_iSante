<?php

echo "
<!-- -------------------------------------------------------------------- -->
<!-- -------------------------- ARV Enrollment -------------------------- -->
<!-- ------------------- (tab indices " . ($tabIndex + 1) . " - " . ($tabIndex + 1000) . ") -------------------- -->
<!-- -------------------------------------------------------------------- -->
";

echo "
  <hr noshade>

  <p><b>" . $arvEnrollment_header[$lang][1] . "</b>

  <table cellspacing=\"10\" cellpadding=\"0\" width=\"100%\" border=\"1\">
   <tr>
    <td>
     <table cellspacing=\"5\" cellpadding=\"0\" width=\"100%\" border=\"0\">
      <tr>
       <td><b>" . $arv[$lang][0] . "</b></td>
       <td><input tabindex=\"" . ($tabIndex + 1) . "\" name=\"arv[]\" " . getData ("arv", "checkbox", 1) . " type=\"checkbox\" value=\"1\"> " . $arv[$lang][1] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 2) . "\" name=\"arv[]\" " . getData ("arv", "checkbox", 2) . " type=\"checkbox\" value=\"2\"> " . $arv[$lang][2] . "</td>
      </tr>
     </table>
    </td>
   </tr>
   <tr>
    <td>
     <table cellspacing=\"5\" cellpadding=\"0\" width=\"100%\" border=\"0\">
      <tr>
       <th align=\"left\">" . $arvEnrollment_subhead1[$lang][0] . "</th>
       <th align=\"center\"></th>
       <th align=\"left\">" . $arvEnrollment_subhead1[$lang][1] . "</th>
       <th align=\"left\">" . $arvEnrollment_subhead1[$lang][2] . "</th>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 101) . "\" name=\"initiateTB\" " . getData ("initiateTB", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $initiateTB[$lang][1] . "</td>
       <td align=\"center\">" . $initiateTB[$lang][2] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 116) . "\" name=\"TBprogram\" " . getData ("TBprogram", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $TBprogram[$lang][1] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 123) . "\" name=\"PMTCTprogram\" " . getData ("PMTCTprogram", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $PMTCTprogram[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 102) . "\" name=\"continueTB\" " . getData ("continueTB", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $continueTB[$lang][1] . "</td>
       <td align=\"center\">" . $continueTB[$lang][2] . "</td>
       <td></td>
       <td><input tabindex=\"" . ($tabIndex + 124) . "\" name=\"familyPlanProg\" " . getData ("familyPlanProg", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $familyPlanProg[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 103) . "\" name=\"inadPsychPro\" " . getData ("inadPsychPro", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $inadPsychPro[$lang][1] . "</td>
       <td align=\"center\">" . $inadPsychPro[$lang][2] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 117) . "\" name=\"psychEval\" " . getData ("psychEval", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $psychEval[$lang][1] . "</td>
       <td></td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 104) . "\" name=\"poorAdherence\" " . getData ("poorAdherence", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $poorAdherence[$lang][1] . "</td>
       <td align=\"center\">" . $poorAdherence[$lang][2] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 118) . "\" name=\"ARVadherCoun\" " . getData ("ARVadherCoun", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $ARVadherCoun[$lang][1] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 125) . "\" name=\"immunProg\" " . getData ("immunProg", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $immunProg[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 105) . "\" name=\"patientPref\" " . getData ("patientPref", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $patientPref[$lang][1] . "</td>
       <td align=\"center\">" . $patientPref[$lang][2] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 119) . "\" name=\"ARVeducCoun\" " . getData ("ARVeducCoun", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $ARVeducCoun[$lang][1] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 126) . "\" name=\"hospitalization\" " . getData ("hospitalization", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $hospitalization[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 106) . "\" name=\"inadPrepForAd\" " . getData ("inadPrepForAd", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $inadPrepForAd[$lang][1] . "</td>
       <td align=\"center\">" . $inadPrepForAd[$lang][2] . "</td>
       <td></td>
       <td rowspan=\"3\"><input tabindex=\"" . ($tabIndex + 127) . "\" name=\"otherMedRef\" " . getData ("otherMedRef", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $otherMedRef[$lang][1] . "<br /><textarea tabindex=\"" . ($tabIndex + 128) . "\" name=\"otherMedRefText\" cols=\"30\" rows=\"3\">" . getData ("otherMedRefText", "textarea") . "</textarea></td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 107) . "\" name=\"doesntAccAcc\" " . getData ("doesntAccAcc", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $doesntAccAcc[$lang][1] . "</td>
       <td align=\"center\">" . $doesntAccAcc[$lang][2] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 120) . "\" name=\"psychSocialCoun\" " . getData ("psychSocialCoun", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $psychSocialCoun[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 108) . "\" name=\"doesntAccHome\" " . getData ("doesntAccHome", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $doesntAccHome[$lang][1] . "</td>
       <td align=\"center\">" . $doesntAccHome[$lang][2] . "</td>
       <td></td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 109) . "\" name=\"weakFamilySupp\" " . getData ("weakFamilySupp", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $weakFamilySupp[$lang][1] . "</td>
       <td align=\"center\">" . $weakFamilySupp[$lang][2] . "</td>
       <td></td>
       <td rowspan=\"6\">" . $notesArvEnroll[$lang][1] . "<br /><textarea tabindex=\"" . ($tabIndex + 129) . "\" name=\"notesArvEnroll\" cols=\"30\" rows=\"6\">" . getData ("notesArvEnroll", "textarea") . "</textarea></td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 110) . "\" name=\"barriersToReg\" " . getData ("barriersToReg", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $barriersToReg[$lang][1] . "</td>
       <td align=\"center\">" . $barriersToReg[$lang][2] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 121) . "\" name=\"transAssProg\" " . getData ("transAssProg", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $transAssProg[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 111) . "\" name=\"livesOutsideZone\" " . getData ("livesOutsideZone", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $livesOutsideZone[$lang][1] . "</td>
       <td align=\"center\">" . $livesOutsideZone[$lang][2] . "</td>
       <td><input tabindex=\"" . ($tabIndex + 122) . "\" name=\"otherARVprog\" " . getData ("otherARVprog", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $otherARVprog[$lang][1] . "</td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 112) . "\" name=\"progHasRlimit\" " . getData ("progHasRlimit", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $progHasRlimit[$lang][1] . "</td>
       <td align=\"center\">" . $progHasRlimit[$lang][2] . "</td>
       <td></td>
      </tr>
      <tr>
       <td><input tabindex=\"" . ($tabIndex + 113) . "\" name=\"ARVsTempUn\" " . getData ("ARVsTempUn", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $ARVsTempUn[$lang][1] . "</td>
       <td align=\"center\">" . $ARVsTempUn[$lang][2] . "</td>
       <td></td>
      </tr>
      <tr>
       <td colspan=\"3\"><input tabindex=\"" . ($tabIndex + 114) . "\" name=\"otherMedElig\" " . getData ("otherMedElig", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $otherMedElig[$lang][1] . " <input tabindex=\"" . ($tabIndex + 115) . "\" name=\"otherMedEligText\" " . getData ("otherMedEligText", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
      </tr>
     </table>
    </td>
   </tr>
   <tr>
    <td>
     <table cellspacing=\"5\" cellpadding=\"0\" width=\"100%\" border=\"0\">
      <tr>
       <td><b>" . $nextVisitWeeks[$lang][1] . "</b> <input tabindex=\"" . ($tabIndex + 201) . "\" name=\"nextVisitWeeks\" " . getData ("nextVisitWeeks", "text") . " type=\"text\" size=\"16\" maxlength=\"64\"> " . $nextVisitWeeks[$lang][2] . "</td>
";
//if ($lang == "en") echo "
//       <td><b>" . $nextVisitDD[$lang][1] . "</b> <input tabindex=\"" . ($tabIndex + 202) . "\" name=\"nextVisitMM\" " . getData ("nextVisitMM", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 203) . "\" name=\"nextVisitDD\" " . getData ("nextVisitDD", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 204) . "\" name=\"nextVisitYY\" " . getData ("nextVisitYY", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"> " . $nextVisitYY[$lang][2] . "</td>";
echo "
       <td><b>" . $nextVisitDD[$lang][1] . "</b> <input tabindex=\"" . ($tabIndex + 202) . "\" name=\"nextVisitDD\" " . getData ("nextVisitDD", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 203) . "\" name=\"nextVisitMM\" " . getData ("nextVisitMM", "text") . " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 204) . "\" name=\"nextVisitYY\" " . getData ("nextVisitYY", "text") . " type=\"text\" size=\"2\" maxlength=\"2\"> " . $nextVisitYY[$lang][2] . "</td>
";
echo "
      </tr>
     </table>
    </td>
   </tr>
  </table>
  </p>
";
?>
