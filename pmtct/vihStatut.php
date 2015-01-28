<?php
// disable the HIV positive control if patient is already HIV positive
$vihResultDisabled = (getHivPositive($pid)) ? "disabled" : ""; 
// check the HIV positive control on a new form if patient is already HIV positive
$vihResultCheckedPos = (getHivPositive($pid) && !isset($_GET['eid'])) ? "checked" : "";
if(DEBUG_FLAG)
	fb("PID: ".$pid ." DISABLE: " . $vihResultDisabled . " CHECKPOS: " . $vihResultCheckedPos, "VIH Status Settings");
echo "
<div id=\"pane_VIHStatus\">
	<table class=\"header\">
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td valign=\"top\" width=\"100%\">
				<table class=\"b_header_nb\">
					<tr>
						<td class=\"s_header\">" . $vih_section[$lang][0] . "</td>
					</tr>
					<tr>
						<td>
							<table width=\"100%\">
								<tr>
									<td width=\"15%\"> " . $vih_section[$lang][1] . " </td>
									<td width=\"10%\">
										<input tabindex=\"". ($tab++) . "\" type=\"radio\" id=\"lastVIHTest0\" name=\"lastVIHTest[]\" " . 
getData ("lastVIHTest", "radio","1") . " value=\"1\"/>" . $generalOption[$lang][0] . " &nbsp;
									</td>
									<td width=\"10%\">
										<input tabindex=\"". ($tab++) . "\" type=\"radio\" id=\"lastVIHTest1\" name=\"lastVIHTest[]\" " . 
getData ("lastVIHTest", "radio","2") . " value=\"2\"/>" . $generalOption[$lang][1] . " &nbsp;
									</td>
									<td width=\"10%\">
										<input tabindex=\"". ($tab++) . "\" type=\"radio\" id=\"lastVIHTest2\" name=\"lastVIHTest[]\" " . 
getData ("lastVIHTest", "radio","4") . " value=\"4\"/>" . $generalOption[$lang][2] . "
									</td>
									<td width=\"10%\">&nbsp; </td>
									<td class=\"vert_line\" width=\"1%\"  rowspan=\"4\">&nbsp;</td>
									<td rowspan=\"4\" valign=\"center\"><a href=\"#medications_section\" tabindex=\" . ($tab++) .\">" . 
$vih_section[$lang][4] 
. " 
</a></td>
								</tr>
								<tr>
									<td class=\"bottom_line\" colspan=\"5\">&nbsp;</td>
								</tr>
								<tr>
									<td colspan=\"5\">
										<table width=\"100%\">
											<tr>
												<td width=\"40%\">" . $vih_section[$lang][2] . "</td>
												<td width=\"1%\" id =\"lastVIHTestDtTitle\"> &nbsp;</td>
												<td> <input tabindex=\"".($tab++)."\" type=\"text\" id=\"lastVIHTestDt\" name=\"lastVIHTestDt\" size=\"8\" value=\"" . getData ("lastVIHTestDd", "textarea") . "/". getData ("lastVIHTestMm", "textarea") ."/". getData ("lastVIHTestYy", "textarea") . "\" />
	                                                                                                <input type=\"hidden\" id=\"lastVIHTestYy\" name=\"lastVIHTestYy\" " . getData ("lastVIHTestYy", "text") . "/>
        	                                                                                        <input type=\"hidden\" id=\"lastVIHTestMm\" name=\"lastVIHTestMm\" " . getData ("lastVIHTestMm", "text") . "/>
                	                                                                                <input type=\"hidden\" id=\"lastVIHTestDd\" name=\"lastVIHTestDd\" " . getData ("lastVIHTestDd", "text") . "/>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td>&nbsp;&nbsp;" . $vih_section[$lang][3] . " </td>
									<td><input tabindex=\"".($tab++)."\" type=\"radio\" id=\"lastVIHTestResult0\" name=\"lastVIHTestResult\" " . getData ("lastVIHTestResult", "checkbox","1") . " value=\"1\" " . $vihResultCheckedPos . " " . $vihResultDisabled . " />" . $generalOption[$lang][3] . " </td>
									<td><input tabindex=\"".($tab++)."\" type=\"radio\" id=\"lastVIHTestResult1\" name=\"lastVIHTestResult\" " . getData ("lastVIHTestResult", "checkbox","2") . " value=\"2\" " . $vihResultDisabled . " />" . $generalOption[$lang][4] . "</td>
									<td><input tabindex=\"".($tab++)."\" type=\"radio\" id=\"lastVIHTestResult2\" name=\"lastVIHTestResult\" " . getData ("lastVIHTestResult", "checkbox","4") . " value=\"4\" " . $vihResultDisabled . " />" . $generalOption[$lang][5] . "</td>
									<td> &nbsp;</td>
								</tr>
								<tr>
									<td class=\"top_line\" colspan=\"7\">&nbsp;</td>
								</tr>
								<tr>
									<td colspan=\"7\">
										<table width=\"100%\">
											<tr>
												<td width=\"30%\">" . $vih_section[$lang][5] . " </td>
												<td width=\"15%\"><input tabindex=\"".($tab++)."\" type=\"radio\" id=\"lastHIVTestFac0\" name=\"lastHIVTestFac[]\" " . getData ("lastHIVTestFac", "checkbox","1") . " value=\"1\"/>" . $vih_section[$lang][6] . " &nbsp;</td>
												<td> <input tabindex=\"".($tab++)."\" type=\"radio\" id=\"lastHIVTestFac1\" 
name=\"lastHIVTestFac[]\" " . getData ("lastHIVTestFac", "checkbox","2") . " value=\"2\"/>" . $vih_section[$lang][7] . " &nbsp;&nbsp;<input tabindex=\"".($tab++)."\" type=\"text\" 
id=\"lastHIVTestOtherText\" name=\"lastHIVTestOtherText\" " . getData ("lastHIVTestOtherText", "text") . " size=\"60\" maxlength=\"255\"/></td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		
		<tr>
			<td>
     <table class=\"b_header_nb\">

      <tr>
       <td width=\"20%\">" . $cd4_section[$lang][2] . "</td>
	   <td width=\"5%\"> <input tabindex=\"".($tab++)."\" id=\"lowestCd4CntNotDone0\" name=\"lowestCd4CntNotDone[]\" " . getData ("lowestCd4CntNotDone", "radio", 2) .  " type=\"radio\" value=\"2\">". $generalOption[$lang][0] . "</td>
 	   <td width=\"5%\"> <input tabindex=\"".($tab++)."\" id=\"lowestCd4CntNotDone1\" name=\"lowestCd4CntNotDone[]\" " . getData ("lowestCd4CntNotDone", "radio", 1) .  " type=\"radio\" value=\"1\">". $generalOption[$lang][1] . "</td>
	   <td width=\"20%\"> <input tabindex=\"".($tab++)."\" id=\"lowestCd4CntNotDone2\" name=\"lowestCd4CntNotDone[]\" " . getData ("lowestCd4CntNotDone", "radio", 4) .  " type=\"radio\" value=\"4\">". $generalOption[$lang][2] . "</td>	   
       <td width=\"10%\" id=\"lowestCd4CntDtTitle\">" . $cd4_section[$lang][0] . "</td>
	   <td width=\"20%\"><input tabindex=\"".($tab++)."\" id=\"lowestCd4CntDt\" name=\"lowestCd4CntDt\"  type=\"text\" size=\"8\" maxlength=\"8\" value=\"".getData ("lowestCd4CntDd", "textarea") ."/". getData ("lowestCd4CntMm", "textarea") ."/". getData ("lowestCd4CntYy", "textarea") ."\" >
	    <input id=\"lowestCd4CntDd\" name=\"lowestCd4CntDd\" " . getData ("lowestCd4CntDd", "text") . " type=\"hidden\" >
		<input id=\"lowestCd4CntMm\" name=\"lowestCd4CntMm\" " . getData ("lowestCd4CntMm", "text") . " type=\"hidden\" >
		<input id=\"lowestCd4CntYy\" name=\"lowestCd4CntYy\" " . getData ("lowestCd4CntYy", "text") . "type=\"hidden\" >
	   </td> 
	   <td id=\"lowestCd4CntTitle\" width=\"10%\">" . $cd4_section[$lang][1] . "</td>	   
       <td><input tabindex=\"".($tab++)."\" id=\"lowestCd4Cnt\" name=\"lowestCd4Cnt\" " . getData ("lowestCd4Cnt", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"></td>
       <td><input tabindex=\"".($tab++)."\" id=\"lowestCd4CntUnknown\" name=\"lowestCd4CntUnknown\" value=\"1\" " . getData ("lowestCd4CntUnknown", "radio",1) . 
" type=\"radio\" /> ".$generalOption[$lang][2]." </td>
      </tr>
      <tr>
       <td width=\"20%\">" . $firstViralLoad[$lang][1] . "</td>
	   <td width=\"5%\"> <input tabindex=\"".($tab++)."\" id=\"firstViralLoadNotDone0\" name=\"firstViralLoadNotDone[]\" " . getData ("firstViralLoadNotDone", "radio", 2) .  " type=\"radio\" value=\"2\">". $generalOption[$lang][0] . "</td>
 	   <td width=\"5%\"> <input tabindex=\"".($tab++)."\" id=\"firstViralLoadNotDone1\" name=\"firstViralLoadNotDone[]\" " . getData ("firstViralLoadNotDone", "radio", 1) .  " type=\"radio\" value=\"1\">". $generalOption[$lang][1] . "</td>
	   <td width=\"20%\"> <input tabindex=\"".($tab++)."\" id=\"firstViralLoadNotDone2\" name=\"firstViralLoadNotDone[]\" " . getData ("firstViralLoadNotDone", "radio", 4) .  " type=\"radio\" value=\"4\">". $generalOption[$lang][2] . "</td>	   
       <td width=\"10%\" id=\"firstViralLoadDtTitle\">" . $cd4_section[$lang][0] . "</td>
	   <td width=\"20%\"><input tabindex=\"".($tab++)."\" id=\"firstViralLoadDt\" name=\"firstViralLoadDt\"  type=\"text\" size=\"8\" maxlength=\"8\" value=\"".getData ("firstViralLoadDd", "textarea") ."/". getData ("firstViralLoadMm", "textarea") ."/". getData ("firstViralLoadYy", "textarea") ."\" >
	    <input id=\"firstViralLoadDd\" name=\"firstViralLoadDd\" " . getData ("firstViralLoadDd", "text") . " type=\"hidden\" >
		<input id=\"firstViralLoadMm\" name=\"firstViralLoadMm\" " . getData ("firstViralLoadMm", "text") . " type=\"hidden\" >
		<input id=\"firstViralLoadYy\" name=\"firstViralLoadYy\" " . getData ("firstViralLoadYy", "text") . "type=\"hidden\" >
	   </td> 
	   <td id=\"firstViralLoadTitle\" width=\"10%\">" . $cd4_section[$lang][1] . "</td>	   
       <td><input tabindex=\"".($tab++)."\" id=\"firstViralLoad\" name=\"firstViralLoad\" " . getData ("firstViralLoad", "text") . " type=\"text\" size=\"10\" maxlength=\"64\"></td>
	<td> <input type=\"radio\" name=\"firstViralLoadUnknown\" value=\"1\" tabindex=\"".($tab++)."\" " . getData ("firstViralLoadUnknown", "radio",1) . "> ". $generalOption[$lang][2] ." </td>
      </tr>
	<tr>
		<td id=\"referenceTitle\">" .$vih_section[$lang][12] ."	</td>
		<td>
			<input type=\"radio\" value=\"1\" name=\"partnerReference\" ".getData("partnerReference","radio",1)." tabindex=\"".($tab++)."\" /> " 
.$generalOption[$lang][0] ." &nbsp;
		</td><td>
			<input type=\"radio\" value=\"2\" name=\"partnerReference\" ".getData("partnerReference","radio",2)." tabindex=\"".($tab++)."\" /> " 
.$generalOption[$lang][1] ." &nbsp;
		</td><td>
			<input type=\"radio\" value=\"4\" name=\"partnerReference\" ".getData("partnerReference","radio",4)." tabindex=\"".($tab++)."\" /> " 
.$generalOption[$lang][2] ." &nbsp;
		</td>

     </table>

			</td>
		</tr>

	</table>
</div>
";


?>
