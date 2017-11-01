<?
chdir ("..");
require_once ("backend.php");
require_once 'backend/constants.php';

$lang = $_GET['lang'];
$user = 'cirgadmin';
$pid = $_GET['pid'];
ini_set('memory_limit','16M');

$launchedFrom = 'report';
if (strpos($_SERVER['HTTP_REFERER'],'patienttabs.php')) $launchedFrom = 'coverpage';

// fetch existing plan for patient
$qry = "select * from eventLog where eventtype = ? order by eventDate desc";
$oldPlan = database()->query($qry, array('r34Hist:' . $pid))->fetchAll(PDO::FETCH_ASSOC);
$plan = '';
foreach ($oldPlan as $row) {
	$params = json_decode($row['eventParameters'],true);
	//print_r($params);
	if (strlen($params['newPlan' ]) > 0) $plan .= $row['eventDate'] . " : " . str_replace("<br>","\n",$params['newPlan']) . " (" . $row['username'] . ")\n";	
}

// fetch contents of r34Summary for this patient
$qry = "select * from r34Summary where patientid = ? ";
$sa = database()->query($qry, array($pid))->fetchAll(PDO::FETCH_ASSOC);
$summaryArray = $sa[0];
$summaryArray['launchedFrom'] = $launchedFrom;
// record launch event
recordEvent('r34.launchDialog', $summaryArray);

// fetch all patient dispenses
$qry = "SELECT patientid, preDate, dispDate, postDate, doseDays,
DATEDIFF(postDate,dispDate) AS intObserved,
DATE_ADD(dispDate, INTERVAL doseDays + 1 DAY) as mStart,
postDate AS mEnd
FROM lwPDC180detail where patientid = ?";
$dispArray = database()->query($qry,array($pid))->fetchAll(PDO::FETCH_ASSOC);

// fetch risk history
$qry = "SELECT calcDate AS endDate, riskLevel AS riskFactor 
FROM r34Scores
WHERE patientid = '" . $pid . "'";
$ra = databaseSelect()->query($qry)->fetchAll(PDO::FETCH_ASSOC);

/* setup drawing the calendar
 * these statements move the date setup information into useful individual arrays for display purposes
 */

$dateArray = getDateArray();
$alphaM = array( '','janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre' );
if ($lang === 'en') $alphaM = array( '','january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december' );
$days = array($dateArray[0]['d1'],$dateArray[0]['d2'],$dateArray[0]['d3'],$dateArray[0]['d4'],$dateArray[0]['d5'],$dateArray[0]['d6']);
$months = array( $alphaM[$dateArray[0]['m6']], $alphaM[$dateArray[0]['m5']], $alphaM[$dateArray[0]['m4']], $alphaM[$dateArray[0]['m3']], $alphaM[$dateArray[0]['m2']], $alphaM[$dateArray[0]['m1']]);
$last = array($dateArray[0]['l1'],$dateArray[0]['l2'],$dateArray[0]['l3'],$dateArray[0]['l4'],$dateArray[0]['l5'],$dateArray[0]['l6']);

$body = '
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>r34</title>
<link rel="stylesheet" type="text/css" href="../bootstrap.css?3.4.0">
<link rel="stylesheet" type="text/css" href="../default.css?3.4.0">
<script type="text/javascript" src="../jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="../ext-3.4.0/adapter/jquery/ext-jquery-adapter.js"></script>
<script type="text/javascript" src="../ext-3.4.0/ext-all.js"></script>
<script type="text/javascript">
function saveDialog() {
	var rb = "Nul";
	if (document.getElementById("adherenceDiscussed1").checked == true) rb = "Oui";
	if (document.getElementById("adherenceDiscussed2").checked == true) rb = "Non";
	var newPlan = document.getElementById("newPlan");
	Ext.Ajax.request({   
		waitMsg: "Saving changes...",
		url: "../r34/r34Service.php", 
		params: {
			eventType: "r34Hist:" + "' . $pid . '",
			newPlan: newPlan.value.replace(/[\n\r]/g, "<br>"),
			riskLevel: "' . $summaryArray['riskLevel'] . '",
			cb: rb,
			patientid: "' . $pid . '",
			site: "' . $pid . '",
		},
		failure:function(response,options){
			Ext.MessageBox.alert("Warning","Oops...something went wrong");
		},
		success:function(response,options) {
			window.close();
		}
	});	
}
</script>';
require_once 'localPopup.php';
$body .= '
</head>
<body>' . $formTitle[$lang] . 
$currentPercent[$lang] . '<span class="grayborder"><input type="text" value="' . $summaryArray['pdc0']*100 . ' %" readonly></span> 
<p class="boldText">' . $calendarTitle[$lang] . '</p>
<table> 
	<tr>
		<td>' . $months[0] . '</td>
		<td>&nbsp;</td>
		<td>' . $months[1] . '</td>
		<td>&nbsp;</td>
		<td>' . $months[2] . '</td>
	</tr> <tr>
		<td>' . printMonth(1,$last[5],$days[5],$dateArray[0]['y6'] . '-' . pad0($dateArray[0]['m6']), $dispArray, $ra) . '</td>
		<td>&nbsp;</td>
		<td>' . printMonth(30,$last[4],$days[4],$dateArray[0]['y5'] . '-' . pad0($dateArray[0]['m5']), $dispArray, $ra) . '</td>
		<td>&nbsp;</td>
		<td>' . printMonth(60,$last[3],$days[3],$dateArray[0]['y4'] . '-' . pad0($dateArray[0]['m4']), $dispArray, $ra) . '</td>
	</tr> <tr>
		<td>' . $months[3] . '</td>
		<td>&nbsp;</td>
		<td>' . $months[4] . '</td>
		<td>&nbsp;</td>
		<td>' . $months[5] . '</td>
	</tr> <tr>
		<td>' . printMonth(90,$last[2],$days[2],$dateArray[0]['y3'] . '-' . pad0($dateArray[0]['m3']), $dispArray, $ra) . '</td>
		<td>&nbsp;</td>
		<td>' . printMonth(120,$last[1],$days[1],$dateArray[0]['y2'] . '-' . pad0($dateArray[0]['m2']), $dispArray, $ra) . '</td>
		<td>&nbsp;</td>
		<td>' . printMonth(150,$last[0],$days[0],$dateArray[0]['y1'] . '-' . pad0($dateArray[0]['m1']), $dispArray, $ra) . '</td>
</tr> </table><br>' . $legend[$lang] . '
<br>' . $xLate[$lang] . ' 
<br> 
<p class="boldText">' . $adhere[$lang] . '&nbsp;<input type="radio" name="adherencedDiscussed" id="adherenceDiscussed1" value="1">' . $yes[$lang] . '&nbsp;&nbsp;<input type="radio" name="adherencedDiscussed" id="adherenceDiscussed2" value="0">' . $no[$lang] . '</p>
' . 
$history[$lang] .
'<br>
<textarea name="oldPlan" id="oldPlan" rows="8" cols="130" readonly>' . $plan . '</textarea>
' . 
$planText[$lang] . '
<br> 
<textarea name="newPlan" id="newPlan" rows="4" cols="130">' . $x . '</textarea> 
<br><input type="button" value="' . $save[$lang] . '" onclick="saveDialog()">
&nbsp;&nbsp;
<input type="button" value="' . $cancel[$lang] . '" onclick="window.close()">
<br>' . $explain[$lang];
/* this displays data and should be removed for production
echo "<table><tr><td>predate</td><td>dispDate</td><td>postDate</td><td>DD</td><td>intOb</td><td>ddEndDate</td><td>intObEndDate</td></tr>";
foreach ($dispArray as $row) {
	echo "<tr>";
	echo "<td>" . $row['preDate'] . "</td><td>" . $row['dispDate'] . "</td><td>" . $row['postDate'] . "</td><td>" . $row['doseDays'] . "</td><td>" . $row['intObserved'] . "</td><td>" . $row['mStart'] . "</td><td>" . $row['mEnd'] . "</td>";
	echo "</tr>";
}
echo "</table>";
echo "&nbsp;<br>";
// end of displayed data to be removed*/
echo $body;

function dStoN ($s) {
	// converts string to numeric
	return (intval(str_replace('-','',$s)));
}
function pad0 ($s) {
	// pads with a zero if only 1 char long
	return ((strlen(strval($s)) == 1) ? '0'.strval($s):strval($s));
}
function printMonth($k, $lastDay, $startDay, $startDate, $dispArray, $ra) {
// fetch risk history for patient
	$x = '<table> <tr><th>di</th><th>lu</th><th>ma</th><th>me</th><th>je</th><th>ve</th><th>sa</th></tr>';	
	$day = 1;
	$flag = 1;
	for ($j = 0; $j < 6; $j++) { // month loop
		$x .= '<tr>';
		for ($i = 1; $i < 8; $i++) { // day of week loop
			$stp = '';
			// this checks whether the day is within the month at beginning and end of the loop
			if (($i == $startDay && $j == 0 && $flag) || (! $flag && $day < $lastDay+1)) {
				$curDay  = pad0($day);
				$curDate = dStoN($startDate . '-' . $curDay);
				$y = 0;
				foreach ($ra as $row) {
					if ($row['endDate'] === $startDate . '-' . $curDay) {
						$y = intVal($row['riskFactor']);
						break;
					}
				}
				$stp = ' style="background-color: ';
				switch ($y) {
					case 500:
						$stp .= '#ff0000"';             //virologic failure
						break;
					case 400:
						$stp .= '#ff8000"';       //high risk
						break;
					case 300:
						$stp .= '#ffff66"';            //medium risk
						break;
					case 200:
						$stp .= '#00ff00"';        //low risk
						break;
					case 100:
						$stp .= '#0080ff"';            //success
						break;
					default;
						$stp = '';
				} // end of switch statement
				// figure out if day was missing meds
				$z = '';
				foreach ($dispArray as $row) { // dispenses loop
					$begin   = dStoN($row['start']);
					$end     = dStoN($row['end']);
					$mStart   = $row['mStart'];
					$mEnd     = $row['mEnd'];
					$dayDiff = $row['doseDays'] - $row['intObserved'];
					//echo "<br>dayDiff: " . $dayDiff . " startDay: " . $startDate . '-' . $curDay . " mStart: " . $mStart . " mEnd: " . $mEnd;
					if (missingMed($startDate . '-' . $curDay, $mStart, $mEnd)) {
						$z = 'X';
						break;
					}
				} // end of dispenses loop
				$flag = 0;
				$x .= '<td' . $stp . '>' . $z . '&nbsp;<span class="sup">' . $day++ . '</span></td>';
			} else {
				$x .= '<td>&nbsp;</td>';
			} // end of day check IF statement
		} // end of day of week loop
		$x .= '</tr>';
	} // end of month loop
	$x .= '</table>';
	return $x;
}
function missingMed ($curDt, $mStartDt, $mEndDt) {
	$qry = "select case when ? >= ? and ? < ? then 1 else 0 end as result";
	$result = database()->query($qry,array($curDt,$mStartDt,$curDt,$mEndDt))->fetchAll(PDO::FETCH_ASSOC);
	if ($result[0]['result']) return 1;
	else return 0;
}
function getDateArray() {
	$qry = 'SELECT                                          DAYOFWEEK(YMDtODATE(YEAR(NOW()),MONTH(NOW()),1)) as d1,
	DAYOFWEEK(YMDtODATE(YEAR(DATE_ADD(NOW(),INTERVAL -1 MONTH)),MONTH(DATE_ADD(NOW(),INTERVAL -1 MONTH)),1)) as d2,
	DAYOFWEEK(YMDtODATE(YEAR(DATE_ADD(NOW(),INTERVAL -2 MONTH)),MONTH(DATE_ADD(NOW(),INTERVAL -2 MONTH)),1)) as d3,
	DAYOFWEEK(YMDtODATE(YEAR(DATE_ADD(NOW(),INTERVAL -3 MONTH)),MONTH(DATE_ADD(NOW(),INTERVAL -3 MONTH)),1)) as d4,
	DAYOFWEEK(YMDtODATE(YEAR(DATE_ADD(NOW(),INTERVAL -4 MONTH)),MONTH(DATE_ADD(NOW(),INTERVAL -4 MONTH)),1)) as d5,
	DAYOFWEEK(YMDtODATE(YEAR(DATE_ADD(NOW(),INTERVAL -5 MONTH)),MONTH(DATE_ADD(NOW(),INTERVAL -5 MONTH)),1)) as d6,
	                            month(now()) as m1,
	MONTH(DATE_ADD(NOW(),INTERVAL -1 MONTH)) as m2,
	MONTH(DATE_ADD(NOW(),INTERVAL -2 MONTH)) as m3,
	MONTH(DATE_ADD(NOW(),INTERVAL -3 MONTH)) as m4,
	MONTH(DATE_ADD(NOW(),INTERVAL -4 MONTH)) as m5,
	MONTH(DATE_ADD(NOW(),INTERVAL -5 MONTH)) as m6,
	                            YEAR(now()) as y1,
	YEAR(DATE_ADD(NOW(),INTERVAL -1 MONTH)) as y2,
	YEAR(DATE_ADD(NOW(),INTERVAL -2 MONTH)) as y3,
	YEAR(DATE_ADD(NOW(),INTERVAL -3 MONTH)) as y4,
	YEAR(DATE_ADD(NOW(),INTERVAL -4 MONTH)) as y5,
	YEAR(DATE_ADD(NOW(),INTERVAL -5 MONTH)) as y6,
	                            DAY(LAST_DAY(NOW())) as l1,
	DAY(LAST_DAY(DATE_ADD(NOW(),INTERVAL -1 MONTH))) as l2,
	DAY(LAST_DAY(DATE_ADD(NOW(),INTERVAL -2 MONTH))) as l3,
	DAY(LAST_DAY(DATE_ADD(NOW(),INTERVAL -3 MONTH))) as l4,
	DAY(LAST_DAY(DATE_ADD(NOW(),INTERVAL -4 MONTH))) as l5,
	DAY(LAST_DAY(DATE_ADD(NOW(),INTERVAL -5 MONTH))) as l6';
	return database()->query($qry)->fetchAll(PDO::FETCH_ASSOC);
}
?>
</body>
</html>
