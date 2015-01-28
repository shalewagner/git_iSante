<?php

require_once 'backend/jasper-reports.php';

if (preg_match ('/MSIE/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('/Trident/i', $_SERVER['HTTP_USER_AGENT'])) {
  header ("Pragma: token");
  header ("Cache-Control: private");
}

if (strtoupper($_REQUEST['format']) == 'PDF') {
  header('Content-type: application/pdf');
  header('Content-disposition: attachment; filename="report.pdf"');
} elseif (strtoupper($_REQUEST['format']) == 'HTML') {
  header('Content-type: text/html; charset=utf-8');
} elseif (strtoupper($_REQUEST['format']) == 'XLS') {
  header('Content-type: application/x-excel');
  header('Content-disposition: attachment; filename="report.xls"');
}

$argumentsArray = array();

foreach ($_GET as $key => $value) {
  $argumentsArray[$key] = $value;
}
foreach ($_POST as $key => $value) {
  $argumentsArray[$key] = $value;
}

readfile(renderReportToFile($argumentsArray, empty($_REQUEST['donotlog'])));

?>
