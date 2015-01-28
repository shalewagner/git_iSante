<?php

echo "
<!-- ******************************************************************** -->
<!-- ********************* Demographic Information ********************** -->
<!-- * (tab indices " . ($tabIndex + 1) . " - " . ($tabIndex + 1000) . ") * -->
<!-- ********************************************************************** -->";



echo "
  <table class=\"b_header_nb\">
   <tr>
    <td class=\"s_header\">" . $vitals_header[$lang][2] . "</td>
   </tr>
   <tr>
    <td>
     <table class=\"header\">
      <tr>
       <td width=\"20%\">" . $lname[$lang][1] . "</td>
       <td ><input tabindex=\"" . ($tabIndex + 1) . "\" name=\"lname\" " . getData ("lname", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
       <td >" . $fname[$lang][1] . " <input tabindex=\"" . ($tabIndex + 2) . "\" name=\"fname\" " . getData ("fname", "text") . " type=\"text\" size=\"40\" maxlength=\"255\"></td>
       <td id=\"sexTitle\">" . $sex[$lang][0] .
         " <input tabindex=\"" . ($tabIndex + 3) . "\" id=\"s1\" name=\"sex[]\" " . getData ("sex", "radio", 1) .
           " type=\"radio\" value=\"female\">" . $sex[$lang][1] .
         " <input tabindex=\"" . ($tabIndex + 4) . "\" id=\"s2\" name=\"sex[]\" " . getData ("sex", "radio", 2) .
           " type=\"radio\" value=\"male\">" . $sex[$lang][2] . "
           <input type=\"hidden\" id=\"sex\" value=\"".$sex."\"></td>
      </tr>
	  <tr>
		<td width=\"20%\" id=\"dobDtTitle\"> ".$patName[$lang][3]."</td>
        <td colspan=\"3\"><input tabindex=\"2202\" id=\"dobDt\" name=\"dobDt\" value=\"" . getData ("dobDd", "textarea") . "/" . getData ("dobMm", "textarea") . "/" .getData ("dobYy", "textarea") . "\" type=\"text\" size=\"8\" maxlength=\"8\">
        <input tabindex=\"2202\" id=\"dobDd\" name=\"dobDd\" " . getData ("dobDd", "text") . " type=\"hidden\"><input tabindex=\"2203\" id=\"dobMm\"  name=\"dobMm\" " . getData ("dobMm", "text") . " type=\"hidden\"><input tabindex=\"2204\" id=\"dobYy\" name=\"dobYy\" " . getData ("dobYy", "text") . " type=\"hidden\">
       </td>
    </tr>
      <tr>
       <td width=\"20%\" id=\"ageYearsTitle\">" . $ageYears[$lang][1] . "</td><td colspan=\"3\"><input tabindex=\"" . ($tabIndex + 14) . "\" id=\"ageYears\" name=\"ageYears\" " . getData ("ageYears", "text") . " type=\"text\" size=\"10\" maxlength=\"16\"></td>
      </tr>
      <tr>
       <td width=\"20%\">" . $fnameMother[$lang][1] . "</td>
       <td colspan=\"3\"><input tabindex=\"" . ($tabIndex + 15) . "\" id=\"fnameMother\" name=\"fnameMother\" " . getData ("fnameMother", "text") . " type=\"text\" size=\"80\" maxlength=\"255\"></td>
      </tr>
     </table>
    </td>
   </tr>
  </table>
";
?>
