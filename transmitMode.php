<?php

require_once 'backend.php';
require_once 'labels/report.php';
require_once 'labels/reportSetupLabels.php';

//$errors = getErrors ($_POST, 14, 1);

if (!empty ($_GET['lang'])) $lang = $_GET['lang'];
if (!empty ($_POST['lang'])) $lang = $_POST['lang'];
$lang = (empty ($lang) || !in_array ($lang, $langs)) ? $def_lang : $lang;

$debugFlag = true;

if (!empty ($_GET['siteCode'])) $siteCode = $_GET['siteCode'];
if (!empty ($_POST['siteCode'])) $siteCode = $_POST['siteCode'];
$sites = array();
if ($siteCode != "ALL") {
	$qry = "select distinct rtrim(r.siteCode) as siteCode from riskAssessment r, encValid v
		where v.siteCode = r.siteCode order by 1";
	$result = dbQuery($qry);
	$numSites = 0;
	while ($row = psRowFetchNum($result)) {
		$sites[$numSites] = $row[0];
		$numSites++;
	}
} else {
	$numSites = 1;
	$sites[0] = "All Sites";
}

//$startMm = $_POST['startMm'];
//$startYy = $_POST['startYy'];
// put date in YYMM format
//$startDate = $startYy . $startMm;
$startDate = "0101";

//$endMm = $_POST['endMm'];
//$endYy = $_POST['endYy'];
//$endDate = $endYy . $endMm;
$endDate = "1207";

//$year = $startYy;
$year = "01";
//$month = $startMm;
$month = "01";
$unixStartDate = mktime(0,0,0, $month, 1, $year);
//$year = $endYy;
$year = "07";
//$month = $endMm;
$month = "12";
$unixEndDate = mktime(0,0,0, $month, 1, $year);

echo "
<html>
 <head>
  <meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-1\">
  <title>Mode probable de transmission</title>
  <link href=\"default.css\" type=\"text/css\" rel=\"StyleSheet\">
 </head>
 <body>
  <table class=\"header\">
	<tr>
	<td class=\"m_header\">
		Mode probable de transmission
	</td>
	</tr>
  </table>
  <input type=\"button\" name=\"ret1\" value=\"" . $repReturn[$lang] . "\" onclick=\"history.back()\" />
  <table border=\"1\">
  		<tr>
			<th width=\"300\" align=\"left\">Mode</th>
			<th width=\"100\" align=\"right\">#</th>
			<th width=\"100\" align=\"right\">%</th>
		</tr>";
  for ($j = 0; $j < $numSites; $j++) {
	// counts of mode of transmission
	$mode = array();

	$qry = "select ";
	for ($i = 0; $i < 15; $i++) {
		$mode[$i] = 0;
		$qry .= $modeNames['fields'][$i];
		if ($i < 14) $qry .= ",";
	}
	$qry .=	" from riskassessment r, encValid e where r.patientid = e.patientid and
		r.visitdateyy + r.visitdatemm + r.visitdatedd = e.visitdateyy + e.visitdatemm + e.visitdatedd  and
		e.encountertype = 1 and r.visitDateYy + r.visitDateMm >= '" . $startDate . "' and
		r.visitDateYy + r.visitDateMm <= '" . $endDate . "'";
	if ($siteCode != "ALL")
		$qry .= " and rtrim(r.siteCode) = '" . $sites[$j] . "'";

	$result = dbQuery($qry);

	while ($row = psRowFetchNum($result)) {
		for ($i = 0; $i < 15; $i++) {
			if ($row[$i] == 1)
				$mode[$i]++;
		}
	}
	$total = 0;
	for ($i = 0; $i < 15; $i++)
		$total = $total + $mode[$i];
	echo "<tr>
			<th align=\"left\" colspan=\"5\">&nbsp;</th>
		  </tr>
		  <tr>
			<th align=\"left\" colspan=\"5\">" . $sites[$j] . "</th>
		  </tr>";
		if ($total > 0) {
			for ($i = 0; $i < 15; $i++) {
				if ($mode[$i] > 0) {
					$currPercent = sprintf("%2.2f", ($mode[$i]/$total)*100);
				echo "<tr>
						<td align=\"left\">" . $modeNames[$lang][$i] . "</td>
						<td align=\"right\">" . $mode[$i] . "</td>
						<td align=\"right\">" . $currPercent . "</td>
					</tr>";
				}
			}
	echo "<tr>
			<td align=\"left\"><b>Total</b></td>
			<td align=\"right\">" . $total . "</td>
			<td align=\"right\">100%</td>
		  </tr>";
		} else {
	echo "<tr>
			<td colspan=\"6\"><b>No data found</b><td>
		  </tr>";
		}
    }
echo "</table>";
	if ($debugFlag) echo "<br />" . date('h:i:s A') . $qry . "<br />";
echo "<input type=\"button\" name=\"ret2\" value=\"" . $repReturn[$lang] . "\" onclick=\"history.back()\" />
 </body>
</html>
";

function headerGen($cell = "") {

	global $lang;
	global $siteCode;
	global $startDate;
	global $endDate;
	global $unixStartDate;
	global $unixEndDate;
	global $localizedMonths;

	// This top switch statement puts header info into the report
    switch ($cell) {
		case "start":
			return ( $localizedMonths[$lang][date("n", $unixStartDate) - 1] . " - " . "20" . substr($startDate,0,2));
			break;
		case "end":
			return ( $localizedMonths[$lang][date("n", $unixEndDate) - 1] . " - " . "20" . substr($endDate,0,2) );
			break;
		case "facility":
			return ( getSiteName($siteCode, $lang) );
			break;
		case "location":
			return ( getSiteLocation($siteCode) );
			break;
		case "grantee":
			return ("I-TECH");
			break;
		case "country":
			return ("Haiti");
			break;
		case "6.q":
			return ("");
			break;
    }
}

?>