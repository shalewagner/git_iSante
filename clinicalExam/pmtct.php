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
    <td>&nbsp;</td>
   <tr>
    <td>
     <table class=\"b_header_nb\" border=\"0\" cellspacing =\"0\" cellpadding=\"0\">
      <tr>
       <td class=\"s_header\" colspan=\"6\">" . $clinicalExam[$lang][1] . "</td>
      </tr>
      <tr>
       <td width=\"10%\" align=\"center\" class=\"small_cnt\">" . $clinicalExam_subhead1[$lang][0] . "</td>
       <td width=\"10%\" align=\"center\" class=\"small_cnt\">" . $clinicalExam_subhead1[$lang][1] . "</td>
       <td width=\"10%\" align=\"center\" class=\"small_cnt\">" . $generalOption[$lang][2] . "</td>
       <td width=\"30%\" colspan=\"2\">&nbsp;</td>
       <td class=\"small_cnt\">&nbsp;&nbsp;" . $clinicalExam[$lang][2] . "</td>
      </tr>
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 2) . "\" id=\"physicalGeneral1\" name=\"physicalGeneral[]\" " . getData ("physicalGeneral", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 3) . "\" id=\"physicalGeneral2\" name=\"physicalGeneral[]\" " . getData ("physicalGeneral", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 4) . "\" id=\"physicalGeneral4\" name=\"physicalGeneral[]\" " . getData ("physicalGeneral", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td colspan=\"2\" class=\"small_cnt\">" . $physicalGeneral_1[$lang][0] . "</td>
       <td valign=\"top\" rowspan=\"17\"  bgcolor=\"" . $nonColoredBg.
          "\">&nbsp;&nbsp;<textarea  class=\"physical\"  tabindex=\"" . ($tabIndex + 38) .
          "\" id=\"clinicalExam\" name=\"clinicalExam\" cols=\"60\" rows=\"16\">" .
          getData ("clinicalExam", "textarea") . "</textarea></td>
      </tr>
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 5) . "\" id=\"physicalHead1\" name=\"physicalHead[]\" " . getData ("physicalHead", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 6) . "\" id=\"physicalHead2\" name=\"physicalHead[]\" " . getData ("physicalHead", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 7) . "\" id=\"physicalHead4\" name=\"physicalHead[]\" " . getData ("physicalHead", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\" colspan=\"2\">" . $physicalHead[$lang][0] . "</td>
      </tr>
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 8) . "\" id=\"physicalNeck1\" name=\"physicalNeck[]\" " . getData ("physicalNeck", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 9) . "\" id=\"physicalNeck2\" name=\"physicalNeck[]\" " . getData ("physicalNeck", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 10) . "\" id=\"physicalNeck4\" name=\"physicalNeck[]\" " . getData ("physicalNeck", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\" colspan=\"2\">" . $physicalNeck[$lang][0] . "</td>
      </tr>
	  ";

echo "
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 11) . "\" id=\"physicalLungs1\"  name=\"physicalLungs[]\" " . getData ("physicalLungs", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 12) . "\" id=\"physicalLungs2\" name=\"physicalLungs[]\" " . getData ("physicalLungs", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 13) . "\" id=\"physicalLungs4\" name=\"physicalLungs[]\" " . getData ("physicalLungs", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\" colspan=\"2\">" . $physicalLungs[$lang][1] . "</td>
      </tr> ";

echo "
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 14) . "\" id=\"physicalHeart1\" name=\"physicalHeart[]\" " . getData ("physicalHeart", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 15) . "\" id=\"physicalHeart2\" name=\"physicalHeart[]\" " . getData ("physicalHeart", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 16) . "\" id=\"physicalHeart4\" name=\"physicalHeart[]\" " . getData ("physicalHeart", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\" colspan=\"2\">" . $physicalHeart[$lang][0] . "</td>
      </tr>
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 17) . "\" id=\"physicalCentres1\" name=\"physicalCentres[]\" " . getData ("physicalCentres", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 18) . "\" id=\"physicalCentres2\" name=\"physicalCentres[]\" " . getData ("physicalCentres", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 19) . "\" id=\"physicalCentres4\" name=\"physicalCentres[]\" " . getData ("physicalCentres", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\" colspan=\"2\">" . $physicalCentres[$lang][0] . "</td>
      </tr>
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 23) . "\" id=\"physicalAbdomen1\" name=\"physicalAbdomen[]\" " . getData ("physicalAbdomen", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 24) . "\" id=\"physicalAbdomen2\" name=\"physicalAbdomen[]\" " . getData ("physicalAbdomen", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td align=\"center\"><input class=\"physical\"  tabindex=\"" . ($tabIndex + 25) . "\" id=\"physicalAbdomen4\" name=\"physicalAbdomen[]\" " . getData ("physicalAbdomen", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\" colspan=\"2\">" . $physicalAbdomen[$lang][1] . "</td>
      </tr>";
if($type == "24" || $type == "25")
{
echo "
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 26) . "\" ".getData("physicalUterine","radio",1)." id=\"physicalUterine1\" name=\"physicalUterine[]\" 
type=\"radio\" value=\"1\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 27) . "\" ".getData("physicalUterine","radio",2)." id=\"physicalUterine2\" name=\"physicalUterine[]\" type=\"radio\" value=\"2\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 28) . "\" ".getData("physicalUterine","radio",4)." id=\"physicalUterine4\" name=\"physicalUterine[]\" type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\" colspan=\"2\">" . $physicalUterine[$lang][0] . "</td>
      </tr>
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 29) . "\" id=\"physicalExternalGenitals1\" name=\"physicalExternalGenitals[]\" " . getData ("physicalExternalGenitals", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 30) . "\" id=\"physicalExternalGenitals2\" name=\"physicalExternalGenitals[]\" " . getData ("physicalExternalGenitals", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 31) . "\" id=\"physicalExternalGenitals4\" name=\"physicalExternalGenitals[]\" " . getData ("physicalExternalGenitals", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\" colspan=\"2\">" . $physicalExternalGenitals[$lang][0] . "</td>
      </tr>
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 32) . "\" id=\"physicalVagina1\" name=\"physicalVagina[]\" " . getData ("physicalVagina", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 33) . "\" id=\"physicalVagina2\" name=\"physicalVagina[]\" " . getData ("physicalVagina", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 34) . "\" id=\"physicalVagina4\" name=\"physicalVagina[]\" " . getData ("physicalVagina", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td width=\"15%\" class=\"small_cnt\">" . $physicalVagina[$lang][0] . "</td>
	   <td width=\"15%\" class=\"small_cnt\" rowspan=\"3\" valign=\"middle\">" .$physicalVaginalExam[$lang][0] . "</td>
      </tr>
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 35) . "\" id=\"physicalCollar1\" name=\"physicalCollar[]\" " . getData ("physicalCollar", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 36) . "\" id=\"physicalCollar2\" name=\"physicalCollar[]\" " . getData ("physicalCollar", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 37) . "\" id=\"physicalCollar4\" name=\"physicalCollar[]\" " . getData ("physicalCollar", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $physicalCollar[$lang][0] . "</td>
      </tr>
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 38) . "\" id=\"physicalAppendices1\" name=\"physicalAppendices[]\" " . getData ("physicalAppendices", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 39) . "\" id=\"physicalAppendices2\" name=\"physicalAppendices[]\" " . getData ("physicalAppendices", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 40) . "\" id=\"physicalAppendices4\" name=\"physicalAppendices[]\" " . getData ("physicalAppendices", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $physicalAppendices[$lang][0] . "</td>
      </tr>";
	  }
echo "
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 41) . "\" id=\"physicalRectum1\" name=\"physicalRectum[]\" " . getData ("physicalRectum", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 42) . "\" id=\"physicalRectum2\" name=\"physicalRectum[]\" " . getData ("physicalRectum", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 43) . "\" id=\"physicalRectum4\" name=\"physicalRectum[]\" " . getData ("physicalRectum", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\">" . $physicalRectum[$lang][0] . "</td>
	   <td width=\"15%\" class=\"small_cnt\" valign=\"middle\">" .$physicalRectalExam[$lang][0]	 . "</td>
      </tr>	
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 44) . "\" id=\"physicalMembers1\" name=\"physicalMembers[]\" " . getData ("physicalMembers", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 45) . "\" id=\"physicalMembers2\" name=\"physicalMembers[]\" " . getData ("physicalMembers", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 46) . "\" id=\"physicalMembers4\" name=\"physicalMembers[]\" " . getData ("physicalMembers", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\" colspan=\"2\">" . $physicalMembers[$lang][0] . "</td>
      </tr>	
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 47) . "\" id=\"physicalTendonReflexes1\"  name=\"physicalTendonReflexes[]\" " . getData ("physicalTendonReflexes", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 48) . "\" id=\"physicalTendonReflexes2\"  name=\"physicalTendonReflexes[]\" " . getData ("physicalTendonReflexes", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 49) . "\" id=\"physicalTendonReflexes4\"  name=\"physicalTendonReflexes[]\" " . getData ("physicalTendonReflexes", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\" colspan=\"2\">" . $physicalTendonReflexes[$lang][0] . "</td>
      </tr>	  
      <tr bgcolor=\"" . switchBgColor() . "\">
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 50) . "\" id=\"physicalSkin1\" name=\"physicalSkin[]\" " . getData ("physicalSkin", "radio", 1) . " type=\"radio\" value=\"1\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 51) . "\" id=\"physicalSkin2\" name=\"physicalSkin[]\" " . getData ("physicalSkin", "radio", 2) . " type=\"radio\" value=\"2\"></td>
       <td align=\"center\"><input class=\"physical\" tabindex=\"" . ($tabIndex + 52) . "\" id=\"physicalSkin4\" name=\"physicalSkin[]\" " . getData ("physicalSkin", "radio", 4) . " type=\"radio\" value=\"4\"></td>
       <td class=\"small_cnt\" colspan=\"2\">" . $physicalSkin[$lang][1] . "</td>
      </tr>
	</table>
</td></tr>";


if ($type == 24 || $type == 25){
	echo "
		<tr>
			<td>";

	include("clinicalExam/fetalStats.php");

	echo "</td></tr>";



}


?>
