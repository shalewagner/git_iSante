

/* PROBLEM: order, sign, width incorrect */
alter table drugs add forPepPmtct tinyint NULL
go
/* PROBLEM: sign, width incorrect */
alter table pepfarTable add forPepPmtct tinyint NULL
go
/* PROBLEM: order, sign, width incorrect */
alter table tempDrugTable add forPepPmtct tinyint NULL
go
/* incorrect but already corrected by another update */
alter table drugTable add forPepPmtct tinyint NULL
go


DROP TABLE if exists drugSummary
go
CREATE TABLE drugSummary (
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
  INDEX drugSummaryINDEX (patientid, drugID)
)
go


create INDEX cd4TableIndex on cd4Table (patientid, visitDate)
go
create INDEX cd4Index on cd4Table (cd4, patientid, visitDate)
go
create index bloodeval1Idx on bloodeval1 (patientid, visitDate)
go
create index bloodeval2Idx on bloodeval2 (patientid, visitDate)
go

/* These next two indexes should already exist on Linux installs of RC1. Will they cause a problem? */
create index pepfarTable22 on pepfarTable (patientid, visitDate)
go
create index discTableIdx on discTable (patientid, discDate)
go


/* GUID stuff for OpenELIS integration */
alter table patient add patGuid varchar(36) NULL
go


/* tables used for splash page */
DROP TABLE IF EXISTS patientStatusTemp
go
create table patientStatusTemp (
  patientID varchar(11),
  patientStatus int,
  endDate date NOT NULL,
  insertDate timestamp
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci
go

drop table if exists lastSplashText
go
create table lastSplashText (lastSplashText_id int unsigned NOT NULL AUTO_INCREMENT, 
splashText varchar(200), 
PRIMARY KEY (lastSplashText_id)
)
go

/* reindex labs because rapidtest and some other can have dup keys */
drop index labsINDEX on labs
go
create unique index labsINDEX on labs (siteCode, patientID, visitDateDd, visitDateMm, visitDateYy, labID, seqNum, labs_id)
go

/* these 2 alters seem to be necessary when loading existing obs records into the db */
/* PROBLEM: initial schema was never updated for this change */
alter table obs modify date_created datetime null
go
alter table obs modify obs_datetime datetime null
go
/* PROBLEM: initial schema was never updated for this change */
alter table obs modify creator int(10) unsigned null
go
/* PROBLEM: initial schema was never updated for this change */
alter table obs modify voided tinyint unsigned null
go

/* This must be last. lastSplash.lastSplashDate is the proof column for this upgrade file.*/
drop table if exists lastSplash
go
create table lastSplash (lastSplashDate datetime)
go
insert into lastSplash values ('1970-01-01')
go
