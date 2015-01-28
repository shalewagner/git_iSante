<? 
function updateNutritionSnapshot ($lastModified) { 
  /* Borrowing from Eric's fine work on the growth charts, the following are
   * the relevant weight and height-related fields we'll need to poll for data:
   *
   * Weights:
   * vitals.vitalWeight
   * vitals.vitalWeightUnits (1 = kgs, 2 = lbs)
   * vitals.pedVitBirWt
   * vitals.pedVitBirWtUnits (1 = kgs, 2 = lbs)
   * obs.value_text where obs.concept_id = 70767 (birthWeight)
   * obs.value_numeric where obs.concept_id = 70768 (birthWeightUnits, 1 = lbs, 2 = kgs)
   *
   * Heights:
   * vitals.vitalHeight
   * vitals.vitalHeightCm
   * vitals.pedVitBirLen
   *
   * BMI will be calculated using gathered weight and height values.
   */

  // Get birthdates where we can calculate 'age in months'.  Need year and
  // month if 5 years old or less, otherwise year is sufficient
  database()->query ('INSERT INTO ' . $GLOBALS['tempTableNames'][1] . '
    SELECT DISTINCT p.patientID,
     CASE WHEN ISNUMERIC(p.dobYy) = 1
      AND ISNUMERIC(p.dobMm) <> 1
      AND ISDATE(ymdToDate(p.dobYy, ?, ?)) = 1
      AND YEAR(NOW()) - p.dobYy >= 6
      THEN ymdToDate(p.dobYy, ?, ?)
     WHEN ISNUMERIC(p.dobYy) = 1
      AND ISNUMERIC(p.dobMm) = 1
      AND ISNUMERIC(p.dobDd) <> 1
      AND ISDATE(ymdToDate(p.dobYy, p.dobMm, ?)) = 1
      THEN ymdToDate(p.dobYy, p.dobMm, ?)
     WHEN ISNUMERIC(p.dobYy) = 1
      AND ISNUMERIC(p.dobMm) = 1
      AND ISNUMERIC(p.dobDd) = 1
      AND ISDATE(ymdToDate(p.dobYy, p.dobMm, p.dobDd)) = 1
      THEN ymdToDate(p.dobYy, p.dobMm, p.dobDd)
     ELSE NULL END
    FROM encValidAll e, patient p
    WHERE p.patientID = e.patientID
     AND ISNUMERIC(p.dobYy) = 1
     AND ISNUMERIC(p.dobMm) = 1
     AND ISDATE(ymdToDate(p.dobYy, p.dobMm, ?)) = 1', array ('01', '01', '01', '01', '01', '01', '01'));

  // Collect weight and height data from a_vitals view
  $params = array ();
  for ($i = 0; $i < 24; $i++) {
    $params[] = ',';
    $params[] = '.';
  }
  $params[] = $lastModified;

  // This query returns way too much data on a consolidated server to use 
  // 'fetchAll' to collect into a PHP variable (runs out of memory), so we'll
  // need to keep everything within the database.
  database()->query ('INSERT INTO ' . $GLOBALS['tempTableNames'][2] . '
    SELECT STRAIGHT_JOIN v.patientID, v.visitDate, p.dob,
     FLOOR(DATEDIFF(v.visitDate, p.dob) / ' . DAYS_IN_MONTH . ') AS ageInMos,
     CASE WHEN v.vitalWeightUnits = 2
      THEN ROUND((REPLACE(LTRIM(RTRIM(v.vitalWeight)), ?, ?)) * 0.45359237, 1)
     WHEN v.vitalWeightUnits = 1
      THEN REPLACE(LTRIM(RTRIM(v.vitalWeight)), ?, ?)
     ELSE 0 END AS vitalWeight,
     CASE WHEN v.pedVitBirWtUnits = 2
      THEN ROUND((REPLACE(LTRIM(RTRIM(v.pedVitBirWt)), ?, ?)) * 0.45359237, 1)
     WHEN v.pedVitBirWtUnits = 1
      THEN REPLACE(LTRIM(RTRIM(v.pedVitBirWt)), ?, ?)
     ELSE 0 END AS pedVitBirWt,
     CASE WHEN ISNUMERIC(REPLACE(LTRIM(RTRIM(v.vitalHeight)), ?, ?)) = 1 AND
      ISNUMERIC(REPLACE(LTRIM(RTRIM(v.vitalHeightCm)), ?, ?)) = 1
      THEN REPLACE(LTRIM(RTRIM(v.vitalHeight)), ?, ?) + (REPLACE(LTRIM(RTRIM(v.vitalHeightCm)), ?, ?) / 100)
     WHEN ISNUMERIC(REPLACE(LTRIM(RTRIM(v.vitalHeight)), ?, ?)) = 1 AND
      ISNUMERIC(REPLACE(LTRIM(RTRIM(v.vitalHeightCm)), ?, ?)) <> 1
      THEN REPLACE(LTRIM(RTRIM(v.vitalHeight)), ?, ?)
     WHEN ISNUMERIC(REPLACE(LTRIM(RTRIM(v.vitalHeight)), ?, ?)) <> 1 AND
      ISNUMERIC(REPLACE(LTRIM(RTRIM(v.vitalHeightCm)), ?, ?)) = 1
      THEN REPLACE(LTRIM(RTRIM(vitalHeightCm)), ?, ?) / 100
     ELSE 0 END AS vitalHeight,
     CASE WHEN ISNUMERIC(REPLACE(LTRIM(RTRIM(v.pedVitBirLen)), ?, ?)) = 1
      THEN REPLACE(LTRIM(RTRIM(v.pedVitBirLen)), ?, ?) / 100
     ELSE 0 END AS pedVitBirLen,
     CASE WHEN ISNUMERIC(REPLACE(LTRIM(RTRIM(v.pedVitCurBracCirc)), ?, ?)) = 1
      THEN REPLACE(LTRIM(RTRIM(v.pedVitCurBracCirc)), ?, ?)
     ELSE 0 END AS pedVitCurBracCirc
    FROM a_vitals v,
     dw_encounter_snapshot e,
     ' . $GLOBALS['tempTableNames'][1]  . ' p
    WHERE e.patientID = v.patientID
     AND e.encounter_id = v.encounter_id
     AND e.dbSite = v.dbSite
     AND v.patientID = p.patientID
     AND p.dob IS NOT NULL
     AND v.visitDate >= p.dob
     AND
      (
       (ISNUMERIC(REPLACE(LTRIM(RTRIM(v.vitalWeight)), ?, ?)) = 1
        AND v.vitalWeightUnits IN (1, 2))
       OR
       (ISNUMERIC(REPLACE(LTRIM(RTRIM(v.pedVitBirWt)), ?, ?)) = 1
        AND v.pedVitBirWtUnits IN (1, 2))
       OR
       ISNUMERIC(REPLACE(LTRIM(RTRIM(v.vitalHeight)), ?, ?)) = 1
       OR
       ISNUMERIC(REPLACE(LTRIM(RTRIM(v.vitalHeightCm)), ?, ?)) = 1
       OR
       ISNUMERIC(REPLACE(LTRIM(RTRIM(v.pedVitBirLen)), ?, ?)) = 1
       OR
       ISNUMERIC(REPLACE(LTRIM(RTRIM(v.pedVitCurBracCirc)), ?, ?)) = 1
      )
      AND e.lastModified >= ?', $params);

  // For any visit where only weight was entered, if the patient is >= 20 years
  // old, add a previously entered height value (as long as it was after age 20)
  database()->query ('INSERT INTO ' . $GLOBALS['tempTableNames'][3] . '
    SELECT patientID, visitDate
    FROM ' . $GLOBALS['tempTableNames'][2] . '
    WHERE ageInMos >= 240
     AND vitalHeight = 0
     AND vitalWeight > 0');

  database()->query ('INSERT INTO ' . $GLOBALS['tempTableNames'][4] . '
    SELECT t.patientID, t.visitDate, MAX(s.visitDate)
    FROM ' . $GLOBALS['tempTableNames'][2] . ' s,
     ' . $GLOBALS['tempTableNames'][3] . ' t
    WHERE s.patientID = t.patientID
     AND s.ageInMos >= 240
     AND s.vitalHeight > 0
     AND s.visitDate < t.visitDate
    GROUP BY 1, 2');

  database()->query ('INSERT INTO ' . $GLOBALS['tempTableNames'][5] . '
    SELECT t.patientID, t.visitDate, s.vitalHeight
    FROM ' . $GLOBALS['tempTableNames'][2] . ' s,
     ' . $GLOBALS['tempTableNames'][4] . ' t
    WHERE s.patientID = t.patientID
     AND s.visitDate = t.prevHtDate');

  database()->query ('UPDATE ' . $GLOBALS['tempTableNames'][2] . ' s,
    ' . $GLOBALS['tempTableNames'][5] . ' t
    SET s.vitalHeight = t.prevHt
    WHERE s.patientID = t.patientID
     AND s.visitDate = t.visitDate');

  // Collect birth weight data from obs
  $obsData = database()->query ('
    SELECT e.patientID, e.visitdate, p.dob,
     CASE WHEN o2.value_numeric = 1
      THEN ROUND((REPLACE(LTRIM(RTRIM(o1.value_text)), ?, ?)) * 0.45359237, 1)
     WHEN o2.value_numeric = 2
      THEN REPLACE(LTRIM(RTRIM(o1.value_text)), ?, ?)
     ELSE 0 END AS birthWeight
    FROM obs o1, obs o2, dw_encounter_snapshot e, concept c1, concept c2,
     ' . $GLOBALS['tempTableNames'][1]  . ' p
    WHERE SUBSTR(e.patientID, 6) = o1.person_id
     AND o1.person_id = o2.person_id
     AND e.siteCode = o1.location_id
     AND o1.location_id = o2.location_id
     AND e.encounter_id = o1.encounter_id
     AND o1.encounter_id = o2.encounter_id
     AND e.patientID = p.patientID
     AND c1.concept_id = o1.concept_id
     AND c1.short_name = ?
     AND ISNUMERIC(REPLACE(LTRIM(RTRIM(o1.value_text)), ?, ?)) = 1
     AND c2.concept_id = o2.concept_id
     AND c2.short_name = ?
     AND o2.value_numeric IN (1, 2)
     AND p.dob IS NOT NULL
     AND e.visitdate >= p.dob
     AND e.lastModified >= ?', array (',', '.', ',', '.', 'birthWeight', ',', '.', 'birthWeightUnits', $lastModified))->fetchAll();

  // Collect nutritional edema data from obs
  $nutrEdemaData = database()->query ('
    SELECT e.patientID, e.visitdate,
     FLOOR(DATEDIFF(e.visitDate, p.dob) / ' . DAYS_IN_MONTH . ') AS ageInMos
    FROM obs o, dw_encounter_snapshot e, concept c,
     ' . $GLOBALS['tempTableNames'][1]  . ' p
    WHERE SUBSTR(e.patientID, 6) = o.person_id
     AND e.siteCode = o.location_id
     AND e.encounter_id = o.encounter_id
     AND e.patientID = p.patientID
     AND c.concept_id = o.concept_id
     AND c.short_name = ?
     AND o.value_boolean = 1
     AND p.dob IS NOT NULL
     AND e.visitdate >= p.dob
     AND e.lastModified >= ?', array ('pedSympNutritionalEdema', $lastModified))->fetchAll();

  // Collect arm circumference data from obs
  $armCircData = database()->query ('
    SELECT e.patientID, e.visitdate,
     FLOOR(DATEDIFF(e.visitDate, p.dob) / ' . DAYS_IN_MONTH . ') AS ageInMos,
     o.value_numeric AS pedVitCurBracCirc
    FROM obs o, dw_encounter_snapshot e, concept c,
     ' . $GLOBALS['tempTableNames'][1]  . ' p
    WHERE SUBSTR(e.patientID, 6) = o.person_id
     AND e.siteCode = o.location_id
     AND e.encounter_id = o.encounter_id
     AND e.patientID = p.patientID
     AND c.concept_id = o.concept_id
     AND c.short_name = ?
     AND ISNUMERIC(REPLACE(LTRIM(RTRIM(o.value_numeric)), ?, ?)) = 1
     AND p.dob IS NOT NULL
     AND e.visitdate >= p.dob
     AND e.lastModified >= ?', array ('vitalPb', ',', '.', $lastModified))->fetchAll();

  // Collect BMI data from obs
  $bmiData = database()->query ('
    SELECT e.patientID, e.visitdate,
     FLOOR(DATEDIFF(e.visitDate, p.dob) / ' . DAYS_IN_MONTH . ') AS ageInMos,
     o.value_numeric AS bmi
    FROM obs o, dw_encounter_snapshot e, concept c,
     ' . $GLOBALS['tempTableNames'][1]  . ' p
    WHERE SUBSTR(e.patientID, 6) = o.person_id
     AND e.siteCode = o.location_id
     AND e.encounter_id = o.encounter_id
     AND e.patientID = p.patientID
     AND c.concept_id = o.concept_id
     AND c.short_name = ?
     AND ISNUMERIC(REPLACE(LTRIM(RTRIM(o.value_numeric)), ?, ?)) = 1
     AND p.dob IS NOT NULL
     AND e.visitdate >= p.dob
     AND e.lastModified >= ?', array ('vitalIMC', ',', '.', $lastModified))->fetchAll();

  // Process birth weight data
  foreach ($obsData as $row) {
    // If any birthWeight values, use dob for visitDate
    // Don't overwrite any values pulled from other sources
    if ($row['birthWeight'] > 0) {
      database()->query ('
        INSERT INTO dw_nutrition_snapshot
        (patientID, visitDate, ageInMos, wtInKgs)
        VALUES
        (?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE patientID = ?', array ($row['patientID'], $row['dob'], 0, $row['birthWeight'], $row['patientID']));
    }
  }

  // Process vitals data
  // If any pedVitBirWt and/or pedVitBirLen values, use dob for visitDate
  // Don't overwrite any values pulled from other sources
  database()->query ('
    INSERT INTO dw_nutrition_snapshot
    SELECT patientID, dob, 0, pedVitBirWt, pedVitBirLen,
     CASE WHEN pedVitBirLen IS NULL OR pedVitBirLen <= 0
      THEN 0 ELSE pedVitBirWt / (pedVitBirLen * pedVitBirLen) END AS bmi,
     NULL, NULL
    FROM ' . $GLOBALS['tempTableNames'][2] . '
    WHERE (pedVitBirLen IS NOT NULL AND pedVitBirLen > 0)
     OR (pedVitBirWt IS NOT NULL AND pedVitBirWt > 0)
    ON DUPLICATE KEY UPDATE dw_nutrition_snapshot.patientID = ' . $GLOBALS['tempTableNames'][2] . '.patientID');

  // Process the other vitals data, overwriting if visitDate = dob
  database()->query ('
    INSERT INTO dw_nutrition_snapshot
    SELECT patientID, visitDate, ageInMos, vitalWeight, vitalHeight,
     CASE WHEN vitalHeight IS NULL OR vitalHeight <= 0
      THEN 0 ELSE vitalWeight / (vitalHeight * vitalHeight) END AS bmi,
     NULL, NULL
    FROM ' . $GLOBALS['tempTableNames'][2] . '
    WHERE (vitalHeight IS NOT NULL AND vitalHeight > 0)
     OR (vitalWeight IS NOT NULL AND vitalWeight > 0)
    ON DUPLICATE KEY UPDATE dw_nutrition_snapshot.ageInMos = ' . $GLOBALS['tempTableNames'][2] . '.ageInMos, wtInKgs = vitalWeight, htInMeters = vitalHeight, bmi = CASE WHEN vitalHeight IS NULL OR vitalHeight = 0 THEN 0 ELSE vitalWeight / (vitalHeight * vitalHeight) END');

  // Process nutritional edema data
  foreach ($nutrEdemaData as $row) {
    database()->query ('
      INSERT INTO dw_nutrition_snapshot
      (patientID, visitDate, ageInMos, nutritionalEdema)
      VALUES
      (?, ?, ?, ?)
      ON DUPLICATE KEY UPDATE nutritionalEdema = ?', array ($row['patientID'], $row['visitdate'], $row['ageInMos'], 1, 1));
  }

  // Process arm circumference data
  // First, use HIV+ form data, then overwrite with any obs data
  database()->query ('
    INSERT INTO dw_nutrition_snapshot
    (patientID, visitDate, ageInMos, armCirc)
    SELECT patientID, visitDate, ageInMos, pedVitCurBracCirc
    FROM ' . $GLOBALS['tempTableNames'][2] . '
    WHERE pedVitCurBracCirc IS NOT NULL AND pedVitCurBracCirc > 0
    ON DUPLICATE KEY UPDATE dw_nutrition_snapshot.armCirc = ' . $GLOBALS['tempTableNames'][2] . '.pedVitCurBracCirc');

  foreach ($armCircData as $row) {
    if ($row['pedVitCurBracCirc'] > 0) {
      database()->query ('
        INSERT INTO dw_nutrition_snapshot
        (patientID, visitDate, ageInMos, armCirc)
        VALUES
        (?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE armCirc = ?', array ($row['patientID'], $row['visitdate'], $row['ageInMos'], $row['pedVitCurBracCirc'], $row['pedVitCurBracCirc']));
    }
  }

  // Process BMI data from obs, if BMI provided overwrite calculated value
  foreach ($bmiData as $row) {
    if ($row['bmi'] > 0) {
      database()->query ('
        INSERT INTO dw_nutrition_snapshot
        (patientID, visitDate, ageInMos, bmi)
        VALUES
        (?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE bmi = ?', array ($row['patientID'], $row['visitdate'], $row['ageInMos'], $row['bmi'], $row['bmi']));
    }
  }
}

function nutritionSlices($key, $orgType, $time_period) {
      // SQL where additions for the denominator queries
      $denoms = array (
        "-1" => "r.patientID IS NULL
                 AND s.ageInMos BETWEEN 6 AND 59
                 AND
                  (s.nutritionalEdema = 1
                   OR
                   s.bmi > 0
                  )",
        "-2" => "r.patientID IS NULL
                 AND s.ageInMos BETWEEN 6 AND 59
                 AND s.bmi > 0",
        "-3" => "r.patientID IS NULL
                 AND s.ageInMos BETWEEN 60 AND 228 
                 AND s.bmi > 0",
        "-4" => "r.patientID IS NULL
                 AND s.ageInMos >= 229
                 AND s.bmi > 0",
        "-5" => "s.visitDate BETWEEN r.startDate AND r.stopDate
                 AND s.armCirc > 0",
        "-6" => "r.patientID IS NULL
                 AND FLOOR(DATEDIFF(e.visitDate, p.dob) / " . DAYS_IN_MONTH . ") BETWEEN 6 AND 59"
      );

      // SQL, parameters and 'denoms' index for all indicators
      $indicators = array (
        1 => array (
              " dw_nutrition_snapshot s
                LEFT JOIN dw_pregnancy_ranges r USING (patientID)
               WHERE r.patientID IS NULL
                AND s.ageInMos BETWEEN 6 AND 59
                AND s.wtInKgs > 0", array () , "-6"),
        2 => array (
              " dw_nutrition_snapshot s
                LEFT JOIN dw_pregnancy_ranges r USING (patientID)
               WHERE r.patientID IS NULL
                AND s.ageInMos BETWEEN 6 AND 59
                AND s.htInMeters > 0", array () , "-6"),
        3 => array (
              " dw_weightForHeightLookup l,
                patient p,
                dw_nutrition_snapshot s
                LEFT JOIN dw_nutrition_snapshot s2 ON s.patientID = s2.patientID
                 AND #period_value# = #period#(s2.visitDate#period_param#)
                 AND s2.nutritionalEdema = 1
                LEFT JOIN dw_pregnancy_ranges r ON s.patientID = r.patientID
               WHERE r.patientID IS NULL
                AND p.patientID = s.patientID
                AND s.ageInMos BETWEEN 6 AND 59
                AND s2.patientID IS NULL
                AND s.nutritionalEdema = 0
                AND
                 CASE WHEN p.sex = 1 THEN ?
                 WHEN p.sex = 2 THEN ? END = l.gender
                AND
                 CASE WHEN s.ageInMos <= 24 THEN ?
                 WHEN s.ageInMos BETWEEN 25 AND 59 THEN ? END = l.maxAgeInYrs
                AND ROUND(s.htInMeters * 200) / 2 = l.heightInCm
                AND s.htInMeters > 0
                AND s.wtInKgs > 0
                AND s.wtInKgs <= l.minus2Sd
                AND s.wtInKgs > l.minus3Sd", array ('f', 'm', '2', '5'), "-2"),
        4 => array (
              " patient p,
                dw_weightForHeightLookup l,
                dw_nutrition_snapshot s
                LEFT JOIN dw_pregnancy_ranges r ON s.patientID = r.patientID
               WHERE r.patientID IS NULL
                AND p.patientID = s.patientID
                AND s.ageInMos BETWEEN 6 AND 59
                AND
                 (s.nutritionalEdema = 1
                  OR
                  (CASE WHEN p.sex = 1 THEN ?
                   WHEN p.sex = 2 THEN ? END = l.gender
                   AND CASE WHEN s.ageInMos <= 24 THEN ?
                   WHEN s.ageInMos BETWEEN 25 AND 59 THEN ? END = l.maxAgeInYrs
                   AND ROUND(s.htInMeters * 200) / 2 = l.heightInCm
                   AND s.htInMeters > 0
                   AND s.wtInKgs > 0
                   AND s.wtInKgs <= l.minus3Sd
                  )
                 )", array ('f', 'm', '2', '5'), "-1"),
        5 => array (
              " patient p,
                dw_measureForAgeLookup l,
                dw_nutrition_snapshot s
                LEFT JOIN dw_pregnancy_ranges r ON s.patientID = r.patientID
               WHERE r.patientID IS NULL
                AND p.patientID = s.patientID
                AND s.ageInMos BETWEEN 60 AND 228
                AND
                 CASE WHEN p.sex = 1 THEN ?
                 WHEN p.sex = 2 THEN ? END = l.gender
                AND s.ageInMos = l.ageInMos
                AND l.measure = ?
                AND s.bmi > l.plus1Sd
                AND s.bmi <= l.plus2Sd", array ('f', 'm', 'bmi'), "-3"),
        6 => array (
              " patient p,
                dw_measureForAgeLookup l,
                dw_nutrition_snapshot s
                LEFT JOIN dw_pregnancy_ranges r ON s.patientID = r.patientID
               WHERE r.patientID IS NULL
                AND p.patientID = s.patientID
                AND s.ageInMos BETWEEN 60 AND 228
                AND
                 CASE WHEN p.sex = 1 THEN ?
                 WHEN p.sex = 2 THEN ? END = l.gender
                AND s.ageInMos = l.ageInMos
                AND l.measure = ?
                AND s.bmi > l.plus2Sd", array ('f', 'm', 'bmi'), "-3"),
        7 => array (
              " patient p,
                dw_measureForAgeLookup l,
                dw_nutrition_snapshot s
                LEFT JOIN dw_pregnancy_ranges r ON s.patientID = r.patientID
               WHERE r.patientID IS NULL
                AND p.patientID = s.patientID
                AND s.ageInMos BETWEEN 60 AND 228
                AND
                 CASE WHEN p.sex = 1 THEN ?
                 WHEN p.sex = 2 THEN ? END = l.gender
                AND s.ageInMos = l.ageInMos
                AND l.measure = ?
                AND s.bmi < l.minus2Sd
                AND s.bmi >= l.minus3Sd", array ('f', 'm', 'bmi'), "-3"),
        8 => array (
              " patient p,
                dw_measureForAgeLookup l,
                dw_nutrition_snapshot s
                LEFT JOIN dw_pregnancy_ranges r ON s.patientID = r.patientID
               WHERE r.patientID IS NULL
                AND p.patientID = s.patientID
                AND s.ageInMos BETWEEN 60 AND 228
                AND
                 CASE WHEN p.sex = 1 THEN ?
                 WHEN p.sex = 2 THEN ? END = l.gender
                AND s.ageInMos = l.ageInMos
                AND l.measure = ?
                AND s.bmi > 0
                AND s.bmi < l.minus3Sd", array ('f', 'm', 'bmi'), "-3"),
        9 => array (
              " dw_nutrition_snapshot s
                LEFT JOIN dw_pregnancy_ranges r USING (patientID)
               WHERE r.patientID IS NULL
                AND s.ageInMos >= 229
                AND s.bmi BETWEEN 18.51 AND 24.99", array (), "-4"),
        10 => array (
              " dw_nutrition_snapshot s
                LEFT JOIN dw_pregnancy_ranges r USING (patientID)
               WHERE r.patientID IS NULL
                AND s.ageInMos >= 229
                AND s.bmi >= 25
                AND s.bmi < 30", array (), "-4"),
        11 => array (
              " dw_nutrition_snapshot s
                LEFT JOIN dw_pregnancy_ranges r USING (patientID)
               WHERE r.patientID IS NULL
                AND s.ageInMos >= 229
                AND s.bmi >= 30", array (), "-4"),
        12 => array (
              " dw_nutrition_snapshot s
                LEFT JOIN dw_pregnancy_ranges r USING (patientID)
               WHERE r.patientID IS NULL
                AND s.ageInMos >= 229
                AND s.bmi > 0
                AND s.bmi <= 18.5", array (), "-4"),
        13 => array (
              " dw_nutrition_snapshot s
                LEFT JOIN dw_pregnancy_ranges r USING (patientID)
               WHERE s.visitDate BETWEEN r.startDate AND r.stopDate
                AND s.armCirc BETWEEN 0.01 AND 21", array (), "-5"),
        14 => array (
              " dw_nutrition_snapshot s
                LEFT JOIN dw_pregnancy_ranges r USING (patientID)
               WHERE s.visitDate BETWEEN r.startDate AND r.stopDate
                AND s.armCirc >= 23", array (), "-5"),
      );
 
      $slicesTempTables = createTempTables ("tempNutritionSlices", 2, array ("org_unit varchar(64), org_value varchar(255), indicator tinyint unsigned, time_period varchar(16), `year` smallint unsigned, period smallint unsigned, gender tinyint unsigned, `value` decimal(9,1), primary key (org_unit, org_value, indicator, time_period, `year`, period, gender)", "org_unit varchar(64), org_value varchar(255), indicator tinyint unsigned, time_period varchar(16), `year` smallint unsigned, period smallint unsigned, gender tinyint unsigned, `value` decimal(9,1), primary key (org_unit, org_value, indicator, time_period, `year`, period, gender)"));

      $baseInd = 1;
      foreach ($indicators as $ind => $arr) {
        // Run certain queries only if this indicator is the last of a group
        // that share the same denominator
        $denomInd = ($ind == 2 || $ind == 3 || $ind == 4 || $ind == 8 || $ind == 12 || $ind == 14) ? 1 : 0;

        // Store patientIDs per indicator for drill-down purposes
        foreach ($time_period as $period) {
          $period_value = $period . "(s.visitDate" . ($period == "Week" ? ", 2) " : ") ");
          $froms = array ("#period#", "#period_value#", "#period_param#");
          $tos = array ($period, $period_value, ($period == "Week" ? ", 2" : ""));
          $sql = "INSERT INTO dw_nutrition_patients 
            SELECT DISTINCT $ind, ?, YEAR(s.visitDate),
             $period_value, s.patientID
            FROM " .
            str_replace ($froms, $tos, $arr[0]);
          $rc = database()->query ($sql, array_merge (array ($period), str_replace ($froms, $tos, $arr[1])))->rowCount();

          if ($denomInd) {
            // Insert denominator patients into dw_nutrition_patients, but with
            // the denominator index as the indicator value
            if ($arr[2] > -6) {
              $sql = "INSERT INTO dw_nutrition_patients
                SELECT DISTINCT " . $arr[2] . ", ?, YEAR(s.visitDate),
                 $period_value, s.patientID
                FROM dw_nutrition_snapshot s
                 LEFT JOIN dw_pregnancy_ranges r USING (patientID)
                WHERE " . $denoms[$arr[2]];
            } else {
              // Denominator -6 is a special case, since it may include patients
              // not in the snapshot table, basically just all patients with a
              // visit in the period within the age group of the numerator.
              $period_value = $period . "(e.visitDate" . ($period == "Week" ? ", 2) " : ") ");
              $sql = "INSERT INTO dw_nutrition_patients
                SELECT DISTINCT " . $arr[2] . ", ?, YEAR(e.visitDate),
                 $period_value, e.patientID
                FROM " . $GLOBALS['tempTableNames'][1] . " p, encValidAll e
                 LEFT JOIN dw_pregnancy_ranges r ON e.patientID = r.patientID
                WHERE e.patientID = p.patientID
                 AND " . $denoms[$arr[2]] . "
                 AND e.encounterType IN (1, 2, 16, 17, 24, 25, 27, 28, 29, 31)";
            }
            $rc = database()->query ($sql, array ($period))->rowCount();
          }
        }

        // Store numerator data per indicator and org unit
        foreach ($orgType as $org_unit => $org_value) {
          $sql = "INSERT INTO " . $slicesTempTables[1] . "
            SELECT ?, $org_value, $ind, p.time_period, p.year, p.period,
             t.sex, COUNT(DISTINCT p.patientID)
            FROM dw_nutrition_patients p,
             patient t" .
             ($org_unit != "Haiti" ? ", clinicLookup l" : "") . " 
            WHERE p.patientID = t.patientID
             AND p.indicator = ?
             AND t.sex IN (1, 2) " .
             ($org_unit != "Haiti" ? "AND l.siteCode = LEFT(p.patientID, 5)" : "") . " 
            GROUP BY 1, 2, 3, 4, 5, 6, 7";
          $params = $org_unit == "Commune" ? array ($org_unit, "-", $ind) : array ($org_unit, $ind);
          $rc = database()->query ($sql, $params)->rowCount();

          if ($denomInd) {
            for ($i = $baseInd; $i <= $ind; $i++) {
              // Store denominator data per indicator and org unit
              $sql = "INSERT INTO " . $slicesTempTables[2] . "
                SELECT ?, $org_value, $i, p.time_period, p.year, p.period,
                 t.sex, COUNT(DISTINCT p.patientID)
                FROM dw_nutrition_patients p,
                 patient t" .
                 ($org_unit != "Haiti" ? ", clinicLookup l" : "") . " 
                WHERE p.patientID = t.patientID
                 AND p.indicator = ?
                 AND t.sex IN (1, 2) " .
                 ($org_unit != "Haiti" ? "AND l.siteCode = LEFT(p.patientID, 5)" : "") . " 
                GROUP BY 1, 2, 3, 4, 5, 6, 7";
              $params = $org_unit == "Commune" ? array ($org_unit, "-", $arr[2]) : array ($org_unit, $arr[2]);
              $rc = database()->query ($sql, $params)->rowCount();
            }
          }
        }

        // Merge num. and den. temp table rows into slices table
        if ($denomInd) {
          for ($i = $baseInd; $i <= $ind; $i++) {
            $sql = "INSERT INTO dw_nutrition_slices
              SELECT d.org_unit, d.org_value, $i, d.time_period, d.year,
               d.period, d.gender, 0, d.value
              FROM " . $slicesTempTables[2] . " d
              ON DUPLICATE KEY UPDATE value = VALUES(value), denominator = VALUES(denominator)";
            $rc = database()->query ($sql)->rowCount();
  
            $sql = "INSERT INTO dw_nutrition_slices
              SELECT d.org_unit, d.org_value, $i, d.time_period, d.year,
               d.period, d.gender, IFNULL(p.value, 0), d.value
              FROM " . $slicesTempTables[2] . " d LEFT JOIN
               " . $slicesTempTables[1] . " p USING (org_unit, org_value, indicator, time_period, year, period, gender)
              WHERE d.indicator = $i
              ON DUPLICATE KEY UPDATE value = VALUES(value)";
            $rc = database()->query ($sql)->rowCount();
          }
          // Clean-up
          truncateTable ($slicesTempTables[1]);
          truncateTable ($slicesTempTables[2]);
          $baseInd = $ind + 1;
        }
      }

      // Remove any rows where numerator and denominator are both zero
      $rc = database()->query ('DELETE FROM dw_nutrition_slices
        WHERE value = 0
         AND denominator = 0');
      dropTempTables ($slicesTempTables);
}
?>