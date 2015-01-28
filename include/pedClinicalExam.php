<?php

$coloredBg = "#D8D8D8";
$nonColoredBg = "#FFFFFF";
$bgColor = $nonColoredBg;

//Switches background colors. Used to clearly identify one table row from the previous / next.
function swicthBgColor() {
 global $coloredBg, $nonColoredBg, $bgColor;
 return $bgColor = ($bgColor == $nonColoredBg) ? $coloredBg : $nonColoredBg;
}

echo "
<!-- ****************************************************************** -->
<!-- ****************************** Exams ******************************- -->
<!-- ****************** (tab indices " . ($tabIndex + 1) . " - " . ($tabIndex + 200) . ") ********************* -->
<!-- ******************************************************************** -->
";

echo "
   <tr>
    <td colspan=\"3\">
     <table class=\"b_header_nb\">
      <tr>
       <td class=\"s_header\" colspan=\"5\">" . $pedExam[$lang][0] . "</td>
      </tr>
      <tr>
       <td class=\"sm_header_cnt_np\">" . $pedExam[$lang][1] . "</td>
       <td class=\"sm_header_cnt_np\">" . $pedExam[$lang][2] . "</td>
       <td class=\"sm_header_cnt_np\">" . $pedExam[$lang][3] . "</td>
       <td>&nbsp;</td>
       <td class=\"sm_header_lt\">&nbsp;&nbsp;" . $pedExam[$lang][4] . "</td>
      </tr>
      <tr bgcolor=\"" . swicthBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 1) . "\" name=\"physicalGeneral[]\" " . getData ("physicalGeneral", "checkbox", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 2) . "\" name=\"physicalGeneral[]\" " . getData ("physicalGeneral", "checkbox", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 3) . "\" name=\"physicalGeneral[]\" " . getData ("physicalGeneral", "checkbox", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $pedExam[$lang][5] . "</td>
       <td valign=\"top\" rowspan=\"16\"  bgcolor=\"" . $nonColoredBg.
          "\">&nbsp;&nbsp;<textarea tabindex=\"" . ($tabIndex + 49) .
          "\" name=\"clinicalExam\" cols=\"60\" rows=\"17\">" .
          getData ("clinicalExam", "textarea") . "</textarea></td>
      </tr>
      <tr bgcolor=\"" . swicthBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 4) . "\" name=\"physicalSkin[]\" " . getData ("physicalSkin", "checkbox", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 5) . "\" name=\"physicalSkin[]\" " . getData ("physicalSkin", "checkbox", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 6) . "\" name=\"physicalSkin[]\" " . getData ("physicalSkin", "checkbox", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $pedExam[$lang][6] . "</td>
      </tr>
      <tr bgcolor=\"" . swicthBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 7) . "\" name=\"physicalOral[]\" " . getData ("physicalOral", "checkbox", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 8) . "\" name=\"physicalOral[]\" " . getData ("physicalOral", "checkbox", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 9) . "\" name=\"physicalOral[]\" " . getData ("physicalOral", "checkbox", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $pedExam[$lang][7] . "</td>
      </tr>
      <tr bgcolor=\"" . swicthBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 10) . "\" name=\"physicalEarsNose[]\" " . getData ("physicalEarsNose", "checkbox", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 11) . "\" name=\"physicalEarsNose[]\" " . getData ("physicalEarsNose", "checkbox", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 12) . "\" name=\"physicalEarsNose[]\" " . getData ("physicalEarsNose", "checkbox", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $pedExam[$lang][8] . "</td>
      </tr>
      <tr bgcolor=\"" . swicthBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 13) . "\" name=\"pedExamEyes[]\" " . getData ("pedExamEyes", "checkbox", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 14) . "\" name=\"pedExamEyes[]\" " . getData ("pedExamEyes", "checkbox", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 15) . "\" name=\"pedExamEyes[]\" " . getData ("pedExamEyes", "checkbox", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $pedExam[$lang][9] . "</td>
      </tr>
      <tr bgcolor=\"" . swicthBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 16) . "\" name=\"pedExamHeadNeck[]\" " . getData ("pedExamHeadNeck", "checkbox", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 17) . "\" name=\"pedExamHeadNeck[]\" " . getData ("pedExamHeadNeck", "checkbox", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 18) . "\" name=\"pedExamHeadNeck[]\" " . getData ("pedExamHeadNeck", "checkbox", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $pedExam[$lang][10] . "</td>
      </tr>
      <tr bgcolor=\"" . swicthBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 19) . "\" name=\"physicalLymph[]\" " . getData ("physicalLymph", "checkbox", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 20) . "\" name=\"physicalLymph[]\" " . getData ("physicalLymph", "checkbox", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 21) . "\" name=\"physicalLymph[]\" " . getData ("physicalLymph", "checkbox", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $pedExam[$lang][11] . "</td>
      </tr>
      <tr bgcolor=\"" . swicthBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 22) . "\" name=\"physicalLungs[]\" " . getData ("physicalLungs", "checkbox", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 23) . "\" name=\"physicalLungs[]\" " . getData ("physicalLungs", "checkbox", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 24) . "\" name=\"physicalLungs[]\" " . getData ("physicalLungs", "checkbox", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $pedExam[$lang][12] . "</td>
      </tr>
      <tr bgcolor=\"" . swicthBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 25) . "\" name=\"physicalCardio[]\" " . getData ("physicalCardio", "checkbox", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 26) . "\" name=\"physicalCardio[]\" " . getData ("physicalCardio", "checkbox", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 27) . "\" name=\"physicalCardio[]\" " . getData ("physicalCardio", "checkbox", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $pedExam[$lang][13] . "</td>
      </tr>
      <tr bgcolor=\"" . swicthBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 28) . "\" name=\"physicalAbdomen[]\" " . getData ("physicalAbdomen", "checkbox", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 29) . "\" name=\"physicalAbdomen[]\" " . getData ("physicalAbdomen", "checkbox", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 30) . "\" name=\"physicalAbdomen[]\" " . getData ("physicalAbdomen", "checkbox", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $pedExam[$lang][14] . "</td>
      </tr>
      <tr bgcolor=\"" . swicthBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 31) . "\" name=\"pedExamLimbs[]\" " . getData ("pedExamLimbs", "checkbox", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 32) . "\" name=\"pedExamLimbs[]\" " . getData ("pedExamLimbs", "checkbox", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 33) . "\" name=\"pedExamLimbs[]\" " . getData ("pedExamLimbs", "checkbox", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $pedExam[$lang][15] . "</td>
      </tr>
      <tr bgcolor=\"" . swicthBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 34) . "\" name=\"pedExamBreast[]\" " . getData ("pedExamBreast", "checkbox", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 35) . "\" name=\"pedExamBreast[]\" " . getData ("pedExamBreast", "checkbox", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 36) . "\" name=\"pedExamBreast[]\" " . getData ("pedExamBreast", "checkbox", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $pedExam[$lang][16] . "</td>
      </tr>
      <tr bgcolor=\"" . swicthBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 37) . "\" name=\"physicalUro[]\" " . getData ("physicalUro", "checkbox", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 38) . "\" name=\"physicalUro[]\" " . getData ("physicalUro", "checkbox", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 39) . "\" name=\"physicalUro[]\" " . getData ("physicalUro", "checkbox", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $pedExam[$lang][17] . "</td>
      </tr>
      <tr bgcolor=\"" . swicthBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 40) . "\" name=\"physicalMusculo[]\" " . getData ("physicalMusculo", "checkbox", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 41) . "\" name=\"physicalMusculo[]\" " . getData ("physicalMusculo", "checkbox", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 42) . "\" name=\"physicalMusculo[]\" " . getData ("physicalMusculo", "checkbox", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $pedExam[$lang][18] . "</td>
      </tr>
      <tr bgcolor=\"" . swicthBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 43) . "\" name=\"physicalNeuro[]\" " . getData ("physicalNeuro", "checkbox", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 44) . "\" name=\"physicalNeuro[]\" " . getData ("physicalNeuro", "checkbox", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 45) . "\" name=\"physicalNeuro[]\" " . getData ("physicalNeuro", "checkbox", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $pedExam[$lang][19] . "</td>
      </tr>
      <tr bgcolor=\"" . swicthBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 46) . "\" name=\"physicalOther[]\" " . getData ("physicalOther", "checkbox", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 47) . "\" name=\"physicalOther[]\" " . getData ("physicalOther", "checkbox", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 48) . "\" name=\"physicalOther[]\" " . getData ("physicalOther", "checkbox", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $pedExam[$lang][20] . " <i>" . $pedExam[$lang][21] . "</i></td>
      </tr>
     </table>
    </td>
   </tr>

";
?>
