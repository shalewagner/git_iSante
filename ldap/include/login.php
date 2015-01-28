<?php
/**
 * Login page
 *
 * @author	Svend Sorensen
 * @version	$Id: login.php 66 2006-04-26 19:24:38Z svends $
 */

if (isset($_POST['_auth_submit_check'])) {
	// If form has been submitted, login must have failed.  Add an error
	// message.
	$_SESSION['messages']['error'][] = gettext("Login failed");

	$id = $_POST['username'];
} elseif (isset($_GET['id'])) {
	// Account name was supplied
	$id = $_GET['id'];
} else {
	$id = '';
}

$title = gettext("LDAP Login");

// Make strings HTML safe
$username = htmlspecialchars($id);

include ('./include/login.tmpl.php');
?>
