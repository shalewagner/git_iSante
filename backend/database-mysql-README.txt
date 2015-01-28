
OVERVIEW

database-mysql.php provides an extended PDO interface through two functions called database() and databaseSelect(). The only difference between these two is that queries made through databaseSelect() are limited to SELECT statements only. 

Calling database() returns an extended PDO object. The documentation for PDO can be found here http://php.net/manual/en/book.pdo.php
Repeated calls to database() will result in the same PDO object being returned. It is possible to get a new connection by calling like this database(true) but this should rarely be needed. Database connections are drawn from a connection pool and set to use the UTF-8 character set. Connections are made using Mysql's unbuffered API. 

EXTENSIONS

The object returned by database() is an extended version of the PDO object described here http://php.net/manual/en/book.pdo.php
The changes are as follows.
*. Functions that normally return PDOStatement objects return isantePDOStatement objects instead. isantePDOStatement is described below.
*. To encourage the use of placeholder variables, query statements that contain a ' or " character will produce an error when using the query(). However, it is still possible to have single quotes in select statements by using databaseSelect() instead of database(). See the bottom of this file for an example of that usage.
*. In addition to the ways it can normally be called PDO::query can be called with parameters like (string $statement, array $arguments). Calling query() like this is equivalent to calling PDO::prepare($statement) then PDOStatement::execute($arguments). A isantePDOStatement object is returned.
*. Failures and errors result in a stack trace being printed and execution of the script being terminated. 
*. If the debug flag is set queries will be logged when exec(), query() and prepare() are called.

isantePDOStatement has the following changes vs. the standard PDOStatement.
*. fetch() and fetchAll() return rows with style PDO::FETCH_ASSOC by default.
*. Failures and errors result in a stack trace being printed and execution of the script being terminated. 

CAVEATS

*. Connections are drawn from a common connection pool. After a script is done executing it's connections are returned to the pool. This means that some care needs to be taken to insure a connection is not returned in a bad state. A bad state would be caused by something like leaving tables locked or not finishing a transaction. 
*. This interfaces uses Mysql's unbuffered API. This means that Mysql only returns data to the client when a fetch() function is called. This is in contrast to the buffered API which returns all data from a query to the client at once. Because of this it is not possible to run a second query until the first one is finished. The easiest way around this limitation is to use fetchAll() to retrieve all data at once or to use PDOStatement::closeCursor() to finish the query. 
*. Since ' and " characters will result in an error string values must be passed using query parameters.
*. Query parameters are never logged when using PDO::prepare() with PDOStatement::execute(). 

EXAMPLES

Simple one-off query

       $statement = database()->query('select * from foobar');
       while ($row = $statement->fetch()) {
       	     ...
       }

Simple one-off query with parameters

       $statement = database()->query('select * from foobar where bar = ?', array($parameter));
       while ($row = $statement->fetch()) {
       	     ...
       }

Execute queries based on rows from another query

       #must use fetchAll() because multiple queries can not execute at the same time
       $data = database()->query('select * from readData')->fetchAll();
       foreach ($data as $row) {
       	       database()->query('insert into foobar set bar = ?', array($row['bar']));
       }

Execute queries based on rows from another query (using prepare)

       #must use fetchAll() because multiple queries can not execute at the same time
       $data = database()->query('select * from readData')->fetchAll();
       $statement = database()->prepare('select * from foobar where foo = ? and bar = ?');
       foreach ($data as $row) {
		$statement->execute(array($row['foo'],$row['bar']));
		while ($subrow = $statement->fetch()) {
			...
		}
       } 

Insert a bunch of data using the same query multiple times as a prepared statement

       $data = array(...);
       $barParam = null;
       $statement = database()->prepare('insert into foobar set bar = :bar');
       $statement->bindParam(':bar', $barParam, PDO::PARAM_INT);
       foreach ($data as $row) {
       	       $barParam = $row['bar'];
	       $statement->execute();
	       $statement->closeCursor();
       }

Fetch a few records and abort the query

       $statement = database()->query('select * from foobar');
       $row1 = $statement->fetch();
       $row2 = $statement->fetch();
       $statement->closeCursor(); 

Execute a read-only select containing single quotes and put the result into a json string:

	   $sql = "select * from patient where patientid = '" . $pid . "'";
	   $resultArray = databaseSelect()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	   $data = json_encode($resultArray);  
	   echo '({"total":"' . $rows . '","results":' . $data . '})';

