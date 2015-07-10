
drop table if exists dw_mer_snapshot;

CREATE TABLE IF NOT EXISTS `dw_mer_snapshot` (
  `patientID` varchar(11) NOT NULL default '',
  `visitDate` date NOT NULL,
  `TBRegistered` tinyint(1) default '0',
  `tbTraetementStart` date default NULL,
  `tbTestVih` date default NULL,
  `tbArvDate` date default NULL,
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
