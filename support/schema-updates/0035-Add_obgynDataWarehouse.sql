/* last date modified :  sept 29th */
DROP TABLE IF EXISTS dw_obgynReportLookup
go
CREATE TABLE IF NOT EXISTS dw_obgynReportLookup (
  indicator smallint(6) NOT NULL,
  indicatorType smallint(6) NOT NULL,
  nameen varchar(250) character set utf8 collate utf8_unicode_ci NOT NULL,
  namefr varchar(250) character set utf8 collate utf8_unicode_ci NOT NULL,
  definitionen varchar(1024) character set utf8 collate utf8_unicode_ci NOT NULL,
  definitionfr varchar(1024) NOT NULL,
  indicatorDenominator smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go

DROP TABLE IF EXISTS dw_obgyn_patients
go
CREATE TABLE IF NOT EXISTS dw_obgyn_patients (
  indicator smallint(10) NOT NULL,
  time_period varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  period smallint(6) NOT NULL,
  patientid varchar(11) NOT NULL,
  PRIMARY KEY (indicator,time_period,`year`,period,patientid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

go

DROP TABLE IF EXISTS dw_obgyn_slices
go
CREATE TABLE IF NOT EXISTS dw_obgyn_slices (
  org_unit varchar(64) NOT NULL,
  org_value varchar(255) NOT NULL,
  indicator smallint(6) NOT NULL,
  time_period varchar(16) NOT NULL,
  `year` smallint(5) unsigned NOT NULL,
  period smallint(5) unsigned NOT NULL,
  gender tinyint(3) unsigned NOT NULL,
  `value` decimal(9,1) DEFAULT '0.0',
  denominator decimal(9,1) DEFAULT '0.0',
  PRIMARY KEY (org_unit,org_value,indicator,time_period,`year`,period,gender)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go

DROP TABLE IF EXISTS dw_obgyn_snapshot
go
CREATE TABLE IF NOT EXISTS dw_obgyn_snapshot (
  patientID varchar(11) NOT NULL,
  visitDate date NOT NULL DEFAULT '0000-00-00',
  mammographDt tinyint(1) NOT NULL DEFAULT '0',
  papTestResult tinyint(1) NOT NULL DEFAULT '0',
  leucorhee tinyint(1) NOT NULL DEFAULT '0',
  metrorragieSymptom tinyint(1) NOT NULL DEFAULT '0',
  sexAgression tinyint(1) NOT NULL DEFAULT '0',
  consult_obs tinyint(1) NOT NULL DEFAULT '0',
  grossesseHautRisque tinyint(1) NOT NULL DEFAULT '0',
  tetanosDtD1 tinyint(1) NOT NULL DEFAULT '0',
  hypertensionArteryA tinyint(1) NOT NULL DEFAULT '0',
  hemorragieVaginale tinyint(1) NOT NULL DEFAULT '0',
  membraneRupture tinyint(1) NOT NULL DEFAULT '0',
  vacuum tinyint(1) NOT NULL DEFAULT '0',
  laborMethod tinyint(1) NOT NULL DEFAULT '0',
  laborMystery tinyint(1) NOT NULL DEFAULT '0',
  laborDifficultBirth tinyint(1) NOT NULL DEFAULT '0',
  vitalWeight1 tinyint(1) NOT NULL DEFAULT '0',
  ppVitalBp1 tinyint(1) NOT NULL DEFAULT '0',
  ironSup tinyint(1) NOT NULL DEFAULT '0',
  utilisationPartogramme tinyint(1) NOT NULL DEFAULT '0',
  beneficieGATPA tinyint(1) NOT NULL DEFAULT '0',
  laborEvolution tinyint(1) NOT NULL DEFAULT '0',
  plusDe30Ans tinyint(1) NOT NULL DEFAULT '0',
  plusDe40Ans tinyint(1) NOT NULL DEFAULT '0',
  femmesVuesPrenatal tinyint(1) NOT NULL DEFAULT '0',
  suiviPrenatal tinyint(1) NOT NULL DEFAULT '0',
  accouchement tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (visitDate, patientID),
  KEY patientID (patientID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go
