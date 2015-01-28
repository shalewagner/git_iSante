
This directory contains database schema update files. Schema changes are tracked in the schemaVersion table. During an upgrade any schema update file that has not been applied to the database will be.

The schema update files have a special naming convention. 

$number-$name.sql

$number is a four digit, zero padded, unique integer that expresses the order the change should be applied. $name is a small descriptive name for the schema change. Ideally each schema update file would only contain a single logical change to the database schema and have a name that expresses the intent of that single logical change. 

All you have to do is put files in this directory and they will automatically be picked up. The format of the files is not quite standard SQL. Statements in these files are processed through the SQL translator and use a delimiter of 'go'.

It is generally a very bad idea to make any edits to schema update files that have been included in a production release. Edits to schema update files that have not yet been included in a release are no problem. 

The initial schema still needs to be kept in sync with these changes. The initial schema file is located in support/schema-tables.sql. The initial record in the schemaVersion must also be kept updated. 
