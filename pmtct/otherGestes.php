<?php

echo "
 <div id=\"pane_otherGestes\">
  <table class=\"header\">
   <tr>
    <td valign=\"top\" width=\"100%\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\">" . $other_gestes[$lang][0] . "</td>
      </tr>
          <tr>
           <td>
                <table width=\"100%\">
                  <tr><td>
                        <input type=\"checkbox\" tabindex=\"". ($tab++) . "\" ".getData("obsLabAnalysis","checkbox",1)." name=\"obsLabAnalysis\" 
value=\"1\" /> " . $other_gestes[$lang][1] . "
                  </td></tr>
                  <tr><td>
                        <input type=\"checkbox\" name=\"obsMedOrder\" ".getData("obsMedOrder","checkbox",1)." value=\"1\" tabindex=\"". 
($tab++) . "\" /> " . $other_gestes[$lang][2] . "
                  </td></tr>
                  <tr><td>
                        " . $obstetrical[$lang][4] . " <input type=\"text\" name=\"otherObsText\" ".getData("otherObsText","text")."
tabindex=\"". ($tab++) . "\" />
                  </td></tr>

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
