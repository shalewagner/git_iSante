<?php

include ("backend.php");

function addBreak ($chr = "") {
  echo "$chr<br />";
}

echo "
<html>
 <head>
  <meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-1\">
  <title>Report on Treatment Status/Outcomes for Cohorts on ART</title>
  <style type=\"text/css\">
   .popup
   {
   color: #yellow;
   cursor: help;
   text-decoration: none
   }
  </style>
 </head>
 <body>
  <table cellspacing=\"0\" cellpadding=\"2\" valign=\"bottom\" width=\"100%\" border=\"0\">
   <tr>
    <td><h3>Report on Treatment Status/Outcomes for Cohorts on ART</h3></td>
    <td align=\"right\">ART start-up groups (cohorts) are defined by month/year they started ART.</td>
   </tr>
   <tr>
    <td><h4>Facility: " . annualRepGen ("outcomesFacility") . "</h4></td>
    <td align=\"right\"></td>
   </tr>
  </table>

  <p>

  <table cellspacing=\"0\" cellpadding=\"2\" valign=\"bottom\" width=\"100%\" border=\"1\">
   <tr>
    <td colspan=\"18\">For cohort starting ART by month/year: at baseline then results at 6 months on ART, 12 months on ART, 24 months on ART</td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"7%\"><small>[mouseover column names for legend]</small></td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\"><span class=\"popup\" title=\" Started on ART at this clinic \"><b>X</b><br /></span></td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\"><span class=\"popup\" title=\" Transfers In \"><b>Y</b><br /></span></td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\"><span class=\"popup\" title=\" Number in Cohort \"><b>Z</b><br /></span></td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\"><span class=\"popup\" title=\" Continuing on Original 1st Line Regimen \"><b>H</b><br /></span></td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\"><span class=\"popup\" title=\" Substituted to Alternative 1st Line Regimen \"><b>I</b><br /></span></td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\"><span class=\"popup\" title=\" Switched to 2nd Line Regimen \"><b>J</b><br /></span></td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\"><span class=\"popup\" title=\" Stopped \"><b>D</b><br /></span></td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\"><span class=\"popup\" title=\" Died \"><b>E</b><br /></span></td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\"><span class=\"popup\" title=\" Transferred Out \"><b>F</b><br /></span></td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\"><span class=\"popup\" title=\" Lost to Follow-up (DROP) \"><b>G</b><br /></span></td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\"><span class=\"popup\" title=\" Percent of cohort alive and on ART [ (H + I + J) / Z * 100 ] \"><b>K</b><br /></span></td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\"><span class=\"popup\" title=\" CD4 median or proportion &ge; 200 (optional) \"><b>L</b><br /></span></td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\"><span class=\"popup\" title=\" Functional Status: Proportion Working \"><b>M</b><br /></span></td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\"><span class=\"popup\" title=\" Functional Status: Proportion Ambulatory \"><b>N</b><br /></span></td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\"><span class=\"popup\" title=\" Functional Status: Proportion Bedridden \"><b>O</b><br /></span></td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\"><span class=\"popup\" title=\" Number of persons who picked up ARVs each month for 6 months \"><b>P</b><br /></span></td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\"><span class=\"popup\" title=\" Number of persons who picked up ARVs each month for 12 months \"><b>Q</b><br /></span></td>
   </tr>

<!-- Testing vertically printed headers
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"7%\"></td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">
";
array_walk (str_split ("Started on ART in this clinic"), 'addBreak');
echo "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">
";
array_walk (str_split ("Transfers In"), 'addBreak');
echo "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">
";
array_walk (str_split ("Number in Cohort"), 'addBreak');
echo "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">
";
array_walk (str_split ("Continuing on Original 1st Line Regimen"), 'addBreak');
echo "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">
";
array_walk (str_split ("Substituted to Alternative 1st Line Regimen"), 'addBreak');
echo "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">
";
array_walk (str_split ("Switched to 2nd Line Regimen"), 'addBreak');
echo "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">
";
array_walk (str_split ("Stopped"), 'addBreak');
echo "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">
";
array_walk (str_split ("Died"), 'addBreak');
echo "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">
";
array_walk (str_split ("Transferred Out"), 'addBreak');
echo "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">
";
array_walk (str_split ("Lost to Follow-up (DROP)"), 'addBreak');
echo "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">
";
array_walk (str_split ("Percent of cohort alive and on ART"), 'addBreak');
echo "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">
";
array_walk (str_split ("CD4 median or proportion 200 (optional)"), 'addBreak');
echo "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">
";
array_walk (str_split ("Proportion Working"), 'addBreak');
echo "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">
";
array_walk (str_split ("Proportion Ambulatory"), 'addBreak');
echo "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">
";
array_walk (str_split ("Proportion Bedridden"), 'addBreak');
echo "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">
";
array_walk (str_split ("No. who picked up ARVs each month for 6 months"), 'addBreak');
echo "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">
";
array_walk (str_split ("No. who picked up ARVs each month for 12 months"), 'addBreak');
echo "</td>
   </tr>
-->
";

$months = array (
"Jan 04" => array ('base' => "Jan 04", '6' => "6 mo- Jul 04", '12' => "12 mo- Jan 05", '24' => "24 mo- Jan 06"),
"Feb 04" => array ('base' => "Feb 04", '6' => "6 mo- Aug 04", '12' => "12 mo- Feb 05", '24' => "24 mo- Feb 06"),
"Mar 04" => array ('base' => "Mar 04", '6' => "6 mo- Sep 04", '12' => "12 mo- Mar 05", '24' => "24 mo- Mar 06"),
"Apr 04" => array ('base' => "Apr 04", '6' => "6 mo- Oct 04", '12' => "12 mo- Apr 05", '24' => "24 mo- Apr 06"),
"May 04" => array ('base' => "May 04", '6' => "6 mo- Nov 04", '12' => "12 mo- May 05", '24' => "24 mo- May 06"),
"Jun 04" => array ('base' => "Jun 04", '6' => "6 mo- Dec 04", '12' => "12 mo- Jun 05", '24' => "24 mo- Jun 06"),
"Jul 04" => array ('base' => "Jul 04", '6' => "6 mo- Jan 05", '12' => "12 mo- Jul 05", '24' => "24 mo- Jul 06"),
"Aug 04" => array ('base' => "Aug 04", '6' => "6 mo- Feb 05", '12' => "12 mo- Aug 05", '24' => "24 mo- Aug 06"),
"Sep 04" => array ('base' => "Sep 04", '6' => "6 mo- Mar 05", '12' => "12 mo- Sep 05", '24' => "24 mo- Sep 06"),
"Oct 04" => array ('base' => "Oct 04", '6' => "6 mo- Apr 05", '12' => "12 mo- Oct 05", '24' => "24 mo- Oct 06"),
"Nov 04" => array ('base' => "Nov 04", '6' => "6 mo- May 05", '12' => "12 mo- Nov 05", '24' => "24 mo- Nov 06"),
"Dec 04" => array ('base' => "Dec 04", '6' => "6 mo- Jun 05", '12' => "12 mo- Dec 05", '24' => "24 mo- Dec 06"));

foreach ($months as $mo) {
  echo "
   <tr bgcolor=\"silver\">
    <td align=\"center\" valign=\"bottom\" width=\"7%\">Cohort " . $mo['base'] . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo . ".x") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo . ".y") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo . ".z") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo . ".h") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo . ".i") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo . ".j") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo . ".d") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo . ".e") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo . ".f") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo . ".g") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo . ".k") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo . ".l") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo . ".m") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo . ".n") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo . ".o") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">x</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">x</td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"7%\">" . $mo['6'] . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo['6'] . ".x") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo['6'] . ".y") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo['6'] . ".z") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo['6'] . ".h") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo['6'] . ".i") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo['6'] . ".j") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo['6'] . ".d") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo['6'] . ".e") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo['6'] . ".f") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo['6'] . ".g") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo['6'] . ".k") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo['6'] . ".l") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo['6'] . ".m") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo['6'] . ".n") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo['6'] . ".o") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo['6'] . ".p") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">x</td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"7%\">" . $mo['12'] . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo['12'] . ".x") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo['12'] . ".y") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo['12'] . ".z") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo['12'] . ".h") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo['12'] . ".i") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo['12'] . ".j") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo['12'] . ".d") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo['12'] . ".e") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo['12'] . ".f") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo['12'] . ".g") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo['12'] . ".k") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo['12'] . ".l") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo['12'] . ".m") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo['12'] . ".n") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo['12'] . ".o") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">x</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo['12'] . ".q") . "</td>
   </tr>
   <tr>
    <td align=\"center\" valign=\"bottom\" width=\"7%\">" . $mo['24'] . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo['24'] . ".x") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo['24'] . ".y") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo['24'] . ".z") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo['24'] . ".h") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo['24'] . ".i") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo['24'] . ".j") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo['24'] . ".d") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo['24'] . ".e") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo['24'] . ".f") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo['24'] . ".g") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo['24'] . ".k") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo['24'] . ".l") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo['24'] . ".m") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">" . annualRepGen ($mo['24'] . ".n") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">" . annualRepGen ($mo['24'] . ".o") . "</td>
    <td align=\"center\" valign=\"bottom\" width=\"6%\">x</td>
    <td align=\"center\" valign=\"bottom\" width=\"5%\">x</td>
   </tr>
";
}
echo "
  </table>

  </p>
  <p>

  <table cellspacing=\"0\" cellpadding=\"2\" valign=\"bottom\" width=\"100%\" border=\"1\">
   <tr>
    <td colspan=\"3\"><h4>Legend:</h4></td>
   </tr>
   <tr>
    <td><b>X:</b> Started on ART at this clinic</td>
    <td><b>Y:</b> Transfers In</td>
    <td><b>Z:</b> Number in Cohort</td>
   </tr>
   <tr>
    <td><b>H:</b> Continuing on Original 1st Line Regimen</td>
    <td><b>I:</b> Substituted to Alternative 1st Line Regimen</td>
    <td><b>J:</b> Switched to 2nd Line Regimen</td>
   </tr>
   <tr>
    <td><b>D:</b> Stopped</td>
    <td><b>E:</b> Died</td>
    <td><b>F:</b> Transferred Out</td>
   </tr>
   <tr>
    <td><b>G:</b> Lost to Follow-up (DROP)</td>
    <td><b>K:</b> Percent of cohort alive and on ART [ (H + I + J) / Z * 100 ]</td>
    <td><b>L:</b> CD4 median or proportion &ge; 200 (optional)</td>
   </tr>
   <tr>
    <td><b>M:</b> Functional Status: Proportion Working</td>
    <td><b>N:</b> Functional Status: Proportion Ambulatory</td>
    <td><b>O:</b> Functional Status: Proportion Bedridden</td>
   </tr>
   <tr>
    <td><b>P:</b> Number of persons who picked up ARVs each month for 6 months</td>
    <td><b>Q:</b> Number of persons who picked up ARVs each month for 12 months</td>
   </tr>
  </table>

  </p>

 </body>
</html>
";

?>
