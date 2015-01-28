<?

require_once ("backend/sharedRptFunctions.php");

$tempPregTableNames = array ();

function updatePregnancyRanges () {
  global $tempPregTableNames;

  $tempPregTableNames = createTempTables ("tempPregRangeCalc", 2, array ("patientID varchar(11), pregDate date, primary key (patientID, pregDate)", "patientID varchar(11), notPregDate date, primary key (patientID, notPregDate)"), "pat_idx::patientID");

  /* Store all pregnancy = 'Yes' values */
  /* first, "yes" checked on hiv intake & f/u forms for pregnant question */
  database()->query ("INSERT INTO " . $tempPregTableNames[1] . "
    SELECT STRAIGHT_JOIN v.patientID, v.visitDate
    FROM a_vitals v
    WHERE v.pregnant = 1
     AND v.visitDate <= NOW()
    ON DUPLICATE KEY UPDATE patientID = v.patientID");
  
  /* next, positive pregnancy test results on laboratory forms */
  database()->query ("INSERT INTO " . $tempPregTableNames[1] . "
    SELECT l.patientID, ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd)
    FROM a_labsCompleted l
    WHERE 
      (
       (l.labID IN (134) AND l.result = 1)
       OR
       (l.labID > 1000 AND l.testNameFr LIKE ? AND l.result NOT LIKE ?)
      )
     AND ISDATE(ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd)) = 1
     AND ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd) <= NOW()
    ON DUPLICATE KEY UPDATE patientID = l.patientID", array ('%grossesse%', '%neg%'));
  
  /* next, DPA entered on old ob/gyn forms */
  database()->query ("INSERT INTO " . $tempPregTableNames[1] . "
    SELECT e.patientID, e.visitDate
    FROM encValidAll e, obs t1, obs t2, obs t3
    WHERE e.encounter_id = t1.encounter_id
     AND t1.encounter_id = t2.encounter_id
     AND t1.encounter_id = t3.encounter_id
     AND e.siteCode = t1.location_id
     AND t1.location_id = t2.location_id
     AND t1.location_id = t3.location_id
     AND e.encounterType IN " . visitList ("obGynFirstAndFollowup") . "
     AND e.visitDate <= NOW()
     AND
      (
       (t1.concept_id = 7057
        AND t2.concept_id = 7058
        AND t3.concept_id = 7059
        AND ISDATE(ymdToDate(t1.value_text, t2.value_text, t3.value_text)) = 1)
       OR
       (t1.concept_id = 8062
        AND t2.concept_id = 8063
        AND t3.concept_id = 8061
        AND ISDATE(ymdToDate(t1.value_text, t2.value_text, t3.value_text)) = 1)
      )
    ON DUPLICATE KEY UPDATE patientID = e.patientID");
  
  /* next, DPA entered on new ob/gyn forms */
  database()->query ("INSERT INTO " . $tempPregTableNames[1] . "
    SELECT e.patientID, e.visitDate
    FROM encValidAll e, obs o
    WHERE o.location_id = e.siteCode
     AND o.encounter_id = e.encounter_id
     AND o.concept_id IN (71069, 70466)
     AND e.encounterType IN " . visitList ("obGynFirstAndFollowup") . "
     AND e.visitDate <= NOW()
    ON DUPLICATE KEY UPDATE patientID = e.patientID");
  
  /* next, pregnancy symptoms/diagnoses on primary care & ob/gyn forms */
  database()->query ("INSERT INTO " . $tempPregTableNames[1] . "
    SELECT patientID, visitDate
    FROM encValidAll e, obs o
    WHERE o.location_id = e.siteCode
     AND o.encounter_id = e.encounter_id
     AND e.visitDate <= NOW()
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
    ON DUPLICATE KEY UPDATE patientID = e.patientID");
  
  /* finally, pregnancy checked as a condition on ob/gyn forms */
  database()->query ("INSERT INTO " . $tempPregTableNames[1] . "
    SELECT c.patientID, c.visitDate
    FROM a_conditions c
    WHERE c.conditionID IN (439)
     AND c.conditionActive = 1
     AND c.encounterType IN " . visitList ("obGynFirstAndFollowup") . "
     AND c.visitDate <= NOW()
    ON DUPLICATE KEY UPDATE patientID = c.patientID");
  
  /* Store all pregnancy = 'No' values */
  /* first, "no" checked on hiv intake & f/u forms for pregnant question */
  database()->query ("INSERT INTO " . $tempPregTableNames[2] . "
    SELECT STRAIGHT_JOIN patientID, visitDate
    FROM a_vitals v
    WHERE v.pregnant = 2
     AND v.visitDate <= NOW()
    ON DUPLICATE KEY UPDATE patientID = v.patientID");
  
  /* next, negative pregnancy test results on laboratory forms */
  database()->query ("INSERT INTO " . $tempPregTableNames[2] . "
    SELECT l.patientID, ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd)
    FROM a_labsCompleted l
    WHERE 
      (
       (l.labID IN (134) AND l.result = 2)
       OR
       (l.labID > 1000 AND l.testNameFr LIKE ? AND l.result LIKE ?)
      )
     AND ISDATE(ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd)) = 1
     AND ymdToDate(l.resultDateYy, l.resultDateMm, l.resultDateDd) <= NOW()
    ON DUPLICATE KEY UPDATE patientID = l.patientID", array ('%grossesse%', '%neg%'));
  
  /* next, LMP entered (store LMP date, not visitDate) */
  database()->query ("INSERT INTO " . $tempPregTableNames[2] . "
      SELECT STRAIGHT_JOIN v.patientID,
       CASE WHEN ISNUMERIC(v.pregnantLmpDd) <> 1
       AND ISDATE(ymdToDate(v.pregnantLmpYy,v.pregnantLmpMm,?)) = 1
       THEN ymdToDate(v.pregnantLmpYy,v.pregnantLmpMm,?)
       WHEN ISNUMERIC(v.pregnantLmpDd) = 1
       AND ISDATE(ymdToDate(v.pregnantLmpYy,v.pregnantLmpMm, v.pregnantLmpDd)) = 1
       THEN ymdToDate(v.pregnantLmpYy,v.pregnantLmpMm, v.pregnantLmpDd) END lmpDate
      FROM a_vitals v
      WHERE v.visitDate <= NOW()
       AND 
        ((ISNUMERIC(v.pregnantLmpDd) = 1
          AND ISNUMERIC(v.pregnantLmpMm) = 1
          AND ISNUMERIC(v.pregnantLmpYy) = 1
          AND ISDATE(ymdToDate(v.pregnantLmpYy,v.pregnantLmpMm,v.pregnantLmpDd)) = 1)
          AND ymdToDate(v.pregnantLmpYy,v.pregnantLmpMm,v.pregnantLmpDd) <= NOW()
         OR
         (ISNUMERIC(v.pregnantLmpDd) <> 1
          AND ISNUMERIC(v.pregnantLmpMm) = 1
          AND ISNUMERIC(v.pregnantLmpYy) = 1
          AND ISDATE(ymdToDate(v.pregnantLmpYy,v.pregnantLmpMm,?)) = 1)
          AND ymdToDate(v.pregnantLmpYy,v.pregnantLmpMm,?) <= NOW()
        )
      ON DUPLICATE KEY UPDATE patientID = v.patientID", array ('15', '15', '1', '1'));
  
  /* more LMP data from ob/gyn forms */
  database()->query ("INSERT INTO " . $tempPregTableNames[2] . "
      SELECT e.patientID, t.lmpDate
      FROM encValidAll e,
       (
        SELECT
         CONCAT(t1.location_id, t1.person_id) AS patientID,
         ymdToDate(t1.value_text, t2.value_text, t3.value_text) AS lmpDate
        FROM obs t1, obs t2, obs t3
        WHERE t1.encounter_id = t2.encounter_id
         AND t1.encounter_id = t3.encounter_id
         AND t1.location_id = t2.location_id
         AND t1.location_id = t3.location_id
         AND t1.concept_id = 7051
         AND t2.concept_id = 7052
         AND t3.concept_id = 7053
       ) t
      WHERE e.patientID = t.patientID
       AND e.encounterType IN " . visitList ("obGynFirstAndFollowup") . "
       AND ISDATE(t.lmpDate) = 1 
       AND e.visitDate <= NOW()
      ON DUPLICATE KEY UPDATE patientID = e.patientID");
  
  /* still more LMP data from obs table */
  database()->query ("INSERT INTO " . $tempPregTableNames[2] . "
      SELECT
       e.patientID,
       CASE WHEN o.concept_id = 70465 THEN o.value_datetime
       ELSE DATE_ADD(e.visitDate, INTERVAL -o.value_text WEEK) END lmpDate
      FROM encValidAll e, obs o
      WHERE e.siteCode = o.location_id
       AND e.encounter_id = o.encounter_id
       AND e.visitDate <= NOW()
       AND e.encounterType IN " . visitList ("obGynFirstAndFollowup") . "
       AND
        (o.concept_id = 70465
         OR
         (o.concept_id IN (7098,70750)
          AND ISNUMERIC(REPLACE(o.value_text, ?, ?)) = 1)
        )
      ON DUPLICATE KEY UPDATE patientID = e.patientID", array (',', '.'));
  
  /* next, labor form filed */
  database()->query ("INSERT INTO " . $tempPregTableNames[2] . "
    SELECT e.patientID, e.visitDate
    FROM encValidAll e
    WHERE e.encounterType = 26
     AND e.visitDate <= NOW()
    ON DUPLICATE KEY UPDATE patientID = e.patientID");
  
  /* now, remove male patients from both lists */
  database()->query ("
    DELETE FROM " . $tempPregTableNames[1] . "
    WHERE patientID IN
     (SELECT p.patientID
      FROM patient p
      WHERE p.sex = 2)");
  
  database()->query ("
    DELETE FROM " . $tempPregTableNames[2] . "
    WHERE patientID IN
     (SELECT p.patientID
      FROM patient p
      WHERE p.sex = 2)");
  
  /* initialize the ranges table with the earliest start date for each patient */
  database()->query ("INSERT INTO dw_pregnancy_ranges
    (patientID, startDate)
    SELECT patientID, MIN(pregDate)
    FROM " . $tempPregTableNames[1] . "
    GROUP BY 1");
  
  /* Look up maximum unique pregnancy = "Yes" dates for a single patient */
  /* This will inform us how many times we will need to loop below */
  $result = database()->query ("
    SELECT patientID, COUNT(*) AS total
    FROM " . $tempPregTableNames[1] . "
    GROUP BY 1
    ORDER BY 2 DESC
    LIMIT 1")->fetchAll();
  
  foreach ($result as $row) {
    $maxRuns = $row['total'];
  }
  
  /* loop matching stop dates and start dates, or using start + 10 months if */
  /* no stop dates within that range */
  for ($i = 0; $i <= $maxRuns; $i++) { // threw in an extra run, just to be safe
    database()->query ("INSERT INTO dw_pregnancy_ranges
      (patientID, startDate, stopDate)
      SELECT t2.patientID, p.maxPregStart,
       CASE WHEN MIN(t2.notPregDate) > DATE_ADD(p.maxPregStart, INTERVAL 10 MONTH)
        THEN DATE_ADD(p.maxPregStart, INTERVAL 10 MONTH)
       ELSE MIN(t2.notPregDate) END AS notPregDate
      FROM " . $tempPregTableNames[2] . " t2,
     (SELECT patientID, MAX(startDate) AS maxPregStart
        FROM dw_pregnancy_ranges GROUP BY 1) p
      WHERE t2.patientID = p.patientID
       AND t2.notPregDate > p.maxPregStart
      GROUP BY 1
      ON DUPLICATE KEY UPDATE stopDate = VALUES(stopDate)");
  
    database()->query ("INSERT INTO dw_pregnancy_ranges
      (patientID, startDate)
      SELECT t1.patientID, MIN(t1.pregDate)
      FROM " . $tempPregTableNames[1] . " t1,
       (SELECT patientID, MAX(stopDate) AS maxPregStop
        FROM dw_pregnancy_ranges GROUP BY 1) p
      WHERE t1.patientID = p.patientID
       AND t1.pregDate > p.maxPregStop
      GROUP BY 1
      ON DUPLICATE KEY UPDATE patientID = VALUES(patientID)");
  }
  
  /* replace any bogus stopDates with startDate + 10 months */
  database()->query ("
    UPDATE dw_pregnancy_ranges
    SET stopDate = DATE_ADD(startDate, INTERVAL 10 MONTH)
    WHERE stopDate IS NULL
     OR stopDate = ?
     OR stopDate <= startDate", array (''));

  dropTempTables ($tempPregTableNames);
}  

?>
