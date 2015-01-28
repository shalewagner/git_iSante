Account Manager README

Svend Sorensen
$Id: README.txt 155 2007-04-12 22:56:19Z svends $

Version 1.0.0

This application manages accounts in an LDAP database.  It uses GPL code from
other packages.

Installation
------------

To install, copy the source code into a directory under your web server's
document root.

To configure the application, edit the include/config.php file.  To change a
setting, uncomment the line and change the default value.  Descriptions of each
setting are in the include/config.default.php file.

Requirements
------------

The ldap and gettext PHP extensions are required.  The mhash PHP extension is
required for sha, smd5, and ssha password hashing.

LDAP Structure
--------------

Accounts are created directly under the base_dn.  For example:

base_dn: ou=users,dc=domain,dc=com

dc=domain,dc=com
`- ou=users
   |- uid=account1
   |- uid=account2
   |- uid=account3
   `- ...
