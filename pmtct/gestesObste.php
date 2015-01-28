<?php
echo "
 <div id=\"pane_gestesObste\">
  <table class=\"header\">
   <tr>
    <td valign=\"top\" width=\"100%\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\">" . $obstetrical[$lang][0] . "</td>
      </tr>
          <tr>
           <td>
                <table width=\"100%\">
                  <tr><td>
                        <input type=\"checkbox\" ".getData("physioChildbirth","checkbox",1)." name=\"physioChildbirth\" tabindex=\"". ($tab++) . "\" 
value=\"1\" /> " . 
$obstetrical[$lang][1] 
. 
"
                  </td></tr>
                  <tr><td>
                        <input type=\"checkbox\" ".getData("cSection","checkbox",1)." name=\"cSection\" tabindex=\"". ($tab++) . "\" value=\"1\" /> 
" . $obstetrical[$lang][2] . "
                  </td></tr>
                  <tr><td>
                        <input type=\"checkbox\" ".getData("tocolysis","checkbox",1)." name=\"tocolysis\" tabindex=\"". ($tab++) . "\" value=\"1\" 
/> " 
. $obstetrical[$lang][3] . "
                  </td></tr>
                  <tr><td>
                        " . $obstetrical[$lang][4] . " <input type=\"text\" tabindex=\"". ($tab++) . "\" ".getData("obstetricalText","text")." 
name=\"obstetricalText\" />
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
