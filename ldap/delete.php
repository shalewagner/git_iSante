<?php
/**
 * Script to delete an account
 *
 * This should redirect back to the list after it has completed.
 *
 * @author	Svend Sorensen
 * @version	$Id: delete.php 129 2006-10-20 18:34:59Z svends $
 */
$ccwd = getcwd();
chdir("..");
require_once ('backend.php');
chdir($ccwd);
require_once ('./include/app.php');

if ($_GET['id']) {
	if ($accounts->destroy($_GET['id'])) {
		$_SESSION['messages']['info'][] = gettext("Account deleted");
		dbQuery("delete from userPrivilege where username = '" . $_GET['id'] . "'") or die ("failed to remove user from userPrivilege table.");
		dbQuery("delete from siteAccess where username = '" . $_GET['id'] . "'") or die ("failed to remove user from siteAccess table.");
	} else {
		$_SESSION['messages']['error'][] = gettext("Delete failed");
	}
} else {
	// Script was called incorrectly
	$_SESSION['messages']['error'][] = gettext("Delete failed");
}

// Redirect back to list page
header('Location: ../LDAPform.php?site=' . $_GET['site'] . '&lang=' . $_GET['lang'] . '&lastPid=' . $_GET['lastPid']);
?>
