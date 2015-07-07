
drop table if exists dw_mer_snapshot;

CREATE TABLE `dw_mer_snapshot` (
  `patientID` varchar(20) NOT NULL default '',
  `visitDate` varchar(20) NOT NULL default '',
  `TBRegistered` varchar(20) default NULL,
  `tbTraetementStart` varchar(20) default NULL,
  `tbTestVih` varchar(20) default NULL,
  `tbArvDate` varchar(20) default NULL,
  `vitalPb` varchar(20) default NULL,
  `tbOnArv` varchar(20) default NULL,
  `tbTraetment` varchar(20) default NULL,
  `pregnancy` varchar(20) default NULL,
  `HIVStatus` varchar(20) default NULL,
  `HIVForm` varchar(20) default NULL,
  `ARVPatient` varchar(20) default NULL,
  `newHIV` varchar(20) default NULL,
  `ipt` varchar(20) default NULL,
  `accouchement` varchar(20) default NULL,
  `virologicTest` varchar(20) default NULL,
  `viralLoad` varchar(20) default NULL,
  `stagingCd4Viralload` varchar(20) default NULL,
  `outcomeTb` varchar(20) default NULL,
  `tbSymptom` varchar(20) default NULL,
  `TX_UNDETECT_N` varchar(20) default NULL,
  `TX_UNDETECT_D` varchar(20) default NULL,
  `AntiRetroViral` varchar(20) default NULL,
  `statutVihActuel` varchar(20) default NULL,
  `linkToArv` varchar(20) default NULL,
  `cotrimoxazole` varchar(20) default NULL,
  `tbPrescription` varchar(20) default NULL,
  `isDeath` varchar(20) default NULL,
  `noFollowup` varchar(20) default NULL,
  `transfer` varchar(20) default NULL,
  `AnthroPrometrique` varchar(20) default NULL,
  `newEnrollArt` varchar(20) default NULL,
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
