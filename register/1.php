<?php
if($pid != ""){
echo "";
}
echo"
<div id=\"tab-panes\">

<!-- ******************************************************************** -->
<!-- ********************* Demographic Information ********************** -->
<!-- ******************** (tab indices 1001 - 2000) ********************* -->
<!-- ******************************************************************** -->

  <div id=\"pane1\">
  <table>
   <tr>
    <td class=\"s_header\">" . $vitals_header[$lang][2] . "</td>
   </tr>
   <tr>
    <td>
     <table>
     <tr>
		<td id=\"clinicPatientIDTitle\">No. de code PC</td>
		<td><input tabindex=\"997\" id=\"primCareID\" name=\"primCareID\" " . getData ("primCareID", "text") . " type=\"text\" size=\"20\" maxlength=\"255\"></td>
		<td id=\"clinicPatientIDTitle\" align=\"right\">No. de code OG</td>
		<td><input tabindex=\"998\" id=\"obgynID\" name=\"obgynID\" " . getData ("obgynID", "text") . " type=\"text\" size=\"20\" maxlength=\"255\"></td>
		<td id=\"clinicPatientIDTitle\" align=\"right\">No. de code ST</td>
		<td><input tabindex=\"999\" id=\"clinicPatientID\" name=\"clinicPatientID\" " . getData ("clinicPatientID", "text") . " type=\"text\" size=\"20\" maxlength=\"255\"></td>
	 </tr>
     <tr><td id=\"nationalIDTitle\">" . $nationalID[$lang][1] . "</td>
	   <td><input tabindex=\"1000\" id=\"nationalID\" name=\"nationalID\" " . getData ("nationalID", "text") . " type=\"text\" size=\"30\" maxlength=\"255\"></td>
      </tr>
      <tr>
        <td id=\"fnameTitle\">" . $fname[$lang][1] . "</td>
        <td><input tabindex=\"1001\" id=\"fname\" name=\"fname\" " . getData ("fname", "text") . " type=\"text\" size=\"30\" maxlength=\"255\"></td>
        <td id=\"lnameTitle\" align=\"right\">" . $lname[$lang][1] . "</td>
        <td><input tabindex=\"1002\" id=\"lname\" name=\"lname\" " . getData ("lname", "text") . " type=\"text\" size=\"30\" maxlength=\"255\"></td>";
        echo "<td>" . $sex[$lang][0] . " <input tabindex=\"1003\" name=\"sex[]\" " . getData ("sex", "radio", 1) . " type=\"radio\" value=\"1\">" . $sex[$lang][1] . " <input tabindex=\"1004\" name=\"sex[]\" " . getData ("sex", "radio", 2) . " type=\"radio\" value=\"2\">" . $sex[$lang][2] . "</td>
      </tr>
      <tr>
       <td>" . $addrDistrict[$lang][1] . "</td>
       <td colspan=\"4\"><input tabindex=\"1005\" name=\"addrDistrict\" " . getData ("addrDistrict", "text") . " type=\"text\" size=\"80\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td>" . $addrSection[$lang][1] . "</td>
       <td>";
         $temp = getData ("addrSection", "textarea");
         $extra = getExtra($temp, $lang);
         genCommuneDropDown ("addrSection", "1006", $temp, $extra);
         echo "</td>
       <td align=\"right\">" . $addrTown[$lang][1] . "</td>
       <td  colspan=\"2\"><input tabindex=\"1007\" name=\"addrTown\" " . getData ("addrTown", "text") . " type=\"text\" size=\"30\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td>" . $telephone[$lang][1] . "</td>
       <td colspan=\"5\"><input tabindex=\"1008\" name=\"telephone\" " . getData ("telephone", "text") . " type=\"text\" size=\"30\" maxlength=\"255\"></td>
      </tr>
      <tr>
       <td>" . $birthDistrict[$lang][1] . "</td>
       <td colspan=\"5\"><input tabindex=\"1009\" name=\"birthDistrict\" " . getData ("birthDistrict", "text") . " type=\"text\" size=\"80\" maxlength=\"255\"></td>
      </tr>
      <tr>
        <td id=\"dobDtTitle\">" . $dobDd[$lang][1] . "</td>
        <td colspan=\"3\">
          <table>
            <tr>
              <td style=\"width: 110px\"><input tabindex=\"1012\" id=\"dobDt\" name=\"dobDt\" value=\"" .getData ("dobDd", "textarea"). "/" .getData ("dobMm", "textarea"). "/" .getData ("dobYy", "textarea"). "\" type=\"text\" size=\"10\" maxlength=\"10\"><input id=\"dobDd\" name=\"dobDd\" " . getData ("dobDd", "text") . " type=\"hidden\"><input id=\"dobMm\" name=\"dobMm\" " . getData ("dobMm", "text") . " type=\"hidden\"><input id=\"dobYy\" name=\"dobYy\" " . getData ("dobYy", "text") . " type=\"hidden\"></td>
              <td><span class=\"dateFormat\">" . $dobYy[$lang][3] . "</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=\"comment\">" . $dobYy[$lang][2] . "</span></td>
            </tr>
          </table>
        </td>
        <td colspan=\"2\" id=\"ageYearsTitle\">" . $ageYears[$lang][3] . "&nbsp<input tabindex=\"1013\" id=\"ageYears\" name=\"ageYears\" " . getData ("ageYears", "text") . " type=\"text\" size=\"10\" maxlength=\"16\" /></td>
      </tr>
      <tr>
        <td id=\"deathDtTitle\">Date du décès</td>
        <td colspan=\"3\">
          <table>
            <tr>
              <td style=\"width: 110px\"><input tabindex=\"1014\" id=\"deathDt\" name=\"deathDt\" value=\"" .getData ("deathDt", "textarea") . "\" type=\"text\" size=\"10\" maxlength=\"10\"></td>
              <td><span class=\"dateFormat\">" . $dobYy[$lang][3] . "</span></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td>" . $maritalStatus[$lang][0] . "</td>
        <td colspan=\"3\"><input tabindex=\"1016\" name=\"maritalStatus[]\" " . getData ("maritalStatus", "checkbox", 1) . " type=\"radio\" value=\"1\" />" . $maritalStatus[$lang][1] . " <input tabindex=\"1017\" name=\"maritalStatus[]\" " . getData ("maritalStatus", "checkbox", 2) . " type=\"radio\" value=\"2\" />" . $maritalStatus[$lang][2] . " <input tabindex=\"1018\" name=\"maritalStatus[]\" " . getData ("maritalStatus", "checkbox", 4) . " type=\"radio\" value=\"4\" />" . $maritalStatus[$lang][3] . " <input tabindex=\"1019\" name=\"maritalStatus[]\" " . getData ("maritalStatus", "checkbox", 8) . " type=\"radio\" value=\"8\">" . $maritalStatus[$lang][4] . " <input tabindex=\"1020\" name=\"maritalStatus[]\" " . getData ("maritalStatus", "checkbox", 16) . " type=\"radio\" value=\"16\" /> " . $maritalStatus[$lang][5] . " <input tabindex=\"1021\" name=\"maritalStatus[]\" " . getData ("maritalStatus", "checkbox", 32) . " type=\"radio\" value=\"32\" />" . $maritalStatus[$lang][6] . "</td>
      </tr>
      <tr>
       <td>" . $occupation_1[$lang][1] . "</td>
	   <td><input tabindex=\"1022\" name=\"occupation\" " . getData ("occupation", "text") . " type=\"text\" size=\"30\" maxlength=\"255\" /></td>
       <td align=\"right\">" . stripslashes($fnameMother[$lang][1]) . "</td>
       <td colspan=\"2\"><input tabindex=\"1023\" name=\"fnameMother\" " . getData ("fnameMother", "text") . " type=\"text\" size=\"30\" maxlength=\"255\" /></td>
       </tr>

      <tr>
       <td class=\"bold\" colspan=\"5\">" . $contact[$lang][0] . "</td>
      </tr>
      <tr>
        <td>" . $contact[$lang][1] . "</td>
        <td colspan=\"2\"><input tabindex=\"1024\" name=\"contact\" " . getData ("contact", "text") . " type=\"text\" size=\"40\" maxlength=\"255\" /></td>
        <td colspan=\"3\">" . $discloseList[$lang][2] . "&nbsp;<input tabindex=\"1026\" name=\"relationContact\" " . getData ("relationContact", "text") . " type=\"text\" size=\"30\" maxlength=\"255\" /></td>
      </tr>
      <tr>
       <td>" . $addrContact[$lang][1] . "</td>
       <td colspan=\"2\"><input tabindex=\"1025\" name=\"addrContact\" " . getData ("addrContact", "text") . " type=\"text\" size=\"40\" maxlength=\"255\" /></td>
       <td colspan=\"3\">" . $telephone[$lang][1] . "&nbsp;<input tabindex=\"1027\" name=\"phoneContact\" " . getData ("phoneContact", "text") . " type=\"text\" size=\"30\" maxlength=\"255\" /></td>
      </tr>
     </table>
    </td>
   </tr>
  </table>
 </div>

 <div id=\"pane2\">
  <table>
   <tr>
    <td class=\"bold\">" . $discloseList[$lang][3] . "</td>
   </tr>";

$tabIndex = 1100;
// was $max_disclose (4, not 2)
for ($i = 1; $i <= 2; $i++) {
  echo "
   <tr>
    <td><span>" . $i . ".&nbsp;" . $discloseList[$lang][0] . " <input tabindex=\"" . ($tabIndex++) . "\" name=\"discloseStatusName" . $i . "\" " . getData ("discloseStatusName" . $i, "text") . " type=\"text\" size=\"60\" maxlength=\"255\" /></span><span>" . $discloseList[$lang][2] . " <input tabindex=\"" . ($tabIndex++) . "\" name=\"discloseStatusRel" . $i . "\" " . getData ("discloseStatusRel" . $i, "text") . " type=\"text\" size=\"25\" maxlength=\"255\" /></span></td>
   </tr>
   <tr>
    <td><span>" . $addrContact[$lang][1] . " <input tabindex=\"" . ($tabIndex++) . "\" name=\"discloseStatusAddress" . $i . "\" " . getData ("discloseStatusAddress" . $i, "text") . " type=\"text\" size=\"60\" maxlength=\"255\" /></span><span>" . $telephone[$lang][1] . " <input tabindex=\"" . ($tabIndex++) . "\" name=\"discloseStatusTelephone" . $i . "\" " . getData ("discloseStatusTelephone" . $i, "text") . " type=\"text\" size=\"25\" maxlength=\"255\" /></span></td>
   </tr>";
}
echo "
  </table>
  </div>
  </div>";

if ($tabsOn) {
  echo "</div>";
}

$tabIndex = 4000;
$formName = "register";
echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"register/1.js\"></script>";

?>
