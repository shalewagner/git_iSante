<?php
/**
 * LDAP Account Object Class
 *
 * @author	Svend Sorensen
 * @version	$Id: ldap_account.php 139 2006-10-25 20:39:28Z svends $
 *
 * LDAP account is based on the inetOrgPerson object class.
 */

require_once('./include/account.php');

class LdapAccount extends Account
{
	var $ldap_dn;			// Account DN
	var $ldap_rdn;			// Account RDN
	var $pw_hash;			// Password hashing algorithm

	// LDAP attributes
	var $commonName;		// Full name
	var $givenname;			// First name
	var $surname;			// Last name
	var $description;
	var $telephoneNumber;		// PHP LDAP entry has "telephonenumber"
	var $mail;
	var $organizationName;

	/*
	 * Constructor
	 *
	 * This does nothing except call the parent constructor (it is merely a
	 * placeholder right now).
	 */
	function LdapAccount($username = null, $password = null)
	{
		$this->Account($username, $password);
	}

	function validate()
	{
		$errors = parent::validate();

		// Required by object class
		if (! $this->commonName) {
			$errors[] = gettext("Full name is required");
		}

		// Required by object class
		if (! $this->surname) {
			$errors[] = gettext("Last name is required");
		}

		// Required by application
		if (! $this->givenname) {
			$errors[] = gettext("First name is required");
		}

		// Required by application
		if (! $this->mail) {
			$errors[] = gettext("Email address is required");
		}
		if (! $this->organizationName) {
			$errors[] = gettext("Organization is required");
		}

		return $errors;
	}

	function get_ldap_rdn()
	{
		require_once ('./include/functions.php');	// for dn_escape()

		if (isset($this->username)) {
			return sprintf('uid=%s', dn_escape($this->username));
		} else {
			return NULL;
		}
	}

	/*
	 * Return an LDAP entry based on this account
	 */
	function getLdapEntry()
	{
		require_once ('./include/functions.php');	// for password_hash()

		// Required
		$entry['uid'][0] = $this->username;
		$entry['sn'][0] = $this->surname;
		$entry['cn'][0] = $this->commonName;

		// Optional
		if ($this->givenname) {
			$entry['givenname'][0] = $this->givenname;
		}
		if ($this->password) {
			$entry['userPassword'][0] = password_hash($this->password, $this->pw_hash);
		}
		if ($this->description) {
			$entry['description'][0] = $this->description;
		}
		if ($this->telephoneNumber) {
			$entry['telephonenumber'][0] = $this->telephoneNumber;
		}
		if ($this->mail) {
			$entry['mail'][0] = $this->mail;
		}
		if ($this->organizationName) {
			$entry['o'][0] = $this->organizationName;
		}

		// Required (objectClass)
		$entry['objectClass'][0] = 'inetOrgPerson';
		$entry['objectClass'][1] = 'top';

		return $entry;
	}

	/*
	 * Set up this account based on an LDAP entry
	 */
	function setLdapEntry($entry)
	{
		$this->ldap_dn = $entry['dn'];

		// Required
		$this->username = $entry['uid'][0];
		$this->surname = $entry['sn'][0];
		$this->commonName = $entry['cn'][0];

		// Optional
		if (isset($entry['givenname'][0])) {
			$this->givenname = $entry['givenname'][0];
		}
		if (isset($entry['userPassword'][0])) {
			$this->password = $entry['userPassword'][0];
		}
		if (isset($entry['description'])) {
			$this->description = $entry['description'][0];
		}
		if (isset($entry['telephonenumber'])) {
			$this->telephoneNumber = $entry['telephonenumber'][0];
		}
		if (isset($entry['mail'])) {
			$this->mail = $entry['mail'][0];
		}
		if (isset($entry['o'])) {
			$this->organizationName = $entry['o'][0];
		}
	}
}
?>
