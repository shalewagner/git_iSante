<?php

echo "
 <div id=\"pane_riskSection\">
  <table class=\"header\">
   <tr>
    <td>&nbsp;</td>
   </tr>
   <tr>
    <td valign=\"top\" width=\"100%\">
     <table class=\"b_header_nb\">
		  <tr>
	       <td class=\"s_header\" colspan=\"5\">" . $risk_titles[$lang][0] . "</td>
	      </tr>
	      <tr>";
	      	$where = getEncounterWhere ($eid, $pid);
	      	queryBlock($lang, $where, 24,8200,8300);
		  echo "
		  </tr> 
     </table>
	</td>
   </tr>
   <tr>
	<td>
     <table width=\"100%\">
			<tr>
				<td class=\"bottom_line\" colspan=\"10\">&nbsp;</td>
			</tr>
			<tr>
				<td colspan=\"10\">&nbsp;</td>
			</tr>
            <tr>
                <td width=\"30%\">" . $medRecord[$lang][0] . "</td>
                <td width=\"10%\"><input tabindex=\"".($tab++)."\" id=\"medRecord0\" name=\"medRecord[]\" " .getData ("medRecord", "checkbox", 1) .  " type=\"radio\" value=\"1\">" .$medRecord[$lang][1] . " </td>
                <td width=\"10%\"><input tabindex=\"".($tab++)."\" id=\"medRecord1\" name=\"medRecord[]\" " .  getData ("medRecord", "checkbox", 2) . " type=\"radio\" value=\"2\">" .$medRecord[$lang][2] . " </td>
                <td width=\"30%\">" . $transferOnArv[$lang][0] . "</td>
                <td width=\"10%\"><input tabindex=\"".($tab++)."\" id=\"transferOnArv0\" name=\"transferOnArv[]\" " .getData ("transferOnArv", "checkbox", 1) .  " type=\"radio\" value=\"1\">" .  $transferOnArv[$lang][1] . "</td>
                <td width=\"10%\"><input tabindex=\"".($tab++)."\" id=\"transferOnArv1\" name=\"transferOnArv[]\" " . getData ("transferOnArv", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $transferOnArv[$lang][2] ."</td>
            </tr>
     </table>
	 </td>
	</tr>
  </table>
 </div>";
 

?>
