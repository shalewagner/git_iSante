<?php


echo "
<!-- ******************************************************************** -->
<!-- ******************** SEX Last 3 Months ******************** -->
<!-- ******************** (tab indices 6001 - 7000) ******************** -->
<!-- ******************************************************************** -->
 <div id=\"pane_sexLast3Mos\">
  <table width=\"100%\">
   <tr>
    <td>
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" width=\"100%\" colspan=\"4\">" . $riskassessment_subhead2[$lang][1] . "</td>
      </tr>
      <tr>

	   <td align=\"center\" width=\"10%\"> &nbsp;</td>
	   <td align=\"center\" width=\"10%\"> " . $generalOption[$lang][0] ."</td>
	   <td align=\"center\" width=\"10%\"> " . $generalOption[$lang][1] ."</td>
	   <td align=\"center\" width=\"10%\"> " . $generalOption[$lang][2] ."</td>
      </tr>
      <tr>
       <td>" . $lastQuarterSex[$lang][0] . "</td>
       <td align=\"center\"> <input tabindex=\"".($tab++)."\" id=\"lastQuarterSex0\" name=\"lastQuarterSex[]\" " .getData ("lastQuarterSex", "checkbox", 1) . " type=\"radio\" value=\"1\"> </td>
       <td align=\"center\"> <input tabindex=\"".($tab++)."\" id=\"lastQuarterSex1\" name=\"lastQuarterSex[]\" " .getData ("lastQuarterSex", "checkbox", 2) . " type=\"radio\" value=\"2\"> </td>
       <td align=\"center\"> <input tabindex=\"".($tab++)."\" id=\"lastQuarterSex2\" name=\"lastQuarterSex[]\" " .getData ("lastQuarterSex", "checkbox", 4) . " type=\"radio\" value=\"4\"> </td>	   
     </tr>
      <tr>
       <td>" . $lastQuarterSexWithoutCondom[$lang][0] . "</td>
       <td align=\"center\"> <input tabindex=\"".($tab++)."\" id=\"lastQuarterSexWithoutCondom0\" name=\"lastQuarterSexWithoutCondom[]\" " . getData ("lastQuarterSexWithoutCondom", "checkbox", 1) .  " type=\"radio\" value=\"1\"></td>
       <td align=\"center\"> <input tabindex=\"".($tab++)."\" id=\"lastQuarterSexWithoutCondom1\" name=\"lastQuarterSexWithoutCondom[]\" " . getData ("lastQuarterSexWithoutCondom", "checkbox", 2) .  " type=\"radio\" value=\"2\"></td>
       <td align=\"center\"> <input tabindex=\"".($tab++)."\" id=\"lastQuarterSexWithoutCondom2\" name=\"lastQuarterSexWithoutCondom[]\" " . getData ("lastQuarterSexWithoutCondom", "checkbox", 4) .  " type=\"radio\" value=\"4\"></td>	   
      </tr>
	 <tr>
	  <td>" . $lastQuarterSerologicStatusPartner[$lang][0] . "</td>
	  <td align=\"center\"> <input tabindex=\"".($tab++)."\" id=\"lastQuarterSeroStatPart0\" name=\"lastQuarterSeroStatPart[]\" " .getData ("lastQuarterSeroStatPart", "checkbox", 1) .  " type=\"radio\" value=\"1\"></td>
	  <td align=\"center\"> <input tabindex=\"".($tab++)."\" id=\"lastQuarterSeroStatPart1\" name=\"lastQuarterSeroStatPart[]\" " .getData ("lastQuarterSeroStatPart", "checkbox", 2) .  " type=\"radio\" value=\"2\"></td>
	  <td align=\"center\"> <input tabindex=\"".($tab++)."\" id=\"lastQuarterSeroStatPart2\" name=\"lastQuarterSeroStatPart[]\" " .getData ("lastQuarterSeroStatPart", "checkbox", 4) .  " type=\"radio\" value=\"4\"></td>	  
      </tr>
	<tr><td>" . $sexualContact_added[$lang][0]. " </td>
	
	<td><input type=\"radio\" ".getData("partnerHIVStatus", "radio", 1)." value=\"1\" tabindex=\"". ($tab++) . "\" name=\"partnerHIVStatus\"> " . 
$sexualContact_added[$lang][1]. 
"</td>
	<td><input type=\"radio\" ".getData("partnerHIVStatus", "radio", 2)." value=\"2\" tabindex=\"". ($tab++) . "\" name=\"partnerHIVStatus\"> " . 
$sexualContact_added[$lang][2]. 
"</td>
	</tr>
     </table>
    </td>
   </tr>
   <tr>
    <td>&nbsp;</td>
   </tr>
  </table>
 </div>";

?>
