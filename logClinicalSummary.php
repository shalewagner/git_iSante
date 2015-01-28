<?php
include ("backend.php");
error_reporting (E_ALL | E_STRICT);
$paramArray = array ("pid" => $_GET["pid"], "username" => getSessionUser(), "siteCode" => $_GET['site'], "reportNumber" => "206");
#recordEvent($_GET['type'], $paramArray);
?>
