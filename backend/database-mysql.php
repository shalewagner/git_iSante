<?php

#These first two functions are the only ones that should be called directly by code not in this file. They both return an extended PDO object. The difference between them is that the object returned by databaseSelect only has permission to execute select statements. 
function database($forceNewConnection = false) {
  static $dbHandle = null;
  if (!isset($dbHandle) || $forceNewConnection) {
    $dbHandle = _isante_dbConnect();
  }
  return $dbHandle;
}
function databaseSelect($forceNewConnection = false) {
  static $dbHandle = null;
  if (!isset($dbHandle) || $forceNewConnection) {
    $dbHandle = _isante_dbConnect(true);
  }
  return $dbHandle;
}


#This is the extended version of PDO that is returned by database() and databaseSelect(). The differnces between normal PDO are
#*. Functions that normally return PDOStatement objects return isantePDOStatement objects instead.
#*. To encourage the use of placeholder variables query statements that contain a ' or " character will produce an error.
#*. PDO::query can be called with parameters like (string $statement, array $arguments). Calling query() like this is equivalent to calling PDO::prepare($statement) then PDOStatement::execute($arguments). A isantePDOStatement object is returned.
#*. Failures and errors result in a call to _isante_dbError() 
#*. If the debug flag is set queries will be logged when exec(), query() and prepare() are called.
class isantePDO extends PDO {
  public function exec($statement) {
    $this->_isante_checkStatementAndLog($statement);
    $result = parent::exec($statement);
    if ($result === FALSE) {
      _isante_dbError('Unable to execute sql',
		      array('query' => $statement, 'info' => _isante_dbErrorString($this)));
    }
    return $result;
  }

  public function prepare($statement, $driver_options = array()) {
    $this->_isante_checkStatementAndLog($statement);
    $pdoStatement = parent::prepare($statement, $driver_options);
    if ($pdoStatement === FALSE) {
      _isante_dbError('Unable to prepare sql',
		      array('query' => $statement, 'info' => _isante_dbErrorString($this)));
    }
    return new isantePDOStatement($pdoStatement);
  }

  public function query($statement, $arg2 = null) {
    if (is_null($arg2)) {
      #single parameter case where only a query statement is provided
      $this->_isante_checkStatementAndLog($statement);
      $pdoStatement = parent::query($statement);
    } else if (is_array($arg2)) {
      #two parameter case where a query statement and an array or parameters are given

      #This is what should happen in this case but calling the overloaded methods adds too much overhead for my tastes.
      ##$isantePdoStatement = $this->prepare($statement);
      ##$isantePdoStatement->execute($arg2);
      ##return $isantePdoStatement;

      $this->_isante_checkStatementAndLog($statement, $arg2);
      $pdoStatement = parent::prepare($statement);
      if ($pdoStatement === FALSE) {
	_isante_dbError('Unable to prepare sql',
			array('query' => $statement, 'info' => _isante_dbErrorString($this)));
      }
      $result = $pdoStatement->execute($arg2);
      if ($result === FALSE) {
	_isante_dbError('execute() failed.',
			array('info' => _isante_dbErrorString($pdoStatement)));
      }
      return new isantePDOStatement($pdoStatement);
    } else {
      $arguments = func_get_args();
      $this->_isante_checkStatementAndLog($statement);
      $pdoStatement = call_user_func_array(array(parent, 'query'), $arguments);
    }

    if ($pdoStatement === FALSE) {
      _isante_dbError('Unable to execute sql',
		      array('query' => $statement, 'info' => _isante_dbErrorString($this)));
    }
    return new isantePDOStatement($pdoStatement);
  }

  public function beginTransaction() {
    try {
      $result = parent::beginTransaction();
      if ($result === FALSE) {
	_isante_dbError('beginTransaction() failed.',
			array('info' => _isante_dbErrorString($this)));
      }
      return $result;
    } catch (PDOException $e) {
      _isante_dbError($e->getMessage(), array());
    }
  }

  public function commit() {
    try {
      $result = parent::commit();
      if ($result === FALSE) {
	_isante_dbError('commit() failed.',
			array('info' => _isante_dbErrorString($this)));
      }
      return $result;
    } catch (PDOException $e) {
      _isante_dbError($e->getMessage(), array());
    }
  }

  public function rollBack() {
    try {
      $result = parent::rollBack();
      if ($result === FALSE) {
	_isante_dbError('rollBack() failed.',
			array('info' => _isante_dbErrorString($this)));
      }
      return $result;
    } catch (PDOException $e) {
      _isante_dbError($e->getMessage(), array());
    }
  }

  private static function _isante_checkStatementAndLog($statement, $arguments = null) {
    if (strpos($statement, '\'') !== FALSE
	|| strpos($statement, '"') !== FALSE) {
      _isante_dbError('Query contains illegal character \' or ".', array());
    }
    _isante_dbLogMessage($statement, $arguments);
  }
}

#Version of isantePDO without restriction on ' and " characters. Used for select only queries.
class isantePdoSelect extends isantePDO {
  private static function _isante_checkStatementAndLog($statement, $arguments = null) {
    _isante_dbLogMessage($statement, $arguments);
  }
}


#This is a wrapper to PDOStatement. Note that it does not extend PDOStatement but still provides all the same functionality through __call(). 
#Two aspects of PDOStatement are changed by this. The first is that fetch() and fetchAll() return rows with style PDO::FETCH_ASSOC by default. The second is that when something fails _isante_dbError is called.
class isantePDOStatement {
  private $pdoStatement;

  public function __construct($pdoStatement) {
    $this->pdoStatement = $pdoStatement;
  }

  public function __call($name, $arguments) {
    return call_user_func_array(array($this->pdoStatement, $name), $arguments);
  }

  public function execute($input_parameters = null) {
    $result = $this->pdoStatement->execute($input_parameters);
    if ($result === FALSE) {
      _isante_dbError('execute() failed.',
		      array('info' => _isante_dbErrorString($this)));
    }
    return $result;
  }

  public function fetch($fetch_style = PDO::FETCH_ASSOC,
			$cursor_orientation = PDO::FETCH_ORI_NEXT,
			$cursor_offset = 0) {
    return $this->pdoStatement->fetch($fetch_style, $cursor_orientation, $cursor_offset);
  }

  public function fetchAll($fetch_style = PDO::FETCH_ASSOC,
			   $fetch_argument = null,
			   $ctor_args = null) {
    if (is_null($fetch_argument)) {
      return $this->pdoStatement->fetchAll($fetch_style);
    } else if ($fetch_argument == PDO::FETCH_CLASS) {
      return $this->pdoStatement->fetchAll($fetch_style, $fetch_argument, $ctor_args);
    } else {
      return $this->pdoStatement->fetchAll($fetch_style, $fetch_argument);
    }
  }

  public function fetchColumn($column_number = 0) {
    return $this->pdoStatement->fetchColumn($column_number);
  }

  public function bindColumn($column, $param,
			     $type = null, $maxlen = null, $driverdata = null) {
    $result = $this->pdoStatement->bindColumn($column, $param, $type, $maxlen, $driverdata);
    if ($result === FALSE) {
      _isante_dbError('bindColumn() failed.',
		      array('info' => _isante_dbErrorString($this)));
    }
    return $result;
  }

  public function bindParam($parameter, $variable,
			    $data_type = PDO::PARAM_STR, $length = null, $driver_options = null) {
    $result = $this->pdoStatement->bindParam($parameter, $variable, $data_type, $length, $driver_options);
    if ($result === FALSE) {
      _isante_dbError('bindParam() failed.',
		      array('info' => _isante_dbErrorString($this)));
    }
    return $result;
  }

  public function bindValue($parameter, $value, $data_type = PDO::PARAM_STR) {
    $result = $this->pdoStatement->bindValue($parameter, $value, $data_type);
    if ($result === FALSE) {
      _isante_dbError('bindValue() failed.',
		      array('info' => _isante_dbErrorString($this)));
    }
    return $result;
  }

  public function closeCursor() {
    $result = $this->pdoStatement->closeCursor();
    if ($result === FALSE) {
      _isante_dbError('closeCursor() failed.',
		      array('info' => _isante_dbErrorString($this)));
    }
    return $result;
  }
}

#Get an unbuffered PDO database handle from the connection pool.
function _isante_dbConnect($selectOnly = false) {
  try {
    if ($selectOnly) {
      return new isantePdoSelect('mysql:host=' . DB_SERV . ';dbname=' . DB_NAME,
				 DB_USER . 'select', DB_PASS,
				 array(PDO::ATTR_PERSISTENT => true,
				       PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false,
				       PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8'));
    } else {
      return new isantePDO('mysql:host=' . DB_SERV . ';dbname=' . DB_NAME,
			   DB_USER, DB_PASS,
			   array(PDO::ATTR_PERSISTENT => true,
				 PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false,
				 PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8'));
    }
  } catch (PDOException $e) {
    _isante_dbError('Unable to connect to the database. ' . $e->getMessage(),
		    array('userName' => $username, 'dsn' => $dsn), false);
  }
}

#Get the error string from eaither a PDO or PDOStatement object.
function _isante_dbErrorString($object) {
  $errorArray = $object->errorInfo();
  if (isset($errorArray[2])) {
    return $errorArray[2];
  } else {
    return $errorArray[0];
  }
}

//Call whenever a database related error happens.
//message is a text description of the error
//data is an array of any data to include when logging
//shouldLog is true when the error should be logged to the database
function _isante_dbError($message, $data, $shouldLog=true) {
  //don't do anything if called recursively
  static $doingError = false;
  if ($doingError == true) {
    return;
  }
  $doingError = true;

  //print error output to the user
  $data['stack'] = _isante_getStack();
  print 'FATAL ERROR: ' . $message . "<br>\n";
  foreach ($data as $key => $value) {
    print $key . ': ' . $value . "<br>\n";
  }

  //log error to the database (if we can)
  if ($shouldLog) {
    $data['message'] = $message;
    sleep(1); //make sure we can write to eventLog (timestamp must be unique (I know. It sucks.))
    recordEvent('databaseError', $data);
    if (array_key_exists('query', $data)) {
      _isante_dbLogMessage($message . ': ' . $data['query']);
    } else {
      _isante_dbLogMessage($message);
    }
  }

  die();
}
//helper function to get a stringified stack trace.
function _isante_getStack() {
  $stack = debug_backtrace();
  $output="";
  $skipEntries = 2; //don't show call to _isante_getStack() or _isante_dbError()
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

//append a string to the users sql.log when the debug flag is set
function _isante_dbLogMessage($msg, $arguments = null) {
  //if DEBUG_FLAG is defined it means backend.php and backendAddon.php have been loaded
  // this allows this file not to depend on them and work correctly if they haven't been loaded
  if ( defined('DEBUG_FLAG') && DEBUG_FLAG ) {
    if (is_array($arguments)) {
      $msg = $msg . ' ' . implode(', ', $arguments);
    }
    $fh = fopen(getTempFileName('sql', 'log'), 'a') or die("can't open file");
    fwrite($fh, date('c') . "\n" . $msg . "\n");
    fclose($fh);
  }
}

?>
