
delete from `patientStatusLookup`;

INSERT INTO `patientStatusLookup` (`statusValue`, `statusDescEn`, `statusDescFr`, `ReportOrder`) VALUES
(0,'unknown','Inconu',0),
(7,'Recent Pre-ART','Récents en Pré-ARV',7),
(10,'Lost to follow up Pre-ART','Perdus de vue en Pré-ARV',8),
(4,'Deceased on Pre-ART','Décédés en Pré-ARV',9),
(5,'Transferred on Pre-ART','Transférés en Pré-ARV',10),
(6,'Regular on ART','Réguliers sous ARV',1),
(8,'Missed appointments on ART','Rendez-vous rates sous ARV',3),
(9,'Lost to follow on ART','Perdus de vue sous ARV',2),
(1,'Deceased ART','Décédés sous ARV',4),
(3,'Discontinued on ART','Arrêtés sous ARV',5),
(2,'Transferred on ART','Transférés sous ARV',6),
(11,'Actif on Pre-Art','Actifs en Pré-ARV',11);
