<?php

echo "
 <div id=\"pane_otherInterventions\">
  <table class=\"header\">
   <tr>
    <td valign=\"top\" width=\"100%\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\">" . $other_inter[$lang][0] . "</td>
      </tr>
	  <tr>
	   <td>
		<table width=\"100%\">
			<tr>
				<td width=\"10%\">". $other_inter[$lang][1] ."</td>
				<td width=\"10%\">". $other_inter[$lang][2] ."</td>
				<td width=\"10%\">". $other_inter[$lang][3] ."</td>
				<td width=\"40%\">&nbsp;</td>
				<td width=\"15%\">&nbsp;</td>
				<td width=\"15%\">&nbsp;</td>
			</tr>

			<tr>
				<td><input type=\"radio\" ".getData("ironSup","radio",1)." tabindex=\"". ($tab++) . "\" name=\"ironSup\" value=\"1\" 
/></td>
				<td><input type=\"radio\" ".getData("ironSup","radio",2)." tabindex=\"". ($tab++) . "\" name=\"ironSup\" value=\"2\" 
/></td>
				<td><input type=\"radio\" ".getData("ironSup","radio",4)." tabindex=\"". ($tab++) . "\" name=\"ironSup\" value=\"4\" 
/></td>
				<td>". $other_inter[$lang][4] ."</td>
			</tr>

			<tr>
				<td><input type=\"radio\" ".getData("vitaSup","radio",1)." tabindex=\"". ($tab++) . "\" name=\"vitaSup\" value=\"1\" 
/></td>
				<td><input type=\"radio\" ".getData("vitaSup","radio",2)." tabindex=\"". ($tab++) . "\" name=\"vitaSup\" value=\"2\" 
/></td>
				<td><input type=\"radio\" ".getData("vitaSup","radio",4)." tabindex=\"". ($tab++) . "\" name=\"vitaSup\" value=\"4\" 
/></td>
				<td>". $other_inter[$lang][5] ."</td>
			</tr>

			<tr>
				<td><input type=\"radio\" ".getData("antiTBTreat","radio",1)." tabindex=\"". ($tab++) . "\" name=\"antiTBTreat\" 
value=\"1\" /></td>
				<td><input type=\"radio\" ".getData("antiTBTreat","radio",2)." tabindex=\"". ($tab++) . "\" name=\"antiTBTreat\" 
value=\"2\" /></td>
				<td><input type=\"radio\" ".getData("antiTBTreat","radio",4)." tabindex=\"". ($tab++) . "\" name=\"antiTBTreat\" 
value=\"4\" /></td>
				<td>". $other_inter[$lang][6] ."</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td>&nbsp;&nbsp;&nbsp;". $other_inter[$lang][7] ." <input type=\"text\" 
".getData("antiTBDose","text")." tabindex=\"". 
($tab++) . "\" 
name=\"antiTBDose\" /></td>
			</tr>

			<tr>
				<td><input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("prophylaxie","radio",1)." name=\"prophylaxie\" 
value=\"1\" /></td>
				<td><input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("prophylaxie","radio",2)." name=\"prophylaxie\" 
value=\"2\" /></td>
				<td><input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("prophylaxie","radio",4)." name=\"prophylaxie\" 
value=\"4\" /></td>
				<td>". $other_inter[$lang][8] ."</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td>&nbsp;&nbsp;&nbsp;". $other_inter[$lang][9] ." <input type=\"text\" ".getData("prophylaxieDose","text")." 
tabindex=\"". ($tab++) . "\" 
name=\"prophylaxieDose\" /></td>
			</tr>

			<tr>
				<td><input type=\"radio\" tabindex=\"". ($tab++) . "\" 
".getData("prophylaxieCotrim","radio",1)." name=\"prophylaxieCotrim\" value=\"1\" /></td>
				<td><input type=\"radio\" tabindex=\"". ($tab++) . "\" 
".getData("prophylaxieCotrim","radio",2)." name=\"prophylaxieCotrim\" value=\"2\" /></td>
				<td><input type=\"radio\" tabindex=\"". ($tab++) . "\" 
".getData("prophylaxieCotrim","radio",4)." name=\"prophylaxieCotrim\" value=\"4\" /></td>
				<td>". $other_inter[$lang][10] ."</td>
			</tr>
			<tr>
				<td><input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("placedOnART","radio",1)." name=\"placedOnART\" value=\"1\" /></td>
				<td><input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("placedOnART","radio",2)." name=\"placedOnART\" value=\"2\" /></td>
				<td><input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("placedOnART","radio",4)." name=\"placedOnART\" value=\"4\" /></td>
				<td>". $other_inter[$lang][11] ."</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td>&nbsp;&nbsp;&nbsp;". $other_inter[$lang][12] ." <input type=\"text\" ".getData("ARTMeds","text")." tabindex=\"". 
($tab++) . "\" name=\"ARTMeds\" /></td>
			</tr>

			<tr>
				<td><input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("tetanic","radio",1)." name=\"tetanic\" value=\"1\" 
/></td>
				<td><input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("tetanic","radio",2)." name=\"tetanic\" value=\"2\" 
/></td>
				<td><input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("tetanic","radio",4)." name=\"tetanic\" value=\"4\" 
/></td>
				<td>". $other_inter[$lang][13] ."</td>
				<td><input type=\"checkbox\" value=\"1\" tabindex=\"". ($tab++) . "\" ".getData("tetDoseI","checkbox",1)." 
name=\"tetDoseI\">". 
$other_inter[$lang][14] ."</td>
				<td><input type=\"checkbox\" value=\"1\" tabindex=\"". ($tab++) . "\" ".getData("tetDoseII","checkbox",1)." 
name=\"tetDoseII\">". 
$other_inter[$lang][15] ."</td>
			</tr>

			<tr>
				<td><input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("malariaTreat","radio",1)." name=\"malariaTreat\" 
value=\"1\" /></td>
				<td><input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("malariaTreat","radio",2)." name=\"malariaTreat\" 
value=\"2\" /></td>
				<td><input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("malariaTreat","radio",4)." name=\"malariaTreat\" 
value=\"4\" /></td>
				<td>". $other_inter[$lang][16] ."</td>
				<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" value=\"1\"
".getData("malariaDoseI","checkbox",1)." name=\"malariaDoseI\">". $other_inter[$lang][14] ."</td>
				<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" value=\"1\" 
".getData("malariaDoseII","checkbox",1)." name=\"malariaDoseII\">". $other_inter[$lang][15] ."</td>
			</tr>

			<tr>
				<td><input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("ARVcounsel","radio",1)." name=\"ARVcounsel\" 
value=\"1\" /></td>
				<td><input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("ARVcounsel","radio",2)." name=\"ARVcounsel\" 
value=\"2\" /></td>
				<td><input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("ARVcounsel","radio",3)." name=\"ARVcounsel\" 
value=\"4\" /></td>
				<td>". $other_inter[$lang][17] ."</td>
			</tr>

			<tr>
				<td><input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("PFcounsel","radio",1)." name=\"PFcounsel\" 
value=\"1\" /></td>
				<td><input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("PFcounsel","radio",2)." name=\"PFcounsel\" 
value=\"2\" /></td>
				<td><input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("PFcounsel","radio",4)." name=\"PFcounsel\" 
value=\"4\" /></td>
				<td>". $other_inter[$lang][18] ."</td>
			</tr>

			<tr>
				<td><input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("NNEcounsel","radio",1)." name=\"NNEcounsel\" 
value=\"1\" /></td>
				<td><input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("NNEcounsel","radio",2)." name=\"NNEcounsel\" 
value=\"2\" /></td>
				<td><input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("NNEcounsel","radio",4)." name=\"NNEcounsel\" 
value=\"4\" /></td>
				<td>". $other_inter[$lang][19] ."</td>
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
