
/* This schema change converts the appVersion table into schemaVersion. */

CREATE TABLE schemaVersion (
 version smallint(5) unsigned NOT NULL,
 scriptName text NOT NULL,
 whenUpgraded timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
 PRIMARY KEY (version)
)
go

insert into schemaVersion
select verOrder, scriptName, whenUpgraded
from appVersion
go

drop table appVersion
go
