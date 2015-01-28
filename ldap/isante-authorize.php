<?php

#Temporarily change working directory to the top of the isante app. 
#This is kind of ugly. :(
$ccwd = getcwd();
chdir('..');
require_once 'backend/config.php';
require_once 'backend/database.php';
chdir($ccwd);

function isanteAuthorize($username) {
  $qry = "
insert into userPrivilege (username, sitecode, privLevel) 
values ('$username', '" . DEF_SITE . "', 0)";
  dbQuery($qry);

  $qry = "
insert into siteAccess (username, siteCode) 
values ('$username', '" . DEF_SITE . "')";
  dbQuery($qry);
}

?>
