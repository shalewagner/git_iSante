<?php
  //always update $labData and $labItemsOrder together to have the same items
  $labData = lookupImageLabs ("'chestXray', 'sonogram', 'otherImages', 'eeg', 'ekg', 'otherNotLab'");   
  $labItemsOrder = array ('chestXray', 'sonogram', 'otherImages', 'eeg', 'ekg', 'otherNotLab'); 

  $labMatrixData = '
    <table class="header" border="0" width="100%">
     <tr>
      <td colspan="7">&nbsp;</td>
     </tr>
     <tr>
      <td colspan="7">' . $GLOBALS['labs_resultInstruction'][$lang][0] . '</td>
     </tr>
     <tr>
      <td colspan="7">&nbsp;</td>
     </tr>
   ';

  $firstKey = current($labItemsOrder);  
  while ($firstKey) { 
  $firstItem = $labData[$firstKey];
  $labMatrixData .= "
  <tr>
    <td rowspan=\"3\" valign=\"top\"><b>" .
        $firstItem['testName' . init_upper ($lang)] . "</b>";
		if ($firstKey == "otherImages" || $firstKey == "chestXray") {
			// construct sub-image items into a dropdown
			if ($firstKey == "chestXray")
				$subList = array('chest' => 'Pulmonaire', 'otherChest' => 'Autre');
			else
				$subList = array('doppler' => 'Echo doppler', 'mammography' => 'Mammographie', 'scanner' => 'Scanner', 'irm' => 'IRM', 'colonoscopie' => 'Colonoscopie', 'recto' => 'Rectosigmoïdoscopie', 'anuscopie' => 'Anuscopie', 'transit' => 'Transit oeso gastroduodenal');
			$labMatrixData .= '&nbsp;:&nbsp;<select id="' . $firstKey . 'TestResult3" name="' . $firstKey . 'TestResult3">';
			foreach ($subList as $key => $item) {
				$selected = '';
				$result3 = getData ($firstKey . "TestResult3", "textarea");
				if ($key == $result3) $selected = 'selected';
				$labMatrixData .= '<option value="' . $key . '" ' . $selected . '>' . $item . '</option>';
			}
			$labMatrixData .= '</select>'; 
		};
	$labMatrixData .= "
    </td>
    <td colspan=\"4\">
       <table>
	 <tr>
	   <td id=\"" . $firstKey . "Test[]Title\"></td><td>
              <input tabindex=\"" . $tabIndex . "\"  id=\"" . $firstKey . "Test[]\" name=\"" . $firstKey . "Test[]\" " . getData ($firstKey . "Test", "checkbox") ." type=\"checkbox\" value=\"On\"> " . $labs_lab_ordered[$lang][0] .
          "</td>
         </tr>
       </table>
    </td>
  </tr>
  <tr>
    <td>
        <table>
          <tr>
            <td id=\"". $firstKey. "TestResultTitle\"></td><td><span>
                 <input tabindex=\"" . ($tabIndex + 1) . "\"   id=\"". $firstKey. "TestResult1\"
                 name=\"". $firstKey. "TestResult[]\" " .
                 getData ($firstKey . "TestResult", "checkbox", 1) . " type=\"radio\"
                  value=\"1\"> " . $firstItem['resultLabel' . init_upper ($lang) . "1"] .
                  "</span>
            </td>
          </tr>
         </table>
    </td>
    <td colspan=\"2\"><span>
       <input tabindex=\"" . ($tabIndex + 2) . "\" id=\"". $firstKey. "TestResult2\"
         name=\"" . $firstKey . "TestResult[]\" " .
         getData ($firstKey . "TestResult", "checkbox", 2) . " type=\"radio\"
         value=\"2\"> " . $firstItem['resultLabel' . init_upper ($lang) . "2"] .
         "</span>
    </td>
  </tr>
  <tr>
    <td colspan=\"2\" valign=\"middle\" width=\"30%\">
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
    <td colspan=\"4\"><textarea tabindex=\"" . ($tabIndex + 7) . "\"
         name=\"" . $firstKey . "TestRemarks\" rows=\"2\" cols=\"95\">" .
         getData ($firstKey . "TestRemarks", "textarea") . "</textarea>
    </td>
  </tr>
";
  $firstKey = next($labItemsOrder); 
  $tabIndex += 100;
}

 $labMatrixData .= '
   </tr>
  </table>
 ';
echo $labMatrixData;
echo '<script language="JavaScript" type="text/javascript" src="laboratory/1.js"></script>';  

function lookupImageLabs ($labNames) {
  $query = "SELECT * FROM labLookup WHERE labName IN (" . $labNames . ")";
  $result = dbQuery ($query);
  $vals = array ();
  while ($row = psRowFetch ($result)) {
     $vals[$row['labName']] = $row;
  }
  return $vals;
}
?>
