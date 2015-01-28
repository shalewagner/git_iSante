DROP TABLE IF EXISTS dw_weightForHeightLookup;
go
CREATE TABLE IF NOT EXISTS dw_weightForHeightLookup (
  maxAgeInYrs tinyint unsigned NOT NULL,
  gender char(1) NOT NULL,
  heightInCm decimal(5,2) NOT NULL,
  minus2Sd decimal(3,1),
  minus3Sd decimal(3,1),
  PRIMARY KEY  (maxAgeInYrs, gender, heightInCm)
) ENGINE=InnoDB
CHARACTER SET utf8 COLLATE utf8_general_ci;
go
DROP TABLE IF EXISTS dw_measureForAgeLookup;
go
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
go
DROP TABLE IF EXISTS dw_nutritionReportLookup;
go
CREATE TABLE IF NOT EXISTS dw_nutritionReportLookup (
  indicator smallint NOT NULL,
  indicatorType smallint NOT NULL,
  nameen varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL,
  namefr varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL,
  definitionen varchar(1024) character set utf8 collate utf8_unicode_ci NOT NULL,
  definitionfr varchar(1024) character set utf8 collate utf8_unicode_ci NOT NULL,
  indicatorDenominator smallint
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
go
DROP TABLE IF EXISTS dw_nutrition_patients;
go
CREATE TABLE IF NOT EXISTS dw_nutrition_patients (
  indicator smallint NOT NULL,
  time_period varchar(16) NOT NULL,
  `year` smallint unsigned NOT NULL,
  period smallint unsigned NOT NULL,
  patientid varchar(11) NOT NULL,
  PRIMARY KEY  (indicator, patientid, time_period, `year`, period)
) ENGINE=InnoDB
CHARACTER SET utf8 COLLATE utf8_general_ci;
go
DROP TABLE IF EXISTS dw_nutrition_slices;
go
CREATE TABLE IF NOT EXISTS dw_nutrition_slices (
  org_unit varchar(64) NOT NULL,
  org_value varchar(255) NOT NULL,
  indicator smallint NOT NULL,
  time_period varchar(16) NOT NULL,
  `year` smallint unsigned NOT NULL,
  period smallint unsigned NOT NULL,
  gender tinyint unsigned NOT NULL,
  `value` decimal(9,1) default '0',
  denominator decimal(9,1) default '0',
  PRIMARY KEY  (org_unit, org_value, indicator, time_period, `year`, period, gender)
) ENGINE=InnoDB
CHARACTER SET utf8 COLLATE utf8_general_ci;
go
DROP TABLE IF EXISTS dw_nutrition_snapshot;
go
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
go
DROP TABLE IF EXISTS dw_pregnancy_ranges;
go
CREATE TABLE IF NOT EXISTS dw_pregnancy_ranges (
  patientID varchar(11) NOT NULL,
  startDate date NOT NULL default '0000-00-00',
  stopDate date default NULL,
  PRIMARY KEY  (patientID, startDate),
  KEY pidIdx (patientID)
) ENGINE=InnoDB
CHARACTER SET utf8 COLLATE utf8_general_ci;
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
  gender tinyint unsigned NOT NULL, 
  `value` float default '0',
  denominator float default '0',
  PRIMARY KEY  (org_unit,org_value,indicator,time_period,`year`,period, gender)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go
DROP TABLE IF EXISTS dw_malariaReportLookup
go
CREATE TABLE IF NOT EXISTS dw_malariaReportLookup (
  indicator smallint(6) NOT NULL,
  indicatorType int NOT NULL,
  nameen varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL,
  namefr varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL,
  definitionen varchar(1024) character set utf8 collate utf8_unicode_ci NOT NULL,
  definitionfr varchar(1024) character set utf8 collate utf8_unicode_ci NOT NULL,
  data_elements varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go
DROP TABLE IF EXISTS dw_tbReportLookup
go
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go
DROP TABLE IF EXISTS dw_tb_patients
go
CREATE TABLE IF NOT EXISTS dw_tb_patients (
  indicator smallint(10) NOT NULL,
  time_period varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  period smallint(6) NOT NULL,
  patientid varchar(11) NOT NULL,
  PRIMARY KEY  (indicator,patientid,time_period,`year`,period)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go
DROP TABLE IF EXISTS dw_tb_slices
go
CREATE TABLE IF NOT EXISTS dw_tb_slices (
  org_unit varchar(50) NOT NULL,
  org_value varchar(50) NOT NULL,
  indicator smallint(10) NOT NULL,
  time_period varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  period smallint(6) NOT NULL,
  gender tinyint unsigned NOT NULL, 
  `value` float default '0',
  denominator float default '0',
  PRIMARY KEY  (org_unit,org_value,indicator,time_period,`year`,period, gender)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go
DROP TABLE IF EXISTS dw_tb_snapshot
go
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go
DROP TABLE IF EXISTS dw_malariaReportLookup
go
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
  testsOrdered  tinyint(1) NOT NULL default '0',
  hospitalisation tinyint(1) NOT NULL default '0',
  FT tinyint(1) NOT NULL default '0',
  FG tinyint(1) NOT NULL default '0',
  Vx tinyint(1) NOT NULL default '0',
  Ov tinyint(1) NOT NULL default '0',
  Mai tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (visitdate,patientid),
  KEY pidIndex (patientid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go

DROP TABLE IF EXISTS dw_hivstatusReportLookup
go
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go
DROP TABLE IF EXISTS dw_hivstatus_patients;
CREATE TABLE IF NOT EXISTS dw_hivstatus_patients (
  indicator smallint(10) NOT NULL,
  time_period varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  period smallint(6) NOT NULL,
  patientid varchar(11) NOT NULL,
  PRIMARY KEY  (indicator,patientid,time_period,`year`,period)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go
DROP TABLE IF EXISTS dw_hivstatus_slices
go
CREATE TABLE IF NOT EXISTS dw_hivstatus_slices (
  org_unit varchar(50) NOT NULL,
  org_value varchar(50) NOT NULL,
  indicator smallint(10) NOT NULL,
  time_period varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  period smallint(6) NOT NULL,
  gender tinyint unsigned NOT NULL, 
  `value` float default '0',
  denominator float default '0',
  PRIMARY KEY  (org_unit,org_value,indicator,time_period,`year`,period, gender)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go
DROP TABLE IF EXISTS dw_hivstatus_snapshot
go
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go
call AddColumnUnlessExists(Database(), 'patient', 'deathDt', 'datetime null')
go