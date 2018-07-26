delete FROM  regimen WHERE  regID IN (4,6);

update patientStatusLookup set statusDescEn='Recent during the transition period',statusDescFr='Récent durant la période de transition' where statusValue=7;
update patientStatusLookup set statusDescEn='Active during the transition period',statusDescFr='actif durant  la période de transition' where statusValue=11;	
update patientStatusLookup set statusDescEn='Lost of follow up  during the transition period',statusDescFr='Perdu de vue durant la période de transition' where statusValue=10;
update patientStatusLookup set statusDescEn='Décédé durant la période de transition',statusDescFr='Died during the transition period' where statusValue=4;			
update patientStatusLookup set statusDescEn='Transféré durant la période de transition',statusDescFr='Transferred during the transition period' where statusValue=5;	

                         
insert into alertLookup(alertId,alertName,descriptionFr,descriptionEn,messageFr,messageEn,alertGroup,priority) values 
(10,'formErrors','Forme(s) avec erreur détectée(s)','Form (s) with detected error (s)','Forme(s) avec erreur détectée(s)','Form (s) with detected error (s)',1,1);




		
