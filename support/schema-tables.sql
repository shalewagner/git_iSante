-- ----------------------------------------------------------------------
-- SQL Haiti Database Create Script
-- ----------------------------------------------------------------------

DROP TABLE IF EXISTS schemaVersion;
CREATE TABLE schemaVersion (
 version smallint(5) unsigned NOT NULL,
 scriptName text NOT NULL,
 whenUpgraded timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
 PRIMARY KEY  (version)
);
insert into schemaVersion set version=43, scriptName='support/schema-updates/0043-UpdateMedicalEligArvs.sql';

DROP TABLE IF EXISTS adherenceCounseling;
CREATE TABLE adherenceCounseling (
  adherenceCounseling_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NOT NULL,
  missedDoses tinyint unsigned NULL,
  doseProp SMALLINT(5) NULL,
  reasonNotAvail tinyint unsigned NULL,
  reasonSideEff tinyint unsigned NULL,
  reasonFinished tinyint unsigned NULL,
  reasonLost tinyint unsigned NULL,
  reasonNotComf tinyint unsigned NULL,
  reasonOther tinyint unsigned NULL,
  reasonOtherText VARCHAR(255) NULL,
  reasonForgot tinyint unsigned NULL,
  reasonTooSick tinyint unsigned NULL,
  reasonTravel tinyint unsigned NULL,
  reasonDidNotWant tinyint unsigned NULL,
  reasonNoSwallow tinyint unsigned NULL,
  reasonNoFood tinyint unsigned NULL,
  sideNausea tinyint unsigned NULL,
  sideDiarrhea tinyint unsigned NULL,
  sideRash tinyint unsigned NULL,
  sideHeadache tinyint unsigned NULL,
  sideAbPain tinyint unsigned NULL,
  sideWeak tinyint unsigned NULL,
  sideNumb tinyint unsigned NULL,
  reasonPrison tinyint unsigned NULL,
  reasonFeelWell tinyint unsigned NULL,
  pickupPersonName VARCHAR(255) NULL,
  pickupPersonRel VARCHAR(255) NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  evaluationDoctor tinyint unsigned NULL,
  evaluationPharmacien tinyint unsigned NULL,
  evaluationNurse tinyint unsigned NULL,
  evaluationSocialWorker tinyint unsigned NULL,
  evaluationAgent tinyint unsigned NULL,
  evaluationOther tinyint unsigned NULL,
  evaluationOtherText VARCHAR(255) NULL,
  sideOtherText VARCHAR(255) NULL,
  adherenceRemark VARCHAR(255) NULL,
  behaviorProblem tinyint unsigned NULL,
  neuroMuscularDisorder tinyint unsigned NULL,
  jaundice tinyint unsigned NULL,
  severeAllergicReactions tinyint unsigned NULL,
  PRIMARY KEY (adherenceCounseling_id, dbSite),
  UNIQUE INDEX adherenceCounselingCONSTRAINT (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS allergies;
CREATE TABLE allergies (
  allergies_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NOT NULL DEFAULT 0,
  allergyName VARCHAR(255) NULL,
  allergyStartMm CHAR(2) NULL,
  allergyStartYy CHAR(2) NULL,
  allergyStopMm CHAR(2) NULL,
  allergyStopYy CHAR(2) NULL,
  rash tinyint unsigned NULL DEFAULT 0,
  rashF tinyint unsigned NULL DEFAULT 0,
  ABC tinyint unsigned NULL DEFAULT 0,
  hives tinyint unsigned NULL DEFAULT 0,
  SJ tinyint unsigned NULL DEFAULT 0,
  anaph tinyint unsigned NULL DEFAULT 0,
  allergyOther tinyint unsigned NULL DEFAULT 0,
  allergySlot tinyint unsigned NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (allergies_id, dbSite),
  UNIQUE INDEX allergiesINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, allergyName, allergySlot, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS allowedDisclosures;
CREATE TABLE allowedDisclosures (
  allowedDisclosures_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NULL,
  patientID VARCHAR(11) NULL,
  visitDateDd CHAR(2) NULL,
  visitDateMm CHAR(2) NULL,
  visitDateYy CHAR(2) NULL,
  seqNum tinyint unsigned NULL DEFAULT 0,
  disclosureName VARCHAR(255) NULL,
  disclosureRel VARCHAR(255) NULL,
  disclosureAddress VARCHAR(255) NULL,
  disclosureTelephone VARCHAR(255) NULL,
  disclosureSlot tinyint unsigned NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (allowedDisclosures_id, dbSite),
  UNIQUE INDEX allowedDisclosuresINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, disclosureName, disclosureSlot, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS announcements;
CREATE TABLE announcements (
  announcements_id int unsigned NOT NULL,
  dateStamp DATETIME NULL,
  version VARCHAR(255) NULL,
  bodyEn LONGTEXT NULL,
  bodyFr LONGTEXT NULL,
  hidden tinyint unsigned NULL,
  lastTrans VARCHAR(255) NULL,
  lastTransDate DATETIME NULL,
  PRIMARY KEY (announcements_id)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS arvAndPregnancy;
CREATE TABLE arvAndPregnancy (
  arvAndPregnancy_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NOT NULL DEFAULT 0,
  ARVexcl tinyint unsigned NOT NULL DEFAULT '0',
  zidovudineARVpreg tinyint unsigned NOT NULL DEFAULT '0',
  nevirapineARVpreg tinyint unsigned NOT NULL DEFAULT '0',
  unknownARVpreg tinyint unsigned NOT NULL DEFAULT '0',
  otherARVpreg tinyint unsigned NOT NULL DEFAULT '0',
  otherTextARVpreg VARCHAR(255) NOT NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (arvAndPregnancy_id, dbSite),
  UNIQUE INDEX arvAndPregnancyINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS arvEnrollment;
CREATE TABLE arvEnrollment (
  arvEnrollment_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NOT NULL DEFAULT 0,
  arv tinyint unsigned NULL,
  initiateTB tinyint unsigned NULL,
  TBprogram tinyint unsigned NULL,
  PMTCTprogram tinyint unsigned NULL,
  continueTB tinyint unsigned NULL,
  inadPsychPro tinyint unsigned NULL,
  psychEval tinyint unsigned NULL,
  familyPlanProg tinyint unsigned NULL,
  poorAdherence tinyint unsigned NULL,
  ARVadherCoun tinyint unsigned NULL,
  immunProg tinyint unsigned NULL,
  patientPref tinyint unsigned NULL,
  ARVeducCoun tinyint unsigned NULL,
  hospitalization tinyint unsigned NULL,
  inadPrepForAd tinyint unsigned NULL,
  otherMedRef tinyint unsigned NULL,
  otherMedRefText LONGTEXT NULL,
  doesntAccAcc tinyint unsigned NULL,
  psychSocialCoun tinyint unsigned NULL,
  doesntAccHome tinyint unsigned NULL,
  weakFamilySupp tinyint unsigned NULL,
  notesArvEnroll LONGTEXT NULL,
  barriersToReg tinyint unsigned NULL,
  transAssProg tinyint unsigned NULL,
  livesOutsideZone tinyint unsigned NULL,
  otherARVprog tinyint unsigned NULL,
  progHasRlimit tinyint unsigned NULL,
  ARVsTempUn tinyint unsigned NULL,
  otherMedElig tinyint unsigned NULL,
  otherMedEligText VARCHAR(255) NULL,
  nextVisitWeeks VARCHAR(64) NULL,
  nextVisitDD CHAR(2) NULL,
  nextVisitMM CHAR(2) NULL,
  nextVisitYY CHAR(2) NULL,
  arvEver tinyint unsigned NULL,
  committeeApproval tinyint unsigned NULL,
  committeeApprovalDateDd CHAR(2) NULL,
  committeeApprovalDateMm CHAR(2) NULL,
  committeeApprovalDateYy CHAR(2) NULL,
  tWaitListOther tinyint unsigned NULL,
  tWaitList tinyint unsigned NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  pedArvEver tinyint unsigned NULL,
  pedArvKnown tinyint unsigned NULL,
  pedNextVisitDays CHAR(2) NULL,
  pedNextVisitWeeks CHAR(2) NULL,
  pedNextVisitMos CHAR(2) NULL,
  PRIMARY KEY (arvEnrollment_id, dbSite),
  UNIQUE INDEX arvEnrollmentINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, arv, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS bloodeval1;
CREATE TABLE bloodeval1 (
  patientid VARCHAR(11) NOT NULL,
  visitdate DATETIME NOT NULL,
  seqNum tinyint unsigned NOT NULL,
  labid1 int unsigned NULL,
  labid2 int unsigned NULL,
  labid3 int unsigned NULL,
  labid4 int unsigned NULL,
  labid5 int unsigned NULL,
  INDEX bloodeval1Idx (patientid, visitdate)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS bloodeval2;
CREATE TABLE bloodeval2 (
  patientid VARCHAR(11) NOT NULL,
  visitdate DATETIME NOT NULL,
  seqNum tinyint unsigned NOT NULL,
  labid1 int unsigned NULL,
  labid2 int unsigned NULL,
  labid3 int unsigned NULL,
  labid4 int unsigned NULL,
  INDEX bloodeval2Idx (patientid, visitdate)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS buddies;
CREATE TABLE buddies (
  buddies_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NOT NULL DEFAULT 0,
  supportAccomp tinyint unsigned NULL,
  supportAccompVisit tinyint unsigned NULL,
  supportAccompTrained tinyint unsigned NULL,
  trainMm CHAR(2) NULL,
  trainYy CHAR(2) NULL,
  hasBuddyChanged tinyint unsigned NULL,
  supportAccompName VARCHAR(255) NULL,
  supportAccompAddr VARCHAR(255) NULL,
  supportAccompTel VARCHAR(255) NULL,
  educationLevel tinyint unsigned NULL,
  educationLevelText VARCHAR(255) NULL,
  relationshipTo tinyint unsigned NULL,
  relationshipToText VARCHAR(255) NULL,
  relationshipToTextOther VARCHAR(255) NULL,
  placeOfResidence tinyint unsigned NULL,
  meansOfTransport tinyint unsigned NULL,
  meansOfTransportText VARCHAR(255) NULL,
  availabilityContact tinyint unsigned NULL,
  frequency tinyint unsigned NULL,
  availAccompany tinyint unsigned NULL,
  availPickUp tinyint unsigned NULL,
  availTraining tinyint unsigned NULL,
  availSupportGroup tinyint unsigned NULL,
  supportAccompTrainedMm VARCHAR(2) NULL,
  supportAccompTrainedYy VARCHAR(2) NULL,
  backupAccompName VARCHAR(255) NULL,
  backupAccompRel VARCHAR(255) NULL,
  backupAccompContact VARCHAR(255) NULL,
  availSupportGroupText VARCHAR(255) NULL,
  availTrainingText VARCHAR(255) NULL,
  supportAccompContactMethodOth VARCHAR(255) NULL,
  supportAccompContactMethod tinyint unsigned NULL,
  hasBuddyChangedText LONGTEXT NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (buddies_id, dbSite),
  UNIQUE INDEX buddiesINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS cd4Table;
CREATE TABLE cd4Table (
  siteCode mediumint unsigned NULL,
  patientid VARCHAR(11) NULL,
  visitdate DATETIME NULL,
  cd4 int unsigned NULL,
  encounter_id int unsigned NULL,
  encounterType tinyint unsigned NULL,
  formVersion tinyint unsigned NULL,
  INDEX cd4TableIndex (patientid, visitDate),
  INDEX cd4Index (cd4, patientid, visitDate)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS cd4Temp;
CREATE TABLE cd4Temp (
  siteCode mediumint unsigned NULL,
  patientid VARCHAR(11) NULL,
  visitdate DATETIME NULL,
  cd4 int unsigned NULL
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS clinicLookup;
CREATE TABLE clinicLookup (
  department VARCHAR(100) NULL,
  commune VARCHAR(100) NULL,
  clinic VARCHAR(100) NULL,
  category VARCHAR(100) NULL,
  type VARCHAR(100) NULL,
  siteCode mediumint unsigned,
  network VARCHAR(100) NULL,
  inCPHR tinyint unsigned NULL,
  dbSite int unsigned NULL DEFAULT 0,
  ipAddress VARCHAR(20) NULL DEFAULT '0',
  dbVersion VARCHAR(7) NULL,
  lat FLOAT NULL,
  lng FLOAT NULL,
  oldClinicName VARCHAR(100) NULL, 
  hostname VARCHAR(30) NULL, 
  PRIMARY KEY (siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS cohort;
CREATE TABLE cohort (
  siteCode mediumint unsigned NOT NULL,
  patientid VARCHAR(11) NOT NULL,
  minDate CHAR(6) NOT NULL,
  cntDates CHAR(6) NOT NULL
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS cohortAsort;
CREATE TABLE cohortAsort (
  sorder int unsigned NOT NULL,
  title VARCHAR(100) NOT NULL
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS cohortTable;
CREATE TABLE cohortTable (
  siteCode mediumint unsigned NULL,
  patientid VARCHAR(11) NULL,
  firstVisit DATETIME NULL,
  sex tinyint unsigned NULL,
  ageYears int unsigned NULL,
  pregnant tinyint unsigned NULL
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS comprehension;
CREATE TABLE comprehension (
  comprehension_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NOT NULL DEFAULT 0,
  regularFollowup tinyint unsigned NULL DEFAULT 0,
  doNotCure tinyint unsigned NULL DEFAULT 0,
  canStillTransmit tinyint unsigned NULL DEFAULT 0,
  canMinimizeRisk tinyint unsigned NULL DEFAULT 0,
  adherenceAbove95 tinyint unsigned NULL DEFAULT 0,
  stopAll tinyint unsigned NULL DEFAULT 0,
  sideEffectsComp tinyint unsigned NULL DEFAULT 0,
  canExplain tinyint unsigned NULL DEFAULT 0,
  compRemarks LONGTEXT NULL,
  infoByBuddy tinyint unsigned NULL DEFAULT 0,
  supportByBuddy tinyint unsigned NULL DEFAULT 0,
  adherenceToCare tinyint unsigned NULL DEFAULT 0,
  barriersToAppts tinyint unsigned NULL DEFAULT 0,
  acceptHomeVisits tinyint unsigned NULL DEFAULT 0,
  barriersToHomeVisits tinyint unsigned NULL DEFAULT 0,
  obstaclesRemarks LONGTEXT NULL,
  barriersToApptsText VARCHAR(255) NULL,
  barriersToHomeVisitsText VARCHAR(255) NULL,
  pregnantFemale tinyint unsigned NULL,
  familyViolenceEmo tinyint unsigned NULL,
  familyViolenceVerb tinyint unsigned NULL,
  familyViolencePhys tinyint unsigned NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (comprehension_id, dbSite),
  UNIQUE INDEX comprehensionINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS conditionLookup;
CREATE TABLE conditionLookup (
  conditionLookup_id int unsigned NOT NULL AUTO_INCREMENT,
  conditionsID int unsigned NULL DEFAULT 0,
  conditionCode VARCHAR(20) NULL,
  conditionNameEn VARCHAR(255) NULL,
  conditionNameFr VARCHAR(255) NULL,
  conditionGroup tinyint unsigned NULL,
  conditionDisplay tinyint unsigned NULL,
  conditionSort tinyint unsigned NULL DEFAULT 0,
  conditionSortEn tinyint unsigned NULL,
  PRIMARY KEY (conditionLookup_id),
  UNIQUE INDEX conditionLookupINDEX (conditionsID)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS conditionOrder;
CREATE TABLE conditionOrder (
  conditionID int unsigned NOT NULL,
  conditionEncounterType tinyint unsigned NULL,
  conditionVersion tinyint unsigned NOT NULL DEFAULT 0,
  conditionOrder int unsigned NOT NULL,
  conditionGroupID int unsigned NOT NULL,
  PRIMARY KEY (conditionID, conditionVersion, conditionOrder, conditionGroupID)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS conditions;
CREATE TABLE conditions (
  conditions_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NOT NULL DEFAULT 0,
  conditionID int unsigned NOT NULL,
  conditionMm CHAR(2) NULL,
  conditionYy CHAR(2) NULL,
  conditionActive tinyint unsigned NULL DEFAULT 0,
  conditionComment VARCHAR(200) NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (conditions_id, dbSite),
  UNIQUE INDEX conditionsINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, conditionID, sitecode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS config;
CREATE TABLE config (
  config_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  name VARCHAR( 255 ) NOT NULL ,
  value TEXT NOT NULL ,
UNIQUE (
  name
)
) ENGINE = InnoDB COMMENT = 'see backend/config.php for more info';

DROP TABLE IF EXISTS discEnrollment;
CREATE TABLE discEnrollment (
  discEnrollment_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NOT NULL,
  receiveReferrals tinyint unsigned NULL,
  receiveReferralsText VARCHAR(255) NULL,
  missAppointment tinyint unsigned NULL,
  missDateDd CHAR(2) NULL,
  missDateMm CHAR(2) NULL,
  missDateYy CHAR(2) NULL,
  actionPlan LONGTEXT NULL,
  transferClinics tinyint unsigned NULL,
  transferDateMm CHAR(2) NULL,
  transferDateYy CHAR(2) NULL,
  clinicName VARCHAR(255) NULL,
  ending tinyint unsigned NULL,
  endingMm CHAR(2) NULL,
  endingYy CHAR(2) NULL,
  reasonDiscNoFollowup tinyint unsigned NULL,
  reasonDiscRef tinyint unsigned NULL,
  reasonDiscRefText VARCHAR(255) NULL,
  reasonDiscDeath tinyint unsigned NULL,
  reasonDiscDeathMm CHAR(2) NULL,
  reasonDiscDeathYy CHAR(2) NULL,
  discRemarks LONGTEXT NULL,
  reasonDiscTransfer tinyint unsigned NULL,
  reasonDiscTransferText VARCHAR(255) NULL,
  lastContactDd CHAR(2) NULL,
  lastContactMm CHAR(2) NULL,
  lastContactYy CHAR(2) NULL,
  disEnrollDd CHAR(2) NULL,
  disEnrollMm CHAR(2) NULL,
  disEnrollYy CHAR(2) NULL,
  patientPreference tinyint unsigned NULL,
  patientMoved tinyint unsigned NULL,
  poorAdherence tinyint unsigned NULL,
  noARVs tinyint unsigned NULL,
  sideEffects tinyint unsigned NULL,
  sideEffectsText VARCHAR(255) NULL,
  opportunInf tinyint unsigned NULL,
  opportunInfText VARCHAR(255) NULL,
  discDeathOther tinyint unsigned NULL,
  discDeathOtherText VARCHAR(255) NULL,
  discReasonOther tinyint unsigned NULL,
  discReasonOtherText VARCHAR(255) NULL,
  min3homeVisits tinyint unsigned NULL,
  min3homeVisitsText VARCHAR(255) NULL,
  reasonDiscDeathDd CHAR(2) NULL,
  endingDd CHAR(2) NULL,
  everOn tinyint unsigned NULL,
  partStop tinyint unsigned NULL,
  missOtherAppointment tinyint unsigned NULL,
  alreadyEnrolled tinyint unsigned NULL,
  recommendCommittee tinyint unsigned NULL,
  transferPrepared tinyint unsigned NULL,
  transferDateDd CHAR(2) NULL,
  missOtherDateDd CHAR(2) NULL,
  missOtherDateMm CHAR(2) NULL,
  missOtherDateYy CHAR(2) NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  reasonDiscOther tinyint unsigned NULL,
  reasonUnknownClosing tinyint unsigned NULL,
  seroreversion tinyint unsigned NULL,
  PRIMARY KEY (discEnrollment_id, dbSite),
  UNIQUE INDEX discEnrollmentINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS discReasonLookup;
CREATE TABLE discReasonLookup (
  discType int unsigned NULL,
  reasonDescFr VARCHAR(100) NULL,
  reasonDescEn VARCHAR(100) NULL
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS discTable;
CREATE TABLE discTable (
  sitecode mediumint unsigned NULL,
  patientid VARCHAR(11) NULL,
  discDate DATETIME NULL,
  discType int unsigned NULL,
  INDEX discTableIdx (patientid, discDate)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS drugGroupLookup;
CREATE TABLE drugGroupLookup (
  drugGroupLookup_id int unsigned NOT NULL AUTO_INCREMENT,
  drugGroupID int unsigned NULL,
  drugGroupen VARCHAR(40) NULL,
  drugGroupfr VARCHAR(40) NULL,
  PRIMARY KEY (drugGroupLookup_id),
  UNIQUE INDEX drugGroupLookupINDEX (drugGroupID)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS drugGroupVersionOrder;
CREATE TABLE drugGroupVersionOrder (
  drugGroupVersionOrder_id int unsigned NOT NULL,
  drugGroupID int unsigned NOT NULL,
  formVersion tinyint unsigned NOT NULL,
  encounterType tinyint unsigned NOT NULL,
  versionOrder int unsigned NOT NULL,
  PRIMARY KEY (encounterType, formVersion, versionOrder)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS drugLookup;
CREATE TABLE drugLookup (
  drugLookup_id int unsigned NOT NULL,
  drugID int unsigned NOT NULL DEFAULT '0',
  drugName VARCHAR(255) NULL,
  drugLabel VARCHAR(60) NULL,
  drugGroup VARCHAR(40) NULL,
  stdDosageDescription VARCHAR(255) NULL,
  shortName VARCHAR(20) NULL,
  drugLabelen VARCHAR(255) NULL,
  drugLabelfr VARCHAR(255) NULL,
  pedStdDosageEn1 VARCHAR(255) NULL,
  pedStdDosageEn2 VARCHAR(255) NULL,
  pedStdDosageFr1 VARCHAR(255) NULL,
  pedStdDosageFr2 VARCHAR(255) NULL,
  pedDosageLabel VARCHAR(255) NULL,
  PRIMARY KEY (drugID)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS drugs;
CREATE TABLE drugs (
  drugs_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NULL,
  visitDateMm CHAR(2) NULL,
  visitDateYy CHAR(2) NULL,
  seqNum tinyint unsigned NOT NULL DEFAULT 0,
  drugID int unsigned NOT NULL,
  forPepPmtct tinyint unsigned NULL,
  startMm CHAR(2) NULL,
  startYy CHAR(2) NULL,
  isContinued tinyint unsigned NULL,
  stopMm CHAR(2) NULL,
  stopYy CHAR(2) NULL,
  toxicity tinyint unsigned NULL,
  intolerance tinyint unsigned NULL,
  failure tinyint unsigned NULL,
  stockOut tinyint unsigned NULL,
  pregnancy tinyint unsigned NULL,
  patientHospitalized tinyint unsigned NULL,
  lackMoney tinyint unsigned NULL,
  alternativeTreatments tinyint unsigned NULL,
  missedVisit tinyint unsigned NULL,
  patientPreference tinyint unsigned NULL,
  reasonComments VARCHAR(255) NULL,
  discUnknown tinyint unsigned NULL,
  failureVir tinyint unsigned NULL,
  failureImm tinyint unsigned NULL,
  failureClin tinyint unsigned NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  prophDose tinyint unsigned NULL,
  failureProph tinyint unsigned NULL,
  interUnk tinyint unsigned NULL,
  finPTME tinyint unsigned NULL, 
  PRIMARY KEY (drugs_id, dbSite),
  INDEX drugs1 (drugID, patientID),
  UNIQUE INDEX drugsINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, drugID, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS drugSummary;

DROP TABLE IF EXISTS drugSummaryAll;

CREATE TABLE drugSummaryAll (
  patientid VARCHAR(11) NULL,
  drugID int unsigned NULL,
  forPepPmtct tinyint unsigned NULL,
  startDate DATETIME NULL,
  stopDate DATETIME NULL,
  toxicity tinyint unsigned NULL,
  intolerance tinyint unsigned NULL,
  failureVir tinyint unsigned NULL,
  failureImm tinyint unsigned NULL,
  failureClin tinyint unsigned NULL,
  stockOut tinyint unsigned NULL,
  pregnancy tinyint unsigned NULL,
  patientHospitalized tinyint unsigned NULL,
  lackMoney tinyint unsigned NULL,
  alternativeTreatments tinyint unsigned NULL,
  missedVisit tinyint unsigned NULL,
  patientPreference tinyint unsigned NULL,
  prophDose tinyint unsigned NULL,
  failureProph tinyint unsigned NULL,
  interUnk tinyint unsigned NULL,
  finPTME tinyint unsigned NULL,
  INDEX drugSummaryINDEX (patientid, drugID)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS drugTable;

DROP TABLE IF EXISTS drugTableAll;

CREATE TABLE drugTableAll (
  sitecode mediumint unsigned NULL,
  patientid VARCHAR(11) NULL,
  visitdate DATETIME NULL,
  drugID int unsigned NULL,
  forPepPmtct tinyint unsigned NULL,
  INDEX drugTableINDEX (patientid, drugID)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci; 

DROP TABLE IF EXISTS drugVersionOrder;
CREATE TABLE drugVersionOrder (
  drugVersionOrder_id int unsigned NOT NULL,
  drugGroupID int unsigned NOT NULL,
  drugID int unsigned NULL,
  encounterType tinyint unsigned NOT NULL,
  formVersion tinyint unsigned NOT NULL DEFAULT 0,
  versionOrder int unsigned NOT NULL,
  PRIMARY KEY (encounterType, formVersion, versionOrder)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS dw_encounter_snapshot;
CREATE TABLE IF NOT EXISTS dw_encounter_snapshot (
  siteCode mediumint(8) unsigned NOT NULL,
  patientID varchar(11) NOT NULL,
  visitdate date default NULL,
  encounter_id int(10) unsigned NOT NULL default '0',
  dbSite tinyint(3) unsigned NOT NULL default '0',
  lastModified datetime default NULL,
  PRIMARY KEY  USING BTREE (encounter_id,dbSite),
  KEY lastModifiedSnapshotIndex (lastModified,encounter_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS dw_malariaReportLookup;
CREATE TABLE IF NOT EXISTS dw_malariaReportLookup (
  indicator smallint NOT NULL,
  indicatorType smallint NOT NULL,
  nameen varchar(150) character set utf8 collate utf8_unicode_ci NOT NULL,
  namefr varchar(150) character set utf8 collate utf8_unicode_ci NOT NULL,
  definitionen varchar(1024) character set utf8 collate utf8_unicode_ci NOT NULL,
  definitionfr varchar(1024) character set utf8 collate utf8_unicode_ci NOT NULL,
  subGroupEn varchar(150) character set utf8 collate utf8_unicode_ci NOT NULL,
  subGroupFr varchar(150) character set utf8 collate utf8_unicode_ci NOT NULL,
  indicatorDenominator smallint
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS dw_malaria_patients;
CREATE TABLE IF NOT EXISTS dw_malaria_patients (
  indicator smallint(10) NOT NULL,
  time_period varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  period smallint(6) NOT NULL,
  patientid varchar(11) NOT NULL,
  PRIMARY KEY  (indicator,patientid,time_period,`year`,period)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS dw_malaria_slices;
CREATE TABLE IF NOT EXISTS dw_malaria_slices (
  org_unit varchar(50) NOT NULL,
  org_value varchar(50) NOT NULL,
  indicator smallint(10) NOT NULL,
  time_period varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  period smallint(6) NOT NULL,
  gender tinyint unsigned NOT NULL, 
  `value` bigint default '0',
  denominator bigint default '0',
  PRIMARY KEY  (org_unit,org_value,indicator,time_period,`year`,period, gender)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS dw_malaria_snapshot;
CREATE TABLE IF NOT EXISTS dw_malaria_snapshot (
  visitdate date NOT NULL default '0000-00-00',
  patientid varchar(11) NOT NULL,
  malariaDxA tinyint(1) NOT NULL default '0',
  malariaDx tinyint(1) NOT NULL default '0',
  malariaDxG tinyint(1) NOT NULL default '0',
  malariaDxSuspectedA tinyint(1) NOT NULL default '0',
  malariaDxSuspected tinyint(1) NOT NULL default '0',
  malariaDxSuspectedG tinyint(1) NOT NULL default '0',
  isPregnant tinyint(1) NOT NULL default '0',
  sym_malariaLT tinyint(1) NOT NULL default '0',
  sym_malariaGT tinyint(1) NOT NULL default '0',
  feverLess2 tinyint(1) NOT NULL default '0',
  feverGreat2 tinyint(1) NOT NULL default '0',
  chloroquine tinyint(1) NOT NULL default '0',
  quinine tinyint(1) NOT NULL default '0',
  primaquine tinyint(1) NOT NULL default '0',
  convulsion tinyint(1) NOT NULL default '0',
  lethargy tinyint(1) NOT NULL default '0',
  hematuria tinyint(1) NOT NULL default '0',
  ictere tinyint(1) NOT NULL default '0',
  anemia tinyint(1) NOT NULL default '0',
  anemiaA tinyint(1) NOT NULL default '0',
  anemiaG tinyint(1) NOT NULL default '0',
  hemoglobine float NOT NULL default '5000',
  creatinine float NOT NULL default '5000',
  glycemie float NOT NULL default '5000',
  malariaTest tinyint(1) NOT NULL default '0',
  malariaTestRapid tinyint(1) NOT NULL default '0',
  rapidResultPositive tinyint(1) NOT NULL default '0',
  rapidResultNegative tinyint(1) NOT NULL default '0',
  smearResultPositive tinyint(1) NOT NULL default '0',
  smearResultNegative tinyint(1) NOT NULL default '0',
  testsOrdered  tinyint(1) NOT NULL default '0',
  hospitalisation tinyint(1) NOT NULL default '0',
  FT tinyint(1) NOT NULL default '0',
  FG tinyint(1) NOT NULL default '0',
  Vx tinyint(1) NOT NULL default '0',
  Ov tinyint(1) NOT NULL default '0',
  Mai tinyint(1) NOT NULL default '0',
  highTemp tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (visitdate,patientid),
  KEY pidIndex (patientid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS encounter;
CREATE TABLE encounter (
  encounter_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  lastModified DATETIME NULL,
  encounterType tinyint unsigned NOT NULL,
  seqNum tinyint unsigned NOT NULL DEFAULT 0,
  encStatus tinyint unsigned NOT NULL DEFAULT 0,
  encComments LONGTEXT NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  visitPointer int unsigned NULL,
  formAuthor VARCHAR(100) NULL,
  formVersion SMALLINT(5) NOT NULL DEFAULT 0,
  formAuthor2 VARCHAR(100) NULL,
  labOrDrugForm tinyint unsigned NULL,
  creator VARCHAR(20) NULL,
  createDate DATETIME NULL,
  lastModifier VARCHAR(20) NULL,
  badVisitDate tinyint unsigned NOT NULL DEFAULT 0,
  nxtVisitDd CHAR(2) NULL,
  nxtVisitMm CHAR(2) NULL,
  nxtVisitYy CHAR(2) NULL,
  isRegistry tinyint unsigned DEFAULT 0,
  visitDate DATETIME NULL,
  PRIMARY KEY (encounter_id, dbSite),
  INDEX encounter1 (encounterType),
  UNIQUE INDEX encounterINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, siteCode, encounterType)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS encounterOtherFields;
CREATE TABLE encounterOtherFields (
  encounter_id int unsigned NOT NULL,
  drugRemarks VARCHAR(200) NULL,
  startedArv int unsigned NULL,
  arvStartDate DATETIME NULL,
  signature VARCHAR(64) NULL
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS encounterQueue;
CREATE TABLE encounterQueue (
encounterType tinyint unsigned NOT NULL,
sitecode  mediumint unsigned NOT NULL,
encounter_id int unsigned NOT NULL,
dbSite tinyint unsigned NOT NULL DEFAULT 0, 
encounterStatus tinyint unsigned NOT NULL,
createDateTime datetime NULL,
lastStatusUpdate datetime NULL,
accessionNumber VARCHAR(255) NULL,
  PRIMARY KEY  (encounter_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS queueStatusLookup;
CREATE TABLE queueStatusLookup (
encounterStatus tinyint unsigned NOT NULL,
statusTextEn varchar(200) NOT NULL,
statusTextFr varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO queueStatusLookup values (1, 'New order', 'Nouvel ordre');
INSERT INTO queueStatusLookup values (2, 'Successfully sent and accepted', 'Envoyé avec succès et accepté');
INSERT INTO queueStatusLookup values (3, 'Successfully sent but rejected', 'Envoyé avec succès mais rejeté');
INSERT INTO queueStatusLookup values (4, 'Send failed', 'Envoyer échoué');
INSERT INTO queueStatusLookup values (5, 'Order canceled', 'Ordre annulée');
INSERT INTO queueStatusLookup values (6, 'Results received for order', 'Résultats reçu l’ordre');

DROP TABLE IF EXISTS encTypeLookup;
CREATE TABLE encTypeLookup (
  encounterType tinyint unsigned NULL,
  frName VARCHAR(50) NULL,
  enName VARCHAR(50) NULL,
  newestFormVersion tinyint unsigned NOT NULL default 0
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS followupTreatment;
CREATE TABLE followupTreatment (
  followupTreatment_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NOT NULL DEFAULT 0,
  currToxicity tinyint unsigned NULL,
  currToxRash tinyint unsigned NULL,
  currToxAnemia tinyint unsigned NULL,
  currToxHep tinyint unsigned NULL,
  currToxCNS tinyint unsigned NULL,
  currToxHyper tinyint unsigned NULL,
  currToxOther tinyint unsigned NULL,
  currToxText VARCHAR(255) NULL,
  regFailure tinyint unsigned NULL,
  weightLoss tinyint unsigned NULL,
  oppInfection tinyint unsigned NULL,
  decreaseCD4 tinyint unsigned NULL,
  regFailOther tinyint unsigned NULL,
  regFailText VARCHAR(255) NULL,
  adherence tinyint unsigned NULL,
  currToxicityText VARCHAR(255) NULL,
  adherenceComments LONGTEXT NULL,
  followupComments LONGTEXT NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (followupTreatment_id, dbSite),
  UNIQUE INDEX followupTreatmentINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS formErrors;
CREATE TABLE formErrors (
  encounter_id int unsigned NOT NULL,
  fieldName VARCHAR(64) NOT NULL,
  fieldError VARCHAR(255) NULL
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS homeCareVisits;
CREATE TABLE homeCareVisits (
  homeCareVisits_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NOT NULL DEFAULT 0,
  contactDuringVisit tinyint unsigned NULL,
  freqSupportBuddy tinyint unsigned NULL,
  missedAppointment tinyint unsigned NULL,
  missedDateDd CHAR(2) NULL,
  missedDateMm CHAR(2) NULL,
  missedDateYy CHAR(2) NULL,
  reasonMissed SMALLINT(5) NULL,
  reasonMissedText VARCHAR(255) NULL,
  illnessDescription tinyint unsigned NULL,
  illnessDescriptionOther VARCHAR(255) NULL,
  nextClinicVisitDays VARCHAR(16) NULL,
  nextClinicVisitDd CHAR(2) NULL,
  nextClinicVisitMm CHAR(2) NULL,
  nextClinicVisitYy CHAR(2) NULL,
  nextHomeVisitDays VARCHAR(16) NULL,
  nextHomeVisitDd CHAR(2) NULL,
  nextHomeVisitMm CHAR(2) NULL,
  nextHomeVisitYy CHAR(2) NULL,
  homeVisitRemarks LONGTEXT NULL,
  reasonVisit tinyint unsigned NULL,
  reasonVisitOther VARCHAR(255) NULL,
  serviceDelivery tinyint unsigned NULL,
  serviceDeliveryOther VARCHAR(255) NULL,
  arvDiscontinuation tinyint unsigned NULL,
  arvDiscontinuationDd CHAR(2) NULL,
  arvDiscontinuationMm CHAR(2) NULL,
  arvDiscontinuationYy CHAR(2) NULL,
  careDiscontinuation tinyint unsigned NULL,
  careDiscReason tinyint unsigned NULL,
  careDiscDeathDateDd CHAR(2) NULL,
  careDiscDeathDateMm CHAR(2) NULL,
  careDiscDeathDateYy CHAR(2) NULL,
  careDiscTransferText VARCHAR(255) NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (homeCareVisits_id, dbSite),
  UNIQUE INDEX homeCareVisitsINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS householdComp;
CREATE TABLE householdComp (
  householdComp_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NOT NULL DEFAULT 0,
  householdName VARCHAR(255) NULL,
  householdAge VARCHAR(64) NULL,
  householdRel VARCHAR(255) NULL,
  hivStatus tinyint unsigned NULL,
  householdSlot tinyint unsigned NULL,
  householdDisc tinyint unsigned NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (householdComp_id, dbSite),
  UNIQUE INDEX householdCompINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, householdName, householdSlot, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS immunizationLookup;
CREATE TABLE immunizationLookup (
  immunizationLookup_id int unsigned NOT NULL AUTO_INCREMENT,
  immunizationID int unsigned NULL,
  immunizationCode VARCHAR(20) NULL,
  immunizationNameEn VARCHAR(255) NULL,
  immunizationNameFr VARCHAR(255) NULL,
  PRIMARY KEY (immunizationLookup_id),
  UNIQUE INDEX immunizationLookupINDEX (immunizationID, immunizationCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS immunizationRendering;
CREATE TABLE immunizationRendering (
  immunizationRendering_id int unsigned NOT NULL AUTO_INCREMENT,
  immunizationID int unsigned NULL,
  immunizationEncounterType tinyint unsigned NULL,
  immunizationFormVersion tinyint unsigned NULL,
  immunizationGroup int unsigned NULL,
  immunizationOrderEn int unsigned NULL,
  immunizationOrderFr int unsigned NULL,
  immunizationCnt tinyint unsigned NULL,
  PRIMARY KEY (immunizationRendering_id),
  UNIQUE INDEX immunizationRenderingINDEX (immunizationID, immunizationEncounterType)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS immunizations;
CREATE TABLE immunizations (
  immunizations_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NOT NULL,
  immunizationID int unsigned NULL,
  immunizationDd CHAR(2) NULL,
  immunizationMm CHAR(2) NULL,
  immunizationYy CHAR(2) NULL,
  immunizationDoses int unsigned NULL,
  immunizationSlot tinyint unsigned NULL,
  immunizationComment VARCHAR(255) NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  immunizationGiven tinyint unsigned NULL,
  PRIMARY KEY (immunizations_id, dbSite),
  UNIQUE INDEX immunizationsINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, immunizationID, immunizationSlot, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci; 

DROP TABLE IF EXISTS otherImmunizations;
CREATE TABLE otherImmunizations (
  otherImmunizations_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NOT NULL,
  immunizationName VARCHAR(255) NOT NULL,
  immunizationDd CHAR(2) NULL,
  immunizationMm CHAR(2) NULL,
  immunizationYy CHAR(2) NULL,
  immunizationDoses int unsigned NULL,
  immunizationSlot tinyint unsigned NULL,
  immunizationComment VARCHAR(255) NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  immunizationGiven tinyint unsigned NULL,
  PRIMARY KEY (otherImmunizations_id, dbSite),
  UNIQUE INDEX otherImmunizationsINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, immunizationName, immunizationSlot, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS labelLookup;
CREATE TABLE labelLookup (
  tableName VARCHAR(255) NOT NULL DEFAULT '',
  englishPreLabel LONGTEXT NOT NULL,
  englishLabel LONGTEXT NOT NULL,
  englishPostLabel LONGTEXT NOT NULL,
  frenchPreLabel LONGTEXT NOT NULL,
  frenchLabel LONGTEXT NOT NULL,
  frenchPostLabel LONGTEXT NOT NULL,
  columnName VARCHAR(255) NOT NULL DEFAULT ''
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS labLookup;
CREATE TABLE labLookup (
  labLookup_id int unsigned NOT NULL,
  labID int unsigned NOT NULL,
  testNameEn VARCHAR(255) NULL,
  testNameFr VARCHAR(255) NULL,
  `minValue` VARCHAR(255) NULL,
  `maxValue` VARCHAR(255) NULL,
  labName VARCHAR(255) NULL,
  resultType tinyint unsigned NULL,
  resultLabelEn1 VARCHAR(255) NULL,
  resultLabelFr1 VARCHAR(255) NULL,
  resultLabelEn2 VARCHAR(255) NULL,
  resultLabelFr2 VARCHAR(255) NULL,
  resultLabelEn3 VARCHAR(255) NULL,
  resultLabelFr3 VARCHAR(255) NULL,
  resultLabelEn4 VARCHAR(255) NULL,
  resultLabelFr4 VARCHAR(255) NULL,
  version0 tinyint unsigned NULL,
  version1 tinyint unsigned NULL,
  resultLabelEn5 VARCHAR(255) NULL,
  resultLabelEn6 VARCHAR(255) NULL,
  resultLabelFr5 VARCHAR(255) NULL,
  resultLabelFr6 VARCHAR(255) NULL,
  pedResultLabelEn1 VARCHAR(255) NULL,
  pedResultLabelFr1 VARCHAR(255) NULL,
  pedResultLabelEn2 VARCHAR(255) NULL,
  pedResultLabelFr2 VARCHAR(255) NULL,
  pedResultLabelEn3 VARCHAR(255) NULL,
  pedResultLabelFr3 VARCHAR(255) NULL,
  pedResultLabelEn4 VARCHAR(255) NULL,
  pedResultLabelFr4 VARCHAR(255) NULL,
  pedResultLabelEn5 VARCHAR(255) NULL,
  pedResultLabelFr5 VARCHAR(255) NULL,
  pedResultLabelEn6 VARCHAR(255) NULL,
  pedResultLabelFr6 VARCHAR(255) NULL,
  pedResultLabelEn7 VARCHAR(255) NULL,
  pedResultLabelFr7 VARCHAR(255) NULL,
  pedResultType tinyint unsigned NULL,
  labGroup VARCHAR(255) NULL,
  sectionOrder int unsigned NULL,
  panelName VARCHAR(255) NULL,
  panelOrder int unsigned NULL,
  testOrder int unsigned NULL,
  sampleType VARCHAR(255) NULL,
  loincCode VARCHAR(255) NULL,
  validRangeMin VARCHAR(255) NULL,
  validRangeMax VARCHAR(255) NULL,
  referenceRange VARCHAR(255) NULL,
  units varchar(255) null,
  externalResultType VARCHAR(255) NULL,
  status tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1:iSante lab (default), 2:external lab, 255:deprecated (kept for compatibility)',
  PRIMARY KEY (labID)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS labMessageStorage;
CREATE TABLE labMessageStorage (
  `labMessageStorage_id` int(10) unsigned NOT NULL auto_increment,
  `dbSite` tinyint unsigned not null,
  `senderName` varchar(255) default NULL,
  `senderSiteCode` mediumint(8) default NULL,
  `receiptDateTime` datetime NOT NULL,
  `originalXmitDateTime` datetime NOT NULL,
  `message` mediumblob,
  PRIMARY KEY  (`labMessageStorage_id`, `dbSite`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS labs;
CREATE TABLE labs (
  labs_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  labID int unsigned NOT NULL,
  result VARCHAR(255) NULL,
  result2 VARCHAR(255) NULL,
  units VARCHAR(255) NULL,
  resultDateDd CHAR(2) NULL,
  resultDateMm CHAR(2) NULL,
  resultDateYy CHAR(2) NULL,
  seqNum tinyint unsigned NULL DEFAULT 0,
  ordered tinyint unsigned NULL DEFAULT 0,
  resultAbnormal tinyint unsigned NULL,
  resultRemarks VARCHAR(1000) NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  result3 VARCHAR(255) NULL,
  result4 VARCHAR(255) NULL,
  accessionNumber VARCHAR(255) NULL,
  sendingSiteName VARCHAR(255) NOT NULL DEFAULT 'iSanté',
  sendingSiteID mediumint unsigned NULL,
  labGroup VARCHAR(255) NULL,
  sectionOrder int unsigned NULL,
  panelName VARCHAR(255) NULL,
  panelOrder int unsigned NULL,
  testNameFr VARCHAR(255) NULL,
  testNameEn VARCHAR(255) NULL,
  testOrder int unsigned NULL,
  sampleType VARCHAR(255) NULL,
  loincCode VARCHAR(255) NULL,
  externalResultType VARCHAR(255) NULL,
  `minValue` VARCHAR(255) NULL,
  `maxValue` VARCHAR(255) NULL,
  validRangeMin VARCHAR(255) NULL,
  validRangeMax VARCHAR(255) NULL,
  referenceRange VARCHAR(255) NULL,
  resultTimestamp TIMESTAMP NULL,
  resultStatus TINYINT UNSIGNED NOT NULL DEFAULT 0,
  supersededDate TIMESTAMP NULL,
  labMessageStorage_id INT UNSIGNED NULL,
  labMessageStorage_seq INT UNSIGNED NULL,
  PRIMARY KEY (labs_id, dbSite), 
  INDEX labs3 (patientID),
  UNIQUE INDEX labsINDEX (siteCode, patientID, visitDateDd, visitDateMm, visitDateYy, labID, seqNum, labs_id)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS maxPatientID;
CREATE TABLE maxPatientID (
  patientID int unsigned NULL
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS medicalEligARVs;
CREATE TABLE medicalEligARVs (
  medicalEligARVs_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NOT NULL,
  currentHivStage tinyint unsigned NULL,
  CD4 VARCHAR(16) NULL,
  cellsPmm VARCHAR(16) NULL,
  CD4DateMM CHAR(2) NULL,
  CD4DateYY CHAR(2) NULL,
  TLC VARCHAR(16) NULL,
  TLCDateMM CHAR(2) NULL,
  TLCDateYY CHAR(2) NULL,
  ViralLoad VARCHAR(16) NULL,
  ViralLoadMM CHAR(2) NULL,
  ViralLoadYY CHAR(2) NULL,
  medElig tinyint unsigned NULL,
  cd4LT200 tinyint unsigned NULL,
  WHOIII tinyint unsigned NULL,
  PMTCT tinyint unsigned NULL,
  tlcLT1200 tinyint unsigned NULL,
  WHOIV tinyint unsigned NULL,
  medEligHAART tinyint unsigned NULL,
  ChildLT5ans tinyint(3) unsigned default NULL COMMENT 'add for arv eligibility reason',
  coinfectionTbHiv tinyint(3) unsigned default NULL COMMENT 'add for arv eligibility reason',
  coinfectionHbvHiv tinyint(3) unsigned default NULL COMMENT 'add for arv eligibility reason',
  coupleSerodiscordant tinyint(3) unsigned default NULL COMMENT 'add for arv eligibility reason',
  pregnantWomen tinyint(3) unsigned default NULL COMMENT 'add for arv eligibility reason',
  breastfeedingWomen tinyint(3) unsigned default NULL COMMENT 'add for arv eligibility reason',
  patientGt50ans tinyint(3) unsigned default NULL COMMENT 'add for arv eligibility reason',
  nephropathieVih tinyint(3) default NULL COMMENT 'for eligibility reason ',
  protocoleTestTraitement tinyint(3) default NULL COMMENT 'for eligibility reason ',
  CD4DateDD CHAR(2) NULL,
  TLCDateDD CHAR(2) NULL,
  ViralLoadDD CHAR(2) NULL,
  commAuthEnroll tinyint unsigned NULL,
  commAuthEnrollDD CHAR(2) NULL,
  commAuthEnrollMM CHAR(2) NULL,
  commAuthEnrollYY CHAR(2) NULL,
  commDelayEnroll tinyint unsigned NULL,
  commDelayEnrollDD CHAR(2) NULL,
  commDelayEnrollMM CHAR(2) NULL,
  commDelayEnrollYY CHAR(2) NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  formerARVtherapy tinyint unsigned NULL,
  PEP tinyint unsigned NULL,
  expFromDt CHAR(2) NULL,
  expFromMm CHAR(2) NULL,
  expFromYy CHAR(2) NULL,
  pedMedEligCd4Cnt tinyint unsigned NULL,
  pedMedEligWho3 tinyint unsigned NULL,
  pedMedEligWho4 tinyint unsigned NULL,
  pedMedEligTlc tinyint unsigned NULL,
  pedMedEligPmtct tinyint unsigned NULL,
  pedMedEligFormerTherapy tinyint unsigned NULL,
  PRIMARY KEY (medicalEligARVs_id, dbSite),
  UNIQUE INDEX medicalEligARVsINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS nastadLookup;
CREATE TABLE nastadLookup (
  DescriptionEnglish VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  DescriptionFrench VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  Fieldname VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  Dataelement SMALLINT(5) NULL
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS nastadTable;
CREATE TABLE nastadTable (
  nastadTable_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientid VARCHAR(11) NOT NULL,
  visitdate DATETIME NULL,
  dataElement int unsigned NOT NULL,
  value VARCHAR(255) NULL,
  PRIMARY KEY (nastadTable_id)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS needsAssessment;
CREATE TABLE needsAssessment (
  needsAssessment_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NULL,
  patientID VARCHAR(11) NULL,
  visitDateDd CHAR(2) NULL,
  visitDateMm CHAR(2) NULL,
  visitDateYy CHAR(2) NULL,
  seqNum tinyint unsigned NULL,
  needsAssLimitUnderStatus tinyint unsigned NULL,
  needsAssLimitUnderSvcs tinyint unsigned NULL,
  needsAssLimitUnderDel tinyint unsigned NULL,
  needsAssLimitUnderRef tinyint unsigned NULL,
  needsAssLimitUnderUn tinyint unsigned NULL,
  needsAssDenialStatus tinyint unsigned NULL,
  needsAssDenialSvcs tinyint unsigned NULL,
  needsAssDenialDel tinyint unsigned NULL,
  needsAssDenialRef tinyint unsigned NULL,
  needsAssDenialUn tinyint unsigned NULL,
  needsAssOngRiskStatus tinyint unsigned NULL,
  needsAssOngRiskSvcs tinyint unsigned NULL,
  needsAssOngRiskDel tinyint unsigned NULL,
  needsAssOngRiskRef tinyint unsigned NULL,
  needsAssOngRiskUn tinyint unsigned NULL,
  needsAssBarrHomeStatus tinyint unsigned NULL,
  needsAssBarrHomeSvcs tinyint unsigned NULL,
  needsAssBarrHomeDel tinyint unsigned NULL,
  needsAssBarrHomeRef tinyint unsigned NULL,
  needsAssBarrHomeUn tinyint unsigned NULL,
  needsAssMentHealStatus tinyint unsigned NULL,
  needsAssMentHealSvcs tinyint unsigned NULL,
  needsAssMentHealDel tinyint unsigned NULL,
  needsAssMentHealRef tinyint unsigned NULL,
  needsAssMentHealUn tinyint unsigned NULL,
  needsAssSevDeprStatus tinyint unsigned NULL,
  needsAssSevDeprSvcs tinyint unsigned NULL,
  needsAssSevDeprDel tinyint unsigned NULL,
  needsAssSevDeprRef tinyint unsigned NULL,
  needsAssSevDeprUn tinyint unsigned NULL,
  needsAssPregStatus tinyint unsigned NULL,
  needsAssPregSvcs tinyint unsigned NULL,
  needsAssPregDel tinyint unsigned NULL,
  needsAssPregRef tinyint unsigned NULL,
  needsAssPregUn tinyint unsigned NULL,
  needsAssDrugsStatus tinyint unsigned NULL,
  needsAssDrugsSvcs tinyint unsigned NULL,
  needsAssDrugsDel tinyint unsigned NULL,
  needsAssDrugsRef tinyint unsigned NULL,
  needsAssDrugsUn tinyint unsigned NULL,
  needsAssViolStatus tinyint unsigned NULL,
  needsAssViolSvcs tinyint unsigned NULL,
  needsAssViolDel tinyint unsigned NULL,
  needsAssViolRef tinyint unsigned NULL,
  needsAssViolUn tinyint unsigned NULL,
  needsAssFamPlanStatus tinyint unsigned NULL,
  needsAssFamPlanSvcs tinyint unsigned NULL,
  needsAssFamPlanDel tinyint unsigned NULL,
  needsAssFamPlanRef tinyint unsigned NULL,
  needsAssFamPlanUn tinyint unsigned NULL,
  needsAssTransStatus tinyint unsigned NULL,
  needsAssTransSvcs tinyint unsigned NULL,
  needsAssTransDel tinyint unsigned NULL,
  needsAssTransRef tinyint unsigned NULL,
  needsAssTransUn tinyint unsigned NULL,
  needsAssHousingStatus tinyint unsigned NULL,
  needsAssHousingSvcs tinyint unsigned NULL,
  needsAssHousingDel tinyint unsigned NULL,
  needsAssHousingRef tinyint unsigned NULL,
  needsAssHousingUn tinyint unsigned NULL,
  needsAssNutrStatus tinyint unsigned NULL,
  needsAssNutrSvcs tinyint unsigned NULL,
  needsAssNutrDel tinyint unsigned NULL,
  needsAssNutrRef tinyint unsigned NULL,
  needsAssNutrUn tinyint unsigned NULL,
  needsAssHygStatus tinyint unsigned NULL,
  needsAssHygSvcs tinyint unsigned NULL,
  needsAssHygDel tinyint unsigned NULL,
  needsAssHygRef tinyint unsigned NULL,
  needsAssHygUn tinyint unsigned NULL,
  needsAssOtherText VARCHAR(255) NULL,
  needsAssOtherStatus tinyint unsigned NULL,
  needsAssOtherSvcs tinyint unsigned NULL,
  needsAssOtherSvcsText VARCHAR(255) NULL,
  needsAssOtherDel tinyint unsigned NULL,
  needsAssOtherRef tinyint unsigned NULL,
  needsAssOtherUn tinyint unsigned NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (needsAssessment_id, dbSite),
  UNIQUE INDEX needsAssessmentINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS networkLookup;
CREATE TABLE networkLookup (
  institution VARCHAR(100) NULL,
  networkName VARCHAR(100) NULL,
  departement VARCHAR(100) NULL
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS otherDrugs;
CREATE TABLE otherDrugs (
  otherDrugs_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NOT NULL DEFAULT 0,
  drugName VARCHAR(255) NULL,
  standardDosage tinyint unsigned NULL DEFAULT '0',
  stdDosageDescription VARCHAR(255) NULL,
  alternativeDosage tinyint unsigned NULL DEFAULT '0',
  altDosageDescription VARCHAR(255) NULL,
  startMm CHAR(2) NULL,
  startYy CHAR(2) NULL,
  isContinued tinyint unsigned NULL DEFAULT 0,
  stopMm CHAR(2) NULL,
  stopYy CHAR(2) NULL,
  toxicity tinyint unsigned NULL DEFAULT 0,
  intolerance tinyint unsigned NULL DEFAULT 0,
  failure tinyint unsigned NULL DEFAULT 0,
  stockOut tinyint unsigned NULL DEFAULT 0,
  pregnancy tinyint unsigned NULL DEFAULT 0,
  patientHospitalized tinyint unsigned NULL DEFAULT 0,
  lackMoney tinyint unsigned NULL DEFAULT 0,
  alternativeTreatments tinyint unsigned NULL DEFAULT 0,
  missedVisit tinyint unsigned NULL DEFAULT 0,
  patientPreference tinyint unsigned NULL DEFAULT 0,
  reasonComments VARCHAR(255) NULL,
  discUnknown tinyint unsigned NULL,
  drugSlot tinyint unsigned NULL,
  failureVir tinyint unsigned NULL,
  failureImm tinyint unsigned NULL,
  failureClin tinyint unsigned NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  prophDose tinyint unsigned NULL,
  failureProph tinyint unsigned NULL,
  interUnk tinyint unsigned NULL, 
  finPTME tinyint unsigned NULL,
  PRIMARY KEY (otherDrugs_id, dbSite),
  UNIQUE INDEX otherDrugsINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, drugName, drugSlot, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS otherLabs;
CREATE TABLE otherLabs (
  otherLabs_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NULL,
  patientID VARCHAR(11) NULL DEFAULT 0,
  visitDateDd CHAR(2) NULL,
  visitDateMm CHAR(2) NULL,
  visitDateYy CHAR(2) NULL,
  seqNum tinyint unsigned NULL DEFAULT 0,
  labName VARCHAR(255) NULL,
  result VARCHAR(255) NULL,
  result2 VARCHAR(255) NULL,
  units VARCHAR(255) NULL,
  resultDateDd CHAR(2) NULL,
  resultDateMm CHAR(2) NULL,
  resultDateYy CHAR(2) NULL,
  ordered tinyint unsigned NULL DEFAULT 0,
  resultAbnormal tinyint unsigned NULL,
  labSlot tinyint unsigned NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  accessionNumber VARCHAR(255) NULL,
  sendingSiteName VARCHAR(255) NULL default 'iSanté',
  sendingSiteID mediumint unsigned NULL,
  labGroup VARCHAR(255) NULL,
  sectionOrder int unsigned NULL,
  panelName VARCHAR(255) NULL,
  panelOrder int unsigned NULL,
  testOrder int unsigned NULL,
  sampleType VARCHAR(255) NULL,
  loincCode VARCHAR(255) NULL,
  externalResultType VARCHAR(255) NULL,
  `minValue` VARCHAR(255) NULL,
  `maxValue` VARCHAR(255) NULL,
  validRangeMin VARCHAR(255) NULL,
  validRangeMax VARCHAR(255) NULL,
  referenceRange VARCHAR(255) NULL,
  resultTimestamp TIMESTAMP NULL,
  resultRemarks VARCHAR(1000) NULL, 
  labMessageStorage_id INT UNSIGNED NULL,
  labMessageStorage_seq INT UNSIGNED NULL,
  PRIMARY KEY (otherLabs_id, dbSite),
  UNIQUE INDEX otherLabsINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, labName, labSlot, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS otherPrescriptions;
CREATE TABLE otherPrescriptions (
  otherPrescriptions_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  drug VARCHAR(255) NULL,
  stdDosage tinyint unsigned NULL,
  altDosage tinyint unsigned NULL,
  altDosageSpecify VARCHAR(50) NULL,
  numDays tinyint unsigned NULL,
  numDaysDesc CHAR(10) NULL,
  dispensed tinyint unsigned NULL,
  dispAltDosage tinyint unsigned NULL,
  dispAltDosageSpecify VARCHAR(50) NULL,
  dispAltNumDays tinyint unsigned NULL,
  dispAltNumDaysSpecify VARCHAR(255) NULL,
  stdDosageSpecify VARCHAR(255) NULL,
  seqNum tinyint unsigned NULL DEFAULT 0,
  rxSlot tinyint unsigned NULL,
  dispDateDd CHAR(2) NULL,
  dispDateMm CHAR(2) NULL,
  dispDateYy CHAR(2) NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  pedPresentationDesc VARCHAR(255) NULL,
  pedDosageDesc VARCHAR(255) NULL,
  dispAltNumPills VARCHAR(255) NULL,
  PRIMARY KEY (otherPrescriptions_id, dbSite),
  UNIQUE INDEX otherPrescriptionsINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, drug, rxSlot, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS patient;
CREATE TABLE patient (
  location_id int unsigned NOT NULL default '0',
  person_id int unsigned NOT NULL auto_increment,
  patientID varchar(11) default NULL,
  nationalID varchar(255) character set utf8 default NULL,
  lname varchar(255) character set utf8 default NULL,
  fname varchar(255) character set utf8 default NULL,
  sex tinyint unsigned default NULL,
  addrDistrict varchar(255) character set utf8 default NULL,
  addrSection varchar(255) character set utf8 default NULL,
  addrTown varchar(255) character set utf8 default NULL,
  birthDistrict varchar(255) character set utf8 default NULL,
  birthSection varchar(255) character set utf8 default NULL,
  birthTown varchar(255) character set utf8 default NULL,
  dobDd char(2) character set utf8 default NULL,
  dobMm char(2) character set utf8 default NULL,
  dobYy char(4) character set utf8 default NULL,
  ageYears varchar(16) character set utf8 default NULL,
  fnameMother varchar(255) character set utf8 default NULL,
  occupation varchar(255) character set utf8 default NULL,
  maritalStatus tinyint(3) default NULL,
  contact varchar(255) character set utf8 default NULL,
  addrContact varchar(255) character set utf8 default NULL,
  phoneContact varchar(255) character set utf8 default NULL,
  homeDirections longtext character set utf8,
  telephone varchar(255) character set utf8 default NULL,
  patStatus tinyint unsigned NULL default '0',
  stid float default '0',
  isPediatric tinyint unsigned default NULL,
  fnameFather varchar(255) character set utf8 default NULL,
  relationContact varchar(255) character set utf8 default NULL,
  addrContactSection varchar(255) character set utf8 default NULL,
  addrContactTown varchar(255) character set utf8 default NULL,
  medicalPoa varchar(255) character set utf8 default NULL,
  relationMedicalPoa varchar(255) character set utf8 default NULL,
  addrMedicalPoa varchar(255) character set utf8 default NULL,
  phoneMedicalPoa varchar(255) character set utf8 default NULL,
  addrMedicalPoaSection varchar(255) character set utf8 default NULL,
  addrMedicalPoaTown varchar(255) character set utf8 default NULL,
  patientStatus int unsigned default NULL,
  clinicPatientID varchar(255) default NULL,
  patGuid varchar(36) NULL,
  hivPositive tinyint unsigned NULL,
  masterPid varchar(11) null,
  deathDt datetime null,
  PRIMARY KEY  (person_id, location_id),
  INDEX patientIDIndex (patientID)
) ENGINE=INNODB 
CHARACTER SET utf8 COLLATE utf8_general_ci 
AUTO_INCREMENT=1;


DROP TABLE IF EXISTS patientEducation;
CREATE TABLE patientEducation (
  patientEducation_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NOT NULL DEFAULT 0,
  supportDiscPartner tinyint unsigned NULL DEFAULT 0,
  supportDiscParent tinyint unsigned NULL DEFAULT 0,
  supportDiscChild tinyint unsigned NULL DEFAULT 0,
  supportDiscFriend tinyint unsigned NULL DEFAULT 0,
  supportDiscOther tinyint unsigned NULL DEFAULT 0,
  supportDiscNobody tinyint unsigned NULL DEFAULT 0,
  supportLevel tinyint unsigned NULL DEFAULT 0,
  supportServPatho tinyint unsigned NULL DEFAULT 0,
  supportServPrev tinyint unsigned NULL DEFAULT 0,
  supportServCoun tinyint unsigned NULL DEFAULT 0,
  supportServGroup tinyint unsigned NULL DEFAULT 0,
  supportServArvEduc tinyint unsigned NULL DEFAULT 0,
  supportServPreAdher tinyint unsigned NULL DEFAULT 0,
  supportServOngAdher tinyint unsigned NULL DEFAULT 0,
  supportServNutr tinyint unsigned NULL DEFAULT 0,
  supportServTransport tinyint unsigned NULL DEFAULT 0,
  supportOtherCounsel LONGTEXT NULL,
  supportServOther tinyint unsigned NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (patientEducation_id, dbSite),
  UNIQUE INDEX patientEducationINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS patientStatusLookup;
CREATE TABLE patientStatusLookup (
  statusValue tinyint unsigned NOT NULL,
  statusDescEn VARCHAR(255) NOT NULL,
  statusDescFr VARCHAR(255) NOT NULL,
  reportOrder tinyint unsigned NULL
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS patientStatusTemp;
create table patientStatusTemp (
  patientID varchar(11),
  patientStatus int,
  endDate date NOT NULL,
  insertDate timestamp,
  INDEX patientStatusTempIndex (endDate, patientID)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS pedHistory;
CREATE TABLE pedHistory (
  pedHistory_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NOT NULL,
  pedChildAware tinyint unsigned NULL,
  pedParentAware tinyint unsigned NULL,
  pedMotherHistUnk tinyint unsigned NULL,
  pedMotherHistDobDd CHAR(2) NULL,
  pedMotherHistDobMm CHAR(2) NULL,
  pedMotherHistDobYy CHAR(2) NULL,
  pedMotherHistAge CHAR(2) NULL,
  pedMotherHistRecentTb tinyint unsigned NULL,
  pedMotherHistTreatTb tinyint unsigned NULL,
  pedMotherHistActiveTb tinyint unsigned NULL,
  pedMotherHistTreatTbDd CHAR(2) NULL,
  pedMotherHistTreatTbMm CHAR(2) NULL,
  pedMotherHistTreatTbYy CHAR(2) NULL,
  pedMotherHistGrosGrav CHAR(2) NULL,
  pedMotherHistGrosPara CHAR(2) NULL,
  pedMotherHistGrosAbor CHAR(2) NULL,
  pedMotherHistGrosViva CHAR(2) NULL,
  pedMotherHistGrosDeadAge1 CHAR(2) NULL,
  pedMotherHistGrosDeadCause1 VARCHAR(255) NULL,
  pedMotherHistGrosDeadUnk1 tinyint unsigned NULL,
  pedMotherHistGrosDeadAge2 CHAR(2) NULL,
  pedMotherHistGrosDeadCause2 VARCHAR(255) NULL,
  pedMotherHistGrosDeadUnk2 tinyint unsigned NULL,
  pedMotherHistGrosDeadAge3 CHAR(2) NULL,
  pedMotherHistGrosDeadCause3 VARCHAR(255) NULL,
  pedMotherHistGrosDeadUnk3 tinyint unsigned NULL,
  pedMotherHistGrosIst tinyint unsigned NULL,
  pedMotherHistGrosIstTri tinyint unsigned NULL,
  pedMotherHistGrosPreCare tinyint unsigned NULL,
  pedMotherHistGrosPreCareSite VARCHAR(64) NULL,
  pedMotherHistGrosPreCareNum VARCHAR(64) NULL,
  pedMotherHistGrosMeth tinyint unsigned NULL,
  pedMotherHistGrosWhere tinyint unsigned NULL,
  pedMotherHistGrosWhereHosp VARCHAR(64) NULL,
  pedMotherHistGrosWhereOther VARCHAR(64) NULL,
  pedMotherHistHivStat tinyint unsigned NULL,
  pedMotherHistHivPmtct tinyint unsigned NULL,
  pedMotherHistHivPmtctWhere VARCHAR(64) NULL,
  pedMotherHistHivArvPreg tinyint unsigned NULL,
  pedMotherHistHivArvPregStartDd CHAR(2) NULL,
  pedMotherHistHivArvPregStartMm CHAR(2) NULL,
  pedMotherHistHivArvPregStartYy CHAR(2) NULL,
  pedMotherHistHivArvPregStopDd CHAR(2) NULL,
  pedMotherHistHivArvPregStopMm CHAR(2) NULL,
  pedMotherHistHivArvPregStopYy CHAR(2) NULL,
  pedMotherHistHivHaartPreg tinyint unsigned NULL,
  pedMotherHistHivHaartPregStDd CHAR(2) NULL,
  pedMotherHistHivHaartPregStMm CHAR(2) NULL,
  pedMotherHistHivHaartPregStYy CHAR(2) NULL,
  pedMotherHistHivHaartPregSpDd CHAR(2) NULL,
  pedMotherHistHivHaartPregSpMm CHAR(2) NULL,
  pedMotherHistHivHaartPregSpYy CHAR(2) NULL,
  pedMotherHistHivArvDel tinyint unsigned NULL,
  pedMotherHistHivReg VARCHAR(255) NULL,
  pedFratHistUnk tinyint unsigned NULL,
  pedFratHistRecentTb tinyint unsigned NULL,
  pedFratHistTreatTb tinyint unsigned NULL,
  pedFratHistActiveTb tinyint unsigned NULL,
  pedFratHistTreatTbDd CHAR(2) NULL,
  pedFratHistTreatTbMm CHAR(2) NULL,
  pedFratHistTreatTbYy CHAR(2) NULL,
  pedFratHistHivStat tinyint unsigned NULL,
  pedFratHistHivStatFrat tinyint unsigned NULL,
  pedFratHistHivStatNumNeg CHAR(2) NULL,
  pedFratHistHivStatNumPos CHAR(2) NULL,
  pedFratHistHivStatNumUnk CHAR(2) NULL,
  pedFratHistHivStatNumDead CHAR(2) NULL,
  pedInfProArv tinyint unsigned NULL,
  pedInfProPcp tinyint unsigned NULL,
  pedInfProMac tinyint unsigned NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (pedHistory_id, dbSite),
  UNIQUE INDEX pedHistoryINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, siteCode) 
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS pedLabs;
CREATE TABLE pedLabs (
  pedLabs_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NOT NULL,
  pedLabsID int unsigned NULL,
  pedLabsOrdered tinyint unsigned NULL,
  pedLabsResult int unsigned NULL,
  pedLabsResultOrder int unsigned NULL,
  pedLabsResultAge CHAR(2) NULL,
  pedLabsResultAgeUnits tinyint unsigned NULL,
  pedLabsSlot tinyint unsigned NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (pedLabs_id, dbSite),
  UNIQUE INDEX pedLabsINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, pedLabsID, pedLabsSlot, siteCode)

)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS pedLabsLookup;
CREATE TABLE pedLabsLookup (
  pedLabsLookup_id int unsigned NOT NULL AUTO_INCREMENT,
  pedLabsID int unsigned NULL,
  pedLabsCode VARCHAR(20) NULL,
  pedLabsNameEn VARCHAR(255) NULL,
  pedLabsNameFr VARCHAR(255) NULL,
  PRIMARY KEY (pedLabsLookup_id),
  UNIQUE INDEX pedLabsLookupINDEX (pedLabsID)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS pedLabsRendering;
CREATE TABLE pedLabsRendering (
  pedLabsRendering_id int unsigned NOT NULL AUTO_INCREMENT,
  pedLabsID int unsigned NULL,
  pedLabsEncounterType tinyint unsigned NULL,
  pedLabsFormVersion tinyint unsigned NULL,
  pedLabsGroup int unsigned NULL,
  pedLabsOrderEn int unsigned NULL,
  pedLabsOrderFr int unsigned NULL,
  pedLabsCnt tinyint unsigned NULL,
  PRIMARY KEY (pedLabsRendering_id),
  UNIQUE INDEX (pedLabsID, pedLabsEncounterType)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS pepfarRecords;
CREATE TABLE pepfarRecords (
  id int unsigned NULL,
  recType int unsigned NULL,
  col1 VARCHAR(300) NULL,
  col2 VARCHAR(300) NULL,
  col3 VARCHAR(300) NULL,
  col4 VARCHAR(300) NULL
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS pepfarTable;
CREATE TABLE pepfarTable (
  siteCode mediumint unsigned NULL,
  patientid VARCHAR(11) NULL,
  visitDate DATETIME NULL,
  regimen VARCHAR(25) NULL,
  forPepPmtct tinyint unsigned NULL,
  INDEX pepfarTable22 (patientid, visitDate)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS prescriptionOtherFields;
CREATE TABLE prescriptionOtherFields (
  prescriptionOtherFields_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NOT NULL,
  drugRemarks VARCHAR(200) NULL,
  startedArv int unsigned NULL,
  arvStartDateDd CHAR(2) NULL,
  arvStartDateMm CHAR(2) NULL,
  arvStartDateYy CHAR(2) NULL,
  dbSite tinyint unsigned NOT NULL,
  PRIMARY KEY (prescriptionOtherFields_id, dbSite),
  UNIQUE INDEX prescriptionOtherFieldsINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS prescriptions;
CREATE TABLE prescriptions (
  prescriptions_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  drugID int unsigned NOT NULL,
  stdDosage tinyint unsigned NULL,
  altDosage tinyint unsigned NULL,
  altDosageSpecify VARCHAR(255) NULL,
  numDays tinyint unsigned NULL,
  numDaysDesc CHAR(10) NULL,
  dispensed tinyint unsigned NULL,
  dispAltDosage tinyint unsigned NULL,
  dispAltDosageSpecify VARCHAR(50) NULL,
  dispAltNumDays tinyint unsigned NULL,
  stdDosageSpecify VARCHAR(255) NULL,
  dispAltNumDaysSpecify VARCHAR(255) NULL,
  seqNum tinyint unsigned NOT NULL DEFAULT 0,
  dispDateDd CHAR(2) NULL,
  dispDateMm CHAR(2) NULL,
  dispDateYy CHAR(2) NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  pedPresentationDesc VARCHAR(255) NULL,
  pedDosageDesc VARCHAR(255) NULL,
  forPepPmtct tinyint unsigned NULL,
  dispAltNumPills VARCHAR(255) NULL,
  PRIMARY KEY (prescriptions_id, dbSite),
  UNIQUE INDEX prescriptionsINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, drugID, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS referralLookup;
CREATE TABLE referralLookup (
  referralLookup_id int unsigned NOT NULL AUTO_INCREMENT,
  refName VARCHAR(255) NULL,
  refLabelFr VARCHAR(255) NULL,
  refLabelEn VARCHAR(255) NULL,
  refSequence int unsigned NULL,
  PRIMARY KEY (referralLookup_id)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS referrals;
CREATE TABLE referrals (
  referrals_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NOT NULL DEFAULT 0,
  referralChecked tinyint unsigned NULL,
  referral VARCHAR(255) NULL,
  refClinic VARCHAR(255) NULL,
  refAdateDd CHAR(2) NULL,
  refAdateMm CHAR(2) NULL,
  refAdateYy CHAR(2) NULL,
  refAkept tinyint unsigned NULL,
  refFdateDd CHAR(2) NULL,
  refFdateMm CHAR(2) NULL,
  refFdateYy CHAR(2) NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (referrals_id, dbSite),
  INDEX referralsINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS regimen;
CREATE TABLE regimen (
  regID int unsigned NOT NULL DEFAULT '0',
  regimenName VARCHAR(40) NOT NULL,
  drugID1 int unsigned NOT NULL DEFAULT '0',
  drugID2 int unsigned NOT NULL DEFAULT '0',
  drugID3 int unsigned NULL,
  charCode VARCHAR(9) NOT NULL DEFAULT '',
  shortName VARCHAR(25) NULL,
  regGroup VARCHAR(10) NULL,
  INDEX regimenIndex1 (drugID1),
  INDEX regimenIndex2 (drugID2),
  INDEX regimenIndex3 (drugID3)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS replicationRead;
CREATE TABLE replicationRead (
  replicationRead_id int unsigned NOT NULL AUTO_INCREMENT,
  targetName VARCHAR(500) NOT NULL,
  targetUrl VARCHAR(1000) NOT NULL,
  startTime DATETIME NOT NULL,
  stopTime DATETIME NOT NULL,
  dataFileName VARCHAR(500) NOT NULL,
  reportFileName VARCHAR(500) NOT NULL,
  errorFileName VARCHAR(500) NOT NULL,
  deidentified tinyint unsigned NOT NULL,
  transmitted tinyint unsigned NOT NULL,
  PRIMARY KEY (replicationRead_id)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS riskAssessment;
CREATE TABLE riskAssessment (
  riskAssessment_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NOT NULL DEFAULT 0,
  sexWithMale tinyint unsigned NULL,
  sexWithFemale tinyint unsigned NULL,
  injectionDrugs tinyint unsigned NULL,
  bloodExp tinyint unsigned NULL,
  bloodTrans tinyint unsigned NULL,
  bloodTransYear VARCHAR(16) NULL,
  verticalTransmission tinyint unsigned NULL,
  sexWithCommercialSexWorker tinyint unsigned NULL,
  sexWithoutCondom tinyint unsigned NULL,
  stdHistory tinyint unsigned NULL,
  sexAssault tinyint unsigned NULL,
  lastQuarterSex tinyint unsigned NULL,
  lastQuarterSexWithoutCondom tinyint unsigned NULL,
  lastQuarterSeroStatPart tinyint unsigned NULL,
  sharedNeedles tinyint unsigned NULL,
  sexWithIvDrugUser tinyint unsigned NULL,
  sexWithHomoBi tinyint unsigned NULL,
  sexAnal tinyint unsigned NULL,
  sexOral tinyint unsigned NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (riskAssessment_id, dbSite),
  UNIQUE INDEX riskAssessmentINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS riskAssessments;
CREATE TABLE riskAssessments (
  riskAssessments_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NULL,
  riskID int unsigned NOT NULL,
  riskAnswer tinyint unsigned NULL,
  riskDd CHAR(2) NULL,
  riskMm CHAR(2) NULL,
  riskYy CHAR(2) NULL,
  riskComment VARCHAR(200) NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (riskAssessments_id, dbSite),
  UNIQUE INDEX riskAssessmentsINDEX (siteCode, patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, riskID)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS riskLookup;
CREATE TABLE riskLookup (
  riskID int unsigned NULL,
  fieldName VARCHAR(30) NULL,
  riskDescEn VARCHAR(100) NULL,
  riskDescFr VARCHAR(100) NULL,
  answerType VARCHAR(15) NULL,
  PRIMARY KEY (riskID)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS riskOrder;
CREATE TABLE riskOrder (
  riskName VARCHAR(60) NOT NULL,
  riskOrder int unsigned NOT NULL,
  formVersion tinyint unsigned NOT NULL,
  preMarkup VARCHAR(200) NULL,
  postMarkup VARCHAR(200) NULL
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS siteAccess;
CREATE TABLE siteAccess (
 username varchar(20) NOT NULL default '',
 siteCode mediumint(5) unsigned zerofill NOT NULL default '00000',
 PRIMARY KEY (username, siteCode)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS startARV;
CREATE TABLE startARV (
  siteCode mediumint unsigned NOT NULL,
  patientid VARCHAR(11) NOT NULL,
  age VARCHAR(5) NOT NULL,
  sex tinyint unsigned NOT NULL,
  pregnant tinyint unsigned NOT NULL,
  visitdate CHAR(6) NOT NULL
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS symptoms;
CREATE TABLE symptoms (
  symptoms_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NOT NULL DEFAULT 0,
  anorexia tinyint unsigned NULL DEFAULT 0,
  weightLossLessTenPercMo tinyint unsigned NULL DEFAULT 0,
  weightLossPlusTenPercMo tinyint unsigned NULL DEFAULT 0,
  diarrheaLessMo tinyint unsigned NULL DEFAULT 0,
  diarrheaPlusMo tinyint unsigned NULL DEFAULT 0,
  chronicWeakness tinyint unsigned NULL DEFAULT 0,
  feverLessMo tinyint unsigned NULL DEFAULT 0,
  feverPlusMo tinyint unsigned NULL DEFAULT 0,
  wtLossTenPercWithDiarrMo tinyint unsigned NULL DEFAULT 0,
  nightSweats tinyint unsigned NULL DEFAULT 0,
  lymphadenopathies tinyint unsigned NULL DEFAULT 0,
  prurigo tinyint unsigned NULL DEFAULT 0,
  cough tinyint unsigned NULL DEFAULT 0,
  dyspnea tinyint unsigned NULL DEFAULT 0,
  expectoration tinyint unsigned NULL DEFAULT 0,
  hemoptysie tinyint unsigned NULL DEFAULT 0,
  odynophagia tinyint unsigned NULL DEFAULT 0,
  otherSymptoms LONGTEXT NULL,
  illnessHistory LONGTEXT NULL,
  abPain tinyint unsigned NULL,
  headache tinyint unsigned NULL,
  nausea tinyint unsigned NULL,
  numbness tinyint unsigned NULL,
  sympRash tinyint unsigned NULL,
  vomiting tinyint unsigned NULL,
  sympOther tinyint unsigned NULL,
  asymptomaticWho tinyint unsigned NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  cough3WeeksLess tinyint unsigned NULL,
  cough3WeeksEqualMore tinyint unsigned NULL,
  pedSympRegurg tinyint unsigned NULL,
  pedSympAsthenia tinyint unsigned NULL,
  pedSympRashText VARCHAR(64) NULL,
  pedSympEarache tinyint unsigned NULL,
  pedSympSeizure tinyint unsigned NULL,
  pedSympInsuffWt tinyint unsigned NULL,
  pedSympCoughText VARCHAR(64) NULL,
  pedSympDiarrhea tinyint unsigned NULL,
  pedSympIrritability tinyint unsigned NULL,
  pedSympWtLoss tinyint unsigned NULL,
  pedSympLethargy tinyint unsigned NULL,
  pedSympVision tinyint unsigned NULL,
  pedSympMuscPain tinyint unsigned NULL,
  pedSympPrurigo tinyint unsigned NULL,
  pedSympWhoDiarrhea tinyint unsigned NULL,
  pedSympWhoWtLoss2 tinyint unsigned NULL,
  pedSympWhoWtLoss3 tinyint unsigned NULL,
  PRIMARY KEY (symptoms_id, dbSite),
  UNIQUE INDEX symptomsINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS tbStatus;
CREATE TABLE tbStatus (
  tbStatus_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NOT NULL DEFAULT 0,
  asymptomaticTb tinyint unsigned NULL DEFAULT 0,
  suspectedTb tinyint unsigned NULL DEFAULT 0,
  currentProp tinyint unsigned NULL DEFAULT 0,
  currentTreat tinyint unsigned NULL DEFAULT 0,
  currentTreatNo VARCHAR(64) NULL,
  currentTreatFac VARCHAR(255) NULL,
  completeTreat tinyint unsigned NULL DEFAULT 0,
  completeTreatFac VARCHAR(255) NULL,
  completeTreatMm CHAR(2) NULL,
  completeTreatYy CHAR(2) NULL,
  completeTreatDd CHAR(2) NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  presenceBCG tinyint unsigned NULL,
  suspicionTBwSymptoms tinyint unsigned NULL,
  noTBsymptoms tinyint unsigned NULL,
  recentNegPPD tinyint unsigned NULL,
  statusPPDunknown tinyint unsigned NULL,
  propINH tinyint unsigned NULL,
  debutINHMm CHAR(2) NULL,
  debutINHYy CHAR(2) NULL,
  arretINHMm CHAR(2) NULL,
  arretINHYy CHAR(2) NULL,
  pedTbEvalRecentExp tinyint unsigned NULL,
  pedCompleteTreatStartMm CHAR(2) NULL,
  pedCompleteTreatStartYy CHAR(2) NULL,
  pedTbEvalPpdRecent tinyint unsigned NULL,
  pedTbEvalPpdRecentMm CHAR(2) NULL,
  pedTbEvalPpdRecentYy CHAR(2) NULL,
  pedTbEvalPpdRecentRes CHAR(2) NULL,
  PRIMARY KEY (tbStatus_id, dbSite),
  UNIQUE INDEX tbStatusINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS tempDiscTable;
CREATE TABLE tempDiscTable (
  sitecode mediumint unsigned NULL,
  patientid VARCHAR(11) NULL,
  discDate DATETIME NULL,
  discType int unsigned NULL
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS tmpNxtDate;
CREATE TABLE tmpNxtDate (
  patientid VARCHAR(11) NULL,
  visitdate DATETIME NULL
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS userPrivilege;
CREATE TABLE userPrivilege (
 username varchar(20) NOT NULL default '',
 privLevel tinyint(3) unsigned NOT NULL default '0',
 siteCode mediumint(5) unsigned zerofill NOT NULL default '00000',
 allowTrans tinyint(3) unsigned NOT NULL default '0',
 allowValidate tinyint(3) unsigned NOT NULL default '0',
 uiConfiguration tinyint(3) unsigned NOT NULL default '0',
 debugFlag tinyint(3) unsigned NOT NULL default '0',
 network varchar(100) NULL, 
 serviceArea tinyint(3) unsigned NOT NULL default '7',
 PRIMARY KEY  (username)
) ENGINE=InnoDB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS validations;
CREATE TABLE validations (
  validations_id int unsigned NOT NULL AUTO_INCREMENT,
  fieldName VARCHAR(255) NOT NULL,
  encounterType tinyint unsigned NOT NULL,
  fieldMandatory tinyint unsigned NULL,
  fieldNonBlank tinyint unsigned NULL,
  fieldRegEx VARCHAR(255) NULL,
  fieldLowerBound FLOAT(53) NULL,
  fieldUpperBound FLOAT(53) NULL,
  fieldLinkage VARCHAR(1024) NULL,
  checkLinkageIfBlank tinyint unsigned NULL,
  lastModified DATETIME NULL,
  lastModifiedBy VARCHAR(255) NULL,
  formVersion SMALLINT(5) NULL,
  PRIMARY KEY (validations_id)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS validVitals;
CREATE TABLE validVitals (
  vitals_id int unsigned NULL,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NOT NULL,
  scheduledVisit tinyint unsigned NULL,
  vitalTemp VARCHAR(64) NULL,
  vitalBp1 VARCHAR(64) NULL,
  vitalBp2 VARCHAR(64) NULL,
  vitalHr VARCHAR(64) NULL,
  vitalRr VARCHAR(64) NULL,
  vitalHeight VARCHAR(64) NULL,
  vitalWeight VARCHAR(64) NULL,
  vitalPrevWt VARCHAR(64) NULL,
  pregnant tinyint unsigned NULL,
  pregnantLmpDd CHAR(2) NULL,
  pregnantLmpMm CHAR(2) NULL,
  pregnantLmpYy CHAR(2) NULL,
  genStat tinyint unsigned NULL,
  hospitalized tinyint unsigned NULL,
  functionalStatus tinyint unsigned NULL,
  sexInt tinyint unsigned NULL,
  sexIntWOcondom tinyint unsigned NULL,
  firstTestMm CHAR(2) NULL,
  firstTestYy CHAR(2) NULL,
  firstTestThisFac tinyint unsigned NULL,
  firstTestOtherFac tinyint unsigned NULL,
  firstTestOtherFacText VARCHAR(255) NULL,
  repeatTestMm CHAR(2) NULL,
  repeatTestYy CHAR(2) NULL,
  referSelf tinyint unsigned NULL,
  referPrivateDoc tinyint unsigned NULL,
  referHosp tinyint unsigned NULL,
  referVctCenter tinyint unsigned NULL,
  referPmtctProg tinyint unsigned NULL,
  referOutpatStd tinyint unsigned NULL,
  referOutpatTb tinyint unsigned NULL,
  referOutpatMed tinyint unsigned NULL,
  referOther tinyint unsigned NULL,
  referYouthProg tinyint unsigned NULL,
  referCommercialSexWorkerClinic tinyint unsigned NULL,
  referCommunityBasedProg tinyint unsigned NULL,
  firstCareToday tinyint unsigned NULL,
  firstCareOther tinyint unsigned NULL,
  firstCareOtherMm CHAR(2) NULL,
  firstCareOtherYy CHAR(2) NULL,
  firstCareThisFac tinyint unsigned NULL,
  firstCareOtherFac tinyint unsigned NULL,
  firstCareOtherFacText VARCHAR(255) NULL,
  medRecord tinyint unsigned NULL,
  lowestCd4Cnt VARCHAR(64) NULL,
  lowestCd4CntNotDone tinyint unsigned NULL,
  lowestCd4CntMm CHAR(2) NULL,
  lowestCd4CntYy CHAR(2) NULL,
  firstViralLoad VARCHAR(64) NULL,
  firstViralLoadNotDone tinyint unsigned NULL,
  firstViralLoadMm CHAR(2) NULL,
  firstViralLoadYy CHAR(2) NULL,
  vaccNone tinyint unsigned NULL,
  vaccPneumovaxMm CHAR(2) NULL,
  vaccPneumovaxYy CHAR(2) NULL,
  vaccHepAMm CHAR(2) NULL,
  vaccHepAYy CHAR(2) NULL,
  vaccHepBMm CHAR(2) NULL,
  vaccHepBYy CHAR(2) NULL,
  vaccTetanusMm CHAR(2) NULL,
  vaccTetanusYy CHAR(2) NULL,
  vaccInfluenzaMm CHAR(2) NULL,
  vaccInfluenzaYy CHAR(2) NULL,
  famPlan tinyint unsigned NULL,
  famPlanOtherText VARCHAR(255) NULL,
  clinicalExam LONGTEXT NULL,
  followupNotes LONGTEXT NULL,
  vaccPneumovax tinyint unsigned NULL,
  vaccHepA tinyint unsigned NULL,
  vaccHepB tinyint unsigned NULL,
  vaccTetanus tinyint unsigned NULL,
  vaccInfluenza tinyint unsigned NULL,
  famPlanMethodCondom tinyint unsigned NULL,
  famPlanMethodDmpa tinyint unsigned NULL,
  famPlanMethodOcPills tinyint unsigned NULL,
  famPlanMethodTubalLig tinyint unsigned NULL,
  famPlanOther tinyint unsigned NULL,
  noneTreatments tinyint unsigned NULL,
  aMedOther LONGTEXT NULL,
  otherStdText VARCHAR(255) NULL,
  otherInfecText VARCHAR(255) NULL,
  vitalWeightUnits tinyint unsigned NULL,
  vitalPrevWtUnits tinyint unsigned NULL,
  firstTestDd CHAR(2) NULL,
  repeatTestDd CHAR(2) NULL,
  firstCareOtherDd CHAR(2) NULL,
  transferIn tinyint unsigned NULL,
  transferOnArv tinyint unsigned NULL,
  lowestCd4CntDd CHAR(2) NULL,
  firstViralLoadDd CHAR(2) NULL,
  conditionComments LONGTEXT NULL,
  otherMentalHealthText VARCHAR(255) NULL,
  physicalDone tinyint unsigned NULL,
  physicalGeneral tinyint unsigned NULL,
  physicalSkin tinyint unsigned NULL,
  physicalOral tinyint unsigned NULL,
  physicalEarsNose tinyint unsigned NULL,
  physicalLymph tinyint unsigned NULL,
  physicalLungs tinyint unsigned NULL,
  physicalCardio tinyint unsigned NULL,
  physicalAbdomen tinyint unsigned NULL,
  physicalUro tinyint unsigned NULL,
  physicalMusculo tinyint unsigned NULL,
  physicalNeuro tinyint unsigned NULL,
  physicalOther tinyint unsigned NULL,
  treatmentComments LONGTEXT NULL,
  drugComments LONGTEXT NULL,
  assessmentPlan LONGTEXT NULL,
  vitalHeightCm VARCHAR(64) NULL,
  firstTestResultsReceived tinyint unsigned NULL,
  pregnantPrenatal tinyint unsigned NULL,
  pregnantPrenatalFirstDd CHAR(2) NULL,
  pregnantPrenatalFirstMm CHAR(2) NULL,
  pregnantPrenatalFirstYy CHAR(2) NULL,
  pregnantPrenatalLastDd CHAR(2) NULL,
  pregnantPrenatalLastMm CHAR(2) NULL,
  pregnantPrenatalLastYy CHAR(2) NULL,
  drugOtherText VARCHAR(255) NULL,
  hospitalizedText VARCHAR(255) NULL,
  dbSite tinyint unsigned NULL,
  vitalTempUnits tinyint unsigned NULL,
  papTest tinyint unsigned NULL,
  papTestDd CHAR(2) NULL,
  papTestMm CHAR(2) NULL,
  papTestYy CHAR(2) NULL,
  gravida VARCHAR(5) NULL,
  para VARCHAR(5) NULL,
  aborta VARCHAR(5) NULL,
  children VARCHAR(5) NULL,
  vitalBPUnits tinyint unsigned NULL,
  hepBdoses VARCHAR(64) NULL,
  tetDoses VARCHAR(64) NULL,
  otherVaccination VARCHAR(64) NULL,
  noDiagnosis tinyint unsigned NULL
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS vitals;
CREATE TABLE vitals (
  vitals_id int unsigned NOT NULL AUTO_INCREMENT,
  siteCode mediumint unsigned NOT NULL,
  patientID VARCHAR(11) NOT NULL,
  visitDateDd CHAR(2) NOT NULL,
  visitDateMm CHAR(2) NOT NULL,
  visitDateYy CHAR(2) NOT NULL,
  seqNum tinyint unsigned NOT NULL,
  scheduledVisit tinyint unsigned NULL,
  vitalTemp VARCHAR(64) NULL,
  vitalBp1 VARCHAR(64) NULL,
  vitalBp2 VARCHAR(64) NULL,
  vitalHr VARCHAR(64) NULL,
  vitalRr VARCHAR(64) NULL,
  vitalHeight VARCHAR(64) NULL,
  vitalWeight VARCHAR(64) NULL,
  vitalPrevWt VARCHAR(64) NULL,
  pregnant tinyint unsigned NULL,
  pregnantLmpDd CHAR(2) NULL,
  pregnantLmpMm CHAR(2) NULL,
  pregnantLmpYy CHAR(2) NULL,
  genStat tinyint unsigned NULL,
  hospitalized tinyint unsigned NULL,
  functionalStatus tinyint unsigned NULL,
  sexInt tinyint unsigned NULL,
  sexIntWOcondom tinyint unsigned NULL,
  firstTestMm CHAR(2) NULL,
  firstTestYy CHAR(2) NULL,
  firstTestThisFac tinyint unsigned NULL,
  firstTestOtherFac tinyint unsigned NULL,
  firstTestOtherFacText VARCHAR(255) NULL,
  repeatTestMm CHAR(2) NULL,
  repeatTestYy CHAR(2) NULL,
  referSelf tinyint unsigned NULL,
  referPrivateDoc tinyint unsigned NULL,
  referHosp tinyint unsigned NULL,
  referVctCenter tinyint unsigned NULL,
  referPmtctProg tinyint unsigned NULL,
  referOutpatStd tinyint unsigned NULL,
  referOutpatTb tinyint unsigned NULL,
  referOutpatMed tinyint unsigned NULL,
  referOther tinyint unsigned NULL,
  referYouthProg tinyint unsigned NULL,
  referCommercialSexWorkerClinic tinyint unsigned NULL,
  referCommunityBasedProg tinyint unsigned NULL,
  firstCareToday tinyint unsigned NULL,
  firstCareOther tinyint unsigned NULL,
  firstCareOtherMm CHAR(2) NULL,
  firstCareOtherYy CHAR(2) NULL,
  firstCareThisFac tinyint unsigned NULL,
  firstCareOtherFac tinyint unsigned NULL,
  firstCareOtherFacText VARCHAR(255) NULL,
  medRecord tinyint unsigned NULL,
  lowestCd4Cnt VARCHAR(64) NULL,
  lowestCd4CntNotDone tinyint unsigned NULL,
  lowestCd4CntMm CHAR(2) NULL,
  lowestCd4CntYy CHAR(2) NULL,
  firstViralLoad VARCHAR(64) NULL,
  firstViralLoadNotDone tinyint unsigned NULL,
  firstViralLoadMm CHAR(2) NULL,
  firstViralLoadYy CHAR(2) NULL,
  vaccNone tinyint unsigned NULL,
  vaccPneumovaxMm CHAR(2) NULL,
  vaccPneumovaxYy CHAR(2) NULL,
  vaccHepAMm CHAR(2) NULL,
  vaccHepAYy CHAR(2) NULL,
  vaccHepBMm CHAR(2) NULL,
  vaccHepBYy CHAR(2) NULL,
  vaccTetanusMm CHAR(2) NULL,
  vaccTetanusYy CHAR(2) NULL,
  vaccInfluenzaMm CHAR(2) NULL,
  vaccInfluenzaYy CHAR(2) NULL,
  famPlan tinyint unsigned NULL,
  famPlanOtherText VARCHAR(255) NULL,
  clinicalExam LONGTEXT NULL,
  followupNotes LONGTEXT NULL,
  vaccPneumovax tinyint unsigned NULL,
  vaccHepA tinyint unsigned NULL,
  vaccHepB tinyint unsigned NULL,
  vaccTetanus tinyint unsigned NULL,
  vaccInfluenza tinyint unsigned NULL,
  famPlanMethodCondom tinyint unsigned NULL,
  famPlanMethodDmpa tinyint unsigned NULL,
  famPlanMethodOcPills tinyint unsigned NULL,
  famPlanMethodTubalLig tinyint unsigned NULL,
  famPlanOther tinyint unsigned NULL,
  noneTreatments tinyint unsigned NULL,
  aMedOther LONGTEXT NULL,
  otherStdText VARCHAR(255) NULL,
  otherInfecText VARCHAR(255) NULL,
  vitalWeightUnits tinyint unsigned NULL,
  vitalPrevWtUnits tinyint unsigned NULL,
  firstTestDd CHAR(2) NULL,
  repeatTestDd CHAR(2) NULL,
  firstCareOtherDd CHAR(2) NULL,
  transferIn tinyint unsigned NULL,
  transferOnArv tinyint unsigned NULL,
  lowestCd4CntDd CHAR(2) NULL,
  firstViralLoadDd CHAR(2) NULL,
  conditionComments LONGTEXT NULL,
  otherMentalHealthText VARCHAR(255) NULL,
  physicalDone tinyint unsigned NULL,
  physicalGeneral tinyint unsigned NULL,
  physicalSkin tinyint unsigned NULL,
  physicalOral tinyint unsigned NULL,
  physicalEarsNose tinyint unsigned NULL,
  physicalLymph tinyint unsigned NULL,
  physicalLungs tinyint unsigned NULL,
  physicalCardio tinyint unsigned NULL,
  physicalAbdomen tinyint unsigned NULL,
  physicalUro tinyint unsigned NULL,
  physicalMusculo tinyint unsigned NULL,
  physicalNeuro tinyint unsigned NULL,
  physicalOther tinyint unsigned NULL,
  treatmentComments LONGTEXT NULL,
  drugComments LONGTEXT NULL,
  assessmentPlan LONGTEXT NULL,
  vitalHeightCm VARCHAR(64) NULL,
  firstTestResultsReceived tinyint unsigned NULL,
  pregnantPrenatal tinyint unsigned NULL,
  pregnantPrenatalFirstDd CHAR(2) NULL,
  pregnantPrenatalFirstMm CHAR(2) NULL,
  pregnantPrenatalFirstYy CHAR(2) NULL,
  pregnantPrenatalLastDd CHAR(2) NULL,
  pregnantPrenatalLastMm CHAR(2) NULL,
  pregnantPrenatalLastYy CHAR(2) NULL,
  drugOtherText VARCHAR(255) NULL,
  hospitalizedText VARCHAR(255) NULL,
  dbSite tinyint unsigned NOT NULL DEFAULT 0,
  vitalTempUnits tinyint unsigned NULL,
  papTest tinyint unsigned NULL,
  papTestDd CHAR(2) NULL,
  papTestMm CHAR(2) NULL,
  papTestYy CHAR(2) NULL,
  gravida VARCHAR(5) NULL,
  para VARCHAR(5) NULL,
  aborta VARCHAR(5) NULL,
  children VARCHAR(5) NULL,
  vitalBPUnits tinyint unsigned NULL,
  hepBdoses VARCHAR(64) NULL,
  tetDoses VARCHAR(64) NULL,
  otherVaccination VARCHAR(64) NULL,
  noDiagnosis tinyint unsigned NULL,
  pedCd4CntPerc CHAR(2) NULL,
  pedReproHealthMenses tinyint unsigned NULL,
  pedPapTestRes tinyint unsigned NULL,
  pedFeedBreast tinyint unsigned NULL,
  pedFeedBreastAge CHAR(2) NULL,
  pedFeedFormula tinyint unsigned NULL,
  pedFeedFormulaAge CHAR(2) NULL,
  pedFeedMixed tinyint unsigned NULL,
  pedFeedMixedAge CHAR(2) NULL,
  pedFeedOther tinyint unsigned NULL,
  pedFeedOtherAge CHAR(2) NULL,
  pedFeedMixedType VARCHAR(255) NULL,
  pedFeedOtherType VARCHAR(255) NULL,
  pedVitBirWt VARCHAR(64) NULL,
  pedVitBirWtUnits tinyint unsigned NULL,
  pedVitBirLen CHAR(2) NULL,
  pedVitBirPc VARCHAR(64) NULL,
  pedVitBirGest CHAR(2) NULL,
  pedVitCurPt2 CHAR(2) NULL,
  pedVitCurHeadCirc VARCHAR(64) NULL,
  pedVitCurCircCirc VARCHAR(64) NULL,
  pedVitCurBracCirc VARCHAR(64) NULL,
  pedVitCurOxySat VARCHAR(3) NULL,
  pedExamEyes tinyint unsigned NULL,
  pedExamHeadNeck tinyint unsigned NULL,
  pedExamLimbs tinyint unsigned NULL,
  pedExamBreast tinyint unsigned NULL,
  pedPsychoMotorGross tinyint unsigned NULL,
  pedPsychoMotorFine tinyint unsigned NULL,
  pedPsychoMotorLang tinyint unsigned NULL,
  pedPsychoMotorSocial tinyint unsigned NULL,
  pedCurrHiv tinyint unsigned NULL,
  pedCurrHivProb tinyint unsigned NULL,
  pedMedAllerg tinyint unsigned NULL,
  pedFoodAllerg tinyint unsigned NULL,
  pedFoodAllergText VARCHAR(255) NULL,
  pedOtherAllerg tinyint unsigned NULL,
  pedMedAllergMeds tinyint unsigned NULL,
  pedImmVacc tinyint unsigned NULL,
  pedVitCurWtLast VARCHAR(64) NULL,
  pedVitCurWtLastUnits tinyint unsigned NULL,
  pregnancyDesired TINYINT NULL, 
  familyPlanningDesired TINYINT NULL,
  physicalEyes TINYINT NULL, 
  PRIMARY KEY (vitals_id, dbSite),
  INDEX vitals21 (patientID, dbSite),
  INDEX pregIndex (siteCode, pregnant),
  UNIQUE INDEX vitalsINDEX (patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, siteCode)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS eventLog;
CREATE TABLE eventLog (
  eventLog_id int unsigned  NOT NULL AUTO_INCREMENT,
  dbSite tinyint unsigned NOT NULL,
  siteCode mediumint unsigned NOT NULL ,
  username varchar (20) NOT NULL ,
  eventDate datetime NOT NULL,
  eventType varchar (20) NOT NULL,
  eventParameters text NOT NULL,
  primary key (eventLog_id, siteCode, username, eventDate)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS eligibility;
CREATE TABLE eligibility (
  eligibility_id int unsigned NOT NULL AUTO_INCREMENT,
  patientid varchar (11), 
  reason varchar(30), 
  visitDate datetime, 
  encounter_id int unsigned, 
  encountertype int, 
  formVersion int,
  criteriaVersion tinyint unsigned null,
  primary key (eligibility_id),
  INDEX eligibilityINDEX (patientid, reason, encounter_id)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS healthQual;
CREATE TABLE healthQual (
  lastRun DATETIME,
  startDate DATETIME,
  endDate DATETIME,
  siteCode mediumint unsigned NULL,
  casesM mediumint unsigned NULL,
  casesF mediumint unsigned NULL,
  ind01_num_m mediumint unsigned NULL,
  ind01_num_f mediumint unsigned NULL,
  ind01_num_total mediumint unsigned NULL,
  ind01_den_m mediumint unsigned NULL,
  ind01_den_f mediumint unsigned NULL,
  ind01_den_total mediumint unsigned NULL,
  ind01_ratio_m VARCHAR(8) NULL,
  ind01_ratio_f VARCHAR(8) NULL,
  ind01_ratio_total VARCHAR(8) NULL,
  ind02_num_m mediumint unsigned NULL,
  ind02_num_f mediumint unsigned NULL,
  ind02_num_total mediumint unsigned NULL,
  ind02_den_m mediumint unsigned NULL,
  ind02_den_f mediumint unsigned NULL,
  ind02_den_total mediumint unsigned NULL,
  ind02_ratio_m VARCHAR(8) NULL,
  ind02_ratio_f VARCHAR(8) NULL,
  ind02_ratio_total VARCHAR(8) NULL,
  ind03_num_m mediumint unsigned NULL,
  ind03_num_f mediumint unsigned NULL,
  ind03_num_total mediumint unsigned NULL,
  ind03_den_m mediumint unsigned NULL,
  ind03_den_f mediumint unsigned NULL,
  ind03_den_total mediumint unsigned NULL,
  ind03_ratio_m VARCHAR(8) NULL,
  ind03_ratio_f VARCHAR(8) NULL,
  ind03_ratio_total VARCHAR(8) NULL,
  ind04_num_m mediumint unsigned NULL,
  ind04_num_f mediumint unsigned NULL,
  ind04_num_total mediumint unsigned NULL,
  ind04_den_m mediumint unsigned NULL,
  ind04_den_f mediumint unsigned NULL,
  ind04_den_total mediumint unsigned NULL,
  ind04_ratio_m VARCHAR(8) NULL,
  ind04_ratio_f VARCHAR(8) NULL,
  ind04_ratio_total VARCHAR(8) NULL,
  ind05_num_m mediumint unsigned NULL,
  ind05_num_f mediumint unsigned NULL,
  ind05_num_total mediumint unsigned NULL,
  ind05_den_m mediumint unsigned NULL,
  ind05_den_f mediumint unsigned NULL,
  ind05_den_total mediumint unsigned NULL,
  ind05_ratio_m VARCHAR(8) NULL,
  ind05_ratio_f VARCHAR(8) NULL,
  ind05_ratio_total VARCHAR(8) NULL,
  ind06_num_m mediumint unsigned NULL,
  ind06_num_f mediumint unsigned NULL,
  ind06_num_total mediumint unsigned NULL,
  ind06_den_m mediumint unsigned NULL,
  ind06_den_f mediumint unsigned NULL,
  ind06_den_total mediumint unsigned NULL,
  ind06_ratio_m VARCHAR(8) NULL,
  ind06_ratio_f VARCHAR(8) NULL,
  ind06_ratio_total VARCHAR(8) NULL,
  ind07_num_m mediumint unsigned NULL,
  ind07_num_f mediumint unsigned NULL,
  ind07_num_total mediumint unsigned NULL,
  ind07_den_m mediumint unsigned NULL,
  ind07_den_f mediumint unsigned NULL,
  ind07_den_total mediumint unsigned NULL,
  ind07_ratio_m VARCHAR(8) NULL,
  ind07_ratio_f VARCHAR(8) NULL,
  ind07_ratio_total VARCHAR(8) NULL,
  ind08_num_m mediumint unsigned NULL,
  ind08_num_f mediumint unsigned NULL,
  ind08_num_total mediumint unsigned NULL,
  ind08_den_m mediumint unsigned NULL,
  ind08_den_f mediumint unsigned NULL,
  ind08_den_total mediumint unsigned NULL,
  ind08_ratio_m VARCHAR(8) NULL,
  ind08_ratio_f VARCHAR(8) NULL,
  ind08_ratio_total VARCHAR(8) NULL,
  ind09_num_m mediumint unsigned NULL,
  ind09_num_f mediumint unsigned NULL,
  ind09_num_total mediumint unsigned NULL,
  ind09_den_m mediumint unsigned NULL,
  ind09_den_f mediumint unsigned NULL,
  ind09_den_total mediumint unsigned NULL,
  ind09_ratio_m VARCHAR(8) NULL,
  ind09_ratio_f VARCHAR(8) NULL,
  ind09_ratio_total VARCHAR(8) NULL,
  ind10_num_m mediumint unsigned NULL,
  ind10_num_f mediumint unsigned NULL,
  ind10_num_total mediumint unsigned NULL,
  ind10_den_m mediumint unsigned NULL,
  ind10_den_f mediumint unsigned NULL,
  ind10_den_total mediumint unsigned NULL,
  ind10_ratio_m VARCHAR(8) NULL,
  ind10_ratio_f VARCHAR(8) NULL,
  ind10_ratio_total VARCHAR(8) NULL,
  ind11_num_m mediumint unsigned NULL,
  ind11_num_f mediumint unsigned NULL,
  ind11_num_total mediumint unsigned NULL,
  ind11_den_m mediumint unsigned NULL,
  ind11_den_f mediumint unsigned NULL,
  ind11_den_total mediumint unsigned NULL,
  ind11_ratio_m VARCHAR(8) NULL,
  ind11_ratio_f VARCHAR(8) NULL,
  ind11_ratio_total VARCHAR(8) NULL,
  ind12_num_m mediumint unsigned NULL,
  ind12_num_f mediumint unsigned NULL,
  ind12_num_total mediumint unsigned NULL,
  ind12_den_m mediumint unsigned NULL,
  ind12_den_f mediumint unsigned NULL,
  ind12_den_total mediumint unsigned NULL,
  ind12_ratio_m VARCHAR(8) NULL,
  ind12_ratio_f VARCHAR(8) NULL,
  ind12_ratio_total VARCHAR(8) NULL,
  ind13_num_m mediumint unsigned NULL,
  ind13_num_f mediumint unsigned NULL,
  ind13_num_total mediumint unsigned NULL,
  ind13_den_m mediumint unsigned NULL,
  ind13_den_f mediumint unsigned NULL,
  ind13_den_total mediumint unsigned NULL,
  ind13_ratio_m VARCHAR(8) NULL,
  ind13_ratio_f VARCHAR(8) NULL,
  ind13_ratio_total VARCHAR(8) NULL,
  ind14_num_m mediumint unsigned NULL,
  ind14_num_f mediumint unsigned NULL,
  ind14_num_total mediumint unsigned NULL,
  ind14_den_m mediumint unsigned NULL,
  ind14_den_f mediumint unsigned NULL,
  ind14_den_total mediumint unsigned NULL,
  ind14_ratio_m VARCHAR(8) NULL,
  ind14_ratio_f VARCHAR(8) NULL,
  ind14_ratio_total VARCHAR(8) NULL,
  ind15_num_m mediumint unsigned NULL,
  ind15_num_f mediumint unsigned NULL,
  ind15_num_total mediumint unsigned NULL,
  ind15_den_m mediumint unsigned NULL,
  ind15_den_f mediumint unsigned NULL,
  ind15_den_total mediumint unsigned NULL,
  ind15_ratio_m VARCHAR(8) NULL,
  ind15_ratio_f VARCHAR(8) NULL,
  ind15_ratio_total VARCHAR(8) NULL,
  ind16_num_m mediumint unsigned NULL,
  ind16_num_f mediumint unsigned NULL,
  ind16_num_total mediumint unsigned NULL,
  ind16_den_m mediumint unsigned NULL,
  ind16_den_f mediumint unsigned NULL,
  ind16_den_total mediumint unsigned NULL,
  ind16_ratio_m VARCHAR(8) NULL,
  ind16_ratio_f VARCHAR(8) NULL,
  ind16_ratio_total VARCHAR(8) NULL,
  ind17_num_m mediumint unsigned NULL,
  ind17_num_f mediumint unsigned NULL,
  ind17_num_total mediumint unsigned NULL,
  ind17_den_m mediumint unsigned NULL,
  ind17_den_f mediumint unsigned NULL,
  ind17_den_total mediumint unsigned NULL,
  ind17_ratio_m VARCHAR(8) NULL,
  ind17_ratio_f VARCHAR(8) NULL,
  ind17_ratio_total VARCHAR(8) NULL,
  ind18_num_m mediumint unsigned NULL,
  ind18_num_f mediumint unsigned NULL,
  ind18_num_total mediumint unsigned NULL,
  ind18_den_m mediumint unsigned NULL,
  ind18_den_f mediumint unsigned NULL,
  ind18_den_total mediumint unsigned NULL,
  ind18_ratio_m VARCHAR(8) NULL,
  ind18_ratio_f VARCHAR(8) NULL,
  ind18_ratio_total VARCHAR(8) NULL,
  ind19_num_m mediumint unsigned NULL,
  ind19_num_f mediumint unsigned NULL,
  ind19_num_total mediumint unsigned NULL,
  ind19_den_m mediumint unsigned NULL,
  ind19_den_f mediumint unsigned NULL,
  ind19_den_total mediumint unsigned NULL,
  ind19_ratio_m VARCHAR(8) NULL,
  ind19_ratio_f VARCHAR(8) NULL,
  ind19_ratio_total VARCHAR(8) NULL,
  row_type TINYINT NULL,
  UNIQUE INDEX healthqualIndex (siteCode, startDate, endDate, row_type)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS hivQual;
CREATE TABLE hivQual (
  lastRun DATETIME,
  startDate DATETIME,
  endDate DATETIME,
  siteCode mediumint unsigned NULL,
  cases INT NULL,
  ind1_num INT NULL,
  ind1_den INT NULL,
  ind1_ratio VARCHAR(255) NULL,
  ind2_num INT NULL,
  ind2_den INT NULL,
  ind2_ratio VARCHAR(255) NULL,
  ind3_num INT NULL,
  ind3_den INT NULL,
  ind3_ratio VARCHAR(255) NULL,
  ind4A_num INT NULL,
  ind4A_den INT NULL,
  ind4A_ratio VARCHAR(255) NULL,
  ind4B_num INT NULL,
  ind4B_den INT NULL,
  ind4B_ratio VARCHAR(255) NULL,
  ind5_num INT NULL,
  ind5_den INT NULL,
  ind5_ratio VARCHAR(255) NULL,
  ind6_num INT NULL,
  ind6_den INT NULL,
  ind6_ratio VARCHAR(255) NULL,
  ind7_num INT NULL,
  ind7_den INT NULL,
  ind7_ratio VARCHAR(255) NULL,
  ind8_num INT NULL,
  ind8_den INT NULL,
  ind8_ratio VARCHAR(255) NULL,
  ind9_num INT NULL,
  ind9_den INT NULL,
  ind9_ratio VARCHAR(255) NULL,
  ind10_num INT NULL,
  ind10_den INT NULL,
  ind10_ratio VARCHAR(255) NULL,
  row_type TINYINT NULL,
  UNIQUE INDEX hivqualIndex (siteCode, startDate, endDate, row_type)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

drop table if exists lastJobRun;
create table lastJobRun (
  lastRun datetime)
ENGINE = INNODB
CHARACTER SET UTF8 COLLATE utf8_general_ci;

insert into lastJobRun (lastRun) values ('1970-01-01');

drop table if exists lastMarkers2;
CREATE TABLE lastMarkers2 (
 lastMarkersDate datetime NOT NULL,
 markerText mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists lastSplash;
CREATE TABLE lastSplash (
       lastSplashDate datetime default NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into lastSplash (lastSplashDate) values ('1970-01-01');

drop table if exists lastSplashText;
CREATE TABLE lastSplashText (
 lastSplashText_id int unsigned NOT NULL auto_increment,
 splashText varchar(200) default NULL,
 PRIMARY KEY  (`lastSplashText_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists duplicatePatients;
CREATE TABLE duplicatePatients (
	patient_id int unsigned,
	patientID varchar(11),
	nationalID varchar(255),
	siteCode mediumint unsigned,
	lname varchar(255),
	fname varchar(255),
	dobDd char(2),
	dobMm char(2),
	dobYy char(2),
	fnamemother varchar(255),
	dupCount tinyint unsigned
);

drop table if exists concept;
CREATE TABLE  concept  (
   concept_id  int(10) unsigned NOT NULL,
   retired  tinyint unsigned NOT NULL default '0',
   short_name  varchar(255) default NULL,
   description  text,
   form_text  text,
   datatype_id  int(10) unsigned NOT NULL default '0',
   class_id  int(10) unsigned NOT NULL default '0',
   is_set  tinyint unsigned NOT NULL default '0',
   creator  int(10) unsigned NOT NULL default '0',
   date_created  datetime NOT NULL default '0000-00-00 00:00:00',
   default_charge  int(10) unsigned default NULL,
   version  varchar(50) default NULL,
   changed_by  int(10) unsigned default NULL,
   date_changed  datetime default NULL,
  PRIMARY KEY  ( concept_id ),
  KEY  concept_classes  ( class_id ),
  KEY  concept_creator  ( creator ),
  KEY  concept_datatypes  ( datatype_id ),
  KEY  user_who_changed_concept  ( changed_by )
) 
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci ; 

CREATE UNIQUE INDEX conceptNameIndex ON concept (short_name);

drop table if exists concept_class;
CREATE TABLE  concept_class  (
   concept_class_id  int(10) unsigned NOT NULL,
   name  varchar(255) NOT NULL default '',
   description  varchar(255) NOT NULL default '',
   creator  int(10) unsigned NOT NULL default '0',
   date_created  datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  ( concept_class_id ),
  KEY  concept_class_creator  ( creator )
) 
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

drop table if exists concept_datatype;
CREATE TABLE  concept_datatype  (
   concept_datatype_id  int(10) unsigned NOT NULL,
   name  varchar(255) NOT NULL default '',
   hl7_abbreviation  varchar(3) default NULL,
   description  varchar(255) NOT NULL default '',
   creator  int(10) unsigned NOT NULL default '0',
   date_created  datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  ( concept_datatype_id ),
  KEY  concept_datatype_creator  ( creator )
) 
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

drop table if exists concept_name;
CREATE TABLE  concept_name  (
   concept_id  int(10) unsigned NOT NULL default '0',
   name  varchar(255) NOT NULL default '',
   short_name  varchar(255) default NULL,
   description  text NOT NULL,
   locale  varchar(50) NOT NULL default '',
   creator  int(10) unsigned NOT NULL default '0',
   date_created  datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  ( concept_id , locale ),
  KEY  user_who_created_name  ( creator ),
  KEY  name_of_concept  ( name ),
  KEY  short_name_of_concept  ( short_name )
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

drop table if exists obs;
CREATE TABLE obs (
  obs_id int(10) unsigned NOT NULL auto_increment,
  person_id int(10) unsigned NOT NULL,
  concept_id int(10) unsigned NOT NULL default '0',
  encounter_id int(10) unsigned default NULL,
  order_id int(10) unsigned default NULL,
  obs_datetime datetime default NULL,
  location_id int(10) unsigned NOT NULL default '0',
  obs_group_id int(10) unsigned default NULL,
  accession_number varchar(255) default NULL,
  value_group_id int(10) unsigned default NULL,
  value_boolean tinyint unsigned default NULL,
  value_coded int(10) unsigned default NULL,
  value_drug int(10) unsigned default NULL,
  value_datetime datetime default NULL,
  value_numeric double default NULL,
  value_modifier varchar(2) default NULL,
  value_text text,
  date_started datetime default NULL,
  date_stopped datetime default NULL,
  comments varchar(255) default NULL,
  creator int(10) unsigned default NULL,
  date_created datetime default NULL,
  voided tinyint unsigned default NULL,
  voided_by int(10) unsigned default NULL,
  date_voided datetime default NULL,
  void_reason varchar(255) default NULL,
  PRIMARY KEY  (obs_id, location_id),
  KEY encounter_observations (encounter_id),
  KEY obs_concept (concept_id),
  KEY obs_location (location_id),
  KEY patient_obs (person_id),
  KEY patientIDindex (location_id, person_id, concept_id)
) 
ENGINE=INNODB
CHARACTER SET utf8 
COLLATE utf8_general_ci;
	
DROP TABLE IF EXISTS staticReportData;
CREATE TABLE staticReportData (
  runningSince DATETIME NULL ,
  connID INT UNSIGNED NULL ,
  reportNumber INT UNSIGNED NOT NULL ,
  username VARCHAR( 20 ) NOT NULL ,
  value1 TEXT NULL ,
  value2 TEXT NULL ,
  value3 TEXT NULL ,
  value4 TEXT NULL,
  INDEX staticReportDataIndex (reportNumber, username)
) ENGINE = InnoDB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS isanteConcepts;
create table isanteConcepts (
concept_id  int(10) unsigned NOT NULL, 
conceptKey varchar(50) NOT NULL,
oldiSanteId int(10) unsigned NULL,
datatype_id int(10) unsigned NOT NULL,
primary key  ( conceptKey ),
unique index mvpId  ( concept_id, conceptKey )
) 
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS staticConcepts;
create table staticConcepts (
column_name varchar(64) not null, 
table_name varchar(64) not null, 
concept_class_id tinyint unsigned not null default 11, 
concept_datatype_id tinyint unsigned not null default 3
) ENGINE = InnoDB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS isanteForms;
CREATE TABLE isanteForms ( 
encType int(11) NOT NULL ,
formVersion tinyint(4) NOT NULL ,
section tinyint(4) NOT NULL ,
field int(4) NOT NULL ,
labelEn varchar(50) default NULL ,
labelFr varchar(50) default NULL ,
conceptKey varchar(50) default NULL ,
default_value varchar(50) default NULL ,
conceptOrTable varchar(30) default NULL ,
UNIQUE KEY dictionaryIndex (encType, formVersion , section , field) 
) ENGINE = InnoDB DEFAULT CHARSET = utf8; 

DROP TABLE IF EXISTS labGroupLookup;
CREATE TABLE IF NOT EXISTS labGroupLookup (
  labGroupLookup_id int(10) unsigned NOT NULL,
  labGroup varchar(255) default NULL,
  PRIMARY KEY  (labGroupLookup_id)
) ENGINE=InnoDB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS labPanelLookup;
CREATE TABLE IF NOT EXISTS labPanelLookup (
  labPanelLookup_id int(10) unsigned NOT NULL,
  labGroup varchar(255) default NULL,
  panelName varchar(255) default NULL,
  sampleType varchar(255) default NULL,
  PRIMARY KEY  (labPanelLookup_id)
) ENGINE=InnoDB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS dw_weightForHeightLookup;
CREATE TABLE IF NOT EXISTS dw_weightForHeightLookup (
  maxAgeInYrs tinyint unsigned NOT NULL,
  gender char(1) NOT NULL,
  heightInCm decimal(5,2) NOT NULL,
  minus2Sd decimal(3,1),
  minus3Sd decimal(3,1),
  PRIMARY KEY  (maxAgeInYrs, gender, heightInCm)
) ENGINE=InnoDB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS dw_measureForAgeLookup;
CREATE TABLE IF NOT EXISTS dw_measureForAgeLookup (
  measure varchar(16) NOT NULL,
  ageInMos smallint unsigned NOT NULL,
  gender char(1) NOT NULL,
  minus2Sd decimal(4,1),
  minus3Sd decimal(4,1),
  plus1Sd decimal(4,1),
  plus2Sd decimal(4,1),
  PRIMARY KEY  (measure, ageInMos, gender)
) ENGINE=InnoDB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS dw_nutritionReportLookup;
CREATE TABLE IF NOT EXISTS dw_nutritionReportLookup (
  indicator smallint NOT NULL,
  indicatorType smallint NOT NULL,
  nameen varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL,
  namefr varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL,
  definitionen varchar(1024) character set utf8 collate utf8_unicode_ci NOT NULL,
  definitionfr varchar(1024) character set utf8 collate utf8_unicode_ci NOT NULL,
  indicatorDenominator smallint
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS dw_nutrition_patients;
CREATE TABLE IF NOT EXISTS dw_nutrition_patients (
  indicator smallint NOT NULL,
  time_period varchar(16) NOT NULL,
  `year` smallint unsigned NOT NULL,
  period smallint unsigned NOT NULL,
  patientid varchar(11) NOT NULL,
  PRIMARY KEY  (indicator, patientid, time_period, `year`, period)
) ENGINE=InnoDB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS dw_nutrition_slices;
CREATE TABLE IF NOT EXISTS dw_nutrition_slices (
  org_unit varchar(64) NOT NULL,
  org_value varchar(255) NOT NULL,
  indicator smallint NOT NULL,
  time_period varchar(16) NOT NULL,
  `year` smallint unsigned NOT NULL,
  period smallint unsigned NOT NULL,
  gender tinyint unsigned NOT NULL,
  `value` bigint default '0',
  denominator bigint default '0',
  PRIMARY KEY  (org_unit, org_value, indicator, time_period, `year`, period, gender)
) ENGINE=InnoDB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS dw_nutrition_snapshot;
CREATE TABLE IF NOT EXISTS dw_nutrition_snapshot (
  patientID varchar(11) NOT NULL,
  visitDate date NOT NULL default '0000-00-00',
  ageInMos smallint unsigned NOT NULL,
  wtInKgs decimal(5,2) NOT NULL default '0',
  htInMeters decimal(4,2) NOT NULL default '0',
  bmi decimal(4,2) NOT NULL default '0',
  nutritionalEdema tinyint unsigned NOT NULL default 0,
  armCirc decimal(5,2) NOT NULL default '0',
  PRIMARY KEY  (visitDate, patientID),
  KEY pidIdx (patientID)
) ENGINE=InnoDB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS dw_pregnancy_ranges;
CREATE TABLE IF NOT EXISTS dw_pregnancy_ranges (
  patientID varchar(11) NOT NULL,
  startDate date NOT NULL default '0000-00-00',
  stopDate date default NULL,
  PRIMARY KEY  (patientID, startDate),
  KEY pidIdx (patientID)
) ENGINE=InnoDB
CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS dw_tbReportLookup;
CREATE TABLE IF NOT EXISTS dw_tbReportLookup (
  indicator smallint(6) NOT NULL,
  indicatorType int NOT NULL,
  nameen varchar(150) character set utf8 collate utf8_unicode_ci NOT NULL,
  namefr varchar(150) character set utf8 collate utf8_unicode_ci NOT NULL,
  definitionen varchar(1024) character set utf8 collate utf8_unicode_ci NOT NULL,
  definitionfr varchar(1024) character set utf8 collate utf8_unicode_ci NOT NULL,
  data_elements varchar(100) NOT NULL,
  subGroupEn varchar(150) character set utf8 collate utf8_unicode_ci NOT NULL, 
  subGroupFr varchar(150) character set utf8 collate utf8_unicode_ci NOT NULL,
  indicatorDenominator int NOT NULL default '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS dw_tb_patients;
CREATE TABLE IF NOT EXISTS dw_tb_patients (
  indicator smallint(10) NOT NULL,
  time_period varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  period smallint(6) NOT NULL,
  patientid varchar(11) NOT NULL,
  PRIMARY KEY  (indicator,patientid,time_period,`year`,period)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS dw_tb_slices;
CREATE TABLE IF NOT EXISTS dw_tb_slices (
  org_unit varchar(50) NOT NULL,
  org_value varchar(50) NOT NULL,
  indicator smallint(10) NOT NULL,
  time_period varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  period smallint(6) NOT NULL,
  gender tinyint unsigned NOT NULL, 
  `value` bigint default '0',
  denominator bigint default '0',
  PRIMARY KEY  (org_unit,org_value,indicator,time_period,`year`,period, gender)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; 

DROP TABLE IF EXISTS dw_tb_snapshot;
CREATE TABLE IF NOT EXISTS dw_tb_snapshot (
  patientID varchar(11) NOT NULL,
  visitDate date NOT NULL default '0000-00-00',
  dxMDRtb tinyint(1) NOT NULL default '0', 
  dxMDRtbA tinyint(1) NOT NULL default '0', 
  dxTB tinyint(1) NOT NULL default '0', 
  dxTBA tinyint(1) NOT NULL default '0', 
  dyspnea tinyint(1) NOT NULL default '0', 
  propCotrimoxazole tinyint(1) NOT NULL default '0', 
  tbArvYN tinyint(1) NOT NULL default '0', 
  tbClassExtra tinyint(1) NOT NULL default '0', 
  tbClassPulmonaire tinyint(1) NOT NULL default '0',
  tbDxClinique tinyint(1) NOT NULL default '0',
  tbDxCrachat tinyint(1) NOT NULL default '0',
  tbDxNew tinyint(1) NOT NULL default '0',
  tbRegistrationDt tinyint(1) NOT NULL default '0',  
  tbDxXray tinyint(1) NOT NULL default '0',
  tbMaladeNew tinyint(1) NOT NULL default '0',
  tbMaladeRechute tinyint(1) NOT NULL default '0',
  tbMeningite tinyint(1) NOT NULL default '0',
  tbGenitale tinyint(1) NOT NULL default '0',
  tbPleurale tinyint(1) NOT NULL default '0',
  tbMiliaire tinyint(1) NOT NULL default '0',
  tbGanglionnaire tinyint(1) NOT NULL default '0',
  tbIntestinale tinyint(1) NOT NULL default '0',
  tbClassOther tinyint(1) NOT NULL default '0',
  tbPrestataire tinyint(1) NOT NULL default '0', 
  tbEvalresult0 tinyint(1) NOT NULL default '0', 
  tbEvalresult2 tinyint(1) NOT NULL default '0', 
  tbEvalresult3 tinyint(1) NOT NULL default '0',
  tbEvalresult5 tinyint(1) NOT NULL default '0',
  tbEvalresultFin tinyint(1) NOT NULL default '0',
  tbStartTreatment tinyint(1) NOT NULL default '0',
  tbStopReason int NOT NULL default '0',
  tbTestVIH tinyint(1) NOT NULL default '0',
  touxGreat2 tinyint(1) NOT NULL default '0',
  crachat tinyint(1) NOT NULL default '0',
  xray tinyint(1) NOT NULL default '0',
  tbRegimen tinyint(1) NOT NULL default '0',
  hemoptysie tinyint(1) NOT NULL default '0', 
  perteDePoid tinyint(1) NOT NULL default '0', 
  feverLess2 tinyint(1) NOT NULL default '0', 
  feverGreat2 tinyint(1) NOT NULL default '0', 
  ethambutol tinyint(1) NOT NULL default '0',
  isoniazid tinyint(1) NOT NULL default '0',
  pyrazinamide tinyint(1) NOT NULL default '0',
  rifampicine tinyint(1) NOT NULL default '0',
  streptomycine tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (visitDate, patientID),
  KEY pidIdx (patientID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS dw_hivstatusReportLookup;
CREATE TABLE IF NOT EXISTS dw_hivstatusReportLookup (
  indicator smallint NOT NULL,
  indicatorType smallint NOT NULL,
  nameen varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL,
  namefr varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL,
  definitionen varchar(1024) character set utf8 collate utf8_unicode_ci NOT NULL,
  definitionfr varchar(1024) character set utf8 collate utf8_unicode_ci NOT NULL,
  subGroupEn varchar(150) character set utf8 collate utf8_unicode_ci NOT NULL,
  subGroupFr varchar(150) character set utf8 collate utf8_unicode_ci NOT NULL,
  indicatorDenominator smallint
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS dw_hivstatus_patients;
CREATE TABLE IF NOT EXISTS dw_hivstatus_patients (
  indicator smallint(10) NOT NULL,
  time_period varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  period smallint(6) NOT NULL,
  patientid varchar(11) NOT NULL,
  PRIMARY KEY  (indicator,patientid,time_period,`year`,period)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS dw_hivstatus_slices;
CREATE TABLE IF NOT EXISTS dw_hivstatus_slices (
  org_unit varchar(50) NOT NULL,
  org_value varchar(50) NOT NULL,
  indicator smallint(10) NOT NULL,
  time_period varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  period smallint(6) NOT NULL,
  gender tinyint unsigned NOT NULL, 
  `value` bigint default '0',
  denominator bigint default '0',
  PRIMARY KEY  (org_unit,org_value,indicator,time_period,`year`,period, gender)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS dw_hivstatus_snapshot;
CREATE TABLE IF NOT EXISTS dw_hivstatus_snapshot (
  patientID varchar(11) NOT NULL,
  visitDate date NOT NULL default '0000-00-00',
  new_palliatifs     tinyint(1) NOT NULL default '0', 
  actif_palliatifs   tinyint(1) NOT NULL default '0',
  risque_palliatifs  tinyint(1) NOT NULL default '0',
  inactif_palliatifs tinyint(1) NOT NULL default '0',
  disc_palliatifs    tinyint(1) NOT NULL default '0',
  new_tar            tinyint(1) NOT NULL default '0', 
  actif_tar          tinyint(1) NOT NULL default '0',
  risque_tar         tinyint(1) NOT NULL default '0',
  inactif_tar        tinyint(1) NOT NULL default '0',
  disc_tar           tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (visitdate,patientid),
  KEY pidIndex (patientid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `dw_obgyn_patients`;

CREATE TABLE `dw_obgyn_patients` (
  `indicator` smallint(6) NOT NULL,
  `time_period` varchar(16) NOT NULL,
  `year` smallint(5) unsigned NOT NULL,
  `period` smallint(5) unsigned NOT NULL,
  `patientid` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `dw_obgyn_slices`;

CREATE TABLE `dw_obgyn_slices` (
  `org_unit` varchar(64) NOT NULL,
  `org_value` varchar(255) NOT NULL,
  `indicator` smallint(6) NOT NULL,
  `time_period` varchar(16) NOT NULL,
  `year` smallint(5) unsigned NOT NULL,
  `period` smallint(5) unsigned NOT NULL,
  `gender` tinyint(3) unsigned NOT NULL,
  `value` bigint(20) default '0',
  `denominator` bigint(20) default '0',
  PRIMARY KEY  (`org_unit`,`org_value`,`indicator`,`time_period`,`year`,`period`,`gender`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `dw_obgyn_snapshot`;

CREATE TABLE  `dw_obgyn_snapshot` (
  `PatientID` varchar(11) NOT NULL,
  `VisitDate` date NOT NULL,
  `mammographDt` tinyint(1) NOT NULL,
  `papTestResult` tinyint(1) NOT NULL,
  `leucorhee` tinyint(1) NOT NULL,
  `metrorragieSymptom` tinyint(1) NOT NULL,
  `sexAgression` tinyint(1) NOT NULL,
  `consult_obs` tinyint(1) NOT NULL,
  `GrossesseHautRisque` tinyint(1) NOT NULL,
  `tetanosDtD1` tinyint(1) NOT NULL,
  `hypertensionArteryA` tinyint(1) NOT NULL,
  `hemorragieVaginale` tinyint(1) NOT NULL,
  `hemorragieVaginalet1` bigint(20) NOT NULL,
  `membraneRupture` tinyint(1) NOT NULL,
  `vacuum` tinyint(1) NOT NULL,
  `laborMethod` tinyint(1) NOT NULL,
  `laborMystery` tinyint(1) NOT NULL,
  `laborDifficultBirth` tinyint(1) NOT NULL,
  `vitalWeight1` tinyint(1) NOT NULL,
  `ppVitalBp1` tinyint(1) NOT NULL,
  `ironSup` tinyint(1) NOT NULL,
  `UtilisationPartogramme` tinyint(1) NOT NULL,
  `BeneficieGATPA` tinyint(1) NOT NULL,
  `laborEvolution` tinyint(1) NOT NULL,
  `plusDe30Ans` tinyint(1) NOT NULL,
  `plusDe40Ans` tinyint(1) NOT NULL,
  `femmesVuesPrenatal` tinyint(1) NOT NULL,
  `suiviPrenatal` tinyint(1) NOT NULL,
  `accouchement` tinyint(1) NOT NULL,
  `membraneRuptureDeno` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `dw_obgynReportLookup`;

CREATE TABLE  `dw_obgynReportLookup` (
  `indicator` smallint(6) NOT NULL,
  `indicatorType` smallint(6) NOT NULL,
  `nameen` text NOT NULL,
  `namefr` text NOT NULL,
  `definitionen` text NOT NULL,
  `definitionfr` text NOT NULL,
  `indicatorDenominator` smallint(6) default NULL,
  PRIMARY KEY  (`indicator`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `dw_dataquality_patients`;

CREATE TABLE `dw_dataquality_patients` (
  `indicator` smallint(10) NOT NULL,
  `time_period` varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  `period` smallint(6) NOT NULL,
  `patientid` varchar(11) NOT NULL,
  PRIMARY KEY (`indicator`,`time_period`,`year`,`period`,`patientid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `dw_dataquality_slices` */

DROP TABLE IF EXISTS `dw_dataquality_slices`;

CREATE TABLE `dw_dataquality_slices` (
  `org_unit` varchar(64) NOT NULL,
  `org_value` varchar(255) NOT NULL,
  `indicator` smallint(6) NOT NULL,
  `time_period` varchar(16) NOT NULL,
  `year` smallint(5) unsigned NOT NULL,
  `period` smallint(5) unsigned NOT NULL,
  `gender` tinyint(3) unsigned NOT NULL,
  `value` bigint DEFAULT '0.0',
  `denominator` bigint DEFAULT '0.0',
  PRIMARY KEY (`org_unit`,`org_value`,`indicator`,`time_period`,`year`,`period`,`gender`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `dw_dataquality_snapshot` */

DROP TABLE IF EXISTS `dw_dataquality_snapshot`;

CREATE TABLE `dw_dataquality_snapshot` (
  `patientID` varchar(11) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `visitDate` date DEFAULT NULL,
  `A1D` bigint(21) NOT NULL DEFAULT '0',
  `A1N` bigint(21) NOT NULL DEFAULT '0',
  `A2N` bigint(21) NOT NULL DEFAULT '0',
  `A3N` bigint(21) NOT NULL DEFAULT '0',
  `A4N` bigint(21) NOT NULL DEFAULT '0',
  `A5N` bigint(21) NOT NULL DEFAULT '0',
  `A6N` bigint(21) NOT NULL DEFAULT '0',
  `A7N` bigint(21) NOT NULL DEFAULT '0',
  `A7D` bigint(21) NOT NULL DEFAULT '0',
  `A8N` bigint(21) NOT NULL DEFAULT '0',
  `A8D` bigint(21) NOT NULL DEFAULT '0',
  `A9N` bigint(21) NOT NULL DEFAULT '0',
  `A9D` bigint(21) NOT NULL DEFAULT '0',
  `A10N` bigint(21) NOT NULL DEFAULT '0',
  `A10D` bigint(21) NOT NULL DEFAULT '0',
  `A11D` bigint(21) NOT NULL DEFAULT '0',
  `A11N` bigint(21) NOT NULL DEFAULT '0',
  `A12N` bigint(21) NOT NULL DEFAULT '0',
  `A13N` bigint(21) NOT NULL DEFAULT '0',
  `A14D` bigint(21) NOT NULL DEFAULT '0',
  `A14N` bigint(21) NOT NULL DEFAULT '0',
  `A15N` bigint(21) NOT NULL DEFAULT '0',
  `A16N` bigint(21) NOT NULL DEFAULT '0',
  `A17N` bigint(21) NOT NULL DEFAULT '0',
  `A18N` bigint(21) NOT NULL DEFAULT '0',
  `A18D` bigint(21) NOT NULL DEFAULT '0',
  `A19N` bigint(21) NOT NULL DEFAULT '0',
  `A19D` bigint(21) NOT NULL DEFAULT '0',
  `A20D` bigint(21) NOT NULL DEFAULT '0',
  `A20N` bigint(21) NOT NULL DEFAULT '0',
  `C1D` bigint(21) NOT NULL DEFAULT '0',
  `C1N` bigint(21) NOT NULL DEFAULT '0',
  `C2D` bigint(21) NOT NULL DEFAULT '0',
  `C2N` bigint(21) NOT NULL DEFAULT '0',
  `C3D` bigint(21) NOT NULL DEFAULT '0',
  `C3N` bigint(21) NOT NULL DEFAULT '0',
  `C4D` bigint(21) NOT NULL DEFAULT '0',
  `C4N` bigint(21) NOT NULL DEFAULT '0',
  `C5D` bigint(21) NOT NULL DEFAULT '0',
  `C5N` bigint(21) NOT NULL DEFAULT '0',
  `C6D` bigint(21) NOT NULL DEFAULT '0',
  `C6N` bigint(21) NOT NULL DEFAULT '0',
  `C7D` bigint(21) NOT NULL DEFAULT '0',
  `C7N` bigint(21) NOT NULL DEFAULT '0',
  `C8D` bigint(21) NOT NULL DEFAULT '0',
  `C8N` bigint(21) NOT NULL DEFAULT '0',
  `C9D` bigint(21) NOT NULL DEFAULT '0',
  `C9N` bigint(21) NOT NULL DEFAULT '0',
  `C10D` bigint(21) NOT NULL DEFAULT '0',
  `C10N` bigint(21) NOT NULL DEFAULT '0',
  `C11N` bigint(21) NOT NULL DEFAULT '0',
  `C11D` bigint(21) NOT NULL DEFAULT '0',
  `C12N` bigint(21) NOT NULL DEFAULT '0',
  `C12D` bigint(21) NOT NULL DEFAULT '0',
  `C13N` bigint(21) NOT NULL DEFAULT '0',
  `C13D` bigint(21) NOT NULL DEFAULT '0',
  `C14N` bigint(21) NOT NULL DEFAULT '0',
  `C14D` bigint(21) NOT NULL DEFAULT '0',
  `C15N` bigint(21) NOT NULL DEFAULT '0',
  `C15D` bigint(21) NOT NULL DEFAULT '0',
  `C16N` bigint(21) NOT NULL DEFAULT '0',
  `C16D` bigint(21) NOT NULL DEFAULT '0',
  `C17N` bigint(21) NOT NULL DEFAULT '0',
  `C17D` bigint(21) NOT NULL DEFAULT '0',
  `C18N` bigint(21) NOT NULL DEFAULT '0',
  `C18D` bigint(21) NOT NULL DEFAULT '0',
  `C19N` bigint(21) NOT NULL DEFAULT '0',
  `C19D` bigint(21) NOT NULL DEFAULT '0',
  `t1N` bigint(21) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `dw_dataqualityReportLookup` */

DROP TABLE IF EXISTS `dw_dataqualityReportLookup`;

CREATE TABLE `dw_dataqualityReportLookup` (
  `indicator` smallint(6) NOT NULL,
  `indicatorType` smallint(6) DEFAULT NULL,
  `nameen` varchar(350) character set utf8 collate utf8_unicode_ci NOT NULL,
  `namefr` varchar(350) character set utf8 collate utf8_unicode_ci NOT NULL,
  `definitionen` varchar(1024) character set utf8 collate utf8_unicode_ci NOT NULL,
  `definitionfr` varchar(1024) character set utf8 collate utf8_unicode_ci NOT NULL,
  `subGroupEn` varchar(150) character set utf8 collate utf8_unicode_ci NOT NULL,
  `subGroupFr` varchar(150) character set utf8 collate utf8_unicode_ci NOT NULL,
  `indicatorDenominator` smallint(6) DEFAULT '0',
  PRIMARY KEY (`indicator`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


drop table if exists dw_mer_snapshot;

CREATE TABLE IF NOT EXISTS `dw_mer_snapshot` (
  `patientID` varchar(11) NOT NULL default '',
  `visitDate` date NOT NULL,
  `TBRegistered` tinyint(1) default '0',
  `tbTraetementStart` tinyint(1) default '0',
  `tbTestVih` tinyint(1) default '0',
  `tbArvDate` tinyint(1) default '0',
  `vitalPb` float default '0',
  `tbOnArv` tinyint(1) default '0',
  `tbTraetment` tinyint(1) default '0',
  `pregnancy` tinyint(1) default '0',
  `HIVStatus` tinyint(1) default '0',
  `HIVForm` tinyint(1) default '0',
  `ARVPatient` tinyint(1) default '0',
  `newHIV` tinyint(1) default '0',
  `ipt` tinyint(1) default '0',
  `accouchement` tinyint(1) default '0',
  `virologicTest` float default '0',
  `viralLoad` float default '0',
  `stagingCd4Viralload` tinyint(1) default '0',
  `outcomeTb` float default '0',
  `tbSymptom` tinyint(1) default '0',
  `TX_UNDETECT_N` tinyint(1) default '0',
  `TX_UNDETECT_D` tinyint(1) default '0',
  `AntiRetroViral` float default '0',
  `statutVihActuel` tinyint(1) default '0',
  `linkToArv` float default '0',
  `cotrimoxazole` tinyint(1) default '0',
  `tbPrescription` tinyint(1) default '0',
  `isDeath` tinyint(1) default '0',
  `noFollowup` tinyint(1) default '0',
  `transfer` tinyint(1) default '0',
  `AnthroPrometrique` tinyint(1) default '0',
  `newEnrollArt` tinyint(1) default '0',
  `pedVirologicTest` tinyint(1) default '0',
  `breastfeeding` tinyint(1) default '0',
  PRIMARY KEY  (`patientID`,`visitDate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists dw_mer_slices;

CREATE TABLE `dw_mer_slices` (
  `org_unit` varchar(64) NOT NULL,
  `org_value` varchar(255) NOT NULL,
  `indicator` smallint(6) NOT NULL,
  `time_period` varchar(16) NOT NULL,
  `year` smallint(5) unsigned NOT NULL,
  `period` smallint(5) unsigned NOT NULL,
  `gender` tinyint(3) unsigned NOT NULL,
  `value` bigint(20) default '0',
  `denominator` decimal(9,1) default '0.0',
  PRIMARY KEY  (`org_unit`,`org_value`,`indicator`,`time_period`,`year`,`period`,`gender`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


drop table if exists dw_mer_patients;

CREATE TABLE `dw_mer_patients` (
  `indicator` smallint(10) NOT NULL,
  `time_period` varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  `period` smallint(6) NOT NULL,
  `patientid` varchar(11) NOT NULL,
  PRIMARY KEY  (`indicator`,`patientid`,`time_period`,`year`,`period`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists dw_merReportLookup;

CREATE TABLE `dw_merReportLookup` (
  `indicator` smallint(6) NOT NULL,
  `indicatorType` smallint(6) default NULL,
  `nameen` varchar(350) character set utf8 collate utf8_unicode_ci NOT NULL,
  `namefr` varchar(350) character set utf8 collate utf8_unicode_ci NOT NULL,
  `definitionen` varchar(1024) character set utf8 collate utf8_unicode_ci NOT NULL,
  `definitionfr` varchar(1024) character set utf8 collate utf8_unicode_ci NOT NULL,
  `subGroupEn` varchar(150) character set utf8 collate utf8_unicode_ci NOT NULL,
  `subGroupFr` varchar(150) character set utf8 collate utf8_unicode_ci NOT NULL,
  `indicatorDenominator` smallint(6) default '0',
  PRIMARY KEY  (`indicator`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
