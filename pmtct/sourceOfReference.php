<?php



echo "
 <div id=\"pane_sourceOfReference\">
  <table class=\"header\">
   <tr>
    <td valign=\"top\" width=\"100%\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\">" . $general_information[$lang][0] . "</td>
      </tr>
	  <tr>
	   <td>
		<table width=\"100%\">
			<tr>
				<td width=\"20%\">" . $general_information[$lang][1] . "</td>
				<td colspan=\"2\"><input type=\"radio\"  value=\"1\" ".getData("consult_rsn", "radio",1) ." tabindex=\"". ($tab++) . "\" name=\"consult_rsn\" 
/>" . 
$general_information[$lang][2] . "</td>
				<td colspan=\"2\"><input type=\"radio\" value=\"2\" ".getData("consult_rsn", "radio",2) ." tabindex=\"". ($tab++) . "\" name=\"consult_rsn\" 
/>" . 
$general_information[$lang][3] . "</td>
				<td colspan=\"2\"><input type=\"radio\" ".getData("consult_rsn", "radio",4) ." tabindex=\"". ($tab++) . "\" name=\"consult_rsn\" />" . 
$general_information[$lang][4] . "</td>
			</tr>
			<tr>
				<td>" . $general_information[$lang][5] . "</td>
				<td><input type=\"radio\" name=\"blood_group\" ".getData("blood_group", "radio",1) ." tabindex=\"". ($tab++) . "\" value=\"1\" />" . 
$general_information["blood"][0] . "</td>		
				<td><input type=\"radio\" name=\"blood_group\" ".getData("blood_group", "radio",2) ." tabindex=\"". ($tab++) . "\" value=\"2\" />" . 
$general_information["blood"][1] . "</td>		
				<td><input type=\"radio\" name=\"blood_group\" ".getData("blood_group", "radio",4) ." tabindex=\"". ($tab++) . "\" value=\"4\" />" . 
$general_information["blood"][2] . "</td>		
				<td><input type=\"radio\" name=\"blood_group\" ".getData("blood_group", "radio",8) ." tabindex=\"". ($tab++) . "\" value=\"8\" />" . 
$general_information["blood"][3] . "</td>		
				<td><input type=\"radio\" name=\"blood_group\" ".getData("blood_group", "radio",16) ." tabindex=\"". ($tab++) . "\" value=\"16\" />" . 
$general_information["blood"][4] . "</td>		
				<td><input type=\"radio\" name=\"blood_group\" ".getData("blood_group", "radio",32) ." tabindex=\"". ($tab++) . "\" value=\"32\" />" . 
$general_information["blood"][5] . "</td>		
				<td><input type=\"radio\" name=\"blood_group\" ".getData("blood_group", "radio",64) ." tabindex=\"". ($tab++) . "\" value=\"64\" />" . 
$general_information["blood"][6] . "</td>		
				<td><input type=\"radio\" name=\"blood_group\" ".getData("blood_group", "radio",128) ." tabindex=\"". ($tab++) . "\" value=\"128\" />" . 
$general_information["blood"][7] . 
"</td>		
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
