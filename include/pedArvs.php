<?php
echo "
<tr>
    <td>
	     <table class=\"b_header_nb\" cellspacing =\"0\" cellpadding=\"0\" BORDER=\"0\">
	      <tr>
	       <td class=\"s_header\" colspan=\"" . ((!empty ($followup) && $followup === 1) ? 19 : 11) . "\" width=\"100%\">" . ((!empty ($followup) && $followup === 1) ? $pedFollowup[$lang][17] : $pedArvs[$lang][0]) . "</td>
	      </tr>";

echo (!empty ($followup) && $followup == 1) ? "
	      <tr>
	       <td  colspan=\"19\" width=\"100%\">" . $pedFollowup[$lang][18] . " <input tabindex=\"6201\"  id=\"arvEverY\" name=\"arvEver[]\" " . getData ("arvEver", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $ynu[$lang][0] . " <input tabindex=\"6202\" id=\"arvEverN\" name=\"arvEver[]\" " . getData ("arvEver", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $pedFollowup[$lang][19] . " <i>" . $pedFollowup[$lang][20] . "</i></td>
	      </tr>
	      <tr>
	       <td colspan=\"19\" width=\"100%\"><i>" . $pedFollowup[$lang][21] . "</i></td>
	      </tr>
	      <tr>
	       <td width=\"15%\">&nbsp;</td>
               <td class=\"sm_header_cnt\" width=\"5%\">" . $pedFollowup[$lang][22] . "</td>
               <td width=\"5%\">&nbsp;</td>
	       <td class=\"sm_header_lt\" width=\"15%\">" . $pedFollowup[$lang][23] . "</td>
	       <td class=\"sm_header_lt\" colspan=\"5\" width=\"20%\">" . $pedFollowup[$lang][24] . "</td>
               <td colspan=\"2\" width=\"3%\">&nbsp;</td>
	       <td class=\"sm_header_lt\" colspan=\"8\" width=\"37%\">" . $pedFollowup[$lang][25] . "</td>
	      </tr>
	      <tr>
	       <td colspan=\"4\" width=\"40%\">&nbsp;</td>
		   <td class=\"sm_header_cnt\" width=\"4%\">" . $pedFollowup[$lang][47] . "</td>
	       <td class=\"sm_header_cnt\" width=\"4%\">" . $pedFollowup[$lang][26] . "</td>
	       <td class=\"sm_header_cnt\" width=\"4%\">" . $pedFollowup[$lang][27] . "</td>
	       <td class=\"sm_header_cnt\" width=\"4%\">" . $pedFollowup[$lang][28] . "</td>
	       <td class=\"sm_header_cnt\" width=\"4%\">" . $pedFollowup[$lang][29] . "</td>
	       <td class=\"sm_header_cnt\" width=\"4%\">" . $pedFollowup[$lang][30] . "</td>
               <td colspan=\"2\" width=\"2%\">&nbsp;</td>
	       <td class=\"sm_header_cnt\" width=\"4%\">" . $pedFollowup[$lang][31] . "</td>
	       <td class=\"sm_header_cnt\" width=\"4%\">" . $pedFollowup[$lang][32] . "</td>
	       <td class=\"sm_header_cnt\" width=\"4%\">" . $pedFollowup[$lang][33] . "</td>
	       <td class=\"sm_header_cnt\" width=\"4%\">" . $pedFollowup[$lang][34] . "</td>
	       <td class=\"sm_header_cnt\" width=\"4%\">" . $pedFollowup[$lang][35] . "</td>
	       <td class=\"sm_header_cnt\" width=\"4%\">" . $pedFollowup[$lang][36] . "</td>
	       <td class=\"sm_header_cnt\" width=\"4%\">" . $pedFollowup[$lang][37] . "</td>
	       <td class=\"sm_header_cnt\" width=\"6%\">" . $pedFollowup[$lang][38] . "</td>
	      </tr>
	      <tr>
	       <td class=\"top_line\" colspan=\"19\" width=\"100%\">&nbsp;</td>
              </tr>
              <tr>
	       <td colspan=\"10\" width=\"60%\"><b><a class=\"toggle_display\"
	            onclick=\"toggleDisplay(0,$arvSubHeadElems[0]);\"
	            title=\"Toggle display\">
	            <span id=\"section0Y\" style=\"display:none\">(+)</span>
	            <span id=\"section0N\">(-)&nbsp;</span>" .
	          $arv_subhead3[$version][$lang][1] .
	         "</a></b></td>
               <td class=\"vert_line\" rowspan=\"20\" width=\"1%\">&nbsp;</td>
               <td class=\"left_pad\" rowspan=\"20\" width=\"2%\">&nbsp;</td>
               <td colspan=\"8\" width=\"37%\">&nbsp;</td>
	      </tr>" . $ped_arv_rows . "
              <tr>
               <td class=\"sm_lt\" colspan=\"17\"><b>" . $arv_subhead14[$lang][0] . "</b> &nbsp;" . $arv_subhead12[$lang][1] . " &nbsp;" . $arv_subhead14[$lang][1] . " &nbsp;" . $arv_subhead18[$lang][0] . " &nbsp;" . $arv_subhead18[$lang][1] . " &nbsp;" . $arv_subhead18[$lang][2] . " &nbsp;" . $arv_subhead14[$lang][2] . " &nbsp;" . $arv_subhead13[$lang][0] . " &nbsp;" . $arv_subhead15[$lang][0] . " &nbsp;" . $arv_subhead13[$lang][1] . " &nbsp;" . $arv_subhead15[$lang][1] . " &nbsp;" . $arv_subhead13[$lang][2] . " &nbsp;" . $arv_subhead15[$lang][2] . " &nbsp;<b>" . $pedFollowup[$lang][41] . "</b>=" . $pedFollowup[$lang][42] . "</td>
              </tr>
            " : "
	      <tr>
	       <td colspan=\"2\" width=\"30%\">" . $pedArvs[$lang][1] . "</td>
               <td colspan=\"9\" width=\"70%\"><input  tabindex=\"6201\"  id=\"pedArvEver1\" name=\"pedArvEver[]\" " . getData ("pedArvEver", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $pedArvs[$lang][2] . " <i>" . $pedArvs[$lang][3] . "</i> <input tabindex=\"6202\" id=\"pedArvEver2\" name=\"pedArvEver[]\" " . getData ("pedArvEver", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $pedArvs[$lang][2] . " <i>" . $pedArvs[$lang][4] . "</i></td>
	      </tr>
	      <tr>
	       <td colspan=\"2\" width=\"30%\">&nbsp;</td>
               <td colspan=\"9\" width=\"70%\"><input  tabindex=\"6203\" id=\"arvEverY\"  name=\"arvEver[]\" " . getData ("arvEver", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $pedArvs[$lang][5] . " <i>" . $pedArvs[$lang][6] . "</i></td>
	      </tr>
	      <tr>
	       <td colspan=\"2\" width=\"30%\">" . $pedArvs[$lang][7] . "</td>
               <td colspan=\"9\" width=\"70%\"><input  class=\"pedArvKnown\"  id=\"pedArvKnownY\" tabindex=\"6204\" name=\"pedArvKnown[]\" " . getData ("pedArvKnown", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $ynu[$lang][0] . " <input tabindex=\"6205\"  class=\"pedArvKnown\"  id=\"pedArvKnownN\" name=\"pedArvKnown[]\" " . getData ("pedArvKnown", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $ynu[$lang][1] . "</td>
	      </tr>
	      <tr>
	       <td colspan=\"2\" width=\"30%\"><i>" . $pedArvs[$lang][8] . "</i></td>
	       <td colspan=\"9\" class=\"sm_cnt\" width=\"70%\"><b>" . $pedArvs[$lang][9] . " &nbsp; " . $pedArvs[$lang][10] . "</b>" . $pedArvs[$lang][11] . " &nbsp; <b>" . $pedArvs[$lang][12] . "</b>" . $pedArvs[$lang][13] . " &nbsp; <b>" . $pedArvs[$lang][14] . "</b>" . $pedArvs[$lang][15] . " &nbsp; <b>" . $pedArvs[$lang][16] . "</b>" . $pedArvs[$lang][17] . "</td>
	      </tr>
	      <tr>
	       <td class=\"bottom_line\" colspan=\"11\" width=\"100%\">&nbsp;</td>
	      </tr>
	      <tr>
	       <td width=\"15%\">&nbsp;</td>
	       <td class=\"sm_header_lt\" width=\"15%\">" . $pedArvs[$lang][18] . "</td>
	       <td width=\"5%\">&nbsp;</td>
	       <td class=\"sm_header_lt\" width=\"15%\">" . $pedArvs[$lang][19] . "</td>
	       <td class=\"sm_header_cnt\" width=\"15%\">" . $pedArvs[$lang][20] . "</td>
	       <td class=\"sm_header_cnt\"width=\"15%\">" . $pedArvs[$lang][21] . "</td>
	       <td class=\"sm_header_lt\" colspan=\"5\" width=\"24%\">" . $pedArvs[$lang][22] . "</td>
	      </tr>
	      <tr>
	       <td class=\"top_line\" colspan=\"11\" width=\"100%\">&nbsp;</td>
	      </tr>
	      <tr>
	       <td colspan=\"6\" width=\"76%\"><b><a class=\"toggle_display\"
	            onclick=\"toggleDisplay(0,$arvSubHeadElems[0]);\"
	            title=\"Toggle display\">
	            <span id=\"section0Y\" style=\"display:none\">(+)</span>
	            <span id=\"section0N\">(-)&nbsp;</span>" .
	          $arv_subhead3[$version][$lang][1] .
	         "</a></b></td>
		   <td class=\"sm_header_cnt\" width=\"4%\">" . $pedArvs[$lang][24] . "</td>
	       <td class=\"sm_header_cnt\" width=\"4%\">" . $pedArvs[$lang][10] . "</td>		   
	       <td class=\"sm_header_cnt\" width=\"4%\">" . $pedArvs[$lang][12] . "</td>
	       <td class=\"sm_header_cnt\" width=\"4%\">" . $pedArvs[$lang][14] . "</td>
	       <td class=\"sm_header_cnt\" width=\"4%\">" . $pedArvs[$lang][16] . "</td>
	       <td class=\"sm_header_cnt\" width=\"4%\">" . $pedArvs[$lang][23] . "</td>
	      </tr>" . $ped_arv_rows . "
	      <tr>
	       <td class=\"s_header\" colspan=\"11\" width=\"100%\">" . $arv_subhead11[$lang][1] . "</td>
	      </tr>
	      <tr>
	       <td colspan=\"11\"><textarea tabindex=\"6401\" name=\"drugComments\" cols=\"80\" rows=\"5\">" . getData ("drugComments", "textarea") . "</textarea></td>
	      </tr>
";

echo "
	     </table>
    </td>
</tr>
";

if (!empty ($followup) && $followup == 1) {
  echo "

<!-- ****************************************************************** -->
<!-- ************************- Toxicity/Adherence ********************* -->
<!-- ********************* (tab indices 6601 - 6800) ****************** -->
<!-- ****************************************************************** -->

   <tr>
    <td>
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\">" . $pedFollowup[$lang][43] . "</td>
      </tr>
      <tr>
       <td><b>" . $pedFollowup[$lang][44] . "</b> <input tabindex=\"6601\" name=\"currToxicityText\" " . getData ("currToxicityText", "text") . " type=\"text\" size=\"80\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td>
        <span><input tabindex=\"6602\" id=\"currToxRash\" name=\"currToxRash\" " . getData ("currToxRash", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $currToxRash[$lang][1] . "</span>
        <span><input tabindex=\"6603\" id=\"currToxAnemia\" name=\"currToxAnemia\" " . getData ("currToxAnemia", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $currToxAnemia[$lang][1] . "</span>
        <span><input tabindex=\"6604\" id=\"currToxHep\" name=\"currToxHep\" " . getData ("currToxHep", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $currToxHep[$lang][1] . "</span>
        <span><input tabindex=\"6605\" id=\"currToxCNS\" name=\"currToxCNS\" " . getData ("currToxCNS", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $currToxCNS[$lang][1] . "</span>
        <span><input tabindex=\"6606\" id=\"currToxHyper\" name=\"currToxHyper\" " . getData ("currToxHyper", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $currToxHyper[$lang][1] . "</span>
        <span><input tabindex=\"6607\" id=\"currToxOther\" name=\"currToxOther\" " . getData ("currToxOther", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $currToxOther[$lang][1] . "
        <input tabindex=\"6608\" id=\"currToxText\" name=\"currToxText\" " . getData ("currToxText", "text") . " type=\"text\" size=\"40\" maxlength=\"20\"></span>
       </td>
      </tr>
      <tr>
	   <td>&nbsp;</td>
      </tr>
      <tr>
       <td class=\"s_header\">" . $adherenceComments[$lang][1] . "</td>
      </tr>
      <tr>
       <td><textarea tabindex=\"6701\" name=\"adherenceComments\" cols=\"80\" rows=\"5\">" . getData ("adherenceComments", "textarea") . "</textarea></td>
      </tr>
     </table>
    </td>
   </tr>
";
}

$tabIndex = (!empty ($followup) && $followup === 1) ? 6800 : 6500;
echo "
<!-- ******************************************************************** -->
<!-- *************************** Treatments ***************************** -->
<!--  (tab indices " . ($tabIndex + 1) . " - " . ($tabIndex + 200) . ") ********************* -->
<!-- ******************************************************************** -->

<tr>
    <td>
     <table class=\"b_header_nb\" cellspacing =\"0\" cellpadding=\"0\" BORDER=\"0\">
      <tr>
       <td class=\"s_header\" colspan=\"8\">" . ((!empty ($followup) && $followup === 1) ? $pedFollowup[$lang][45] : $pedTreats[$lang][0]) . "</td>
      </tr>
      <tr>
       <td colspan=\"8\"><i>" . $pedTreats[$lang][1] . "</i></td>
      </tr>
      <tr>
       <td colspan=\"8\"><i>" . $pedTreats[$lang][2] . "</i></td>
      </tr>
      <tr>
       <td class=\"bottom_line\" colspan=\"8\">&nbsp;</td>
      </tr>
";
echo (!empty ($followup) && $followup === 1) ?
"
      <tr>
       <td class=\"sm_header_lt\">" . $pedTreats[$lang][3] . "</td>
       <td class=\"sm_header_cnt\">&nbsp;</td>
       <td class=\"sm_header_cnt\">" . $pedFollowup[$lang][46] . "</td>
       <td class=\"sm_header_cnt\">&nbsp;</td>
       <td class=\"sm_header_lt\">" . $pedTreats[$lang][5] . "</td>
       <td class=\"sm_header_cnt\">&nbsp;</td>
       <td class=\"sm_header_cnt\">&nbsp;</td>
       <td class=\"sm_header_lt\">&nbsp;&nbsp;" . $pedTreats[$lang][7] . "</td>
      </tr>
" : "
      <tr>
       <td class=\"sm_header_lt\">" . $pedTreats[$lang][3] . "</td>
       <td class=\"sm_header_cnt\">&nbsp;</td>
       <td class=\"sm_header_lt\">" . $pedTreats[$lang][4] . "</td>
       <td class=\"sm_header_cnt\">&nbsp;</td>
       <td class=\"sm_header_lt\">" . $pedTreats[$lang][5] . "</td>
       <td class=\"sm_header_cnt\">&nbsp;</td>
       <td class=\"sm_header_cnt\">" . $pedTreats[$lang][6] . "</td>
       <td class=\"sm_header_lt\">&nbsp;&nbsp;" . $pedTreats[$lang][7] . "</td>
      </tr>
";

echo "
      <tr>
       <td class=\"top_line\" colspan=\"8\">&nbsp;</td>
      </tr>
      <tr>
       <td colspan=\"7\"><b>" . $pedTreats[$lang][8] . "</b></td>
       <td rowspan=\"17\" class=\"reg\">
         &nbsp;&nbsp;<textarea tabindex=\"" . ($tabIndex + 101) . "\" name=\"treatmentComments\"
           rows=\"18\" cols=\"30\">" .
           getData ("treatmentComments", "textarea") . "</textarea>
       </td>
      </tr>
      <tr class=\"alt\">
       <td class=\"small_cnt\">" . $pedTreats[$lang][9] . "</td>
";
echo (!empty ($followup) && $followup === 1) ?
"      <td id=\"ethambutolContinuedTitle\" />
       <td class=\"sm_header_cnt_np\">
         <input tabindex=\"" . ($tabIndex + 1) . "\" id=\"ethambutolContinued\" name=\"ethambutolContinued\" " . getData ("ethambutolContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
" : "
	   <td id=\"ethambutolStartTitle\" />
       <td>
         <input tabindex=\"" . ($tabIndex + 1) . "\" id=\"ethambutolStartMm\" name=\"ethambutolStartMm\" class=\"small_cnt\" " .
           getData ("ethambutolStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 2) . "\" id=\"ethambutolStartYy\" name=\"ethambutolStartYy\" class=\"small_cnt\" " .
           getData ("ethambutolStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo "
       <td id=\"ethambutolStopTitle\">&nbsp;</td>
       <td>
         <input tabindex=\"" . ($tabIndex + 3) . "\" id=\"ethambutolStopMm\" name=\"ethambutolStopMm\" class=\"small_cnt\" " .
           getData ("ethambutolStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 4) . "\" id=\"ethambutolStopYy\" name=\"ethambutolStopYy\" class=\"small_cnt\" " .
           getData ("ethambutolStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo (!empty ($followup) && $followup === 1) ?
"	   <td/>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
" : "
	   <td id=\"ethambutolContinuedTitle\" />
       <td class=\"sm_header_cnt_np\">
         <input tabindex=\"" . ($tabIndex + 5) . "\" id=\"ethambutolContinued\" name=\"ethambutolContinued\" " . getData ("ethambutolContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
";
echo "
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
     <tr>
       <td class=\"small_cnt\">" . $pedTreats[$lang][10] . "</td>
";
echo (!empty ($followup) && $followup === 1) ?
"
       <td id=\"isoniazidContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 6) . "\" id=\"isoniazidContinued\" name=\"isoniazidContinued\" " . getData ("isoniazidContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
" : "
	   <td id=\"isoniazidStartTitle\" />
       <td>
         <input tabindex=\"" . ($tabIndex + 6) . "\" id=\"isoniazidStartMm\"  name=\"isoniazidStartMm\" class=\"small_cnt\" " .
           getData ("isoniazidStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 7) . "\" id=\"isoniazidStartYy\" name=\"isoniazidStartYy\" class=\"small_cnt\" " .
           getData ("isoniazidStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo "
       <td id=\"isoniazidStopTitle\">&nbsp;</td>
       <td>
         <input tabindex=\"" . ($tabIndex + 8) . "\" id=\"isoniazidStopMm\" name=\"isoniazidStopMm\" class=\"small_cnt\" " .
           getData ("isoniazidStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 9) . "\" id=\"isoniazidStopYy\" name=\"isoniazidStopYy\" class=\"small_cnt\" " .
           getData ("isoniazidStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo (!empty ($followup) && $followup === 1) ?
"
	   <td/>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
" : "
       <td id=\"isoniazidContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 10) . "\" id=\"isoniazidContinued\" name=\"isoniazidContinued\" " . getData ("isoniazidContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
";
echo "
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr class=\"alt\">
       <td class=\"small_cnt\">" . $pedTreats[$lang][11] . "</td>
";
echo (!empty ($followup) && $followup === 1) ?
"
       <td id=\"pyrazinamideContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 11) . "\" id=\"pyrazinamideContinued\" name=\"pyrazinamideContinued\" " . getData ("pyrazinamideContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
" : "
	   <td id=\"pyrazinamideStartTitle\" />
       <td>
         <input tabindex=\"" . ($tabIndex + 11) . "\" id=\"pyrazinamideStartMm\" name=\"pyrazinamideStartMm\" class=\"small_cnt\" " .
           getData ("pyrazinamideStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 12) . "\" id=\"pyrazinamideStartYy\" name=\"pyrazinamideStartYy\" class=\"small_cnt\" " .
           getData ("pyrazinamideStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo "
       <td id=\"pyrazinamideStopTitle\">&nbsp;</td>
       <td>
         <input tabindex=\"" . ($tabIndex + 13) . "\" id=\"pyrazinamideStopMm\" name=\"pyrazinamideStopMm\" class=\"small_cnt\" " .
           getData ("pyrazinamideStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 14) . "\" id=\"pyrazinamideStopYy\" name=\"pyrazinamideStopYy\" class=\"small_cnt\" " .
           getData ("pyrazinamideStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo (!empty ($followup) && $followup === 1) ?
"
       <td/>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
" : "
       <td id=\"pyrazinamideContinuedTitle\"/>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 15) . "\" id=\"pyrazinamideContinued\" name=\"pyrazinamideContinued\" " . getData ("pyrazinamideContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
";
echo "
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr>
       <td class=\"small_cnt\">" . $pedTreats[$lang][12] . "</td>
";
echo (!empty ($followup) && $followup === 1) ?
"
       <td id=\"rifampicineContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 16) . "\" id=\"rifampicineContinued\" name=\"rifampicineContinued\" " . getData ("rifampicineContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
" : "
       <td id=\"rifampicineStartTitle\"/>
       <td>
         <input tabindex=\"" . ($tabIndex + 16) . "\" id=\"rifampicineStartMm\" name=\"rifampicineStartMm\" class=\"small_cnt\" " .
           getData ("rifampicineStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 17) . "\" id=\"rifampicineStartYy\" name=\"rifampicineStartYy\" class=\"small_cnt\" " .
            getData ("rifampicineStartYy", "text") .
            " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo "
       <td id=\"rifampicineStopTitle\">&nbsp;</td>
       <td>
         <input tabindex=\"" . ($tabIndex + 18) . "\" id=\"rifampicineStopMm\" name=\"rifampicineStopMm\" class=\"small_cnt\" " .
           getData ("rifampicineStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 19) . "\" id=\"rifampicineStopYy\" name=\"rifampicineStopYy\" class=\"small_cnt\" " .
           getData ("rifampicineStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo (!empty ($followup) && $followup === 1) ?
"
       <td/>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
" : "
	   <td class=\"sm_header_cnt_np\" id=\"rifampicineContinuedTitle\">&nbsp;</td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 20) . "\" id=\"rifampicineContinued\" name=\"rifampicineContinued\" " . getData ("rifampicineContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
";
echo "
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr class=\"alt\">
       <td class=\"small_cnt\">" . $pedTreats[$lang][13] . "</td>
";
echo (!empty ($followup) && $followup === 1) ?
"
	   <td id=\"streptomycineContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 21) . "\" id=\"streptomycineContinued\" name=\"streptomycineContinued\" " . getData ("streptomycineContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
" : "
       <td  id=\"streptomycineStartTitle\"/>
       <td>
         <input tabindex=\"" . ($tabIndex + 21) . "\" id=\"streptomycineStartMm\" name=\"streptomycineStartMm\" class=\"small_cnt\" " .
           getData ("streptomycineStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 22) . "\" id=\"streptomycineStartYy\" name=\"streptomycineStartYy\" class=\"small_cnt\" " .
           getData ("streptomycineStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo "
       <td id=\"streptomycineStopTitle\">&nbsp;</td>
       <td>
         <input tabindex=\"" . ($tabIndex + 23) . "\" id=\"streptomycineStopMm\" name=\"streptomycineStopMm\" class=\"small_cnt\" " .
           getData ("streptomycineStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
           showValidationIcon ($encType, "streptomycineStopMm") .
         "/<input tabindex=\"" . ($tabIndex + 24) . "\" id=\"streptomycineStopYy\" name=\"streptomycineStopYy\" class=\"small_cnt\" " .
           getData ("streptomycineStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">" .
         showValidationIcon ($encType, "streptomycineStopYy") . "</td>
";
echo (!empty ($followup) && $followup === 1) ?
"
       <td/>
       <td class=\"sm_header_cnt_np\" >&nbsp;</td>
" : "
	   <td id=\"streptomycineContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 25) . "\" id=\"streptomycineContinued\" name=\"streptomycineContinued\" " . getData ("streptomycineContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
";
echo "
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr>
       <td colspan=\"5\"><b>" . $pedTreats[$lang][14] . "</b></td>
      </tr>
      <tr class=\"alt\">
       <td class=\"small_cnt\">" . $pedTreats[$lang][15] . "</td>
";
echo (!empty ($followup) && $followup === 1) ?
"
       <td id=\"acyclovirContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 26) . "\" id=\"acyclovirContinued\" name=\"acyclovirContinued\" " . getData ("acyclovirContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
" : "
       <td id=\"acyclovirStartTitle\" />
       <td>
         <input tabindex=\"" . ($tabIndex + 26) . "\" id=\"acyclovirStartMm\" name=\"acyclovirStartMm\" class=\"small_cnt\" " .
           getData ("acyclovirStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 27) . "\" id=\"acyclovirStartYy\" name=\"acyclovirStartYy\" class=\"small_cnt\" " .
           getData ("acyclovirStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo "
       <td id=\"acyclovirStopTitle\">&nbsp;</td>
       <td>
         <input tabindex=\"" . ($tabIndex + 28) . "\" id=\"acyclovirStopMm\" name=\"acyclovirStopMm\" class=\"small_cnt\" " .
           getData ("acyclovirStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 29) . "\" id=\"acyclovirStopYy\" name=\"acyclovirStopYy\" class=\"small_cnt\" " .
           getData ("acyclovirStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo (!empty ($followup) && $followup === 1) ?
"
	   <td />
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
" : "
       <td id=\"acyclovirContinuedTitle\"/>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 30) . "\" id=\"acyclovirContinued\" name=\"acyclovirContinued\" " . getData ("acyclovirContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
";
echo "
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr>
       <td class=\"small_cnt\">" . $pedTreats[$lang][16] . " <i>" . $pedTreats[$lang][17] . "</i></td>
";
echo (!empty ($followup) && $followup === 1) ?
"
       <td id=\"azythroProphContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 31) . "\" id=\"azythroProphContinued\" name=\"azythroProphContinued\" " . getData ("azythroProphContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
" : "
	   <td id=\"azythroProphStartTitle\" />
       <td>
         <input tabindex=\"" . ($tabIndex + 31) . "\" id=\"azythroProphStartMm\" name=\"azythroProphStartMm\" class=\"small_cnt\" " .
           getData ("azythroProphStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 32) . "\" id=\"azythroProphStartYy\" name=\"azythroProphStartYy\" class=\"small_cnt\" " .
           getData ("azythroProphStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo "
       <td id=\"azythroProphStopTitle\">&nbsp;</td>
       <td>
         <input tabindex=\"" . ($tabIndex + 33) . "\" id=\"azythroProphStopMm\" name=\"azythroProphStopMm\" class=\"small_cnt\" " .
           getData ("azythroProphStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 34) . "\" id=\"azythroProphStopYy\" name=\"azythroProphStopYy\" class=\"small_cnt\" " .
           getData ("azythroProphStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo (!empty ($followup) && $followup === 1) ?
"
	   <td/>
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
" : "
       <td id=\"azythroProphContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 35) . "\" id=\"azythroProphContinued\" name=\"azythroProphContinued\" " . getData ("azythroProphContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
";
echo "
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr class=\"alt\">
       <td class=\"small_cnt\">" . $pedTreats[$lang][16] . " <i>" . $pedTreats[$lang][18] . "</i></td>
";
echo (!empty ($followup) && $followup === 1) ?
"
	   <td id=\"azythroOtherContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 36) . "\" id=\"azythroOtherContinued\" name=\"azythroOtherContinued\" " . getData ("azythroOtherContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
" : "
	   <td id=\"azythroOtherStartTitle\" />
       <td>
         <input tabindex=\"" . ($tabIndex + 36) . "\" id=\"azythroOtherStartMm\" name=\"azythroOtherStartMm\" class=\"small_cnt\" " .
           getData ("azythroOtherStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 37) . "\" id=\"azythroOtherStartYy\" name=\"azythroOtherStartYy\" class=\"small_cnt\" " .
           getData ("azythroOtherStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo "
       <td id=\"azythroOtherStopTitle\" >&nbsp;</td>
       <td>
         <input tabindex=\"" . ($tabIndex + 38) . "\" id=\"azythroOtherStopMm\"  name=\"azythroOtherStopMm\" class=\"small_cnt\" " .
           getData ("azythroOtherStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 39) . "\" id=\"azythroOtherStopYy\" name=\"azythroOtherStopYy\" class=\"small_cnt\" " .
           getData ("azythroOtherStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo (!empty ($followup) && $followup === 1) ?
"
	   <td />
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
" : "
       <td id=\"azythroOtherContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 40) . "\" id=\"azythroOtherContinued\" name=\"azythroOtherContinued\" " . getData ("azythroOtherContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
";
echo "
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr>
       <td class=\"small_cnt\">" . $pedTreats[$lang][19] . "</td>
";
echo (!empty ($followup) && $followup === 1) ?
"
       <td id=\"clarithromycinContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 41) . "\" id=\"clarithromycinContinued\" name=\"clarithromycinContinued\" " . getData ("clarithromycinContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
" : "
	   <td id=\"clarithromycinStartTitle\"  />
       <td>
         <input tabindex=\"" . ($tabIndex + 41) . "\" id=\"clarithromycinStartMm\"  name=\"clarithromycinStartMm\" class=\"small_cnt\" " .
           getData ("clarithromycinStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 42) . "\" id=\"clarithromycinStartYy\" name=\"clarithromycinStartYy\" class=\"small_cnt\" " .
           getData ("clarithromycinStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo "
       <td id=\"clarithromycinStopTitle\">&nbsp;</td>
       <td>
         <input tabindex=\"" . ($tabIndex + 43) . "\" id=\"clarithromycinStopMm\" name=\"clarithromycinStopMm\" class=\"small_cnt\" " .
           getData ("clarithromycinStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 44) . "\" id=\"clarithromycinStopYy\" name=\"clarithromycinStopYy\" class=\"small_cnt\" " .
           getData ("clarithromycinStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo (!empty ($followup) && $followup === 1) ?
"
	   <td />
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
" : "
	   <td id=\"clarithromycinContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 45) . "\" id=\"clarithromycinContinued\" name=\"clarithromycinContinued\" " . getData ("clarithromycinContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
";
echo "
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr class=\"alt\">
       <td class=\"small_cnt\">" . $pedTreats[$lang][20] . " <i>" . $pedTreats[$lang][21] . "</i></td>
";
echo (!empty ($followup) && $followup === 1) ?
"
	   <td id=\"cotrimoxazoleProphContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 46) . "\" id=\"cotrimoxazoleProphContinued\" name=\"cotrimoxazoleProphContinued\" " . getData ("cotrimoxazoleProphContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
" : "
	   <td id=\"cotrimoxazoleProphStartTitle\" />
       <td>
         <input tabindex=\"" . ($tabIndex + 46) . "\" id=\"cotrimoxazoleProphStartMm\" name=\"cotrimoxazoleProphStartMm\" class=\"small_cnt\" " .
           getData ("cotrimoxazoleProphStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 47) . "\" id=\"cotrimoxazoleProphStartYy\"  name=\"cotrimoxazoleProphStartYy\" class=\"small_cnt\" " .
           getData ("cotrimoxazoleProphStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo "
       <td id=\"cotrimoxazoleProphStopTitle\">&nbsp;</td>
       <td>
         <input tabindex=\"" . ($tabIndex + 48) . "\" id=\"cotrimoxazoleProphStopMm\" name=\"cotrimoxazoleProphStopMm\" class=\"small_cnt\" " .
           getData ("cotrimoxazoleProphStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 49) . "\" id=\"cotrimoxazoleProphStopYy\" name=\"cotrimoxazoleProphStopYy\" class=\"small_cnt\" " .
           getData ("cotrimoxazoleProphStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo (!empty ($followup) && $followup === 1) ?
"
	   <td />
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
" : "
       <td id=\"cotrimoxazoleProphContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 50) . "\" id=\"cotrimoxazoleProphContinued\" name=\"cotrimoxazoleProphContinued\" " . getData ("cotrimoxazoleProphContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
";
echo "
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr>
       <td class=\"small_cnt\">" . $pedTreats[$lang][20] . " <i>" . $pedTreats[$lang][18] . "</i></td>
";
echo (!empty ($followup) && $followup === 1) ?
"
	   <td id=\"cotrimoxazoleOtherContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 51) . "\" id=\"cotrimoxazoleOtherContinued\" name=\"cotrimoxazoleOtherContinued\" " . getData ("cotrimoxazoleOtherContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
" : "
	   <td id=\"cotrimoxazoleOtherStartTitle\" />
       <td>
         <input tabindex=\"" . ($tabIndex + 51) . "\" id=\"cotrimoxazoleOtherStartMm\" name=\"cotrimoxazoleOtherStartMm\" class=\"small_cnt\" " .
           getData ("cotrimoxazoleOtherStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 52) . "\" id=\"cotrimoxazoleOtherStartYy\" name=\"cotrimoxazoleOtherStartYy\" class=\"small_cnt\" " .
           getData ("cotrimoxazoleOtherStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo "
       <td id=\"cotrimoxazoleOtherStopTitle\">&nbsp;</td>
       <td>
         <input tabindex=\"" . ($tabIndex + 53) . "\" id=\"cotrimoxazoleOtherStopMm\" name=\"cotrimoxazoleOtherStopMm\" class=\"small_cnt\" " .
           getData ("cotrimoxazoleOtherStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 54) . "\" id=\"cotrimoxazoleOtherStopYy\"  name=\"cotrimoxazoleOtherStopYy\" class=\"small_cnt\" " .
           getData ("cotrimoxazoleOtherStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo (!empty ($followup) && $followup === 1) ?
"
	   <td />
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
" : "
	   <td id=\"cotrimoxazoleOtherContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 55) . "\" id=\"cotrimoxazoleOtherContinued\" name=\"cotrimoxazoleOtherContinued\" " . getData ("cotrimoxazoleOtherContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
";
echo "
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr class=\"alt\">
       <td class=\"small_cnt\">" . $pedTreats[$lang][22] . "</td>
";
echo (!empty ($followup) && $followup === 1) ?
"
       <td id=\"fluconazoleContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 56) . "\" id=\"fluconazoleContinued\" name=\"fluconazoleContinued\" " . getData ("fluconazoleContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
" : "
       <td id=\"fluconazoleStartTitle\" />
       <td>
         <input tabindex=\"" . ($tabIndex + 56) . "\" id=\"fluconazoleStartMm\" name=\"fluconazoleStartMm\" class=\"small_cnt\" " .
           getData ("fluconazoleStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 57) . "\" id=\"fluconazoleStartYy\" name=\"fluconazoleStartYy\" class=\"small_cnt\" " .
           getData ("fluconazoleStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo "
       <td id=\"fluconazoleStopTitle\">&nbsp;</td>
       <td>
         <input tabindex=\"" . ($tabIndex + 58) . "\" id=\"fluconazoleStopMm\" name=\"fluconazoleStopMm\" class=\"small_cnt\" " .
           getData ("fluconazoleStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 59) . "\" id=\"fluconazoleStopYy\" name=\"fluconazoleStopYy\" class=\"small_cnt\" " .
           getData ("fluconazoleStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo (!empty ($followup) && $followup === 1) ?
"
       <td />
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
" : "
       <td id=\"fluconazoleContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 60) . "\" id=\"fluconazoleContinued\" name=\"fluconazoleContinued\" " . getData ("fluconazoleContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
";
echo "
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr>
       <td class=\"small_cnt\">" . $pedTreats[$lang][23] . "</td>
";
echo (!empty ($followup) && $followup === 1) ?
"
       <td id=\"ketaconazoleContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 61) . "\" id=\"ketaconazoleContinued\" name=\"ketaconazoleContinued\" " . getData ("ketaconazoleContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
" : "
       <td id=\"ketaconazoleStartTitle\" />
       <td>
         <input tabindex=\"" . ($tabIndex + 61) . "\" id=\"ketaconazoleStartMm\" name=\"ketaconazoleStartMm\" class=\"small_cnt\" " .
           getData ("ketaconazoleStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 62) . "\" id=\"ketaconazoleStartYy\" name=\"ketaconazoleStartYy\" class=\"small_cnt\" " .
           getData ("ketaconazoleStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo "
       <td id=\"ketaconazoleStopTitle\">&nbsp;</td>
       <td>
         <input tabindex=\"" . ($tabIndex + 63) . "\" id=\"ketaconazoleStopMm\" name=\"ketaconazoleStopMm\" class=\"small_cnt\" " .
           getData ("ketaconazoleStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 64) . "\" id=\"ketaconazoleStopYy\" name=\"ketaconazoleStopYy\" class=\"small_cnt\" " .
           getData ("ketaconazoleStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo (!empty ($followup) && $followup === 1) ?
"
       <td />
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
" : "
	   <td id=\"ketaconazoleContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 65) . "\" id=\"ketaconazoleContinued\" name=\"ketaconazoleContinued\" " . getData ("ketaconazoleContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
";
echo "
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr class=\"alt\">
       <td class=\"small_cnt\">" . $pedTreats[$lang][24] . "</td>
";
echo (!empty ($followup) && $followup === 1) ?
"
	   <td id=\"traditionalContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 66) . "\" id=\"traditionalContinued\" name=\"traditionalContinued\" " . getData ("traditionalContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
" : "
	   <td id=\"traditionalStartTitle\" />
       <td>
         <input tabindex=\"" . ($tabIndex + 66) . "\" id=\"traditionalStartMm\" name=\"traditionalStartMm\" class=\"small_cnt\" " .
           getData ("traditionalStartMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 67) . "\" id=\"traditionalStartYy\" name=\"traditionalStartYy\" class=\"small_cnt\" " .
           getData ("traditionalStartYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo "
       <td id=\"traditionalStopTitle\">&nbsp;</td>
       <td>
         <input tabindex=\"" . ($tabIndex + 68) . "\" id=\"traditionalStopMm\" name=\"traditionalStopMm\" class=\"small_cnt\" " .
           getData ("traditionalStopMm", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 69) . "\" id=\"traditionalStopYy\" name=\"traditionalStopYy\" class=\"small_cnt\" " .
           getData ("traditionalStopYy", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo (!empty ($followup) && $followup === 1) ?
"
       <td />
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
" : "
       <td id=\"traditionalContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 70) . "\" id=\"traditionalContinued\"  name=\"traditionalContinued\" " . getData ("traditionalContinued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
";
echo "
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
      <tr>
       <td class=\"small_cnt\" >" . $pedTreats[$lang][25] .
         " <i>" . $pedTreats[$lang][26] . "</i> <input tabindex=\"" . ($tabIndex + 71) . "\" id=\"other3Text\" name=\"other3Text\" class=\"small_cnt\" " .
             getData ("other3Text", "text") .
             " type=\"text\" size=\"20\" maxlength=\"255\"></td>
";
echo (!empty ($followup) && $followup === 1) ?
"
	   <td id=\"other3ContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 72) . "\" id=\"other3Continued\" name=\"other3Continued\" " . getData ("other3Continued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
" : "
       <td id=\"other3StartTitle\" />
       <td >
         <input tabindex=\"" . ($tabIndex + 72) . "\" id=\"other3StartMm\" name=\"other3MM\" class=\"small_cnt\" " .
           getData ("other3MM", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 73) . "\" id=\"other3StartYy\" name=\"other3YY\" class=\"small_cnt\" " .
           getData ("other3YY", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo "
       <td id=\"other3StopTitle\">&nbsp;</td>
       <td>
         <input tabindex=\"" . ($tabIndex + 74) . "\" id=\"other3StopMm\" name=\"other3SpMM\" class=\"small_cnt\" " .
           getData ("other3SpMM", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\">/<input tabindex=\"" . ($tabIndex + 75) . "\" id=\"other3StopYy\" name=\"other3SpYY\" class=\"small_cnt\" " .
           getData ("other3SpYY", "text") .
           " type=\"text\" size=\"2\" maxlength=\"2\"></td>
";
echo (!empty ($followup) && $followup === 1) ?
"
       <td />
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
" : "
	   <td id=\"other3ContinuedTitle\" />
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 76) . "\" id=\"other3Continued\" name=\"other3Continued\" " . getData ("other3Continued", "checkbox") . " type=\"checkbox\" value=\"On\"></td>
";
echo "
       <td class=\"sm_header_cnt_np\">&nbsp;</td>
      </tr>
     </table>
    </td>
   </tr>";
echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"include/pedArvs.js\"></script>";
?>
