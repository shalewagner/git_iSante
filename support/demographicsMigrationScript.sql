/* Add Haiti locations (sitecodes) from clinicLookup table
 * 5 digit sitecodes may be changed to 6 digit if CDC provides an updated clinic list
 * other CDC changes likely prior to actual deployment
 * not included or necessary to migrate: inCPHR, dbSite, ipAddress, dbVersion, oldClinicName, hostname
 * see location_attribute_type/location_attribue for attributes not mapped directly to location object 
 */
INSERT INTO location
(location_id, name,   city_village, country, latitude, longitude, creator, date_created,uuid) 
SELECT 
 siteCode,    clinic, commune,      'Haiti', lat,      lng,       1,       now(),       uuid()
FROM itech.clinicLookup ON DUPLICATE KEY UPDATE
name          =VALUES(name), 
city_village  =VALUES(city_village), 
country       =VALUES(country), 
latitude      =VALUES(latitude), 
longitude     =VALUES(longitude), 
creator       =VALUES(creator), 
date_created  =VALUES(date_created);

/* add location_attribute_type objects 
 * network, type, category, department
 */
INSERT INTO location_attribute_type 
(name,         min_occurs,creator,date_created,uuid) VALUES 
('network',    1,         1,      now(),       uuid()),
('type',       1,         1,      now(),       uuid()),
('category',   1,         1,      now(),       uuid()),
('department', 1,         1,      now(),       uuid());

/* this unique index enables rerun of location_attributes
 */
create unique index locAtt on location_attribute (location_id, attribute_type_id, value_reference(255));

INSERT INTO location_attribute (
    location_id, attribute_type_id,            value_reference, creator, date_created, uuid)
SELECT c.sitecode,  l.location_attribute_type_id, case when l.name = 'network' then c.network
                                                       when l.name = 'type' then c.type
                                                       when l.name = 'category' <> '' then c.category
                                                       when l.name = 'department' then c.department end,         
                                                                   1,       now(),        uuid() 
FROM itech.clinicLookup c, location_attribute_type l
WHERE (l.name = 'network' and c.network is not null and c.network <> '' and c.network <> 'Non associée' and c.network <> 'N/A' and c.network <> 'NULL') OR
      (l.name = 'type' and c.type is not null and c.type <> '') OR
   (l.name = 'category' and c.category is not null and c.type <> '') OR
   (l.name = 'department' and c.department is not null and c.type <> '') ON DUPLICATE KEY UPDATE
value_reference = VALUES(value_reference);

/* Load person table, linking person.uuid to itech.patient.patGuid
 * use lastModified field from encounter for create_date
 * make patGuid from patient table primary key for all additional migration statements
 */
 
alter table itech.patient modify person_id int not null;
alter table itech.patient drop primary key;
alter table itech.patient add primary key (patGuid);

INSERT INTO person (gender, birthdate, birthdate_estimated, dead, death_date, creator, date_created, uuid)
SELECT CASE WHEN sex = 1 THEN 'F' WHEN sex = 2 THEN 'M' ELSE 'U' END,
case when dobyy REGEXP '^[0-9]+$' and dobmm REGEXP '^[0-9]+$' and dobdd REGEXP '^[0-9]+$' AND (
(dobmm+0 IN (4,6,9,11) AND dobdd+0 BETWEEN 1 AND 30) OR (dobmm+0 IN (1,3,5,7,8,12) AND dobdd+0 BETWEEN 1 AND 31) OR (dobmm+0 = 2 AND dobdd+0 BETWEEN 1 and 28)) THEN DATE(CONCAT(dobyy,'-',dobmm,'-',dobdd)) else 
case when dobyy REGEXP '^[0-9]+$' and dobmm REGEXP '^[0-9]+$' AND dobmm+0 BETWEEN 1 AND 12 THEN DATE(CONCAT(dobyy,'-',dobmm,'-01')) else 
case when dobyy REGEXP '^[0-9]+$' THEN DATE(CONCAT(dobyy,'-01-01')) ELSE NULL END END END,
CASE WHEN ageYears is not null then 1 ELSE 0 END,
CASE WHEN date(deathDt) <> "0000-00-00" then 1 ELSE 0 END,
CASE WHEN date(deathDt) = "0000-00-00" then NULL ELSE deathDt END, 
1, now(), patGuid 
FROM itech.patient p
where p.location_id > 0 ON DUPLICATE KEY UPDATE
gender=VALUES(gender),
birthdate=VALUES(birthdate),
birthdate_estimated=VALUES(birthdate_estimated),
dead=VALUES(dead),
death_date=VALUES(death_date),
creator=VALUES(creator),
date_created=VALUES(date_created);

/* Load person name information
 * create unique index so that script can be rerun
 */
CREATE UNIQUE INDEX nameIndex ON person_name (person_id, given_name, family_name); 
INSERT INTO person_name(person_id,   preferred, given_name,                      family_name,                    creator, date_created, uuid)
SELECT                  p.person_id, 1,         left(replace(fname, ' ',''),50), left(replace(lname,' ',''),50), 1,       date_created, UUID()
FROM person p, itech.patient j where p.uuid = j.patGuid ON DUPLICATE KEY UPDATE
preferred      = VALUES(preferred),
given_name     = VALUES(given_name),
family_name    = VALUES(family_name),
creator        = VALUES(creator),
date_created   = VALUES(date_created);

/* Load person address information
 * create unique index so that script can be rerun
 */
CREATE UNIQUE INDEX addressIndex ON person_address (person_id, address1, city_village);
INSERT INTO person_address(person_id,   preferred, address1, city_village, creator, date_created, uuid)
SELECT                     p.person_id, 1,         addrDistrict, addrSection, 1, date_created, UUID()
FROM person p, itech.patient j where p.uuid = j.patGuid ON DUPLICATE KEY UPDATE
preferred = VALUES(preferred), 
address1 = VALUES(address1), 
city_village = VALUES(city_village), 
creator = VALUES(creator), 
date_created = VALUES(date_created);
 
/* Load patient table
 */
INSERT INTO patient(patient_id,  creator, date_created)
SELECT              p.person_id, 1,       date_created
FROM person p, itech.patient j where p.uuid = j.patGuid ON DUPLICATE KEY UPDATE
creator = VALUES(creator),
date_created = VALUES(date_created);

/* Load iSanté patient identifier types    
 */ 
INSERT INTO patient_identifier_type (patient_identifier_type_id, name, description, creator, date_created) VALUES 
(20,'Haiti NationalID','Haiti NationalID',1,now()),
(21,'masterPID','masterPID',1,now()),
(22,'obgynID','obgynID',1,now()),
(23,'primCareID','primCareID',1,now()),
(24,'clinicPatientID','clinicPatientID',1,now()),
(25,'iSante PatientID','iSante PatientID',1,now());

/* create unique index so that script can be rerun
 */
CREATE UNIQUE INDEX patIdentIndex on patient_identifier (patient_id,identifier_type,identifier);

/* Load patient identifiers from patient table
 * these identifiers come directly from isante patient table: 
 *   patientID (original iSanté internal identifier), 
 *   nationalid, 
 *   masterPID (first iSanté patientID nationwide: assumes national fingerprint server in use), 
 *   clinicPatientID (ST code: HIV patients) 
*/
INSERT INTO patient_identifier(patient_id,  identifier, identifier_type, preferred, location_id, creator, date_created, uuid)
SELECT p.person_id, case when t.name = 'Haiti NationalID' then left(j.nationalid,50)
when t.name = 'masterPID' then j.masterPID
when t.name = 'iSante PatientID' then j.patientID
when t.name = 'clinicPatientID' then left(j.clinicPatientID,50) end, t.patient_identifier_type_id, 1, j.location_id, 1, p.date_created,UUID()
FROM person p, itech.patient j, patient_identifier_type t 
WHERE p.uuid = j.patGuid AND (t.name = 'iSante PatientID' OR (t.name = 'Haiti NationalID' and j.nationalid is not null and j.nationalid <> '') OR (t.name = 'masterPID' AND j.masterPID IS NOT NULL AND j.masterPID <> '') OR (t.name = 'clinicPatientID' and j.clinicPatientID is not null and j.clinicPatientID <> '')) ON DUPLICATE KEY UPDATE
identifier=VALUES(identifier),
identifier_type=VALUES(identifier_type), 
preferred=VALUES(preferred), 
location_id=VALUES(location_id), 
creator=VALUES(creator), 
date_created=VALUES(date_created);

/* Load patient identifiers from obs table
 * These identifiers are loaded here: 
 *    primCareID (itech.obs concept short_name = 'primCareID', ID = 70039)
 *    obgynID (itech.obs concept short_name = 'obgynID', ID = 70040) 
 */
INSERT INTO patient_identifier(patient_id,  identifier, identifier_type, preferred, location_id, creator, date_created, uuid)
SELECT p.person_id, left(o.value_text,50), t.patient_identifier_type_id, 1, j.location_id, 1, p.date_created, UUID()
FROM person p, itech.patient j, itech.obs o, patient_identifier_type t 
WHERE p.uuid = j.patGuid AND j.patientid = concat(o.location_id,o.person_id) AND ((o.concept_id = 70039 and t.name = 'primCareID') OR (o.concept_id = 70040 AND t.name = 'obgynID')) AND o.value_text IS NOT NULL ON DUPLICATE KEY UPDATE
identifier=VALUES(identifier),
identifier_type=VALUES(identifier_type), 
preferred=VALUES(preferred), 
location_id=VALUES(location_id), 
creator=VALUES(creator), 
date_created=VALUES(date_created);

/* Load iSanté person attribute types    
 */ 
INSERT INTO person_attribute_type (person_attribute_type_id,name,description,creator,date_created) VALUES
(28,'addrContact','addrContact',1,now()),
(29,'addrContactSection','addrContactSection',1,now()),
(30,'addrContactTown','addrContactTown',1,now()),
(31,'addrDistrict','addrDistrict',1,now()),
(32,'addrMedicalPoa','addrMedicalPoa',1,now()),
(33,'addrMedicalPoaSection','addrMedicalPoaSection',1,now()),
(34,'addrMedicalPoaTown','addrMedicalPoaTown',1,now()),
(35,'addrSection','addrSection',1,now()),
(36,'addrTown','addrTown',1,now()),
(37,'ageYears','ageYears',1,now()),
(38,'birthDistrict','birthDistrict',1,now()),
(39,'birthSection','birthSection',1,now()),
(40,'birthTown','birthTown',1,now()),
(41,'contact','contact',1,now()),
(42,'fnameFather','fnameFather',1,now()),
(43,'homeDirections','homeDirections',1,now()),
(44,'medicalPoa','medicalPoa',1,now()),
(45,'occupation','occupation',1,now()),
(46,'phoneContact','phoneContact',1,now()),
(47,'phoneMedicalPoa','phoneMedicalPoa',1,now()),
(48,'relationContact','relationContact',1,now()),
(49,'relationMedicalPoa','relationMedicalPoa',1,now());

/* Load person_attribute for additional iSanté attributes
/* need unique index on person_attribute to prevent duplicate records 
*/
create unique index personAttrIndex on person_attribute (person_id, person_attribute_type_id, value);
 
/* Load person_attributes not in person, person_name, person_address
 * see above for iSanté attributes added
 * fnameMother is type 4
 * maritalStatus is type 5
 * telephone is type 8
 * marital status decode: 5555 Married, 1056 SEPARATED, 1059 WIDOWED, 1057 SINGLE
 */
INSERT INTO person_attribute (person_id, value, person_attribute_type_id, creator, date_created, uuid)
SELECT p.person_id, case 
when t.person_attribute_type_id = 28 then left(j.addrContact,50)
when t.person_attribute_type_id = 29 then left(j.addrContactSection,50)
when t.person_attribute_type_id = 30 then left(j.addrContactTown,50)
when t.person_attribute_type_id = 31 then left(j.addrDistrict,50)
when t.person_attribute_type_id = 32 then left(j.addrMedicalPoa,50)
when t.person_attribute_type_id = 33 then left(j.addrMedicalPoaSection,50)
when t.person_attribute_type_id = 34 then left(j.addrMedicalPoaTown,50)
when t.person_attribute_type_id = 35 then left(j.addrSection,50)
when t.person_attribute_type_id = 36 then left(j.addrTown,50)
when t.person_attribute_type_id = 37 then left(j.ageYears,50)
when t.person_attribute_type_id = 38 then left(j.birthDistrict,50)
when t.person_attribute_type_id = 39 then left(j.birthSection,50)
when t.person_attribute_type_id = 40 then left(j.birthTown,50)
when t.person_attribute_type_id = 41 then left(j.contact,50)
when t.person_attribute_type_id = 42 then left(j.fnameFather,50)
when t.person_attribute_type_id =  4 then left(j.fnameMother,50)
when t.person_attribute_type_id = 43 then left(j.homeDirections,50)
when t.person_attribute_type_id =  5 then CASE 
WHEN j.maritalStatus=1 THEN 5555 
WHEN j.maritalStatus=8 THEN 1056 
WHEN j.maritalStatus=4 THEN 1059 
ELSE 1057 END
when t.person_attribute_type_id = 44 then left(j.medicalPoa,50)
when t.person_attribute_type_id = 45 then left(j.occupation,50)
when t.person_attribute_type_id = 46 then left(j.phoneContact,50)
when t.person_attribute_type_id = 47 then left(j.phoneMedicalPoa,50)
when t.person_attribute_type_id = 48 then left(j.relationContact,50)
when t.person_attribute_type_id = 49 then left(j.relationMedicalPoa,50)
when t.person_attribute_type_id =  8 then left(j.telephone,50)
end, t.person_attribute_type_id,1, p.date_created, UUID()
FROM person p, itech.patient j, person_attribute_type t 
WHERE j.patGuid = p.uuid AND (
(t.person_attribute_type_id = 28 AND j.addrContact IS NOT NULL AND j.addrContact <> '') OR 
(t.person_attribute_type_id = 29 AND j.addrContactSection IS NOT NULL AND j.addrContactSection <> '') OR 
(t.person_attribute_type_id = 30 AND j.addrContactTown IS NOT NULL AND j.addrContactTown <> '') OR 
(t.person_attribute_type_id = 31 AND j.addrDistrict IS NOT NULL AND j.addrDistrict <> '') OR 
(t.person_attribute_type_id = 32 AND j.addrMedicalPoa IS NOT NULL AND j.addrMedicalPoa <> '') OR 
(t.person_attribute_type_id = 33 AND j.addrMedicalPoaSection IS NOT NULL AND j.addrMedicalPoaSection <> '') OR 
(t.person_attribute_type_id = 34 AND j.addrMedicalPoaTown IS NOT NULL AND j.addrMedicalPoaTown <> '') OR 
(t.person_attribute_type_id = 35 AND j.addrSection IS NOT NULL AND j.addrSection <> '') OR 
(t.person_attribute_type_id = 36 AND j.addrTown IS NOT NULL AND j.addrTown <> '') OR 
(t.person_attribute_type_id = 37 AND j.ageYears IS NOT NULL AND j.ageYears <> '') OR 
(t.person_attribute_type_id = 38 AND j.birthDistrict IS NOT NULL AND j.birthDistrict <> '') OR 
(t.person_attribute_type_id = 39 AND j.birthSection IS NOT NULL AND j.birthSection <> '') OR 
(t.person_attribute_type_id = 40 AND j.birthTown IS NOT NULL AND j.birthTown <> '') OR 
(t.person_attribute_type_id = 41 AND j.contact IS NOT NULL AND j.contact <> '') OR 
(t.person_attribute_type_id = 42 AND j.fnameFather IS NOT NULL AND j.fnameFather <> '') OR 
(t.person_attribute_type_id =  4 AND j.fnameMother IS NOT NULL AND j.fnameMother <> '') OR 
(t.person_attribute_type_id = 43 AND j.homeDirections IS NOT NULL AND j.homeDirections <> '') OR 
(t.person_attribute_type_id =  5 AND j.maritalStatus IS NOT NULL AND j.maritalStatus <> '') OR 
(t.person_attribute_type_id = 44 AND j.medicalPoa IS NOT NULL AND j.medicalPoa <> '') OR 
(t.person_attribute_type_id = 37 AND j.occupation IS NOT NULL AND j.occupation <> '') OR 
(t.person_attribute_type_id = 45 AND j.phoneContact IS NOT NULL AND j.phoneContact <> '') OR 
(t.person_attribute_type_id = 46 AND j.phoneMedicalPoa IS NOT NULL AND j.phoneMedicalPoa <> '') OR 
(t.person_attribute_type_id = 47 AND j.relationContact IS NOT NULL AND j.relationContact <> '') OR 
(t.person_attribute_type_id = 48 AND j.relationMedicalPoa IS NOT NULL AND j.relationMedicalPoa <> '') OR 
(t.person_attribute_type_id =  8 AND j.telephone IS NOT NULL AND j.telephone <> '')
) ON DUPLICATE KEY UPDATE
value=VALUES(value), 
person_attribute_type_id=VALUES(person_attribute_type_id), 
creator=VALUES(creator), 
date_created=VALUES(date_created);