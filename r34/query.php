<?
$queryList = array(
"dropLongWide" => "DROP TABLE IF EXISTS longWide",
"createLongWide" => array("query" => "CREATE TABLE longWide ( seqNum bigint(20) NOT NULL AUTO_INCREMENT, patientid varchar(11) NOT NULL, dispDate DATE NOT NULL DEFAULT ?, nxtDt date DEFAULT NULL, doseDays int(7) DEFAULT NULL, numDaysdesc VARCHAR(50), dispaltnumdaysspecify VARCHAR(50), Regimen VARCHAR(50), DispDts VARCHAR(50), PRIMARY KEY (seqNum,patientid,dispDate), INDEX iPID (patientid) ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0","data" => "0000-00-00"),
"populateLongWide" => array("query" => "INSERT INTO longWide ( patientid, dispDate, nxtDt, numDaysdesc, dispaltnumdaysspecify, Regimen, DispDts) SELECT e.patientid, CASE WHEN isdate(ymdToDate(dispdateyy,dispdatemm,dispdatedd)) = 1 AND ymdToDate(dispdateyy,dispdatemm,dispdatedd) >= ymdToDate(e.visitdateyy,e.visitdatemm,e.visitdatedd) THEN DATE(ymdToDate(dispdateyy,dispdatemm,dispdatedd)) ELSE DATE(ymdToDate(e.visitdateyy,e.visitdatemm,e.visitdatedd)) END as dispDate, CASE WHEN isdate(ymdToDate(e.nxtVisityy,e.nxtVisitmm,e.nxtVisitdd)) THEN DATE(ymdToDate(e.nxtVisityy,e.nxtVisitmm,e.nxtVisitdd)) ELSE NULL END AS nxtDt, convert(group_concat(distinct digits(numdaysdesc)+0 order by digits(numdaysdesc)+0 SEPARATOR ?) using utf8) as numDaysdesc, convert(group_concat(distinct digits(dispaltnumdaysspecify)+0 order by digits(dispaltnumdaysspecify)+0 SEPARATOR ?) using utf8) as dispaltnumdaysspecify, convert(group_concat(distinct p.drugid order by p.drugid SEPARATOR ?) using utf8) as Regimen, convert(group_concat(distinct ymdToDate(dispdateyy,dispdatemm,dispdatedd) SEPARATOR ?) using utf8) as DispDts FROM encounter e, prescriptions p WHERE e.patientid = p.patientid and e.visitdateyy = p.visitdateyy and e.visitdatemm = p.visitdatemm and e.visitdatedd = p.visitdatedd and e.seqnum = p.seqnum and e.sitecode = p.sitecode AND e.encountertype in (5,18) AND encStatus < 255 AND drugid IN ( 1, 3, 4, 5, 6, 7, 8, 10, 11, 12, 15, 16, 17, 20, 21, 22, 23, 26, 27, 28, 29, 31, 32, 33, 34, 87, 88) AND (dispensed = 1 OR dispAltNumPills IS NOT NULL OR ISDATE(ymdToDate(dispdateyy,dispdatemm,dispdatedd)) = 1 OR dispAltNumDays IS NOT NULL OR dispAltDosage IS NOT NULL) AND (forPepPmtct = 2 OR forPepPmtct IS NULL) GROUP BY 1,2 ORDER BY 1,2","data" => "|,|,|,|"),
"dropSeq" => "DROP TABLE IF EXISTS lwSeq",
"maxSeqNum" => "CREATE TABLE lwSeq SELECT patientid, MAX(seqNum) AS maxSeq, MIN(seqNum) AS minSeq FROM longWide GROUP BY 1",
"alterMaxSeq" => "ALTER TABLE lwSeq ADD PRIMARY KEY (patientid)",
"delete1stMonoRegimens" => "DELETE a FROM longWide a JOIN (SELECT lw.patientid, min(lw.seqNum) as minOk FROM longWide lw, r34Regimens r WHERE lw.Regimen = r.drugIDs AND r.regID != 8 GROUP BY 1) b ON a.patientID = b.patientid WHERE a.seqNum < b.minOk",
"updateSeq" => "UPDATE lwSeq s, (SELECT patientid, MIN(seqNum) AS x FROM longWide GROUP BY 1) l SET minSeq = x WHERE s.patientid = l.patientid",
"computeDoseDays" => array("query" => "UPDATE longWide SET doseDays = IF(DATEDIFF(nxtDt,dispDate) > 0, DATEDIFF(nxtDt,dispDate), IF(SUBSTRING_INDEX(dispAltNumDaysSpecify,?,1)+0 > 0, SUBSTRING_INDEX(dispAltNumDaysSpecify,?,1)+0, IF(SUBSTRING_INDEX(numDaysDesc,?,1)+0 > 0, SUBSTRING_INDEX(numDaysDesc,?,1)+0, NULL)))","data" => "'|','|','|','|'"),
"truncateSummary" => "TRUNCATE TABLE r34Summary",
"summaryPopulate" => "INSERT INTO r34Summary (patientid) SELECT DISTINCT patientid FROM longWide",
"registrationDate" => "UPDATE r34Summary l, ( SELECT w.patientid, DATE(ymdToDate(visitDateYy,visitDateMm,visitDateDd)) as regdatefirst FROM encounter e, r34Summary w WHERE e.patientid = w.patientid AND e.encounterType in (10,15) ) f SET l.regdatefirst = f.regdatefirst WHERE l.patientid = f.patientid",
"deleteChildren1" => "DELETE l FROM r34Summary l JOIN patient p ON l.patientid = p.patientid WHERE DATEDIFF(l.regdatefirst, ymdtodate(IF(isnumeric(dobyy) = 1 AND dobyy+0 BETWEEN 1901 AND YEAR(" . $end180 . "),dobyy,NULL), IF(ISNUMERIC(dobmm) = 1 AND dobmm+0 BETWEEN 1 AND 12 ,dobmm, 6),15)) < 15*365", 
"deleteChildren2" => "DELETE FROM longWide WHERE patientid NOT IN (SELECT patientid FROM r34Summary)",
"ComputeArtStartDate" => "UPDATE r34Summary l, ( SELECT patientid, MIN(dispDate) as dt FROM longWide GROUP by 1) w SET l.artStartDate = w.dt WHERE l.patientid = w.patientid",
"deleteGT4years" => "DELETE FROM r34Summary WHERE DATEDIFF(" . $end180 . ",artstartdate)/365 > 4",
"delete2ndLineRegimens" => "DELETE FROM r34Summary WHERE patientid in (SELECT l.patientid FROM longWide l, r34Regimens r WHERE INSTR(l.regimen,r.drugids) AND r.regID = 7)",
"ComputeMinimumVisitDate" => "UPDATE r34Summary l, ( SELECT e.patientid, DATE(MIN(ymdToDate(e.visitDateYy,e.visitDateMm,e.visitDateDd))) as encdatefirst FROM encounter e, r34Summary w WHERE e.patientid = w.patientid GROUP BY 1) f SET l.encdatefirst = f.encdatefirst WHERE l.patientid = f.patientid",
"vitalsPregCheck" => "UPDATE r34Summary r, vitals v SET r.pregnant = 1 WHERE r.patientid = v.patientid AND v.pregnant = 1 AND ABS(DATEDIFF(r.artstartdate,ymdtodate(visitdateyy,visitdatemm,visitdatedd))) BETWEEN 0 AND 180",
"LaborandDeliveryPregCheck" => "UPDATE r34Summary r, encounter e SET pregnant = 1 WHERE r.patientid = e.patientid AND encountertype = 26 AND ABS(DATEDIFF(r.artstartdate,ymdtodate(visitdateyy,visitdatemm,visitdatedd))) BETWEEN 0 AND 180",
"obgynFormPregCheck" => "UPDATE r34Summary a,( SELECT e.patientid, ymdtodate(visitdateyy,visitdatemm,visitdatedd) as visitdate FROM concept c, obs o, encounter e, r34pregNames r WHERE c.concept_id = o.concept_id AND e.encounter_id = o.encounter_id AND e.sitecode = o.location_id AND c.short_name = r.short_name) b SET a.pregnant = 1 WHERE a.patientid = b.patientid AND ABS(DATEDIFF(a.artStartDate,b.visitdate)) BETWEEN 0 AND 180",
"MedicallyEligPregCheck" => "UPDATE r34Summary a, (SELECT patientid, ymdtodate(visitdateyy,visitdatemm,visitdatedd) as visitdate FROM medicalEligARVs m WHERE (pmtct = 1 OR pregnantwomen = 1 OR breastfeedingwomen = 1)) b SET pregnant = 1 WHERE a.patientid = b.patientid AND ABS(DATEDIFF(a.artStartDate,b.visitdate)) BETWEEN 0 AND 180",
"computeGender" => "UPDATE r34Summary r, patient p SET r.gender = CASE WHEN p.sex = 1 AND r.pregnant = 0 THEN 0 WHEN p.sex = 1 AND r.pregnant = 1 THEN 1 WHEN p.sex = 2 THEN 2 ELSE 3 END WHERE r.patientid = p.patientid",
"dropLabs" => "DROP TABLE IF EXISTS r34Labs",
"createLabsTable" => array("query" => "CREATE TABLE r34Labs ( patientid varchar(11) NOT NULL, vd DATE NOT NULL DEFAULT ?, labs_id int unsigned, labid INT, labType VARCHAR(25), nResult VARCHAR(50), resultDate VARCHAR(200), artStartInterval INT, result VARCHAR(200), PRIMARY KEY (patientid,vd,labs_id,labid,nResult) ) ENGINE=InnoDB DEFAULT CHARSET=utf8","data" => "0000-00-00"),
"PopulateLabsTable" => array("query" => "INSERT INTO r34Labs (patientid,vd, labs_id, labid,labType,nResult,resultDate, artStartInterval,result) SELECT l.patientid, ymdToDate(e.visitDateYy, e.visitDateMm,e.visitDateDd) as vd, l.labs_id, labid, CASE WHEN labid = 103 THEN ? ELSE ? END AS labType, group_concat(distinct DIGITS(result) order by l.labs_id desc SEPARATOR ?) AS nResult, group_concat(distinct CASE WHEN ISDATE(ymdtodate(resultdateyy,resultdatemm,resultdatedd)) = 1 THEN DATE(ymdtodate(resultdateyy,resultdatemm,resultdatedd)) ELSE DATE(ymdToDate(e.visitDateYy,e.visitDateMm,e.visitDateDd)) END ORDER BY l.labs_id desc SEPARATOR ?) as resultDate, ABS(DATEDIFF(r.artStartDate,ymdToDate(e.visitDateYy,e.visitDateMm,e.visitDateDd))) AS artStartInterval, group_concat(distinct result order by l.labs_id desc SEPARATOR ?) AS result FROM encounter e, labs l, r34Summary r WHERE l.patientid = r.patientid AND l.patientid = e.patientid and concat(l.visitdateyy,l.visitdatemm,l.visitdatedd) = concat(e.visitdateyy,e.visitdatemm,e.visitdatedd) and l.sitecode = e.sitecode and l.seqNum = e.seqNum and e.encountertype in (6,19) and labid in (103,176,1214,1561,2031) AND LENGTH(result) > 0 AND result IS NOT NULL GROUP BY 1,2","data" => "viralLoad,cd4,|,|,|"),
"deleteLabsResult>180" => "DELETE FROM r34Labs WHERE LEFT(resultDate,10) > DATE_ADD(vd,INTERVAL 180 DAY)",
"dropTBdrugs" => "DROP TABLE IF EXISTS tbDrugs",
"createTbDrugs" => array("query" => "CREATE TABLE tbDrugs ( seqNum bigint(20) NOT NULL AUTO_INCREMENT, patientid varchar(11) NOT NULL, dispDate DATE NOT NULL DEFAULT ?, nxtDt date DEFAULT NULL, numDaysdesc VARCHAR(50), dispaltnumdaysspecify VARCHAR(50), DispDts VARCHAR(50), PRIMARY KEY (seqNum,patientid,dispDate), INDEX iPID (patientid) ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0","data" => "0000-00-00"),
"PopulateTBdrugsTable" => array("query" => "INSERT INTO tbDrugs ( patientid, dispDate, nxtDt, numDaysdesc, dispaltnumdaysspecify, DispDts) SELECT e.patientid, CASE WHEN isdate(ymdToDate(dispdateyy,dispdatemm,dispdatedd)) = 1 AND ymdToDate(dispdateyy,dispdatemm,dispdatedd) >= ymdToDate(e.visitdateyy,e.visitdatemm,e.visitdatedd) THEN DATE(ymdToDate(dispdateyy,dispdatemm,dispdatedd)) ELSE DATE(ymdToDate(e.visitdateyy,e.visitdatemm,e.visitdatedd)) END as dispDate, CASE WHEN isdate(ymdToDate(e.nxtVisityy,e.nxtVisitmm,e.nxtVisitdd)) THEN DATE(ymdToDate(e.nxtVisityy,e.nxtVisitmm,e.nxtVisitdd)) ELSE NULL END AS nxtDt, convert(group_concat(distinct digits(numdaysdesc)+0 order by digits(numdaysdesc)+0 SEPARATOR ?) using utf8) as numDaysdesc, convert(group_concat(distinct digits(dispaltnumdaysspecify)+0 order by digits(dispaltnumdaysspecify)+0 SEPARATOR ?) using utf8) as dispaltnumdaysspecify, convert(group_concat(distinct ymdToDate(dispdateyy,dispdatemm,dispdatedd) SEPARATOR ?) using utf8) as DispDts FROM encounter e, prescriptions p WHERE e.patientid = p.patientid and e.visitdateyy = p.visitdateyy and e.visitdatemm = p.visitdatemm and e.visitdatedd = p.visitdatedd and e.seqnum = p.seqnum and e.sitecode = p.sitecode AND e.encountertype in (5,18) AND encStatus < 255 AND drugid IN (13,24,25,30) AND (dispensed = 1 OR dispAltNumPills IS NOT NULL OR ISDATE(ymdToDate(dispdateyy,dispdatemm,dispdatedd)) = 1 OR dispAltNumDays IS NOT NULL OR dispAltDosage IS NOT NULL) AND (forPepPmtct = 2 OR forPepPmtct IS NULL) GROUP BY 1,2 ORDER BY 1,2","data" => "|,|,|"),
"DropTemporaryWhoStageTable" => "DROP TABLE IF EXISTS hStage",
"PopulateWhoStageTable" => "CREATE TABLE hStage SELECT a.patientid,3 AS stage FROM r34Summary a, medicalEligARVs b WHERE a.patientid = b.patientid AND pedmedeligwho3 = 1 AND ymdToDate(visitdateyy,visitdatemm,visitdatedd) BETWEEN DATE_ADD(a.artStartDate,INTERVAL -90 DAY) AND DATE_ADD(a.artStartDate,INTERVAL 7 DAY) UNION SELECT a.patientid, 4 FROM r34Summary a, medicalEligARVs b WHERE a.patientid = b.patientid AND pedmedeligwho4 = 1 AND ymdToDate(visitdateyy,visitdatemm,visitdatedd) BETWEEN DATE_ADD(a.artStartDate,INTERVAL -90 DAY) AND DATE_ADD(a.artStartDate,INTERVAL 7 DAY) UNION SELECT a.patientid, 3 FROM r34Summary a, medicalEligARVs b WHERE a.patientid = b.patientid AND whoiii = 1 AND ymdToDate(visitdateyy,visitdatemm,visitdatedd) BETWEEN DATE_ADD(a.artStartDate,INTERVAL -90 DAY) AND DATE_ADD(a.artStartDate,INTERVAL 7 DAY) UNION SELECT a.patientid, 4 FROM r34Summary a, medicalEligARVs b WHERE a.patientid = b.patientid AND whoiv = 1 AND ymdToDate(visitdateyy,visitdatemm,visitdatedd) BETWEEN DATE_ADD(a.artStartDate,INTERVAL -90 DAY) AND DATE_ADD(a.artStartDate,INTERVAL 7 DAY) UNION SELECT a.patientid, CASE WHEN currenthivstage = 1 THEN 1 WHEN currenthivstage = 2 THEN 2 WHEN currenthivstage = 4 THEN 3 WHEN currenthivstage = 8 THEN 4 END FROM r34Summary a, medicalEligARVs b WHERE a.patientid = b.patientid AND currenthivstage in (1,2,4,8) AND ymdToDate(visitdateyy,visitdatemm,visitdatedd) BETWEEN DATE_ADD(a.artStartDate,INTERVAL -90 DAY) AND DATE_ADD(a.artStartDate,INTERVAL 7 DAY)",
"ExtractMaxWhoStage" => "UPDATE r34Summary a, ( SELECT patientid, max(stage) as stage FROM hStage GROUP BY 1 ) b SET a.whoStage = b.stage WHERE a.patientid = b.patientid",
"FactorSymptomsToWhoStage" => "UPDATE r34Summary a, ( SELECT e.patientid, ymdtodate(visitdateyy,visitdatemm,visitdatedd) as visitdate, r.stage FROM concept c, obs o, encounter e, r34stageNames r WHERE c.concept_id = o.concept_id AND e.encounter_id = o.encounter_id AND e.sitecode = o.location_id AND c.short_name = r.short_name) b SET a.whoStage = b.stage WHERE a.patientid = b.patientid AND a.whoStage <> 4 AND b.visitdate BETWEEN DATE_ADD(a.artStartDate,INTERVAL -90 DAY) AND DATE_ADD(a.artStartDate,INTERVAL 7 DAY)",
"FactorDxToWhoStage" => array("query" => "UPDATE r34Summary a, ( SELECT patientid, ymdtodate(visitdateyy,visitdatemm,visitdatedd) as visitdate, whostage FROM a_conditions WHERE conditionactive = 1 AND whostage in (?,?)) b SET a.whoStage = IF(b.whostage = ?,3,4) WHERE a.patientid = b.patientid AND a.whoStage <> 4 AND b.visitdate BETWEEN DATE_ADD(a.artStartDate,INTERVAL -90 DAY) AND DATE_ADD(a.artStartDate,INTERVAL 7 DAY)", "data" => "STAGE III,STAGE IV,STAGE III"),
"drop abc" => "DROP TABLE IF EXISTS abc",
"computeBaselineCD4-Step1" => array("query" => "CREATE TABLE abc SELECT l.patientid, MIN(artstartInterval) as minI FROM r34Labs l, r34Summary s WHERE l.labtype = ? AND vd BETWEEN DATE_ADD(s.artStartDate,interval -90 day) AND DATE_ADD(s.artStartDate,INTERVAL 7 day) AND l.patientid = s.patientid GROUP BY 1", "data" => "cd4"),
"drop xyz" => "DROP TABLE IF EXISTS xyz",
"computeBaselineCD4-Step2" => array("query" => "CREATE TABLE xyz SELECT y.patientid, LEFT(nResult,LENGTH(nResult)-instr(nResult,?))+0 AS n FROM r34Labs y, abc r WHERE y.artStartInterval = r.minI AND y.labtype = ? AND y.patientid = r.patientid", "data" =>"|,cd4"), 
"computeBaselineCD4-Step3" => "UPDATE r34Summary a, xyz b SET a.baselineCD4 = b.n WHERE a.patientid = b.patientid",
"computeCD4cat" => "UPDATE r34Summary SET baselineCD4cat = CASE 
WHEN baselineCD4 < 200 THEN 0 
WHEN baselineCD4 BETWEEN 200 AND 349 THEN 1 
WHEN baselineCD4 BETWEEN 350 AND 499 THEN 2 
WHEN baselineCD4 >= 500 THEN 3 ELSE 4 END",
"FactorCd4ToWhoStage" => "UPDATE r34Summary SET whoStage = CASE WHEN baselineCD4cat = 2 AND whoStage < 2 THEN 2 WHEN baselineCD4cat = 1 AND whoStage < 3 THEN 3 WHEN baselineCD4cat = 0 AND whoStage < 4 THEN 4 ELSE whoStage END WHERE baselineCD4 IN (0,1,2)",
"FactorTbDrugToWhoStage" => "UPDATE r34Summary a, tbDrugs b SET a.whoStage = 4 WHERE a.patientid = b.patientid AND b.dispDate BETWEEN DATE_ADD(a.artStartDate,INTERVAL -90 DAY) AND DATE_ADD(a.artStartDate,INTERVAL 7 DAY)",
"droplwPDC0detail" => "DROP TABLE IF EXISTS lwPDC0detail",
"generatelwPDC0detail" => "CREATE TABLE lwPDC0detail 
SELECT w2.patientid, w1.seqNum, " . $start0 . " AS periodStart,  " . $end0 . " AS periodEnd, w1.dispDate AS preDate, w2.dispDate, w3.dispDate AS postDate, w2.doseDays,
IF(w1.dispdate > " . $start0 . " AND w1.seqNum = q.minSeq AND w1.dosedays > 0, LEAST(w1.dosedays,DATEDIFF(w2.dispDate,w1.dispDate)),0) + IF(w1.dispdate < " . $start0 . " AND w2.dispdate >= " . $start0 . " AND w1.doseDays > DATEDIFF(" . $start0 . ",w1.dispDate), LEAST(w1.dosedays - DATEDIFF(" . $start0 . ",w1.dispdate), DATEDIFF(w2.dispDate," . $start0 . ")),0) AS pre,
IF(w2.dispdate >= " . $start0 . " AND w3.dispdate < " . $end0 . ", LEAST(w2.dosedays,DATEDIFF(w3.dispDate,w2.dispDate)),0) as during,
IF(w2.dispdate <= " . $end0 . " AND w3.dispdate > " . $end0 . ", LEAST(w2.dosedays,DATEDIFF(" . $end0 . ",w2.dispdate)),0) as after,
IF(w1.dispdate > " . $start0 . " AND w2.seqNum = q.minSeq, -DATEDIFF(" . $start0 . ", w1.dispDate),0) + IF(w1.dispDate < " . $start0 . " AND (w1.dosedays IS NULL OR w1.dosedays = 0), DATEDIFF(w2.dispdate," . $start0 . "),0) as denStart,
IF(w1.dispDate >= " . $start0 . " AND w3.dispdate <= " . $end0 . " AND (w2.dosedays IS NULL OR w3.dosedays = 0), DATEDIFF(w2.dispdate,w3.dispdate),0) AS denIn,
IF(w3.dispDate > " . $end0 . " AND  (w3.dosedays IS NULL OR w3.dosedays = 0), DATEDIFF(" . $end0 . ",w2.dispdate),0) as denEnd
FROM longWide w1, longWide w2, longWide w3, r34Summary a, lwSeq q
WHERE w1.patientid = w2.patientid AND w2.patientid = w3.patientid AND w2.seqNum = w1.seqNum + 1 AND w3.seqNum = w2.seqNum + 1 AND w1.patientid = a.patientid AND w3.patientid = q.patientid 
UNION SELECT w1.patientid, q.maxSeq + 1, " . $start0 . ", " . $end0 . ", w1.dispDate, w2.dispDate, w2.nxtDt, w2.doseDays,
IF(w1.dispdate < " . $start0 . " AND w2.dispdate > " . $start0 . " AND w1.doseDays > DATEDIFF(" . $start0 . ",w1.dispDate), LEAST(w1.dosedays - DATEDIFF(" . $start0 . ",w1.dispdate), DATEDIFF(w2.dispDate," . $start0 . ")),0) AS pre,
IF(w2.dispdate >= " . $start0 . " AND w2.nxtDt < " . $end0 . ", LEAST(w2.dosedays,DATEDIFF(w2.nxtDt,w2.dispDate)),0) as during,
IF(w2.dispdate <= " . $end0 . " AND w2.nxtDt > " . $end0 . ", LEAST(w2.dosedays,DATEDIFF(" . $end0 . ",w2.dispdate)),0) as after,
IF(w1.dispDate < " . $start0 . " AND (w1.dosedays IS NULL OR w1.dosedays = 0), DATEDIFF(w2.dispdate," . $start0 . "),0) as denStart,
IF(w1.dispDate >= " . $start0 . " AND w2.nxtDt <= " . $end0 . " AND w2.dosedays IS NULL, DATEDIFF(w2.dispdate,w2.nxtDt),0) AS denIn,
IF(w2.nxtDt > " . $end0 . " AND  (w2.dosedays IS NULL OR w2.dosedays = 0), DATEDIFF(" . $end0 . ",w2.dispdate),0) as denEnd
from longWide w1, longWide w2, r34Summary a, lwSeq q 
where w1.seqNum = q.maxSeq - 1 and w2.seqNum = q.maxSeq and w1.patientid = w2.patientid and w2.patientid = q.patientid and w1.patientid = a.patientid
UNION SELECT l.patientid, seqNum, " . $start0 . ", " . $end0 . ", null, dispdate, nxtDt, doseDays,0, 
IF(dispdate >= " . $start0 . " and nxtDt < " . $end0 . ", LEAST(dosedays,datediff(nxtDt,dispdate)),0),
IF(dispdate <= " . $end0 . " and nxtdt > " . $end0 . ", LEAST(dosedays,datediff(" . $end0 . ",dispdate)),0),0,DATEDIFF(" . $start0 . ",dispDate),
IF(nxtDt > " . $end0 . " AND (dosedays is null or dosedays = 0),datediff(" . $end0 . ",dispdate),0) as denEnd
FROM longWide l, r34Summary r, (SELECT patientid, COUNT(*) FROM longWide GROUP BY 1 HAVING COUNT(*) = 1) b
WHERE l.patientid = b.patientid AND l.patientid = r.patientid
ORDER BY 1,2",
"pdc0" => "UPDATE r34Summary a JOIN (SELECT patientid, SUM(pre+during+after)/(90 + SUM(denStart+denIn+denEnd)) AS pdc FROM lwPDC0detail 
WHERE dispDate BETWEEN periodStart AND periodEnd GROUP BY 1) b ON a.patientid = b.patientid
SET a.pdc0 = b.pdc WHERE a.patientid = b.patientid",
"droplwPDC90detail" => "DROP TABLE IF EXISTS lwPDC90detail",
"generatelwPDC90detail" => "CREATE TABLE lwPDC90detail 
SELECT w2.patientid, w1.seqNum, " . $start90 . " AS periodStart,  " . $end90 . " AS periodEnd, w1.dispDate AS preDate, w2.dispDate, w3.dispDate AS postDate, w2.doseDays,
IF(w1.dispdate > " . $start90 . " AND w1.seqNum = q.minSeq AND w1.dosedays > 0, LEAST(w1.dosedays,DATEDIFF(w2.dispDate,w1.dispDate)),0) + IF(w1.dispdate < " . $start90 . " AND w2.dispdate >= " . $start90 . " AND w1.doseDays > DATEDIFF(" . $start90 . ",w1.dispDate), LEAST(w1.dosedays - DATEDIFF(" . $start90 . ",w1.dispdate), DATEDIFF(w2.dispDate," . $start90 . ")),0) AS pre,
IF(w2.dispdate >= " . $start90 . " AND w3.dispdate < " . $end90 . ", LEAST(w2.dosedays,DATEDIFF(w3.dispDate,w2.dispDate)),0) as during,
IF(w2.dispdate <= " . $end90 . " AND w3.dispdate > " . $end90 . ", LEAST(w2.dosedays,DATEDIFF(" . $end90 . ",w2.dispdate)),0) as after,
IF(w1.dispdate > " . $start90 . " AND w2.seqNum = q.minSeq, -DATEDIFF(" . $start90 . ", w1.dispDate),0) + IF(w1.dispDate < " . $start90 . " AND (w1.dosedays IS NULL OR w1.dosedays = 0), DATEDIFF(w2.dispdate," . $start90 . "),0) as denStart,
IF(w1.dispDate >= " . $start90 . " AND w3.dispdate <= " . $end90 . " AND (w2.dosedays IS NULL OR w3.dosedays = 0), DATEDIFF(w2.dispdate,w3.dispdate),0) AS denIn,
IF(w3.dispDate > " . $end90 . " AND  (w3.dosedays IS NULL OR w3.dosedays = 0), DATEDIFF(" . $end90 . ",w2.dispdate),0) as denEnd
FROM longWide w1, longWide w2, longWide w3, r34Summary a, lwSeq q
WHERE w1.patientid = w2.patientid AND w2.patientid = w3.patientid AND w2.seqNum = w1.seqNum + 1 AND w3.seqNum = w2.seqNum + 1 AND w1.patientid = a.patientid AND w3.patientid = q.patientid 
UNION SELECT w1.patientid, q.maxSeq + 1, " . $start90 . ", " . $end90 . ", w1.dispDate, w2.dispDate, w2.nxtDt, w2.doseDays,
IF(w1.dispdate < " . $start90 . " AND w2.dispdate > " . $start90 . " AND w1.doseDays > DATEDIFF(" . $start90 . ",w1.dispDate), LEAST(w1.dosedays - DATEDIFF(" . $start90 . ",w1.dispdate), DATEDIFF(w2.dispDate," . $start90 . ")),0) AS pre,
IF(w2.dispdate >= " . $start90 . " AND w2.nxtDt < " . $end90 . ", LEAST(w2.dosedays,DATEDIFF(w2.nxtDt,w2.dispDate)),0) as during,
IF(w2.dispdate <= " . $end90 . " AND w2.nxtDt > " . $end90 . ", LEAST(w2.dosedays,DATEDIFF(" . $end90 . ",w2.dispdate)),0) as after,
IF(w1.dispDate < " . $start90 . " AND (w1.dosedays IS NULL OR w1.dosedays = 0), DATEDIFF(w2.dispdate," . $start90 . "),0) as denStart,
IF(w1.dispDate >= " . $start90 . " AND w2.nxtDt <= " . $end90 . " AND w2.dosedays IS NULL, DATEDIFF(w2.dispdate,w2.nxtDt),0) AS denIn,
IF(w2.nxtDt > " . $end90 . " AND  (w2.dosedays IS NULL OR w2.dosedays = 0), DATEDIFF(" . $end90 . ",w2.dispdate),0) as denEnd
from longWide w1, longWide w2, r34Summary a, lwSeq q 
where w1.seqNum = q.maxSeq - 1 and w2.seqNum = q.maxSeq and w1.patientid = w2.patientid and w2.patientid = q.patientid and w1.patientid = a.patientid
UNION SELECT l.patientid, seqNum, " . $start90 . ", " . $end90 . ", null, dispdate, nxtDt, doseDays,0, 
IF(dispdate >= " . $start90 . " and nxtDt < " . $end90 . ", LEAST(dosedays,datediff(nxtDt,dispdate)),0),
IF(dispdate <= " . $end90 . " and nxtdt > " . $end90 . ", LEAST(dosedays,datediff(" . $end90 . ",dispdate)),0),0,DATEDIFF(" . $start90 . ",dispDate),
IF(nxtDt > " . $end90 . " AND (dosedays is null or dosedays = 0),datediff(" . $end90 . ",dispdate),0) as denEnd
FROM longWide l, r34Summary r, (SELECT patientid, COUNT(*) FROM longWide GROUP BY 1 HAVING COUNT(*) = 1) b
WHERE l.patientid = b.patientid AND l.patientid = r.patientid
ORDER BY 1,2",
"pdc90" => "UPDATE r34Summary a JOIN (SELECT patientid, SUM(pre+during+after)/(90 + SUM(denStart+denIn+denEnd)) AS pdc FROM lwPDC90detail 
WHERE dispDate BETWEEN periodStart AND periodEnd GROUP BY 1) b ON a.patientid = b.patientid
SET a.pdc90 = b.pdc WHERE a.patientid = b.patientid",
"droplwPDC180detail" => "DROP TABLE IF EXISTS lwPDC180detail",
"generatelwPDCdetail" => "CREATE TABLE lwPDC180detail 
SELECT w2.patientid, w1.seqNum, " . $start180 . " AS periodStart,  " . $end180 . " AS periodEnd, w1.dispDate AS preDate, w2.dispDate, w3.dispDate AS postDate, w2.doseDays,
IF(w1.dispdate > " . $start180 . " AND w1.seqNum = q.minSeq AND w1.dosedays > 0, LEAST(w1.dosedays,DATEDIFF(w2.dispDate,w1.dispDate)),0) + IF(w1.dispdate < " . $start180 . " AND w2.dispdate >= " . $start180 . " AND w1.doseDays > DATEDIFF(" . $start180 . ",w1.dispDate), LEAST(w1.dosedays - DATEDIFF(" . $start180 . ",w1.dispdate), DATEDIFF(w2.dispDate," . $start180 . ")),0) AS pre,
IF(w2.dispdate >= " . $start180 . " AND w3.dispdate < " . $end180 . ", LEAST(w2.dosedays,DATEDIFF(w3.dispDate,w2.dispDate)),0) as during,
IF(w2.dispdate <= " . $end180 . " AND w3.dispdate > " . $end180 . ", LEAST(w2.dosedays,DATEDIFF(" . $end180 . ",w2.dispdate)),0) as after,
IF(w1.dispdate > " . $start180 . " AND w2.seqNum = q.minSeq, -DATEDIFF(" . $start180 . ", w1.dispDate),0) + IF(w1.dispDate < " . $start180 . " AND (w1.dosedays IS NULL OR w1.dosedays = 0), DATEDIFF(w2.dispdate," . $start180 . "),0) as denStart,
IF(w1.dispDate >= " . $start180 . " AND w3.dispdate <= " . $end180 . " AND (w2.dosedays IS NULL OR w3.dosedays = 0), DATEDIFF(w2.dispdate,w3.dispdate),0) AS denIn,
IF(w3.dispDate > " . $end180 . " AND  (w3.dosedays IS NULL OR w3.dosedays = 0), DATEDIFF(" . $end180 . ",w2.dispdate),0) as denEnd
FROM longWide w1, longWide w2, longWide w3, r34Summary a, lwSeq q
WHERE w1.patientid = w2.patientid AND w2.patientid = w3.patientid AND w2.seqNum = w1.seqNum + 1 AND w3.seqNum = w2.seqNum + 1 AND w1.patientid = a.patientid AND w3.patientid = q.patientid 
UNION SELECT w1.patientid, q.maxSeq + 1, " . $start180 . ", " . $end180 . ", w1.dispDate, w2.dispDate, w2.nxtDt, w2.doseDays,
IF(w1.dispdate < " . $start180 . " AND w2.dispdate > " . $start180 . " AND w1.doseDays > DATEDIFF(" . $start180 . ",w1.dispDate), LEAST(w1.dosedays - DATEDIFF(" . $start180 . ",w1.dispdate), DATEDIFF(w2.dispDate," . $start180 . ")),0) AS pre,
IF(w2.dispdate >= " . $start180 . " AND w2.nxtDt < " . $end180 . ", LEAST(w2.dosedays,DATEDIFF(w2.nxtDt,w2.dispDate)),0) as during,
IF(w2.dispdate <= " . $end180 . " AND w2.nxtDt > " . $end180 . ", LEAST(w2.dosedays,DATEDIFF(" . $end180 . ",w2.dispdate)),0) as after,
IF(w1.dispDate < " . $start180 . " AND (w1.dosedays IS NULL OR w1.dosedays = 0), DATEDIFF(w2.dispdate," . $start180 . "),0) as denStart,
IF(w1.dispDate >= " . $start180 . " AND w2.nxtDt <= " . $end180 . " AND w2.dosedays IS NULL, DATEDIFF(w2.dispdate,w2.nxtDt),0) AS denIn,
IF(w2.nxtDt > " . $end180 . " AND  (w2.dosedays IS NULL OR w2.dosedays = 0), DATEDIFF(" . $end180 . ",w2.dispdate),0) as denEnd
from longWide w1, longWide w2, r34Summary a, lwSeq q 
where w1.seqNum = q.maxSeq - 1 and w2.seqNum = q.maxSeq and w1.patientid = w2.patientid and w2.patientid = q.patientid and w1.patientid = a.patientid
UNION SELECT l.patientid, seqNum, " . $start180 . ", " . $end180 . ", null, dispdate, nxtDt, doseDays,0, 
IF(dispdate >= " . $start180 . " and nxtDt < " . $end180 . ", LEAST(dosedays,datediff(nxtDt,dispdate)),0),
IF(dispdate <= " . $end180 . " and nxtdt > " . $end180 . ", LEAST(dosedays,datediff(" . $end180 . ",dispdate)),0),0,DATEDIFF(" . $start180 . ",dispDate),
IF(nxtDt > " . $end180 . " AND (dosedays is null or dosedays = 0),datediff(" . $end180 . ",dispdate),0) as denEnd
FROM longWide l, r34Summary r, (SELECT patientid, COUNT(*) FROM longWide GROUP BY 1 HAVING COUNT(*) = 1) b
WHERE l.patientid = b.patientid AND l.patientid = r.patientid
ORDER BY 1,2",
"pdc180" => "UPDATE r34Summary a JOIN (SELECT patientid, SUM(pre+during+after)/(180 + SUM(denStart+denIn+denEnd)) AS pdc FROM lwPDC180detail 
WHERE dispDate BETWEEN periodStart AND periodEnd GROUP BY 1) b ON a.patientid = b.patientid
SET a.pdc180 = b.pdc WHERE a.patientid = b.patientid",
"gap3count" => "UPDATE r34Summary a JOIN (SELECT patientid, count(*) as cnt from lwPDC180detail WHERE (
DATEDIFF(postDate,dispDate) - dosedays >= 3 OR 
(preDate < periodStart AND dispdate > periodStart AND DATEDIFF(dispDate,preDate) + dosedays >= 3) OR
(dispdate < periodEnd AND postDate > periodEnd AND DATEDIFF(periodEnd,dispDate) >= 3))
AND dispdate between periodStart AND periodEnd GROUP BY 1) b ON a.patientid = b.patientid
SET gap3count180 = b.cnt",
"pdcfall" =>   "UPDATE r34Summary a, (SELECT patientid from r34Summary WHERE pdc0 - pdc90 >= .1 group by 1) b set pdcfall = 1 where a.patientid = b.patientid",
"computeNewestVLdate" => array("query" => "UPDATE r34Summary a, (
SELECT r.patientid, max(vd) AS vd FROM r34Labs r, r34Summary s WHERE r.labType = ? AND r.patientid = s.patientid GROUP BY 1) b
SET a.vllast_date = vd
WHERE a.patientid = b.patientid", "data" => "viralLoad"),
"viralLoadFailSuccess" => array("query" => "UPDATE r34Summary a, r34Labs b
SET vllast_pfail = CASE WHEN b.nResult > 1000 THEN 1 ELSE 0 END, 
vllast_success = CASE WHEN DATEDIFF(DATE_ADD(" . $end180 . ",INTERVAL -90 DAY),DATE_ADD(b.vd,INTERVAL -90 DAY)) <= 90 AND (b.nResult < 1000 OR INSTR(result,?) > 0 OR INSTR(result,?) > 0 OR INSTR(result,?) > 0 OR INSTR(result,?) > 0 OR INSTR(result,?) > 0 OR INSTR(result,?) > 0 OR INSTR(result,?) > 0 OR INSTR(result,?) > 0) THEN 1
ELSE 0 END
WHERE a.patientid = b.patientid AND a.vllast_date = b.vd AND b.labType = ?", "data" => "no,int,tnd,<300,nondet,notdet,non-det,not-det,viralLoad"),
"baselineRegimen" => "UPDATE r34Summary a, (SELECT l.patientid, r.regID FROM longWide l, r34Regimens r, (
SELECT patientid, MIN(seqNum) as minS FROM longWide GROUP BY 1) a 
WHERE a.patientid = l.patientid AND a.minS = l.seqNum AND l.regimen = r.drugids) b
SET a.regimen = b.regID
WHERE a.patientid = b.patientid",
"dropbmiTemp" => "DROP TABLE IF EXISTS bmiTemp",
"bmiTemp" => "CREATE TABLE bmiTemp SELECT patientid, IF(vitalWeightUnits = 2, vw * 0.453592, vw) / pow(((vh * 100 + vhc)/100),2) AS value FROM (
SELECT s.patientid, ymdToDate(v.visitdateyy,v.visitdatemm,v.visitdatedd) AS vd, DIGITS(vitalWeight)+0 AS vw, vitalWeightUnits, DIGITS(vitalHeight)+0 AS vh, DIGITS(vitalHeightCm)+0 AS vhc 
FROM vitals v, r34Summary s 
WHERE v.patientid = s.patientid AND 
DIGITS(vitalWeight)+0 > 0 AND ((DIGITS(vitalHeight)+0) * 100 + DIGITS(vitalHeightCm)+0) > 0 AND 
ymdToDate(v.visitdateyy,v.visitdatemm,v.visitdatedd) BETWEEN DATE_ADD(s.artStartDate,INTERVAL -180 DAY) AND DATE_ADD(s.artStartDate, INTERVAL 7 day) AND 
IF(vitalWeightUnits = 2, (DIGITS(vitalWeight)+0) * 0.453592, DIGITS(vitalWeight)+0) between 22 and 136 GROUP BY 1) c",
"bmi" => "INSERT INTO r34Summary (patientid, bmi) SELECT patientid, value FROM bmiTemp ON DUPLICATE KEY UPDATE bmi = VALUES(bmi)",
"bmicat" => "INSERT INTO r34Summary (patientid, bmicat) SELECT patientid, CASE
WHEN value < 18.5 THEN 0 
WHEN value >= 18.5 AND value < 25 THEN 1
WHEN value >= 25 AND value < 30 THEN 2
WHEN value >= 30 THEN 3
ELSE 4 END FROM bmiTemp ON DUPLICATE KEY UPDATE bmicat = VALUES(bmicat)",
"preartdays" => "UPDATE r34Summary SET preartdays = DATEDIFF(artStartDate,encdatefirst)",
"agecat" => "UPDATE r34Summary a, (
SELECT r.patientid, FLOOR(DATEDIFF(artstartdate,ymdtodate(IF(isnumeric(dobyy) = 1 AND dobyy+0 BETWEEN 1901 AND YEAR(" . $end180 . "),dobyy,NULL), IF(ISNUMERIC(dobmm) = 1 AND dobmm+0 BETWEEN 1 AND 12 ,dobmm, 6),15)) / 365) AS ageartstart FROM r34Summary r, patient p WHERE r.patientid = p.patientid) b
SET a.agecat = CASE 
WHEN ageartstart < 25 THEN 0
WHEN ageartstart >= 25 AND ageartstart < 35 THEN 1
WHEN ageartstart >= 35 AND ageartstart < 50 THEN 2
WHEN ageartstart >= 50 THEN 3
ELSE 4 END
WHERE a.patientid = b.patientid",
"risk_gender" => "UPDATE r34Summary SET risk_gender   = 
-44.67083*IF(gender = 1,1,0) +
30.57897* IF(gender = 2,1,0) +
38.83717* IF(gender = 3,1,0)",
"risk_age" => "UPDATE r34Summary SET risk_age   = 
-11.01293*IF(agecat = 1,1,0) + 
-26.27305*IF(agecat = 2,1,0) + 
-45.01253*IF(agecat = 3,1,0) +
-98.05792*IF(agecat = 4,1,0)",
"maritalStatus" => "UPDATE r34Summary a, patient b
SET a.marital_status = b.maritalstatus
WHERE a.patientid = b.patientid",
"risk_marital"=> "UPDATE r34Summary SET risk_marital =
       0*IF(marital_status IN (1,2),1,0) +
11.72425*IF(marital_status IN (4,8),1,0) + 
 2.62293*IF(marital_status = 16,1,0) + 
 5.85281*IF(marital_status IN (0,32,NULL),1,0)", 
"risk_cd4" => "UPDATE r34Summary SET risk_cd4 = 
-71.05391*IF(baselineCD4cat = 1,1,0) +
-81.09986*IF(baselineCD4cat = 2,1,0) +
-97.72722*IF(baselineCD4cat = 3,1,0) +
-35.89984*IF(baselineCD4 = 4,1,0)",
"risk_bmi" => "UPDATE r34Summary a, bmiTemp b SET a.risk_bmi =
        0*IF(value >= 14.5 AND value < 18.5,1,0) +  
-20.18563*IF(value >= 18.5 AND value < 25,1,0) +
-60.20525*IF(value >= 25 AND value < 30,1,0) +
-46.01367*IF(value BETWEEN 30 AND 40,1,0) +
 -6.43656*IF(value < 14.5 OR value > 40,1,0)
WHERE a.patientid = b.patientid",
"risk_who" => "UPDATE r34Summary SET risk_who =  
-4.5233*IF(whostage IS NULL,1,0) +
20.19184*IF(whostage = 2,1,0) + 
38.15259*IF(whostage = 3,1,0) + 
58.18041*IF(whostage = 4,1,0)",
"risk_test" => "UPDATE r34Summary a, (SELECT r.patientid, MIN(DATEDIFF(artStartDate,ymdToDate(firsttestyy,firsttestmm,IF(ISNUMERIC(firsttestdd) = 1 AND firsttestdd+0 BETWEEN 1 AND 31, firsttestdd,15)))) as testenroll  
FROM vitals v, r34Summary r WHERE v.patientid = r.patientid GROUP BY 1) b
SET risk_test =  
 4.95099*IF(testenroll >= 3 AND testenroll <= 29,1,0) +
 7.74691*IF(testenroll >= 30 AND testenroll <= 364,1,0) +
17.19205*IF(testenroll >= 365,1,0) +
 9.72316*IF(testenroll IS NULL,1,0)
WHERE a.patientid = b.patientid",
"risk_regimen"=> "UPDATE r34Summary SET risk_regimen = 
 7.01872*IF(regimen = 1,1,0) + 
14.44537*IF(regimen = 2,1,0) + 
32.67827*IF(regimen = 3,1,0) + 
24.09195*IF(regimen = 4,1,0) +  
48.07717*IF(regimen = 5,1,0) + 
17.57296*IF(regimen = 8,1,0)",
"risk_pdc" => "UPDATE r34Summary SET risk_pdc = 
-52.52749*IF(DATEDIFF(" . $end180 . ",artStartDate) BETWEEN 90 AND 180, pdc0, pdc180)", 
"risk_pdcfall" => "UPDATE r34Summary SET risk_pdcfall = 
11.0674*pdcfall",
"risk_gap3" => "UPDATE r34Summary SET risk_gap3 = 11.19824*gap3count180",
"risk_preart" => "UPDATE r34Summary SET risk_preart = -.01655*preartdays",
"riskscore" => "UPDATE r34Summary SET riskscore = 300 + risk_pdc + risk_pdcfall + risk_gap3 + risk_preart + risk_gender + risk_age + risk_marital + risk_cd4 + risk_bmi + risk_test + risk_regimen",
"computeRiskLevel" => "UPDATE r34Summary 
SET riskLevel = CASE WHEN vllast_pfail = 1 THEN 500 WHEN vllast_success = 1 THEN 100
ELSE CASE WHEN riskScore < 260 THEN 200 WHEN riskScore BETWEEN 261 AND 305 THEN 300 ELSE 400 END END",
"saveRiskHistory" => "INSERT INTO r34Scores SELECT patientid, " . $end180 . ", riskScore, riskLevel FROM r34Summary ON DUPLICATE KEY UPDATE riskScore = VALUES(riskScore), riskLevel = VALUES(riskLevel)",
"clearRiskQueue" => "DELETE FROM patientAlert WHERE alertID BETWEEN 100 AND 500",
"loadRiskQueue" => "INSERT INTO patientAlert SELECT LEFT(patientid,5)+0, patientid, riskLevel," . $end180 . " FROM r34Summary"
)
?>
