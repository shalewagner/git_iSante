

INSERT INTO longWide ( patientid, dispDate, nxtDt, doseDays, numDaysdesc, dispaltnumdaysspecify, Regimen, DispDts)
SELECT e.patientid, 
CASE WHEN isdate(ymdToDate(dispdateyy,dispdatemm,dispdatedd)) = 1 THEN DATE(ymdToDate(dispdateyy,dispdatemm,dispdatedd)) 
ELSE DATE(ymdToDate(e.visitdateyy,e.visitdatemm,e.visitdatedd)) END as dispDate, 
DATE(ymdToDate(e.nxtVisityy,e.nxtVisitmm,e.nxtVisitdd)) as nxtDt, 
DATEDIFF(ymdToDate(e.nxtVisityy,e.nxtVisitmm,e.nxtVisitdd), ymdToDate(e.visitdateyy,e.visitdatemm,e.visitdatedd)) as doseDays, 
convert(group_concat(distinct digits(numdaysdesc)+0 order by digits(numdaysdesc)+0) using utf8) as numDaysdesc,  
convert(group_concat(distinct digits(dispaltnumdaysspecify)+0 order by digits(dispaltnumdaysspecify)+0) using utf8) as dispaltnumdaysspecify, 
convert(group_concat(distinct p.drugid order by p.drugid) using utf8) as Regimen, 
convert(group_concat(distinct ymdToDate(dispdateyy,dispdatemm,dispdatedd)) using utf8) as DispDts 
FROM encounter e, prescriptions p 
WHERE 
e.patientid = p.patientid and 
e.visitdateyy = p.visitdateyy and e.visitdatemm = p.visitdatemm and e.visitdatedd = p.visitdatedd and e.seqnum = p.seqnum and 
e.sitecode = p.sitecode AND
e.encountertype in (5,18) AND 
encStatus < 255 AND 
drugid IN ( 1, 3, 4, 5, 6, 7, 8, 10, 11, 12, 15, 16, 17, 20, 21, 22, 23, 26, 27, 28, 29, 31, 32, 33, 34, 87, 88) AND (dispensed = 1 OR dispAltNumPills IS NOT NULL OR ISDATE(ymdToDate(dispdateyy,dispdatemm,dispdatedd)) = 1 OR 
dispAltNumDays IS NOT NULL OR 
dispAltDosage IS NOT NULL) AND
(forPepPmtct = 2 OR forPepPmtct IS NULL)
GROUP BY 1,2;

INSERT INTO r34Summary (patientid) SELECT DISTINCT patientid FROM longWide;

/* compute registration date */
UPDATE r34Summary l, ( 
SELECT w.patientid, DATE(ymdToDate(visitDateYy,visitDateMm,visitDateDd)) as regdatefirst 
FROM encounter e, r34Summary w WHERE e.patientid = w.patientid AND e.encounterType in (10,15) ) f
SET l.regdatefirst = f.regdatefirst WHERE l.patientid = f.patientid;

/* delete patients less than 15 years old */
DELETE l FROM r34Summary l JOIN patient p ON l.patientid = p.patientid WHERE DATEDIFF(l.regdatefirst, ymdtodate(dobyy,1,1)) < 15*365; 
DELETE FROM longWide WHERE patientid NOT IN (SELECT patientid FROM r34Summary);

/* compute minimum dispense date */
UPDATE r34Summary l, (
SELECT patientid, MIN(dispDate) as dt FROM longWide GROUP by 1) w 
SET l.artStartDate = w.dt WHERE l.patientid = w.patientid;

/* compute minimum visit date */
UPDATE r34Summary l, (
SELECT e.patientid, DATE(MIN(ymdToDate(e.visitDateYy,e.visitDateMm,e.visitDateDd))) as encdatefirst 
FROM encounter e, r34Summary w WHERE e.patientid = w.patientid GROUP BY 1) f
SET l.encdatefirst = f.encdatefirst
WHERE l.patientid = f.patientid;

/* compute dosedays */
/* TODO - check before and after this computation */
UPDATE longWide SET dosedays = CASE WHEN ISDATE(nxtDt) = 1 AND DATEDIFF(nxtDt,dispdate) > 0 THEN DATEDIFF(nxtDt,dispdate)
WHEN LEFT(dispaltnumdaysspecify,2)+0 > 9 THEN LEFT(dispaltnumdaysspecify,2)+0
WHEN LEFT(dispaltnumdaysspecify,1)+0 = 0 THEN (CONCAT(SUBSTRING(dispaltnumdaysspecify,2,1),'0'))+0
WHEN LEFT(numdaysdesc,2)+0 > 9 THEN LEFT(numdaysdesc,2)+0 
WHEN LEFT(numdaysdesc,1)+0 = 0 THEN (CONCAT(SUBSTRING(numdaysdesc,2,1),'0'))+0 ElSE 0 END; 

select count(distinct patientid) from longWide where dosedays = 0;

/* find a few patients with the most dispenses */
select s.patientid, count(*) from longWide l, r34Summary s where l.patientid = s.patientid and year(l.dispDate) = 2017 group by 1 order by 2 desc limit 10;

/*
insert into patientAlert values (11100,'111009536',94,now()); 
insert into patientAlert values (11100,'111009744',95,now()); 
insert into patientAlert values (11100,'111009713',96,now()); 
insert into patientAlert values (11100,'111009702',97,now()); 
insert into patientAlert values (11100,'111009690',98,now());
insert into patientAlert values (11100,'1110011055',99,now());

select * from longWide where patientid = '111009536' order by dispDate;*/

/* compute intobserved and differences for numerator/denominator */
create table lwPDCdetail SELECT distinct w2.patientid, 
p2.period, w1.seqNum, 
p2.days as periodDays, 
s.artStartDate,
DATE_ADD(s.artStartDate,INTERVAL p1.days DAY) AS periodStart, 
DATE_ADD(s.artStartDate,interval p2.days-1 day) AS periodEnd,  
w1.dispDate AS beginDisp,
w2.dispDate AS endDisp, 
CASE WHEN w2.dispDate > DATE_ADD(s.artStartDate,interval p2.days-1 DAY) THEN datediff(date_add(s.artStartDate,interval p2.days-1 DAY),w2.dispDate) ELSE 0 END AS 'lastDifference',
w1.doseDays,
DATEDIFF(w2.dispDate,w1.dispDate) AS 'intObserved',  
w1.doseDays - DATEDIFF(w2.dispDate,w1.dispDate) AS 'dosedays-intObserved',
CASE WHEN w1.doseDays - DATEDIFF(w2.dispDate,w1.dispDate) > 0 THEN DATEDIFF(w2.dispDate,w1.dispDate) ELSE w1.dosedays END AS numerator
FROM longWide w1, longWide w2, hivPeriods p1, hivPeriods p2, r34Summary s 
WHERE p2.period = p1.period + 1 AND 
w1.dispDate BETWEEN date_add(s.artStartDate,interval p1.days day) AND 
date_add(s.artStartDate,interval p2.days-1 day) AND
w1.patientid = w2.patientid AND 
w2.seqNum = w1.seqNum + 1 AND
s.patientid = w1.patientid AND
left(w2.patientid,5) = '11100' 
ORDER BY 1,2,3;

DROP TABLE IF EXISTS r34Labs;
CREATE TABLE r34Labs
SELECT distinct l.patientid, ymdToDate(visitDateYy,visitDateMm,visitDateDd) as vd, 
labid, 
case when labid = 103 then 'viralLoad' else 'cd4' end as labType, 
digits(result)+0 as nResult, 
result, 
CASE WHEN ISDATE(ymdToDate(resultDateYy,resultDateMm,resultDateDd)) = 1 THEN DATE(ymdToDate(resultDateYy,resultDateMm,resultDateDd)) 
ELSE DATE(ymdToDate(resultDateYy,resultDateMm,15)) END AS resultDate, 
resultDateYy, resultDateMm, resultDateDd,
1 AS failVar
FROM labs l, longWide w WHERE l.patientid = w.patientid AND
labid in (103,176,2031,1561,1214) AND
isnumeric(digits(result)) = 1;
CREATE INDEX iPid ON r34Labs (patientid);

UPDATE r34Labs SET failVar = 0 WHERE labType = 'viralLoad' AND (
INSTR(result,"ind") > 0 OR
INSTR(result,"<300") > 0 OR
INSTR(result,"nondet") > 0 OR
INSTR(result,"notdet") > 0 OR
INSTR(result,"non-det") > 0 OR
INSTR(result,"not-det") > 0);

UPDATE r34Labs l, r34Summary w SET w.vLfailVar = 0 WHERE l.labType = 'viralLoad' AND 
l.patientid = w.patientid AND 
(ABS(DATEDIFF(resultDate,vd)) > 180 OR DATEDIFF(vd,artStartDate) < 180);

UPDATE r34Labs SET failVar = 1 WHERE labType = 'viralLoad' AND nResult >= 1000;

/* compute baseline CD4 */ 
UPDATE r34Summary w, (
SELECT r.patientid, r.vd, r.nResult, s.artStartDate, MIN(ABS(DATEDIFF(s.artStartDate,r.vd))) AS 'dayInterval'
FROM longWide l, r34Labs r, r34Summary s 
WHERE r.labType = 'cd4' AND l.patientid = r.patientid AND l.patientid = s.patientid and
r.vd BETWEEN DATE_ADD(s.artStartDate,INTERVAL -180 DAY) AND DATE_ADD(s.artStartDate,INTERVAL 7 DAY)
GROUP BY 1) b
SET w.baselineCD4 = b.nResult
WHERE w.patientid = b.patientid;

/* compute max CD4 */ 
UPDATE r34Summary w, (
SELECT r.patientid, max(nResult) AS nResult
FROM longWide l, r34Labs r, r34Summary s 
WHERE r.labType = 'cd4' AND l.patientid = r.patientid AND l.patientid = s.patientid AND
r.vd >= s.artStartDate
GROUP BY 1) b
SET w.maxCD4 = b.nResult
WHERE w.patientid = b.patientid;

select distinct l.*, w.* from r34Labs l, longWide w where l.patientid = w.patientid AND l.labtype = 'cd4' and l.patientid = '1115634204' order by vd;
select * from longWide where patientid = '1113445142' order by seqNum;
select count(distinct patientid) from longWide union
select count(distinct patientid) from longWide where baselineCD4 is not null;

/* compute success/failure - most recent viral load */
SELECT r.patientid, CASE WHEN failVar = 1 THEN 'failure' ELSE 'success' END AS 'xxx' 
FROM r34Labs r, ( 
SELECT patientid, max(resultdate) AS maxVL FROM r34Labs WHERE labType = 'viralLoad' GROUP BY 1
) a 
WHERE r.patientid = a.patientid AND r.labType = 'viralLoad' AND DATEDIFF(now(),a.maxVL) <= 90 AND  
r.patientid NOT IN (SELECT patientid FROM longWide l, r34Regimens g WHERE g.regName = '2nd' AND INSTR(l.regimen, g.drugids) > 0);

/* TODO - these queries are probably not correct */
SELECT CASE WHEN failVar = 1 THEN 'failure' ELSE 'success' END AS 'xxx', count(distinct a.patientid) 
FROM r34Labs r, ( 
SELECT patientid, max(resultdate) AS maxVL FROM r34Labs WHERE labType = 'viralLoad' GROUP BY 1
) a 
WHERE r.patientid = a.patientid AND r.labType = 'viralLoad' AND DATEDIFF(now(),a.maxVL) <= 90 AND  
r.patientid NOT IN (SELECT patientid FROM longWide l, r34Regimens g WHERE g.regName = '2nd' AND INSTR(l.regimen, g.drugids) > 0) group by 1;

SELECT r.patientid, r.vd, r.nResult, r.result, s.artStartDate, MIN(ABS(DATEDIFF(s.artStartDate,r.vd))) AS 'dayInterval'
FROM longWide l, r34Labs r, r34Summary s 
WHERE r.labType = 'cd4' AND 
l.patientid = r.patientid AND
l.patientid = s.patientid AND 
r.vd BETWEEN DATE_ADD(s.artStartDate,INTERVAL -180 DAY) AND DATE_ADD(s.artStartDate,INTERVAL 7 DAY)
GROUP BY 1,2,3;

// compute BMI 
// TODO: not correct yet
DROP TABLE IF EXISTS bmiDetail;
CREATE TEMPORARY TABLE bmiDetail SELECT s.patientid, ymdtodate(visitdateyy,visitdatemm,visitdatedd) AS visitDate, artStartDate,
CASE WHEN vitalHeight IS NOT NULL THEN vitalHeight*100+0 + vitalHeightCm+0 ELSE vitalHeightCm+0 END AS vitalHeight, 
CASE WHEN vitalWeightUnits = 2 THEN ROUND((REPLACE(LTRIM(RTRIM(vitalWeight)), ',', '.'))+0 * 0.453592, 2)+0 ELSE REPLACE(LTRIM(RTRIM(vitalWeight)), ',', '.')+0 END AS vitalWeight 
FROM vitals v, r34Summary s 
WHERE v.patientid = s.patientid AND (ISNUMERIC(vitalheight) = 1 or ISNUMERIC(vitalheightcm) = 1) AND ISNUMERIC(vitalweight) = 1;
CREATE INDEX iPid ON bmiDetail (patientid);

UPDATE r34Summary a, (
SELECT patientid, min(ABS(DATEDIFF(artstartdate,visitdate))) as minInt, visitdate, artstartdate, vitalHeight, vitalWeight, ROUND(vitalWeight/POWER(vitalHeight/100,2),2) AS bmi 
FROM bmiDetail 
WHERE vitalWeight/POW((vitalHeight/100),2) BETWEEN 1 AND 50 
GROUP BY 1) b
SET a.bmi = b.bmi
WHERE a.patientid = b.patientid;





