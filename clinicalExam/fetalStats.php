<?php

echo "


  <table width=\"100%\">

   <tr>
           <td width=\"20%\" id=\"foeCardRhythmTitle\" >
            " . $foeCardRhythm[$lang][0] . "
           </td>
           <td>
            <input tabindex=\"".($tab++)."\" id=\"foeCardRhythm\" name=\"foeCardRhythm\" " . getData ("foeCardRhythm", "text") . " type=\"text\" 
size=\"8\" 
maxsize=\"255\"> " .$foeCardRhythm[$lang][1] ."
           </td>


           <td width=\"16%\"  id=\"uterHeightTitle\">
            " . $uterHeight[$lang][0] . "
           </td>
           <td>
            <input tabindex=\"".($tab++)."\" id=\"uterHeight\" name=\"uterHeight\" " . getData ("uterHeight", "text") . " type=\"text\" size=\"4\" maxsize=\"24\">&nbsp;" . $uterHeight[$lang][1] . "
           </td>




           <td width=\"13%\" id=\"oedemaTitle\">
            " . $oedema[$lang][0] . "
           </td>
           <td>
            <input tabindex=\"".($tab++)."\" id=\"oedema1\" name=\"oedema[]\" " . getData ("oedema", "radio","1") . " type=\"radio\" value=\"1\">". $generalOption[$lang][0] . "
                &nbsp;
                <input tabindex=\"".($tab++)."\" id=\"oedema2\" name=\"oedema[]\" " . getData ("oedema", "radio","2") . " type=\"radio\" value=\"2\">". $generalOption[$lang][1] . "
           </td>

	  </tr>

          <tr>
           <td width=\"15%\"  id=\"presentationTitle\">
            " . $presentation[$lang][0] . "
           </td>
           <td>
            <input tabindex=\"".($tab++)."\" id=\"presentation1\" name=\"presentation[]\" " . getData ("presentation", "radio","1") . " type=\"radio\" value=\"1\">". $presentation[$lang][1] . 
"
                &nbsp;
                 <input tabindex=\"".($tab++)."\" id=\"presentation2\" name=\"presentation[]\" " . getData ("presentation", "radio","2") . " type=\"radio\" value=\"2\">". $presentation[$lang][2] . "
                &nbsp;<input tabindex=\"".($tab++)."\" id=\"presentation4\" name=\"presentation[]\" " . getData ("presentation", "radio","4") . " type=\"radio\" value=\"4\">". $presentation[$lang][3] . "
           </td>

           <td width=\"20%\" id=\"uterContractionTitle\">
            " . $uterContraction[$lang][0] . "
           </td>
           <td>
            <input tabindex=\"".($tab++)."\" id=\"uterContraction1\" name=\"uterContraction[]\" " . getData ("uterContraction", "radio","1") . " type=\"radio\" value=\"1\">". $generalOption[$lang][0] . "
                &nbsp;
                <input tabindex=\"".($tab++)."\" id=\"uterContraction2\" name=\"uterContraction[]\" " . getData ("uterContraction", "radio","2") . " type=\"radio\" value=\"2\">".$generalOption[$lang][1] . "
           </td>
          </tr>
	<tr><td>&nbsp;</td></tr>
         </table>

";


?>
