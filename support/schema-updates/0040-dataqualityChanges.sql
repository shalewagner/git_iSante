drop table if exists dw_dataqualityReportLookup;
go     

CREATE TABLE  dw_dataqualityReportLookup (
  indicator smallint(6) NOT NULL,
  indicatorType smallint(6) default NULL,
  nameen varchar(350) character set utf8 collate utf8_unicode_ci NOT NULL,
  namefr varchar(350) character set utf8 collate utf8_unicode_ci NOT NULL,
  definitionen varchar(1024) character set utf8 collate utf8_unicode_ci NOT NULL,
  definitionfr varchar(1024) character set utf8 collate utf8_unicode_ci NOT NULL,
  subGroupEn varchar(150) character set utf8 collate utf8_unicode_ci NOT NULL,
  subGroupFr varchar(150) character set utf8 collate utf8_unicode_ci NOT NULL,
  indicatorDenominator smallint(6) default '0',
  PRIMARY KEY  (indicator)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
go

drop table if exists dw_dataquality_patients;    
go

CREATE TABLE dw_dataquality_patients (
  indicator smallint(10) NOT NULL,
  time_period varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  period smallint(6) NOT NULL,
  patientid varchar(11) NOT NULL,
  PRIMARY KEY  (indicator,time_period,`year`,period,patientid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
go

drop table if exists dw_dataquality_slices;
go

CREATE TABLE dw_dataquality_slices (
  org_unit varchar(64) NOT NULL,
  org_value varchar(255) NOT NULL,
  indicator smallint(6) NOT NULL,
  time_period varchar(16) NOT NULL,
  `year` smallint(5) unsigned NOT NULL,
  period smallint(5) unsigned NOT NULL,
  gender tinyint(3) unsigned NOT NULL,
  `value` bigint(20) default '0',
  denominator decimal(9,1) default '0.0',
  PRIMARY KEY  (indicator,time_period,org_unit,org_value,`year`,period,gender)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
go

drop table if exists dw_dataquality_snapshot;
go

CREATE TABLE dw_dataquality_snapshot (
  patientID varchar(11) NOT NULL,
  visitDate date NOT NULL default '0000-00-00',
  A1D tinyint(1) NOT NULL default '0',
  A1N tinyint(1) NOT NULL default '0',
  A2N tinyint(1) NOT NULL default '0',
  A3N tinyint(1) NOT NULL default '0',
  A4N tinyint(1) NOT NULL default '0',
  A5N tinyint(1) NOT NULL default '0',
  A6N tinyint(1) NOT NULL default '0',
  A7N tinyint(1) NOT NULL default '0',
  A7D tinyint(1) NOT NULL default '0',
  A8N tinyint(1) NOT NULL default '0',
  A8D tinyint(1) NOT NULL default '0',
  A9N tinyint(1) NOT NULL default '0',
  A9D tinyint(1) NOT NULL default '0',
  A10N tinyint(1) NOT NULL default '0',
  A10D tinyint(1) NOT NULL default '0',
  A11D tinyint(1) NOT NULL default '0',
  A11N tinyint(1) NOT NULL default '0',
  A12N tinyint(1) NOT NULL default '0',
  A13N tinyint(1) NOT NULL default '0',
  A14D tinyint(1) NOT NULL default '0',
  A14N tinyint(1) NOT NULL default '0',
  A15N tinyint(1) NOT NULL default '0',
  A16N tinyint(1) NOT NULL default '0',
  A17N tinyint(1) NOT NULL default '0',
  A18N tinyint(1) NOT NULL default '0',
  A18D tinyint(1) NOT NULL default '0',
  A19N tinyint(1) NOT NULL default '0',
  A19D tinyint(1) NOT NULL default '0',
  A20D tinyint(1) NOT NULL default '0',
  A20N tinyint(1) NOT NULL default '0',
  C1D tinyint(1) NOT NULL default '0',
  C1N tinyint(1) NOT NULL default '0',
  C2D tinyint(1) NOT NULL default '0',
  C2N tinyint(1) NOT NULL default '0',
  C3D tinyint(1) NOT NULL default '0',
  C3N tinyint(1) NOT NULL default '0',
  C4D tinyint(1) NOT NULL default '0',
  C4N tinyint(1) NOT NULL default '0',
  C5D tinyint(1) NOT NULL default '0',
  C5N tinyint(1) NOT NULL default '0',
  C6D tinyint(1) NOT NULL default '0',
  C6N tinyint(1) NOT NULL default '0',
  C7D tinyint(1) NOT NULL default '0',
  C7N tinyint(1) NOT NULL default '0',
  C8D tinyint(1) NOT NULL default '0',
  C8N tinyint(1) NOT NULL default '0',
  C9D tinyint(1) NOT NULL default '0',
  C9N tinyint(1) NOT NULL default '0',
  C10D tinyint(1) NOT NULL default '0',
  C10N tinyint(1) NOT NULL default '0',
  C11N tinyint(1) NOT NULL default '0',
  C11D tinyint(1) NOT NULL default '0',
  C12N tinyint(1) NOT NULL default '0',
  C12D tinyint(1) NOT NULL default '0',
  C13N tinyint(1) NOT NULL default '0',
  C13D tinyint(1) NOT NULL default '0',
  C14N tinyint(1) NOT NULL default '0',
  C14D tinyint(1) NOT NULL default '0',
  C15N tinyint(1) NOT NULL default '0',
  C15D tinyint(1) NOT NULL default '0',
  C16N tinyint(1) NOT NULL default '0',
  C16D tinyint(1) NOT NULL default '0',
  C17N tinyint(1) NOT NULL default '0',
  C17D tinyint(1) NOT NULL default '0',
  C18N tinyint(1) NOT NULL default '0',
  C18D tinyint(1) NOT NULL default '0',
  C19N tinyint(1) NOT NULL default '0',
  C19D tinyint(1) NOT NULL default '0',
  t1N tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (visitDate,patientID),
  KEY idx_patientID (patientID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
go

