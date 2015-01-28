<?php			   
require_once 'backend.php';
require_once 'backend/sharedRptFunctions.php';

$setupTableNames = array ();

function valInRange ($arr, $low, $high) {
  /* if given array contains a value between $low and $high, return true */
  if (is_array ($arr)) {
    foreach ($arr as $val) {
      if ($val >= $low && $val <= $high) return (true);
    }
  }
  return (false);
}

function maxValLimit ($arr, $limit) {
  /* return highest value in array that's equal to or less than $limit */
  /* if no such value, or $arr is not an array, return -1 */
  if (is_array ($arr)) {
    sort ($arr);   
    for ($i = count ($arr) - 1; $i >= 0; $i--) {
      if ($arr[$i] <= $limit) {
        return ($arr[$i]);
        break;
      }
    }
  }
  return (-1);
}

function generateAgeGroups ($in, $site, $dt) {
  $out = array ("adults" => array (), "kids" => array ());
  global $setupTableNames;

  $result = dbQuery ("
    SELECT patientID, startDays
    FROM " . $setupTableNames[1]);

  while ($row = psRowFetch ($result)) {
    if ($row[1] < (15 * DAYS_IN_YEAR)) {
      array_push ($out["kids"], $row[0]);
    } else {
      array_push ($out["adults"], $row[0]);
    }
  }
   
  return (array ("adults" => array_intersect ($in, $out["adults"]),
                 "kids" => array_intersect ($in, $out["kids"])));
}

function setupHivQual ($repNum, $site, $start, $end) {
  global $setupTableNames;

  $setupTableNames = createTempTables ("#setupHivQual", 2, array ("patientID varchar(11), startDays mediumint, endDays mediumint", "patientID varchar(11), lmpDate date, eligDate date"), "pat_idx::patientID");

  fillPidAgeTable ($setupTableNames[1], $site, $start, $end);
  fillLmpTable ($setupTableNames[2], $site, $end, getEligDays ($repNum, $start));
}

function cleanupHivQual () {
  global $setupTableNames;

  dropTempTables ($setupTableNames);  
}

function hivQual($repNum, $site, $intervalLength, $startDate, $endDate = null) {
  if (DEBUG_FLAG) echo "<BR />Entering hivQual: " . date ("Y-m-d H:i:s")  . " - site = $site - date = $endDate<BR />\n";

  setupHivQual ($repNum, $site, $startDate, $endDate);

  // old versions created permanent table, clean those up here
  $user = ereg_replace ('[^A-Za-z0-9]', '', getSessionUser());
  $tempTableNames = array ();
  for ($i = 1; $i <= 6; $i++) {
    $tempTableNames[$i] = TEMP_DB . ".tempHivQualSubquery$i" . $user;
  }
  dropTempTables ($tempTableNames);  

  $site = trim($site);
  $num = 0;
  $den = 0; 
  $pedNum = 0;
  $pedDen = 0;
  $pidsByAge = array ();
  $tmpDen = array ();
  $tmpNum = array ();
  $tmpInd = array ('01' => array (), '02' => array (), '03' => array (),
                   '04A' => array (), '04B' => array (), '05' => array (),
                   '06' => array (), '07' => array (), '08' => array (),
                   '09' => array (), '10' => array ());
  $tmpPedInd = array ('01' => array (), '02' => array (), '03' => array (),
                      '04A' => array (), '04B' => array (), '05' => array (),
                      '06' => array (), '07' => array (), '08' => array (),
                      '09' => array (), '10' => array ());

  if ($endDate == null) {
    $endDate = date ('Y-m-d');
  }

  // make sure patient status data exists
  // Original HIVQual needs $endDate, $endDate - 3 months and $endDate - 6 months
  // Monthly indicator report needs $endDate and $endDate - 1 month
  $checkDates = array ($endDate);
  if ($repNum == "530") {
    array_push ($checkDates, $startDate);
  } else {
    array_push ($checkDates, monthDiff(-3, $endDate), monthDiff(-6, $endDate));
  }
  foreach ($checkDates as $checkDate) {
    if (!isPatientStatusExist($checkDate)) {
      updatePatientStatus(2, $checkDate);
    }
  }
  
  $indicatorProperties = array();
  $indicatorProperties[] = array('name' => '05', 'numFunct' => 'getInd5Num', 'denFunct' => 'getInd5Den');
  $indicatorProperties[] = array('name' => '01', 'numFunct' => 'getInd1Num', 'denFunct' => 'getInd1Den');
  $indicatorProperties[] = array('name' => '02', 'numFunct' => 'getInd2Num', 'denFunct' => 'getInd2Den');
  $indicatorProperties[] = array('name' => '03', 'numFunct' => 'getInd3Num', 'denFunct' => 'getInd3Den');
  $indicatorProperties[] = array('name' => '04A', 'numFunct' => 'getInd4Num', 'denFunct' => 'getInd4ADen');
  $indicatorProperties[] = array('name' => '04B', 'numFunct' => 'getInd4Num', 'denFunct' => 'getInd4BDen');
  $indicatorProperties[] = array('name' => '06', 'numFunct' => 'getInd6Num', 'denFunct' => 'getInd6Den');
  $indicatorProperties[] = array('name' => '07', 'numFunct' => 'getInd7Num', 'denFunct' => 'getInd7Den');
  $indicatorProperties[] = array('name' => '08', 'numFunct' => 'getInd8Num', 'denFunct' => 'getInd8Den');
  $indicatorProperties[] = array('name' => '09', 'numFunct' => 'getInd9Num', 'denFunct' => 'getInd9Den');
  $indicatorProperties[] = array('name' => '10', 'numFunct' => 'getInd10Num', 'denFunct' => 'getInd10Den');
  
  foreach ($indicatorProperties as $indicatorProperty) {
    // No need to run 5, 7, or 8 if monthly indicator report
    if ($repNum == "530" && ($indicatorProperty['name'] == '05' ||
        $indicatorProperty['name'] == '07' || $indicatorProperty['name'] == '08')) {
     array_push($tmpInd[$indicatorProperty[name]],
  	        $startDate, $endDate, 0, 0, "0");
     continue;
    }

    if (DEBUG_FLAG) echo "<BR />Running indicator #$indicatorProperty[name]: " 
		      . date ("Y-m-d H:i:s")  . "<BR />\n";

    $tmpDen = call_user_func($indicatorProperty[denFunct], $repNum, $site, $intervalLength, $startDate, $endDate);
    if ($repNum == "504") {
      $pidsByAge = generateAgeGroups ($tmpDen, $site, $startDate);
      $den = count ($pidsByAge["adults"]);
      $pedDen = count ($pidsByAge["kids"]);
    } else {
      $den = count($tmpDen);
    }
    
    if (DEBUG_FLAG) echo "<BR />Den. done, now num.:  " . date ("Y-m-d H:i:s")  . "<BR />\n";

    $tmpNum = array_intersect($tmpDen,
                              call_user_func($indicatorProperty[numFunct],
                                             $repNum, $site, $intervalLength,
                                             $startDate, $endDate));
    if ($repNum == "504") {
      $num = count (array_intersect ($tmpNum, $pidsByAge["adults"]));
      $pedNum = count (array_intersect ($tmpNum, $pidsByAge["kids"]));

      if ($pedDen == 0) {
        $pedRatio = "0";
      } else {
        $pedRatio = round(100*$pedNum/$pedDen, 1);
      }
    } else {
      $num = count ($tmpNum);
    }
    
    if ($den == 0) {
      $ratio = "0";
    } else {
      $ratio = round(100*$num/$den, 1);
    }
    
    array_push($tmpInd[$indicatorProperty[name]],
	       $startDate, $endDate, $num, $den, $ratio);

    if ($repNum == "504") {
      array_push($tmpPedInd[$indicatorProperty[name]],
	         $startDate, $endDate, $pedNum, $pedDen, $pedRatio);
    }
  }
  
  /* Insert values into pre-existing temp table */
  $cases = 0;
  $result = dbQuery ("SELECT COUNT(*) FROM patientStatusTemp WHERE LEFT(patientID, 5) = '$site' AND patientStatus IN (2, 3, 4, 5, 6, 7, 8, 10) AND endDate = '$endDate'");
  if ($row = psRowFetch ($result)) {
    $cases = $row[0];
  }

  // insert into table, or update if row already exists
  $valSql = "('" . date ("Y-m-d H:i:s") . "', '$startDate', '$endDate', '$site', '$cases'";
  foreach ($tmpInd as $k => $v) {
    $valSql .= ", " . $v[2] . ", " . $v[3] . ", '" . $v[4] . "'";
  }
  $valSql .= $repNum == "530" ? ", 1" : ", 0";
  $valSql .= ")";

  dbQuery("
DELETE FROM hivQual
WHERE siteCode = '$site'
 AND startDate = '$startDate'
 AND endDate = '$endDate'
" . ($repNum == "530" ? "
 AND row_type = 1
" : "
 AND (row_type = 0 OR row_type IS NULL)
"));
  dbQuery("INSERT hivQual (lastRun, startDate, endDate, siteCode, cases, ind1_num, ind1_den, ind1_ratio, ind2_num, ind2_den, ind2_ratio, ind3_num,ind3_den, ind3_ratio, ind4A_num, ind4A_den, ind4A_ratio, ind4B_num, ind4B_den,ind4B_ratio, ind5_num, ind5_den, ind5_ratio, ind6_num, ind6_den, ind6_ratio, ind7_num, ind7_den, ind7_ratio, ind8_num, ind8_den, ind8_ratio, ind9_num, ind9_den, ind9_ratio, ind10_num, ind10_den, ind10_ratio, row_type) VALUES " . $valSql);
  
  // Also add ped. row, if original HIVQual
  if ($repNum == "504") {
    $valSql = "('" . date ("Y-m-d H:i:s") . "', '$startDate', '$endDate', '$site', '$cases'";
    foreach ($tmpPedInd as $k => $v) {
      $valSql .= ", " . $v[2] . ", " . $v[3] . ", '" . $v[4] . "'";
    }
    $valSql .= ", 2)";

    dbQuery("
  DELETE FROM hivQual
  WHERE siteCode = '$site'
   AND startDate = '$startDate'
   AND endDate = '$endDate'
   AND row_type = 2
  ");

    dbQuery("INSERT hivQual (lastRun, startDate, endDate, siteCode, cases, ind1_num, ind1_den, ind1_ratio, ind2_num, ind2_den, ind2_ratio, ind3_num,ind3_den, ind3_ratio, ind4A_num, ind4A_den, ind4A_ratio, ind4B_num, ind4B_den,ind4B_ratio, ind5_num, ind5_den, ind5_ratio, ind6_num, ind6_den, ind6_ratio, ind7_num, ind7_den, ind7_ratio, ind8_num, ind8_den, ind8_ratio, ind9_num, ind9_den, ind9_ratio, ind10_num, ind10_den, ind10_ratio, row_type) VALUES " . $valSql);
  }

  if (DEBUG_FLAG) echo "<BR />Leaving hivQual: " . date ("Y-m-d H:i:s")  . "<BR />\n";

  cleanupHivQual ();
}


// Adherence Assessment

function getInd5Den($repNum, $site, $intervalLength, $startDate, $endDate) {
  $threeMonths = monthDiff(-3, $endDate);
  return fetchFirstColumn(dbQuery("
SELECT DISTINCT p.patientid 
FROM encValid e, pepfarTable p
WHERE p.siteCode = '$site'
 AND (p.forPepPmtct = 0 OR p.forPepPmtct IS NULL)
 AND p.visitDate <= '$threeMonths'
 AND e.patientid = p.patientid
 AND e.encounterType IN " . visitList ("hivQual") . "
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'
 AND p.patientid NOT IN (SELECT DISTINCT patientID FROM discTable WHERE sitecode = '$site' AND discDate <= '$endDate')"));
}

function getInd5Num($repNum, $site, $intervalLength, $startDate, $endDate) {
  return fetchFirstColumn(dbQuery("
SELECT STRAIGHT_JOIN DISTINCT patientID 
FROM encValid 
WHERE siteCode = '$site'
 AND encounterType IN (14, 20)
 AND visitDate BETWEEN '$startDate' AND '$endDate'"));
}


//Continuity of Care
  
function getInd1Den($repNum, $site, $intervalLength, $startDate, $endDate) {
  $threeMonths = monthDiff(-3, $endDate);

  return fetchFirstColumn(dbQuery("
SELECT DISTINCT p.patientid 
FROM pepfarTable p, patientStatusTemp t 
WHERE p.siteCode = '$site'
 AND (p.forPepPmtct = 0 OR p.forPepPmtct IS NULL)
 AND p.visitDate <= '$threeMonths'
 AND p.patientid = t.patientid
 AND t.patientStatus IN (2,4,6,8)
 AND endDate = '$startDate'"));
}

function getInd1Num($repNum, $site, $intervalLength, $startDate, $endDate) {
  $threeMonths = monthDiff(-3, $endDate);
  
  return fetchFirstColumn(dbQuery("
SELECT STRAIGHT_JOIN e.patientID
FROM patientStatusTemp t, encValid e
WHERE e.encounterType IN " . visitList ("hivQual") . "
 AND e.siteCode = '$site'
 AND e.visitDate BETWEEN '$threeMonths' AND '$endDate'
 AND e.patientid = t.patientid
 AND t.patientStatus IN (2,4,6,8)
 AND t.endDate = '$startDate'
GROUP BY e.patientID
HAVING COUNT(e.visitDate) >= 2"));
}


// HIV Monitoring
   
function getInd2Den($repNum, $site, $intervalLength, $startDate, $endDate) {
  global $setupTableNames;
  $rangeEnd = monthDiff (-6, $endDate);
  $rangeStart = monthDiff (-6, $startDate);

  return $repNum == "530" ? fetchFirstColumn(dbQuery("
SELECT DISTINCT e.patientID 
FROM encValid e, pepfarTable p
WHERE e.siteCode = '$site'
 AND (p.forPepPmtct = 0 OR p.forPepPmtct IS NULL)
 AND e.encounterType IN " . visitList ("hivQual") . "
 AND e.patientID NOT IN (SELECT patientid FROM discTable WHERE sitecode = '$site' AND discDate <= '$endDate')
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'
 AND e.patientID = p.patientID"))
:
  fetchFirstColumn(dbQuery("
SELECT e.patientID 
FROM encValid e
 " . (strtotime ($endDate) > strtotime (CD4_350_DATE) ? "
 LEFT JOIN " . $setupTableNames[1] . " t1 ON e.patientID = t1.patientID
 LEFT JOIN eligibility l ON e.patientID = l.patientID" : "") . "
WHERE e.siteCode = '$site'
 " . (strtotime ($endDate) > strtotime (CD4_350_DATE) ? "
 AND
 (
  t1.startDays >= 15 * " . DAYS_IN_YEAR . "
  OR
  (t1.startDays >= 0
   AND t1.startDays < 15 * " . DAYS_IN_YEAR . "
   AND l.visitDate <= '$startDate'
   AND l.reason IN ('cd4LT200', 'eligByAge', 'eligByCond', 'eligPcr', 'tlcLT1200', 'WHOIII-2', 'WHOIIICond', 'WHOIV')
   AND l.criteriaVersion = 2)
 )" : "") . " 
 AND e.encounterType IN (10, 15)
 AND e.patientID NOT IN (SELECT patientid FROM discTable WHERE sitecode = '$site' AND discDate <= '$endDate') 
GROUP BY e.patientID 
HAVING MIN(e.visitDate) BETWEEN '$rangeStart' AND '$rangeEnd'"));
}

function getInd2Num($repNum, $site, $intervalLength, $startDate, $endDate) {
  $rangeEnd = monthDiff (-6, $endDate);
  $rangeStart = monthDiff (-6, $startDate);
  $eightMonths = monthDiff (-8, $endDate);  // used for monthly indicator report

  return $repNum == "530" ? fetchFirstColumn(dbQuery("
SELECT DISTINCT l.patientid 
FROM cd4Table l, pepfarTable p
WHERE l.patientId = p.patientID
 AND (p.forPepPmtct = 0 OR p.forPepPmtct IS NULL)
 AND l.sitecode = '$site'
 AND l.visitDate BETWEEN '$eightMonths' AND '$endDate'"))
:
  fetchFirstColumn(dbQuery("
SELECT l.patientid
FROM cd4Table l, (
 SELECT patientID 
 FROM encValid 
 WHERE siteCode = '$site'
  AND encounterType IN (10, 15)
  AND patientID NOT IN (SELECT patientid FROM discTable WHERE sitecode = '$site' AND discDate <= '$endDate') 
 GROUP BY patientID 
 HAVING MIN(visitDate) BETWEEN '$rangeStart' AND '$rangeEnd') t
WHERE t.patientid = l.patientID
 AND l.visitDate BETWEEN '$rangeStart' AND '$endDate'
GROUP BY l.patientID
HAVING COUNT(l.visitDate) >= 2"));
}


// ART Enrollment
  
function getInd3Den($repNum, $site, $intervalLength, $startDate, $endDate) {

  // Make some temp tables to hold all the subquery results to use in
  // later joins (improves performance enormously)
  $tempTableNames = createTempTables ("#ind3Den", 3, "patientID varchar(11)", "pid_idx::patientID");

  // Fill temp tables with values to be used in later joins
  /* Don't count anyone who initiated ART previously */
  dbQuery ("INSERT INTO " . $tempTableNames[1] . " SELECT DISTINCT patientid FROM pepfarTable WHERE siteCode = '$site' AND (forPepPmtct = 0 OR forPepPmtct IS NULL) GROUP BY patientid HAVING MIN(visitDate) < '$startDate'");
  /* Don't count anyone who's been discontinued */
  dbQuery ("INSERT INTO " . $tempTableNames[2] . " SELECT DISTINCT patientid FROM discTable WHERE sitecode = '$site' AND discDate <= '$endDate'");
  /* Patient needs >= 1 visit in period */
  dbQuery ("INSERT INTO " . $tempTableNames[3] . " SELECT STRAIGHT_JOIN DISTINCT patientID FROM encValid WHERE siteCode = '$site' AND encounterType IN " . visitList ("hivQual") . " AND visitDate BETWEEN '$startDate' AND '$endDate'");

  /* Run eligibility query at end of period and store matching pids */
  $result = fetchFirstColumn(dbQuery("
SELECT DISTINCT e.patientid 
FROM eligibility e 
LEFT JOIN " . $tempTableNames[1] . " t1 ON e.patientid = t1.patientID
LEFT JOIN " . $tempTableNames[2] . " t2 ON e.patientid = t2.patientID
LEFT JOIN " . $tempTableNames[3] . " t3 ON e.patientid = t3.patientID
WHERE LEFT(e.patientid, 5) = '$site'
 AND e.visitDate <= '$endDate'
 AND e.criteriaVersion
 " . (strtotime ($endDate) <= strtotime (CD4_350_DATE) ? "= 1" : (strtotime ($endDate) <= strtotime (OPTION_B_PLUS_DATE) ? "= 2" : "IN (2, 3)")) . "
 AND e.reason IN ('cd4LT200', 'tlcLT1200', 'WHOIII', 'WHOIV', 'medEligHAART', 'estPrev', 'former', 'eligByAge', 'eligByCond', 'eligPcr', 'WHOIII-2', 'WHOIIICond', 'OptionB+')
 AND t1.patientID IS NULL
 AND t2.patientID IS NULL
 AND t3.patientID = e.patientID"));

  dropTempTables ($tempTableNames);  
  return $result;
}
        
function getInd3Num($repNum, $site, $intervalLength, $startDate, $endDate) {
  return fetchFirstColumn(dbQuery("
SELECT DISTINCT patientid 
FROM pepfarTable 
WHERE siteCode = '$site'
 AND (forPepPmtct = 0 OR forPepPmtct IS NULL)
" . ($repNum == "530" ? "
 AND visitDate BETWEEN '$startDate' AND '$endDate'
" : "
GROUP BY patientid 
HAVING MIN(visitDate) BETWEEN '$startDate' AND '$endDate'
")));
}


// Cotrimoxazole Prophylaxis Adult

function getInd4DrugList($intervalLength) {
//  if ($intervalLength == 6) {
//    return '9, 69, 70';
//  } elseif ($intervalLength == 1) {
    return '9, 69, 70';
//  }
}

// Make some temp tables to hold all the subquery results to use in
// later joins (improves performance enormously)
function makeInd4DenTemp($repNum, $site, $intervalLength, $startDate, $endDate) {
  $drugList = getInd4DrugList($intervalLength);

  $tempTableNames = createTempTables ("#ind4Den", 2, array ("patientID varchar(11)", "patientID varchar(11)"), "pat_idx::patientID");
  dbQuery ("
INSERT INTO " . $tempTableNames[1] . "
SELECT DISTINCT patientID 
FROM patient 
WHERE patStatus = 0
 AND hivPositive = 1
 AND location_id = '$site'
 AND patientID NOT IN (SELECT patientid FROM discTable WHERE sitecode = '$site' AND discDate <= '$endDate')");

//  dbQuery ("
//INSERT INTO " . $tempTableNames[2] . "
//SELECT DISTINCT patientID 
//FROM patient 
//WHERE patStatus < 255
// AND hivPositive = 1
// AND location_id = '$site'
// AND patientID NOT IN (
//  SELECT patientid FROM drugTable
//  WHERE sitecode = '$site' AND drugID IN ($drugList) AND visitdate < '$startDate')
//" . ($repNum == "530" ? "AND patientID NOT IN (SELECT e.patientID FROM encValid e, otherPrescriptions o WHERE e.patientID = o.patientID AND e.siteCode = o.siteCode AND e.visitDateDd = o.visitDateDd AND e.visitDateMm = o.visitDateMm AND e.visitDateYy = o.visitDateYy AND e.seqNum = o.seqNum AND e.siteCode = '$site' AND LOWER(o.drug) LIKE '%dapson%' AND e.visitDate < '$startDate')" : ""));

  return $tempTableNames;
}

function getInd4ADen($repNum, $site, $intervalLength, $startDate, $endDate) {
  global $setupTableNames;

  $tempTableNames = makeInd4DenTemp($repNum, $site, $intervalLength, $startDate, $endDate);
  $result = fetchFirstColumn(dbQuery("
SELECT DISTINCT e.patientID 
FROM encValid e, " . $tempTableNames[1] . " t1,
" . $setupTableNames[1] . " t3
WHERE e.patientID = t1.patientID
 AND e.patientID = t3.patientID
 AND t3.startDays >= 15 * " . DAYS_IN_YEAR . "
 AND e.siteCode = '$site'
 AND e.encounterType IN " . visitList ("hivQual") . "
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'"));
  dropTempTables ($tempTableNames);  
  return $result;
}

// This function is used for both 4A and 4B numerator calculations
function getInd4Num($repNum, $site, $intervalLength, $startDate, $endDate) {
  $drugList = getInd4DrugList($intervalLength);
  return fetchFirstColumn(dbQuery("
SELECT STRAIGHT_JOIN DISTINCT patientID 
FROM v_drugTable 
WHERE sitecode = '$site'
 AND drugID IN ($drugList)
 AND visitdate BETWEEN '$startDate' AND '$endDate'
" . ($repNum == "530" ? "
UNION
SELECT DISTINCT e.patientID
FROM encValid e, otherPrescriptions o
WHERE e.patientID = o.patientID
 AND e.siteCode = o.siteCode
 AND e.visitDateDd = o.visitDateDd
 AND e.visitDateMm = o.visitDateMm
 AND e.visitDateYy = o.visitDateYy
 AND e.seqNum = o.seqNum
 AND e.siteCode = '$site'
 AND LOWER(o.drug) LIKE '%dapson%'
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'
" : "")));
}
//For backward compatibility with things that used the old functions (i'm looking at you hivQualPatientID.php)
function getInd4ANum() {$args = func_get_args(); return call_user_func_array('getInd4Num', $args);}
function getInd4BNum() {$args = func_get_args(); return call_user_func_array('getInd4Num', $args);}


// Cotrimoxazole Prophylaxis Pediatric
  
function getInd4BDen($repNum, $site, $intervalLength, $startDate, $endDate) {
  global $setupTableNames;

  $tempTableNames = makeInd4DenTemp($repNum, $site, $intervalLength, $startDate, $endDate);
  $result1 = fetchFirstColumn(dbQuery("
SELECT DISTINCT e.patientID 
FROM v_vitals v, encValid e, " . $tempTableNames[1] . " t1,
" . $setupTableNames[1] . " t3
WHERE e.patientID = v.patientID
 AND v.siteCode = '$site'
 AND v.pedCurrHiv > 1
 AND v.visitdate <= '$endDate'
 AND e.patientID = t1.patientID
 AND e.patientID = t3.patientID
 AND t3.startDays BETWEEN " . DAYS_IN_YEAR . " * 5 AND " . DAYS_IN_YEAR . " * 15
 AND e.encounterType IN " . visitList ("hivQual") . "
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'"));
  $result2 = fetchFirstColumn(dbQuery("
SELECT DISTINCT e.patientID 
FROM v_vitals v, v_conditions c, encValid e, " . $tempTableNames[1] . " t1,
" . $setupTableNames[1] . " t3
WHERE e.patientID = v.patientID
 AND v.siteCode = '$site'
 AND v.pedCurrHiv > 1
 AND v.visitdate <= '$endDate'
 AND e.patientID = c.patientID
 AND c.whoStage IN ('Stage II', 'Stage III', 'Stage IV')
 AND c.visitDate <= '$endDate'
 AND e.patientID = t1.patientID
 AND e.patientID = t3.patientID
 AND t3.startDays BETWEEN " . DAYS_IN_YEAR . " AND " . DAYS_IN_YEAR . " * 5
 AND e.encounterType IN " . visitList ("hivQual") . "
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'"));
  $result3 = fetchFirstColumn(dbQuery("
SELECT DISTINCT e.patientID 
FROM v_vitals v, encValid e, " . $tempTableNames[1] . " t1,
" . $setupTableNames[1] . " t3
WHERE e.patientID = v.patientID
 AND v.siteCode = '$site'
 AND v.pedCurrHiv >= 1
 AND v.visitdate <= '$endDate'
 AND e.patientID = t1.patientID
 AND e.patientID = t3.patientID
 AND t3.startDays BETWEEN 42 AND " . DAYS_IN_YEAR . "
 AND e.encounterType IN " . visitList ("hivQual") . "
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'"));
  dropTempTables ($tempTableNames);  
  return array_merge($result1, $result2, $result3);
}


// TB Assessment

function getInd6Den($repNum, $site, $intervalLength, $startDate, $endDate) {
  $threeDaysStart = dayDiff (-3, $startDate);
  $threeDaysEnd = dayDiff (-3, $endDate);

  $rangeStart = ($repNum == "530") ? $startDate : $threeDaysStart;
  $rangeEnd = ($repNum == "530") ? $endDate : $threeDaysEnd;

  // Need temp tables to hold subquery results used in later joins
  $tempTableNames = createTempTables ("#ind6Den", 2, "patientID varchar(11)", "pat_idx::patientID");

  // Fill temp tables with values to be used in later joins
  /* Don't count anyone who's on TB treatment currently */
  /* Joining encValid and tbStatus runs much faster than using v_tbStatus */
  dbQuery ("INSERT INTO " . $tempTableNames[1] . " SELECT STRAIGHT_JOIN DISTINCT e.patientid FROM encValid e, tbStatus t WHERE e.patientID = t.patientID AND e.siteCode = t.siteCode AND e.visitDateDd = t.visitDateDd AND e.visitDateMm = t.visitDateMm AND e.visitDateYy = t.visitDateYy AND e.seqNum = t.seqNum AND e.siteCode = '$site' AND (t.currentTreat = 1 OR t.currentProp = 1 OR t.propINH = 1) AND e.encounterType IN (1, 2, 16, 17) AND e.visitDate BETWEEN '$rangeStart' AND '$endDate'");
  /* Joining encValid and prescriptions runs much faster than using v_prescriptions */
  dbQuery ("INSERT INTO " . $tempTableNames[1] . " SELECT STRAIGHT_JOIN DISTINCT e.patientid FROM encValid e, prescriptions t WHERE e.patientID = t.patientID AND e.siteCode = t.siteCode AND e.visitDateDd = t.visitDateDd AND e.visitDateMm = t.visitDateMm AND e.visitDateYy = t.visitDateYy AND e.seqNum = t.seqNum AND e.siteCode = '$site' AND e.encounterType IN (5, 18) AND t.drugID IN (13, 18, 24, 25, 30) AND t.dispensed = 1 AND e.visitDate BETWEEN '$rangeStart' AND '$endDate'");
  /* Don't count anyone who's been discontinued */
  dbQuery ("INSERT INTO " . $tempTableNames[2] . " SELECT DISTINCT patientid FROM discTable WHERE sitecode = '$site' AND discDate <= '$endDate'");

  $result = $repNum == "530" ? fetchFirstColumn(dbQuery("
SELECT DISTINCT e.patientID
FROM encValid e
LEFT JOIN " . $tempTableNames[1] . " t1 ON e.patientID = t1.patientID
LEFT JOIN " . $tempTableNames[2] . " t2 ON e.patientID = t2.patientID
WHERE e.siteCode = '$site'
 AND e.encounterType IN " . visitList ("hivQual") . "
 AND e.visitDate BETWEEN '$rangeStart' AND '$rangeEnd'
 AND t1.patientID IS NULL
 AND t2.patientID IS NULL
"))
:
  fetchFirstColumn(dbQuery("
SELECT e.patientID 
FROM encValid e
LEFT JOIN " . $tempTableNames[1] . " t1 ON e.patientID = t1.patientID
LEFT JOIN " . $tempTableNames[2] . " t2 ON e.patientID = t2.patientID
WHERE siteCode = '$site'
 AND e.encounterType IN (10, 15)
 AND t1.patientID IS NULL
 AND t2.patientID IS NULL
GROUP BY e.patientID 
HAVING MIN(e.visitDate) BETWEEN '$rangeStart' AND '$rangeEnd'"));
  dropTempTables ($tempTableNames);
  return $result;
}

function getInd6Num($repNum, $site, $intervalLength, $startDate, $endDate) {
  $threeDaysStart = dayDiff (-3, $startDate);
  $threeDaysEnd = dayDiff (-3, $endDate);

  $rangeStart = ($repNum == "530") ? $startDate : $threeDaysStart;
  $rangeEnd = ($repNum == "530") ? $endDate : $threeDaysEnd;

  // Need temp table to hold subquery results used in later joins
  $tempTableNames = createTempTables ("#ind6Num", 1, "patientID varchar(11)", "pat_idx::patientID");

  // Fill temp table with values to be used in later joins
  /* Count patients screened for TB symptoms */
  dbQuery ("INSERT INTO " . $tempTableNames[1] . " SELECT STRAIGHT_JOIN DISTINCT e.patientid FROM encValid e, tbStatus t WHERE e.patientID = t.patientID AND e.siteCode = t.siteCode AND e.visitDateDd = t.visitDateDd AND e.visitDateMm = t.visitDateMm AND e.visitDateYy = t.visitDateYy AND e.seqNum = t.seqNum AND e.siteCode = '$site' AND (t.noTBsymptoms = 1 OR t.asymptomaticTb = 1) AND e.encounterType IN (1, 2, 16, 17) AND e.visitDate BETWEEN '$rangeStart' AND '$endDate'");
  dbQuery ("INSERT INTO " . $tempTableNames[1] . " SELECT STRAIGHT_JOIN DISTINCT e.patientid FROM encValid e, obs t WHERE e.siteCode = t.location_id AND e.encounter_id = t.encounter_id AND e.siteCode = '$site' AND ((t.concept_id IN ('7000', '7001', '7002', '7003', '7004', '7005', '7006', '7007', '7008', '7009', '7010', '7011', '7012', '7013', '7014', '7015', '7016', '7017', '7018', '7019', '7020', '7021', '7022', '7023', '7024', '7025', '7026', '7027', '7028', '7029', '7023', '7033', '7034', '7035', '7036', '7037', '7038', '7042', '7043') AND t.value_boolean = 1) OR (t.concept_id IN ('7030', '7031', '7044') AND t.value_text IS NOT NULL)) AND e.encounterType IN (1, 2, 16, 17) AND e.visitDate BETWEEN '$rangeStart' AND '$endDate'");

  $result = $repNum == "530" ? fetchFirstColumn(dbQuery("
SELECT STRAIGHT_JOIN DISTINCT l.patientID
FROM encValid e, labs l
WHERE e.patientID = l.patientID
 AND e.siteCode = l.siteCode
 AND e.visitDateDd = l.visitDateDd
 AND e.visitDateMm = l.visitDateMm
 AND e.visitDateYy = l.visitDateYy
 AND e.seqNum = l.seqNum
 AND l.siteCode = '$site'
 AND ISNUMERIC(LTRIM(RTRIM(l.resultDateDd))) = 1
 AND ISNUMERIC(LTRIM(RTRIM(l.resultDateMm))) = 1
 AND ISNUMERIC(LTRIM(RTRIM(l.resultDateYy))) = 1
 AND isDate(dbo.ymdToDate(LTRIM(RTRIM(l.resultDateYy)),LTRIM(RTRIM(l.resultDateMm)),LTRIM(RTRIM(l.resultDateDd)))) = 1
 AND dbo.ymdToDate(LTRIM(RTRIM(l.resultDateYy)),LTRIM(RTRIM(l.resultDateMm)),LTRIM(RTRIM(l.resultDateDd))) BETWEEN '$rangeStart' AND '$endDate'
 AND l.labID IN (130, 172)
 AND
  ((l.result IS NOT NULL AND LTRIM(RTRIM(l.result)) != '') OR
   (l.result2 IS NOT NULL AND LTRIM(RTRIM(l.result2)) != '') OR
   (l.result3 IS NOT NULL AND LTRIM(RTRIM(l.result3)) != '') OR
   (l.result4 IS NOT NULL AND LTRIM(RTRIM(l.result4)) != '') OR
   (l.resultAbnormal IS NOT NULL AND l.resultAbnormal = 1))
UNION
SELECT DISTINCT patientID FROM " . $tempTableNames[1]))
:
  fetchFirstColumn(dbQuery("
SELECT STRAIGHT_JOIN DISTINCT l.patientID 
FROM v_labsCompleted l, encValid e 
WHERE l.siteCode = '$site'
 AND isDate(e.visitDate) = 1
 AND ISNUMERIC(LTRIM(RTRIM(l.resultDateDd))) = 1
 AND ISNUMERIC(LTRIM(RTRIM(l.resultDateMm))) = 1
 AND ISNUMERIC(LTRIM(RTRIM(l.resultDateYy))) = 1
 AND isDate(dbo.ymdToDate(LTRIM(RTRIM(l.resultDateYy)),LTRIM(RTRIM(l.resultDateMm)),LTRIM(RTRIM(l.resultDateDd)))) = 1
 AND dbo.ymdToDate(LTRIM(RTRIM(l.resultDateYy)),LTRIM(RTRIM(l.resultDateMm)),LTRIM(RTRIM(l.resultDateDd))) >= e.visitDate
 AND dbo.ymdToDate(LTRIM(RTRIM(l.resultDateYy)),LTRIM(RTRIM(l.resultDateMm)),LTRIM(RTRIM(l.resultDateDd))) <= '$endDate'
 AND l.labID IN (130, 172)
 AND l.patientID = e.patientID
 AND e.encounterType IN (10, 15)
 AND e.visitdate BETWEEN '$rangeStart' AND '$rangeEnd'" .
(strtotime ($startDate) >= strtotime (TB_SYMP_EVAL_DATE) ? "
UNION
SELECT DISTINCT patientID FROM " . $tempTableNames[1]
: "")));
  dropTempTables ($tempTableNames);
  return $result;
}


// Nutritional Assessment

function getInd7Den($repNum, $site, $intervalLength, $startDate, $endDate) {
  return fetchFirstColumn(dbQuery("
SELECT STRAIGHT_JOIN DISTINCT patientID 
FROM encValid 
WHERE siteCode = '$site'
 AND encounterType IN " . visitList ("hivQual") . "
 AND visitDate BETWEEN '$startDate' AND '$endDate'
 AND patientID NOT IN (SELECT patientid FROM discTable WHERE sitecode = '$site' AND discDate <= '$endDate')"));
}

function getInd7Num($repNum, $site, $intervalLength, $startDate, $endDate) {
  global $setupTableNames;

  $threeMonths = monthDiff(-3, $endDate);
  $sixMonths = monthDiff(-6, $endDate);

  // Make some temp tables to hold all the subquery results to use in
  // later joins (improves performance enormously)
  $tempTableNames = createTempTables ("#ind7Num", 2, "patientID varchar(11), visitDate date", "pat_visit_idx::patientID, visitDate");

  // Fill temp tables with values to be used in later joins
  dbQuery ("INSERT INTO " . $tempTableNames[1] . "
	SELECT patientID, MAX(visitDate) FROM v_vitals
        WHERE siteCode = '$site' AND
	( ISNUMERIC(REPLACE(LTRIM(RTRIM(vitalHeight)), ',', '.')) = 1 OR
	  ISNUMERIC(REPLACE(LTRIM(RTRIM(vitalHeightCm)), ',', '.')) = 1 )
	GROUP BY patientID");
  
  dbQuery ("INSERT INTO " . $tempTableNames[2] . "
	SELECT patientID, MAX(visitDate) FROM v_vitals
        WHERE siteCode = '$site' AND
	ISNUMERIC(REPLACE(LTRIM(RTRIM(vitalWeight)), ',', '.')) = 1 AND
	visitDate BETWEEN '$startDate' AND '$endDate'
	GROUP BY patientID");
	
  // Now run main query
  $result = fetchFirstColumn(dbQuery("
        SELECT DISTINCT t1.patientID FROM
	" . $tempTableNames[1] . " t1,
	" . $tempTableNames[2] . " t2,
	" . $setupTableNames[1] . " t3
	WHERE
	t1.patientID = t2.patientID AND
	t1.patientID = t3.patientID AND
	(
	  (t3.startDays >= 0 AND t3.startDays < 10 * " . DAYS_IN_YEAR . " AND
	   t2.visitDate BETWEEN '$threeMonths' AND '$endDate')
	  OR
	  (t3.startDays >= 10 * " . DAYS_IN_YEAR . "
           AND t3.startDays < 19 * " . DAYS_IN_YEAR . " AND
	   t2.visitDate BETWEEN '$sixMonths' AND '$endDate')
	  OR
           t3.startDays >= 19 * " . DAYS_IN_YEAR . "
        )"));

  dropTempTables ($tempTableNames);  
  return $result;
}


// Family Planning

function getInd8Den($repNum, $site, $intervalLength, $startDate, $endDate) {
  global $setupTableNames;

  $tempTableNames = createTempTables ("#ind8Den", 1, "patientID varchar(11)", "pat_idx::patientID");

  // Fill temp tables with values to be used in later joins
  dbQuery ("INSERT INTO " . $tempTableNames[1] . "
	SELECT DISTINCT patientID
        FROM discTable
        WHERE siteCode = '$site'
         AND discDate <= '$endDate'");
  
  $result = fetchFirstColumn(dbQuery("
SELECT e.patientID 
FROM encValid e, " . $setupTableNames[1] . " s1, patient p
 LEFT JOIN " . $tempTableNames[1] . " t1
 ON p.patientID = t1.patientID
WHERE p.patientID = s1.patientID
 AND p.patientID = e.patientID
 AND t1.patientID IS NULL
 AND p.sex = 1
 AND e.encounterType IN " . visitList ("hivQual") . "
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'
 AND s1.startDays >= 15 * " . DAYS_IN_YEAR . "
 AND s1.startDays < 50 * " . DAYS_IN_YEAR . "
GROUP BY 1 HAVING COUNT(e.visitDate) >= 1"));

  dropTempTables ($tempTableNames);  
  return $result;
}

function getInd8Num($repNum, $site, $intervalLength, $startDate, $endDate) {
  return fetchFirstColumn(dbQuery("
SELECT STRAIGHT_JOIN DISTINCT patientID 
FROM v_vitals 
WHERE siteCode = '$site'
 AND (famPlanMethodTubalLig = 1 OR famPlanMethodCondom = 1 OR famPlanMethodDmpa = 1 OR famPlanMethodOcPills = 1 OR (LTRIM(RTRIM(famPlanOtherText)) != ''
 AND famPlanOtherText IS NOT NULL))
 AND encounterType IN (1, 2) 
 AND visitdate BETWEEN '$startDate' AND '$endDate'"));
}


// PMTCT

function getEligDays ($repNum, $startDate) {
  if ($repNum == "530") {
    $eligDays = 98;
  } else if (($repNum == "504" || $repNum == "512") && strtotime ($startDate) >= strtotime (PMTCT_14_WEEKS_DATE)) {
    $eligDays = 98;
  } else {
    $eligDays = 196;
  }

  return ($eligDays);
}

function getInd9Den($repNum, $site, $intervalLength, $startDate, $endDate) {
  global $setupTableNames;
  $eligDays = getEligDays ($repNum, $startDate);

  // Make some temp tables to hold all the subquery results to use in
  // later joins (improves performance enormously)
  $tempTableNames = createTempTables ("#ind9Den", 4, array ("patientID varchar(11), maxDate date", "patientID varchar(11), reason varchar(255)", "patientID varchar(11), maxDate date", "patientID varchar(11), lmpDate date, eligDate date"), "pat_idx::patientID");

  fillPregnancyTable ($tempTableNames[1], $site, $startDate, $endDate, $setupTableNames[2]);

  /* For monthly, need to check for treatment eligibility too */
  if ($repNum == "530") {
    dbQuery ("INSERT INTO " . $tempTableNames[2] . " SELECT patientID, reason FROM eligibility WHERE LEFT(patientid, 5) = '$site' AND visitDate BETWEEN '$startDate' AND '$endDate' AND criteriaVersion " . (strtotime ($endDate) <= strtotime (CD4_350_DATE) ? "= 1" : (strtotime ($endDate) <= strtotime (OPTION_B_PLUS_DATE) ? "= 2" : "IN (2, 3)")));
    /* Need multiple copies to avoid "Can't reopen table" error */
    dbQuery ("INSERT INTO " . $tempTableNames[3] . " SELECT patientID, maxDate FROM " . $tempTableNames[1]);
    dbQuery ("INSERT INTO " . $tempTableNames[4] . " SELECT patientID, lmpDate, eligDate FROM " . $setupTableNames[2]);
  }

  /* Run denominator query and store results for computing numerator */
  $result = fetchFirstColumn(dbQuery("
SELECT DISTINCT e.patientID
FROM encValid e, " . $setupTableNames[2] . " t, " . $tempTableNames[1] . " x
WHERE t.patientID = e.patientID
 AND e.siteCode = '$site'
 AND e.encounterType IN " . visitList ("hivQual") . "
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'
 AND e.patientID = x.patientID
 AND e.patientID NOT IN
  (
   SELECT patientid
   FROM pepfarTable
   WHERE (forPepPmtct = 0 OR forPepPmtct IS NULL)
    AND visitDate < '$startDate'
  )
 AND e.patientID NOT IN
  (
   SELECT patientid
   FROM discTable
   WHERE sitecode = '$site'
    AND discDate <= '$endDate'
  )
 AND isDate(lmpDate) =  1
 AND dateDiff(dd,lmpDate, '$endDate') <= 322
 AND dateDiff(dd,lmpDate, '$endDate') >= $eligDays
" . ($repNum == "530" ? "
UNION
SELECT DISTINCT e.patientID
FROM encValid e, " . $tempTableNames[4] . " t, " . $tempTableNames[3] . " x, " . $tempTableNames[2] . " y
WHERE t.patientID = e.patientID
 AND e.siteCode = '$site'
 AND e.encounterType IN " . visitList ("hivQual") . "
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'
 AND e.patientID = x.patientID
 AND e.patientID = y.patientID
 AND e.patientID NOT IN
  (
   SELECT patientid
   FROM pepfarTable
   WHERE (forPepPmtct = 0 OR forPepPmtct IS NULL)
    AND visitDate < '$startDate'
  )
 AND e.patientID NOT IN
  (
   SELECT patientid
   FROM discTable
   WHERE sitecode = '$site'
    AND discDate <= '$endDate'
  )
 AND y.reason IN ('cd4LT200', 'tlcLT1200', 'eligByAge', 'eligByCond', 'eligPcr', 'WHOIII', 'WHOIII-2', 'WHOIIICond', 'WHOIV')
" : "")));

  dropTempTables ($tempTableNames);  
  return $result;
}

function getInd9Num($repNum, $site, $intervalLength, $startDate, $endDate) {
  global $setupTableNames;

  // If monthly, need temp tables to hold subquery results used in later joins
  if ($repNum == "530") {
    $tempTableNames = createTempTables ("#ind9Num", 2, array ("patientID varchar(11), reason varchar(255)", "patientID varchar(11), lmpDate date, eligDate date"), "pat_idx::patientID");

    // Fill temp tables with values to be used in later joins
    dbQuery ("INSERT INTO " . $tempTableNames[1] . " SELECT patientID, reason FROM eligibility WHERE LEFT(patientid, 5) = '$site' AND visitDate BETWEEN '$startDate' AND '$endDate' AND criteriaVersion " . (strtotime ($endDate) <= strtotime (CD4_350_DATE) ? "= 1" : (strtotime ($endDate) <= strtotime (OPTION_B_PLUS_DATE) ? "= 2" : "IN (2, 3)")));
    /* Need multiple copies to avoid "Can't reopen table" error */
    dbQuery ("INSERT INTO " . $tempTableNames[2] . " SELECT patientID, lmpDate, eligDate FROM " . $setupTableNames[2]);
  }

  $result = fetchFirstColumn(dbQuery("
SELECT DISTINCT p.patientID
FROM patient p, v_drugTable d, " . $setupTableNames[2] . " t
WHERE p.patientID = d.patientID
 AND p.patStatus = 0
 AND p.hivPositive = 1
 AND p.location_id = '$site'
 AND p.patientID = t.patientID
 AND isDate(t.eligDate) = 1
 AND d.drugGroup IN ('NRTIs', 'NNRTIs', 'Pls')
" . ($repNum == "530" ? "
 AND d.visitdate BETWEEN '$startDate' AND '$endDate'
UNION
SELECT DISTINCT p.patientID
FROM patient p, v_drugTable d, " . $tempTableNames[2] . " t1, " . $tempTableNames[1] . " t2
WHERE p.patientID = d.patientID
 AND p.patStatus = 0
 AND p.hivPositive = 1
 AND p.location_id = '$site'
 AND p.patientID = t1.patientID
 AND p.patientID = t2.patientID
 AND t2.reason IN ('cd4LT200', 'tlcLT1200', 'eligByAge', 'eligByCond', 'eligPcr', 'WHOIII', 'WHOIII-2', 'WHOIIICond', 'WHOIV')
 AND d.drugGroup IN ('NRTIs', 'NNRTIs', 'Pls')
 AND d.visitdate BETWEEN '$startDate' AND '$endDate'
" : "
 AND d.visitdate BETWEEN t.eligDate AND '$endDate'")));
  if ($repNum == "530") dropTempTables ($tempTableNames);
  return $result;
}


// Immunization

function getInd10Den($repNum, $site, $intervalLength, $startDate, $endDate) {
  return fetchFirstColumn(dbQuery("
SELECT patientID
FROM v_patients 
WHERE siteCode = '$site'
 AND encounterType IN " . visitList ("hivQual") . "
 AND visitDate BETWEEN '$startDate' AND '$endDate'
 AND patientID NOT IN (SELECT patientid FROM discTable WHERE sitecode = '$site' AND discDate <= '$endDate')
 AND ISNUMERIC(dobDd) = 1
 AND ISNUMERIC(dobMm) = 1
 AND ISNUMERIC(dobYy) = 1
 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, dobDd)) = 1
 AND FLOOR(DATEDIFF(dd, dbo.ymdToDate(dobYy, dobMm, dobDd), '$endDate')) BETWEEN 0 AND " . DAYS_IN_YEAR . " * 6
GROUP BY 1
HAVING COUNT(visitDate) >= 1"));
}

function getInd10Num($repNum, $site, $intervalLength, $startDate, $endDate) {
  /* get immunization data */
  // skip if immunization or birth date is invalid
  // store immunization data for later use if date is after dob
  $immArray = array ();
  $result = dbQuery ("SELECT patientID, immunizationID, ageDays, dobDd, dobMm, dobYy FROM (SELECT DISTINCT i.patientID, i.immunizationID, FLOOR(DATEDIFF(dd,dbo.ymdToDate(p.dobYy,p.dobMm,p.dobDd), dbo.ymdToDate(i.immunizationYy,i.immunizationMm,i.immunizationDd))) ageDays, dobDd, dobMm, dobYy FROM patient p, immunizations i WHERE p.patStatus = 0 AND p.hivPositive = 1 AND p.location_id = '$site' AND p.patientID = i.patientID AND ISNUMERIC(i.immunizationDd) = 1 AND ISNUMERIC(i.immunizationMm) = 1 AND ISNUMERIC(i.immunizationYy) = 1 AND ISDATE(dbo.ymdToDate(i.immunizationYy,i.immunizationMm,i.immunizationDd)) = 1 AND ISNUMERIC(p.dobDd) = 1 AND isnumeric(p.dobMm) = 1 AND ISNUMERIC(p.dobYy) = 1 AND ISDATE(dbo.ymdToDate(p.dobYy,p.dobMm,p.dobDd)) = 1 AND dbo.ymdToDate(i.immunizationYy,i.immunizationMm,i.immunizationDd) <= '$endDate') t WHERE ageDays BETWEEN 0 AND " . DAYS_IN_YEAR . " * 6");

  while ($row = psRowFetch ($result)) {
    $ageDays = $row[2];
    if ($ageDays < 0) continue;
    if ($row[1] == 7) $row[1] = 6; // Set Measles to ROR as they're equivalent
    if (isset ($immArray[$row[0]][$row[1]])) {
      array_push ($immArray[$row[0]][$row[1]], $ageDays);
    } else if (isset ($immArray[$row[0]])) {
      $immArray[$row[0]][$row[1]] = array ($ageDays);
    } else {
      $immArray[$row[0]] = array ($row[1] => array ($ageDays));
    }
  }
   
  if (DEBUG_FLAG) echo "<BR />Fetching exp. vs. inf.:  " . date ("Y-m-d H:i:s")  . "<BR />\n";
  /* Need to calculate exposed vs. infected asymptomatic vs. infected symptomatic at various ages */
  $hivStatus = array ();
  $symptomatic = array ();
  $result = dbQuery ("
SELECT STRAIGHT_JOIN DISTINCT p.patientID, v.pedCurrHiv,
 FLOOR(DATEDIFF(dd,dbo.ymdToDate(p.dobYy,p.dobMm,p.dobDd), e.visitDate)) ageDays
FROM encValid e, vitals v, patient p
WHERE e.siteCode = '$site'
 AND p.patientID = e.patientID
 AND v.patientID = e.patientID
 AND v.siteCode = e.siteCode
 AND v.visitDateYy = e.visitDateYy
 AND v.visitDateMm = e.visitDateMm
 AND v.visitDateDd = e.visitDateDd
 AND v.seqNum = e.seqNum
 AND v.pedCurrHiv >= 1
 AND ISNUMERIC(LTRIM(RTRIM(p.dobDd))) = 1
 AND ISNUMERIC(LTRIM(RTRIM(p.dobMm))) = 1
 AND ISNUMERIC(LTRIM(RTRIM(p.dobYy))) = 1
 AND ISDATE(dbo.ymdToDate(p.dobYy,p.dobMm,p.dobDd)) = 1
 AND e.visitDate <= '$endDate'
ORDER BY e.visitDate DESC");

  while ($row = psRowFetch ($result)) {
    $ageDays = $row[2];
    if ($ageDays < 0) continue;
    $status = ($row[1] == 1 ? "exp" : "inf");
    if (isset ($hivStatus[$row[0]][$status])) {
      array_push ($hivStatus[$row[0]][$status], $ageDays);
    } else if (isset ($hivStatus[$row[0]])) {
      $hivStatus[$row[0]][$status] = array ($ageDays);
    } else {
      $hivStatus[$row[0]] = array ($status => array ($ageDays));
    }
  }

  if (DEBUG_FLAG) echo "<BR />Fetching PCR tests:  " . date ("Y-m-d H:i:s")  . "<BR />\n";
  /* Also need results of PCR tests */
  $pcrNeg = array ();
  $pcr = array ();
  $result = dbQuery ("
SELECT DISTINCT v.patientID, v.result,
 FLOOR(DATEDIFF(dd,dbo.ymdToDate(p.dobYy, p.dobMm, p.dobDd), dbo.ymdToDate(LTRIM(RTRIM(v.resultDateYy)),LTRIM(RTRIM(v.resultDateMm)), LTRIM(RTRIM(v.resultDateDd))))) ageDays
FROM v_labsCompleted v, patient p
WHERE v.siteCode = '$site'
 AND v.labID = '181'
 AND v.result IN (1, 2)
 AND v.patientID = p.patientID
 AND ISNUMERIC(LTRIM(RTRIM(v.resultDateDd))) = 1
 AND ISNUMERIC(LTRIM(RTRIM(v.resultDateMm))) = 1
 AND ISNUMERIC(LTRIM(RTRIM(v.resultDateYy))) = 1
 AND ISNUMERIC(LTRIM(RTRIM(p.dobDd))) = 1
 AND ISNUMERIC(LTRIM(RTRIM(p.dobMm))) = 1
 AND ISNUMERIC(LTRIM(RTRIM(p.dobYy))) = 1
 AND ISDATE(dbo.ymdToDate(p.dobYy,p.dobMm,p.dobDd)) = 1
 AND ISDATE(dbo.ymdToDate(LTRIM(RTRIM(v.resultDateYy)),LTRIM(RTRIM(v.resultDateMm)),LTRIM(RTRIM(v.resultDateDd)))) = 1
 AND dbo.ymdToDate(LTRIM(RTRIM(v.resultDateYy)),LTRIM(RTRIM(v.resultDateMm)),LTRIM(RTRIM(v.resultDateDd))) <= '$endDate'");

  while ($row = psRowFetch ($result)) {
    $ageDays = $row[2];
    if ($ageDays < 0) continue;
    $res = ($row[1] == 1 ? "pos" : "neg");
    if (isset ($pcr[$row[0]][$res])) {
      array_push ($pcr[$row[0]][$res], $ageDays);
    } else if (isset ($pcr[$row[0]])) {
      $pcr[$row[0]][$res] = array ($ageDays);
    } else {
      $pcr[$row[0]] = array ($res => array ($ageDays));
    }
    
    if ($res == "neg") {
      if (isset ($pcrNeg[$row[0]])) {
        if ($ageDays < $pcrNeg[$row[0]])
          $pcrNeg[$row[0]] = $ageDays;
      } else {
        $pcrNeg[$row[0]] = $ageDays;
      }
    }
  }

  if (DEBUG_FLAG) echo "<BR />Fetching symp. vs. asymp. (concepts):  " . date ("Y-m-d H:i:s")  . "<BR />\n";
  $result = dbQuery ("
SELECT STRAIGHT_JOIN DISTINCT p.patientID, o.concept_id,
 FLOOR(DATEDIFF(dd,dbo.ymdToDate(p.dobYy,p.dobMm,p.dobDd), e.visitDate)) ageDays
FROM encValid e, obs o, patient p
WHERE e.siteCode = '$site'
 AND p.patientID = e.patientID
 AND o.encounter_id = e.encounter_id
 AND o.location_id = e.siteCode
 AND o.concept_id IN ('7002', '7010', '7020', '7021', '7022')
 AND o.value_boolean = 1
 AND ISNUMERIC(LTRIM(RTRIM(p.dobDd))) = 1
 AND ISNUMERIC(LTRIM(RTRIM(p.dobMm))) = 1
 AND ISNUMERIC(LTRIM(RTRIM(p.dobYy))) = 1
 AND ISDATE(dbo.ymdToDate(p.dobYy,p.dobMm,p.dobDd)) = 1
 AND e.visitDate <= '$endDate'");

  while ($row = psRowFetch ($result)) {
    $ageDays = $row[2];
    if ($ageDays < 0) continue;
    $symp = ($row[1] == "7002" ? "asymp" : "symp");
    if (isset ($symptomatic[$row[0]][$symp])) {
      array_push ($symptomatic[$row[0]][$symp], $ageDays);
    } else if (isset ($symptomatic[$row[0]])) {
      $symptomatic[$row[0]][$symp] = array ($ageDays);
    } else {
      $symptomatic[$row[0]] = array ($symp => array ($ageDays));
    }
  }

  if (DEBUG_FLAG) echo "<BR />Fetching symp. vs. asymp. (medEligArvs):  " . date ("Y-m-d H:i:s")  . "<BR />\n";
  $result = dbQuery ("
SELECT STRAIGHT_JOIN DISTINCT p.patientID, t.currentHivStage,
 FLOOR(DATEDIFF(dd,dbo.ymdToDate(p.dobYy,p.dobMm,p.dobDd), e.visitDate)) ageDays
FROM encValid e, medicalEligARVs t, patient p
WHERE e.siteCode = '$site'
 AND p.patientID = e.patientID
 AND e.patientID = t.patientID
 AND e.siteCode = t.siteCode
 AND e.visitDateDd = t.visitDateDd
 AND e.visitDateMm = t.visitDateMm
 AND e.visitDateYy = t.visitDateYy
 AND e.seqNum = t.seqNum
 AND t.currentHivStage >= 1
 AND ISNUMERIC(LTRIM(RTRIM(p.dobDd))) = 1
 AND ISNUMERIC(LTRIM(RTRIM(p.dobMm))) = 1
 AND ISNUMERIC(LTRIM(RTRIM(p.dobYy))) = 1
 AND ISDATE(dbo.ymdToDate(p.dobYy,p.dobMm,p.dobDd)) = 1
 AND e.visitDate <= '$endDate'");

  while ($row = psRowFetch ($result)) {
    $ageDays = $row[2];
    if ($ageDays < 0) continue;
    $symp = ($row[1] == 1 ? "asymp" : "symp");
    if (isset ($symptomatic[$row[0]][$symp])) {
      array_push ($symptomatic[$row[0]][$symp], $ageDays);
    } else if (isset ($symptomatic[$row[0]])) {
      $symptomatic[$row[0]][$symp] = array ($ageDays);
    } else {
      $symptomatic[$row[0]] = array ($symp => array ($ageDays));
    }
  }

  if (DEBUG_FLAG) echo "<BR />Starting main loop:  " . date ("Y-m-d H:i:s")  . "<BR />\n";
  /* store all patients immunized at the proper times based on status and age */
  $tmpArray = array ();
  $result = dbQuery ("
SELECT patientID, FLOOR(DATEDIFF(dd, dbo.ymdToDate(dobYy,dobMm,dobDd), '$endDate')) ageDays, DATEADD(yy, 1, dbo.ymdToDate(dobYy, dobMm, dobDd)) oneYear, DATEADD(mm, 15, dbo.ymdToDate(dobYy, dobMm, dobDd)) fifteenMonths
FROM v_patients
WHERE siteCode = '$site'
 AND encounterType IN " . visitList ("hivQual") . "
 AND visitDate BETWEEN '$startDate' AND '$endDate'
 AND patientID NOT IN (SELECT patientid FROM discTable WHERE sitecode = '$site'
AND discDate <= '$endDate')
 AND ISNUMERIC(dobDd) = 1
 AND ISNUMERIC(dobMm) = 1
 AND ISNUMERIC(dobYy) = 1
 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, dobDd)) = 1
 AND FLOOR(DATEDIFF(dd, dbo.ymdToDate(dobYy, dobMm, dobDd), '$endDate')) BETWEEN 0 AND " . DAYS_IN_YEAR . " * 6
GROUP BY 1
HAVING COUNT(visitDate) >= 1");

  while ($row = psRowFetch ($result)) {
    $ageDays = $row[1];
    $dateAtOneYear = $row[2];
    $dateAtFifteenMonths = $row[3];

    if ($repNum == "530" || (($repNum == "504" || $repNum == "512") && strtotime ($startDate) >= strtotime (IMM_2009_DATE))) {
      // count patient if immunized according to schedule for age
      if ($ageDays >= 0 &&
          immunCheck (1, $row[0], $ageDays, $hivStatus[$row[0]], $immArray[$row[0]], null, $pcr[$row[0]]) &&
          immunCheck (3, $row[0], $ageDays, $hivStatus[$row[0]], $immArray[$row[0]], $symptomatic[$row[0]], $pcr[$row[0]]) &&
          immunCheck (4, $row[0], $ageDays, $hivStatus[$row[0]], $immArray[$row[0]], null, $pcr[$row[0]]) &&
          immunCheck (6, $row[0], $ageDays, $hivStatus[$row[0]], $immArray[$row[0]], $symptomatic[$row[0]], $pcr[$row[0]])) {
        if ($repNum == "530") { // Additional vaccinations for monthly report
          if (immunCheck (2, $row[0], $ageDays, $hivStatus[$row[0]], $immArray[$row[0]], null, $pcr[$row[0]]) &&
              immunCheck (5, $row[0], $ageDays, $hivStatus[$row[0]], $immArray[$row[0]], null, $pcr[$row[0]])) {
            // Good
            if (!in_array ($row[0], $tmpArray)) {
              array_push ($tmpArray, $row[0]);
              continue;
            }
          }
        }
        // Good
        if (!in_array ($row[0], $tmpArray)) array_push ($tmpArray, $row[0]);
      }
    } else {
      if ($ageDays >= 0) {
        if ((isset ($hivStatus[$row[0]]["exp"]) && valInRange ($hivStatus[$row[0]]["exp"], 0, 15) && (!isset ($hivStatus[$row[0]]["inf"]) || (isset ($hivStatus[$row[0]]["inf"]) && !valInRange ($hivStatus[$row[0]]["inf"], 0, 15))) && isset ($immArray[$row[0]][1]) && valInRange ($immArray[$row[0]][1], 0, 15) && isset ($immArray[$row[0]][3]) && valInRange ($immArray[$row[0]][3], 0, 15) && isset ($pcrNeg[$row[0]])) || (((isset ($hivStatus[$row[0]]["inf"]) && valInRange ($hivStatus[$row[0]]["inf"], 0, 15)) || !isset ($pcrNeg[$row[0]])) && !isset ($immArray[$row[0]][1]))) {
          if ($ageDays >= 45) {
            if ((((isset ($hivStatus[$row[0]]["exp"]) && valInRange ($hivStatus[$row[0]]["exp"], 0, 60)) || (isset ($hivStatus[$row[0]]["inf"]) && valInRange ($hivStatus[$row[0]]["inf"], 0, 60))) && isset($immArray[$row[0]][4]) && valInRange ($immArray[$row[0]][4], 45, 60)) && (((isset ($hivStatus[$row[0]]["exp"]) && valInRange ($hivStatus[$row[0]]["exp"], 0, 60)) || (isset ($hivStatus[$row[0]]["inf"]) && valInRange ($hivStatus[$row[0]]["inf"], 0, 60))) && isset ($immArray[$row[0]][3]) && valInRange ($immArray[$row[0]][3], 45, 60))) {
              if ($ageDays >= 75) {
                if ((((isset ($hivStatus[$row[0]]["exp"]) && valInRange ($hivStatus[$row[0]]["exp"], 0, 90)) || (isset ($hivStatus[$row[0]]["inf"]) && valInRange ($hivStatus[$row[0]]["inf"], 0, 90))) && isset($immArray[$row[0]][4]) && valInRange ($immArray[$row[0]][4], 75, 90)) && (((isset ($hivStatus[$row[0]]["exp"]) && valInRange ($hivStatus[$row[0]]["exp"], 0, 90)) || (isset ($hivStatus[$row[0]]["inf"]) && valInRange ($hivStatus[$row[0]]["inf"], 0, 90))) && isset ($immArray[$row[0]][3]) && valInRange ($immArray[$row[0]][3], 75, 90))) {
                  if ($ageDays >= 105) {
                    if ((((isset ($hivStatus[$row[0]]["exp"]) && valInRange ($hivStatus[$row[0]]["exp"], 0, 120)) || (isset ($hivStatus[$row[0]]["inf"]) && valInRange ($hivStatus[$row[0]]["inf"], 0, 120))) && isset($immArray[$row[0]][4]) && valInRange ($immArray[$row[0]][4], 105, 120)) && (((isset ($hivStatus[$row[0]]["exp"]) && valInRange ($hivStatus[$row[0]]["exp"], 0, 120)) || (isset ($hivStatus[$row[0]]["inf"]) && valInRange ($hivStatus[$row[0]]["inf"], 0, 120))) && isset ($immArray[$row[0]][3]) && valInRange ($immArray[$row[0]][3], 105, 120))) {
                      if ($ageDays >= 270) {
                        // exclude WHO Stage IV patients
                        $exclude = 0;
                        $result2 = dbQuery ("SELECT patientid FROM eligibility WHERE patientid = '$row[0]' AND reason IN ('WHOIV') AND visitdate <= '$dateAtOneYear' AND criteriaVersion " . (strtotime ($endDate) <= strtotime (CD4_350_DATE) ? "= 1" : (strtotime ($endDate) <= strtotime (OPTION_B_PLUS_DATE) ? "= 2" : "IN (2, 3)")));
                        if ($row2 = psRowFetch ($result2)) {
                          $exclude = 1;
                        }
                        if ((((isset ($hivStatus[$row[0]]["exp"]) && valInRange ($hivStatus[$row[0]]["exp"], 0, 365) && (!isset ($hivStatus[$row[0]]["inf"]) || (isset ($hivStatus[$row[0]]["inf"]) && !valInRange ($hivStatus[$row[0]]["inf"], 0, 365)))) || (isset ($hivStatus[$row[0]]["inf"]) && valInRange ($hivStatus[$row[0]]["inf"], 0, 365) && !$exclude)) && (isset ($immArray[$row[0]][6]) && valInRange ($immArray[$row[0]][6], 270, 365))) || (isset ($hivStatus[$row[0]]["inf"]) && valInRange ($hivStatus[$row[0]]["inf"], 0, 365) && $exclude && !isset ($immArray[$row[0]][6]))) {
                          if ($ageDays >= 365) {
                            // exclude WHO Stage IV patients
                            $exclude = 0;
                            $result2 = dbQuery ("SELECT patientid FROM eligibility WHERE patientid = '$row[0]' AND reason IN ('WHOIV') AND visitdate <= '$dateAtFifteenMonths' AND criteriaVersion " . (strtotime ($endDate) <= strtotime (CD4_350_DATE) ? "= 1" : (strtotime ($endDate) <= strtotime (OPTION_B_PLUS_DATE) ? "= 2" : "IN (2, 3)")));
                            if ($row2 = psRowFetch ($result2)) {
                              $exclude = 1;
                            }
                            if ((((isset ($hivStatus[$row[0]]["exp"]) && valInRange ($hivStatus[$row[0]]["exp"], 0, 450) && (!isset ($hivStatus[$row[0]]["inf"]) || (isset ($hivStatus[$row[0]]["inf"]) && !valInRange ($hivStatus[$row[0]]["inf"], 0, 450)))) || (isset ($hivStatus[$row[0]]["inf"]) && valInRange ($hivStatus[$row[0]]["inf"], 0, 450) && !$exclude)) && (isset ($immArray[$row[0]][6]) && valInRange ($immArray[$row[0]][6], 365, 450))) || (isset ($hivStatus[$row[0]]["inf"]) && valInRange ($hivStatus[$row[0]]["inf"], 0, 450) && $exclude && (!isset ($immArray[$row[0]][6]) || (isset ($immArray[$row[0]][6]) && !valInRange ($immArray[$row[0]][6], 365, 2192))))) {
                              if ($ageDays >= 540) {
                                if ((((isset ($hivStatus[$row[0]]["exp"]) && valInRange ($hivStatus[$row[0]]["exp"], 0, 555)) || (isset ($hivStatus[$row[0]]["inf"]) && valInRange ($hivStatus[$row[0]]["inf"], 0, 555))) && isset($immArray[$row[0]][4]) && valInRange ($immArray[$row[0]][4], 540, 555)) && (((isset ($hivStatus[$row[0]]["exp"]) && valInRange ($hivStatus[$row[0]]["exp"], 0, 555)) || (isset ($hivStatus[$row[0]]["inf"]) && valInRange ($hivStatus[$row[0]]["inf"], 0, 555))) && isset ($immArray[$row[0]][3]) && valInRange ($immArray[$row[0]][3], 540, 555))) {
                                  if (!in_array ($row[0], $tmpArray)) array_push ($tmpArray, $row[0]);
                                }
                              } else {
                                if (!in_array ($row[0], $tmpArray)) array_push ($tmpArray, $row[0]);
                              }
                            }
                          } else {
                            if (!in_array ($row[0], $tmpArray)) array_push ($tmpArray, $row[0]);
                          }
                        }
                      } else {
                        if (!in_array ($row[0], $tmpArray)) array_push ($tmpArray, $row[0]);
                      }
                    }
                  } else {
                    if (!in_array ($row[0], $tmpArray)) array_push ($tmpArray, $row[0]);
                  }
                }
              } else {
                if (!in_array ($row[0], $tmpArray)) array_push ($tmpArray, $row[0]);
              }
            }
          } else {
            if (!in_array ($row[0], $tmpArray)) array_push ($tmpArray, $row[0]);
          }
        }
      }
    }
  }
 
  return $tmpArray;
}

function immunCheck ($immId, $pid, $ageDays, $hivStatus, $immArray, $symptomatic = null, $pcr = null) {
  // Calculate if child is infected & symptomatic at end of report period
  $immunSymp = immunSymp ($hivStatus, $symptomatic, $pcr, $ageDays);

  if (DEBUG_FLAG) {
    echo "<BR />Checking patient $pid, age $ageDays, immunSymp $immunSymp, hivStatus: ";
    if (isset ($hivStatus["exp"])) sort ($hivStatus["exp"]);
    if (isset ($hivStatus["inf"])) sort ($hivStatus["inf"]);
    print_r ($hivStatus);
    echo ", immunizations: ";
    print_r ($immArray);
    if (isset ($symptomatic)) {
      echo ", symptomatic: ";
      if (isset ($symptomatic["symp"])) sort ($symptomatic["symp"]);
      if (isset ($symptomatic["asymp"])) sort ($symptomatic["asymp"]);
      print_r ($symptomatic);
    }
    if (isset ($pcr)) {
      echo ", PCR: ";
      if (isset ($pcr["pos"])) sort ($pcr["pos"]);
      if (isset ($pcr["neg"])) sort ($pcr["neg"]);
      print_r ($pcr);
    }
    echo "<BR />\n";
  }

  switch ($immId) {
    case 1: // BCG
      if (isset ($immArray[$immId])) {
        sort ($immArray[$immId]);
      }
      if (isset ($pcr["neg"])) {
        sort ($pcr["neg"]);
      }
      if (DEBUG_FLAG) echo count ($immArray[$immId]) . " doses of BCG<BR />\n";
      if (
          (
           isset ($pcr["neg"]) &&
           !isset ($pcr["pos"]) &&
           isset ($immArray[$immId]) &&
           $immArray[$immId][0] >= $pcr["neg"][0]
          ) ||
          (
           !isset ($pcr["neg"]) &&
           !isset ($immArray[$immId])
          )
         ) { if (DEBUG_FLAG) echo "Passed BCG<BR />\n"; return true; }
      else { if (DEBUG_FLAG) echo "Failed BCG<BR />\n"; return false; }
      break;
    case 2: // Hep B
      if (DEBUG_FLAG) echo count ($immArray[$immId]) . " doses of HepB<BR />\n";
      if (($ageDays < 30 && count ($immArray[$immId]) >= 1) ||
          ($ageDays >= 30 && $ageDays < 180 && count ($immArray[$immId]) >= 2) ||
          ($ageDays >= 180 && count ($immArray[$immId]) >= 3)) {
        if (DEBUG_FLAG) echo "Passed HepB<BR />\n";
        return true;
      } else {
        if (DEBUG_FLAG) echo "Failed HepB<BR />\n";
        return false;
      }
      break;
    case 3: // Polio
      if (DEBUG_FLAG) echo count ($immArray[$immId]) . " doses of Polio<BR />\n";
      if (($ageDays < 42 && count ($immArray[$immId]) == 0) ||
          ($ageDays >= 42 && $ageDays < 70 && count ($immArray[$immId]) >= 1 && !$immunSymp) ||
          ($ageDays >= 70 && $ageDays < 98 && count ($immArray[$immId]) >= 2 && !$immunSymp) ||
          ($ageDays >= 98 && count ($immArray[$immId]) >= 3 && !$immunSymp) ||
          ($ageDays >= 42 && count ($immArray[$immId]) == 0 && $immunSymp)) {
        if (DEBUG_FLAG) echo "Passed Polio<BR />\n";
        return true;
      } else {
        if (DEBUG_FLAG) echo "Failed Polio<BR />\n";
        return false;
      }
      break;
    case 4: // DTP
    case 5: // HIB
      if (DEBUG_FLAG) echo count ($immArray[$immId]) . " doses of DTP/HIB<BR />\n";
      if (($ageDays < 42 && count ($immArray[$immId]) == 0) ||
          ($ageDays >= 42 && $ageDays < 70 && count ($immArray[$immId]) >= 1) ||
          ($ageDays >= 70 && $ageDays < 98 && count ($immArray[$immId]) >= 2) ||
          ($ageDays >= 98 && count ($immArray[$immId]) >= 3)) {
        if (DEBUG_FLAG) echo "Passed DTP/HIB<BR />\n";
        return true;
      } else {
        if (DEBUG_FLAG) echo "Failed DTP/HIB<BR />\n";
        return false;
      }
      break;
    case 6: // ROR
    case 7: // Measles
      if (DEBUG_FLAG) echo count ($immArray[$immId]) . " doses of ROR<BR />\n";
      if (($ageDays < DAYS_IN_YEAR && count ($immArray[$immId]) == 0) ||
          ($ageDays >= DAYS_IN_YEAR && count ($immArray[$immId]) >= 1 && !$immunSymp) ||
          ($ageDays >= DAYS_IN_YEAR && count ($immArray[$immId]) == 0 && $immunSymp)) {
        if (DEBUG_FLAG) echo "Passed ROR<BR />\n";
        return true;
      } else {
        if (DEBUG_FLAG) echo "Failed ROR<BR />\n";
        return false;
      }
      break;
    default:
      if (DEBUG_FLAG) echo "Unknown id $immId<BR />\n";
      return false;
      break;
  }
}

function immunSymp ($hivStatus, $symptomatic, $pcr, $ageDays) {
  // Return true if kid was infected and symptomatic at given age
  $symp = false;
  $inf = true;
  $answer = false;
  $maxSymp = maxValLimit ($symptomatic["symp"], $ageDays);
  $maxAsymp = maxValLimit ($symptomatic["asymp"], $ageDays);
  $maxInf = maxValLimit ($hivStatus["inf"], $ageDays);
  $maxExp = maxValLimit ($hivStatus["exp"], $ageDays);
  $maxPos = maxValLimit ($pcr["pos"], $ageDays);
  $maxNeg = maxValLimit ($pcr["neg"], $ageDays);
  if (($maxExp > $maxInf && ($maxNeg > $maxPos || ($maxPos >= $maxNeg && $maxPos != -1 && $maxExp > $maxPos))) ||
      ($maxInf >= $maxExp && $maxInf != -1 && $maxInf < $maxNeg && $maxNeg > $maxPos) ||
      ($maxExp == -1 && maxInf == -1 && $maxNeg > $maxPos)) $inf = false;

  if ($maxSymp >= $maxAsymp && $maxSymp != -1) $symp = true;

  if ($inf && $symp) {
    $answer = true;
  }
  return ($answer);
}

function getPatientDetail($tmpNum, $lang) {
  $patientArr = array();
  
  if (count($tmpNum) > 0) {
    $patientIds  = "(";
    foreach ($tmpNum as $id) {
      $patientIds .= "'" . $id . "',";
    }
    $patientIds = substr($patientIds,0,strlen($patientIds)-1);
    $patientIds .= ")";
    $result = dbQuery ("SELECT clinicPatientID, fname, lname from patient where patientID in " . $patientIds . " order by clinicPatientID");
    
    while ($row = psRowFetch ($result)) {
      array_push ($patientArr,array($row[0],$row[1],$row[2]));
    }
  }
  
  return $patientArr;
}

?>
