/* This file contains database schema updates to be applied when upgrading to 9.0 RC2 */


/* This first set is corrections to minor problems introduced when upgrading to 7.0RC2. */
/* These three had incorrect sign, position and width in the original upgrade file. */
alter table drugs modify forPepPmtct tinyint(3) unsigned NULL after drugID
go
alter table pepfarTable modify forPepPmtct tinyint(3) unsigned NULL
go
alter table tempDrugTable modify forPepPmtct tinyint(3) unsigned NULL after isContinued
go
/* This one was changed in the initial schema but never added to the upgrade file. */
alter table prescriptions modify forPepPmtct tinyint(3) unsigned NULL
go
/* These changes to the obs table were included in the 7.0RC2 schema upgrade file but never in the initial schema file. Repeat them here and update the initial schema file. */
alter table obs modify date_created datetime null
go
update obs set date_created=null where date_created='0000-00-00 00:00:00'
go
alter table obs modify creator int(10) unsigned null
go
update obs set creator=null where creator='0'
go
alter table obs modify voided tinyint unsigned null
go
update obs set voided=null where voided='0'
go
/* Remove tempDrugTable.forPmPct which was included by accident in the initial schema before 7.0RC2. This table isn't used anymore so just drop the whole thing. */
drop table if exists tempDrugTable
go


/* new table for holding last markers data */
drop table if exists lastMarkers2
go
CREATE TABLE lastMarkers2 (
 lastMarkersDate datetime NOT NULL,
 markerText mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go

/* remove old last markers tables */
drop table if exists lastMarkers
go
drop table if exists lastMarkersText
go

/* this mostly replaces config.ini */
CREATE TABLE IF NOT EXISTS config (
  config_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  name VARCHAR( 255 ) NOT NULL ,
  value TEXT NOT NULL ,
UNIQUE (
  name
)
) ENGINE = InnoDB COMMENT = 'see backend/config.php for more info'
go 

/* Redo some changes to the hivQual table that may not have been included in new installs of 9.0RC1 */
truncate table hivQual
go
call AddColumnUnlessExists(Database(), 'hivQual', 'row_type', 'tinyint NULL')
go
call DropIndexIfExists(Database(), 'hivQual', 'hivqualIndex')
go
call AddIndexUnlessExists(Database(), 'hivQual', 'UNIQUE', 'hivqualIndex', '( siteCode, startDate, endDate, row_type )')
go

/* drugSummary and drugTable tables that contain all patients not just hivPositive ones */
DROP TABLE IF EXISTS drugSummary
go
DROP TABLE IF EXISTS drugSummaryAll
go
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
CHARACTER SET utf8 COLLATE utf8_general_ci
go
DROP TABLE IF EXISTS drugTable
go
DROP TABLE IF EXISTS drugTableAll
go
CREATE TABLE drugTableAll (
  sitecode mediumint unsigned NULL,
  patientid VARCHAR(11) NULL,
  visitdate DATETIME NULL,
  drugID int unsigned NULL,
  forPepPmtct tinyint unsigned NULL,
  INDEX drugTableINDEX (patientid, drugID)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci
go

/* add some fields to staticReportData to enforce running only one report at a time */
call AddColumnUnlessExists(Database(), 'staticReportData', 'runningSince', 'datetime NULL first')
go
call AddColumnUnlessExists(Database(), 'staticReportData', 'connID', 'int unsigned NULL after runningSince')
go
alter table staticReportData modify value1 text NULL
go

/* make unique index a regular one on referrals table to fix PivotalTracker story #20457421 */
call DropIndexIfExists(Database(), 'referrals', 'referralsINDEX')
go
call AddIndexUnlessExists(Database(), 'referrals', '', 'referralsINDEX', '(patientID, visitDateYy, visitDateMm, visitDateDd, seqNum, siteCode)')
go

/* get rid of duplicate breast cancer concept references */
update obs set concept_id = 70059 where concept_id = 70379
go
update obs set concept_id = 70112 where concept_id = 71004
go
update obs set concept_id = 70113 where concept_id = 71005
go
