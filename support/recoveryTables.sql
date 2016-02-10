-- phpMyAdmin SQL Dump
-- version 2.11.8.1deb5+lenny9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 22, 2016 at 03:58 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6-1+lenny16

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `itech`
--

-- --------------------------------------------------------

--
-- Table structure for table `bloodeval1`
--

CREATE TABLE IF NOT EXISTS `bloodeval1` (
  `patientid` varchar(11) NOT NULL,
  `visitdate` datetime NOT NULL,
  `seqNum` tinyint(3) unsigned NOT NULL,
  `labid1` int(10) unsigned default NULL,
  `labid2` int(10) unsigned default NULL,
  `labid3` int(10) unsigned default NULL,
  `labid4` int(10) unsigned default NULL,
  `labid5` int(10) unsigned default NULL,
  KEY `bloodeval1Idx` (`patientid`,`visitdate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bloodeval2`
--

CREATE TABLE IF NOT EXISTS `bloodeval2` (
  `patientid` varchar(11) NOT NULL,
  `visitdate` datetime NOT NULL,
  `seqNum` tinyint(3) unsigned NOT NULL,
  `labid1` int(10) unsigned default NULL,
  `labid2` int(10) unsigned default NULL,
  `labid3` int(10) unsigned default NULL,
  `labid4` int(10) unsigned default NULL,
  KEY `bloodeval2Idx` (`patientid`,`visitdate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cd4Table`
--

CREATE TABLE IF NOT EXISTS `cd4Table` (
  `siteCode` mediumint(8) unsigned default NULL,
  `patientid` varchar(11) default NULL,
  `visitdate` datetime default NULL,
  `cd4` int(10) unsigned default NULL,
  `encounter_id` int(10) unsigned default NULL,
  `encounterType` tinyint(3) unsigned default NULL,
  `formVersion` tinyint(3) unsigned default NULL,
  KEY `cd4TableIndex` (`patientid`,`visitdate`),
  KEY `cd4Index` (`cd4`,`patientid`,`visitdate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cd4Temp`
--

CREATE TABLE IF NOT EXISTS `cd4Temp` (
  `siteCode` mediumint(8) unsigned default NULL,
  `patientid` varchar(11) default NULL,
  `visitdate` datetime default NULL,
  `cd4` int(10) unsigned default NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `discTable`
--

CREATE TABLE IF NOT EXISTS `discTable` (
  `sitecode` mediumint(8) unsigned default NULL,
  `patientid` varchar(11) default NULL,
  `discDate` datetime default NULL,
  `discType` int(10) unsigned default NULL,
  KEY `discTableIdx` (`patientid`,`discDate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `drugSummaryAll`
--

CREATE TABLE IF NOT EXISTS `drugSummaryAll` (
  `patientid` varchar(11) default NULL,
  `drugID` int(10) unsigned default NULL,
  `forPepPmtct` tinyint(3) unsigned default NULL,
  `startDate` datetime default NULL,
  `stopDate` datetime default NULL,
  `toxicity` tinyint(3) unsigned default NULL,
  `intolerance` tinyint(3) unsigned default NULL,
  `failureVir` tinyint(3) unsigned default NULL,
  `failureImm` tinyint(3) unsigned default NULL,
  `failureClin` tinyint(3) unsigned default NULL,
  `stockOut` tinyint(3) unsigned default NULL,
  `pregnancy` tinyint(3) unsigned default NULL,
  `patientHospitalized` tinyint(3) unsigned default NULL,
  `lackMoney` tinyint(3) unsigned default NULL,
  `alternativeTreatments` tinyint(3) unsigned default NULL,
  `missedVisit` tinyint(3) unsigned default NULL,
  `patientPreference` tinyint(3) unsigned default NULL,
  `prophDose` tinyint(3) unsigned default NULL,
  `failureProph` tinyint(3) unsigned default NULL,
  `interUnk` tinyint(3) unsigned default NULL,
  `finPTME` tinyint(3) unsigned default NULL,
  KEY `drugSummaryINDEX` (`patientid`,`drugID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `drugTableAll`
--

CREATE TABLE IF NOT EXISTS `drugTableAll` (
  `sitecode` mediumint(8) unsigned default NULL,
  `patientid` varchar(11) default NULL,
  `visitdate` datetime default NULL,
  `drugID` int(10) unsigned default NULL,
  `forPepPmtct` tinyint(3) unsigned default NULL,
  KEY `drugTableINDEX` (`patientid`,`drugID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dw_dataquality_patients`
--

CREATE TABLE IF NOT EXISTS `dw_dataquality_patients` (
  `indicator` smallint(10) NOT NULL,
  `time_period` varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  `period` smallint(6) NOT NULL,
  `patientid` varchar(11) NOT NULL,
  PRIMARY KEY  (`indicator`,`time_period`,`year`,`period`,`patientid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dw_dataquality_slices`
--

CREATE TABLE IF NOT EXISTS `dw_dataquality_slices` (
  `org_unit` varchar(64) NOT NULL,
  `org_value` varchar(255) NOT NULL,
  `indicator` smallint(6) NOT NULL,
  `time_period` varchar(16) NOT NULL,
  `year` smallint(5) unsigned NOT NULL,
  `period` smallint(5) unsigned NOT NULL,
  `gender` tinyint(3) unsigned NOT NULL,
  `value` decimal(9,1) default '0.0',
  `denominator` decimal(9,1) default '0.0',
  PRIMARY KEY  (`org_unit`,`org_value`,`indicator`,`time_period`,`year`,`period`,`gender`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dw_dataquality_snapshot`
--

CREATE TABLE IF NOT EXISTS `dw_dataquality_snapshot` (
  `patientID` varchar(11) NOT NULL,
  `visitDate` date NOT NULL default '0000-00-00',
  `A1D` tinyint(1) NOT NULL default '0',
  `A1N` tinyint(1) NOT NULL default '0',
  `A2N` tinyint(1) NOT NULL default '0',
  `A3N` tinyint(1) NOT NULL default '0',
  `A4N` tinyint(1) NOT NULL default '0',
  `A5N` tinyint(1) NOT NULL default '0',
  `A6N` tinyint(1) NOT NULL default '0',
  `A7N` tinyint(1) NOT NULL default '0',
  `A7D` tinyint(1) NOT NULL default '0',
  `A8N` tinyint(1) NOT NULL default '0',
  `A8D` tinyint(1) NOT NULL default '0',
  `A9N` tinyint(1) NOT NULL default '0',
  `A9D` tinyint(1) NOT NULL default '0',
  `A10N` tinyint(1) NOT NULL default '0',
  `A10D` tinyint(1) NOT NULL default '0',
  `A11D` tinyint(1) NOT NULL default '0',
  `A11N` tinyint(1) NOT NULL default '0',
  `A12N` tinyint(1) NOT NULL default '0',
  `A13N` tinyint(1) NOT NULL default '0',
  `A14D` tinyint(1) NOT NULL default '0',
  `A14N` tinyint(1) NOT NULL default '0',
  `A15N` tinyint(1) NOT NULL default '0',
  `A16N` tinyint(1) NOT NULL default '0',
  `A17N` tinyint(1) NOT NULL default '0',
  `A18N` tinyint(1) NOT NULL default '0',
  `A18D` tinyint(1) NOT NULL default '0',
  `A19N` tinyint(1) NOT NULL default '0',
  `A19D` tinyint(1) NOT NULL default '0',
  `A20D` tinyint(1) NOT NULL default '0',
  `A20N` tinyint(1) NOT NULL default '0',
  `C1D` tinyint(1) NOT NULL default '0',
  `C1N` tinyint(1) NOT NULL default '0',
  `C2D` tinyint(1) NOT NULL default '0',
  `C2N` tinyint(1) NOT NULL default '0',
  `C3D` tinyint(1) NOT NULL default '0',
  `C3N` tinyint(1) NOT NULL default '0',
  `C4D` tinyint(1) NOT NULL default '0',
  `C4N` tinyint(1) NOT NULL default '0',
  `C5D` tinyint(1) NOT NULL default '0',
  `C5N` tinyint(1) NOT NULL default '0',
  `C6D` tinyint(1) NOT NULL default '0',
  `C6N` tinyint(1) NOT NULL default '0',
  `C7D` tinyint(1) NOT NULL default '0',
  `C7N` tinyint(1) NOT NULL default '0',
  `C8D` tinyint(1) NOT NULL default '0',
  `C8N` tinyint(1) NOT NULL default '0',
  `C9D` tinyint(1) NOT NULL default '0',
  `C9N` tinyint(1) NOT NULL default '0',
  `C10D` tinyint(1) NOT NULL default '0',
  `C10N` tinyint(1) NOT NULL default '0',
  `C11N` tinyint(1) NOT NULL default '0',
  `C11D` tinyint(1) NOT NULL default '0',
  `C12N` tinyint(1) NOT NULL default '0',
  `C12D` tinyint(1) NOT NULL default '0',
  `C13N` tinyint(1) NOT NULL default '0',
  `C13D` tinyint(1) NOT NULL default '0',
  `C14N` tinyint(1) NOT NULL default '0',
  `C14D` tinyint(1) NOT NULL default '0',
  `C15N` tinyint(1) NOT NULL default '0',
  `C15D` tinyint(1) NOT NULL default '0',
  `C16N` tinyint(1) NOT NULL default '0',
  `C16D` tinyint(1) NOT NULL default '0',
  `C17N` tinyint(1) NOT NULL default '0',
  `C17D` tinyint(1) NOT NULL default '0',
  `C18N` tinyint(1) NOT NULL default '0',
  `C18D` tinyint(1) NOT NULL default '0',
  `C19N` tinyint(1) NOT NULL default '0',
  `C19D` tinyint(1) NOT NULL default '0',
  `t1N` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`visitDate`,`patientID`),
  KEY `idx_patientID` (`patientID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dw_encounter_snapshot`
--

CREATE TABLE IF NOT EXISTS `dw_encounter_snapshot` (
  `siteCode` mediumint(8) unsigned NOT NULL,
  `patientID` varchar(11) NOT NULL,
  `visitdate` date default NULL,
  `encounter_id` int(10) unsigned NOT NULL default '0',
  `dbSite` tinyint(3) unsigned NOT NULL default '0',
  `lastModified` datetime default NULL,
  PRIMARY KEY  USING BTREE (`encounter_id`,`dbSite`),
  KEY `lastModifiedSnapshotIndex` (`lastModified`,`encounter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dw_hivstatus_patients`
--

CREATE TABLE IF NOT EXISTS `dw_hivstatus_patients` (
  `indicator` smallint(10) NOT NULL,
  `time_period` varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  `period` smallint(6) NOT NULL,
  `patientid` varchar(11) NOT NULL,
  PRIMARY KEY  (`indicator`,`patientid`,`time_period`,`year`,`period`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dw_hivstatus_slices`
--

CREATE TABLE IF NOT EXISTS `dw_hivstatus_slices` (
  `org_unit` varchar(50) NOT NULL,
  `org_value` varchar(50) NOT NULL,
  `indicator` smallint(10) NOT NULL,
  `time_period` varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  `period` smallint(6) NOT NULL,
  `gender` tinyint(3) unsigned NOT NULL,
  `value` float default '0',
  `denominator` float default '0',
  PRIMARY KEY  (`org_unit`,`org_value`,`indicator`,`time_period`,`year`,`period`,`gender`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dw_hivstatus_snapshot`
--

CREATE TABLE IF NOT EXISTS `dw_hivstatus_snapshot` (
  `patientID` varchar(11) NOT NULL,
  `visitDate` date NOT NULL default '0000-00-00',
  `new_palliatifs` tinyint(1) NOT NULL default '0',
  `actif_palliatifs` tinyint(1) NOT NULL default '0',
  `risque_palliatifs` tinyint(1) NOT NULL default '0',
  `inactif_palliatifs` tinyint(1) NOT NULL default '0',
  `disc_palliatifs` tinyint(1) NOT NULL default '0',
  `new_tar` tinyint(1) NOT NULL default '0',
  `actif_tar` tinyint(1) NOT NULL default '0',
  `risque_tar` tinyint(1) NOT NULL default '0',
  `inactif_tar` tinyint(1) NOT NULL default '0',
  `disc_tar` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`visitDate`,`patientID`),
  KEY `pidIndex` (`patientID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dw_malaria_patients`
--

CREATE TABLE IF NOT EXISTS `dw_malaria_patients` (
  `indicator` smallint(10) NOT NULL,
  `time_period` varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  `period` smallint(6) NOT NULL,
  `patientid` varchar(11) NOT NULL,
  PRIMARY KEY  (`indicator`,`patientid`,`time_period`,`year`,`period`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dw_malaria_slices`
--

CREATE TABLE IF NOT EXISTS `dw_malaria_slices` (
  `org_unit` varchar(50) NOT NULL,
  `org_value` varchar(50) NOT NULL,
  `indicator` smallint(10) NOT NULL,
  `time_period` varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  `period` smallint(6) NOT NULL,
  `gender` tinyint(3) unsigned NOT NULL,
  `value` bigint(20) default '0',
  `denominator` bigint(20) default '0',
  PRIMARY KEY  (`org_unit`,`org_value`,`indicator`,`time_period`,`year`,`period`,`gender`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dw_malaria_snapshot`
--

CREATE TABLE IF NOT EXISTS `dw_malaria_snapshot` (
  `visitdate` date NOT NULL default '0000-00-00',
  `patientid` varchar(11) NOT NULL,
  `malariaDxA` tinyint(1) NOT NULL default '0',
  `malariaDx` tinyint(1) NOT NULL default '0',
  `malariaDxG` tinyint(1) NOT NULL default '0',
  `malariaDxSuspectedA` tinyint(1) NOT NULL default '0',
  `malariaDxSuspected` tinyint(1) NOT NULL default '0',
  `malariaDxSuspectedG` tinyint(1) NOT NULL default '0',
  `isPregnant` tinyint(1) NOT NULL default '0',
  `sym_malariaLT` tinyint(1) NOT NULL default '0',
  `sym_malariaGT` tinyint(1) NOT NULL default '0',
  `feverLess2` tinyint(1) NOT NULL default '0',
  `feverGreat2` tinyint(1) NOT NULL default '0',
  `chloroquine` tinyint(1) NOT NULL default '0',
  `quinine` tinyint(1) NOT NULL default '0',
  `primaquine` tinyint(1) NOT NULL default '0',
  `convulsion` tinyint(1) NOT NULL default '0',
  `lethargy` tinyint(1) NOT NULL default '0',
  `hematuria` tinyint(1) NOT NULL default '0',
  `ictere` tinyint(1) NOT NULL default '0',
  `anemia` tinyint(1) NOT NULL default '0',
  `anemiaA` tinyint(1) NOT NULL default '0',
  `anemiaG` tinyint(1) NOT NULL default '0',
  `hemoglobine` float NOT NULL default '5000',
  `creatinine` float NOT NULL default '5000',
  `glycemie` float NOT NULL default '5000',
  `malariaTest` tinyint(1) NOT NULL default '0',
  `malariaTestRapid` tinyint(1) NOT NULL default '0',
  `rapidResultPositive` tinyint(1) NOT NULL default '0',
  `rapidResultNegative` tinyint(1) NOT NULL default '0',
  `smearResultPositive` tinyint(1) NOT NULL default '0',
  `smearResultNegative` tinyint(1) NOT NULL default '0',
  `testsOrdered` tinyint(1) NOT NULL default '0',
  `hospitalisation` tinyint(1) NOT NULL default '0',
  `FT` tinyint(1) NOT NULL default '0',
  `FG` tinyint(1) NOT NULL default '0',
  `Vx` tinyint(1) NOT NULL default '0',
  `Ov` tinyint(1) NOT NULL default '0',
  `Mai` tinyint(1) NOT NULL default '0',
  `highTemp` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`visitdate`,`patientid`),
  KEY `pidIndex` (`patientid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dw_mer_patients`
--

CREATE TABLE IF NOT EXISTS `dw_mer_patients` (
  `indicator` smallint(10) NOT NULL,
  `time_period` varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  `period` smallint(6) NOT NULL,
  `patientid` varchar(11) NOT NULL,
  PRIMARY KEY  (`indicator`,`patientid`,`time_period`,`year`,`period`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dw_mer_slices`
--

CREATE TABLE IF NOT EXISTS `dw_mer_slices` (
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

-- --------------------------------------------------------

--
-- Table structure for table `dw_mer_snapshot`
--

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
  `ARVstart` tinyint(4) default '0',
  PRIMARY KEY  (`patientID`,`visitDate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dw_nutrition_patients`
--

CREATE TABLE IF NOT EXISTS `dw_nutrition_patients` (
  `indicator` smallint(6) NOT NULL,
  `time_period` varchar(16) NOT NULL,
  `year` smallint(5) unsigned NOT NULL,
  `period` smallint(5) unsigned NOT NULL,
  `patientid` varchar(11) NOT NULL,
  PRIMARY KEY  (`indicator`,`patientid`,`time_period`,`year`,`period`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dw_nutrition_slices`
--

CREATE TABLE IF NOT EXISTS `dw_nutrition_slices` (
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

-- --------------------------------------------------------

--
-- Table structure for table `dw_nutrition_snapshot`
--

CREATE TABLE IF NOT EXISTS `dw_nutrition_snapshot` (
  `patientID` varchar(11) NOT NULL,
  `visitDate` date NOT NULL default '0000-00-00',
  `ageInMos` smallint(5) unsigned NOT NULL,
  `wtInKgs` decimal(5,2) NOT NULL default '0.00',
  `htInMeters` decimal(4,2) NOT NULL default '0.00',
  `bmi` decimal(4,2) NOT NULL default '0.00',
  `nutritionalEdema` tinyint(3) unsigned NOT NULL default '0',
  `armCirc` decimal(5,2) NOT NULL default '0.00',
  PRIMARY KEY  (`visitDate`,`patientID`),
  KEY `pidIdx` (`patientID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dw_obgyn_patients`
--

CREATE TABLE IF NOT EXISTS `dw_obgyn_patients` (
  `indicator` smallint(6) NOT NULL,
  `time_period` varchar(16) NOT NULL,
  `year` smallint(5) unsigned NOT NULL,
  `period` smallint(5) unsigned NOT NULL,
  `patientid` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dw_obgyn_slices`
--

CREATE TABLE IF NOT EXISTS `dw_obgyn_slices` (
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

-- --------------------------------------------------------

--
-- Table structure for table `dw_obgyn_snapshot`
--

CREATE TABLE IF NOT EXISTS `dw_obgyn_snapshot` (
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

-- --------------------------------------------------------

--
-- Table structure for table `dw_tb_patients`
--

CREATE TABLE IF NOT EXISTS `dw_tb_patients` (
  `indicator` smallint(10) NOT NULL,
  `time_period` varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  `period` smallint(6) NOT NULL,
  `patientid` varchar(11) NOT NULL,
  PRIMARY KEY  (`indicator`,`patientid`,`time_period`,`year`,`period`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dw_tb_slices`
--

CREATE TABLE IF NOT EXISTS `dw_tb_slices` (
  `org_unit` varchar(50) NOT NULL,
  `org_value` varchar(50) NOT NULL,
  `indicator` smallint(10) NOT NULL,
  `time_period` varchar(10) NOT NULL,
  `year` int(11) NOT NULL,
  `period` smallint(6) NOT NULL,
  `gender` tinyint(3) unsigned NOT NULL,
  `value` float default '0',
  `denominator` float default '0',
  PRIMARY KEY  (`org_unit`,`org_value`,`indicator`,`time_period`,`year`,`period`,`gender`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dw_tb_snapshot`
--

CREATE TABLE IF NOT EXISTS `dw_tb_snapshot` (
  `patientID` varchar(11) NOT NULL,
  `visitDate` date NOT NULL default '0000-00-00',
  `dxMDRtb` tinyint(1) NOT NULL default '0',
  `dxMDRtbA` tinyint(1) NOT NULL default '0',
  `dxTB` tinyint(1) NOT NULL default '0',
  `dxTBA` tinyint(1) NOT NULL default '0',
  `dyspnea` tinyint(1) NOT NULL default '0',
  `propCotrimoxazole` tinyint(1) NOT NULL default '0',
  `tbArvYN` tinyint(1) NOT NULL default '0',
  `tbClassExtra` tinyint(1) NOT NULL default '0',
  `tbClassPulmonaire` tinyint(1) NOT NULL default '0',
  `tbDxClinique` tinyint(1) NOT NULL default '0',
  `tbDxCrachat` tinyint(1) NOT NULL default '0',
  `tbDxNew` tinyint(1) NOT NULL default '0',
  `tbRegistrationDt` tinyint(1) NOT NULL default '0',
  `tbDxXray` tinyint(1) NOT NULL default '0',
  `tbMaladeNew` tinyint(1) NOT NULL default '0',
  `tbMaladeRechute` tinyint(1) NOT NULL default '0',
  `tbMeningite` tinyint(1) NOT NULL default '0',
  `tbGenitale` tinyint(1) NOT NULL default '0',
  `tbPleurale` tinyint(1) NOT NULL default '0',
  `tbMiliaire` tinyint(1) NOT NULL default '0',
  `tbGanglionnaire` tinyint(1) NOT NULL default '0',
  `tbIntestinale` tinyint(1) NOT NULL default '0',
  `tbClassOther` tinyint(1) NOT NULL default '0',
  `tbPrestataire` tinyint(1) NOT NULL default '0',
  `tbEvalresult0` tinyint(1) NOT NULL default '0',
  `tbEvalresult2` tinyint(1) NOT NULL default '0',
  `tbEvalresult3` tinyint(1) NOT NULL default '0',
  `tbEvalresult5` tinyint(1) NOT NULL default '0',
  `tbEvalresultFin` tinyint(1) NOT NULL default '0',
  `tbStartTreatment` tinyint(1) NOT NULL default '0',
  `tbStopReason` int(11) NOT NULL default '0',
  `tbTestVIH` tinyint(1) NOT NULL default '0',
  `touxGreat2` tinyint(1) NOT NULL default '0',
  `crachat` tinyint(1) NOT NULL default '0',
  `xray` tinyint(1) NOT NULL default '0',
  `tbRegimen` tinyint(1) NOT NULL default '0',
  `hemoptysie` tinyint(1) NOT NULL default '0',
  `perteDePoid` tinyint(1) NOT NULL default '0',
  `feverLess2` tinyint(1) NOT NULL default '0',
  `feverGreat2` tinyint(1) NOT NULL default '0',
  `ethambutol` tinyint(1) NOT NULL default '0',
  `isoniazid` tinyint(1) NOT NULL default '0',
  `pyrazinamide` tinyint(1) NOT NULL default '0',
  `rifampicine` tinyint(1) NOT NULL default '0',
  `streptomycine` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`visitDate`,`patientID`),
  KEY `pidIdx` (`patientID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `patientStatusTemp`
--

CREATE TABLE IF NOT EXISTS `patientStatusTemp` (
  `patientID` varchar(11) default NULL,
  `patientStatus` int(11) default NULL,
  `endDate` date NOT NULL,
  `insertDate` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  KEY `patientStatusTempIndex` (`endDate`,`patientID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pepfarRecords`
--

CREATE TABLE IF NOT EXISTS `pepfarRecords` (
  `id` int(10) unsigned default NULL,
  `recType` int(10) unsigned default NULL,
  `col1` varchar(300) default NULL,
  `col2` varchar(300) default NULL,
  `col3` varchar(300) default NULL,
  `col4` varchar(300) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE eventLog (
  eventLog_id int unsigned  NOT NULL AUTO_INCREMENT,
  dbSite tinyint unsigned NOT NULL,
  siteCode mediumint unsigned NOT NULL ,
  username varchar (20) NOT NULL ,
  eventDate datetime NOT NULL,
  eventType varchar (20) NOT NULL,
  eventParameters text NOT NULL,
  primary key (eventLog_id, siteCode, username, eventDate)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE pepfarTable (
  siteCode mediumint unsigned NULL,
  patientid VARCHAR(11) NULL,
  visitDate DATETIME NULL,
  regimen VARCHAR(25) NULL,
  forPepPmtct tinyint unsigned NULL,
  INDEX pepfarTable22 (patientid, visitDate)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE lastSplash (
       lastSplashDate datetime default NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into lastSplash (lastSplashDate) values ('1970-01-01');

CREATE TABLE lastSplashText (
 lastSplashText_id int unsigned NOT NULL auto_increment,
 splashText varchar(200) default NULL,
 PRIMARY KEY  (`lastSplashText_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE lastMarkers2 (
 lastMarkersDate datetime NOT NULL,
 markerText mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS dw_pregnancy_ranges (
  patientID varchar(11) NOT NULL,
  startDate date NOT NULL default '0000-00-00',
  stopDate date default NULL,
  PRIMARY KEY  (patientID, startDate),
  KEY pidIdx (patientID)
) ENGINE=InnoDB
CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE IF NOT EXISTS healthQual (
  lastRun DATETIME,
  startDate DATETIME,
  endDate DATETIME,
  siteCode mediumint unsigned NULL,
  casesM mediumint unsigned NULL,
  casesF mediumint unsigned NULL,
  ind01_num_m mediumint unsigned NULL,
  ind01_num_f mediumint unsigned NULL,
  ind01_num_total mediumint unsigned NULL,
  ind01_den_m mediumint unsigned NULL,
  ind01_den_f mediumint unsigned NULL,
  ind01_den_total mediumint unsigned NULL,
  ind01_ratio_m VARCHAR(8) NULL,
  ind01_ratio_f VARCHAR(8) NULL,
  ind01_ratio_total VARCHAR(8) NULL,
  ind02_num_m mediumint unsigned NULL,
  ind02_num_f mediumint unsigned NULL,
  ind02_num_total mediumint unsigned NULL,
  ind02_den_m mediumint unsigned NULL,
  ind02_den_f mediumint unsigned NULL,
  ind02_den_total mediumint unsigned NULL,
  ind02_ratio_m VARCHAR(8) NULL,
  ind02_ratio_f VARCHAR(8) NULL,
  ind02_ratio_total VARCHAR(8) NULL,
  ind03_num_m mediumint unsigned NULL,
  ind03_num_f mediumint unsigned NULL,
  ind03_num_total mediumint unsigned NULL,
  ind03_den_m mediumint unsigned NULL,
  ind03_den_f mediumint unsigned NULL,
  ind03_den_total mediumint unsigned NULL,
  ind03_ratio_m VARCHAR(8) NULL,
  ind03_ratio_f VARCHAR(8) NULL,
  ind03_ratio_total VARCHAR(8) NULL,
  ind04_num_m mediumint unsigned NULL,
  ind04_num_f mediumint unsigned NULL,
  ind04_num_total mediumint unsigned NULL,
  ind04_den_m mediumint unsigned NULL,
  ind04_den_f mediumint unsigned NULL,
  ind04_den_total mediumint unsigned NULL,
  ind04_ratio_m VARCHAR(8) NULL,
  ind04_ratio_f VARCHAR(8) NULL,
  ind04_ratio_total VARCHAR(8) NULL,
  ind05_num_m mediumint unsigned NULL,
  ind05_num_f mediumint unsigned NULL,
  ind05_num_total mediumint unsigned NULL,
  ind05_den_m mediumint unsigned NULL,
  ind05_den_f mediumint unsigned NULL,
  ind05_den_total mediumint unsigned NULL,
  ind05_ratio_m VARCHAR(8) NULL,
  ind05_ratio_f VARCHAR(8) NULL,
  ind05_ratio_total VARCHAR(8) NULL,
  ind06_num_m mediumint unsigned NULL,
  ind06_num_f mediumint unsigned NULL,
  ind06_num_total mediumint unsigned NULL,
  ind06_den_m mediumint unsigned NULL,
  ind06_den_f mediumint unsigned NULL,
  ind06_den_total mediumint unsigned NULL,
  ind06_ratio_m VARCHAR(8) NULL,
  ind06_ratio_f VARCHAR(8) NULL,
  ind06_ratio_total VARCHAR(8) NULL,
  ind07_num_m mediumint unsigned NULL,
  ind07_num_f mediumint unsigned NULL,
  ind07_num_total mediumint unsigned NULL,
  ind07_den_m mediumint unsigned NULL,
  ind07_den_f mediumint unsigned NULL,
  ind07_den_total mediumint unsigned NULL,
  ind07_ratio_m VARCHAR(8) NULL,
  ind07_ratio_f VARCHAR(8) NULL,
  ind07_ratio_total VARCHAR(8) NULL,
  ind08_num_m mediumint unsigned NULL,
  ind08_num_f mediumint unsigned NULL,
  ind08_num_total mediumint unsigned NULL,
  ind08_den_m mediumint unsigned NULL,
  ind08_den_f mediumint unsigned NULL,
  ind08_den_total mediumint unsigned NULL,
  ind08_ratio_m VARCHAR(8) NULL,
  ind08_ratio_f VARCHAR(8) NULL,
  ind08_ratio_total VARCHAR(8) NULL,
  ind09_num_m mediumint unsigned NULL,
  ind09_num_f mediumint unsigned NULL,
  ind09_num_total mediumint unsigned NULL,
  ind09_den_m mediumint unsigned NULL,
  ind09_den_f mediumint unsigned NULL,
  ind09_den_total mediumint unsigned NULL,
  ind09_ratio_m VARCHAR(8) NULL,
  ind09_ratio_f VARCHAR(8) NULL,
  ind09_ratio_total VARCHAR(8) NULL,
  ind10_num_m mediumint unsigned NULL,
  ind10_num_f mediumint unsigned NULL,
  ind10_num_total mediumint unsigned NULL,
  ind10_den_m mediumint unsigned NULL,
  ind10_den_f mediumint unsigned NULL,
  ind10_den_total mediumint unsigned NULL,
  ind10_ratio_m VARCHAR(8) NULL,
  ind10_ratio_f VARCHAR(8) NULL,
  ind10_ratio_total VARCHAR(8) NULL,
  ind11_num_m mediumint unsigned NULL,
  ind11_num_f mediumint unsigned NULL,
  ind11_num_total mediumint unsigned NULL,
  ind11_den_m mediumint unsigned NULL,
  ind11_den_f mediumint unsigned NULL,
  ind11_den_total mediumint unsigned NULL,
  ind11_ratio_m VARCHAR(8) NULL,
  ind11_ratio_f VARCHAR(8) NULL,
  ind11_ratio_total VARCHAR(8) NULL,
  ind12_num_m mediumint unsigned NULL,
  ind12_num_f mediumint unsigned NULL,
  ind12_num_total mediumint unsigned NULL,
  ind12_den_m mediumint unsigned NULL,
  ind12_den_f mediumint unsigned NULL,
  ind12_den_total mediumint unsigned NULL,
  ind12_ratio_m VARCHAR(8) NULL,
  ind12_ratio_f VARCHAR(8) NULL,
  ind12_ratio_total VARCHAR(8) NULL,
  ind13_num_m mediumint unsigned NULL,
  ind13_num_f mediumint unsigned NULL,
  ind13_num_total mediumint unsigned NULL,
  ind13_den_m mediumint unsigned NULL,
  ind13_den_f mediumint unsigned NULL,
  ind13_den_total mediumint unsigned NULL,
  ind13_ratio_m VARCHAR(8) NULL,
  ind13_ratio_f VARCHAR(8) NULL,
  ind13_ratio_total VARCHAR(8) NULL,
  ind14_num_m mediumint unsigned NULL,
  ind14_num_f mediumint unsigned NULL,
  ind14_num_total mediumint unsigned NULL,
  ind14_den_m mediumint unsigned NULL,
  ind14_den_f mediumint unsigned NULL,
  ind14_den_total mediumint unsigned NULL,
  ind14_ratio_m VARCHAR(8) NULL,
  ind14_ratio_f VARCHAR(8) NULL,
  ind14_ratio_total VARCHAR(8) NULL,
  ind15_num_m mediumint unsigned NULL,
  ind15_num_f mediumint unsigned NULL,
  ind15_num_total mediumint unsigned NULL,
  ind15_den_m mediumint unsigned NULL,
  ind15_den_f mediumint unsigned NULL,
  ind15_den_total mediumint unsigned NULL,
  ind15_ratio_m VARCHAR(8) NULL,
  ind15_ratio_f VARCHAR(8) NULL,
  ind15_ratio_total VARCHAR(8) NULL,
  ind16_num_m mediumint unsigned NULL,
  ind16_num_f mediumint unsigned NULL,
  ind16_num_total mediumint unsigned NULL,
  ind16_den_m mediumint unsigned NULL,
  ind16_den_f mediumint unsigned NULL,
  ind16_den_total mediumint unsigned NULL,
  ind16_ratio_m VARCHAR(8) NULL,
  ind16_ratio_f VARCHAR(8) NULL,
  ind16_ratio_total VARCHAR(8) NULL,
  ind17_num_m mediumint unsigned NULL,
  ind17_num_f mediumint unsigned NULL,
  ind17_num_total mediumint unsigned NULL,
  ind17_den_m mediumint unsigned NULL,
  ind17_den_f mediumint unsigned NULL,
  ind17_den_total mediumint unsigned NULL,
  ind17_ratio_m VARCHAR(8) NULL,
  ind17_ratio_f VARCHAR(8) NULL,
  ind17_ratio_total VARCHAR(8) NULL,
  ind18_num_m mediumint unsigned NULL,
  ind18_num_f mediumint unsigned NULL,
  ind18_num_total mediumint unsigned NULL,
  ind18_den_m mediumint unsigned NULL,
  ind18_den_f mediumint unsigned NULL,
  ind18_den_total mediumint unsigned NULL,
  ind18_ratio_m VARCHAR(8) NULL,
  ind18_ratio_f VARCHAR(8) NULL,
  ind18_ratio_total VARCHAR(8) NULL,
  ind19_num_m mediumint unsigned NULL,
  ind19_num_f mediumint unsigned NULL,
  ind19_num_total mediumint unsigned NULL,
  ind19_den_m mediumint unsigned NULL,
  ind19_den_f mediumint unsigned NULL,
  ind19_den_total mediumint unsigned NULL,
  ind19_ratio_m VARCHAR(8) NULL,
  ind19_ratio_f VARCHAR(8) NULL,
  ind19_ratio_total VARCHAR(8) NULL,
  row_type TINYINT NULL,
  UNIQUE INDEX healthqualIndex (siteCode, startDate, endDate, row_type)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE IF NOT EXISTS hivQual (
  lastRun DATETIME,
  startDate DATETIME,
  endDate DATETIME,
  siteCode mediumint unsigned NULL,
  cases INT NULL,
  ind1_num INT NULL,
  ind1_den INT NULL,
  ind1_ratio VARCHAR(255) NULL,
  ind2_num INT NULL,
  ind2_den INT NULL,
  ind2_ratio VARCHAR(255) NULL,
  ind3_num INT NULL,
  ind3_den INT NULL,
  ind3_ratio VARCHAR(255) NULL,
  ind4A_num INT NULL,
  ind4A_den INT NULL,
  ind4A_ratio VARCHAR(255) NULL,
  ind4B_num INT NULL,
  ind4B_den INT NULL,
  ind4B_ratio VARCHAR(255) NULL,
  ind5_num INT NULL,
  ind5_den INT NULL,
  ind5_ratio VARCHAR(255) NULL,
  ind6_num INT NULL,
  ind6_den INT NULL,
  ind6_ratio VARCHAR(255) NULL,
  ind7_num INT NULL,
  ind7_den INT NULL,
  ind7_ratio VARCHAR(255) NULL,
  ind8_num INT NULL,
  ind8_den INT NULL,
  ind8_ratio VARCHAR(255) NULL,
  ind9_num INT NULL,
  ind9_den INT NULL,
  ind9_ratio VARCHAR(255) NULL,
  ind10_num INT NULL,
  ind10_den INT NULL,
  ind10_ratio VARCHAR(255) NULL,
  row_type TINYINT NULL,
  UNIQUE INDEX hivqualIndex (siteCode, startDate, endDate, row_type)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE IF NOT EXISTS staticReportData (
  runningSince DATETIME NULL ,
  connID INT UNSIGNED NULL ,
  reportNumber INT UNSIGNED NOT NULL ,
  username VARCHAR( 20 ) NOT NULL ,
  value1 TEXT NULL ,
  value2 TEXT NULL ,
  value3 TEXT NULL ,
  value4 TEXT NULL,
  INDEX staticReportDataIndex (reportNumber, username)
) ENGINE = InnoDB
CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE labMessageStorage (
  `labMessageStorage_id` int(10) unsigned NOT NULL auto_increment,
  `dbSite` tinyint unsigned not null,
  `senderName` varchar(255) default NULL,
  `senderSiteCode` mediumint(8) default NULL,
  `receiptDateTime` datetime NOT NULL,
  `originalXmitDateTime` datetime NOT NULL,
  `message` mediumblob,
  PRIMARY KEY  (`labMessageStorage_id`, `dbSite`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;
