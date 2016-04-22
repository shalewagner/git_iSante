insert into drugGroupLookup(drugGroupID,drugGroupen,drugGroupfr) values (11,"II","Inhibiteur de l'integrase");

insert into drugLookup (drugLookup_id,drugID,drugName,drugLabel,drugGroup,stdDosageDescription,shortName,drugLabelen,drugLabelfr,pedStdDosageEn1,pedStdDosageEn2,pedStdDosageFr1,pedStdDosageFr2,pedDosageLabel) values 
(108,87,"Raltegravir","Raltegravir","II","400 mg 1Co BID","RAL","Raltegravir","Raltegravir",null,null,null,null,null),
(109,88,"Darunavir","Darunavir","Pls","300mg 2co BID","DRV","Darunavir","Darunavir",null,null,null,null,"BID");

update drugLookup set pedStdDosageEn1="40mg/10mg caplet",pedStdDosageFr1="40mg/10mg capsule" where drugID=21;

insert into regimen( regID,regimenName,drugID1,drugID2,drugID3,shortName,regGroup) 
values ('107','2nd2016-1','31','12','88','TNF+FTC+DRV/r','2nd2016-1'),
       ('108','1stReg2016-2','8','23','0','AZT+3TC+NVP ','1stReg2016-2'),
       ('109','2nd2016-3','31','20','88','TNF+3TC+DRV/r','2nd2016-3'),
	   ('110','2nd2016-4','8','88','0','AZT+3TC+DRV/r','2nd2016-4'),
       ('111','2nd2016-5','8','21','0','AZT+3TC+LPR/r','2nd2016-5'),
	   ('112','1stReg2016-6','8','11','0','AZT+3TC+EFV','1stReg2016-6'),
       ('113','1stReg2016-7','1','34','20','ABC + AZT+3TC ','1stReg2016-7'),
	   ('114','2nd2016-8','88','11','87','DRV/r+EFV+RAL','2nd2016-8');
