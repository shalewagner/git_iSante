<?php
/**
 * Page header template
 *
 * @author	Svend Sorensen
 * @version	$Id: header.tmpl.php 127 2006-10-20 17:35:41Z svends $
 */

// TODO: The message code shouldn't be in the template page

// Message passing between pages
//
// messages is an indexed array:
// index 'info' is an array of informational messages
// index 'error' is an array of error messages
if (isset($_SESSION['messages'])) {
	$messages = $_SESSION['messages'];
	unset($_SESSION['messages']);
} else {
	$messages = array();
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php print $title; ?></title>
	<link href="stylesheets/main.css" media="screen" rel="Stylesheet" type="text/css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
	<h1><?php print $title; ?></h1>

<?php if (array_key_exists('error', $messages)) { ?>
	<ul class="error">
<?php foreach ($messages['error'] as $message) { ?>
		<li><?php print $message; ?></li>
<?php } // End foreach ?>
	</ul>
<?php } // End if ?>

<?php if (array_key_exists('info', $messages)) { ?>
	<ul class="info">
<?php foreach ($messages['info'] as $message) { ?>
		<li><?php print $message; ?></li>
<?php } // End foreach ?>
	</ul>
<?php } // End if ?>
