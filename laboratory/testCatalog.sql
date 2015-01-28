// get all unique labGroups
drop table if exists labGroupLookup;
create table labGroupLookup (
labGroupLookup_id int unsigned not null auto_increment, 
labGroup varchar(255),
primary key (labGroupLookup_id)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci; 
insert into labGroupLookup (labGroup) select distinct labGroup from labLookup where status = 2 order by testorder;

drop table if exists labPanelLookup;
create table labPanelLookup (
labPanelLookup_id int unsigned not null auto_increment, 
labGroup varchar(255),
panelName varchar(255),
sampleType varchar(255),
primary key (labPanelLookup_id)
)
ENGINE = INNODB
CHARACTER SET utf8 COLLATE utf8_general_ci; 
insert into labPanelLookup (labGroup, panelName, sampleType) select distinct labGroup, panelName, sampletype from labLookup 
where status = 2 and panelName is not null and panelName <> '' and panelName <> 'n/a' order by testorder;
update labPanelLookup set labPanelLookup_id = labPanelLookup_id + 2000;