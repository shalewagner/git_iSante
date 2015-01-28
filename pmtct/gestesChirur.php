<?php

echo "
 <div id=\"pane_gestesChirurgicaux\">
  <table class=\"header\">
   <tr>
    <td valign=\"top\" width=\"100%\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\">" . $gests_chir[$lang][0] . "</td>
      </tr>
	  <tr>
	   <td>
		<table width=\"100%\">
			<tr>
				<td><input value=\"1\" type=\"checkbox\" ".getData("myomectomy","checkbox",1)." name=\"myomectomy\" tabindex=\"". ($tab++) . "\"> " . $gests_chir[$lang][1] . "   </td>
				<td>&nbsp;   </td>
				<td><input value=\"1\" type=\"checkbox\" ".getData("perinoplasty","checkbox",1)." name=\"perinoplasty\" tabindex=\"". ($tab++) . "\"> " . $gests_chir[$lang][16] . "   </td>
				<td>&nbsp;   </td>

			</tr>
			<tr>
				<td><input value=\"1\" type=\"checkbox\" ".getData("tubalLigation","checkbox",1)." name=\"tubalLigation\" tabindex=\"". ($tab++) . "\"> " . $gests_chir[$lang][2] . "   </td>
				<td>&nbsp;   </td>
				<td><input value=\"1\" type=\"checkbox\" ".getData("laparotimie","checkbox",1)." name=\"laparotimie\" tabindex=\"". ($tab++) . "\"> " . $gests_chir[$lang][17] . "   </td>
				<td>&nbsp;   </td>

			</tr>
			<tr>
				<td><input value=\"1\" type=\"checkbox\" ".getData("cervCerclage","checkbox",1)." name=\"cervCerclage\" tabindex=\"". ($tab++) . "\"> " .$gests_chir[$lang][3] . "   </td>
				<td>&nbsp;   </td>
				<td><input value=\"1\" type=\"checkbox\" ".getData("bartMarsup","checkbox",1)." name=\"bartMarsup\" tabindex=\"". ($tab++) . "\"> " . $gests_chir[$lang][18] . "   </td>
				<td>&nbsp;   </td>

			</tr>
			<tr>
				<td><input value=\"1\" type=\"checkbox\" ".getData("vagHysterectomy","checkbox",1)." name=\"vagHysterectomy\" tabindex=\"". ($tab++) . "\"> " .$gests_chir[$lang][4] . "   </td>
				<td>&nbsp;   </td>
				<td><input value=\"1\" type=\"checkbox\" ".getData("bartExcision","checkbox",1)." name=\"bartExcision\" tabindex=\"". ($tab++) . "\"> " . $gests_chir[$lang][19] . "   </td>
				<td>&nbsp;   </td>

			</tr>
			<tr>
				<td><input value=\"1\" type=\"checkbox\" ".getData("cystocele","checkbox",1)." name=\"cystocele\" tabindex=\"". ($tab++) . "\" > " .$gests_chir[$lang][5] . "   </td>
				<td>&nbsp;   </td>
				<td><input value=\"1\" type=\"checkbox\" ".getData("conization","checkbox",1)." name=\"conization\" tabindex=\"". ($tab++) . "\"> " . $gests_chir[$lang][20] . "   </td>
				<td>&nbsp;   </td>

			</tr>
			<tr>
				<td><input value=\"1\" type=\"checkbox\" ".getData("rectocele","checkbox",1)." name=\"rectocele\" tabindex=\"". ($tab++) . "\"> " .$gests_chir[$lang][6] . "   </td>
				<td>&nbsp;   </td>
				<td><input value=\"1\" type=\"checkbox\" ".getData("laparascopy","checkbox",1)." name=\"laparascopy\" tabindex=\"". ($tab++) . "\"> " . $gests_chir[$lang][21] . "   </td>
				<td>&nbsp;   </td>

			</tr>
			<tr>
				<td><input value=\"1\" type=\"checkbox\" ".getData("vaginalFistula","checkbox",1)." name=\"vaginalFistula\" tabindex=\"". ($tab++) . "\"> " .$gests_chir[$lang][7] . "   </td>
				<td>&nbsp;   </td>
				<td><input value=\"1\" type=\"checkbox\" ".getData("lumpectomy","checkbox",1)." name=\"lumpectomy\" tabindex=\"". ($tab++) . "\"> " . 
$gests_chir[$lang][22] . "  " .  $gests_chir[$lang][23]. " <input type=\"text\" ".getData("tumorectomyText","text")." name=\"tumorectomyText\" tabindex=\"". ($tab++) . "\"> </td>
				<td>&nbsp;   </td>

			</tr>
			<tr>
				<td><input value=\"1\" type=\"checkbox\" ".getData("cervBiopsy","checkbox",1)." name=\"cervBiopsy\" tabindex=\"". ($tab++) . "\"> " .$gests_chir[$lang][8] . "   </td>
				<td>&nbsp;   </td>
				<td><input value=\"1\" type=\"checkbox\" ".getData("endoBiopsy","checkbox",1)." name=\"endoBiopsy\" tabindex=\"". ($tab++) . "\"> " . $gests_chir[$lang][24] . "   </td>
				<td>&nbsp;   </td>

			</tr>
			<tr>
				<td>" .$gests_chir[$lang][9] . "   </td>
				<td> <input type=\"radio\" value=\"1\" ".getData("transabHyst","radio",1)." value=\"1\"name=\"transabHyst\" id=\"\" tabindex=\"". ($tab++) . "\" /> " .$gests_chir[$lang][25] . " </td>
				<td> <input type=\"radio\" value=\"2\" ".getData("transabHyst","radio",2)." value=\"2\" name=\"transabHyst\" id=\"\" tabindex=\"". ($tab++) . "\" /> " .$gests_chir[$lang][26] . " </td>
	
			</tr>
			<tr>
				<td>" .$gests_chir[$lang][10] . "   </td>
				<td> <input type=\"radio\" value=\"1\" ".getData("tAbdomHyst","radio",1)." name=\"tAbdomHyst\" id=\"\" tabindex=\"". ($tab++) . "\"/> " .$gests_chir[$lang][27] . " </td>
				<td> <input type=\"radio\" value=\"2\" ".getData("tAbdomHyst","radio",2)." name=\"tAbdomHyst\" id=\"\" tabindex=\"". ($tab++) . "\" /> " 
.$gests_chir[$lang][31] . " </td>

			</tr>
			<tr>
				<td>" .$gests_chir[$lang][11] . "   </td>
				<td> <input type=\"radio\" value=\"1\" ".getData("annexectomie","radio",1)." name=\"annexectomie\" id=\"\" tabindex=\"". ($tab++) . "\" /> " .$gests_chir[$lang][28] . " </td>
				<td class=\"inlineblock\"> <input type=\"radio\" value=\"2\" ".getData("annexectomie","radio",2)." 
name=\"annexectomie\" id=\"\" tabindex=\"". ($tab++) . "\" /> " .$gests_chir[$lang][29] . " </td>
				<td class=\"inlineblock\"> <input type=\"radio\" value=\"4\" ".getData("annexectomie","radio",4)." name=\"annexectomie\" id=\"\" tabindex=\"". ($tab++) . "\" /> " .$gests_chir[$lang][30] . " </td>

			</tr>
			<tr>
				<td>" .$gests_chir[$lang][12] . "   </td>
				<td> <input type=\"radio\" value=\"1\" ".getData("ovarectomie","radio",1)." name=\"ovarectomie\" id=\"\" tabindex=\"". ($tab++) . "\" /> " .$gests_chir[$lang][28] . " </td>
				<td class=\"inlineblock\"> <input type=\"radio\" value=\"2\" ".getData("ovarectomie","radio",2)." 
name=\"ovarectomie\" id=\"\" tabindex=\"". ($tab++) . "\" /> " .$gests_chir[$lang][29] . " </td>
				<td class=\"inlineblock\"> <input type=\"radio\" value=\"4\" ".getData("ovarectomie","radio",4)." name=\"ovarectomie\" id=\"\" tabindex=\"". ($tab++) . "\" /> " .$gests_chir[$lang][30] . " </td>
			</tr>
			<tr>
				<td>" .$gests_chir[$lang][13] . "   </td>
				<td> <input type=\"radio\" value=\"1\" ".getData("salping","radio",1)." name=\"salping\" id=\"\" tabindex=\"". ($tab++) . "\" /> " .$gests_chir[$lang][28] . " </td>
				<td class=\"inlineblock\"> <input type=\"radio\" value=\"2\"  ".getData("salping","radio",2)." name=\"salping\" 
id=\"\" tabindex=\"". ($tab++) . "\" /> " .$gests_chir[$lang][29] . " </td>
				<td class=\"inlineblock\"> <input type=\"radio\" value=\"4\" ".getData("salping","radio",4)." name=\"salping\" id=\"\" tabindex=\"". ($tab++) . "\" /> " .$gests_chir[$lang][30] . " </td>
			</tr>
			<tr>
				<td>" .$gests_chir[$lang][14] . "   </td>
				<td> <input type=\"radio\" value=\"1\" ".getData("mastectomie","radio",1)." name=\"mastectomie\" id=\"\" tabindex=\"". ($tab++) . "\" /> " .$gests_chir[$lang][28] . " </td>
				<td class=\"inlineblock\"> <input type=\"radio\" value=\"2\" ".getData("mastectomie","radio",2)." 
name=\"mastectomie\" id=\"\" tabindex=\"". ($tab++) . "\" /> " .$gests_chir[$lang][29] . " </td>
				<td class=\"inlineblock\"> <input type=\"radio\" value=\"4\" ".getData("mastectomie","radio",4)." name=\"mastectomie\" id=\"\" tabindex=\"". ($tab++) . "\" /> " .$gests_chir[$lang][30] . " </td>
			</tr>
		</table>
	   </td>
	  </tr>
	  <tr>
	   <td class=\"bottom_line\">&nbsp;</td>
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
