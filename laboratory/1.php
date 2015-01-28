<?php

  //always update $labData and $labItemsOrder together to have the same items
  $labData = lookupLabs ($version,
    "'chestXray', 'otherImages', 'frottisvaginal', 'gouttePendante', 'papTest',
     'stool', 'urine'");
  $labItemsOrder = array ('chestXray', 'otherImages', 'frottisvaginal',
    'gouttePendante', 'papTest', 'stool', 'urine');
  $labMatrixData = "
    <table class=\"header\" border=\"0\" width=\"100%\">
     <tr>
      <td colspan=\"7\">&nbsp;</td>
     </tr>
     <tr>
      <td class=\"s_header\" colspan=\"7\">&nbsp;</td>
     </tr>
     <tr>
      <td colspan=\"7\">" . $GLOBALS['labs_resultInstruction'][$lang][0] . "</td>
     </tr>
     <tr>
      <td colspan=\"7\">&nbsp;</td>
     </tr>";


  //first item spans across 2 columns

  $firstKey = current($labItemsOrder);
  $firstItem = $labData[$firstKey];
  $labMatrixData .= "
    <tr>
      <td rowspan=\"3\" valign=\"top\"><b>" .
        $firstItem['testName' . init_upper ($lang)] . "</b></td>
      <td colspan=\"6\"><table><tr><td id=\"" . $firstKey . "Test[]Title\"></td><td>
        <input tabindex=\"" . $tabIndex . "\"  id=\"" .
        $firstKey . "Test[]\" name=\"" .
        $firstKey . "Test[]\" " . getData ($firstKey . "Test", "checkbox") .
        " type=\"checkbox\" value=\"On\"> " . $labs_lab_ordered[$lang][0] .
     "</td></tr></table></td>
    </tr>
    <tr>
      <td><table><tr><td id=\"". $firstKey. "TestResultTitle\"></td><td><span>
       <input tabindex=\"" . ($tabIndex + 1) . "\"   id=\"". $firstKey. "TestResult1\"
         name=\"". $firstKey. "TestResult[]\" " .
         getData ($firstKey . "TestResult", "checkbox", 1) . " type=\"radio\"
         value=\"1\"> " . $firstItem['resultLabel' . init_upper ($lang) . "1"] .
         "</span></td></tr></table>
     </td>
     <td colspan=\"5\"><span>
       <input tabindex=\"" . ($tabIndex + 2) . "\" id=\"". $firstKey. "TestResult2\"
         name=\"" . $firstKey . "TestResult[]\" " .
         getData ($firstKey . "TestResult", "checkbox", 2) . " type=\"radio\"
         value=\"2\"> " . $firstItem['resultLabel' . init_upper ($lang) . "2"] .
         "</span>
     </td>
    </tr>

    <tr>
      <td colspan=\"6\" valign=\"middle\" width=\"30%\">
      	<table><tr><td id=\"" . $firstKey . "TestDtTitle\"></td><td><input tabindex=\"" . ($tabIndex + 3) . "\" id=\"" . $firstKey . "TestDt\" name=\"" . $firstKey . "TestDt\"
		 value=\"" . getData ($firstKey . "TestDd", "textarea") . "/". getData ($firstKey . "TestMm", "textarea") ."/". getData ($firstKey . "TestYy", "textarea") . "\".
      	type=\"text\" size=\"8\"
          maxlength=\"8\">
        <input id=\"" . $firstKey . "TestDd\"  name=\"" . $firstKey . "TestDd\" " .
          getData ($firstKey . "TestDd", "text") . " type=\"hidden\">
          <input tabindex=\"" . ($tabIndex + 4) . "\"
          id=\"" . $firstKey . "TestMm\"  name=\"" . $firstKey . "TestMm\" " . getData ($firstKey . "TestMm", "text") .
          " type=\"hidden\">
          <input tabindex=\"" .
          ($tabIndex + 5) . "\" id=\"" . $firstKey . "TestYy\" name=\"" . $firstKey . "TestYy\" " .
          getData ($firstKey . "TestYy", "text") .
          " type=\"hidden\"> </td><td><i>" .
          $GLOBALS['labs_resultDate'][$lang][2] . "</i></td></tr></table>
       </td>
     </tr>
     <tr>
       <td valign=\"top\" class=\"left_pad\">" . $GLOBALS['labs_results'][$lang][1] . "</td>
       <td colspan=\"6\"><textarea tabindex=\"" . ($tabIndex + 7) . "\"
         name=\"" . $firstKey . "TestRemarks\" rows=\"2\" cols=\"95\">" .
         getData ($firstKey . "TestRemarks", "textarea") . "</textarea>
     </td>
     </tr>
     ";

  $leftKey = next($labItemsOrder);
  while ($leftKey) {
    $leftItem = $labData[$leftKey];
    $labMatrixData .= "
    <tr>
      <td class=\"bottom_line\" colspan=\"3\">&nbsp;</td>
      <td class=\"bottom_line vert_line\" colspan=\"4\">&nbsp;</td>
    </tr>
    <tr>
      <td rowspan=\"3\" valign=\"top\"><b>" .  $leftItem['testName' . init_upper ($lang)] . "</b></td>
      <td colspan=\"2\"><table><tr><td id=\"" . $leftKey . "Test[]Title\"></td><td><input tabindex=\"" . ($tabIndex + 8). "\" id=\"" .$leftKey . "Test[]\" name=\"" .$leftKey . "Test[]\" " .
         getData ($leftKey . "Test", "checkbox") . " type=\"checkbox\" value=\"On\"> " .
         $labs_lab_ordered[$lang][0] . "</td></tr></table></td>";
    $rightKey = NULL;
    $rightItem = NULL;
    if ($rightKey = next($labItemsOrder)) {
      $rightItem = $labData[$rightKey];
      $labMatrixData .= "
      <td class=\"vert_line\" rowspan=\"4\" width=\"1%\">&nbsp;</td>
      <td rowspan=3 valign=\"top\"><b>" .  $rightItem['testName' . init_upper ($lang)] . "</b></td>
      <td colspan=\"2\"><table><tr><td id=\"" . $rightKey . "Test[]Title\"></td><td><input tabindex=\"" . ($tabIndex +9). "\" id=\"" .$rightKey . "Test[]\" name=\"" .$rightKey . "Test[]\" " .
         getData ($rightKey . "Test", "checkbox") . " type=\"checkbox\" value=\"On\"> " .
         $labs_lab_ordered[$lang][0]  . "</td></tr></table></td>";
   }

   $labMatrixData .= "</tr><tr>
     <td><table><tr><td id=\"". $leftKey. "TestResultTitle\"></td><td><span>
       <input tabindex=\"" . ($tabIndex + 10) . "\"
         id=\"". $leftKey. "TestResult1\"  name=\"". $leftKey. "TestResult[]\" " .
         getData ($leftKey . "TestResult", "checkbox", 1) . " type=\"radio\"
         value=\"1\"> " . $leftItem['resultLabel' . init_upper ($lang) . "1"] .
         "</span></td></tr></table>
     </td>
     <td><span>
       <input tabindex=\"" . ($tabIndex + 11) . "\"
         id=\"". $leftKey. "TestResult2\" name=\"" . $leftKey . "TestResult[]\" " .
         getData ($leftKey . "TestResult", "checkbox", 2) . " type=\"radio\"
         value=\"2\"> " . $leftItem['resultLabel' . init_upper ($lang) . "2"] .
         "</span>
     </td>";

     if ($rightItem) {
       $labMatrixData .= "
       <td><table><tr><td id=\"". $rightKey. "TestResultTitle\"></td><td><span>
         <input tabindex=\"" . ($tabIndex + 12) . "\"
           id=\"" . $rightKey . "TestResult1\" name=\"" . $rightKey . "TestResult[]\" " .
           getData ($rightKey . "TestResult", "checkbox", 1) . " type=\"radio\"
           value=\"1\"> " . $rightItem['resultLabel' . init_upper ($lang) . "1"] .
           "</span></td></tr></table>
       </td>
       <td><span>
         <input tabindex=\"" . ($tabIndex + 13) . "\"
           id=\"" . $rightKey . "TestResult2\" name=\"" . $rightKey . "TestResult[]\" " .
           getData ($rightKey . "TestResult", "checkbox", 2) . " type=\"radio\"
           value=\"2\"> " . $rightItem['resultLabel' . init_upper ($lang) . "2"] .
           "</span>
       </td>";
   }
   $labMatrixData .= "
    </tr><tr>
      <td colspan=\"2\" valign=\"middle\" width=\"30%\">
       <table>
		<tr>
		<td id=\"" . $leftKey . "TestDtTitle\" width=\"5%\">&nbsp;</td>
		<td>
		<input tabindex=\"" . ($tabIndex + 14) . "\" id=\"" . $leftKey . "TestDt\" name=\"" . $leftKey . "TestDt\"
		 value=\"" . getData ($leftKey . "TestDd", "textarea") . "/". getData ($leftKey . "TestMm", "textarea") ."/". getData ($leftKey . "TestYy", "textarea") . "\"
		 type=\"text\" size=\"8\"
		  maxlength=\"8\">
		  <input  id=\"" . $leftKey . "TestDd\"
		  name=\"" . $leftKey . "TestDd\" " . getData ($leftKey . "TestDd", "text") .
		  " type=\"hidden\">
		  <input tabindex=\"" . ($tabIndex + 15) . "\" id=\"" . $leftKey . "TestMm\"
		  name=\"" . $leftKey . "TestMm\" " . getData ($leftKey . "TestMm", "text") .
		  " type=\"hidden\"> <input tabindex=\"" .
		  ($tabIndex + 5) . "\" id=\"" . $leftKey . "TestYy\"
		  name=\"" . $leftKey . "TestYy\" " .
		  getData ($leftKey . "TestYy", "text") .
		  " type=\"hidden\">
		 </td>
		 <td><i>" .
		  $GLOBALS['labs_resultDate'][$lang][2] . "</i>
		 </td>
		 </tr>
          </table>
       </td>";

     if ($rightItem) {
       $labMatrixData .= "
         <td colspan=\"2\" valign=\"middle\" width=\"30%\">
         <table>
         <tr>
         <td id=\"" . $rightKey . "TestDtTitle\" width=\"5%\">&nbsp;</td>
         <td>
         <input tabindex=\"" . ($tabIndex + 16) . "\" id=\"" . $rightKey . "TestDt\" name=\"" . $rightKey . "TestDt\"
          value=\"" . getData ($rightKey . "TestDd", "textarea") . "/". getData ($rightKey . "TestMm", "textarea") ."/". getData ($rightKey . "TestYy", "textarea") . "\"
          type=\"text\" size=\"8\"
           maxlength=\"8\">
           <input  id=\"" . $rightKey . "TestDd\"
           name=\"" . $rightKey . "TestDd\" " . getData ($rightKey . "TestDd", "text") .
           " type=\"hidden\">
           <input tabindex=\"" . ($tabIndex + 17) . "\" id=\"" . $rightKey . "TestMm\"
           name=\"" . $rightKey . "TestMm\" " . getData ($rightKey . "TestMm", "text") .
           " type=\"hidden\"> <input tabindex=\"" .
           ($tabIndex + 18) . "\" id=\"" . $rightKey . "TestYy\"
           name=\"" . $rightKey . "TestYy\" " .
           getData ($rightKey . "TestYy", "text") .
           " type=\"hidden\">
          </td>
          <td><i>" .
           $GLOBALS['labs_resultDate'][$lang][2] . "</i>
          </td>
          </tr>
          </table>
       </td>";
     }

   $labMatrixData .= "</tr><tr>
     <td valign=\"top\" class=\"left_pad\">" . $GLOBALS['labs_results'][$lang][1] . "</td>
     <td colspan=\"2\"><textarea tabindex=\"" . ($tabIndex + 19) . "\"
       name=\"" . $leftKey . "TestRemarks\" rows=\"2\" cols=\"40\">" .
       getData ($leftKey . "TestRemarks", "textarea") . "</textarea>
     </td>";

   if ($rightItem) {
     $labMatrixData .= "
       <td valign=\"top\" class=\"left_pad\">" . $GLOBALS['labs_results'][$lang][1] . "</td>
       <td colspan=\"2\"><textarea tabindex=\"" . ($tabIndex + 20) . "\"
         name=\"" . $rightKey . "TestRemarks\" rows=\"2\" cols=\"40\">" .
         getData ($rightKey . "TestRemarks", "textarea") . "</textarea>
       </td>";
   }
 $leftKey = next($labItemsOrder);
 $tabIndex += 100;
 }

 $labMatrixData .= "
   </tr>
  </table>";
echo $labMatrixData;
echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"laboratory/1.js\"></script>";
?>
