<?php

require_once 'include/standardHeaderExt.php';
require_once 'labels/report.php';
require_once 'labels/menu.php';

if (DEBUG_FLAG) print_r($_GET);
switch ($rtype) {
	case "clinicalCare":
		$formTitle = $menuReports[$lang][0];
		break;
	case "individualCase":
		$pid = $_GET['pid'];
		$formTitle = $menuReports[$lang][1];
		break;
	case "qualityCare":
		$formTitle = $menuReports[$lang][2];
		break;
	case "aggregatePop":
		$formTitle = $menuReports[$lang][3];
		break;
	case "primaryCare":
		$formTitle = $menuReports[$lang][7];
		break;
	case "obGyn":
		$formTitle = $menuReports[$lang][8];
		break;
	case "dataQuality":
		$formTitle = $menuReports[$lang][4];
		break;
	case "adhoc":
		$formTitle = $menuReports[$lang][5];
}

echo "
<title>" . $topLabels[$lang][3] . "</title>
<script type=\"text/javascript\">

function addParams(url) {
  nForms = prompt ('" . $rep510Prompts[$lang][0] . "', '100')
  if (nForms == '' || nForms == null) nForms = '100'
    creator = prompt ('" . $rep510Prompts[$lang][1] . "', '%')
    if (creator == '' || creator == null) creator = '%'
      url = url + '&nForms=' + nForms + '&creator=' + creator
      doWindow (url)
}

function addStartEndDates(url)
{
	startDate = prompt ('" . $repDatePrompts[$lang][0] . "', '2001-01-01')
	if (startDate == '' || startDate == null || Date.parse(startDate)=='NaN' ) startDate = '2001-01-01'
    var cDate = new Date();
    var cDateStr = cDate.getFullYear() + '-' + (cDate.getMonth() < 9 ? '0' : '') + (cDate.getMonth() + 1) + '-' + (cDate.getDate() < 10 ? '0' : '') + cDate.getDate();
    endDate = prompt ('" . $repDatePrompts[$lang][1] . "', cDateStr)
    if (endDate == '' || endDate == null || Date.parse(endDate)=='NaN') endDate = cDateStr
      url = url + '&start=' + startDate + '&end=' + endDate
      doWindow (url)
}

function doWindow (url) {
	stuff = 'width=800,height=600,toolbar=yes,location=yes,directories=no,scrollbars=yes,menubar=yes,resizable=yes'
	currWindow = window.open(url ,'RapportWindow', stuff)
	currWindow.focus()
}

</script>
</head>
<body>
<form name=\"mainForm\" action=\"runQuery.php?lang=" . $lang . "&amp;ddValue=&amp;site=" . $site . "\" method=\"get\">
";

include ("bannerbody.php");
echo "
  <input type=\"hidden\" name=\"reportNumber\" />
  <input type=\"hidden\" name=\"reportFormat\" />
  <input tabindex=\"0\" name=\"pid\" value=\"\" type=\"hidden\" />
  <input tabindex=\"0\" name=\"site\" value=\"$site\" type=\"hidden\" />
  <input tabindex=\"0\" name=\"lang\" type=\"hidden\" value=\"$lang\" />
  <input type=\"hidden\" name=\"start\" />
  <input type=\"hidden\" name=\"end\" />
  <div class=\"contentArea\">
  <table class=\"formType\">
  			<tr >
  			<td id=\"title\" class=\"m_header\" width=\"50%\">" . $topLabels[$lang][3] . "</td>
  				<td id=\"errorText\" width=\"50%\"></td>
  			</tr>
		</table>
";

   	// compute the current date as the end date
	  $date = date("d/m/y");
      list($dd, $mm, $yy) = explode('/', $date);
	echo "
		<input type=\"hidden\" name=\"startDd\" value=\"01\" size=\"2\" />
		<input type=\"hidden\" name=\"startMm\" value=\"01\" size=\"2\" />
		<input type=\"hidden\" name=\"startYy\" value=\"01\" size=\"2\" />
		<input type=\"hidden\" name=\"endDd\" value=\"" . $dd . "\" size=\"2\" />
		<input type=\"hidden\" name=\"endMm\" value=\"" . $mm . "\" size=\"2\" />
		<input type=\"hidden\" name=\"endYy\" value=\"" . $yy . "\" size=\"2\" />";
	$colHead = split("/", $reportGroup[$lang]);
  	echo "<table cellspacing='5' border='0' id='reportsTable'>
  	<tr><th align=\"left\">" . $colHead[0] . "</th><th align=\"left\">" . $colHead[1] . "</th></tr>";
	    $reportSetArray = genReportArray($rtype, "");
	    $k = 0;
	    $groupName = "";
	    for ($i = 0; $i < count($reportSetArray); $i++) {
			$repName = $reportSetArray[$i]['reportName' . $lang];
			$repNum =  $reportSetArray[$i]['reportNumber'];
			$repDesc = $reportSetArray[$i]['description'];
			$pStatus = $reportSetArray[$i]['patientStatus'];
			$tStatus = $reportSetArray[$i]['treatmentStatus'];
			$tType = $reportSetArray[$i]['testType'];
			$gLevel =  $reportSetArray[$i]['groupLevel'];
			$oLevel =  $reportSetArray[$i]['otherLevel'];
			$mSelection =  $reportSetArray[$i]['menuSelection'];
			
			// skip r34 report for all sites except Justinien
			if ($repNum == 778 && getConfig('defsitecode') != '31100' ) continue;

			if ( $repNum == '') { // group header--print on left
				$k = 0;
				$groupName = $repName;
				echo "<tr bgcolor=\"#DDDDDD\"><td>" . $groupName . "</td>";
				$flag = true;
			} else { // actual report link shd be generated
				if ($flag)
					$flag = false;
				else {
					if ($k % 2) echo "<tr bgcolor=\"#DDDDDD\">";
					else echo "<tr>";
					echo "<td bgcolor=\"#FFFFFF\">&nbsp;</td>";
				}
				echo "<td>";
				$requestNoid = '';
				if (array_key_exists('noid', $_REQUEST)) {
					$requestNoid = $_REQUEST['noid'];
				}
				if (($pStatus + $tStatus + $tType + $gLevel + $oLevel == 0) && $mSelection != "dateSelect") {  // launch directly off the menu
					$url = "runReport.php?" . ($requestNoid == "true" ? "noid=true&" : "") . "rtype=" . $_GET['rtype'] . "&reportNumber=" . $repNum . "&lang=" . $lang . "&site=" . $site . "&patientStatus=" . $pStatus . "&treatmentStatus=" . $tStatus . "&testType=" . $tType . "&groupLevel=0&otherLevel=0&start=" . $start . "&end=" . $end . "&pid=" . $pid . "&ddValue=0";
					if ($repNum == 510)
						echo "<a href=\"#\" onclick=\"addParams ('" . $url . "')\">" . $repName . "</a>";
					else if ($repNum >600 && $repNum < 610 )
						echo "<a href=\"#\" onclick=\"addStartEndDates ('" . $url . "')\">" . $repName . "</a>";
					else
						echo "<a href=\"#\" onclick=\"doWindow ('" . $url . "')\">" . $repName . "</a>";
				} else {  // launch via kickPoint
					if ($repNum == 777) {
						$url = "kick2.php?" . ($requestNoid == "true" ? "noid=true&" : "") . "rtype=" . $_GET['rtype'] . "&reportNumber=" . $repNum . "&lang=" . $lang . "&site=" . $site . "&patientStatus=" . $pStatus . "&treatmentStatus=" . $tStatus . "&testType=" . $tType . "&groupLevel=" . $gLevel . "&otherLevel=" . $oLevel . "&menu=" . $mSelection . "&lastPid=" . $_GET['lastPid'];

					} else
					$url = "kickPoint.php?" . ($requestNoid == "true" ? "noid=true&" : "") . "rtype=" . $_GET['rtype'] . "&reportNumber=" . $repNum . "&lang=" . $lang . "&site=" . $site . "&patientStatus=" . $pStatus . "&treatmentStatus=" . $tStatus . "&testType=" . $tType . "&groupLevel=" . $gLevel . "&otherLevel=" . $oLevel . "&menu=" . $mSelection . "&lastPid=" . $_GET['lastPid'];
					echo "<a href=\"" . $url . "\">" . $repName . "</a>";
				}
				echo "</td></tr>";
			}
			$k++;
		}
    echo "</table>";
?>

</div>
</form>
</body>
</html>
