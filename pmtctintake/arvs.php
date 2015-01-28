<?php
echo "
<tr>
    <td>
	     <table class=\"b_header_nb\" cellspacing =\"0\" cellpadding=\"0\" BORDER=\"0\">
	      <tr>
	       <td class=\"s_header\" colspan=\"10\">" . $arv_header[$lang][1] . "</td>
	      </tr>
	      <!-- tr>
	       < td colspan=\"10\">" . $arvEver[$lang][0] . " <span>
	         <input tabindex=\"" . ($tab++ ) . "\" id=\"arv0\" name=\"arvEver[]\" " . getData ("arvEver", "checkbox", 1) . " type=\"radio\" value=\"1\">" . $arvEver_1[$lang][1] . " &nbsp;&nbsp;<input tabindex=\"" . ($tab++) . "\" id=\"arv1\" name=\"arvEver[]\" " . getData ("arvEver", "checkbox", 2) . " type=\"radio\" value=\"2\">" . $arvEver_1[$lang][2] . "</span></td>
	      </tr -->
	      <tr>
	       <td class=\"bottom_line\" colspan=\"10\">&nbsp;</td>
	      </tr>
	      <tr>
	       <td>&nbsp;</td>
	       <td class=\"sm_header_lt\">" . $arv_subhead1[$lang][0] . "</td>
	       <td class=\"sm_header_lt\">" . $arv_subhead1[$lang][1] . "</td>
	       <td class=\"sm_header_cnt\">" . $arv_subhead1[$lang][2] . "</td>
	       <td class=\"sm_header_cnt\">&nbsp;</td>
	       <td class=\"sm_header_lt\" colspan=\"4\">" . $arv_subhead6[$lang][1] . "</td>
	      </tr>
	      <tr>
	       <td class=\"top_line\" colspan=\"10\">&nbsp;</td>
	      </tr>
	      <tr>
	       <td colspan=\"5\"><b><a class=\"toggle_display\"
	            onclick=\"toggleDisplay(0,$arvSubHeadElems[0]);\"
	            title=\"Toggle display\">
	            <span id=\"section0Y\" style=\"display:none\">(+)</span>
	            <span id=\"section0N\">(-)&nbsp;</span>" .
	          $arv_subhead3[$version][$lang][1] .
	         "</a></b></td>
	       <td class=\"sm_header_cnt\">" . $arv_subhead8[$lang][0] . "</td>
	       <td class=\"sm_header_cnt\">" . $arv_subhead8[$lang][1] . "</td>
	       <td class=\"sm_header_cnt\">" . $arv_subhead8[$lang][2] . "</td>
	       <td class=\"sm_header_cnt\">" . $arv_subhead11[$lang][2] . "</td>
	       <td class=\"sm_header_cnt\">" . $arv_addon[$lang][0] . "</td>
	      </tr>" . $arv_rows . "
                <tr style=\"padding-top:.5em;\">
                        <td id=\"arvOtherWriteinTitle\"> ".$arv_section[$lang][7]."</td>
                        <td colspan=\"5\"><input size=\"120\" maxsize=\"240\"  type=\"text\" name=\"arvOtherWritein\" tabindex=\"" . ($tab++ ) . "\" 
".getData("arvOtherWritein","text") 
." 
/></td>
                </tr>

	     </table>
    </td>
</tr>
";


?>
