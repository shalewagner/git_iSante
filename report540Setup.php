<?php
require_once 'backend/sharedRptFunctions.php';

$username = ereg_replace ('[^A-Za-z0-9]', '', getSessionUser());

// relevant data for the syndromes we're interested in
$syndromes = array (
  array (
    "label" => $report540Labels[$lang][2],
    "concepts" => "('70882')",
    "conditions" => "('')"
  ),
  array (
    "label" => $report540Labels[$lang][3],
    "concepts" => "('70320')",
    "conditions" => "('205')" 
  ),
  array (
    "label" => $report540Labels[$lang][4],
    "concepts" => "('70296')",
    "conditions" => "('')" 
  ),
  array (
    "label" => $report540Labels[$lang][5],
    "concepts" => "('70201')",
    "conditions" => "('')" 
  ),
  array (
    "label" => $report540Labels[$lang][6],
    "concepts" => "('70339')",
    "conditions" => "('47')" 
  ),
  array (
    "label" => $report540Labels[$lang][7],
    "concepts" => "('70336')",
    "conditions" => "('')" 
  ),
  array (
    "label" => $report540Labels[$lang][8],
    "concepts" => "('70850', '71148')",
    "conditions" => "('45', '335', '716')" 
  ),
  array (
    "label" => $report540Labels[$lang][9],
    "concepts" => "('71149')",
    "conditions" => "('717')", 
  ),
  array (
    "label" => $report540Labels[$lang][10],
    "concepts" => "('70292')",
    "conditions" => "('')" 
  ),
  array (
    "label" => $report540Labels[$lang][11],
    "concepts" => "('70246')",
    "conditions" => "('')" 
  ),
  array (
    "label" => $report540Labels[$lang][12],
    "concepts" => "('70342')",
    "conditions" => "('')" 
  ),
  array (
    "label" => $report540Labels[$lang][13],
    "concepts" => "('70258')",
    "conditions" => "('')" 
  ),
  array (
    "label" => $report540Labels[$lang][14],
    "concepts" => "('70261')",
    "conditions" => "('')" 
  ),
  array (
    "label" => $report540Labels[$lang][15],
    "concepts" => "('70302')",
    "conditions" => "('50')" 
  ),
  array (
    "label" => $report540Labels[$lang][16],
    "concepts" => "('70289')",
    "conditions" => "('')" 
  ),
  array (
    "label" => $report540Labels[$lang][17],
    "concepts" => "('70308')",
    "conditions" => "('9', '403')" 
  ),
  array (
    "label" => $report540Labels[$lang][18],
    "concepts" => "('70351', '71224', '71271')",
    "conditions" => "('20', '21', '41', '208', '405', '409', '423')" 
  ),
  array (
    "label" => $report540Labels[$lang][19],
    "concepts" => "('70348', '70855')",
    "conditions" => "('')" 
  ),
  array (
    "label" => $report540Labels[$lang][20],
    "concepts" => "('70279')",
    "conditions" => "('')" 
  ),
  array (
    "label" => $report540Labels[$lang][21],
    "concepts" => "('7209', '70057', '70066', '70067', '70069', '70078', '70082', '70084', '70086', '70087', '70103')",
    "conditions" => "('439', '713')"
  ),
  array (
    "label" => $report540Labels[$lang][22],
    "concepts" => "",
    "conditions" => ""
  )
);

$final_tally = array ();

// run backwards for weekly periods until the end date of a period is
// earlier than the given start date, first pick the Saturday prior
// to the supplied end date
$endDate = dayDiff (0 - ((1 + date ("w", strtotime ($_REQUEST["end"]))) % 7), $_REQUEST["end"]);

// compute how many weeks we'll be running in order to create final output table
$endDateCopy = $endDate;
$numWeeks = 0;
$repeatCols = "";
while (strtotime ($endDateCopy) >= strtotime ($_REQUEST["start"])) {
  $repeatCols .= ", boys$numWeeks int unsigned null, girls$numWeeks int unsigned null, men$numWeeks int unsigned null, women$numWeeks int unsigned null, total$numWeeks int unsigned null";
  $numWeeks++;
  $endDateCopy = dayDiff (-7, $endDateCopy);
}

// setup temp table to hold final counts
$finalTemp = createTempTables ("tempRpt540", 1, "syndrome varchar(255), site varchar(255) $repeatCols, grandTotal int unsigned null", "main_idx::site, syndrome");
$tblNames[] = $finalTemp[1];

// more temp tables
$tempTableNames = createTempTables ("#temp540Calc", 3, array ("patientID varchar(11), maxDate date", "patientID varchar(11), lmpDate date, eligDate date", "patientID varchar(11), startDays mediumint, endDays mediumint"), "pat_idx::patientID");

// compute which sites to use
$groupOrder = array ();
if ($_REQUEST["groupLevel"] > 2) {
  switch ($_REQUEST["groupLevel"]) {
    case 3:
      $queryCol = "commune";
      break;
    case 4:
      $queryCol = "department";
      break;
    default:
      $queryCol = "network";
      break;
  }
  if ($_REQUEST["ddValue"] == "All") {
    $orderCol = $queryCol;
    $queryCol = "siteCode";
    $queryComp = " LIKE ? ";
    $queryParams = array ("%");
  } else {
    $queryComp = " = ? ";
    $queryParams = array ($_REQUEST["ddValue"]);
    $orderCol = $queryCol;
  }
  $orderClause = "ORDER BY $orderCol, clinic";

  // get sites
  $result = database()->query ("
    SELECT c1.siteCode
    FROM clinicLookup c1, clinicLookup c2
    WHERE c1.inCPHR = 1
     AND c1.$queryCol = c2.$queryCol
     AND c2.siteCode " . $queryComp, $queryParams);
  while ($row = $result->fetch()) {
    $sites[] = $row['siteCode'];
  }

  // get group order
  $result = database()->query ("
    SELECT siteCode
    FROM clinicLookup
    WHERE inCPHR = 1
    $orderClause");
  while ($row = $result->fetch()) {
    $groupOrder[] = $row['siteCode'];
  }
} else {
  $sites = explode (",", $_REQUEST["site"]);

  // get group order, if multiple sites
  if (count ($sites) > 1) {
    $result = database()->query ("
      SELECT siteCode
      FROM clinicLookup
      WHERE inCPHR = 1
      ORDER BY clinic");
    while ($row = $result->fetch()) {
      $groupOrder[] = $row['siteCode'];
    }
  }
}

// hold list of sites that have data per syndrome
$hasData = array ();

// hold list of patients already counted (only one diagnosis per patient)
$counted = array ();

while (strtotime ($endDate) >= strtotime ($_REQUEST["start"])) {
  $startDate = dayDiff (-6, $endDate);
  $endDates[] = $endDate;
  $counted[$endDate] = array ();

  // clean out temp tables
  foreach ($tempTableNames as $name) {
    dbQuery ("TRUNCATE TABLE $name");
  }

  fillLmpTable ($tempTableNames[2], $sites, $endDate, (strtotime ($startDate) >= strtotime (PMTCT_14_WEEKS_DATE) ? 98 : 196));
  fillPregnancyTable ($tempTableNames[1], $sites, $startDate, $endDate, $tempTableNames[2]);
  fillPidAgeTable ($tempTableNames[3], $sites, $startDate, $endDate);

  // run queries for syndromes
  foreach ($syndromes as $key => $syndrome) {
    $synLabel = $syndrome["label"];

    // special case - new patients w/ other conditions
    if ($key == 20) {
      $result = dbQuery ("
        SELECT p.patientID,
         CASE WHEN a.startDays BETWEEN 0 AND 5 * " . DAYS_IN_YEAR . " - 1
          AND p.sex = 2 THEN 'boy'
          WHEN a.startDays >= 5 * " . DAYS_IN_YEAR . " AND p.sex = 2 THEN 'man'
          WHEN a.startDays BETWEEN 0 AND 5 * " . DAYS_IN_YEAR . " - 1
          AND p.sex = 1 THEN 'girl'
          WHEN a.startDays >= 5 * " . DAYS_IN_YEAR . " AND p.sex = 1 THEN 'woman'
          ELSE 'unknown'
         END AS ageGroup
        FROM patient p, " . $tempTableNames[3] . " a, encValidAll e
        WHERE p.patientID = a.patientID
         AND p.patientID = e.patientID
         AND p.patStatus = 0
         AND e.encounterType IN " . visitList ("registrations") . "
         AND e.visitDate BETWEEN '$startDate' AND '$endDate'");
    } else {
      $incidenceTable = setupIncidenceTable ($sites, $startDate, $endDate, $username, $syndrome["concepts"], $syndrome["conditions"]);

      // special case - 3rd trimester preg. or preg. complications
      if ($key == 19) {
        // need temp table to hold preg. complications incidence
        if (is_array ($sites)) {
          $siteList = implode (',', $sites);
        } else {
          $siteList = $sites;
        }
        $siteList = "(" . $siteList . ")";
        $pregCompTables = createTempTables ("#tempPregComp", 1, "patientID varchar(11), visitDate date", "pat_idx::patientID");
        dbQuery ("INSERT INTO " . $pregCompTables[1] . "
              SELECT e.patientID, MIN(e.visitDate)
              FROM encValidAll e, obs o
              WHERE e.siteCode IN $siteList
               AND e.siteCode = o.location_id
               AND
                (
                 (
                  o.value_numeric = 1
                  OR o.value_text = 1
                 )
                 AND o.concept_id = '7828'
                )
               AND e.encounter_id = o.encounter_id
               AND e.encounterType = 26
               AND e.visitDate BETWEEN '$startDate' AND '$endDate'
              GROUP BY 1");
      }

      $result = dbQuery ("
        SELECT p.patientID,
         CASE WHEN a.startDays BETWEEN 0 AND 5 * " . DAYS_IN_YEAR . " - 1
          AND p.sex = 2 THEN 'boy'
          WHEN a.startDays >= 5 * " . DAYS_IN_YEAR . " AND p.sex = 2 THEN 'man'
          WHEN a.startDays BETWEEN 0 AND 5 * " . DAYS_IN_YEAR . " - 1
          AND p.sex = 1 THEN 'girl'
          WHEN a.startDays >= 5 * " . DAYS_IN_YEAR . " AND p.sex = 1 THEN 'woman'
          ELSE 'unknown'
         END AS ageGroup
        FROM " . $tempTableNames[3] . " a, patient p" . ($key == 19 ? " LEFT JOIN " . $incidenceTable[1] . " i ON p.patientID = i.patientID LEFT JOIN " .  $tempTableNames[1] . " t1 ON p.patientID = t1.patientID LEFT JOIN " . $tempTableNames[2] . " t2 ON p.patientID = t2.patientID LEFT JOIN " . $pregCompTables[1] . " t3 ON p.patientID = t3.patientID" : ", " . $incidenceTable[1] . " i") . "
        WHERE p.patientID = a.patientID
         AND p.patStatus = 0
         AND " . ($key == 19 ? "(" : "") . "p.patientID = i.patientID
         " . ($key == 19 ? "
         OR
          (
           p.patientID = t1.patientID
           AND '$endDate' BETWEEN DATEADD(dd, 196, t2.lmpDate) AND DATEADD(dd, 308, t2.lmpDate)
          )
         OR
         p.patientID = t3.patientID)" : ""));
    }

    while ($row = psRowFetch ($result)) {
      if (alreadyCounted ($row[0], $endDate)) continue;

      // special case - confirmed malaria
      if ($key == 6) {
        // Need to see if any suspected cases were confirmed with a lab test
        $subRes = dbQuery ("
          SELECT TOP 1 a.patientID
          FROM a_labs a
          WHERE a.patientID = '" . $row[0] . "'
           AND dbo.ymdToDate(a.resultDateYy, a.resultDateMm, a.resultDateDd) BETWEEN DATE_ADD('$startDate', INTERVAL -1 MONTH) AND '$endDate'
           AND
            (
             a.testNameFr LIKE '%malaria%'
             OR a.testNameFr LIKE '%plasmodiun%'
            )
           AND
            (
             (
              (
               (
                a.encounterType = 6
                AND a.formVersion = 1
               )
               OR a.encounterType = 19
              )
              AND a.result = 1
             )
             OR
             (
              a.encounterType = 6
              AND a.formVersion = 0
              AND a.result BETWEEN 1 AND 7
             )
             OR
             (
              a.encounterType = 13
              AND INSTR(LOWER(a.result), 'neg') = 0
             )
            )");
        while ($subRow = psRowFetch ($subRes)) {
          // confirmed with lab test, change syndrome name
          $synLabel = $syndromes[7]["label"];
        }
      }

      $site = substr ($row[0], 0, 5);
      if (!isset ($final_tally[$endDate])) {
        $final_tally[$endDate] = array ($synLabel => array ($site => array ()));
      } else if (!isset ($final_tally[$endDate][$synLabel])) {
        $final_tally[$endDate][$synLabel] = array ($site => array ());
      } else if (!isset ($final_tally[$endDate][$synLabel][$site])) {
        $final_tally[$endDate][$synLabel][$site] = array ();
      }

      $final_tally[$endDate][$synLabel][$site][$row[1]]++;
      if (!isset ($hasData[$synLabel])) $hasData[$synLabel] = array ();
      if (!in_array ($site, array_keys ($hasData[$synLabel]))) $hasData[$synLabel][$site] = 0;
    }

    dropTempTables ($incidenceTable);
  }

  // run for next weekly period
  $endDate = dayDiff (-7, $endDate);
}

if (!empty ($groupOrder)) {
  $sorted = array ();
  foreach ($hasData as $k => $v) {
    if (count (array_keys ($v)) > 1) uksort ($v, "customSort");
    $sorted[$k] = $v;
  }
  $hasData = $sorted;
}

// insert individual sites into final table
$weekCnt = 0;
if (!empty ($endDates)) {
  sort ($endDates);
  foreach ($endDates as $endDay) {
    foreach ($syndromes as $syndrome) {
      if (isset ($hasData[$syndrome["label"]])) {
        foreach (array_keys ($hasData[$syndrome["label"]]) as $siteNum) {
          $boys = intVal ($final_tally[$endDay][$syndrome["label"]][$siteNum]["boy"]);
          $girls = intVal ($final_tally[$endDay][$syndrome["label"]][$siteNum]["girl"]);
          $men = intVal ($final_tally[$endDay][$syndrome["label"]][$siteNum]["man"]);
          $women = intVal ($final_tally[$endDay][$syndrome["label"]][$siteNum]["woman"]);
          $total = intVal ($boys + $girls + $men + $women);
          $hasData[$syndrome["label"]][$siteNum] += intVal ($total);
          if ($weekCnt == 0) {
            dbQuery ("
              INSERT " . $finalTemp[1] . "
              (syndrome, site, boys$weekCnt, girls$weekCnt, men$weekCnt, women$weekCnt, total$weekCnt, grandTotal)
              VALUES ('" . str_replace ("'", "''", $syndrome["label"]) . "', $siteNum, $boys, $girls, $men, $women, $total, " . $hasData[$syndrome["label"]][$siteNum] . ")");
          } else {
            dbQuery ("
              UPDATE " . $finalTemp[1] . "
              SET boys$weekCnt = $boys,
               girls$weekCnt = $girls,
               men$weekCnt = $men,
               women$weekCnt = $women,
               total$weekCnt = $total,
               grandTotal = " . $hasData[$syndrome["label"]][$siteNum] . "
              WHERE syndrome = '" . str_replace ("'", "''", $syndrome["label"]) . "'
               AND site = $siteNum");
          }
        }
      }
    }
    $weekCnt++;
  }
}

function customSort ($a, $b) {
  global $groupOrder;
  $aKeys = array_keys ($groupOrder, $a);
  $bKeys = array_keys ($groupOrder, $b);
  return ($aKeys[0] > $bKeys[0]);
}

function alreadyCounted ($pid, $endDate) {
  global $counted;
  if (in_array ($pid, $counted[$endDate])) {
    return true;
  } else {
    $counted[$endDate][] = $pid;
    return false;
  }
}

?>
