<?php
/**
 * Account edit page
 *
 * @author	Svend Sorensen
 * @version	$Id: edit.php 143 2006-10-25 21:05:15Z svends $
 */

require_once ('./include/app.php');

function show_form($account, $errors = '')
{
	$title = gettext("Edit account");;

	// Make strings HTML safe
	$form['username'] = htmlspecialchars($account->username);
	$form['firstname'] = htmlspecialchars($account->givenname);
	$form['lastname'] = htmlspecialchars($account->surname);
	$form['mail'] = htmlspecialchars($account->mail);
	$form['org'] = htmlspecialchars($account->organizationName);
	$form['phone'] = htmlspecialchars($account->telephoneNumber);
	$form['comments'] = htmlspecialchars($account->description);

	$passFlag = (isset($_GET['passFlag'])) ? true : false;

	if ($passFlag) {
		$submit_url = sprintf('edit.php?id=%s&site=%s&lang=%s&lastPid=%s&passFlag=true', $_GET['id'], $_GET['site'], $_GET['lang'], $_GET['lastPid']);
		$cancel_url = sprintf('../splash.php?site=%s&lang=%s&lastPid=%s', $_GET['site'], $_GET['lang'], $_GET['lastPid']);
	} else {
		$submit_url = sprintf('edit.php?id=%s&site=%s&lang=%s&lastPid=%s', $_GET['id'], $_GET['site'], $_GET['lang'], $_GET['lastPid']);
		$cancel_url = sprintf('../LDAPform.php?site=%s&lang=%s&lastPid=%s', $_GET['site'], $_GET['lang'], $_GET['lastPid']);
	}

	include ('./include/edit.tmpl.php');
}

function validate_form($account, $password)
{
	$errors = array();

	// If a password was not submitted, do not set password
	if (!empty($account->password) || !empty($password)) {
		// Check password for errors
		$errors = $account->validate_pass();

		// Check if submitted passwords match
		if (!$account->check_password($password)) {
			$errors[] = gettext("Passwords do not match");
		}
	}

	// Check account for errors
	$errors = array_merge($errors, $account->validate());

	return $errors;
}

// Attempt to update account, then redirect back to splash or list page
function process_form($account, $accounts)
{
	if ($accounts->update($account)) {
		$_SESSION['messages']['info'][] = gettext("Edit succeeded");
	} else {
		$_SESSION['messages']['error'][] = gettext("Edit failed");
	}

	// Redirect back to splash or list page
	if (isset($_POST['passFlag']) && $_POST['passFlag'] == true) {
		$hString = "Location: ../splash.php?site=" . $_GET['site'] . "&lang=" . $_GET['lang'] . "&lastPid=" . $_GET['lastPid'];
	} else {
		$hString = "Location: ../LDAPform.php?site=" . $_GET['site'] . "&lang=" . $_GET['lang'] . "&lastPid=" . $_GET['lastPid'];
	}
	header($hString);
}

// Script requires GET id variable to be set
if (!isset($_GET['id'])) {
	// Script was called incorrectly
	$_SESSION['messages']['error'][] = gettext("Edit failed");

	// Redirect back to splash or list page
	if (isset($_POST['passFlag']) && $_POST['passFlag'] == true) {
		$hString = "Location: ../splash.php?site=" . $_GET['site'] . "&lang=" . $_GET['lang'] . "&lastPid=" . $_GET['lastPid'];
	} else {
		$hString = "Location: ../LDAPform.php?site=" . $_GET['site'] . "&lang=" . $_GET['lang'] . "&lastPid=" . $_GET['lastPid'];
	}
	header($hString);
}

// Find account
$account = $accounts->find($_GET['id']);

if (!$account) {
	// Account was not found
	$_SESSION['messages']['error'][] = gettext("Edit failed");

	// Redirect back to splash or list page
	if (isset($_POST['passFlag']) && $_POST['passFlag'] == true) {
		$hString = "Location: ../splash.php?site=" . $_GET['site'] . "&lang=" . $_GET['lang'] . "&lastPid=" . $_GET['lastPid'];
	} else {
		$hString = "Location: ../LDAPform.php?site=" . $_GET['site'] . "&lang=" . $_GET['lang'] . "&lastPid=" . $_GET['lastPid'];
	}
	header($hString);
}

if (isset($_POST['_submit_check'])) {
	// Form data has been submitted

	// Override account with form entries
	// The commonName is generated by concatenating the first and last names
	$account->commonName = sprintf('%s %s', $_POST['firstname'], $_POST['lastname']);
	$account->givenname = $_POST['firstname'];
	$account->surname = $_POST['lastname'];
	$account->mail = $_POST['mail'];
	$account->organizationName = $_POST['org'];
	$account->telephoneNumber = $_POST['phone'];
	$account->description = $_POST['comments'];
	$account->password = $_POST['password'];

	$password = $_POST['password2'];

	// If validate_form() returns errors, pass them to show_form(), else
	// process the form
	if ($errors = validate_form($account, $password)) {
       	 	show_form($account, $errors);
	} else {
		process_form($account, $accounts);
	}
} else {
	// Form is being displayed for the first time

	show_form($account);
}
?>
