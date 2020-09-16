drop table if exists drugRupture;						  
create table drugRupture(
id int primary key auto_increment,
sitecode	varchar(10),	
drugID	int(11),
startDate	date,
endDate	date,
signature	varchar(55),
createDate	datetime,
lastDate	datetime);

drop table if exists iap_indicator;
create table iap_indicator (
id int primary key auto_increment,
indicatorID int,
name varchar(255),
definition longtext,
numerotor longtext,
denominator longtext,
type varchar(25)
);



insert into iap_indicator(indicatorID,name,definition,numerotor,denominator,type) values
(1,'Retrait à temps des ARV','Retrait à temps des ARV (ART.7) - Pourcentage des patients qui retirent l\'ensemble des ARV prescrits avec maximum deux jours de retard au premier retrait après un retrait de référence défini',	
'Nombre de patients qui retirent à temps les ARV au premier retrait après un retrait de Référence défini.',
'Nombre de patients qui ont retirés les ARV à la date désignée de début de L\’échantillonnage IAP ou après celle-ci.',
'percentage');

insert into iap_indicator(indicatorID,name,definition,numerotor,denominator,type) values
(2,'Rétention sous TAR','Rétention sous TAR (ART.5) - Pourcentage de patients retenus pour le traitement 12 mois après avoir débuté',	
'Nombre de patients en vie et sous TAR 12 mois après la mise en route du traitement',
'Nombre total de patients qui ont commencé un TAR et qui sont censés le poursuivre pendant 12 mois au cours de la période sous rapport, y compris ceux qui sont décédés depuis le début de la thérapie, ceux qui ont arrêté le traitement, et ceux perdus de vue', 
'percentage');

insert into iap_indicator(indicatorID,name,definition,numerotor,denominator,type) values
(3,'Rupture de stock','Rupture de stock - Pourcentage de mois dans l\'année du suivi de rupture de stock de tout ARV dispensé régulièrement',
'Nombre de mois avec jour(s) dans l\'année du suivi de rupture de stock de tout ARV dispensé régulièrement par l\'établissement',
'12 mois',									
'percentage');

insert into iap_indicator(indicatorID,name,definition,numerotor,denominator,type) values
(4,'Suppression de la charge virale','Suppression de la charge virale (VLS.1) - Pourcentage de patients présentant une charge virale (<1000 copies/ml) 12 mois après la mise en route du TAR', 
'Nombre de patients pour lesquels un résultat de mesure de la charge virale est disponible après 12 ± 3 mois', 
'Nombre de patients en vie et sous TAR 12 mois après le début du traitement disposant d\'un résultat d\'analyse de la charge virale',
'percentage');	
										
insert into iap_indicator(indicatorID,name,definition,numerotor,denominator,type) values
(5,'Achèvement du processus d\'analyse de la charge virale','Achèvement du processus d\'analyse de la charge virale (VLS.2) - Pourcentage des patients disposant d\'un résultat d\'analyse de la charge virale après 12 mois',
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

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163623,'emigrationCause','emigrationCause','Emigration','en','1','2020-07-25'),
       (163623,'emigrationCause','emigrationCause','Émigration','fr','1','2020-07-25');	   

/* mois 0*/	   
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163624,'surveillanceTbDatemois0','surveillanceTbDatemois0','TB surveillance date month 0','en','1','2020-07-25'),
       (163624,'surveillanceTbDatemois0','surveillanceTbDatemois0','Date surveillance TB mois 0','fr','1','2020-07-25');	   

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163625,'bacilloscopiemois0','bacilloscopiemois0','bacilloscopy month 0','en','1','2020-07-25'),
       (163625,'bacilloscopiemois0','bacilloscopiemois0','bacilloscopie mois 0','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163626,'geneXpertBkmois0','geneXpertBkmois0','geneXpert Bk month 0','en','1','2020-07-25'),
       (163626,'geneXpertBkmois0','geneXpertBkmois0','geneXpert Bk mois 0','fr','1','2020-07-25');
	   
	   
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163627,'geneXpertRifmois0','geneXpertRifmois0','geneXpert RIF month 0','en','1','2020-07-25'),
       (163627,'geneXpertRifmois0','geneXpertRifmois0','geneXpert RIF mois 0','fr','1','2020-07-25');	

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163628,'culturemois0','culturemois0','Culture month 0','en','1','2020-07-25'),
       (163628,'culturemois0','culturemois0','Culture mois 0','fr','1','2020-07-25');	   
 
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163629,'dstmois0','dstmois0','DST month 0','en','1','2020-07-25'),
       (163629,'dstmois0','dstmois0','DST mois 0','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163630,'poidsmois0','poidsmois0','Poids month 0','en','1','2020-07-25'),
       (163630,'poidsmois0','poidsmois0','Poids mois 0','fr','1','2020-07-25');
	   
	   
/*mois 1*/	   
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163631,'surveillanceTbDatemois1','surveillanceTbDatemois1','TB surveillance date month 1','en','1','2020-07-25'),
       (163631,'surveillanceTbDatemois1','surveillanceTbDatemois1','Date surveillance TB mois 1','fr','1','2020-07-25');	   

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163632,'bacilloscopiemois1','bacilloscopiemois1','bacilloscopy month 1','en','1','2020-07-25'),
       (163632,'bacilloscopiemois1','bacilloscopiemois1','bacilloscopie mois 1','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163633,'geneXpertBkmois1','geneXpertBkmois1','geneXpert Bk month 1','en','1','2020-07-25'),
       (163633,'geneXpertBkmois1','geneXpertBkmois1','geneXpert Bk mois 1','fr','1','2020-07-25');
	   
	   
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163634,'geneXpertRifmois1','geneXpertRifmois1','geneXpert RIF month 1','en','1','2020-07-25'),
       (163634,'geneXpertRifmois1','geneXpertRifmois1','geneXpert RIF mois 1','fr','1','2020-07-25');	

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163635,'culturemois1','culturemois1','Culture month 1','en','1','2020-07-25'),
       (163635,'culturemois1','culturemois1','Culture mois 1','fr','1','2020-07-25');	   
 
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163636,'dstmois1','dstmois1','DST month 1','en','1','2020-07-25'),
       (163636,'dstmois1','dstmois1','DST mois 1','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163637,'poidsmois1','poidsmois1','Poids month 1','en','1','2020-07-25'),
       (163637,'poidsmois1','poidsmois1','Poids mois 1','fr','1','2020-07-25');

/*mois 2*/	   
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163638,'surveillanceTbDatemois2','surveillanceTbDatemois2','TB surveillance date month 2','en','1','2020-07-25'),
       (163638,'surveillanceTbDatemois2','surveillanceTbDatemois2','Date surveillance TB mois 2','fr','1','2020-07-25');	   

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163639,'bacilloscopiemois2','bacilloscopiemois2','bacilloscopy month 2','en','1','2020-07-25'),
       (163639,'bacilloscopiemois2','bacilloscopiemois2','bacilloscopie mois 2','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163640,'geneXpertBkmois2','geneXpertBkmois2','geneXpert Bk month 2','en','1','2020-07-25'),
       (163640,'geneXpertBkmois2','geneXpertBkmois2','geneXpert Bk mois 2','fr','1','2020-07-25');
	   
	   
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163641,'geneXpertRifmois2','geneXpertRifmois2','geneXpert RIF month 2','en','1','2020-07-25'),
       (163641,'geneXpertRifmois2','geneXpertRifmois2','geneXpert RIF mois 2','fr','1','2020-07-25');	

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163642,'culturemois2','culturemois2','Culture month 2','en','1','2020-07-25'),
       (163642,'culturemois2','culturemois2','Culture mois 2','fr','1','2020-07-25');	   
 
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163643,'dstmois2','dstmois2','DST month 2','en','1','2020-07-25'),
       (163643,'dstmois2','dstmois2','DST mois 2','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163644,'poidsmois2','poidsmois2','Poids month 2','en','1','2020-07-25'),
       (163644,'poidsmois2','poidsmois2','Poids mois 2','fr','1','2020-07-25');	   
	   
/*mois 3*/	   
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163645,'surveillanceTbDatemois3','surveillanceTbDatemois3','TB surveillance date month 3','en','1','2020-07-25'),
       (163645,'surveillanceTbDatemois3','surveillanceTbDatemois3','Date surveillance TB mois 3','fr','1','2020-07-25');	   

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163646,'bacilloscopiemois3','bacilloscopiemois3','bacilloscopy month 3','en','1','2020-07-25'),
       (163646,'bacilloscopiemois3','bacilloscopiemois3','bacilloscopie mois 3','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163647,'geneXpertBkmois3','geneXpertBkmois3','geneXpert Bk month 3','en','1','2020-07-25'),
       (163647,'geneXpertBkmois3','geneXpertBkmois3','geneXpert Bk mois 3','fr','1','2020-07-25');
	   
	   
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163648,'geneXpertRifmois3','geneXpertRifmois3','geneXpert RIF month 3','en','1','2020-07-25'),
       (163648,'geneXpertRifmois3','geneXpertRifmois3','geneXpert RIF mois 3','fr','1','2020-07-25');	

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163649,'culturemois3','culturemois3','Culture month 3','en','1','2020-07-25'),
       (163649,'culturemois3','culturemois3','Culture mois 3','fr','1','2020-07-25');	   
 
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163650,'dstmois3','dstmois3','DST month 3','en','1','2020-07-25'),
       (163650,'dstmois3','dstmois3','DST mois 3','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163651,'poidsmois3','poidsmois3','Poids month 3','en','1','2020-07-25'),
       (163651,'poidsmois3','poidsmois3','Poids mois 3','fr','1','2020-07-25');	 
	   
/*mois 4*/	   
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163652,'surveillanceTbDatemois4','surveillanceTbDatemois4','TB surveillance date month 4','en','1','2020-07-25'),
       (163652,'surveillanceTbDatemois4','surveillanceTbDatemois4','Date surveillance TB mois 4','fr','1','2020-07-25');	   

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163653,'bacilloscopiemois4','bacilloscopiemois4','bacilloscopy month 4','en','1','2020-07-25'),
       (163653,'bacilloscopiemois4','bacilloscopiemois4','bacilloscopie mois 4','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163654,'geneXpertBkmois4','geneXpertBkmois4','geneXpert Bk month 4','en','1','2020-07-25'),
       (163654,'geneXpertBkmois4','geneXpertBkmois4','geneXpert Bk mois 4','fr','1','2020-07-25');
	   
	   
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163655,'geneXpertRifmois4','geneXpertRifmois4','geneXpert RIF month 4','en','1','2020-07-25'),
       (163655,'geneXpertRifmois4','geneXpertRifmois4','geneXpert RIF mois 4','fr','1','2020-07-25');	

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163656,'culturemois4','culturemois4','Culture month 4','en','1','2020-07-25'),
       (163656,'culturemois4','culturemois4','Culture mois 4','fr','1','2020-07-25');	   
 
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163657,'dstmois4','dstmois4','DST month 4','en','1','2020-07-25'),
       (163657,'dstmois4','dstmois4','DST mois 4','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163658,'poidsmois4','poidsmois4','Poids month 4','en','1','2020-07-25'),
       (163658,'poidsmois4','poidsmois4','Poids mois 4','fr','1','2020-07-25');	 


/*mois 5*/	   
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163659,'surveillanceTbDatemois5','surveillanceTbDatemois5','TB surveillance date month 5','en','1','2020-07-25'),
       (163659,'surveillanceTbDatemois5','surveillanceTbDatemois5','Date surveillance TB mois 5','fr','1','2020-07-25');	   

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163660,'bacilloscopiemois5','bacilloscopiemois5','bacilloscopy month 5','en','1','2020-07-25'),
       (163660,'bacilloscopiemois5','bacilloscopiemois5','bacilloscopie mois 5','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163661,'geneXpertBkmois5','geneXpertBkmois5','geneXpert Bk month 5','en','1','2020-07-25'),
       (163661,'geneXpertBkmois5','geneXpertBkmois5','geneXpert Bk mois 5','fr','1','2020-07-25');
	   
	   
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163662,'geneXpertRifmois5','geneXpertRifmois5','geneXpert RIF month 5','en','1','2020-07-25'),
       (163662,'geneXpertRifmois5','geneXpertRifmois5','geneXpert RIF mois 5','fr','1','2020-07-25');	

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163663,'culturemois5','culturemois5','Culture month 5','en','1','2020-07-25'),
       (163663,'culturemois5','culturemois5','Culture mois 5','fr','1','2020-07-25');	   
 
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163664,'dstmois5','dstmois5','DST month 5','en','1','2020-07-25'),
       (163664,'dstmois5','dstmois5','DST mois 5','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163665,'poidsmois5','poidsmois5','Poids month 5','en','1','2020-07-25'),
       (163665,'poidsmois5','poidsmois5','Poids mois 5','fr','1','2020-07-25');	 	   
	   

/*mois 6*/	   
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163666,'surveillanceTbDatemois6','surveillanceTbDatemois6','TB surveillance date month 6','en','1','2020-07-25'),
       (163666,'surveillanceTbDatemois6','surveillanceTbDatemois6','Date surveillance TB mois 6','fr','1','2020-07-25');	   

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163667,'bacilloscopiemois6','bacilloscopiemois6','bacilloscopy month 6','en','1','2020-07-25'),
       (163667,'bacilloscopiemois6','bacilloscopiemois6','bacilloscopie mois 6','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163668,'geneXpertBkmois6','geneXpertBkmois6','geneXpert Bk month 6','en','1','2020-07-25'),
       (163668,'geneXpertBkmois6','geneXpertBkmois6','geneXpert Bk mois 6','fr','1','2020-07-25');
	   
	   
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163669,'geneXpertRifmois6','geneXpertRifmois6','geneXpert RIF month 6','en','1','2020-07-25'),
       (163669,'geneXpertRifmois6','geneXpertRifmois6','geneXpert RIF mois 6','fr','1','2020-07-25');	

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163670,'culturemois6','culturemois6','Culture month 6','en','1','2020-07-25'),
       (163670,'culturemois6','culturemois6','Culture mois 6','fr','1','2020-07-25');	   
 
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163671,'dstmois6','dstmois6','DST month 6','en','1','2020-07-25'),
       (163671,'dstmois6','dstmois6','DST mois 6','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163672,'poidsmois6','poidsmois6','Poids month 6','en','1','2020-07-25'),
       (163672,'poidsmois6','poidsmois6','Poids mois 6','fr','1','2020-07-25');	
	   
/*mois fin TX*/	   
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163673,'surveillanceTbDateFinTx','surveillanceTbDateFinTx','TB surveillance date End of Tx','en','1','2020-07-25'),
       (163673,'surveillanceTbDateFinTx','surveillanceTbDateFinTx','Date surveillance TB Fin de Tx','fr','1','2020-07-25');	   

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163674,'bacilloscopieFinTx','bacilloscopieFinTx','bacilloscopy End of Tx','en','1','2020-07-25'),
       (163674,'bacilloscopieFinTx','bacilloscopieFinTx','bacilloscopie Fin de Tx','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163675,'geneXpertBkFinTx','geneXpertBkFinTx','geneXpert Bk End of Tx','en','1','2020-07-25'),
       (163675,'geneXpertBkFinTx','geneXpertBkFinTx','geneXpert Bk Fin de Tx','fr','1','2020-07-25');
	   
	   
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163676,'geneXpertRifFinTx','geneXpertRifFinTx','geneXpert RIF End of Tx','en','1','2020-07-25'),
       (163676,'geneXpertRifFinTx','geneXpertRifFinTx','geneXpert RIF Fin de Tx','fr','1','2020-07-25');	

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163677,'cultureFinTx','cultureFinTx','Culture End of Tx','en','1','2020-07-25'),
       (163677,'cultureFinTx','cultureFinTx','Culture Fin de Tx','fr','1','2020-07-25');	   
 
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163678,'dstFinTx','dstFinTx','DST End of Tx','en','1','2020-07-25'),
       (163678,'dstFinTx','dstFinTx','DST Fin de Tx','fr','1','2020-07-25');

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163679,'poidsFinTx','poidsFinTx','Poids End of Tx','en','1','2020-07-25'),
       (163679,'poidsFinTx','poidsFinTx','Poids Fin de Tx','fr','1','2020-07-25');		   
	   


insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163680,'adenopathies','adenopathies','Lymphadenopathy','en','1','2020-07-25'),
       (163680,'adenopathies','adenopathies','Adénopathies','fr','1','2020-07-25');
	   
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163681,'douleurThoracique','douleurThoracique','Chest pain','en','1','2020-07-25'),
       (163681,'douleurThoracique','douleurThoracique','Douleur thoracique','fr','1','2020-07-25');	 

insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163682,'fievreVesperale','fievreVesperale','Evening fever','en','1','2020-07-25'),
       (163682,'fievreVesperale','fievreVesperale','Fièvre vespérale','fr','1','2020-07-25');	   
	   
insert into concept_name (concept_id,name,short_name,description,locale,creator,date_created) 
values (163683,'perteAppetit','perteAppetit','Loss of appetite','en','1','2020-07-25'),
       (163683,'perteAppetit','perteAppetit','Perte d’appétit','fr','1','2020-07-25');

	   
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
	  (163622,0,'allaitementEndDate','allaitementEndDate','Fin Allaitement',7,5,0,1,'2020-07-25'),
	  (163623,0,'emigrationCause','emigrationCause','Émigration',10,5,0,1,'2020-07-25'),
	  
	  (163624,0,'surveillanceTbDatemois0','surveillanceTbDatemois0','Date surveillance TB mois 0',8,5,0,1,'2020-07-25'),
	  (163625,0,'bacilloscopiemois0','bacilloscopiemois0','bacilloscopie mois 0',1,5,0,1,'2020-07-25'),
	  (163626,0,'geneXpertBkmois0','geneXpertBkmois0','geneXpert Bk mois 0',1,5,0,1,'2020-07-25'),
	  (163627,0,'geneXpertRifmois0','geneXpertRifmois0','geneXpert RIF mois 0',1,5,0,1,'2020-07-25'),
	  (163628,0,'culturemois0','culturemois0','Culture mois 0',1,5,0,1,'2020-07-25'),
	  (163629,0,'dstmois0','dstmois0','DST mois 0',1,5,0,1,'2020-07-25'),
	  (163630,0,'poidsmois0','poidsmois0','Poids mois 0',1,5,0,1,'2020-07-25'),

	  
	  (163631,0,'surveillanceTbDatemois1','surveillanceTbDatemois1','Date surveillance TB mois 1',8,5,0,1,'2020-07-25'),
	  (163632,0,'bacilloscopiemois1','bacilloscopiemois1','bacilloscopie mois 1',1,5,0,1,'2020-07-25'),
	  (163633,0,'geneXpertBkmois1','geneXpertBkmois1','geneXpert Bk mois 1',1,5,0,1,'2020-07-25'),
	  (163634,0,'geneXpertRifmois1','geneXpertRifmois1','geneXpert RIF mois 1',1,5,0,1,'2020-07-25'),
	  (163635,0,'culturemois1','culturemois1','Culture mois 1',1,5,0,1,'2020-07-25'),
	  (163636,0,'dstmois1','dstmois1','DST mois 1',1,5,0,1,'2020-07-25'),
	  (163637,0,'poidsmois1','poidsmois1','Poids mois 1',1,5,0,1,'2020-07-25'),
	  
	  (163638,0,'surveillanceTbDatemois2','surveillanceTbDatemois2','Date surveillance TB mois 2',8,5,0,1,'2020-07-25'),
	  (163639,0,'bacilloscopiemois2','bacilloscopiemois2','bacilloscopie mois 2',1,5,0,1,'2020-07-25'),
	  (163640,0,'geneXpertBkmois2','geneXpertBkmois2','geneXpert Bk mois 2',1,5,0,1,'2020-07-25'),
	  (163641,0,'geneXpertRifmois2','geneXpertRifmois2','geneXpert RIF mois 2',1,5,0,1,'2020-07-25'),
	  (163642,0,'culturemois2','culturemois2','Culture mois 2',1,5,0,1,'2020-07-25'),
	  (163643,0,'dstmois2','dstmois2','DST mois 2',1,5,0,1,'2020-07-25'),
	  (163644,0,'poidsmois2','poidsmois2','Poids mois 2',1,5,0,1,'2020-07-25'),
	  
	  (163645,0,'surveillanceTbDatemois3','surveillanceTbDatemois3','Date surveillance TB mois 3',8,5,0,1,'2020-07-25'),
	  (163646,0,'bacilloscopiemois3','bacilloscopiemois3','bacilloscopie mois 3',1,5,0,1,'2020-07-25'),
	  (163647,0,'geneXpertBkmois3','geneXpertBkmois3','geneXpert Bk mois 3',1,5,0,1,'2020-07-25'),
	  (163648,0,'geneXpertRifmois3','geneXpertRifmois3','geneXpert RIF mois 3',1,5,0,1,'2020-07-25'),
	  (163649,0,'culturemois3','culturemois3','Culture mois 3',1,5,0,1,'2020-07-25'),
	  (163650,0,'dstmois3','dstmois3','DST mois 3',1,5,0,1,'2020-07-25'),
	  (163651,0,'poidsmois3','poidsmois3','Poids mois 3',1,5,0,1,'2020-07-25'),
	  
	  (163652,0,'surveillanceTbDatemois4','surveillanceTbDatemois4','Date surveillance TB mois 4',8,5,0,1,'2020-07-25'),
	  (163653,0,'bacilloscopiemois4','bacilloscopiemois4','bacilloscopie mois 4',1,5,0,1,'2020-07-25'),
	  (163654,0,'geneXpertBkmois4','geneXpertBkmois4','geneXpert Bk mois 4',1,5,0,1,'2020-07-25'),
	  (163655,0,'geneXpertRifmois4','geneXpertRifmois4','geneXpert RIF mois 4',1,5,0,1,'2020-07-25'),
	  (163656,0,'culturemois4','culturemois4','Culture mois 4',1,5,0,1,'2020-07-25'),
	  (163657,0,'dstmois4','dstmois4','DST mois 4',1,5,0,1,'2020-07-25'),
	  (163658,0,'poidsmois4','poidsmois4','Poids mois 4',1,5,0,1,'2020-07-25'),
	  
	  (163659,0,'surveillanceTbDatemois5','surveillanceTbDatemois5','Date surveillance TB mois 5',8,5,0,1,'2020-07-25'),
	  (163660,0,'bacilloscopiemois5','bacilloscopiemois5','bacilloscopie mois 5',1,5,0,1,'2020-07-25'),
	  (163661,0,'geneXpertBkmois5','geneXpertBkmois5','geneXpert Bk mois 5',1,5,0,1,'2020-07-25'),
	  (163662,0,'geneXpertRifmois5','geneXpertRifmois5','geneXpert RIF mois 5',1,5,0,1,'2020-07-25'),
	  (163663,0,'culturemois5','culturemois5','Culture mois 5',1,5,0,1,'2020-07-25'),
	  (163664,0,'dstmois5','dstmois5','DST mois 5',1,5,0,1,'2020-07-25'),
	  (163665,0,'poidsmois5','poidsmois5','Poids mois 5',1,5,0,1,'2020-07-25'),
	  
	  (163666,0,'surveillanceTbDatemois6','surveillanceTbDatemois6','Date surveillance TB mois 6',8,5,0,1,'2020-07-25'),
	  (163667,0,'bacilloscopiemois6','bacilloscopiemois6','bacilloscopie mois 6',1,5,0,1,'2020-07-25'),
	  (163668,0,'geneXpertBkmois6','geneXpertBkmois6','geneXpert Bk mois 6',1,5,0,1,'2020-07-25'),
	  (163669,0,'geneXpertRifmois6','geneXpertRifmois6','geneXpert RIF mois 6',1,5,0,1,'2020-07-25'),
	  (163670,0,'culturemois6','culturemois6','Culture mois 6',1,5,0,1,'2020-07-25'),
	  (163671,0,'dstmois6','dstmois6','DST mois 6',1,5,0,1,'2020-07-25'),
	  (163672,0,'poidsmois6','poidsmois6','Poids mois 6',1,5,0,1,'2020-07-25'),
	  
	  (163673,0,'surveillanceTbDateFinTx','surveillanceTbDateFinTx','Date surveillance TB Fin de Tx',8,5,0,1,'2020-07-25'),
	  (163674,0,'bacilloscopieFinTx','bacilloscopieFinTx','bacilloscopie Fin de Tx',1,5,0,1,'2020-07-25'),
	  (163675,0,'geneXpertBkFinTx','geneXpertBkFinTx','geneXpert Bk Fin de Tx',1,5,0,1,'2020-07-25'),
	  (163676,0,'geneXpertRifFinTx','geneXpertRifFinTx','geneXpert RIF Fin de Tx',1,5,0,1,'2020-07-25'),
	  (163677,0,'cultureFinTx','cultureFinTx','Culture Fin de Tx',1,5,0,1,'2020-07-25'),
	  (163678,0,'dstFinTx','dstFinTx','DST Fin de Tx',1,5,0,1,'2020-07-25'),
	  (163679,0,'poidsFinTx','poidsFinTx','Poids Fin de Tx',1,5,0,1,'2020-07-25'),
	  
	  (163680,0,'adenopathies','adenopathies','Adénopathies',10,13,0,1,'2020-07-25'),
	  (163681,0,'douleurThoracique','douleurThoracique','Douleur thoracique',10,13,0,1,'2020-07-25'),
	  (163682,0,'fievreVesperale','fievreVesperale','Fièvre vespérale',10,13,0,1,'2020-07-25'),
	  (163683,0,'perteAppetit','perteAppetit','Perte d’appétit',10,13,0,1,'2020-07-25');
	  
  
	  
insert into alertLookup(alertId,alertName,descriptionFr,descriptionEn,messageFr,messageEn,alertGroup,priority) values 
(11,'prophylaxieInh','Le patient a six mois sous prophylaxie à l’INH mais n’a pas de date de fin','Patient has six months old on INH prophylaxis but has no end date','Le patient a six mois sous prophylaxie à l’INH mais n’a pas de date de fin','Patient has six months old on INH prophylaxis but has no end date',1,1);	  

insert into alertLookup(alertId,alertName,descriptionFr,descriptionEn,messageFr,messageEn,alertGroup,priority) values 
(12,'nonprophylaxieInh','Le patient est séropositif mais n’a jamais reçu de prophylaxie à l’INH','The patient is HIV positive but has never received INH prophylaxis','Le patient est séropositif mais n’a jamais reçu de prophylaxie à l’INH','The patient is HIV positive but has never received INH prophylaxis',1,1);	  

     