<?php
require_once 'backend.php';
$lang = !empty ($_REQUEST['lang']) ? $_REQUEST['lang'] : "fr";
$ts = !empty ($_REQUEST['ts']) ? $_REQUEST['ts'] : "";
$conn = !empty ($_REQUEST['conn']) ? $_REQUEST['conn'] : "";
$report = !empty ($_REQUEST['report']) ? $_REQUEST['report'] : "";
$username = !empty ($_REQUEST['username']) ? $_REQUEST['username'] : "";
$val1 = !empty ($_REQUEST['val1']) ? $_REQUEST['val1'] : "";
$val2 = !empty ($_REQUEST['val2']) ? $_REQUEST['val2'] : "";
$val3 = !empty ($_REQUEST['val3']) ? $_REQUEST['val3'] : "";
$siteList = "";

// Get report title
$xml = loadXMLFile("jrxml/reports.xml");
$xpath = "reportSet[@rtype='$rtype']/reportSubSet/report[@id='$report']";
$xmlRep = $xml->xpath($xpath);
$titleArray = $xml->xpath("//report[@id='$report']/title[@lang='$lang']");
$title = $titleArray[0];

// Get site names from list, if any
if (!empty ($val3)) {
  $result = dbQuery ("
    SELECT clinic
    FROM clinicLookup
    WHERE siteCode IN ($val3)
    ORDER BY 1");
  while ($row = psRowFetch ($result)) {
    if (!empty ($row[0])) {
      $siteList .= $row[0] . ",";
    }
  }
  $siteList = substr ($siteList, 0, strlen ($siteList) - 1);
}

echo "
<html>
 <head>
  <title>" . $alreadyRunning[$lang][0] . "</title>
  <link href=\"default.css\" type=\"text/css\" rel=\"StyleSheet\">
 </head>
 <body>";

echo "<center>
   <h3>" . $alreadyRunning[$lang][0] . "</h3>
   <h4>" . $alreadyRunning[$lang][1] . "</h4>";

echo "
   <h4>" . $alreadyRunning[$lang][2] . "<br/>
   <table style=\"font-family: Verdana,Arial,Helvetica,sans-serif; color: #444; font-size: 11px; line-height: 1.5em;\" border=\"0\" width=\"50%\">
    <tr>
     <td valign=\"top\" width=\"50%\"><h4>" . $alreadyRunning[$lang][3] . "</h4></td>
     <td valign=\"top\" width=\"50%\"><h4>" . $title . "</h4></td>
    </tr>
    <tr>
     <td valign=\"top\" width=\"50%\"><h4>" . $alreadyRunning[$lang][4] . "</h4></td>
     <td valign=\"top\" width=\"50%\"><h4>" . $ts . "</h4></td>
    </tr>
    <tr>
     <td valign=\"top\" width=\"50%\"><h4>" . $alreadyRunning[$lang][5] . "</h4></td>
     <td valign=\"top\" width=\"50%\"><h4>" . $val1 . "</h4></td>
    </tr>
    <tr>
     <td valign=\"top\" width=\"50%\"><h4>" . $alreadyRunning[$lang][6] . "</h4></td>
     <td valign=\"top\" width=\"50%\"><h4>" . $val2 . "</h4></td>
    </tr>
    <tr>
     <td valign=\"top\" width=\"50%\"><h4>" . $alreadyRunning[$lang][7] . "</h4></td>
     <td valign=\"top\" width=\"50%\"><h4>";

foreach (split (",", $siteList) as $site) {
  echo "
        " . $site . "<br/>";
}

echo "</h4></td>
    </tr>
   </table></h4>";

if (!empty ($conn)) {
  echo "
   <h4>" . $alreadyRunning[$lang][9] . "<br/>
   <a onClick=\"javascript:return confirm('" . $alreadyRunning[$lang][14] . "')\" href=\"stopReport.php?ts=" . urlencode ($ts) . "&conn=$conn&report=$report&username=$username&lang=$lang\">" . $alreadyRunning[$lang][10] . "</a>&nbsp; | &nbsp;
   <a href=\"javascript:window.close()\">" . $alreadyRunning[$lang][11] . "</a></h4>";
} else {
  echo "
   <h4>" . $alreadyRunning[$lang][8] . "<br/>
   <a href=\"javascript:window.close()\">" . $alreadyRunning[$lang][11] . "</a></h4>";
}

echo "
 </center>
 </body>
</html>
";
?>
