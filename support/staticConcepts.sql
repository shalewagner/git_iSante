create table staticConcepts (column_name varchar(64), table_name varchar(64), concept_class_id tinyint unsigned not null default 11, concept_datatype_id tinyint unsigned not null default 3);
truncate table staticConcepts;
insert into staticConcepts select column_name, table_name, 
case when table_name in ('labs','pedLabs','otherLabs') then 1 
when table_name = 'followupTreatment' then 2 
when table_name in ('drugs','otherDrugs','prescriptions','otherPrescriptions', 'prescriptionOtherFields') then 3 
when table_name = 'conditions' then 4 when table_name in ('allergies','arvAndPregnancy','arvEnrollment','discEnrollment','tbStatus','vitals') then 5 
else 11 end as concept_class_id, 
case when data_type in ('int','mediumint','smallint') then 1 
when data_type = 'tinyint' then 10 
when data_type in ('varchar','char','longtext') then 3 
when data_type = 'date' then 6 end as concept_datatype_id 
from information_schema.columns where table_schema = 'itech' and table_name in ('encounter','patient','adherenceCounseling', 'allergies', 'allowedDisclosures', 'arvAndPregnancy', 'arvEnrollment', 'buddies', 'comprehension', 'discEnrollment', 'followupTreatment', 'homeCareVisits', 'householdComp', 'immunizations', 'medicalEligARVs', 'needsAssessment', 'otherDrugs', 'otherLabs', 'otherPrescriptions', 'patientEducation', 'pedHistory', 'pedLabs', 'referrals', 'tbStatus', 'vitals', 'riskAssessments', 'prescriptionOtherFields', 'otherImmunizations'); 
insert into staticConcepts select concat(conditionCode,'Active'),'conditions',13,1 from conditionLookup union select concat(conditionCode,'Comment'),'conditions',11,3 from conditionLookup;
insert into staticConcepts select concat(labName,'Test'),'labs',1,10 from labLookup union select concat(pedLabsCode,'Test'),'labs',1,10 from pedLabsLookup;
delete from staticConcepts where column_name in ('sitecode','visitdatedd','visitdatemm','visitdateyy','seqNum','dbsite');
delete from staticConcepts where column_name like '%_id';
 