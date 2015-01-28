<?php
/**
 * Language logic
 *
 * The order in which the language is set is:
 * 1. from the 'lang' GET variable
 * 2. or from the 'lang' session variable
 * 3. or finally from the 'language' variable
 *
 * @author	Svend Sorensen
 * @version	$Id: lang.php 73 2006-04-26 20:51:21Z svends $
 */

// Get session language
if (isset($_SESSION['lang'])) {
	$language = $_SESSION['lang'];
}

// Get GET language
if (isset($_GET['lang'])) {
	$language = $_GET['lang'];

	// Save language setting
	$_SESSION['lang'] = $language;
}

// Convert two character language IDs to gettext format
if (strlen($language) == 2) {
	$language = sprintf("%s_%s",
		strtolower($language),
		strtoupper($language)
	);
}

// Set up gettext for language
putenv("LANG=$language");
setlocale(LC_ALL, $language);
bindtextdomain('messages', "./include/locale");
textdomain('messages');
?>
