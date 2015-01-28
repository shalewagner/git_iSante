/* This file contains database schema updates to be applied when upgrading to 8.0rc2 */

alter table patient add masterPid varchar(11) null;
go
update patient set masterPid = patientID where masterPid is null;
go

alter table encTypeLookup modify column enName varchar(50);
go
alter table encTypeLookup modify column frName varchar(50);
go
