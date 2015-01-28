<?php			   
require_once 'backend.php';
require_once 'backend/sharedRptFunctions.php';

function primCareSetup ($site, $startDate, $endDate, $user) {
  // Setup required for all primary care reports - no longer used as of 2011-04-21
  $tempTableNames = createTempTables ("tempId", 2, array ("patientID varchar(11), otherID varchar(64)", "patientID varchar(11)"), "pat_idx::patientID");

  dbQuery ("INSERT INTO " . $tempTableNames[2] . "
	SELECT DISTINCT e.patientID
        FROM encValidAll e
        WHERE e.encounterType IN (27, 28, 29, 31) AND
        e.siteCode = '$site' AND
	e.visitDate <= '$endDate'");
  
  dbQuery ("INSERT INTO " . $tempTableNames[1] . "
         SELECT DISTINCT e.patientID, o.value_text
         FROM " . $tempTableNames[2] . " t, encValidAll e
         LEFT JOIN obs o ON SUBSTRING(e.patientID, 6) = o.person_id AND
         o.concept_id = 70039 AND
         e.siteCode = o.location_id AND
	 e.visitDate <= '$endDate'
         WHERE t.patientID = e.patientID AND
         e.siteCode = '$site' AND
         e.encounterType IN (10, 15)");

  return $tempTableNames;
}

function setupPrimCareRpt ($repNum, $site, $startDate, $endDate, $user) {
  switch ($repNum) {
    case '2000':
    case '2035':
      return setupPrimCareType1 ($site, $startDate, $endDate, $user, 0, visitList ("sharedPcOb"));
      break;
    case '2002':
      return setupPrimCareType2 ($site, $startDate, $endDate, $user);
      break;
    case '2024':
      return setupIncidenceTable ($site, monthDiff (-6, $startDate), $endDate, $user, "(70351)", "(21,208,397,409)");
      break;
    case '2027':
      return setupPrimCareType5 ($site, $startDate, $endDate, $user, 1);
      break;
    case '2030':
      return setupPrimCareType6 ($site, $startDate, $endDate, $user, "arme a feu");
      break;
    case '2031':
      return setupPrimCareType6 ($site, $startDate, $endDate, $user, "arme blanche");
      break;
    case '2033':
    case '2034':
    case '2502':
    case '2505':
    case '2506':
    case '2507':
    case '2508':
    case '2509':
    case '2609':
      return setupPrimCareType3 ($site, $startDate, $endDate, $user);
      break;
    case '2500':
    case '2547':
    case '2647': 
      return setupPrimCareType5 ($site, $startDate, $endDate, $user);
      break;
    case '2501':
      return setupPrimCareType1 ($site, $startDate, $endDate, $user, 1, visitList ("sharedPcOb"));
      break;
    case '2504':
      return setupPrimCareType4 ($site, $startDate, $endDate, $user);
      break;
    default:
      break;
  }
}

function denPrimCareRpt ($repNum, $site, $startDate, $endDate, $tblNames = array ()) {
  switch ($repNum) {
    case '2000':
    case '2035': 
      return denPrimCareType1 ($site, $startDate, $endDate, $tblNames);
      break;
    case '2002':
      return denPrimCareType3 ($site, $startDate, $endDate, "", visitList ("sharedPcAdultHiv"), $tblNames);
      break;
    case '2003':
      return denPrimCareType2 ($site, $startDate, $endDate, visitList ("sharedAdultPcFirstOb"), $tblNames);
      break;
    case '2004':
    case '2005':
    case '2006':
    case '2011':
      return denPrimCareType2 ($site, $startDate, $endDate, visitList ("sharedPcAdultHiv"), $tblNames);
      break;
    case '2008':
      return denPrimCareType2 ($site, $startDate, $endDate, visitList ("sharedAdultPcOb"), $tblNames);
      break;
    case '2009':
      return denPrimCareType2 ($site, $startDate, $endDate, visitList ("sharedAdultPcAdultHiv"), $tblNames);
      break;
    case '2010':
      return denPrimCareType2 ($site, $startDate, $endDate, visitList ("adultPc"), $tblNames);
      break;
    case '2017':
    case '2217':
    case '2024':
    case '2025':
    case '2509':
    case '2609':
    case '2547': 
      return denPrimCareType2 ($site, $startDate, $endDate, visitList ("sharedPcHiv"), $tblNames);
      break;
    case '2020':
    case '2026':
    case '2647':
      return denPrimCareType2 ($site, $startDate, $endDate, visitList ("sharedPcPedHiv"), $tblNames);
      break;
    case '2027':
    case '2500': 
      return denPrimCareType3 ($site, $startDate, $endDate, "", visitList ("sharedPcObPedHiv"), $tblNames);
      break;
    case '2030':
    case '2031':
      return denPrimCareType2 ($site, $startDate, $endDate, visitList ("adultPc"), $tblNames);
      break;
    case '2033':
    case '2034':
      return denPrimCareType3 ($site, $startDate, $endDate, "BETWEEN 0 AND 15", visitList ("primCare"), $tblNames);
      break;
    case '2501':
      return denPrimCareType4 ($site, $startDate, $endDate, $tblNames);
      break;
    case '2502':
      return denPrimCareType3 ($site, $startDate, $endDate, ">= 15", visitList ("primCare"), $tblNames);
      break;
    case '2504':
      return denPrimCareType3 ($site, $startDate, $endDate, "", visitList ("sharedPcHiv"), $tblNames);
      break;
    case '2505':
      return denPrimCareType3 ($site, $startDate, $endDate, "BETWEEN 0 AND 15", visitList ("sharedPcPedHiv"), $tblNames);
      break;
    case '2506':
    case '2507':
    case '2508':
      return denPrimCareType3 ($site, $startDate, $endDate, "BETWEEN 0 AND 15", visitList ("primCare"), $tblNames);
      break;
    default:
      return denPrimCareType2 ($site, $startDate, $endDate, visitList ("primCare"), $tblNames);
      break;
  }
}

function denPrimCareType1 ($site, $startDate, $endDate, $tblNames = array ()) {
  return fetchFirstColumn(dbQuery("
SELECT DISTINCT t0.patientID
FROM " . $tblNames[0] . " t0,
" . $tblNames[1] . " t1,
" . $tblNames[2] . " t2
WHERE
 t0.patientID NOT IN
 (SELECT patientID
  FROM " . $tblNames[4] . ") AND
 t0.patientID = t1.patientID AND
 t0.patientID = t2.patientID AND
 (
  (t1.startDays >= 15 * " . DAYS_IN_YEAR . "
   AND t1.startDays < 19 * " . DAYS_IN_YEAR . "
   AND t2.visitDate BETWEEN DATEADD(month, -6, '$startDate') AND '$endDate')
  OR
   t1.startDays >= 19 * " . DAYS_IN_YEAR . "
 )"));
}
 
function denPrimCareType2 ($site, $startDate, $endDate, $visits = "(NULL)", $tblNames = array ()) {
  return fetchFirstColumn(dbQuery("
SELECT DISTINCT e.patientID
FROM encValidAll e
WHERE e.siteCode = '$site'
 AND e.encounterType IN $visits
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'"));
}

function denPrimCareType3 ($site, $startDate, $endDate, $ages = "", $visits = "(NULL)", $tblNames = array ()) {
  return fetchFirstColumn(dbQuery("
SELECT DISTINCT e.patientID
FROM encValidAll e,
" . $tblNames[0] . " t1
WHERE e.patientID = t1.patientID
 AND e.siteCode = '$site'
 AND e.encounterType IN $visits
" . (!empty ($ages) ? "AND FLOOR(t1.startDays / " . DAYS_IN_YEAR . ") $ages" : "") . "
 AND e.visitDate BETWEEN '$startDate' AND '$endDate'"));
}

function denPrimCareType4 ($site, $startDate, $endDate, $tblNames = array ()) {
  return fetchFirstColumn (dbQuery ("
SELECT DISTINCT p.patientID
FROM patient p,
" . $tblNames[0] . " t1,
" . $tblNames[1] . " t2,
" . $tblNames[2] . " t3,
" . $tblNames[3] . " t4
WHERE p.patientID = t1.patientID
 AND p.patientID = t2.patientID
 AND p.patientID = t3.patientID
 AND p.patientID = t4.patientID AND
 p.patientID NOT IN
 (SELECT patientID
  FROM " . $tblNames[4] . ") AND
 ((t2.startDays >= 15 * " . DAYS_IN_YEAR . "
   AND t2.startDays < 19  * " . DAYS_IN_YEAR . "
   AND t3.visitDate BETWEEN DATEADD(month, -6, '$startDate') AND '$endDate')
  OR t2.startDays >= 19 * " . DAYS_IN_YEAR . ")
 AND ROUND(CONVERT(float, t1.wt / (CONVERT(float, t3.ht) * CONVERT(float, t3.ht))), 0) < '18.5'"));
}

function setupPrimCareType1 ($site, $startDate, $endDate, $user, $extra = 0, $visits = "(NULL)") {
   // weight, height, pregnancy status?
  $tempTableNames = createTempTables ("#temp", 7, array ("patientID varchar(11), visitDate date, wt varchar(64)", "patientID varchar(11), startDays mediumint, endDays mediumint", "patientID varchar(11), visitDate date, ht varchar(64)", "patientID varchar(11), visitDate date", "patientID varchar(11), maxDate date", "patientID varchar(11), lmpDate date, eligDate date", "patientID varchar(11), visitDate date, ht varchar(64)"), array ("pat_visit_idx::patientID, visitDate", "pat_idx::patientID", "pat_visit_idx::patientID, visitDate", "pat_visit_idx::patientID, visitDate", "pat_idx::patientID", "pat_idx::patientID", "pat_visit_idx::patientID, visitDate"));

  // Fill temp tables with values to be used in later joins
  dbQuery ("INSERT INTO " . $tempTableNames[1] . "
	    SELECT patientID, visitDate,
            CASE WHEN
             vitalWeightUnits = 2 THEN
             ROUND(CONVERT(float,
             REPLACE(LTRIM(RTRIM(vitalWeight)), ',', '.')) * 0.45359237, 0) ELSE
             REPLACE(LTRIM(RTRIM(vitalWeight)), ',', '.')
            END AS vitalWeight
            FROM a_vitals
            WHERE siteCode = '$site' AND
            ISNUMERIC(REPLACE(LTRIM(RTRIM(vitalWeight)), ',', '.')) = 1 AND
            vitalWeightUnits IN (1,2) AND
            visitDate BETWEEN '$startDate' AND '$endDate' AND
            encounterType IN " . visitList ("sharedPcOb"));
  
  dbQuery ("DELETE t FROM " . $tempTableNames[1] . " t,
            (
             SELECT patientID, MAX(visitDate) AS visitDate
             FROM encValidAll
             WHERE encounterType IN " . visitList ("sharedPcOb") . "
              AND siteCode = '$site'
              AND visitDate <= '$endDate'
             GROUP BY patientID
            ) u
            WHERE t.visitDate <> u.visitDate AND
            t.patientID = u.patientID");

  fillPidAgeTable ($tempTableNames[2], $site, $startDate, $endDate);

  dbQuery ("INSERT INTO " . $tempTableNames[3] . "
            SELECT patientID, visitDate,
            CASE WHEN
             ISNUMERIC(REPLACE(LTRIM(RTRIM(vitalHeight)),',','.')) = 1 AND
             ISNUMERIC(REPLACE(LTRIM(RTRIM(vitalHeightCm)),',','.')) = 1
             THEN REPLACE(LTRIM(RTRIM(vitalHeight)),',','.') + (REPLACE(LTRIM(RTRIM(vitalHeightCm)),',','.') / 100)
            WHEN
             ISNUMERIC(REPLACE(LTRIM(RTRIM(vitalHeight)),',','.')) = 1 AND
             ISNUMERIC(REPLACE(LTRIM(RTRIM(vitalHeightCm)),',','.')) <> 1
             THEN REPLACE(LTRIM(RTRIM(vitalHeight)),',','.')
            WHEN
             ISNUMERIC(REPLACE(LTRIM(RTRIM(vitalHeight)),',','.')) <> 1 AND
             ISNUMERIC(REPLACE(LTRIM(RTRIM(vitalHeightCm)),',','.')) = 1
             THEN REPLACE(LTRIM(RTRIM(vitalHeightCm)),',','.') / 100
            ELSE NULL END
	    FROM a_vitals
            WHERE siteCode = '$site' AND
	    (ISNUMERIC(REPLACE(LTRIM(RTRIM(vitalHeight)), ',', '.')) = 1 OR
	     ISNUMERIC(REPLACE(LTRIM(RTRIM(vitalHeightCm)), ',', '.')) = 1) AND
            encounterType IN " . visitList ("sharedPcOb") . " AND
	    visitDate <= '$endDate'");

  dbQuery ("INSERT INTO " . $tempTableNames[7] . "
             SELECT patientID, visitDate, ht
             FROM " . $tempTableNames[3]);

  dbQuery ("DELETE t FROM " . $tempTableNames[3] . " t,
            (
             SELECT patientID, MAX(visitDate) AS visitDate
             FROM " . $tempTableNames[7] . "
             GROUP BY patientID
            ) u
            WHERE t.visitDate <> u.visitDate AND
            t.patientID = u.patientID");

  if ($extra) {
    dbQuery ("INSERT INTO " . $tempTableNames[4] . "
              SELECT DISTINCT e.patientID, e.visitDate
              FROM encValidAll e, obs o
              WHERE e.siteCode = '$site'
               AND e.siteCode = o.location_id
               AND o.value_boolean = 1
               AND e.encounter_id = o.encounter_id
               AND o.concept_id = 70422
               AND e.encounterType IN " . visitList ("sharedPcOb") . "
               AND e.visitDate BETWEEN '$startDate' AND '$endDate'");
  }

  fillLmpTable ($tempTableNames[6], $site, $endDate, (strtotime ($startDate) >= strtotime (PMTCT_14_WEEKS_DATE) ? 98 : 196));
  fillPregnancyTable ($tempTableNames[5], $site, $startDate, $endDate, $tempTableNames[6]);

  return $tempTableNames;
}

function setupPrimCareType2 ($site, $startDate, $endDate, $user) {
  // diabetes setup
  $tempTableNames = createTempTables ("#temp", 1, "patientID varchar(11)", "pat_idx::patientID");

  // Fill temp tables with values to be used in later joins
  dbQuery ("INSERT INTO " . $tempTableNames[1] . "
            SELECT DISTINCT e.patientID
            FROM encValidAll e
            LEFT JOIN obs o ON e.encounter_id = o.encounter_id
             AND e.siteCode = o.location_id
            LEFT JOIN conditions c ON e.patientID = c.patientID
             AND e.siteCode = c.siteCode
             AND e.visitDateDd = c.visitDateDd
             AND e.visitDateMm = c.visitDateMm
             AND e.visitDateYy = c.visitDateYy
             AND e.seqNum= c.seqNum
            WHERE e.siteCode = '$site'
             AND e.visitDate <= '$endDate'
             AND
              (
               (o.value_boolean = 1
                AND o.concept_id IN (70249, 70250, 70252, 70253)
                AND e.encounterType IN " . visitList ("primCare") . "
               )
               OR
               (c.conditionID IN (316,317) AND c.conditionActive IN (1,4,5)
                AND e.encounterType IN " . visitList ("adultHivFirstAndFollowup") . "
               )
              )");
 
  return $tempTableNames;
}

function setupPrimCareType3 ($site, $startDate, $endDate, $user) {
  // age table
  $tempTableNames = createTempTables ("#temp", 1, array ("patientID varchar(11), startDays mediumint, endDays mediumint"), array ("pat_idx::patientID"));

  fillPidAgeTable ($tempTableNames[1], $site, $startDate, $endDate);

  return $tempTableNames;
}

function setupPrimCareType4 ($site, $startDate, $endDate, $user) {
  // various symptoms plus x ray, pulmon, thora
  $tempTableNames = createTempTables ("#temp", 2, "patientID varchar(11)", "pat_idx::patientID");

  dbQuery ("INSERT INTO " . $tempTableNames[1] . "
            SELECT DISTINCT e.patientID
            FROM encValidAll e, obs o1, obs o2
            WHERE e.siteCode = '$site'
             AND e.siteCode = o1.location_id
             AND e.siteCode = o2.location_id
             AND o1.value_boolean = 1
             AND o2.value_boolean = 1
             AND e.encounter_id = o1.encounter_id
             AND e.encounter_id = o2.encounter_id
             AND o1.concept_id IN (7010, 7012, 7026, 7027, 70173, 70207, 70174, 70610)
             AND o2.concept_id IN (7010, 7012, 7026, 7027, 70173, 70207, 70174, 70610)
             AND e.encounterType IN " . visitList ("sharedPcHiv") . "
             AND e.visitDate BETWEEN '$startDate' AND '$endDate'");

  dbQuery ("INSERT INTO " . $tempTableNames[2] . "
            SELECT DISTINCT e.patientID
            FROM encValidAll e, obs o
            WHERE e.siteCode = '$site'
             AND e.siteCode = o.location_id
             AND e.encounter_id = o.encounter_id
             AND o.concept_id IN (70639)
             AND o.value_boolean = 1
             AND e.encounterType IN " . visitList ("primCare") . "
             AND e.visitDate BETWEEN '$startDate' AND '$endDate'
            UNION
            SELECT DISTINCT e.patientID
            FROM encValidAll e, obs o1, obs o2
            WHERE e.siteCode = '$site'
             AND e.siteCode = o1.location_id
             AND e.siteCode = o2.location_id
             AND o1.value_boolean = 1
             AND
              (o2.value_text LIKE '%pulmon%'
               OR 
               o2.value_text LIKE '%thora%')
             AND e.encounter_id = o1.encounter_id
             AND e.encounter_id = o2.encounter_id
             AND o1.concept_id IN (70582)
             AND o2.concept_id IN (70641)
             AND e.encounterType IN " . visitList ("sharedPcOb") . "
             AND e.visitDate BETWEEN '$startDate' AND '$endDate'
            UNION
            SELECT DISTINCT patientID
            FROM a_labs
            WHERE siteCode = '$site'
             AND visitDate BETWEEN '$startDate' AND '$endDate'
             AND labID IN (131, 137, 169)");

  return $tempTableNames;
}

function setupPrimCareType5 ($site, $startDate, $endDate, $user, $extra = 0) {
  $tempTableNames = createTempTables ("#temp", 2, "patientID varchar(11)", "pat_idx::patientID");

  dbQuery ("INSERT INTO " . $tempTableNames[1] . "
            SELECT DISTINCT patientID
            FROM patient
            WHERE patStatus = 0
             AND location_id = '$site'");

  dbQuery ("DELETE t1
            FROM encValid e
            LEFT JOIN vitals v ON v.patientID = e.patientID
             AND v.siteCode = e.siteCode
             AND v.visitDateYy = e.visitDateYy
             AND v.visitDateMm = e.visitDateMm
             AND v.visitDateDd = e.visitDateDd
             AND v.seqNum = e.seqNum, " . $tempTableNames[1] . " t1
            WHERE e.patientID = t1.patientID
             AND
             (
              (e.encounterType IN (1,2)
               AND e.visitDate < '$startDate'
              )
              OR
              (e.encounterType IN (16,17)
               AND e.visitDate < '$startDate'
               AND v.pedCurrHiv > 1
              )
             )");

  if ($extra) {
    dbQuery ("INSERT INTO " . $tempTableNames[2] . "
              SELECT DISTINCT e.patientID
              FROM encValidAll e, obs o
              WHERE e.siteCode = '$site'
               AND e.siteCode = o.location_id
               AND e.encounter_id = o.encounter_id
               AND o.concept_id IN (71138,71139)
               AND o.value_boolean = 1
               AND e.encounterType IN " . visitList ("sharedPcOb") . "
               AND e.visitDate BETWEEN '$startDate' AND '$endDate'
              UNION
              SELECT DISTINCT e.patientID
              FROM encValidAll e
              LEFT JOIN vitals v ON v.patientID = e.patientID
               AND v.siteCode = e.siteCode
               AND v.visitDateYy = e.visitDateYy
               AND v.visitDateMm = e.visitDateMm
               AND v.visitDateDd = e.visitDateDd
               AND v.seqNum = e.seqNum
              WHERE e.siteCode = '$site'
               AND e.visitDate BETWEEN '$startDate' AND '$endDate'
               AND
                (
                 (e.encounterType = 1)
                 OR
                 (e.encounterType = 16
                  AND v.pedCurrHiv > 1)
                )
              ");
  }

  return $tempTableNames;
}

function setupPrimCareType6 ($site, $startDate, $endDate, $user, $extra = "") {
  // wounds
  $tempTableNames = createTempTables ("#temp", 1, "patientID varchar(11)", "pat_idx::patientID");

  // Fill temp tables with values to be used in later joins
  dbQuery ("INSERT INTO " . $tempTableNames[1] . "
            SELECT DISTINCT e.patientID
            FROM encValidAll e, obs o1, obs o2
            WHERE e.siteCode = o1.location_id
             AND e.encounter_id = o1.encounter_id
             AND e.siteCode = o2.location_id
             AND e.encounter_id = o2.encounter_id
             AND e.siteCode = '$site'
             AND e.visitDate BETWEEN '$startDate' AND '$endDate'
             AND o1.concept_id IN (70370, 70371)
             AND o1.value_boolean = 1
             AND o2.concept_id = 70373
             AND o2.value_text LIKE '%" . $extra . "%'");
 
  return $tempTableNames;
}

?>
