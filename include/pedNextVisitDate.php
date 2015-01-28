<?php

echo "

<!-- -------------------------------------------------------------------- -->
<!-- --------------------------- Next Visit Date ------------------------ -->
<!-- -------------------- (tab indices " . ($tabIndex + 1) . " - " . ($tabIndex + 1000) . ") --------------------- -->
<!-- -------------------------------------------------------------------- -->

   <tr>
    <td id=\"nxtVisitD2Title\">" . $pedNextVisit[$lang][10] . "</td>
    <td ><table><tr><td>
	      <input tabindex=\"" . ($tabIndex + 1) . "\" id=\"nxtVisitD2\" name=\"nxtVisitD2\" value=\"" . getData ("nxtVisitDd", "textarea") . "/". getData ("nxtVisitMm", "textarea") ."/". getData ("nxtVisitYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
	      <input id = \"nxtVisitDd\" name = \"nxtVisitDd\" type=\"hidden\">
	      <input tabindex=\"" . ($tabIndex + 2) . "\" id = \"nxtVisitMm\" name = \"nxtVisitMm\" type=\"hidden\">
	      <input tabindex=\"" . ($tabIndex + 3) . "\" id = \"nxtVisitYy\" name = \"nxtVisitYy\" type=\"hidden\">" .
	    " </td><td><i>" . $jma[$lang][1] . "</i></td></tr></table>
    </td>
   </tr>
  </table>
";

?>
