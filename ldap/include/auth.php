<?php
/**
 * Authentication class
 *
 * @author	Svend Sorensen
 * @version	$Id: auth.php 149 2007-04-12 21:49:37Z svends $
 */

/**
 * Auth class
 *
 * The Auth class provides session authtication management.
 */
Class Auth {
	/**
	 * Username
	 *
	 * @var string
	 */
	var $username;

	/**
	 * Password
	 *
	 * @var string
	 */
	var $password;

	/**
	 * Constructor
	 *
	 * Set up the authentication object.
	 *
	 * @return void
	 */
	function Auth()
	{
		@session_start();

		// Login form must set _auth_sumbit_check, username, and
		// password
		if (isset($_POST['_auth_submit_check'])) {
			// Function was called from login form

			// Set username and password from form variables
			$this->username = $_POST['username'];
			$this->password = $_POST['password'];
		} elseif (isset($_SESSION['username']) && isset($_SESSION['password'])) {
			// Set username and password from session variables
			$this->username = $_SESSION['username'];
			$this->password = $_SESSION['password'];
		}
	}

	/*
	 * Get username
	 *
	 * @access public
	 * @return string
	 */
	function get_username()
	{
		return $this->username;
	}

	/*
	 * Get password
	 *
	 * @access public
	 * @return string
	 */
	function get_password()
	{
		return $this->password;
	}

	/*
	 * Store credentials
	 *
	 * @access public
	 * @return void
	 */
	function login()
	{
		// Store username and password in session variables
		$_SESSION['username'] = $this->username;
		$_SESSION['password'] = $this->password;
	}

	/*
	 * Remove credentials
	 *
	 * @access public
	 * @return void
	 */
	function logout()
	{
		$this->username = null;
		$this->password = null;

		unset($_SESSION['username']);
		unset($_SESSION['password']);

                // Expire the session cookie
                if (isset($_COOKIE[session_name()])) {
                        setcookie(session_name(), '', time() - 42000, '/');
                }

                // Finally, destroy the session
                @session_destroy();
	}
}
?>
