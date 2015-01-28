<?php

/*SYMPTOM SECTION*/
echo "
 <div id=\"pane_symptom\">
  <table class=\"header\">
   <tr>
    <td valign=\"top\" width=\"100%\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\">" . $symptoms_obgyn[$lang][0] . "</td>
      </tr>
	  <tr>
	   <td>
		<table width=\"100%\">
		  <tr>
			<th>" . $symptoms_obgyn[$lang][1] . "</th>
			<th>" . $symptoms_obgyn[$lang][1] . "</th>
		  </tr>
		  <tr>
			<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("vaginalBleeding","checkbox",1)." value=\"1\" name=\"vaginalBleeding\" />" . $symptoms_obgyn[$lang][2] . "  </td>
			<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("feverMore15Days","checkbox",1)." name=\"feverMore15Days\" value=\"1\" />" . $symptoms_obgyn[$lang][24] . "  </td>
		  </tr>

		  <tr>
			<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("leucorhee","checkbox",1)." name=\"leucorhee\" value=\"1\" />" . $symptoms_obgyn[$lang][4] . "  </td>
			<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("epigasPain","checkbox",1)." value=\"1\" name=\"epigasPain\" />" . $symptoms_obgyn[$lang][3] . "  </td>

		  </tr>

		  <tr>
			<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("dysurie","checkbox",1)." name=\"dysurie\" value=\"1\" />" . $symptoms_obgyn[$lang][6] . "  </td>
			<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("abdomPain","checkbox",1)." name=\"abdomPain\" value=\"1\" />" . $symptoms_obgyn[$lang][5] . "  </td>
		  </tr>

		  <tr>
			<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("profuseSweating","checkbox",1)." name=\"profuseSweating\" value=\"1\" />" . $symptoms_obgyn[$lang][8] . "  </td>
			<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("vomiting","checkbox",1)." name=\"vomiting\" value=\"On\" />" . $symptoms_obgyn[$lang][7] . "  </td>
		  </tr>

		  <tr>
			<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("cephalgia","checkbox",1)." name=\"cephalgia\" value=\"1\" />" . $symptoms_obgyn[$lang][10] . "  </td>
			<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("coughLess15days","checkbox",1)." name=\"coughLess15days\" value=\"1\" />" . $symptoms_obgyn[$lang][9] . "  </td>
		  </tr>

		  <tr>
			<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("eyeTrouble","checkbox",1)." name=\"eyeTrouble\" value=\"1\" />" . $symptoms_obgyn[$lang][12] . "  </td>
			<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("coughMore15Days","checkbox",1)."  name=\"coughMore15Days\" value=\"1\" />" . $symptoms_obgyn[$lang][11] . "  </td>
		  </tr>

		  <tr>
			<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("menorrhagia","checkbox",1)." name=\"menorrhagia\" value=\"1\" />" . $symptoms_obgyn[$lang][14] . "  </td>
			<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("shiverFever","checkbox",1)." name=\"shiverFever\" value=\"1\" />" . $symptoms_obgyn[$lang][13] . "  </td>
		  </tr>

		  <tr>
			<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("hypomenorrhee","checkbox",1)." name=\"hypomenorrhee\" value=\"1\" />" . $symptoms_obgyn[$lang][16] . "  </td>
			<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("vaginaLiquid","checkbox",1)." name=\"vaginaLiquid\" value=\"1\" />" . $symptoms_obgyn[$lang][15] . "  </td>
		  </tr>

		  <tr>
			<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("metrorragie","checkbox",1)." name=\"metrorragie\" value=\"1\" />" . $symptoms_obgyn[$lang][26] . "  </td>
			<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("foetalMovementChange","checkbox",1)." name=\"foetalMovementChange\" value=\"1\" />" . $symptoms_obgyn[$lang][17] . "  </td>
		  </tr>

	
		  <tr>
			<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("hypermenorrhee","checkbox",1)." name=\"hypermenorrhee\" value=\"1\" />" . $symptoms_obgyn[$lang][18] . "  </td>
			<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("diarrhea","checkbox",1)." name=\"diarrhea\" value=\"1\" />" . $symptoms_obgyn[$lang][21] . "  </td>
		  </tr>

		  <tr>
			<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("menorrheeOligo","checkbox",1)." name=\"menorrheeOligo\" value=\"1\" />" . $symptoms_obgyn[$lang][20] . "  </td>
			<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("convulsions","checkbox",1)." name=\"convulsions\" value=\"1\" />" . $symptoms_obgyn[$lang][23] . "  </td>
		  </tr>

		  <tr>

			<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("polymenorrhee","checkbox",1)." name=\"polymenorrhee\" value=\"1\" />" . $symptoms_obgyn[$lang][19] . "  </td>
			<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("sympOther","checkbox",1)." name=\"sympOther\" value=\"On\" />" . $symptoms_obgyn[$lang][25] . "  <input type=\"text\" tabindex=\"". ($tab++) . "\" name=\"symptomSpecify\" ".getdata("symptomSpecify","text")." /></td>
		  </tr>
		  <tr>
			<td><input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("feverLess15Days","checkbox",1)." name=\"feverLess15Days\" value=\"1\" />" . $symptoms_obgyn[$lang][22] . "  </td>
		  </tr>

		  <tr>


		  </tr>

			</table>
	   </td>
	  </tr>
	  <tr>
	   <td valign=\"bottom\">
		<table width=\"100%\">
		</table>
	   </td>
	  </tr>
	  <tr>
	   <td class=\"bottom_line\">&nbsp;</td>
	  </tr>
	  <tr>
	   <td>
		".$symptom_comments[$lang][0]. " <input type=\"text\" maxlength=\"255\" size=\"40\" id=\"otherSymptoms\" tabindex=\"". ($tab++) . "\" name=\"otherSymptoms\" ".getData("otherSymptoms","text")." />
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
