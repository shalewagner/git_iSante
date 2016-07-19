drop table if exists  alertLookup ;

create table alertLookup(id int primary key auto_increment,
                         alertId int,
                         alertName varchar(150),
                         descriptionFr varchar(1024),
                         descriptionEn varchar(1024),
                         messageFr varchar(1024),
                         messageEn varchar(1024),
                         alertGroup varchar(20),
                         priority int
                         );
insert into alertLookup(alertId,alertName,descriptionFr,descriptionEn,messageFr,messageEn,alertGroup,priority)
values (1,'noViralLoadArv_6months','patients 6 months after ART initiation','patients 6 months after ART initiation','Le patient est sous ARV depuis 6 mois sans un résultat de charge virale','Le patient est sous ARV depuis 6 mois sans un résultat de charge virale',1,1),
       (2,'noViralLoadArv_5months','patients 5 months after ART initiation','patients 5 months after ART initiation','Le patient est sous ARV depuis 5 mois sans un résultat de charge virale','Le patient est sous ARV depuis 5 mois sans un résultat de charge virale',1,2),
	   (3,'noViralLoadArvPregnant_4months','pregnant woman 4 months after ART initiation','pregnant woman 4 months after ART initiation','La patiente est enceinte, sous ARV depuis 4 mois sans un résultat de charge virale','La patiente est enceinte, sous ARV depuis 4 mois sans un résultat de charge virale',1,3),
	   (4,'ViralLoadHiv_12months','patient whose last viral load test was performed 12 months prior','patient whose last viral load test was performed 12 months prior','La dernière charge virale de ce patient remonte à au moins 12 mois.','La dernière charge virale de ce patient remonte à au moins 12 mois.',1,4),
	   (5,'1000ViralLoadHiv_3months','patient whose viral test result was greater than 1000 copies and was performed 3 months ago','patient  whose viral test result was greater than 1000 copies and was performed 3 months ago','La dernière charge virale de ce patient remonte à au moins 3 mois et le résultat était > 1000 copies/ml','La dernière charge virale de ce patient remonte à au moins 3 mois et le résultat était > 1000 copies/ml',1,5),
	   (6,'1000ViralLoadHiv','patient with a VL test of >1000 copies','patient with a VL test of >1000 copies','La dernière charge virale du patient est >1000 copies/ml','La dernière charge virale du patient est >1000 copies/ml',1,6);
