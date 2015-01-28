
There are two ways to interact with the database. One is exposed through database-mssql.php and the other through database-mysql.php.

database-mysql.php is the preferred interface and should be used for all new queries and when changing old ones. This interface exposes an extended PDO interface directly to a MySql database. See database-mysql-README.txt for details on the extensions made and for usage examples. 

database-mssql.php is an old interface left over from when this project used Microsoft SQL Server. This interface exposes a proprietary interface that can optionally perform some translation on MsSql queries into MySql compatible queries. This translation is accomplished with a custom PHP extension written in Haskell (see sqlProcess/). Use of this interface should be avoided. 

