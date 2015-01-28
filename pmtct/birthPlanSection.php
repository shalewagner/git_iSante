<?php


echo "
 <div id=\"pane_birthPlan\">
  <table class=\"header\">
   <tr>
    <td valign=\"top\" width=\"100%\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\">" . $birthPlanVisits[$lang][0] . "</td>
      </tr>
	  <tr>
	   <td>
		<table width=\"100%\">
			<tr>
				<th style=\"text-align:center;\">".$birthPlanVisits[$lang][1]."</th>
				<th>&nbsp; </th>
				<th style=\"text-align:center;\">".$birthPlanVisits[$lang][2]."</th>
				<th style=\"text-align:center;\">".$birthPlanVisits[$lang][3]."</th>
				<th style=\"text-align:center;\">".$birthPlanVisits[$lang][4]."</th>
				<th style=\"text-align:center;\">".$birthPlanVisits[$lang][5]."</th>
				<th style=\"text-align:center;\">".$birthPlanVisits[$lang][6]."</th>
				<th style=\"text-align:center;\">".$birthPlanVisits[$lang][7]."</th>
			</tr>
";
for($i = 1; $i < 11;$i++){
echo "
			<tr>
				<!-- td style=\"text-align:center;\"><input type=\"text\" ".getData("birthPlanDate".$i,"text")." tabindex=\"". ($tab++) . "\" name=\"birthPlanDate".$i."\" /> </td -->




           <td id=\"antenatalVisit$i". "DtTitle\"> " . $visitSeq[$lang][$i] . "</td>
           <td>
                <input tabindex=\"" . ($tab++) . "\" id=\"antenatalVisit$i". "Dt\" name=\"antenatalVisit$i". "Dt\" value=\"" . getData("antenatalVisit" . $i . "Dd" , "textarea") . "/". getData ("antenatalVisit" . $i . "Mm", "textarea") ."/". getData ("antenatalVisit" . $i . "Yy", "textarea") . "\"  type=\"text\" type=\"text\" size=\"8\" maxsize=\"8\">

                <input type=\"hidden\" id=\"antenatalVisit$i" . "Dd\" name=\"antenatalVisit$i" . "Dd\" " . getData ("antenatalVisit" . $i . "Dd" ,"text") . "/>
                <input type=\"hidden\" id=\"antenatalVisit$i" . "Mm\" name=\"antenatalVisit$i" . "Mm\" " . getData ("antenatalVisit" . $i . "Mm" ,"text") . "/>
                <input type=\"hidden\" id=\"antenatalVisit$i" . "Yy\" name=\"antenatalVisit$i" . "Yy\" " . getData ("antenatalVisit" . $i . "Yy" ,"text") . "/>           </td>


				<td style=\"text-align:center;\"><input type=\"checkbox\" value=\"1\"  ".getData("suiviPrenatal".$i,"checkbox",1)." tabindex=\"". ($tab++) . "\" name=\"suiviPrenatal".$i."\" /></td>
				<td style=\"text-align:center;\"><input type=\"checkbox\" value=\"1\"  ".getData("dispensationARV".$i,"checkbox",1)." tabindex=\"". ($tab++) . "\" name=\"dispensationARV".$i."\" /></td>
				<td style=\"text-align:center;\"><input type=\"checkbox\" value=\"1\"  ".getData("educationInd".$i,"checkbox",1)." tabindex=\"". ($tab++) . "\" name=\"educationInd".$i."\" /></td>
				<td style=\"text-align:center;\"><input type=\"checkbox\" value=\"1\"  ".getData("educationBddy".$i,"checkbox",1)." tabindex=\"". ($tab++) . "\" name=\"educationBddy".$i."\" /></td>
				<td style=\"text-align:center;\"><input type=\"checkbox\" value=\"1\"  ".getData("homeVisit".$i,"checkbox",1)." tabindex=\"". ($tab++) . "\" name=\"homeVisit".$i."\" /></td>
				<td style=\"text-align:center;\"><input type=\"checkbox\" value=\"1\"  ".getData("groupSupport".$i,"checkbox",1)." tabindex=\"". ($tab++) . "\" name=\"groupSupport".$i."\" /></td>

			</tr>

";

}

echo "		</table>
	</td>
	</tr>
	</table>
	</td>
	</tr>
	
	</table>
     </div>";

?>
