<?
$locIndex = 4246; 
if ($_REQUEST['type'] == "1" || $_REQUEST['type'] == "2") $locIndex = 4235;
echo "
<tr bgcolor=\"" . switchBgColor() . "\">
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td class=\"small_cnt\">Lymphad&eacute;nopathie :</td>
</tr>
<tr bgcolor=\"" . switchBgColor() . "\">
 <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($locIndex++) . "\"  class=\"clinicalExam\"  id=\"physicalCervical1\"  name=\"physicalCervical\" " . getData ("physicalCervical", "radio", 1) . " type=\"radio\" value=\"1\"></td>
 <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($locIndex++) . "\"  class=\"clinicalExam\"  id=\"physicalCervical2\" name=\"physicalCervical\" " . getData ("physicalCervical", "radio", 2) . " type=\"radio\" value=\"2\"></td>
 <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($locIndex++) . "\"  class=\"clinicalExam\"  id=\"physicalCervical3\" name=\"physicalCervical\" " . getData ("physicalCervical", "radio", 4) . " type=\"radio\" value=\"4\"></td>
 <td class=\"small_cnt\">--Cervicale</td>
</tr>
<tr bgcolor=\"" . switchBgColor() . "\">
 <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($locIndex++) . "\"  class=\"clinicalExam\"  id=\"physicalSupraclavicular1\"  name=\"physicalSupraclavicular\" " . getData ("physicalSupraclavicular", "radio", 1) . " type=\"radio\" value=\"1\"></td>
 <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($locIndex++) . "\"  class=\"clinicalExam\"  id=\"physicalSupraclavicular2\" name=\"physicalSupraclavicular\" " . getData ("physicalSupraclavicular", "radio", 2) . " type=\"radio\" value=\"2\"></td>
 <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($locIndex++) . "\"  class=\"clinicalExam\"  id=\"physicalSupraclavicular3\" name=\"physicalSupraclavicular\" " . getData ("physicalSupraclavicular", "radio", 4) . " type=\"radio\" value=\"4\"></td>
 <td class=\"small_cnt\">--Supraclaviculaire</td>
</tr>
<tr bgcolor=\"" . switchBgColor() . "\">
 <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($locIndex++) . "\"  class=\"clinicalExam\"  id=\"physicalAxillary1\"  name=\"physicalAxillary\" " . getData ("physicalAxillary", "radio", 1) . " type=\"radio\" value=\"1\"></td>
 <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($locIndex++) . "\"  class=\"clinicalExam\"  id=\"physicalAxillary2\" name=\"physicalAxillary\" " . getData ("physicalAxillary", "radio", 2) . " type=\"radio\" value=\"2\"></td>
 <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($locIndex++) . "\"  class=\"clinicalExam\"  id=\"physicalAxillary3\" name=\"physicalAxillary\" " . getData ("physicalAxillary", "radio", 4) . " type=\"radio\" value=\"4\"></td>
 <td class=\"small_cnt\">--Axillaire</td>
</tr>
<tr bgcolor=\"" . switchBgColor() . "\">
 <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($locIndex++) . "\"  class=\"clinicalExam\"  id=\"physicalInguinal1\"  name=\"physicalInguinal\" " . getData ("physicalInguinal", "radio", 1) . " type=\"radio\" value=\"1\"></td>
 <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($locIndex++) . "\"  class=\"clinicalExam\"  id=\"physicalInguinal2\" name=\"physicalInguinal\" " . getData ("physicalInguinal", "radio", 2) . " type=\"radio\" value=\"2\"></td>
 <td class=\"sm_header_cnt_np\"><input  tabindex=\"" . ($locIndex++) . "\"  class=\"clinicalExam\"  id=\"physicalInguinal3\" name=\"physicalInguinal\" " . getData ("physicalInguinal", "radio", 4) . " type=\"radio\" value=\"4\"></td>
 <td class=\"small_cnt\">--Inguinale</td>
</tr>
";
?>