<?php
require_once 'backend.php';
require_once 'backend/sharedRptFunctions.php';

function obGynSetup ($site, $startDate, $endDate, $user) {
  // Setup required for all ob/gyn reports - no longer used as of 2011-04-21
  $tempTableNames = createTempTables ("tempId", 1, "patientID varchar(11), stID varchar(255), otherID varchar(255)", "pat_idx::patientID");

  dbQuery ("INSERT INTO " . $tempTableNames[1] . "
         SELECT DISTINCT e.patientID, p.clinicPatientID, o.value_text
         FROM encValidAll e
         LEFT JOIN patient p ON e.patientID = p.patientID
         LEFT JOIN obs o ON SUBSTRING(e.patientID, 6) = o.person_id AND
         o.concept_id = 70040 AND
         e.siteCode = o.location_id
         WHERE e.siteCode = '$site' AND
	 e.visitDate <= '$endDate' AND
         e.encounterType IN (10, 15)");

  return $tempTableNames;
}

function setupObGynRpt ($repNum, $site, $startDate, $endDate, $user) {
  switch ($repNum) {
    case '3000':
      return setupObGynType1 ($site, $startDate, $endDate, $user);
      break;
    case '3001':
      return setupObGynType2 ($site, $startDate, $endDate, $user);
      break;
    case '3002':
    case '3003':
    case '3100':
    case '3101':
    case '3103':
    case '3104':
    case '3105':
    case '3111':
    case '3120':
    case '3121':
    case '3133':
    case '3138':
    case '3144':
    case '3145':
    case '3146':
    case '3147':
    case '3211':
    case '3247':
    case '3509':
      return setupObGynType3 ($site, $startDate, $endDate, $user);
      break;
    case '3004':
      return setupObGynType4 ($site, $startDate, $endDate, $user, 1);
      break;
    case '3005':
    case '3117':
    case '3118':
    case '3119':
    case '3120':
    case '3122':
    case '3124':
    case '3125':
      return setupObGynType4 ($site, $startDate, $endDate, $user);
      break;
    case '3102':
    case '3106':
    case '3110':
    case '3114':
    case '3134':
    case '3135':
    case '3136':
      return setupObGynType3 ($site, $startDate, $endDate, $user, 1);
      break;
    case '3107':
    case '3108':
    case '3109':
      return setupObGynType3 ($site, $startDate, $endDate, $user, 1, 1);
      break;
    case '3131':
      return setupIncidenceTable ($site, "2001-01-01", $endDate, $user, "(70059)", "(705)");
      break;
    case '3150':
    case '3151':
    case '3152':
    case '3153':
    case '3154':
    case '3155':
      return setupObGynType5 ($site, $startDate, $endDate, $user);
      break;
    case '3156':
    case '3157':
    case '3158':
    case '3159':
    case '3160':
    case '3161':
      return setupObGynType5 ($site, $startDate, $endDate, $user, 1);
      break;
    default:
      break;
  }
}

function denObGynRpt ($repNum, $site, $startDate, $endDate, $tblNames = array ()) {
  switch ($repNum) {
    case '3000':
    case '3509':
      return denObGynType1 ($site, $startDate, $endDate, $tblNames);
      break;
    case '3002':
    case '3003':
      return denObGynType2 ($site, $startDate, $endDate, $tblNames);
      break;
    case '3004':
      return denObGynType3 ($site, $startDate, $endDate, $tblNames);
      break;
    case '3005':
      return denObGynType4 ($site, $startDate, $endDate, $tblNames);
      break;
    default:
      break;
  }
}

function setupObGynType1 ($site, $startDate, $endDate, $user) {
  $tempTableNames = createTempTables ("#temp", 4, array ("patientID varchar(11), maxDate date", "patientID varchar(11), visitDate date, encounter_id int, dpa date", "patientID varchar(11), lmpDate date, eligDate date", "patientID varchar(11), visitDate date, encounter_id int, dpa date"), "pat_idx::patientID");

  fillLmpTable ($tempTableNames[3], $site, $endDate, (strtotime ($startDate) >= strtotime (PMTCT_14_WEEKS_DATE) ? 98 : 196));
  fillPregnancyTable ($tempTableNames[1], $site, $startDate, $endDate, $tempTableNames[3]);

  dbQuery ("INSERT INTO " . $tempTableNames[2] . "
            SELECT DISTINCT e.patientID, e.visitDate,
             e.encounter_id, o.value_datetime
            FROM encValidAll e, obs o
            WHERE e.siteCode = o.location_id AND
             e.encounterType IN (24,25) AND
             e.encounter_id = o.encounter_id AND
             o.concept_id = 70466 AND
             o.location_id = '$site' AND
             o.value_datetime BETWEEN '$startDate' AND DATEADD(month, 9, '$endDate') AND
             e.visitDate BETWEEN '$startDate' AND '$endDate'");

  dbQuery ("INSERT INTO " . $tempTableNames[4] . "
            SELECT patientID, visitDate, encounter_id, dpa
            FROM " . $tempTableNames[2]);

  dbQuery ("DELETE t FROM " . $tempTableNames[2] . " t,
            (
             SELECT patientID, MAX(visitDate) AS visitDate
             FROM " . $tempTableNames[4] . "
             GROUP BY patientID
            ) u
            WHERE t.visitDate <> u.visitDate AND
            t.patientID = u.patientID");

  return $tempTableNames;
}

function setupObGynType2 ($site, $startDate, $endDate, $user) {
  $tempTableNames = createTempTables ("#temp", 2, array ("patientID varchar(11), visitDate date", "visCount varchar(3), patientID varchar(11)"), "pat_idx::patientID");

  // Fill temp tables with values to be used in later joins
  dbQuery ("INSERT INTO " . $tempTableNames[1] . "
            SELECT DISTINCT e.patientID, e.visitDate
            FROM encValidAll e
            WHERE e.encounterType = '26' AND
             e.visitDate BETWEEN '$startDate' AND '$endDate'");

  dbQuery ("INSERT INTO " . $tempTableNames[2] . "
            SELECT DISTINCT '0', e.patientID
            FROM encValidAll e, " . $tempTableNames[1] . " t1
            WHERE e.patientID = t1.patientID AND
             e.encounterType IN (24,25) AND
             e.visitDate BETWEEN DATEADD(month, -10, t1.visitDate) AND t1.visitDate
             GROUP BY e.patientID HAVING count(*) < 1");

  dbQuery ("INSERT INTO " . $tempTableNames[2] . "
            SELECT DISTINCT '1-3', e.patientID
            FROM encValidAll e, " . $tempTableNames[1] . " t1
            WHERE e.patientID = t1.patientID AND
             e.encounterType IN (24,25) AND
             e.visitDate BETWEEN DATEADD(month, -10, t1.visitDate) AND t1.visitDate
             GROUP BY e.patientID HAVING count(*) BETWEEN 1 AND 3");

  dbQuery ("INSERT INTO " . $tempTableNames[2] . "
            SELECT DISTINCT '3+', e.patientID
            FROM encValidAll e, " . $tempTableNames[1] . " t1
            WHERE e.patientID = t1.patientID AND
             e.encounterType IN (24,25) AND
             e.visitDate BETWEEN DATEADD(month, -10, t1.visitDate) AND t1.visitDate
             GROUP BY e.patientID HAVING count(*) > 3");

  return $tempTableNames;
}

function setupObGynType3 ($site, $startDate, $endDate, $user, $extra1 = 0, $extra2 = 0) {
  $tempTableNames = createTempTables ("#temp", 6, array ("patientID varchar(11), maxDate date", "patientID varchar(11), lmpDate date, eligDate date", "patientID varchar(11), drugID int, drugGroup varchar(40)", "patientID varchar(11), drugID int, drugGroup varchar(40)", "patientID varchar(11), drugID int, drugGroup varchar(40)", "patientID varchar(11), drugID int, drugGroup varchar(40)"), "pat_idx::patientID");

  fillLmpTable ($tempTableNames[2], $site, $endDate, (strtotime ($startDate) >= strtotime (PMTCT_14_WEEKS_DATE) ? 98 : 196));
  fillPregnancyTable ($tempTableNames[1], $site, $startDate, $endDate, $tempTableNames[2]);

  if ($extra2) {
    dbQuery ("INSERT INTO " . $tempTableNames[3] . "
              SELECT p.patientID, p.drugID, l.drugGroup
              FROM a_prescriptions p, drugLookup l
              WHERE p.drugID = l.drugID
               AND l.drugGroup IN ('NRTIs', 'NNRTIs', 'Pls')
               AND p.visitDate BETWEEN '$startDate' AND '$endDate'
               AND p.siteCode = '$site'
              GROUP BY 1, 2");

    // Need duplicates to avoid "Can't reopen table" error
    dbQuery ("INSERT INTO " . $tempTableNames[4] . "
              SELECT patientID, drugID, drugGroup
              FROM " . $tempTableNames[3]);

    dbQuery ("INSERT INTO " . $tempTableNames[5] . "
              SELECT patientID, drugID, drugGroup
              FROM " . $tempTableNames[3]);

    dbQuery ("INSERT INTO " . $tempTableNames[6] . "
              SELECT patientID, drugID, drugGroup
              FROM " . $tempTableNames[3]);
  }

  return $tempTableNames;
}

function setupObGynType4 ($site, $startDate, $endDate, $user, $extra = 0) {
  $tempTableNames = createTempTables ("#temp", 2, array ("visitDate date, encID int unsigned, siteCode mediumint unsigned, living tinyint, fetalMac tinyint, fetalNonMac tinyint, neonatal tinyint", "visitDate date, encID int unsigned, siteCode mediumint unsigned, wt varchar(255)"), "tmp_idx::encID, siteCode, visitDate");

  dbQuery ("INSERT INTO " . $tempTableNames[1] . "
            SELECT e.visitDate, e.encounter_id, e.siteCode,
             COUNT(DISTINCT o1.obs_id),
             COUNT(DISTINCT o2.obs_id),
             COUNT(DISTINCT o3.obs_id),
             COUNT(DISTINCT o4.obs_id)
            FROM encValidAll e
            LEFT JOIN obs o1 ON e.encounter_id = o1.encounter_id
             AND e.siteCode = o1.location_id
             AND o1.concept_id IN (70500,70501,70502,70503)
             AND o1.value_numeric = 1
            LEFT JOIN obs o2 ON e.encounter_id = o2.encounter_id
             AND e.siteCode = o2.location_id
             AND o2.concept_id IN (70500,70501,70502,70503)
             AND o2.value_numeric = 2
            LEFT JOIN obs o3 ON e.encounter_id = o3.encounter_id
             AND e.siteCode = o3.location_id
             AND o3.concept_id IN (70500,70501,70502,70503)
             AND o3.value_numeric = 4
            LEFT JOIN obs o4 ON e.encounter_id = o4.encounter_id
             AND e.siteCode = o4.location_id
             AND o4.concept_id IN (70500,70501,70502,70503)
             AND o4.value_numeric = 8
            WHERE e.siteCode = '$site'
             AND e.encounterType = 26
             AND e.visitDate BETWEEN '$startDate' AND '$endDate'
            GROUP BY 1,2,3");

  if ($extra) {
    dbQuery ("INSERT INTO " . $tempTableNames[2] . "
              SELECT DISTINCT t1.visitDate, t1.encID, t1.siteCode,
               CASE WHEN o3.value_numeric = 2 THEN
               ROUND(CONVERT(float,
               REPLACE(LTRIM(RTRIM(o2.value_text)), ',', '.')) * 0.45359237, 0) ELSE
               REPLACE(LTRIM(RTRIM(o2.value_text)), ',', '.') END
              FROM " . $tempTableNames[1] . " t1, obs o1, obs o2, obs o3
              WHERE t1.encID = o1.encounter_id
               AND t1.encID = o2.encounter_id
               AND t1.siteCode = o1.location_id
               AND t1.siteCode = o2.location_id
               AND t1.siteCode = o3.location_id
               AND t1.siteCode = o3.location_id
               AND t1.living > 0
               AND
               (
                (o1.concept_id = 70500
                 AND o1.value_numeric = 1
                 AND o2.concept_id = 70508
                 AND o2.value_text IS NOT NULL
                 AND LTRIM(RTRIM(o2.value_text)) <> ''
                 AND ISNUMERIC(REPLACE(LTRIM(RTRIM(o2.value_text)), ',', '.')) = 1
                 AND o3.concept_id = 70512
                 AND o3.value_numeric IN (1,2)
                )
               OR
                (o1.concept_id = 70501
                 AND o1.value_numeric = 1
                 AND o2.concept_id = 70509
                 AND o2.value_text IS NOT NULL
                 AND LTRIM(RTRIM(o2.value_text)) <> ''
                 AND ISNUMERIC(REPLACE(LTRIM(RTRIM(o2.value_text)), ',', '.')) = 1
                 AND o3.concept_id = 70513
                 AND o3.value_numeric IN (1,2)
                )
               OR
                (o1.concept_id = 70502
                 AND o1.value_numeric = 1
                 AND o2.concept_id = 70510
                 AND o2.value_text IS NOT NULL
                 AND LTRIM(RTRIM(o2.value_text)) <> ''
                 AND ISNUMERIC(REPLACE(LTRIM(RTRIM(o2.value_text)), ',', '.')) = 1
                 AND o3.concept_id = 70514
                 AND o3.value_numeric IN (1,2)
                )
               OR
                (o1.concept_id = 70503
                 AND o1.value_numeric = 1
                 AND o2.concept_id = 70511
                 AND o2.value_text IS NOT NULL
                 AND LTRIM(RTRIM(o2.value_text)) <> ''
                 AND ISNUMERIC(REPLACE(LTRIM(RTRIM(o2.value_text)), ',', '.')) = 1
                 AND o3.concept_id = 70515
                 AND o3.value_numeric IN (1,2)
                )
               )");
  }

  return $tempTableNames;
}

function setupObGynType5 ($site, $startDate, $endDate, $user, $extra = 0) {
  $tempTableNames = createTempTables ("#temp", 2, array("patientID varchar(11), startDate date, pill tinyint, condom tinyint, tablet tinyint, inject tinyint, implant tinyint", "patientID varchar(11), contDate date, pill tinyint, condom tinyint, tablet tinyint, inject tinyint, implant tinyint"), "pat_idx::patientID");

  dbQuery ("INSERT INTO " . $tempTableNames[1] . "
            SELECT STRAIGHT_JOIN DISTINCT e.patientID, o1.value_datetime,
             CASE WHEN l.famPlanMethodOcPills = 1 THEN l.famPlanMethodOcPills
             ELSE 0 END,
             CASE WHEN l.famPlanMethodCondom = 1 THEN l.famPlanMethodCondom
             ELSE 0 END,
             CASE WHEN o2.value_text = 1 THEN o2.value_text
             WHEN o2.value_numeric = 1 THEN o2.value_numeric
             ELSE 0 END,
             CASE WHEN o3.value_boolean = 1 THEN o3.value_boolean
             ELSE 0 END,
             CASE WHEN o4.value_boolean = 1 THEN o4.value_boolean
             ELSE 0 END
            FROM encValidAll e
             LEFT JOIN vitals l ON e.patientID = l.patientID
             AND e.siteCode = l.siteCode
             AND e.visitDateDd = l.visitDateDd
             AND e.visitDateMm = l.visitDateMm
             AND e.visitDateYy = l.visitDateYy
             AND e.seqNum = l.seqNum
             AND e.encounterType IN " . visitList ("obGynFirstAndFollowup") . "
             LEFT JOIN obs o1 ON e.encounter_id = o1.encounter_ID
             AND e.siteCode = o1.location_id
             LEFT JOIN obs o2 ON e.encounter_id = o2.encounter_ID
             AND e.siteCode = o2.location_id
             AND o2.concept_id = 7876
             LEFT JOIN obs o3 ON e.encounter_id = o3.encounter_ID
             AND e.siteCode = o3.location_id
             AND o3.concept_id = 71128
             LEFT JOIN obs o4 ON e.encounter_id = o4.encounter_ID
             AND e.siteCode = o4.location_id
             AND o4.concept_id = 71127
            WHERE e.siteCode = '$site'
             AND o1.concept_id = 70584
             AND o1.value_datetime <= '$endDate'");

  if ($extra) {
    dbQuery ("INSERT INTO " . $tempTableNames[2] . "
              SELECT STRAIGHT_JOIN DISTINCT e.patientID, e.visitDate,
               CASE WHEN l.famPlanMethodOcPills = 1 THEN l.famPlanMethodOcPills
               ELSE 0 END,
               CASE WHEN l.famPlanMethodCondom = 1 THEN l.famPlanMethodCondom
               ELSE 0 END,
               CASE WHEN o2.value_text = 1 THEN o2.value_text
               WHEN o2.value_numeric = 1 THEN o2.value_numeric
               ELSE 0 END,
               CASE WHEN o3.value_boolean = 1 THEN o3.value_boolean
               ELSE 0 END,
               CASE WHEN o4.value_boolean = 1 THEN o4.value_boolean
               ELSE 0 END
              FROM encValidAll e
               LEFT JOIN vitals l ON e.patientID = l.patientID
               AND e.siteCode = l.siteCode
               AND e.visitDateDd = l.visitDateDd
               AND e.visitDateMm = l.visitDateMm
               AND e.visitDateYy = l.visitDateYy
               AND e.seqNum = l.seqNum
               AND e.encounterType IN " . visitList ("obGynFirstAndFollowup") . "
               LEFT JOIN obs o2 ON e.encounter_id = o2.encounter_ID
               AND e.siteCode = o2.location_id
               AND o2.concept_id = 7876
               LEFT JOIN obs o3 ON e.encounter_id = o3.encounter_ID
               AND e.siteCode = o3.location_id
               AND o3.concept_id = 71128
               LEFT JOIN obs o4 ON e.encounter_id = o4.encounter_ID
               AND e.siteCode = o4.location_id
               AND o4.concept_id = 71127
              WHERE e.siteCode = '$site'
               AND e.visitDate BETWEEN '$startDate' AND '$endDate'");
  }

  return $tempTableNames;
}

function denObGynType1 ($site, $startDate, $endDate, $tblNames = array ()) {
  return fetchFirstColumn(dbQuery("
SELECT DISTINCT t1.patientID
FROM " . $tblNames[0] . " t1,
" . $tblNames[1] . " t2
WHERE t1.patientID = t2.patientID"));
}
 
function denObGynType2 ($site, $startDate, $endDate, $tblNames = array ()) {
  return fetchFirstColumn(dbQuery("
SELECT DISTINCT e.patientID
FROM encValidAll e, " . $tblNames[0] . " t1
WHERE e.patientID = t1.patientID
 AND e.siteCode = '$site'
 AND e.encounterType IN " . visitList ("obGyn") . "
 AND e.visitDate <= '$endDate'"));
}
 
function denObGynType3 ($site, $startDate, $endDate, $tblNames = array ()) {
  $ret = array ();

  $result = dbQuery("
  SELECT living
  FROM " . $tblNames[0] . "
  WHERE living > 0");

  /* denominator is expected to be counted as an array of values, so populate */
  /* a dummy array and return that with the total number found in db */
  while ($row = psRowFetch ($result)) {
    for ($i = 1; $i <= $row[0]; $i++) {
      $ret[] = '1';
    }
  }

  return ($ret);
}
 
function denObGynType4 ($site, $startDate, $endDate, $tblNames = array ()) {
  $ret = array ();

  $result = dbQuery("SELECT t1.living, t1.fetalMac, t1.fetalNonMac FROM " . $tblNames[0] . " t1");

  /* denominator is expected to be counted as an array of values, so populate */
  /* a dummy array and return that with the total number found in db */
  while ($row = psRowFetch ($result)) {
    for ($i = 1; $i <= $row[0]; $i++) {
      $ret[] = '1';
    }
    for ($i = 1; $i <= $row[1]; $i++) {
      $ret[] = '1';
    }
    for ($i = 1; $i <= $row[2]; $i++) {
      $ret[] = '1';
    }
  }

  return ($ret);
}
 
?>
