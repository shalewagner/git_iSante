DROP TABLE IF EXISTS dw_encounter_snapshot
go
CREATE TABLE IF NOT EXISTS dw_encounter_snapshot (
  siteCode mediumint(8) unsigned NOT NULL,
  patientID varchar(11) NOT NULL,
  visitdate date default NULL,
  encounter_id int(10) unsigned NOT NULL default '0',
  dbSite tinyint(3) unsigned NOT NULL default '0',
  lastModified datetime default NULL,
  PRIMARY KEY  USING BTREE (encounter_id,dbSite),
  KEY lastModifiedSnapshotIndex (lastModified,encounter_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go

DROP TABLE IF EXISTS dw_malariaReportLookup
go
CREATE TABLE IF NOT EXISTS dw_malariaReportLookup (
  indicator smallint(6) NOT NULL, 
  indicatorType int NOT NULL, 
  nameen varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL,
  namefr varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL,
  data_elements varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go

DROP TABLE IF EXISTS dw_malaria_patients
go
CREATE TABLE IF NOT EXISTS dw_malaria_patients (
  indicator smallint(10) NOT NULL,
  time_period varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  period smallint(6) NOT NULL,
  patientid varchar(11) NOT NULL,
  PRIMARY KEY  (indicator,patientid,time_period,`year`,period)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go

DROP TABLE IF EXISTS dw_malaria_slices
go
CREATE TABLE IF NOT EXISTS dw_malaria_slices (
  org_unit varchar(50) NOT NULL,
  org_value varchar(50) NOT NULL,
  indicator smallint(10) NOT NULL,
  time_period varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  period smallint(6) NOT NULL,
  `value` float default '0',
  denominator float default '0',
  PRIMARY KEY  (org_unit,org_value,indicator,time_period,`year`,period)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go

DROP TABLE IF EXISTS dw_malaria_snapshot
go
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
  PRIMARY KEY  (visitdate,patientid),
  KEY pidIndex (patientid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go
