<?php

echo "
 <div id=\"pane_evalAndPlanning\">
  <table width=\"100%\">
   <tr>
	<td colspan=\"4\">&nbsp;</td>
   </tr>
   <tr>
	<td class=\"s_header\"  colspan=\"4\"><b>" . $newVih[$lang][0] . "</b></td>
   </tr>
   <tr>
	<td id=\"motherPregWeeksTitle\" width=\"8%\">" . $newVih[$lang][1] . " </td><td colspan=\"3\"><input tabindex=\"".($tab++)."\" id=\"motherPregWeeks\" name=\"motherPregWeeks\" " . getData ("motherPregWeeks", "text") . " type=\"text\" size=\"4\" maxlength=\"4\">  ".$newVih[$lang][2]."	</td>
   </tr>
   <tr>
	<td id=\"riskFactPresTitle\">" . $newVih[$lang][3] . "</td>
	<td> <input type=\"radio\" id=\"riskFactPres0\" value=\"1\" tabindex=\"". ($tab++) . "\" 
".getData("riskFactPres","radio",1)." 
name=\"riskFactPres\" >&nbsp;" . $generalOption[$lang][0]. " </td><td> <input type=\"radio\" id=\"riskFactPres1\" value=\"2\" tabindex=\"". 
($tab++) . "\" ".getData("riskFactPres","radio",2)." name=\"riskFactPres\" >" . $generalOption[$lang][1]. "</td>
	<td> 	" .$specifier[$lang][0]." <input type=\"text\" id=\"riskSpecified\" name=\"riskSpecified\" ".getData("riskSpecified","text")." tabindex=\"". ($tab++) . "\" />	</td>
   </tr>
  </table>
  <table width=\"100%\">
   <tr>
    <td colspan=\"5\"><b>" . $newVih[$lang][4] . "</b></td>
   </tr>
   <tr>
    <td width=\"15%\"> " . $newVih[$lang][5] . "</b></td>
	<td width=\"15%\"><input tabindex=\"".($tab++)."\" id=\"currentHivStage1\" name=\"currentHivStage[]\" " . getData ("currentHivStage", "checkbox","1") . " type=\"radio\" 
value=\"1\">". $newVih[$lang][6] . "</td>
	<td width=\"15%\"><input tabindex=\"".($tab++)."\" id=\"currentHivStage2\" name=\"currentHivStage[]\" " . getData ("currentHivStage", "checkbox","2") . " type=\"radio\" 
value=\"2\">". $newVih[$lang][7] . "</td>
	<td width=\"15%\"><input tabindex=\"".($tab++)."\" id=\"currentHivStage3\" name=\"currentHivStage[]\" " . getData ("currentHivStage", "checkbox","4") . " type=\"radio\" 
value=\"4\">". $newVih[$lang][8] . "</td>
	<td><input tabindex=\"".($tab++)."\" id=\"currentHivStage4\" name=\"currentHivStage[]\" " . getData ("currentHivStage", "checkbox","8") . " type=\"radio\" value=\"8\">". 
$newVih[$lang][9] . "</td>	
   </tr>
   <tr>
    <td width=\"12%\"> " . $newVih[$lang][10] . "</b></td>
	<td width=\"15%\"><input tabindex=\"".($tab++)."\" id=\"underArv1\" name=\"underArv[]\" " . getData ("underArv", "radio","1") . " type=\"radio\" value=\"1\">". $generalOption[$lang][0] . "</td>
  	<td colspan=\"4\"><input tabindex=\"".($tab++)."\" id=\"underArv2\" name=\"underArv[]\" " . getData ("underArv", "radio","2") . " type=\"radio\" value=\"2\">". 
$generalOption[$lang][1] . " " .$newVih[$lang][11]. "</td>
   </tr>
  </table>
  <table width=\"100%\">
   <tr>
	<td width=\"30%\" colspan=\"2\">&nbsp;&nbsp;" . $newVih[$lang][12] . "</td>
	<td id=\"arvInitDtTitle\" align=\"left\">
		<input tabindex=\"".($tab++)."\" id=\"arvInitDt\" name=\"arvInitDt\" value=\"" . getData ("arvInitDd","textarea") . "/". getData ("arvInitMm", "textarea") ."/". getData 
("arvInitYy", "textarea") . "\" type=\"text\"  size=\"8\" maxsize=\"8\">
		<input type=\"hidden\" id=\"arvInitYy\" name=\"arvInitYy\" " . getData ("arvInitYy", "text") . "/>
	<input type=\"hidden\" id=\"arvInitMm\" name=\"arvInitMm\" " . getData ("arvInitMm", "text") . "/>
	<input type=\"hidden\" id=\"arvInitDd\" name=\"arvInitDd\" " . getData ("arvInitDd", "text") . "/>
	

</td>
   </tr>
   <tr>
	<td width=\"10%\" colspan=\"5\">&nbsp;&nbsp;" . $newVih[$lang][13] . "</td>
   </tr>
   <tr>
	<td width=\"10%\" id=\"arvStartDtTitle\">&nbsp;&nbsp;" . $newVih[$lang][14] . "</td>
	<td width=\"18%\"> <input type=\"radio\" tabindex=\"".($tab++)."\" value=\"1\" ".getData("treatPlan","radio",1)." name=\"treatPlan\">    " . 
$newVih[$lang][15] . "</td>
	<td width=\"18%\"> <input type=\"radio\" tabindex=\"".($tab++)."\" value=\"2\" ".getData("treatPlan","radio",2)." name=\"treatPlan\">    " . 
$newVih[$lang][16] . "</td>
	<td width=\"18%\"> <input type=\"radio\" tabindex=\"".($tab++)."\" value=\"4\" ".getData("treatPlan","radio",4)." name=\"treatPlan\">    " . 
$newVih[$lang][17] . "</td>
	<td width=\"18%\"> <input type=\"radio\" tabindex=\"".($tab++)."\" value=\"8\" ".getData("treatPlan","radio",8)." name=\"treatPlan\">    " . 
$newVih[$lang][18] . "</td>
	<td width=\"18%\"> <input type=\"radio\" tabindex=\"".($tab++)."\" value=\"16\" ".getData("treatPlan","radio",16)." name=\"treatPlan\">    " 
. 
$others[$lang][0] . " <input type=\"text\" 
tabindex=\"".($tab++)."\" name=\"treatPlanText\" ".getData("treatPlanText","text")." /></td>
   </tr>
  </table>
  <table width=\"100%\">
   <tr>
    <td width=\"50%\"><b>" . $newVih[$lang][19] . "</b></td>
	<td width=\"50%\"><b>" . $newVih[$lang][20] . "</b></td>
   </tr> 
   <tr>	 
   <td><input tabindex=\"".($tab++)."\" name=\"otherDiagonse1\" " . getData ("otherDiagonse1" , "text") . " type=\"text\" size=\"50\"></td>
   <td><input tabindex=\"".($tab++)."\" name=\"otherDiagnoseTreatment1\"  " . getData ("otherDiagnoseTreatment1" , "text") . " type=\"text\" size=\"50\"></td>
  </tr>
   <tr>	 
   <td><input tabindex=\"".($tab++)."\" name=\"otherDiagonse2\" " . getData ("otherDiagonse2" , "text") . " type=\"text\" size=\"50\"></td>
   <td><input tabindex=\"".($tab++)."\" name=\"otherDiagnoseTreatment2\"  " . getData ("otherDiagnoseTreatment2" , "text") . " type=\"text\" size=\"50\"></td>
  </tr>
  <tr>	 
   <td><input tabindex=\"".($tab++)."\" name=\"otherDiagonse3\" " . getData ("otherDiagonse3" , "text") . " type=\"text\" size=\"50\"></td>
   <td><input tabindex=\"".($tab++)."\" name=\"otherDiagnoseTreatment3\"  " . getData ("otherDiagnoseTreatment3" , "text") . " type=\"text\" size=\"50\"></td>
  </tr>

  </table>
  <!-- table>
   <tr>
    <td colspan=\"3\"><b>" . $newVih[$lang][21] . "</b></td>
   </tr>
   <tr>
    <td width=\"20%\">" . $newVih[$lang][22] . "</td>
	<td align=\"left\" colspan=\"2\"><input tabindex=\"".($tab++)."\" name=\"enfantVitamin\" " . getData ("enfantVitamin", "text") . " type=\"text\"  size=\"60\" maxsize=\"255\"></td>
   </tr>
   <tr>
    <td width=\"45%\" colspan=\"2\">" . $newVih[$lang][23] . "</td>
	<td align=\"left\" ><input tabindex=\"".($tab++)."\" name=\"enfantSuppl\" " . getData ("enfantSuppl", "text") . " type=\"text\"  size=\"60\" maxsize=\"255\"></td>
   </tr>  
   <tr>
    <td width=\"20%\">" . $newVih[$lang][24] . "</td>
	<td align=\"left\" colspan=\"2\"><input tabindex=\"".($tab++)."\" name=\"enfantOtherNutr\" " . getData ("enfantOtherNutr", "text") . " type=\"text\"  size=\"60\" maxsize=\"255\"></td>
   </tr>  
  </table -->
 </div>";

?>
