<?php
require_once 'backend.php';
$procName = $_GET['proc'];
dbQuery("exec " . $procName);

//OBSOLETE
/*
switch ($procName) {
case "sp_calculateDoB":
	$rows = returnDate($_GET['ageYears'],$_GET['visitYy'],$_GET['visitMm'],$_GET['visitDd']);
	break;
case "sp_chkVisitDate":
	$rows = dateValid($_GET['visitDate']);
	break;
case "sp_addToUserPrivilege":
	$rows = addUser($_GET['userName']);
	break;
case "sp_removeUser":
	$rows = deleteUser($_GET['userName']);
	break;
case "getQuery":
	$rows = buildRepQuery ($_GET['repNum'],$_GET['site'],$_GET['start'],$_GET['end'], 1);
	break;
default:
	dbQuery("exec " . $procName);
}
echo $rows;
*/
function addUser ($userName) {
	dbQuery("insert into userprivilege (username) values ('" . $userName . "')");
  /*
  $stmt = mssql_init("sp_addToUserPrivilege");
  mssql_bind($stmt, "@userName", $userName, SQLVARCHAR, FALSE, FALSE, 20);
  $result = mssql_execute ($stmt) or die("Could not run addUser proc.");
  */
}
function deleteUser ($userName) {
	dbQuery("delete from userprivilege where username = '" . $userName . "'");
  /*
  $stmt = mssql_init("sp_removeUser");
  mssql_bind($stmt, "@userName", $userName, SQLVARCHAR, FALSE, FALSE, 20);
  $result = mssql_execute ($stmt) or die("Could not run addUser proc.");
  */
}
/*
function dateValid ($visitDate) {
  $stmt = mssql_init("sp_chkVisitDate");
  mssql_bind($stmt, "@visitDate", $visitDate, SQLVARCHAR, FALSE, FALSE, 20);
  $result = mssql_execute ($stmt) or die("Could not run proc.");
  $row = psRowFetchNum($result);
  return ($row[0]);
}

function returnDate ($ageYears,$visitYy,$visitMm,$visitDd) {
  $stmt = mssql_init("sp_calculateDoB");
  mssql_bind($stmt, "@ageYears", $ageYears, SQLVARCHAR, FALSE, FALSE, 20);
  mssql_bind($stmt, "@visitYy", $visitYy, SQLVARCHAR, FALSE, FALSE, 20);
  mssql_bind($stmt, "@visitMm", $visitMm, SQLVARCHAR, FALSE, FALSE, 20);
  mssql_bind($stmt, "@visitDd", $visitDd, SQLVARCHAR, FALSE, FALSE, 20);
  $result = mssql_execute ($stmt) or die("Could not run proc.");
  $row = psRowFetchNum ($result);
  return ($row[0]);
}
*/

?>