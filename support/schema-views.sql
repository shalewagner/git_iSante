/* interesting info about isante views
 * 1) the master views encValid, encValidAll, and encValidNeg each provide only undeleted patients and encounters via restricting to < 255 and forcing valid visitdates
 * 2) most of the other views are built off of these and given v_, a_, and n_ prefixes respectively to 1)
 * 3) because some views (which correspond to normalized tables) only apply to certain encounter types, they now include an encounterType restriction to force accurate record counts. Those restrictions follow:
 *        x_prescriptions       : encounterType in (5,18)
 *        x_drugs, x_conditions : encounterType in (1,2,16,17,24,25)
 *        x_labs                : encounterType in (6,13,19,24,25,27,28,29,31)
 *        x_riskAssessments     : encounterType in (1,16,24,25)
 *    other tables do not have such a restriction
 * 4) there is only one view related to the concept schema (v_obs), which makes it easier to find encounter instances via their short_name. As our use of the concept schema evolves, 
 *    we will likely take fuller advantage of the concept_name table and the concept_classes. 
 *    For instance, in 13.1, all diagnoses in encountertypes 24,25,28,29,31 were updated to have concept_class = 4 (Diagnosis - Conclusion drawn through findings). 
 *    All concepts misclassified as diagnoses were moved to other classes, though no other classes are currently reliable for querying 
 * 5) There should be no name overlap between table column name and concept short_name, and there isn't currently: 
 *        (select distinct c.column_name, co.short_name from information_schema.columns c, information_schema.tables t, concept co where c.column_name = co.short_name and c.table_schema = 'itech' and t.table_schema = 'itech' and c.table_name = t.table_name and t.table_type = 'TABLE')
 *    However, there are overlaps between labs and conditions (diagnoses) in those respective lookup tables, which result in redundant data storage:
 *        (select distinct short_name from labLookup join concept on labname = short_name): rpr, malaria, frottisVaginal, dengue, glycemie, fsh
 *        (select distinct conditionCode, short_name from conditionLookup join concept on conditionCode = short_name where class_id = 4): anemia, scabies, syphilis, eclampsia
 *    TODO: There is perhaps no harm in this redundancy, but it might be desirable to resolve it going forward. 
 * 2013-03-20 lastModified was added to the target list of most views to avoid needing a separate join to use it in queries
 */

drop table if exists encValid;
create or replace view encValid as
select e.encounter_id, e.siteCode, e.patientID, e.visitDateDd, e.visitDateMm, e.visitDateYy, e.lastModified, e.encounterType, e.seqNum, p.clinicPatientID, e.encStatus, e.encComments, e.dbSite, e.visitPointer, e.formAuthor, e.formVersion, e.formAuthor2, e.labOrDrugForm, e.creator, e.createDate, e.lastModifier, e.badVisitDate, e.nxtVisitDd, e.nxtVisitMm, e.nxtVisitYy, ymdToDate(e.visitDateYy, e.visitDateMm, e.visitDateDd) as visitDate, p.isPediatric, p.patientStatus from encounter e, patient p where e.encStatus < 255 and e.patientid = p.patientid and p.patStatus < 255 and badvisitdate = 0 and p.hivPositive = 1;

drop table if exists drugTable;
create or replace view drugTable as
select d.* from drugTableAll d, patient p where d.patientid = p.patientid and p.hivPositive = 1;

drop table if exists drugSummary;
create or replace view drugSummary as select d.* from drugSummaryAll d, patient p where d.patientid = p.patientid and p.hivPositive = 1;

drop table if exists v_conditions;
create or replace view v_conditions as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.formVersion, e.clinicPatientID, e.isPediatric, e.lastModified,
case
when l.conditionsID in (1,400,435) then 'Stage I'
when l.conditionGroup in (1,11) or conditionsID in (2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 192, 401, 402, 403, 404, 406) then 'Stage II'
when l.conditionGroup in (2,12) or conditionsID in (12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 196, 202, 205, 211, 214, 297, 396, 397, 408, 410) then 'Stage III'
when l.conditionGroup in (3,13) or conditionsID in (22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 218, 224, 227, 230, 233, 236, 239, 242, 245, 248, 251, 254, 257, 260, 263, 269, 272, 275, 278, 281, 287, 290, 398, 399, 405, 411, 412, 413, 414, 415, 416, 417, 418, 419, 420, 421, 422, 423, 424, 425, 426, 427, 433, 434) then 'Stage IV'
when l.conditionGroup in (4,14) or conditionsID in (42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 294, 303, 306, 315, 316, 317, 320, 323, 326, 329, 332, 335, 344, 347, 353, 356, 389, 392, 428, 429, 430) then 'Other'
when l.conditionsID in (377, 380, 383, 386, 395, 431) then 'Psych'
when l.conditionsID in (368, 371, 374, 432 ) then 'Substance Use'
else 'Unknown' end as 'whoStage',
l.conditionGroup, l.conditionCode,
case
when l.conditionsID in (316, 317) then concat('DM (', l.conditionNameEn, ')')
when l.conditionsID in (52, 389, 392, 395, 432) then concat(substring(l.conditionNameEn, 1, locate(',', l.conditionNameEn) - 1), ': ', ifnull(t.conditionComment, '[not specified]'))
else l.conditionNameEn end as conditionNameEn,
case
when l.conditionsID in (316, 317) then concat('Diabte (', l.conditionNameFr, ')')
when l.conditionsID in (52, 389, 392, 395, 432) then concat(substring(l.conditionNameFr, 1, locate(',', l.conditionNameFr) - 1), ': ', ifnull(t.conditionComment, '[pas specifi&#xe9;]'))
else l.conditionNameFr end as conditionNameFr
from conditions t, conditionLookup l, encValid e
where t.siteCode = e.siteCode and
t.patientID = e.patientID and
t.visitDatedd = e.visitDatedd and
t.visitDatemm = e.visitDatemm and
t.visitDateyy = e.visitDateyy and
t.seqNum = e.seqNum and
t.conditionID = l.conditionsID and
e.encounterType in (1,2,16,17,24,25);

drop table if exists v_labs;
create or replace view v_labs as select t.labs_id, t.siteCode, t.patientID, t.visitDateDd, t.visitDateMm, t.visitDateYy, t.labID, t.result, t.result2, t.resultDateDd, t.resultDateMm, t.resultDateYy, t.seqNum, t.ordered, t.resultAbnormal, t.resultRemarks, t.dbSite, t.result3, t.result4, t.labMessageStorage_id, t.labMessageStorage_seq, t.accessionNumber, t.sendingSiteName, t.sendingSiteID, 
case when length(t.labGroup) > 0 then t.labGroup else l.labGroup end as labGroup, 
case when t.sectionOrder >= 0 then t.sectionOrder else l.sectionOrder end as sectionOrder, 
case when length(t.panelName) > 0 then t.panelName else l.panelName end as panelName, 
case when t.panelOrder >= 0 then t.panelOrder else l.panelOrder end as panelOrder, 
case when length(t.testNameFr) > 0 then t.testNameFr else l.testNameFr end as testNameFr, 
case when length(t.testNameEn) > 0 then t.testNameEn else l.testNameEn end as testNameEn, 
case when t.testOrder >= 0 then t.testOrder else l.testOrder end as testOrder, 
case when length(t.sampleType) > 0 then t.sampleType else l.sampleType end as sampleType, 
case when length(t.loincCode) > 0 then t.loincCode else l.loincCode end as loincCode, 
case when length(t.externalResultType) > 0 then t.externalResultType else l.externalResultType end as externalResultType, 
case when length(t.minValue) > 0 then t.minValue else l.minValue end as minValue, 
case when length(t.maxValue) > 0 then t.maxValue else l.maxValue end as maxValue, 
case when length(t.validRangeMin) > 0 then t.validRangeMin else l.validRangeMin end as validRangeMin, 
case when length(t.validRangeMax) > 0 then t.validRangeMax else l.validRangeMax end as validRangeMax, 
case when length(t.referenceRange) > 0 then t.referenceRange else l.referenceRange end as referenceRange, 
t.resultTimestamp,
case when length(t.units) > 0 then t.units else l.units end as units,
e.visitDate,
e.encounterType,
e.encounter_id,
e.formVersion,
e.clinicPatientID,
e.isPediatric,
e.lastModified,
t.resultStatus,
t.supersededDate,
l.resultType,
l.resultLabelEn1,
l.resultLabelFr1,
l.resultLabelEn2,
l.resultLabelFr2,
l.resultLabelEn3,
l.resultLabelFr3,
l.resultLabelEn4,
l.resultLabelFr4,
l.resultLabelEn5,
l.resultLabelFr5,
l.resultLabelEn6,
l.resultLabelFr6
from labs t, labLookup l, encValid e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum and ((t.labID = l.labID and t.labID <= 1000) or (t.labID > 1000 and lcase(t.testNameFr) = lcase(l.testNameFr) and lcase(t.sampleType) = lcase(l.sampleType))) and e.encounterType in (6,13,16,19,24,25,27,28,29,31);

drop table if exists v_vitals;
create or replace view v_vitals as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.formVersion, e.clinicPatientID, e.isPediatric, e.lastModified from vitals t, 
encValid e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum;

drop table if exists v_medicalEligARVs;
create or replace view v_medicalEligARVs as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.formVersion, e.clinicPatientID, e.isPediatric, e.lastModified from medicalEligARVs t, 
encValid e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum;

drop table if exists v_arvEnrollment;
create or replace view v_arvEnrollment as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.formVersion, e.clinicPatientID, e.isPediatric, e.lastModified from arvEnrollment t, encValid e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum;

drop table if exists v_patients;
create or replace view v_patients as select t.*, siteCode, visitDate, encounterType, e.encounter_id, e.formVersion, encStatus from patient t, encValid e
where t.patientID = e.patientID;

drop table if exists v_drugs;
create or replace view v_drugs as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.formVersion, e.clinicPatientID, e.isPediatric, e.lastModified, l.drugName from drugs t, drugLookup l,
encValid e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum and t.drugID = l.drugID and e.encounterType in (1,2,16,17,24,25);

drop table if exists v_prescriptions;
create or replace view v_prescriptions as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.formVersion, e.clinicPatientID, e.isPediatric, e.lastModified, l.drugName from prescriptions t, drugLookup l, encValid e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum and t.drugID = l.drugID and case when l.drugGroup in ('NRTIs', 'NNRTIs', 'Pls') then (t.forPepPmtct IN (1, 2) OR t.dispensed = 1) else 1 = 1 end and e.encounterType in (5,18);

drop table if exists v_symptoms;
create or replace view v_symptoms as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.formVersion, e.clinicPatientID, e.isPediatric, e.lastModified from symptoms t, encValid e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum;

drop table if exists v_tbStatus;
create or replace view v_tbStatus as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.clinicPatientID, e.isPediatric, e.lastModified from tbStatus t, encValid e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum;

drop table if exists v_drugTable;
create or replace view v_drugTable as select d.*, l.drugGroup from drugTable d, drugLookup l 
where d.drugID = l.drugID;

drop table if exists v_discEnrollment;
create or replace view v_discEnrollment as select t.*, e.visitDate, e.encounterType, e.clinicPatientID, e.isPediatric, e.lastModified from discEnrollment t, encValid e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum;

drop table if exists v_medsDispensed;
create or replace view v_medsDispensed as select *, str_to_date(concat_ws('/',dispDateMm, '01', dispDateYy),'%m/%d/%y') as dispDate from v_prescriptions;

drop table if exists siteName;
drop view if exists siteName;
CREATE ALGORITHM=MERGE VIEW `siteName` AS 
select
 `clinicLookup`.`clinic` AS `Site`,
 `clinicLookup`.`commune` AS `commune`,
 `clinicLookup`.`department` AS `departement`,
 `clinicLookup`.`network` AS `network`,
 `clinicLookup`.`siteCode` AS `siteCode` 
from `clinicLookup` where (`clinicLookup`.`inCPHR` = 1);

drop table if exists v_riskAssessments;
create or replace view v_riskAssessments as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.formVersion, e.clinicPatientID, e.isPediatric, e.lastModified, l.riskDescFr from riskAssessments t, riskLookup l, encValid e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum and t.riskID = l.riskID and encounterType in (1,16,24,25);

drop table if exists v_bloodeval;
create or replace view v_bloodeval as select distinct patientid, visitDate from bloodeval1 where labid1 is not null and labid2 is not null and labid3 is not null and (labid4 is not null or labid5 is not null) union
select distinct patientid, visitDate from bloodeval2 where labid1 is not null and labid2 is not null and (labid3 is not null or labid4 is not null);

/* views for labs ordered, labs completed */ 
drop table if exists v_labsOrdered;
create or replace view v_labsOrdered as select * from v_labs 
where (result is null or result = '') 
and (result2 is null or result2 = '') 
and (result3 is null or result3 = '') 
and (result4 is null or result4 = '') 
and (resultAbnormal is null or resultAbnormal != 1) and ordered = 1;
drop table if exists v_labsCompleted;
create or replace view v_labsCompleted as select * from v_labs where (result is not null and result != '') 
or (result2 is not null and result2 != '') 
or (result3 is not null and result3 != '') 
or (result4 is not null and result4 != '') 
or (resultAbnormal is not null and resultAbnormal = 1);

/* added to make Linux version backward compatible */
drop table if exists v_patientTargetList;
create or replace view v_patientTargetList as
select patientid,
location_id as siteCode,
clinicPatientID,
p.nationalID,
p.fname as Prenom,
p.lname as Nom,
CASE WHEN sex = 1 THEN 'F' WHEN sex = 2 THEN 'H' ELSE 'I' END as 'Sexe',
ageYears as 'Age',
l.statusDescEn, l.statusDescFr
from v_patients p, patientStatusLookup l
where l.statusValue = p.patientStatus and p.encountertype in (10, 15);

/* view linking the concept table with the obs table */
drop table if exists v_obs;
create or replace view v_obs as select o.*, c.short_name from obs o, concept c where c.concept_id = o.concept_id;

drop table if exists encValidAll;
create or replace view encValidAll as
select e.encounter_id, e.siteCode, e.patientID, e.visitDateDd, e.visitDateMm, e.visitDateYy, e.lastModified, e.encounterType, e.seqNum, p.clinicPatientID, e.encStatus, e.encComments, e.dbSite, e.visitPointer, e.formAuthor, e.formVersion, e.formAuthor2, e.labOrDrugForm, e.creator, e.createDate, e.lastModifier, e.badVisitDate, e.nxtVisitDd, e.nxtVisitMm, e.nxtVisitYy, ymdToDate(e.visitDateYy, e.visitDateMm, e.visitDateDd) as visitDate, p.isPediatric, p.patientStatus from encounter e, patient p where e.encStatus < 255 and e.patientid = p.patientid and p.patStatus < 255 and badvisitdate = 0;

drop table if exists a_conditions;
create or replace view a_conditions as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.formVersion, e.clinicPatientID, e.isPediatric, e.lastModified,
case
when l.conditionsID in (1,400,435) then 'Stage I'
when l.conditionGroup in (1,11) or conditionsID in (2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 192, 401, 402, 403, 404, 406) then 'Stage II'
when l.conditionGroup in (2,12) or conditionsID in (12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 196, 202, 205, 211, 214, 297, 396, 397, 408, 410) then 'Stage III'
when l.conditionGroup in (3,13) or conditionsID in (22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 218, 224, 227, 230, 233, 236, 239, 242, 245, 248, 251, 254, 257, 260, 263, 269, 272, 275, 278, 281, 287, 290, 398, 399, 405, 411, 412, 413, 414, 415, 416, 417, 418, 419, 420, 421, 422, 423, 424, 425, 426, 427, 433, 434) then 'Stage IV'
when l.conditionGroup in (4,14) or conditionsID in (42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 294, 303, 306, 315, 316, 317, 320, 323, 326, 329, 332, 335, 344, 347, 353, 356, 389, 392, 428, 429, 430) then 'Other'
when l.conditionsID in (377, 380, 383, 386, 395, 431) then 'Psych'
when l.conditionsID in (368, 371, 374, 432 ) then 'Substance Use'
else 'Unknown' end as 'whoStage',
l.conditionGroup, l.conditionCode,
case
when l.conditionsID in (316, 317) then concat('DM (', l.conditionNameEn, ')')
when l.conditionsID in (52, 389, 392, 395, 432) then concat(substring(l.conditionNameEn, 1, locate(',', l.conditionNameEn) - 1), ': ', ifnull(t.conditionComment, '[not specified]'))
else l.conditionNameEn end as conditionNameEn,
case
when l.conditionsID in (316, 317) then concat('Diabte (', l.conditionNameFr, ')')
when l.conditionsID in (52, 389, 392, 395, 432) then concat(substring(l.conditionNameFr, 1, locate(',', l.conditionNameFr) - 1), ': ', ifnull(t.conditionComment, '[pas specifi&#xe9;]'))
else l.conditionNameFr end as conditionNameFr
from conditions t, conditionLookup l, encValidAll e
where t.siteCode = e.siteCode and
t.patientID = e.patientID and
t.visitDatedd = e.visitDatedd and
t.visitDatemm = e.visitDatemm and
t.visitDateyy = e.visitDateyy and
t.seqNum = e.seqNum and
t.conditionID = l.conditionsID and e.encounterType in (1,2,16,17,24,25);

drop table if exists a_labs;
create or replace view a_labs as select t.labs_id, t.siteCode, t.patientID, t.visitDateDd, t.visitDateMm, t.visitDateYy, t.labID, t.result, t.result2, t.resultDateDd, t.resultDateMm, t.resultDateYy, t.seqNum, t.ordered, t.resultAbnormal, t.resultRemarks, t.dbSite, t.result3, t.result4, t.labMessageStorage_id, t.labMessageStorage_seq, t.accessionNumber, t.sendingSiteName, t.sendingSiteID, 
case when length(t.labGroup) > 0 then t.labGroup else l.labGroup end as labGroup, 
case when t.sectionOrder >= 0 then t.sectionOrder else l.sectionOrder end as sectionOrder, 
case when length(t.panelName) > 0 then t.panelName else l.panelName end as panelName, 
case when t.panelOrder >= 0 then t.panelOrder else l.panelOrder end as panelOrder, 
case when length(t.testNameFr) > 0 then t.testNameFr else l.testNameFr end as testNameFr, 
case when length(t.testNameEn) > 0 then t.testNameEn else l.testNameEn end as testNameEn, 
case when t.testOrder >= 0 then t.testOrder else l.testOrder end as testOrder, 
case when length(t.sampleType) > 0 then t.sampleType else l.sampleType end as sampleType, 
case when length(t.loincCode) > 0 then t.loincCode else l.loincCode end as loincCode, 
case when length(t.externalResultType) > 0 then t.externalResultType else l.externalResultType end as externalResultType, 
case when length(t.minValue) > 0 then t.minValue else l.minValue end as 'minValue', 
case when length(t.maxValue) > 0 then t.maxValue else l.maxValue end as 'maxValue', 
case when length(t.validRangeMin) > 0 then t.validRangeMin else l.validRangeMin end as validRangeMin, 
case when length(t.validRangeMax) > 0 then t.validRangeMax else l.validRangeMax end as validRangeMax, 
case when length(t.referenceRange) > 0 then t.referenceRange else l.referenceRange end as referenceRange, 
t.resultTimestamp,
case when length(t.units) > 0 then t.units else l.units end as units,
e.visitDate,
e.encounterType,
e.encounter_id,
e.formVersion,
e.clinicPatientID,
e.isPediatric,
e.lastModified,
t.resultStatus,
t.supersededDate,
l.resultType,
l.resultLabelEn1,
l.resultLabelFr1,
l.resultLabelEn2,
l.resultLabelFr2,
l.resultLabelEn3,
l.resultLabelFr3,
l.resultLabelEn4,
l.resultLabelFr4,
l.resultLabelEn5,
l.resultLabelFr5,
l.resultLabelEn6,
l.resultLabelFr6
from labs t, labLookup l, encValidAll e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum and t.labID = l.labID;

drop table if exists a_vitals;
create or replace view a_vitals as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.formVersion, e.clinicPatientID, e.isPediatric, e.lastModified from vitals t, 
encValidAll e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum;

drop table if exists a_medicalEligARVs;
create or replace view a_medicalEligARVs as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.formVersion, e.clinicPatientID, e.isPediatric, e.lastModified from medicalEligARVs t, encValidAll e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum;

drop table if exists a_arvEnrollment;
create or replace view a_arvEnrollment as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.formVersion, e.clinicPatientID, e.isPediatric, e.lastModified from arvEnrollment t, encValidAll e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum;

drop table if exists a_labsCompleted;
create or replace view a_labsCompleted as select * from a_labs where (result is not null and result != '') 
or (result2 is not null and result2 != '') 
or (result3 is not null and result3 != '') 
or (result4 is not null and result4 != '') 
or (resultAbnormal is not null and resultAbnormal = 1);

drop table if exists a_patients;
create or replace view a_patients as select t.*, siteCode, visitDate, encounterType, e.encounter_id, e.formVersion, encStatus from patient t, encValidAll e
where t.patientID = e.patientID;

drop table if exists a_drugs;
create or replace view a_drugs as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.formVersion, e.clinicPatientID, e.isPediatric, e.lastModified, l.drugName from drugs t, drugLookup l,
encValidAll e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum and t.drugID = l.drugID and e.encounterType in (1,2,16,17,24,25);

drop table if exists a_prescriptions;
create or replace view a_prescriptions as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.formVersion, e.clinicPatientID, e.isPediatric, e.lastModified, l.drugName from prescriptions t, drugLookup l, encValidAll e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum and t.drugID = l.drugID and case when l.drugGroup in ('NRTIs', 'NNRTIs', 'Pls') then (t.forPepPmtct IN (1, 2) OR t.dispensed = 1) else 1 = 1 end and e.encounterType in (5,18);

drop table if exists a_symptoms;
create or replace view a_symptoms as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.formVersion, e.clinicPatientID, e.isPediatric, e.lastModified from symptoms t, encValidAll e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum;

drop table if exists a_tbStatus;
create or replace view a_tbStatus as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.clinicPatientID, e.isPediatric, e.lastModified from tbStatus t, encValidAll e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum;

drop table if exists a_drugTable;
create or replace view a_drugTable as select d.*, l.drugGroup from drugTableAll d, drugLookup l 
where d.drugID = l.drugID;

drop table if exists a_discEnrollment;
create or replace view a_discEnrollment as select t.*, e.visitDate, e.encounterType, e.clinicPatientID, e.isPediatric, e.lastModified from discEnrollment t, encValidAll e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum;

drop table if exists a_medsDispensed;
create or replace view a_medsDispensed as select *, str_to_date(concat_ws('/',dispDateMm, '01', dispDateYy),'%m/%d/%y') as dispDate from a_prescriptions;

drop table if exists a_riskAssessments;
create or replace view a_riskAssessments as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.formVersion, e.clinicPatientID, e.isPediatric, e.lastModified, l.riskDescFr from riskAssessments t, riskLookup l, encValidAll e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum and t.riskID = l.riskID and encounterType in (1,16,24,25);

drop table if exists a_bloodeval;
create or replace view a_bloodeval as select distinct patientid, visitDate from bloodeval1 where labid1 is not null and labid2 is not null and labid3 is not null and (labid4 is not null or labid5 is not null) union
select distinct patientid, visitDate from bloodeval2 where labid1 is not null and labid2 is not null and (labid3 is not null or labid4 is not null);

/* new views for labs ordered, labs completed */
drop table if exists a_labsOrdered;
create or replace view a_labsOrdered as select * from a_labs 
where (result is null or result = '') 
and (result2 is null or result2 = '') 
and (result3 is null or result3 = '') 
and (result4 is null or result4 = '') 
and (resultAbnormal is null or resultAbnormal != 1) and ordered = 1;

/* added to make Linux version backward compatible */
drop table if exists a_patientTargetList;
create or replace view a_patientTargetList as
select patientid,
location_id as siteCode,
clinicPatientID,
p.nationalID,
p.fname as Prenom,
p.lname as Nom,
CASE WHEN sex = 1 THEN 'F' WHEN sex = 2 THEN 'H' ELSE 'I' END as 'Sexe',
ageYears as 'Age',
l.statusDescEn, l.statusDescFr
from a_patients p, patientStatusLookup l
where l.statusValue = p.patientStatus and p.encountertype in (10, 15);

drop table if exists encValidNeg;
create or replace view encValidNeg as
select e.encounter_id, e.siteCode, e.patientID, e.visitDateDd, e.visitDateMm, e.visitDateYy, e.lastModified, e.encounterType, e.seqNum, p.clinicPatientID, e.encStatus, e.encComments, e.dbSite, e.visitPointer, e.formAuthor, e.formVersion, e.formAuthor2, e.labOrDrugForm, e.creator, e.createDate, e.lastModifier, e.badVisitDate, e.nxtVisitDd, e.nxtVisitMm, e.nxtVisitYy, ymdToDate(e.visitDateYy, e.visitDateMm, e.visitDateDd) as visitDate, p.isPediatric, p.patientStatus from encounter e, patient p where e.encStatus < 255 and e.patientid = p.patientid and p.patStatus < 255 and badvisitdate = 0 and (p.hivPositive <> 1 or p.hivPositive is null);

drop table if exists n_conditions;
create or replace view n_conditions as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.formVersion, e.clinicPatientID, e.isPediatric, e.lastModified,
case
when l.conditionsID in (1,400,435) then 'Stage I'
when l.conditionGroup in (1,11) or conditionsID in (2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 192, 401, 402, 403, 404, 406) then 'Stage II'
when l.conditionGroup in (2,12) or conditionsID in (12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 196, 202, 205, 211, 214, 297, 396, 397, 408, 410) then 'Stage III'
when l.conditionGroup in (3,13) or conditionsID in (22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 218, 224, 227, 230, 233, 236, 239, 242, 245, 248, 251, 254, 257, 260, 263, 269, 272, 275, 278, 281, 287, 290, 398, 399, 405, 411, 412, 413, 414, 415, 416, 417, 418, 419, 420, 421, 422, 423, 424, 425, 426, 427, 433, 434) then 'Stage IV'
when l.conditionGroup in (4,14) or conditionsID in (42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 294, 303, 306, 315, 316, 317, 320, 323, 326, 329, 332, 335, 344, 347, 353, 356, 389, 392, 428, 429, 430) then 'Other'
when l.conditionsID in (377, 380, 383, 386, 395, 431) then 'Psych'
when l.conditionsID in (368, 371, 374, 432 ) then 'Substance Use'
else 'Unknown' end as 'whoStage',
l.conditionGroup, l.conditionCode,
case
when l.conditionsID in (316, 317) then concat('DM (', l.conditionNameEn, ')')
when l.conditionsID in (52, 389, 392, 395, 432) then concat(substring(l.conditionNameEn, 1, locate(',', l.conditionNameEn) - 1), ': ', ifnull(t.conditionComment, '[not specified]'))
else l.conditionNameEn end as conditionNameEn,
case
when l.conditionsID in (316, 317) then concat('Diabte (', l.conditionNameFr, ')')
when l.conditionsID in (52, 389, 392, 395, 432) then concat(substring(l.conditionNameFr, 1, locate(',', l.conditionNameFr) - 1), ': ', ifnull(t.conditionComment, '[pas specifi&#xe9;]'))
else l.conditionNameFr end as conditionNameFr
from conditions t, conditionLookup l, encValidNeg e
where t.siteCode = e.siteCode and
t.patientID = e.patientID and
t.visitDatedd = e.visitDatedd and
t.visitDatemm = e.visitDatemm and
t.visitDateyy = e.visitDateyy and
t.seqNum = e.seqNum and
t.conditionID = l.conditionsID and e.encounterType in (1,2,16,17,24,25);

drop table if exists n_labs;
create or replace view n_labs as select t.labs_id, t.siteCode, t.patientID, t.visitDateDd, t.visitDateMm, t.visitDateYy, t.labID, t.result, t.result2, t.resultDateDd, t.resultDateMm, t.resultDateYy, t.seqNum, t.ordered, t.resultAbnormal, t.resultRemarks, t.dbSite, t.result3, t.result4, t.labMessageStorage_id, t.labMessageStorage_seq, t.accessionNumber, t.sendingSiteName, t.sendingSiteID, 
case when length(t.labGroup) > 0 then t.labGroup else l.labGroup end as labGroup, 
case when t.sectionOrder >= 0 then t.sectionOrder else l.sectionOrder end as sectionOrder, 
case when length(t.panelName) > 0 then t.panelName else l.panelName end as panelName, 
case when t.panelOrder >= 0 then t.panelOrder else l.panelOrder end as panelOrder, 
case when length(t.testNameFr) > 0 then t.testNameFr else l.testNameFr end as testNameFr, 
case when length(t.testNameEn) > 0 then t.testNameEn else l.testNameEn end as testNameEn, 
case when t.testOrder >= 0 then t.testOrder else l.testOrder end as testOrder, 
case when length(t.sampleType) > 0 then t.sampleType else l.sampleType end as sampleType, 
case when length(t.loincCode) > 0 then t.loincCode else l.loincCode end as loincCode, 
case when length(t.externalResultType) > 0 then t.externalResultType else l.externalResultType end as externalResultType, 
case when length(t.minValue) > 0 then t.minValue else l.minValue end as minValue, 
case when length(t.maxValue) > 0 then t.maxValue else l.maxValue end as maxValue, 
case when length(t.validRangeMin) > 0 then t.validRangeMin else l.validRangeMin end as validRangeMin, 
case when length(t.validRangeMax) > 0 then t.validRangeMax else l.validRangeMax end as validRangeMax, 
case when length(t.referenceRange) > 0 then t.referenceRange else l.referenceRange end as referenceRange, 
t.resultTimestamp,
case when length(t.units) > 0 then t.units else l.units end as units,
e.visitDate,
e.encounterType,
e.encounter_id,
e.formVersion,
e.clinicPatientID,
e.isPediatric, 
e.lastModified,
t.resultStatus,
t.supersededDate,
l.resultType,
l.resultLabelEn1,
l.resultLabelFr1,
l.resultLabelEn2,
l.resultLabelFr2,
l.resultLabelEn3,
l.resultLabelFr3,
l.resultLabelEn4,
l.resultLabelFr4,
l.resultLabelEn5,
l.resultLabelFr5,
l.resultLabelEn6,
l.resultLabelFr6
from labs t, labLookup l, encValidNeg e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum and ((t.labID = l.labID and t.labID <= 1000) or (t.labID > 1000 and lcase(t.testNameFr) = lcase(l.testNameFr) and lcase(t.sampleType) = lcase(l.sampleType))) and e.encounterType in (6,13,16,19,24,25,27,28,29,31);

drop table if exists n_vitals;
create or replace view n_vitals as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.formVersion, e.clinicPatientID, e.isPediatric, e.lastModified from vitals t, 
encValidNeg e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum;

drop table if exists n_medicalEligARVs;
create or replace view n_medicalEligARVs as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.formVersion, e.clinicPatientID, e.isPediatric, e.lastModified from medicalEligARVs t, encValidNeg e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum;

drop table if exists n_arvEnrollment;
create or replace view n_arvEnrollment as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.formVersion, e.clinicPatientID, e.isPediatric, e.lastModified from arvEnrollment t, encValidNeg e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum;

drop table if exists n_labsCompleted;
create or replace view n_labsCompleted as select * from n_labs where (result is not null and result != '') 
or (result2 is not null and result2 != '') 
or (result3 is not null and result3 != '') 
or (result4 is not null and result4 != '') 
or (resultAbnormal is not null and resultAbnormal = 1);

drop table if exists n_patients;
create or replace view n_patients as select t.*, siteCode, visitDate, encounterType, e.encounter_id, e.formVersion, encStatus from patient t, encValidNeg e
where t.patientID = e.patientID;

drop table if exists n_drugs;
create or replace view n_drugs as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.formVersion, e.clinicPatientID, e.isPediatric, e.lastModified, l.drugName from drugs t, drugLookup l,
encValidNeg e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum and t.drugID = l.drugID and e.encounterType in (1,2,16,17,24,25);

drop table if exists n_prescriptions;
create or replace view n_prescriptions as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.formVersion, e.clinicPatientID, e.isPediatric, e.lastModified, l.drugName from prescriptions t, drugLookup l, encValidNeg e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum and t.drugID = l.drugID and case when l.drugGroup in ('NRTIs', 'NNRTIs', 'Pls') then (t.forPepPmtct IN (1, 2) OR t.dispensed = 1) else 1 = 1 end and e.encounterType in (5,18);

drop table if exists n_symptoms;
create or replace view n_symptoms as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.formVersion, e.clinicPatientID, e.isPediatric, e.lastModified from symptoms t, encValidNeg e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum;

drop table if exists n_tbStatus;
create or replace view n_tbStatus as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.clinicPatientID, e.isPediatric, e.lastModified from tbStatus t, encValidNeg e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum;

drop table if exists n_drugTable;
create or replace view n_drugTable as select d.*, l.drugGroup from drugTableAll d, drugLookup l, patient p 
where d.drugID = l.drugID and d.patientid = p.patientid and (p.hivpositive <> 1 or p.hivpositive is null);

drop table if exists n_discEnrollment;
create or replace view n_discEnrollment as select t.*, e.visitDate, e.encounterType, e.clinicPatientID, e.isPediatric, e.lastModified from discEnrollment t, encValidNeg e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum;

drop table if exists n_medsDispensed;
create or replace view n_medsDispensed as select *, str_to_date(concat_ws('/',dispDateMm, '01', dispDateYy),'%m/%d/%y') as dispDate from n_prescriptions;

drop table if exists n_riskAssessments;
create or replace view n_riskAssessments as select t.*, e.visitDate, e.encounterType, e.encounter_id, e.formVersion, e.clinicPatientID, e.isPediatric, e.lastModified, l.riskDescFr from riskAssessments t, riskLookup l, encValidNeg e where t.siteCode = e.siteCode and t.patientID = e.patientID and t.visitDatedd = e.visitDatedd and t.visitDatemm = e.visitDatemm and t.visitDateyy = e.visitDateyy and t.seqNum = e.seqNum and t.riskID = l.riskID and encounterType in (1,16,24,25);

drop table if exists n_bloodeval;
create or replace view n_bloodeval as select distinct patientid, visitDate from bloodeval1 where labid1 is not null and labid2 is not null and labid3 is not null and (labid4 is not null or labid5 is not null) union
select distinct patientid, visitDate from bloodeval2 where labid1 is not null and labid2 is not null and (labid3 is not null or labid4 is not null);

/* new views for labs ordered, labs completed */
drop table if exists n_labsOrdered;
create or replace view n_labsOrdered as select * from n_labs 
where (result is null or result = '') 
and (result2 is null or result2 = '') 
and (result3 is null or result3 = '') 
and (result4 is null or result4 = '') 
and (resultAbnormal is null or resultAbnormal != 1) and ordered = 1;

/* added to make Linux version backward compatible */
drop table if exists n_patientTargetList;
create or replace view n_patientTargetList as
select patientid,
location_id as siteCode,
clinicPatientID,
p.nationalID,
p.fname as Prenom,
p.lname as Nom,
CASE WHEN sex = 1 THEN 'F' WHEN sex = 2 THEN 'H' ELSE 'I' END as 'Sexe',
ageYears as 'Age',
l.statusDescEn, l.statusDescFr
from n_patients p, patientStatusLookup l
where l.statusValue = p.patientStatus and p.encountertype in (10, 15);

/* added for the Lab interoperability open order */
create or replace VIEW `openLabs` AS select `t`.`labs_id` AS `labs_id`,`t`.`siteCode` AS `siteCode`,`t`.`patientID` AS `patientID`,`t`.`labID` AS `labID`,`t`.`result` AS `result`,`t`.`result2` AS `result2`,`t`.`resultDateDd` AS `resultDateDd`,`t`.`resultDateMm` AS `resultDateMm`,`t`.`resultDateYy` AS `resultDateYy`,`t`.`seqNum` AS `seqNum`,`t`.`ordered` AS `ordered`,`t`.`resultAbnormal` AS `resultAbnormal`,`t`.`resultRemarks` AS `resultRemarks`,`t`.`dbSite` AS `dbSite`,`t`.`result3` AS `result3`,`t`.`result4` AS `result4`,`t`.`labMessageStorage_id` AS `labMessageStorage_id`,`t`.`labMessageStorage_seq` AS `labMessageStorage_seq`,`t`.`accessionNumber` AS `accessionNumber`,`t`.`sendingSiteName` AS `sendingSiteName`,`t`.`sendingSiteID` AS `sendingSiteID`,(case when (length(`t`.`labGroup`) > 0) then `t`.`labGroup` else `l`.`labGroup` end) AS `labGroup`,(case when (length(`t`.`panelName`) > 0) then `t`.`panelName` else `l`.`panelName` end) AS `panelName`,(case when (length(`t`.`testNameFr`) > 0) then `t`.`testNameFr` else `l`.`testNameFr` end) AS `testNameFr`,(case when (length(`t`.`testNameEn`) > 0) then `t`.`testNameEn` else `l`.`testNameEn` end) AS `testNameEn`,(case when (length(`t`.`sampleType`) > 0) then `t`.`sampleType` else `l`.`sampleType` end) AS `sampleType`,(case when (length(`t`.`loincCode`) > 0) then `t`.`loincCode` else `l`.`loincCode` end) AS `loincCode`,(case when (length(`t`.`externalResultType`) > 0) then `t`.`externalResultType` else `l`.`externalResultType` end) AS `externalResultType`,(case when (length(`t`.`minValue`) > 0) then `t`.`minValue` else `l`.`minValue` end) AS `minValue`,(case when (length(`t`.`maxValue`) > 0) then `t`.`maxValue` else `l`.`maxValue` end) AS `maxValue`,(case when (length(`t`.`validRangeMin`) > 0) then `t`.`validRangeMin` else `l`.`validRangeMin` end) AS `validRangeMin`,(case when (length(`t`.`validRangeMax`) > 0) then `t`.`validRangeMax` else `l`.`validRangeMax` end) AS `validRangeMax`,(case when (length(`t`.`referenceRange`) > 0) then `t`.`referenceRange` else `l`.`referenceRange` end) AS `referenceRange`,`t`.`resultTimestamp` AS `resultTimestamp`,(case when (length(`t`.`units`) > 0) then `t`.`units` else `l`.`units` end) AS `units`,`e`.`visitDate` AS `visitDate`,`e`.`encounterType` AS `encounterType`,`e`.`encounter_id` AS `encounter_id`,`e`.`formVersion` AS `formVersion`,`e`.`clinicPatientID` AS `clinicPatientID`,`e`.`isPediatric` AS `isPediatric`,`e`.`lastModified` AS `lastModified`,`t`.`resultStatus` AS `resultStatus`,`t`.`supersededDate` AS `supersededDate`,`l`.`resultType` AS `resultType`,`l`.`resultLabelEn1` AS `resultLabelEn1`,`l`.`resultLabelFr1` AS `resultLabelFr1`,`l`.`resultLabelEn2` AS `resultLabelEn2`,`l`.`resultLabelFr2` AS `resultLabelFr2`,`l`.`resultLabelEn3` AS `resultLabelEn3`,`l`.`resultLabelFr3` AS `resultLabelFr3`,`l`.`resultLabelEn4` AS `resultLabelEn4`,`l`.`resultLabelFr4` AS `resultLabelFr4`,`l`.`resultLabelEn5` AS `resultLabelEn5`,`l`.`resultLabelFr5` AS `resultLabelFr5`,`l`.`resultLabelEn6` AS `resultLabelEn6`,`l`.`resultLabelFr6` AS `resultLabelFr6` from ((`labs` `t` join `labLookup` `l`) join `encValidAll` `e`) where ((`t`.`siteCode` = `e`.`siteCode`) and (`t`.`patientID` = `e`.`patientID`) and (`t`.`visitDateDd` = `e`.`visitDateDd`) and (`t`.`visitDateMm` = `e`.`visitDateMm`) and (`t`.`visitDateYy` = `e`.`visitDateYy`) and (`t`.`seqNum` = `e`.`seqNum`) and (`t`.`labID` = `l`.`labID`));

