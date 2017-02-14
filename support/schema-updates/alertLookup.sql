drop table if exists  alertLookup ;

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
                         
insert into alertLookup(alertId,alertName,descriptionFr,descriptionEn,messageFr,messageEn,alertGroup,priority)
values (1,'noViralLoadArv_6months','Nombre de patient sous ARV depuis 6 mois sans un résultat de charge virale','patients 6 months after ART initiation','Le patient est sous ARV depuis 6 mois sans un résultat de charge virale','Le patient est sous ARV depuis 6 mois sans un résultat de charge virale',1,1),
       (2,'noViralLoadArv_5months','Nombre de patient sous ARV depuis 5 mois sans un résultat de charge virale','patients 5 months after ART initiation','Le patient est sous ARV depuis 5 mois sans un résultat de charge virale','Le patient est sous ARV depuis 5 mois sans un résultat de charge virale',1,6),
	   (3,'noViralLoadArvPregnant_4months','Femmes enceintes, sous ARV depuis 4 mois sans un résultat de charge virale','pregnant woman 4 months after ART initiation','La patiente est enceinte, sous ARV depuis 4 mois sans un résultat de charge virale','La patiente est enceinte, sous ARV depuis 4 mois sans un résultat de charge virale',1,2),
	   (4,'ViralLoadHiv_12months','Patients ayant leur dernière charge virale remontant à au moins 12 mois','patient whose last viral load test was performed 12 months prior','La dernière charge virale de ce patient remonte à au moins 12 mois.','La dernière charge virale de ce patient remonte à au moins 12 mois.',1,3),
	   (5,'1000ViralLoadHiv_3months','Patients ayant leur dernière charge virale remontant à au moins 3 mois avec un résultat > 1000 copies/mlo','patient  whose viral test result was greater than 1000 copies and was performed 3 months ago','La dernière charge virale de ce patient remonte à au moins 3 mois et le résultat était > 1000 copies/ml','La dernière charge virale de ce patient remonte à au moins 3 mois et le résultat était > 1000 copies/ml',1,4),
	   (6,'1000ViralLoadHiv','Patients ayant un charge virale superieur a 1000 copies','patient with a VL test of >1000 copies','La dernière charge virale du patient est >1000 copies/ml','La dernière charge virale du patient est >1000 copies/ml',1,7);
