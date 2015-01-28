<?php

function fillPregnancyTable ($tbl, $site, $start, $end, $lmpTbl) {
  if (is_array ($site)) {
    $siteList = implode (',', $site);
  } else {
    $siteList = $site;
  }
  $siteList = "(" . $siteList . ")";

  $tempTableNames = array_merge (array ($tbl), createTempTables ("#pregCalc", 2, "patientID varchar(11), maxDate date", "pid_idx::patientID"));

  /* try to determine pregnancy using all possible sources */
  /* first, "yes" checked on hiv intake & f/u forms for pregnant question */
  dbQuery ("INSERT INTO " . $tempTableNames[0] . "
            SELECT patientID, MAX(visitDate) AS maxDate
            FROM a_vitals
            WHERE siteCode IN $siteList
             AND pregnant = 1
             AND visitDate BETWEEN DATEADD(mm, -9, '$start') AND '$end'
            GROUP BY 1");

  /* next, positive pregnancy test results on laboratory forms */
  comparePregnancyTables ($tempTableNames, 1, "
            SELECT patientID, MAX(dbo.ymdToDate(resultDateYy, resultDateMm, resultDateDd)) AS maxDate
            FROM a_labsCompleted
            WHERE siteCode IN $siteList
             AND
              (
               (labID IN (134) AND result = 1)
               OR
               (labID > 1000 AND testNameFr LIKE '%grossesse%' AND result NOT LIKE '%neg%')
              )
             AND ISDATE(dbo.ymdToDate(resultDateYy, resultDateMm, resultDateDd)) = 1
             AND dbo.ymdToDate(resultDateYy, resultDateMm, resultDateDd) BETWEEN DATEADD(mm, -9, '$start') AND '$end'
            GROUP BY 1");

  /* next, DPA in range on ob/gyn forms */
  comparePregnancyTables ($tempTableNames, 1, "
            SELECT e.patientID, MAX(e.visitDate) AS maxDate
            FROM encValidAll e, obs t1, obs t2, obs t3
            WHERE e.encounter_id = t1.encounter_id
             AND t1.encounter_id = t2.encounter_id
             AND t1.encounter_id = t3.encounter_id
             AND e.siteCode IN $siteList
             AND e.siteCode = t1.location_id
             AND t1.location_id = t2.location_id
             AND t1.location_id = t3.location_id
             AND e.encounterType IN " . visitList ("obGynFirstAndFollowup") . "
             AND e.visitDate <= '$end'
             AND
              (
               (t1.concept_id = 7057
                AND t2.concept_id = 7058
                AND t3.concept_id = 7059
                AND ISDATE(dbo.ymdToDate(t1.value_text, t2.value_text, t3.value_text)) = 1
                AND dbo.ymdToDate(t1.value_text, t2.value_text, t3.value_text) BETWEEN '$start' AND DATEADD(month, 9, '$end'))
               OR
               (t1.concept_id = 8062
                AND t2.concept_id = 8063
                AND t3.concept_id = 8061
                AND ISDATE(dbo.ymdToDate(t1.value_text, t2.value_text, t3.value_text)) = 1
                AND dbo.ymdToDate(t1.value_text, t2.value_text, t3.value_text) BETWEEN '$start' AND DATEADD(month, 9, '$end'))
              )
            GROUP BY 1
            UNION
            SELECT e.patientID, MAX(e.visitDate) AS maxDate
            FROM encValidAll e, obs o
            WHERE e.siteCode IN $siteList
             AND o.location_id = e.siteCode
             AND o.encounter_id = e.encounter_id
             AND o.concept_id IN (71069, 70466)
             AND o.value_datetime BETWEEN '$start' AND DATEADD(month, 9, '$end')
             AND e.encounterType IN " . visitList ("obGynFirstAndFollowup") . "
             AND e.visitDate <= '$end'
            GROUP BY 1");

  /* next, labor form filed in range */
  comparePregnancyTables ($tempTableNames, 1, "
            SELECT e.patientID, MAX(e.visitDate) AS maxDate
            FROM encValidAll e
            WHERE e.siteCode IN $siteList
             AND e.encounterType = 26
             AND e.visitDate BETWEEN '$start' AND '$end'
            GROUP BY 1");

  /* next, pregnancy symptoms/diagnoses on primary care & ob/gyn forms */
  comparePregnancyTables ($tempTableNames, 1, "
            SELECT patientID, MAX(visitDate) AS maxDate
            FROM encValidAll e, obs o
            WHERE e.siteCode IN $siteList
             AND o.location_id = e.siteCode
             AND o.encounter_id = e.encounter_id
             AND e.visitDate BETWEEN DATEADD(mm, -9, '$start') AND '$end'
             AND
              (
               (e.encounterType IN " . visitList ("primCare") . "
                AND o.concept_id IN (70264, 70265)
                AND o.value_boolean = 1)
               OR
               (e.encounterType IN " . visitList ("obGynFirstAndFollowup") . "
                AND
                 (
                  (o.concept_id IN (70067,70068,70069,70078,70082,70084,70086,70087,70103,70118,70126,70130,70132,70144,70148,70150,71140)
                   AND o.value_boolean = 1)
                  OR
                  (o.concept_id IN (7098,7163,7166,7897)
                   AND
                    (ISNUMERIC(o.value_text) = 1
                     OR ISNUMERIC(o.value_numeric) = 1)
                   AND
                    (o.value_text > 0
                     OR o.value_numeric > 0))
                 ))
              )
            GROUP BY 1
            UNION
            SELECT patientID, MAX(visitDate) AS maxDate
            FROM a_conditions
            WHERE siteCode IN $siteList
             AND conditionID IN (439)
             AND conditionActive = 1
             AND encounterType IN " . visitList ("obGynFirstAndFollowup") . "
             AND visitDate BETWEEN DATEADD(mm, -9, '$start') AND '$end'
            GROUP BY 1");

  /* now, remove any patients with non-pregnant data after maxDate set above */
  /* first, "no" checked on hiv intake & f/u forms for pregnant question */
  comparePregnancyTables ($tempTableNames, 2, "
            SELECT patientID, MAX(visitDate) AS maxDate
            FROM a_vitals
            WHERE siteCode IN $siteList
             AND pregnant = 2
             AND visitDate BETWEEN DATEADD(mm, -9, '$start') AND '$start'
            GROUP BY 1");

  /* next, negative pregnancy test results on laboratory forms */
  comparePregnancyTables ($tempTableNames, 2, "
            SELECT patientID, MAX(dbo.ymdToDate(resultDateYy, resultDateMm, resultDateDd)) AS maxDate
            FROM a_labsCompleted
            WHERE siteCode IN $siteList
             AND
              (
               (labID IN (134) AND result = 2)
               OR
               (labID > 1000 AND testNameFr LIKE '%grossesse%' AND result LIKE '%neg%')
              )
             AND ISDATE(dbo.ymdToDate(resultDateYy, resultDateMm, resultDateDd)) = 1
             AND dbo.ymdToDate(resultDateYy, resultDateMm, resultDateDd) BETWEEN DATEADD(mm, -9, '$start') AND '$end'
            GROUP BY 1");

  /* next, LMP date in range */
  comparePregnancyTables ($tempTableNames, 2, "
            SELECT patientID, lmpDate AS maxDate
            FROM " . $lmpTbl);

  /* next, labor form filed in range */
  comparePregnancyTables ($tempTableNames, 2, "
            SELECT e.patientID, MAX(e.visitDate) AS maxDate
            FROM encValidAll e
            WHERE e.siteCode IN $siteList
             AND e.encounterType = 26
             AND e.visitDate <= '$start'
            GROUP BY 1");

  /* finally, remove any male patients */
  dbQuery ("DELETE FROM " . $tempTableNames[0] . "
            WHERE patientID IN
            (SELECT patientID
             FROM patient
             WHERE sex = 2
              AND location_id IN $siteList)");

  dropTempTables (array ("pregCalc"));
}

function fillLmpTable ($tbl, $site, $end, $eligDays) {
  if (is_array ($site)) {
    $siteList = implode (',', $site);
  } else {
    $siteList = $site;
  }
  $siteList = "(" . $siteList . ")";

  $tempTableNames = createTempTables ("#lmpCalc", 2, "patientID varchar(11), lmpDate date, visitDate date", "pid_idx::patientID, visitDate");
  dbQuery ("
    INSERT INTO " . $tempTableNames[1] . "
    SELECT STRAIGHT_JOIN patientID,
     CASE WHEN ISNUMERIC(pregnantLmpDd) <> 1
     AND ISDATE(dbo.ymdToDate(pregnantLmpYy,pregnantLmpMm,'15')) = 1
     THEN dbo.ymdToDate(pregnantLmpYy,pregnantLmpMm,'15')
     WHEN ISNUMERIC(pregnantLmpDd) = 1
     AND ISDATE(dbo.ymdToDate(pregnantLmpYy,pregnantLmpMm, pregnantLmpDd)) = 1
     THEN dbo.ymdToDate(pregnantLmpYy,pregnantLmpMm, pregnantLmpDd) END lmpDate,
     visitDate
    FROM a_vitals 
    WHERE siteCode IN $siteList
     AND visitDate < '$end'
     AND 
      ((ISNUMERIC(pregnantLmpDd) = 1
        AND ISNUMERIC(pregnantLmpMm) = 1
        AND ISNUMERIC(pregnantLmpYy) = 1
        AND ISDATE(dbo.ymdToDate(pregnantLmpYy,pregnantLmpMm,pregnantLmpDd)) = 1)
       OR
       (ISNUMERIC(pregnantLmpDd) <> 1
        AND ISNUMERIC(pregnantLmpMm) = 1
        AND ISNUMERIC(pregnantLmpYy) = 1
        AND ISDATE(dbo.ymdToDate(pregnantLmpYy,pregnantLmpMm,'1')) = 1)
      )
    UNION
    SELECT e.patientID, t.lmpDate, e.visitDate
    FROM encValidAll e,
     (
      SELECT
       (CONVERT(varchar, t1.location_id) + CONVERT(varchar, t1.person_id)) AS patientID,
       dbo.ymdToDate(t1.value_text, t2.value_text, t3.value_text) AS lmpDate
      FROM obs t1, obs t2, obs t3
      WHERE t1.encounter_id = t2.encounter_id
       AND t1.encounter_id = t3.encounter_id
       AND t1.location_id IN $siteList
       AND t1.location_id = t2.location_id
       AND t1.location_id = t3.location_id
       AND t1.concept_id = 7051
       AND t2.concept_id = 7052
       AND t3.concept_id = 7053
     ) t
    WHERE e.patientID = t.patientID
     AND e.encounterType IN " . visitList ("obGynFirstAndFollowup") . "
     AND ISDATE(t.lmpDate) = 1 
     AND e.visitDate < '$end'
    UNION
    SELECT
     e.patientID,
     CASE WHEN o.concept_id = 70465 THEN o.value_datetime
     ELSE DATEADD(week, -o.value_text, e.visitDate) END lmpDate,
     e.visitDate
    FROM encValidAll e, obs o
    WHERE o.location_id IN $siteList
     AND e.siteCode = o.location_id
     AND e.encounter_id = o.encounter_id
     AND e.visitDate < '$end'
     AND e.encounterType IN " . visitList ("obGynFirstAndFollowup") . "
     AND
      (o.concept_id = 70465
       OR
       (o.concept_id IN (7098,70750)
        AND ISNUMERIC(REPLACE(o.value_text, ',', '.')) = 1)
      )
    ");

  /* Copy contents of first temp table to second */
  dbQuery ("
    INSERT INTO " . $tempTableNames[2] . "
    SELECT patientID, lmpDate, visitDate
    FROM " . $tempTableNames[1]);

  /* compute most recent LMP date and eligibility for proph. date */
  dbQuery ("
    INSERT INTO " . $tbl . "
    SELECT t1.patientID, MAX(t1.lmpDate), DATEADD(dd, $eligDays, MAX(t1.lmpDate))
    FROM " . $tempTableNames[1] . " t1,
     (SELECT patientID, MAX(visitDate) AS visitDate
      FROM " . $tempTableNames[2] . "
      GROUP BY 1) t2
    WHERE t1.patientID = t2.patientID
     AND t1.visitDate = t2.visitDate
    GROUP BY t1.patientID, t1.visitDate");
}

function comparePregnancyTables ($tbls, $type, $qry) {
  dbQuery ("INSERT INTO " . $tbls[1] . " $qry");

  if ($type == 1) {
    /* type 1: add new and update existing if date found is newer */

    /* Need to copy into another table to avoid "Can't reopen table" error */
    dbQuery ("TRUNCATE TABLE " . $tbls[2]);
    dbQuery ("INSERT INTO " . $tbls[2] . "
              SELECT patientID, maxDate
              FROM " . $tbls[0]);

    dbQuery ("INSERT INTO " . $tbls[0] . "
              SELECT t2.patientID, t2.maxDate
              FROM " . $tbls[1] . " t2
              LEFT JOIN " . $tbls[2] . " t1 ON t1.patientID = t2.patientID
              WHERE t1.patientID IS NULL");

    dbQuery ("UPDATE " . $tbls[0] . " t1, " . $tbls[1] . " t2
              SET t1.maxDate = t2.maxDate
              WHERE t1.patientID = t2.patientID
               AND t2.maxDate > t1.maxDate");
  } else {
    /* type 2: if date found is newer than previous, delete */
    dbQuery ("DELETE t1
              FROM " . $tbls[0] . " t1, " . $tbls[1] . " t2
              WHERE t1.patientID = t2.patientID
               AND t2.maxDate > t1.maxDate");
  }

  /* reset */
  dbQuery ("TRUNCATE TABLE " . $tbls[1]);
}

function fillPidAgeTable ($tbl, $site, $startDate, $endDate) {
  if (is_array ($site)) {
    $siteList = implode (',', $site);
  } else {
    $siteList = $site;
  }
  $siteList = "(" . $siteList . ")";

  dbQuery ("INSERT INTO " . $tbl . "
	    SELECT patientID,
            CASE WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) <> 1
            THEN (YEAR('$startDate') - CONVERT(BIGINT, dobYy)) * " . DAYS_IN_YEAR . "
            WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND
            ISNUMERIC(dobDd) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, '01')) = 1
            THEN DATEDIFF(dd, dbo.ymdToDate(dobYy, dobMm, '01'), '$startDate')
            WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND
            ISNUMERIC(dobDd) = 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, dobDd)) = 1
            THEN DATEDIFF(dd, dbo.ymdToDate(dobYy, dobMm, dobDd), '$startDate')
	    ELSE '-1' END AS startDays,
            CASE WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) <> 1
            THEN (YEAR('$endDate') - CONVERT(BIGINT, dobYy)) * " . DAYS_IN_YEAR . "
            WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND
            ISNUMERIC(dobDd) <> 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, '01')) = 1
            THEN DATEDIFF(dd, dbo.ymdToDate(dobYy, dobMm, '01'), '$endDate')
            WHEN ISNUMERIC(dobYy) = 1 AND ISNUMERIC(dobMm) = 1 AND
            ISNUMERIC(dobDd) = 1 AND ISDATE(dbo.ymdToDate(dobYy, dobMm, dobDd)) = 1
            THEN DATEDIFF(dd, dbo.ymdToDate(dobYy, dobMm, dobDd), '$endDate')
	    ELSE '-1' END AS endDays
            FROM patient
	    WHERE patStatus = 0
            AND location_id IN $siteList");
}

function visitList ($in) {
  switch ($in) {
    case "all":
      return "(1,2,3,4,5,6,7,10,12,14,15,16,17,18,19,20,21,24,25,26,27,28,29,31)";
      break;
    case "hivQual":
      return "(1,2,3,4,5,6,7,10,14,15,16,17,18,19,20)";
      break;
    case "firstAndFollowup":
      return "(1,2,16,17,24,25,27,28,29,31)";
      break;
    case "sharedPcObPedHiv":
      return "(16,17,24,25,27,28,29,31)";
      break;
    case "sharedPcHiv":
      return "(1,2,16,17,27,28,29,31)";
      break;
    case "sharedHivObConditions":
      return "(1,2,16,17,24,25)";
      break;
    case "sharedPcAdultHiv":
      return "(1,2,27,28,29,31)";
      break;
    case "sharedPcPedHiv":
      return "(16,17,27,28,29,31)";
      break;
    case "sharedPcOb":
      return "(24,25,27,28,29,31)";
      break;
    case "hivFirstAndFollowup":
      return "(1,2,16,17)";
      break;
    case "sharedAdultPcAdultHiv":
      return "(1,2,27,28)";
      break;
    case "sharedAdultPcOb":
      return "(24,25,27,28)";
      break;
    case "followup":
      return "(2,17,28,31)";
      break;
    case "primCare":
      return "(27,28,29,31)";
      break;
    case "obGyn":
      return "(24,25,26)";
      break;
    case "sharedAdultPcFirstOb":
      return "(24,27,28)";
      break;
    case "obGynFirstAndFollowup":
      return "(24,25)";
      break;
    case "adultPc":
      return "(27,28)";
      break;
    case "pedHivFirstAndFollowup":
      return "(16,17)";
      break;
    case "adultHivFirstAndFollowup":
      return "(1,2)";
      break;
    case "hivIntake":
      return "(1,16)";
      break;
    case "labs":
      return "(6,19)";
      break;
    case "rxs":
      return "(5,18)";
      break;
    case "discontinuations":
      return "(12,21)";
      break;
    case "registrations":
      return "(10,15)";
      break;
    default:
      break;
  }
}

function setupIncidenceTable ($site, $startDate, $endDate, $user, $concepts = "", $conditions = "") {

  if (is_array ($site)) {
    $siteList = implode (',', $site);
  } else {
    $siteList = $site;
  }
  $siteList = "(" . $siteList . ")";

  $tempTableNames = createTempTables ("#tempIncidence", 2, "patientID varchar(11), visitDate date", "pat_idx::patientID");

  dbQuery ("INSERT INTO " . $tempTableNames[2] . "
            SELECT e.patientID, MIN(e.visitDate)
            FROM encValidAll e, obs o
            WHERE e.siteCode IN $siteList
             AND e.siteCode = o.location_id
             AND o.value_boolean = 1
             AND e.encounter_id = o.encounter_id
             AND o.concept_id IN $concepts
             AND e.encounterType IN " . visitList ("sharedPcOb") . "
             AND e.visitDate BETWEEN '$startDate' AND '$endDate'
            GROUP BY 1");

  dbQuery ("INSERT INTO " . $tempTableNames[2] . "
            SELECT patientID,
             MIN(CASE WHEN ISDATE(dbo.ymdToDate(conditionYy, conditionMm, '15')) = 1
             THEN dbo.ymdToDate(conditionYy, conditionMm, '15')
             ELSE visitDate END) AS visitDate
            FROM a_conditions
            WHERE siteCode IN $siteList
             AND conditionID IN $conditions
             AND
              (
               (conditionActive IN (1,5) AND encounterType IN " . visitList ("pedHivFirstAndFollowup") . ")
               OR (conditionActive IN (1,4,5) AND encounterType IN " . visitList ("adultHivFirstAndFollowup") . ")
               OR (conditionActive = 1 AND encounterType IN " . visitList ("obGynFirstAndFollowup") . ")
              )
             AND
              (
               (ISDATE(dbo.ymdToDate(conditionYy, conditionMm, '15')) = 1
                AND dbo.ymdToDate(conditionYy, conditionMm, '15') BETWEEN '$startDate' AND '$endDate')
               OR
               (ISDATE(dbo.ymdToDate(conditionYy, conditionMm, '15')) <> 1
                AND visitDate BETWEEN '$startDate' AND '$endDate')
              )
            GROUP BY 1");

  dbQuery ("INSERT INTO " . $tempTableNames[1] . "
            SELECT patientID, MIN(visitDate)
            FROM " . $tempTableNames[2] . "
            GROUP BY 1");

  return $tempTableNames;
}

function siteData ($site) {
  $data = array (
    11100 => array ( "uuid" => "fefa7b61-d193-4ee6-8bec-9ed67fad94da",
                     "name" => "Hôpital de l'Universite d'Etat d'Haiti - HUEH"
                   ),
    11120 => array ( "uuid" => "1a7cb65d-54de-48d2-ba14-f76f1a459386",
                     "name" => "Hôpital Saint François de Sales"
                   ),
    11123 => array ( "uuid" => "6317491c-d645-433f-a45e-4cc6bdefd718",
                     "name" => "Sanatorium de Port-au-Prince"
                   ),
    11127 => array ( "uuid" => "fbddf197-3b53-4214-a2cd-c7dabde7e1de",
                     "name" => "Institut Fame Pereo"
                   ),
    11151 => array ( "uuid" => "d6198946-0a35-41d0-b7a2-5ba9234a049f",
                     "name" => "FOSREF"
                   ),
    11155 => array ( "uuid" => "491cd245-a378-4535-943c-31d31d579bb8",
                     "name" => "Centre Jeunes de Lalue"
                   ),
    11156 => array ( "uuid" => "7574e7fd-d8dc-4b3f-a046-905483e347f3",
                     "name" => "Centre Lakay Centre Ville"
                   ),
    11157 => array ( "uuid" => "859d4511-1b3f-4bee-b0c0-f7e8bdae6f03",
                     "name" => "CEGYPEF"
                   ),
    11158 => array ( "uuid" => "e855c4c6-a000-4ddc-9b8e-9165342ebab5",
                     "name" => "CEPOZ Centre Espoir"
                   ),
    11208 => array ( "uuid" => "e87fa0b0-d430-40f3-a41e-ec9eb4119231",
                     "name" => "Grace Children's Hospital"
                   ),
    11217 => array ( "uuid" => "6a283040-8d18-42a0-a22b-0288a53bc902",
                     "name" => "Maternite Isaie Jeanty"
                   ),
    11221 => array ( "uuid" => "bf2a5e80-3ee4-4b4f-9edd-f3879c90edd8",
                     "name" => "Hôpital Universitaire de la Paix"
                   ),
    11228 => array ( "uuid" => "d0f0e9ea-f0b9-471b-909f-00d972c10137",
                     "name" => "Centre de Sante Bernard Mevs"
                   ),
    11229 => array ( "uuid" => "0d95f8ae-73ec-48f2-8fa1-a2ee9cb98538",
                     "name" => "CHOSCAL"
                   ),
    11234 => array ( "uuid" => "da3fe957-df4e-4e9f-9fa7-ddb1a3261a29",
                     "name" => "Centre Jeunes de Delmas"
                   ),
    11303 => array ( "uuid" => "7e8c28a0-3842-417c-ad1b-18aa60fc2882",
                     "name" => "Hôpital de Carrefour"
                   ),
    11306 => array ( "uuid" => "bb21738d-bd3a-48ae-ab02-1d3657ba4706",
                     "name" => "Hôpital Adventiste de Diquini"
                   ),
    11316 => array ( "uuid" => "90087349-bc0d-4f48-9120-1b9c67095eb4",
                     "name" => "Centre Hospitalier d'Arcachon 32"
                   ),
    11404 => array ( "uuid" => "e3b75d69-1b8a-45a2-a564-b140488dbd3c",
                     "name" => "Hôpital de la Communauté Haïtienne"
                   ),
    11405 => array ( "uuid" => "a58ce80a-71c4-4d3b-a08b-b840c6fb7fb8",
                     "name" => "Centre Hospitalier Eliazar Germain"
                   ),
    11412 => array ( "uuid" => "fdd5698e-fb00-44bd-a4f3-759436fd8f10",
                     "name" => "Hôpital Saint Damien (NPFS)"
                   ),
    11423 => array ( "uuid" => "156996a1-cb2c-429c-af02-738cee498120",
                     "name" => "Centre Lakay de Pétion ville"
                   ),
    11503 => array ( "uuid" => "6c26f493-17b9-42d1-be81-90955c697179",
                     "name" => "Hôpital de Fermathe (mission baptiste)"
                   ),
    12107 => array ( "uuid" => "a5d37a07-e484-45af-8cbb-e233dc7e7736",
                     "name" => "Sanatorium de Sigueneau"
                   ),
    12108 => array ( "uuid" => "58d08db3-9f8a-40df-bfd5-50b65378b645",
                     "name" => "Hôpital Sainte-Croix de Leogane"
                   ),
    12201 => array ( "uuid" => "11ee5c51-61ab-464d-a76b-1fe48be3a951",
                     "name" => "Hôpital Notre Dame de Petit Goave"
                   ),
    13103 => array ( "uuid" => "bfb6eb4a-3040-4b53-8cf0-fbdc08b47a9d",
                     "name" => "Centre de Santé de la Croix-des-Bouquets"
                   ),
    13109 => array ( "uuid" => "3354e5d4-c03a-46b6-9d63-f472a573195d",
                     "name" => "Foyer St Camille"
                   ),
    13114 => array ( "uuid" => "404bf209-590d-41aa-8ea4-311d2f0bf352",
                     "name" => "Centre Jeunes de la Plaine du cul de sac"
                   ),
    14103 => array ( "uuid" => "c401dfc5-0f05-4af1-9c86-275f6554d5ee",
                     "name" => "SADA   matheux"
                   ),
    14106 => array ( "uuid" => "10b45a7c-628d-46b1-a61b-a2d00ed2d364",
                     "name" => "CSL St Paul (montrouis)"
                   ),
    15103 => array ( "uuid" => "266cf440-eb7d-4a0f-a3a6-53298b563a7a",
                     "name" => "Hôpital Wesleyen de la Gonave"
                   ),
    21100 => array ( "uuid" => "d06594b4-8af1-47b6-a27c-a158b5c77c1c",
                     "name" => "Hôpital St Michel de Jacmel"
                   ),
    21201 => array ( "uuid" => "e75180a0-81f2-4139-87db-0d7e4d82a36b",
                     "name" => "Centre de Sante de Marigot"
                   ),
    21401 => array ( "uuid" => "8cf2ffc2-11c5-4f8a-9e26-986d9ae64214",
                     "name" => "Hôpital Saint Joseph de La Vallée de Jacmel"
                   ),
    22101 => array ( "uuid" => "8db00359-1dd8-4b92-b0f2-d5e723f3b464",
                     "name" => "CAL de Bainet"
                   ),
    31100 => array ( "uuid" => "a8e03941-af03-4ff4-b1e1-43accc1402ff",
                     "name" => "Hôpital Universitaire Justinien"
                   ),
    31101 => array ( "uuid" => "83883e5e-c0f0-441b-ba71-7730b15f8beb",
                     "name" => "CDS La Fossette"
                   ),
    31102 => array ( "uuid" => "3d7ad0cf-bc60-4878-9cdb-741710e174bd",
                     "name" => "Hôpital Fort St Michel"
                   ),
    31110 => array ( "uuid" => "a5e8dc39-5bb5-4db8-92e3-880107b90d01",
                     "name" => "FOSREF, rue 16"
                   ),
    32205 => array ( "uuid" => "930f36b7-65cf-40c0-b583-12a80f8a024f",
                     "name" => "Clinique Béthesda de Vaudreuil"
                   ),
    32207 => array ( "uuid" => "c7a707da-d484-466e-b53f-7fd689801c2b",
                     "name" => "Clin. François DUGUE"
                   ),
    32301 => array ( "uuid" => "e58a6275-a2e7-48c3-84cd-bd7ff8630049",
                     "name" => "Hôpital Sacre Coeur de Milot"
                   ),
    33101 => array ( "uuid" => "f46c840c-2f86-4d48-a0a0-0f31cdbe1f6d",
                     "name" => "Hôpital de La Grande Riviere du Nord"
                   ),
    34401 => array ( "uuid" => "d58a651f-98b0-4630-8206-2643b7023866",
                     "name" => "Hôpital Bienfaisance de Pignon"
                   ),
    35101 => array ( "uuid" => "13fbfe32-42ce-419a-a7a5-bf32d90f7a2c",
                     "name" => "Alliance Santé de Borgne"
                   ),
    36101 => array ( "uuid" => "24bbaa36-e681-44dd-8403-73938a24a17a",
                     "name" => "Hôpital Saint-Jean de Limbe"
                   ),
    37201 => array ( "uuid" => "c27d658a-9e8b-4462-9310-e6d2de4c3e79",
                     "name" => "Hôpital Esperance de Pilate"
                   ),
    41100 => array ( "uuid" => "62d90aef-09d0-49bb-bddd-9c11bf27a912",
                     "name" => "Hôpital de Fort Liberté"
                   ),
    41201 => array ( "uuid" => "fa3dea25-e937-44f4-968b-16ec8c345b92",
                     "name" => "Centre Medico-Social de Ouanaminthe"
                   ),
    42301 => array ( "uuid" => "074d9ff2-8335-4d56-8fc4-7207f3234292",
                     "name" => "CAL de Mont Organise"
                   ),
    51100 => array ( "uuid" => "959fd444-7567-4a5c-b434-0bfa609998dc",
                     "name" => "Hôpital La Providence des Gonaives"
                   ),
    52101 => array ( "uuid" => "5f17d20d-22d4-4327-bcb9-d65acff5afe3",
                     "name" => "Hôpital Alma Mater de Gros Morne"
                   ),
    53108 => array ( "uuid" => "ebe7a1f7-dd3c-4514-905a-8503e829beea",
                     "name" => "Centre de Sante Pierre Payen"
                   ),
    54101 => array ( "uuid" => "8fdfb449-3c72-43aa-a03a-3f1b11a8567a",
                     "name" => "Hôpital Claire Heureuse"
                   ),
    62104 => array ( "uuid" => "2f6fcd68-3e4c-4cc4-a4a5-72adc9fd4296",
                     "name" => "Dispensaire Marché Canard"
                   ),
    71100 => array ( "uuid" => "c6abe62c-50d6-47bf-8cfd-9b9f7ce04f66",
                     "name" => "Hôpital Immaculée Conception des Cayes"
                   ),
    71104 => array ( "uuid" => "2fc8d1fa-9030-4975-a4db-eca20943f24a",
                     "name" => "Centre de Sante Lumiere (FINCA)"
                   ),
    71106 => array ( "uuid" => "d2510f43-1869-487d-9547-742b73346419",
                     "name" => "Quatre Chemins"
                   ),
    71107 => array ( "uuid" => "a0ee13e5-a638-4878-a1f4-78b3598e7374",
                     "name" => "Dispensaire Sacre-Coeur de Charpentier"
                   ),
    71201 => array ( "uuid" => "c97632c0-88f7-4314-96dc-a0defb1d28d6",
                     "name" => "Maison de Naissance"
                   ),
    71301 => array ( "uuid" => "5d7dd96b-716b-4e9e-8a85-9855c78fef5c",
                     "name" => "Dispensaire Sainte Jeanne de Chantal"
                   ),
    71401 => array ( "uuid" => "0701d473-2592-461a-ac6d-0da04ed915cf",
                     "name" => "Hôpital Sainte-Anne de Camp-Perrin"
                   ),
    72101 => array ( "uuid" => "96d8ff54-0f14-4ab5-bc0d-577f06d292ed",
                     "name" => "HCR de Port Salut"
                   ),
    73101 => array ( "uuid" => "0475e9d2-9b34-491e-909a-7863a00e6b37",
                     "name" => "HCR d'Aquin"
                   ),
    73103 => array ( "uuid" => "0db00483-df4c-4023-8562-f14d58841f9b",
                     "name" => "Hôpital Saint Boniface de Fond des Blancs"
                   ),
    73301 => array ( "uuid" => "fa33f2d0-1e46-4962-8df5-90e60315562c",
                     "name" => "Hôpital Lumiere Bonne-Fin"
                   ),
    81100 => array ( "uuid" => "d4e37e3f-b369-497a-a64d-3216c0f34d11",
                     "name" => "Hôpital Saint Antoine de Jeremie"
                   ),
    81101 => array ( "uuid" => "812af70d-c825-478a-afa2-56b70e56ee9c",
                     "name" => "Haitian Health Foundation"
                   ),
    82201 => array ( "uuid" => "089d61cb-c707-4c9b-9242-6a62188dc64f",
                     "name" => "AEADEMA de Dame-Marie"
                   ),
    83401 => array ( "uuid" => "eeaeaf14-ef57-4da4-8455-e94abdf17625",
                     "name" => "Centre de Sante de Pestel"
                   ),
    84100 => array ( "uuid" => "fd4024ef-c5eb-474a-96ed-b7a25aa21df8",
                     "name" => "Hôpital Sainte Thérèse de Miragoane"
                   ),
    84111 => array ( "uuid" => "8bda2532-88a3-4303-80af-9ace8e43c947",
                     "name" => "Hôpital Armee du Salut Clinic Béthel"
                   ),
    91100 => array ( "uuid" => "67674604-6a5f-4fa4-812c-43473694fd79",
                     "name" => "Hôpital Immaculée Conception de Port de Paix"
                   ),
    91114 => array ( "uuid" => "b6faeba6-bc13-46fb-b50c-17890f86b05e",
                     "name" => "Centre Medical Beraca"
                   ),
    93301 => array ( "uuid" => "d9458d6f-4fec-41c2-ba5f-ae0ca86a5708",
                     "name" => "Hôpital Evangelique de Bombardopolis"
                   ),
    93401 => array ( "uuid" => "40cb4dfb-2717-42c4-94f8-5dca9dde8286",
                     "name" => "Hôpital Notre Dame de la Paix de Jean Rabel"
                   ),
    95698 => array ( "uuid" => "8a539655-83b7-4435-b2d2-09fa8743d39b",
                     "name" => "CEPOZ Centre Espoir"
                   )
  );

  return ($data[$site]);
}

?>
