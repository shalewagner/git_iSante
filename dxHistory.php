<?php
//include ("include/standardHeaderExt.php");
//include ("labels/menu.php");
//include ("labels/labels.php");
echo "
<script type=\"text/javascript\">
// db query used for fetching patient's data using json
var queryVar = \"select (visitdateDd + '/' + visitdateMm + '/' + visitdateYy) as vDate, conditions_id, whoStage, conditionNameFr, case when conditionactive = 1 then convert(tinyint,1) else convert(tinyint,0) end as active, case when conditionactive = 2 then convert(tinyint,1) else convert(tinyint,0) end as resolved, '01/01/01' as onsetDate from v_conditions where patientid = '" . $pid . "'\";
</script>
<script type=\"text/javascript\" src=\"include/dx.js\"></script>
<title>Dx display and management</title>
 </head>
 <body>
<form name=\"mainForm\" action=\"#\" method=\"get\">
<div id=\"content\"></div>";
$stage = array ("en" => array ("Stage I", "Stage II", "Stage III", "Stage IV", "Stage V", "Other", "Psych", "Substance Abuse"), "fr" => array("Stade I", "Stade II", "Stade III", "Stade IV", "Stade V", "Autres", "Psych", "Substance Abuse"));
echo "<br /><font size=\"3\">Choose new diagnoses:</font>";
$conditionList = generateConditionList($lang);
$groupCounter = 0;
foreach ($conditionList as $group) {
	echo "<br />" . $stage[$groupCounter] . "&nbsp;->&nbsp;";
	$first = true;
	foreach ($group as $grp => $diagnosis) {
		if (! $first) echo "&nbsp;&nbsp;";
		$first = false;
		echo "<a class=\"menux\" href=\"#\" onclick=\"showDialog('0:" . $stage[$groupCounter] . ":" . addslashes($diagnosis[$lang]) .":1:0')\">" . $diagnosis[$lang] . "</a>";
	}
	$groupCounter++;
	if ($groupCounter == 8) break;
}
?>
<div id="hello-win" class="x-hidden">
    <div class="x-window-header">New diagnosis</div>
</div>
</form>
</body>
</html>

