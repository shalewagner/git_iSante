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
	$qry = "select distinct rtrim(siteCode) as siteCode from clinicLookup where sitecode != 'UW'";
	$result = mysql_query($qry);
	$numSites = 0;
	while ($row = mysql_fetch_row($result)) {
		$sites[$numSites] = $row[0];
		$numSites++;
	}
} else {
	$numSites = 1;
	$sites[0] = "All Sites";
}

$qry = "create table #getResults (patientID varchar(20), visitdate varchar(6), drugList varchar(20))";
$result = mysql_query($qry);

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
		Patient Drug List
	</td>
	</tr>
  </table>
  <input type=\"button\" name=\"ret1\" value=\"" . $repReturn[$lang] . "\" onclick=\"history.back()\" />";

  echo "<table border=\"1\">
  		<tr>
			<th width=\"300\" align=\"left\">PatientID</th>
			<th width=\"100\" align=\"right\">Visit Date</th>
			<th width=\"100\" align=\"right\">DrugList</th>
		</tr>";
  for ($j = 0; $j < $numSites; $j++) {
  	echo "<th align=\"left\" colspan=\"5\">" . $sites[$j] . "</th>";
	$qry ="select distinct d.siteCode,
				p.nationalid as patient,
				d.visitdateyy + d.visitdatemm + d.visitdatedd as visit,
				shortname
				from drugs d, encValid e, druglookup l, patient p
				where l.drugid = d.drugid and l.druggroup not like 'OTHER%' and
				p.patientid = d.patientid and
				e.visitdatedd = d.visitdatedd and
				e.visitdatemm = d.visitdatemm and
				e.visitdateyy = d.visitdateyy and
				e.patientid = d.patientid and
				e.seqNum = d.seqNum and
				d.isContinued = 1";
	if ($siteCode != "ALL") $qry .= " and rtrim(d.siteCode) = '" . $sites[$j] . "' ";
	$qry .=	"union
			select distinct d.siteCode,
				p.nationalid as patient,
				d.visitdateyy + d.visitdatemm + d.visitdatedd as visit,
				shortname from prescriptions d, encValid e, druglookup l, patient p
				where l.drugid = d.drugid and l.druggroup not like 'OTHER%' and
				p.patientid = d.patientid and
				e.visitdatedd = d.visitdatedd and
				e.visitdatemm = d.visitdatemm and
				e.visitdateyy = d.visitdateyy and
				e.patientid = d.patientid and
				e.seqNum = d.seqNum ";
	if ($siteCode != "ALL") $qry .= " and rtrim(d.siteCode) = '" . $sites[$j] . "' ";
	$qry .= "order by 1,2,3";
	if ($debugFlag) print $qry . "<br>";
	$result = mysql_query($qry);
	$lastPatient = "";
	$lastVisit = "";
	$drugList = "";
	$startFlag = false;
	$i = 0;
	while ($row = mysql_fetch_row($result)) {
		$i++;
		$patient = $row[1];
		$visit = $row[2];
		$drug = $row[3];
		if ($lastPatient == $patient && $lastVisit == $visit) {
			// just add to the druglist
			$drugList .= "+" . $drug;
		} elseif ($lastPatient != $patient) {
			echo "<tr>
					<td align=\"left\"><b>" . $lastPatient . "</b></td>
				    <td align=\"right\">" . $lastVisit . "</td>
					<td align=\"right\">" . $drugList . "</td>
			     </tr>";
			echo "<tr><td colspan=\"5\">&nbsp;</td></tr>";
			$qry2 = "insert into #getResults values ('" . $lastPatient . "','" . $lastVisit . "','" . $drugList . "')";
			$result2 = mysql_query($qry2);
			$lastPatient = $patient;
			$lastVisit = $visit;
			$drugList = $drug;
			$startFlag = true;
		} else {
			$qry2 = "insert into #getResults values ('" . $lastPatient . "','" . $lastVisit . "','" . $drugList . "')";
			$result2 = mysql_query($qry2);
			echo "<tr>";
				if ($startFlag) {
					echo "<td align=\"left\"><b>" . $lastPatient . "</b></td>";
					$startFlag = false;
				}
				else
					echo "<td align=\"left\"><b>&nbsp;</b></td>";
				echo "<td align=\"right\">" . $lastVisit . "</td>
					<td align=\"right\">" . $drugList . "</td>
			     </tr>";
			$lastVisit = $visit;
			$drugList = $drug;
		}
    }
    if ($i == 0) echo "<tr><td align=\"left\" colspan=\"5\">No Data</td></tr>";

  }
echo "</table><table>";
$qry = "select drugList, count(*) from #getResults group by drugList order by 1";
$result = mysql_query($qry);
while ($row = mysql_fetch_row($result)) {
	echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>";
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