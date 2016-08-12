<?
require_once 'include/standardHeaderExt.php';
require_once 'labels/menu.php';
require_once 'labels/report.php';

function genRadioControl ($label, $lang, $name, $value, $passedIn, $repNum) {
  // if the makeDisabled array value is 1, item is not disabled, if it is 0, the item is disabled
  $makeDisabled = array (1,1,1,1,1,1,1,1,1,1);
  switch ($repNum) {
  case "503":
  case "505":
	if ($name == "groupLevel") {
	  $makeDisabled = array (1,1,0,0,0,0,0,0,0,0);
	  break;
	}
  case "504":
  case "511":
  case "512":
  case "520":
  case "530":
	if ($name == "groupLevel") {
	  $makeDisabled = array (1,0,1,0,0,0,0,0,0,0);
	  break;
	}
  case "604":
  case "605":
	$makeDisabled = array (0,0,0,0,0,1,0,0,0,0);
	break;
  case "5005":
	if ($name == "treatmentStatus") break;
	if ($name == "testType") {
	  // only allow cd4,liver, hemo
	  $makeDisabled = array (1,1,0,0,0,1,1,0,0,0);
	  break;
	}
  case "5020": 
	genNoReason($lang);
	if ($name == "treatmentStatus") {
	  // only allow CC
	  $makeDisabled = array (1,0,0,1,0,0,0,0,0,0);
	  break;
	}
  case "5021":
  case "5022":
	if ($name == "treatmentStatus") {
	  // only allow ctx
	  $makeDisabled = array (1,0,0,0,0,1,0,0,0,0);
	  break;
	}
  case "5023":
	// only allow tb
	if ($name == "treatmentStatus") {
	  $makeDisabled = array (1,0,0,0,0,0,1,0,0,0);
	  break;
	}
  case "5024":
	if ($name == "treatmentStatus") {
	  // only allow any, art, and noart
	  $makeDisabled = array (1,1,1,1,0,0,0,0,0,0);
	  break;
	}
	if ($name == "testType" || $name == "groupLevel") break;
  case "5025":
  case "5026":
  case "5027":
  case "5028":
	if ($name == "groupLevel") {
	  $makeDisabled = array (1,1,0,0,0,0,0,0,0,0);
	  break;
	}
  case "5030":
	if ($name == "testType") break;
  case "5031":
	if ($name == "treatmentStatus") {
	  // only allow any, art, and noart
	  $makeDisabled = array (1,1,1,1,0,0,0,0,0,0);
	  break;
	}
	// only allow cd4,liver, hemo
	if ($name == "testType") {
	  $makeDisabled = array (1,1,0,0,0,1,1,0,0,0);
	  break;
	}
  case "5040":
	// only allow ART
	if ($name == "treatmentStatus") {
	  $makeDisabled = array (1,0,1,0,0,0,0,0,0,0);
	  break;
	}
  case "5041":
  case "5042":
	// only allow ctx
	if ($name == "treatmentStatus") {
	  $makeDisabled = array (1,0,0,0,0,1,0,0,0,0);
	  break;
	}
  case "5043":
  case "5044":
	// only allow tb
	if ($name == "treatmentStatus") {
	  $makeDisabled = array (1,0,0,0,0,0,1,0,0,0);
	  break;
	}
	if ($name == "groupLevel") $makeDisabled = array (1,0,1,1,1,1,1,1,1,1);
  case "5045":
	if ($name == "groupLevel") $makeDisabled = array (1,0,1,1,1,1,1,1,1,1);
  case "5046":
	if ($name == "groupLevel") $makeDisabled = array (1,0,1,1,1,1,1,1,1,1);
  }

  $label = $label[$name][$lang][$value];
  if ($passedIn == 0 || $makeDisabled[$value] == 0) {
	$checked = "disabled";
	$label = setLabelDisabled($label, 0);
  } else if ($value == $passedIn)
	$checked = "checked";
		else
		  $checked = "";
  return "<input type=\"radio\" name=\"" . $name . "\" value=\"" . $value . "\" " . $checked . ">" . $label;
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
$tType = (!empty ($_GET['testType'])) ? $_GET['testType'] : 0;
$gLevel =  (!empty ($_GET['groupLevel'])) ? $_GET['groupLevel'] : 0;
$oLevel = (!empty ($_GET['otherLevel'])) ? $_GET['otherLevel'] : 0;
$menuSelection = (!empty ($_GET['menu'])) ? $_GET['menu'] : "";

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
			if(tempYear <= 20) {
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
	if (eYear.length==2) { 
	lastDd = daysInMonth(eMonth,'20' + eYear);
	sDate = new Date(sMonth+'/01/20'+sYear);
	eDate = new Date(eMonth+'/'+lastDd+'/20' +eYear); 
	}
	else
	{
	lastDd = daysInMonth(eMonth, eYear);
	sDate = new Date(sMonth+'/01/'+sYear);
	eDate = new Date(eMonth+'/'+lastDd+'/' +eYear); 
	}
}
function sendParameters () {
	formatStartEndDates();
	var runFlag = true;
	if (document.forms['mainForm'].reportNumber.value == '903') {
		if (eYear.length==2) { 
		start = '20' + sYear + sMonth;
		end = '20' + eYear + eMonth;
		}
		else { 
		start = sYear + sMonth;
		end = eYear + eMonth;
		}
		
	} else if (document.forms['mainForm'].reportNumber.value == '540') {	
                sDay = document.forms['mainForm'].startDd.value;
                if (sDay.length == 1) sDay = '0'+ sDay;
		start = ymdToDate (sYear , sMonth , sDay);
                eDay = document.forms['mainForm'].endDd.value;
                if (eDay.length == 1) eDay = '0'+ eDay;
		end = ymdToDate (eYear , eMonth , eDay); 
		if (eYear.length==2) { 
	        sDate = new Date(sMonth + '/' + sDay + '/20' + sYear);
	        eDate = new Date(eMonth + '/' + eDay + '/20' + eYear); 
		}
		else { 
	        sDate = new Date(sMonth + '/' + sDay + '/' + sYear);
	        eDate = new Date(eMonth + '/' + eDay + '/' + eYear); 
		}
		
	} else {	
		start = ymdToDate(sYear , sMonth , document.forms['mainForm'].startDd.value );
		end = ymdToDate(eYear , eMonth , lastDd); 
	}
	pStatus = tStatus = tType = gLevel = oLevel = 0;
        ddValue = "";
        if (document.forms['mainForm'].reportNumber.value >= 2000 &&
            document.forms['mainForm'].reportNumber.value <= 3999) {
        } else {
	  if (document.forms['mainForm'].patientStatus0.checked) pStatus = pStatus + 2;
	  if (document.forms['mainForm'].patientStatus1.checked) pStatus = pStatus + 4;
	  if (document.forms['mainForm'].patientStatus2.checked) pStatus = pStatus + 8;
	  tStatus = getCheckedValue(document.forms['mainForm'].treatmentStatus);
	  tType = getCheckedValue(document.forms['mainForm'].testType);
	  gLevel  = getCheckedValue(document.forms['mainForm'].groupLevel);
<?
  $entity = array ("","patient", "clinic", "commune", "department", "network");
  echo "
          if (gLevel == 1) ddValue = document.forms['mainForm'].patient.value\n";
  if (count(getEntity(getSessionUser(), "clinic")) == 1) {
    // pick up from hidden values on form
    for ($i = 2; $i < 6; $i++) {
      echo "
          if (gLevel == " . $i . ") ddValue = document.forms['mainForm']." . $entity[$i] . ".value\n";
    }
  } else {
	for ($i = 2; $i < 6; $i++) {
		echo "
		if (gLevel == " . $i . ") {
			ival = document.forms['mainForm']." . $entity[$i] . ".selectedIndex
			ddValue = document.forms['mainForm']." . $entity[$i] . "[ival].value
		}";
	}
  }
  echo "\noLevel  = getCheckedValue(document.forms['mainForm'].otherLevel);\n";
  echo "}\n";

  if ($repNum == "511") {
	echo " var cmd = 'runCaseNotif.php?" . ($_GET['noid'] == "true" ? "noid=true&" : "") . "lang=' + document.forms['mainForm'].lang.value + '&site=';";
  } else {
	echo " var cmd = 'runReport.php?" . ($_GET['noid'] == "true" ? "noid=true&" : "") . "reportNumber=' + document.forms['mainForm'].reportNumber.value + '&rtype=' + document.forms['mainForm'].rtype.value + '&lang=' + document.forms['mainForm'].lang.value + '&site=';";
  }
?>
	switch (document.forms['mainForm'].reportNumber.value) {
	case '504':  
	case '512':  
	case '530':
		var firstOfMonth = new Date();
                firstOfMonth.setDate(1);
		var interval;
		if (document.forms['mainForm'].interval) 
			interval = document.forms['mainForm'].interval.value * oneMonth;
		else
			interval = oneMonth;
		if ((eDate.getTime() - sDate.getTime()) < interval + oneMonth) {
			alert ('<?=($repNum == "504" || $repNum == "512" ? $hivqualIntervalMsg[$lang] : $monthlyIndIntervalMsg[$lang]);?>');
			document.forms['mainForm'].startMm.focus();
			runFlag = false;
		}
		if (eDate.getTime() >= firstOfMonth.getTime()) {
			alert ('<?=$hivqualDateRangeMsg[$lang];?>');
			document.forms['mainForm'].endMm.focus();
			runFlag = false;
		}
		if (document.forms['mainForm'].clinic.type == 'hidden') {
			cmd += ddValue;
		} else if (document.forms['mainForm'].clinic.type == 'select-multiple') {
			multValue = '';
			for (z = 0; z <= document.forms['mainForm'].clinic.options.length - 1; z++) {
				if (document.forms['mainForm'].clinic.options[z].selected && document.forms['mainForm'].clinic.options[z].value && document.forms['mainForm'].clinic.options[z].value != null) {
					if (multValue.length > 0) multValue += '%2C';
					multValue += document.forms['mainForm'].clinic.options[z].value;
				}
			}
			cmd += multValue;
		} else if (document.forms['mainForm'].clinic.type == 'select-one') {
			sel = document.forms['mainForm'].clinic.selectedIndex;
			cmd += document.forms['mainForm'].clinic[sel].value;
		}
		if (document.forms['mainForm'].reportNumber.value == '504' ||
                    document.forms['mainForm'].reportNumber.value == '512') {
			cmd += '&interval=' + document.forms['mainForm'].interval.value;
		}
		break;
	case '505':
		ddValue = document.forms['mainForm'].patient.value;
		cmd = cmd + ddValue;
		break;
	case '511':
		myValue = null;
		if (document.forms['mainForm'].clinic.type == 'hidden') {
			myValue = ddValue;
		} else if (document.forms['mainForm'].clinic.type == 'select-multiple') {
			multValue = '';
			for (z = 0; z <= document.forms['mainForm'].clinic.options.length - 1; z++) {
				if (document.forms['mainForm'].clinic.options[z].selected && document.forms['mainForm'].clinic.options[z].value && document.forms['mainForm'].clinic.options[z].value != null) {
					if (multValue.length > 0) multValue += '%2C';
					multValue += document.forms['mainForm'].clinic.options[z].value;
				} 
			}
			myValue = multValue;
		} else if (document.forms['mainForm'].clinic.type == 'select-one') {
			sel = document.forms['mainForm'].clinic.selectedIndex;
			myValue = document.forms['mainForm'].clinic[sel].value;
		}
		prevdate = null;
		while (prevdate == null) {
			prevdate = prompt ('<?=$caseNotifPrevDate[$lang];?>', end); 
		}
		if (confirm ('<?=$caseNotifTimeMsg[$lang];?>')) {
			cmd = cmd + myValue + '&prevdate=' + prevdate;
		} else {
			runFlag = false; 
		}   
		break;
	case '520':
		myValue = null;
		if (document.forms['mainForm'].clinic.type == 'hidden') {
			myValue = ddValue;
		} else if (document.forms['mainForm'].clinic.type == 'select-multiple') {
		multValue = '';
		for (z = 0; z <= document.forms['mainForm'].clinic.options.length - 1; z++) {
			if (document.forms['mainForm'].clinic.options[z].selected && document.forms['mainForm'].clinic.options[z].value && document.forms['mainForm'].clinic.options[z].value != null) {
				if (multValue.length > 0) multValue += '%2C';
				multValue += document.forms['mainForm'].clinic.options[z].value; 
			}
		}
		myValue = multValue;
		} else if (document.forms['mainForm'].clinic.type == 'select-one') {
			sel = document.forms['mainForm'].clinic.selectedIndex;
			myValue = document.forms['mainForm'].clinic[sel].value;
		}
		cmd = cmd + myValue; 
		break;
	case '540':
		if (sDate.getTime() >= eDate.getTime()) {
			alert ('<?=$report540Labels[$lang][0];?>');
			document.forms['mainForm'].startDd.focus();
			runFlag = false;
		}
                var today = new Date('<?echo date ("m/d/Y");?>');
		if (eDate.getTime() >= today.getTime()) {
			alert ('<?=$report540Labels[$lang][1];?>');
			document.forms['mainForm'].endDd.focus();
			runFlag = false;
		}
		if (document.forms['mainForm'].clinic.type == 'hidden') {
			cmd += ddValue;
		} else if (document.forms['mainForm'].clinic.type == 'select-multiple') {
			multValue = '';
			for (z = 0; z <= document.forms['mainForm'].clinic.options.length - 1; z++) {
				if (document.forms['mainForm'].clinic.options[z].selected && document.forms['mainForm'].clinic.options[z].value && document.forms['mainForm'].clinic.options[z].value != null) {
					if (multValue.length > 0) multValue += '%2C';
					multValue += document.forms['mainForm'].clinic.options[z].value;
				}
			}
			cmd += multValue;
		} else if (document.forms['mainForm'].clinic.type == 'select-one') {
			sel = document.forms['mainForm'].clinic.selectedIndex;
			cmd += document.forms['mainForm'].clinic[sel].value;
		}
		break;
	case '604': 
	case '605':
		var obj = document.forms['mainForm'].network;
		if (obj.options[obj.selectedIndex].value == 'All') {
			alert('<?=$dispenseWarnings[$lang][0];?>');
			runFlag = false;  
		} 
		/* removed at Solon's request
		else {  
			if ((eDate.getTime() - sDate.getTime()) > (62 * oneDay)) { 
				alert('<?=$dispenseWarnings[$lang][1];?>');
				runFlag = false;        
			}
		} */
		ddValue = obj.options[obj.selectedIndex].value; 
		break; 
	default:
		cmd = cmd + document.forms['mainForm'].site.value;
	}
        if (gLevel > 1) {
                var entities = ['', '', 'clinic', 'commune', 'department', 'network'];
                var entityName = entities[gLevel];
                if (document.forms['mainForm'][entityName].type == 'select-multiple') {
                        multValue = '';
                        for (z = 0; z <= document.forms['mainForm'][entityName].options.length - 1; z++) {
                                if (document.forms['mainForm'][entityName].options[z].selected &&
                                                document.forms['mainForm'][entityName].options[z].value &&
                                                document.forms['mainForm'][entityName].options[z].value != null) {
                                        if (multValue.length > 0) multValue += '%2C';
                                        multValue += document.forms['mainForm'][entityName].options[z].value;
                                }
                        }
                        if (multValue.indexOf('All') < 0) ddValue = multValue;
                }
        }
	cmd = cmd + '&patientStatus=' + pStatus + '&treatmentStatus=' + tStatus + '&testType=' + tType + '&groupLevel=' + gLevel + '&otherLevel=' + oLevel + '&start=' + start + '&end=' + end + '&pid=' + document.forms['mainForm'].pid.value + '&ddValue=' + ddValue;
	if (runFlag) doWindow(cmd)
}

function daysInMonth(month,year) {
	var dd = new Date(year, month, 0);
	return dd.getDate();
}

function doWindow (url) {
<? 
  if ($repNum == '504' || $repNum == '512' || $repNum == '530') echo "
	stuff = 'width=1024,height=600,toolbar=yes,location=yes,directories=no,scrollbars=yes,menubar=yes,resizable=yes'
  ";
  else if ($repNum == "511") echo "
	stuff = 'width=1024,height=600,toolbar=yes,location=yes,directories=no,scrollbars=yes,menubar=yes,resizable=yes'
  ";
  else echo "
	stuff = 'width=1024,height=1000,toolbar=yes,location=yes,directories=no,scrollbars=yes,menubar=yes,resizable=yes'
  ";
?>
	currWindow = window.open(url ,'ContentAreaLaunchedReport', stuff)
	currWindow.focus()
}
</script>
</head>
<body onLoad="if (document.getElementById('repDesc')) document.getElementById('repDesc').readOnly = true;">
<form name="mainForm" action="#" method="get">
<?
include 'bannerbody.php';
echo "
<div class=\"contentArea\">
<table class=\"formType\">
	<tr>
		<td id=\"title\" class=\"m_header\" width=\"50%\">" . $kickLabel['parameters'][$lang] . ": " . $title . "</td>
		<td id=\"errorText\" width=\"50%\"></td>
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
if ($repNum == "504" || $repNum == '512') {
  $stDate = date ("m/d/y", strtotime ("$mm/01/$yy -6 months"));
  list ($stMm, $stDd, $stYy) = explode ("/", $stDate);
} elseif ($repNum == "530" || $repNum == "604" || $repNum == "605") {
  $stDate = date ("m/d/y", strtotime ("$mm/01/$yy -1 months"));
  list ($stMm, $stDd, $stYy) = explode ("/", $stDate);
} elseif ($repNum == "540") {
  $stDate = date ("m/d/y", strtotime ("$mm/$dd/$yy -6 days"));
  list ($stMm, $stDd, $stYy) = explode ("/", $stDate);
} elseif ($repNum >= 2000 && $repNum <= 3999) {
  $stDate = date ("m/d/y", strtotime ("$mm/01/$yy"));
  list ($stMm, $stDd, $stYy) = explode ("/", $stDate);
} else {
  list ($stMm, $stDd, $stYy) = array ("01", "01", "01");
}

if ($repNum == "540") {
  $startFields = "<td><input type=\"text\" name=\"startDd\" value=\"$stDd\" size=\"2\" />/<input type=\"text\" name=\"startMm\" value=\"$stMm\" size=\"2\" " . $startDisabled . " />/<input type=\"text\" name=\"startYy\" value=\"$stYy\" size=\"2\" " . $startDisabled . "/> " . setLabelDisabled($dateFormatWithDay[$lang], $startPassedIn) . "</td>";
  $endFields = "<td><input type=\"text\" name=\"endDd\" value=\"$dd\" size=\"2\" />/<input type=\"text\" name=\"endMm\" value=\"" . $mm . "\" size=\"2\"" . $endDisabled . " />/<input type=\"text\" name=\"endYy\" value=\"" . $yy . "\" size=\"2\" " . $endDisabled . " /> " . setLabelDisabled($dateFormatWithDay[$lang], $endPassedIn) . "</td>";
} else {
  $startFields = "<td><input type=\"hidden\" name=\"startDd\" value=\"$stDd\" size=\"2\" /><input type=\"text\" name=\"startMm\" value=\"$stMm\" size=\"2\" " . $startDisabled . " />/<input type=\"text\" name=\"startYy\" value=\"$stYy\" size=\"2\" " . $startDisabled . "/> " . setLabelDisabled($dateFormat[$lang], $startPassedIn) . "</td>";
  $endFields = "<td><input type=\"hidden\" name=\"endDd\" value=\"$dd\" size=\"2\" /><input type=\"text\" name=\"endMm\" value=\"" . $mm . "\" size=\"2\"" . $endDisabled . " />/<input type=\"text\" name=\"endYy\" value=\"" . $yy . "\" size=\"2\" " . $endDisabled . " /> " . setLabelDisabled($dateFormat[$lang], $endPassedIn) . "</td>";
}

echo "
<table>
  <tr>
	<td>" . setLabelDisabled($startDateLabel[$lang], $startPassedIn) . "</td>
        $startFields
	<td>&nbsp;</td>
	<td>" . setLabelDisabled($endDateLabel[$lang], $endPassedIn) . "</td>
        $endFields
	";   
if ($repNum == "504" || $repNum == '512') {
	echo "
	<td>&nbsp;</td>
	<td><input type=\"text\" name=\"interval\" value=\"" . $interval . "\" size=\"2\"/> " . $hivqualInterval[$lang] . "</td>
	";
}   
echo "
  </tr>
</table>
<input type=\"hidden\" name=\"pid\" value=\"" . $pid . "\" />
<input type=\"hidden\" name=\"rtype\" value=\"" . $rtype . "\" />
<input type=\"hidden\" name=\"reportNumber\" value=\"" . $repNum . "\" />
<table width=\"100%\" border=\"0\">
";
if ($repNum >= 2000 && $repNum <= 3999) { // use prim. care & ob/gyn report layout
  echo "
	<tr>
		<th align=\"left\" colspan=\"2\">" . _("Description") . "</th>
	</tr>
	<tr>
		<td align=\"left\" colspan=\"2\"><textarea style=\"overflow: auto; font-family: Verdana, Arial, Helvetica, Geneva, sans-serif; color: #444; font-size: 11px; line-height: 1.5em;\" cols=\"90\" rows=\"9\" id=\"repDesc\">" . str_replace ("<BR/>", "\n", $repDesc) . "</textarea></td>
	</tr>
	<tr>
		<th align=\"left\" colspan=\"2\">" . setLabelDisabled($kickLabel['groupLevel'][$lang][0], $gLevel) . "</th>
	</tr>
  ";
} else { // use HIV report layout
  echo "
	<tr>
		<th align=\"left\" colspan=\"2\">" . setLabelDisabled($kickLabel['patientStatus'][$lang][0], $pStatus) . "</th>
		<td class=\"vert_line\" rowspan=\"16\" width=\"1%\">&nbsp;</td>
		<th align=\"left\">" . setLabelDisabled($kickLabel['treatmentStatus'][$lang][0], $tStatus) . "</th>
		<td class=\"vert_line\" rowspan=\"7\" width=\"1%\">&nbsp;</td>
		<th align=\"left\">" . setLabelDisabled($kickLabel['testType'][$lang][0], $tType) . "</th>
	</tr>
  ";

	$j = 1;
	for ($i = 1; $i <= 6; $i++) {
		echo "
		<tr>";
			if ($i <= 3) {
				echo "
				<td colspan=\"2\" width=\"50%\">" . genCheckboxControl ($kickLabel, $lang, "patientStatus", $i-1, $pStatus) . "
				</td>
				<td width=\"29%\">" . genRadioControl ($kickLabel, $lang, "treatmentStatus", $i, $tStatus, $repNum) . "</td>";
			}
			if ($i >= 4) {
				echo "
				<td colspan=\"2\" width=\"50%\">&nbsp;</td>
				<td width=\"29%\">" . genRadioControl ($kickLabel, $lang, "treatmentStatus", $i, $tStatus, $repNum) . "</td>";
			}
			if ($j <= 8) {
				echo "
				<td width=\"22%\">
					<span class=\"small_cnt\">" .
						genRadioControl ($kickLabel, $lang, "testType", $j++, $tType, $repNum) . "<br>" .
						genRadioControl ($kickLabel, $lang, "testType", $j++, $tType, $repNum) . "
					</span>
				</td>";
			}
		echo "
		</tr>";
	}
	echo "
	<tr>
		<td colspan=\"5\">&nbsp;</td>
	</tr>
	<tr>
		<th align=\"left\" colspan=\"2\">" . setLabelDisabled($kickLabel['groupLevel'][$lang][0], $gLevel) . "</th>
		<th align=\"left\">" . setLabelDisabled($kickLabel['otherLevel'][$lang][0], $oLevel) . "</th>
	</tr>";
}
	$user = getSessionUser ();
	if (empty ($site)) $site = getDefaultSite ($user);
	$defDropdown = "selected";
	if ($_GET["noid"] == "true" && $gLevel < 2) $gLevel = 2;
	if ($site == "00000") $gLevel = 4;
	for ($i = 1; $i <= 5; $i++) {
		$rc = genRadioControl ($kickLabel, $lang, "groupLevel", $i, $gLevel, $repNum);
		if ($i == 1 && $_GET['noid'] == "true") $rc = "&nbsp;";
		echo "
		<tr>
			<td>" . $rc . "</td>
			<td>";
			if ($i == 1) {
				if ($site != "00000") {
					$sn = getSiteName ($site, $lang);
					if ($i == 1 && ($repNum > 5029 && $repNum < 5047)) $sn = setLabelDisabled($sn, 0);
					echo $sn . "<input type=\"hidden\" name=\"" . $entity[$i] . "\" value=\"" . $site . "\"></td>";
				} else {
					echo "&nbsp;</td>";
				}
			} else if ($i == 2) {
				if ($repNum == 504 || $repNum == '512') {
					if ($_GET["noid"] == "true" || SERVER_ROLE == "consolidated") {
						echo loadHivQualDropdown ($lang, array ("21100", "71100", "71401", "71104", "72101", "11100", "11208", "11303", "11127", "91100", "41100", "31100", "32301", "31101", "84100", "81100", "51100", "63101", "54201")) . "</td>";
					} else {
						$sn = getSiteName ($site, $lang);
						echo loadDropdown ($entity[$i], $lang, $user, $gLevel, $sn, "") . "</td>";
					}
				} else if ($repNum == 511 || $repNum == 520 || $repNum == 530 || $repNum == 540) {
					if ($_GET["noid"] == "true" || SERVER_ROLE == "consolidated") {
						echo loadHivQualDropdown ($lang, array ($site)) . "</td>";
					} else {
						$sn = getSiteName ($site, $lang);
						echo loadDropdown ($entity[$i], $lang, $user, $gLevel, $sn, "") . "</td>";
					}
				} else {
					echo loadDropdown ($entity[$i], $lang, $user, $gLevel, "", $defDropdown) . "</td>";
				}
			} else // $i 3,4,5
				if ($repNum == 504 || $repNum == 505 || $repNum == 511 || $repNum == '512' || $repNum == 530) {
					echo loadDropdown ($entity[$i], $lang, $user, 0, "", $defDropdown) . "</td>";
				} else {
					echo loadDropdown ($entity[$i], $lang, $user, $gLevel, "", $defDropdown) . "</td>";
			}
		if ($i < 5 && ($repNum < 2000 || $repNum > 3999)) {
                        // Not displaying 'pregnancy' grouping option since it
                        // is incorrectly implemented and will take more time
                        // than currently available to fix - JS 1/31/2013
                        if ($i == 4) continue;
			echo "<td>" . genRadioControl ($kickLabel, $lang, "otherLevel", $i, $oLevel, $repNum) . "</td>";
		}
		echo "</tr>";
	}
?>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
</table>
<input id="kickPoint" type="button" value="<?=$buttonLbls[$lang][0];?>" onClick="sendParameters()" />&nbsp;
<input type="reset" value="<?=$buttonLbls[$lang][1];?>" />
</div>
</div>
</form>
</body>
</html>
<?
function genNoReason($lang) { 
	/* this is not factored in at the moment:
		, "otherMedEligText"
	 */
        $reasonArray = array("initiateTB", "continueTB", "inadPsychPro", "poorAdherence", "patientPref", "inadPrepForAd",
        "doesntAccAcc", "doesntAccHome", "weakFamilySupp", "barriersToReg", "livesOutsideZone", "progHasRlimit", "ARVsTempUn",
        "otherMedElig");
        if ($lang == 'en')
	$reasonDescArray = array (
	"Initiate TB treatment before ARV enrollment",
	"Currently on TB treatment: continue before enrolling",
	"Inadequate psychological profile",
	"Poor adherence (previous regimen)",
	"Patient preference",
	"Inadequate preparation for adherence", 
	"Doesn't accept treatment buddy",
	"Doesn't accept home visit",
	"Weak family support", 
	"Barriers to regular clinic visits", 
	"Lives outside zone of program services",
	"Program has reached enrollment limit",
	"ARVs temporarily unavailable",
	"Other"); 
	else
	$reasonDescArray = array (
	"Initier traitement TB avant enr&#xf4;lement ARV",  
	"Actuellement sous traitement TB: continuer avant enr&#xf4;lement",
	"Profil psychologique inad&eacute;quat", 
	"Adh&eacute;rence inad&#xe9;quate (r&eacute;gime ant&eacute;rieur)",
	"Pr&#xe9;f&#xe9;rence du patient",
	"Pr&#xe9;paration inad&#xe9;quate pour adh&#xe9;rence maximum", 
	"N'accepte pas d'accompagnateur", 
	"N'accepte pas de visite &#xe0; domicile",
	"Support familial faible", 
	"Difficult&#xe9;s de suivi clinique",
	"R&#xe9;sidence hors zone de couverture",  
	"Limite d'enr&#xf4;lement atteinte",    
	"ARV temporairement non-disponibles",
	"Autre");
        $qry = "drop table if exists arvNoReasons";
        $retVal = database()->query($qry)->rowCount();
        $qry = "create table arvNoReasons (patientid varchar(11) not null, arvNoReasonDesc varchar(100) not null, index arvNoI (patientid, arvNoReasonDesc))";
        $retVal = database()->query($qry)->rowCount();
        $qry = "select distinct * from arvEnrollment where arv = 2";
        $retArray = databaseSelect()->query($qry)->fetchAll();
        foreach ($retArray as $rec) {
                foreach ($reasonArray as $key => $col) {
                        if ($rec[$col] == 1) {
                                $retVal = database()->query("insert into arvNoReasons (patientid, arvNoReasonDesc) values (?,?)",array($rec['patientID'], $reasonDescArray[$key]))->rowCount();
                        }
                }
        }
}
