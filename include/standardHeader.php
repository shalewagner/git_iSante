<?php
if (DEBUG_FLAG) {
	require_once 'firePHP/lib/FirePHPCore/FirePHP.class.php';
	require_once 'firePHP/lib/FirePHPCore/fb.php';
	ob_start();
	$firephp = FirePHP::getInstance(true);
}

$pid = "";
$lang = "fr";
$site = "";

if (isset ($_REQUEST['pid'])) $pid = $_REQUEST['pid'];
if (isset ($_REQUEST['lang']))$lang = $_REQUEST['lang'];
if (isset ($_REQUEST['site'])) $site = $_REQUEST['site'];
if (isset ($_REQUEST['lastPid'])) $lastPid = $_REQUEST['lastPid'];

if ($pid != "")  $lastPid = $pid;

require_once 'backend.php';
require_once 'include/standardGets.php';
require_once 'labels/bannerLabels.php';
require_once 'labels/labels.php';
require_once 'labels/menu.php';
if (!headers_sent()) {
  header('Content-Type: text/html; charset=utf-8');
}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="x-ua-compatible" content="IE=8">
<link rel="shortcut icon" href="favicon.ico">
<link rel="StyleSheet" type="text/css" href="default.css?<?= urlencode(APP_VERSION) ?>">
<link rel="StyleSheet" type="text/css" href="tabs.css?<?= urlencode(APP_VERSION) ?>">
<link rel="stylesheet" type="text/css" media="print" href="print.css?<?= urlencode(APP_VERSION) ?>">
<?
if ( $type != 0) {
	echo "<script src=\"include/formSubmit.js\"></script>";
}
require_once 'include/errorHead.php';
?>
