<?php
echo "
   <table class=\"header\" border=\"0\" width=\"100%\">
    <tr>
     <td colspan=\"6\">&nbsp;</td>
    </tr>
    <tr>
     <td class=\"s_header\" colspan=\"6\">&nbsp;</td>
    </tr>
    <tr>
     <td colspan=\"6\"><i>" . $pedLaboratory[$lang][9] . "</i></td>
    </tr>
    <tr>
     <td colspan=\"6\">&nbsp;</td>
    </tr>
    <tr>
     <td rowspan=\"2\" valign=\"top\"><b>" . $pedLaboratory[$lang][10] . "</b></td>
     <td valign=\"top\"><table><tr><td id=\"frottisvaginalTestResultTitle\"></td><td><input tabindex=\"" . ($tabIndex + 1) . "\" id=\"frottisvaginalTestResult1\" name=\"frottisvaginalTestResult[]\" " . getData ("frottisvaginalTestResult", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $pedLaboratory[$lang][11] . " <input tabindex=\"" . ($tabIndex + 2) . "\" id=\"frottisvaginalTestResult2\" name=\"frottisvaginalTestResult[]\" " . getData ("frottisvaginalTestResult", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $pedLaboratory[$lang][12] . "</td></tr></table></td>
     <td rowspan=\"2\" class=\"vert_line\">&nbsp;</td>
     <td rowspan=\"2\" class=\"left_pad\">&nbsp;</td>
     <td rowspan=\"2\" valign=\"top\"><b>" . $pedLaboratory[$lang][14] . "</b></td>
     <td valign=\"top\"><table><tr><td id=\"gouttePendanteTestResultTitle\"></td><td><input tabindex=\"" . ($tabIndex + 19) . "\" id=\"gouttePendanteTestResult1\" name=\"gouttePendanteTestResult[]\" " . getData ("gouttePendanteTestResult", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $pedLaboratory[$lang][11] . " <input tabindex=\"" . ($tabIndex + 20) . "\" id=\"gouttePendanteTestResult2\" name=\"gouttePendanteTestResult[]\" " . getData ("gouttePendanteTestResult", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $pedLaboratory[$lang][12] . "</td></tr></table></td>
    </tr>
    <tr>
     <td valign=\"top\">
      <table>
       <tr><td width=\"5%\" id=\"frottisvaginalTestDtTitle\" ></td>
           <td><input tabindex=\"" . ($tabIndex + 3) . "\" id=\"frottisvaginalTestDt\" name=\"frottisvaginalTestDt\"
	 		 value=\"" . getData ("frottisvaginalTestDd", "textarea") . "/". getData ("frottisvaginalTestMm", "textarea") ."/". getData ("frottisvaginalTestYy", "textarea") . "\"
	       	 type=\"text\" size=\"8\" maxlength=\"8\">
	           <input id=\"frottisvaginalTestDd\"  name=\"frottisvaginalTestDd\" " .
	           getData ("frottisvaginalTestDd", "text") . " type=\"hidden\">
	           <input tabindex=\"" . ($tabIndex + 4) . "\"
	           id=\"frottisvaginalTestMm\"  name=\"frottisvaginalTestMm\" " .
	           getData ("frottisvaginalTestMm", "text") .
	           " type=\"hidden\">
	           <input tabindex=\"" . ($tabIndex + 5) . "\"
	           id=\"frottisvaginalTestYy\" name=\"frottisvaginalTestYy\" " .
	           getData ("frottisvaginalTestYy", "text") .
	           " type=\"hidden\"></td>
	       <td><i>" . $jma[$lang][1] . "</i>
	     </td></tr>
	   </table>
      </td>
     <td valign=\"top\">
      <table>
       <tr><td width=\"5%\" id=\"gouttePendanteTestDtTitle\" ></td>
           <td><input tabindex=\"" . ($tabIndex + 21) . "\" id=\"gouttePendanteTestDt\" name=\"gouttePendanteTestDt\"
	 		 value=\"" . getData ("gouttePendanteTestDd", "textarea") . "/". getData ("gouttePendanteTestMm", "textarea") ."/". getData ("gouttePendanteTestYy", "textarea") . "\"
	       	 type=\"text\" size=\"8\" maxlength=\"8\">
	           <input id=\"gouttePendanteTestDd\"  name=\"gouttePendanteTestDd\" " .
	           getData ("gouttePendanteTestDd", "text") . " type=\"hidden\">
	           <input tabindex=\"" . ($tabIndex + 22) . "\"
	           id=\"gouttePendanteTestMm\"  name=\"gouttePendanteTestMm\" " .
	           getData ("gouttePendanteTestMm", "text") .
	           " type=\"hidden\">
	           <input tabindex=\"" . ($tabIndex + 23) . "\"
	           id=\"gouttePendanteTestYy\" name=\"gouttePendanteTestYy\" " .
	           getData ("gouttePendanteTestYy", "text") .
	           " type=\"hidden\"></td>
	       <td><i>" . $jma[$lang][1] . "</i>
	     </td></tr>
	   </table>
     </td>
    </tr>
    <tr>
     <td class=\"bottom_line\" valign=\"top\">" . $pedLaboratory[$lang][13] . "</td>
     <td class=\"bottom_line\" valign=\"top\"><textarea tabindex=\"" . ($tabIndex + 6) . "\" id=\"frottisvaginalTestRemarks\" name=\"frottisvaginalTestRemarks\" rows=\"2\" cols=\"40\">" . getData ("frottisvaginalTestRemarks", "textarea") . "</textarea></td>
     <td class=\"bottom_line vert_line\">&nbsp;</td>
     <td class=\"bottom_line left_pad\">&nbsp;</td>
     <td class=\"bottom_line\" valign=\"top\">" . $pedLaboratory[$lang][13] . "</td>
     <td class=\"bottom_line\" valign=\"top\"><textarea tabindex=\"" . ($tabIndex + 24) . "\" id=\"gouttePendanteTestRemarks\" name=\"gouttePendanteTestRemarks\" rows=\"2\" cols=\"40\">" . getData ("gouttePendanteTestRemarks", "textarea") . "</textarea></td>
    </tr>
    <tr>
     <td rowspan=\"2\" valign=\"top\"><b>" . $pedLaboratory[$lang][15] . "</b></td>
     <td valign=\"top\"><table><tr><td id=\"urineTestResultTitle\"></td><td> <input tabindex=\"" . ($tabIndex + 7) . "\" id=\"urineTestResult1\" name=\"urineTestResult[]\" " . getData ("urineTestResult", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $pedLaboratory[$lang][11] . " <input tabindex=\"" . ($tabIndex + 8) . "\" id=\"urineTestResult2\" name=\"urineTestResult[]\" " . getData ("urineTestResult", "checkbox", 2) . " type=\"radio\"  value=\"2\"> " . $pedLaboratory[$lang][12] . "</td></tr></table>
     <td rowspan=\"2\" class=\"vert_line\">&nbsp;</td>
     <td rowspan=\"2\" class=\"left_pad\">&nbsp;</td>
     <td rowspan=\"2\" valign=\"top\"><b>" . $pedLaboratory[$lang][16] . "</b></td>
     <td valign=\"top\"><table><tr><td id=\"papTestTestResultTitle\"></td><td><input tabindex=\"" . ($tabIndex + 25) . "\" id=\"papTestTestResult1\" name=\"papTestTestResult[]\" " . getData ("papTestTestResult", "checkbox", 1) . " type=\"radio\"  value=\"1\"> " . $pedLaboratory[$lang][11] . " <input tabindex=\"" . ($tabIndex + 26) . "\" id=\"papTestTestResult2\" name=\"papTestTestResult[]\" " . getData ("papTestTestResult", "checkbox", 2) . " type=\"radio\"  value=\"2\"> " . $pedLaboratory[$lang][12] . "<br><input tabindex=\"" . ($tabIndex + 27) . "\" id=\"papTestTestResult3\" name=\"papTestTestResult[]\" " . getData ("papTestTestResult", "checkbox", 4) . " type=\"radio\"  value=\"4\"> " . $pedLaboratory[$lang][17] . " <input tabindex=\"" . ($tabIndex + 28) . "\" id=\"papTestTestResult4\" name=\"papTestTestResult[]\" " . getData ("papTestTestResult", "checkbox", 8) . " type=\"radio\"  value=\"8\"> " . $pedLaboratory[$lang][18] . "<br><input tabindex=\"" . ($tabIndex + 29) . "\" id=\"papTestTestResult5\" name=\"papTestTestResult[]\" " . getData ("papTestTestResult", "checkbox", 16) . " type=\"radio\"  value=\"16\"> " . $pedLaboratory[$lang][19] . "</td></tr></table></td>
    </tr>
    <tr>
     <td valign=\"top\">
     <table>
       <tr><td width=\"5%\" id=\"urineTestDtTitle\" ></td>
           <td><input tabindex=\"" . ($tabIndex + 9) . "\" id=\"urineTestDt\" name=\"urineTestDt\"
	 		 value=\"" . getData ("urineTestDd", "textarea") . "/". getData ("urineTestMm", "textarea") ."/". getData ("urineTestYy", "textarea") . "\"
	       	 type=\"text\" size=\"8\" maxlength=\"8\">
	           <input id=\"urineTestDd\"  name=\"urineTestDd\" " .
	           getData ("urineTestDd", "text") . " type=\"hidden\">
	           <input tabindex=\"" . ($tabIndex + 10) . "\"
	           id=\"urineTestMm\"  name=\"urineTestMm\" " .
	           getData ("urineTestMm", "text") .
	           " type=\"hidden\">
	           <input tabindex=\"" . ($tabIndex + 11) . "\"
	           id=\"urineTestYy\" name=\"urineTestYy\" " .
	           getData ("urineTestYy", "text") .
	           " type=\"hidden\"></td>
	       <td><i>" . $jma[$lang][1] . "</i>
	     </td></tr>
	   </table>
     </td>
     <td valign=\"top\">
     <table>
       <tr><td width=\"5%\" id=\"papTestTestDtTitle\" ></td>
           <td><input tabindex=\"" . ($tabIndex + 30) . "\" id=\"papTestTestDt\" name=\"papTestTestDt\"
	 		 value=\"" . getData ("papTestTestDd", "textarea") . "/". getData ("papTestTestMm", "textarea") . "/" . getData ("papTestTestYy", "textarea") . "\"
	       	 type=\"text\" size=\"8\" maxlength=\"8\">
	           <input tabindex=\"" . ($tabIndex + 31) . "\"
                   id=\"papTestTestDd\"  name=\"papTestTestDd\" " .
	           getData ("papTestTestDd", "text") . " type=\"hidden\">
	           <input tabindex=\"" . ($tabIndex + 32) . "\"
	           id=\"papTestTestMm\"  name=\"papTestTestMm\" " .
	           getData ("papTestTestMm", "text") .
	           " type=\"hidden\">
	           <input tabindex=\"" . ($tabIndex + 33) . "\"
	           id=\"papTestTestYy\" name=\"papTestTestYy\" " .
	           getData ("papTestTestYy", "text") .
	           " type=\"hidden\"></td>
	       <td><i>" . $jma[$lang][1] . "</i>
	     </td></tr>
	   </table>
     </td>
    </tr>
    <tr>
     <td class=\"bottom_line\" valign=\"top\">" . $pedLaboratory[$lang][13] . "</td>
     <td class=\"bottom_line\" valign=\"top\"><textarea tabindex=\"" . ($tabIndex + 12) . "\" id=\"urineTestRemarks\"  name=\"urineTestRemarks\" rows=\"2\" cols=\"40\">" . getData ("urineTestRemarks", "textarea") . "</textarea></td>
     <td class=\"bottom_line vert_line\">&nbsp;</td>
     <td class=\"bottom_line left_pad\">&nbsp;</td>
     <td class=\"bottom_line\" valign=\"top\">" . $pedLaboratory[$lang][13] . "</td>
     <td class=\"bottom_line\" valign=\"top\"><textarea tabindex=\"" . ($tabIndex + 34) . "\" id=\"papTestTestRemarks\" name=\"papTestTestRemarks\" rows=\"2\" cols=\"40\">" . getData ("papTestTestRemarks", "textarea") . "</textarea></td>
    </tr>
    <tr>
     <td rowspan=\"2\" valign=\"top\"><b>" . $pedLaboratory[$lang][20] . "</b></td>
     <td valign=\"top\"><table><tr><td  id=\"chestXrayTestResultTitle\"></td><td><input tabindex=\"" . ($tabIndex + 13) . "\" id=\"chestXrayTestResult1\" name=\"chestXrayTestResult[]\" " . getData ("chestXrayTestResult", "checkbox", 1) . " type=\"radio\"  value=\"1\"> " . $pedLaboratory[$lang][11] . " <input tabindex=\"" . ($tabIndex + 14) . "\" id=\"chestXrayTestResult2\" name=\"chestXrayTestResult[]\" " . getData ("chestXrayTestResult", "checkbox", 2) . " type=\"radio\"  value=\"2\"> " . $pedLaboratory[$lang][12] . "</td></tr></table></td>
     <td rowspan=\"2\" class=\"vert_line\">&nbsp;</td>
     <td rowspan=\"2\" class=\"left_pad\">&nbsp;</td>
     <td rowspan=\"2\" valign=\"top\"><b>" . $pedLaboratory[$lang][21] . " <i>" . $pedLaboratory[$lang][22] . "</i></b></td>
     <td valign=\"top\"><table><tr><td  id=\"otherImagesTestResultTitle\"></td><td><input tabindex=\"" . ($tabIndex + 35) . "\" id=\"otherImagesTestResult1\" name=\"otherImagesTestResult[]\" " . getData ("otherImagesTestResult", "checkbox", 1) . " type=\"radio\"  value=\"1\"> " . $pedLaboratory[$lang][11] . " <input tabindex=\"" . ($tabIndex + 36) . "\" id=\"otherImagesTestResult2\" name=\"otherImagesTestResult[]\" " . getData ("otherImagesTestResult", "checkbox", 2) . " type=\"radio\"  value=\"2\"> " . $pedLaboratory[$lang][12] . "</td></tr></table></td>
    </tr>
    <tr>
     <td valign=\"top\">
      <table>
       <tr><td width=\"5%\" id=\"chestXrayTestDtTitle\" ></td>
           <td><input tabindex=\"" . ($tabIndex + 15) . "\" id=\"chestXrayTestDt\" name=\"chestXrayTestDt\"
	 		 value=\"" . getData ("chestXrayTestDd", "textarea") . "/". getData ("chestXrayTestMm", "textarea") ."/". getData ("chestXrayTestYy", "textarea") . "\"
	       	 type=\"text\" size=\"8\" maxlength=\"8\">
	           <input id=\"chestXrayTestDd\"  name=\"chestXrayTestDd\" " .
	           getData ("chestXrayTestDd", "text") . " type=\"hidden\">
	           <input tabindex=\"" . ($tabIndex + 16) . "\"
	           id=\"chestXrayTestMm\"  name=\"chestXrayTestMm\" " .
	           getData ("chestXrayTestMm", "text") .
	           " type=\"hidden\">
	           <input tabindex=\"" . ($tabIndex + 17) . "\"
	           id=\"chestXrayTestYy\" name=\"chestXrayTestYy\" " .
	           getData ("chestXrayTestYy", "text") .
	           " type=\"hidden\"></td>
	       <td><i>" . $jma[$lang][1] . "</i>
	     </td></tr>
	   </table>
     </td>
     <td valign=\"top\">
      <table>
       <tr><td width=\"5%\" id=\"otherImagesTestDtTitle\" ></td>
           <td><input tabindex=\"" . ($tabIndex + 37) . "\" id=\"otherImagesTestDt\" name=\"otherImagesTestDt\"
	 		 value=\"" . getData ("otherImagesTestDd", "textarea") . "/". getData ("otherImagesTestMm", "textarea") ."/". getData ("otherImagesTestYy", "textarea") . "\"
	       	 type=\"text\" size=\"8\" maxlength=\"8\">
	           <input id=\"otherImagesTestDd\"  name=\"otherImagesTestDd\" " .
	           getData ("otherImagesTestDd", "text") . " type=\"hidden\">
	           <input tabindex=\"" . ($tabIndex + 38) . "\"
	           id=\"otherImagesTestMm\"  name=\"otherImagesTestMm\" " .
	           getData ("otherImagesTestMm", "text") .
	           " type=\"hidden\">
	           <input tabindex=\"" . ($tabIndex + 39) . "\"
	           id=\"otherImagesTestYy\" name=\"otherImagesTestYy\" " .
	           getData ("otherImagesTestYy", "text") .
	           " type=\"hidden\"></td>
	       <td><i>" . $jma[$lang][1] . "</i>
	     </td></tr>
	   </table>
     </td>
    </tr>
    <tr>
     <td rowspan=\"4\" valign=\"top\">" . $pedLaboratory[$lang][13] . "</td>
     <td rowspan=\"4\" valign=\"top\"><textarea tabindex=\"" . ($tabIndex + 18) . "\" id=\"chestXrayTestRemarks\" name=\"chestXrayTestRemarks\" rows=\"10\" cols=\"40\">" . getData ("chestXrayTestRemarks", "textarea") . "</textarea></td>
     <td class=\"vert_line\">&nbsp;</td>
     <td class=\"bottom_line left_pad\">&nbsp;</td>
     <td class=\"bottom_line\" valign=\"top\">" . $pedLaboratory[$lang][13] . "</td>
     <td class=\"bottom_line\" valign=\"top\"><textarea tabindex=\"" . ($tabIndex + 40) . "\" id=\"otherImagesTestRemarks\" name=\"otherImagesTestRemarks\" rows=\"2\" cols=\"40\">" . getData ("otherImagesTestRemarks", "textarea") . "</textarea></td>
    </tr>
    <tr>
     <td rowspan=\"2\" class=\"vert_line\">&nbsp;</td>
     <td rowspan=\"2\" class=\"left_pad\">&nbsp;</td>
     <td rowspan=\"2\" valign=\"top\"><b>" . $pedLaboratory[$lang][23] . "</b></td>
     <td valign=\"top\"><table><tr><td id=\"stoolTestResultTitle\"></td><td><input tabindex=\"" . ($tabIndex + 41) . "\" id=\"stoolTestResult1\" name=\"stoolTestResult[]\" " . getData ("stoolTestResult", "checkbox", 1) . " type=\"radio\"  value=\"1\"> " . $pedLaboratory[$lang][11] . " <input tabindex=\"" . ($tabIndex + 42) . "\" id=\"stoolTestResult2\" name=\"stoolTestResult[]\" " . getData ("stoolTestResult", "checkbox", 2) . " type=\"radio\"  value=\"2\"> " . $pedLaboratory[$lang][12] . "</td></tr></table></td>
    </tr>
    <tr>
     <td valign=\"top\">
      <table>
       <tr><td width=\"5%\" id=\"stoolTestDtTitle\" ></td>
           <td><input tabindex=\"" . ($tabIndex + 43) . "\" id=\"stoolTestDt\" name=\"stoolTestDt\"
	 		 value=\"" . getData ("stoolTestDd", "textarea") . "/". getData ("stoolTestMm", "textarea") ."/". getData ("stoolTestYy", "textarea") . "\"
	       	 type=\"text\" size=\"8\" maxlength=\"8\">
	           <input id=\"stoolTestDd\"  name=\"stoolTestDd\" " .
	           getData ("stoolTestDd", "text") . " type=\"hidden\">
	           <input tabindex=\"" . ($tabIndex + 44) . "\"
	           id=\"stoolTestMm\"  name=\"stoolTestMm\" " .
	           getData ("stoolTestMm", "text") .
	           " type=\"hidden\">
	           <input tabindex=\"" . ($tabIndex + 45) . "\"
	           id=\"stoolTestYy\" name=\"stoolTestYy\" " .
	           getData ("stoolTestYy", "text") .
	           " type=\"hidden\"></td>
	       <td><i>" . $jma[$lang][1] . "</i>
	     </td></tr>
	   </table>
     </td>
    </tr>
    <tr>
     <td class=\"vert_line\">&nbsp;</td>
     <td class=\"left_pad\">&nbsp;</td>
     <td valign=\"top\">" . $pedLaboratory[$lang][13] . "</td>
     <td valign=\"top\"><textarea tabindex=\"" . ($tabIndex + 46) . "\" id=\"stoolTestRemarks\" name=\"stoolTestRemarks\" rows=\"2\" cols=\"40\">" . getData ("stoolTestRemarks", "textarea") . "</textarea></td>
    </tr>
   </table>
";
echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"laboratory/pedlaboratory.js\"></script>";
?>
