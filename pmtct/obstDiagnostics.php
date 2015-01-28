<?php

echo "
 <div id=\"pane_obstDiagnostics\">
  <table class=\"header\">
   <tr>
    <td valign=\"top\" width=\"100%\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\">" . $antecedents_head[$lang][0] . "</td>
      </tr>
	  <tr>
	   <td>
	    <table width=\"100%\">
		 <tr>
		  <td width=\"15%\" id=\"pregnantDDRDtTitle\">".$lastRuleDate[$lang][0] ."</td>
	      <td width=\"15%\">
		   <input tabindex=\"".($tab++)."\" type=\"text\" id=\"pregnantDDRDt\" name=\"pregnantDDRDt\" size=\"8\" value=\"" . getData ("pregnantDDRDd", "textarea") . "/". getData ("pregnantDDRMm", "textarea") ."/". getData ("pregnantDDRYy", "textarea") . "\" />
		   <input type=\"hidden\" id=\"pregnantDDRYy\" name=\"pregnantDDRYy\" " . getData ("pregnantDDRYy", "text") . "/>
		   <input type=\"hidden\" id=\"pregnantDDRMm\" name=\"pregnantDDRMm\" " . getData ("pregnantDDRMm", "text") . "/>
		   <input type=\"hidden\" id=\"pregnantDDRDd\" name=\"pregnantDDRDd\" " . getData ("pregnantDDRDd", "text") . "/>
		  </td>
	      <td width=\"10%\" align=\"right\" id=\"DPADtTitle\">".$dpaDate[$lang][0] ."</td>
	      <td width=\"25%\" align=\"left\"><input tabindex=\"".($tab++)."\" type=\"text\" id=\"DPADt\" name=\"DPADt\" size=\"8\" value=\"" . getData ("DPADd", "textarea") . "/". getData ("DPAMm", "textarea") ."/". getData ("DPAYy", "textarea") . "\">
		   <input type=\"hidden\" id=\"DPAYy\" name=\"DPAYy\" " . getData ("DPAYy", "text") . "/>
		   <input type=\"hidden\" id=\"DPAMm\" name=\"DPAMm\" " . getData ("DPAMm", "text") . "/>
		   <input type=\"hidden\" id=\"DPADd\" name=\"DPADd\" " . getData ("DPADd", "text") . "/>
		  </td>


                         <td id=\"liveChildTitle\">" . $antecedents_section[$lang][19] . "
                         </td>

                         <td> <!-- ADD TO DB -->

                          <input tabindex=\"". ($tab++) . "\" type=\"text\" id=\"liveChilds\" name=\"liveChilds\" size=\"8\" maxsize=\"8\" " . getData ("liveChilds", "text") . " />
                         </td>


		 </tr>
		 <tr> 
		      <td width=\"10%\"  id=\"oldGestWeeksTitle\">".$oldGestWeeks[$lang][0] ."</td>
		      <td width=\"25%\" ><input tabindex=\"".($tab++)."\" id=\"oldGestWeeks\" name=\"oldGestWeeks\" " . getData ("oldGestWeeks", "text") . " type=\"text\"  size=\"3\" maxsize=\"3\">&nbsp;".$oldGestWeeks[$lang][1] ."</td>
			  <td id=\"gravidaTitle\" width=\"10%\">" . $antecedents_section[$lang][0] . "</td>
			  <td width=\"10%\" ><input tabindex=\"".($tab++)."\" type=\"text\" id=\"gravida\"  name=\"gravida\" size=\"8\" maxsize=\"8\" " . getData ("gravida", "text") . " /></td>
			  <td id=\"paraTitle\" width=\"10%\">" . $antecedents_section[$lang][1] . " </td>
			  <td width=\"10%\" ><input tabindex=\"".($tab++)."\" type=\"text\" id=\"para\" name=\"para\" size=\"8\" maxsize=\"8\" " . getData ("para", "text") . " /></td>
			  <td id=\"abortaTitle\" width=\"10%\">" . $antecedents_section[$lang][2] . "</td>
			  <td ><input tabindex=\"".($tab++)."\" type=\"text\" id=\"aborta\" name=\"aborta\" size=\"8\" maxsize=\"8\" " . getData ("aborta", "text") . " /></td>
		 </tr>
		</table>
	   </td>
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
