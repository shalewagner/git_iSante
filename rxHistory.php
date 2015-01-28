<?php
//include ("include/standardHeaderExt.php");
//include ("labels/menu.php");
//include ("labels/labels.php");
echo "
<title>Rx display and management</title>
<script type=\"text/javascript\">
// db query used for fetching patient's data (move to main file)
var queryVar = \"select (visitdateDd + '/' + visitdateMm + '/' + visitdateYy) as vDate, v.drugID, drugGroup, v.drugName, isContinued, '01/' + startMm + '/' + startYy as startDate, toxicity, intolerance, failure, stockOut, ('01/' + stopMm + '/' + stopYy) as stopDate from v_drugs v, drugLookup l where v.drugid = l.drugid and patientid = '" . $pid . "'\";
</script>
<script type=\"text/javascript\" src=\"include/rx.js\"></script> 
</head>
<body>
<form name=\"mainForm\" action=\"#\" method=\"get\">
<div id=\"content\"></div>
<br /><font size=\"3\">Choose new treatments:</font><br /><br />";

$drugClasses = array ("NRTIs", "NNRTIs", "Pls", "Anti-TB" , "Antibiotic", "Antifungal", "Antiparasite", "Micronutrients", "Analgesic", "Other Treatments");

//$drugList = generateDrugList($drugClasses);
$first = false;
for ($i = 0; $i < 10; $i++) {
	if ($first) echo "&nbsp;&nbsp;";
	$first = true;
	echo "<a class=\"menux\" href=\"#\" onclick=\"showDialog('" . $drugClasses[$i] . "')\">" . $drugClasses[$i] . "</a>";
/*	echo "<br />" . $drugClasses[$i] . "&nbsp;->&nbsp;";
	$first = false;
	foreach ($drugList[$drugClasses[$i]] as  $drug) {
		if ($first) echo "&nbsp;&nbsp;";
		$first = true;
		echo "<a class=\"menux\" href=\"#\" onclick=\"showDialog('333:" . $drugClasses[$i] . ":" . $drug .":1:0:0:0:0')\">" . $drug . "</a>";
	}*/
}
function generateDrugList ($groups) {
  $drugList = array ();
	for ($i = 0; $i < 10; $i++) {
		$gp = $groups[$i];
		$queryStmt = "SELECT drugName, drugID FROM drugLookup WHERE drugGroup = '" . $gp . "' order by drugName";
		$result = dbQuery ($queryStmt) ;
		while ($row = psRowFetch ($result)) {
			if (! isset($drugList[$gp]))
				$drugList[$gp] = array($row['drugName']);
			else 
				array_push ($drugList[$gp],  $row['drugName']);
		}
	}
  return ($drugList);
}
?>
<div id="hello-win" class="x-hidden">
    <div class="x-window-header">New medication</div>
</div>
</form>
</body>
</html>
