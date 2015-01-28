
/* authorization for the admin user */
insert into userPrivilege (username, sitecode, privLevel, uiConfiguration)
 values ('admin', '[% siteCode %]', 3, 3);
insert into siteAccess (username, sitecode) values ('admin', '[% siteCode %]');

/* authorization for the cirgadmin user (this needs to go away) */
insert into userPrivilege (username, sitecode, privLevel, uiConfiguration, debugFlag)
 values ('cirgadmin', '[% siteCode %]', 3, 3, 1);
insert into siteAccess (username, sitecode) values ('cirgadmin', '[% siteCode %]');

/* populate mandatory configuration parameters */
insert into config set `name`='serverRole', `value`='[% serverRole %]';
insert into config set `name`='dbsite', `value`='[% dbSite %]';
insert into config set `name`='defsitecode', `value`='[% siteCode %]';
insert into config set `name`='ldapbasedn', `value`='[% ldapBaseDn %]';
