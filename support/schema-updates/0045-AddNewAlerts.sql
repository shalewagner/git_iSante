delete FROM  regimen WHERE  regID IN (4,6);
go
update patientStatusLookup set statusDescEn='Recent during the transition period',statusDescFr='Récent durant la période de transition' where statusValue=7;
update patientStatusLookup set statusDescEn='Active during the transition period',statusDescFr='actif durant  la période de transition' where statusValue=11;	
update patientStatusLookup set statusDescEn='Lost of follow up  during the transition period',statusDescFr='Perdu de vue durant la période de transition' where statusValue=10;
update patientStatusLookup set statusDescFr='Died during the transition period',statusDescEn='Décédé durant la période de transition' where statusValue=4;			
update patientStatusLookup set statusDescFr='Transferred during the transition period',statusDescEn='Transféré durant la période de transition' where statusValue=5;	
go
                         
insert into alertLookup(alertId,alertName,descriptionFr,descriptionEn,messageFr,messageEn,alertGroup,priority) values 
(10,'formErrors','Forme(s) avec erreur détectée(s)','Form (s) with detected error (s)','Forme(s) avec erreur détectée(s)','Form (s) with detected error (s)',1,1);
go

insert into regimen( regID,regimenName,drugID1,drugID2,drugID3,shortName,regGroup) 
values ('120','1stReg120','91','12','31','EVG-FTC-TDF','1stReg120'),
       ('121','3rd','87','88','90','RAL-DRV/r - ETV','3rd'),
	   ('122','1stReg122','8','89','0','AZT-3TC-DTG','1stReg122'),
       ('123','1stReg123','1','20','89','ABC-3TC-DTG''1stReg123');
go	   

		
