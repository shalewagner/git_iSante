-- phpMyAdmin SQL Dump
-- version 2.11.8.1deb5+lenny9
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mer 30 Mai 2012 à 09:00
-- Version du serveur: 5.0.51
-- Version de PHP: 5.2.6-1+lenny16cirg1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `datawarehouse`
--

-- --------------------------------------------------------

--
-- Structure de la table `dw_aggregated_patient`
--

CREATE TABLE IF NOT EXISTS `dw_aggregated_patient` (
  `clinic` int(11) default NULL,
  `department` int(11) default NULL,
  `sex` int(11) default NULL,
  `age` bigint(20) default NULL,
  `patientStatus` int(11) default NULL,
  `hivPositive` int(11) default NULL,
  `discontinuedReason` int(11) default NULL,
  `population` bigint(20) default NULL,
  `network` varchar(255) default NULL,
  `snapshot_date` datetime default NULL,
  `pregnant` tinyint(4) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dw_daily_patient`
--

CREATE TABLE IF NOT EXISTS `dw_daily_patient` (
  `clinic` int(11) default NULL,
  `patientID` varchar(11) default NULL,
  `age` decimal(18,0) default NULL,
  `sex` int(11) default NULL,
  `department` int(11) default NULL,
  `network` varchar(255) default NULL,
  `patientStatus` int(11) default NULL,
  `hivPositive` int(11) default NULL,
  `pregnant` tinyint(1) default NULL,
  `discontinuedReason` int(11) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `dw_snapshots`
--

CREATE TABLE IF NOT EXISTS `dw_snapshots` (
  `clinic` int(11) default NULL,
  `patientID` varchar(11) character set latin1 default NULL,
  `age` decimal(18,0) default NULL,
  `sex` int(11) default NULL,
  `department` int(11) default NULL,
  `network` varchar(255) character set latin1 default NULL,
  `patientStatus` int(11) default NULL,
  `hivPositive` int(11) default NULL,
  `pregnant` tinyint(2) default NULL,
  `discontinuedReason` int(11) default NULL,
  `snapshot_date` datetime NOT NULL default '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dw_departments`
--

CREATE TABLE IF NOT EXISTS `dw_departments` (
  `department` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY  (`department`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `dw_departments`
--

INSERT INTO `dw_departments` (`department`, `name`) VALUES
(1, 'Ouest'),
(2, 'Sud-est'),
(3, 'Nord'),
(4, 'Nord-est'),
(5, 'Artibonite'),
(6, 'Centre'),
(7, 'Sud'),
(8, 'Grande-anse'),
(9, 'Nord-ouest'),
(10, 'Nippes');

-- --------------------------------------------------------

--
-- Structure de la table `dw_visitLists`
--

CREATE TABLE IF NOT EXISTS `dw_visitLists` (
  `id` int(11) NOT NULL auto_increment,
  `encounterType` tinyint(3) NOT NULL,
  `list` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=134 ;

--
-- Contenu de la table `dw_visitLists`
--

INSERT INTO `dw_visitLists` (`id`, `encounterType`, `list`) VALUES
(1, 1, 'all'),
(2, 2, 'all'),
(3, 3, 'all'),
(4, 4, 'all'),
(5, 5, 'all'),
(6, 6, 'all'),
(7, 7, 'all'),
(8, 10, 'all'),
(9, 12, 'all'),
(10, 14, 'all'),
(11, 15, 'all'),
(12, 16, 'all'),
(13, 17, 'all'),
(14, 18, 'all'),
(15, 19, 'all'),
(16, 20, 'all'),
(17, 21, 'all'),
(18, 24, 'all'),
(19, 25, 'all'),
(20, 26, 'all'),
(21, 27, 'all'),
(22, 28, 'all'),
(23, 29, 'all'),
(24, 31, 'all'),
(25, 1, 'hivQual'),
(26, 2, 'hivQual'),
(27, 3, 'hivQual'),
(28, 4, 'hivQual'),
(29, 5, 'hivQual'),
(30, 6, 'hivQual'),
(31, 7, 'hivQual'),
(32, 10, 'hivQual'),
(33, 14, 'hivQual'),
(34, 15, 'hivQual'),
(35, 16, 'hivQual'),
(36, 17, 'hivQual'),
(37, 18, 'hivQual'),
(38, 19, 'hivQual'),
(39, 20, 'hivQual'),
(40, 1, 'firstAndFollowup'),
(41, 2, 'firstAndFollowup'),
(42, 16, 'firstAndFollowup'),
(43, 17, 'firstAndFollowup'),
(44, 24, 'firstAndFollowup'),
(45, 25, 'firstAndFollowup'),
(46, 27, 'firstAndFollowup'),
(47, 28, 'firstAndFollowup'),
(48, 29, 'firstAndFollowup'),
(49, 31, 'firstAndFollowup'),
(50, 16, 'sharedPcObPedHiv'),
(51, 17, 'sharedPcObPedHiv'),
(52, 24, 'sharedPcObPedHiv'),
(53, 25, 'sharedPcObPedHiv'),
(54, 27, 'sharedPcObPedHiv'),
(55, 28, 'sharedPcObPedHiv'),
(56, 29, 'sharedPcObPedHiv'),
(57, 31, 'sharedPcObPedHiv'),
(58, 1, 'sharedPcHiv'),
(59, 2, 'sharedPcHiv'),
(60, 16, 'sharedPcHiv'),
(61, 17, 'sharedPcHiv'),
(62, 27, 'sharedPcHiv'),
(63, 28, 'sharedPcHiv'),
(64, 29, 'sharedPcHiv'),
(65, 31, 'sharedPcHiv'),
(66, 1, 'sharedHivObConditions'),
(67, 2, 'sharedHivObConditions'),
(68, 16, 'sharedHivObConditions'),
(69, 17, 'sharedHivObConditions'),
(70, 24, 'sharedHivObConditions'),
(71, 25, 'sharedHivObConditions'),
(72, 1, 'sharedPcAdultHiv'),
(73, 2, 'sharedPcAdultHiv'),
(74, 27, 'sharedPcAdultHiv'),
(75, 28, 'sharedPcAdultHiv'),
(76, 29, 'sharedPcAdultHiv'),
(77, 31, 'sharedPcAdultHiv'),
(78, 16, 'sharedPcPedHiv'),
(79, 17, 'sharedPcPedHiv'),
(80, 27, 'sharedPcPedHiv'),
(81, 28, 'sharedPcPedHiv'),
(82, 29, 'sharedPcPedHiv'),
(83, 31, 'sharedPcPedHiv'),
(84, 24, 'sharedPcOb'),
(85, 25, 'sharedPcOb'),
(86, 27, 'sharedPcOb'),
(87, 28, 'sharedPcOb'),
(88, 29, 'sharedPcOb'),
(89, 31, 'sharedPcOb'),
(90, 1, 'hivFirstAndFollowup'),
(91, 2, 'hivFirstAndFollowup'),
(92, 16, 'hivFirstAndFollowup'),
(93, 17, 'hivFirstAndFollowup'),
(94, 1, 'sharedAdultPcAdultHiv'),
(95, 2, 'sharedAdultPcAdultHiv'),
(96, 27, 'sharedAdultPcAdultHiv'),
(97, 28, 'sharedAdultPcAdultHiv'),
(98, 24, 'sharedAdultPcOb'),
(99, 25, 'sharedAdultPcOb'),
(100, 27, 'sharedAdultPcOb'),
(101, 28, 'sharedAdultPcOb'),
(102, 2, 'followup'),
(103, 17, 'followup'),
(104, 28, 'followup'),
(105, 31, 'followup'),
(106, 27, 'primCare'),
(107, 28, 'primCare'),
(108, 29, 'primCare'),
(109, 31, 'primCare'),
(110, 24, 'obGyn'),
(111, 25, 'obGyn'),
(112, 26, 'obGyn'),
(113, 24, 'sharedAdultPcFirstOb'),
(114, 27, 'sharedAdultPcFirstOb'),
(115, 28, 'sharedAdultPcFirstOb'),
(116, 24, 'obGynFirstAndFollowup'),
(117, 25, 'obGynFirstAndFollowup'),
(118, 27, 'adultPc'),
(119, 28, 'adultPc'),
(120, 16, 'pedHivFirstAndFollowup'),
(121, 17, 'pedHivFirstAndFollowup'),
(122, 1, 'adultHivFirstAndFollowup'),
(123, 2, 'adultHivFirstAndFollowup'),
(124, 1, 'hivIntake'),
(125, 16, 'hivIntake'),
(126, 6, 'labs'),
(127, 19, 'labs'),
(128, 5, 'rxs'),
(129, 18, 'rxs'),
(130, 12, 'discontinuations'),
(131, 21, 'discontinuations'),
(132, 10, 'registrations'),
(133, 15, 'registrations');
