<?php

echo "
 <div id=\"pane_vitalSigns\">
  <table class=\"header\">
   <tr>
    <td>&nbsp;</td>
   </tr>
   <tr>
    <td valign=\"top\" width=\"100%\">
     <table class=\"b_header_nb\" id=\"vitalsTable\">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
       <td class=\"s_header\" width=\"100%\" colspan=\"10\">" . $vital_title[$lang][0] . "</td>
      </tr>
      <tr>
       <td id=\"vitalHeightTitle\" width=\"3%\">&nbsp;" . $vitalHeight[$lang][0] . "&nbsp;&nbsp;</td>
       <td width=\"5%\"><input tabindex=\"".($tab++)."\" id=\"vitalHeight\" name=\"vitalHeight\" " . getData ("vitalHeight", "text") . " type=\"text\" size=\"3\" maxlength=\"64\"></td>
       <td width=\"3%\" id=\"vitalHeightCmTitle\"> &nbsp;<i>" . $vitalHeight[$lang][1] . "</i></td>
       <td width=\"8%\"> <input tabindex=\"".($tab++)."\" id=\"vitalHeightCm\" name=\"vitalHeightCm\" " . getData ("vitalHeightCm", "text") . " type=\"text\" size=\"3\" maxlength=\"64\"> &nbsp;<i>" . $vitalHeight[$lang][2] . "</i></td>

       <td width=\"3%\"id=\"vitalWeightTitle\" >" . $vitalWeight[$lang][1] . "&nbsp;</td>
       <td width=\"5%\"><input tabindex=\"".($tab++)."\"  id=\"vitalWeight\" name=\"vitalWeight\" " . getData ("vitalWeight", "text") .  " type=\"text\" size=\"5\" maxlength=\"10\"></td>
	<td id = \"vitalWeightUnitTitle\" width=\"1%\">&nbsp;</td>
	<td width=\"8%\">
	   <input tabindex=\"".($tab++)."\" id=\"vitalWeightUnit1\" name=\"vitalWeightUnits[]\" " . getData ("vitalWeightUnits", "radio", 1) . " type=\"radio\" value=\"1\">" .$vitalWeightUnit[$lang][0] .         " 
	   <input tabindex=\"".($tab++)."\" id=\"vitalWeightUnit2\" name=\"vitalWeightUnits[]\" " . getData ("vitalWeightUnits", "radio", 2). " type=\"radio\" value=\"2\">" .   showValidationIcon ($type, "vitalWeightUnits") . " " .  $vitalWeightUnit[$lang][1] . "</i>
	</td>
	<td  width=\"5%\" id=\"vitalHrTitle\" align=\"right\">" . $vitalHr[$lang][1] . "&nbsp;</td>
	<td ><input tabindex=\"".($tab++)."\" id=\"vitalHr\" name=\"vitalHr\" " . getData ("vitalHr", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"></td>

      </tr>
      </table>

	    <table width=\"100%\">
		<tr></tr>
		 <tr>
		  <td width=\"3%\" id=\"vitalTempTitle\" >" . $vitalTemp[$lang][1] . "&nbsp;&nbsp;</td>
		  <td width=\"5%\"><input tabindex=\"".($tab++)."\"  id=\"vitalTemp\" name=\"vitalTemp\" " . getData ("vitalTemp", "text") . " type=\"text\" size=\"5\" maxlength=\"10\">  </td>
		  <td width=\"1%\" id=\"vitalTempUnitTitle\">&nbsp;</td>
		  <td width=\"3%\"><input tabindex=\"".($tab++)."\" id=\"vitalTempUnit1\" name=\"vitalTempUnits[]\" " . getData 
("vitalTempUnits", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $vitalTempUnit[$lang][0] . " </td>
		  <td width=\"3%\"><input tabindex=\"5005\" id=\"vitalTempUnit2\" name=\"vitalTempUnits[]\" " . getData 
("vitalTempUnits", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $vitalTempUnit[$lang][1] . "</i></span></td>
		  <td width=\"3%\" id=\"vitalBp1Title\" >" . $vitalBp1[$lang][1] . "&nbsp;</td>
		  <td width=\"5%\"><input tabindex=\"".($tab++)."\" id=\"vitalBp1\" name=\"vitalBp1\" " . getData ("vitalBp1", "text") . " type=\"text\" size=\"5\" maxlength=\"10\"></td>
		  <td width=\"1%\" id=\"vitalBp2Title\">/</td>
          	  <td width=\"5%\">
			<input tabindex=\"".($tab++)."\" id=\"vitalBp2\" name=\"vitalBp2\" " . getData ("vitalBp2", "text") . " type=\"text\" size=\"5\" maxlength=\"10\"> </td>
		  <td width=\"1%\" id=\"vitalBpUnitTitle\"> </td>
		  <td width=\"8%\"> 
			<input tabindex=\"".($tab++)."\" id=\"vitalBpUnit1\" name=\"vitalBpUnit\" value=\"1\" type=\"radio\" ".getData("vitalBpUnit","radio",1)." /> ".$bpUnits[$lang][0]." 
		  </td><td width=\"8%\">
			<input tabindex=\"".($tab++)."\" id=\"vitalBpUnit2\" name=\"vitalBpUnit\" value=\"2\" type=\"radio\" ".getData("vitalBpUnit","radio",2)." /> ".$bpUnits[$lang][1]."
		  </td>
		  <td  id=\"vitalRrTitle\" width=\"5%\">" . $vitalRr[$lang][1] . "&nbsp;</td>
          <td><input tabindex=\"".($tab++)."\" id=\"vitalRr\" name=\"vitalRr\" " . getData ("vitalRr", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"></td>		  
		 </tr>
		</table>


    </td>
   </tr>
  </table>
 </div>";

?>
