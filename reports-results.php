<?php
require_once 'backendAddon.php';
require_once 'labels/report.php';

$reportType = $_POST['reportType'];
$lang = $_POST['lang'];
$timePeriod = $_POST['time'];
$timeBack = $_POST['timeBack'];
$orgUnit = $_POST['display'];
$indicatorType = $_POST['indicatorType'];
$limitIndicators = "";
$limitIndicatorsDisplay = $reportFilteringLabels[$lang][50]." ";
// limitIndicators currently for TB and malaria only
if ($indicatorType != "" && ($reportType == 'tb' || $reportType == 'malaria' || $reportType == 'dataquality'|| $reportType == 'mer')) {
  $limitIndicators = "AND l.subGroup$lang = '$indicatorType'";
  $limitIndicatorsDisplay = $indicatorType." ";
}

/*** Variables used for reporting ***/
// Set number of columns of data to be displayed. Set to 6 currently
$reportByTimeCount = 6;
$reportPeriod = ($reportByTimeCount * $timeBack) - 1;
$reportPeriodWeek = ($reportByTimeCount * $timeBack);
// Find most recent months from current date
$monthToUse = date("m", strtotime("-$reportPeriod month"));
$yearToUse = date("Y", strtotime("-$reportPeriod month"));
// For year query
$yearQueryToUse = date("Y", strtotime("-$reportPeriod year"));
// For week, need to handle differently b/c PHP and mySQL have problems together
// Need to change slightly what weeks get displayed when query could potentially
// include "week 53". Change by one to make sure no weeks get skipped.
// FIXME: This may need to be iterated for each year that includes a week 53
// and in general this seems like a hack.
$weekYearToUse = date("Y", strtotime("-$reportPeriodWeek week"));
$weekToUse = date("W", strtotime("-$reportPeriodWeek week"));
if ($weekToUse > 47 || $weekYearToUse < 2013 ) {
  $reportPeriodWeek = $reportPeriodWeek - 1;
  $weekYearToUse = date("Y", strtotime("-$reportPeriodWeek  week"));
  $weekToUse = date("W", strtotime("-$reportPeriodWeek  week"));
}

if ($orgUnit == 'Network') {
  $orgUnitDisplay = strtolower($kickLabel['groupLevel'][$lang][5]);
} elseif ($orgUnit == 'Department') {
  $orgUnitDisplay = strtolower($kickLabel['groupLevel'][$lang][4]);
} elseif ($orgUnit == 'Commune') {
  $orgUnitDisplay = strtolower($kickLabel['groupLevel'][$lang][3]);
} elseif ($orgUnit == 'SiteCode') {
  $orgUnitDisplay = strtolower($kickLabel['groupLevel'][$lang][2]);
}
//$reportTitleShow = $reportFilteringLabels[$lang][11] .", " . $reportFilteringLabels[$lang][13] . $orgUnitDisplay . $reportFilteringLabels[$lang][17];
$reportTitleShow = $reportFilteringLabels[$lang][13];

/*** Functions used in reporting ***/
// Converts decimal to percentage.
function makePercent($num, $denom) {
  $getP = ($num / $denom) * 100;
  $val = number_format($getP,1,'.','') . '%';
  return $val;
}

// Find beginng date for week slices (need to query database b/c default php
// functions don't match the way mysql handles weeks).
function findWeekRange($weekBack, &$startWeekDate){
  $weekCalc = "SELECT STR_TO_DATE('".$weekBack." Sunday', '%X%V %W') AS weekStart";
  $fetchWeekRange = databaseSelect()->query($weekCalc)->fetchAll(PDO::FETCH_ASSOC);
  $startWeekDate = $fetchWeekRange[0]['weekStart'];
  return $startWeekDate;
}
findWeekRange($weekYearToUse.$weekToUse,$startWeekDate);

// Check year var (used to prevent the "Past results" from going back past 2004
$yearsBackLimit = false;
/*** Queries used in reporting ***/
// Build pivot for view to be used in query
for ($k = 0; $k < $reportByTimeCount; $k++) {
  if ($timePeriod == 'week') { // Use weeks view
    $timePeriodDisplay = strtolower($reportFilteringLabels[$lang][2]);
    $startWeek = date('j/n/y', strtotime($startWeekDate . ' +'.$k.' weeks'));
    $weekTitleDisplay = $reportFilteringLabels[$lang][20].$reportFilteringLabels[$lang][49].' '.$startWeek;
    if (($weekToUse + $k) <=53) {
      $periodsInQuery .= ' SUM(CASE WHEN period = '.($weekToUse + $k).' and year = '.$weekYearToUse.' THEN value ELSE 0 END) AS val'.$k.',';
      $periodsInQuery .= ' SUM(CASE WHEN period = '.($weekToUse + $k).' and year = '.$weekYearToUse.' THEN denominator ELSE 0 END) AS val'.$k.'d,';
      $periodsInQuery .= ' SUM(CASE WHEN period = '.($weekToUse + $k).' AND s.gender = 1 and year = '.$weekYearToUse.' THEN value ELSE 0 END) AS val'.$k.'f,';
      $periodsInQuery .= ' SUM(CASE WHEN period = '.($weekToUse + $k).' AND s.gender = 1 and year = '.$weekYearToUse.' THEN denominator ELSE 0 END) AS val'.$k.'df,';
      $periodsInQuery .= ' SUM(CASE WHEN period = '.($weekToUse + $k).' AND s.gender = 2 and year = '.$weekYearToUse.' THEN value ELSE 0 END) AS val'.$k.'m,';
      $periodsInQuery .= ' SUM(CASE WHEN period = '.($weekToUse + $k).' AND s.gender = 2 and year = '.$weekYearToUse.' THEN denominator ELSE 0 END) AS val'.$k.'dm,';
      $tableHeaderVals .= '<th colspan="3" class="result-header header-small" data-box="'.$k.'" period="'.($weekToUse + $k).'" year="'.$weekYearToUse.'" title="'.$weekTitleDisplay.'">'.$weekTitleDisplay.'</th>';
      if ($weekYearToUse < 2004) $yearsBackLimit = true;
    } else {
      $periodsInQuery .= ' SUM(CASE WHEN period = '.($weekToUse + $k - 53).' and year = '.($weekYearToUse+1).' THEN value ELSE 0 END) AS val'.$k.',';
      $periodsInQuery .= ' SUM(CASE WHEN period = '.($weekToUse + $k - 53).' and year = '.($weekYearToUse+1).' THEN denominator ELSE 0 END) AS val'.$k.'d,';
      $periodsInQuery .= ' SUM(CASE WHEN period = '.($weekToUse + $k - 53).' AND s.gender = 1 and year = '.($weekYearToUse+1).' THEN value ELSE 0 END) AS val'.$k.'f,';
      $periodsInQuery .= ' SUM(CASE WHEN period = '.($weekToUse + $k - 53).' AND s.gender = 1 and year = '.($weekYearToUse+1).' THEN denominator ELSE 0 END) AS val'.$k.'df,';
      $periodsInQuery .= ' SUM(CASE WHEN period = '.($weekToUse + $k - 53).' AND s.gender = 2 and year = '.($weekYearToUse+1).' THEN value ELSE 0 END) AS val'.$k.'m,';
      $periodsInQuery .= ' SUM(CASE WHEN period = '.($weekToUse + $k - 53).' AND s.gender = 2 and year = '.($weekYearToUse+1).' THEN denominator ELSE 0 END) AS val'.$k.'dm,';      
      $tableHeaderVals .= '<th colspan="3" class="result-header header-small" data-box="'.$k.'" period="'.($weekToUse + $k - 53).'" year="'.($weekYearToUse+1).'" title="'.$weekTitleDisplay.'">'.$weekTitleDisplay.'</th>';
      if (($weekYearToUse+1) < 2004) $yearsBackLimit = true;
    }
  } elseif ($timePeriod == 'month') { // Use month view
    $timePeriodDisplay = strtolower($reportFilteringLabels[$lang][3]);
    if (($monthToUse + $k) <=12) {
      $periodsInQuery .= ' SUM(CASE WHEN period = '.($monthToUse + $k).' and year = '.$yearToUse.' THEN value ELSE 0 END) AS val'.$k.',';
      $periodsInQuery .= ' SUM(CASE WHEN period = '.($monthToUse + $k).' and year = '.$yearToUse.' THEN denominator ELSE 0 END) AS val'.$k.'d,';
      $periodsInQuery .= ' SUM(CASE WHEN period = '.($monthToUse + $k).' AND s.gender = 1 and year = '.$yearToUse.' THEN value ELSE 0 END) AS val'.$k.'f,';
      $periodsInQuery .= ' SUM(CASE WHEN period = '.($monthToUse + $k).' AND s.gender = 1 and year = '.$yearToUse.' THEN denominator ELSE 0 END) AS val'.$k.'df,';
      $periodsInQuery .= ' SUM(CASE WHEN period = '.($monthToUse + $k).' AND s.gender = 2 and year = '.$yearToUse.' THEN value ELSE 0 END) AS val'.$k.'m,';
      $periodsInQuery .= ' SUM(CASE WHEN period = '.($monthToUse + $k).' AND s.gender = 2 and year = '.$yearToUse.' THEN denominator ELSE 0 END) AS val'.$k.'dm,';
      $tableHeaderVals .= '<th colspan="3" class="result-header" data-box="'.$k.'" period="'.($monthToUse + $k).'" year="'.$yearToUse.'" title="'.($monthToUse + $k).'-'.$yearToUse.'">'.($monthToUse + $k).'/'.$yearToUse.'</th>';
      if ($yearToUse < 2004) $yearsBackLimit = true;
    } else {
      $periodsInQuery .= ' SUM(CASE WHEN period = '.($monthToUse + $k - 12).' and year = '.($yearToUse+1).' THEN value ELSE 0 END) AS val'.$k.',';
      $periodsInQuery .= ' SUM(CASE WHEN period = '.($monthToUse + $k - 12).' and year = '.($yearToUse+1).' THEN denominator ELSE 0 END) AS val'.$k.'d,';
      $periodsInQuery .= ' SUM(CASE WHEN period = '.($monthToUse + $k - 12).' AND s.gender = 1 and year = '.($yearToUse+1).' THEN value ELSE 0 END) AS val'.$k.'f,';
      $periodsInQuery .= ' SUM(CASE WHEN period = '.($monthToUse + $k - 12).' AND s.gender = 1 and year = '.($yearToUse+1).' THEN denominator ELSE 0 END) AS val'.$k.'df,';
      $periodsInQuery .= ' SUM(CASE WHEN period = '.($monthToUse + $k - 12).' AND s.gender = 2 and year = '.($yearToUse+1).' THEN value ELSE 0 END) AS val'.$k.'m,';
      $periodsInQuery .= ' SUM(CASE WHEN period = '.($monthToUse + $k - 12).' AND s.gender = 2 and year = '.($yearToUse+1).' THEN denominator ELSE 0 END) AS val'.$k.'dm,';
      $tableHeaderVals .= '<th colspan="3" class="result-header" data-box="'.$k.'" period="'.($monthToUse + $k - 12).'" year="'.($yearToUse+1).'" title="'.($monthToUse + $k - 12).'-'.($yearToUse+1).'">'.($monthToUse + $k - 12).'/'.($yearToUse+1).'</th>';
      if (($yearToUse+1) < 2004) $yearsBackLimit = true;
    }
  } else { // Else use year view (default)
    $timePeriodDisplay = strtolower($reportFilteringLabels[$lang][4]);
    // Sum values of M and F
    $periodsInQuery .= ' SUM(CASE WHEN year = '.($yearQueryToUse +$k).' THEN value ELSE 0 END) AS val'.$k.',';
    $periodsInQuery .= ' SUM(CASE WHEN year = '.($yearQueryToUse +$k).' THEN denominator ELSE 0 END) AS val'.$k.'d,';
    $periodsInQuery .= ' SUM(CASE WHEN year = '.($yearQueryToUse +$k).' AND s.gender = 1 THEN value ELSE 0 END) AS val'.$k.'f,';
    $periodsInQuery .= ' SUM(CASE WHEN year = '.($yearQueryToUse +$k).' AND s.gender = 1 THEN denominator ELSE 0 END) AS val'.$k.'df,';
    $periodsInQuery .= ' SUM(CASE WHEN year = '.($yearQueryToUse +$k).' AND s.gender = 2 THEN value ELSE 0 END) AS val'.$k.'m,';
    $periodsInQuery .= ' SUM(CASE WHEN year = '.($yearQueryToUse +$k).' AND s.gender = 2 THEN denominator ELSE 0 END) AS val'.$k.'dm,';
    $tableHeaderVals .= '<th colspan="3" class="result-header" data-box="'.$k.'" period="'.($yearQueryToUse + $k).'" year="'.($yearQueryToUse + $k).'" title="'.($yearQueryToUse + $k).'">'.($yearQueryToUse + $k).'</th>';
    if (($yearQueryToUse + $k) < 2004) $yearsBackLimit = true;
  }
}
$periodsInQuery = substr($periodsInQuery, 0, -1); // Remove trailing comma

$findDenom = "";
if ($reportType == 'tb' || $reportType == 'nutrition'|| $reportType == 'mer' || $reportType == 'malaria' || $reportType == 'hivstatus' || $reportType == 'dataquality' || $reportType == 'obgyn') {
  $findDenom = "l.indicatorDenominator, ";
}
// The main query - uses left join to show all potential indicators
$sqlByTime = "select l.indicator, l.indicatorType, $findDenom name$lang, definition$lang,  
  $periodsInQuery
from dw_".$reportType."ReportLookup l LEFT JOIN dw_" . $reportType . "_slices s ON org_unit = '$orgUnit' and time_period = '$timePeriod' and s.indicator = l.indicator WHERE l.indicator > 0 ".$limitIndicators."GROUP BY l.indicator";
$resultByTime = databaseSelect()->query($sqlByTime)->fetchAll(PDO::FETCH_ASSOC);

// The subrow (aka detail) query
if ( $orgUnit != 'Haiti') {
  if ($orgUnit == 'SiteCode') {
   // Subrow query for clinics
    $sqlByTimeSubrow = "select s.indicator, c.clinic, c.siteCode, l.indicatorType, $findDenom name$lang, $periodsInQuery from dw_" . $reportType . "_slices s, dw_" . $reportType . "ReportLookup l, clinicLookup c where org_unit = '$orgUnit' and time_period = '$timePeriod' and s.indicator = l.indicator and c.siteCode = s.org_value and s.indicator > 0 GROUP BY c.clinic, s.indicator";
  } else {
    // Subrow query for network, department, commune
    $sqlByTimeSubrow = "select s.indicator, org_value, l.indicatorType, $findDenom name$lang, $periodsInQuery from dw_" . $reportType . "_slices s, dw_" . $reportType . "ReportLookup l where org_unit = '$orgUnit' and time_period = '$timePeriod' and s.indicator = l.indicator and s.indicator > 0 GROUP BY s.org_value, s.indicator"; 
  }
  $resultByTimeSubrow = databaseSelect()->query($sqlByTimeSubrow)->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="row-fluid">
  <div class="span12">
    <div class="pull-right print-hide">
      <div class="btn-group">
        <button class="btn btn-mini" name="printButton" id="btnPrint"><i class="icon-print"></i> <?php echo _('en:Print'); ?></button><a class="btn btn-mini csv-list" rel="popover"><i class="icon-share-alt"></i> Excel</a>
      </div>
      <div class="btn-group">
        <?php
        // If we've hit our limit of going back in time (currently set to 2004)
        // then we disable the previous button
        $disabledBtn = ($yearsBackLimit == true) ? "disabled" : "";
        ?>
        <button style="margin-left: 12px" id="goBack" class="btn btn-mini <?= $disabledBtn ?>" <?= $disabledBtn ?> name="<?php echo $timeBack + 1 ?>"><i class="icon-chevron-left"></i> <?php echo $reportFilteringLabels[$lang][5]?></button><button id="goForward" class="btn btn-mini disabled" disabled="disabled" name="<?php echo $timeBack - 1 ?>"><?php echo $reportFilteringLabels[$lang][6]?> <i class="icon-chevron-right"></i></button>
      </div>
    </div>
    <div class="filter-result"><?php
    echo $reportFilteringLabels[$lang][7] . ": ";
    if ($reportType == 'tb' || $reportType == 'malaria' || $reportType == 'dataquality'|| $reportType == 'mer') {
      echo $limitIndicatorsDisplay;
    }
    echo $reportTitleShow . " ";
    echo $timePeriodDisplay . ", ";
    echo $reportFilteringLabels[$lang][14] . " ";
    ?>
    <span id="reportTitleTimeStart"></span>
    <?php echo $reportFilteringLabels[$lang][15] ?>
    <span id="reportTitleTimeEnd"></span>.
    <?php
    if ($orgUnit != 'Haiti') {
      echo " " . $reportFilteringLabels[$lang][8] . " ";
      echo $reportFilteringLabels[$lang][13] . " " . $orgUnitDisplay . ".";
    } ?>
    </div>
  </div>
</div>

<div id="exportContainer">
<table id="datatable" class="table table-bordered table-hover table-condensed report-table" time="<?php echo $timePeriod; ?>" data-display="<?php echo $orgUnit; ?>" data-lang="<?php echo $lang; ?>">
  <thead>
    <tr>
      <th colspan="2" class="indicator-name"><?= $reportFilteringLabels[$lang][0]?></th>
      <?= $tableHeaderVals ?>
    </tr> 
  </thead> 
  <tbody>
  <?php
  $bigCSV = '';
  for ($i = 0; $i < count($resultByTime); $i++) {
    // Row begins and indicator ID cell
    echo '<tr data-indicator="'.$resultByTime[$i]['indicator'].'" data-indicator-d="'.$resultByTime[$i]['indicatorDenominator'].'" name="'.$resultByTime[$i]['name'.$lang].'" class="report-mainrow">';
    // Indicator name cell
    echo '<td class="report-row-info" colspan="2"><div class="pull-right">';
    echo '<a href="#" rel="popover" class="launch-definition" data-content="'.$resultByTime[$i]['definition'.$lang].'"><i class="icon-question-sign report-icon"/></i></a>';
    echo '<a href="#" class="chart-launch"><i></i></a>';
    echo '</div><div class=""><span class="report-row-title">'.$resultByTime[$i]['indicator'].' : '.$resultByTime[$i]['name'.$lang].'</td>';
    // All values
    for ($k = 0; $k < $reportByTimeCount; $k++) {
      
      $cellVal = 'val' . $k;
      $cellVal2 = 'dateS' . $k;
      // Declaring the variables for data
      $dataPercent = $dataPercentF = $dataPercentM = $dataCount = $dataCountD = $dataCountF = $dataCountFD = $dataCountM = $dataCountMD = "";   
      $sumNum = $resultByTime[$i][$cellVal];
      $sumTest = $resultByTime[$i][$cellVal2];
      $sumTest2 = $resultByTime[$i][$cellVal2];
      // Change value to percentages for percent-based indicators
      if ($resultByTime[$i]['indicatorType'] == '1') {
        $sumDenom = $resultByTime[$i][$cellVal . 'd'];
        if ($sumDenom != '0') {
          $dataPercent = makePercent($sumNum, $sumDenom);
          if ($resultByTime[$i][$cellVal . 'df'] != '0') {
            $dataPercentF = makePercent($resultByTime[$i][$cellVal . 'f'], $resultByTime[$i][$cellVal . 'df']);
          }
          if ($resultByTime[$i][$cellVal . 'dm'] != '0') {
            $dataPercentM = makePercent($resultByTime[$i][$cellVal . 'm'], $resultByTime[$i][$cellVal . 'dm']);
          }
        }
        $dataCount = str_replace(".0", "", $sumNum);
        $dataCountD = str_replace(".0", "", $sumDenom);
        $dataCountF = str_replace(".0", "", $resultByTime[$i][$cellVal . 'f']);
        $dataCountFD = str_replace(".0", "", $resultByTime[$i][$cellVal . 'df']);
        $dataCountM = str_replace(".0", "", $resultByTime[$i][$cellVal . 'm']);
        $dataCountMD = str_replace(".0", "", $resultByTime[$i][$cellVal . 'dm']);
        $dataCountDisplay = $dataCount."/".$dataCountD;
      } else {
        $dataCount = $dataCountDisplay = $sumNum;
        $dataCountF = $resultByTime[$i][$cellVal . 'f'];
        $dataCountM = $resultByTime[$i][$cellVal . 'm'];
      }
      
      echo '<td class="skip-export">';
      // If there is one or more patients in this indicator
      if ($resultByTime[$i][$cellVal] > 0) {
        // Experiment - replace two links with one popover chooser
        echo '<i rel="popover" class="icon-list report-icon launch-list" data-box="'.$k.'" data-percent="'.$dataPercent.'" data-percent-f="'.$dataPercentF.'" data-percent-m="'.$dataPercentM.'" data-count="'.$dataCount.'" data-count-d="'.$dataCountD.'" data-count-f="'.$dataCountF.'" data-count-fd="'.$dataCountFD.'" data-count-m="'.$dataCountM.'" data-count-md="'.$dataCountMD.'"></i>';
      }
      echo "</td>";
      if ($dataPercent == "") {
        echo "<td class='cell-no-bl'>";
        echo "<span class='hide'>0%</span>";
        echo "</td><td class='cell-no-bl cell-ratio'>";
        echo "<span class='data-graph'>".$dataCountDisplay."</span>";
        echo "</td>";
      } else {
        echo "<td class='cell-no-bl'>";
        echo "<span class='data-graph'>".$dataPercent."</span>";
        echo "</td><td class='cell-no-bl cell-ratio'>";
        echo "<span>".$dataCountDisplay."</span>";
        echo "</td>";
      }
    }
    echo "</tr>";
    if ( $orgUnit != 'Haiti') {
      // Start subrows
      // FIXME - This looks through all subrows to find matching indicator
      // Would be nice to set indicators first so it doesn't have to look
      // repeatedly.
      foreach ($resultByTimeSubrow as $subRow) {
        if ($subRow['indicator'] ==  $resultByTime[$i]['indicator']) {
          echo "<tr data-indicator='".$subRow['indicator']."' data-indicator-d='".$subRow['indicatorDenominator']."' name='";
          if ($orgUnit == 'SiteCode') {
            echo $subRow['clinic'];
            echo "' sitecode='";
            echo $subRow['siteCode'];
          } else {
            echo $subRow['org_value'];
          }
          echo "' class='report-subrow'>";
          // Indicator name cell
          echo "<td class='report-row-info'><div class='pull-right'><a href='#' class='chart-launch'><i></i></a></div><div><span class='report-row-title'>";
          if ($orgUnit == 'SiteCode') {
            echo $subRow['clinic']; 
          } else {
            echo $subRow['org_value'];
          }
          echo "</td>";
          // All values
          for ($k = 0; $k < $reportByTimeCount; $k++) {
            $cellVal = 'val' . $k;
            $dataPercent = $dataPercentF = $dataPercentM = $dataCount = $dataCountD = $dataCountF = $dataCountFD = $dataCountM = $dataCountMD = "";
            $sumSubNum = $subRow[$cellVal];
            // Change value to percentages for percent-based indicators
            if ($resultByTime[$i]['indicatorType'] == '1') {
              $sumSubDenom = $subRow[$cellVal.'d'];
              if ($sumSubDenom != '0') {
                $dataPercent = makePercent($sumSubNum, $sumSubDenom);
                if ($subRow[$cellVal . 'df'] != '0') {
                  $dataPercentF = makePercent($subRow[$cellVal . 'f'], $subRow[$cellVal . 'df']);
                }
                if ($subRow[$cellVal . 'dm'] != '0') {
                  $dataPercentM = makePercent($subRow[$cellVal . 'm'], $subRow[$cellVal . 'dm']);
                }
              }
              $dataCount = str_replace(".0", "", $sumSubNum);
              $dataCountD = str_replace(".0", "", $sumSubDenom);
              $dataCountF = str_replace(".0", "", $subRow[$cellVal . 'f']);
              $dataCountFD = str_replace(".0", "", $subRow[$cellVal . 'df']);
              $dataCountM = str_replace(".0", "", $subRow[$cellVal . 'm']);
              $dataCountMD = str_replace(".0", "", $subRow[$cellVal . 'dm']);
              $dataCountDisplay = $dataCount."/".$dataCountD;
            } else {
              $dataCount = $dataCountDisplay = $sumSubNum;
              $dataCountF = $subRow[$cellVal . 'f'];
              $dataCountM = $subRow[$cellVal . 'm'];
            }
            echo '<td class="skip-export">';
            if ($subRow[$cellVal] > 0) {
              echo '<i rel="popover" class="icon-list report-icon launch-list subrow-list" data-box="'.$k.'" data-percent="'.$dataPercent.'" data-percent-f="'.$dataPercentF.'" data-percent-m="'.$dataPercentM.'" data-count="'.$dataCount.'" data-count-d="'.$dataCountD.'" data-count-f="'.$dataCountF.'" data-count-fd="'.$dataCountFD.'" data-count-m="'.$dataCountM.'" data-count-md="'.$dataCountMD.'"></i>';
            }
            echo "</td><td class='cell-no-bl'>";
            if ($dataPercent == "") {
              echo "<span class='hide'>0%</span>";
              echo "</td><td class='cell-no-bl cell-ratio'>";
              echo "<span class='data-graph'>".$dataCountDisplay."</span>";
            } else {
              echo "<span class='data-graph'>".$dataPercent."</span>";
              echo "</td><td class='cell-no-bl cell-ratio'>";
              echo "<span>".$dataCountDisplay."</span>";
            }
            echo "</td>";
          }
          echo "</tr>"; 
        }           
      }
    }
  }
  ?>
  </tbody>
</table>
</div>

<br /><br /><br />
<div class="hidden">
<?php  // Debug info
echo "Main query:<br />" . $sqlByTime;
echo "<br /><br />";
if ( $orgUnit != 'Haiti') {
  echo "Subrow query:<br />" . $sqlByTimeSubrow;
}
?>  
</div>

<script>
  var definitionText = '<?php echo $reportFilteringLabels[$lang][43] ?>';
  var patientText = '<?php echo $reportFilteringLabels[$lang][33] ?>';
  var chartText = '<?php echo $reportFilteringLabels[$lang][34] ?>';
  var textTitleSection = '<?= $reportFilteringLabels[$lang][40].$reportFilteringLabels[$lang][39] ?>';
  var textGenderF = '<?php echo $reportFilteringLabels[$lang][44] ?>';
  var textGenderM = '<?php echo $reportFilteringLabels[$lang][45] ?>';
  var textGenderAll = '<?php echo $reportFilteringLabels[$lang][52] ?>';
  var textNumerator = '<?php echo $reportFilteringLabels[$lang][53] ?>';
  var textDenominator = '<?php echo $reportFilteringLabels[$lang][54] ?>';
  var textComplement = '<?php echo $reportFilteringLabels[$lang][55] ?>';
  var textTotal = '<?php echo $reportFilteringLabels[$lang][46] ?>';
  var textSaveCsv = '<?php echo $reportFilteringLabels[$lang][47] ?>';
  var textShowCsv = '<?php echo $reportFilteringLabels[$lang][48] ?>';
  function setTitles() {
    $('.patient-launch').attr('title',patientText);
    $('.chart-launch').attr('title',chartText);
  }
  function setSubTitles() {
    var chartText = '<?php echo $reportFilteringLabels[$lang][34] ?>';
    $('.chart-launch-many').attr('title',chartText);
  }
</script>
