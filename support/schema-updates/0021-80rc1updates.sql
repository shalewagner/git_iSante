/* This file contains database schema updates to be applied when upgrading to 8.0rc1 */

alter table drugs add finPTME tinyint unsigned null;
go
alter table drugSummary add finPTME tinyint unsigned null;
go 
alter table otherDrugs add finPTME tinyint unsigned null;
go
alter table riskLookup add answerType varchar(15) null
go
alter table patient add hivPositive tinyint unsigned null;
go
alter table clinicLookup add hostname varchar(30) null;
go

/* Drop the old UDFs written in SQL and load up the new C versions. */
DROP FUNCTION IF EXISTS IsNumeric;
CREATE FUNCTION IsNumeric RETURNS INTEGER SONAME 'udf_itech.so';
go
DROP FUNCTION IF EXISTS IsDate;
CREATE FUNCTION IsDate RETURNS INTEGER SONAME 'udf_itech.so';
go
DROP FUNCTION IF EXISTS ymdToDate;
CREATE FUNCTION ymdToDate RETURNS STRING SONAME 'udf_itech.so';
go 
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
go 
update patient set hivPositive = 1 where hivPositive is null;
go
