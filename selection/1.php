<?php
if ($tabsOn) {
  echo $tabHeaders;
}
echo "
<div id=\"tab-panes\">
";

echo"
<div id=\"pane1\">
  <table class=\"header\">
      <tr>
       <td class=\"under_header\">
       </td>
      </tr>
      <tr>
          <td class=\"s_header\">" . $selection_header[$lang][1] . "</td>
      </tr>
      <tr>
         <td class=\"bottom_line\">" . $selection[$lang][0] . " <span><input tabindex=\"2001\" name=\"arv[]\" " . getData ("arv", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $selection[$lang][1] . " <input tabindex=\"2002\" name=\"arv[]\" " . getData ("arv", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $selection[$lang][2] . "</span>
         </td>
      </tr>
  </table>

  <table class=\"header\">
    <tr>
       <th align=\"left\" width=\"40%\">" . $selection_subhead[$lang][0] . "</th>
       <th align=\"center\" width=\"10%\"></th>
       <th align=\"left\" width=\"40%\">" . $selection_subhead[$lang][1] . "</th>
       <th align=\"left\" width=\"10%\">" . $selection_subhead[$lang][2] . "</th>
    </tr>
    <tr>
       <td width=\"40%\">
       		<input tabindex=\"2101\" name=\"initiateTB\" " . getData ("initiateTB", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $initiateTB[$lang][1] . "</td>
       <td align=\"center\"  rowspan=\"2\" width=\"10%\">" .
       		$initiateTB[$lang][2] . "
       </td>
       <td rowspan=\"2\" width=\"40%\">
       		<input tabindex=\"2116\" name=\"TBprogram\" " . getData ("TBprogram", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $TBprogram[$lang][1] . "</td>
       <td width=\"10%\">
       		<input tabindex=\"2125\" name=\"PMTCTprogram\" " . getData ("PMTCTprogram", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $PMTCTprogram[$lang][1] . "
       </td>
    </tr>
    <tr>
       <td width=\"40%\">
       		<input tabindex=\"2102\" name=\"continueTB\" " . getData ("continueTB", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $continueTB[$lang][1] . "</td>
       <td width=\"10%\">
       		<input tabindex=\"2126\" name=\"familyPlanProg\" " . getData ("familyPlanProg", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $familyPlanProg[$lang][1] . "
       </td>
    </tr>
    <tr>
       <td width=\"40%\"><input tabindex=\"2103\" name=\"inadPsychPro\" " . getData ("inadPsychPro", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $inadPsychPro[$lang][1] . "</td>
       <td align=\"center\" width=\"10%\">" . $inadPsychPro[$lang][2] . "</td>
       <td width=\"40%\"><input tabindex=\"2117\" name=\"psychEval\" " . getData ("psychEval", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $psychEval[$lang][1] . "</td>
       <td width=\"10%\"><input tabindex=\"2127\" name=\"immunProg\" " . getData ("immunProg", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $immunProg[$lang][1] . "</td>

    </tr>
    <tr>
       <td width=\"40%\"><input tabindex=\"2104\" name=\"poorAdherence\" " . getData ("poorAdherence", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $poorAdherence[$lang][1] . "</td>
       <td align=\"center\" width=\"10%\">" . $poorAdherence[$lang][2] . "</td>
       <td width=\"40%\"><input tabindex=\"2118\" name=\"ARVadherCoun\" " . getData ("ARVadherCoun", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $ARVadherCoun[$lang][1] . "</td>
       <td width=\"10%\"><input tabindex=\"2128\" name=\"hospitalization\" " . getData ("hospitalization", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $hospitalization[$lang][1] . "</td>
    </tr>
    <tr>
       <td width=\"40%\">
       		<input tabindex=\"2105\" name=\"patientPref\" " . getData ("patientPref", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $patientPref[$lang][1] . "
       </td>
       <td align=\"center\" rowspan=\"2\" width=\"10%\">" . $patientPref[$lang][2] . "</td>
       <td  rowspan=\"2\" width=\"40%\"><input tabindex=\"2119\" name=\"ARVeducCoun\" " . getData ("ARVeducCoun", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $ARVeducCoun[$lang][1] . "</td>
       <td width=\"10%\"><input tabindex=\"2129\" name=\"otherMedRef\" " . getData ("otherMedRef", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $otherMedRef[$lang][1] . "</td>

    </tr>
    <tr>
       <td width=\"40%\"><input tabindex=\"2106\" name=\"inadPrepForAd\" " . getData ("inadPrepForAd", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $inadPrepForAd[$lang][1] . "</td>
       <td  rowspan=\"9\" width=\"10%\">
       		<textarea tabindex=\"2130\" name=\"notesArvEnroll\" cols=\"30\" rows=\"12\">" . getData ("notesArvEnroll", "textarea") . "</textarea>
       	</td>
    </tr>
    <tr>
       <td width=\"40%\"><input tabindex=\"2107\" name=\"doesntAccAcc\" " . getData ("doesntAccAcc", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $doesntAccAcc[$lang][1] . "</td>
       <td align=\"center\"  rowspan=\"3\" width=\"10%\">" . $doesntAccAcc[$lang][2] . "</td>
       <td rowspan=\"3\" width=\"40%\"><input tabindex=\"2120\" name=\"psychSocialCoun\" " . getData ("psychSocialCoun", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $psychSocialCoun[$lang][1] . "</td>
    </tr>
    <tr>
       <td width=\"40%\"><input tabindex=\"2108\" name=\"doesntAccHome\" " . getData ("doesntAccHome", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $doesntAccHome[$lang][1] . "</td>
    </tr>
    <tr>
       <td width=\"40%\"><input tabindex=\"2109\" name=\"weakFamilySupp\" " . getData ("weakFamilySupp", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $weakFamilySupp[$lang][1] . "</td>
    </tr>
    <tr>
       <td width=\"40%\">
       		<input tabindex=\"2110\" name=\"barriersToReg\" " . getData ("barriersToReg", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $barriersToReg[$lang][1] . "
       </td>
       <td align=\"center\" width=\"10%\">" .
       		$barriersToReg[$lang][2] . "
       </td>
       <td width=\"40%\">
       		<input tabindex=\"2121\" name=\"transAssProg\" " . getData ("transAssProg", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $transAssProg[$lang][1] . "
       </td>
    </tr>
    <tr>
       <td width=\"40%\">
       		<input tabindex=\"2111\" name=\"livesOutsideZone\" " . getData ("livesOutsideZone", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $livesOutsideZone[$lang][1] . "</td>
       <td align=\"center\" width=\"10%\">" .
       		$livesOutsideZone[$lang][2] . "
       </td>
       <td width=\"40%\">
       		<input tabindex=\"2122\" name=\"otherARVprog\" " . getData ("otherARVprog", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $otherARVprog[$lang][1] . "</td>
    </tr>
    <tr>
          <td width=\"40%\">
          		<input tabindex=\"2112\" name=\"progHasRlimit\" " . getData ("progHasRlimit", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $progHasRlimit[$lang][1] . "</td>
          <td align=\"center\" width=\"10%\">" .
          		$progHasRlimit[$lang][2] . "</td>
          <td width=\"40%\">
          		<input tabindex=\"2123\" name=\"tWaitListOther\" " . getData ("tWaitListOther", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $tWaitListOther[$lang][1] . "
          </td>
    </tr>
    <tr>
        <td width=\"40%\">
          	<input tabindex=\"2113\" name=\"ARVsTempUn\" " . getData ("ARVsTempUn", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $ARVsTempUn[$lang][1] . "</td>
       	<td align=\"center\" width=\"10%\">" .
       		$ARVsTempUn[$lang][2] . "
       	</td>
       	<td width=\"40%\">
       		<input tabindex=\"2124\" name=\"tWaitList\" " . getData ("tWaitList", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $tWaitList[$lang][1] . "
       	</td>
    </tr>
    <tr>
        <td colspan=\"3\" width=\"90%\">
          	<input tabindex=\"2114\" name=\"otherMedElig\" " . getData ("otherMedElig", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $otherMedElig[$lang][1] . " <input tabindex=\"2115\" name=\"otherMedEligText\" " . getData ("otherMedEligText", "text") . " type=\"text\" size=\"80\" maxlength=\"255\">
        </td>
    </tr>
    <tr>
	   <td class=\"s_header\" colspan=\"4\">" . $nextVisitDD[$lang][1] . "</td>
	</tr>
    <tr>
        <td colspan=\"4\" width=\"100%\"><table><tr><td id=\"nextVisitD1Title\">&nbsp;</td><td  ><input tabindex=\"2202\" id=\"nextVisitD1\" name=\"nextVisitD1\" value=\"" . getData ("nextVisitDD", "textarea") . "/" . getData ("nextVisitMM", "textarea") . "/" .getData ("nextVisitYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\"></td><td>" .
         	$nextVisitDD[$lang][1] . " <input tabindex=\"2202\" id=\"nextVisitDD\" name=\"nextVisitDD\" " . getData ("nextVisitDD", "textarea") . " type=\"hidden\"><input tabindex=\"2203\" id=\"nextVisitMM\"  name=\"nextVisitMM\" " . getData ("nextVisitMM", "textarea") . " type=\"hidden\"><input tabindex=\"2204\" id=\"nextVisitYY\" name=\"nextVisitYY\" " . getData ("nextVisitYY", "textarea") . " type=\"hidden\"> <i>" . $nextVisitYY[$lang][2] . "</i></td></tr></table>
       </td>
    </tr>
 </table>

 <table class=\"header\">
	<tr>
	   <td class=\"s_header\">" . $otherMedRefText[$lang][1] . "
	   </td>
	</tr>
	<tr>
		<td>
		  <table class=\"header\">
			  <tr>
			     <td><textarea tabindex=\"3001\" name=\"otherMedRefText\" cols=\"80\" rows=\"5\">" . getData ("otherMedRefText", "textarea") . "</textarea></td>
			  </tr>
		 </table>
		</td>
	</tr>
	</table>
  </div>";
  echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"selection/0.js\"></script>";
 ?>
