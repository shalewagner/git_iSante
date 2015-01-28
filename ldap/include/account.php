<?php
/**
 * Account Object Class
 *
 * Account object consists of a username and password.
 *
 * @author	Svend Sorensen
 * @version	$Id: account.php 139 2006-10-25 20:39:28Z svends $
 */

class Account
{
	var $username;		// username (unique)
	var $password;		// cleartext password

	/**
	 * Contructor
	 */
	function Account($username = null, $password = null)
	{
		$this->username = $username;
		$this->password = $password;
	}

	function validate_pass()
	{
		$errors = array();

		// Password checks

		// TODO: Minimum password length is a magic number.
		if (strlen($this->password) < 8) {
			// Password is too short
			$errors[] = gettext("Password is too short");
		} elseif (
			// Password is long enough, check complexity requirements

			// At least one of each of the following: a letter, a
			// number, and a symbol
			!ereg('[[:alpha:]]', $this->password)		// letter (uppercase or lowercase)
//			|| !ereg('[[:lower:]]', $this->password)	// lowercase letter
//			|| !ereg('[[:upper:]]', $this->password)	// uppercase letter
			|| !ereg('[[:digit:]]', $this->password)	// digit
			|| !preg_match('/\W/', $this->password)		// symbol
		) {
			// Password fails complexity requirements
			$errors[] = gettext("Password fails compexity requirements");
		}

		return $errors;
	}

	/*
	 * Check account object and return an array of errors
	 */
	function validate()
	{
		$errors = array();

		// Name checks (length and validity)

		// Check length of username
		if (strlen($this->username) < 4 || strlen($this->username) > 16) {
			// TODO: add name too long error?
			$errors[] = gettext("Username is too short");
		}

		// Check if name consists of valid charachers (letters,
		// numbers, -, and _)
		if (
			!ereg('^([[:alnum:]]|-|_)*$', $this->username)
		) {
			$errors[] = gettext("Username contains illegal characters");
		}

		return $errors;
	}

	/*
	 * Check account password against supplied password
	 */
	function check_password($password)
	{
		return ($password == $this->password);
	}
}
?>
