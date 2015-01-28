<?php

echo "
 <div id=\"pane_birthPlanPrevention\">
  <table class=\"header\">
   <tr>
    <td valign=\"top\" width=\"100%\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\">" . $birthPlan[$lang][0] . "</td>
      </tr>
	  <tr>
	   <td>
		<table width=\"100%\">
			<tr>
				<td width=\"40%\" id=\"probableBirthDtTitle\">" . $birthPlan[$lang][1] . "  </td> 
				<td>" . $birthPlan[$lang][2] . " <input type=\"radio\" ".getData("birthPlace","radio",1)." tabindex=\"". 
($tab++) 
. 
"\" name=\"birthPlace\" 
value=\"1\" /> " . $birthPlan[$lang][3] . " 
								<input type=\"radio\" ".getData("birthPlace","radio",2)." tabindex=\"". ($tab++) . 
"\" name=\"birthPlace\" value=\"2\" /> " . $birthPlan[$lang][4] . "  </td>
			</tr>

			<tr>
				<td><input type=\"text\" value=\"" . getData ("probableBirthDd","textarea") . "/". getData ("probableBirthMm", "textarea") ."/". getData 
("probableBirthYy", "textarea") . "\" tabindex=\"". ($tab++) . "\" name=\"probableBirthDt\" id=\"probableBirthDt\" size=\"8\" maxsize=\"8\" />

					<input type=\"hidden\" id=\"probableBirthYy\" name=\"probableBirthYy\" " . getData ("probableBirthYy", "text") . "/>
					<input type=\"hidden\" id=\"probableBirthMm\" name=\"probableBirthMm\" " . getData ("probableBirthMm", "text") . "/>
					<input type=\"hidden\" id=\"probableBirthDd\" name=\"probableBirthDd\" " . getData ("probableBirthDd", "text") . "/>


</td>
				<td>" . $birthPlan[$lang][5] . " <input ".getData("birthHospitalName","text")." type=\"text\" tabindex=\"". 
($tab++) . "\" 
name=\"birthHospitalName\" /></td>
			</tr>

			<tr>
				<td> " . $birthPlan[$lang][6] . "</td>
				<td> <input type=\"radio\" ".getData("HIVBabyPreventionPlan","radio",1)." tabindex=\"". ($tab++) . "\" 
name=\"HIVBabyPreventionPlan\" value=\"1\"/> " .$generalOption[$lang][0]."
				     <input type=\"radio\" ".getData("HIVBabyPreventionPlan","radio",2)." tabindex=\"". ($tab++) . "\" 
name=\"HIVBabyPreventionPlan\" value=\"2\"/> " .$generalOption[$lang][1]."</td>
			</tr>

			<tr>
				<td>" . $birthPlan[$lang][7] ."</td>
				<td> <input type=\"text\" tabindex=\"". ($tab++) . "\" 
".getData("birthPlanHIVPrevention","text")." name=\"birthPlanHIVPrevention\" /></td>
			</tr>

			<tr>
				<td> " . $birthPlan[$lang][8] . "</td>
				<td> <input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("residentialPlanMatron","radio",1)." name=\"residentialPlanMatron\" value=\"1\"/> " .$generalOption[$lang][0]."
				     <input type=\"radio\" ".getData("residentialPlanMatron","radio",2)." tabindex=\"". ($tab++) . "\" name=\"residentialPlanMatron\" value=\"2\"/> " .$generalOption[$lang][1]."</td>
			</tr>

			<tr>
				<td>" . $birthPlan[$lang][9] ."</td>
				<td> <input type=\"text\" tabindex=\"". ($tab++) . "\" ".getData("residentialPlanMatronName","text")." name=\"residentialPlanMatronName\" /></td>
			</tr>

			<tr>
				<td> " . $birthPlan[$lang][10] . "</td>
				<td> <input type=\"radio\" tabindex=\"". ($tab++) . "\" name=\"BddyPresent\" ".getData("BddyPresent","radio",1)." value=\"1\"/> " .$generalOption[$lang][0]."
				     <input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("BddyPresent","radio",2)." name=\"BddyPresent\" value=\"2\"/> " .$generalOption[$lang][1]."</td>
			</tr>

			<tr>
				<td>" . $birthPlan[$lang][11] ."</td>
				<td> <input type=\"text\" tabindex=\"". ($tab++) . "\" name=\"nameOfBuddy\" ".getData("nameOfBuddy","text")."/></td>
			</tr>

			<tr>
				<td>" . $birthPlan[$lang][12] ."</td>
				<td> <input type=\"text\" tabindex=\"". ($tab++) . "\" name=\"planForFood\" ".getData("planForFood","text")." /></td>
			</tr>

			<tr>
				<td>" . $birthPlan[$lang][13] ."</td>
				<td><table width=\"100%\">
					<tr>
						<td width=\"33%\">  " . $birthPlan[$lang][14] ."</td>
						<td>  <input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("agentVisitMade","radio",1)." value=\"1\" name=\"agentVisitMade\">" .$generalOption[$lang][0]." </td>
						<td>  <input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("agentVisitMade","radio",2)." value=\"2\" name=\"agentVisitMade\">" .$generalOption[$lang][1]." </td>
					</tr>
					<tr>
						<td>  " . $birthPlan[$lang][15] ."</td>
						<td>  <input type=\"radio\" tabindex=\"". ($tab++) . "\" ".getData("agentVisitPlanned","radio",1)." value=\"1\" name=\"agentVisitPlanned\">" .$generalOption[$lang][0]." </td>
						<td>  <input type=\"radio\" ".getData("agentVisitPlanned","radio",2)." value=\"2\" tabindex=\"". ($tab++) . "\" name=\"agentVisitPlanned\">" .$generalOption[$lang][1]." </td>
					</tr>
				    </table>
				</td>
			</tr>

			<tr>
				<td>" . $birthPlan[$lang][16] ."</td>
				<td><table width=\"100%\">
					<tr>
						<td width=\"33%\">  " . $birthPlan[$lang][17] ."</td>
						<td>  <input type=\"radio\" ".getData("motherClub","radio",1)." value=\"1\" tabindex=\"". ($tab++) . "\" name=\"motherClub\">" .$generalOption[$lang][0]." </td>
						<td>  <input type=\"radio\" ".getData("motherClub","radio",2)." value=\"2\" tabindex=\"". ($tab++) . "\" name=\"motherClub\">" .$generalOption[$lang][1]." </td>
					</tr>
					<tr>
						<td width=\"33%\">  " . $birthPlan[$lang][18] ."</td>
						<td>  <input type=\"radio\" ".getData("motherClubPlanned","radio",1)." value=\"1\" tabindex=\"". ($tab++) . "\" name=\"motherClubPlanned\">" .$generalOption[$lang][0]." </td>
						<td>  <input type=\"radio\" ".getData("motherClubPlanned","radio",2)." value=\"2\" tabindex=\"". ($tab++) . "\" name=\"motherClubPlanned\">" .$generalOption[$lang][1]." </td>
					</tr>
				    </table>
				</td>
			</tr>


		</table>
	   </td>
	  </tr>
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
