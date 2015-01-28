<?php

echo "
<div id=\"pane_familyPlanning\">
		   <table width=\"100%\">
			<tr>   <td class=\"s_header\" colspan=\"5\">

" . $antecedents_section[$lang][13] . "
			</td></tr>

		    <tr>
			 <td >" . $antecedents_section[$lang][13] . "</td>
			 <td > <input tabindex=\"". ($tab++) . "\" type=\"radio\" id=\"famPlan0\" name=\"famPlan[]\" " . getData ("famPlan", "checkbox","1") . " value=\"1\"/>" . 
$generalOption[$lang][0] . " </b>
			 <td > <input tabindex=\"". ($tab++) . "\" type=\"radio\" id=\"famPlan1\" name=\"famPlan[]\" " . getData ("famPlan", "checkbox","2") . " value=\"2\"/>" . 
$generalOption[$lang][1] . " </b>
			 <td > <input tabindex=\"". ($tab++) . "\" type=\"radio\" id=\"famPlan2\" name=\"famPlan[]\" " . getData ("famPlan", "checkbox","4") . " value=\"4\"/>" . 
$generalOption[$lang][2] . " </b>
	        </tr>

		<tr>
			<td id=\"beginBCDtTitle\">".$added_familyPlanning[$lang][0]." </td>
			<td><input name=\"beginBCDt\" id=\"beginBCDt\"size=\"8\" maxsize=\"8\" value=\"" . getData ("beginBCDd", "textarea") .
"/". getData ("beginBCMm", "textarea") ."/". getData ("beginBCYy", "textarea") . "\"/> 
                   <input type=\"hidden\" id=\"beginBCYy\" name=\"beginBCYy\" " . getData ("beginBCYy", "text") . "/>
                   <input type=\"hidden\" id=\"beginBCMm\" name=\"beginBCMm\" " . getData ("beginBCMm", "text") . "/>
                   <input type=\"hidden\" id=\"beginBCDd\" name=\"beginBCDd\" " . getData ("beginBCDd", "text") . "/>



			</td>

			<td id=\"endBCDtTitle\"> ".$added_familyPlanning[$lang][1]."</td>

			<td><input name=\"endBCDt\" id=\"endBCDt\" size=\"8\" maxsize=\"8\" value=\"" . getData ("endBCDd", "textarea") .
"/". getData ("endBCMm", "textarea") ."/". getData ("endBCYy", "textarea") . "\"/> 
                   <input type=\"hidden\" id=\"endBCYy\" name=\"endBCYy\" " . getData ("endBCYy", "text") . "/>
                   <input type=\"hidden\" id=\"endBCMm\" name=\"endBCMm\" " . getData ("endBCMm", "text") . "/>
                   <input type=\"hidden\" id=\"endBCDd\" name=\"endBCDd\" " . getData ("endBCDd", "text") . "/>






			</td>
			<td><input type=\"checkbox\" name=\"currentBCUse\" value=\"1\" " . getData ("currentBCUse", "checkbox",1) . "/> ".$added_familyPlanning[$lang][2]."</td>
		</tr>
		   </table>
		  </td>
		 </tr>
		 <tr>
		  <td>
		  </td>
		 </tr>
		
		   <table width=\"100%\">
		    <tr>
			 <td colspan=\"2\" width=\"40%\">" . $antecedents_section[$lang][14] . "</td>
	         <td ><input tabindex=\"". ($tab++) . "\" type=\"checkbox\" id=\"famPlanMethodCondom\" name=\"famPlanMethodCondom\" " . getData ("famPlanMethodCondom", 
"checkbox","1") . " value=\"1\" /> ". $famPlanMethod[$lang][0] . "</td>
	         <td ><input tabindex=\"". ($tab++) . "\" type=\"checkbox\" id=\"famPlanMethodDmpa\" name=\"famPlanMethodDmpa\" " . getData ("famPlanMethodDmpa", "checkbox","1") 
. " value=\"1\"/> ". $famPlanMethod[$lang][1] . "</td>
	         <td ><input tabindex=\"". ($tab++) . "\" type=\"checkbox\" id=\"famPlanMethodOcPills\" name=\"famPlanMethodOcPills\" " . getData ("famPlanMethodOcPills", 
"checkbox","1") . " value=\"1\"/> ". $famPlanMethod[$lang][2] . "</td>
	         <td ><input tabindex=\"". ($tab++) . "\" type=\"checkbox\" id=\"famPlanMethodNorplan\" name=\"famPlanMethodNorplan\" " . getData ("famPlanMethodNorplan", 
"checkbox","1") . " value=\"1\"/> ". $famPlanMethod[$lang][3] . "</td>


	         <td ><input tabindex=\"". ($tab++) . "\" value=\"1\" type=\"checkbox\" ".getData("famPlanMethodTablet","checkbox",1)." id=\"famPlanMethodTablet\" 
name=\"famPlanMethodTablet\" /> ". 
$famPlanMethod[$lang][5] 
. 
"</td>
	         <td ><input tabindex=\"". ($tab++) . "\" value=\"1\" type=\"checkbox\" ".getData("famPlanMethodSterile","checkbox",1)." id=\"famPlanMethodSterile\" 
name=\"famPlanMethodSterile\" /> ". 
$famPlanMethod[$lang][6] . 
"</td>
	         <td ><input tabindex=\"". ($tab++) . "\" value=\"1\" type=\"checkbox\" ".getData("famPlanMethodImplant","checkbox",1)." id=\"famPlanMethodImplant\" 
name=\"famPlanMethodImplant\" /> ". 
$famPlanMethod[$lang][7] . 
"</td>
	         <td ><input tabindex=\"". ($tab++) . "\" value=\"1\" type=\"checkbox\" ".getData("famPlanMethodLigature","checkbox",1)." id=\"famPlanMethodLigature\" 
name=\"famPlanMethodLigature\" /> ". 
$famPlanMethod[$lang][8] . 
"</td>


			</tr>
			<tr>
	         <td ><input tabindex=\"". ($tab++) . "\" type=\"checkbox\" id=\"famPlanOther\" name=\"famPlanOther\" " . getData ("famPlanOther", "checkbox","1") . " 
value=\"1\"/> ". 
$famPlanMethod[$lang][4] . "</td>     
		     <td colspan=\"5\"><input tabindex=\"". ($tab++) . "\" id=\"famPlanOtherText\" name=\"famPlanOtherText\" size=\"30\" maxlength=\"255\"  type=\"text\"  " . 
getData 
("famPlanOtherText", "text") . "></td>
			</tr>
		   </table>

	</div>
";



?>
