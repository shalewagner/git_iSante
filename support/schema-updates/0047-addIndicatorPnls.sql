insert into iap_indicator(indicatorID,name,definition,numerotor,denominator,type) values
(1,'Retrait à temps des ARV (ART.7)','Retrait à temps des ARV (ART.7) - Pourcentage des patients qui retirent l\'ensemble des ARV prescrits avec maximum deux jours de retard au premier retrait après un retrait de référence défini',	
'Nombre de patients qui retirent à temps les ARV au premier retrait après un retrait de Référence défini.',
'Nombre de patients qui ont retirés les ARV à la date désignée de début de L\’échantillonnage IAP ou après celle-ci.',
'percentage');

insert into iap_indicator(indicatorID,name,definition,numerotor,denominator,type) values
(2,'Rétention sous TAR (ART.5)','Rétention sous TAR (ART.5) - Pourcentage de patients retenus pour le traitement 12 mois après avoir débuté',	
'Nombre de patients en vie et sous TAR 12 mois après la mise en route du traitement',
'Nombre total de patients qui ont commencé un TAR et qui sont censés le poursuivre pendant 12 mois au cours de la période sous rapport, y compris ceux qui sont décédés depuis le début de la thérapie, ceux qui ont arrêté le traitement, et ceux perdus de vue', 
'percentage');

insert into iap_indicator(indicatorID,name,definition,numerotor,denominator,type) values
(3,'Rupture de stock','Rupture de stock - Pourcentage de mois dans l\'année du suivi de rupture de stock de tout ARV dispensé régulièrement',
'Nombre de mois avec jour(s) dans l\'année du suivi de rupture de stock de tout ARV dispensé régulièrement par l\'établissement',
'12 mois',									
'percentage');

insert into iap_indicator(indicatorID,name,definition,numerotor,denominator,type) values
(4,'Suppression de la charge virale (VLS.1)','Suppression de la charge virale (VLS.1) - Pourcentage de patients présentant une charge virale (<1000 copies/ml) 12 mois après la mise en route du TAR', 
'Nombre de patients pour lesquels un résultat de mesure de la charge virale est disponible après 12 ± 3 mois', 
'Nombre de patients en vie et sous TAR 12 mois après le début du traitement disposant d\'un résultat d\'analyse de la charge virale',
'percentage');	
										
insert into iap_indicator(indicatorID,name,definition,numerotor,denominator,type) values
(5,'Achèvement du processus d\'analyse de la charge virale (VLS.2)','Achèvement du processus d\'analyse de la charge virale (VLS.2) - Pourcentage des patients disposant d\'un résultat d\'analyse de la charge virale après 12 mois',
'Nombre de patients pour lesquels un résultat de mesure de la charge virale est disponible après 12 ± 3 mois',
'Nombre de patients qui selon la politique nationale auraient dû avoir une analyse de la charge virale après 12 ±3 mois', 
'percentage'); 

insert into iap_indicator(indicatorID,name,definition,numerotor,denominator,type) values
(6,'Changement approprié','Changement approprié - Pourcentage de patients avec un échec virologique confirmé après changement au TAR de deuxième intention dans les 3 mois',
'Nombre de patients avec CV≥ 1000 copies/ml confirmée qui passent au TAR de deuxième intention dans les 90 jours suivant la date de l\'analyse de la charge virale de confirmation', 
'Nombre total de patients avec un test de confirmation de la charge virale ≥ 1000 copies/ml',
'percentage');
				
insert into iap_indicator(indicatorID,name,definition,numerotor,denominator,type) values
(7,'Perdu de vue','Perdu de vue - Pourcentage de patients ayant débuté un TAR dans un établissement pendant une période donnée qui sont perdus de vue 12 mois après la mise en route du traitement',
'Nombre de personnes perdues de vue 12 mois après le début du TAR (nombre de personnes avec résultats non classifiables, c.-à-d. non classifiés comme étant en soins de santé, décédé, transféré vers un autre établissement ou arrêt)',
'Nombre de personnes qui ont débuté le TAR au cours de la période de 12 mois (les décès connus et les transferts vers d\'autres établissements sont exclus du dénominateur)',	
'percentage');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163590,'grossesseOuiNon','grossesseOuiNon','Pregnancy','en','1','2020-07-25'),
       (163590,'grossesseOuiNon','grossesseOuiNon','Grossesse','fr','1','2020-07-25'),
	   (163591,'grossesseStartDate','grossesseStartDate','Start of pregnancy','en','1','2020-07-25'),
	   (163591,'grossesseStartDate','grossesseStartDate','Debut de grossesse','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163592,'grossesseEndDate','grossesseEndDate','End of pregnancy','en','1','2020-07-25'),
       (163592,'grossesseEndDate','grossesseEndDate','Fin de grossesse','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163593,'harsahRisk','harsahRisk','HARSAH','en','1','2020-07-25'),
       (163593,'harsahRisk','harsahRisk','HARSAH','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163594,'sexProfessionelRisk','sexProfessionelRisk','Sex professionals','en','1','2020-07-25'),
       (163594,'sexProfessionelRisk','sexProfessionelRisk','Professionnels de Sex','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163595,'prisonierRisk','prisonierRisk','Prisoners','en','1','2020-07-25'),
       (163595,'prisonierRisk','prisonierRisk','Prisonniers','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163596,'transgenreRisk','transgenreRisk','Transgender','en','1','2020-07-25'),
       (163596,'transgenreRisk','transgenreRisk','Transgenre','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163597,'drugUserRisk','drugUserRisk','Injecting drug user','en','1','2020-07-25'),
       (163597,'drugUserRisk','drugUserRisk','Utilisateur de drogues injectables','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163598,'refusVolontaireArv','refusVolontaireArv','Voluntary refusal to take ARVs','en','1','2020-07-25'),
       (163598,'refusVolontaireArv','refusVolontaireArv','Refus volontaire de prendre les ARV','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163599,'decisionMedicaleARV','decisionMedicaleARV','Medical decision','en','1','2020-07-25'),
       (163599,'decisionMedicaleARV','decisionMedicaleARV','Décision médicale','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163600,'infectionOpportunistesARV','infectionOpportunistesARV','Opportunistic infections (OI)','en','1','2020-07-25'),
       (163600,'infectionOpportunistesARV','infectionOpportunistesARV','Infection opportunistes (IO)','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163601,'troublePsychiatriquesARV','troublePsychiatriquesARV','Psychiatric disorders','en','1','2020-07-25'),
       (163601,'troublePsychiatriquesARV','troublePsychiatriquesARV','Troubles psychiatriques','fr','1','2020-07-25');


insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163602,'deniARV','deniARV','Denial','en','1','2020-07-25'),
       (163602,'deniARV','deniARV','Déni','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163603,'maladieIntercurrentesARV','maladieIntercurrentesARV','Non-OI intercurrent diseases','en','1','2020-07-25'),
       (163603,'maladieIntercurrentesARV','maladieIntercurrentesARV','Maladies intercurrentes non IO','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163604,'autreCausesARV','autreCausesARV','Other Causes','en','1','2020-07-25'),
       (163604,'autreCausesARV','autreCausesARV','Autres Causes','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163605,'autreCausesARVSpecify','autreCausesARVSpecify','Other Causes Specify','en','1','2020-07-25'),
       (163605,'autreCausesARVSpecify','autreCausesARVSpecify','Autres Causes specifie','fr','1','2020-07-25');


insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163606,'debutArtReference','debutArtReference','ARV start date in the Reference establishment','en','1','2020-07-25'),
       (163606,'debutArtReference','debutArtReference','Date début ARV dans l’établissement de Reference','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163607,'dateDebutTb','dateDebutTb','TB treatment start date','en','1','2020-07-25'),
       (163607,'dateDebutTb','dateDebutTb','date du début de traitement TB','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163608,'regimeLigne','regimeLigne','Line of Regimen','en','1','2020-07-25'),
       (163608,'regimeLigne','regimeLigne','Ligne du Regime','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163609,'emigrationPrecisez','emigrationPrecisez','Emigration,Specify','en','1','2020-07-25'),
       (163609,'emigrationPrecisez','emigrationPrecisez','Émigration, précisez','fr','1','2020-07-25');


insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163610,'tuberculoseCauseDeces','tuberculoseCauseDeces','Tuberculosis','en','1','2020-07-25'),
       (163610,'tuberculoseCauseDeces','tuberculoseCauseDeces','Tuberculose','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163611,'maladieInfectuesesCauseDeces','maladieInfectuesesCauseDeces','HIV-related infectious and / or parasitic diseases','en','1','2020-07-25'),
       (163611,'maladieInfectuesesCauseDeces','maladieInfectuesesCauseDeces','Maladies infectieuses et/ou parasitaires liées au VIH','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163612,'CancerCauseDeces','CancerCauseDeces','HIV-related cancer','en','1','2020-07-25'),
       (163612,'CancerCauseDeces','CancerCauseDeces','Cancer lié au VIH','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163613,'autreMaladieCauseDeces','autreMaladieCauseDeces','Other HIV-related illnesses or conditions','en','1','2020-07-25'),
       (163613,'autreMaladieCauseDeces','autreMaladieCauseDeces','Autres maladies ou conditions liées au VIH','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163614,'causeNaturelCauseDeces','causeNaturelCauseDeces','Natural causes (cancer and infections, etc.) unrelated to HIV','en','1','2020-07-25'),
       (163614,'causeNaturelCauseDeces','causeNaturelCauseDeces','Causes naturelles (cancer et infections, etc ) non liées au VIH','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163615,'causeNonNaturelCauseDeces','causeNonNaturelCauseDeces','Non-natural causes (trauma, accident, suicide, homicide, war, etc.)','en','1','2020-07-25'),
       (163615,'causeNonNaturelCauseDeces','causeNonNaturelCauseDeces','Causes non naturelles (traumatisme, accident, suicide, homicide, guerre, etc)','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163616,'inconnueCauseDeces','inconnueCauseDeces','Unknown','en','1','2020-07-25'),
       (163616,'inconnueCauseDeces','inconnueCauseDeces','Inconnue','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163617,'decisionPrestataire','decisionPrestataire','Decision of the provider','en','1','2020-07-25'),
       (163617,'decisionPrestataire','decisionPrestataire','Décision du prestataire','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163618,'deniArret','deniArret','Denied','en','1','2020-07-25'),
       (163618,'deniArret','deniArret','Déni','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163619,'troublePsychiatre','troublePsychiatre','Troubles psychiatriques et / ou psychologiques','en','1','2020-07-25'),
       (163619,'troublePsychiatre','troublePsychiatre','Troubles psychiatriques et/ou psychologiques','fr','1','2020-07-25');


insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163620,'allaitementOuiNon','allaitementOuiNon','Pregnancy','en','1','2020-07-25'),
       (163620,'allaitementOuiNon','allaitementOuiNon','Grossesse','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163621,'allaitementStartDate','allaitementStartDate','Start of pregnancy','en','1','2020-07-25'),
       (163621,'allaitementStartDate','allaitementStartDate','Debut de grossesse','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163622,'allaitementEndDate','allaitementEndDate','End of pregnancy','en','1','2020-07-25'),
       (163622,'allaitementEndDate','allaitementEndDate','Fin de grossesse','fr','1','2020-07-25');


 

insert into concept(concept_id,retired,short_name,description,form_text,datatype_id,class_id,is_set,creator,date_created)
values(163590,0,'grossesseOuiNon','Grossesse','Grossesse',1,13,0,1,'2020-07-25'),
      (163591,0,'grossesseStartDate','Debut de grossesse','Debut de grossesse',7,5,0,1,'2020-07-25'),
      (163592,0,'grossesseEndDate','Fin de grossesse','Fin de grossesse',7,5,0,1,'2020-07-25'),
	  
	  (163593,0,'harsahRisk','HARSAH','HARSAH',10,5,0,1,'2020-07-25'),
      (163594,0,'sexProfessionelRisk','Professionnels de Sex','Professionnels de Sex',10,5,0,1,'2020-07-25'),
      (163595,0,'prisonierRisk','Prisonniers','Prisonniers',10,5,0,1,'2020-07-25'),
	  (163596,0,'transgenreRisk','Transgenre','Transgenre',10,5,0,1,'2020-07-25'),
      (163597,0,'drugUserRisk','Utilisateur de drogues injectables','Utilisateur de drogues injectables',10,5,0,1,'2020-07-25'),
	  (163598,0,'refusVolontaireArv','Refus volontaire de prendre les ARV','Refus volontaire de prendre les ARV',10,5,0,1,'2020-07-25'),
      (163599,0,'decisionMedicaleARV','Décision médicale','Décision médicale',10,5,0,1,'2020-07-25'),
      (163600,0,'infectionOpportunistesARV','Infection opportunistes (IO)','Infection opportunistes (IO)',10,5,0,1,'2020-07-25'),
      (163601,0,'troublePsychiatriquesARV','Troubles psychiatriques','Troubles psychiatriques',10,5,0,1,'2020-07-25'),
      (163602,0,'deniARV','Déni','Déni',10,5,0,1,'2020-07-25'),
      (163603,0,'maladieIntercurrentesARV','Maladies intercurrentes non IO','Maladies intercurrentes non IO',10,5,0,1,'2020-07-25'),
      (163604,0,'autreCausesARV','Autres Causes','Autres Causes',10,5,0,1,'2020-07-25'),
	  (163605,0,'autreCausesARVSpecify','Autres Causes specifie','Autres Causes specifie',3,5,0,1,'2020-07-25'),
	  (163606,0,'debutArtReference','Date début ARV dans l’établissement de Reference','Date début ARV dans l’établissement de Reference',7,5,0,1,'2020-07-25'),
	  (163607,0,'dateDebutTb','date du début de traitement TB','date du début de traitement TB',7,5,0,1,'2020-07-25'),
	  (163608,0,'regimeLigne','Ligne du Regime','Ligne du Regime',1,5,0,1,'2020-07-25'),
	  (163609,0,'emigrationPrecisez','Émigration, précisez','Émigration, précisez',3,5,0,1,'2020-07-25'),
	  (163610,0,'tuberculoseCauseDeces','Tuberculose','Tuberculose',10,5,0,1,'2020-07-25'),
	  (163611,0,'maladieInfectuesesCauseDeces','Maladies infectieuses et/ou parasitaires liées au VIH','Maladies infectieuses et/ou parasitaires liées au VIH',10,5,0,1,'2020-07-25'),
	  (163612,0,'CancerCauseDeces','Cancer lié au VIH','Cancer lié au VIH',10,5,0,1,'2020-07-25'),
	  (163613,0,'autreMaladieCauseDeces','Autres maladies ou conditions liées au VIH','Autres maladies ou conditions liées au VIH',10,5,0,1,'2020-07-25'),
	  (163614,0,'causeNaturelCauseDeces','Causes naturelles (cancer et infections, etc ) non liées au VIH','Causes naturelles (cancer et infections, etc ) non liées au VIH',10,5,0,1,'2020-07-25'),
	  (163615,0,'causeNonNaturelCauseDeces','Causes non naturelles (traumatisme, accident, suicide, homicide, guerre, etc)','Causes non naturelles (traumatisme, accident, suicide, homicide, guerre, etc)',10,5,0,1,'2020-07-25'),
	  (163616,0,'inconnueCauseDeces','Inconnue','Inconnue',10,5,0,1,'2020-07-25'),
	  (163617,0,'decisionPrestataire','Décision du prestataire','Décision du prestataire',10,5,0,1,'2020-07-25'),
	  (163618,0,'deniArret','Déni','Déni',10,5,0,1,'2020-07-25'),
	  (163619,0,'troublePsychiatre','Troubles psychiatriques et/ou psychologiques','Troubles psychiatriques et/ou psychologiques',10,5,0,1,'2020-07-25'),
	  
	  (163620,0,'allaitementOuiNon','allaitementOuiNon','Allaitement',1,13,0,1,'2020-07-25'),
	  (163621,0,'allaitementStartDate','allaitementStartDate','Debut Allaitement',7,5,0,1,'2020-07-25'),
	  (163622,0,'allaitementEndDate','allaitementEndDate','Fin Allaitement',7,5,0,1,'2020-07-25');
