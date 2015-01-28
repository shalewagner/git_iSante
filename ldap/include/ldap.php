<?php
/**
 * LDAP Server Class
 *
 * @author	Svend Sorensen
 * @version	$Id: ldap.php 148 2006-11-07 08:10:46Z svends $
 */

class LdapServer
{
	var $host;		// Server hostname
	var $use_tls;		// Use TLS (boolean)
	var $bind_dn;		// DN for binding; empty for anonymous bind
	var $bind_pass;		// Password for binding
	var $base_dn;		// Base DN for LDAP operations
	var $conn;		// LDAP connection

	/**
	 * Constructor
	 */
	function LdapServer($host = 'localhost', $use_tls = false, $bind_dn = '', $bind_pass = '', $base_dn = '')
	{
		$this->host = $host;
		$this->use_tls = $use_tls;
		$this->bind_dn = $bind_dn;
		$this->bind_pass = $bind_pass;

		// Try to determine base DN, if it was not specified
		if ($base_dn) {
			$this->base_dn = $base_dn;
		} else {
			$this->base_dn = $this->get_base_dn();
		}
	}

	/**
	 * Connect and bind
	 */
	function connect($bind_dn = null, $bind_pass = null)
	{
		$r = false;

		$this->conn = @ldap_connect($this->host);

		if ($this->conn) {
			// Try switching to LDAPv3
			// TODO: Check return value
			$r = @ldap_set_option($this->conn, LDAP_OPT_PROTOCOL_VERSION, 3);

			// Start TLS if set
			if ($this->use_tls) {
				// TODO: Check return value
				$r = @ldap_start_tls($this->conn);
			}

			// Bind to LDAP server
			if ($bind_dn) {
				// Bind with passed username and password
				$r = @ldap_bind($this->conn, $bind_dn, $bind_pass);
			} elseif ($this->bind_dn) {
				// Bind with class username and password
				$r = @ldap_bind($this->conn, $this->bind_dn, $this->bind_pass);
			} else {
				// Anonymous bind
				$r = @ldap_bind($this->conn);
			}
		}

		return $r;
	}

	/**
	 * Closes LDAP connection
	 */
	function close()
	{
		if ($this->conn) {
			// TODO: Check return value
			@ldap_close($this->conn);
		}
	}

	/**
	 * Return base DN for LDAP directory
	 *
	 * This attempts to get the directory's namingContexts attribute.  If
	 * there are multiple namingContexts, it will return the first one.
	 */
	function get_base_dn()
	{
		$base_dn = '';

		if ($this->connect()) {
			$filter = '(objectClass=*)';
			$attrs = array('namingConexts');

			// Search
			$sr = @ldap_read($this->conn, '', $filter, $attrs);
			$entry = @ldap_first_entry($this->conn, $sr);

			if ($entry) {
				$base_dn = $entry['namingcontexts'][0];
			}

			// Close
			$this->close();
		}

		return $base_dn;
	}

	/**
	 * Return an array of all entries matching filter
	 */
	function get_entries($filter = '(objectClass=*)')
	{
		$entries = null;

		if ($this->connect()) {
			// Search
			$sr = @ldap_search($this->conn, $this->base_dn, $filter);
			$entries = @ldap_get_entries($this->conn, $sr);

			// Close
			$this->close();
		}

		return $entries;
	}

	/**
	 * Delete entry under $dn
	 */
	function delete($dn)
	{
		$r = false;

		if ($this->connect()) {
			// Delete
			$r = @ldap_delete($this->conn, $dn);

			// Close
			$this->close();
		}

		return $r;
	}

	/**
	 * Add entry under dn of $rdn,$base_dn
	 */
	function add($rdn, $entry)
	{
		$r = false;

		if ($this->connect()) {
			// Add
			$entry_dn = sprintf('%s,%s', $rdn, $this->base_dn);
			$r = @ldap_add($this->conn, $entry_dn, $entry);

			// Close
			$this->close();
		}

		return $r;
	}

	/**
	 * Modify entry at dn of $dn
	 */
	function update($dn, $entry)
	{
		$r = false;

		if ($this->connect()) {
			// Modify
			$r = @ldap_mod_replace($this->conn, $dn, $entry);

			// Close
			$this->close();
		}

		return $r;
	}
}
?>
