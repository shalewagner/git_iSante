<?php

echo "
 <div id=\"pane_habits\">
  <table class=\"header\">
   <tr>
    <td valign=\"top\" width=\"100%\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\">" . $practices[$lang][0] . "</td>
      </tr>
	  <tr>
	   <td>
		<table width=\"100%\">
			<tr>
				<td>
					<table width=\"100%\">
						<tr>
							<td>" . $practices[$lang][1] . "</td>
							<td><input type=\"radio\"  ".getData("addic_alcohol", "radio",1) ." name=\"addic_alcohol\" tabindex=\"". ($tab++) . "\" 
value=\"1\" />" . $generalOption[$lang][0] . 
"</td>		
							<td><input type=\"radio\" ".getData("addic_alcohol", "radio",2) ." name=\"addic_alcohol\" tabindex=\"". ($tab++) . "\" 
value=\"2\" />" . $generalOption[$lang][1] . 
"</td>		
						</tr>
					</table>
				</td>

				<td>
					<table width=\"100%\">
						<tr>
							<td>" . $practices[$lang][2] . "</td>
							<td><input type=\"radio\" ".getData("addic_smoking", "radio",1) ." name=\"addic_smoking\" tabindex=\"". ($tab++) . "\" 
value=\"1\" />" . $generalOption[$lang][0] . 
"</td>		
							<td><input type=\"radio\" ".getData("addic_smoking", "radio",2) ." name=\"addic_smoking\" tabindex=\"". ($tab++) . "\" 
value=\"2\" />" . $generalOption[$lang][1] . 
"</td>		
						</tr>
					</table>
				</td>

				<td>
					<table width=\"100%\">
						<tr>
							<td>" . $practices[$lang][3] . "</td>
							<td><input type=\"radio\" name=\"addic_drugs\" ".getData("addic_drugs", "radio",1) ." tabindex=\"". ($tab++) . "\" 
value=\"1\" />" . $generalOption[$lang][0] . 
"</td>		
							<td><input type=\"radio\" name=\"addic_drugs\" ".getData("addic_drugs", "radio",2) ." tabindex=\"". ($tab++) . "\" 
value=\"2\" />" . $generalOption[$lang][1] . 
"</td>		
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
    <td>&nbsp;</td>
   </tr>
  </table>
 </div>";


?>
