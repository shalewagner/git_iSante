<?php

$coloredBg = "#D8D8D8";
$nonColoredBg = "#FFFFFF";
$bgColor = $nonColoredBg;

//Switches background colors. Used to clearly identify one table row from the previous / next.
function switchBgColor() {
 global $coloredBg, $nonColoredBg, $bgColor;
 return $bgColor = ($bgColor == $nonColoredBg) ? $coloredBg : $nonColoredBg;
}

echo "
<!-- ******************************************************************** -->
<!-- ****************************** Exams ******************************* -->
<!-- * (tab indices " . ($tabIndex + 1) . " - " . ($tabIndex + 1000) . ")* -->
<!-- ********************************************************************* -->
";

echo "
   <tr>
    <td>
     <table class=\"b_header_nb\" border=\"0\" cellspacing =\"0\" cellpadding=\"0\">
      <tr>
       <td class=\"s_header\" colspan=\"5\">" . $clinicalExam[$lang][1] . "</td>
      </tr>
      <tr>
       <td colspan=\"5\"><input tabindex=\"" . ($tabIndex + 1) . "\" id=\"physicalDone\" name=\"physicalDone\" " . getData ("physicalDone", "checkbox") . " type=\"checkbox\" value=\"On\"> <i>" . $physicalDone[$lang][1] . "</i></td>
      </tr>
      <tr>
       <td class=\"sm_header_cnt_np\">" . $clinicalExam_subhead1[$lang][0] . "</td>
       <td class=\"sm_header_cnt_np\">" . $clinicalExam_subhead1[$lang][1] . "</td>
       <td class=\"sm_header_cnt_np\">" . $clinicalExam_subhead1[$lang][2] . "</td>
       <td>&nbsp;</td>
       <td class=\"sm_header_lt\">&nbsp;&nbsp;" . $clinicalExam[$lang][2] . "</td>
      </tr>
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 2) . "\" id=\"physicalGeneral1\"  class=\"clinicalExam\"  name=\"physicalGeneral[]\" " . getData ("physicalGeneral", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 3) . "\" id=\"physicalGeneral2\"  class=\"clinicalExam\"  name=\"physicalGeneral[]\" " . getData ("physicalGeneral", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 4) . "\" id=\"physicalGeneral4\"  class=\"clinicalExam\"  name=\"physicalGeneral[]\" " . getData ("physicalGeneral", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $physicalGeneral[$lang][1] . "</td>
       <td valign=\"top\" rowspan=\"12\"  bgcolor=\"" . $nonColoredBg.
          "\">&nbsp;&nbsp;<textarea    tabindex=\"" . ($tabIndex + 38) .
          "\" id=\"clinicalExam\"  class=\"clinicalExam\"  name=\"clinicalExam\" cols=\"60\" rows=\"16\">" .
          getData ("clinicalExam", "textarea") . "</textarea></td>
      </tr>
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 5) . "\"  class=\"clinicalExam\"  id=\"physicalSkin1\"  name=\"physicalSkin[]\" " . getData ("physicalSkin", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 6) . "\"  class=\"clinicalExam\"  id=\"physicalSkin2\"  name=\"physicalSkin[]\" " . getData ("physicalSkin", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 7) . "\"  class=\"clinicalExam\"  id=\"physicalSkin4\"  name=\"physicalSkin[]\" " . getData ("physicalSkin", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $physicalSkin[$lang][1] . "</td>
      </tr>
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 8) . "\"  class=\"clinicalExam\"  id=\"physicalOral1\"  name=\"physicalOral[]\" " . getData ("physicalOral", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 9) . "\"  class=\"clinicalExam\"  id=\"physicalOral2\"  name=\"physicalOral[]\" " . getData ("physicalOral", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 10) . "\"  class=\"clinicalExam\" id=\"physicalOral4\"  name=\"physicalOral[]\" " . getData ("physicalOral", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $physicalOral[$lang][1] . "</td>
      </tr>
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 11) . "\"  class=\"clinicalExam\" id=\"physicalEarsNose1\" name=\"physicalEarsNose[]\" " . getData ("physicalEarsNose", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 12) . "\"  class=\"clinicalExam\" id=\"physicalEarsNose2\" name=\"physicalEarsNose[]\" " . getData ("physicalEarsNose", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 13) . "\"  class=\"clinicalExam\" id=\"physicalEarsNose4\" name=\"physicalEarsNose[]\" " . getData ("physicalEarsNose", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $physicalEarsNose[$lang][1] . "</td>
      </tr>";
	  
	 if (getUiConfig(getSessionUser()) == "2" || getUiConfig(getSessionUser()) == "3"){
	  echo "<tr bgcolor=\"" . switchBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 38) . "\"  class=\"clinicalExam\" id=\"physicalEyes1\" name=\"physicalEyes[]\" " . getData ("physicalEyes", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 39) . "\"  class=\"clinicalExam\" id=\"physicalEyes2\" name=\"physicalEyes[]\" " . getData ("physicalEyes", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input tabindex=\"" . ($tabIndex + 40) . "\"  class=\"clinicalExam\" id=\"physicalEyes4\" name=\"physicalEyes[]\" " . getData ("physicalEyes", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $physicalEyes[$lang][1] . "</td>
      </tr>";
      }
	  
      echo "
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 14) . "\"  class=\"clinicalExam\"  id=\"physicalLymph1\" name=\"physicalLymph[]\" " . getData ("physicalLymph", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 15) . "\"  class=\"clinicalExam\"  id=\"physicalLymph2\" name=\"physicalLymph[]\" " . getData ("physicalLymph", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 16) . "\"  class=\"clinicalExam\"  id=\"physicalLymph4\" name=\"physicalLymph[]\" " . getData ("physicalLymph", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $physicalLymph[$lang][1] . "</td>
      </tr>
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 17) . "\"  class=\"clinicalExam\"  id=\"physicalLungs1\"  name=\"physicalLungs[]\" " . getData ("physicalLungs", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 18) . "\"  class=\"clinicalExam\"  id=\"physicalLungs2\" name=\"physicalLungs[]\" " . getData ("physicalLungs", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 19) . "\"  class=\"clinicalExam\"  id=\"physicalLungs4\" name=\"physicalLungs[]\" " . getData ("physicalLungs", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $physicalLungs[$lang][1] . "</td>
      </tr>
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 20) . "\"  class=\"clinicalExam\"  id=\"physicalCardio1\" name=\"physicalCardio[]\" " . getData ("physicalCardio", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 21) . "\"  class=\"clinicalExam\"  id=\"physicalCardio2\" name=\"physicalCardio[]\" " . getData ("physicalCardio", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 22) . "\"  class=\"clinicalExam\"  id=\"physicalCardio4\" name=\"physicalCardio[]\" " . getData ("physicalCardio", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $physicalCardio[$lang][1] . "</td>
      </tr>
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 23) . "\"  class=\"clinicalExam\"  id=\"physicalAbdomen1\" name=\"physicalAbdomen[]\" " . getData ("physicalAbdomen", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 24) . "\"  class=\"clinicalExam\"  id=\"physicalAbdomen2\" name=\"physicalAbdomen[]\" " . getData ("physicalAbdomen", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input   tabindex=\"" . ($tabIndex + 25) . "\"  class=\"clinicalExam\" id=\"physicalAbdomen4\" name=\"physicalAbdomen[]\" " . getData ("physicalAbdomen", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $physicalAbdomen[$lang][1] . "</td>
      </tr>
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 26) . "\"  class=\"clinicalExam\"  id=\"physicalUro1\" name=\"physicalUro[]\" " . getData ("physicalUro", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 27) . "\"  class=\"clinicalExam\"  id=\"physicalUro2\" name=\"physicalUro[]\" " . getData ("physicalUro", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 28) . "\"  class=\"clinicalExam\"  id=\"physicalUro4\" name=\"physicalUro[]\" " . getData ("physicalUro", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $physicalUro[$lang][1] . "</td>
      </tr>
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 29) . "\"  class=\"clinicalExam\"  id=\"physicalMusculo1\" name=\"physicalMusculo[]\" " . getData ("physicalMusculo", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 30) . "\"  class=\"clinicalExam\"  id=\"physicalMusculo2\" name=\"physicalMusculo[]\" " . getData ("physicalMusculo", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 31) . "\"  class=\"clinicalExam\"  id=\"physicalMusculo4\" name=\"physicalMusculo[]\" " . getData ("physicalMusculo", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $physicalMusculo[$lang][1] . "</td>
      </tr>
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 32) . "\"  class=\"clinicalExam\"  id=\"physicalNeuro1\"  name=\"physicalNeuro[]\" " . getData ("physicalNeuro", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 33) . "\"  class=\"clinicalExam\"  id=\"physicalNeuro3\" name=\"physicalNeuro[]\" " . getData ("physicalNeuro", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 34) . "\"  class=\"clinicalExam\"  id=\"physicalNeuro4\" name=\"physicalNeuro[]\" " . getData ("physicalNeuro", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $physicalNeuro[$lang][1] . "</td>
      </tr>
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 35) . "\"  class=\"clinicalExam\"  id=\"physicalOther1\"  name=\"physicalOther[]\" " . getData ("physicalOther", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 36) . "\"  class=\"clinicalExam\"  id=\"physicalOther2\" name=\"physicalOther[]\" " . getData ("physicalOther", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($tabIndex + 37) . "\"  class=\"clinicalExam\"  id=\"physicalOther4\" name=\"physicalOther[]\" " . getData ("physicalOther", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $physicalOther[$lang][1] . " <i>" . $physicalOther[$lang][2] . "</i></td>
      </tr>
     </table>
    </td>
   </tr>

";
?>
