<?php

if (strpos ($site, ",") > 0) 
  $site = str_replace (",", "','", $site);
$site = "'$site'";

// setup temp table for report 520
$tempTableName = TEMP_DB . ".temp" . substr ($user, 0, 3);
dbQuery("drop table if exists " . $tempTableName);
dbQuery("create table " . $tempTableName . " (patientID varchar(11), pregStart date, pregStop date)");
dbQuery("create index pid_idx on " . $tempTableName . " (patientID)");

/* guess at pregnant periods using intake, f/u and lab forms */
$result = dbQuery ("SELECT DISTINCT patientID, visitDate AS dataDate FROM v_vitals WHERE siteCode IN ($site) AND pregnant = 2 AND visitDate BETWEEN '$start' AND '$end' UNION SELECT DISTINCT patientID, visitDate AS dataDate FROM v_labsCompleted WHERE siteCode IN ($site) AND labID IN (134) AND result = 2 AND visitDate BETWEEN '$start' AND '$end' ORDER BY patientID asc, dataDate asc");
$notPregDates = array ();
while ($row = psRowFetch ($result)) {
  if (empty ($row[1])) continue;
  if (empty ($notPregDates[$row[0]])) {
    $notPregDates[$row[0]] = array ();
  }
  array_push ($notPregDates[$row[0]], $row[1]);
}
$result = dbQuery ("SELECT DISTINCT patientID, CASE WHEN ISNUMERIC(pregnantLmpDd) <> 1 AND ISDATE(dbo.ymdToDate(pregnantLmpYy,pregnantLmpMm,'15')) = 1 AND dbo.ymdToDate(pregnantLmpYy,pregnantLmpMm, '15') BETWEEN DATEADD(mm, -10, '$start') AND '$end' THEN dbo.ymdToDate(pregnantLmpYy,pregnantLmpMm,'15') WHEN ISNUMERIC(pregnantLmpDd) = 1 AND ISDATE(dbo.ymdToDate(pregnantLmpYy,pregnantLmpMm, pregnantLmpDd)) = 1 AND dbo.ymdToDate(pregnantLmpYy,pregnantLmpMm, pregnantLmpDd) BETWEEN DATEADD(mm, -10, '$start') AND '$end' THEN dbo.ymdToDate(pregnantLmpYy,pregnantLmpMm, pregnantLmpDd) END AS dataDate FROM v_vitals WHERE siteCode IN ($site) AND ISNUMERIC(pregnantLmpMm) = 1 AND ISNUMERIC(pregnantLmpYy) = 1 AND ISDATE(dbo.ymdToDate(pregnantLmpYy,pregnantLmpMm,'1')) = 1 ORDER BY patientID asc, dataDate DESC");
$lmpDates = array ();
while ($row = psRowFetch ($result)) {
  if (empty ($row[1])) continue;
  if (empty ($lmpDates[$row[0]])) {
    $lmpDates[$row[0]] = array ();
  }
  array_push ($lmpDates[$row[0]], $row[1]);
}
$result = dbQuery ("SELECT DISTINCT patientID, visitDate AS dataDate FROM v_vitals WHERE siteCode IN ($site) AND pregnant = 1 AND visitDate BETWEEN '$start' AND '$end' UNION SELECT DISTINCT patientID, visitDate AS dataDate FROM v_labsCompleted WHERE siteCode IN ($site) AND labID IN (134) AND result = 1 AND visitDate BETWEEN '$start' AND '$end' ORDER BY patientID asc, dataDate asc");
$pregRanges = array ();
while ($row = psRowFetch ($result)) {
  if (empty ($row[1])) continue;
  if (empty ($pregRanges[$row[0]])) {
    $pregRanges[$row[0]] = array ();
  }
  if (!pregRange ($row[1], $pregRanges[$row[0]]))
    array_push ($pregRanges[$row[0]], calcPreg ($row[1], $lmpDates[$row[0]], $notPregDates[$row[0]]));
}
foreach ($pregRanges as $k => $v) {
  foreach ($v as $a => $b) {
    dbQuery ("INSERT " . $tempTableName . " (patientID, pregStart, pregStop) VALUES ('$k', '" . $b[0] . "', '" . $b[1] . "')");
  }
}
$result = dbQuery ("SELECT regID, drugID1, drugID2, drugID3, shortName FROM regimen WHERE regGroup IN ('1stReg3', '1stReg4', '1stReg7', '1stReg8', '1stReg69', '1stReg73', '1stReg74', '2ndReg4', '2ndReg5') ORDER BY shortName ASC");
$regimens = array ();
while ($row = psRowFetch ($result)) {
  if (empty ($regimens[$row[0]])) {
    $regimens[$row[0]] = array ();
  }
  array_push ($regimens[$row[0]], $row[1], $row[2], $row[3], $row[4]);
}

$result = dbQuery ("SELECT DISTINCT p.siteCode, p.patientID, p.drugID, dbo.ymdToDate(LTRIM(RTRIM(p.dispDateYy)), LTRIM(RTRIM(p.dispDateMm)), ISNULL(NULLIF(UPPER(LTRIM(RTRIM(p.dispDateDd))), 'XX'), '15')) AS dispDate FROM v_prescriptions p, $tempTableName t, drugLookup l WHERE t.patientID = p.patientID AND l.drugGroup IN ('Pls', 'NNRTIs', 'NRTIs') AND l.drugID = p.drugID AND p.dispensed = 1 AND (ISNUMERIC(LTRIM(RTRIM(p.dispDateDd))) = 1 OR UPPER(LTRIM(RTRIM(p.dispDateDd))) = 'XX') AND (ISNUMERIC(LTRIM(RTRIM(p.dispDateMm))) = 1) AND (ISNUMERIC(LTRIM(RTRIM(p.dispDateYy))) = 1) AND ISDATE(dbo.ymdToDate(LTRIM(RTRIM(p.dispDateYy)), LTRIM(RTRIM(p.dispDateMm)), ISNULL(NULLIF(UPPER(LTRIM(RTRIM(p.dispDateDd))), 'XX'), '15'))) = 1 AND dbo.ymdToDate(LTRIM(RTRIM(p.dispDateYy)), LTRIM(RTRIM(p.dispDateMm)), ISNULL(NULLIF(UPPER(LTRIM(RTRIM(p.dispDateDd))), 'XX'), '15')) BETWEEN t.pregStart AND t.pregStop ORDER BY p.siteCode ASC, p.patientID ASC, dispDate ASC");

dbQuery("drop table if exists " . $tempTableName);
dbQuery("create table " . $tempTableName . " (rpt520siteCode mediumint, rpt520label varchar(255), rpt520count int, rpt520percentage varchar(255))");

$curSite = "";
$curPid = "";
$curDt = "";
$monoCnt = 0;
$biCnt = 0;
$triCnt = 0;
$myRegs = array ();
$disps = array ();
$siteDen = array ();
$multiSite = false;
$totalDen = 0;
$totalMono = 0;
$totalBi = 0;
$totalTri = 0;
$totalRegs = array ();
foreach (array_keys ($pregRanges) as $key) {
  $key = substr ($key, 0, 5);
  if (empty ($siteDen[$key])) $siteDen[$key] = 0;
  $siteDen[$key]++;
  $totalDen++;
}
if (count ($siteDen) > 1) $multiSite = true;
while ($row = psRowFetch ($result)) {
  if (substr ($row[1], 0, 5) != $curSite) {
    // if new siteCode, output data from previous one
    if (!empty ($curSite)) {
      fillTempTable ($tempTableName, $curSite, $monoCnt, $biCnt, $triCnt, $siteDen[$curSite], $regimens, $myRegs);
    }
    $totalMono += $monoCnt;
    $totalBi += $biCnt;
    $totalTri += $triCnt;
    foreach ($myRegs as $reg => $cnt) {
      if (empty ($totalRegs[$reg])) $totalRegs[$reg] = 0;
      $totalRegs[$reg] += $cnt;
    }
    $monoCnt = 0;
    $biCnt = 0;
    $triCnt = 0;
    $myRegs = array ();
    $curSite = substr ($row[1], 0, 5);
    $curPid = "";
    $curDt = "";
  }
  if ($curPid != $row[1]) {
    if (!empty ($curPid)) {
      // count therapy types and compute regimens for patient
      totalPatient ($disps, $regimens, $monoCnt, $biCnt, $triCnt, $myRegs);
    } 
    $curPid = $row[1];
    $curDt = $row[3];
    $disps = array ();
    $disps[$curDt] = array ();
    array_push ($disps[$curDt], $row[2]);
  } else {
    if ($curDt != $row[3]) {
      $curDt = $row[3];
      $disps[$curDt] = array ();
    }
    array_push ($disps[$curDt], $row[2]);
  }
}

if (!empty ($curSite)) {
  totalPatient ($disps, $regimens, $monoCnt, $biCnt, $triCnt, $myRegs);
  fillTempTable ($tempTableName, $curSite, $monoCnt, $biCnt, $triCnt, $siteDen[$curSite], $regimens, $myRegs);

  $totalMono += $monoCnt;
  $totalBi += $biCnt;
  $totalTri += $triCnt;
  foreach ($myRegs as $reg => $cnt) {
    if (empty ($totalRegs[$reg])) $totalRegs[$reg] = 0;
    $totalRegs[$reg] += $cnt;
  }

  if ($multiSite) {
    $curSite = "99999";
    fillTempTable ($tempTableName, $curSite, $totalMono, $totalBi, $totalTri, $totalDen, $regimens, $totalRegs);
  }
}
// end temp table setup

function calcPreg ($pregDate, $lmps, $notPregs) {
  // make an educated guess at a date range when a patient was pregnant
  $twoWeeksSeconds = 1296000;
  $tenMonthsSeconds = 25920000;
  $start = $pregDate;
  $end = "";
  $newStart = "";
  $noGood = false;

  if (!empty ($lmps)) {
    rsort ($lmps);
    foreach ($lmps as $date) {
      if (strtotime ($date) < strtotime ($pregDate) &&
          strtotime ($date) >= strtotime ($pregDate) - $tenMonthsSeconds) {
        $newStart = date ("Ymd", strtotime ($date) + $twoWeeksSeconds);
        break;
      }
    }
  }

  if (!empty ($newStart)) {
    if (!empty ($notPregs)) {
      sort ($notPregs);
      foreach ($notPregs as $date) {
        if (strtotime ($date) >= strtotime ($newStart) &&
            strtotime ($date) <= strtotime ($pregDate)) {
          $noGood = true;
          break;
        }
      }
    }
    if (!$noGood) $start = $newStart;
  }

  $ends = array ();
  if (!empty ($lmps)) {
    if (!empty ($notPregs)) {
      $ends = array_merge ($lmps, $notPregs);
    } else {
      $ends = $lmps;
    }
  } else if (!empty ($notPregs)) {
    $ends = $notPregs;
  }
  if (!empty ($ends)) sort ($ends);
  foreach ($ends as $date) {
    if (strtotime ($date) > strtotime ($start) &&
        strtotime ($date) <= strtotime ($start) + $tenMonthsSeconds) {
      $end = date ("Ymd", strtotime ($date));
      break;
    }
  }

  if (empty ($end)) $end = date ("Ymd", strtotime ($start) + $tenMonthsSeconds);
  return (array ($start, $end));
}

function pregRange ($date, $ranges) {
  // see if a given date is within a pre-existing pregnancy date range
  foreach ($ranges as $range) {
    if (strtotime ($date) >= strtotime ($range[0]) &&
        strtotime ($date) <= strtotime ($range[1]))
      return (true);
  }
  return (false);
}

function totalPatient ($disps, $regimens, &$mono, &$bi, &$tri, &$regs) {
  $tempMono = false;
  $tempBi = false;
  $tempTri = false;
  $tempReg = "";
  foreach ($disps as $k => $v) {
    if (count ($v) == 1) {
      if ($v[0] == 23 || $v[0] == 34) $tempMono = true;
      else if ($v[0] == 8) $tempBi = true;
      else if ($v[0] == 33) {
        $tempTri = true;
        $tempReg = "ZDV-3TC-ABC";
      }
    } else if (count ($v) == 2) {
      if (in_array (20, $v) && in_array (34, $v)) $tempBi = true;
      else if (in_array (8, $v)) {
        $tempTri = true;
        if (in_array (1, $v)) $tempReg = "ZDV-3TC-ABC";
        if (in_array (11, $v)) $tempReg = "ZDV-3TC-EFV";
      } else if (in_array (33, $v)) {
        $tempTri = true;
        $tempReg = "ZDV-3TC-ABC";
      }
    } else if (count ($v) > 2) {
      $tempTri = true;
      if (in_array (33, $v)) $tempReg = "ZDV-3TC-ABC";
      else if (in_array (8, $v)) {
        if (in_array (1, $v)) $tempReg = "ZDV-3TC-ABC";
        if (in_array (11, $v)) $tempReg = "ZDV-3TC-EFV";
      } else {
        foreach ($regimens as $a => $b) {
          if (count (array_map ("skipBlanks", array_values ($b))) == 4) {
            if (in_array ($b[0], $v) && in_array ($b[1], $v) && in_array ($b[2], $v)) {
              $tempReg = $b[3];
              break;
            }
          }
        }
      }
    }
  }
  if ($tempMono) $mono++;
  if ($tempBi) $bi++;
  if ($tempTri) {
    $tri++;
    $regs[$tempReg]++;
  }
}

function fillTempTable ($name, $site, $mono, $bi, $tri, $den, $regimens, $regs) {
  dbQuery ("INSERT " . $name . " (rpt520siteCode, rpt520label, rpt520count, rpt520percentage) VALUES ('" . $site . "', '" . $GLOBALS['report520Labels'][$GLOBALS['lang']][0] . "', " . ($site == "99999" ? "NULL" : "'$den'") . ", NULL)");
  dbQuery ("INSERT " . $name . " (rpt520siteCode, rpt520label, rpt520count, rpt520percentage) VALUES ('" . $site . "', '" . $GLOBALS['report520Labels'][$GLOBALS['lang']][3] . "', '" . $mono . "', '" . ($den > 0 ? round ($mono / $den * 100) : 0) . "%')");
  dbQuery ("INSERT " . $name . " (rpt520siteCode, rpt520label, rpt520count, rpt520percentage) VALUES ('" . $site . "', '" . $GLOBALS['report520Labels'][$GLOBALS['lang']][4] . "', '" . $bi . "', '" . ($den > 0 ? round ($bi / $den * 100) : 0) . "%')");
  dbQuery ("INSERT " . $name . " (rpt520siteCode, rpt520label, rpt520count, rpt520percentage) VALUES ('" . $site . "', '" . $GLOBALS['report520Labels'][$GLOBALS['lang']][5] . "', '" . $tri . "', '" . ($den > 0 ? round ($tri / $den * 100) : 0) . "%')");
  dbQuery ("INSERT " . $name . " (rpt520siteCode, rpt520label, rpt520count, rpt520percentage) VALUES ('" . $site . "', '" . $GLOBALS['report520Labels'][$GLOBALS['lang']][6] . "', '" . ($mono + $bi + $tri) . "', '" . ($den > 0 ? round (($mono + $bi + $tri) / $den * 100) : 0) . "%')");
  dbQuery ("INSERT " . $name . " (rpt520siteCode, rpt520label, rpt520count, rpt520percentage) VALUES ('0', '" . $GLOBALS['report520Labels'][$GLOBALS['lang']][7] . "', NULL, NULL)");
  $regTotal = 0;
  $done = array ();
  foreach ($regimens as $k => $v) {
    if (in_array ($v[3], $done)) continue;
    if (array_key_exists ($v[3], $regs)) {
      dbQuery ("INSERT " . $name . " (rpt520siteCode, rpt520label, rpt520count, rpt520percentage) VALUES ('" . $site . "', '" . $v[3] . "', '" . $regs[$v[3]] . "', '" . ($tri > 0 ? round ($regs[$v[3]] / $tri * 100) : 0) . "%')");
      $regTotal += $regs[$v[3]];
    } else {
      dbQuery ("INSERT " . $name . " (rpt520siteCode, rpt520label, rpt520count, rpt520percentage) VALUES ('" . $site . "', '" . $v[3] . "', 0, '0%')");
    }
    array_push ($done, $v[3]);
  }
  // Other tritherapy, don't show for now
  //dbQuery ("INSERT " . $name . " (rpt520siteCode, rpt520label, rpt520count, rpt520percentage) VALUES ('" . $site . "', '" . $GLOBALS['report520Labels'][$GLOBALS['lang']][8] . "', '" . ($tri - $regTotal) . "', '" . ($tri > 0 ? round (($tri - $regTotal) / $tri * 100) : 0) . "%')");
  dbQuery ("INSERT " . $name . " (rpt520siteCode, rpt520label, rpt520count, rpt520percentage) VALUES ('" . $site . "', '" . $GLOBALS['report520Labels'][$GLOBALS['lang']][6] . "', '" . $regTotal . "', '" . ($tri > 0 ? round ($regTotal / $tri * 100) : 0) . "%')");
}

function skipBlanks ($in) {
  return (!empty ($in) ? $in : null);
}
?>
