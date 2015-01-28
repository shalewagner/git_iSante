DROP TABLE IF EXISTS encounterQueue
go
CREATE TABLE IF NOT EXISTS encounterQueue (
encounterType tinyint unsigned NOT NULL,
sitecode  mediumint unsigned NOT NULL,
encounter_id int unsigned NOT NULL,
dbSite tinyint unsigned NOT NULL DEFAULT 0, 
encounterStatus tinyint unsigned NOT NULL,
createDateTime datetime NULL,
lastStatusUpdate datetime NULL,
accessionNumber VARCHAR(255) NULL,
  PRIMARY KEY  (encounter_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go

DROP TABLE IF EXISTS queueStatusLookup;
go
CREATE TABLE IF NOT EXISTS queueStatusLookup (
encounterStatus tinyint unsigned NOT NULL,
statusTextEn varchar(200) NOT NULL,
statusTextFr varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go

INSERT INTO queueStatusLookup values (1, 'New order', 'Nouvel ordre')
go
INSERT INTO queueStatusLookup values (2, 'Successfully sent and accepted', 'Envoyé avec succès et accepté')
go
INSERT INTO queueStatusLookup values (3, 'Successfully sent but rejected', 'Envoyé avec succès mais rejeté')
go
INSERT INTO queueStatusLookup values (4, 'Send failed', 'Envoyer échoué')
go
INSERT INTO queueStatusLookup values (5, 'Order canceled', 'Ordre annulée')
go
INSERT INTO queueStatusLookup values (6, 'Results received for order', 'Résultats reçu l’ordre')
go