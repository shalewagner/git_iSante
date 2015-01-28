<?php

include "backend.php";
include ("drugClauses.php");

function addBreak ($chr = "") {
  echo "$chr<br />";
}

$months = array (
"1" => array ('1' => "Jan 04", '6' => "Jul 04", '12' => "Jan 05", '24' => "Jan 06"),
"2" => array ('1' => "Feb 04", '6' => "Aug 04", '12' => "Feb 05", '24' => "Feb 06"),
"3" => array ('1' => "Mar 04", '6' => "Sep 04", '12' => "Mar 05", '24' => "Mar 06"),
"4" => array ('1' => "Apr 04", '6' => "Oct 04", '12' => "Apr 05", '24' => "Apr 06"),
"5" => array ('1' => "May 04", '6' => "Nov 04", '12' => "May 05", '24' => "May 06"),
"6" => array ('1' => "Jun 04", '6' => "Dec 04", '12' => "Jun 05", '24' => "Jun 06"),
"7" => array ('1' => "Jul 04", '6' => "Jan 05", '12' => "Jul 05", '24' => "Jul 06"),
"8" => array ('1' => "Aug 04", '6' => "Feb 05", '12' => "Aug 05", '24' => "Aug 06"),
"9" => array ('1' => "Sep 04", '6' => "Mar 05", '12' => "Sep 05", '24' => "Sep 06"),
"10" => array ('1' => "Oct 04", '6' => "Apr 05", '12' => "Oct 05", '24' => "Oct 06"),
"11" => array ('1' => "Nov 04", '6' => "May 05", '12' => "Nov 05", '24' => "Nov 06"),
"12" => array ('1' => "Dec 04", '6' => "Jun 05", '12' => "Dec 05", '24' => "Dec 06"));

function printRow ($col1 = "", $col2 = "", $chr="") {

  echo "
   <tr>
    <td align=\"center\" valign=\"center\" width=\"5\">$col1</td>
    <td valign=\"center\" width=\"400\">$col2</td>
";

  foreach ($GLOBALS['months'] as $mo => $val) {
    if (!empty ($chr)) {
      echo "
    <td align=\"center\" bgcolor=\"silver\" valign=\"center\" width=\"80\">" . annualRepGen2 ($mo . "." . $chr) . "</td>
    <td align=\"center\" valign=\"center\" width=\"80\">" . annualRepGen2 ($mo . ".6." . $chr) . "</td>
    <td align=\"center\" valign=\"center\" width=\"80\">" . annualRepGen2 ($mo . ".12." . $chr) . "</td>
    <td align=\"center\" valign=\"center\" width=\"80\">" . annualRepGen2 ($mo . ".24." . $chr) . "</td>
";
    } else {
      echo "
    <td align=\"center\" bgcolor=\"silver\" valign=\"center\" width=\"80\"></td>
    <td align=\"center\" valign=\"center\" width=\"80\"></td>
    <td align=\"center\" valign=\"center\" width=\"80\"></td>
    <td align=\"center\" valign=\"center\" width=\"80\"></td>
";
    }
  }
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
    <td><h4>Facility: " . annualRepGen2 ("outcomesFacility") . "</h4></td>
    <td align=\"right\"></td>
   </tr>
  </table>

  <p>

  <table cellspacing=\"0\" cellpadding=\"2\" valign=\"bottom\" width=\"4245\" border=\"1\">
   <tr>
    <td colspan=\"2\" valign=\"center\" width=\"405\">For cohort starting ART by month/year: at baseline then results at 6 months on ART, 12 months on ART, 24 months on ART</td>
";

foreach ($months as $mo) {
  echo "
    <td align=\"center\" bgcolor=\"silver\" valign=\"center\" width=\"80\">Cohort<br />" . $mo['1'] . "</td>
    <td align=\"center\" valign=\"center\" width=\"80\">6 mo-<br />" . $mo['6'] . "</td>
    <td align=\"center\" valign=\"center\" width=\"80\">12 mo-<br />" . $mo['12'] . "</td>
    <td align=\"center\" valign=\"center\" width=\"80\">24 mo-<br />" . $mo['24'] . "</td>
";
}

echo "
   </tr>
";
$foobar = 12;
printRow ("X", "<b>Started on ART in this clinic</b>", $foobar);
printRow ("Y", "<b>Transfers In</b>", "y");
printRow ("Z", "<b>Number in Cohort</b>", "z");
printRow ("H", "<b>Continuing in Original 1st Line Regimen</b>", "h");
printRow ("I", "<b>Substituted to Alternative 1st Line Regimen</b>", "i");
printRow ("J", "<b>Switched to 2nd Line Regimen</b>", "j");
printRow ("D", "<b>Stopped</b>", "d");
printRow ("E", "<b>Died</b>", "e");
printRow ("F", "<b>Transferred Out</b>", "f");
printRow ("G", "<b>Lost to Follow-up (DROP)</b>", "g");
printRow ("", "", "");
printRow ("", "<b>Percent of cohort alive and on ART</b>", "");
printRow ("", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[ (H + I + J) / Z * 100 ]", "k");
printRow ("", "", "");
printRow ("", "<b>CD4 median or proportion &ge; 200 (optional)</b>", "l");
printRow ("", "", "");
printRow ("", "<b>Functional Status</b>", "");
printRow ("", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Proportion Working", "m");
printRow ("", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Proportion Ambulatory", "n");
printRow ("", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Proportion Bedridden", "o");
printRow ("", "", "");
printRow ("", "Number of persons who <b>picked up ARVs each month for 6 months</b>", "p");
printRow ("", "Number of persons who <b>picked up ARVs each month for 12 months</b>", "q");

echo "
  </table>

  </p>

 </body>
</html>
";

?>
