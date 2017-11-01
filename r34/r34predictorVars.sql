/*
Date: May 2017
File purpose: Explain data processing for:
	pregnancy variable, 
	WHO stage variable, 
	Cotrim prophylaxis variable, and 
	TB treatment or prophylaxis variable (all at start of ART)

PREGNANCY OR POSTPARTUM AT BASELINE

variable pregartstart
	This is a 0/1 variable which will be used to create a 4-status gender variable (0=non-pregnant woman, 1=pregnant woman, 2=man, 3=gender unknown)
any sign of pregnancy WHERE ABS(DATEDIFF(artstartdate,visitdate)) >= 180

Signs of pregnancy:

	pregnancy noted on clinical intake or follow up form (formid==1 or formid==2)
	conditionIDs associated with pregnancy on clinical intake or follow up form (formid==1 or formid==2)
	PMTCT listed as an ART eligibility criteria
	pregnancy-related conditions or labor and delivery noted on OB-GYN forms

See queries used to set up the following data tables (extracts)

--vitalsBplusmissingtxt
--laborBplusmissingtxt
--obBplusmissingtxt
--eligibleBplusmissingtxt

Vitals data: vitalsBplusmissingtxt:
**use visitdate and variable called "pregnant"
**pregartstart=1 IF pregnant==1 and ABS(DATEDIFF(artstartdate,visitdate)) >= 180 */
UPDATE r34Summary r, vitals v
SET r.pregnant = 1
WHERE r.patientid = v.patientid AND
v.pregnant = 1 AND 
ABS(DATEDIFF(r.artstartdate,ymdtodate(visitdateyy,visitdatemm,visitdatedd))) >= 180;

/*Labor and delivery data: laborBplusmissingtxt
**use visitdate associated with this form
**pregartstart=1 WHERE ABS(DATEDIFF(artstartdate,visitdate)) >= 180 */
UPDATE r34Summary r, encounter e
SET pregnant = 1
WHERE r.patientid = e.patientid AND
encountertype = 26 AND
ABS(DATEDIFF(r.artstartdate,ymdtodate(visitdateyy,visitdatemm,visitdatedd))) >= 180;

//Data on conditions from OBgyn forms: obBplusmissingtxt
UPDATE r34Summary a,(
select concat(o.location_id,o.person_id) as patientid, ymdtodate(visitdateyy,visitdatemm,visitdatedd) as visitdate FROM concept c, obs o, encounter e 
WHERE c.concept_id = o.concept_id AND 
e.encounter_id = o.encounter_id AND
e.sitecode = o.location_id AND
(short_name = "retardCroissanceIU" OR short_name ="birthPlanHIVPrevention" OR short_name ="motherPregWeeks" OR short_name ="pregnantDDRYy" OR short_name ="pregnantDDRDd" OR short_name ="pregnantDDRMm" OR short_name ="eclampsiaA" OR short_name ="hemorragieA" OR short_name ="membraneRuptureA" OR short_name ="menacePremaA" OR short_name ="hyperGraviA" OR short_name ="preEclampsieA" OR short_name ="htapregnancyA" OR short_name ="grossesseUterineG" OR short_name ="breastfeeding" OR short_name ="eclampsia" OR short_name ="hemorragie" OR short_name ="membraneRupture" OR short_name ="menacePrema" OR short_name ="diabetespregnancy" OR short_name ="grossesseEctopique" OR short_name ="preEclampsie" OR short_name ="foetalMovementChangeSymptom" OR short_name ="hyperGravi" OR short_name ="htapregnancy" OR short_name ="homeVisit" OR short_name ="HIVBabyPreventionPlan" OR short_name ="groupSupport" OR short_name ="educationBddy" OR short_name ="residentialPlanMatron" OR short_name ="birthTransitionPlan" OR short_name ="motherClub" OR short_name ="dispensationARV" OR short_name ="ptme" OR short_name ="educationInd" OR short_name ="evalplanWeekOfPregnancy" OR short_name ="birthHospitalName" OR short_name ="grossesseUterineA" OR short_name ="birthPlace" OR short_name ="antenatalVisit" OR short_name ="suiviPrenatal" OR short_name ="laborFetalHeartRate" OR short_name ="grossesseUterine" OR short_name ="examObPosition" OR short_name ="laborPresentation" OR short_name ="examObContraction" OR short_name ="laborUterine")) b 
SET a.pregnant = 1
WHERE a.patientid = b.patientid AND
ABS(DATEDIFF(a.artStartDate,b.visitdate)) >= 180; 

//ART eligibility data: eligibleBplusmissingtxt
**use visitdate and variables called "pmtct" "pregnantwomen" and "breastfeedingwomen"
UPDATE r34Summary a, (SELECT patientid, ymdtodate(visitdateyy,visitdatemm,visitdatedd) as visitdate FROM medicalEligARVs m
WHERE (pmtct = 1 OR pregnantwomen = 1 OR breastfeedingwomen = 1)) b
SET pregnant = 1
WHERE a.patientid = b.patientid AND
ABS(DATEDIFF(a.artStartDate,b.visitdate)) >= 180;

UPDATE r34Summary r, patient p 
SET r.gender = CASE 
WHEN p.sex = 1 AND r.pregnant = 0 THEN 0
WHEN p.sex = 1 AND r.pregnant = 1 THEN 1
WHEN p.sex = 2 THEN 2
ELSE 3
END
WHERE r.patientid = p.patientid;

/*
WHO STAGE AT BASELINE

WHO stage at start of ART: establish a variable called whostageartstart
**This is a categorical variable which will have 5 categories (1=Stage 1, 2=Stage 2, 3=Stage 3, 4=Stage 4, 5=Missing)
**We will use indicators of WHO stage in the period < DATE_ADD(artstartdate,INTERVAL 7 DAY)
**WHO stage is the maximum stage observed across the indicators (imissingemissing upcoded to the highest stage)

**We will consider indicators of WHO stage to be:

	WHO stage as noted on criteria for ART eligibility (formid==1 or formid==2)
	symptoms grouped by WHO stage on clinical intake or follow up form (formid==1 or formid==2)
	diagnoses grouped by WHO stage on clinical intake or follow up form (formid==1 or formid==2)
	CD4 count from lab test results during the time window

Set up variable called whoStageBL

//See queries used to set up the following data tables (extracts)


--eligibleBplusmissingtxt
--visitObsBplusmissingtxt
--dxBplusmissingtxt
--labBplusmissingtxt

ART eligibility using eligibleBplusmissingtxt
use the highest stage ever indicated on these variables: pedmedeligwho3 pedmedeligwho4 whoiii whoiv currenthivstage
note that coding on "currenthivstage" is 1=stage 1, 2=stage 2, 4=stage 3, and 8=stage 4 while whoiii is coded as 1=stage 3
whoStageBL == highest value of above variables */

CREATE TEMPORARY TABLE hStage SELECT patientid,  3 AS stage FROM medicalEligARVs WHERE pedmedeligwho3 = 1
UNION SELECT patientid,  4 from medicalEligARVs WHERE pedmedeligwho4 = 1
UNION SELECT patientid,  3 from medicalEligARVs WHERE whoiii         = 1
UNION SELECT patientid,  4 from medicalEligARVs WHERE whoiv          = 1
UNION SELECT patientid,  case 
WHEN currenthivstage = 1 THEN 1
WHEN currenthivstage = 2 THEN 2 
WHEN currenthivstage = 4 THEN 3 
WHEN currenthivstage = 8 THEN 4 END FROM medicalEligARVs where currenthivstage in (1,2,4,8);
UPDATE r34Summary a, (
SELECT patientid, max(stage) as stage FROM hStage GROUP BY 1
) b
SET a.whoStage = b.stage
WHERE a.patientid = b.patientid;

/*Symptoms: using visitObsBplusmissingtxt for presence of symptoms indicating either stage 3 or stage 4
keep if visitdate is less than or equal artstartdate + 7 days
recode whoStageBL=stage 3 if  name=="weightLossPlusTenPercMo" OR name=="wtLossTenPercWithDiarrMo" OR name=="diarrheaPlusMo" OR name=="feverPlusMo" AND whoStageBL is not == stage 4
recode whoStageBL=stage 4 if  if name=="wtLossTenPercWithDiarrMo" AND whoStageBL is not == stage 4 */

UPDATE r34Summary a, (
SELECT e.patientid, ymdtodate(visitdateyy,visitdatemm,visitdatedd) as visitdate
FROM concept c, obs o, encounter e
WHERE c.concept_id = o.concept_id AND
e.encounter_id = o.encounter_id AND
e.sitecode = o.location_id AND 
c.short_name in ('weightLossPlusTenPercMo','wtLossTenPercWithDiarrMo','diarrheaPlusMo','feverPlusMo')) b
SET whoStage = 3
WHERE a.patientid = b.patientid AND
a.whoStage <> 4 AND
b.visitdate <= DATE_ADD(a.artStartDate,INTERVAL 7 DAY);

/*Diagnoses: using dxBplusmissingtxt for presence of diagnoses indicating either stage 3 or stage 4
keep if conditionactive==1 AND visitdate is less than or equal artstartdate + 7 days
use variable called whostage to indicate stage of diagnosis
recode whoStageBL=stage 3 if  whostage==3 AND whoStageBL is not == stage 4
recode whoStageBL=stage 4 if  whostage==4 AND whoStageBL is not == stage 4 */

UPDATE r34Summary a, (
SELECT patientid, ymdtodate(visitdateyy,visitdatemm,visitdatedd) as visitdate, CASE WHEN whostage = 'STAGE III' THEN 3 WHEN whostage = 'STAGE IV' THEN 4 END AS STAGE
FROM a_conditions
WHERE conditionactive = 1 AND
whostage in ('STAGE III','STAGE IV')) b
SET a.whoStage = CASE WHEN b.stage = 3 THEN 3 WHEN b.stage = 4 THEN 4 END
WHERE a.patientid = b.patientid AND
(a.whoStage <> 4 AND b.stage = 4) OR (a.whoStage <> 4 AND b.stage = 3) AND
b.visitdate <= DATE_ADD(a.artStartDate,INTERVAL 7 DAY);


/**CD4 test results
**can process this in the same way described for processing CD4 indicators of ART failure, to determine baseline CD4:

//key variables from the raw data are:

visitdate
labid
result
resultdate

**disregard CD4% results
**keep if labid==176 OR labid==2031 OR labid==1561 OR labid==1214 
**baseline CD4 is the result which falls closest to the artstartdate in the baseline period, where CD4 lab test visitdate = 180 days before up to 7 days after artstartdate

**clean the resultdate values
	**recode resultdatedd = 15 if >31
	**recode resultdatemm= missing if resultdatemm >12 or = 0
	**recode resultdate=visitdate if resultdatemm OR resultdateyy is missing
	**identify result dates where difference in dates between visitdate and resultdate is >OR180 daysORmissing  This could be bad datamissing  Calculate datedif = visitdate - resultdate and take the absolute value

**clean the cd4 result values		
	**destring the result values, removing commas and internal spaces from within the strings
	**extract only the numeric portion of the values
	**recode result = missing if result <0
	**recode result = missing if result >2500
	**if more than 1 cd4 result is associated with a specific visitdate, recode result for that visitdate to be the mean value of the multiple results

**Now classify baseline CD4 by WHO stage, creating variable called cd4StageBL */
CREATE TEMPORARY TABLE bCD4toStage SELECT patientid, CASE WHEN baselineCD4 >= 500 AND baselineCD4 is not NULL THEN 1
WHEN baselineCD4 BETWEEN 350 AND 499 THEN 2 
WHEN baselineCD4 BETWEEN 200 AND 349 THEN 3 
WHEN baselineCD4 < 200 THEN 4 END AS stage
FROM r34Summary;

UPDATE r34Summary a, bCD4toStage b
SET a.whoStage = CASE WHEN b.stage = 3 AND a.whoStage <> 4 THEN 3 WHEN b.stage = 4 AND a.whoStage <> 4 THEN 4 END
WHERE a.patientid = b.patientid AND
(a.whoStage <> 4 AND b.stage = 4) OR (a.whoStage <> 4 AND b.stage = 3);

/*recode whoStageBL=stage 3 if  cd4StageBL==3 AND whoStageBL is not == stage 4
recode whoStageBL=stage 4 if  cd4StageBL==4 AND whoStageBL is not == stage 4

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//COTRIM OR TB DRUGS AT BASELINE
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//On Cotrimoxizole at start of ART: establish a variable called cotrimBL
**This is a 0/1 variable for any indication of a Cotrim dispense before artstartdate (using the artstartdate calculated as part of the PDC calculation)
**Cotrim is drugid==9 
//On TB treatment or prophylaxis at start of ART: establish a variable called tbRxBL
**This is a 0/1 variable for any indication of a dispense of a TB medication before artstartdate (using the artstartdate calculated as part of the PDC calculation)
**TB medications are drugid==13 OR drugid==18 OR drugid==24 OR drugid==25 OR drugid==30 

**use the rxBplusmissingtxt file cotrimBL and tbRxBL

**drop any observations where missing data in ALL of the following variables
	--dispdatedd
	--dispdatemm
	--dispdateyy
	--numdaysdesc
	--dispaltnumdaysspecify
	--dispaltnumpills
	--dispensed

drop observation if dispdateddx==missing AND dispdatemmx==missing AND dispdateyyx==missing AND dispaltnumdaysspecifyx==missing AND dispaltnumpillsx==missing AND dispensedx==missing
drop observation if dispdateddx==missing AND dispdatemmx==missing AND dispdateyyx==missing AND dispaltnumdaysspecifyx==missing AND dispaltnumpillsx==missing AND dispensedx==0

**generate variable called dispdate from the components of dispdatedd, dispdatemm, dispdateyy
**recode the observation as missing if:
	--absolute value of visitdate - dispdate > 180 days 
	--dispdate > today's date
	--dispdate<encdatefirst (where encdatefirst is the visitdate of the first recorded encounter for the patientid where formid<27 for HIV forms only)
	--dispdate<regdatefirst AND regdatefirst>Jan 1 2004 (where regdatefirst is the earliest visitdate where formid==10 OR formid==15)

**drop to baseline ART period, and consider inclusion of observations IF dispdate>=(artstartdatex-90 days) AND dispdate<artstartdatex

/*Cotrim variable
**code cotrimBL=0 if no drugid==9 observed with dispense date during the time period of interest
**code cotrimBL=1 if yes drugid==9 observed with dispense date during the time period of interest */

UPDATE r34Summary a, prescriptions b
SET cotrimbl = 1
WHERE a.patientid = b.patientid AND
drugid = 9 AND 
(dispensed = 1 OR dispAltNumPills IS NOT NULL OR ISDATE(ymdToDate(dispdateyy,dispdatemm,dispdatedd)) = 1 OR dispAltNumDays IS NOT NULL OR dispAltDosage IS NOT NULL) AND
CASE WHEN isdate(ymdToDate(dispdateyy,dispdatemm,dispdatedd)) = 1 THEN DATE(ymdToDate(dispdateyy,dispdatemm,dispdatedd)) 
ELSE DATE(ymdToDate(visitdateyy,visitdatemm,visitdatedd)) END BETWEEN DATE_ADD(a.artStartDate,INTERVAL -90 DAY) AND a.artStartDate;


/*TB drug variable
**code tbRxBL=0 if no if drugid==13 OR drugid==18 OR drugid==24 OR drugid==25 OR drugid==30 observed with dispense date during the time period of interest
**code tbRxBL=1 if yes if drugid==13 OR drugid==18 OR drugid==24 OR drugid==25 OR drugid==30observed with dispense date during the time period of interest
 */
UPDATE r34Summary a, prescriptions b
SET tbrxbl = 1
WHERE a.patientid = b.patientid AND
drugid IN (13,18,24,25,30) AND 
(dispensed = 1 OR dispAltNumPills IS NOT NULL OR ISDATE(ymdToDate(dispdateyy,dispdatemm,dispdatedd)) = 1 OR dispAltNumDays IS NOT NULL OR dispAltDosage IS NOT NULL) AND
CASE WHEN isdate(ymdToDate(dispdateyy,dispdatemm,dispdatedd)) = 1 THEN DATE(ymdToDate(dispdateyy,dispdatemm,dispdatedd)) 
ELSE DATE(ymdToDate(visitdateyy,visitdatemm,visitdatedd)) END BETWEEN DATE_ADD(a.artStartDate,INTERVAL -90 DAY) AND a.artStartDate;

/*
**testdatecat = time lag between HIV test and ART start date

-use first HIV test date from Vitals file
-drop if later than artstartdate
-for the year variable use:

replace testyyyy=testyy+2000 if testyy<17
replace testyyyy=testyy+1900 if testyy>80

-for missing dd variable, impute with value of 15 for mid-month timepoint
-create testdatedif=artstartdate - testdate
-create categorical version of the testdatedif variable, with the following categories: sameday, 1-14days, 15-90days, 91-365days, >365days, missing
                                                                                            1        2         3          4          5        0
 */
UPDATE r34Summary a, vitals b
SET a.testdatecat = CASE 
WHEN a.artStartDate = ymdtodate(b.firstTestYy,b.firstTestMm,b.firstTestDd) THEN 1
WHEN DATEDIFF(a.artStartDate,ymdToDate(b.firstTestYy,b.firstTestMm,b.firstTestDd)) BETWEEN 1 AND 14 THEN 2
WHEN DATEDIFF(a.artStartDate,ymdToDate(b.firstTestYy,b.firstTestMm,b.firstTestDd)) BETWEEN 15 AND 90 THEN 3
WHEN DATEDIFF(a.artStartDate,ymdToDate(b.firstTestYy,b.firstTestMm,b.firstTestDd)) BETWEEN 91 AND 365 THEN 4
WHEN DATEDIFF(a.artStartDate,ymdToDate(b.firstTestYy,b.firstTestMm,b.firstTestDd)) > 365 THEN 5
WHEN DATEDIFF(a.artStartDate,ymdToDate(b.firstTestYy,b.firstTestMm,b.firstTestDd)) < 0 THEN 0 ELSE 0 END
WHERE a.patientid = b.patientid;

/*transferin = transfer in from another facility before starting ART

-use vitals table and transferin = 1
-use visitdate associated with transferin=1

classify transferin as 0 if transferin==0 or transferin==1 and visitdate>artstartdate
classify transferin as 1 if transferin==1 and visitdate<=artstartdate*/

UPDATE r34Summary a, vitals b
SET a.transferin = CASE 
WHEN b.transferin IN (0,1) AND ymdToDate(b.visitDateYy,b.visitDateMm,b.visitDateDd) > a.artStartDate THEN 0
WHEN b.transferin = 1 AND ymdToDate(b.visitDateYy,b.visitDateMm,b.visitDateDd) <= a.artStartDate THEN 1 ELSE 0 END
WHERE a.patientid = b.patientid;

/*agecat: age at artstartdate from DOB

-use DOB on registration form. If multiple registration forms present, used the data with the most current save date, as long as visitdate falls on or before ART start date.
-recode dobyy as missing if <1900
-recode dobmm as missing if <1 or >12; impute any missing values with 6
-use dobdd as 15 for everyone (since it frequently has missing or illogical values)

create variable for ageartstart= round number for the quantity (artstartdatex-dob)/365.25
-recode as missing if ageartstart>100 OR ageartstart<0
-create a categorical version of the variable, with the following categories <25, 25-34, 35-49, 50+, missing
                                                                              1     2      3     4     0*/
UPDATE r34Summary a, patient b
SET a.agecat = CASE 
WHEN DATEDIFF(a.artStartDate,ymdToDate(b.dobYy,CASE WHEN ISNUMERIC(b.dobMm) = 1 THEN b.dobMm ELSE 6 END,15))/365.25 < 25 THEN 1
WHEN DATEDIFF(a.artStartDate,ymdToDate(b.dobYy,CASE WHEN ISNUMERIC(b.dobMm) = 1 THEN b.dobMm ELSE 6 END,15))/365.25 BETWEEN 25 AND 34 THEN 2
WHEN DATEDIFF(a.artStartDate,ymdToDate(b.dobYy,CASE WHEN ISNUMERIC(b.dobMm) = 1 THEN b.dobMm ELSE 6 END,15))/365.25 BETWEEN 35 AND 49 THEN 3
WHEN DATEDIFF(a.artStartDate,ymdToDate(b.dobYy,CASE WHEN ISNUMERIC(b.dobMm) = 1 THEN b.dobMm ELSE 6 END,15))/365.25 >= 50 THEN 4 ELSE 0 END
WHERE a.patientid = b.patientid;

/*marital: marital status

-use maritalstatus variable from registration form. If multiple registration forms present, used the data with the most current save date, as long as visitdate falls on or before ART start date.
-create following categories 
1 "Married/concubinage" (maritalstatus==1 OR maritalstatus==2)
2 "Widow/divorce" (maritalstatus==4 OR maritalstatus==8)
3 "Celibataire" (maritalstatus==16)
4 "Missing/Unknown"(maritalstatus==32 OR maritalstatusx==0 OR maritalstatusx==missing)*/

UPDATE r34Summary a, patient b
SET a.marital_status = CASE 
WHEN b.maritalstatus = 1 OR b.maritalstatus = 2 THEN 1
WHEN b.maritalstatus = 4 OR b.maritalstatus = 8 THEN 2
WHEN b.maritalstatus = 16 THEN 3
ELSE 4 END
WHERE a.patientid = b.patientid;

/*hhanyposcat: Having any known HIV positive person in the household
-use "houseBplus.txt"
-create indicator variable with categories "No" 1 "Yes" 2 "missing"
**preartdays: number of days between registration or first clinical visit for HIV care and ART start date
-use firstvisitdate among formid==1 OR formid==2 OR formid==10 or formid==15
preartdays = artstartdate - firstvisitdate
if preartdays has a negative value, recode as 0
 */

UPDATE r34Summary a, householdComp b
SET a.hhanyposcat = CASE 
WHEN b.hivStatus = 1 THEN 2
WHEN b.hivStatus > 1 THEN 1
ELSE 0 END
WHERE a.patientid = b.patientid AND
(ymdtodate(b.visitdateyy,b.visitdatemm,b.visitdatedd) BETWEEN a.encDateFirst AND a.artStartDate OR
ymdtodate(b.visitdateyy,b.visitdatemm,b.visitdatedd) BETWEEN a.regDateFirst AND a.artStartDate);

/*viscountpreart: count of clinical visits before ART start date
-use encounter file to determine unique dates where formid==1 OR formid==2 OR formid==16 OR formid==17 OR formid==24 OR formid==25 OR formid==26
-calculate count of unique dates occuring before artstartdate
 */

UPDATE r34Summary a JOIN (SELECT b.patientid,
COUNT(distinct ymdtodate(b.visitdateyy,b.visitdatemm,b.visitdatedd)) AS cnt
FROM r34Summary a, encounter b WHERE a.patientid = b.patientid AND 
b.encounterType IN (1,2,16,17,24,25,26) AND 
ymdToDate(b.visitdateyy,b.visitdatemm,b.visitdatedd) < a.artStartDate
GROUP BY b.patientid) x ON a.patientid = x.patientid 
SET a.viscountpreart = x.cnt;

/*viscounselpreart: count of counseling visits before ART start date
-use encounter file to determine unique dates where formid==3 OR formid==4 OR formid==14
-calculate count of unique dates occuring before artstartdate
 */

UPDATE r34Summary a JOIN (SELECT b.patientid,
COUNT(distinct ymdtodate(b.visitdateyy,b.visitdatemm,b.visitdatedd)) AS cnt
FROM r34Summary a, encounter b WHERE a.patientid = b.patientid AND 
b.encounterType IN (3,4,14) AND 
ymdToDate(b.visitdateyy,b.visitdatemm,b.visitdatedd) < a.artStartDate
GROUP BY b.patientid) x ON a.patientid = x.patientid 
SET a.viscounselpreart = x.cnt;

/*visotherpreart: count of pharmacy and lab visits before ART start date
-use encounter file to determine unique dates where formid==5 OR formid==6 
-calculate count of unique dates occuring before artstartdate
 */

UPDATE r34Summary a JOIN (SELECT b.patientid,
COUNT(distinct ymdtodate(b.visitdateyy,b.visitdatemm,b.visitdatedd)) AS cnt
FROM r34Summary a, encounter b WHERE a.patientid = b.patientid AND 
b.encounterType IN (5,6) AND 
ymdToDate(b.visitdateyy,b.visitdatemm,b.visitdatedd) < a.artStartDate
GROUP BY b.patientid) x ON a.patientid = x.patientid 
SET a.visotherpreart = x.cnt;