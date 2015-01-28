<?php
/**
 * Accounts Class
 *
 * Contains CRUD functions for the account list:
 * Create:	create()
 * Retrieve:	find(), find_all()
 * Update:	update()
 * Destroy:	destroy()
 *
 * @author	Svend Sorensen
 * @version	$Id: accounts.php 146 2006-10-31 01:09:23Z svends $
 */

require_once ('./include/ldap.php');
require_once ('./include/ldap_account.php');

Class Accounts {
	var $ldap;		// LDAP server
	var $pw_hash;

	/*
	 * Constructor
	 */
	function Accounts($cfg)
	{
		switch ($cfg['auth_type']) {
		case 'config':
			$bind_dn = $cfg['bind_dn'];
			$bind_pass = $cfg['bind_pass'];
			break;
		case 'session':
			if (!empty($_SESSION['username']) && isset($_SESSION['password'])) {
				$bind_dn = sprintf('uid=%s,%s',
					$_SESSION['username'],
					$cfg['base_dn']
				);
				$bind_pass = $_SESSION['password'];
			} else {
				$bind_dn = '';
				$bind_pass = '';
			}
			break;
		}

		$this->ldap = new LdapServer($cfg['host'],
		                             $cfg['use_tls'],
		                             $bind_dn,
		                             $bind_pass,
		                             $cfg['base_dn']);

		$this->pw_hash = $cfg['pw_hash'];
	}

	/*
	 * Return acccount matching id or null if id does not exist
	 */
	function find($id)
	{
		require_once ('include/functions.php');		// for escape()

		$ldap = $this->ldap;

		$filter = sprintf('(&(objectClass=*)(uid=%s))', escape($id));
		$entries = $ldap->get_entries($filter);

		if ($entries) {
			// Set entry to first result if one entry was found
			if ($entries['count'] == 1) {
				$entry = $entries[0];
			}

			if (isset($entry)) {
				$account = new LdapAccount;
				$account->setLdapEntry($entry);

				return $account;
			}
		}

		return null;
	}

	/*
	 * Return an array of all accounts
	 */
	function find_all()
	{
		$ldap = $this->ldap;

		$accounts = array();

		$filter = '(&(objectClass=*)(uid=*))';
		$entries = $ldap->get_entries($filter);

		for ($i = 0; $i < $entries['count']; $i++) {
			$account = new LdapAccount;
			$account->setLdapEntry($entries[$i]);
			$accounts[] = $account;
		}

		return $accounts;
	}

	/*
	 * Delete account matching id
	 */
	function destroy($id)
	{
		$ldap = $this->ldap;

		$r = false;

		$account = $this->find($id);

		if ($account) {
			$dn = $account->ldap_dn;
			$r =  $ldap->delete($dn);
		}

		return $r;
	}

	/*
	 * Add account to list of accounts
	 */
	function create($account)
	{
		$ldap = $this->ldap;

		$entry = $account->getLdapEntry();
		$rdn = $account->get_ldap_rdn();

		return $ldap->add($rdn, $entry);
	}

	/*
	 * Update account information
	 */
	function update($account)
	{
		$ldap = $this->ldap;

		$dn = $account->ldap_dn;

		// Convert account into LDAP entry
		$entry = $account->getLdapEntry();

		// These cannot be set when updating an entry
		unset($entry['objectClass']);

		return $ldap->update($dn, $entry);
	}

	/*
	 * Return new account
	 *
	 * To add the new account to the account list, use create()
	 */
	function new_account($username = null, $password = null)
	{
		$account = new LdapAccount;

		$account->username = $username;
		$account->password = $password;
		$account->pw_hash = $this->pw_hash;

		return $account;
	}

	/*
	 * Attempt to log in
	 *
	 * If account is supplied, log in using account name and password.
	 * Otherwise, attempt anonymous log in.
	 */
	function login($account = null)
	{
		$ldap = $this->ldap;

		if ($account) {
			// Attempt to bind to LDAP server using account
			$r = $ldap->connect($account->ldap_dn, $account->password);
		} else {
			// Attempt anonymous bind
			$r = $ldap->connect();
		}

		return $r;
	}
}
?>
