<?php

echo "
<!-- ******************************************************************** -->
<!-- ************************ Medical Eligibility *********************** -->
<!-- *(tab indices " . ($tabIndex + 1) . " - " . ($tabIndex + 1000) . ")* -->
<!-- ******************************************************************** -->
";
echo "
   <tr>
    <td>
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"2\" width=\"100%\">" . $medicalEligARVs_header[$lang][2] . "</td>
      </tr>
      <tr>
          <td width=\"55%\" >" .
          $currentHivStage_1[$lang][0] . "</td>
          <td width=\"45%\" >" .
          $medicalEligARVs_subhead2_1[$lang][0] . "</td>
        </tr>
        <tr>
          <td width=\"55%\" >" .
		  $currentHivStage_1[$lang][1] . "</td>
		  <td width=\"45%\" ><i>" .
          $medicalEligARVs_subhead2[$lang][2] . "</i></td>
        </tr>
        <tr>
         <td width=\"55%\" >
          <input tabindex=\"" . ($tabIndex + 1) . "\" class=\"medicalElig\"     name=\"currentHivStage[]\" " . getData ("currentHivStage", "radio", 1) . " type=\"radio\" value=\"1\">&nbsp;"
		  . $currentHivStage_1[$lang][2] .
		  "</td>
		   <td width=\"45%\"><input tabindex=\"" . ($tabIndex + 2) . "\" class=\"medicalElig\"   id=\"cd4LT200\" name=\"cd4LT200\" " . getData ("cd4LT200", "checkbox") . " type=\"checkbox\" value=\"On\">" . showValidationIcon ($encType, "cd4LT200") . " " . $cd4LT200[$lang][1] . "</td>
        </tr>
        <tr>
         <td width=\"55%\" >
		  <input tabindex=\"" . ($tabIndex + 3) . "\" class=\"medicalElig\"   name=\"currentHivStage[]\" " . getData ("currentHivStage", "radio", 2) . " type=\"radio\" value=\"2\">&nbsp;"
		   . $currentHivStage_1[$lang][3] .
		 "</td>
		   <td><input tabindex=\"" . ($tabIndex + 4) . "\" class=\"medicalElig\"   name=\"tlcLT1200\" " . getData ("tlcLT1200", "checkbox") . " type=\"checkbox\" value=\"On\">" . showValidationIcon ($encType, "tlcLT1200") . " " . $tlcLT1200[$lang][1] . "</td>
        </tr>
        <tr>
         <td width=\"55%\" >
		  <input tabindex=\"" . ($tabIndex + 5) . "\" class=\"medicalElig\"   name=\"currentHivStage[]\" " . getData ("currentHivStage", "radio", 4) . " type=\"radio\" value=\"4\">&nbsp;"
		  . $currentHivStage_1[$lang][4] .
		 "</td>
		  <td><input tabindex=\"" . ($tabIndex + 6) . "\" class=\"medicalElig\"   name=\"WHOIII\" " . getData ("WHOIII", "checkbox") . " type=\"checkbox\" value=\"On\">" . $WHOIII[$lang][1] . "</td>
        </tr>
        <tr>
         <td width=\"55%\" >
		  <input tabindex=\"" . ($tabIndex + 7) . "\" class=\"medicalElig\"   name=\"currentHivStage[]\" " . getData ("currentHivStage", "radio", 8) . " type=\"radio\" value=\"8\">&nbsp;"
		  . $currentHivStage_1[$lang][5] .
		 "</td>
         <td><input tabindex=\"" . ($tabIndex + 8) . "\" class=\"medicalElig\"   name=\"WHOIV\" " . getData ("WHOIV", "checkbox") . " type=\"checkbox\" value=\"On\">" . $WHOIV[$lang][1] . "</td>
        </tr>
        <tr>
          <td width=\"55%\" >&nbsp;</td>
		   <td><input tabindex=\"" . ($tabIndex + 10) . "\" class=\"medicalElig\"   name=\"PMTCT\" " . getData ("PMTCT", "checkbox") . " type=\"checkbox\" value=\"On\">" . $PMTCT[$lang][1] . "</td>
        </tr>
        <tr>
          <td width=\"55%\" >" . $medicalEligARVs_subhead1[$lang][1] . "</td>
		  <td colspan=\"2\"><input tabindex=\"" . ($tabIndex + 12) . "\" class=\"medicalElig\"   name=\"medEligHAART\" " . getData ("medEligHAART", "checkbox") . " type=\"checkbox\" value=\"On\">" . $medEligHAART_1[$lang][0] . "</td>
        </tr>
        <tr>
          <td width=\"55%\">
           <input tabindex=\"" . ($tabIndex + 13) . "\" id=\"medElig1\" class=\"medicalElig\"   name=\"medElig[]\" " . getData ("medElig", "radio", 1) . " type=\"radio\" value=\"1\">" . $medElig_1[$lang][0] . "
          <td colspan=\"2\"><input tabindex=\"" . ($tabIndex + 14) . "\" class=\"medicalElig\"   name=\"formerARVtherapy\" " . getData ("formerARVtherapy", "checkbox") . " type=\"checkbox\" value=\"On\">" . $formerARVtherapy[$lang][1] . "</td>
        </tr>
        <tr>
         <td width=\"55%\">
		   <input tabindex=\"" . ($tabIndex + 15) . "\" id=\"medElig2\" class=\"medicalElig\"   name=\"medElig[]\" " . getData ("medElig", "radio", 4) . " type=\"radio\" value=\"4\">" . $medElig_1[$lang][1] . "
          <!-- <input type=\"text\" class=\"medicalElig\"   name=\"yesEligReason\" size=\"40\">-->
          </td>

		  <td colspan=\"2\"><table><tr><td id=\"PEPTitle\"></td><td><input tabindex=\"" .($tabIndex + 16) . "\" id=\"PEP\" class=\"medicalElig\"   name=\"PEP\" " . getData ("PEP", "checkbox") . " type=\"checkbox\" value=\"On\">" . $PEP[$lang][1] . "</td></tr></table></td>
        </tr>
        <tr>
         <td width=\"55%\">
		   <input tabindex=\"" . ($tabIndex + 17) . "\"  id=\"medElig3\" class=\"medicalElig\"   name=\"medElig[]\" " . getData ("medElig", "radio", 8) . " type=\"radio\" value=\"8\">" . $medElig_1[$lang][2] . "
         </td>
         <td width=\"45%\">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $PEP[$lang][2] . "
         </td>
        </tr>
		 <tr>
         <td id=\"expFromD1Title\">&nbsp;
		  
         </td>
         <td class=\"left_pad\">
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<table><tr><td><input tabindex=\"" . ($tabIndex + 20) . "\" id=\"expFromD1\" class=\"medicalElig\"   name=\"expFromD1\" value=\"" . getData ("expFromDt", "textarea") . "/". getData ("expFromMm", "textarea") ."/". getData ("expFromYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\"></td><td><i>" . $PEP[$lang][0] . "</i><input type=\"hidden\"  id=\"expFromDt\" class=\"medicalElig\"   name=\"expFromDt\"><input type=\"hidden\" tabindex=\"" . ($tabIndex + 21) . "\" id=\"expFromMm\" class=\"medicalElig\"   name=\"expFromMm\"><input type=\"hidden\" tabindex=\"" . ($tabIndex + 22) . "\" id=\"expFromYy\"  class=\"medicalElig\"   name=\"expFromYy\" ></td></tr></table>
		 </td>
        </tr>
        <tr>
          <td id=\&quot;expFromD1Title\&quot;2>&nbsp;</td>
          <td class=\"left_pad\"><table width=\"100%\" border=\"0\">
            <tr>
              <td><input tabindex=\"" . ($tabIndex + 24) . "\" class=\"medicalElig\"   name=\"coinfectionTbHiv\" " . getData ("coinfectionTbHiv", "checkbox") . " type=\"checkbox\" value=\"On\">".$coinfectionTbHiv[$lang][1]."</td>
            </tr>
            <tr>
              <td><input tabindex=\"" . ($tabIndex + 25) . "\" class=\"medicalElig\"   name=\"coinfectionHbvHiv\" " . getData ("coinfectionHbvHiv", "checkbox") . " type=\"checkbox\" value=\"On\">
              ".$coinfectionHbvHiv[$lang][1]."</td>
            </tr>
            <tr>
              <td><input tabindex=\"" . ($tabIndex + 26) . "\" class=\"medicalElig\"   name=\"coupleSerodiscordant\" " . getData ("coupleSerodiscordant", "checkbox") . " type=\"checkbox\" value=\"On\">
".$coupleSerodiscordant[$lang][1]."</td>
            </tr>
            <tr>
              <td><input tabindex=\"" . ($tabIndex + 27) . "\" class=\"medicalElig\"   name=\"pregnantWomen\" " . getData ("pregnantWomen", "checkbox") . " type=\"checkbox\" value=\"On\">
".$pregnantWomen[$lang][1]."</td>
            </tr>
            <tr>
              <td><input tabindex=\"" . ($tabIndex + 28) . "\" class=\"medicalElig\"   name=\"breastfeedingWomen\" " . getData ("breastfeedingWomen", "checkbox") . " type=\"checkbox\" value=\"On\">
".$breastfeedingWomen[$lang][1]."</td>
            </tr>
            <tr>
              <td><input tabindex=\"" . ($tabIndex + 29) . "\" class=\"medicalElig\"   name=\"patientGt50ans\" " . getData ("patientGt50ans", "checkbox") . " type=\"checkbox\" value=\"On\">
".$patientGt50ans[$lang][1]."</td>
            </tr>
			<tr>
              <td><input tabindex=\"" . ($tabIndex + 29) . "\" class=\"medicalElig\"   name=\"nephropathieVih\" " . getData ("nephropathieVih", "checkbox") . " type=\"checkbox\" value=\"On\">
".$nephropathieVih[$lang][1]."</td>
            </tr>
          </table></td>
        </tr>
       
	  </table>
    </td>
   </tr>
";
//echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"medicalEligibility/1.js\"></script>";
?>
