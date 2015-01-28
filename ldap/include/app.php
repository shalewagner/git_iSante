<?php
/**
 * Application wide include file
 *
 * This file handles configuration reading, language setting, and
 * authentication.
 *
 * @author	Svend Sorensen
 * @version	$Id: app.php 150 2007-04-12 21:58:46Z svends $
 */

// Read default configuration
require_once ('./include/config.default.php');
// Optionally read configuration overrides
if (is_file('./include/config.php')) {
	include_once ('./include/config.php');
}

// Start session
@session_start();

// Set the application language
$language = $cfg['lang'];
require_once ('./include/lang.php');

// Get account list which is used by all pages
require_once ('./include/accounts.php');
$accounts = new Accounts($cfg);

// Check authentication for session auth_type
if ($cfg['auth_type'] == "session") {
	require_once ('./include/app-auth.php');

        // Refresh the account list after logging in
        $accounts = new Accounts($cfg);
}
?>
