/* This file contains database schema updates to be applied when upgrading to 9.0 RC3 */
/* add some fields to labs to support OpenELIS Interoperability */  
call AddColumnUnlessExists(Database(), 'labs', 'accessionNumber', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'labs', 'sendingSiteName', 'varchar(255) not null default "iSanté"')
go
call AddColumnUnlessExists(Database(), 'labs', 'sendingSiteID', 'mediumint unsigned null')
go
call AddColumnUnlessExists(Database(), 'labs', 'labGroup', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'labs', 'sectionOrder', 'int unsigned null')
go
call AddColumnUnlessExists(Database(), 'labs', 'panelName', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'labs', 'panelOrder', 'int unsigned null')
go
call AddColumnUnlessExists(Database(), 'labs', 'testNameFr', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'labs', 'testNameEn', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'labs', 'testOrder', 'int unsigned null')
go
call AddColumnUnlessExists(Database(), 'labs', 'sampleType', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'labs', 'loincCode', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'labs', 'externalResultType', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'labs', 'minValue', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'labs', 'maxValue', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'labs', 'validRangeMin', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'labs', 'validRangeMax', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'labs', 'referenceRange', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'labs', 'resultTimestamp', 'timestamp null')
go
call AddColumnUnlessExists(Database(), 'labs', 'resultStatus', 'tinyint unsigned not null default 0')
go
call AddColumnUnlessExists(Database(), 'labs', 'supersededDate', 'timestamp null')
go
alter table labs modify units varchar(255) NULL
go
alter table labs modify resultRemarks varchar(1000) NULL
go
/* add some fields to otherLabs to support OpenELIS Interoperability */
call AddColumnUnlessExists(Database(), 'otherLabs', 'accessionNumber', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'otherLabs', 'sendingSiteName', 'varchar(255) null default "iSanté"')
go
call AddColumnUnlessExists(Database(), 'otherLabs', 'sendingSiteID', 'mediumint unsigned null')
go
call AddColumnUnlessExists(Database(), 'otherLabs', 'labGroup', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'otherLabs', 'sectionOrder', 'int unsigned null')
go
call AddColumnUnlessExists(Database(), 'otherLabs', 'panelName', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'otherLabs', 'panelOrder', 'int unsigned null')
go
call AddColumnUnlessExists(Database(), 'otherLabs', 'testOrder', 'int unsigned null')
go
call AddColumnUnlessExists(Database(), 'otherLabs', 'sampleType', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'otherLabs', 'loincCode', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'otherLabs', 'externalResultType', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'otherLabs', 'minValue', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'otherLabs', 'maxValue', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'otherLabs', 'validRangeMin', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'otherLabs', 'validRangeMax', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'otherLabs', 'referenceRange', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'otherLabs', 'resultTimestamp', 'timestamp null')
go 
call AddColumnUnlessExists(Database(), 'otherLabs', 'resultRemarks', 'varchar(1000) null')
go 
alter table otherLabs modify units varchar(255) NULL
go
/* add some fields to labLookup to support OpenELIS Interoperability */
call AddColumnUnlessExists(Database(), 'labLookup', 'sectionOrder', 'int unsigned null')
go
call AddColumnUnlessExists(Database(), 'labLookup', 'panelName', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'labLookup', 'panelOrder', 'int unsigned null')
go
call AddColumnUnlessExists(Database(), 'labLookup', 'testOrder', 'int unsigned null')
go
call AddColumnUnlessExists(Database(), 'labLookup', 'sampleType', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'labLookup', 'loincCode', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'labLookup', 'validRangeMin', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'labLookup', 'validRangeMax', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'labLookup', 'referenceRange', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'labLookup', 'units', 'varchar(255) null')
go
call AddColumnUnlessExists(Database(), 'labLookup', 'externalResultType', 'varchar(255) null')
go 
alter table labLookup modify labGroup varchar(255) NULL
go
alter table labLookup modify minValue varchar(255) NULL
go
alter table labLookup modify maxValue varchar(255) NULL
go
CREATE TABLE IF NOT EXISTS `labMessageStorage` (
  `labMessageStorage_id` int(10) unsigned NOT NULL auto_increment,
  `dbSite` tinyint unsigned not null,
  `senderName` varchar(255) default NULL,
  `senderSiteCode` mediumint(8) default NULL,
  `receiptDateTime` datetime NOT NULL,
  `originalXmitDateTime` datetime NOT NULL,
  `message` mediumblob,
  PRIMARY KEY  (`labMessageStorage_id`, `dbSite`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;
go
call AddColumnUnlessExists(Database(), 'labs', 'labMessageStorage_id', 'INT UNSIGNED NULL')
go
call AddColumnUnlessExists(Database(), 'labs', 'labMessageStorage_seq', 'INT UNSIGNED NULL')
go
call AddColumnUnlessExists(Database(), 'otherLabs', 'labMessageStorage_id', 'INT UNSIGNED NULL')
go
call AddColumnUnlessExists(Database(), 'otherLabs', 'labMessageStorage_seq', 'INT UNSIGNED NULL')
go
/* add support for a default network assignment per user */
call AddColumnUnlessExists(Database(), 'userPrivilege', 'network', 'VARCHAR(100) NULL') 
go
/* add support for authorization by service area */ 
call AddColumnUnlessExists(Database(), 'userPrivilege', 'serviceArea', 'TINYINT UNSIGNED NOT NULL DEFAULT 7')
go
