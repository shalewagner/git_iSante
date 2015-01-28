<?php
  $labData = lookupLabs ($version, "'stool','chestXray', 'urine','otherXray'");

 $labMatrixData = "
   <table class=\"header\" border=\"0\">
    <tr>
     <td class=\"bottom_line\" colspan=\"5\">&nbsp;</td>
    </tr>
    <tr>
     <td width=\"20%\">
      <table>
       <tr>
	    <td id=\"stoolTest[]Title\" width=\"1%\"></td>
        <td><input tabindex=\"" . $tabIndex . "\" id=\"stoolTest[]\" name=\"stoolTest[]\" " . getData ("stoolTest", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $labData['stool']['testName' . init_upper ($lang)] . "</td>
       </tr>
       <tr>
	    <td id=\"stoolTestResultTitle\" width=\"1%\"></td>
        <td><span><input tabindex=\"" . ($tabIndex + 1) . "\" id=\"stoolTestResult1\" name=\"stoolTestResult[]\" " . getData ("stoolTestResult", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $labData['stool']['resultLabel' . init_upper ($lang) . "1"] . "</span></td>
       </tr>
       <tr>
	    <td></td>
        <td><span><input tabindex=\"" . ($tabIndex + 2) . "\" id=\"stoolTestResult2\" name=\"stoolTestResult[]\" " . getData ("stoolTestResult", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $labData['stool']['resultLabel' . init_upper ($lang) . "2"] . "</span></td>
       </tr>
      </table>
     </td>
     <td valign=\"center\" width=\"30%\">
      <table>
       <tr>
        <td id=\"stoolTestDtTitle\">
        </td>
        <td>
         <input tabindex=\"" . ($tabIndex + 3) . "\" id=\"stoolTestDt\" name=\"stoolTestDt\" value=\"" . getData ("stoolTestDd", "textarea") . "/". getData ("stoolTestMm", "textarea") ."/". getData ("stoolTestYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
         <input 									 id=\"stoolTestDd\" name=\"stoolTestDd\" " . getData ("stoolTestDd", "text") . " type=\"hidden\">
         <input tabindex=\"" . ($tabIndex + 4) . "\" id=\"stoolTestMm\" name=\"stoolTestMm\" " . getData ("stoolTestMm", "text") . " type=\"hidden\">
         <input tabindex=\"" . ($tabIndex + 5) . "\" id=\"stoolTestYy\" name=\"stoolTestYy\" " . getData ("stoolTestYy", "text") . " type=\"hidden\">
        </td>
        <td>
         <i>" . $GLOBALS['labs_resultDate'][$lang][2] . "</i>
        </td>
       </tr>
      </table>
     </td>
     <td class=\"vert_line\" rowspan=\"5\" width=\"1%\">&nbsp;</td>
     <td class=\"left_pad\" width=\"20%\">
      <table>
       <tr>
	    <td id=\"chestXrayTest[]Title\" width=\"1%\"></td>
        <td><input tabindex=\"" . ($tabIndex + 15) . "\" id=\"chestXrayTest[]\" name=\"chestXrayTest[]\" " . getData ("chestXrayTest", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $labData['chestXray']['testName' . init_upper ($lang)] . "</td>
       </tr>
       <tr>
	    <td id=\"chestXrayTestResultTitle\" width=\"1%\"></td>
        <td><span><input tabindex=\"" . ($tabIndex + 16) . "\" id=\"chestXrayTestResult1\" name=\"chestXrayTestResult[]\" " . getData ("chestXrayTestResult", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $labData['chestXray']['resultLabel' . init_upper ($lang) . "1"] . "</span></td>
       </tr>
       <tr>
	    <td></td>
        <td><span><input tabindex=\"" . ($tabIndex + 17) . "\" id=\"chestXrayTestResult2\" name=\"chestXrayTestResult[]\" " . getData ("chestXrayTestResult", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $labData['chestXray']['resultLabel' . init_upper ($lang) . "2"] . "</span></td>
       </tr>
      </table>
     </td>
     <td  valign=\"center\" width=\"29%\">
      <table>
       <tr>
        <td id=\"chestXrayTestDtTitle\">
        </td>
        <td>
         <input tabindex=\"" . ($tabIndex + 18) . "\" id=\"chestXrayTestDt\" name=\"chestXrayTestDt\" value=\"" . getData ("chestXrayTestDd", "textarea") . "/". getData ("chestXrayTestMm", "textarea") ."/". getData ("chestXrayTestYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
         <input 									  id=\"chestXrayTestDd\" name=\"chestXrayTestDd\" " . getData ("chestXrayTestDd", "text") . " type=\"hidden\">
         <input tabindex=\"" . ($tabIndex + 19) . "\" id=\"chestXrayTestMm\" name=\"chestXrayTestMm\" " . getData ("chestXrayTestMm", "text") . " type=\"hidden\">
         <input tabindex=\"" . ($tabIndex + 20) . "\" id=\"chestXrayTestYy\" name=\"chestXrayTestYy\" " . getData ("chestXrayTestYy", "text") . " type=\"hidden\">
        </td>
        <td>
         <i>" . $GLOBALS['labs_resultDate'][$lang][2] . "</i>
        </td>
       </tr>
      </table>
     </td>
    </tr>
    <tr>
     <td colspan=\"2\" width=\"50%\">
       <table class=\"b_header_nb_nw\">
         <tr>
         <td valign=\"top\" class=\"left_pad\">" . $GLOBALS['labs_results'][$lang][1] . "</td>
         <td><textarea tabindex=\"" . ($tabIndex + 7) . "\" id=\"stoolTestRemarks\" name=\"stoolTestRemarks\" rows=\"2\" cols=\"55\">" . getData ("stoolTestRemarks", "textarea") . "</textarea>
         </td>
         </tr>
       </table>
     </td>
     <td colspan=\"2\" width=\"49%\">
       <table class=\"b_header_nb_nw\">
         <tr>
         <td valign=\"top\" class=\"left_pad\">" . $GLOBALS['labs_results'][$lang][1] . "</td>
         <td><textarea tabindex=\"" . ($tabIndex + 21) . "\" id=\"chestXrayTestRemarks\" name=\"chestXrayTestRemarks\" rows=\"2\" cols=\"55\">" . getData ("chestXrayTestRemarks", "textarea") . "</textarea>
         </td>
         </tr>
       </table>
     </td>
    </tr>
    <tr>
     <td width=\"20%\">
      <table>
       <tr>
	    <td id=\"urineTest[]Title\" width=\"1%\"></td>
        <td><input tabindex=\"" . ($tabIndex + 8) . "\" id=\"urineTest[]\" name=\"urineTest[]\" " . getData ("urineTest", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $labData['urine']['testName' . init_upper ($lang)] . "</td>
       </tr>
       <tr>
	   <td id=\"urineTestResultTitle\" width=\"1%\"></td>
        <td><span><input tabindex=\"" . ($tabIndex + 9) . "\" id=\"urineTestResult1\" name=\"urineTestResult[]\" " . getData ("urineTestResult", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $labData['urine']['resultLabel' . init_upper ($lang) . "1"] . "</span></td>
       </tr>
       <tr>
	    <td></td>
        <td><span><input tabindex=\"" . ($tabIndex + 10) . "\" id=\"urineTestResult2\" name=\"urineTestResult[]\" " . getData ("urineTestResult", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $labData['urine']['resultLabel' . init_upper ($lang) . "2"] . "</span></td>
       </tr>
      </table>
     </td>
     <td valign=\"center\" width=\"30%\">
      <table>
       <tr>
        <td id=\"urineTestDtTitle\">
        </td>
        <td>
         <input tabindex=\"" . ($tabIndex + 11) . "\" id=\"urineTestDt\" name=\"urineTestDt\" value=\"" . getData ("urineTestDd", "textarea") . "/". getData ("urineTestMm", "textarea") ."/". getData ("urineTestYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
         <input 									  id=\"urineTestDd\" name=\"urineTestDd\" " . getData ("urineTestDd", "text") . " type=\"hidden\">
         <input tabindex=\"" . ($tabIndex + 12) . "\" id=\"urineTestMm\" name=\"urineTestMm\" " . getData ("urineTestMm", "text") . " type=\"hidden\">
         <input tabindex=\"" . ($tabIndex + 13) . "\" id=\"urineTestYy\" name=\"urineTestYy\" " . getData ("urineTestYy", "text") . " type=\"hidden\">
        </td>
        <td>
         <i>" . $GLOBALS['labs_resultDate'][$lang][2] . "</i>
        </td>
       </tr>
      </table>
     </td>
     <td class=\"left_pad\" width=\"20%\">
      <table>
       <tr>
	    <td id=\"otherXrayTest[]Title\" width=\"1%\"></td>
        <td>
        <input tabindex=\"" . ($tabIndex + 22) . "\" id=\"otherXrayTest[]\" name=\"otherXrayTest[]\" " . getData ("otherXrayTest", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $labData['otherXray']['testName' . init_upper ($lang)] . "</td>
       </tr>
	   <tr>
	    <td id=\"otherXrayTestResultTitle\" width=\"1%\"></td>
        <td><span><input tabindex=\"" . ($tabIndex + 23) . "\" id=\"otherXrayTestResult1\" name=\"otherXrayTestResult[]\" " . getData ("otherXrayTestResult", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $labData['otherXray']['resultLabel' . init_upper ($lang) . "1"] . "</span></td>
       </tr>
       <tr>
	    <td></td>
        <td><span><input tabindex=\"" . ($tabIndex + 24) . "\" id=\"otherXrayTestResult2\" name=\"otherXrayTestResult[]\" " . getData ("otherXrayTestResult", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $labData['otherXray']['resultLabel' . init_upper ($lang) . "2"] . "</span></td>
       </tr>
      </table>
     </td>
     <td valign=\"center\" width=\"29%\">
      <table>
       <tr>
        <td id=\"otherXrayTestDtTitle\">
        </td>
        <td>
         <input tabindex=\"" . ($tabIndex + 25) . "\" id=\"otherXrayTestDt\" name=\"otherXrayTestDt\" value=\"" . getData ("otherXrayTestDd", "textarea") . "/". getData ("otherXrayTestMm", "textarea") ."/". getData ("otherXrayTestYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
         <input 									  id=\"otherXrayTestDd\" name=\"otherXrayTestDd\" " . getData ("otherXrayTestDd", "text") . " type=\"hidden\">
         <input tabindex=\"" . ($tabIndex + 26) . "\" id=\"otherXrayTestMm\" name=\"otherXrayTestMm\" " . getData ("otherXrayTestMm", "text") . " type=\"hidden\">
         <input tabindex=\"" . ($tabIndex + 27) . "\" id=\"otherXrayTestYy\" name=\"otherXrayTestYy\" " . getData ("otherXrayTestYy", "text") . " type=\"hidden\">
        </td>
        <td>
         <i>" . $GLOBALS['labs_resultDate'][$lang][2] . "</i>
        </td>
       </tr>
      </table>
     </td>
    </tr>
    <tr>
     <td colspan=\"2\" width=\"50%\">
       <table class=\"b_header_nb_nw\">
         <tr>
         <td valign=\"top\" class=\"left_pad\">" . $GLOBALS['labs_results'][$lang][1] . "</td>
         <td><textarea tabindex=\"" . ($tabIndex + 14) . "\" id=\"urineTestRemarks\" name=\"urineTestRemarks\" rows=\"2\" cols=\"55\">" . getData ("urineTestRemarks", "textarea") . "</textarea>
         </td>
         </tr>
		 
       </table>
     </td>
     <td colspan=\"2\" width=\"49%\">
       <table class=\"b_header_nb_nw\">
         <tr>
         <td valign=\"top\" class=\"left_pad\">" . $GLOBALS['labs_results'][$lang][1] . "</td>
         <td><textarea tabindex=\"" . ($tabIndex + 28) . "\" id=\"otherXrayTestRemarks\" name=\"otherXrayTestRemarks\" rows=\"2\" cols=\"55\" maxlength=\"255\">" . getData ("otherXrayTestRemarks", "textarea") . "</textarea>
         </td>
         </tr>
       </table>
     </td>
    </tr>
  </table>";

echo $labMatrixData;
echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"laboratory/0.js\"></script>";
?>