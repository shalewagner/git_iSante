<?php

function __getGlobalDbHandle() {
  static $dbHandle = null;
  if (!isset($dbHandle)) {
    $dbHandle = __getDbConnection(DB_USER, DB_PASS);
  }
  return $dbHandle;
}

function __getDbConnection($userName, $password) {
  //Functions that use this connection depend on the php extension defined in sqlProcess/ to run.
  //Check to make sure that extension is loaded once here.
  if (!function_exists('itech_translateSql')) {
    dbError('sqlProcess php extension not found');
  }
  if (!function_exists('itech_splitSql')) {
    dbError('sqlProcess php extension not found');
  }

  //Select the correct database.
  if ( (array_key_exists('noid', $_GET)) 
       && ($_GET['noid'] == 'true') ) {
    $dbName = CONSOLIDATED_DB;
  } else {
    $dbName = DB_NAME;
  }

  $dbHandle = new PDO('mysql:host=' . DB_SERV . ';dbname=' . $dbName, $userName, $password)
    or dbError('Unable to connect to the database.',
	       array('userName' => $userName, 'dbName' => $dbName), false);
  $dbHandle->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, TRUE);
  $ps = $dbHandle->prepare('SET CHARACTER SET utf8');
  $ps->execute();
  
  return $dbHandle;
}


//This function translates incompatible expressions in mssql sql strings by calling
//the php extension defined in sqlProcess/.
//Returns the translated SQL or exits with an error.
function transformSql($sql) {
  list($type, $message) = itech_translateSql($sql);
  if ($type == 'SQL') {
    return $message;
  } else if ($type == 'ERROR') {
    dbError('Problem translating SQL statement', 
	    array('query' => $sql, 'message' => $message));
  } else {
    dbError('Got unexpected return type from sqlProcess.', array('type' => $type));
  }
}


//Split up a compound sql statement like 'foo; bar;' into an array of non-compound statements.
//Maybe this function should exit early if no ; characters are in the query?
function splitSql($sql) {
  $results = itech_splitSql($sql);
  $count = array_shift($results);
  if ($count == 0) { //in case of 0 the error message will be the first string
    dbError('Problem splitting SQL statement',
	    array('query' => $sql, 'message' => $results[0]));
  } else {
    return $results;
  }
}


//Prepare a string of SQL. Returns a PDOStatement object.
//Not all drivers supported parameterized prepared statements correctly so they should not be used.
function not_usable__dbPrepare($sql, $shouldTranslate=true) {
  $globalDbHandle = __getGlobalDbHandle();
  if ($shouldTranslate) {
    $fixedSql = transformSql($sql);
  } else {
    $fixedSql = $sql;
  }
  $ps = $globalDbHandle->prepare($fixedSql)
    or dbError('Unable to prepare sql',
	       array('query' => $fixedSql, 'originalQuery' => $sql, 'info' => dbErrorString()));
  logDbMsg($fixedSql);
  return $ps;
}

//Prepare and execute a string of SQL or execute a prepared statement.
//First argument is an SQL string or a PDOStatement object.
//Any additional arguments will be used as parameters when executing the query.
//Returns a PDOStatement object with a result set.
//This object may NOT be reused in future dbQuery calls.
//This function is equivalent to mssql_query();
function dbQuery($sqlOrPs) {

  //if we got a string treat it as sql and prepare it.
  //if we got an object treat it as an already prepared statement. (bad driver support for now)
  if (is_string($sqlOrPs)) {
    //handle multiple query statements by breaking them up
    $statements = splitSql($sqlOrPs);
    while (count($statements) > 1) {
      $statement = array_shift($statements);
      $ps = not_usable__dbPrepare($statement);
      if ($ps->execute() === FALSE) {
	$psError = $ps->errorInfo();
	dbError('Unable to execute prepared statement',
		array('query' => $statement, 'error' => $psError[2],
		      'info' => dbErrorString()));
      }
      $ps->closeCursor();
    }
    $ps = not_usable__dbPrepare($statements[0]);
  } else {
    $ps = $sqlOrPs;
    $ps->closeCursor();
  }

  //bind parameters if there are any (doesn't work with all drivers)
  for ($i = 1; $i < func_num_args(); $i++) {
    dbError("Not all drivers support parameterized prepared statements so don't use them.", array());
    $param = func_get_arg($i);
    $ps->bindValue($i, $param)
      or dbError('Unable to bind value to prepared statement.', array());
  }

  //execute the statement
  if ($ps->execute() === FALSE) {
    $psError = $ps->errorInfo();
    dbError('Unable to execute prepared statement.',
	    array('error' => $psError[2], 'info' => dbErrorString()));
  }

  return $ps;
}


function dbSelectQuery($sqlOrPs) {
  $globalDbHandle = __getGlobalDbHandle();

  static $selectDbHandle = null;

  if (is_null($selectDbHandle)) {
    $selectDbHandle = __getDbConnection(DB_USER . 'select', DB_PASS);
  }
  
  $realGlobalDbHandle = $globalDbHandle;
  $globalDbHandle = $selectDbHandle;
  $ps = dbQuery($sqlOrPs);
  $globalDbHandle = $realGlobalDbHandle;
  return $ps;
}


//Call whenever a database related error happens.
//message is a text description of the error
//data is an array of any data to include when logging
//shouldLog is true when the error should be logged to the database
function dbError($message, $data, $shouldLog=true) {
  $globalDbHandle = __getGlobalDbHandle();

  //prevent this function from calling itself
  static $doingError = false;
  if ($doingError == true) {
    die();
  }
  $doingError = true;

  //print error output to the user
  $data['stack'] = __getStack();
  print 'FATAL ERROR: ' . $message . "<br>\n";
  foreach ($data as $key => $value) {
    print $key . ': ' . $value . "<br>\n";
  }
  
  //log error to the database (if we can)
  if ($shouldLog) {
    $globalDbHandle = __getDbConnection(DB_USER, DB_PASS);
    $data['message'] = $message;
    sleep(1); //make sure we can write to eventLog (timestamp must be unique)
    recordEvent('databaseError', $data);
    if (array_key_exists('query', $data)) {
      logDbMsg($message . ': ' . $data['query']);
    } else {
      logDbMsg($message);
    }
  }
  
  die();
}
//helper function to get a stringified stack trace.
function __getStack() {
  $stack = debug_backtrace();
  $output="";
  $skipEntries = 2; //don't show call to __getStack() or dbError()
  foreach($stack as $entry){
    if ($skipEntries == 0) {
      $output .= "<br>\nFile: " . $entry['file'] . ' (Line: ' . $entry['line'] . ")<br>\n";
      $output .= 'Function: ' . $entry['function'] . "<br>\n";
      $output .= 'Args: ' . implode(', ', $entry['args']) . "<br>\n";
    } else {
      $skipEntries = $skipEntries - 1;
    }
  }
  return $output;
} 


//Turn auto commit off. Start a transaction.
function dbBeginTransaction() {
  $globalDbHandle = __getGlobalDbHandle();
  try {
    $globalDbHandle->beginTransaction();
  } catch (PDOException $e) {
    dbError($e->getMessage(), array());
  }
}

//Finish and commit a transaction.
function dbCommit() {
  $globalDbHandle = __getGlobalDbHandle();
  try {
    return $globalDbHandle->commit();
  } catch (PDOException $e) {
    dbError($e->getMessage(), array());
  }
}

//Revert changes from a transaction.
function dbRollBack() {
  $globalDbHandle = __getGlobalDbHandle();
  try {
    return $globalDbHandle->rollBack();
  } catch (PDOException $e) {
    return false;
  }
}

//Lock tables for writing. Really only needed for Mysql.
function dbLockTables($tables) {
  $tablesWithWrite = array();
  foreach ($tables as $table) {
    $tablesWithWrite[] = $table . ' write';
  }
  dbQuery('lock tables ' . implode(', ', $tablesWithWrite));
}

//Unlocks tables locked by dbLockTables().
function dbUnlockTables() {
  dbQuery('unlock tables');
}

//Get the database error string for the last error.
function dbErrorString() {
  $globalDbHandle = __getGlobalDbHandle();
  $errorArray = $globalDbHandle->errorInfo();
  if (isset($errorArray[2])) {
    return $errorArray[2];
  } else {
    return $errorArray[0];
  }
}


//Takes a PDOStatement object with a result set and returns one record or FALSE on failer.
//Has the default behavior of PDOStatement->fetch()
//Returns an array indexed by both column name and 0-indexed column
//number as returned in your result set.
//This function is equivalent to mssql_fetch_array()
function psRowFetch($ps) {
  return $ps->fetch();
}

//Takes a PDOStatement object with a result set and returns one record or FALSE on failer.
//Returns an array indexed by column name
//number as returned in your result set.
//This function is equivalent to mssql_fetch_assoc()
function psRowFetchAssoc($ps) {
  return $ps->fetch(PDO::FETCH_ASSOC);
}

//Takes a PDOStatement object with a result set and returns one record or FALSE on failer.
//Returns a 0-indexed array
//number as returned in your result set.
//This function is equivalent to mssql_fetch_row()
function psRowFetchNum($ps) {
  return $ps->fetch(PDO::FETCH_NUM);
}

//Return number of fields from the query.
//This function is equivalent to mssql_num_fields()
function psNumFields($ps) {
  return $ps->columnCount();
}

//returns the number of rows modifed by a delete, insert or update query
//does not work with select type queries
function psModifiedCount($ps) {
  return $ps->rowCount();
}



//not for public usage
//just append a string to sql.log
function logDbMsg($msg) {
  //if DEBUG_FLAG is defined it means backend.php and backendAddon.php have been loaded
  // this allows this file not to depend on them and work correctly if they haven't been loaded
  if ( defined('DEBUG_FLAG') && DEBUG_FLAG ) {
    $fh = fopen(getTempFileName('sql', 'log'), 'a') or die("can't open file");
    fwrite($fh, date('c') . "\n" . $msg . "\n");
    fclose($fh);
  }
}

?>
