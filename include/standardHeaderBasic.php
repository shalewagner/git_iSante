<?php
if (DEBUG_FLAG) {
	require_once 'firePHP/lib/FirePHPCore/FirePHP.class.php';
	require_once 'firePHP/lib/FirePHPCore/fb.php';
	ob_start();
	$firephp = FirePHP::getInstance(true);
}
include ("backend.php");
require_once 'include/standardGets.php';
require_once 'labels/bannerLabels.php';
require_once 'labels/labels.php';
require_once 'labels/menu.php';
require_once 'labels/grid.php';
$task = "";
$pid = "";
$lang = "fr";
$site = "";
if (isset ($_REQUEST['task'])) $pid = $_REQUEST['task'];
if (isset ($_REQUEST['pid'])) $pid = $_REQUEST['pid'];
if (isset ($_REQUEST['lang']))$lang = $_REQUEST['lang'];
if (isset ($_REQUEST['site'])) $site = $_REQUEST['site'];
// Variables taken from patient header. Used for print display.
// TODO: Put these in an include?
$fname = getData ("fname", "textarea");
$lname = getData ("lname", "textarea");
$clinID = getData ("clinicPatientID", "textarea");
$fnamemom =  getData ("fnameMother", "textarea");
$natID =  getData ("nationalID", "textarea");
$patientDOB = getData ("dobDd", "textarea") . "/" . getData ("dobMm", "textarea") . "/" . getData ("dobYy", "textarea");
$mf = getData("sex", "textarea");
if($mf!=""){
	$mf=$sex[$lang][$mf]; //this calculation should be a backend function i think
} else {
  $mf = $sex[$lang][3];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=8">
    <link rel="shortcut icon" href="favicon.ico">