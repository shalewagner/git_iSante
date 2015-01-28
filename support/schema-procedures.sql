delimiter '//'

drop procedure if exists AddColumnUnlessExists
// 
drop procedure if exists AddIndexUnlessExists
// 
drop procedure if exists DropIndexIfExists
//

create procedure AddColumnUnlessExists(
IN dbName tinytext,
IN tableName tinytext,
IN fieldName tinytext,
IN fieldDef text)
begin
IF NOT EXISTS (
SELECT * FROM information_schema.COLUMNS
WHERE column_name=fieldName
and table_name=tableName
and table_schema=dbName
)
THEN
set @ddl=CONCAT('ALTER TABLE ',dbName,'.',tableName,' ADD COLUMN ',fieldName,' ',fieldDef);
prepare stmt from @ddl;
execute stmt;
END IF;
end;
//  

create procedure AddIndexUnlessExists(
IN dbName tinytext,
IN tableName tinytext,
IN indexUnique tinytext,
IN indexName tinytext,
IN indexColumns tinytext)
begin
IF NOT EXISTS (
SELECT * FROM information_schema.STATISTICS
WHERE index_name=indexName
and table_name=tableName
and table_schema=dbName
)
THEN
set @ddl=CONCAT('ALTER TABLE ',dbName,'.',tableName,' ADD ', indexUnique, ' INDEX ',indexName, indexColumns);
prepare stmt from @ddl;
execute stmt;
END IF;
end;
//  

create procedure DropIndexIfExists(
IN dbName tinytext,
IN tableName tinytext,
IN indexName tinytext)
begin
IF EXISTS (
SELECT * FROM information_schema.STATISTICS
WHERE index_name=indexName
and table_name=tableName
and table_schema=dbName
)
THEN
set @ddl=CONCAT('ALTER TABLE ',dbName,'.',tableName,' DROP ', ' INDEX ',indexName);
prepare stmt from @ddl;
execute stmt;
END IF;
end;
//