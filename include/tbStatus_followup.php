<?php

echo "
<!-- -------------------------------------------------------------------- -->
<!-- ---------------------------- TB Status BON ----------------------------- -->
<!-- -------------------- (tab indices " . ($tabIndex + 1) . " - " . ($tabIndex + 100) . ") --------------------- -->
<!-- -------------------------------------------------------------------- -->
";
if ($encType == "1" && $version == "1")
	$tbHead = $intakeSectLabs1[$lang][9];
else
	$tbHead = $tbstatus_header[$lang][3];


echo "
     <table class=\"b_header_nb\">
      <tr>
       <td colspan=\"4\" class=\"s_header\">" . $tbHead . "</td>
      </tr>
      <tr>
       <td colspan=\"4\"><table><tr><td id=\"tbStatusTitle\"></td><td>
         <input tabindex=\"" . ($tabIndex + 1) . "\" id=\"antecedentTb1\" name=\"antecedentTb[]\" " .
           getData ("antecedentTb", "radio", 1) .
           " type=\"radio\" value=\"1\" >" .
           $antecedentTb[$lang][1] ."
     </td></tr></table></td>
      </tr>
      <tr>
       <td>
        <table><tr><td id=\"completeTreatTitle\"></td><td>
          <input tabindex=\"" . ($tabIndex + 2) . "\" id=\"antecedentTb2\" name=\"antecedentTb[]\" " . getData ("antecedentTb", "radio", 2) . " type=\"radio\" value=\"2\">" . $completeTreat[$lang][1] . "
        </td></tr></table>
       </td>
       <td id=\"completeTreatDtTitle\">" . $completeTreatMm[$lang][0] . "</td>

       <td><table><tr><td><input tabindex=\"" . ($tabIndex + 3) . "\" id=\"completeTreatDt\" name=\"completeTreatDt\"  value=\"" . getData ("completeTreatDd", "textarea") . "/". getData ("completeTreatMm", "textarea") ."/". getData ("completeTreatYy", "textarea") . "\"  type=\"text\" size=\"8\" maxlength=\"8\"><input id=\"completeTreatDd\" name=\"completeTreatDd\"  type=\"hidden\"><input id=\"completeTreatMm\" name=\"completeTreatMm\"   type=\"hidden\"><input tabindex=\"" . ($tabIndex + 5) . "\" id=\"completeTreatYy\" name=\"completeTreatYy\" type=\"hidden\"></td><td><i>" . $completeTreatYy[$lang][2] . "</i></td></tr></table></td>

       </td>
       <td><table><tr><td id=\"completeTreatFacTitle\">&nbsp;</td><td>" . $completeTreatFac[$lang][1] . "
	  <input tabindex=\"" . ($tabIndex + 6) . "\" id=\"completeTreatFac\" name=\"completeTreatFac\" " . getData ("completeTreatFac", "text") . " type=\"text\" size=\"30\" maxlength=\"255\">
	  </td></tr></table></td>
      </tr>
      <tr>
       <td><table><tr><td id=\"currentTreatTitle\">&nbsp;</td><td>
         <input tabindex=\"" . ($tabIndex + 7) . "\" id=\"antecedentTb3\"  name=\"antecedentTb[]\" " .
           getData ("antecedentTb", "radio",4) .
           " type=\"radio\" value=\"4\">" . $currentTreat[$lang][1] . "
     </td></tr></table></td>
       <td id=\"currentTreatNoTitle\">" . $currentTreatNo[$lang][1] . "</td><td>
         <input tabindex=\"" . ($tabIndex + 8) . "\" id=\"currentTreatNo\" name=\"currentTreatNo\" " . getData ("currentTreatNo", "text") . " type=\"text\" size=\"30\" maxlength=\"64\"></td>
       <td><table><tr><td id=\"currentTreatFacTitle\">&nbsp;</td><td>" . $currentTreatFac[$lang][1] . "
       <input tabindex=\"" . ($tabIndex + 9) . "\" id=\"currentTreatFac\" name=\"currentTreatFac\" " . getData ("currentTreatFac", "text") . " type=\"text\" size=\"30\" maxlength=\"255\"></td></tr></table></td>
      </tr>
	  <tr><td>" . $debutTbTraitement[$lang][0] . "
       <input tabindex=\"" . ($tabIndex + 10) . "\" id=\"dateDebutTb\" name=\"dateDebutTb\" type=\"date\" value=\"" . getData ("dateDebutTb", "textarea") . "\"\></td></tr>
      </tr>
	  
     </table>
    </td>
   
";
?>
