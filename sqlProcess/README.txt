Summary of all files in this directory.

--main source files
Cgi.hs common gateway interface code
CLibrary.hs - foreign function definitions for calling Haskell code from C
CLibrary_stub.h
Cli.hs - command line interface code
Makefile
phpExtension.c - code for building the PHP extension
SimpleSql.hs - data structure for representing a tokenized SQL statement
SqlTokenizer.hs - parses an SQL string into an SqlExpr structure
SqlTransform.hs - functions for transforming an SqlExpr structure

--binary output
itech_sql.so - php extension interface

--miscellaneous 
index.php - let's you manually run a query through the translator
phpExtensionTest.php - test to make sure PHP extension is working


This is an explanation of all the processes an SQL statement goes through when processed by the translator. The processes happen in order.

Comments
remove all comments between /* and */ or lines that start with --

With Clause (mssql table hints)
remove
with (a)

Variable Assignment
change
@a = b
to
@a := b
but only if it happens after 'select' and before 'from'

Declare
change
declare a
to
select 1

set identity_insert
change
set identity_insert a
to
select 1

Multi-table Updates
change
update a set b from c where d
to
update c set b where d

Create Temporary Table
change
create table #a b
to
create temporary table a b

Temporary Table References
remove all # symbols not in a quoted string

Queries That Use TOP
change
a top n b
to
a b limit n

CONVERT() Function With Type datetime Or smalldatetime
change
convert(datetime, a + b + c + ...)
to
str_to_date(concat(a, b, c, ...), '%m/%d/%y')

CONVERT() Function With Type float, real Or numeric
change
convert(float, a)
to
(a)

CONVERT() Function With Type int, smallint, tinyint Or bigint
change
convert(int, a)
to
round(a)

CONVERT() Function With Type varchar, varchar(n), char Or char(n)
change
convert(varchar, a)
to
(a)

DATEDIFF() Function With Type day, dd Or d
change
datediff(day, a, b)
to
datediff(b, a)

DATEDIFF() Function With Type year, yyyy Or yy
change
datediff(year, a, b)
to
round(datediff(b, a)/365.242199)

DATEDIFF() Function With Type month, mm Or m
change
datediff(month, a, b)
to
round(datediff(b, a)/30.4368499)

DATEDIFF() Function With Type quarter, qq Or q
change
datediff(quarter, a, b)
to
round(datediff(b, a)/91.3105497)

DATEDIFF() Function With Type week, wk Or ww
change
datediff(week, a, b)
to
round(datediff(b, a)/7)

DATEADD() Function With Type day, dd Or d
change
dateadd(day, a, b)
to
date_add(b, INTERVAL a day)

DATEADD() Function With Type year, yyyy Or yy
change
dateadd(year, a, b)
to
date_add(b, INTERVAL a year)

DATEADD() Function With Type month, mm Or m
change
dateadd(month, a, b)
to
date_add(b, INTERVAL a month)

DATEADD() Function With Type quarter, qq Or q
change
dateadd(quarter, a, b)
to
date_add(b, INTERVAL a quarter)

GETDATE() Function
change
getdate(...)
to
now(...)

LEN() Function
change
len(...)
to
length(...)

SCOPE_IDENTITY() Function
change
scope_identity(...)
to
last_insert_id(...)

ISNULL() Function
change
isnull(...)
to
ifnull(...)

CHARINDEX() Function
change
charindex(...)
to
locate(...)

STR() Function
change
str(a, b, c)
to
round(a, c)

dbo.YMDTODATE() Function (implemented by user defined function support/schema-user-functions/ymdToDate.cpp)
change
dbo.ymdToDate(...)
to
ymdToDate(...)

String Concatenation Via + Operator
change
(a + b + c + ...)
to
concat(a, b, c, ...)

ISNUMERIC() Function
emulated by user defined function support/schema-user-functions/isNumeric.cpp

ISDATE() Function
emulated by user defined function support/schema-user-functions/isDate.cpp
