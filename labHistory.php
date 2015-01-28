<?php
//include ("include/standardHeaderExt.php");
//include ("labels/menu.php");
//include ("labels/labels.php");
echo "
<script type=\"text/javascript\">
// db query used for fetching patient's data using json
var queryVar = \"select (visitdateDd + '/' + visitdateMm + '/' + visitdateYy) as vDate, labid, testNameFr, result, result2, resultAbnormal, resultRemarks,  (resultdateDd + '/' + resultdateMm + '/' + resultdateYy) as resultDate from v_labs where patientid = '" . $pid . "'\";
</script>
<script type=\"text/javascript\" src=\"include/lab.js\"></script>
<title>Dx display and management</title>
 </head>
 <body>
<form name=\"mainForm\" action=\"#\" method=\"get\">
<div id=\"content\"></div>
<br /><font size=\"3\">Choose new lab tests:</font><br />";
$query = "select distinct labID, testName" . $lang . " as testName from labLookup order by 2";
$result = dbQuery ($query);
$first = false;
  while ($row = psRowFetch ($result)) {
		if ($first) echo "&nbsp;&nbsp;";
		$first = true;
		echo "<a class=\"menux\" href=\"#\" onclick=\"showDialog('" . $row["labID"] . ":" . addslashes($row["testName"]) .":::')\">" . $row["testName"] . "</a>";
}
?>
<div id="hello-win" class="x-hidden">
    <div class="x-window-header">New lab test</div>
</div>
</form>
</body>
</html>
