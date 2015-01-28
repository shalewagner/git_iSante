<?php

echo "
<div id=\"pane_allergies\">
<table width=\"100%\">

<tr>
    <td>
     <table class=\"b_header_nb\" cellspacing =\"0\" cellpadding=\"0\" BORDER=\"0\">
      <tr>
       <td colspan=\"8\">&nbsp;</td>
      </tr>
      <tr>
       <td class=\"s_header\" colspan=\"8\">" . $allergies_header[$lang][1] . "</td>
      </tr>
      <tr>
       <td class=\"sm_header_lt\">" . $allergies_subhead1[$lang][0] . "</td>
       <td class=\"sm_header_lt\">" . $allergies_subhead1[$lang][1] . "</td>
       <td class=\"sm_header_lt\" width=\"3%\">&nbsp;</td>
       <td class=\"sm_header_lt\">" . $allergies_subhead1[$lang][2] . "</td>
       <td class=\"sm_header_lt\" width=\"3%\">&nbsp;</td>
       <td class=\"sm_header_cnt\">" . $allergies_subhead2[$lang][0] . "</td>
       <td class=\"sm_header_cnt\">&nbsp;</td>
       <td class=\"sm_header_lt\">&nbsp;&nbsp;" . $allergies_subhead2[$lang][1] . "</td>
      </tr>
      <tr>
       <td class=\"top_line\" colspan=\"6\">&nbsp;</td>
      </tr>
      <tr>
       <td colspan=\"6\"><b>" . $allergies_subhead11[$lang][0] . "</b></td>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
       <td rowspan=\"13\" class=\"reg\">
         &nbsp;&nbsp;<textarea tabindex=\"" . ($tab++) . "\" name=\"treatmentComments\"
           rows=\"18\" cols=\"30\">" .
           getData ("treatmentComments", "textarea") . "</textarea>
       </td>
      </tr>
      <tr class=\"alt\">
       <td id=\"ethambutolStartTitle\" class=\"small_cnt\">" . $ethambutolMM[$lang][0] . "</td>
       <td>
         <input tabindex=\"" . ($tab++) . "\" id=\"ethambutolStartMm\" name=\"ethambutolStartMm\" class=\"small_cnt\" " .
           getData ("ethambutolStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"" . ($tab++) . "\" id=\"ethambutolStartYy\" name=\"ethambutolStartYy\" class=\"small_cnt\" " .
           getData ("ethambutolStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"ethambutolStopTitle\"></td>
       <td>
         <input tabindex=\"" . ($tab++) . "\" id=\"ethambutolStopMm\" name=\"ethambutolStopMm\" class=\"small_cnt\" " .
           getData ("ethambutolStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .

         "/<input tabindex=\"" . ($tab++) . "\" id=\"ethambutolStopYy\" name=\"ethambutolStopYy\" class=\"small_cnt\" " .
		   getData ("ethambutolStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"ethambutolContinuedTitle\"></td>
       <td class=\"sm_header_cnt_np\">
         <input tabindex=\"" . ($tab++) . "\" id=\"ethambutolContinued\" name=\"ethambutolContinued\" " . getData ("ethambutolContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr>
       <td id=\"isoniazidStartTitle\" class=\"small_cnt\">" . $isoniazidMM[$lang][0] . "</td>
       <td>
         <input tabindex=\"" . ($tab++) . "\" id=\"isoniazidStartMm\" name=\"isoniazidStartMm\" class=\"small_cnt\" " .
           getData ("isoniazidStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"" . ($tab++) . "\" id=\"isoniazidStartYy\" name=\"isoniazidStartYy\" class=\"small_cnt\" " .
           getData ("isoniazidStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"isoniazidStopTitle\" />
       <td>
         <input tabindex=\"" . ($tab++) . "\" id=\"isoniazidStopMm\" name=\"isoniazidStopMm\" class=\"small_cnt\" " .
           getData ("isoniazidStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
          "/<input tabindex=\"" . ($tab++) . "\" id=\"isoniazidStopYy\" name=\"isoniazidStopYy\" class=\"small_cnt\" " .
           getData ("isoniazidStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
        <td  id=\"isoniazidContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tab++) . "\" id=\"isoniazidContinued\" name=\"isoniazidContinued\" " . getData ("isoniazidContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr class=\"alt\">
       <td id=\"pyrazinamideStartTitle\" class=\"small_cnt\">" . $pyrazinamideMM[$lang][0] . "</td>
       <td>
         <input tabindex=\"" . ($tab++) . "\" id=\"pyrazinamideStartMm\" name=\"pyrazinamideStartMm\" class=\"small_cnt\" " .
           getData ("pyrazinamideStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"" . ($tab++) . "\" id=\"pyrazinamideStartYy\" name=\"pyrazinamideStartYy\" class=\"small_cnt\" " .
           getData ("pyrazinamideStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"pyrazinamideStopTitle\" />
       <td>
         <input tabindex=\"" . ($tab++) . "\" id=\"pyrazinamideStopMm\" name=\"pyrazinamideStopMm\" class=\"small_cnt\" " .
           getData ("pyrazinamideStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"" . ($tab++) . "\" id=\"pyrazinamideStopYy\" name=\"pyrazinamideStopYy\" class=\"small_cnt\" " .
           getData ("pyrazinamideStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"pyrazinamideContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tab++) . "\" id=\"pyrazinamideContinued\" name=\"pyrazinamideContinued\" " . getData ("pyrazinamideContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr>
       <td id=\"rifampicineStartTitle\" class=\"small_cnt\">" . $rifampicineMM[$lang][0] . "</td>
       <td>
         <input tabindex=\"" . ($tab++) . "\" id=\"rifampicineStartMm\" name=\"rifampicineStartMm\" class=\"small_cnt\" " .
           getData ("rifampicineStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
          "/<input tabindex=\"" . ($tab++) . "\" id=\"rifampicineStartYy\" name=\"rifampicineStartYy\" class=\"small_cnt\" " .
            getData ("rifampicineStartYy", "text") .
            " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"rifampicineStopTitle\">
       <td>
         <input tabindex=\"" . ($tab++) . "\" id=\"rifampicineStopMm\" name=\"rifampicineStopMm\" class=\"small_cnt\" " .
           getData ("rifampicineStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"" . ($tab++) . "\" id=\"rifampicineStopYy\" name=\"rifampicineStopYy\" class=\"small_cnt\" " .
           getData ("rifampicineStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"rifampicineContinuedTitle\">
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tab++) . "\" id=\"rifampicineContinued\" name=\"rifampicineContinued\" " . getData ("rifampicineContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <!-- tr class=\"alt\">
       <td id=\"streptomycineStartTitle\"  class=\"small_cnt\">" . $streptomycineMM[$lang][0] . "</td>
       <td>
         <input tabindex=\"" . ($tab++) . "\" id=\"streptomycineStartMm\" name=\"streptomycineStartMm\" class=\"small_cnt\" " .
           getData ("streptomycineStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tab++) . "\" id=\"streptomycineStartYy\" name=\"streptomycineStartYy\" class=\"small_cnt\" " .
           getData ("streptomycineStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"streptomycineStopTitle\" />
       <td>
         <input tabindex=\"" . ($tab++) . "\" id=\"streptomycineStopMm\" name=\"streptomycineStopMm\" class=\"small_cnt\" " .
           getData ("streptomycineStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tab++) . "\" id=\"streptomycineStopYy\" name=\"streptomycineStopYy\" class=\"small_cnt\" " .
           getData ("streptomycineStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"streptomycineContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tab++) . "\" id=\"streptomycineContinued\" name=\"streptomycineContinued\" " . getData ("streptomycineContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr -->
      <tr>
       <td colspan=\"5\"><b>" . $allergies_subhead11[$lang][1] . "</b></td>
      </tr>
      <tr class=\"alt\">
       <td id=\"acyclovirStartTitle\" class=\"small_cnt\">" . $acyclovirMM[$lang][0] . "</td>
       <td>
         <input tabindex=\"" . ($tab++) . "\" id=\"acyclovirStartMm\" name=\"acyclovirStartMm\" class=\"small_cnt\" " .
           getData ("acyclovirStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"" . ($tab++) . "\" id=\"acyclovirStartYy\" name=\"acyclovirStartYy\" class=\"small_cnt\" " .
           getData ("acyclovirStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"acyclovirStopTitle\">
       <td>
         <input tabindex=\"" . ($tab++) . "\" id=\"acyclovirStopMm\" name=\"acyclovirStopMm\" class=\"small_cnt\" " .
           getData ("acyclovirStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tab++) . "\" id=\"acyclovirStopYy\" name=\"acyclovirStopYy\" class=\"small_cnt\" " .
           getData ("acyclovirStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"acyclovirContinuedTitle\">
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tab++) . "\" id=\"acyclovirContinued\" name=\"acyclovirContinued\" " . getData ("acyclovirContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr>
       <td id=\"cotrimoxazoleStartTitle\" class=\"small_cnt\">" . $cotrimoxazoleMM[$lang][0] . "</td>
       <td>
         <input tabindex=\"" . ($tab++) . "\" id=\"cotrimoxazoleStartMm\" name=\"cotrimoxazoleStartMm\" class=\"small_cnt\" " .
           getData ("cotrimoxazoleStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"" . ($tab++) . "\" id=\"cotrimoxazoleStartYy\" name=\"cotrimoxazoleStartYy\" class=\"small_cnt\" " .
           getData ("cotrimoxazoleStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"cotrimoxazoleStopTitle\">
       <td>
         <input tabindex=\"" . ($tab++) . "\" id=\"cotrimoxazoleStopMm\" name=\"cotrimoxazoleStopMm\" class=\"small_cnt\" " .
           getData ("cotrimoxazoleStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"" . ($tab++) . "\" id=\"cotrimoxazoleStopYy\" name=\"cotrimoxazoleStopYy\" class=\"small_cnt\" " .
           getData ("cotrimoxazoleStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"cotrimoxazoleContinuedTitle\">
       <td  class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tab++) . "\" id=\"cotrimoxazoleContinued\" name=\"cotrimoxazoleContinued\" " . getData ("cotrimoxazoleContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr class=\"alt\">
       <td id=\"fluconazoleStartTitle\" class=\"small_cnt\">" . $fluconazoleMM[$lang][0] . "</td>
       <td>
         <input tabindex=\"" . ($tab++) . "\" id=\"fluconazoleStartMm\"  name=\"fluconazoleStartMm\" class=\"small_cnt\" " .
           getData ("fluconazoleStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"" . ($tab++) . "\" id=\"fluconazoleStartYy\" name=\"fluconazoleStartYy\" class=\"small_cnt\" " .
           getData ("fluconazoleStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"fluconazoleStopTitle\">
       <td>
         <input tabindex=\"" . ($tab++) . "\" id=\"fluconazoleStopMm\" name=\"fluconazoleStopMm\" class=\"small_cnt\" " .
           getData ("fluconazoleStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"" . ($tab++) . "\" id=\"fluconazoleStopYy\" name=\"fluconazoleStopYy\" class=\"small_cnt\" " .
           getData ("fluconazoleStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"fluconazoleContinuedTitle\">
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tab++) . "\" id=\"fluconazoleContinued\" name=\"fluconazoleContinued\" " . getData ("fluconazoleContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr>
       <td id=\"ketaconazoleStartTitle\" class=\"small_cnt\">" . $ketaconazoleMM[$lang][0] . "</td>
       <td>
         <input tabindex=\"" . ($tab++) . "\" id=\"ketaconazoleStartMm\" name=\"ketaconazoleStartMm\" class=\"small_cnt\" " .
           getData ("ketaconazoleStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"" . ($tab++) . "\" id=\"ketaconazoleStartYy\" name=\"ketaconazoleStartYy\" class=\"small_cnt\" " .
           getData ("ketaconazoleStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"ketaconazoleStopTitle\" />
       <td>
         <input tabindex=\"" . ($tab++) . "\" id=\"ketaconazoleStopMm\" name=\"ketaconazoleStopMm\" class=\"small_cnt\" " .
           getData ("ketaconazoleStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"" . ($tab++) . "\" id=\"ketaconazoleStopYy\" name=\"ketaconazoleStopYy\" class=\"small_cnt\" " .
           getData ("ketaconazoleStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"ketaconazoleContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tab++) . "\" id=\"ketaconazoleContinued\" name=\"ketaconazoleContinued\" " . getData ("ketaconazoleContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr class=\"alt\">
       <td id=\"traditionalStartTitle\" class=\"small_cnt\">" . $traditionalStartMm[$lang][0] . "</td>
       <td>
         <input tabindex=\"" . ($tab++) . "\" id=\"traditionalStartMm\" name=\"traditionalStartMm\" class=\"small_cnt\" " .
           getData ("traditionalStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"" . ($tab++) . "\" id=\"traditionalStartYy\" name=\"traditionalStartYy\" class=\"small_cnt\" " .
           getData ("traditionalStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"traditionalStopTitle\" />
       <td>
         <input tabindex=\"" . ($tab++) . "\" id=\"traditionalStopMm\" name=\"traditionalStopMm\" class=\"small_cnt\" " .
           getData ("traditionalStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"" . ($tab++) . "\" id=\"traditionalStopYy\" name=\"traditionalStopYy\" class=\"small_cnt\" " .
           getData ("traditionalStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"traditionalContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tab++) . "\" id=\"traditionalContinued\" name=\"traditionalContinued\" " . getData 
("traditionalContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr>
       <td class=\"small_cnt\">" . $other1Text[$lang][1] .
         " <input tabindex=\"" . ($tab++) . "\" name=\"other3Text\" class=\"small_cnt\" " .
             getData ("other3Text", "text") .
             " type=\"text\" size=\"20\" maxlength=\"255\"></td>
       <td><table><tr><td  id=\"other3StartTitle\"></td><td>
         <input tabindex=\"" . ($tab++) . "\" id=\"other3StartMm\" name=\"other3MM\" class=\"small_cnt\" " .
           getData ("other3MM", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"" . ($tab++) . "\" id=\"other3StartYy\" name=\"other3YY\" class=\"small_cnt\" " .
           getData ("other3YY", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td></tr></table></td>
       <td id=\"other3StopTitle\" />
       <td>
         <input tabindex=\"" . ($tab++) . "\" id=\"other3StopMm\" name=\"other3SpMM\" class=\"small_cnt\" " .
           getData ("other3SpMM", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         "/<input tabindex=\"" . ($tab++) . "\" id=\"other3StopYy\" name=\"other3SpYY\" class=\"small_cnt\" " .
           getData ("other3SpYY", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
       <td id=\"other3ContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tab++) . "\" id=\"other3Continued\" name=\"other3Continued\" " . getData ("other3Continued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
     </table>
    </td>
   </tr>
  </table>
 </div>
";
?>
