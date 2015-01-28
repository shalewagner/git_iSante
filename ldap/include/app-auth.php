<?php
/**
 * Application authentication file
 *
 * @author	Svend Sorensen
 * @version	$Id: app.php 74 2006-04-26 20:56:34Z svends $
 */
 
/*
 * Test the given username and password
 */
function login($username, $password, $accounts)
{
	$r = false;

	if (!empty($username)) {
		$account = $accounts->find($username);

		if ($account) {
			$account->password = $password;

			$r = $accounts->login($account);
		}
	} else {
		// Attempt anonymous login (disabled)
		// TODO: Add configuration setting to enable/disable anonymous
		// logins
		//$r = $accounts->login();
	}

	return $r;
}

// Authentication test
require_once ('./include/auth.php');
$auth = new Auth();

// Check if a logout was requested
if (isset($_GET['action']) && $_GET['action'] == "logout") {
	$auth->logout();

	// Only keep the script URI; discard the GET string
	$login_action = $_SERVER['PHP_SELF'];
} else {
	// Keep the entire URI, including the GET string
	$login_action = $_SERVER['REQUEST_URI'];
}

// Test authentication credentials
if (login($auth->get_username(), $auth->get_password(), $accounts)) {
	// Authentication succeeded; store credentials
	$auth->login();
} else {
	// Authentication failed; clear credentials
	$auth->logout();

	// Display login page and halt
	require_once('./include/login.php');
	die();
}
?>
