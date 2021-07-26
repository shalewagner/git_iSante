<?php
require_once 'labels/pediatric.php';
echo "
<div id=\"tab-panes\">

<!-- ******************************************************************** -->
<!-- ********************* Demographic Information ********************** -->
<!-- ******************** (tab indices 1001 - 2000) ********************* -->
<!-- ******************************************************************** -->

  <div id=\"pane1\">
  <table>
    <tr>
      <td class=\"s_header\">" . $pedRegister[$lang][0] . "</td>
    </tr>
    <tr>
      <td>
        <table>
          <tr>
            <td id=\"clinicPatientIDTitle\">No. de code PC</td>
            <td><input tabindex=\"997\" id=\"primCareID\" name=\"primCareID\" " . getData ("primCareID", "text") . " type=\"text\" size=\"30\" maxlength=\"255\"></td>
            <td id=\"clinicPatientIDTitle\">No. de code OG</td>
            <td><input tabindex=\"998\" id=\"obgynID\" name=\"obgynID\" " . getData ("obgynID", "text") . " type=\"text\" size=\"30\" maxlength=\"255\"></td>
            <td id=\"clinicPatientIDTitle\">No. de code ST</td>
            <td><input tabindex=\"999\" id=\"clinicPatientID\" name=\"clinicPatientID\" " . getData ("clinicPatientID", "text") . " type=\"text\" size=\"30\" maxlength=\"255\"></td>
          </tr>
          <tr>
            <td id=\"nationalIDTitle\">" . $nationalID[$lang][1] . "</td>
            <td colspan=\"5\"><input tabindex=\"1000\" id=\"nationalID\" name=\"nationalID\" " . getData ("nationalID", "text") . " type=\"text\" size=\"30\" maxlength=\"255\"></td>
          </tr>
          <tr>
            <td id=\"fnameTitle\">" . $pedRegister[$lang][1] . "</td>
            <td><input tabindex=\"1001\" id=\"fname\" name=\"fname\" " . getData ("fname", "text") . " type=\"text\" size=\"30\" maxlength=\"255\"/></td>
            <td id=\"lnameTitle\" align=\"right\">" . $pedRegister[$lang][2] . "</td>
            <td><input tabindex=\"1002\" id=\"lname\" name=\"lname\" " . getData ("lname", "text") . " type=\"text\" size=\"30\" maxlength=\"255\"/></td>
            <td id=\"sexTitle\" colspan=\"2\"  align=\"right\" >" . $pedRegister[$lang][3] . "</td> 
			<td><input tabindex=\"1003\" id=\"sexF\" name=\"sex\" " . getData ("sex", "radio", 1) . " type=\"radio\" value=\"1\"/> " . $pedRegister[$lang][4] . " 
			    <input tabindex=\"1004\" id=\"sexH\" name=\"sex\" " . getData ("sex", "radio", 2) . " type=\"radio\" value=\"2\"/> " . $pedRegister[$lang][5] ." 
			    <input tabindex=\"100442\" id=\"sexI\" name=\"sex\" " . getData ("sex", "radio", 4) . " type=\"radio\" value=\"4\"/> " . $pedRegister[$lang][20] ."</td>
          </tr>
          <tr>
            <td>" . $addrDistrict[$lang][1] . "</td>
            <td colspan=\"5\"><input tabindex=\"1005\" name=\"addrDistrict\" " . getData ("addrDistrict", "text") . " type=\"text\" size=\"80\" maxlength=\"255\"/></td>
          </tr>
          <tr>
            <td>" . $addrSection[$lang][1] . "</td>
            <td>";
            $temp = getData ("addrSection", "textarea");
            $extra = getExtra($temp, $lang);
            genCommuneDropDown ("addrSection", "1006", $temp, $extra);
            echo "</td>
            <td align=\"right\">" . $pedRegister[$lang][8] . "</td>
            <td colspan=\"3\"><input tabindex=\"1007\" name=\"addrTown\" " . getData ("addrTown", "text") . " type=\"text\" size=\"30\" maxlength=\"255\"/></td>
          </tr> 
          <tr>
            <td>" . $telephone[$lang][1] . "</td>
            <td colspan=\"5\"><input tabindex=\"1008\" name=\"telephone\" " . getData ("telephone", "text") . " type=\"text\" size=\"80\" maxlength=\"255\"></td>
          </tr>
          <tr>
            <td>" . $birthDistrict[$lang][1] . "</td>
            <td colspan=\"5\"><input tabindex=\"1009\" name=\"birthDistrict\" " . getData ("birthDistrict", "text") . " type=\"text\" size=\"80\" maxlength=\"255\"/></td>
          </tr>
          <tr>
            <td id=\"dobDtTitle\">" . $dobDd[$lang][1] . "</td>
            <td colspan=\"3\">
              <table>
                <tr>
                  <td style=\"width: 110px\"><input tabindex=\"1012\" id=\"dobDt\" name=\"dobDt\" value=\"" .getData ("dobDd", "textarea"). "/" .getData ("dobMm", "textarea"). "/" .getData ("dobYy", "textarea"). "\" type=\"text\" size=\"10\" maxlength=\"10\"><input id=\"dobDd\" name=\"dobDd\" " . getData ("dobDd", "text") . " type=\"hidden\"><input tabindex=\"1013\" id=\"dobMm\" name=\"dobMm\" " . getData ("dobMm", "text") . " type=\"hidden\"><input tabindex=\"1014\" id=\"dobYy\" name=\"dobYy\" " . getData ("dobYy", "text") . " type=\"hidden\"></td>
                  <td><span class=\"dateFormat\">" . $dobYy[$lang][3] . "</span> &nbsp;&nbsp;&nbsp;<span class=\"comment\">" . $dobYy[$lang][2] . "</span></td>
                </tr>
              </table>
            </td>
            <td colspan=\"2\" id=\"ageYearsTitle\">" . $ageYears[$lang][3] . "&nbsp<input tabindex=\"1015\" id=\"ageYears\" name=\"ageYears\" " . getData ("ageYears", "text") . " type=\"text\" size=\"10\" maxlength=\"16\" /></td>
          </tr> 
          <tr>
            <td>" . stripslashes($pedRegister[$lang][13]) . "</td>
            <td colspan=\"5\"><input tabindex=\"1016\" name=\"fnameMother\" " . getData ("fnameMother", "text") . " type=\"text\" size=\"80\" maxlength=\"255\" /></td>
          </tr>
          <tr>
            <td>" . $maritalStatus[$lang][0] . "</td>
            <td colspan=\"5\"><input tabindex=\"1016\" name=\"maritalStatus[]\" " . getData ("maritalStatus", "checkbox", 1) . " type=\"radio\" value=\"1\" />" . $maritalStatus[$lang][1] . " <input tabindex=\"1017\" name=\"maritalStatus[]\" " . getData ("maritalStatus", "checkbox", 2) . " type=\"radio\" value=\"2\" />" . $maritalStatus[$lang][2] . " <input tabindex=\"1018\" name=\"maritalStatus[]\" " . getData ("maritalStatus", "checkbox", 4) . " type=\"radio\" value=\"4\" />" . $maritalStatus[$lang][3] . " <input tabindex=\"1019\" name=\"maritalStatus[]\" " . getData ("maritalStatus", "checkbox", 8) . " type=\"radio\" value=\"8\">" . $maritalStatus[$lang][4] . " <input tabindex=\"1020\" name=\"maritalStatus[]\" " . getData ("maritalStatus", "checkbox", 16) . " type=\"radio\" value=\"16\" /> " . $maritalStatus[$lang][5] . " <input tabindex=\"1021\" name=\"maritalStatus[]\" " . getData ("maritalStatus", "checkbox", 32) . " type=\"radio\" value=\"32\" />" . $maritalStatus[$lang][6] . "</td>
          </tr>
          <tr>
           <td class=\"bold\" colspan=\"6\">" . $pedRegister[$lang][15] . "</td>
          </tr>
          <tr>
           <td>" . $pedRegister[$lang][16] . "</td>
           <td colspan=\"2\"><input tabindex=\"1101\" name=\"medicalPoa\" " . getData ("medicalPoa", "text") . " type=\"text\" size=\"40\" maxlength=\"255\" /></td>
           <td>" . $pedRegister[$lang][17] . "</td>
           <td colspan=\"2\"><input tabindex=\"1102\" name=\"relationMedicalPoa\" " . getData ("relationMedicalPoa", "text") . " type=\"text\" size=\"40\" maxlength=\"255\" /></td>
          </tr>
          <tr>
           <td>" . $pedRegister[$lang][6] . "</td>
           <td colspan=\"2\"><input tabindex=\"1103\" name=\"addrMedicalPoa\" " . getData ("addrMedicalPoa", "text") . " type=\"text\" size=\"40\" maxlength=\"255\" /></td>
           <td align=\"right\">" . $pedRegister[$lang][18] . "</td>
           <td colspan=\"2\"><input tabindex=\"1104\" name=\"phoneMedicalPoa\" " . getData ("phoneMedicalPoa", "text") . " type=\"text\" size=\"30\" maxlength=\"255\" /></td>
          </tr>
          <tr>
           <td class=\"bold\" colspan=\"5\">" . $pedRegister[$lang][19] . "</td>
          </tr>
          <tr>
           <td>" . $pedRegister[$lang][16] . "</td>
           <td colspan=\"2\"><input tabindex=\"1201\" name=\"contact\" " . getData ("contact", "text") . " type=\"text\" size=\"40\" maxlength=\"255\" /></td>
           <td>" . $pedRegister[$lang][17] . "</td>
           <td colspan=\"2\"><input tabindex=\"1202\" name=\"relationContact\" " . getData ("relationContact", "text") . " type=\"text\" size=\"40\" maxlength=\"255\" /></td>
          </tr>
          <tr>
            <td>" . $pedRegister[$lang][6] . "</td>
            <td colspan=\"2\"><input tabindex=\"1203\" name=\"addrContact\" " . getData ("addrContact", "text") . " type=\"text\" size=\"40\" maxlength=\"255\" /></td>
            <td align=\"right\">" . $pedRegister[$lang][18] . "</td>
            <td colspan=\"2\"><input tabindex=\"1204\" name=\"phoneContact\" " . getData ("phoneContact", "text") . " type=\"text\" size=\"30\" maxlength=\"255\" /></td>
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

$tabIndex = 1250; 
// was $max_disclose (4, not 2)
for ($i = 1; $i <= 2; $i++) {
  echo "
    <tr>
      <td><span>" . $i . ".&nbsp;" . $discloseList[$lang][0] . " <input tabindex=\"" . ($tabIndex++) . "\" name=\"discloseStatusName" . $i . "\" " . getData ("discloseStatusName" . $i, "text") . " type=\"text\" size=\"80\" maxlength=\"255\" /></span><span>" . $discloseList[$lang][2] . " <input tabindex=\"" . ($tabIndex++) . "\" name=\"discloseStatusRel" . $i . "\" " . getData ("discloseStatusRel" . $i, "text") . " type=\"text\" size=\"25\" maxlength=\"255\" /></span></td>
    </tr>
    <tr>
      <td><span>" . $addrContact[$lang][1] . " <input tabindex=\"" . ($tabIndex++) . "\" name=\"discloseStatusAddress" . $i . "\" " . getData ("discloseStatusAddress" . $i, "text") . " type=\"text\" size=\"80\" maxlength=\"255\" /></span><span>" . $telephone[$lang][1] . " <input tabindex=\"" . ($tabIndex++) . "\" name=\"discloseStatusTelephone" . $i . "\" " . getData ("discloseStatusTelephone" . $i, "text") . " type=\"text\" size=\"25\" maxlength=\"255\" /></span></td>
    </tr>";
}
echo "
  </table>
  </div>
  
</div>
<input type=\"hidden\" name=\"encounterType\" value=\"15\"/>
";
$tabIndex = 4000;
$formName = "pedregister";
echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"register/pedregister.js\"></script>";
?>
