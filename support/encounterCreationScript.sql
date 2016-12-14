insert into visit_type (name, description, visit_type_id, date_created, creator, uuid) select enname, frname, encountertype+10, now(),1,UUID() from itech.encTypeLookup;
	
insert into encounter_type (encounter_type_id, name, description, date_created,creator, uuid) select encountertype+10, enname, frname, now(),1,UUID() from itech.encTypeLookup;
	
insert into form (name, encounter_type, date_created, creator, uuid) select enname, encountertype+10, now(),1, UUID() from itech.encTypeLookup;
	
create unique index mmm on encounter (patient_id,location_id, encounter_datetime, encounter_type,date_created);

/*
select count(distinct p.person_id) from itech.patient t, encounter c, person p, itech.encounter e, itech.vitals v
where c.patient_id = p.person_id and p.uuid = t.patGuid and e.patientid = v.patientid and e.sitecode = v.sitecode and concat(e.visitdateyy,'-',e.visitdatemm,'-',e.visitdatedd) = concat(v.visitdateyy,'-',v.visitdatemm,'-',v.visitdatedd) and e.seqNum = v.seqNum;

select distinct e.patientid, v.vitalTemp+0, concat(e.visitdateyy,'-',e.visitdatemm,'-',e.visitdatedd) as dt from encounter e, vitals v
where e.patientid = v.patientid and e.sitecode = v.sitecode and concat(e.visitdateyy,'-',e.visitdatemm,'-',e.visitdatedd) = concat(v.visitdateyy,'-',v.visitdatemm,'-',v.visitdatedd) and e.seqNum = v.seqNum and vitalTemp+0 > 50;
*/
	
/* Visit Migration
 * find all unique patientid, visitdate instances in the encounter table and consider these visits
 */
INSERT INTO visit (patient_id, visit_type_id, date_started, date_stopped, location_id, creator, date_created, uuid)
SELECT DISTINCT p.person_id, 1, ymdToDate(e.visitdateyy,e.visitdatemm,e.visitdatedd), ymdToDate(e.visitdateyy,e.visitdatemm,e.visitdatedd), it.location_id,1, e.lastModified, UUID()
FROM person p, itech.patient it, itech.encounter e
WHERE p.uuid = it.patGuid AND it.patientid = e.patientid AND
e.encounterType in (1,2,3,4,5,6,12,14,16,17,18,19,20,21,24,25,26,27,28,29,31);
		
/*Encounter Migration*/
ALTER TABLE itech.encounter ADD encGuid VARCHAR(36) NOT NULL;

UPDATE itech.encounter SET encGuid = UUID();

CREATE UNIQUE INDEX eGuid ON itech.encounter (encGuid);

CREATE TABLE itech.typeToForm (encounterType INT, form_id INT, uuid VARCHAR(36));
INSERT INTO itech.typeToForm (encounterType, uuid) VALUES 
( 14 , '81ddaf29-50d9-4654-a2e2-5a3d784b7427' ),
( 20 , '81ddaf29-50d9-4654-a2e2-5a3d784b7427' ),
( 6  , '56cf5b28-c0b5-4d57-8dde-a43e93e269d2' ),
( 19 , '56cf5b28-c0b5-4d57-8dde-a43e93e269d2' ),
( 25 , '154a1a80-3565-4b17-aa30-018e623ad148' ),
( 24 , '66207cc7-35ad-436a-8740-0810b92f17fb' ),
( 26 , '92b72750-916f-4cc6-a719-728285143770' ),
( 3  , '89710ca2-ac5a-42e4-a430-0dfa2cb71f6e' ),
( 4  , '89710ca2-ac5a-42e4-a430-0dfa2cb71f6e' ),
( 5  , '2eb5f8f8-9bb4-4aae-92cc-1706eca22e6a' ),
( 18 , 'b1a372de-2961-4468-8e7a-33b7e2048d71' ),
( 12 , '0c3ca345-f834-46d1-a620-6d0f20f217f2' ),
( 21 , '0c3ca345-f834-46d1-a620-6d0f20f217f2' ),
( 1  , 'f73c1969-49c4-4ef5-8943-e8838547a275' ),
( 16 , 'ef15c91f-734f-4e08-b6fa-d148b8ecbfc0' ),
( 31 , 'ae0288ee-a173-4dd3-ae81-88c9e01970ea' ),
( 27 , 'dd2c4fc5-3fea-430a-9442-c65a85d9c320' ),
( 29 , '88692569-a213-43c3-b1f3-d8745c456543' ),
( 28 , '3c7f88b0-b844-47ba-b4da-4b5dee2b8b0a' ),
( 2  , 'df621bc1-6f2e-46bf-9fe9-184f1fdd41f2' ),
( 17 , 'f55d3760-1bf1-4e42-a7f9-0a901fa49cf0' );
UPDATE itech.typeToForm i, form t SET i.form_id = t.form_id where i.uuid = t.uuid;

CREATE TABLE itech.typeToType (encounterType INT, encounter_type_id INT, uuid VARCHAR(36));
INSERT INTO itech.typeToType (encounterType, uuid) VALUES 
( 1  , '17536ba6-dd7c-4f58-8014-08c7cb798ac7' ),
( 2  , '204ad066-c5c2-4229-9a62-644bc5617ca2' ),
( 5  , '10d73929-54b6-4d18-a647-8b7316bc1ae3' ),
( 3  , 'a0d57dca-3028-4153-88b7-c67a30fde595' ),
( 6  , 'f037e97b-471e-4898-a07c-b8e169e0ddc4' ),
( 12 , '9d0113c6-f23a-4461-8428-7e9a7344f2ba' ),
( 14 , 'c45d7299-ad08-4cb5-8e5d-e0ce40532939' ),
( 4  , 'a0d57dca-3028-4153-88b7-c67a30fde595' ),
( 19 , 'f037e97b-471e-4898-a07c-b8e169e0ddc4' ),
( 21 , '9d0113c6-f23a-4461-8428-7e9a7344f2ba' ),
( 20 , 'c45d7299-ad08-4cb5-8e5d-e0ce40532939' ),
( 16 , '349ae0b4-65c1-4122-aa06-480f186c8350' ),
( 17 , '33491314-c352-42d0-bd5d-a9d0bffc9bf1' ),
( 18 , 'a9392241-109f-4d67-885b-57cc4b8c638f' ),
( 24 , '5c312603-25c1-4dbe-be18-1a167eb85f97' ),
( 25 , '49592bec-dd22-4b6c-a97f-4dd2af6f2171' ),
( 26 , 'd95b3540-a39f-4d1e-a301-8ee0e03d5eab' ),
( 27 , '12f4d7c3-e047-4455-a607-47a40fe32460' ),
( 28 , 'a5600919-4dde-4eb8-a45b-05c204af8284' ),
( 29 , '709610ff-5e39-4a47-9c27-a60e740b0944' ),
( 31 , 'fdb5b14f-555f-4282-b4c1-9286addf0aae' );
UPDATE itech.typeToType i, encounter_type t SET i.encounter_type_id = t.encounter_type_id where i.uuid = t.uuid;

INSERT INTO encounter(encounter_type,patient_id,location_id,form_id,visit_id, encounter_datetime,creator,date_created,date_changed,uuid,encounter_id)
SELECT ALL t.encounter_type_id, p.person_id, e.siteCode, f.form_id, v.visit_id,
ymdToDate(e.visitdateyy,e.visitdatemm,e.visitdatedd),1,e.createDate,e.lastModified,UUID(), e.encounter_id
FROM itech.encounter e, person p, itech.patient j, visit v, itech.typeToForm f, itech.typeToType t
WHERE p.uuid = j.patGuid and 
e.patientID = j.patientID AND 
v.patient_id = p.person_id AND 
v.date_started = ymdToDate(e.visitdateyy,e.visitdatemm,e.visitdatedd) AND 
e.encounterType in (1,2,3,4,5,6,12,14,16,17,18,19,20,21,24,25,26,27,28,29,31) AND
e.encounterType = f.encounterType AND
e.encounterType = t.encounterType
ON DUPLICATE KEY UPDATE
encounter_type=VALUES(encounter_type),
patient_id=VALUES(patient_id),
location_id=VALUES(location_id),
form_id=VALUES(form_id),
encounter_datetime=VALUES(encounter_datetime),
creator=VALUES(creator),
date_created=VALUES(date_created),
date_changed=VALUES(date_changed);

create unique index nnn on obs (person_id,location_id,concept_id,obs_datetime);
	
/* SIGNES VITAUX MENU */
/*DATA Migration for vitals Temp*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_numeric,creator,date_created,uuid)
SELECT DISTINCT c.patient_id,5088,c.encounter_id,c.encounter_datetime,c.location_id,
CASE WHEN v.vitalTempUnits=2 THEN ROUND((substring_index(replace(v.vitalTemp,',','.'),'.',2)+0-32)/1.8000,2) 
ELSE ROUND(substring_index(replace(v.vitalTemp,',','.'),'.',2)+0,2) END,1,c.date_created,UUID()
from encounter c, itech.encounter e, itech.vitals v 
WHERE c.uuid = e.encGuid and 
e.patientid = v.patientid and e.sitecode = v.sitecode and concat(e.visitdateyy,'-',e.visitdatemm,'-',e.visitdatedd) = concat(v.visitdateyy,'-',v.visitdatemm,'-',v.visitdatedd) and e.seqNum = v.seqNum AND 
(substring_index(replace(v.vitalTemp,',','.'),'.',2)+0 > 0 AND vitalTempUnits IS NOT NULL) ON DUPLICATE KEY UPDATE
person_id     =VALUES(person_id       ),
concept_id    =VALUES(concept_id      ),
encounter_id  =VALUES(encounter_id    ),
obs_datetime  =VALUES(obs_datetime    ),
location_id   =VALUES(location_id     ),
value_numeric =VALUES(value_numeric   ),
creator       =VALUES(creator         ),
date_created  =VALUES(date_created    );

/*
select vitalBPUnits, CASE 
WHEN replace(v.vitalBp1,',','.')+0 < 50 then replace(v.vitalBp1,',','.')+0*10 
ELSE replace(v.vitalBp1,',','.')+0  END as vitalBP1,
CASE WHEN replace(v.vitalBp2,',','.')+0 < 50 then replace(v.vitalBp2,',','.')+0*10 
ELSE replace(v.vitalBp2,',','.')+0  END as vitalBP2 
from itech.vitals v
where v.vitalBp1 is not null and v.vitalBp2 is not null
limit 50;
*/

/*DATA Migration for vitals TA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_numeric,creator,date_created,uuid)
SELECT DISTINCT p.person_id,5085,e.encounter_id,e.encounter_datetime,e.location_id,
CASE WHEN v.vitalBPUnits=1 THEN substring_index(replace(v.vitalBp1+0,',','.'),'.',2)
WHEN v.vitalBPUnits=2 THEN substring_index(replace(v.vitalBp1+0,',','.'),'.',2)*10 END,1,e.date_created,UUID()
FROM person p, itech.patient j, encounter e, itech.vitals v 
WHERE p.uuid = j.patGuid and p.person_id = e.patient_id and j.patientID = v.patientID and
e.location_id = v.sitecode and e.encounter_datetime = concat(v.visitdateyy,'-',v.visitdatemm,'-',v.visitdatedd) AND 
substring_index(replace(v.vitalBp1,',','.'),'.',2) REGEXP '^[0-9\.]+$' and v.vitalBp1 IS NOT NULL AND v.vitalBp2 <> '' ON DUPLICATE KEY UPDATE
person_id     =VALUES(person_id       ),
concept_id    =VALUES(concept_id      ),
encounter_id  =VALUES(encounter_id    ),
obs_datetime  =VALUES(obs_datetime    ),
location_id   =VALUES(location_id     ),
value_numeric =VALUES(value_numeric   ),
creator       =VALUES(creator         ),
date_created  =VALUES(date_created    );

INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_numeric,creator,date_created,uuid)
SELECT DISTINCT p.person_id,5086,e.encounter_id,e.encounter_datetime,e.location_id,
CASE WHEN v.vitalBPUnits=1 THEN substring_index(replace(v.vitalBp2,',','.'),'.',2)
WHEN v.vitalBPUnits=2 THEN substring_index(replace(v.vitalBp2,',','.'),'.',2)*10 END,1,e.date_created,UUID()
FROM person p, itech.patient j, encounter e, itech.vitals v 
WHERE p.uuid = j.patGuid and p.person_id = e.patient_id and j.patientID = v.patientID and
e.location_id = v.sitecode and e.encounter_datetime = concat(v.visitdateyy,'-',v.visitdatemm,'-',v.visitdatedd) AND 
substring_index(replace(v.vitalBp2,',','.'),'.',2) REGEXP '^[0-9\.]+$' and v.vitalBp2 IS NOT NULL AND v.vitalBp2 <> '' ON DUPLICATE KEY UPDATE
person_id     =VALUES(person_id       ),
concept_id    =VALUES(concept_id      ),
encounter_id  =VALUES(encounter_id    ),
obs_datetime  =VALUES(obs_datetime    ),
location_id   =VALUES(location_id     ),
value_numeric =VALUES(value_numeric   ),
creator       =VALUES(creator         ),
date_created  =VALUES(date_created    );

/*DATA Migration for vitals POULS*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_numeric,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,5087,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,vitals.vitalHr,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.vitalHr<>'';




/*DATA Migration for vitals FR*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_numeric,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,5242,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,vitals.vitalRr,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.vitalHr<>'';




/*DATA Migration for vitals TAILLE*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_numeric,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,5090,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.vitalHeightCm<>'' THEN itech.vitals.vitalHeightCm
WHEN itech.vitals.vitalHeight<>''  THEN vitalHeight*100
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND (itech.vitals.vitalHeight<>''
OR itech.vitals.vitalHeightCm<>'');



/*DATA Migration for vitals POIDS*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_numeric,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,5089,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.vitalWeightUnits=1 THEN itech.vitals.vitalWeight
WHEN itech.vitals.vitalWeightUnits=2  THEN itech.vitals.vitalWeight/2.2046
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.vitalWeight<>'';



/*END OF SIGNES VITAUX MENU*/

/*STARTING SOURCE DE RÉFÉRENCE MENU*/
/*MIGRATION FOR Hôpital (patient a été hospitalisé antérieurement)*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159936,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.referHosp=1 THEN 5485
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.referHosp=1;




/*MIGRATION FOR Centres CDV intégrés*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159936,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.referVctCenter=1 THEN 159940
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.referVctCenter=1;




/*MIGRATION FOR Programme PTME*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159936,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.referPmtctProg=1 THEN 159937
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.referPmtctProg=1;



/*MIGRATION FOR Clinique Externe*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159936,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.referOutpatStd=1 THEN 160542
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.referOutpatStd=1;



/*MIGRATION FOR Programmes communautaires*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159936,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.referCommunityBasedProg=1 THEN 159938
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.referCommunityBasedProg=1;




/*MIGRATION FOR Transfert d'un autre établissement de santé*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,comments,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159936,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.firstCareOtherFacText<>'' THEN 5622
ELSE NULL
END,itech.vitals.firstCareOtherFacText,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.firstCareOtherFacText<>'';




/*END OF SOURCE DE RÉFÉRENCE MENU*/

/*STARTING TEST ANTICORPS VIH MENU*/
/*Migration for Date du premier test (anticorps) VIH positif*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160082,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.firstTestYy<>'' AND itech.vitals.firstTestMm<>'' THEN CONCAT(itech.vitals.firstTestYy,'-',itech.vitals.firstTestMm,'-',01)
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.firstTestYy<>''
AND itech.vitals.firstTestMm<>'';




/*Migration for Établissement où le test a été réalisé*/
/*Cet établissement */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159936,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.firstTestThisFac=1 THEN 163266
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.firstTestThisFac=1;




/*Autre */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,comments,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159936,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.firstTestOtherFac=1 THEN 5622
ELSE NULL
END,itech.vitals.firstTestOtherFacText,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.firstTestOtherFac=1;




/*END OF TEST ANTICORPS VIH MENU*/

/*STARTING ANTECEDENTS OBSTETRIQUES ET GROSSESSE MENU*/
/*GRAVIDA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_numeric,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,5624,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.gravida<>'' THEN itech.vitals.gravida
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.gravida<>'';




/*PARA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_numeric,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1053,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.para<>'' THEN itech.vitals.para
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.para<>'';




/*Aborta*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_numeric,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1823,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.aborta<>'' THEN itech.vitals.aborta
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.aborta<>'';




/*Enfants vivants*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_numeric,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1825,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.children<>'' THEN itech.vitals.children
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.children<>'';




/*Grossesse actuelle*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,5272,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.pregnant=1 THEN 1065
WHEN itech.vitals.pregnant=2 THEN 1066
WHEN itech.vitals.pregnant=4 THEN 1067
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.pregnant<>'';




/*Migration for Date du dernier Pap Test*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,163267,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.papTestDd<1 AND itech.vitals.papTestMm<1 AND itech.vitals.papTestYy>0 THEN CONCAT(itech.vitals.papTestYy,01,01)
WHEN itech.vitals.papTestDd<1 AND itech.vitals.papTestMm>0 AND itech.vitals.papTestYy>0 THEN CONCAT(itech.vitals.papTestYy,itech.vitals.papTestMm,01)
WHEN itech.vitals.papTestDd>0 AND itech.vitals.papTestMm>0 AND itech.vitals.papTestYy>0
THEN CONCAT(itech.vitals.papTestYy,itech.vitals.papTestMm,itech.vitals.papTestDd)  
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.papTestYy>0;




/* Migration for Date des dernières règles*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1427,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.papTestDd<1 AND itech.vitals.pregnantLmpMm<1 AND itech.vitals.pregnantLmpYy>0 THEN CONCAT(itech.vitals.pregnantLmpDd,01,01)
WHEN itech.vitals.pregnantLmpDd<1 AND itech.vitals.pregnantLmpMm>0 AND itech.vitals.pregnantLmpYy>0 THEN CONCAT(itech.vitals.pregnantLmpYy,itech.vitals.pregnantLmpMm,01)
WHEN itech.vitals.pregnantLmpDd>0 AND itech.vitals.pregnantLmpMm>0 AND itech.vitals.pregnantLmpYy>0
THEN CONCAT(itech.vitals.pregnantLmpYy,itech.vitals.pregnantLmpMm,itech.vitals.pregnantLmpDd)  
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.pregnantLmpYy>0;




/*END OF ANTECEDENTS OBSTETRIQUES ET GROSSESSE MENU*/

/*STARTING ANTECEDENTS ÉTAT DE FONCTIONNEMENT MENU*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,162753,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.functionalStatus=1 THEN 159468
WHEN itech.vitals.functionalStatus=2 THEN 160026
WHEN itech.vitals.functionalStatus=4 THEN 162752
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.functionalStatus>0;



/*END OF ANTECEDENTS ÉTAT DE FONCTIONNEMENT MENU*/
/*STARTING MIGRATION FOR PLANNING FAMILIAL MENU*/
/*YES OR NO / OUI OU Non */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,374,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.famPlan=1 THEN 965
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.famPlan=1;




/*Préservatif */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,374,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.famPlan=1 AND itech.vitals.famPlanMethodCondom=1 THEN 190
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.famPlan=1
AND itech.vitals.famPlanMethodCondom=1;




/*DMPA */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,374,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.famPlan=1 AND itech.vitals.famPlanMethodDmpa=1 THEN 5279
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.famPlan=1
AND itech.vitals.famPlanMethodDmpa=1;




/*Pilules*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,374,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.famPlan=1 AND itech.vitals.famPlanMethodOcPills=1 THEN 780
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.famPlan=1
AND itech.vitals.famPlanMethodOcPills=1;




/* Autre  OTHER NON-CODED 5622*/
/*INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,comments,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,374,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.famPlanOtherText<>'' THEN 5622
ELSE NULL
END,
CASE WHEN itech.vitals.famPlan=1 AND itech.vitals.famPlanOtherText<>'' THEN itech.vitals.famPlanOtherText
ELSE NULL
END,
1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter.visitDate=CONCAT(itech.vitals.visitDateYy,itech.vitals.visitDateMm,itech.vitals.visitDateDd)
AND itech.vitals.famPlan=1
AND itech.vitals.famPlanOtherText<>'';


*/
/*END OF MIGRATION FOR PLANNING FAMILIAL MENU*/
/*STARTING MIGRATION FOR MODE PROBABLE DE TRANSMISSION DU VIH MENU*/
/*Rapports sexuels avec un homme*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1061,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.riskAssessments.riskID=1 AND itech.riskAssessments.riskAnswer=1 THEN 163290
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.riskAssessments ON itech.encounter.patientID=itech.riskAssessments.patientID
WHERE itech.riskAssessments.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.riskAssessments.visitDateYy,'-',itech.riskAssessments.visitDateMm,'-',itech.riskAssessments.visitDateDd)
AND itech.riskAssessments.riskID=1
AND itech.riskAssessments.riskAnswer=1;




/*Rapports sexuels avec une femme*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1061,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.riskAssessments.riskID=3 AND itech.riskAssessments.riskAnswer=1 THEN 163291
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.riskAssessments ON itech.encounter.patientID=itech.riskAssessments.patientID
WHERE itech.riskAssessments.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.riskAssessments.visitDateYy,'-',itech.riskAssessments.visitDateMm,'-',itech.riskAssessments.visitDateDd)
AND itech.riskAssessments.riskID=3
AND itech.riskAssessments.riskAnswer=1;



/*Injection de drogues*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1061,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.riskAssessments.riskID=9 AND itech.riskAssessments.riskAnswer=1 THEN 105
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.riskAssessments ON itech.encounter.patientID=itech.riskAssessments.patientID
WHERE itech.riskAssessments.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.riskAssessments.visitDateYy,'-',itech.riskAssessments.visitDateMm,'-',itech.riskAssessments.visitDateDd)
AND itech.riskAssessments.riskID=9
AND itech.riskAssessments.riskAnswer=1;



/*Bénéficier de sang/dérivé sanguin*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1061,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.riskAssessments.riskID=15 AND itech.riskAssessments.riskAnswer=1 THEN 1063
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.riskAssessments ON itech.encounter.patientID=itech.riskAssessments.patientID
WHERE itech.riskAssessments.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.riskAssessments.visitDateYy,'-',itech.riskAssessments.visitDateMm,'-',itech.riskAssessments.visitDateDd)
AND itech.riskAssessments.riskID=15
AND itech.riskAssessments.riskAnswer=1;



/*FOR THE DATE*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,163268,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.riskAssessments.riskID=15 AND itech.riskAssessments.riskAnswer=1 AND itech.riskAssessments.riskDd<1 
AND itech.riskAssessments.riskMm<1 AND itech.riskAssessments.riskYy>0 THEN CONCAT(itech.riskAssessments.riskYy,'-',01,'-',01)
WHEN itech.riskAssessments.riskID=15 AND itech.riskAssessments.riskAnswer=1 AND itech.riskAssessments.riskDd<1 
AND itech.riskAssessments.riskMm>0 AND itech.riskAssessments.riskYy>0 THEN CONCAT(itech.riskAssessments.riskYy,'-',itech.riskAssessments.riskMm,'-',01)
WHEN itech.riskAssessments.riskID=15 AND itech.riskAssessments.riskAnswer=1 AND itech.riskAssessments.riskDd>0 
AND itech.riskAssessments.riskMm>0 AND itech.riskAssessments.riskYy>0 THEN 
CONCAT(itech.riskAssessments.riskYy,'-',itech.riskAssessments.riskMm,'-',itech.riskAssessments.riskDd)
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.riskAssessments ON itech.encounter.patientID=itech.riskAssessments.patientID
WHERE itech.riskAssessments.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.riskAssessments.visitDateYy,'-',itech.riskAssessments.visitDateMm,'-',itech.riskAssessments.visitDateDd)
AND itech.riskAssessments.riskID=15
AND itech.riskAssessments.riskAnswer=1
AND itech.riskAssessments.riskYy>0;



/*Migration FOR Transmission mère a enfant*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1061,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.riskAssessments.riskID=14 AND itech.riskAssessments.riskAnswer=1 THEN 163273
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.riskAssessments ON itech.encounter.patientID=itech.riskAssessments.patientID
WHERE itech.riskAssessments.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.riskAssessments.visitDateYy,'-',itech.riskAssessments.visitDateMm,'-',itech.riskAssessments.visitDateDd)
AND itech.riskAssessments.riskID=14
AND itech.riskAssessments.riskAnswer=1;




/*MIGRATION FOR Accident d'exposition au sang*/
/*CREATE TABLE FOR CONCEPTS GROUP*/
DROP TABLE IF EXISTS itech.obs_concept_group;



CREATE TABLE itech.obs_concept_group (    
obs_id INT(11) NOT NULL,
person_id INT(11) NOT NULL,
concept_id INT(11) NOT NULL,
encounter_id INT(11) NOT NULL,
location_id INT(11) NOT NULL,
obs_datetime datetime,
CONSTRAINT pkobsconceptid PRIMARY KEY (obs_id)
);



/*Migration for obsgroup*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,163288,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.riskAssessments ON itech.encounter.patientID=itech.riskAssessments.patientID
WHERE itech.riskAssessments.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.riskAssessments.visitDateYy,'-',itech.riskAssessments.visitDateMm,'-',itech.riskAssessments.visitDateDd)
AND itech.riskAssessments.riskID=12
AND itech.riskAssessments.riskAnswer=1;




INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT openmrs.obs.obs_id,openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=163288;




/*migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs, 160581,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,itech.obs_concept_group.obs_id,
CASE WHEN itech.riskAssessments.riskID=12 AND itech.riskAssessments.riskAnswer=1 THEN 163274
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.riskAssessments ON itech.encounter.patientID=itech.riskAssessments.patientID
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
WHERE itech.riskAssessments.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.riskAssessments.visitDateYy,'-',itech.riskAssessments.visitDateMm,'-',itech.riskAssessments.visitDateDd)
AND itech.riskAssessments.riskID=12
AND itech.riskAssessments.riskAnswer=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=163288;



/*migration for the date*/

INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs, 162601,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,itech.obs_concept_group.obs_id,
CASE WHEN itech.riskAssessments.riskID=12 AND itech.riskAssessments.riskAnswer=1 AND itech.riskAssessments.riskDd<1 
AND itech.riskAssessments.riskMm<1 AND itech.riskAssessments.riskYy>0 THEN CONCAT(itech.riskAssessments.riskYy,'-',01,'-',01)
WHEN itech.riskAssessments.riskID=15 AND itech.riskAssessments.riskAnswer=1 AND itech.riskAssessments.riskDd<1 
AND itech.riskAssessments.riskMm>0 AND itech.riskAssessments.riskYy>0 THEN CONCAT(itech.riskAssessments.riskYy,'-',itech.riskAssessments.riskMm,'-',01)
WHEN itech.riskAssessments.riskID=15 AND itech.riskAssessments.riskAnswer=1 AND itech.riskAssessments.riskDd>0 
AND itech.riskAssessments.riskMm>0 AND itech.riskAssessments.riskYy>0 THEN 
CONCAT(itech.riskAssessments.riskYy,'-',itech.riskAssessments.riskMm,'-',itech.riskAssessments.riskDd)
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.riskAssessments ON itech.encounter.patientID=itech.riskAssessments.patientID
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
WHERE itech.riskAssessments.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.riskAssessments.visitDateYy,'-',itech.riskAssessments.visitDateMm,'-',itech.riskAssessments.visitDateDd)
AND itech.riskAssessments.riskID=12
AND itech.riskAssessments.riskAnswer=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=163288;




/*MIGRATION FOR Rapports hétérosexuelles avec :
- personne SIDA/VIH+
*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1061,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.riskAssessments.riskID=19 AND itech.riskAssessments.riskAnswer=1 THEN 163289
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.riskAssessments ON itech.encounter.patientID=itech.riskAssessments.patientID
WHERE itech.riskAssessments.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.riskAssessments.visitDateYy,'-',itech.riskAssessments.visitDateMm,'-',itech.riskAssessments.visitDateDd)
AND itech.riskAssessments.riskID=19
AND itech.riskAssessments.riskAnswer=1;




/*MIGRATION FOR - personne qui s'injecte de la drogue */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1061,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.riskAssessments.riskID=5 AND itech.riskAssessments.riskAnswer=1 THEN 105
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.riskAssessments ON itech.encounter.patientID=itech.riskAssessments.patientID
WHERE itech.riskAssessments.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.riskAssessments.visitDateYy,'-',itech.riskAssessments.visitDateMm,'-',itech.riskAssessments.visitDateDd)
AND itech.riskAssessments.riskID=5
AND itech.riskAssessments.riskAnswer=1;




/*MIGRATION FOR - homme bisexuel */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1061,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.riskAssessments.riskID=6 AND itech.riskAssessments.riskAnswer=1 THEN 163275
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.riskAssessments ON itech.encounter.patientID=itech.riskAssessments.patientID
WHERE itech.riskAssessments.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.riskAssessments.visitDateYy,'-',itech.riskAssessments.visitDateMm,'-',itech.riskAssessments.visitDateDd)
AND itech.riskAssessments.riskID=6
AND itech.riskAssessments.riskAnswer=1;




/*MIGRATION FOR - bénéficier de sang/dérivé sanguin */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1061,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.riskAssessments.riskID=31 AND itech.riskAssessments.riskAnswer=1 THEN 1063
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.riskAssessments ON itech.encounter.patientID=itech.riskAssessments.patientID
WHERE itech.riskAssessments.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.riskAssessments.visitDateYy,'-',itech.riskAssessments.visitDateMm,'-',itech.riskAssessments.visitDateDd)
AND itech.riskAssessments.riskID=31
AND itech.riskAssessments.riskAnswer=1;




/*END OF MIGRATION FOR MODE PROBABLE DE TRANSMISSION DU VIH MENU*/

/*MIGRATION FOR AUTRES FACTEURS DE RISQUE MENU*/
/*Migration for Histoire ou présence de syphilis*/
/*Migration for obsgroup*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,163292,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.riskAssessments ON itech.encounter.patientID=itech.riskAssessments.patientID
WHERE itech.riskAssessments.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.riskAssessments.visitDateYy,'-',itech.riskAssessments.visitDateMm,'-',itech.riskAssessments.visitDateDd)
AND itech.riskAssessments.riskID=32
AND (itech.riskAssessments.riskAnswer=1
OR itech.riskAssessments.riskAnswer=2
OR itech.riskAssessments.riskAnswer=4);




INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT openmrs.obs.obs_id,openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=163292;



/*migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs, 163276,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,itech.obs_concept_group.obs_id,
CASE WHEN itech.riskAssessments.riskID=32 AND itech.riskAssessments.riskAnswer=1 THEN 1065
WHEN itech.riskAssessments.riskID=32 AND itech.riskAssessments.riskAnswer=2 THEN 1066
WHEN itech.riskAssessments.riskID=32 AND itech.riskAssessments.riskAnswer=4 THEN 1067
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.riskAssessments ON itech.encounter.patientID=itech.riskAssessments.patientID
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
WHERE itech.riskAssessments.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.riskAssessments.visitDateYy,'-',itech.riskAssessments.visitDateMm,'-',itech.riskAssessments.visitDateDd)
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=163292
AND itech.riskAssessments.riskID=32
AND (itech.riskAssessments.riskAnswer=1
OR itech.riskAssessments.riskAnswer=2
OR itech.riskAssessments.riskAnswer=4);




/*migration for Victime d'agression sexuelle*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs, 123160,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,itech.obs_concept_group.obs_id,
CASE WHEN itech.riskAssessments.riskID=13 AND itech.riskAssessments.riskAnswer=1 THEN 1065
WHEN itech.riskAssessments.riskID=13 AND itech.riskAssessments.riskAnswer=2 THEN 1066
WHEN itech.riskAssessments.riskID=13 AND itech.riskAssessments.riskAnswer=4 THEN 1067
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.riskAssessments ON itech.encounter.patientID=itech.riskAssessments.patientID
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
WHERE itech.riskAssessments.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.riskAssessments.visitDateYy,'-',itech.riskAssessments.visitDateMm,'-',itech.riskAssessments.visitDateDd)
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=163292
AND itech.riskAssessments.riskID=13
AND (itech.riskAssessments.riskAnswer=1
OR itech.riskAssessments.riskAnswer=2
OR itech.riskAssessments.riskAnswer=4);




/*Migration for Rapports sexuels :
- ≥ 2 personnes dans les 3 dernières mois
*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160581,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.riskAssessments.riskID=33 AND itech.riskAssessments.riskAnswer=1 THEN 5567
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.riskAssessments ON itech.encounter.patientID=itech.riskAssessments.patientID
WHERE itech.riskAssessments.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.riskAssessments.visitDateYy,'-',itech.riskAssessments.visitDateMm,'-',itech.riskAssessments.visitDateDd)
AND itech.riskAssessments.riskID=33
AND itech.riskAssessments.riskAnswer=1;




/*- par voie anale*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,163278,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.riskAssessments.riskID=7 AND itech.riskAssessments.riskAnswer=1 THEN 1065
WHEN itech.riskAssessments.riskID=7 AND itech.riskAssessments.riskAnswer=2 THEN 1066
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.riskAssessments ON itech.encounter.patientID=itech.riskAssessments.patientID
WHERE itech.riskAssessments.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.riskAssessments.visitDateYy,'-',itech.riskAssessments.visitDateMm,'-',itech.riskAssessments.visitDateDd)
AND itech.riskAssessments.riskID=7
AND (itech.riskAssessments.riskAnswer=1 OR itech.riskAssessments.riskAnswer=2);




/*- avec travailleur/euse de sexe*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160581,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.riskAssessments.riskID=20 AND (itech.riskAssessments.riskAnswer=1 OR itech.riskAssessments.riskAnswer=2) THEN 160580
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.riskAssessments ON itech.encounter.patientID=itech.riskAssessments.patientID
WHERE itech.riskAssessments.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.riskAssessments.visitDateYy,'-',itech.riskAssessments.visitDateMm,'-',itech.riskAssessments.visitDateDd)
AND itech.riskAssessments.riskID=20
AND (itech.riskAssessments.riskAnswer=1 OR itech.riskAssessments.riskAnswer=2);




INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160580,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.riskAssessments.riskID=20 AND itech.riskAssessments.riskAnswer=1 THEN 1065 
WHEN itech.riskAssessments.riskID=20 AND itech.riskAssessments.riskAnswer=2 THEN 1066
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.riskAssessments ON itech.encounter.patientID=itech.riskAssessments.patientID
WHERE itech.riskAssessments.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.riskAssessments.visitDateYy,'-',itech.riskAssessments.visitDateMm,'-',itech.riskAssessments.visitDateDd)
AND itech.riskAssessments.riskID=20
AND (itech.riskAssessments.riskAnswer=1 OR itech.riskAssessments.riskAnswer=2);




/* - L'échange de sexe pour argent/choses*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160581,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.riskAssessments.riskID=34 AND (itech.riskAssessments.riskAnswer=1 OR itech.riskAssessments.riskAnswer=2) THEN 160579
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.riskAssessments ON itech.encounter.patientID=itech.riskAssessments.patientID
WHERE itech.riskAssessments.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.riskAssessments.visitDateYy,'-',itech.riskAssessments.visitDateMm,'-',itech.riskAssessments.visitDateDd)
AND itech.riskAssessments.riskID=34
AND (itech.riskAssessments.riskAnswer=1 OR itech.riskAssessments.riskAnswer=2);




INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160579,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.riskAssessments.riskID=34 AND itech.riskAssessments.riskAnswer=1 THEN 1065 
WHEN itech.riskAssessments.riskID=34 AND itech.riskAssessments.riskAnswer=2 THEN 1066
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.riskAssessments ON itech.encounter.patientID=itech.riskAssessments.patientID
WHERE itech.riskAssessments.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.riskAssessments.visitDateYy,'-',itech.riskAssessments.visitDateMm,'-',itech.riskAssessments.visitDateDd)
AND itech.riskAssessments.riskID=34
AND (itech.riskAssessments.riskAnswer=1 OR itech.riskAssessments.riskAnswer=2);




/*END OF MIGRATION FOR AUTRES FACTEURS DE RISQUE MENU*/

/*STARTING MIGRATION FOR COMPTE CD4 MENU*/
/*Compte CD4 le plus bas*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_numeric,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159375,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.lowestCd4Cnt<>'' THEN itech.vitals.lowestCd4Cnt
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.lowestCd4Cnt<>'';



/* DATE */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159376,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.lowestCd4CntDd<1 AND itech.vitals.lowestCd4CntMm<1 AND itech.vitals.lowestCd4CntYy>0 
THEN CONCAT(itech.vitals.lowestCd4CntYy,'-',01,'-',01)
WHEN itech.vitals.lowestCd4CntDd<1 AND itech.vitals.lowestCd4CntMm>0 AND itech.vitals.lowestCd4CntYy>0
THEN CONCAT(itech.vitals.lowestCd4CntYy,'-',itech.vitals.lowestCd4CntMm,'-',01)
WHEN itech.vitals.lowestCd4CntDd>0 AND itech.vitals.lowestCd4CntMm>0 AND itech.vitals.lowestCd4CntYy>0
THEN CONCAT(itech.vitals.lowestCd4CntYy,'-',itech.vitals.lowestCd4CntMm,'-',itech.vitals.lowestCd4CntDd)
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.lowestCd4Cnt<>''
AND itech.vitals.lowestCd4CntYy>0;



/*Non effectué/Inconnu*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1941,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.lowestCd4Cnt<>'' AND itech.vitals.lowestCd4CntNotDone=1 THEN 1066
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.lowestCd4Cnt<>''
AND itech.vitals.lowestCd4CntNotDone=1;



/*MIGRATION for Virémie*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_numeric,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,163280,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.firstViralLoad<>'' THEN itech.vitals.firstViralLoad
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.firstViralLoad<>'';




/* DATE */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,163281,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.firstViralLoadDd<1 AND itech.vitals.firstViralLoadMm<1 AND itech.vitals.firstViralLoadYy>0 
THEN CONCAT(itech.vitals.firstViralLoadYy,'-',01,'-',01)
WHEN itech.vitals.firstViralLoadDd<1 AND itech.vitals.firstViralLoadMm>0 AND itech.vitals.firstViralLoadYy>0
THEN CONCAT(itech.vitals.firstViralLoadYy,'-',itech.vitals.firstViralLoadMm,'-',01)
WHEN itech.vitals.firstViralLoadDd>0 AND itech.vitals.firstViralLoadMm>0 AND itech.vitals.firstViralLoadYy>0
THEN CONCAT(itech.vitals.firstViralLoadYy,'-',itech.vitals.firstViralLoadMm,'-',itech.vitals.firstViralLoadDd)
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.firstViralLoad<>''
AND itech.vitals.firstViralLoadYy>0;




/*END OF MIGRATION FOR COMPTE CD4 MENU*/

/*MIGRATION FOR STATUT TB MENU*/

INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1659,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.tbStatus.asymptomaticTb=1 AND (itech.tbStatus.completeTreat=0 OR itech.tbStatus.completeTreat='') 
AND (itech.tbStatus.currentTreat=0 OR itech.tbStatus.currentTreat='') THEN 1660
WHEN itech.tbStatus.completeTreat=1 AND (itech.tbStatus.asymptomaticTb=0 OR itech.tbStatus.asymptomaticTb='') 
AND (itech.tbStatus.currentTreat=0 OR itech.tbStatus.currentTreat='') THEN 1663
WHEN itech.tbStatus.currentTreat=1 AND (itech.tbStatus.asymptomaticTb=0 OR itech.tbStatus.asymptomaticTb='') 
AND (itech.tbStatus.completeTreat=0 OR itech.tbStatus.completeTreat='') THEN 1662
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.tbStatus ON itech.encounter.patientID=itech.tbStatus.patientID
WHERE itech.tbStatus.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.tbStatus.visitDateYy,'-',itech.tbStatus.visitDateMm,'-',itech.tbStatus.visitDateDd)
AND (itech.tbStatus.asymptomaticTb=1 OR itech.tbStatus.completeTreat=1 OR itech.tbStatus.currentTreat=1);



/*Migration for Date complété */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159431,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.tbStatus.completeTreatDd<1 AND itech.tbStatus.completeTreatMm<1 AND itech.tbStatus.completeTreatYy>0 
THEN CONCAT(itech.tbStatus.completeTreatYy,'-',01,'-',01)
WHEN itech.tbStatus.completeTreatDd<1 AND itech.tbStatus.completeTreatMm>0 AND itech.tbStatus.completeTreatYy>0
THEN CONCAT(itech.tbStatus.completeTreatYy,'-',itech.tbStatus.completeTreatMm,'-',01)
WHEN itech.tbStatus.completeTreatDd>0 AND itech.tbStatus.completeTreatMm>0 AND itech.tbStatus.completeTreatYy>0
THEN CONCAT(itech.tbStatus.completeTreatYy,'-',itech.tbStatus.completeTreatMm,'-',itech.tbStatus.completeTreatDd)
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.tbStatus ON itech.encounter.patientID=itech.tbStatus.patientID
WHERE itech.tbStatus.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.tbStatus.visitDateYy,'-',itech.tbStatus.visitDateMm,'-',itech.tbStatus.visitDateDd)
AND itech.tbStatus.completeTreat=1
AND itech.tbStatus.completeTreatYy>0;



/*On Going with james*/

/*END OF MIGRATION FOR STATUT TB MENU */

/*MIGRATION FOR VACCINS MENU*/
/*MIGRATION FOR Hépatite B*/
/*concept group */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1421,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND (itech.vitals.vaccTetanus=1 OR itech.vitals.vaccTetanus=1);




INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT openmrs.obs.obs_id,openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=1421;




/*migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs, 984,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,itech.obs_concept_group.obs_id,
CASE WHEN itech.vitals.vaccHepB=1 THEN 1685
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.vaccHepB=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1421;




/*migration for MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1410,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,itech.obs_concept_group.obs_id,
CASE WHEN itech.vitals.vaccHepB=1 AND itech.vitals.vaccHepBMm<1 AND itech.vitals.vaccHepBYy>0 THEN CONCAT(itech.vitals.vaccHepBYy,'-',01,'-',01)
WHEN itech.vitals.vaccHepB=1 AND itech.vitals.vaccHepBMm>0 AND itech.vitals.vaccHepBYy>0 THEN CONCAT(itech.vitals.vaccHepBYy,'-',itech.vitals.vaccHepBMm,'-',01)
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.vaccHepB=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1421
AND itech.vitals.vaccHepBYy>0;




/*migration for Nombre de dose */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_numeric,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1418,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,itech.obs_concept_group.obs_id,
CASE WHEN itech.vitals.vaccHepB=1 AND itech.vitals.hepBdoses>=0 THEN itech.vitals.hepBdoses
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.vaccHepB=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1421
AND itech.vitals.hepBdoses>=0;



/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*MIGRATION FOR Tétanos*/ 
/*concept group */
/*migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,984,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,itech.obs_concept_group.obs_id,
CASE WHEN itech.vitals.vaccTetanus=1 THEN 1685
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.vaccTetanus=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1421;




/*migration for MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1410,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,itech.obs_concept_group.obs_id,
CASE WHEN itech.vitals.vaccTetanus=1 AND itech.vitals.vaccTetanusMm<1 AND itech.vitals.vaccTetanusYy>0 THEN CONCAT(itech.vitals.vaccTetanusYy,'-',01,'-',01)
WHEN itech.vitals.vaccTetanus=1 AND itech.vitals.vaccTetanusMm>0 AND itech.vitals.vaccTetanusYy>0
THEN CONCAT(itech.vitals.vaccTetanusYy,'-',itech.vitals.vaccTetanusMm,'-',01)
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.vaccTetanus=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1421
AND itech.vitals.vaccTetanusYy>0;




/*migration for Nombre de dose */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_numeric,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1418,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,itech.obs_concept_group.obs_id,
CASE WHEN itech.vitals.vaccTetanus=1 AND itech.vitals.tetDoses>0 THEN itech.vitals.tetDoses
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.vaccTetanus=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1421
AND itech.vitals.tetDoses>0
AND itech.vitals.tetDoses<>'';




/*On going*/
/*Autre preciser*/
/*END OF MIGRATION FOR VACCINS MENU*/
/*MIGRATION FOR SYMPTÔMES MENU*/
/*migration for Douleur abdominale*/
/*concept group */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1727,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.obs.concept_id=7000
AND itech.obs.value_boolean=1;




INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=1727 GROUP BY openmrs.obs.person_id;




/*migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1728,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7000 AND itech.obs.value_boolean=1 THEN 151
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7000 
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for YES */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1729,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7000 AND itech.obs.value_boolean=1 THEN 1065
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7000 
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*=========================================================================================================*/
/*migration for Anorexie/Perte d'appétit*/
/*concept group */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1727,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.obs.concept_id=7001
AND itech.obs.value_boolean=1;




INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=1727 GROUP BY openmrs.obs.person_id;




/*migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1728,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7001 AND itech.obs.value_boolean=1 THEN 6031
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7001 
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for YES */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1729,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7001 AND itech.obs.value_boolean=1 THEN 1065
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7001 
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*migration for Toux*/
/*concept group */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1727,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.obs.concept_id=7004
AND itech.obs.value_boolean=1;




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=1727;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=1727 
GROUP BY openmrs.obs.person_id;




/*migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1728,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7004 AND itech.obs.value_boolean=1 THEN 143264
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7004 
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for YES */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1729,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7004 AND itech.obs.value_boolean=1 THEN 1065
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7004 
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*Migration for Toux/Expectoration (sauf hémoptysie)*/

/*concept group */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1727,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.obs.concept_id=7008
AND itech.obs.value_boolean=1;




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=1727;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=1727 
GROUP BY openmrs.obs.person_id;




/*migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1728,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7008 AND itech.obs.value_boolean=1 THEN 5957
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7008 
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for YES */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1729,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7008 AND itech.obs.value_boolean=1 THEN 1065
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7008 
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*Migration for Dyspnée*/
/*concept group */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1727,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.obs.concept_id=7007
AND itech.obs.value_boolean=1;




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=1727;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=1727 
GROUP BY openmrs.obs.person_id;




/*migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1728,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7007 AND itech.obs.value_boolean=1 THEN 122496
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7007 
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for YES */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1729,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7007 AND itech.obs.value_boolean=1 THEN 1065
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7007 
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*Migration for Céphalée*/
/*concept group */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1727,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.obs.concept_id=7011
AND itech.obs.value_boolean=1;




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=1727;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=1727 
GROUP BY openmrs.obs.person_id;




/*migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1728,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7011 AND itech.obs.value_boolean=1 THEN 139084
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7011 
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for YES */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1729,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7011 AND itech.obs.value_boolean=1 THEN 1065
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7011 
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*=============================================================================================================*/
/*Migration for Hémoptysie*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1727,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.obs.concept_id=7012
AND itech.obs.value_boolean=1;




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=1727;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=1727 
GROUP BY openmrs.obs.person_id;




/*migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1728,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7012 AND itech.obs.value_boolean=1 THEN 138905
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7012 
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for YES */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1729,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7012 AND itech.obs.value_boolean=1 THEN 1065
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7012 
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*=================================================================================================================*/
/*Migration for Nausée*/
/*Concept group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1727,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.obs.concept_id=7013
AND itech.obs.value_boolean=1;




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=1727;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=1727 
GROUP BY openmrs.obs.person_id;




/*migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1728,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7013 AND itech.obs.value_boolean=1 THEN 5978
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7013 
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for YES */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1729,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7013 AND itech.obs.value_boolean=1 THEN 1065
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7013
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*Migration for Sueurs nocturnes*/
/*Concept group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1727,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.obs.concept_id=7014
AND itech.obs.value_boolean=1;




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=1727;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=1727 
GROUP BY openmrs.obs.person_id;




/*migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1728,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7014 AND itech.obs.value_boolean=1 THEN 133027
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7014 
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for YES */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1729,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7014 AND itech.obs.value_boolean=1 THEN 1065
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7014
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*Migration for Perte de sensibilité*/
/*Concept group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1727,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.obs.concept_id=7015
AND itech.obs.value_boolean=1;




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=1727;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=1727 
GROUP BY openmrs.obs.person_id;




/*migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1728,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7015 AND itech.obs.value_boolean=1 THEN 141635
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7015 
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for YES */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1729,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7015 AND itech.obs.value_boolean=1 THEN 1065
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7015
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*Migration for Odynophagie/dysphagie*/
/*Concept group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1727,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.obs.concept_id=7016
AND itech.obs.value_boolean=1;




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=1727;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=1727 
GROUP BY openmrs.obs.person_id;




/*migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1728,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7016 AND itech.obs.value_boolean=1 THEN 118789
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7016 
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for YES */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1729,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7016 AND itech.obs.value_boolean=1 THEN 1065
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7016
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*Migration for Eruption cutanée*/
/*Concept group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1727,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.obs.concept_id=7024
AND itech.obs.value_boolean=1;




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=1727;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=1727 
GROUP BY openmrs.obs.person_id;




/*migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1728,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7024 AND itech.obs.value_boolean=1 THEN 512
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7024 
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for YES */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1729,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7024 AND itech.obs.value_boolean=1 THEN 1065
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7024
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*Migration for Vomissement*/
/*Concept group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1727,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.obs.concept_id=7025
AND itech.obs.value_boolean=1;




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=1727;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=1727 
GROUP BY openmrs.obs.person_id;




/*migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1728,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7025 AND itech.obs.value_boolean=1 THEN 122983
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7025 
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for YES */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1729,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7025 AND itech.obs.value_boolean=1 THEN 1065
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7025
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*Migration for Prurigo*/
/*Concept group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1727,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.obs.concept_id=7042
AND itech.obs.value_boolean=1;




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=1727;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=1727 
GROUP BY openmrs.obs.person_id;




/*migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1728,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7042 AND itech.obs.value_boolean=1 THEN 128319
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7042 
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for YES */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1729,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7042 AND itech.obs.value_boolean=1 THEN 1065
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7042
AND itech.obs.value_boolean=1
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*Migration for Autres, préciser :*/
/*Concept group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1727,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.obs.concept_id=7044
AND itech.obs.value_text<>'';




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=1727;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=1727 
GROUP BY openmrs.obs.person_id;




/*migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,comments,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1728,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7044 AND itech.obs.value_text<>'' AND itech.obs.value_boolean=1 THEN 5622
ELSE NULL
END,itech.obs.value_text,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727 
AND itech.obs.concept_id=7044
AND itech.obs.value_text<>''
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for YES */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1729,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.obs.concept_id=7044 AND itech.obs.value_text<>'' THEN 1065
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs ON itech.encounter.encounter_id=itech.obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.patient ON itech.obs.person_id=itech.patient.person_id
WHERE itech.obs.location_id=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=1727
AND itech.obs.concept_id=7044
AND itech.obs.value_text<>''
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*END OF MIGRATION FOR SYMPTÔMES MENU*/
/*MIGRATION FOR EXAMEN CLINIQUE*/
/* Migration for Général*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1119,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.physicalGeneral=1 THEN 159438
WHEN itech.vitals.physicalGeneral=2 THEN 163293
WHEN itech.vitals.physicalGeneral=4 THEN 1118
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND (itech.vitals.physicalGeneral=1 OR itech.vitals.physicalGeneral=2 OR itech.vitals.physicalGeneral=4);



/*Migration for Peau*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1120,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.physicalSkin=1 THEN 1115
WHEN itech.vitals.physicalSkin=2 THEN 1116
WHEN itech.vitals.physicalSkin=4 THEN 1118
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND (itech.vitals.physicalSkin=1 OR itech.vitals.physicalSkin=2 OR itech.vitals.physicalSkin=4);



/*Migration for Bouche/Orale*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,163308,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.physicalOral=1 THEN 1115
WHEN itech.vitals.physicalOral=2 THEN 1116
WHEN itech.vitals.physicalOral=4 THEN 1118
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND (itech.vitals.physicalOral=1 OR itech.vitals.physicalOral=2 OR itech.vitals.physicalOral=4);



/*Migration for Oreilles*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,163337,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.physicalEarsNose=1 THEN 1115
WHEN itech.vitals.physicalEarsNose=2 THEN 1116
WHEN itech.vitals.physicalEarsNose=4 THEN 1118
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND (itech.vitals.physicalEarsNose=1 OR itech.vitals.physicalEarsNose=2 OR itech.vitals.physicalEarsNose=4);



/*Migration for Yeux*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,163309,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.physicalEyes=1 THEN 1115
WHEN itech.vitals.physicalEyes=2 THEN 1116
WHEN itech.vitals.physicalEyes=4 THEN 1118
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND (itech.vitals.physicalEyes=1 OR itech.vitals.physicalEyes=2 OR itech.vitals.physicalEyes=4);



/*Migration for Ganglions lymphatiques*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1121,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.physicalLymph=1 THEN 1115
WHEN itech.vitals.physicalLymph=2 THEN 1116
WHEN itech.vitals.physicalLymph=4 THEN 1118
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND (itech.vitals.physicalLymph=1 OR itech.vitals.physicalLymph=2 OR itech.vitals.physicalLymph=4);



/*Migration for Poumons*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1123,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.physicalLungs=1 THEN 1115
WHEN itech.vitals.physicalLungs=2 THEN 1116
WHEN itech.vitals.physicalLungs=4 THEN 1118
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND (itech.vitals.physicalLungs=1 OR itech.vitals.physicalLungs=2 OR itech.vitals.physicalLungs=4);



/*Migration for Cardio-vasculaire*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1124,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.physicalCardio=1 THEN 1115
WHEN itech.vitals.physicalCardio=2 THEN 1116
WHEN itech.vitals.physicalCardio=4 THEN 1118
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND (itech.vitals.physicalCardio=1 OR itech.vitals.physicalCardio=2 OR itech.vitals.physicalCardio=4);



/*Migration for Abdomen*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1125,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.physicalAbdomen=1 THEN 1115
WHEN itech.vitals.physicalAbdomen=2 THEN 1116
WHEN itech.vitals.physicalAbdomen=4 THEN 1118
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND (itech.vitals.physicalAbdomen=1 OR itech.vitals.physicalAbdomen=2 OR itech.vitals.physicalAbdomen=4);



/*Migration for Urogénital*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1126,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.physicalUro=1 THEN 1115
WHEN itech.vitals.physicalUro=2 THEN 1116
WHEN itech.vitals.physicalUro=4 THEN 1118
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND (itech.vitals.physicalUro=1 OR itech.vitals.physicalUro=2 OR itech.vitals.physicalUro=4);



/*Migration for Musculo-squeletal*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1128,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.physicalMusculo=1 THEN 1115
WHEN itech.vitals.physicalMusculo=2 THEN 1116
WHEN itech.vitals.physicalMusculo=4 THEN 1118
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND (itech.vitals.physicalMusculo=1 OR itech.vitals.physicalMusculo=2 OR itech.vitals.physicalMusculo=4);



/*Migration for Neurologique*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1129,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.physicalNeuro=1 THEN 1115
WHEN itech.vitals.physicalNeuro=2 THEN 1116
WHEN itech.vitals.physicalNeuro=4 THEN 1118
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND (itech.vitals.physicalNeuro=1 OR itech.vitals.physicalNeuro=2 OR itech.vitals.physicalNeuro=4);



/*Migration for Description des conclusions anormales*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_text,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1391,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.clinicalExam<>'' THEN itech.vitals.clinicalExam
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.clinicalExam<>'';




/*END OF MIGRATION FOR EXAMEN CLINIQUE*/

/*MIGRATION FOR ÉVALUATION TB*/
/*Migration for Présence de cicatrice BCG*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160265,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.tbStatus.presenceBCG=1 THEN 1065
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.tbStatus ON itech.encounter.patientID=itech.tbStatus.patientID
WHERE itech.tbStatus.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.tbStatus.visitDateYy,'-',itech.tbStatus.visitDateMm,'-',itech.tbStatus.visitDateDd)
AND itech.tbStatus.presenceBCG=1;




/*migration for Prophylaxie à I'INH*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1110,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.tbStatus.propINH=1 THEN 1679
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.tbStatus ON itech.encounter.patientID=itech.tbStatus.patientID
WHERE itech.tbStatus.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.tbStatus.visitDateYy,'-',itech.tbStatus.visitDateMm,'-',itech.tbStatus.visitDateDd)
AND itech.tbStatus.propINH=1;




/*Migration for Suspicion de TB selon les symptômes*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1659,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.tbStatus.suspicionTBwSymptoms=1 THEN 142177
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.tbStatus ON itech.encounter.patientID=itech.tbStatus.patientID
WHERE itech.tbStatus.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.tbStatus.visitDateYy,'-',itech.tbStatus.visitDateMm,'-',itech.tbStatus.visitDateDd)
AND itech.tbStatus.suspicionTBwSymptoms=1;



/*Date d'arrêt de I'INH*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,163284,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.tbStatus.arretINHMm<0 AND itech.tbStatus.arretINHYy>0 THEN CONCAT(itech.tbStatus.arretINHYy,'-',01,'-',01)
WHEN itech.tbStatus.arretINHMm>0 AND itech.tbStatus.arretINHYy>0 THEN CONCAT(itech.tbStatus.arretINHYy,'-',itech.tbStatus.arretINHMm,'-',01)
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.tbStatus ON itech.encounter.patientID=itech.tbStatus.patientID
WHERE itech.tbStatus.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.tbStatus.visitDateYy,'-',itech.tbStatus.visitDateMm,'-',itech.tbStatus.visitDateDd)
AND itech.tbStatus.arretINHYy>0;




/*END OF MIGRATION FOR ÉVALUATION TB*/
/*MIGRATION FOR ANTÉCEDENTS MÉDICAUX ET DIAGNOSTICS ACTUELS*/
/*Migration for Lymphadénopathie chronique persistante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,5328,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=435
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Candidose, vulvo-vaginale (non chronique)*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,298,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=406
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Infections récurrentes des voies respiratoires supérieures*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,127794,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=403
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Manifestations cutanéomuqueuses secondaires*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,512,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=402
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);




/*Migration for Ulcere Ulcérations buccales récurrentes (non chronique)*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,111721,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=407
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Zona*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,117543,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=192
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Affections inflammatoires pelviennes*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,902,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=297
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Candidose, buccale (muguet)*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,5334,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=196
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Candidose, vulvo-vaginale chronique (>1 mois)*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,298,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=396
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Infections bactérienne, autre (septicémie incluse)*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,5333,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=408
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Leucoplasie chevelue buccale*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,5337,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=202
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);




/*Migration for Méningites bactériennes*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,121255,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=205 
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for M. tuberculosis(TB) pulmonaire Si actif, complétez la section Tuberculose*/

INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,42,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=409 
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);




/*Migration for Tuberculose multirésistante Si actif, complétez la section Tuberculose*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,159355,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=715 
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Pneumonie bactérienne*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,5030,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=410
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Cancer cervical invasif*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,116023,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=218
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Retinite à CMV*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,5035,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=411
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for CMV viscéral (sauf rétine, ou foie, rate, ganglions lymphatiques)*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,142963,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=230
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Coccidiomycoses (extra pulmonaire)*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,120330,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=233
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Méningites à Cryptococcose (extra pulmonaire)*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,5033,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=257
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Cryptococcocus (extra pulmonaire)*/
/* A verifier avec james
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,5033,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=260
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



*/
/*Migration for Démence liée au VIH*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,1460,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=412
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Salmonella: septicémie (non typhoid)*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,5354,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=433
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Accidents cérébro-vasculaires*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,
CASE WHEN itech.conditions.conditionActive=1 THEN 130864
WHEN itech.conditions.conditionActive=2 THEN 132827
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=428
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);




/*Migration for Anémie*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,
CASE WHEN itech.conditions.conditionActive=1 THEN 1226
WHEN itech.conditions.conditionActive=2 THEN 121629
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=303
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Cancer Anal*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,129079,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=306
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);




/*Migration for Cancer, Autre (Stade IV de l’OMS exclu) préciser*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,116030,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=429
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Coronaropathies*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,119816,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=430
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Diabète*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,
CASE WHEN itech.conditions.conditionActive=1 THEN 142474
WHEN itech.conditions.conditionActive=2 THEN 142473
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=315
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Hépatite B*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,111759,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=320
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Hépatite C*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,
CASE WHEN itech.conditions.conditionActive=1 THEN 149743
WHEN itech.conditions.conditionActive=2 THEN 145347
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=323
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Hyperlipidémie*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,117441,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=326
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Hypertension*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,117339,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=329
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Lipodystrophie*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,135761,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=332
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Malaria, suspecté*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,116128,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=716
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Malaria, confirmé*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,160148,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=335
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*OMS Stade Clinique IV <br/>Diarrhée chronique >1 mois (dûe à):*/
/*Migration for Cause inconnue*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,145443,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=416 
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Cryptosporidiose*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,5034,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=434 
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Isosporose intestinale*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,136458,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=414  
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Oesphagites dûe à candidose*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,139739,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=415   
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Oesphagites avec ulcère (dûe à): 
Cause inconnue
*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,118510,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=416  
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Oesophagites HSV*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,110516,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=417   
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Oesophagites CMV*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,156804,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=418
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Lésions cérébrales focales (dûe à):
*/
/*migration Cause inconnue*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,135886,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=419
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Lymphome primaire CNS*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,5040,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=251
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Toxoplasmose: CNS*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,990,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=287
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Histoplasmoses (extra pulmonaires)*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,5038,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=242
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Ulcère chronique a HSV (>1 mois)*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,141488,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=290 
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Sarcome de Kaposi*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,507,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=420 
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Lymphomes, Hodgkins*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,5041,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=421 
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Lymphomes, non-Hodgkins*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,115195,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=422
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for M. tuberculosis (TB) extrapulmonaire ou disséminée*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,
CASE WHEN itech.conditions.conditionActive=1 THEN 118890
WHEN itech.conditions.conditionActive=2 THEN 5042
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=423
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Si actif, complétez la section Tuberculose*/
/*Migration for  Mycobacteriose, autre (incl. avium complex)*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,
CASE WHEN itech.conditions.conditionActive=1 THEN 5043
WHEN itech.conditions.conditionActive=2 THEN 5044
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=424
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Pneumonie non bactérienne (dûe à):*/
/*Migration for Cause inconnue*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,
CASE WHEN itech.conditions.conditionActive=1 THEN 114100
WHEN itech.conditions.conditionActive=2 THEN 123742
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=425
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Candidose*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,5340,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=426
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Infections virales (incl. HSV,CMV)*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,123098,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=427
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for  PCP*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,882,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=272
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);




/*Migration for Leuco-encéphalopathie multifocale progressive*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,5046,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=248
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);




/*Migration Malaria, grave*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,160155,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=717
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Neuropathie périphérique*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,118983,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=344
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Syphilis*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,112493,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=350
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Thrombopénie idiopathique*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,117295,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=353 
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Anxiété/Dépression*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,119537,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=431 
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);




/*Migration for Psychoses*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,113517,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=383 
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Migration for Trouble affectif bipolaire*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,121131,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=386 
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Usage de substances toxiques*/
/*Alcool*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,159449,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=368 
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*Cocaïne*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,
CASE WHEN itech.conditions.conditionActive=1 THEN 6042
WHEN itech.conditions.conditionActive=2 THEN 6097
END,itech.encounter_vitals_obs.id,
CASE WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm<1 
THEN CONCAT(itech.conditions.conditionYy,'-',01,'-',01)
WHEN (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2) AND itech.conditions.conditionYy>0 AND itech.conditions.conditionMm>0
THEN CONCAT(itech.conditions.conditionYy,'-',itech.conditions.conditionMm,'-',01)
ELSE
itech.encounter.visitDate
END,itech.encounter.siteCode,73650,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.conditions ON itech.encounter.patientID=itech.conditions.patientID
WHERE itech.conditions.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.conditions.visitDateYy,'-',itech.conditions.visitDateMm,'-',itech.conditions.visitDateDd)
AND itech.conditions.conditionID=371 
AND (itech.conditions.conditionActive=1 OR itech.conditions.conditionActive=2);



/*END OF MIGRATION FOR ANTÉCEDENTS MÉDICAUX ET DIAGNOSTICS ACTUELS*/
/*Migration for Est-ce que le patient a déjà utilisé des ARV ?*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160117,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.arvEnrollment.arvEver=1 THEN 160119
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.arvEnrollment ON itech.encounter.patientID=itech.arvEnrollment.patientID
WHERE itech.arvEnrollment.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.arvEnrollment.visitDateYy,'-',itech.arvEnrollment.visitDateMm,'-',itech.arvEnrollment.visitDateDd)
AND itech.arvEnrollment.arvEver=1;



/*(-) INTIs*/
/*Migration for Abacavir (ABC)*/
/*Concept group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160741,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.drugs.drugID=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd);




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=160741;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=160741 
GROUP BY openmrs.obs.person_id;




/*migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1282,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),70056,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*==================================================*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160742,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),138405,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 

/*Migration for Début MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1190,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.startMm<1 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',01,'-',01)
WHEN itech.drugs.startMm>0 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',itech.drugs.startMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=1
AND itech.drugs.startYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Arrêt MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1191,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.stopMm<1 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',01,'-',01)
WHEN itech.drugs.stopMm>0 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',itech.drugs.stopMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=1
AND itech.drugs.stopYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Utilisation courante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159367,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1065,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=1
AND itech.drugs.isContinued=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Arrêt : raison*/
/*Migration for Tox*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),102,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=1
AND itech.drugs.toxicity=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Intol*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),987,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=1
AND itech.drugs.intolerance=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Ech*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),843,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=1
AND itech.drugs.failure=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Inconnu*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1067,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=1
AND itech.drugs.discUnknown=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Fin PTME*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1253,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=1
AND itech.drugs.finPTME=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*Migration for Combivir (AZT+3TC)*/
/*Concept group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160741,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.drugs ON itech.encounter.patientID=itech.drugs.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.drugs.drugID=8
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd);




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=160741;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=160741 
GROUP BY openmrs.obs.person_id;




/*migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1282,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),630,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=8
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*==================================================*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160742,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),138405,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=8
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 

/*Migration for Début MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1190,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.startMm<1 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',01,'-',01)
WHEN itech.drugs.startMm>0 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',itech.drugs.startMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=8
AND itech.drugs.startYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Arrêt MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1191,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.stopMm<1 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',01,'-',01)
WHEN itech.drugs.stopMm>0 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',itech.drugs.stopMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=8
AND itech.drugs.stopYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Utilisation courante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159367,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1065,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=8
AND itech.drugs.isContinued=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Arrêt : raison*/
/*Migration for Tox*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),102,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=8
AND itech.drugs.toxicity=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Intol*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),987,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=8
AND itech.drugs.intolerance=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Ech*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),843,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=8
AND itech.drugs.failure=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Inconnu*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1067,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=8
AND itech.drugs.discUnknown=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Fin PTME*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1253,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=8
AND itech.drugs.finPTME=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;




/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*Migration for Didanosine (ddI) */
/*Concept group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160741,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.drugs ON itech.encounter.patientID=itech.drugs.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.drugs.drugID=10
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd);




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=160741;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=160741 
GROUP BY openmrs.obs.person_id;




/*migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1282,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),74807,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=10
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*==================================================*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160742,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),138405,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=10
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 

/*Migration for Début MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1190,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.startMm<1 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',01,'-',01)
WHEN itech.drugs.startMm>0 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',itech.drugs.startMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=10
AND itech.drugs.startYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Arrêt MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1191,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.stopMm<1 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',01,'-',01)
WHEN itech.drugs.stopMm>0 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',itech.drugs.stopMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=10
AND itech.drugs.stopYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Utilisation courante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159367,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1065,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=10
AND itech.drugs.isContinued=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Arrêt : raison*/
/*Migration for Tox*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),102,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=10
AND itech.drugs.toxicity=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Intol*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),987,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=10
AND itech.drugs.intolerance=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Ech*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),843,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=10
AND itech.drugs.failure=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Inconnu*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1067,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=10
AND itech.drugs.discUnknown=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Fin PTME*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1253,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=10
AND itech.drugs.finPTME=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*======================================================================================================================*/
/*Migration for Emtricitabine (FTC)*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160741,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.drugs ON itech.encounter.patientID=itech.drugs.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.drugs.drugID=12
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd);




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=160741;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=160741 
GROUP BY openmrs.obs.person_id;




/*migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1282,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),75628,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=12
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*==================================================*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160742,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),138405,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=12
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 

/*Migration for Début MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1190,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.startMm<1 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',01,'-',01)
WHEN itech.drugs.startMm>0 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',itech.drugs.startMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=12
AND itech.drugs.startYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Arrêt MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1191,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.stopMm<1 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',01,'-',01)
WHEN itech.drugs.stopMm>0 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',itech.drugs.stopMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=12
AND itech.drugs.stopYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Utilisation courante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159367,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1065,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=12
AND itech.drugs.isContinued=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Arrêt : raison*/
/*Migration for Tox*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),102,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=12
AND itech.drugs.toxicity=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Intol*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),987,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=12
AND itech.drugs.intolerance=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Ech*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),843,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=12
AND itech.drugs.failure=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Inconnu*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1067,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=12
AND itech.drugs.discUnknown=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Fin PTME*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1253,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=12
AND itech.drugs.finPTME=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;




/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/	
/*Migration for Lamivudine (3TC)*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160741,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.drugs ON itech.encounter.patientID=itech.drugs.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.drugs.drugID=20
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd);




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=160741;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=160741 
GROUP BY openmrs.obs.person_id;



/*migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1282,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),78643,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=20
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*==================================================*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160742,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),138405,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=20
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 

/*Migration for Début MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1190,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.startMm<1 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',01,'-',01)
WHEN itech.drugs.startMm>0 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',itech.drugs.startMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=20
AND itech.drugs.startYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Arrêt MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1191,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.stopMm<1 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',01,'-',01)
WHEN itech.drugs.stopMm>0 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',itech.drugs.stopMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=20
AND itech.drugs.stopYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Utilisation courante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159367,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1065,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=20
AND itech.drugs.isContinued=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Arrêt : raison*/
/*Migration for Tox*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),102,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=20
AND itech.drugs.toxicity=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Intol*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),987,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=20
AND itech.drugs.intolerance=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Ech*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),843,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=20
AND itech.drugs.failure=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Inconnu*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1067,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=20
AND itech.drugs.discUnknown=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Fin PTME*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1253,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=20
AND itech.drugs.finPTME=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;




/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*Migration for Stavudine (d4T)*/
/*Migration for the group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160741,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.drugs ON itech.encounter.patientID=itech.drugs.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.drugs.drugID=29
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd);




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=160741;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=160741 
GROUP BY openmrs.obs.person_id;



/*Migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1282,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),84309,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=29
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*==================================================*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160742,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),138405,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=29
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 

/*Migration for Début MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1190,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.startMm<1 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',01,'-',01)
WHEN itech.drugs.startMm>0 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',itech.drugs.startMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=29
AND itech.drugs.startYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Arrêt MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1191,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.stopMm<1 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',01,'-',01)
WHEN itech.drugs.stopMm>0 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',itech.drugs.stopMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=29
AND itech.drugs.stopYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Utilisation courante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159367,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1065,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=29
AND itech.drugs.isContinued=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Arrêt : raison*/
/*Migration for Tox*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),102,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=29
AND itech.drugs.toxicity=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Intol*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),987,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=29
AND itech.drugs.intolerance=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Ech*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),843,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=29
AND itech.drugs.failure=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Inconnu*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1067,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=29
AND itech.drugs.discUnknown=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Fin PTME*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1253,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=29
AND itech.drugs.finPTME=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;





/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*Migration for Tenofovir (TNF)*/
/*Migration for the group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160741,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.drugs ON itech.encounter.patientID=itech.drugs.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.drugs.drugID=31
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd);




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=160741;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=160741 
GROUP BY openmrs.obs.person_id;




/*migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1282,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),84795,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=31
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*==================================================*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160742,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),138405,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=31
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 

/*Migration for Début MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1190,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.startMm<1 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',01,'-',01)
WHEN itech.drugs.startMm>0 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',itech.drugs.startMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=31
AND itech.drugs.startYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Arrêt MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1191,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.stopMm<1 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',01,'-',01)
WHEN itech.drugs.stopMm>0 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',itech.drugs.stopMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=31
AND itech.drugs.stopYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Utilisation courante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159367,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1065,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=31
AND itech.drugs.isContinued=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Arrêt : raison*/
/*Migration for Tox*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),102,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=31
AND itech.drugs.toxicity=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Intol*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),987,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=31
AND itech.drugs.intolerance=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Ech*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),843,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=31
AND itech.drugs.failure=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Inconnu*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1067,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=31
AND itech.drugs.discUnknown=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Fin PTME*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1253,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=31
AND itech.drugs.finPTME=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;




/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*Migration for Trizivir (ABC+AZT+3TC)*/
/*Migration for the group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160741,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.drugs ON itech.encounter.patientID=itech.drugs.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.drugs.drugID=33
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd);




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=160741;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=160741 
GROUP BY openmrs.obs.person_id;




/*====================================================================================*/
/*Migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1282,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),817,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=33
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*==================================================*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160742,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),138405,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=33
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 

/*Migration for Début MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1190,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.startMm<1 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',01,'-',01)
WHEN itech.drugs.startMm>0 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',itech.drugs.startMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=33
AND itech.drugs.startYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Arrêt MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1191,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.stopMm<1 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',01,'-',01)
WHEN itech.drugs.stopMm>0 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',itech.drugs.stopMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=33
AND itech.drugs.stopYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Utilisation courante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159367,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1065,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=33
AND itech.drugs.isContinued=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Arrêt : raison*/
/*Migration for Tox*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),102,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=33
AND itech.drugs.toxicity=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Intol*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),987,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=33
AND itech.drugs.intolerance=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Ech*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),843,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=33
AND itech.drugs.failure=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Inconnu*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1067,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=33
AND itech.drugs.discUnknown=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Fin PTME*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1253,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=33
AND itech.drugs.finPTME=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*Migration for Zidovudine (AZT)*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160741,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.drugs ON itech.encounter.patientID=itech.drugs.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.drugs.drugID=34
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd);




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=160741;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=160741 
GROUP BY openmrs.obs.person_id;




/*Migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1282,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),86663,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=34
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*==================================================*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160742,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),138405,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=34
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 

/*Migration for Début MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1190,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.startMm<1 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',01,'-',01)
WHEN itech.drugs.startMm>0 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',itech.drugs.startMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=34
AND itech.drugs.startYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Arrêt MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1191,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.stopMm<1 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',01,'-',01)
WHEN itech.drugs.stopMm>0 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',itech.drugs.stopMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=34
AND itech.drugs.stopYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Utilisation courante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159367,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1065,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=34
AND itech.drugs.isContinued=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Arrêt : raison*/
/*Migration for Tox*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),102,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=34
AND itech.drugs.toxicity=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Intol*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),987,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=34
AND itech.drugs.intolerance=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Ech*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),843,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=34
AND itech.drugs.failure=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Inconnu*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1067,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=34
AND itech.drugs.discUnknown=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Fin PTME*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1253,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=34
AND itech.drugs.finPTME=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;




/*Migration for Efavirenz (EFV)*/
/*Migration for the group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160741,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.drugs ON itech.encounter.patientID=itech.drugs.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.drugs.drugID=11
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd);




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=160741;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=160741 
GROUP BY openmrs.obs.person_id;




/*Migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1282,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),75523,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=11
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*==================================================*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160742,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),138405,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=11
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 

/*Migration for Début MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1190,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.startMm<1 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',01,'-',01)
WHEN itech.drugs.startMm>0 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',itech.drugs.startMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=11
AND itech.drugs.startYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Arrêt MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1191,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.stopMm<1 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',01,'-',01)
WHEN itech.drugs.stopMm>0 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',itech.drugs.stopMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=11
AND itech.drugs.stopYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Utilisation courante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159367,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1065,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=11
AND itech.drugs.isContinued=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Arrêt : raison*/
/*Migration for Tox*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),102,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=11
AND itech.drugs.toxicity=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Intol*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),987,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=11
AND itech.drugs.intolerance=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Ech*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),843,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=11
AND itech.drugs.failure=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Inconnu*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1067,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=11
AND itech.drugs.discUnknown=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Fin PTME*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1253,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=11
AND itech.drugs.finPTME=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*=========================================================================================================================*/
/*Migration for Nevirapine (NVP)*/
/*Migration for the group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160741,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.drugs ON itech.encounter.patientID=itech.drugs.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.drugs.drugID=23
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd);




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=160741;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=160741 
GROUP BY openmrs.obs.person_id;




/*Migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1282,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),80586,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=23
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*==================================================*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160742,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),138405,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=23
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 

/*Migration for Début MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1190,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.startMm<1 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',01,'-',01)
WHEN itech.drugs.startMm>0 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',itech.drugs.startMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=23
AND itech.drugs.startYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Arrêt MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1191,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.stopMm<1 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',01,'-',01)
WHEN itech.drugs.stopMm>0 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',itech.drugs.stopMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=23
AND itech.drugs.stopYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Utilisation courante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159367,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1065,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=23
AND itech.drugs.isContinued=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Arrêt : raison*/
/*Migration for Tox*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),102,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=23
AND itech.drugs.toxicity=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Intol*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),987,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=23
AND itech.drugs.intolerance=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Ech*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),843,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=23
AND itech.drugs.failure=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Inconnu*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1067,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=23
AND itech.drugs.discUnknown=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Fin PTME*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1253,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=23
AND itech.drugs.finPTME=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Atazanavir (ATZN)*/
/*Migration for the group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160741,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.drugs ON itech.encounter.patientID=itech.drugs.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.drugs.drugID=5
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd);




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=160741;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=160741 
GROUP BY openmrs.obs.person_id;




/*Migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1282,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),71647,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=5
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*==================================================*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160742,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),138405,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=5
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 

/*Migration for Début MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1190,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.startMm<1 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',01,'-',01)
WHEN itech.drugs.startMm>0 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',itech.drugs.startMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=5
AND itech.drugs.startYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Arrêt MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1191,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.stopMm<1 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',01,'-',01)
WHEN itech.drugs.stopMm>0 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',itech.drugs.stopMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=5
AND itech.drugs.stopYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Utilisation courante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159367,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1065,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=5
AND itech.drugs.isContinued=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Arrêt : raison*/
/*Migration for Tox*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),102,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=5
AND itech.drugs.toxicity=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Intol*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),987,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=5
AND itech.drugs.intolerance=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Ech*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),843,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=5
AND itech.drugs.failure=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Inconnu*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1067,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=5
AND itech.drugs.discUnknown=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Fin PTME*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1253,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=5
AND itech.drugs.finPTME=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*+++++++++++++++++++++++++++++++++++++++++++++++*/
/*Migration for Atazanavir+BostRTV*/
/*Migration for the group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160741,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.drugs ON itech.encounter.patientID=itech.drugs.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.drugs.drugID=6
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd);




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=160741;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=160741 
GROUP BY openmrs.obs.person_id;




/*Migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1282,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),159809,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=6
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*==================================================*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160742,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),138405,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=6
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 

/*Migration for Début MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1190,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.startMm<1 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',01,'-',01)
WHEN itech.drugs.startMm>0 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',itech.drugs.startMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=6
AND itech.drugs.startYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Arrêt MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1191,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.stopMm<1 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',01,'-',01)
WHEN itech.drugs.stopMm>0 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',itech.drugs.stopMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=6
AND itech.drugs.stopYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Utilisation courante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159367,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1065,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=6
AND itech.drugs.isContinued=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Arrêt : raison*/
/*Migration for Tox*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),102,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=6
AND itech.drugs.toxicity=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Intol*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),987,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=6
AND itech.drugs.intolerance=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Ech*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),843,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=6
AND itech.drugs.failure=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Inconnu*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1067,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=6
AND itech.drugs.discUnknown=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Fin PTME*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1253,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=6
AND itech.drugs.finPTME=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*--------------------------------------------------------------------------------------------------------*/
/*Migration for Indinavir (IDV)*/
/*Migration for the group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160741,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.drugs ON itech.encounter.patientID=itech.drugs.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.drugs.drugID=16
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd);




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=160741;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=160741 
GROUP BY openmrs.obs.person_id;




/*Migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1282,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),77995,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=16
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*==================================================*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160742,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),138405,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=16
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 

/*Migration for Début MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1190,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.startMm<1 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',01,'-',01)
WHEN itech.drugs.startMm>0 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',itech.drugs.startMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=16
AND itech.drugs.startYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Arrêt MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1191,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.stopMm<1 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',01,'-',01)
WHEN itech.drugs.stopMm>0 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',itech.drugs.stopMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=16
AND itech.drugs.stopYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Utilisation courante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159367,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1065,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=16
AND itech.drugs.isContinued=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Arrêt : raison*/
/*Migration for Tox*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),102,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=16
AND itech.drugs.toxicity=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Intol*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),987,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=16
AND itech.drugs.intolerance=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Ech*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),843,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=16
AND itech.drugs.failure=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Inconnu*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1067,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=16
AND itech.drugs.discUnknown=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Fin PTME*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1253,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=16
AND itech.drugs.finPTME=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*---------------------------------------------------------------------------------------------------------------------------*/
/*Migration for Lopinavir+BostRTV (Kaletra)*/
/*Migration for the group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160741,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.drugs ON itech.encounter.patientID=itech.drugs.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.drugs.drugID=21
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd);




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=160741;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=160741 
GROUP BY openmrs.obs.person_id;




/*Migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1282,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),794,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=21
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*==================================================*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160742,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),138405,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=21
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 

/*Migration for Début MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1190,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.startMm<1 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',01,'-',01)
WHEN itech.drugs.startMm>0 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',itech.drugs.startMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=21
AND itech.drugs.startYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Arrêt MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1191,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.stopMm<1 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',01,'-',01)
WHEN itech.drugs.stopMm>0 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',itech.drugs.stopMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=21
AND itech.drugs.stopYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Utilisation courante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159367,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1065,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=21
AND itech.drugs.isContinued=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Arrêt : raison*/
/*Migration for Tox*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),102,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=21
AND itech.drugs.toxicity=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Intol*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),987,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=21
AND itech.drugs.intolerance=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Ech*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),843,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=21
AND itech.drugs.failure=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Inconnu*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1067,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=21
AND itech.drugs.discUnknown=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Fin PTME*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,6098,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1253,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=21
AND itech.drugs.finPTME=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;




/*Autre a Verifier +++++++++++++++++++++++==========================++++++++++++++++++++++++++++++++++==*/
/*END OF MIGRATION FOR ARV : TRAITEMENTS PRÉCÉDENTS MENU*/
/*MIGRATION FOR REMARQUES MENU*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_text,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,163322,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.drugComments<>'' THEN itech.vitals.drugComments
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.drugComments<>'';



/*END OF MIGRATION FOR REMARQUES MENU*/
/*MIGRATION FOR ARV ET GROSSESSE (SEXE F) MENU*/
/*Migration for Est-ce que la patiente a pris un médicament ARV exclusivement afin de prévenir la transmission mère-enfant ?*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,966,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.arvAndPregnancy.ARVexcl=1 THEN 1107
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.arvAndPregnancy ON itech.encounter.patientID=itech.arvAndPregnancy.patientID
WHERE itech.arvAndPregnancy.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.arvAndPregnancy.visitDateYy,'-',itech.arvAndPregnancy.visitDateMm,'-',itech.arvAndPregnancy.visitDateDd)
AND itech.arvAndPregnancy.ARVexcl=1;



/*Migration for Zidovudine,Nevirapine (NVP),Inconnu,Autre :*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,comments,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,966,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.arvAndPregnancy.zidovudineARVpreg=1 THEN 86663
WHEN itech.arvAndPregnancy.nevirapineARVpreg=1 THEN 80586
WHEN itech.arvAndPregnancy.unknownARVpreg=1 THEN 1067
WHEN itech.arvAndPregnancy.otherARVpreg=1 THEN 5424
END,
CASE WHEN itech.arvAndPregnancy.otherARVpreg=1 AND itech.arvAndPregnancy.otherTextARVpreg<>'' THEN itech.arvAndPregnancy.otherTextARVpreg
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.arvAndPregnancy ON itech.encounter.patientID=itech.arvAndPregnancy.patientID
WHERE itech.arvAndPregnancy.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.arvAndPregnancy.visitDateYy,'-',itech.arvAndPregnancy.visitDateMm,'-',itech.arvAndPregnancy.visitDateDd)
AND (itech.arvAndPregnancy.zidovudineARVpreg=1 OR itech.arvAndPregnancy.nevirapineARVpreg=1 
OR itech.arvAndPregnancy.unknownARVpreg=1 OR itech.arvAndPregnancy.otherARVpreg=1);



/*END OF ARV ET GROSSESSE (SEXE F) MENU*/

/*MIGRATION FOR AUTRES TRAITEMENTS PRÉCÉDENTS MENU */
/*Migration for Ethambutol*/
/*Migration for the group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160741,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.drugs ON itech.encounter.patientID=itech.drugs.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.drugs.drugID=13
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd);




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=160741;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=160741 
GROUP BY openmrs.obs.person_id;




/*Migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1282,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),75948,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=13
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*==================================================*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160742,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),138405,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=13
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 

/*Migration for Début MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1190,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.startMm<1 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',01,'-',01)
WHEN itech.drugs.startMm>0 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',itech.drugs.startMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=13
AND itech.drugs.startYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Arrêt MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1191,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.stopMm<1 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',01,'-',01)
WHEN itech.drugs.stopMm>0 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',itech.drugs.stopMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=13
AND itech.drugs.stopYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Utilisation courante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159367,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1065,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=13
AND itech.drugs.isContinued=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;




/*Migration for Isoniazide (INH)*/
/*Migration for the group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160741,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.drugs ON itech.encounter.patientID=itech.drugs.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.drugs.drugID=18
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd);




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=160741;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=160741 
GROUP BY openmrs.obs.person_id;




/*Migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1282,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),78280,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=18
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*==================================================*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160742,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),138405,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=18
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 

/*Migration for Début MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1190,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.startMm<1 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',01,'-',01)
WHEN itech.drugs.startMm>0 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',itech.drugs.startMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=18
AND itech.drugs.startYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Arrêt MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1191,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.stopMm<1 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',01,'-',01)
WHEN itech.drugs.stopMm>0 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',itech.drugs.stopMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=18
AND itech.drugs.stopYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Utilisation courante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159367,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1065,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=18
AND itech.drugs.isContinued=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Pyrazinamide*/
/*Migration for the group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160741,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.drugs ON itech.encounter.patientID=itech.drugs.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.drugs.drugID=24
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd);




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=160741;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=160741 
GROUP BY openmrs.obs.person_id;




/*Migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1282,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),82900,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=24
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*==================================================*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160742,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),138405,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=24
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 

/*Migration for Début MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1190,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.startMm<1 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',01,'-',01)
WHEN itech.drugs.startMm>0 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',itech.drugs.startMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=24
AND itech.drugs.startYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Arrêt MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1191,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.stopMm<1 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',01,'-',01)
WHEN itech.drugs.stopMm>0 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',itech.drugs.stopMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=24
AND itech.drugs.stopYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Utilisation courante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159367,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1065,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=24
AND itech.drugs.isContinued=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Rifampicine*/
/*Migration for Streptomycine*/
/*Migration for Acyclovir*/
/*Migration for the group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160741,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.drugs ON itech.encounter.patientID=itech.drugs.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.drugs.drugID=2
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd);




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=160741;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=160741 
GROUP BY openmrs.obs.person_id;




/*Migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1282,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),70245,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=2
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*==================================================*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160742,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),138405,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=2
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 

/*Migration for Début MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1190,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.startMm<1 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',01,'-',01)
WHEN itech.drugs.startMm>0 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',itech.drugs.startMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=2
AND itech.drugs.startYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Arrêt MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1191,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.stopMm<1 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',01,'-',01)
WHEN itech.drugs.stopMm>0 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',itech.drugs.stopMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=2
AND itech.drugs.stopYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Utilisation courante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159367,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1065,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=2
AND itech.drugs.isContinued=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Cotrimoxazole (TMS)*/
/*Migration for the group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160741,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.drugs ON itech.encounter.patientID=itech.drugs.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.drugs.drugID=9
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd);




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=160741;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=160741 
GROUP BY openmrs.obs.person_id;




/*Migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1282,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),105281,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=9
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*==================================================*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160742,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),138405,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=9
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 

/*Migration for Début MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1190,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.startMm<1 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',01,'-',01)
WHEN itech.drugs.startMm>0 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',itech.drugs.startMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=9
AND itech.drugs.startYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Arrêt MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1191,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.stopMm<1 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',01,'-',01)
WHEN itech.drugs.stopMm>0 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',itech.drugs.stopMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=9
AND itech.drugs.stopYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Utilisation courante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159367,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1065,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=9
AND itech.drugs.isContinued=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Fluconazole*/
/*Migration for the group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160741,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.drugs ON itech.encounter.patientID=itech.drugs.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.drugs.drugID=14
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd);




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=160741;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=160741 
GROUP BY openmrs.obs.person_id;




/*Migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1282,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),76488,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=14
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*==================================================*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160742,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),138405,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=14
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 

/*Migration for Début MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1190,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.startMm<1 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',01,'-',01)
WHEN itech.drugs.startMm>0 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',itech.drugs.startMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=14
AND itech.drugs.startYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Arrêt MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1191,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.stopMm<1 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',01,'-',01)
WHEN itech.drugs.stopMm>0 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',itech.drugs.stopMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=14
AND itech.drugs.stopYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Utilisation courante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159367,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1065,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=14
AND itech.drugs.isContinued=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Ketaconazole*/
/*Migration for the group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160741,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.drugs ON itech.encounter.patientID=itech.drugs.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.drugs.drugID=19
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd);




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=160741;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=160741 
GROUP BY openmrs.obs.person_id;




/*Migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1282,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),78476,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=19
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*==================================================*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160742,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),138405,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=19
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 

/*Migration for Début MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1190,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.startMm<1 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',01,'-',01)
WHEN itech.drugs.startMm>0 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',itech.drugs.startMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=19
AND itech.drugs.startYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Arrêt MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1191,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.stopMm<1 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',01,'-',01)
WHEN itech.drugs.stopMm>0 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',itech.drugs.stopMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=19
AND itech.drugs.stopYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Utilisation courante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159367,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1065,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=19
AND itech.drugs.isContinued=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Traitement traditionnelle*/
/*Migration for the group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160741,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.drugs ON itech.encounter.patientID=itech.drugs.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.drugs.drugID=35
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd);




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=160741;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=160741 
GROUP BY openmrs.obs.person_id;




/*Migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1282,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),5841,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=35
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*==================================================*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160742,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),138405,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=35
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 

/*Migration for Début MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1190,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.startMm<1 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',01,'-',01)
WHEN itech.drugs.startMm>0 AND itech.drugs.startYy>0 THEN CONCAT(itech.drugs.startYy,'-',itech.drugs.startMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=35
AND itech.drugs.startYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Arrêt MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1191,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.drugs.stopMm<1 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',01,'-',01)
WHEN itech.drugs.stopMm>0 AND itech.drugs.stopYy>0 THEN CONCAT(itech.drugs.stopYy,'-',itech.drugs.stopMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=35
AND itech.drugs.stopYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Utilisation courante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159367,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1065,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.drugs ON itech.drugs.patientID=itech.encounter.patientID
WHERE itech.drugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.drugs.drugID=35
AND itech.drugs.isContinued=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.drugs.visitDateYy,'-',itech.drugs.visitDateMm,'-',itech.drugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;



/*Migration for Autres, préciser :*/
/*Migration for the group*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160741,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.otherDrugs ON itech.encounter.patientID=itech.otherDrugs.patientID
WHERE itech.otherDrugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.otherDrugs.drugName<>''
AND DATE(itech.encounter.visitDate)=CONCAT(itech.otherDrugs.visitDateYy,'-',itech.otherDrugs.visitDateMm,'-',itech.otherDrugs.visitDateDd);




DELETE FROM itech.obs_concept_group WHERE itech.obs_concept_group.concept_id=160741;



INSERT INTO itech.obs_concept_group (obs_id,person_id,concept_id,encounter_id,location_id,obs_datetime)
SELECT MAX(openmrs.obs.obs_id),openmrs.obs.person_id,openmrs.obs.concept_id,openmrs.obs.encounter_id,openmrs.obs.location_id,openmrs.obs.obs_datetime
FROM openmrs.obs
WHERE openmrs.obs.concept_id=160741 
GROUP BY openmrs.obs.person_id;




/*--------------------------------------------------*/

/*Migration for the concept*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1282,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),5622,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.otherDrugs ON itech.encounter.patientID=itech.otherDrugs.patientID
WHERE itech.otherDrugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.otherDrugs.drugName<>''
AND DATE(itech.encounter.visitDate)=CONCAT(itech.otherDrugs.visitDateYy,'-',itech.otherDrugs.visitDateMm,'-',itech.otherDrugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*==================================================*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,160742,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),138405,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.otherDrugs ON itech.encounter.patientID=itech.otherDrugs.patientID
WHERE itech.otherDrugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.otherDrugs.drugName<>''
AND DATE(itech.encounter.visitDate)=CONCAT(itech.otherDrugs.visitDateYy,'-',itech.otherDrugs.visitDateMm,'-',itech.otherDrugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 

/*Migration for Début MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1190,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.otherDrugs.startMm<1 AND itech.otherDrugs.startYy>0 THEN CONCAT(itech.otherDrugs.startYy,'-',01,'-',01)
WHEN itech.otherDrugs.startMm>0 AND itech.otherDrugs.startYy>0 THEN CONCAT(itech.otherDrugs.startYy,'-',itech.otherDrugs.startMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.otherDrugs ON itech.encounter.patientID=itech.otherDrugs.patientID
WHERE itech.otherDrugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.otherDrugs.drugName<>''
AND itech.otherDrugs.startYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.otherDrugs.visitDateYy,'-',itech.otherDrugs.visitDateMm,'-',itech.otherDrugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Arrêt MM/AA*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_datetime,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,1191,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),
CASE WHEN itech.otherDrugs.stopMm<1 AND itech.otherDrugs.stopYy>0 THEN CONCAT(itech.otherDrugs.stopYy,'-',01,'-',01)
WHEN itech.otherDrugs.stopMm>0 AND itech.otherDrugs.stopYy>0 THEN CONCAT(itech.otherDrugs.stopYy,'-',itech.otherDrugs.stopMm,'-',01)
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.otherDrugs ON itech.encounter.patientID=itech.otherDrugs.patientID
WHERE itech.otherDrugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.otherDrugs.drugName<>''
AND itech.otherDrugs.stopYy>0
AND DATE(itech.encounter.visitDate)=CONCAT(itech.otherDrugs.visitDateYy,'-',itech.otherDrugs.visitDateMm,'-',itech.otherDrugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;


 
/*Migration for Utilisation courante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,obs_group_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159367,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,MAX(itech.obs_concept_group.obs_id),1065,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.obs_concept_group ON itech.patient_id_itech.id_patient_openmrs=itech.obs_concept_group.person_id
INNER JOIN itech.otherDrugs ON itech.encounter.patientID=itech.otherDrugs.patientID
WHERE itech.otherDrugs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND itech.encounter_vitals_obs.id=itech.obs_concept_group.encounter_id
AND itech.encounter.siteCode=itech.obs_concept_group.location_id
AND itech.obs_concept_group.concept_id=160741 
AND itech.otherDrugs.drugName<>''
AND itech.otherDrugs.isContinued=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.otherDrugs.visitDateYy,'-',itech.otherDrugs.visitDateMm,'-',itech.otherDrugs.visitDateDd)
GROUP BY itech.patient_id_itech.id_patient_openmrs;




/*Migration for Commentaire*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_text,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,163323,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.vitals.treatmentComments<>'' THEN itech.vitals.treatmentComments
ELSE NULL
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID
WHERE itech.vitals.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd)
AND itech.vitals.treatmentComments<>'';



/*END OF AUTRES TRAITEMENTS PRÉCÉDENTS MENU*/
/*MIGRATION FOR ÉLIGIBILITÉ MÉDICALE AUX ARV MENU*/
/*Stade OMS actuel*/
/*Migration for Stade I (Asymptomatique) AND Stade II (Symptomatique) AND Stade III (Symptomatique) AND Stade IV (SIDA)*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,5356,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.medicalEligARVs.currentHivStage=1 THEN 1204
WHEN itech.medicalEligARVs.currentHivStage=2 THEN 1205
WHEN itech.medicalEligARVs.currentHivStage=4 THEN 1206
WHEN itech.medicalEligARVs.currentHivStage=8 THEN 1207
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.medicalEligARVs ON itech.encounter.patientID=itech.medicalEligARVs.patientID
WHERE itech.medicalEligARVs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.medicalEligARVs.visitDateYy,'-',itech.medicalEligARVs.visitDateMm,'-',itech.medicalEligARVs.visitDateDd)
AND (itech.medicalEligARVs.currentHivStage=1 OR itech.medicalEligARVs.currentHivStage=2 
OR itech.medicalEligARVs.currentHivStage=4 OR itech.medicalEligARVs.currentHivStage=8);



/*Migration for Éligibilité médicale aux ARV*/
/*Migration for Oui - préciser la raison AND Non - pas d'éligibilité médicale aujourd'hui AND À déterminer*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,162703,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.medicalEligARVs.medElig=1 THEN 1065
WHEN itech.medicalEligARVs.medElig=4 THEN 1066
WHEN itech.medicalEligARVs.medElig=8 THEN 1067
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.medicalEligARVs ON itech.encounter.patientID=itech.medicalEligARVs.patientID
WHERE itech.medicalEligARVs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.medicalEligARVs.visitDateYy,'-',itech.medicalEligARVs.visitDateMm,'-',itech.medicalEligARVs.visitDateDd)
AND (itech.medicalEligARVs.medElig=1 OR itech.medicalEligARVs.medElig=4 OR itech.medicalEligARVs.medElig=8);



/*Raison d'éligibilité médicale aux ARV*/
/*Migration for CD4 inférieur au seuil (500) */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid)
SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,162225,itech.encounter_vitals_obs.id,
itech.encounter.visitDate,itech.encounter.siteCode,
CASE WHEN itech.medicalEligARVs.medElig=1 AND itech.medicalEligARVs.cd4LT200=1 THEN 5497
END,1,itech.encounter.createDate,UUID()
FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante
INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id
INNER JOIN itech.medicalEligARVs ON itech.encounter.patientID=itech.medicalEligARVs.patientID
WHERE itech.medicalEligARVs.siteCode=itech.encounter.siteCode
AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id
AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode
AND itech.encounter.encounterType=1
AND DATE(itech.encounter.visitDate)=CONCAT(itech.medicalEligARVs.visitDateYy,'-',itech.medicalEligARVs.visitDateMm,'-',itech.medicalEligARVs.visitDateDd)
AND itech.medicalEligARVs.medElig=1
AND itech.medicalEligARVs.cd4LT200=1;



/*Migration for TLC<1200 Waiting for new concept*/
/*Migration for OMS Stade III+CD4 inférieur au seuil(500)*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid) SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,162225,itech.encounter_vitals_obs.id, itech.encounter.visitDate,itech.encounter.siteCode, CASE WHEN itech.medicalEligARVs.medElig=1 AND itech.medicalEligARVs.WHOIII=1 THEN 163326 END,1,itech.encounter.createDate,UUID() FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id INNER JOIN itech.medicalEligARVs ON itech.encounter.patientID=itech.medicalEligARVs.patientID WHERE itech.medicalEligARVs.siteCode=itech.encounter.siteCode AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode AND itech.encounter.encounterType=1 AND DATE(itech.encounter.visitDate)=CONCAT(itech.medicalEligARVs.visitDateYy,'-',itech.medicalEligARVs.visitDateMm,'-',itech.medicalEligARVs.visitDateDd) AND itech.medicalEligARVs.medElig=1 AND itech.medicalEligARVs.WHOIII=1;



/*Migration for OMS Stade IV*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid) SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,162225,itech.encounter_vitals_obs.id, itech.encounter.visitDate,itech.encounter.siteCode, CASE WHEN itech.medicalEligARVs.medElig=1 AND itech.medicalEligARVs.WHOIV=1 THEN 1207 END,1,itech.encounter.createDate,UUID() FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id INNER JOIN itech.medicalEligARVs ON itech.encounter.patientID=itech.medicalEligARVs.patientID WHERE itech.medicalEligARVs.siteCode=itech.encounter.siteCode AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode AND itech.encounter.encounterType=1 AND DATE(itech.encounter.visitDate)=CONCAT(itech.medicalEligARVs.visitDateYy,'-',itech.medicalEligARVs.visitDateMm,'-',itech.medicalEligARVs.visitDateDd) AND itech.medicalEligARVs.medElig=1 AND itech.medicalEligARVs.WHOIV=1;



/*Migration for PTME*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid) SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,162225,itech.encounter_vitals_obs.id, itech.encounter.visitDate,itech.encounter.siteCode, CASE WHEN itech.medicalEligARVs.medElig=1 AND itech.medicalEligARVs.PMTCT=1 THEN 160538 END,1,itech.encounter.createDate,UUID() FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id INNER JOIN itech.medicalEligARVs ON itech.encounter.patientID=itech.medicalEligARVs.patientID WHERE itech.medicalEligARVs.siteCode=itech.encounter.siteCode AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode AND itech.encounter.encounterType=1 AND DATE(itech.encounter.visitDate)=CONCAT(itech.medicalEligARVs.visitDateYy,'-',itech.medicalEligARVs.visitDateMm,'-',itech.medicalEligARVs.visitDateDd) AND itech.medicalEligARVs.medElig=1 AND itech.medicalEligARVs.PMTCT=1;



/*Migration for Éligibilité médicale établie à la visite antérieure*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid) SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,162225,itech.encounter_vitals_obs.id, itech.encounter.visitDate,itech.encounter.siteCode, CASE WHEN itech.medicalEligARVs.medElig=1 AND itech.medicalEligARVs.medEligHAART=1 THEN 163327 END,1,itech.encounter.createDate,UUID() FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id INNER JOIN itech.medicalEligARVs ON itech.encounter.patientID=itech.medicalEligARVs.patientID WHERE itech.medicalEligARVs.siteCode=itech.encounter.siteCode AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode AND itech.encounter.encounterType=1 AND DATE(itech.encounter.visitDate)=CONCAT(itech.medicalEligARVs.visitDateYy,'-',itech.medicalEligARVs.visitDateMm,'-',itech.medicalEligARVs.visitDateDd) AND itech.medicalEligARVs.medElig=1 AND itech.medicalEligARVs.medEligHAART=1;



/*Migration for ARV trithérapie antérieure*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid) SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,162225,itech.encounter_vitals_obs.id, itech.encounter.visitDate,itech.encounter.siteCode, CASE WHEN itech.medicalEligARVs.medElig=1 AND itech.medicalEligARVs.formerARVtherapy=1 THEN 1087 END,1,itech.encounter.createDate,UUID() FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id INNER JOIN itech.medicalEligARVs ON itech.encounter.patientID=itech.medicalEligARVs.patientID WHERE itech.medicalEligARVs.siteCode=itech.encounter.siteCode AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode AND itech.encounter.encounterType=1 AND DATE(itech.encounter.visitDate)=CONCAT(itech.medicalEligARVs.visitDateYy,'-',itech.medicalEligARVs.visitDateMm,'-',itech.medicalEligARVs.visitDateDd) AND itech.medicalEligARVs.medElig=1 AND itech.medicalEligARVs.formerARVtherapy=1;



/*Migration for Prophylaxie post-exposition (PEP)*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid) SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,162225,itech.encounter_vitals_obs.id, itech.encounter.visitDate,itech.encounter.siteCode, CASE WHEN itech.medicalEligARVs.medElig=1 AND itech.medicalEligARVs.PEP=1 THEN 1691 END,1,itech.encounter.createDate,UUID() FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id INNER JOIN itech.medicalEligARVs ON itech.encounter.patientID=itech.medicalEligARVs.patientID WHERE itech.medicalEligARVs.siteCode=itech.encounter.siteCode AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode AND itech.encounter.encounterType=1 AND DATE(itech.encounter.visitDate)=CONCAT(itech.medicalEligARVs.visitDateYy,'-',itech.medicalEligARVs.visitDateMm,'-',itech.medicalEligARVs.visitDateDd) AND itech.medicalEligARVs.medElig=1 AND itech.medicalEligARVs.PEP=1;



/*Migration for Date de l'expostion - waiting for new concept*/
/*Migration for Coinfection TB/HIV*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid) SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,162225,itech.encounter_vitals_obs.id, itech.encounter.visitDate,itech.encounter.siteCode, CASE WHEN itech.medicalEligARVs.coinfectionTbHiv=1 THEN 163324 END,1,itech.encounter.createDate,UUID() FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id INNER JOIN itech.medicalEligARVs ON itech.encounter.patientID=itech.medicalEligARVs.patientID WHERE itech.medicalEligARVs.siteCode=itech.encounter.siteCode AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode AND itech.encounter.encounterType=1 AND DATE(itech.encounter.visitDate)=CONCAT(itech.medicalEligARVs.visitDateYy,'-',itech.medicalEligARVs.visitDateMm,'-',itech.medicalEligARVs.visitDateDd) AND itech.medicalEligARVs.coinfectionTbHiv=1;



/*Migration for Coinfection HBV/HIV*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid) SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,162225,itech.encounter_vitals_obs.id, itech.encounter.visitDate,itech.encounter.siteCode, CASE WHEN itech.medicalEligARVs.coinfectionHbvHiv=1 THEN 163325 END,1,itech.encounter.createDate,UUID() FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id INNER JOIN itech.medicalEligARVs ON itech.encounter.patientID=itech.medicalEligARVs.patientID WHERE itech.medicalEligARVs.siteCode=itech.encounter.siteCode AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode AND itech.encounter.encounterType=1 AND DATE(itech.encounter.visitDate)=CONCAT(itech.medicalEligARVs.visitDateYy,'-',itech.medicalEligARVs.visitDateMm,'-',itech.medicalEligARVs.visitDateDd) AND itech.medicalEligARVs.coinfectionHbvHiv=1;



/*Migration for Couple sérodiscordant*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid) SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,162225,itech.encounter_vitals_obs.id, itech.encounter.visitDate,itech.encounter.siteCode, CASE WHEN itech.medicalEligARVs.coupleSerodiscordant=1 THEN 6096 END,1,itech.encounter.createDate,UUID() FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id INNER JOIN itech.medicalEligARVs ON itech.encounter.patientID=itech.medicalEligARVs.patientID WHERE itech.medicalEligARVs.siteCode=itech.encounter.siteCode AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode AND itech.encounter.encounterType=1 AND DATE(itech.encounter.visitDate)=CONCAT(itech.medicalEligARVs.visitDateYy,'-',itech.medicalEligARVs.visitDateMm,'-',itech.medicalEligARVs.visitDateDd) AND itech.medicalEligARVs.coupleSerodiscordant=1;



/*Migration for Femme enceinte (Grossesse)*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid) SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,162225,itech.encounter_vitals_obs.id, itech.encounter.visitDate,itech.encounter.siteCode, CASE WHEN itech.medicalEligARVs.pregnantWomen=1 THEN 1434 END,1,itech.encounter.createDate,UUID() FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id INNER JOIN itech.medicalEligARVs ON itech.encounter.patientID=itech.medicalEligARVs.patientID WHERE itech.medicalEligARVs.siteCode=itech.encounter.siteCode AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode AND itech.encounter.encounterType=1 AND DATE(itech.encounter.visitDate)=CONCAT(itech.medicalEligARVs.visitDateYy,'-',itech.medicalEligARVs.visitDateMm,'-',itech.medicalEligARVs.visitDateDd) AND itech.medicalEligARVs.pregnantWomen=1;



/*Migration for Femme allaitante*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid) SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,162225,itech.encounter_vitals_obs.id, itech.encounter.visitDate,itech.encounter.siteCode, CASE WHEN itech.medicalEligARVs.breastfeedingWomen=1 THEN 5632 END,1,itech.encounter.createDate,UUID() FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id INNER JOIN itech.medicalEligARVs ON itech.encounter.patientID=itech.medicalEligARVs.patientID WHERE itech.medicalEligARVs.siteCode=itech.encounter.siteCode AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode AND itech.encounter.encounterType=1 AND DATE(itech.encounter.visitDate)=CONCAT(itech.medicalEligARVs.visitDateYy,'-',itech.medicalEligARVs.visitDateMm,'-',itech.medicalEligARVs.visitDateDd) AND itech.medicalEligARVs.breastfeedingWomen=1;



/*Migration for Patient avec âge > 50 ans*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid) SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,162225,itech.encounter_vitals_obs.id, itech.encounter.visitDate,itech.encounter.siteCode, CASE WHEN itech.medicalEligARVs.patientGt50ans=1 THEN 163328 END,1,itech.encounter.createDate,UUID() FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id INNER JOIN itech.medicalEligARVs ON itech.encounter.patientID=itech.medicalEligARVs.patientID WHERE itech.medicalEligARVs.siteCode=itech.encounter.siteCode AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode AND itech.encounter.encounterType=1 AND DATE(itech.encounter.visitDate)=CONCAT(itech.medicalEligARVs.visitDateYy,'-',itech.medicalEligARVs.visitDateMm,'-',itech.medicalEligARVs.visitDateDd) AND itech.medicalEligARVs.patientGt50ans=1;



/*Migration for Néphropathie à VIH*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid) SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,162225,itech.encounter_vitals_obs.id, itech.encounter.visitDate,itech.encounter.siteCode, CASE WHEN itech.medicalEligARVs.nephropathieVih=1 THEN 153701 END,1,itech.encounter.createDate,UUID() FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id INNER JOIN itech.medicalEligARVs ON itech.encounter.patientID=itech.medicalEligARVs.patientID WHERE itech.medicalEligARVs.siteCode=itech.encounter.siteCode AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode AND itech.encounter.encounterType=1 AND DATE(itech.encounter.visitDate)=CONCAT(itech.medicalEligARVs.visitDateYy,'-',itech.medicalEligARVs.visitDateMm,'-',itech.medicalEligARVs.visitDateDd) AND itech.medicalEligARVs.nephropathieVih=1;



/*Migration for Protocole Test et Traitement*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_coded,creator,date_created,uuid) SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,162225,itech.encounter_vitals_obs.id, itech.encounter.visitDate,itech.encounter.siteCode, CASE WHEN itech.medicalEligARVs.protocoleTestTraitement=1 THEN 163329 END,1,itech.encounter.createDate,UUID() FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id INNER JOIN itech.medicalEligARVs ON itech.encounter.patientID=itech.medicalEligARVs.patientID WHERE itech.medicalEligARVs.siteCode=itech.encounter.siteCode AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode AND itech.encounter.encounterType=1 AND DATE(itech.encounter.visitDate)=CONCAT(itech.medicalEligARVs.visitDateYy,'-',itech.medicalEligARVs.visitDateMm,'-',itech.medicalEligARVs.visitDateDd) AND itech.medicalEligARVs.protocoleTestTraitement=1;



/*END OF ÉLIGIBILITÉ MÉDICALE AUX ARV MENU*/
/*MIGRATION FOR Date de prochaine visite */
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_datetime,creator,date_created,uuid) SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,5096,itech.encounter_vitals_obs.id, itech.encounter.visitDate,itech.encounter.siteCode, CASE WHEN itech.encounter.nxtVisitDd<1 AND itech.encounter.nxtVisitMm<1 AND itech.encounter.nxtVisitYy>0 THEN CONCAT(itech.encounter.nxtVisitYy,'-',01,'-',01) WHEN itech.encounter.nxtVisitDd<1 AND itech.encounter.nxtVisitMm>0 AND itech.encounter.nxtVisitYy>0 THEN CONCAT(itech.encounter.nxtVisitYy,'-',itech.encounter.nxtVisitMm,'-',01) WHEN itech.encounter.nxtVisitDd>0 AND itech.encounter.nxtVisitMm>0 AND itech.encounter.nxtVisitYy>0 THEN CONCAT(itech.encounter.nxtVisitYy,'-',itech.encounter.nxtVisitMm,'-',itech.encounter.nxtVisitDd) ELSE NULL END,1,itech.encounter.createDate,UUID() FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id WHERE itech.encounter.patientID=itech.encounter_vitals_obs.patient_id AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode AND itech.encounter.encounterType=1 AND itech.encounter_vitals_obs.date_created=itech.encounter.createDate AND itech.encounter.nxtVisitYy>0;



/*END OF MIGRATION FOR Date de prochaine visite*/
/*MIGRATION FOR ÉVALUATION ET PLAN MENU*/
INSERT INTO obs(person_id,concept_id,encounter_id,obs_datetime,location_id,value_text,creator,date_created,uuid) SELECT DISTINCT itech.patient_id_itech.id_patient_openmrs,159395,itech.encounter_vitals_obs.id, itech.encounter.visitDate,itech.encounter.siteCode, CASE WHEN itech.vitals.assessmentPlan<>'' THEN itech.vitals.assessmentPlan ELSE NULL END,1,itech.encounter.createDate,UUID() FROM itech.encounter INNER JOIN itech.patient_id_itech ON itech.encounter.patientID=itech.patient_id_itech.id_patient_isante INNER JOIN itech.encounter_vitals_obs ON itech.encounter.encounter_id=itech.encounter_vitals_obs.encounter_id INNER JOIN itech.vitals ON itech.encounter.patientID=itech.vitals.patientID WHERE itech.vitals.siteCode=itech.encounter.siteCode AND itech.encounter.patientID=itech.encounter_vitals_obs.patient_id AND itech.encounter.siteCode=itech.encounter_vitals_obs.siteCode AND itech.encounter.encounterType=1 AND DATE(itech.encounter.visitDate)=CONCAT(itech.vitals.visitDateYy,'-',itech.vitals.visitDateMm,'-',itech.vitals.visitDateDd) AND itech.vitals.assessmentPlan<>'';



/*END OF ÉVALUATION ET PLAN MENU*/


