
DROP TABLE IF EXISTS `dw_obgyn_patients`;
go
CREATE TABLE `dw_obgyn_patients` (
  `indicator` smallint(6) NOT NULL,
  `time_period` varchar(16) NOT NULL,
  `year` smallint(5) unsigned NOT NULL,
  `period` smallint(5) unsigned NOT NULL,
  `patientid` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
go

DROP TABLE IF EXISTS `dw_obgyn_slices`;
go
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
go

DROP TABLE IF EXISTS `dw_obgyn_snapshot`;
go
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
go
DROP TABLE IF EXISTS `dw_obgynReportLookup`;
go
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
go
alter table dw_malaria_slices modify value bigint default '0';
go
alter table dw_tb_slices modify value bigint default '0';
go
alter table dw_nutrition_slices modify value bigint default '0';
go
alter table dw_dataquality_slices modify value bigint default '0';
go