<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>ReportDictionary</title>
</head>
<body>
  <form name="reportForm">
   <table border="1">
<?
$rtype = array( "clinicalCare","individualCase", "qualityCare","aggregatePop","primaryCare","obGynAntenatal","obGynPmtct","obGynDelivery","obGynPostnatal","obGynOther", "dataQuality");
for ($j = 0; $j < count($rtype); $j++)  {  
	//echo $rtype[$j] . "<br>";
	$reportSetArray = genReportArray($rtype[$j], "");
	for ($i = 0; $i < count($reportSetArray); $i++) {
		$repName = $reportSetArray[$i]['reportNamefr'];
		$repNum =  $reportSetArray[$i]['reportNumber'];
		$repDesc = $reportSetArray[$i]['description'];
		$pStatus = $reportSetArray[$i]['patientStatus'];
		$tStatus = $reportSetArray[$i]['treatmentStatus'];
		$tType = $reportSetArray[$i]['testType'];
		$gLevel =  $reportSetArray[$i]['groupLevel'];
		$oLevel =  $reportSetArray[$i]['otherLevel'];
		$mSelection =  $reportSetArray[$i]['menuSelection'];
		echo '<tr><td>' . $rtype[$j] . '</td><td>' . $repName . '</td><td>' . $repNum . '</td></tr>';
	} 
}
echo "</table> 
   </div>
  </form>
</body>
</html>"; 

function loadXMLFile($reportsXMLFile) {
	if (file_exists($reportsXMLFile))
  		$xml = simplexml_load_file($reportsXMLFile);
	else {
		$reportsXMLFile = "c:\\Program Files\\Apache Software Foundation\\Tomcat 5.5\\webapps\\ITECH_Reports\\reports.xml";
		if (file_exists($reportsXMLFile))
	  		$xml = simplexml_load_file($reportsXMLFile);
		else
			exit("Failed to open $reportsXMLFile");
	}
	return $xml;
}

function genReportArray($rtype, $stype) {
	$xml = loadXMLFile("jrxml/reports.xml");

	$reportSetArray = array();


	$xpath = "reportSet[@rtype='$rtype']/reportSubSet/report | reportSet[@rtype='$rtype']/reportSubSet";
	if ( $stype != "" )
	    $xpath = "reportSet[@rtype='$rtype']/reportSubSet[title='$stype']/report";
	//print "XPath: " . $xpath . "\n<br />";
	foreach ($xml->xpath($xpath) as $xml_report)
	{
	    $reportSetArray[] = parseXmlReport($xml_report);
	}

	return $reportSetArray;
} 
function parseXmlReport($xml_report) {
  global $site;
  global $start;
  global $end;
  global $pid;

  $report = array (
	"reportNameen" => $xml_report->xpath("title[@lang='en']"),
	"reportNamefr" => $xml_report->xpath("title[@lang='fr']"),
	"reportNamecr" => $xml_report->xpath("title[@lang='ht']"),
	"reportFile" => $xml_report->xpath("reportFile"),
	"reportNumber" => (string)$xml_report['id'],
	"tempQuery" => (string)$xml_report['tempQuery'],
	"query" => (string)$xml_report->query,
	"description" => (string)$xml_report->description,
	"patientStatus" => $xml_report['patientStatus'],
	"treatmentStatus" => $xml_report['treatmentStatus'],
	"testType" => $xml_report['testType'],
	"groupLevel" => $xml_report->groupLevel,
	"otherLevel" => $xml_report->otherLevel,
	"menuSelection" => $xml_report->menuSelection
  );

  if ($report["reportNameen"]) {
    $report["reportNameen"] = (string)$report["reportNameen"][0];
  } else {
    $report["reportNameen"] = "";
  }
  if ($report["reportNamefr"]) {
    $report["reportNamefr"] = (string)$report["reportNamefr"][0];
  } else {
    $report["reportNamefr"] = "";
  }
  if ($report["reportNamecr"]) {
    $report["reportNamecr"] = (string)$report["reportNamecr"][0];
  } else {
    $report["reportNamecr"] = "";
  }
  if ( $report["reportFile"])   {
      $report["reportFile"] = (string)$report["reportFile"][0];
  } else   {
      $report["reportFile"] = "";
  }

  //is this a reportSubSet rather then a report? (does it contain a list of reports?)
  if ($xml_report->report[0]) {
    $report["reportNameen"] = '<b>' . $report["reportNameen"] . '</b>';
    $report["reportNamefr"] = '<b>' . $report["reportNamefr"] . '</b>';
    $report["reportNamecr"] = '<b>' . $report["reportNamecr"] . '</b>';
    $report["reportFile"] = '<b>' . $report["reportFile"] . '</b>';
  }
  return $report;
}

function getReportSubsets($rtype) {
	$xml = loadXMLFile("jrxml/reports.xml");

	$reportSetArray = array();

	$xpath = "reportSet[@rtype='$rtype']/reportSubSet";
	//print "XPath: " . $xpath . "\n<br />";
	foreach ($xml->xpath($xpath) as $xml_report) {
    	$report = array("reportNameen" => $xml_report->xpath("title[@lang='en']"),
		  "reportNamefr" => $xml_report->xpath("title[@lang='fr']"),
		  "reportNamecr" => $xml_report->xpath("title[@lang='ht']"));

    	  if ($report["reportNameen"]) {
            $report["reportNameen"] = (string)$report["reportNameen"][0];
          } else {
            $report["reportNameen"] = "";
          }
          if ($report["reportNamefr"]) {
            $report["reportNamefr"] = (string)$report["reportNamefr"][0];
          } else {
            $report["reportNamefr"] = "";
          }
          if ($report["reportNamecr"]) {
            $report["reportNamecr"] = (string)$report["reportNamecr"][0];
          } else {
            $report["reportNamecr"] = "";
          }
	    $reportSetArray[] = $report;
     }
    return $reportSetArray;
}
?>