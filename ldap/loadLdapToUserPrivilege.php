<?php
/**
 * fetch ldap user attributes and load into userPrivilege table
 *
 * @author	Steve Wagner
 * @version	$Id: getLdapArray.php 66 2016-01-19
 */

require_once ('./include/app.php');

$title = gettext("Account list");

// alter userPrivilege (if necessary) to contain the ldap attributes
$sql = 'call AddColumnUnlessExists(Database(), ?, ?, ?)';
$tab = 'userPrivilege';
$type = 'varchar(50) null';
database()->query($sql,array($tab, 'commonName', $type));
database()->query($sql,array($tab,  'givenName', $type));
database()->query($sql,array($tab,    'surname', $type));
database()->query($sql,array($tab,'description', $type));
database()->query($sql,array($tab,      'phone', $type));
database()->query($sql,array($tab,      'email', $type));
database()->query($sql,array($tab,    'orgName', $type));

$list = $accounts->find_all();

$counter = 0;
foreach ($list as $row) {
	$sql = 'update userPrivilege set commonName = ?, givenName = ?, surname = ?, description = ?, phone = ?, email = ?, orgName = ? where username = ?';
	$data = array($row->commonName, $row->givenname, $row->surname , $row->description, $row->telephoneNumber, $row->mail, $row->organizationName, $row->username);
	database()->query($sql,$data);
	$counter++;	 
}
echo "Done - " . $counter . ' user accounts updated';
?>