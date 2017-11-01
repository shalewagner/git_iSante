<?
require_once 'include/standardHeaderExt.php';
require_once 'labels/menu.php';
require_once 'labels/report.php';

function makeCheckbox ($label, $lang, $name, $i, $passedIn) {
	$valArray = array (2,4,8,16,32,64,128,256,512,1024,2048);
	$curArray = getPatientStatusArray ($passedIn);
	$label = $label[$name][$lang][$i+1];
	if ($passedIn == 14)
		if ($i > 2) $passedIn = 0;
	if ($passedIn == 0) {
		$checked = "disabled";
		$label = setLabelDisabled($label, $passedIn);
	} else if ($curArray[$i] == 1)
		$checked = "checked";
	else
		$checked = "";
	return "<input type=\"checkbox\" name=\"" . $name . $i . "\" value=\"" . $valArray[$i] . "\" " . $checked . ">" . $label;
}

function genRadioControl ($label, $lang, $name, $value, $passedIn, $repNum) {
  // if the makeDisabled array value is 1, item is not disabled, if it is 0, the item is disabled
  $makeDisabled = array (1,1,1,1,1,1,1,1,1,1);

  $label = $label[$name][$lang][$value];
  if ($passedIn == 0 || $makeDisabled[$value] == 0) {
	  $checked = "disabled";
	  $label = setLabelDisabled($label, 0);
  } else if ($value == $passedIn)
	  $checked = "checked";
  else
	  $checked = "";
  return '<input type="radio" name=' . $name . '" value="' . $value . ' ' . $checked . '>' . $label;
}

if (DEBUG_FLAG) print_r ($_GET);

//set a default value for noid
if (!array_key_exists('noid', $_GET)) {
  $_GET['noid'] = 'false';
}

$rtype = (!empty ($_GET['rtype'])) ? $_GET['rtype'] : "clinicalCare";
$repNum = "";
if (!empty ($_GET['reportNumber'])) $repNum = $_GET['reportNumber'];
if (empty ($repNum) && !empty ($_GET['repNum'])) $repNum = $_GET['repNum'];

if (!empty ($_GET['start'])) $start = $_GET['start'];
if (!empty ($_GET['end'])) $end = $_GET['end'];
$interval = (!empty ($_GET['interval']) ? $_GET['interval'] : 6);
if (!empty ($_GET['lang'])) $lang = $_GET['lang'];
if (!empty ($_POST['lang'])) $lang = $_POST['lang'];

$pStatus = (!empty ($_GET['patientStatus'])) ? $_GET['patientStatus'] : 0;
$tStatus =  (!empty ($_GET['treatmentStatus'])) ? $_GET['treatmentStatus'] : 0;
/*
$tType = (!empty ($_GET['testType'])) ? $_GET['testType'] : 0;
$gLevel =  (!empty ($_GET['groupLevel'])) ? $_GET['groupLevel'] : 0;
$oLevel = (!empty ($_GET['otherLevel'])) ? $_GET['otherLevel'] : 0;
$menuSelection = (!empty ($_GET['menu'])) ? $_GET['menu'] : "";
*/
$xml = loadXMLFile("jrxml/reports.xml");
$xpath = "reportSet[@rtype='$rtype']/reportSubSet/report[@id='$repNum']";
$xmlRep = $xml->xpath($xpath);
$titleArray = $xml->xpath("//report[@id='$repNum']/title[@lang='$lang']");
$title = (CHARSET == 'ISO-8859-1') ? utf8_decode($titleArray[0]) : $titleArray[0];
$descArray = $xml->xpath ("//report[@id='$repNum']/description[@lang='$lang']");
$repDesc = (CHARSET == 'ISO-8859-1') ? utf8_decode($descArray[0]) : $descArray[0];
echo "
<meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-1\" />
<title>" . $kickLabel['parameters'][$lang] . "</title>";
?>
<link href="default.css" type="text/css" rel="StyleSheet" />
<script type="text/javascript">
function trim(str) { 
	if (str != null) {
		var i; 
		for (i=0; i<str.length; i++) {
			if (str.charAt(i)!=" ") {
				str=str.substring(i,str.length); 
				break;
			} 
		} 	
		for (i=str.length-1; i>=0; i--) {
			if (str.charAt(i)!=" ") {
				str=str.substring(0,i+1); 
				break;
			} 
		} 		
		return str;
	}
	return null;
}

function ymdToDate (year,month,day) {
	var result = '';	
	if(year == null || month == null || day == null) {
		return result;
	}	
	var inYear = trim(year);
	var inMonth = trim(month);
	var inDay = trim(day);
	if(inYear.length == 0 || inMonth.length == 0 || inDay.length ==0) {
		return result;
	}	
	var outYear = '';
	var outMonth = '';
	var outDay = '';
	if(!isNaN(inYear)) {
        var tempYear = Number(inYear);
		if( tempYear >= 1000) {
			outYear = tempYear;
		} else {
			if(tempYear <= 18) {
				outYear = 2000 + tempYear;
			} else {
				outYear = 1900 + tempYear;
			}	
		}
	}
	/* zero pad 1 digit month */
	if(!isNaN(inMonth)) {
		if(inMonth.length == 1) {
			outMonth = '0' + inMonth;
		} else {
			outMonth = inMonth;
		}
	}
	/* zero pad 1 digit days */
	if(!isNaN(inDay)) {
		if(inDay.length == 1) {
			outDay = '0' + inDay;
		} else {
			outDay = inDay;
		}
	}
	result = outYear + '-' + outMonth + '-' + outDay;
	return result;
} 

var sMonth = '';
var sYear = '';
var eMonth = '';
var eYear = '';
var lastDd = '';
var sDate = new Date();
var eDate = new Date();
var oneMinute = 60 * 1000;
var oneHour = oneMinute * 60;
var oneDay = oneHour * 24;
var oneMonth = 28 * oneDay;
var sixMonths = 182 * oneDay;

function formatStartEndDates () { 
	sMonth = document.forms['mainForm'].startMm.value;
	if (sMonth.length == 1) sMonth = '0'+ sMonth;
	sYear = document.forms['mainForm'].startYy.value;
	if (sYear.length == 1) sYear = '0'+ sYear; 
	eMonth = document.forms['mainForm'].endMm.value; 
	if (eMonth.length == 1) eMonth = '0'+ eMonth;
	eYear = document.forms['mainForm'].endYy.value; 
	if (eYear.length == 1) eYear = '0'+ eYear; 
	lastDd = daysInMonth(eMonth,'20' + eYear);
	sDate = new Date(sMonth+'/01/20'+sYear);
	eDate = new Date(eMonth+'/'+lastDd+'/20' +eYear);  
}

function sendParameters () {
	//formatStartEndDates();
	var runFlag = true;
	pStatus = tStatus = 0;
	ddValue = "";
	if (document.forms['mainForm'].patientStatus0.checked) pStatus = pStatus + 2;
	if (document.forms['mainForm'].patientStatus1.checked) pStatus = pStatus + 4;
	if (document.forms['mainForm'].patientStatus2.checked) pStatus = pStatus + 8;
	if (document.forms['mainForm'].riskStatus0.checked) tStatus = tStatus + 2;
	if (document.forms['mainForm'].riskStatus1.checked) tStatus = tStatus + 4;
	if (document.forms['mainForm'].riskStatus2.checked) tStatus = tStatus + 8;
	if (document.forms['mainForm'].riskStatus3.checked) tStatus = tStatus + 16;
	if (document.forms['mainForm'].riskStatus4.checked) tStatus = tStatus + 32;
<?
	echo " var cmd = 'runReport.php?" . ($_GET['noid'] == "true" ? "noid=true&" : "") . "reportNumber=' + document.forms['mainForm'].reportNumber.value + '&rtype=' + document.forms['mainForm'].rtype.value + '&lang=' + document.forms['mainForm'].lang.value + '&site=';";
?>
	cmd = cmd + document.forms['mainForm'].site.value + '&patientStatus=' + pStatus + '&treatmentStatus=' + tStatus + '&testType=0&groupLevel=0&otherLevel=0&menu=&lastPid=';
	if (runFlag) doWindow(cmd)
}

function daysInMonth(month,year) {
	var dd = new Date(year, month, 0);
	return dd.getDate();
}

function doWindow (url) {
	stuff = 'width=1024,height=1000,toolbar=yes,location=yes,directories=no,scrollbars=yes,menubar=yes,resizable=yes';
	currWindow = window.open(url ,'ContentAreaLaunchedReport', stuff);
	currWindow.focus();
}
</script>
</head>
<body onLoad="if (document.getElementById('repDesc')) document.getElementById('repDesc').readOnly = true;">
<form name="mainForm" action="#" method="get">
<?
include 'bannerbody.php';
echo "<div class=\"contentArea\">
<table class=\"formType\">
	<tr>
		<td id=\"title\" class=\"m_header\">" . $kickLabel['parameters'][$lang] . ": " . $title . "</td>
	</tr>
</table>
<div id=\"pane0\" style=\"display:none\">
	<font size=\"5\">" . $waitMessageText[$lang] . "</font>
</div>
<div id=\"pane1\">
";
// compute the end date from current date as the last day of the month
if ($repNum == "503" || $repNum == '504' || $repNum == '512' || $repNum == '530') {
  $date = date ("d/m/y", mktime (0, 0, 0, date ("m") - 1, date ("t", mktime (0, 0, 0, date("m") - 1, 1, date ("Y"))), date ("Y")));
} else if ($repNum == "540") {
  $date = date ("d/m/y", strtotime ("last saturday"));
} else {
  $date = date("t/m/y");
}
list($dd, $mm, $yy) = explode('/', $date);
$startDisabled = "";
$endDisabled = "";
$startPassedIn = 1;
$endPassedIn = 1;
if ($menuSelection == "dateNo") {
	$startDisabled = "disabled";
	$endDisabled = "disabled";
	$startPassedIn = 0;
	$endPassedIn = 0;
}
if ($menuSelection == "endDateOnly") {
	$startDisabled = "disabled";
	$endDisabled = "";
	$startPassedIn = 0;
	$endPassedIn = 1;
}

list ($stMm, $stDd, $stYy) = array ("01", "01", "01");

echo '
<input type="hidden" name="pid" value="' . $pid . '"/>
<input type="hidden" name="rtype" value="' . $rtype . '"/>
<input type="hidden" name="reportNumber" value="' . $repNum . '"/>
<table>
<tr>
<th>Statut ARV</th>
<th align="left">Catégories de risque</th>
</tr>
<tr>
<td style="padding: 5px;">' . makeCheckbox($kickLabel, $lang, "patientStatus", 0, $pStatus) . '</td>
<td style="padding: 5px;">' . makeCheckbox($kickLabel, $lang, "riskStatus", 0, $tStatus) . '</td>
</tr>
<tr>
<td style="padding: 5px;">' . makeCheckbox($kickLabel, $lang, "patientStatus", 1, $pStatus) . '</td>
<td style="padding: 5px;">' . makeCheckbox($kickLabel, $lang, "riskStatus", 1, $tStatus) . '</td>
</tr>
<tr>
<td style="padding: 5px;">' . makeCheckbox($kickLabel, $lang, "patientStatus", 2, $pStatus) . '</td>
<td style="padding: 5px;">' . makeCheckbox($kickLabel, $lang, "riskStatus", 2, $tStatus) . '</td>
</tr>
<tr>
<td>&nbsp;</td>
<td style="padding: 5px;">' . makeCheckbox($kickLabel, $lang, "riskStatus", 3, $tStatus) . '</td>
</tr>
<tr>
<td>&nbsp;</td>
<td style="padding: 5px;">' . makeCheckbox($kickLabel, $lang, "riskStatus", 4, $tStatus) . '</td>
</tr>';
?>
</table>
<input id="kick2" type="button" value="<?=$buttonLbls[$lang][0];?>" onclick="sendParameters()" />&nbsp;
<input type="reset" value="<?=$buttonLbls[$lang][1];?>" />
</div>
</div>
</form>
</body>
</html>