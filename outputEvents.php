<?php
require_once 'include/standardHeader.php';
require_once 'labels/menu.php';
require_once 'labels/report.php';

$lang = "en";
if (isset($_GET['lang'])) $lang = $_GET['lang'];

// generate an array of reports
$repArray = array();
$repArray['9999'] = "Ad hoc query";
$category = array ("obGynOther", 
"obGynPostnatal",
"obGynDelivery", "obGynPmtct", "obGynAntenatal", "clinicalCare", "individualCase", "dataQuality", "aggregatePop", "primaryCare", "obGyn", "dataQuality", "mainPage"); 
for ($i = 0; $i < count($category); $i++) {
	$cat = $category[$i];
	$subsets = getReportSubsets($cat);
	foreach ($subsets as $subset) {
		$reports = genReportArray($cat, $subset["reportName" . $lang]);
		if ($reports) {
			foreach ($reports as $report) $repArray[$report["reportNumber"]] = $cat . "-->" . $subset["reportName" . $lang] . "-->" . $report["reportName" . $lang];
		}
	}
}

ksort($repArray);
$totalRequests = 0;
echo "<table>";
foreach ($repArray as $repNum => $repTitle) {
	$qry = "select count(*) as cnt from eventLog where year(eventDate) = 2012 and quarter(eventDate) = 2 and eventParameters like '%\"reportNumber\":\"" . $repNum . "\"%'";
	switch ($repNum ) {
	case 206:
		$qry = "select count(*) as cnt from eventLog where year(eventDate) = 2012 and quarter(eventDate) = 2 and eventType = 'clinicalsummary'";
		break;
	case 9999:
		$qry = "select count(*) as cnt from eventLog where year(eventDate) = 2012 and quarter(eventDate) = 2 and eventType = 'adhoc'";
	}
	$result = dbQuery ($qry);
	if ($result) {
		$row = psRowFetch ($result);
		echo "<tr><td>" . $repNum . "</td><td>" . $repTitle . "</td><td>" . $row['cnt'] . "</td></tr>";
		$totalRequests = $totalRequests + $row['cnt'];
	} else
		echo "<tr><td>" . $repNum . "</td><td>" . $repTitle . "</td><td>0</td></tr>";
}
echo "<tr><td colspan=\"2\">Total Requests</td><td>" . $totalRequests . "</td></tr>
	<table>";
?>