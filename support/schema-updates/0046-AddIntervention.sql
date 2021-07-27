insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) values (162812,'cryotherapie','cryotherapie','Cryotherapie','en','1','2018-10-25');
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) values (162812,'cryotherapie','cryotherapie','Cryotherapie','fr','1','2018-10-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) values (162810,'leep','leep','LEEP','en','1','2018-10-25');
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) values (162810,'leep','leep','Resection a l\'anse Diathermique(RAD)','fr','1','2018-10-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) values (163408,'thermocoagulation','thermocoagulation','Thermocoagulation','en','1','2018-10-25');
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) values (163408,'thermocoagulation','thermocoagulation','Thermocoagulation','fr','1','2018-10-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) values (162811,'conisation','conisation','Conisation','en','1','2018-10-25');
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) values (162811,'conisation','conisation','Conisation','fr','1','2018-10-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) values (159837,'hysterectomie','hysterectomie','Hystérectomie','en','1','2018-10-25');
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) values (159837,'hysterectomie','hysterectomie','Hystérectomie','fr','1','2018-10-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) values (160715,'procedureDate','procedureDate','Date/time procedure performed','en','1','2018-10-25');
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) values (160715,'procedureDate','procedureDate','Date de procedure','fr','1','2018-10-25');
 
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) values (146602,'screeneddone','screeneddone','Screening done','en','1','2018-10-25');
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) values (146602,'screeneddone','screeneddone','Depistage du cancer du col','fr','1','2018-10-25'); 

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) values (163589,'screenedMethode','screenedMethode','Screening Method','en','1','2018-10-25');
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) values (163589,'screenedMethode','screenedMethode','Methode de depistage','fr','1','2018-10-25'); 
 
 
insert into concept(concept_id,retired,short_name,description,form_text,datatype_id,class_id,is_set,creator,date_created)
values(162812,0,'cryotherapie','Cryotherapie','cryotherapie',10,13,0,1,'2018-10-25'),
      (162810,0,'leep','LEEP','leep',10,13,0,1,'2018-10-25'),
      (163408,0,'thermocoagulation','Thermocoagulation','thermocoagulation',10,13,0,1,'2018-10-25'),
	  (162811,0,'conisation','Conisation','conisation',10,13,0,1,'2018-10-25'),
	  (159837,0,'hysterectomie','Hystérectomie','hysterectomie',10,13,0,1,'2018-10-25'),
	  (160715,0,'procedureDate','Date de procedure','procedureDate',8,13,0,1,'2018-10-25'),
	  (146602,0,'screeneddone','Depistage','screeneddone',1,13,0,1,'2018-10-25'),
	  (163589,0,'screenedMethode','Methode de depistage','screenedMethode',1,13,0,1,'2018-10-25');
	  
  
ALTER TABLE `itech`.`dw_obgyn_snapshot` ADD COLUMN `cxca_scrnNum` TINYINT(1) NULL AFTER `membraneRuptureDeno`, ADD COLUMN `cxca_scrnDeno` TINYINT(1) NULL AFTER `cxca_scrnNum`, ADD COLUMN `cxca_txNum` TINYINT(1) NULL AFTER `cxca_scrnDeno`, ADD COLUMN `cxca_txDeno` TINYINT(1) NULL AFTER `cxca_txNum`;

INSERT INTO `itech`.`dw_obgynReportLookup` (`indicator`, `indicatorType`, `nameen`, `namefr`, `definitionen`, `definitionfr`, `indicatorDenominator`) VALUES ('21', '1', 'Percentage of HIV-positive women on ARVs screened for cervical cancer (CXCA_SCRN)', 'Pourcentage de femmes VIH positives sous ARV dépistées pour le cancer du col de l’utérus (CXCA_SCRN)\n', '<b>Numerator :</b>number of women aged 15-49 HIV + on ARVs screened for cervical cancer. <br><br><b>Denominator :</b>number of women aged 15-49 years HIV + on ARVs.\n', '<b>Numerateur :</b>nombre de femmes âgées de 15-49 ans VIH+ sous ARV dépistées pour le cancer du Col. <br><br><b>Denominateur :</b>nombre de femmes âgées de 15-49 ans VIH+ sous ARV.', '-7');
INSERT INTO `itech`.`dw_obgynReportLookup` (`indicator`, `indicatorType`, `nameen`, `namefr`, `definitionen`, `definitionfr`, `indicatorDenominator`) VALUES ('22', '1', 'Percentage of HIV + women on ARVs screened for pre-cancerous cervical lesions treated with cryotherapy, thermoaggregation or LEEP (CXCA-TX\n', 'Pourcentage de femmes VIH+ sous ARV dépistées positives pour lésions pré cancéreuses du col de l’utérus traitées par cryothérapie, thermo coagulation ou LEEP(CXCA-TX)\n', '<b>Numerator :</b>number of women aged 15-49 years HIV + on ARVs treated with cryotherapy, thermo-coagulation or LEEP <br><br><b>Denominator :</b>number of women aged 15-49 years HIV + on ARV screened positive for pre-cancerous cervical lesions.\n', '<b>Numerateur :</b>nombre de femmes âgées de 15-49 ans VIH+ sous ARV traitées par cryothérapie, thermo coagulation ou LEEP <br><br><b>Denominateur :</b>nombre de femmes âgées de 15-49 ans VIH+ sous ARV dépistées positives pour lésions pré cancéreuses du col de l’utérus.\n', '-8');

go	  