call AddColumnUnlessExists(Database(), 'labLookup', 'status', "tinyint unsigned not null default '1' comment '1:iSante lab (default), 2:external lab, 255:deprecated (kept for compatibility)'")
go
DROP TABLE IF EXISTS labGroupLookup;
go
CREATE TABLE IF NOT EXISTS labGroupLookup (
  labGroupLookup_id int(10) unsigned NOT NULL,
  labGroup varchar(255) default NULL,
  PRIMARY KEY  (labGroupLookup_id)
) ENGINE=InnoDB
CHARACTER SET utf8 COLLATE utf8_general_ci
go
DROP TABLE IF EXISTS labPanelLookup;
go
CREATE TABLE IF NOT EXISTS labPanelLookup (
  labPanelLookup_id int(10) unsigned NOT NULL,
  labGroup varchar(255) default NULL,
  panelName varchar(255) default NULL,
  sampleType varchar(255) default NULL,
  PRIMARY KEY  (labPanelLookup_id)
) ENGINE=InnoDB
CHARACTER SET utf8 COLLATE utf8_general_ci
go
delete from labs where labid = 150 and result = 'Off'
go
