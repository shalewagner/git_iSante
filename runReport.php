<?php
require_once 'backend.php';
require_once 'backend/report.php';
require_once 'labels/report.php';

if (DEBUG_FLAG) $rptStart = time();

$repNum = ereg_replace('[^0-9]', '', $_GET['reportNumber']);
$rtype = $_GET['rtype'];
$lang = $_GET['lang'];
$printLabel = ($lang == 'fr') ? 'Impression':'Print';
$site = $_GET['site'];
$pStatus = $_GET['patientStatus'];
$tStatus = $_GET['treatmentStatus'];
$tType = $_GET['testType'];
$gLevel = $_GET['groupLevel'];
$oLevel = $_GET['otherLevel'];
$start = $_GET['start'];
$end = $_GET['end']; 
$pid = $_GET['pid'];
$ddValue = $_GET['ddValue'];
$siteName = lookupSiteName($site);
$order = "";
if (!empty ($_GET['order']))
	$order = $_GET['order'];
$odir = "";
if (!empty ($_GET['odir']))
	$odir = $_GET['odir'];
$nForms = "";
if (!empty ($_GET['nForms']))
	$nForms = $_GET['nForms'];
$creator = "";
if (!empty ($_GET['creator']))
	$creator = $_GET['creator'];
$xml = loadXMLFile("jrxml/reports.xml");

$xpath = "reportSet[@rtype='$rtype']/reportSubSet/report[@id='$repNum']";
$xmlRep = $xml->xpath($xpath);
$titleArray = $xml->xpath("//report[@id='$repNum']/title[@lang='$lang']");
$title = $titleArray[0];
$descArray = $xml->xpath ("//report[@id='$repNum']/description[@lang='$lang']");
$repDesc = (CHARSET == 'ISO-8859-1') ? utf8_decode($descArray[0]) : $descArray[0];
$menuSelection = $xmlRep[0]->menuSelection;
$GLOBALS['reportTotal'] = 0;
$tblNames = array ();

$userSub = substr(getSessionUser(), 0, 3);

// for HIVQUAL (504), HEALTHQUAL (512) & Monthly Quality of Care (530),
// exit script at end of if
if ($repNum == '504' || $repNum == '512' || $repNum == '530') {
  if ($repNum == '504' || $repNum == '530') {
    require_once 'backend/hivQualFunctions.php';
  } else {
    require_once 'backend/healthQualFunctions.php';
  }
  $username = ereg_replace ('[^A-Za-z0-9]', '', getSessionUser());

  // Remove any "temporary" tables that may exist. They are no longer needed and this is just here to clean them out.
  $tempName = 'tempHivQual' . $username;
  dbQuery("DROP TABLE IF EXISTS $tempName");

  // Restrict these reports so that they can only be run one-at-a-time per user
  $isRunning = 0;
  $runningSince = "";
  $connID = 0;
  $reportNumber = 0;
  $val1 = $val2 = $val3 = $val4 = "";
  dbBeginTransaction ();
  dbLockTables (array('staticReportData'));
  $result = dbQuery ("
    SELECT runningSince, connID, reportNumber, value1, value2, value3
    FROM staticReportData
    WHERE reportNumber IN (504, 512, 530)
     AND username = '$username'
    GROUP BY 1,2,3,4,5,6");
  while ($row = psRowFetch ($result)) {
    if (!empty ($row[0])) {
      $isRunning = 1;
      break;
    }
  }
  if ($isRunning) {
    $runningSince = $row[0];
    $connID = $row[1];
    $reportNumber = $row[2];
    $val1 = $row[3];
    $val2 = $row[4];
    $val3 = $row[5];
  } else {
    dbQuery ("
      DELETE FROM staticReportData
      WHERE reportNumber=$repNum
       AND username='$username'");
    if ($repNum == "512") {
      insertHealthqualStaticRows (
        array ("runningSince" => "'" . date ("Y-m-d H:i:s") . "'",
               "connID" => "CONNECTION_ID()",
               "reportNumber" => 512,
               "username" => "'$username'"));
    } else {
      dbQuery ("
        INSERT staticReportData (runningSince, connID, reportNumber, username) 
        VALUES ('" . date ("Y-m-d H:i:s") . "', CONNECTION_ID(), $repNum, '$username')");
    }
  }
  dbCommit ();
  dbUnlockTables ();

  if ($isRunning) {
    header ("Location: reportRunning.php?ts=$runningSince&conn=$connID&report=$reportNumber&username=$username&val1=$val1&val2=$val2&val3=$val3&lang=$lang");
    exit;
  }

  // For each time period, check which sites have been updated since the last
  // run, and only run for them or if no existing data.
  $intervalLength = !empty ($_GET['interval']) ? $_GET['interval'] : 6;
  if ($repNum == '530') {
    $intervalLength = 1;
  }
  $endTs = strtotime($end);
  $startTs = strtotime($start);
  $times = round( (($endTs - $startTs) / (60 * 60 * 24 * 30.4368499) - 1) / $intervalLength );
  $endingDate = date ("Y-m-d", $endTs);
  $sites = explode (",", $site);

  // Loop once for each time period
  for ($i = 1; $i <= $times; $i++) {
    $startDate = monthDiff(-$intervalLength, $endingDate);

    // Put time period in user's temp table
    // If first time through, just update, else insert
    if ($i == 1) {
      dbQuery("
        UPDATE staticReportData
        SET value1 = '$startDate',
         value2 = '$endingDate',
         value3 = '$site' 
        WHERE reportNumber = $repNum
         AND username = '$username'");
    } else {
      // Update runningSince to indicate new report is running
      dbBeginTransaction ();
      dbLockTables (array('staticReportData'));
      dbQuery("
        UPDATE staticReportData
        SET runningSince = NULL
        WHERE reportNumber = $repNum
         AND runningSince IS NOT NULL
         AND username = '$username'");
      if ($repNum == "512") {
        insertHealthqualStaticRows (
          array ("runningSince" => "'" . date ("Y-m-d H:i:s") . "'",
                 "connID" => "CONNECTION_ID()",
                 "reportNumber" => 512,
                 "username" => "'$username'",
                 "value1" => "'$startDate'",
                 "value2" => "'$endingDate'",
                 "value3" => "'$site'"));
      } else {
        dbQuery("
          INSERT staticReportData (runningSince, connID, reportNumber, username, value1, value2, value3) 
          VALUES ('" . date ("Y-m-d H:i:s") . "', CONNECTION_ID(), $repNum, '$username', '$startDate', '$endingDate', '$site')");
      }
      dbCommit ();
      dbUnlockTables ();
    }

    // For each site, only compute data if none exists for this time period
    // or if any data has been modified for the site since the last run
    $qualTable = $repNum == "512" ? "healthQual" : "hivQual";
    $rowTypeSql = "";
    if ($repNum == "504") {
      $rowTypeSql = "(row_type IN (0, 2) OR row_type IS NULL)";
    } else if ($repNum == "512") {
      $rowTypeSql = "row_type IN (1, 2)";
    } else if ($repNum == "530") {
      $rowTypeSql = "row_type = 1";
    }

    foreach ($sites as $clinic) {
      $lastRun = strtotime ("2001-01-01");
      $result = dbQuery ("
        SELECT TOP 1 lastRun 
        FROM $qualTable
        WHERE siteCode = '$clinic'
         AND startDate = '$startDate'
         AND endDate = '$endingDate'
         AND $rowTypeSql
        ORDER BY lastRun DESC");
      while ($row = psRowFetch ($result)) {
	if (!empty ($row[0])) $lastRun = strtotime ($row[0]);
      }

      $lastMod = strtotime ("2001-01-01");
      $result = dbQuery ("
        SELECT TOP 1 lastModified
        FROM encounter
        WHERE siteCode = '$clinic'
        ORDER BY lastModified DESC");
      while ($row = psRowFetch ($result)) {
	if (!empty ($row[0])) $lastMod = strtotime ($row[0]);
      }

      if ($lastMod >= $lastRun) {
        // Run for this site and time period
        if ($repNum == "512") {
          healthQual($repNum, $clinic, $intervalLength, $startDate, $endingDate);
        } else {
          hivQual($repNum, $clinic, $intervalLength, $startDate, $endingDate);
        }
      }
    }

    // If last time period, remove timestamp to indicate report is finished
    if ($times == $i) {
      dbBeginTransaction ();
      dbLockTables (array('staticReportData'));
      dbQuery("
        UPDATE staticReportData
        SET runningSince = NULL
        WHERE reportNumber = $repNum
         AND value1 = '$startDate'
         AND value2 = '$endingDate'
         AND value3 = '$site'
         AND username = '$username'");
      dbCommit ();
      dbUnlockTables ();
    } else {
      // Prep for next time period
      $endingDate = $startDate;
    }
  }

  header ("Location: " . JASPER_RENDERER . "?" . ($_GET['noid'] == "true" ? "noid=true&" : "") . "report=$repNum&rtype=$rtype&lang=$lang&format=html&user=$username&jasperRenderer=" . urlencode (substr (JASPER_RENDERER, strrpos (JASPER_RENDERER, "/") + 1)));

  exit;
}


include 'include/standardHeader.php';
if (DEBUG_FLAG) print_r ($_GET);

// do some pre-processing on some of the reports
if ($repNum >= 2000 && $repNum <= 2999) {
  include_once ("backend/primCareRptFunctions.php");
  #$tblNames = primCareSetup ($site, $start, $end, $userSub);
}

if ($repNum >= 3000 && $repNum <= 3999) {
  include_once ("backend/obGynRptFunctions.php");
  #$tblNames = obGynSetup ($site, $start, $end, $userSub);
}

switch ( $repNum ) {
	case '200':
	case '201':
		// nastad
		//dbQuery("sp_nastad");
		break;
	case '503':
		// for new pepfar
		include_once ("backend/pepfarRptFunctions.php");
                $startDate = monthDiff (-1, $end);
                pepfarMain ($site, $lang, $startDate, $end, $username, $utf8Months);
		break;
	case '505':
		// for old pepfar
		include ("pepfarInit.php");
		include ("pepfarLoad.php");
		doPepfarPrep($site, $lang, $start, $end);
		break;
    case '520':
        // for report 520 (pregnancy regimens)
        include ("report520Setup.php");
        $oLevel = 0;
        $gLevel = 0;
        break;
    case '540':
        // for report 540 (disease surveillance)
        include ("report540Setup.php");
        $oLevel = 0;
        $gLevel = 0;
        break;
    case '601':
        include ("backend/sharedRptFunctions.php");
        $tempTableNames = createTempTables ("#tempPregCalc", 2, array ("patientID varchar(11), maxDate date", "patientID varchar(11), lmpDate date, eligDate date"), "pat_idx::patientID");
        fillLmpTable ($tempTableNames[2], $site, $end, (strtotime ($start) >= strtotime (PMTCT_14_WEEKS_DATE) ? 98 : 196));
        fillPregnancyTable ($tempTableNames[1], $site, $start, $end, $tempTableNames[2]);
        break;
	case '604':
	case '605':
		$gLevel = 0;
		break;
	case '909':
		// cohort analysis
		dbQuery("sp_cohortAnalysis");
	case '5000':
		echo  "<style type=\"text/css\">
	    <!--
		td{font-family: Arial; font-size: 8pt;}
		th{font-family: Arial; font-size: 8pt;}
	    --->
		</style>";
        break;
    case ($repNum >= 2000 && $repNum <= 2999):
        $tempNames = setupPrimCareRpt ($repNum, $site, $start, $end, $userSub);
        if (!empty ($tempNames)) {
          foreach ($tempNames as $tbl) {
            array_push ($tblNames, $tbl);
          }
        }
        if (DEBUG_FLAG) dumpTempTables ($tblNames);
        $den = count (denPrimCareRpt ($repNum, $site, $start, $end, $tblNames));
        break;
    case ($repNum >= 3000 && $repNum <= 3099 && $repNum != 3001):
        $tempNames = setupObGynRpt ($repNum, $site, $start, $end, $userSub);
        if (!empty ($tempNames)) {
          foreach ($tempNames as $tbl) {
            array_push ($tblNames, $tbl);
          }
        }
        if (DEBUG_FLAG) dumpTempTables ($tblNames);
        $den = count (denObGynRpt ($repNum, $site, $start, $end, $tblNames));
        break;
    case (($repNum >= 3100 && $repNum <= 3999) || $repNum == 3001):
       $tempNames = setupObGynRpt ($repNum, $site, $start, $end, $userSub);
       if (!empty ($tempNames)) {
         foreach ($tempNames as $tbl) {
           array_push ($tblNames, $tbl);
         }
       }
       if (DEBUG_FLAG) dumpTempTables ($tblNames);
       break;
}

$r34pStatus = $pStatus;
$r34tStatus = $tStatus;
	if (DEBUG_FLAG) print "<br>before list statement, query for table: " . $qry . "<br>";
list($qry, $chartQry, $tableName,
     $start, $end, $pStatus, $tStatus, $tType,
     $gLevel, $oLevel, $ddValue) = 
  prepareReportQueries($xmlRep, $rtype, $repNum, $lang, $site, $pStatus, $tStatus, $tType,
		       $gLevel, $oLevel, $start, $end, $pid, $ddValue,
		       $nForms, $creator, $order, $odir);
	if (DEBUG_FLAG) print "<br>after list statement, query for table: " . $qry . "<br>";
if ($repNum == 777) {
$pStatus = $r34pStatus;
$tStatus = $r34tStatus;
}
?>
<script type="text/javascript" src="jquery-<?= JQUERY_VERSION ?>.js"></script>
<script type="text/javascript" src="Highcharts-<?= HIGHCHARTS_VERSION ?>/js/highcharts.js"></script>
<script type="text/javascript">
//Global chart options which emulate the style of phpcharts.
Highcharts.setOptions({
	chart: {
	    backgroundColor: "#fafafa",
	    borderColor: "#a3a3a3",
	    borderWidth: 1,
	    borderRadius: 0,
	    plotBackgroundColor: "#ffffff",
	    plotBorderColor: "#dcdbc6",
	    plotBorderWidth: 1
	},
	colors: [
		 'rgb(51, 153, 255)',
		 'rgb(255, 204, 51)',
		 'rgb(0, 153, 102)',
		 'rgb(204, 51, 153)',
		 'rgb(255, 102, 0)',
		 'rgb(51, 255, 102)',
		 'rgb(244, 49, 84)',
		 'rgb(50, 50, 50)',
		 'rgb(200, 200, 200)',
		 'rgb(173, 137, 60)',
		 'rgb(55, 84, 138)',
		 'rgb(135, 246, 209)',
		 'rgb(232, 162, 209)',
		 'rgb(242, 223, 166)',
		 'rgb(255, 255, 0)',
		 'rgb(0, 0, 255)'
		 ],
	credits: {
	    enabled: false
	},
	legend: {
	    borderRadius: 0
	},
	plotOptions: {
	    column: {
		borderWidth: 0,
		groupPadding: 0.05,
		pointPadding: 0
	    },
	    pie: {
		borderWidth: 0,
		dataLabels: {
		    formatter: function() {
			return '<b>' + this.point.name + '</b>: ' + Highcharts.numberFormat(this.percentage, 1) + '%';
		    }
		}
	    },
	    series: {
		animation: false,
                pointWidth: 20,
		shadow: false
	    }
	},
	title: {
	    text: ''
	},
	yAxis: {
	    min: 0,
	    lineColor: "#000000",
	    lineWidth: 1,
	    gridLineColor: "#dcdbc6",
	    title: {
		style: {
		    "font-size": "13px"
		}
	    }
	}
    });
<?php
echo "
function runJasper(format) {
	if ('$repNum' == '505' && format == 'pdf')
		doWindow ('" . JASPER_RENDERER . "?report=$repNum&rtype=$rtype&lang=$lang&format=pdf&oLevel=$oLevel&gLevel=$gLevel')
	else {
		if (format == 'pdf') {
			document.forms[0].action = '" . JASPER_RENDERER . "?report=$repNum&lang=$lang&format=pdf&oLevel=$oLevel&gLevel=$gLevel' 
			document.forms[0].method = 'post'
		} else {

			document.forms[0].action = 'getTempFile.php?baseName=xlsOutput&extension=csv'
			document.forms[0].method = 'post'
		}
		document.forms[0].submit()
	}
}
function doWindow (url) {
	stuff = 'width=1024,height=800,toolbar=yes,location=yes,directories=no,scrollbars=yes,menubar=yes,resizable=yes'
	currWindow = window.open(url ,'RapportWindow', stuff)
	currWindow.focus()
}
</script>";
if ($gLevel > 1)
  echo "
<link rel=\"stylesheet\" type=\"text/css\" href=\"bootstrap.css?" . urlencode(APP_VERSION) . "\">
<link rel=\"stylesheet\" type=\"text/css\" href=\"reporting.css\">
<script type=\"text/javascript\" src=\"include/bootstrap.js\"></script>
<script type=\"text/javascript\" src=\"include/group-reporting-functions.js\"></script>
<script type=\"text/javascript\" src=\"include/jquery.datatables.js\"></script>
<script type=\"text/javascript\" src=\"include/ZeroClipboard.js\"></script>
<script type=\"text/javascript\" src=\"include/jquery.datatables.tabletools.js\"></script>";
echo "
</head>
<body onLoad=\"if (document.getElementById('repDesc')) document.getElementById('repDesc').readOnly = true;\">
<form name=\"reportForm\" action=\"getTempFile.php?baseName=xlsOutput&extension=csv\" method=\"get\">
 <input type=\"hidden\" name=\"rtype\" value=\"" . $rtype . "\">
 <input type=\"hidden\" name=\"report\" value=\"" . $repNum . "\">
 <input type=\"hidden\" name=\"lang\" value=\"" . $lang . "\">
 <input type=\"hidden\" name=\"site\" value=\"" . $site . "\">
 <input type=\"hidden\" name=\"pStatus\" value=\"" . $pStatus . "\">
 <input type=\"hidden\" name=\"tStatus\" value=\"" . $tStatus . "\">
 <input type=\"hidden\" name=\"gLevel\" value=\"" . $gLevel . "\">
 <input type=\"hidden\" name=\"oLevel\" value=\"" . $oLevel . "\">
 <input type=\"hidden\" name=\"start\" value=\"" . $start . "\">
 <input type=\"hidden\" name=\"end\" value=\"" . $end . "\">
 <input type=\"hidden\" name=\"pid\" value=\"" . $pid . "\">
 <input type=\"hidden\" name=\"ddValue\" value=\"" . $ddValue . "\">
 <input type=\"hidden\" name=\"tableName\" value=\"" . $tableName . "\">
 <input type=\"hidden\" name=\"user\" value=\"" . substr(getSessionUser(), 0, 3) . "\">
 <input type=\"hidden\" name=\"siteName\" value=\"" . $siteName . "\">
 <input type=\"hidden\" name=\"total\" value=\"".$GLOBALS['reportTotal'] . "\">
 <input type=\"hidden\" name=\"tType\" value=\"" . $tType . "\">
 <input type=\"hidden\" name=\"order\" value=\"" . $order . "\">
 <input type=\"hidden\" name=\"odir\" value=\"" . $odir . "\">
 <input type=\"hidden\" name=\"nForms\" value=\"" . $nForms . "\">
 <input type=\"hidden\" name=\"creator\" value=\"" . $creator . "\">

<div class=\"hide-this print-show\">
  <div style=\"float: right; margin-left: 20px\"><img src=\"images/isante_logo_bw_large.png\" width=\"108\" height=\"30\" /></div></div>

	<table class=\"header\">
		<tr>
		<td colspan=\"2\" class=\"m_header\">" . iconv("UTF-8", CHARSET, $title). "
		</td>
		</tr>
		<tr>
		   	<td>
		   		<input class=\"print-hide\" type=\"button\" name=\"ret1\" value=\"" . $repReturn[$lang] . "\" onclick=\"window.close()\" />
		   		<input class=\"print-hide\" type=\"button\" name=\"printButton\" value=\"" . $printLabel . "\" onclick=\"window.print()\" />";
		   		if ($rtype == "clinicalCare"||$rtype == "qualityCare"||$repNum == "505" || $repNum == "903")
                                        //echo "&nbsp;<input class=\"print-hide\" type=\"button\" name=\"genPDF\" value=\"PDF\" onclick=\"runJasper('pdf')\" />";
		   		if ($repNum != 205 && $repNum != 5000)
		   			echo "&nbsp;<input class=\"print-hide\" type=\"button\" name=\"genExcel\" value=\"Excel (CSV)\" onclick=\"runJasper('xls')\" />";
                                if ($repNum == 505)
                                  echo "&nbsp;<input class=\"print-hide\" type=\"button\" name=\"genXml\" value=\"XML\" onClick=\"doWindow('pepfarXml.php?site=$site&month=" . substr ($end, 5, 2) . "&year=" . substr ($end, 0, 2) . "')\" />";
		   	echo "
		   	</td>
		</tr>";
	if ($menuSelection != "dateNo" || $repNum >600 && $repNum < 610) {
		if (substr($start,0,3) == "dbo") {
			$startYY = substr($start,14,2);
			$startMM = substr($start,17,2);
			$endYY = substr($end,14,2);
			$endMM = substr($end,17,2);
		} else {
			$startYY = substr($start,2,2);
			$startMM = substr($start,5,2);
			$startDD = substr($start,8,2);
			$endYY = substr($end,2,2);
			$endMM = substr($end,5,2);
			$endDD = substr($end,8,2);
	    }
	    if ($repNum == 777 | $repNum == 778) {
		echo "
			<tr>
				<td>Date d'exécution:" . date("d-m-Y") . "</td>
			</tr>";		
	    } else {
			echo "
			<tr>
				<td>" . $startDateLabel[$lang] . " " . ($repNum == 540 && !empty ($startDD) ? "$startDD/" : "") . $startMM . "/" . $startYY . " " . ($repNum == 540 ? $dateFormatWithDay[$lang] : $dateFormat[$lang]) . "
				</td>
				<td>" . $endDateLabel[$lang] . " " . ($repNum == 540 && !empty ($endDD) ? "$endDD/" : "") . $endMM . "/" . $endYY . " " . ($repNum == 540 ? $dateFormatWithDay[$lang] : $dateFormat[$lang]) . "
				</td>
			</tr>";
		}
	}

	  // Print report description here if prim. care or ob/gyn report
	  if (($repNum >= 2000 && $repNum <= 3999) || $repNum == 311 || $repNum == 777 || $repNum == 778) {
	          echo "
		<tr>
			<th align=\"left\" colspan=\"2\">" . _("Description") . "</th>
		</tr>
		<tr>
			<td align=\"left\" colspan=\"2\"><textarea style=\"overflow: auto; font-family: Verdana, Arial, Helvetica, Geneva, sans-serif; color: #444; font-size: 11px; line-height: 1.5em;\" cols=\"90\" rows=\"9\" id=\"repDesc\">" . str_replace ("<BR/>", "\n", $repDesc) . "</textarea></td>
		</tr>
		<tr>
			<th align=\"left\" colspan=\"2\">" . _("Résultats") . "</th>
		</tr>
	          ";
      }

	  if (!($pStatus == 0 && $tStatus == 0 && $tType == 0 && $gLevel == 0 && $oLevel == 0)) { 
		// main flag block for patient status, treatment, tests
			echo "
			<tr>";
			if ($repNum != 777) 
				echo "<td valign=\"top\" colspan=\"5\">" . $kickLabel['patientStatus'][$lang][0] . ": ";
			else
				echo "<td valign=\"top\" colspan=\"5\">Statut ARV: ";					
			$pArray = getPatientStatusArray ($pStatus);
			$j = 0;
			if (array_sum($pArray) > 0) {
				for ($i = 0; $i < 5; $i++) {
					if ($pArray[$i] == 1) {
						$curVal = $kickLabel['patientStatus'][$lang][$i+1];
						if ($j == 0) echo $curVal;
						else echo ", " . $curVal;
						$j++;
					}
				}
			} else
				echo "-";
			echo "
			</td>
		</tr>
		<tr>";

		if ($repNum == 777) {
			echo "
			<tr>
				<td valign=\"top\" colspan=\"5\">Status Risque : ";
				$tArray = getPatientStatusArray ($tStatus);
				$j = 0;
				if (array_sum($tArray) > 0) {
					for ($i = 0; $i < 5; $i++) {
						if ($tArray[$i] == 1) {
						$curVal = $kickLabel['riskStatus'][$lang][$i+1];
							if ($j == 0) echo $curVal;
							else echo ", " . $curVal;
							$j++;
						}
					}
				} else
					echo "-";
				echo "
				</td>
			</tr>
			<tr>";		
	   } else {
			if ($tStatus == 0) $curVal = "-";				
			else $curVal = substr($kickLabel['treatmentStatus'][$lang][$tStatus],0,strpos($kickLabel['treatmentStatus'][$lang][$tStatus],"<span")-1);
			echo "
			<td valign=\"top\">" . $kickLabel['treatmentStatus'][$lang][0] . ": " . $curVal . "
			</td>";
			if ($tType == 0) $curVal = "-";
			else $curVal = $kickLabel['testType'][$lang][$tType];
			echo "
			<td valign=\"top\">" . $kickLabel['testType'][$lang][0] . ": " . $curVal . "
			</td>
		</tr>";
		$curVal = $kickLabel['groupLevel'][$lang][$gLevel];
		echo "
		<tr>
			<td>" . $kickLabel['groupLevel'][$lang][0] . ": " . $curVal . "
			</td>";
				if ($oLevel == 0) $curVal = "-";
				else $curVal = $kickLabel['otherLevel'][$lang][$oLevel];
				echo "
			<td>" . $kickLabel['otherLevel'][$lang][0] . ": " . $curVal . "
			</td>
		</tr>";
	  }
	}
	echo "
	</table>";
	// display a pie or chart here unless $gLevel = 1 and $oLevel = 1
	if ($oLevel > 1 || $gLevel > 1 || ($repNum > "5029" && $repNum < "5047")) {
	  if (DEBUG_FLAG) print "<br>query for chart: " . $chartQry . "<br>";

	  //clean up old chart files if they still exist
	  foreach (array('piechart', 'bargraph') as $oldChartBaseName) {
	    if (file_exists(getTempFileName($oldChartBaseName, 'png'))) {
	      unlink(getTempFileName($oldChartBaseName, 'png'));
	    }
	  }
	  
	  if ($gLevel == 1) {
	    $percentArray2 = drawPieChart($chartQry);
	  } else {
	    $percentArray2 = drawBarChart($chartQry, $gLevel, $oLevel, $rtype, $repNum, $ddValue);
	  }
	  
	  // only do a pie or bar chart if there are rows retrieved
	  if (count($percentArray2) > 0) {
            /* disabling redundant legend - JS 12/14/2012
	    // only display the legend when there are less than 10 items in it
	    if (count($percentArray2) < 10) {
	      ?>
<table border="0">
  <tr>
    <td><div id=reportGraph></div></td>
    <td>
      <table>
	<tr>
	  <td class="legend_display"><b><?= $kickLabel['groupLevel'][$lang][$gLevel] ?></b></td>
	  <td class="legend_display"><b><?= $patientCount[$lang] ?></b></td>
	</tr>
	      <?php
	      $percentKey2 = array_keys($percentArray2);
	      for ($k = 0; $k < count($percentArray2); $k++) {
		echo "
<tr><td class=\"legend_display\">" . $percentKey2[$k] . "</td><td class=\"num_display\">" . $percentArray2[$percentKey2[$k]] . "</td></tr>";
	      }
	      ?>
      </table>
    </td>
  </tr>
</table>
	      <?php
	    } else {
            */
	      echo '<div id=reportGraph></div>';
/*	    } */
	  } else {
	    ?>
<script type="text/javascript">
  document.forms[0].genPDF.disabled=true;
  document.forms[0].genExcel.disabled=true;
</script>
	    <?php
	  }
	}

	// get the exact total number which filters the items with empty keys
	if ($gLevel == 1) {
	  	  $total4Patients = 0;
                  if (!empty ($percentArray2)) {
		    foreach ($percentArray2 as $key=>$value) {
		  	$total4Patients += $value;
		    }
                  }
		  echo "<script language=\"javascript\" type=\"text/javascript\">document.forms[0].total.value=".$total4Patients . "</script>";
  	}
	
	if ($repNum == 777) {
		$y = array(6,8,9);
		$x = getPatientStatusArray ($r34pStatus);
		print_r($y);
		echo $r34pStatus;
		print_r($x);
		$j = 0;
		if (array_sum($x) > 0) {
			$j = 0;
			for ($i = 0; $i < 3; $i++) {
				if ($x[$i] == 1) {
					if ($j == 0) {
						$ps = $y[$i];
						$j++;
					}
					else $ps .= ',' . $y[$i];
				}
			}
		}
		$y = array(500,400,300,200,100);
		$x = getPatientStatusArray ($r34tStatus);
		if (array_sum($x) > 0) {
			$j = 0;
			for ($i = 0; $i < 5; $i++) {
				if ($x[$i] == 1) {
					if ($j == 0) {
						$ts = $y[$i];
						$j++;
					}
					else $ts .= ',' . $y[$i];
				}
			}
		}
		$qry .= " and p.patientStatus in (" . $ps . ")";
		$qry .= " and r.riskLevel in (" . $ts . ")";
		$qry .= " group by 4 having MAX(lw.dispDate) > DATE_ADD(now(),interval -180 day) order by 1,2";
	}

	if (DEBUG_FLAG) print "<br>query for table: " . $qry . "<br>";
	recordEvent('report', array(
				    'query' => $qry, 
				    'rtype' => $rtype, 
				    'reportNumber' => $repNum, 
				    'lang' => $lang, 
				    'pStatus' => $pStatus, 
				    'tStatus' => $tStatus, 
				    'tType' => $tType, 
				    'gLevel' => $gLevel,
				    'oLevel' => $oLevel, 
				    'startDate' => $start, 
				    'endDate' => $end, 
				    'pid' => $pid, 
				    'ddValue' => $ddValue, 
				    'nForms' => $nForms, 
				    'creator' => $creator
				    ));

	generateQueryResult($qry, $rtype, $repNum, $lang, $site, $pStatus, $tStatus,
			    $tType, $gLevel, $oLevel, $start, $end, $pid, $ddValue,
			    $nForms, $creator, $den, $tblNames);

	/*
  if ($repNum != 205 && $repNum != 5000) {
	writeOutput($qry, $rtype, $repNum, $lang, $site, $pStatus, $tStatus, $tType, $gLevel, $oLevel, $start, $end, $pid, $ddValue);
  }*/

  echo "<br>
		<input class=\"print-hide\" type=\"button\" name=\"ret2\" value=\"" . $repReturn[$lang] . "\" onclick=\"window.close()\" />";


function drawPieChart($qry) {
  $processed = array();
  $data = array();
  $result = dbQuery($qry);
  while ($row = psRowFetch($result)) {
    if (!is_null($row[0])) {
      if (is_numeric($row[1])) {
	$row[1] = $row[1] + 0; //force numbers to a numeric type
      }
      $data[] = array($row[0], $row[1]);
      $processed[$row[0]] = $row[1];
    }
  }

  ?>
<script type="text/javascript">
$(document).ready(function() {
	new Highcharts.Chart({
		chart: {
		    renderTo: 'reportGraph',
		    type: 'pie',
		    width: 550,
		    height: 350,
		    spacingTop: 5,
		    spacingRight: 5,
		    spacingBottom: 5,
		    spacingLeft: 5
		},
		legend: {
		    enabled: <?= count($data) > 1 ? 'true' : 'false' ?>
		},
		tooltip: {
		    formatter: function () {
			return '<b>' + this.point.name + '</b>: ' + this.y + ', ' + Highcharts.numberFormat(this.percentage, 1) + '%';
		    }
		},
		series: [{
		    data: <?= json_encode($data) ?>
		}]
	    });
    });
</script>
  <?php
  return ($processed);
}

function drawBarChart($qry, $gLevel, $oLevel, $rtype, $repNum, $ddValue) {
  $processed = array();
  $data = array();

  $result = dbQuery ($qry);
  while ($row = psRowFetch($result)) {
    if (! (is_null($row[0]) || is_null($row[1]))) {
      if ($repNum > 5029 && $repNum < 5047) {
	if ($ddValue == 'All') {
	  $data[] = array($row[0], $row[4], $row[1]);
	  $processed[$row[0] . '-'] = $row[4];
	} else {
	  $data[] = array($row[0], $row[3], '');
	  $processed[$row[0]] = $row[3];
	}
      } else {
	if ($oLevel == 1 && ($rtype == 'clinicalCare' || $rtype == 'qualityCare')) {
	  $data[] = array($row[0], $row[1], '');
	  $processed[$row[0]] = $row[1];
	}
	if ($oLevel > 1  && ($rtype == 'clinicalCare' || $rtype == 'qualityCare')) {
	  $data[] = array($row[0], $row[2], $row[1]);
	  $processed[$row[0] . '-' . $row[1]] = $row[2];
	}
	if ($rtype == 'aggregatePop') {
	  $data[] = array($row[1], $row[2], $row[0]);
	  $processed[$row[1] . '-' . $row[0]] = $row[2];
	}
      }
    }
  }

  $categories = array();
  $nextCategory = 0;
  foreach ($data as $point) {
    if (!array_key_exists($point[0], $categories)) {
      $categories[$point[0]] = $nextCategory;
      $nextCategory = $nextCategory + 1;
    }
  }

  $series = array();
  foreach ($data as $point) {
    if (!array_key_exists($point[2], $series)) {
      $series[$point[2]] = array();
      $series[$point[2]]['name'] = $point[2];
      $series[$point[2]]['data'] = array();
      
    }
    if (is_numeric($point[1])) {
      $point[1] = $point[1] + 0; //force all numeric values to have a numeric type
    }
    $series[$point[2]]['data'][] = array('x' => $categories[$point[0]], 'y' => $point[1]);
  }
  ksort($series);

  if ($repNum > 5029 && $repNum < 5047) {
    $yTitle = _('Pour cent');
  } else {
    $yTitle = _('Compte');
  }

  # Adjust graph dimensions based on number of data points in series
  $graphHeight = 600;
  $minWidth = 400;
  $minSpacingRight = 0;
  $graphWidth = $minWidth + (floor (100 / $gLevel) * count ($data));
  $graphSpacingRight = $minSpacingRight + (floor (10 / $gLevel) * count ($data));

  ?>
<script type="text/javascript">
$(document).ready(function() {
	new Highcharts.Chart({
		chart: {
		    renderTo: 'reportGraph',
		    type: 'column',
		    width: <?= $graphWidth ?>,
		    height: <?= $graphHeight ?>,
		    spacingLeft: 4,
                    spacingRight: <?= $graphSpacingRight ?>
		},
		xAxis: {
		    lineColor: "#000000",
		    categories: <?= json_encode(array_flip($categories)) ?>,
                    labels: {
                      align: 'left',
                      rotation: 45,
                      overflow: 'justify'
                    }
		},
		yAxis: {
		    title: {
			text: '<?= $yTitle ?>'
		    }
		},
		legend: {
		    enabled: <?= count($series) > 1 ? 'true' : 'false' ?>
		},
		series: <?= json_encode(array_values($series)) ?>
	    });
    });
</script>
  <?php
  return ($processed);
}

?>
 </form>
<?
if (DEBUG_FLAG) print "The report took " . (time() - $rptStart) . " seconds to run.";
?>
 </body>
</html>
