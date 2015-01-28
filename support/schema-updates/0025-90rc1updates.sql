/* This file contains database schema updates to be applied when upgrading to 9.0 RC1 */

/* must start with a fresh batch of replication file in order to fix deleted encounter problem */
truncate table replicationRead
go

/* need to add a column to hivQual table to be able to distinguish between */
/* adult, ped. & monthly indicator rows (0 or NULL = adult (default), */
/* 1 = monthly indicator, 2 = ped.). */
call AddColumnUnlessExists(Database(), 'hivQual', 'row_type', 'tinyint NULL')
go

/* add startdate and row_type to the unique index on hivQual ALTER TABLE hivQual DROP INDEX IX_hivQual_siteCode_endDate */
call DropIndexIfExists(Database(), 'hivQual', 'IX_hivQual_siteCode_endDate')
go
/*ALTER TABLE hivQual ADD UNIQUE INDEX hivqualIndex ( siteCode, startDate, endDate ) */
call AddIndexUnlessExists(Database(), 'hivQual', 'UNIQUE', 'hivqualIndex', '( siteCode, startDate, endDate, row_type )')   
go

/* add table for communicating report data between php and jasper */
DROP TABLE IF EXISTS staticReportData
go
CREATE TABLE staticReportData (
reportNumber INT UNSIGNED NOT NULL ,
username VARCHAR( 20 ) NOT NULL ,
value1 TEXT NOT NULL ,
value2 TEXT NULL ,
value3 TEXT NULL ,
value4 TEXT NULL
) ENGINE = InnoDB 
go

/*ALTER TABLE staticReportData ADD INDEX ( reportNumber, user ) */
call AddIndexUnlessExists(Database(), 'staticReportData', '', 'staticReportDataIndex', '( reportNumber, username )') 
go

/* add index for patientStatusTemp ALTER TABLE patientStatusTemp ADD INDEX ( endDate, patientID ) */
call AddIndexUnlessExists(Database(), 'patientStatusTemp', '', 'patientStatusTempIndex', '( endDate, patientID )')
go 

/* add table to hold iSanté concepts and map their conceptKey values to the MVP dictionary concept_id values */ 
DROP TABLE IF EXISTS isanteConcepts
go
create table isanteConcepts (
concept_id  int(10) unsigned NOT NULL, 
conceptKey varchar(50) NOT NULL,
oldiSanteId int(10) unsigned NULL,
datatype_id int(10) unsigned NOT NULL,
primary key  ( conceptKey ),
unique index mvpId  ( concept_id, conceptKey )
) 
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci;
go 

/* add table to hold concepts that come from existing table columns rather than from the concept table */
DROP TABLE IF EXISTS staticConcepts
go
create table staticConcepts (
column_name varchar(64) not null, 
table_name varchar(64) not null, 
concept_class_id tinyint unsigned not null default 11, 
concept_datatype_id tinyint unsigned not null default 3
) ENGINE = InnoDB
go

/* add newest form version column to encTypeLookup table */
call AddColumnUnlessExists(Database(), 'encTypeLookup', 'newestFormVersion', 'tinyint unsigned not null default 0')
go

/* add new columns for allowedDisclosures in the registration form */
call AddColumnUnlessExists(Database(), 'allowedDisclosures', 'disclosureAddress', 'varchar(255) NULL after disclosureRel')
go

/*alter table allowedDisclosures add disclosureTelephone varchar(255) NULL after disclosureAddress*/ 
call AddColumnUnlessExists(Database(), 'allowedDisclosures', 'disclosureTelephone', 'varchar(255) NULL after disclosureAddress')
go

/* add an index on vitals to hasten pregnancy calculation queries (mostly for consolidated servers) */
call AddIndexUnlessExists(Database(), 'vitals', '', 'pregIndex', '( siteCode, pregnant )')
go 

/* add unique index on concept.short_name */
/* Truncate the table because old versions had duplicates. They will be restored when lookups.csv.gz is reloaded. */
truncate table concept
go
call AddIndexUnlessExists(Database(), 'concept', 'UNIQUE', 'conceptNameIndex', '( short_name )')   
go


/* remove duplicates from siteAccess and add primary index (mysql only) */
CREATE temporary TABLE siteAccessTemp (
 username varchar(20) NOT NULL default '',
 siteCode mediumint(5) unsigned zerofill NOT NULL default '00000',
 PRIMARY KEY  (username,siteCode)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go

insert into siteAccessTemp
select * from siteAccess
on duplicate key update siteAccessTemp.username=siteAccess.username
go

drop table siteAccess
go

CREATE TABLE siteAccess (
 username varchar(20) NOT NULL default '',
 siteCode mediumint(5) unsigned zerofill NOT NULL default '00000',
 PRIMARY KEY  (username,siteCode)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go

insert into siteAccess
select * from siteAccessTemp
go


/* remove duplicates from userPrivilege and add primary index (mysql only) */
CREATE temporary TABLE userPrivilegeTemp (
 username varchar(20) NOT NULL default '',
 privLevel tinyint(3) unsigned NOT NULL default '0',
 siteCode mediumint(5) unsigned zerofill NOT NULL default '00000',
 allowTrans tinyint(3) unsigned NOT NULL default '0',
 allowValidate tinyint(3) unsigned NOT NULL default '0',
 uiConfiguration tinyint(3) unsigned NOT NULL default '0',
 debugFlag tinyint(3) unsigned NOT NULL default '0',
 PRIMARY KEY  (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go

insert into userPrivilegeTemp
select * from userPrivilege
on duplicate key update userPrivilegeTemp.username= userPrivilege.username
go

drop table userPrivilege
go

CREATE TABLE userPrivilege (
 username varchar(20) NOT NULL default '',
 privLevel tinyint(3) unsigned NOT NULL default '0',
 siteCode mediumint(5) unsigned zerofill NOT NULL default '00000',
 allowTrans tinyint(3) unsigned NOT NULL default '0',
 allowValidate tinyint(3) unsigned NOT NULL default '0',
 uiConfiguration tinyint(3) unsigned NOT NULL default '0',
 debugFlag tinyint(3) unsigned NOT NULL default '0',
 PRIMARY KEY  (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
go

insert into userPrivilege
select * from userPrivilegeTemp
go


/* add isanteForms (forms dictionary, previously named excelLoad) */
DROP TABLE IF EXISTS isanteForms
go
CREATE TABLE isanteForms ( 
encType int(11) NOT NULL ,
formVersion tinyint(4) NOT NULL ,
section tinyint(4) NOT NULL ,
field int(4) NOT NULL ,
labelEn varchar(50) default NULL ,
labelFr varchar(50) default NULL ,
conceptKey varchar(50) default NULL ,
default_value varchar(50) default NULL ,
conceptOrTable varchar(30) default NULL ,
UNIQUE KEY dictionaryIndex (encType, formVersion , section , field) 
) ENGINE = InnoDB DEFAULT CHARSET = utf8
go
