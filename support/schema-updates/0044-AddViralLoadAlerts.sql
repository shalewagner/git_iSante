drop table if exists alertLookup ;
go
create table alertLookup(id int primary key auto_increment,
alertId int,
alertName varchar(150) character set utf8 collate utf8_unicode_ci  NOT NULL,
descriptionFr varchar(1024) character set utf8 collate utf8_unicode_ci  NOT NULL,
descriptionEn varchar(1024) character set utf8 collate utf8_unicode_ci  NOT NULL,
messageFr varchar(1024) character set utf8 collate utf8_unicode_ci  NOT NULL,
messageEn varchar(1024) character set utf8 collate utf8_unicode_ci  NOT NULL,
alertGroup varchar(20) character set utf8 collate utf8_unicode_ci  NOT NULL,
priority int
)  ENGINE=InnoDB DEFAULT CHARSET=utf8;

go                         
insert into alertLookup(alertId,alertName,descriptionFr,descriptionEn,messageFr,messageEn,alertGroup,priority) values 
(1,'noViralLoadArv_6months','patients 6 months after ART initiation','patients 6 months after ART initiation','Le patient est sous ARV depuis 6 mois sans un résultat de charge virale','Le patient est sous ARV depuis 6 mois sans un résultat de charge virale',1,1),
(2,'noViralLoadArv_5months','patients 5 months after ART initiation','patients 5 months after ART initiation','Le patient est sous ARV depuis 5 mois sans un résultat de charge virale','Le patient est sous ARV depuis 5 mois sans un résultat de charge virale',1,2),
(3,'noViralLoadArvPregnant_4months','pregnant woman 4 months after ART initiation','pregnant woman 4 months after ART initiation','La patiente est enceinte, sous ARV depuis 4 mois sans un résultat de charge virale','La patiente est enceinte, sous ARV depuis 4 mois sans un résultat de charge virale',1,3),
(4,'ViralLoadHiv_12months','patient whose last viral load test was performed 12 months prior','patient whose last viral load test was performed 12 months prior','La dernière charge virale de ce patient remonte à au moins 12 mois.','La dernière charge virale de ce patient remonte à au moins 12 mois.',1,4),
(5,'1000ViralLoadHiv_3months','patient whose viral test result was greater than 1000 copies and was performed 3 months ago','patient  whose viral test result was greater than 1000 copies and was performed 3 months ago','La dernière charge virale de ce patient remonte à au moins 3 mois et le résultat était > 1000 copies/ml','La dernière charge virale de ce patient remonte à au moins 3 mois et le résultat était > 1000 copies/ml',1,5),
(6,'1000ViralLoadHiv','patient with a VL test of >1000 copies','patient with a VL test of >1000 copies','La dernière charge virale du patient est >1000 copies/ml','La dernière charge virale du patient est >1000 copies/ml',1,6);
go

insert into regimen( regID,regimenName,drugID1,drugID2,drugID3,shortName,regGroup) 
values ('120','1stReg120','91','12','31','EVG-FTC-TDF','1stReg120'),
       ('121','3rd','87','88','90','RAL-DRV/r - ETV','3rd'),
	   ('122','1stReg122','8','89','0','AZT-3TC-DTG','1stReg122'),
       ('123','1stReg123','1','20','89','ABC-3TC-DTG''1stReg123');


go
drop table if exists patientAlert;
go
create table patientAlert(siteCode int,
patientID varchar(11),
alertId int,
insertDate date
)  ENGINE=InnoDB DEFAULT CHARSET=utf8;
go
