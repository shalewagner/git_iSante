<?php

echo "
<!-- ******************************************************************** -->
<!-- ************************ Medical Eligibility *********************** -->
<!-- * (tab indices " . ($tabIndex + 1) . " - " . ($tabIndex + 1000) . ") * -->
<!-- ******************************************************************** -->
";

echo "
   <tr>
    <td>
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"2\" width=\"100%\">" . $pedMedElig[$lang][0] . "</td>
      </tr>
      <tr>
          <td width=\"55%\" ><b>" .
          $pedMedElig[$lang][1] . "</b></td>
          <td width=\"45%\" ><b>" .
          $pedMedElig[$lang][2] . "</b></td>
        </tr>
        <tr>
          <td width=\"55%\" ><i>" .
		  $pedMedElig[$lang][3] . "</i></td>
		  <td width=\"45%\" ><i>" .
          $pedMedElig[$lang][4] . "</i></td>
        </tr>
        <tr>
         <td width=\"55%\" >
          <input tabindex=\"" . ($tabIndex + 1) . "\" name=\"currentHivStage[]\" " . getData ("currentHivStage", "checkbox", 1) . " type=\"radio\" value=\"1\">&nbsp;"
		   . $pedMedElig[$lang][5] .
		  "</td>
		   <td width=\"45%\"><input class=\"pedMedElig\" tabindex=\"" . ($tabIndex + 8) . "\" name=\"pedMedEligCd4Cnt\" " . getData ("pedMedEligCd4Cnt", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedMedElig[$lang][6] . "</td>
        </tr>
        <tr>
         <td width=\"55%\" >
		  <input tabindex=\"" . ($tabIndex + 2) . "\" name=\"currentHivStage[]\" " . getData ("currentHivStage", "checkbox", 2) . " type=\"radio\" value=\"2\">&nbsp;"
		   . $pedMedElig[$lang][7] .
		 "</td>
		   <td width=\"45%\"><input class=\"pedMedElig\" tabindex=\"" . ($tabIndex + 9) . "\" name=\"pedMedEligWho3\" " . getData ("pedMedEligWho3", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedMedElig[$lang][8] . "</td>
        </tr>
        <tr>
         <td width=\"55%\" >
		  <input tabindex=\"" . ($tabIndex + 3) . "\" name=\"currentHivStage[]\" " . getData ("currentHivStage", "checkbox", 4) . " type=\"radio\" value=\"4\">&nbsp;"
		   . $pedMedElig[$lang][9] .
		 "</td>
		  <td width=\"45%\"><input class=\"pedMedElig\" tabindex=\"" . ($tabIndex + 10) . "\" name=\"pedMedEligWho4\" " . getData ("pedMedEligWho4", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedMedElig[$lang][10] . "</td>
        </tr>
        <tr>
         <td width=\"55%\" >
		  <input tabindex=\"" . ($tabIndex + 4) . "\" name=\"currentHivStage[]\" " . getData ("currentHivStage", "checkbox", 8) . " type=\"radio\" value=\"8\">&nbsp;"
		  . $pedMedElig[$lang][11] .
		 "</td>
         <td width=\"45%\"><input class=\"pedMedElig\" tabindex=\"" . ($tabIndex + 11) . "\" name=\"pedMedEligTlc\" " . getData ("pedMedEligTlc", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedMedElig[$lang][12] . "</td>
        </tr>
        <tr>
          <td width=\"55%\" >&nbsp;</td>
		   <td width=\"45%\"><input class=\"pedMedElig\" tabindex=\"" . ($tabIndex + 12) . "\" name=\"pedMedEligPmtct\" " . getData ("pedMedEligPmtct", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedMedElig[$lang][13] . "</td>
        </tr>
        <tr>
          <td width=\"55%\" ><b>" . $pedMedElig[$lang][14] . "</b></td>
		  <td width=\"45%\"><input class=\"pedMedElig\" tabindex=\"" . ($tabIndex + 13) . "\" name=\"pedMedEligFormerTherapy\" " . getData ("pedMedEligFormerTherapy", "checkbox") . " type=\"checkbox\" value=\"On\">" . $pedMedElig[$lang][15] . "</td>
        </tr>
        <tr>
          <td width=\"55%\">
           <input tabindex=\"" . ($tabIndex + 5) . "\" id=\"medEligY\" name=\"medElig[]\" " . getData ("medElig", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $pedMedElig[$lang][16] . " <i>" . $pedMedElig[$lang][17] . "</i></td>
          <td width=\"45%\"><table width=\"100%\">
            <tr>
              <td><input class=\"pedMedElig\" tabindex=\"" . ($tabIndex + 14) . "\" name=\"ChildLT5ans\" " . getData ("ChildLT5ans", "checkbox") . " type=\"checkbox\" value=\"On\">".$ChildLT5ans[$lang][1]."</td>
            </tr>
            <tr>
              <td><input tabindex=\"" . ($tabIndex + 15) . "\" class=\"pedMedElig\"   name=\"coinfectionTbHiv\" " . getData ("coinfectionTbHiv", "checkbox") . " type=\"checkbox\" value=\"On\">".$coinfectionTbHiv[$lang][1]."</td>
            </tr>
            <tr>
              <td><input tabindex=\"" . ($tabIndex + 15) . "\" class=\"pedMedElig\"   name=\"coinfectionHbvHiv\" " . getData ("coinfectionHbvHiv", "checkbox") . " type=\"checkbox\" value=\"On\">
              ".$coinfectionHbvHiv[$lang][1]."</td>
            </tr>
			<tr>
              <td><input tabindex=\"" . ($tabIndex + 15) . "\" class=\"pedMedElig\"   name=\"pregnantWomen\" " . getData ("pregnantWomen", "checkbox") . " type=\"checkbox\" value=\"On\">
              ".$pregnantWomen[$lang][1]."</td>
            </tr>
			<tr>
              <td><input tabindex=\"" . ($tabIndex + 15) . "\" class=\"pedMedElig\"   name=\"breastfeedingWomen\" " . getData ("breastfeedingWomen", "checkbox") . " type=\"checkbox\" value=\"On\">
              ".$breastfeedingWomen[$lang][1]."</td>
            </tr>
			<tr>
              <td><input tabindex=\"" . ($tabIndex + 15) . "\" class=\"pedMedElig\"   name=\"nephropathieVih\" " . getData ("nephropathieVih", "checkbox") . " type=\"checkbox\" value=\"On\">
              ".$nephropathieVih[$lang][1]."</td>
            </tr>
          </table></td>
        </tr>
        <tr>
         <td width=\"55%\">
		   <input tabindex=\"" . ($tabIndex + 6) . "\" id=\"medEligN\" name=\"medElig[]\" " . getData ("medElig", "checkbox", 4) . " type=\"radio\" value=\"4\">" . $pedMedElig[$lang][18] . "
          </td>
	  <td width=\"45%\"><i>" . $pedMedElig[$lang][19] . "</i></td>
        </tr>
        <tr>
         <td width=\"55%\">
		   <input tabindex=\"" . ($tabIndex + 7) . "\" id=\"medEligU\" name=\"medElig[]\" " . getData ("medElig", "checkbox", 8) . " type=\"radio\" value=\"8\">" . $pedMedElig[$lang][20] . "
         </td>
         <td width=\"45%\">&nbsp;</td>

        </tr>
     </table>
    </td>
   </tr>
";
?>
