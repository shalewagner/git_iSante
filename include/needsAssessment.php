<?php

echo "
<!-- ******************************************************************** -->
<!-- ***********************  Needs Assessment ************************** -->
<!-- * (tab indices " . ($tabIndex + 1) . " - " . ($tabIndex + 1000) . ") * -->
<!-- ********************************************************************** -->

  <table class=\"header\">
   <tr>
    <td class=\"s_header\" colspan=\"9\" width=\"100%\">" . $needsAss_header[$lang][0] . "</td>
   </tr>
   <tr>
    <td class=\"sm_header_lt\" width=\"25%\">" . $needsAss_header[$lang][1] . "</td>
    <td rowspan=\"17\" width=\"5%\">&nbsp;</td>
    <td class=\"sm_header_lt\" width=\"25%\">" . $needsAss_header[$lang][2] . "</td>
    <td rowspan=\"17\" width=\"5%\">&nbsp;</td>
    <td class=\"sm_header_lt\" width=\"20%\">" . $needsAss_header[$lang][3] . "</td>
    <td rowspan=\"17\" width=\"5%\">&nbsp;</td>
    <td class=\"sm_header_cnt\" width=\"5%\">" . $needsAss_header[$lang][4] . "</td>
    <td class=\"sm_header_cnt\" width=\"5%\">" . $needsAss_header[$lang][5] . "</td>
    <td class=\"sm_header_cnt\" width=\"5%\">" . $needsAss_header[$lang][6] . "</td>
   </tr>
   <tr>
    <td colspan=\"9\" class=\"top_line\">&nbsp;</td>
   </tr>
   <tr>
    <td width=\"25%\">" .  $needsAssLimitUnder[$lang][0] . "</td>
    <td width=\"25%\"><span><input tabindex=\"" . ($tabIndex + 1) . "\" name=\"needsAssLimitUnderStatus[]\" " . getData ("needsAssLimitUnderStatus", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $needsAssLimitUnder[$lang][2] . " <input tabindex=\"" . ($tabIndex + 2) . "\" name=\"needsAssLimitUnderStatus[]\" " . getData ("needsAssLimitUnderStatus", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $needsAssLimitUnder[$lang][3] . " <input tabindex=\"" . ($tabIndex + 3) . "\" name=\"needsAssLimitUnderStatus[]\" " . getData ("needsAssLimitUnderStatus", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $needsAssLimitUnder[$lang][4] . "</span></td>
    <td width=\"20%\"><input tabindex=\"" . ($tabIndex + 4) . "\" name=\"needsAssLimitUnderSvcs\" " . getData ("needsAssLimitUnderSvcs", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $needsAssLimitUnder[$lang][1] . "</td>
    <td class=\"sm_header_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 5) . "\" id=\"needsAssLimitUnderDel\" name=\"needsAssLimitUnderDel\" " . getData ("needsAssLimitUnderDel", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"sm_header_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 6) . "\" id=\"needsAssLimitUnderRef\" name=\"needsAssLimitUnderRef\" " . getData ("needsAssLimitUnderRef", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"sm_header_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 7) . "\" id=\"needsAssLimitUnderUn\" name=\"needsAssLimitUnderUn\" " . getData ("needsAssLimitUnderUn", "checkbox") . " type=\"radio\" value=\"On\"></td>
   </tr>
   <tr>
    <td class=\"top_pad\" width=\"25%\">" .  $needsAssDenial[$lang][0] . "</td>
    <td class=\"top_pad\" width=\"25%\"><span><input tabindex=\"" . ($tabIndex + 8) . "\" name=\"needsAssDenialStatus[]\" " . getData ("needsAssDenialStatus", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $needsAssDenial[$lang][2] . " <input tabindex=\"" . ($tabIndex + 10) . "\" name=\"needsAssDenialStatus[]\" " . getData ("needsAssDenialStatus", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $needsAssDenial[$lang][3] . " <input tabindex=\"" . ($tabIndex + 11) . "\" name=\"needsAssDenialStatus[]\" " . getData ("needsAssDenialStatus", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $needsAssDenial[$lang][4] . "</span></td>
    <td class=\"top_pad\" width=\"20%\"><input tabindex=\"" . ($tabIndex + 12) . "\" name=\"needsAssDenialSvcs\" " . getData ("needsAssDenialSvcs", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $needsAssDenial[$lang][1] . "</td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 13) . "\" id=\"needsAssDenialDel\" name=\"needsAssDenialDel\" " . getData ("needsAssDenialDel", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 14) . "\" id=\"needsAssDenialRef\" name=\"needsAssDenialRef\" " . getData ("needsAssDenialRef", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 15) . "\" id=\"needsAssDenialUn\" name=\"needsAssDenialUn\" " . getData ("needsAssDenialUn", "checkbox") . " type=\"radio\" value=\"On\"></td>
   </tr>
   <tr>
    <td class=\"top_pad\" width=\"25%\">" .  $needsAssOngRisk[$lang][0] . "</td>
    <td class=\"top_pad\" width=\"25%\"><span><input tabindex=\"" . ($tabIndex + 16) . "\" name=\"needsAssOngRiskStatus[]\" " . getData ("needsAssOngRiskStatus", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $needsAssOngRisk[$lang][2] . " <input tabindex=\"" . ($tabIndex + 18) . "\" name=\"needsAssOngRiskStatus[]\" " . getData ("needsAssOngRiskStatus", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $needsAssOngRisk[$lang][3] . " <input tabindex=\"" . ($tabIndex + 19) . "\" name=\"needsAssOngRiskStatus[]\" " . getData ("needsAssOngRiskStatus", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $needsAssOngRisk[$lang][4] . "</span></td>
    <td class=\"top_pad\" width=\"20%\"><input tabindex=\"" . ($tabIndex + 20) . "\" name=\"needsAssOngRiskSvcs\" " . getData ("needsAssOngRiskSvcs", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $needsAssOngRisk[$lang][1] . "</td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 21) . "\" id=\"needsAssOngRiskDel\" name=\"needsAssOngRiskDel\" " . getData ("needsAssOngRiskDel", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 22) . "\" id=\"needsAssOngRiskRef\" name=\"needsAssOngRiskRef\" " . getData ("needsAssOngRiskRef", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 23) . "\" id=\"needsAssOngRiskUn\" name=\"needsAssOngRiskUn\" " . getData ("needsAssOngRiskUn", "checkbox") . " type=\"radio\" value=\"On\"></td>
   </tr>
   <tr>
    <td class=\"top_pad\" width=\"25%\">" .  $needsAssBarrHome[$lang][0] . "</td>
    <td class=\"top_pad\" width=\"25%\"><span><input tabindex=\"" . ($tabIndex + 24) . "\" name=\"needsAssBarrHomeStatus[]\" " . getData ("needsAssBarrHomeStatus", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $needsAssBarrHome[$lang][2] . " <input tabindex=\"" . ($tabIndex + 26) . "\" name=\"needsAssBarrHomeStatus[]\" " . getData ("needsAssBarrHomeStatus", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $needsAssBarrHome[$lang][3] . " <input tabindex=\"" . ($tabIndex + 27) . "\" name=\"needsAssBarrHomeStatus[]\" " . getData ("needsAssBarrHomeStatus", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $needsAssBarrHome[$lang][4] . "</span></td>
    <td class=\"top_pad\" width=\"20%\"><input tabindex=\"" . ($tabIndex + 28) . "\" name=\"needsAssBarrHomeSvcs\" " . getData ("needsAssBarrHomeSvcs", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $needsAssBarrHome[$lang][1] . "</td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 29) . "\" id=\"needsAssBarrHomeDel\" name=\"needsAssBarrHomeDel\" " . getData ("needsAssBarrHomeDel", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 30) . "\" id=\"needsAssBarrHomeRef\" name=\"needsAssBarrHomeRef\" " . getData ("needsAssBarrHomeRef", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 31) . "\" id=\"needsAssBarrHomeUn\" name=\"needsAssBarrHomeUn\" " . getData ("needsAssBarrHomeUn", "checkbox") . " type=\"radio\" value=\"On\"></td>
   </tr>
   <tr>
    <td class=\"top_pad\" width=\"25%\">" .  $needsAssMentHeal[$lang][0] . "</td>
    <td class=\"top_pad\" width=\"25%\"><span><input tabindex=\"" . ($tabIndex + 32) . "\" name=\"needsAssMentHealStatus[]\" " . getData ("needsAssMentHealStatus", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $needsAssMentHeal[$lang][2] . " <input tabindex=\"" . ($tabIndex + 34) . "\" name=\"needsAssMentHealStatus[]\" " . getData ("needsAssMentHealStatus", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $needsAssMentHeal[$lang][3] . " <input tabindex=\"" . ($tabIndex + 35) . "\" name=\"needsAssMentHealStatus[]\" " . getData ("needsAssMentHealStatus", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $needsAssMentHeal[$lang][4] . "</span></td>
    <td class=\"top_pad\" width=\"20%\"><input tabindex=\"" . ($tabIndex + 36) . "\" name=\"needsAssMentHealSvcs\" " . getData ("needsAssMentHealSvcs", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $needsAssMentHeal[$lang][1] . "</td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 37) . "\" id=\"needsAssMentHealDel\" name=\"needsAssMentHealDel\" " . getData ("needsAssMentHealDel", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 38) . "\" id=\"needsAssMentHealRef\" name=\"needsAssMentHealRef\" " . getData ("needsAssMentHealRef", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 39) . "\" id=\"needsAssMentHealUn\" name=\"needsAssMentHealUn\" " . getData ("needsAssMentHealUn", "checkbox") . " type=\"radio\" value=\"On\"></td>
   </tr>
   <tr>
    <td class=\"top_pad\" width=\"25%\">" .  $needsAssSevDepr[$lang][0] . "</td>
    <td class=\"top_pad\" width=\"25%\"><span><input tabindex=\"" . ($tabIndex + 40) . "\" name=\"needsAssSevDeprStatus[]\" " . getData ("needsAssSevDeprStatus", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $needsAssSevDepr[$lang][2] . " <input tabindex=\"" . ($tabIndex + 42) . "\" name=\"needsAssSevDeprStatus[]\" " . getData ("needsAssSevDeprStatus", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $needsAssSevDepr[$lang][3] . " <input tabindex=\"" . ($tabIndex + 43) . "\" name=\"needsAssSevDeprStatus[]\" " . getData ("needsAssSevDeprStatus", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $needsAssSevDepr[$lang][4] . "</span></td>
    <td class=\"top_pad\" width=\"20%\"><input tabindex=\"" . ($tabIndex + 44) . "\" name=\"needsAssSevDeprSvcs\" " . getData ("needsAssSevDeprSvcs", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $needsAssSevDepr[$lang][1] . "</td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 45) . "\" id=\"needsAssSevDeprDel\" name=\"needsAssSevDeprDel\" " . getData ("needsAssSevDeprDel", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 46) . "\" id=\"needsAssSevDeprRef\" name=\"needsAssSevDeprRef\" " . getData ("needsAssSevDeprRef", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 47) . "\" id=\"needsAssSevDeprUn\" name=\"needsAssSevDeprUn\" " . getData ("needsAssSevDeprUn", "checkbox") . " type=\"radio\" value=\"On\"></td>
   </tr>
   <tr>
    <td class=\"top_pad\" width=\"25%\">" .  $needsAssPreg[$lang][0] . "</td>
    <td class=\"top_pad\" width=\"25%\"><span ><input tabindex=\"" . ($tabIndex + 48) . "\" name=\"needsAssPregStatus[]\" " . getData ("needsAssPregStatus", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $needsAssPreg[$lang][2] . " <input tabindex=\"" . ($tabIndex + 50) . "\" name=\"needsAssPregStatus[]\" " . getData ("needsAssPregStatus", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $needsAssPreg[$lang][3] . " <input tabindex=\"" . ($tabIndex + 51) . "\" name=\"needsAssPregStatus[]\" " . getData ("needsAssPregStatus", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $needsAssPreg[$lang][4] . "</span></td>
    <td class=\"top_pad\" width=\"20%\"><input tabindex=\"" . ($tabIndex + 52) . "\" name=\"needsAssPregSvcs\" " . getData ("needsAssPregSvcs", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $needsAssPreg[$lang][1] . "</td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 53) . "\" id=\"needsAssPregDel\" name=\"needsAssPregDel\" " . getData ("needsAssPregDel", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 54) . "\" id=\"needsAssPregRef\" name=\"needsAssPregRef\" " . getData ("needsAssPregRef", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 55) . "\" id=\"needsAssPregUn\" name=\"needsAssPregUn\" " . getData ("needsAssPregUn", "checkbox") . " type=\"radio\" value=\"On\"></td>
   </tr>
   <tr>
    <td class=\"top_pad\" width=\"25%\">" .  $needsAssDrugs[$lang][0] . "</td>
    <td class=\"top_pad\" width=\"25%\"><span><input tabindex=\"" . ($tabIndex + 56) . "\" name=\"needsAssDrugsStatus[]\" " . getData ("needsAssDrugsStatus", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $needsAssDrugs[$lang][2] . " <input tabindex=\"" . ($tabIndex + 58) . "\" name=\"needsAssDrugsStatus[]\" " . getData ("needsAssDrugsStatus", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $needsAssDrugs[$lang][3] . " <input tabindex=\"" . ($tabIndex + 59) . "\" name=\"needsAssDrugsStatus[]\" " . getData ("needsAssDrugsStatus", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $needsAssDrugs[$lang][4] . "</span></td>
    <td class=\"top_pad\" width=\"20%\"><input tabindex=\"" . ($tabIndex + 60) . "\" name=\"needsAssDrugsSvcs\" " . getData ("needsAssDrugsSvcs", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $needsAssDrugs[$lang][1] . "</td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 61) . "\" id=\"needsAssDrugsDel\" name=\"needsAssDrugsDel\" " . getData ("needsAssDrugsDel", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 62) . "\" id=\"needsAssDrugsRef\" name=\"needsAssDrugsRef\" " . getData ("needsAssDrugsRef", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 63) . "\" id=\"needsAssDrugsUn\" name=\"needsAssDrugsUn\" " . getData ("needsAssDrugsUn", "checkbox") . " type=\"radio\" value=\"On\"></td>
   </tr>
   <tr>
    <td class=\"top_pad\" width=\"25%\">" .  $needsAssViol[$lang][0] . "</td>
    <td class=\"top_pad\" width=\"25%\"><span><input tabindex=\"" . ($tabIndex + 64) . "\" name=\"needsAssViolStatus[]\" " . getData ("needsAssViolStatus", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $needsAssViol[$lang][2] . " <input tabindex=\"" . ($tabIndex + 66) . "\" name=\"needsAssViolStatus[]\" " . getData ("needsAssViolStatus", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $needsAssViol[$lang][3] . " <input tabindex=\"" . ($tabIndex + 67) . "\" name=\"needsAssViolStatus[]\" " . getData ("needsAssViolStatus", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $needsAssViol[$lang][4] . "</span></td>
    <td class=\"top_pad\" width=\"20%\"><input tabindex=\"" . ($tabIndex + 68) . "\" name=\"needsAssViolSvcs\" " . getData ("needsAssViolSvcs", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $needsAssViol[$lang][1] . "</td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 69) . "\" id=\"needsAssViolDel\" name=\"needsAssViolDel\" " . getData ("needsAssViolDel", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 70) . "\" id=\"needsAssViolRef\" name=\"needsAssViolRef\" " . getData ("needsAssViolRef", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 71) . "\" id=\"needsAssViolUn\" name=\"needsAssViolUn\" " . getData ("needsAssViolUn", "checkbox") . " type=\"radio\" value=\"On\"></td>
   </tr>
   <tr>
    <td class=\"top_pad\" width=\"25%\">" .  $needsAssFamPlan[$lang][0] . "</td>
    <td class=\"top_pad\" width=\"25%\"><span><input tabindex=\"" . ($tabIndex + 72) . "\" name=\"needsAssFamPlanStatus[]\" " . getData ("needsAssFamPlanStatus", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $needsAssFamPlan[$lang][2] . " <input tabindex=\"" . ($tabIndex + 74) . "\" name=\"needsAssFamPlanStatus[]\" " . getData ("needsAssFamPlanStatus", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $needsAssFamPlan[$lang][3] . " <input tabindex=\"" . ($tabIndex + 75) . "\" name=\"needsAssFamPlanStatus[]\" " . getData ("needsAssFamPlanStatus", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $needsAssFamPlan[$lang][4] . "</span></td>
    <td class=\"top_pad\" width=\"20%\"><input tabindex=\"" . ($tabIndex + 76) . "\" name=\"needsAssFamPlanSvcs\" " . getData ("needsAssFamPlanSvcs", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $needsAssFamPlan[$lang][1] . "</td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 77) . "\" id=\"needsAssFamPlanDel\" name=\"needsAssFamPlanDel\" " . getData ("needsAssFamPlanDel", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 78) . "\" id=\"needsAssFamPlanRef\" name=\"needsAssFamPlanRef\" " . getData ("needsAssFamPlanRef", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 79) . "\" id=\"needsAssFamPlanUn\" name=\"needsAssFamPlanUn\" " . getData ("needsAssFamPlanUn", "checkbox") . " type=\"radio\" value=\"On\"></td>
   </tr>
   <tr>
    <td class=\"top_pad\" width=\"25%\">" .  $needsAssTrans[$lang][0] . "</td>
    <td class=\"top_pad\" width=\"25%\"><span><input tabindex=\"" . ($tabIndex + 80) . "\" name=\"needsAssTransStatus[]\" " . getData ("needsAssTransStatus", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $needsAssTrans[$lang][2] . " <input tabindex=\"" . ($tabIndex + 82) . "\" name=\"needsAssTransStatus[]\" " . getData ("needsAssTransStatus", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $needsAssTrans[$lang][3] . " <input tabindex=\"" . ($tabIndex + 83) . "\" name=\"needsAssTransStatus[]\" " . getData ("needsAssTransStatus", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $needsAssTrans[$lang][4] . "</span></td>
    <td class=\"top_pad\" width=\"20%\"><input tabindex=\"" . ($tabIndex + 84) . "\" name=\"needsAssTransSvcs\" " . getData ("needsAssTransSvcs", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $needsAssTrans[$lang][1] . "</td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 85) . "\" id=\"needsAssTransDel\" name=\"needsAssTransDel\" " . getData ("needsAssTransDel", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 86) . "\" id=\"needsAssTransRef\" name=\"needsAssTransRef\" " . getData ("needsAssTransRef", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 87) . "\" id=\"needsAssTransUn\" name=\"needsAssTransUn\" " . getData ("needsAssTransUn", "checkbox") . " type=\"radio\" value=\"On\"></td>
   </tr>
   <tr>
    <td class=\"top_pad\" width=\"25%\">" .  $needsAssHousing[$lang][0] . "</td>
    <td class=\"top_pad\" width=\"25%\"><span><input tabindex=\"" . ($tabIndex + 88) . "\" name=\"needsAssHousingStatus[]\" " . getData ("needsAssHousingStatus", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $needsAssHousing[$lang][2] . " <input tabindex=\"" . ($tabIndex + 90) . "\" name=\"needsAssHousingStatus[]\" " . getData ("needsAssHousingStatus", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $needsAssHousing[$lang][3] . " <input tabindex=\"" . ($tabIndex + 91) . "\" name=\"needsAssHousingStatus[]\" " . getData ("needsAssHousingStatus", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $needsAssHousing[$lang][4] . "</span></td>
    <td class=\"top_pad\" width=\"20%\"><input tabindex=\"" . ($tabIndex + 92) . "\" name=\"needsAssHousingSvcs\" " . getData ("needsAssHousingSvcs", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $needsAssHousing[$lang][1] . "</td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 93) . "\" id=\"needsAssHousingDel\" name=\"needsAssHousingDel\" " . getData ("needsAssHousingDel", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 94) . "\" id=\"needsAssHousingRef\" name=\"needsAssHousingRef\" " . getData ("needsAssHousingRef", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 95) . "\" id=\"needsAssHousingUn\" name=\"needsAssHousingUn\" " . getData ("needsAssHousingUn", "checkbox") . " type=\"radio\" value=\"On\"></td>
   </tr>
   <tr>
    <td class=\"top_pad\" width=\"25%\">" .  $needsAssNutr[$lang][0] . "</td>
    <td class=\"top_pad\" width=\"25%\"><span><input tabindex=\"" . ($tabIndex + 96) . "\" name=\"needsAssNutrStatus[]\" " . getData ("needsAssNutrStatus", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $needsAssNutr[$lang][2] . " <input tabindex=\"" . ($tabIndex + 98) . "\" name=\"needsAssNutrStatus[]\" " . getData ("needsAssNutrStatus", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $needsAssNutr[$lang][3] . " <input tabindex=\"" . ($tabIndex + 99) . "\" name=\"needsAssNutrStatus[]\" " . getData ("needsAssNutrStatus", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $needsAssNutr[$lang][4] . "</span></td>
    <td class=\"top_pad\" width=\"20%\"><input tabindex=\"" . ($tabIndex + 100) . "\" name=\"needsAssNutrSvcs\" " . getData ("needsAssNutrSvcs", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $needsAssNutr[$lang][1] . "</td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 101) . "\" id=\"needsAssNutrDel\" name=\"needsAssNutrDel\" " . getData ("needsAssNutrDel", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 102) . "\" id=\"needsAssNutrRef\" name=\"needsAssNutrRef\" " . getData ("needsAssNutrRef", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 103) . "\" id=\"needsAssNutrUn\" name=\"needsAssNutrUn\" " . getData ("needsAssNutrUn", "checkbox") . " type=\"radio\" value=\"On\"></td>
   </tr>
   <tr>
    <td class=\"top_pad\" width=\"25%\">" .  $needsAssHyg[$lang][0] . "</td>
    <td class=\"top_pad\" width=\"25%\"><span><input tabindex=\"" . ($tabIndex + 104) . "\" name=\"needsAssHygStatus[]\" " . getData ("needsAssHygStatus", "checkbox", 1) . " type=\"radio\" value=\"1\"> " . $needsAssHyg[$lang][2] . " <input tabindex=\"" . ($tabIndex + 106) . "\" name=\"needsAssHygStatus[]\" " . getData ("needsAssHygStatus", "checkbox", 2) . " type=\"radio\" value=\"2\"> " . $needsAssHyg[$lang][3] . " <input tabindex=\"" . ($tabIndex + 107) . "\" name=\"needsAssHygStatus[]\" " . getData ("needsAssHygStatus", "checkbox", 4) . " type=\"radio\" value=\"4\"> " . $needsAssHyg[$lang][4] . "</span></td>
    <td class=\"top_pad\" width=\"20%\"><input tabindex=\"" . ($tabIndex + 108) . "\" name=\"needsAssHygSvcs\" " . getData ("needsAssHygSvcs", "checkbox") . " type=\"checkbox\" value=\"On\"> " . $needsAssHyg[$lang][1] . "</td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 109) . "\" id=\"needsAssHygDel\" name=\"needsAssHygDel\" " . getData ("needsAssHygDel", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 110) . "\" id=\"needsAssHygRef\" name=\"needsAssHygRef\" " . getData ("needsAssHygRef", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 111) . "\" id=\"needsAssHygUn\" name=\"needsAssHygUn\" " . getData ("needsAssHygUn", "checkbox") . " type=\"radio\" value=\"On\"></td>
   </tr>
   <tr>
    <td class=\"top_pad\" width=\"25%\">" .  $needsAssOther[$lang][0] . " <input tabindex=\"" . ($tabIndex + 112) . "\" name=\"needsAssOtherText\" " . getData ("needsAssOtherText", "text") . " type=\"text\"  maxlength=\"255\"/></td>
    <td class=\"top_pad\" width=\"25%\"><span><input tabindex=\"" . ($tabIndex + 113) . "\" name=\"needsAssOtherStatus[]\" " . getData ("needsAssOtherStatus", "checkbox", 1) . " type=\"radio\" value=\"1\"/> " . $needsAssOther[$lang][2] . " <input tabindex=\"" . ($tabIndex + 115) . "\" name=\"needsAssOtherStatus[]\" " . getData ("needsAssOtherStatus", "checkbox", 2) . " type=\"radio\" value=\"2\"/> " . $needsAssOther[$lang][3] . " <input tabindex=\"" . ($tabIndex + 116) . "\" name=\"needsAssOtherStatus[]\" " . getData ("needsAssOtherStatus", "checkbox", 4) . " type=\"radio\" value=\"4\"/> " . $needsAssOther[$lang][4] . "</span></td>
    <td class=\"top_pad\" width=\"20%\"><input tabindex=\"" . ($tabIndex + 117) . "\" name=\"needsAssOtherSvcs\" " . getData ("needsAssOtherSvcs", "checkbox") . " type=\"checkbox\" value=\"On\"/> <input tabindex=\"" . ($tabIndex + 118) . "\" name=\"needsAssOtherSvcsText\" " . getData ("needsAssOtherSvcsText", "text") . " type=\"text\"  maxlength=\"255\"/></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 119) . "\" id=\"needsAssOtherDel\" name=\"needsAssOtherDel\" " . getData ("needsAssOtherDel", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 120) . "\" id=\"needsAssOtherRef\" name=\"needsAssOtherRef\" " . getData ("needsAssOtherRef", "checkbox") . " type=\"radio\" value=\"On\"></td>
    <td class=\"top_pad_cnt\" width=\"5%\"><input tabindex=\"" . ($tabIndex + 121) . "\" id=\"needsAssOtherUn\" name=\"needsAssOtherUn\" " . getData ("needsAssOtherUn", "checkbox") . " type=\"radio\" value=\"On\"></td>
   </tr>
  </table>
";
?>
