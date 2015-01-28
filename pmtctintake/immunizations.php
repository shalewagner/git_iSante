<?php

if( ($type == 24 && $version == 1 )|| ($type == 25 && $version == 1))
	$imms_list = generatePedImmunizationList ($lang, 24, 0);
else
	$imms_list = generatePedImmunizationList ($lang, $type, $version);

echo "
     <table width=\"100%\">
	  <tr>
	   <td class=\"s_header\" colspan=\"7\">" . $vacc_section[$lang][0] . "</td>
	  </tr>
	  <tr>
	   <th width=\"25%\" rowspan=\"2\">". $vacc_section[$lang][1] . "</th>
	   <th width=\"25%\" colspan=\"2\" align=\"center\">". $vacc_section[$lang][2] . "</th>	
	   <th width=\"25%\" colspan=\"2\" align=\"center\">". $vacc_section[$lang][3] . "</th>
	   <th width=\"25%\" colspan=\"2\" align=\"center\">". $vacc_section[$lang][4] . "</th>
	  </tr>
	  <tr>
	   <td width=\"15%\" align=\"center\">". $vacc_section[$lang][5] . "</td>
	   <td width=\"10%\" align=\"center\">". $vacc_section[$lang][6] . "</td>	
	   <td width=\"15%\" align=\"center\">". $vacc_section[$lang][5] . "</td>
	   <td width=\"10%\" align=\"center\">". $vacc_section[$lang][6] . "</td>
	   <td width=\"15%\" align=\"center\">". $vacc_section[$lang][5] . "</td>
	   <td width=\"10%\" align=\"center\">". $vacc_section[$lang][6] . "</td>
	  </tr>";
foreach ($imms_list as $imm) 
{
echo "
    <tr>";
	if ($imm['code'] == "immunOther") 
		echo "<td>" . $imm['label'] . "&nbsp;: <input tabindex=\"" . $tab++ . "\" id=\"" . $imm['code'] . "Text1\" name=\"" . $imm['code'] . "Text1\" type=\"text\" " . getData($imm['code'] . "Text1", "text") . "\" size=\"20\" maxlength=\"20\"></td>";
	else 
		echo "<td>" . $imm['label'] . "</td>";
      for ($i = 1; $i <= 3; $i++) {
	 	$dd = getData ($imm['code'] . "Dd". $i , "textarea");
		$mm = getData ($imm['code'] . "Mm". $i , "textarea");
		$yy = getData ($imm['code'] . "Yy". $i , "textarea");
		$sameDate = ($dd . "/" . $mm . "/" . $yy == $vstDate) ? "checked":"";
			if ($i <= $imm['cnt']) {
echo "
	 <td>	   
      <table width=\"100%\">
	   <tr>
		<td id=\"". $imm['code'] .$i . "DtTitle\">&nbsp;</td>
		<td align=\"center\"><input tabindex=\"" . $tab++ . "\" id=\"" . $imm['code'] . $i ."Dt\" name=\"" . $imm['code'] .$i . "Dt\"  value=\"" . $dd . "/" . $mm . "/" . $yy . "\" type=\"text\" size=\"8\" maxlength=\"8\">
        	<input tabindex=\"" . $tab++ . "\" id=\"" . $imm['code'] . $i ."Dd\" name=\"" . $imm['code'] . "Dd" . $i . "\" " . getData ($imm['code'] . "Dd". $i , "text") . " type=\"hidden\">
        	<input tabindex=\"" . $tab++ . "\" id=\"" . $imm['code'] . $i ."Mm\" name=\"" . $imm['code'] . "Mm" . $i . "\" " . getData ($imm['code'] . "Mm". $i , "text") . " type=\"hidden\">
       		<input tabindex=\"" . $tab++ . "\" id=\"" . $imm['code'] . $i ."Yy\" name=\"" . $imm['code'] . "Yy" . $i . "\" " . getData ($imm['code'] . "Yy". $i , "text") . " type=\"hidden\">
	    </td>
	   </tr>
	  </table>
	 </td>
	 <td align=\"center\">
	 <input tabindex=\"" . $tab++ . "\" id=\"" . $imm['code'] . $i ."DtToday\" name=\"" . $imm['code'] .$i . "DtToday\"  ".getData($imm['code'] .$i . "DtToday","checkbox",1)." type=\"checkbox\" value=\"on\" " . $sameDate . ">
	 </td>";
} 
else 
{
echo "
     <td>&nbsp;</td>
	 <td>&nbsp;</td>";
	}
}
    echo "
    </tr>";
}

?>
