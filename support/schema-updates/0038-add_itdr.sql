use `itech`;  

DROP TABLE if exists subjectlookup;
CREATE TABLE `subjectlookup` (
  `subjectid` int(10) unsigned NOT NULL,
  `subjectname` varchar(255) NOT NULL,
  PRIMARY KEY (`subjectID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE if exists fieldlookup;
CREATE TABLE `fieldlookup` (
  `fieldid` int(10) unsigned NOT NULL,
  `fieldname` varchar(255) NOT NULL,
  `displayname` varchar(255) NOT NULL,
  `subjectid` int(2) unsigned NOT NULL,
  `fieldtypeid` int(1) unsigned NOT NULL,
  `rawonly` int(1) unsigned NOT NULL,
  `aggregateonly` int(1) unsigned NOT NULL,
  `showinfieldlist` int(1) unsigned NOT NULL,
  PRIMARY KEY (`fieldId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE if exists fieldtypelookup;
CREATE TABLE `fieldtypelookup` (
  `fieldtypeid` int(10) unsigned NOT NULL,
  `fieldtypename` varchar(255) NOT NULL,
  PRIMARY KEY (`fieldtypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE if exists userindicatortype;
CREATE TABLE `userindicatortype` (
  `userindicatortypeid` int(1) unsigned NOT NULL,
  `userindicatortypename` varchar(255) NOT NULL,
  PRIMARY KEY (`userindicatortypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE if exists userindicator;
CREATE TABLE `userindicator` (
  `userindicatorid` int(10) NOT NULL AUTO_INCREMENT,
  `userindicatortypeid` int(1) NOT NULL,
  `subjectid` int(2) NOT NULL,
  `useridentifier` varchar(255) NOT NULL,
  `userindicatorname` varchar(255) NOT NULL,
  `agelevel` int(1) NOT NULL,
  `genderlevel` int(1) NOT NULL,
  `numeratorequation` varchar(255) NOT NULL,
  `denominatorequation` varchar(255) NOT NULL,
  PRIMARY KEY (`userindicatorId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `subjectlookup`
(`subjectid`,
`subjectname`)
VALUES
(1,"Malaria"),
(2,"Nutrition"),
(3,"Tuberculosis"),
(4,"Ob-gyn"),
(5,"Data Quality");

INSERT INTO `fieldtypelookup`
(`fieldtypeid`,
`fieldtypename`)
VALUES 
(1,"string"),
(2,"boolean"),
(3,"integer"),
(4,"float");

INSERT INTO `userindicatortype`
(`userindicatortypeid`,
`userindicatortypename`)
VALUES 
(1,"shared"),
(2,"user");

INSERT INTO `userindicator`
(`userindicatortypeid`,
`useridentifier`,
`subjectid`,
`userindicatorname`,
`agelevel`,
`genderlevel`,
`numeratorequation`,
`denominatorequation`)
VALUES 
(1, 'System', 1, 'Malaria Diagnoses', 0,0,'{malariadx} OR {malariadxa}','{allpatients}'),
(2, 'User 1',1,'Chloroquine Treatments', 1,0,'{chloroquine}','{allpatients}'),
(3, 'User 1',1,'Pregnant and Chloroquine', 0,2,'{ispregnant} AND {chloroquine}','{allpatients}'),
(4, 'User 1',1,'Pregnant and Confirmed Case', 0,2,'{ispregnant} AND {confirmedcase}','{allpatients}');

INSERT INTO `fieldlookup`
(`fieldid`,
`fieldname`,
`displayname`,
`fieldtypeid`,
`subjectid`,
`rawonly`,
`aggregateonly`,
`showinfieldlist`)
VALUES
    (1,"visitdate","Visit Date",1,1,1,0, 0),
    (2,"patientid","Patient Id",1,1,1,0, 0),
    (3,"malariadxa","New Diagnosis",2,1,0,0,1),
    (4,"malariadx","Existing Diagnosis",2,1,0,0,1),
    (9,"ispregnant","Is Pregnant",2,1,0,0,1),
    (12,"feverless2","Fever LT 2 weeks",2,1,0,0,1),
    (14,"chloroquine","Chloroquine",2,1,0,0,1),
    (15,"quinine","Quinine",2,1,0,0,1),
    (16,"primaquine","Primaquine",2,1,0,0,1),
    (29,"rapidresultpositive","Rapid Malaria Test Positive",2,1,0,0,1),
    (30,"rapidresultnegative","Rapid Malaria Test Negative",2,1,0,0,1),
    (31,"smearresultpositive","Microscopy Malaria Test Positive",2,1,0,0,1),
    (32,"smearresultnegative","Microscopy Malaria Test",2,1,0,0,1),
    (34,"hospitalisation","Is Hospitalized",2,1,0,0,1),
    (35,"ft","FT",2,1,0,0,1),
    (36,"fg","FG",2,1,0,0,1),
    (37,"vx","VX",2,1,0,0,1),
    (38,"ov","OV",2,1,0,0,1),
    (39,"mai","MAI",2,1,0,0,1),
    (40,"TimeLevel","Time Level",2,1,0,1,0),
    (41,"GeographyLevel","Geography Level",2,1,0,1,0),
    (42,"AgeLevel","Age Level",2,1,0,1,0),
    (43,"GenderLevel","Gender Level",2,1,0,1,0),
    (44,"department","",2,1,1,0,0),
    (45,"commune","",2,1,1,0,0),
    (46,"clinic","",2,1,1,0,0),
    (47,"category","",2,1,1,0,0),
    (48,"type","",2,1,1,0,0),
    (49,"sitecode","",2,1,1,0,0),
    (50,"sex","",2,1,1,0,0),
    (51,"gendertext","",2,1,1,0,0),
    (52,"ageyears","",2,1,1,0,0),
    (53,"agegroup","",2,1,1,0,0),
    (54,"agegrouptext","",2,1,1,0,0),
    (55,"confirmedcase","Confirmed Cases",2,1,0,0,1),
    (56,"alltreatments","All Treatments",2,1,0,0,1),
    (57,"singletreatment","Single Treatment",2,1,0,0,1),
    (58,"anytreatment","Any Treatment",2,1,0,0,1),
    (59,"positivefalciparumtest","Positive Falci. Test",2,1,0,0,1),
    (60,"positiveotherparasitetest","Positive Other Parasite Test",2,1,0,0,1);

DROP VIEW if exists vw_malaria;
CREATE ALGORITHM=UNDEFINED DEFINER=`itechapp`@`localhost` SQL SECURITY DEFINER VIEW `vw_malaria` AS select `s`.`visitdate` AS `visitdate`,`s`.`patientid` AS `patientid`,`s`.`malariaDxA` AS `malariadxa`,`s`.`malariaDx` AS `malariadx`,`s`.`isPregnant` AS `ispregnant`,`s`.`feverLess2` AS `feverless2`,`s`.`chloroquine` AS `chloroquine`,`s`.`quinine` AS `quinine`,`s`.`primaquine` AS `primaquine`,`s`.`rapidResultPositive` AS `rapidresultpositive`,`s`.`rapidResultNegative` AS `rapidresultnegative`,`s`.`smearResultPositive` AS `smearresultpositive`,`s`.`smearResultNegative` AS `smearresultnegative`,`s`.`hospitalisation` AS `hospitalisation`,`s`.`FT` AS `ft`,`s`.`FG` AS `fg`,`s`.`Vx` AS `vx`,`s`.`Ov` AS `ov`,`s`.`Mai` AS `mai`,`c`.`department` AS `department`,`c`.`commune` AS `commune`,`c`.`clinic` AS `clinic`,`c`.`category` AS `category`,`c`.`type` AS `type`,`c`.`siteCode` AS `sitecode`,`p`.`sex` AS `sex`,(case `p`.`sex` when 1 then 'Male' when 2 then 'Female' end) AS `gendertext`,`p`.`ageYears` AS `ageyears`,(case when isnull(`p`.`ageYears`) then NULL when (`p`.`ageYears` < 1) then 1 when (`p`.`ageYears` between 1 and 4) then 2 when (`p`.`ageYears` between 5 and 9) then 3 when (`p`.`ageYears` between 10 and 14) then 4 when (`p`.`ageYears` between 15 and 24) then 5 when (`p`.`ageYears` between 25 and 49) then 6 when (`p`.`ageYears` > 49) then 7 end) AS `ageGroup`,(case when isnull(`p`.`ageYears`) then NULL when (`p`.`ageYears` < 1) then ' <01' when (`p`.`ageYears` between 1 and 4) then '01-04' when (`p`.`ageYears` between 5 and 9) then '05-09' when (`p`.`ageYears` between 10 and 14) then '10-14' when (`p`.`ageYears` between 15 and 24) then '15-24' when (`p`.`ageYears` between 25 and 49) then '25-49' when (`p`.`ageYears` > 49) then '>49' end) AS `agegrouptext`,(case when ((((`s`.`malariaDx` + `s`.`malariaDxA`) + `s`.`rapidResultPositive`) + `s`.`smearResultPositive`) > 0) then 1 else 0 end) AS `confirmedcase`,(case when (((`s`.`chloroquine` + `s`.`primaquine`) + `s`.`quinine`) = 3) then 1 else 0 end) AS `alltreatments`,(case when (((`s`.`chloroquine` = 1) and ((`s`.`quinine` + `s`.`primaquine`) = 0)) or ((`s`.`primaquine` = 1) and ((`s`.`quinine` + `s`.`chloroquine`) = 0)) or ((`s`.`quinine` = 1) and ((`s`.`chloroquine` + `s`.`primaquine`) = 0))) then 1 else 0 end) AS `singletreatment`,(case when (((`s`.`chloroquine` + `s`.`primaquine`) + `s`.`quinine`) > 0) then 1 else 0 end) AS `anytreatment`,(case when ((`s`.`FT` + `s`.`FG`) > 0) then 1 else 0 end) AS `positivefalciparumtest`,(case when (((`s`.`Vx` + `s`.`Ov`) + `s`.`Mai`) > 0) then 1 else 0 end) AS `positiveotherparasitetest` from ((`dw_malaria_snapshot` `s` left join `clinicLookup` `c` on((substr(`s`.`patientid`,1,5) = `c`.`siteCode`))) left join `patient` `p` on((substr(`s`.`patientid`,6,10) = `p`.`person_id`)));

DROP PROCEDURE if exists GetMalariaData;
DELIMITER $$
CREATE DEFINER=`itechapp`@`localhost` PROCEDURE `GetMalariaData`(IN timeLevel INT, IN geographyLevel INT, IN ageLevel INT, IN genderLevel INT)
BEGIN

declare timeLevelString, geographyLevelString, ageLevelString, genderLevelString Varchar(50);
declare sqlstring varchar(5000);

case timeLevel
	when 0 then
		set @timeLevelString = "'All' as timeLevel";
	when 1 then
		set @timeLevelString = "Year(s.visitdate) as timeLevel";
	when 2 then
		set @timeLevelString = "Concat(Year(s.visitdate),'-',Quarter(s.visitdate)) as timeLevel";	
	when 3 then
		set @timeLevelString = "case length(Month(s.visitDate))
			when 1 then Concat(Year(s.visitdate),'-0',Month(s.visitdate))
			else  Concat(Year(s.visitdate),'-',Month(s.visitdate)) 
			end as timeLevel";
	when 4 then
		set @timeLevelString = "case length(Week(s.visitDate,3))
			when 1 then Concat(Year(s.visitdate),'-0',Week(s.visitdate,3))
			else  Concat(Year(s.visitdate),'-',Week(s.visitdate,3)) 
			end as timeLevel";
	end case;

case geographyLevel	
	when 0 then
		set @geographyLevelString = "'All' as geographyLevel";
	when 1 then
		set @geographyLevelString = "department as geographyLevel";
	when 2 then
		set @geographyLevelString = "commune as geographyLevel";
	when 3 then
		set @geographyLevelString = "sitecode as geographyLevel";
end case;

case ageLevel
	when 0 then
		set @ageLevelString = "'All' as ageLevel";
	when 1 then
		set @ageLevelString = "ageGroupText as ageLevel";
end case;

case genderLevel
	when 0 then
		set @genderLevelString = "'All' as genderLevel";
	when 1 then
		set @genderLevelString = "genderText as genderLevel";
end case;

set @sqlstring="select ";
set @sqlstring=concat(@sqlstring,@timeLevelString,",");
set @sqlstring=concat(@sqlstring,@geographyLevelString,",");
set @sqlstring=concat(@sqlstring,@ageLevelString,",");
set @sqlstring=concat(@sqlstring,@genderLevelString,",");
set @sqlstring=concat(@sqlstring, 
        "sum(s.malariadxa) AS malariadxa,
        sum(s.malariadx) AS malariadx,
        sum(s.ispregnant) AS ispregnant,
        sum(s.feverless2) AS feverless2,
        sum(s.chloroquine) AS chloroquine,
        sum(s.quinine) AS quinine,
        sum(s.primaquine) AS primaquine,
        sum(s.rapidresultpositive) AS rapidresultpositive,
        sum(s.rapidresultnegative) AS rapidresultnegative,
        sum(s.smearresultpositive) AS smearresultpositive,
        sum(s.smearresultnegative) AS smearresultnegative,
        sum(s.hospitalisation) AS hospitalisation,
        sum(s.ft) AS ft,
        sum(s.fg) AS fg,
        sum(s.vx) AS vx,
        sum(s.ov) AS ov,
        sum(s.mai) AS mai,
        sum(s.confirmedcase) AS confirmedcase,
        sum(s.alltreatments) AS alltreatments,
        sum(s.singletreatment) AS singletreatment,
        sum(s.anytreatment) AS anytreatment,
        sum(s.positivefalciparumtest) AS positivefalciparumtest,
        sum(s.positiveotherparasitetest) AS positiveotherparasitetest"
);
set @sqlstring=concat(@sqlstring," from vw_malaria s group by ");

set @sqlstring=concat(@sqlstring, "timeLevel, geographyLevel, ageLevel, genderLevel");

PREPARE stmt1 FROM @sqlstring; 
EXECUTE stmt1; 
DEALLOCATE PREPARE stmt1; 

END$$
DELIMITER ;
DROP PROCEDURE if exists GetMalariaDataWithWhereClause;
DELIMITER $$
CREATE DEFINER=`itechapp`@`localhost` PROCEDURE `GetMalariaDataWithWhereClause`(IN timeLevel INT, IN geographyLevel INT, IN ageLevel INT, IN genderLevel INT, IN whereClause Varchar(1000))
BEGIN

declare timeLevelString, geographyLevelString, ageLevelString, genderLevelString Varchar(50);
declare sqlstring varchar(5000);

case timeLevel
	when 0 then
		set @timeLevelString = "'All' as timeLevel";
	when 1 then
		set @timeLevelString = "Year(visitdate) as timeLevel";
	when 2 then
		set @timeLevelString = "Concat(Year(visitdate),'-',Quarter(visitdate)) as timeLevel";	
	when 3 then
		set @timeLevelString = "case length(Month(visitDate))
				when 1 then Concat(Year(visitdate),'-0',Month(visitdate))
				else  Concat(Year(visitdate),'-',Month(visitdate)) 
				end as timeLevel"; 
	when 4 then
		set @timeLevelString = "case length(Week(visitDate,3))
				when 1 then Concat(Year(visitdate),'-0',Week(visitdate,3))
				else  Concat(Year(visitdate),'-',Week(visitdate,3)) 
				end as timeLevel";
	end case;

case geographyLevel	
	when 0 then
		set @geographyLevelString = "'All' as geographyLevel";
	when 1 then
		set @geographyLevelString = "department as geographyLevel";
	when 2 then
		set @geographyLevelString = "commune as geographyLevel";
	when 3 then
		set @geographyLevelString = "sitecode as geographyLevel";
end case;

if ageLevel=0
then set @ageLevelString="'All' as ageLevel";
else set @ageLevelString=concat(ageLevel," as ageLevel");
end if;

if genderLevel=0
then set @genderLevelString="'All' as genderLevel";
else set @genderLevelString=concat(genderLevel," as genderLevel");
end if;

set @sqlstring="select ";
set @sqlstring=concat(@sqlstring,@timeLevelString,",");
set @sqlstring=concat(@sqlstring,@geographyLevelString,",");
set @sqlstring=concat(@sqlstring,@ageLevelString,",");
set @sqlstring=concat(@sqlstring,@genderLevelString,",");
set @sqlstring=concat(@sqlstring, 
        "count(patientid) as count");
set @sqlstring=concat(@sqlstring," from vw_malaria where ");
set @sqlstring=concat(@sqlstring, whereClause);
set @sqlstring=concat(@sqlstring, " group by ");
set @sqlstring=concat(@sqlstring, "timeLevel, geographyLevel, ageLevel, genderLevel");

PREPARE stmt1 FROM @sqlstring; 
EXECUTE stmt1; 
DEALLOCATE PREPARE stmt1; 

end$$
DELIMITER ;

DROP PROCEDURE if exists GetMalariaDataFilteredByAgeAndGender;
DELIMITER $$
CREATE DEFINER=`itechapp`@`localhost` PROCEDURE `GetMalariaDataFilteredByAgeAndGender`(IN timeLevel INT, IN geographyLevel INT, IN ageLevel INT, IN genderLevel INT)
BEGIN

declare timeLevelString, geographyLevelString, ageLevelString, genderLevelString Varchar(50);
declare sqlstring varchar(5000);

case timeLevel
	when 0 then
		set @timeLevelString = "'All' as timeLevel";
	when 1 then
		set @timeLevelString = "Year(s.visitdate) as timeLevel";
	when 2 then
		set @timeLevelString = "Concat(Year(s.visitdate),'-',Quarter(s.visitdate)) as timeLevel";	
	when 3 then
		set @timeLevelString = "case length(Month(s.visitDate))
			when 1 then Concat(Year(s.visitdate),'-0',Month(s.visitdate))
			else  Concat(Year(s.visitdate),'-',Month(s.visitdate)) 
			end as timeLevel";
	when 4 then
		set @timeLevelString = "case length(Week(s.visitDate,3))
			when 1 then Concat(Year(s.visitdate),'-0',Week(s.visitdate,3))
			else  Concat(Year(s.visitdate),'-',Week(s.visitdate,3)) 
			end as timeLevel"; 
	end case;

case geographyLevel	
	when 0 then
		set @geographyLevelString = "'All' as geographyLevel";
	when 1 then
		set @geographyLevelString = "department as geographyLevel";
	when 2 then
		set @geographyLevelString = "commune as geographyLevel";
	when 3 then
		set @geographyLevelString = "sitecode as geographyLevel";
end case;

if ageLevel=0
then set @ageLevelString="'All' as ageLevel";
else set @ageLevelString=concat(ageLevel," as ageLevel");
end if;

if genderLevel=0
then set @genderLevelString="'All' as genderLevel";
else set @genderLevelString=concat(genderLevel," as genderLevel");
end if;

set @sqlstring="select ";
set @sqlstring=concat(@sqlstring,@timeLevelString,",");
set @sqlstring=concat(@sqlstring,@geographyLevelString,",");
set @sqlstring=concat(@sqlstring,@ageLevelString,",");
set @sqlstring=concat(@sqlstring,@genderLevelString,",");
set @sqlstring=concat(@sqlstring, 
        "sum(s.malariadxa) AS malariadxa,
        sum(s.malariadx) AS malariadx,
        sum(s.ispregnant) AS ispregnant,
        sum(s.feverless2) AS feverless2,
        sum(s.chloroquine) AS chloroquine,
        sum(s.quinine) AS quinine,
        sum(s.primaquine) AS primaquine,
        sum(s.rapidresultpositive) AS rapidresultpositive,
        sum(s.rapidresultnegative) AS rapidresultnegative,
        sum(s.smearresultpositive) AS smearresultpositive,
        sum(s.smearresultnegative) AS smearresultnegative,
        sum(s.hospitalisation) AS hospitalisation,
        sum(s.ft) AS ft,
        sum(s.fg) AS fg,
        sum(s.vx) AS vx,
        sum(s.ov) AS ov,
        sum(s.mai) AS mai,
        sum(s.confirmedcase) AS confirmedcase,
        sum(s.alltreatments) AS alltreatments,
        sum(s.singletreatment) AS singletreatment,
        sum(s.anytreatment) AS anytreatment,
        sum(s.positivefalciparumtest) AS positivefalciparumtest,
        sum(s.positiveotherparasitetest) AS positiveotherparasitetest"
);
set @sqlstring=concat(@sqlstring," from vw_malaria s");
		
if (ageLevel<>0 or genderLevel<>0)
then 
	set @sqlstring=concat(@sqlstring, " where");
	if (ageLevel<>0)
		then set @sqlstring=concat(@sqlstring, " s.ageGroup=",ageLevel);
		if (genderLevel<>0)
			then set @sqlstring=concat(@sqlstring, " and");
		end	if;	
	end if;
	if (genderLevel<>0)
		then set @sqlstring=concat(@sqlstring, " s.sex=",genderLevel);
	end if;
end if;

set @sqlstring=concat(@sqlstring, " group by timeLevel, geographyLevel, ageLevel, genderLevel");

PREPARE stmt1 FROM @sqlstring; 
EXECUTE stmt1; 
DEALLOCATE PREPARE stmt1; 

END$$
DELIMITER ;